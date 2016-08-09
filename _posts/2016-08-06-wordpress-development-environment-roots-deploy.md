---
layout: post
title: "워드프레스 DevOps를 위한 Roots Suite의 Trellis, Bedrock으로 AWS 배포"
description: "워드프레스 DevOps를 위한 Roots Suite를 이용하여 AWS에 Deploy한다."
category: blog
tags: [wordpress, devops, development, environment, roots, trellis, bedrock, sage, woocommerce, storefront, vagrant, aws, deploy]
---

- [워드프레스 개발 환경 Roots.io의 Trellis, Bedrock, Sage를 만나기까지](http://nolboo.kim/blog/2016/06/22/wordpress-development-environment-roots/)
- [워드프레스 DevOps를 위한 Roots Suite의 Trellis, Bedrock, Sage 설치](http://nolboo.kim/blog/2016/06/23/wordpress-development-environment-roots-install/)
- [워드프레스 DevOps를 위한 Roots Suite의 Trellis, Bedrock, Sage 로컬 VM 설치](http://nolboo.kim/blog/2016/06/26/wordpress-development-environment-roots-vm/)

위의 시리즈 포스트에 이은 Root Suite를 배포`Deployment`하는 포스트 글이다. 워드프레스 개발 환경에 대한 불만에서 출발한 호기심으로 스터디한 [워드프레스 개발 환경 포스트들](http://nolboo.kim/search/?tags=wordpress)의 12번째 글이다.

처음 저장소를 클론하는 것부터 시작하여 DevOps의 마지막 차례인 Production Deploy까지를 순서대로 따라 해보는 형식으로 포스트를 작성하였다.

## 저장소 클론

roots-example-project.com 저장소를 원하는 폴더명으로 클론한다. 폴더명이 사이트 키값으로 사용되니 호스팅할 도메인명으로 지정하는 것이 좋다. 이 포스트에서는 `roots.nolboo.kim`로 지정하여 설명한다.

```shell
git clone https://github.com/roots/roots-example-project.com.git roots.nolboo.kim && cd roots.nolboo.kim
cd trellis && ansible-galaxy install -r requirements.yml
```

이전에 [포스트](http://nolboo.kim/blog/2016/06/26/wordpress-development-environment-roots-vm/)에서 설명한 대로 `wordpress_sites.yml`와 `vault.yml`을 도메인명에 맞게 편집한다. 개발 중에는 `ssl`을 끄도록`false` 하였다.

## Development Deploy

이제 개발 서버 VM을 프로비전하고 실행한다.

```shell
# roots.nolboo.kim/trellis
vagrant up
.
.
.
PLAY RECAP *********************************************************************
default                    : ok=107  changed=78   unreachable=0    failed=0
```

마지막 메시지가 위와 비슷하게 실패 없이 끝나야 한다. 물론 에러가 나면 중간에서 멈춘다.

>만약 사전에 설치한 같은 이름의 VM이 있다면 에러가 난다.(이 포스트를 쓰기 위해서 여러 번 삭제하였다 빌드하였다.) 그럴 때는 `vagrant global-status`로 VM ID를 얻은 후에 `vagrant destroy {VM ID}`로 기존 VM을 삭제한다. 잘 안되면 Virtual Box를 실행하여 GUI에서 삭제하고 명령어로도 삭제해본다. 자세한 것은 [스택오버플로우](http://stackoverflow.com/a/34581195/1308010) 등을 참고한다. `vagrant --debug up`과 같은 명령으로 자세하게 디버깅할 수도 있다.

`roots.nolboo.app/wp/wp-admin`에서 한글판과 타임 존, 날자 설정을 하고 우커머스와 스토어프론트 테마 설치한다. [WP-CLI를 이용하는 방법](http://nolboo.kim/blog/2016/05/16/ultimate-wordpress-development-environment-wp-cli/)도 있으나 나중에 원격 서버에 배포하려면 [Composer를 이용하는 방법](http://nolboo.kim/blog/2016/06/19/wordpress-composer/)이 좋다.

```shell
#site/
composer require wpackagist-plugin/woocommerce wpackagist-theme/storefront
```

## Git Push

이제 비트버킷 등의 깃 저장소로 푸시할 차례이다.

프로젝트 루트에 `.gitignore` 파일을 만들고 아래와 같이 입력한다.

```
# Application
web/app/plugins/*
!web/app/plugins/.gitkeep
web/app/mu-plugins/*/
web/app/upgrade
web/app/uploads/*
!web/app/uploads/.gitkeep

# WordPress
web/wp
web/.htaccess

# WP-CLI
db-sync
sql-dump-*.sql

# Dotenv
.env
.env.*
!.env.example

# Vendor (e.g. Composer)
vendor/*
!vendor/.gitkeep

# Node Package Manager
node_modules

# Vagrant
bin
.vagrant
```

플러그인은 제외하였다.

기존 origin을 삭제하고 자신이 만든 새 원격 저장소(비트버킷을 예로 하였다)를 origin으로 지정하고 푸시한다.

```shell
git remote remove origin
git remote add origin git@bitbucket.org:nolboo/roots.nolboo.kim.git
git push -u origin --all

git add . -A
git commit -m "install woocommerce and storefront"
git push origin master
```

## Remote Server Setup - Prodution Deploy

이제 가상머신으로 개발한 워드프레스 사이트를 실제로 도메인이 주어진 웹사이트로 Deploy 해본다. 로컬 VM과 비슷하나 Provision, Deploy 두 가지 새로운 개념이 추가된다.

### Provision

서버를 provision한다는 것은 워드프레스를 운영하는 데에 필요한 소프트웨어를 설치하고 설정한다는 것을 뜻한다. MariaDB 설치, Nginx 설치와 환경설정, 데이터베이스 만들기 등을 한다. Ansible이 `server.yml` 플레이북을 이용하여 서버를 프로비전한다.

### Deploy

개발할 때는 동기화된 폴더 기능으로 VM에서 편하게 사이트를 보거나 관리할 수 있으나, 원격 서버에는 반드시 deploy를 먼저 해야 한다.

`deploy.yml` 플레이북으로 deploy할 수 있다. 깃 저장소를 클론하여 코드 베이스를 서버에 올린 후 Composer 실행, config 파일 만들기, Nginx 재실행 등도 관리한다.

### Requirements

원격 서버의 최소 요구사항은 다음과 같다.

1. Ubuntu 14.04 Trusty bare/stock 버전의 서버

AWS에서 ubuntu 인스턴스를 생성하고 Elastic IP를 연결한다. 자신의 도메인이 등록된 DNS 관리 서비스에서 a 레코드에 AWS의 EIP 추가하여 서버와 도메인을 실제로 연결한다.

>**shared host(공유 서버)에서는 Trellis를 운영할 수 없다.**

2. SSH 연결이 가능해야 하며, SSH key를 이용하는 것을 강력하게 추천한다. 

AWS의 경우에는 `ubuntu`라는 사용자 명으로 SSH 로그인하도록 설정해야 한다.

> 아직 서투른 상태에서 기존 도메인명으로 여러 번 원격 서버를 테스트하다 보면 새롭게 AWS EC2 인스턴스를 포맷하고 싶을 때가 있다. 그러면 새로운 인스턴스를 생성하고 elastic ip를 연결하는 방법으로 ec2 인스턴스를 초기화한다.

위의 두 가지가 준비되면 다음 설정이 필요하다

### 사이트 설정

1. `group_vars/development/wordpress_sites.yml`에 맞춰 프로덕션 설정 파일 `group_vars/production/wordpress_sites.yml`에 실제 적용할 원격 서버 정보, 소스 리포지토리, ssl, cache 등을 설정한다:

```yaml
# Documentation: https://roots.io/trellis/docs/remote-server-setup/
# `wordpress_sites` options: https://roots.io/trellis/docs/wordpress-sites
# Define accompanying passwords/secrets in group_vars/production/vault.yml

wordpress_sites:
  roots.nolboo.kim:
    site_hosts:
      - roots.nolboo.kim
    local_path: ../site # path targeting local Bedrock site directory (relative to Ansible root)
    repo: git@bitbucket.org:nolboo/roots.nolboo.kim.git # replace with your Git repo URL
    repo_subtree_path: site # relative path to your Bedrock/WP directory in your repo
    branch: master
    multisite:
      enabled: false
    ssl:
      enabled: true
      provider: letsencrypt
    cache:
      enabled: true
```

### Vault 패스워드

[Passwords](https://roots.io/trellis/docs/passwords/)를 참고해서 [RANDOM.ORG Password Generator](https://www.random.org/passwords/)에서 다음 최대길이(24)의 "랜덤 패스워드"를 생성하고 `group_vars/production/vault.yml` 파일의 값들에 하나씩 입력한다.

* vault_wordpress_sites: roots.nolboo.kim로 변경한다.
* vault_mysql_root_password에 랜덤 패스워드 중 하나를 입력한다.
* vault_wordpress_sites.env.db_password에 랜덤 패스워드 중 하나를 입력한다.

[Security](https://roots.io/trellis/docs/security/)의 `Admin user sudoer password` 섹션을 참조하면 아래와 같은 방법으로 여 암호화된 패스워드를 지정한다.

[Frequently Asked Questions — Ansible Documentation](http://docs.ansible.com/ansible/faq.html#how-do-i-generate-crypted-passwords-for-the-user-module)의 파이썬 명령으로 암호화된 패스워드를 만들어야 한다.(파이썬 3에선 아래 스크립트가 에러가 난다;;)

```shell
pyenv local 2.7.9 
pip install passlib
python -c "from passlib.hash import sha512_crypt; import getpass; print sha512_crypt.encrypt(getpass.getpass())"
Password:
```

* group_vars/production/vault.yml - vault_sudoer_passwords.admin: 원하는 패스워드를 입력하고 얻은 SHA512 패스워드를 지정한다.

[WordPress Salts](https://roots.io/salts.html)에서 키를 제너레이트하여 Yaml Format (for Trellis) 전체를 `group_vars/production/vault.yml`의 env에 지정한다.

`group_vars/all/vault.yml`의 `vault_mail_password`도 랜덤 패스워드 중 하나로 변경한다.

`group_vars/all/security.yml`의 `sshd_permit_root_login`을 `false`로 변경해야 하는 호스팅 업체도 있으나, AWS는 디폴트 값인 true로 놔둔다.

#### .vault_pass

Ansible 유저 모듈은 암호화하지 않으므로 미리 암호화해야 한다.

`trellis` 폴더에 `.vault_pass` 파일을 만들고 Ansible 커맨드에서 사용할 vault 패스워드를 지정한다.

```shell
touch .vault_pass
```

텍스트 에디터로 `.vault_pass`에 랜덤 패스워드 중 하나를 입력하고 저장한다.

[Vault](https://roots.io/trellis/docs/vault/)의 `2. Inform Ansible of vault password`를 참조하여:

`trellis/ansible.cfg`에 `vault_password_file = .vault_pass`를 추가하여 Ansible에게 vault 패스워드가 들어있는 파일을 알려준다.

```
# ansible.cfg
  [defaults]
  roles_path = vendor/roles
  force_handlers = True
  inventory = hosts
+ vault_password_file = .vault_pass
```

>물론 `trellis/.gitignore`에 `.vault_pass`를 **반드시** 포함해야 한다. 확인했어도 이 글 보면 다시 확인!

[Vault](https://roots.io/trellis/docs/vault/)의 `3. Encrypt files`를 참조하여 모든 Vault 파일들을 암호화한다. 모든 열려있는 `vault.yml`을 닫고 다음 명령을 실행한다.

```shell
ansible-vault encrypt group_vars/all/vault.yml group_vars/development/vault.yml group_vars/staging/vault.yml group_vars/production/vault.yml
```

참고로 암호화를 해제할 때는:

```shell
ansible-vault decrypt group_vars/all/vault.yml group_vars/development/vault.yml group_vars/staging/vault.yml group_vars/production/vault.yml
```

### SSH 설정

`hosts/production` 파일의 `[production]`과 `[web]`에 자신의 호스트명인 `roots.nolboo.kim`을 입력한다.

`group_vars/all/users.yml`에 SSH 공개키를 지정한다. github 저장소이거나 bitbucket과 공개키가 같으면 `https://github.com/nolboo.keys` 형식으로 지정한다. 자신의 것이 아닌 경우는 주석처리 한다. AWS 우분투의 경우 `ubuntu`로 ssh 로그인을 해야 하므로 `admin_user`를 `ubuntu`로 변경한다.

#### Hooks

Sage를 이용하여 테마를 직접 개발하였을 때나 자신의 테마를 Sage 스타일로 개발한 경우에는 `trellis/deploy-hooks/build-before.yml`에서 빌드하기 전에 처리해야할 명령어들을 지정한다. 자신의 테마가 적용되길 원한다면 `sage` 대신 자신의 테마 폴더(`storefront-child-theme`)로 변경하는 방식이다. 자세한 것은 [Deploys](https://roots.io/trellis/docs/deploys/)의 Hooks 섹션을 참조한다.

## Provision

모든 설정이 끝나면 SSH 로그인을 테스트하고 원격 서버를 프로비전 한다.

```shell
# Trellis
ssh roots.nolboo.kim
ansible-playbook server.yml -e env=production
```

### Errors

세심하게 설정하면 에러가 자주 나지는 않는다. 에러가 날 때에는 `trellis/role/` 폴더의 Ansible Role 파일들에서 자세한 TASK를 살펴보면서 하나씩 해결해야 할 수도 있다.

#### SSH 로그인

만약 ssh 로그인이 공개키 지정 에러가 날 때는 다음과 같이 `~/.ssh/config`에 SSH 관련 설정이 잘되어 있는지 살펴본다. 자주 드나들게 되므로 파일에 지정하는 것이 편리하다.

```shell
ssh roots.nolboo.kim
Permission denied (publickey).
cat ~/.ssh/config
Host roots.nolboo.kim
 HostName 52.78.xx.xx
 User ubuntu
 IdentityFile /your-path/awskey.pem
```

#### letsencrypt URL 에러

이 포스트를 완성하려고 마지막 프로비전 테스트를 하는데 [Let's Encrypt](https://letsencrypt.org/) 동의서 URL이 맞지 않는다는 에러가 났다. Trellis에서 채택하고 있는 오픈소스 스크립트인 [acme-tiny: A tiny script to issue and renew TLS certs from Let's Encrypt](https://github.com/diafygi/acme-tiny)에서는 2016년 8월 1일 pdf URL로 업데이트된 걸 확인하였으나 이 포스트에서 사용하고 있는 [샘플 프로젝트 저장소](https://github.com/roots/roots-example-project.com.git)에는 반영이 되어 있지 않았다. [Trellis 저장소의 yml 파일](https://github.com/roots/trellis/blob/master/roles/letsencrypt/defaults/main.yml)에는 반영이 되어 있어서 `acme_tiny_commit` 값을 직접 고쳐주어서 acme-tiny 스크립트 최신판이 적용되도록 하였다.

* PR했더니 머지 해줬다. [Update acme-tiny for new Let's Encrypt agreement URL by nolboo · Pull Request #50 · roots/roots-example-project.com](https://github.com/roots/roots-example-project.com/pull/50) 거저 먹는 풀리퀘~

#### Let’s Encrypt: Could not access the challenge file for the hosts/domain 에러

에러가 난 이후 https URL로는 접속할 수 없었다. 에러 내용을 알 수가 없어서 다음과 같은 절차로 하나씩 살펴보았다.

```shell
curl https://roots.nolboo.kim
curl: (7) Failed to connect to roots.nolboo.kim port 443: Connection refused
curl -k --verbose https://roots.nolboo.kim
```

아예 https가 작동하지 않았다. Lets Encrypt 에러로 ssl을 false로 하고 디플로이한 다음 다시 true로 하여 프로비전한 것이 원인인 것 같다.

먼저 Nginx가 작동하고 있는가?([참고](http://tips.tutorialhorizon.com/2015/10/27/how-to-check-if-nginx-is-running-on-your-ubuntu-machine/))

```shell
ps waux | grep nginx
```

80이나 443 포트에서 리스닝하고 있는가?([참고](http://stackoverflow.com/questions/23136025/nginx-is-listening-on-port-80-or-443-but-not-responding))

```shell
sudo netstat -anltp
```

Nginx가 정상적으로 동작하는 것을 확인했다. 이미 a 레코드가 추가된 도메인이므로 `group_vars/production/wordpress_sites.yml`에 `www_redirect: false` 추가해도 https 접근이 안되었다. [Roots 포럼](https://discourse.roots.io/t/lets-encrypt-could-not-access-the-challenge-file-for-the-hosts-domain/6457/11)을 참고하니 기존서버일 경우 다음과 같이 태그별 프로비전한 후에 EC2 인스턴스를 reboot 하였더니 된다.

```shell
ansible-playbook server.yml -e env=<environment> --tags wordpress
ansible-playbook server.yml -e env=<environment> --tags letsencrypt
```

## Deploy`배포`

**배포 전에 반드시 저장소에 푸시하는 것을 잊지 말자. 이것이 로컬 VM에서 개발하는 경우와 확실히 다른 점이다. 한 글자를 고쳐도 푸시한 다음에 배포해야 한다.**

```
git add . -A
git commit -m "Push before every Deployment!"
git push origin master

./deploy.sh production roots.nolboo.kim
```

마지막 줄의 디플로이 스크립트는 아래와 같다:

```shell
ansible-playbook deploy.yml -e "site=roots.nolboo.kim env=production"
```

배포가 정상적으로 되었다면 `roots.nolboo.kim/wp/wp-admin`으로 가서 나머지 워드프레스를 설치하고, 플러그인과 테마를 활성화시킨다.

이제 

- 로컬에서 (자식) 테마를 개발하면서
- 로컬 VM인 `roots.nolboo.app`에서 확인하고 난 후
- 원격 저장소에 푸시
- Deploy

위의 절차를 반복하면서 DevOps를 진행하면 된다. 후아~!
