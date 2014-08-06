---
layout: post
title: "지킬로 깃허브에 무료 블로그 만들기"
description: "깃허브의 정적 사이트 제너레이터 엔진인 오픈소스 지킬로 블로그를 만든다. 로컬에서 쉽게 관리하고 깃허브에서 계정 페이지와 프로젝트 페이지의 두 가지 방법으로 만드는 방법을 설명한다."
category: blog
tags: [jekyll, github]
---

<div id="toc"><p class="toc_title">목차</p></div>

[Jekyll][1]은 여러(특히 마크다운) 형태의 텍스트와 테마를 소스로 하여 정적 HTML 웹사이트를 제너레이트하는 툴이다. Ruby 스크립트로 만들어져 있으나, 블로그를 만드는 데에는 루비를 전혀 몰라도 된다. 워드프레스를 사용하여 블로그를 만드는 노력이면 워드프레스보다 훨씬 더 빠르고 보안에도 뛰어난 블로그를 깃허브에 무료로 만들 수 있고, 별도의 페이지를 만들기도 쉽다. 또한, HTML과 CSS에 대한 약간의 지식만 있으면 페이지는 물론 각 포스트마다 다른 레이아웃을 줄 수도 있다.

## 설치

***맥 OS X에서 터미널을 원활히 사용하기 위해서는 Xcode와 커맨드 라인 툴은 기본으로 [설치](https://developer.apple.com/kr/support/xcode/)되어 있어야 한다.***

맥 OS X에는 루비가 이미 설치되어 있으므로 터미널에서 `ruby -v`를 입력하여 루비 버전을 체크한 후 다음 명령으로 지킬을 설치한다.


    [sudo] gem install jekyll


`[sudo]`가 필요한 경우엔 `[]`없이 `sudo gem install jekyll`을 입력한다. 만약, RubyGems 버전과 관련한 에러가 나면 `sudo gem update --system`으로 업데이트한 후 설치하면 대부분 해결할 수 있다.

이제 로컬 디렉토리에 지킬을 설치하고 온라인 깃허브에 자신의 블로그를 올릴 차례이다. 이 블로그 주소와 같이 `nolboo.github.io` 계정주소로 생성하는 경우와 `nolboo.github.io/blog`처럼 프로젝트 페이지 주소로 생성하는 경우가 있다. 전자의 경우가 훨씬 사용하기 쉽다.

## 계정 주소 페이지


    jekyll new 깃허브사용자명.github.com // 깃허브사용자명.github.com 디렉토리를 만들어 기본 디렉토리와 화일을 생성한다.


깃허브사용자명.github.com으로 만들면 별도의 비용없이도 자신의 블로그 주소를 가질 수 있다. 자신의 경우에 맞게 `깃허브사용명`을 입력한다.


    cd 깃허브사용자명.github.com
    jekyll serve --watch


이제 웹브라우저 주소창에 `localhost:4000`을 입력하면 내 컴퓨터(로컬)에서 디폴트 페이지로 생성된 지킬 사이트를 볼 수 있다.

![basic-jekyll][2]

지킬은 웹서버를 내장하고 있어 아파치나 NgineX와 같은 별도의 웹서버를 띄우지 않고도 사이트를 확인할 수 있다. `--watch`는 사이트를 변경하는 대로 백그라운드에서 제너레이트하여 브라우저에서 변경사항을 바로 확인할 수 있는 옵션이다.

  * _리눅스와 윈도우는 놀부가 직접 테스트해 볼 수가 없으니 [공식문서][3]와 [추천글][4]로 대치한다._

깃허브에서 `깃허브사용자명.github.com`이란 이름으로 새로운 온라인 저장소를 만든다. 깃허브나 커맨드 라인이 생소하면 [완전초보를 위한 깃허브][5]를 참조한다.


    git init
    git remote add origin 저장소URL
    git add .
    git commit -m "Initialize blog"
    git push origin master


이제 끝났다. 지킬에서 페이지를 생성하는 것이 시간이 걸리는 경우가 있기 때문에 보통 10분 정도 기다리면(바로 반영되는 경우도 많다.) `깃허브사용자명.gthub.io`에서 내 블로그를 볼 수 있다. 약간 복잡한 프로젝트 주소로 설정하는 것에 관심없는 사람은 아래 부분은 건너뛰어도 좋다.

## 프로젝트 주소 페이지

프로젝트 페이지로 만들 때 상대경로를 써야하기 때문에 조금 더 복잡해진다.


    jekyll new blog // blog 디렉토리를 만들어 기본 디렉토리와 화일을 생성한다.
    cd blog
    jekyll serve --watch


여기까지는 거의 동일하다.


    git init
    git checkout --orphan gh-pages


깃허브에 `blog`란 이름으로 새 저장소를 만들고(로컬 디렉토리와 같은 이름으로 만드는 것이 나중에 기억하거나 유지보수하기가 좋다.) 저장소url을 복사한다.


    git remote add origin 저장소url
    git add .
    git commit -m "Initialize blog"
    git push origin gh-pages  // 반드시 gh-pages 브랜치로 푸시해야 깃허브가 블로그 페이지를 만들어 준다.


이제 `깃허브사용자명.github.io/blog`의 주소로 가면 자신의 블로그를 볼 수 있다.

![project-no-css][6]

이런! 그러나, 기본 CSS 스타일이 적용되지 않았다. 이제부터 조금 수고를 해줘야한다.(템플릿 등이 익숙하지 않은 사람에겐 **계정주소**로 설정하는 것이 좋다.)

### 상대주소 지정

`_config.yml`화일을 텍스트에디터로 열어 baseurl 값을 저장소이름과 동일하게 설정한다.


    name: Your New Jekyll Site // 자신이 원하는 멋진 블로그 이름으로 변경한다.
    markdown: redcarpet
    pygments: true

    baseurl: "/blog" // 이 부분을 반드시 추가하여야 한다.


`index.html` 화일을 다음과 같이 변경하여 상대경로로 변경한다.

![index.html][7]

`_layout` 디렉토리 안의 `default.html`의 `head` 태그의 스타일 시트의 경로를 상대경로로 변경하여야 한다.

```html
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>지킬로 깃허브에 무료 블로그 만들기</title>
    <meta name="viewport" content="width=device-width">

    <!-- syntax highlighting CSS -->
    <link rel="stylesheet" href="/css/syntax.css"> <!-- /css 앞에 을 추가한다. -->

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/main.css"> <!-- /css 앞에 을 추가한다. -->

</head>
```

저장한 후에 로컬에서 지킬을 실행할 때 다음과 같이 `-baseurl ''` 옵션을 주어 상대경로를 없애야 `localhost:4000`의 로컬 주소에서 블로그를 볼 수 있다.


    jekyll serve --baseurl '' --watch


블로그 제목과 계정 등을 텍스트에디터로 추가적으로 변경하고 깃허브로 푸시(업로드)한다.


    git add .
    git commit -m "Change url method"
    git push origin gh-pages


이제 `깃허브사용자명.github.io/blog`에서 자신의 블로그를 볼 수 있다.(10분 정도의 시간이 걸릴 수 있다)

복잡하다고 생각되는 사람은 제가 올려놓은 [깃허브 소스][8]를 포크하여 자신의 로컬 디렉토리로 클론하여 시작할 수 있다. 깃허브에서 포크한 후 다음과 같은 터미널 명령어를 입력한다.


    git clone https://github.com/깃허브사용자명/blog


그러나, 이 경우에도 `_config.yml`에 `baseurl: /blog`는 직접 추가해야 한다.

## 필수 엔진 설치

### 마크다운 프로세싱 엔진 설치

RDiscount는 C로된 마크다운 프로세싱 엔진이다. `[sudo] gem install rdiscount`로 설치한다. kramdown과 redcarpet 등도 동일한 방법으로 설치할 수 있다. 기본 마크다운을 사용한다면 차후에 좀 더 필요성을 느낄 때 설치하여도 된다.

### [Pygments][9]

Pygments는 파이썬 기반 구문 하일라이터이며, 코드를 이쁘게 보여준다. `[sudo] easy_install Pygments`로 설치한다.

## 지킬 기본 디렉토리 구조

디렉토리와 설정화일인 `_config.yml`은 구조와 설명은 참고적으로 설명한다. 그러나, **자신이 작성할 블로그글을 `_post` 안에 `YYYY-MM-DD-[POST SLUG].[FORMAT` 형식으로 포스트 화일명을 지정하는 것은 엄격하게 지켜야 한다.**

  * _config.yml // 전역 환경설정 화일
  * _layouts // 기본 레이아웃
  * _posts
    * 2013-09-14-welcome-to-jekyll.markdown // 기본 블로그 포스팅
  * _site // 제너레이트된 블로그가 위치하는 곳
  * css
    * main.css
    * syntax.css // 코드 하일라이트 스타일링
  * index.html

### _config.yml

환경설정은 [YAML 형식][10]을 사용한다.

`name`과 `description`의 따옴표 안에 자신의 것을 넣어 준다. 특수문자를 포함하지 않으면 따옴표를 사용할 필요도 없다.

### _includes

`template partials`(혹은 워드프레스의 `get_header()` 명령)에 친숙하다면 includes 디렉토리는 같은 일을 한다. 헤더와 푸터 같이 공통의 화일을 같는 포스트와 페이지의 테마 빌더이다. 디렉토리나 화일 앞의 `_`을 붙이면 웹사이트를 제너레이트할 때 복사되지 않는다.

### _layouts

이것도 테마에 사용되는 폴더이다. 포스트의 레이아웃 화일을 저장한다. 여러 개의 레이이웃을 사용할 수 있으며, 대부분의 블로그 포스트는 `post` 레이아웃을 사용하고, 각 포스트의 텍스트 컨텐츠, 공유버튼, Disqus 댓글 등을 포함한다. 댓글과 공유버튼이 없는 `posts-no-comments`라는 레이아웃을 사용하는 페이지도 있다. 너비가 꽉차는 포트폴리오 레이아웃을 사용하기도 한다.

### _posts

마크다운(또는 HTML/Textile) 블로그 포스트 화일을 넣는 곳이다.

### _site

컴파일된 블로그 사이트는 `_site`에 옮겨진다.

## 블로그 포스트 추가

### Front-matter

프론트매터는 지킬에게 이 화일을 처리해야할 방법을 알려주는 일종의 메타데이타이다. 화일의 제일 앞에 위치해야 한다. **지킬은 front matter 블록으로 시작되는 화일(.html이라고 할지라도)만 처리한다.**


    ---
    layout: post
    title: Blogging Like a Hacker
    ---


각 블로그 포스트의 front matter에는 “title”과 “layout” 필드는 반드시 들어가야 한다. date는 화일 이름에 들어가니 필수는 아니다.

### 마크다운으로 포스트 작성하기

`_posts` 폴더에 모든 블로그 포스트 컨텐츠와 메타데이타가 있다. 지킬은 매우 스마트해서 이 폴더에 Markdown, HTML 과 다른 포맷을 섞어 넣을 수도 있다.

블로그를 포스트하려면 마크다운 화일을 `_posts` 폴더에 떨어뜨리면 된다. 그러나, 포스트와 화일의 이름은 다음과 같은 이름 구조를 가져야한다:

`YYYY-MM-DD-[POST SLUG].[FORMAT]`

예로, 2013년 9월 14일에 마크다운 포맷으로 “best-blog-platforms”(한글은 피해야 한다.)에 대한 포스트를 썼다면 다음과 같이 이름붙인다.

`2013-10-15-best-blog-platforms.md`

[post slug][11]는 포스트 이름의 URL 친화적인 형식을 말한다. 스페이스나 이상한 문자와 URL에서 보통 허용되지 않는 것을 쓰지말라는 것이다. 표준 관례는 모든 문자는 소문자, 스페이스 대신 `-`를, 비교적 짧은 slug를 사용하는 것을 포함한다.

이제 깃허브에 나만의 주소를 가진 블로그를 만들고 마크다운으로 블로그 포스트를 작성할 수 있다! 모든 문서를 텍스트에디터에서 작성할 수 있는 마크다운이 익숙하지 않은 분들은 [존 그루버 마크다운 페이지 번역][12]을 보면 쉽게 따라 할 수 있다.

지킬은 워드프레스, Blogger, Tumblr, Posterous, 드루팔, Movable Type, Typo, TextPattern, Mephisto 등에서 블로그를 [마이그레이션][13]할 수 있다.

## 기타 참고 사항

* <mark>[지킬 공식 사이트 한글 번역](http://svperstarz.github.io/jekyll-docs-ko/)</mark>
* [지킬 테마 모음](http://jekyllthemes.org/)
* Sass기반 지킬 블로그 테마: [머핀](http://www.richbray.me/muffin/)
* 지킬 기반 블로그 플랫폼
  1. [옥토프레스](http://octopress.org/) : 이 블로그는 여러 편의 때문에 옥토프레스로 먼저 만들어졌다. 설치방법은 [옥토프레스로 블로깅하기](http://j.mp/1b4M9AD) 참조.
  2. [지킬 부트스트랩](http://jekyllbootstrap.com/)
* 지킬을 깃허브에 적용할 때 아쉬운 점은 보안상의 문제로 플러그인을 사용할 수 없다는 것이다. 그러나 사이트를 아예 제너레이트한 다음 깃허브로 푸시하면 대부분 문제없이 사용할 수 있다. 다양한 플러그인은 [지킬 사이트](http://jekyllrb.com/docs/plugins/)와 [이곳](http://www.jekyll-plugins.com/)에서 볼 수 있다.
* [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/)

   [1]: http://jekyllrb.com/
   [2]: http://farm8.staticflickr.com/7413/10289345933_7fefe3a053.jpg
   [3]: http://jekyllrb.com/docs/installation/
   [4]: http://www.madhur.co.in/blog/2011/09/01/runningjekyllwindows.html
   [5]: http://j.mp/18GPAt2
   [6]: http://farm6.staticflickr.com/5532/10289218326_e4a2f03264.jpg
   [7]: http://farm4.staticflickr.com/3786/10289443045_20c91b2f4d_z.jpg
   [8]: https://github.com/nolboo/Jekyll-Github-Page-blog
   [9]: http://pygments.org/
   [10]: https://en.wikipedia.org/wiki/YAML
   [11]: https://en.wikipedia.org/wiki/Clean_URL#Slug
   [12]: http://j.mp/157wQmp
   [13]: http://jekyllrb.com/docs/migrations/
  