---
layout: post
title: "부트스트랩 3에서 새롭게 바뀐 것"
description: "모바일 퍼스트를 주장하고 나온 트위터 부트스트랩 3에서 새로워진 부분을 모아서 잘 설명한 글의 번역"
category: blog
tags: [bootstrap, css, css3, first, framework, mobile, responsive, web, design, twitter]
---

<div id="toc"><p class="toc_title">목차</p></div>

원문 : [What’s new in Twitter Bootstrap 3?][1]

## Scaffolding

  * 모바일 퍼스트, 반응형 12행 그리드

## 그리드 시스템

`.span*`에서 `.col-xs`, `.col-sm-*`, `.col-md-*`, `.col-lg-*`로 변경. 디폴트로 fluid이므로 `.container-fluid`와 `.row-fluid`은 제거.

모바일, 태블릿, 테스트탑에서 그리드 예제:

```html
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">6</div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">6</div>
</div>
```

## 반응형 디자인

### 반응형 이미지

구글 맵스와 [문제][2]가 있었는데, BS3에선 `.img-responsive` 클래스를 넣어 해결했다. 이 클래스는 이미지에 `max-width: 100%;`와 `height: auto;`를 적용하여 부모 엘리먼트에 따라 크기가 달라진다.

### 반응형 유틸리티

`.visible-xs`, `.visible-sm`, `.visible-md`, `.visible-lg` 4개의 클래스로 크기별로 보이거나, `.hidden-xs`, `.hidden-sm`, `.hidden-md`, `.hidden-lg` 클래스로 숨길 수 있다.

## CSS

글로발 CSS 설정, 기본 HTML 엘리먼트 스타일링 `*zoom: 1`, `-moz-box-shadow` 등의 hack을 없애고 IE7과 파이어폭스 3.6을 지원하지 않는다.

### Typography

헤딩, 리스트, 텍스트 클래스명이 좀 더 일관성있게 되었다. 예: `.list-unstyled`, `.list-inline`, `.text-muted`, `.h1`, `.h2`, `.h3` 등을 사용

### 테이블

기본적으로 `<table>`에 스타일링하지 않으며, `.table`을 사용하여 기본 스타일링을 한다. `.table-hover`로 마우스 오버했을 때와 같이 `.active`로 열을 하일라이트할 수 있다.

### Forms

`.input-prepend`, `.input-append`를 사용하지 않고 `input-group`을 사용한다. 수평폼도 모바일 퍼스트이므로, 768px 보다 작은 화면에서는 그냥 쌓인다. _`.form-control`과 함께 `<input>`, `<textarea>`, `<select>` 엘리먼트는 기본적으로 `width: 100%;`로 설정된다._

`.radio-inline`은 그대로이고 `.form-group`이 추가되었으며, 다음은 없어졌다:

  * .inline-help
  * .help-inline
  * .uneditable-input
  * .form-search
  * .input-block-level
  * .controls-row
  * .input-prepend
  * .input-append

#### Height sizing

`.input-small`, `.input-large` 등을 사용할 때 버튼 크기에 따라 폼의 높이도 변경된다.

### Buttons

기본 버튼도 `.button-default`가 필요하며, `.btn-inverse`는 없어졌다. 나머지 버튼 크기는 `btn-xs`, `.btn-sm`, `.btn-lg`로 바뀌었다.

### Images

`.img-polaroid`는 없어졌으며, 보통의 inline(-block) 이미지를 위한 `.img-thumbnail`이 추가되었다. _`.img-responsive` 클래스를 추가하여 반응형에 가깝게 사용할 수 있다._

## Components

드랍다운 메뉴에 헤더를 줄 수 있다.

### Buttons

`.btn-group-justified` 클래스로 부모 엘리먼트의 전체 너비와 같은 크기를 가질 수 있다.

### Alerts

`.alert` 컴포넌트 안의 `hr` 엘리먼트는 alert 색의 경계선으로 스타일링될 것이다. 링크도 가독성을 위해 자동으로 알맞게 스타일링된다.

### Navs

`.nav-list`가 없어졌고, List group이 대신한다. 왼쪽/오른쪽/아래쪽 탭이 없어졌다. **자바스크립트 플러그인과 커스텀 CSS로 왼쪽/오른쪽 탭을 사용할 수 있다. 그러나 이제 핵심 기능에 포함되지 않는다.**

### Navbar

navbar의 높이가 모바일 기기에선 44px에서 62px로, 데스크탑에선 50px로 커졌고, 박스 그림자나 그라디언트되지 않는다. `.navbar-search`, `.divider-vertical`, `.navbar-inner`가 없어졌으며, 변경된 것은 다음과 같다:

| BS2            | BS3            |
|----------------|----------------|
| .navbar > .nav | .navbar-nav    |
| .btn-navbar    | .navbar-toggle |
| .brand         | .navbar-brand  |

### List group(NEW)

#### Basic list group

기본적으로 BS2의 `.nav-list`와 같다. **리스트 그룹 항목엔 배지를 추가할 수 있으며, 자동으로 오른쪽에 위치한다.**

```html
<ul class="list-group">
    <li class="list-group-item">Cras justo odio</li>
    <li class="list-group-item">Dapibus ac facilisis in</li>
    <li class="list-group-item">Morbi leo risus</li>
</ul>
```

#### Linked list group

```html
<div class="list-group">
    <a href="#" class="list-group-item active">Cras justo odio</a>
    <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
    <a href="#" class="list-group-item">Morbi leo risus</a>
</div>
```

#### Custom content

```html
<div class="list-group">
    <a href="#" class="list-group-item active">
        <h4 class="list-group-item-heading">List group item heading</h4>
        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus.</p>
    </a>
    <a href="#" class="list-group-item">
        <h4 class="list-group-item-heading">List group item heading</h4>
        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus.</p>
    </a>
</div>
```

### Typographic components

헤딩 `font-weight`가 가벼워졌으며, **반응형 뷰에서 폰트 사이즈가 변경된다.** `.hero-unit`이 `.jumbotron`으로 바뀌었다.

### Progress bars

구조가 다음과 같으며:

```html
<div class="progress">
    <div class="progress-bar"></div>
</div>
```

`.progress-bar-info`과 같은 클래스가 `.progress-bar`에 바로 옆에 오며, 다음과 같이 클래스가 바뀌었다.

| BS2            | BS3            |
|----------------|----------------|
|.bar|.progress-bar|
|.progress-info|.progress-bar-info|
|.progress-success|.progress-bar-success|
|.progress-warning|.progress-bar-warning|
|.progress-danger|.progress-bar-danger|

### Panels(NEW)

헤더와 푸터를 가진 박스를 만들 수 있다.

#### Panel with heading

```html
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
    </div>
    Panel content
</div>
```

#### Panel with footer

```html
<div class="panel">
    Panel content
    <div class="panel-footer">Panel footer</div>
</div>
```

#### Contextual alternatives

문맥 상태(success, warning, danger, info)를 나타내는 `.panel-success` 등의 클래스를 사용하여 의미있는 패널을 만들 수 있다.

```html
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
    </div>
    Panel content
</div>
```

## Sources

* [Bootstrap Blog](http://blog.getbootstrap.com/)
* [List of changes and useful tips](https://github.com/twbs/bootstrap/pull/6342)

## 역자추가링크

* [Bootstrap 3.0: What’s new and how to migrate from 2.x to 3.x](http://designyoutrust.com/technology/bootstrap-3-0-tutorial/)

   [1]: http://julienrenaux.fr/2013/08/11/whats-new-in-twitter-bootstrap-3/
   [2]: https://github.com/twbs/bootstrap/issues/1552
  