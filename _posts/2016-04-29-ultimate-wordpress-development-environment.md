---
layout: post
title: "궁극의 워드프레스 개발 환경"
description: "The Ultimate WordPress Development Environment을 발췌해서 번역"
category: blog
tags: [wordpress, development, environment]
---

원문 : [The Ultimate WordPress Development Environment](http://www.sitepoint.com/ultimate-wordpress-development-environment/?utm_content=buffer4fe5c&utm_medium=social&utm_source=twitter.com&utm_campaign=buffer)

* 원문에서 필요한 부분만 발췌하여 번역하였으니 원문을 꼭 참조하시기 바랍니다.
* 실제로 이 글에서 설명된 개발환경을 구현하는 방법을 별도의 포스트로 진행하고 있습니다.
    * [궁극의 워드프레스 개발 환경 실전편 - VV](http://nolboo.github.io/blog/2016/05/10/ultimate-wordpress-development-environment-vv/) 
    * [궁극의 워드프레스 개발 환경 실전편 - VV Blueprints](http://nolboo.github.io/blog/2016/05/14/ultimate-wordpress-development-environment-vv-blueprints/)
    * [궁극의 워드프레스 개발 환경 실전편 - WP-CLI](http://nolboo.kim/blog/2016/05/16/ultimate-wordpress-development-environment-wp-cli/)

## It Starts with the Server

워드프레스 개발 환경 퍼즐의 가장 중요한 부분은 서버다. 서버 없이 아무것도 할 수 없다.

로컬 환경에서 워드프레스 웹사이트를 호스팅하는 것은 아주 많은 옵션이 있다.

MAMP/WAMP/XAMP를 버리고 가상 개발 환경을 사용하는 것을 제안하려고 한다.

왜? 많은 이유가 있다:

1. 하나의 독립된 환경. 가상 환경을 사용하면 호스트 운영체제로부터 독립된 개발 서버를 만들게 된다. 가상 머신에 원하는 운영체제를 설치할 수 있고, 내 호스트에게 영향을 주지 않고 시작/중지/재시작할 수 있다. 개발이 끝난 후 필요 없으면 없애버리기도 쉽다.
2. 엉망인가? 문제없다! 개발 환경을 다시 만들어라. 서버 설정을 땜빵하고 뭔가 날려버릴 골치 아픈 상황에 부닥쳤을 때 가상 환경을 다시 만들거나 스냅샷을 사용해서 쉽게 해결할 수 있다. 이제 실패의 두려움 없이 설정을 둘러보거나 tweak할 수 있다.
3. As close to live as you can get. 원하는 대로 로컬 호스트에 라이브 환경을 복제할 수 있다. 똑같은 두 개의 환경을 가지고 디버그, tweak, 배포를 할 수 있다.
4. 하나의 컴퓨터에 여러 개의 다른 서버 환경을 돌릴 수도 있다.
5. 개발팀끼리도 환경을 통일할 수 있다. 개발팀원들이 정확히 같은 설정을 사용하면 개발시간과 다른 사람의 머신에서 동작하지 않는 것에 대한 질문도 적어진다.

이제까지 가상환경에 정신이 팔려있었다. 다음 사용할 것은 무엇인가?

난 [VVV](https://github.com/Varying-Vagrant-Vagrants/VVV)를 사용하고 있다. 준비하고 돌리기에 지극히 간단하고, 지원 시스템이 좋다. 내가 일한 [XWP](https://xwp.co/)를 포함한 많은 대형 워드프레스 개발 에이전시가 사용하고 있다.

다른 가상 워드프레스 개발 환경은 다음과 같은 것이 있다: [HGV](https://github.com/wpengine/hgv), [Wocker](http://wckr.github.io/), [VIP Quickstart](https://github.com/Automattic/vip-quickstart)

VVV로 가기로 했다면, 다음 플러그인과 툴을 강력하게 권한다.

* [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater) - 이 플러그인은 vagrant 설치가 도메인과 IP 주소의 매핑을 추가하기 위해 컴퓨터의 호스트 파일을 업데이트할 수 있다. 호스트 파일을 직접 추가할 필요가 없다.
* [Variable VVV(VV)](https://github.com/bradp/vv) - VVV를 위한 가장 유용한 툴이다. 커맨드 라인에서 새 VVV 워드프레스를 빠르고 쉽게 만들 수 있다.

알렉산더 코코가 [VVV에 대해서 일전에 글을 썼었고](http://www.sitepoint.com/wordpress-meets-vagrant-vvv/), 나도 [컴퓨터에 VVV 셋업하는 법](https://mattgeri.com/article/wordpress-vvv/)에 대한 비디오를 녹화했다.

## The Power of the Command Line

커맨드 라인에 어려움이 있는 사람은 [WP-CLI](http://wp-cli.org/)이 대안일 수 있다.

![WordPress WP-CLI](http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2016/04/1461864990wp-cli-wordpress-1024x275.gif)

WP-CLI로 커맨드 라인에서 워드프레스 설치를 관리할 수 있다(VVV에도 포함되어있다).

로컬 개발 환경에서 WP-CLI를 사용하는 실용적인 예를 보자.

* 워드프레스 설치. 서버에 SSH로 접속하고 워드프레스를 빠르게 설치할 필요가 있는가?
* 워드프레스 업데이트. 엄청난 수의 워드프레스 웹사이트에 각각 방문하고, 로그인하고, 클릭하고, 업데이트할 필요가 없다. 커맨드 라인에서 하나의 명령어로 할 수 있다.
* 플러그인 설치. 여러 사이트에 플러그인을 동시에 설치할 수 있다.
* 워드프레스 데이터베이스 재설정.
* 컨텐츠 임포트.
* [그 외 많은 것](http://wp-cli.org/commands/)

다음은 IDE에 관해서 이야기하겠다. IDE에서 이 모든 명령을 할 수 있다.

좀 더 배우고 싶다면 [아산 파웨즈가 쓴 WP-CLI에 대한 이 글](http://www.sitepoint.com/wp-cli/)을 검토하라.


## An IDE That Makes a Difference

IDE가 좋냐 텍스트 에디터가 좋냐를 말하지 않을 것이다. IDE로 바꾸고 난 후의 내 경험을 이야기할 것이다.

IDE를 진짜 싫어했고, 서브라임 텍스트의 광팬이었다(아직도 그렇고 매일 쓰고 있다).

워드프레스 개발을 다시 하게 된 12월에 에디터를 조사하고 있었다. PhpStorm이란 IDE가 언급되어 매우 놀랐다.

마지못해 훑어봤다.

PhpStorm은 PHP와 워드프레스 개발에 최고의 IDE이다. 워드프레스 웹사이트 개발, 플러그인, 테마를 만드는 데 필요한 모든 것을 제공하고, 믿을 수 없을 정도의 워드프레스 통합을 제공한다.

워드프레스 개발에 PhpStorm을 고려해야 할 세 가지 이유:

1. 하나의 앱에서 필요한 모든 것 제공. FTP, database 지원, 터미널, 버전 컨트롤, 디버깅, 리팩토링, 훌륭한 intellisense와 자동완성, 등등등!
2. PhpStorm에서 워드프레스 통합은 둘째가라면 서러워할 일이다. PhpStorm은 워드프레스를 깊게 이해하고 있다. 워드프레스 프로젝트에 일단 접속하면 모든 것을 어떻게 결합해야 할지 알고 있다. 워드프레스 함수, 액션, 필터를 자동완성한다.
3. 최고수 워드프레스 개발자와 에이젼시들이 이제 PhpStorm으로 개발하고 있다.

PhpStorm으로 시작하는 것에 관심이 있다면, 내가 IDE를 시작할 때 녹화한 [7개의 PhpStorm 시리즈 비디오](https://mattgeri.com/article/phpstorm-for-wordpress-development/)를 참조하라.

## Making Sure Your Code Is Silky Clean

마지막 툴이 걸작이다! 난 코드를 쓸 때 특히 현학적이다. 매우 깨끗하고 워드프레스 코딩 표준을 정확히 따르는 것을 좋아한다.

아무리 현학적이라고 해도 우리는 인간이며, 여백이나 줄 등에서 실수가 잦다.

오픈소스 세계에선 프로젝트가 정의한 코딩 표준을 준수하는 것이 매우 중요하다. 그렇지 않으면 코드 베이스를 바로 탈락시킨다. 워드프레스와 같은 인기 있는 오픈소스 프로젝트는 더 하다.

사실 워드프레스 코어 팀은 코딩 표준에 대해 특히 엄격하다.

워드프레스 코딩 표준을 따르고 있는 확실히 하는 방법은? 답은 간단하다. [WordPress coding standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) 룰셋과 [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)란 툴이다.

![WordPress Coding Standards](http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2016/04/1461865716WordPress-Coding-Standards-1024x504.png)

이 두 유틸리티가 코드를 스캔하고 무엇이 잘못되었는지 알려준다. 매직!

가장 좋은 점은 고수준의 보안 이슈도 알려주는 것이다. Now it won't catch every single security issue so make sure you're always thinking about security when you're writing your code but it is a good first line of defense.

PhpStorm은 PHP CodeSniffer도 지원한다. [PhpStorm, PHPCS, the WordPress 코딩 표준 룰셋](https://mattgeri.com/article/wordpress-coding-standards/)을 결합하는 방법에 대한 비디오도 찍어놨다.

## In Closing

위의 툴 외에 많은 대안이 있다. 추천하고 싶은 것이 있으면 댓글로 알려주라^^



