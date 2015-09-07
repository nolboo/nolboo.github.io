---
layout: post
title: "Harp로 블로그 만들기"
description: "node.js 기반의 오픈소스 정적 사이트 제너레이터인 harp로 블로그를 만드는 방법"
category: blog
tags: [blog, harp, static]
---

원문 : [Start a blog with Harp](http://kennethormandy.com/journal/start-a-blog-with-harp)

참조 :  [Intoducing Harp](http://sintaxi.com/introducing-harp)

<div id="toc"><p class="toc_title">목차</p></div>

## Install Harp

    sudo npm install harp -g

하프를 글로벌로 설치한다.

    cd ~/Sites
    harp init my-harp-blog

`harp init`이 다음과 같은 디폴트앱을 만든다.

    ▾ /
      ▪ _layout.jade
      ▪ 404.jade
      ▪ index.jade
      ▪ main.less

    이제 웹서버를 시작하여 하프앱을 눈으로 보자.

    harp server my-harp-blog

[localhost:9000](localhost:9000)에서 로컬에서 실행된 `my-harp-blog`를 볼 수 있다.

![](http://kennethormandy.com/journal/images/start-a-blog-with-harp/1.png)

## Start with Markdown

마크다운 화일을 추가하여 새 페이지를 만들어보자. 루트 디렉토리에 `about.md`를 만들어 아래와 같은 형식으로 자신에 대한 것을 적는다.

    # About Kenneth

    Hi, I’m Kenneth. Sometimes I write about building things with [Harp](http://harpjs.com).

화일을 저장하고 [localhost:9000/about](localhost:9000/about)를 방문하면 about 페이지를 볼 수 있다. 하프를 재시작할 필요도, 무언가를 설정할 필요도 없다.

`about.md` 화일을 변경하고 저장하고 브라우저를 새로고침하면, 변경된 것이 이미 반영된다.

![](http://kennethormandy.com/journal/images/start-a-blog-with-harp/2.png)

정적 사이트 제너레이터를 경험해 본 적이 있다면 화일 watcher를 시작하고 정지시키는 작업을 했을 것이다. 하프에선 그럴 필요가 없다; 서버가 작동하고 있는 한, 변경사항이 바로 브라우저로 전달된다. 이 프로세스는 매우 빠르다: 화일이 제대로 준비된다면, 하나의 화일이 변경되었을 때 전체 앱을 다시 빌드할 필요가 없다.

하프는 순수 HTML로 about 페이지를 렌더링하지 않는 것을 주목해야한다. 대신, 먼저 레이아웃 화일을 통과하여 인덱스 페이지와 매칭한다.

## Layouts

레이아웃은 헤더와 푸터 등 또는 더 복잡하게 반복되는 구조를 만들기 위해서 사용된다. `_layout` 화일은 마크업을 포함한다. [규약](http://harpjs.com/docs/development/rules)에 의하면, 하프는 밑줄(`_`)로 시작되는 화일이나 폴더는 서비스하지 않는다. 특별히, 이 `_layout.jade`은 화일을 위한 wrapper로서 _서비스 된다_.

`about.md`, `404.jade`, `index.jade`의 모든 컨텐츠는 `yield` 변수로 사용하여 레이아웃의 어디에든 가져올 수 있다.

```jade
!!!
html
  head
    link(rel="stylesheet", href="/main.css")
  body
    != yield
```

Jade의 명쾌함은 강력하다. 처음에 친숙하지 않더라도 사용해 볼 것을 권한다. 당신이 `HTML`을 고수하려한다면, 하프는 `EJS`도 지원한다.

```html
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="main.css" />
  </head>
  <body>
    <%- yield %>
  </body>
</html>
```

Jade에서, 감탄부호(`!`)는 `yield`가 예외처리되지 않게 한다. `EJS`에서 하이픈(`-`)과 같다.

어느 쪽이든, `main.css`가 참조된 것을 주의한다. 폴더에 실제로 그 화일이 없더라도;`main.less`가 있다. 하프는 프리프로세싱이 내장되어 있다. `LESS` 화일을 업데이트하고 저장하면 변경사항이 브라우저에 바로 변경된다. 디폴트 스타일시트에 조금 추가한 것이 있다. 같은 것을 사용하고 싶다면, [여기](https://github.com/kennethormandy/my-harp-blog/blob/master/main.less)에 있다.

![](http://kennethormandy.com/journal/images/start-a-blog-with-harp/3.png)

## Adding Articles

나는 `localhost:9000/articles/another-article`에서 내 첫번째 글을 액세스하고 싶다. 그래서 `article` 디렉토리를 만들 것이다. 폴더가 그대로 URL이 된다; 원하는 대로 `URL`을 반영하는 디렉토리 구조를 만들어라.

    ▾ /
      ▪ _layout.jade
      ▪ 404.jade
      ▪ index.jade
      ▪ main.less
      ▾ articles/
        ▪ _data.json
        ▪ a-simple-article.md
        ▪ another-article.md

추가한 글은 마크다운이면 된다. 글 자체를 넘어서는 글에 관한 정보는 `_data.json` 안에 담긴다.

## Flexible Metadata

각각의 `.md` 화일이 아닌  _data.json` 안의 메타데이타를 유지하는 것은 몇 가지 이유로 잘 작동된다.

1.  하나의 화일에 어떤 크기의 메타데이타를 가질 수 있으므로, 당신의 글을 방해하지 않는다.
2.  포스트, 이미지, 비디오 혹은 다른 어떤 것의 메타데이타가 같은 방식으로 추가될 수 있다.
3.  다른 화일들도 이 `_data.json`을 쉽게 사용할 수 있다.
4.  정보의 순서를 화일명으로 요구하기보다 `_data.json`에서 정할 수 있다.

글 자체 안이 아닌 `_data.json` 화일에 제목, 날짜, 혹은 다른 정보를 추가하여, 마크다운을 사용하는 이점을 최대한으로 얻을 수 있으며 단지 글쓰기에 대해서만 고민하면 된다.

이 블로그를 위해, 내 `_data.json` 화일에 아래와 같이 추가하기로 했다:

```json
{
  "a-good-article": {
    "title": "A Good Article"
  },
  "a-complicated-article": {
    "title": "Another Article"
  }
}
```

Jade를 사용하여, 이 메타데이타를 반복할 수 있고, 모든 글을 목록화했다. `index.jade`에 다음을 추가했다.

```jade
ul
  each article, slug in public.articles.data
    li
      a(href="/articles/#{ slug }") #{ article.title }
```

기대한대로, 홈페이지에 이제 글 목록이 있다.

![](http://kennethormandy.com/journal/images/start-a-blog-with-harp/4.png)

이 블로그는 아직 내비게이션할 방법이 빠져있다. 레이아웃에 헤더뿐만 아니라 푸터에 내비를 넣는 것이 좋을 것이다. 하프의 `partial` 함수로 같은 마크업을 여러 번 반복하지 않을 수 있다.

## Partials

`partial()`은 하나의 화일에서 다른 화일로 가져다 사용할 수 있다. 앱에서 하나의 partial로 어떤 텍스트 기반 화일을 사용할 수 있다. 일반적으로 전체 페이지보다는 하나의 코드 스니핏으로 가져오길 원할 것이다. 그러나, 각각에 `partial()`을 사용할 수도 있다. `_layout` 화일을 사용할 때, 화일명의 시작에 밑줄을 추가하면 자신의 페이지가 제너레이트되지 않을 것이다. 코드 스니핏일 때 훌륭하다. 이 규약은 폴더에서도 적용된다:밑줄로 시작되는 폴더는 그 안의 어떤 것도 제너레이트되지 않는다. 밑줄로 시작되는 폴더는 partial을 저장하기에 좋은 장소이다. 이를 위해 `_shared` 폴더를 만들었다.

`_shared/` 안에 `nav.jade`란 새 화일을 만들었다.

```jade
nav
  a(href="/") Home
  a(href="/about") About
```

이제 `_layout.jade` 안에 `partial()`로 다음 화일을 사용했다:

```jade
!!!
html
  head
    link(rel="stylesheet", href="/main.css")
  body
    != partial("_shared/nav")
    != yield
    footer
      != partial("_shared/nav")
```

이제, 중복된 마크업을 사용하지 않고 내비가 블로그 포스트의 위와 아래에 나타난다. 이건 단순한 예제이다. 그러나, 유용한 partial들이 블로그의 부분들로 얼마나 유용하게 어디서나 재사용될 수 있는지 상상할 수 있을 것이다.

![](http://kennethormandy.com/journal/images/start-a-blog-with-harp/5.png)

## Getting it out there

이제 블로그가 첫번째 버전을 온라인으로 올릴 만하게 보인다. 하프앱은 `HTML`, `CSS` & `JavaScript`로 변환하여 원하는 어떤 곳에도 발행할 수 있다.

    harp compile

이 명령은 블로그의 `HTML`, `CSS` &amp; `JavaScript`이 들어있는 `www` 폴더를 제너레이트한다. 아마존 S3, [GitHub Pages](http://harpjs.com/docs/deployment/github-pages), [Heroku](http://kennethormandy.com/journal/harpjs.com/docs/deployment/heroku), Nodejitsu 혹은 Apache Cordova/PhoneGap를 포함한 어떤 곳에서도 훌륭히 작동된다.

컴파일 단계를 완전히 생략하고, 드랍박스에 앱을 올릴 수 있는 [하프플랫폼](http://harp.io/)에서도 작업할 수 있다.

하프로 사이트를 만들 때 `LESS`, 마크다운, `Jade`와 작업하는 것이 덜 어렵다는 것을 알았다.

_블로그 소스코드는 [GitHub](http://github.com/kennethormandy/my-harp-blog)에 올려져있다._

## 역자 참조 링크

*   계속해서 깃허브 등에 적용하는 포스트가 올라올 것으로 생각되지만, 바로 자신의 블로그를 만들어서 깃허브에 적용하려면 [지킬로 깃허브에 무료 블로그 만들기](http://nolboo.github.io/blog/2013/10/15/free-blog-with-github-jekyll/)와 [완전 초보를 위한 깃허브](http://nolboo.github.io/blog/2013/10/06/github-for-beginner/)를 참조하면 쉽게 올릴 수 있을 것으로 생각한다.
*   마크다운에 익숙하지 않는 분은 [존 그루버 마크다운 페이지 번역](http://nolboo.github.io/blog/2013/09/07/john-gruber-markdown/)을 참조하시면 글쓰기의 신천지를 경험할 수 있다.
*   이 블로그는 [옥토프레스](http://nolboo.github.io/blog/2013/07/21/start-octopress/)로 만들어졌으며, 다양한 블로깅 플랫폼을 탐색하는 중이다.
