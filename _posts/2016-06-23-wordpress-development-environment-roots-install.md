---
layout: post
title: "워드프레스 DevOps를 위한 Roots Suite의 Trellis, Bedrock, Sage 설치"
description: "Roots Suite인 Trellis, Bedrock, Sage를 설치한다."
category: blog
tags: [wordpress, devops, development, environment, roots, trellis, bedrock, sage]
---

[워드프레스 개발 환경 Roots.io의 Trellis, Bedrock, Sage를 만나기까지](http://nolboo.kim/blog/2016/06/22/wordpress-development-environment-roots/)에 이은 시리즈 글로 여기서는 Roots Suite를 설치한다.

## Roots Suite 설치

Trellis, Bedrock, Sage를 각각 설치하는 방법이 있고, Roots Suite를 한 번에 적용할 수 있는 샘플 저장소를 클론해서 한 번에 설치하는 방법이 있다.

### Requirement

Trellis, Bedrock, Sage로 이루어진 Roots Suite를 설치하려면 다음과 같은 패키지가 로컬에 설치되어 있어야 한다:

* [Ansible](http://docs.ansible.com/ansible/intro_installation.html#latest-releases-via-pip) >= 2.0.0.2
* [Virtualbox](https://www.virtualbox.org/wiki/Downloads) >= 4.3.10
* [Vagrant](http://www.vagrantup.com/downloads.html) >= 1.5.4
* [vagrant-bindfs](https://github.com/gael-ian/vagrant-bindfs#installation) >= 0.3.1 (Windows users may skip this)
* [vagrant-hostmanager](https://github.com/smdahlen/vagrant-hostmanager#installation)
* [Node.js](http://nodejs.org/) >= 0.12.x
* [Gulp](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md) >= 3.8.10
* [Bower](https://github.com/bower/bower/blob/master/README.md#install) >= 1.3.12

이 [링크](https://github.com/roots/roots-example-project.com#requirements)에서 정확한 버전을 체크할 수 있다.

```shell
$ sudo pip install ansible
$ brew cask install virtualbox vagrant
```

>brew cask를 처음 사용한다면 [맥 설치와 환경 설정을 최대한 자동화하기](http://nolboo.kim/blog/2015/05/07/mac-setup/#cask)에서 해당부분을 참조한다.

```shell
$ vagrant plugin install vagrant-hostsupdater vagrant-bindfs
$ brew install wp-cli
$ brew install composer
```

### Example.com으로 설치

```shell
# 프로젝트 디렉터리를 만든다.
$ mkdir example.com && cd example.com
# Trellis를 클론하고 깃을 해제한다.
$ git clone --depth=1 git@github.com:roots/trellis.git && rm -rf trellis/.git
# Bedrock를 site/ 디렉터리로 클론하고 깃을 해제한다.
$ git clone --depth=1 git@github.com:roots/bedrock.git site && rm -rf site/.git
# Sage를 테마 디렉터리에 클론하고 깃을 해제한다.
$ git clone --depth=1 git@github.com:roots/sage.git site/web/app/themes/sage && rm -rf site/web/app/themes/sage/.git
```

이것은 ssh를 통하여 설치하는 것이며, 미리 ssh key를 생성하는 등의 사전 작업이 필요하다. 같은 일을 조금 더 간편하고 안전하게 할 수 있다.

먼저 디렉터리를 완벽하게 날려버리는 `rm -rf`에 알레르기 증상이 있는 분을 위해 지운 다음 휴지통에서 복구할 수 있는 [trash](https://github.com/sindresorhus/trash)를 권한다.

```shell
# trash를 글로벌하게 설치한다.
$ npm install --global trash-cli
# 프로젝트 디렉터리를 만든다.
$ mkdir example.com && cd example.com
# Trellis를 HTTPS로 클론하고 깃을 해제한다.
$ git clone --depth=1 https://github.com/roots/trellis.git && trash trellis/.git
# Bedrock을 site/ 디렉터리로 클론하고 깃을 해제한다.
$ git clone --depth=1 https://github.com/roots/bedrock.git site && trash site/.git
# Sage를 테마 디렉터리에 클론하고 깃을 해제한다.
$ git clone --depth=1 https://github.com/roots/sage.git site/web/app/themes/sage && trash site/web/app/themes/sage/.git
```

Bedrock은 컴포저의 `create-project` 옵션으로도 설치할 수 있다.

```shell
$ git clone --depth=1 https://github.com/roots/bedrock.git site && trash site/.git
# 위의 명령어는 아래와 같다.
$ composer create-project roots/bedrock site
```

#### 디렉토리 구조

```shell
example.com/      # → 프로젝트 루트 폴더
├── trellis/      # → 시스템 관리와 배포
└── site/         # → Bedrock 기반 워드프레스 사이트
    └── web/
        ├── app/  # → 워드프레스 컨텐츠 디렉터리(테마, 플러그인 등)
        └── wp/   # → 워드프레스 코어
```

### Roots Example Project으로 설치

앞서 말한 바와 같이 위의 과정을 미리 준비해놓은 [샘플 프로젝트 저장소](https://github.com/roots/roots-example-project.com)가 있다. 즉, 위의 과정을 한 번에 할 수 있다.

```shell
$ git clone https://github.com/roots/roots-example-project.com.git && cd roots-example-project.com
```

실제로 살펴보면 위의 두 가지 방법 중 Roots 예제 프로젝트로 설치하는 것은 프로젝트 루트 디렉터리의 이름도 다르지만, 그에 따른 설정파일들도 약간의 차이가 있다. 이 글에서는 후자인 `roots-example-project.com`으로 설치하는 곳으로 나머지 절차를 빠르게 살펴본다.

### Ansible Galaxy roles 설치

원하는 프로젝트 구조를 만들었다면 Ansible Galaxy roles를 설치한다.

```shell
$ cd trellis && ansible-galaxy install -r requirements.yml
```

## 로컬 개발 환경

이제 테마 개발에 필요한 패키지를 설치하기 위해 `roots-example-project.com/site/web/app/themes/sage`로 이동하여 다음 명령을 실행한다:

```shell
$ npm install
$ bower install
$ gulp
```

### 로컬 개발용 가상머신 만들기

`trellis` 디렉터리로 이용하여 `vagrant up`을 실행한다. 시간이 오래 걸린다. 인터넷 연결 속도에 따라 시간 차이가 많이 날 수 있다.

```shell
$ cd roots-example-project.com/trellis
$ vagrant up
```

브라우저에서 `roots-example-project.dev`를 입력하여 설치가 제대로 되었는지 확인한다.

![Roots 샘플 프로젝트 화면](https://c3.staticflickr.com/8/7342/27820470106_8062a9de00_c.jpg)

## 테마 개발

gulp를 watch 모드로 실행하여 `localhost:3000`에서 실시간 업데이트하면서 테마를 개발할 수 있다.

```shell
$ cd roots-example-project.com/site/web/app/themes/sage
$ gulp watch
```

이 경우에도 관리자 모드는 `roots-example-project.dev`에서 사용해야 한다.

> 가상머신을 실행해 놓으면 1기가에 가까운 메모리가 할당되니 사용하지 않을 때는 `vagrant halt`으로 가상머신을 끄길 권한다.

## 맺음말

이렇게 하고 나면 간단한 것으로 느껴지나 아직 실제로는 개발하거나 프로덕션 환경에 필요한 설정과 보안 관련 절차가 남아 있다. 다음 글에서 자세하게 살펴본다.