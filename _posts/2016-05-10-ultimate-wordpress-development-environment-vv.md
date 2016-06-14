---
layout: post
title: "궁극의 워드프레스 개발 환경 실전편 - VV"
description: "The Ultimate WordPress Development Environment에서 Vagrant, VVV, VV, WP-Cli를 사용하여 개발에 필요한 가상머신을 쉽고 편하게 다루는 방법"
category: blog
tags: [wordpress, development, environment, vagrant, vvv, vv]
---

[궁극의 워드프레스 개발 환경](http://nolboo.github.io/blog/2016/04/29/ultimate-wordpress-development-environment/)에서 언급한 VVV와 VV를 실제로 설치하고 워드프레스 개발 가상머신 환경을 구축해본다.

* [궁극의 워드프레스 개발 환경 실전편 - VV](http://nolboo.github.io/blog/2016/05/10/ultimate-wordpress-development-environment-vv/) 
* [궁극의 워드프레스 개발 환경 실전편 - VV Blueprints](http://nolboo.github.io/blog/2016/05/14/ultimate-wordpress-development-environment-vv-blueprints/)
* [궁극의 워드프레스 개발 환경 실전편 - WP-CLI](http://nolboo.kim/blog/2016/05/16/ultimate-wordpress-development-environment-wp-cli/)

처음 설치하면 시간이 오래 걸리니 인터넷 속도가 좋은 곳에서 설치한다. 속도가 좋지 않은 카페에서 처음 시도했다가 3시간 넘게 걸렸다.

가상머신 소프트웨어인 [Oracle VM VirtualBox](https://www.virtualbox.org/)와 가상머신을 쉽게 만들고 배포할 수 있는 [Vagrant by HashiCorp](https://www.vagrantup.com/)가 미리 설치되어 있어야 한다. 만약 설치되지 않았다면 다음 명령어로 한방에 설치한다.(OS X 기준)

```shell
brew cask install virtualbox vagrant
```

* brew cask를 처음 사용한다면 [맥 설치와 환경 설정을 최대한 자동화하기](https://nolboo.github.io/blog/2015/05/07/mac-setup/#cask)에서 해당부분만 참조한다.

## VVV(Varying Vagrant Vagrants)

[Varying-Vagrant-Vagrants/VVV](https://github.com/Varying-Vagrant-Vagrants/VVV)는 워드프레스 개발에 초점을 맞춘 Vagrant 환경 설정이며, 오픈소스이다.

먼저 도메인과 IP 주소의 매핑을 위해 컴퓨터의 호스트 파일(`/etc/hosts`)을 업데이트해주는 [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater)를 설치한다.

```shell
vagrant plugin install vagrant-hostsupdater
```

이제 VVV를 클론하고 버추얼머신을 생성하고 시작한다.

```shell
git clone https://github.com/Varying-Vagrant-Vagrants/VVV.git vvv-local

cd vvv-local
vagrant up  // VVV 버추얼머신을 생성하고 시작한다. 시간이 오래 걸린다.
```

vvv-local은 자신이 원하는 폴더명을 지정하면 된다. 만약 버추얼박스가 설치되었는 데도 인식을 못하거나 다른 VM을 원한다면 `--provider` 옵션으로 직접 프로바이더를 지정한다.

```shell
vagrant up --provider=virtualbox
```

* 버추얼박스 5.0.x는 [vagrant의 최신버전](https://www.vagrantup.com/downloads.html)에서만 지원된다.

제대로 했다면 엄청난 패키지가 설치되며, 인터넷 속도가 빠른 곳에서도 30분에서 1시간의 시간이 걸린다. 성공적으로 설치와 생성이 완료되었다면 가상머신에 접속한 후에 개발환경이 되었는지 살펴본다.

```shell
vagrant ssh     // 생성된 가상머신에 SSH로 접속한다.
vagrant@vvv:~$ cd /vagrant
vagrant@vvv:/vagrant$ ls -la
vagrant@vvv:/vagrant$ cd www
vagrant@vvv:/vagrant/www$ ls -la
```

### 기본 설치 사이트들

`www` 아래에 다음 사이트가 설치된다.
The below sites are installed by default and are located in your browser as:
* 워드프레스 안정화 버전인 `http://local.wordpress.dev/`
* 워드프레스 SVN 트렁크 버전인 `http://local.wordpress-trunk.dev/`
* 워드프레스 코어 개발을 위한 `http://build.wordpress-develop.dev/`
* 여러 프로젝트 관리를 편하게 해주는 대시보드는 `http://vvv.dev/`에서 각각 브라우저로 볼 수 있다.

`http://local.wordpress.dev/`의 웹 루트는 `/vagrant/www/wordpress-default`이며, 다른 주소는 디렉토리 이름과 같다.

가상머신의 `/vagrant` 디렉토리와 로컬의 `vvv-local` 디렉토리의 모든 내용이 자동으로 동기화된다는 것이 핵심이다. 로컬에서 편집한 파일이 자동으로 가상머신과 동기화되므로(반대도 마찬가지이다) ftp 등으로 귀찮은 작업을 할 필요가 없으며, 여러 명이 개발해도 동일환경에서 테스트할 수 있다. 다음에 소개할 VV를 사용하면 개발환경을 추가하는 것도 간단해서 여러 프로젝트를 동시에 진행할 수도 있다.

>[Synced Folders](https://www.vagrantup.com/docs/synced-folders/):
호스트 머신과 게스트 머신의 폴더를 동기화하여 호스트 머신의 프로젝트 파일에서 작업하고 게스트 머신의 리소스를 사용할 수 있다. 기본적으로 `/vagrant` 밑에 (`Vagrantfile` 파일이 있는) 프로젝트 디렉토리를 동기화한다. [RSync](https://www.vagrantup.com/docs/synced-folders/rsync.html)로 동기화할 수도 있다.

#### 워드프레스 관리자 모드와 MySQL에 로그인하기

WordPress WP-Admin은

    admin
    password

MySQL db 와 dbUser는

    wp
    wp

MySQL root 사용자는

    root
    root

### Vagrant 기본 명령어

`vagrant halt`는 가상머신을 종료한다. 컴퓨터를 끄는 것과 같다. 컴퓨터를 켜려면 `vagrant up`으로 가상머신을 시작한다. 컴퓨터를 없애버리려면 `vagrant destroy`로 가상머신 전체를 완전히 날려버릴 수 있다.

```shell
exit                // 가상머신 SSH 접속을 끊는다.
vagrant halt -f     // 가상머신을 중지한다. -f는 강제 옵션이므로 꼭 필요할 때만.
vagrant up          // 가상머신을 시작한다.
vagrant reload      // 가상머신을 재부팅한다.
vagrant ssh -c 'sudo service nginx restart'
```

`vagrant ssh -c`로 로컬에서 가상머신에 명령어를 전달하여 실행할 수 있다.

* 만약 vvv를 언인스톨하고 싶다면 `vagrant destory`로 가상머신을 지우고 vvv 루트 디렉토리를 지우면 된다.

### 대시보드

기본 제공되는 대시보드(`vvv.dev`)가 마음에 들지 않아서 [VVV-Dashboard](https://github.com/topdown/VVV-Dashboard)를 설치하였다.

Vagrant 설치 디렉토리(예:vvv-local)의 `www/default` 디렉토리로 이동한다:

```shell
cd www/default
git clone https://github.com/topdown/VVV-Dashboard.git dashboard
cp dashboard/dashboard-custom.php .
```

웹브라우저에서 `vvv.dev`를 액세스하면 보다 이쁜 대시보드가 반길 것이다. 

![](https://farm8.staticflickr.com/7674/26325803623_06a86d8e31.jpg)

약간 심플한 [leogopal/VVV-Dashboard](https://github.com/leogopal/VVV-Dashboard)도 있다.

## [Variable VVV - a VVV Site Creation Wizard](https://github.com/bradp/vv)

vv는 [Varying-Vagrant-Vagrants(VVV)](https://github.com/Varying-Vagrant-Vagrants/VVV)를 이용하여 새로운 워드프레스 사이트를 더욱 쉽게 만들 수 있고, 플러그인, 테마, 메뉴 등의 설정을 미리 지정한 템플릿으로 다양하게 워드프레스 개발 및 설치 환경을 만들 수 있다.

```shell
brew install bradp/vv/vv
```

* 탭으로 명령어를 자동완성하려면 `.bash_profile`, `.bashrc`, `.zshrc` 중 자신의 쉘 환경에 맞는 파일의 끝에 `source $( echo $(which vv)-completions)`를 추가하면 된다. 근데 좀 느리다.

```shell
vv -h
```

위의 명령을 내리면 vv 명령어와 옵션, 사이트 옵션을 볼 수 있다.

* 만약 아래와 같이 VVV 설치 디렉토리를 묻는다면:

```shell
Automagically found ~/Downloads/vvv-local
 Is this where vv is installed? (Y/n):
VVV install directory:
```

`~/.vv-config`에 아래와 같이 경로를 지정해놓으면 다시 물어보지 않는다. 프로젝트 루트 디렉토리에 `.vv-config`를 만들어 `~/.vv-config `의 내용을 override할 수도 있다.

```json
{
    "path": "~/Projects/vvv-local"
}
```

vv의 주요 명령어는 `list`, `create`, `delete`이다.

```shell
vv create
```

위의 명령어를 내리면 다음과 같은 절차를 밟는다:

* Vagrant 중지한다.(실행되어 있다면)
* `www` 폴더 아래에 `vvv-init.sh`, `wp-cli.yml`, `vvv-hosts` 세 파일을 가진 웹 루트 디렉토리를 만든다.
    - `vvv-init.sh`: Vagrant가 프로비전`provision`될 때 데이터베이스가 없다면 만들고, 워드프레스의 최신 버전을 WP-CLI로 설치한다.
    - `wp-cli.yml`: 워드프레스가 `htdocs`에 설치되어 있다는 것을 WP-CLI에 알려준다.
    - `vvv-hosts`: 사용자가 입력한 사이트 도메인 이름.
* nginx-config 폴더 안에 사이트의 서버 세팅을 다루는 파일을 만든다.
* `agrant up --provision` 명령으로 Vagrant를 재실행한다.

한글 워드프레스를 설치하려면 다음과 같이 옵션을 준다.

```shell
vv create --locale ko_KR
```

사이트를 삭제하려면:

```shell
vv delete {directory}   // www 밑의 삭제하고 싶은 워드프레스 디렉토리명
```

사이트명이 아닌 디렉토리명을 입력해야 한다. `vv remove`도 같은 명령어이다.

* vv는 개발이 빈번하다고 `vv --update`으로 계속 업데이트를 부탁하고 있다.

### Blueprints

vv로 편리하게 워드프레스 개발환경을 만들고 지울 수 있지만, 가장 유용해 보이는 것이 blueprints 기능이다. 만들어질 워드프레스 사이트에 설치될 다른 플러그인, 테마, 옵션, 위젯, 메뉴, 상수들을 설정할 수 있다.

블루프린트를 살펴보는 것은 다음 글에서 다룰 예정이다. 빨리 필요한 분은 [bradp/vv: Variable VVV - a VVV Site Creation Wizard](https://github.com/bradp/vv#blueprints)를 참조한다.^^

## 참조링크

* [Setting up VVV Varying Vagrant Vagrants on OSX](https://coolestguidesontheplanet.com/using-vvv-varying-vagrant-vagrants-wordpress-local-development-environment/)
* [Varying-Vagrant-Vagrants/VVV - The First Vagrant up](https://github.com/Varying-Vagrant-Vagrants/VVV#the-first-vagrant-up)
* [When WordPress Meets Vagrant: VVV](http://www.sitepoint.com/wordpress-meets-vagrant-vvv/)
