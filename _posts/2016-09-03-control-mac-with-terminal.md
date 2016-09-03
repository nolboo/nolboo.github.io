---
layout: post
title: "맥을 터미널로 제어할 수 있는 세 가지 명령어 유틸리티 m, mac, mas"
description: "맥용 터미널 유틸리티인 m, mac, mas로 시스템은 물론 개발환경까지 쉽게 제어하고, 앱스토어의 엡데이트까지 터미널에서 편리하게 하는 방법"
category: blog
tags: [mac, macos, osx, terminal, appstore, command, developement, environment, update]
---

맥을 터미널 명령어로 제어할 수 있는 세 가지 패키지 m-cli, mac-cli, mas-cli를 살펴본다.

## 설치 준비

OS X 용 패키지 관리자 [Homebrew](http://brew.sh/index_ko.html)를 설치해야 한다. 완전 대세이니 맥 사용자라면 필수 유틸리티이니 설치한다. 터미널에서 다음 명령을 입력한다:

```shell
/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

국내 최고의 맥 블로그인 백투더맥에서 [OS X 10.11 엘 캐피탄에 '홈브류(Homebrew)'를 설치하는 방법](http://macnews.tistory.com/3728)이 친절하게 설명되어 있다.

설치한 기념으로 바로 다음 패키지를 설치할 때 사용할 `wget`을 설치해보자.

```shell
brew install wget
```

## m

공식 저장소 [rgcr/m-cli](https://github.com/rgcr/m-cli)에는 "Swiss Army Knife for macOS"라고 적혀있지만 아직은 그 정도까지는 아니고 목표하는 바인 것 같다. 그러나 여러 가지 유용한 기능이 있다. 먼저 홈브루로 설치한다.

```shell
brew install m-cli
```

`m help`로 도움말을 불 수 있는데, 쓸만한 몇 가지를 나열한다.

```shell
m bluetooth disable         # 블루투스를 끈다
m bluetooth enable          # 블루투스를 킨다

m dir tree /path            # /path 폴더의 폴더 트리를 보여준다
m dir delete empty /path    # /path 폴더 밑의 빈 폴더를 전부 지운다
m dir delete dsfiles /path  # /path 폴더 밑의 .DS_Store 파일을 지운다
m dir size /path            # /path 폴더의 크기를 보여준다

m info                      # MacOS 시스템 정보를 보여준다
m network ls                # 네트워크 인터페이스를 보여준다

m nosleep until 3600        # 3600초 동안 잠자지 않는다 
m nosleep until my_script.sh # 스크립트가 끝날 때까지 잠자지 않는다

m notification showcenter NO # 알림센터를 끈다
m notification showcenter YES # 알림센터를 킨다

m restart -f                # 확인 없이 재시작한다
m shutdown -f               # 확인 없이 종료한다

m screensaver               # 스크린세이버 실행

m service --ls              # 모든 서비스를 보여준다. start, stop할 수 있다

m trash clean               # 휴지통을 비운다

m update list               # 할 수 있는 엡데이트를 보여준다. 주로 시스템 관련인듯.

m user ls                   # 사용자를 보여준다
m user info demouser        # 특정 사용자의 정보를 보여준다

m wifi showpassword         # 접속된 와이파이 비밀번호를 보여준다
```

그 외에도 [rgcr/m-cli](https://github.com/rgcr/m-cli)에 더 많은 명령어가 있다. 이것의 개발자가 다음의 mac-cli에서 힌트를 많이 얻었다고 한다. 이제 mac-cli를 살펴본다.

## mac

`m`은 주로 시스템 관련한 명령이 많고 [`mac`](https://github.com/guarinogabriel/Mac-CLI)은 개발 관련한 명령이 많으며, 플러그인 형식으로 되어 있어서 확장하기 쉽게 만든 것 같다. 다음 명령으로 설치한다.

```shell
sh -c "$(wget https://raw.githubusercontent.com/guarinogabriel/mac-cli/master/mac-cli/tools/install -O -)"
```

터미널을 재시작한 다음 명령으로 설치를 확인한다:

```shell
mac help
```

`m`과 중복되는 명령도 많으니 편한 대로 선택해서 사용할 수 있다.


```shell
mac apps:close-all          # 열려있는 모든 앱을 닫는다

mac find:text 문자열          # 폴더에서 문자열을 찾는다(recursive)
mac find:biggest-files      # 폴더에서 가장 큰 파일을 찾는다
mac find:biggest-directories # 폴더에서 가장 큰 폴더를 찾는다
mac find:duplicated         # 중복된 파일을 찾는다

mac port                    # 사용하고 있는 포트를 보여준다
mac ip:local                # 로컬 IP 주소를 보여준다
mac ip:public               # 퍼블릭 IP 주소를 보여준다

mac system                  # glance 유틸을 이용하여 시스템 정보를 보여준다
mac memory                  # top 유틸을 이용하여 메모리 정보를 보여준다
mac trash:size              # 휴지통 크기를 보여준다
mac desktop:cleanup         # 데스크톱 폴더의 모든 파일과 폴더를 지운다
mac downloads:cleanup       # 다운로드 폴더의 모든 파일과 폴더를 지운다
```

그 외에도 개발과 관련하여 [LAMP](https://github.com/guarinogabriel/Mac-CLI#lamp-linux-apache-mysql-php-utilities), [SSH](https://github.com/guarinogabriel/Mac-CLI#ssh-utilities), [웹 개발](https://github.com/guarinogabriel/Mac-CLI#web-development-utilities), [Git](https://github.com/guarinogabriel/Mac-CLI#git-utilities), [Magento](https://github.com/guarinogabriel/Mac-CLI#magento-utilities)를 지원하는 명령어들이 있다. 그중에서도 가장 눈에 띄는 것은 `mac update` 명령인데, 시스템 업데이트뿐만 아니라 brew, npm, gem, pip, apm를 한방에 업데이트해준다. 시간이 오래 걸릴 수 있다.

주로 시스템 유틸이나 기존의 유틸을 활용하여 쉽게 기억할 수 있도록 하는 역할을 한다. 아직 개발 중이라서 그런지 오동작하는 명령도 몇 개 있다.

## mas

맥 앱스토어는 후졌다.(아니 내가 사용해본 앱스토어는 이상하게 다 후지다.) 설치하고 있는 앱이 많다 보니 업데이트 숫자가 계속 올라가는데 맥 앱스토어는 툭하면 먹통이 되기 일쑤다. 미국 계정을 주로 사용하지만, 한국 계정을 동시에 사용하다 보니 매번 로그인해서 앱스토어를 변경해 주어야 하는 것도 참 귀찮은 일이었다. 그래서 백여 개의 업데이트가 밀려 있었다. 이럴 때 구원투수와 같은 [argon/mas](https://github.com/argon/mas)를 사용하면 된다.

백투더맥 블로그의 [맥 앱스토어 응용 프로그램을 터미널에서 설치할 수 있는 커맨드라인 인터페이스 'mas-cli'](http://macnews.tistory.com/4762)에서 전반적인 것을 잘 설명하고 있으니 여기서는 내 워크플로우 위주로 설명한다. 먼저 brew로 설치한다.
    
```shell
brew install mas
mas version
mas help
```

먼저 앱스토어 로그인 계정을 확인한다.

```shell
mas account
```

엡데이트하려는 국가에 맞는 앱스토어 계정이면 바로 펜딩되어 있는 모든 업데이트를 한 방에 진행할 수 있다.

```shell
mas upgrade
```

만약 계정을 변경해야 한다면 `signout`과 `signin` 옵션으로 계정을 변경한 후에 `upgrade` 옵션으로 실행하면 된다. `mas list`로 앱스토어에서 맥에 설치한 목록을 볼 수 있으며, 이 순서대로 업데이트되므로 계정을 몇 번 변경해야 할 수도 있다. 그러나 앱스토어에서 변경하는 것보단 아주 편리하다.

## 참고 링크

- [Mac CLI Simplifies Your Command Line So You Can Work Faster](http://www.makeuseof.com/tag/mac-cli-simplifies-command-line-can-work-faster/)

## 추가 링크

- [Command Line Cheat Sheet](https://www.git-tower.com/blog/command-line-cheat-sheet/)
- [Command Line Tools for Frontend Developers](https://seesparkbox.com/foundry/command_line_tools_for_frontend_developers)
- [An A-Z Index of the Apple OS X command line](http://ss64.com/osx/)
- [API Reference: Mac OS X Manual Pages](https://developer.apple.com/legacy/library/documentation/Darwin/Reference/ManPages/index.html)
- [explainshell.com - match command-line arguments to their help text](http://explainshell.com/)
- [How to Quickly Resize Multiple Photos in Mac OS X Using a Terminal Command](http://petapixel.com/2012/11/21/how-to-quickly-resize-multiple-photos-on-a-mac-using-a-terminal-command/)