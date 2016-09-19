---
layout: post
title: "HTML & CSS 초보자 가이드 - 2강 : Elements & Semantics"
description: "일단 코딩을 시작하게 되면 semantic 코딩을 반드시 원하게 될 것이다. semantic 코딩을 한다는 것은 코드를 잘 정리하고 풍부한 정보를 갖춘 결정도 할 수 있다는 것이다."
category: blog
tags: [Beginner, CSS, HTML, semantic, element]
---

원본 : [A Beginner’s Guide to HTML &amp; CSS - LESSON 2 : Elements &amp; Semantics][1]

일단 코딩을 시작하게 되면 semantic 코딩을 반드시 원하게 될 것이다. semantic 코딩을 한다는 것은 코드를 잘 정리하고 풍부한 정보를 갖춘 결정도 할 수 있다는 것이다.

## Semantics Overview(시맨틱 개요)

HTML에서 [Semantics][2]는 페이지의 의미와 구조 위에 컨텐츠를 올려놓는 것이다. 페이지에서 컨텐츠의 **가치**를 표현하며, 스타일링 목적으로**만 사용되진 않는다**. semantic 코딩은 웹 페이지를 적절히 읽고 이해하는 능력을 컴퓨터, 스크린 리더, 검색엔진이나 다른 기기들에게 제공하는 등의 이점을 제공한다. 게다가 semnatic 코드는 각 컨텐츠의 특성을 명확하게 알 수 있어 관리하거나 일하는 것이 더 쉽다.  

역자 참고링크:

* [HTML5 : 의미있는 문서, 시맨틱(SEMANTIC) 요소](http://m.mkexdev.net/77)
* [시맨틱 웹](http://ko.wikipedia.org/wiki/%EC%8B%9C%EB%A7%A8%ED%8B%B1_%EC%9B%B9)

## Divisions & Spans

div(division)와 span은 켄텐츠의 컨테이너로 작동되는 HTML 엘리먼트다. p(paragraph)는 단락을 나타내는 시멘틱 엘리먼트이지만 div와 span은 그런 의미를 가지지않는 단순한 컨테이너다. 그러나, CSS 스타일링을 세부적으로 지정할 수 있기 때문에 는 웹사이트 제작 시 매우 쓸모있는 것이다.

div는 웹 사이트의 큰 섹션을 정의하는 데에 주로 사용되는 블럭 엘리먼트이며, 레이아웃과 디자인을 만드는 것을 도와준다. 한편, span은 문단(p)과 같은 블럭 엘리먼트 안의 일부 텍스트 부분을 정의하는 데에 주로 사용되는 inline 엘리먼트다.

> #### Block vs. Inline Elements
>
> 모든 엘리먼트는 블럭 또는 inline 엘리먼트다. 그 차이점은?
>
> **블럭 엘리먼트**는 페이지의 새로운 줄에 시작되며, 가능한 최대의 너비를 갖는다. inline 레벨 엘리먼트 뿐만 아니라 다른 블럭 엘리먼트도 포함할 수 있다.
>
> **inline 엘리먼트**는 새로운 줄에서 시작되지 않으며, 문서의 흐름을 따르고 필요한 너비만을 가진다. 블럭 엘리먼트를 포함할 수 없으나 다른 inline 엘리먼트를 포함할 수는 있다.

div와 span은 class나 id를 주어 값을 더해줄 수 있다. class와 id는 대체로 스타일링 목적으로 사용되거나 다른 div, span과의 차이를 나타낼 수 있다. 그러므로 클래스나 id 이름은 semantic하게 선택하는 것이 중요하다.

예를 들면, 오렌지 배경색를 가진 소셜미디어 링크를 “orange” 클래스로 이름을 주게되면, 나중에 배경색이 파란색으로 바뀌면 “orange” 클래스는 더 이상 의미가 없어진다. 좀 더 낫게 시멘틱한 클래스 이름은 `div` 스타일이 아닌 컨텐츠에 적합한 “social”이 될 것이다.

```html
<!-- div -->
<div class="social">
  <p>Lorem ipsum dolor sit amet...</p>
  <p>Lorem ipsum dolor sit amet...</p>
</div>

<!-- span -->
<p>Lorem ipsum dolor sit amet, <span class="tooltip">consectetur</span> elit.</p>
```

## Typography

온라인 컨텐츠의 아주 많은 부분은 문자 위주다.

### Headings

블럭 엘리먼트이며 `h1`~`h6`까지 6개이다. `h1`은 페이지나 섹션의 주 헤딩으로 쓰여야 하며, 보조적 헤딩으로 `h2`가 필요할 때 쓰여져야 한다. 텍스트를 굵게하거나 크게하기 위해 쓰여져서는 안된다.

```html
<h1>This is a Level 1 Heading</h1>
<h2>This is a Level 2 Heading</h2>
<h3>This is a Level 3 Heading</h3>
```

> #### Headings Demo
>
> ## This is a Level 2 Heading ### This is a Level 3 Heading

### Paragraphs

`p` 블럭 엘리먼트로 정의한다

### Bold Text with Strong

`strong`과 `b`는 모두 텍스트를 굵은체로 표시한다. 둘의 [semantic 차이][3]를 이해하는 것이 중요하다. `strong`은 중요하여 강조하는 굵은 체이며, `b`는 스타일 상 굵은 체이나 항상 주목받는 텍스트는 아니다.

### Italicize Text with Emphasis

`em`과 `i`의 차이도 거의 ditto다.

## Hyperlinks(하이퍼링크)

`a`(nchor) inline 엘리먼트로 정의되며 `href`(hyperlink reference)로 링크의 목적지를 정한다.

HTML5에서는 `a` inline 엘리먼트가 블럭 또는 inline 레벨 엘리먼트를 포함할 수 있게 되어, 페이지의 컨텐츠 블럭 전체를 링크할 수 있다.

### Relative & Absolute Paths(상대주소와 절대주소)

링크의 일반적인 두가지 형태는 한 웹사이트 안에서 _다른 페이지_로의 링크와 _다른 웹사이트_로의 링크다.

같은 웹사이트 안의 다른 페이지로 링크를 **상대주소**라고 하며, `href` 속성값에 `/about.html`과 같이 도메인이 없다. 서브디렉토리를 지정하려면 `/page/about.html`과 같이 한다.

다른 웹사이트로 링크하려면 **절대주소**가 필요하며, `href` 속성값에 `http`와 `.com` 등의 전체 도메인이 포함되어야 한다.

```html
<!-- Relative Path -->
<a href="/about.html">About</a>

<!-- Absolute Path -->
<a href="http://www.google.com/">Google</a>
```

### Linking to an Email Address(이메일 링크)

이메일 링크를 만들려면 `href` 속성값에 `mailto:`로 시작되는 이메일 주소를 준다.

추가적으로 이메일의 제목과 본문도 줄 수 있다. 제목은 추가하려면 이메일 주소 바로 뒤 패러미터(`?` 바로 뒤에 위치)로 `subject=`로 지정하며 여러 단어를 사용할 경우에는 빈칸으로 해석되는 `%20`을 사용하여 나열할 수 있다. 본문을 추가하려면 `body=` 패터미터를 사용한다. 마찬가지로 빈칸은 `%20`을 사용하고 줄바꿈은 `%0A`를 사용한다.

여러 개의 이메일 주소, cc, bcc 패러미터 등을 추가하는 방법은 [The Full mailto Link Syntax][4]를 참조.

```html
<a href="mailto:shay@awesome.com?subject=Still%20Awesome&body=This%20is%20awesome">Email Me</a>
```

### Opening Links in a New Window(새 창으로 링크 열기)

아래와 같이 `target` 속성에 `_blank`값을 준다.

```html
<a href="http://shayhowe.com/" target="_blank">Shay Howe</a>
```

### Linking to Elements within the Same Page(같은 페이지 내의 엘리먼트 링크)

아래와 같이 링크하기를 원하는 엘리먼트에 ID를 지정하고 `href`의 속성값을로 그 ID를 사용한다.

```html
<a href="#awesome">Awesome</a>
<div id="awesome">Awesome Section</div>
```

## HTML5 Structural Elements(HTML5 구조 엘리먼트)

HTML5에서는 좀 더 시맨틱한 코드를 허용하는 몇 개의 새로운 블럭 엘리먼트가 제공된다.

![HTML5 Document Structure][5]

**Fig. 2.01** The new HTML5 structural elements outline.

`header`는 페이지, article, section 혹은 페이지의 세그먼트의 머리 부분을 정의한다. 일반적으로 헤딩, 도입 구문, 네비게이션을 포함하기도 한다. 한 페이지에 한 개 이상의 `header`를 사용할 수 있다. 페이지의 시작에 `header`를 포함하는 것이 이상적이나 구자거으로 article의 헤더나 섹션에 필요한 만큼 사용할 수 있다.

> `header` 엘리먼트는 `head` 또는 `h1` ~ `h6`의 heading과 혼동하면 안된다.
>
> `header` 엘리먼트는 `body` 엘리먼트에 포함되는 페이지 헤딩을 잡아주는 구조적 엘리먼트다. `head` 엘리먼트는 페이지에 표시되지 않으며 메타데이터, 도큐먼트 제목, 외부 화일 링크 등의 정보를 지정하기 위해 사용된다.
>
> `h1` ~ `h6`의 heading은 페이지에 걸친 텍스트 헤딩의 여러 단계를 표현하기 위해 사용된다.

### Navigation

`nav`는 웹사이트의 주요 항해 링크들을 하나로 모은 블럭 엘리먼트다.

```html
<nav>
  <ul>
    <li><a href="#">...</a></li>
    <li><a href="#">...</a></li>
  </ul>
</nav>
```

### Article

`article`은 `div`나 `section`과 매우 유사한 블럭 엘리먼트이나 독립적으로 분배되거나 재사용할 수 있는 컨텐츠를 특별히 지정한다. 대부분의 경우 `article`은 블로그나 퍼블리싱 웹사이트 내의 공개된 컨텐츠를 정의한다. `article` 안의 컨텐츠는 RSS 피드 컨텐츠와 같이 다른 곳에 배포될 수 있어야 한다.

### Section

`section`은 `article`보다는 `div`와 좀 더 혼동될 수 있다. `section`은 일반 도큐멘트 혹은 앱의 섹션을 정의한다. `section`은 스타일링이나 스크립팅의 편의를 위해 사용되지 않는 것이 `div`와의 차이점이다.

`section`에 스타일을 적용할 수 있으나, 스타일 적용만을 목적으로 사용되지 않는다.

> #### Deciding When to Use a section or div
>
> `div`와 대비하여 `section`을 사용하기를 결정하는 가장 좋은 방법은 실제 컨텐츠를 보는 것이다. 만약 컨텐츠 블럭이 데이타베이스 안의 레코드로 존재하고 CSS 스타일링 훅이 명백히 필요하지 않다면 `section` 엘리먼트가 가장 좋을 것이다. 섹션은 페이지를 나누기 위해 사용되어져야 하며, 자연스런 계층을 제공하고 대부분 적절한 헤딩이 가지고 있다.
>
> 반면 `div`는 컨텐츠 블럭에 스타일을 적용할 때 사용될 수 있다. 예를 들면 한 쌍의 문단이 페이지의 나머지 컨텐츠보다 두드러질 필요가 있다면 그것들을 `div`로 감싸고 백그라운드, 보더와 같은 적절한 스타일을 주어야 한다.

### Aside

`aside`는 도큐멘트나 섹션과 관련된 컨텐츠를 정의하는 블럭 엘리먼트이며, 필요하다면 한 페이지에서 여러번 사용될 수 있다.

좌우로 위치시키려면 `aside` 엘리먼트를 `float`하는 것이 필요하고 이는 나중에 [floating and positioning][6] 에서 배울 것이다.

### Footer

`footer`는 `header`와 동일하나 페이지, article, section이나 다른 페이지 세그먼트의 아래 부분을 위한 것이다.

## D.R.Y. – Don’t Repeat Yourself

개발의 원칙 중 하나는 코드를 여러번 되풀이하지 말라는 D.R.Y.이다. CSS에서는 계속해서 같은 스타일을 지속적으로 코딩하기 쉽기 때문에 이 원칙은 많은 걸 말해준다. 절대 하지 마라. CSS는 스타일을 적용하고 상속하기 쉽게 하도록 cascade와 class를 허락하게 디자인되어 있다. 최종 목표는 깨끗하고 가벼운 코드를 쓰고 시맨틱하고 쉽게 관리되는 것이다.

## Resources & Links

* [Semantic code: What? Why? How?](http://boagworld.com/dev/semantic-code-what-why-how/) via Boagworld
* [HTML5 Doctor](http://html5doctor.com/)
* [The i, b, em, & strong Elements](http://html5doctor.com/i-b-em-strong-element/) via HTML5 Doctor
* [The Full mailto Link Syntax](http://yoast.com/guide-mailto-links/) via Joost de Valk
* [New Structural Elements in HTML5](http://dev.opera.com/articles/view/new-structural-elements-in-html5/) via Dev.Opera


   [1]: http://learn.shayhowe.com/html-css/elements-semantics
   [2]: http://boagworld.com/dev/semantic-code-what-why-how/
   [3]: http://html5doctor.com/i-b-em-strong-element/
   [4]: http://yoast.com/guide-mailto-links/
   [5]: http://learn.shayhowe.com/assets/courses/html-css-guide/elements-semantics/html5.png
   [6]: http://learn.shayhowe.com/html-css/box-model
  