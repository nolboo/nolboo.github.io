---
layout: post
title: "워드프레스 개발 환경 Roots.io의 Trellis, Bedrock, Sage를 만나기까지"
description: "Roots의 Trellis, Bedrock, Sage를 만나기까지의 여정을 간략하게 설명하고, 살펴본 개발 환경들을 정리했다."
category: blog
tags: [wordpress, development, environment, roots, trellis, bedrock, sage]
---

워드프레스 개발 환경을 `/wp-admin` url로 접근하는 관리자 모드에서 플러그인이나 테마를 설치하고 커스터마이징하는 방법이 익숙지 않아(솔직히 말하면 - 맘에 들지 않아) 커맨드라인과 텍스트 에디터나 IDE에서 하는 방법을 몇 가지 훑어보았다. 제일 먼저 살펴본 것이 [궁극의 워드프레스 개발 환경](http://nolboo.kim/blog/2016/04/29/ultimate-wordpress-development-environment/)인데 VVV를 위주로 여러 가지 팁을 얻을 수 있었다. 그래서 실제로 VVV 개발환경을 사용하려면 실제로는 어떻게 해야 할까를 정리해서 실전편 시리즈 글을 아래와 같이 정리하였다.

* [궁극의 워드프레스 개발 환경 실전편 - VV](http://nolboo.github.io/blog/2016/05/10/ultimate-wordpress-development-environment-vv/) 
* [궁극의 워드프레스 개발 환경 실전편 - VV Blueprints](http://nolboo.github.io/blog/2016/05/14/ultimate-wordpress-development-environment-vv-blueprints/)
* [궁극의 워드프레스 개발 환경 실전편 - WP-CLI](http://nolboo.kim/blog/2016/05/16/ultimate-wordpress-development-environment-wp-cli/)

VVV를 더 편하게 관리할 수 있는 VV를 중심으로 정리해보았지만 Deploy 부분이 마음에 들지 않았다.

그러는 사이 테마 개발을 PHPStorm에서 어떻게 개발할 것인가를 검색하다가 
[Sage를 사용하여 워드프레스 테마 개발을 현대화하기](http://nolboo.kim/blog/2016/05/19/modernizing-wordpress-theme-development-with-sage/)를 읽었고 여기서 [Roots](https://roots.io/)란 사이트를 알게 되었다.

내용이 Trellis, Bedrock, Sage를 세 가지를 소개하는데 읽어야 할 내용이 많았다. 차근차근 읽는 도중 [모던 워드프레스 서버 스택](http://nolboo.kim/blog/2016/05/31/modern-wordpress-server-stack/)이 스매싱에 올라왔다. 읽다가 내용이 좋아서 전체를 번역했다. 전체적인 내용은 쉽게 접할 수 없는 고급 정보였지만, Roots에 대해서는 약간 부정적이라는 느낌이 들었다. Roots가 일반적인 워드프레스 설치와는 사용할 수 없다는 부분이 있는데, 이 글을 쓴 [Carl Alexander](https://carlalexander.ca/)는 [DebOps](http://debops.org/)의 팬인 것 같다.(글에서 언급하고 있는 [debops-wordpress](https://github.com/carlalexander/debops-wordpress)를 만들었다) 글에서 소개한 개발 환경을 대충 살펴보았는데 Roots 이외에는 설명이 부족해서 깊게 이해하기 힘들었다.

결국엔 Roots를 더 자세하게 파보기로 하였다. 현재까지 살펴본 Roots의 장점은:

1. 문서화가 잘 되어 있고,
2. 커뮤니티가 활성화되어 있고,
3. 로컬 개발 환경과 서버 디플로이가 연속적으로 이루어져 있다.
4. 테마 개발 환경이 최근의 프런트 엔드 개발 트렌드에 맞게 최적화되어 있다.

![Roots.io 홈페이지](https://c6.staticflickr.com/8/7446/27757896141_249f21c54f_c.jpg)"

Roots.io에서는 세개의 툴을 소개하고 있다.

* Trellis: Vagrant를 이용한 가상머신 개발환경과 Ansible(또는 Capistrano)을 이용한 프로덕션 배포환경 관리
* Bedrock: 컴포저를 이용한 의존성 설정과 플러그인 관리
* Sage: gulp, bower, BrowserSync를 이용한 최신 환경을 채택한 스타터 테마

다음에는 Roots의 툴들에 대해 살펴볼 예정인데, HHVM이 PHP7보다 4~5배 빠르다는 벤치마크를 소개하고 있는 [Getting Started with HHVM and WordPress](https://www.sitepoint.com/hhvm-and-wordpress/)도 있는 걸 보니 개발환경에 대한 여정은 계속될 전망이다;;

## 개발 환경의 목록

워드프레스 생태계가 워낙 커서 정말 많은 개발 환경을 만들어서 나름대로 활용하고 있는 것을 알 수 있었다. 다음은 잠깐이라도 살펴본 개발 환경들이다.

* [bradp/vv: Variable VVV - a VVV Site Creation Wizard](https://github.com/bradp/vv)
* [Chassis/Chassis: Chassis is a virtual server for your WordPress site, built using Vagrant.](https://github.com/Chassis/Chassis)
* [Your Debian-based data center in a box](http://debops.org/)
* [carlalexander/debops-wordpress: Your superpowered WordPress server in two commands.](https://github.com/carlalexander/debops-wordpress)
* [EasyEngine - WordPress On Nginx Made Easy!](https://easyengine.io/)
* [wpengine/hgv: WP Engine's Mercury vagrant environment](https://github.com/wpengine/hgv)
* [Wocker: Docker-based rapid development environment of WordPress. IT TAKES JUST 3 SECONDS TO CREATE A NEW ONE!](http://wckr.github.io/)
* [Automattic/vip-quickstart: Quickstart your WordPress.com VIP development!](https://github.com/Automattic/vip-quickstart)
* [evolution/wordpress: Rapidly create, develop, & deploy WordPress across multiple environments.](https://github.com/evolution/wordpress)
* [vagrantpress/vagrantpress: A WordPress Development Environment With Vagrant/Puppet](https://github.com/vagrantpress/vagrantpress)

실은 Roots를 소개하려다가 머리말이 길어져서 별도의 글로 정리한 것이다. :)



