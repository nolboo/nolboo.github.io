---
layout: post
title: "HTML & CSS 초보자 가이드 - 1강 : 용어, 문법, 소개"
description: "HTML은 콘텐츠에 구조와 의미를 주기 위한 하이퍼 텍스트 마크업 언어이고, CSS는 콘텐츠에 스타일과 모양을 주기위한 프리젠테이션 언어이다."
category: blog
tags: [Beginner, CSS, HTML, terminology, syntax, introduction]
---

<div id="toc"><p class="toc_title">목차</p></div>

원본 : [A Beginner’s Guide to HTML &amp; CSS - LESSON 1 : Terminology, Syntax, & Introduction][1]

HTML은 콘텐츠에 구조와 의미를 주기 위한 하이퍼 텍스트 마크업 언어이고, CSS(**C**ascading **S**tyle **S**heets)는 콘텐츠에 스타일과 모양을 주기위한 프리젠테이션 언어이다. 두 언어는 서로에 독립적이며, CSS가 HTML 문서 안에 있을 필요는 없고, 그 반대도 마찬가지다.

## Common HTML Terms

오늘은 tags, elements, and attributes 세 가지 용어에 대해 익숙해지자.

### Elements

페이지 안에서 구조와 컨텐츠를 포함하는 객체를 정의하기 위한 지명자.

### Tags

시작 태그 `<>` 와 끝 태그 `</>` 엘리먼트는 하나 또는 여러 개의 태그로 만들어진다.

### Attributes

엘리먼트에 추가적으로 주어지는 속성.

## HTML Document Structure &amp; Syntax

모든 HTML 문서는 `doctype, html, head, body`의 선언과 태그를 포함하는 구조로 만들어진다.

`doctype` 선언은 사용된 HTML 버전을 웹 브라우저에게 알려주며, HTML 문서의 최상위에 위치한다. `doctype` 선언에 이어, 문서의 처음과 끝을 뜻하는 `html` 태그가 위치한다.

`head`는 메타 데이타, 문서 `title`, 외부 화일 링크로 구성된다. 실제 웹 페이지에서는 보여지지 않는다. 웹 페이지에 보여줄 모든 콘텐츠는 `body 태그 안`에 넣는다.

일반적인 HTML 문서 구조

```html
<!DOCTYPE html>
<html lang="en">
      <head>
            <meta charset="utf-8">
            <title>Hello World</title>
      </head>
      <body>
            <h1>Hello World</h1>
            <p>This is a website.</p>
      </body>
</html>
```

## Common CSS Terms

### Selectors

스타일을 적용할 엘리먼트(들). ID, class, type, 속성들의 조합이 하나의 실렉터가 될 수도 있다.

### Properties

엘리먼트에 적용될 스타일을 결정한다.

```css
p {
      color: #ff0;
      font-size: 16px;
}
```

### Values

property 의 값이며, `:`와 `;`사이에 위치한다.

## CSS Structure & Syntax

CSS는 실렉터를 사용하여 HTML 엘리먼트에 스타일을 적용하며, 모든 CSS 스타일은 여러 엘리먼트에 상속될 수 있다.

예를 들어 한 페이지 안의 모든 텍스트에 특정 컬러와 크기와 wieght를 하나의 스타일로 지정할 수 있으며, 좀 더 세분화된 실렉터를 사용하여 특정 엘리먼트에 유일한 스타일을 덮어씌울 수 있다.

Fig. 1.01 CSS syntax outline.  
![][2]

### Long vs. Short Hand

CSS에서 속성값을 선언하는 방법 중 하나의 속성과 하나의 값을 여러번 선언하는 것은 long hand, 하나의 속성에 여러 값을 나열하는 것이 short hand이다. short hand를 사용하는 것이 코드가 적기 때문에 좋다. 모든 속성이 shot hand를 지원하는 것이 아니기 때문에 확인해야 한다.

```css
/* Long Hand */
p {
  padding-top: 10px;
  padding-right: 20px;
  padding-bottom: 10px;
  padding-left: 20px;
}

/* Short Hand */
p {
  padding: 10px 20px;
}

/* Short Hand */
p {
  padding: 10px;
}
```

#### Comments within HTML & CSS

주석(comments)은 특히 여러 사람들이 공동작업할 때 매우 유용하다.

HTML comments : `<!--` 로 시작하고 `-->`로 끝난다. CSS comments : `/*` 로 시작하고 `*/`로 끝난다.

## Selectors

elements, IDs, and classes 또는 세 가지의 조합

### Type Selectors

가장 기본적인 실렉터이다. 관리하기 쉽고 코드량이 적고 관리하기 쉽기 때문에 선호된다.

### Class Selectors

HTML에선 `class=”classname”`, CSS에선 `.classname`으로 사용하며, 페이지 내 여러 엘리먼트에 적용될 수 있다.

### ID Selectors

클래스 실렉터와 유사하지만 한번에 하나의 엘리먼트 만을 대상으로 한다. 한 페이지 당 하나만 허용되므로, 중요한 엘리먼트에만 사용되야 한다.

HTML에선 `id=”idname”`, CSS에서 `#idname`으로 사용한다.

### Combining Selectors

CSS의 아름다움은 seelector 와 inherit 스타일을 조합하는 능력이다. 일반적인 실렉터로부터 시작하고 원하는 만큼 특정 실렉터를 조합해 나간다.

```css
ul#social li {
  padding: 0 3px;
}
ul#social li a {
  height: 17px;
  width: 16px;
}
ul#social li.tumblr a {
  background: url('tumblr.png') 0 0 no-repeat;
}
```

### Additional Selectors

그 외 많은 진보된 실렉터가 존재한다. 그러나, [진보된 실렉터][3]가 모든 브라우저에서 작동되는 것은 아니니 제대로 동작하지 않으면 브라우저 지원을 확인해야 한다.

## Referencing CSS

가장 좋은 방법은 웹페이지의 head 안에 하나의 외부 화일로 링크하도록 한다. 하나의 외부 스타일시트을 사용하면 전체 웹 사이트에 걸쳐 같은 스타일을 사용할 수 있고, 사이트를 빠르게 변경할 수 있다.

인터널과 인라인 스타일은 일반적으로 웹 사이트를 업데이트하고 유지하는 것을 짜증나게 한다.

```html
<!-- External CSS File -->
<link rel="stylesheet" href="file.css">

<!-- Internal CSS -->
<style type="text/css">
p {
  color: #f60;
  font-size: 16px;
}
</style>

<!-- Inline CSS -->
<p style="color: #f60; font-size: 16px;">Lorem ipsum dolor sit amet...</p>
```

### Using External CSS Stylesheets

전체 웹사이트에 걸쳐 하나의 스타일로 편하게 관리할 수 있으며, 스타일 렌더링을 위한 트래픽도 적어진다.

다음 예는 서브 디렉토리인 styles의 file.css를 불러오게 된다.

```html
<head>
    <link rel="stylesheet" href="styles/file.css">
</head>
```

## Reset

기본적으로 모든 웹브라우저는 자신 만의 방법으로 엘리먼트의 스타일을 해석한다. 이러한 문제와 전투를 벌이기 위해서 CSS reset이 널리 사용왼다.


> #### Cross Browser Compatibility & Testing
> 각 브라우저가 다른 방식으로 페이지를 렌더링한다. 웹사이트가 모든 브라우저에서 동일하게 보일 필요는 없지만 유사하게는 보여야 한다.


CSS reset은 모든 일반적인 HTML 엘리먼트를 하나의 통일된 스타일로 만들어버리는 몇 개의 룰셋이다. 페이지의 뼈대에 적용되는 모든 스타일이 확실히 렌더링되기 위해 CSS 스타일의 가장 앞에서 위치한다.

엄청 많은 reset이 있으면 각장의 장점을 가지고 있다. 저자가 가장 좋은 하는 것은 [Eric Meyers reset][4]


> #### Code Validation
>
>코드 검증은 브라우저에 걸처 적절하게 렌더링하는 것도 도와주며, 코드 작성을 위한 베스트 프랙티스도 가르쳐 준다.
>[W3C HTML validator](http://validator.w3.org/)
>[W3C CSS validator](http://jigsaw.w3.org/css-validator/)


## Resources & Links

* [Common HTML Terms](http://www.scriptingmaster.com/html/HTML-terms-glossary.asp) via Scripting Master
* [CSS Glossary](http://www.codestyle.org/css/Glossary.shtml) via Code Style
* [Taming Advanced CSS Selectors](http://coding.smashingmagazine.com/2009/08/17/taming-advanced-css-selectors/) via Smashing Magazine
* [CSS Tools: Reset CSS](http://meyerweb.com/eric/tools/css/reset/) via Eric Meyer
* [An Intro to HTML & CSS via Shay Howe](http://www.shayhowe.com/web-design/intro-to-html-css/)


   [1]: http://learn.shayhowe.com/html-css/terminology-syntax-intro
   [2]: http://learn.shayhowe.com/assets/courses/html-css-guide/terminology-syntax-intro/selector.png
   [3]: http://coding.smashingmagazine.com/2009/08/17/taming-advanced-css-selectors/
   [4]: http://meyerweb.com/eric/tools/css/reset/
  