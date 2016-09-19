---
layout: post
title: "옥토프레스로 블로깅하기"
description: "옥토프레스를 설치하여 워드프레스 블로그를 마이그레이션하고, 무료 호스팅 서비스를 제공하는 깃허브에 올리고 운영하는 방법"
category: blog
tags: [blog, github, octopress]
---

<!-- <div id="toc"><p class="toc_title">목차</p></div> -->

## 이전 동기와 간단한 과정 소개

워드프레스닷컴의 두 개의 블로그 중 학습을 위해 번역과 요약을 주로 올리던 `nolboos.wordpress.com` 블로그가 워드프레스닷컴에 의해 [중지][1]되었다. 워드프레스 설치 호스팅 서비스를 세 곳이나 친절하게 알려주긴 했지만 도메인이나 비용, 속도 등 여러 사항이 걸리고, 아마존 이외에는 이용하던 호스팅 서비스도 없어 난감해 하고 있었다. 예전부터 Github Page로 블로그를 올리는 방법을 염두에 두고 있었는데 [@sungchi][2]님이 [Github](http://sungchi.github.io/)와 [Ghost][3]를 추천하셨다. 고스트는 아직 개발 중이어서 고려대상에서 제외하였고 깃허브는 블로그글을 쓸 때마다 메인페이지에 링크를 다는 불편함 등이 있었다. 게으른 놀부는 불편함을 없애주는 방법을 찾기 시작했고, 두 개가 눈에 들어왔다.

[하루프레스][4]와 [옥토프레스][5] 옥토프레스가 먼저 나왔고 해외에서 사용자 수가 점차적으로 늘어가고 있는 것 같으나 개발이 일년 이상 중지되어 있는 것 같았고, 하루프레스는 한국분이 [@Rhiokim][6] 만들어서인지 디자인이나 기능적인 측면에서 좀 더 끌리는 면이 있었다. 그래서 하루프레스를 설치하기 시작하였다. 그러나, 중간에 Xcode를 요구하는 에러메시지가 나와 물어보았더니 Xcode가 반드시 있어야 한다는 [답][7]이 돌아왔다. 디스크 용량을 걱정해야 하는 상황에선 Xcode 설치는 무리였다. 낙망하고 별 수 없이 옥토프레스를 설치하기 시작하였다.

## 사전 경험 얻기

검색을 해봐도 옥토프레스에 대한 한글 블로그 글이 거의 없었고,(해커들을 위한 블로그 시스템이라 설명을 안하나?ㅠㅠ) [옥토프레스 이전 과정][8]에서 몇 가지 사전 지식을 얻을 수 있었다.

  * [Exitwp][9] : 워드프레스 블로그를 지킬 블로그 엔진으로 쉽게 이전. 마크다운으로 변환
  * 동영상 임베딩 등은 플러그인을 사용하지말고 원 코드를 사용하는 것이 좋다.
  * 블로그의 제목, 태그는 모두 영문 사용을 기본으로 하는 것이 좋을듯.

## 기존 블로그 글을 [지킬로 마이그레이션](http://jekyllrb.com/docs/migrations/)

    $ gem install jekyll-import --pre


공개/비공개 포스트를 구별하지 않으니 확인해야 한다.


    $ gem install hpricot


`https://YOUR-USER-NAME.wordpress.com/wp-admin/export.php`에서 내려받은 `wordpress.xml`을 변환


    $ ruby -rubygems -e 'require "jekyll/jekyll-import/wordpressdotcom";
    JekyllImport::WordpressDotCom.process({ :source => "wordpress.xml" })'


`_posts`, `_pages`, `_nav_menu_items`의 세 개의 디렉토리에 `.html` 화일들이 추출된다.

## 설치

git과 Ruby를 [설치][10]하고 테마를 적용하였다.(글이 너무 길어지니 이 부분은 링크에서 보세요)

이제 [깃허브에 올려보자][11].

원하던 블로그 도메인인 `nolboo.github.com`으로 [새 저장소][12]를 만든다.


    $ rake setup_github_pages //저장소 URL을 물어보면 내 경우엔 `https://github.com/nolboo/nolboo.github.com.git`을 입력

    $ rake generate
    $ rake deploy


위의 과정까지 마치면 `nolboo.github.com`이나 `nolboo.github.io`로 가보면 기본테마가 적용된 최초의 블로그를 볼 수 있다. 의외로 간단하다.

`Rakefile`과 `_config.yml`만 변경하는 것으로 충분하나 설정 화일 리스트는 다음과 같다.


    _config.yml       # Main config (Jekyll's settings)
    Rakefile          # Configs for deployment
    config.rb         # Compass config
    config.ru         # Rack config


`Rakefile`도 `rsync`를 사용하지 않는 한 변경할 것이 없다.

### 블로그 설정

`_config.yml`은 세 섹션으로 되어있다. _`url`, `title`, `subtitle`, `author`는 반드시 변경해야 하고, 서드파티 서비스를 활성화시켜주어야 한다._

#### 주요 설정


    url:                # For rewriting urls for RSS, etc
    title:              # Used in the header and title tags
    subtitle:           # A description used in the header
    author:             # Your name, for RSS, Copyright, Metadata
    simple_search:      # Search engine for simple site search
    description:        # A default meta description for your site


위의 것만 확인하면서 변경하였다.

플러그인에서는 일단 `disqus_short_name`에 숏네임을 하나 정해서 넣어주었고, `google_analytics_tracking_id`에 추적 ID를 생성해서 입력했다.

## 블로깅 하기

블로그 포스트는 `source/_posts` 디렉토리에 지킬 방식인 `YYYY-MM-DD-post-title.markdown` 형식의 이름으로 저장되어야 한다. 이를 편하게 해주는 rake 명령은 다음과 같다.


    $ rake new_post["title"]


_Title은 영문으로 주는 것이 좋다._ 해당 `.markdown` 화일을 에디터로 열어보면 다음과 같은 YAML 헤더를 볼 수 있다.


    ---
    layout: post
    title: "Zombie Ninjas Attack: A survivor's retrospective"
    date: 2011-07-03 5:59
    comments: true
    external-url:
    categories:
    ---


비공개로 할 경우에는 `published: false`를 추가한다. linklog 스타일로 포스팅할 때는 `external-url`에 링크를 추가하면 된다.

카테고리는 다음과 같은 방식으로 지정한다.


    # 한 개 추가
    categories: Sass

    # 여러 개 추가하기 1
    categories: [CSS3, Sass, Media Queries]

    # 여러 개 추가하기 2
    categories:
    - CSS3
    - Sass
    - Media Queries


블로그의 인덱스 페이지에서 글의 일부만 보여주려면 `` 주석을 넣어주면 “Continue →” 버튼으로 전체 글로 링크된다.

## 제너레이트와 미리보기


    rake generate   # public 디렉토리에 포스트와 페이지를 제너레이트한다.
    rake preview    # http://localhost:4000 에 웹서버를 마운트하고 볼 수 있게 한다.


이제 웹 브라우저에서 `http://localhost:4000` 주소를 입력하여 미리볼 수 있다.

## 출판하기


    $ rake deploy


## 블로깅 워크플로우


    1. $ rake new_post["title"] //title은 영문으로 간단하게
    2. 에디터로 .markdown 화일 편집하고
    3. title: 에 멋진 한글 제목을 달고 categories: [CSS3, Sass, Media Queries] 지정
    4. $ rake generate && rake preview //localhost:4000에서 미리보기와 수정
    5. 소스 백업(*아래 참조*)
    6. $ rake deploy


깃허브에 반영되는 것은 시간이 좀 걸리니 바로 안 나타난다고 조급해하지 말자.

**5번 출판하기 전에 `source` 브랜치에 소스를 직접 푸시하는 것을 잊지마라.**


    git add .
    git commit -m 'your message'
    git push origin source


## 맺는말

마크다운을 이용할 수 있을 정도의 사용자라면 쉽게 써보려고 했지만 많이 부족한 것 같다. 옥토프레스가 내가 원하는 블로깅 워크플로우에 가장 근접하게 사용할 수 있을 것 같다. 이제 워드프레스닷컴에서 홀대받았던 나머지 글들을 계속 올리고 추가적인 포스팅도 꾸준히 할 것이다.

## 추가 참조 링크

* [3rd party plugins](https://github.com/imathis/octopress/wiki/3rd-party-plugins)
* [Creating a Github Blog Using Octopress](http://www.tomordonez.com/blog/2012/06/04/creating-a-github-blog-using-octopress/)
* [Getting Started with Octopress](http://webdesign.tutsplus.com/tutorials/applications/getting-started-with-octopress/)
* [Hello Octopress & Github Pages](http://paulsturgess.co.uk/blog/2013/04/24/hello-octopress-and-github-pages/)

   [1]: http://en.support.wordpress.com/suspended-blogs/
   [2]: https://twitter.com/sungchi
   [3]: http://tryghost.org/
   [4]: http://haroopress.com/
   [5]: http://octopress.org/
   [6]: https://twitter.com/Rhiokim
   [7]: https://twitter.com/n0lb00/status/356388684259528705
   [8]: http://doomed-lover.com/archives/migrating-to-octopress/
   [9]: https://github.com/thomasf/exitwp
   [10]: http://octopress.org/docs/setup/
   [11]: http://octopress.org/docs/deploying/github/
   [12]: https://github.com/repositories/new
  