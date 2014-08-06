---
layout: post
title: "HTML & CSS 초보자 가이드 - 3강 : Box Model & Positioning"
description: "HTML과 CSS를 완전히 이해하는데 필요한 하나의 원칙은 박스모델이다."
category: blog
tags: [Beginner, CSS, HTML, box, positioning]
---

<div id="toc"><p class="toc_title">목차</p></div>

원본 : [A Beginner’s Guide to HTML & CSS - LESSON 3 : Box Model & Positioning][1]

HTML과 CSS를 완전히 이해하는데 필요한 하나의 원칙은 박스모델이다.

**“페이지의 모든 엘리먼트는 사각형 박스이다.”**

박스 모델을 이해하는 것은 어렵고 까다로울 수 있으나 일반적인 웹사이트를 만들기 위해서는 필요하다. 더불어 레이아웃을 만들기 위해, 페이지에 엘리먼트를 배치하는 방법을 아는 것도 똑같이 중요하다.

## Box Sizing

이전의 강의를 통해 페이지에 모든 엘리먼트는, 블럭이나 인라인 레벨이건, 모두 사각형 박스라는 것을 알았을 것이다. 박스는 다른 크기를 가질 수 있으며, 마진, 패딩, 경계선 등이 크기를 변경할 수도 있다. 이것들을 통틀어 _the box model_ 이라 한다. 박스 모델의 한 예를 보자.

Fig. 3.01 ![][2]

## The Box Model

알다시피 모든 엘리먼트는 높이(height)와 너비(width)를 가지는 사각형 박스이며, 다른 마진(margin), 패딩(padding), 보더(boarder)로 구성되어 있다. 이 모든 값들이 합쳐져 [박스모델][3]을 만든다.

박스는 엘리먼트의 `height`와 `width`의 속성값을 주는 것으로 시작된다. `padding`과 `border`가 차례로 `height` 와 `width`를 둘러싼다. 그런 다음 `margin`이 `border`를 둘러싼다. 그러나, 마진은 박스의 실제 크기에는 포함되지 않으며, 박스모델을 정의하는 것에는 도움을 준다.

```css
    div {
      background: #fff;
      border: 6px solid #ccc;
      height: 100px;
      margin: 20px;
      padding: 20px;
      width: 400px;
    }
```

박스모델에서 엘리먼트의 전체 너비는 다음 공식을 사용한다:

`margin-right` + `border-right` + `padding-right` + `width` + `padding-left` + `border-left` + `margin-left`

엘리먼트의 전체 높이 공식은

`margin-top` + `border-top` + `padding-top` + `height` + `padding-bottom` + `border-bottom` + `margin-bottom`

Fig. 3.02 박스모델 

![][4]

공식을 사용하여 위 그림의 전체 높이와 너비를 계산하면

**Width**: `492px` = `20px` + `6px` + `20px` + `400px` + `20px` + `6px` + `20px`
**Height**: `192px` = `20px` + `6px` + `20px` + `100px` + `20px` + `6px` + `20px`

## Height & Width

모든 엘리먼트는 상속된 `height`와 `width`를 갖는다. 어떤 엘리먼트가 페이지의 레이아웃과 디자인에 핵심요소(key)가 된다면 특정한 `height`와 `width`가 필요할 것이고 이때 블럭 레벨 엘리먼트의 디폴트 값은 (새로 지정된 값으로) 덮어씌워질 것이다.(overrided)

역자참조링크 : [상속과 캐스케이딩][5]

### CSS Height Property

엘리먼트의 `height`의 디폴트 값은 컨텐츠에 의해 결정된다. 컨텐츠를 수용하기 위해 필요한 만큼 수직으로 늘어나거나 줄어들 것이다. 블럭 엘리먼트의 높이를 지정하기 위해는 `height` 속성이 사용된다.

```css
div {
  height: 100px;
}
```

### CSS Width Property

엘리먼트의 `width`의 디폴트값은 보여지는 방식에 달려있다. 블럭 레벨 엘리먼트는 width = 100% 가 디폴트이며, 가능한 모든 너비를 차지한다. inline 엘리먼트는 컨텐츠가 차지하는 만큼 수평적으로 늘어나고 줄어든다. 인라인 레벨 엘리먼트는 정해진 값을 가질 수 없으므로, `height` 속성처럼 `width` 속성은 블럭 레벨 엘리먼트와만 관계가 있다.

```css
div {
  width: 400px;
}
```

## Margin & Padding

`margin` 과 `padding`은 브라우저마다 엘리먼트마다 가독성을 이유로 다른 디폴트 값을 가진다. 이러한 디폴트값을 모두 0로 맞추기 위해 제1강에서 [CSS reset][6]을 사용하는 것을 논의했다.

### CSS Margin Property

`margin` 속성으로 엘리먼트를 둘러싼 여백의 크기를 정할 수 있다. 마진은 경계선(border)의 바깥에 위치하며 완전히 투명하다. 마진으로 페이지의 특정 위치에 엘리먼트가 배치되는 것을 돕거나 다른 엘리먼트가 충분한 거리를 두도록 여백만을 줄 수도 있다.

```css
div {
  margin: 20px;
}
```

### CSS Padding Property

`padding` 속성은 `margin` 속성과 매우 유사하나 엘리먼트의 경계선(`border`)안에 위치한다. 패딩은 엘리먼트의 백그라운드를 상속한다. `margin` 속성은 엘리먼트를 배치하기 위한 것이지만 패딩은 엘리먼트 안의 여백을 제공한다.

```css
div {
  padding: 20px;
}
```

Fig. 3.03 ![][7]

### Margin & Padding Declarations(선언)

`margin` 과 `padding` 값은 롱핸드와 숏핸드 형식으로 줄 수 있다.

엘리먼트의 네 변을 하나의 값으로 설정하거나 상하, 좌우, 상우하좌로 한번에 설정할 수 있다.(숏핸드)

```css
margin: 20px;             /* 상하좌우 모두 20px */
margin: 10px 20px;        /* 상하 10px, 좌우 20px */
margin: 10px 20px 0 15px; /* 상부터 시계 방향으로 상우하좌 순 */
```

한 개의 속성을 사용해서 한 번에 한 변의 값을 설정할 수 있다. 각 속성은 `margin` 혹은 `padding`으로 시작하며 -와 적용할 `top`, `right`, `bottom`, or `left` 으로 적용할 변을 뒤따라 지정한다. 예를 들어 `padding-left`는 엘리먼트의 왼쪽 패딩에 값을 적용한다.(롱핸드)

```css
div {
  margin-top: 10px;
  padding-left: 6px;
}
```

## Borders(경계선)

경계선은 `padding`과 `margin`사이에 위치하며, 엘리먼트 주위의 아웃라인을 제공한다. 모든 경계선은 너비, 스타일, 색상의 세가지 값이 필요하다. 숏핸드 값은 너비, 스타일, 색상 순으로 주어진다. 롱핸드의 경우 `border-width`, `border-style`, `border-color` 값으로 나뉘어진다.

대부분 단순한 사이즈, 실선, 한가지 색의 경계를 볼 수 있을 것이다. 그러나 [수많은][8] 사이즈와 모양과 색상이 가능하다.

```css
    div {
      border: 6px solid #ccc;
    }
```

> #### Length Value
>
> 마진, 패딩, 경계선과 쓸 수 있는 [길이 값][9]은 상대적인, 절대적인 값으로 여러 가지가 있다.
>
> **상대 값**은 값이 적용되는 엘리먼트와 상관관계가 있다. `em`과 퍼센티지 등이 있다.
>
> **절대 값**은 엘리먼트와 상관없이 측정 단위로 고정된다. 픽셀, 포인트, 인치, 센티미터 등이 있다.

## Floating Elements

박스모델로 엘리먼트의 모양새를 다듬는 것은 페이지 레이아웃을 코딩하는 전체에서 반을 차지한다. 나머지 반은 페이지의 다른 엘리먼트들을 적절하게 정렬하는 방법을 아는 것이다. 다른 엘리먼트 옆에 엘리먼트를 배치하는 방법 중 하나는 `float` 속성을 이용하는 것이다. `float` 속성은 엘리먼트들을 왼쪽과 오른쪽으로 연속으로 배치하게 한다.

**역자 링크** : 역자는 `float` 개념이 처음에 많이 헷갈렸다. 그래서 도움을 얻을만한 글들을 몇 개 링크한다.^^

* [float 속성의 이해와 웹 페이지 레이아웃 잡기](http://celestarry.egloos.com/3595449)
* [CSS 플로트 기초](http://tranbot.net/ALA/css-floats-101/)
* [CSS Float 속성의 모든것 (All About Floats)](http://techbug.tistory.com/181)
* [float을 clear하는 4가지 방법](http://naradesign.net/wp/2008/05/27/144/)
* [position, float, display 속성간의 관계](http://blog.wystan.net/2009/01/12/relationships-between-position-float-display)

블럭 엘리먼트인 `section`과 `aside`로 일반적인 페이지 레이아웃을 잡을 때 기본적으로는 수직적으로 쌓여버릴 것이다. 나란히 옆으로 배치하고 싶다면 각각 특정 `width`를 준 후에 하나는 왼쪽으로 다른 하나는 오른쪽으로 플로트하면 된다.

Fig. 3.04 ![][10]

[엘리먼트를 플로팅][11]할 때 주목해야 할 몇가지 것들이 있다. 첫번째는 플로팅 엘리먼트가 부모 컨테이너의 가장자리에 붙어버린다는 것이다. 만약 부모 엘리먼트가 없다면 페이지의 가장자리에 붙어버릴 것이다. 추가적으로 하나의 엘리먼트를 폴로트하면 다른 엘리먼트는 페이지 흐름 안에서 자연스럽게 이어붙을 것이다.

```css
section {
  float: left;
  margin: 10px;
  width: 600px;
}
aside {
  float: right;
  margin: 10px;
  width: 320px;
}
```

### Clearing Floated Elements

엘리먼트가 플로트될 때마다 페이지의 보통 흐름이 깨지고 다른 엘리먼트는 필요한대로 플로팅된 것 주위로 랩핑된다. 켄텐츠 옆에 이미지를 플로팅한 것과 같이 좋을 때도 있지만 때론 좋지 않다.

하나나 여러 개의 엘리먼트를 플로팅한 후 `clear` 속성을 이용하여 도큐먼트를 보통 흐름으로 되돌린다.

위의 예젱에서는 `section`과 `aside`를 플로트한 후 두 플로트된 엘리먼트 밑에 위치하는 `footer`에 클리어를 적용했다.

```css
footer {
  clear: both;
}
```

## Positioning Elements

플로팅하는 것 외에 엘리먼트를 정렬할 때 `position` 속성을 사용할 수도 있다. `position` 속성은 [다른 기능][12]을 하는 여러 값을 가진다.

디폴트 `position` 값은 `static`이다. `realtive` 값은 `top`, `right`, `bottom`, `left`과 같은 오프셋 값을 사용할 수 있다. `absolute`와 `fixed`는 `relative` 값을 가진 부모 엘리먼트와 함께 사용된다.

Fig. 3.05

![][13]

위의 예에서, `header` 엘리먼트는 고정된 엘리먼트로 동작하기 위해 `relative`로 배치되고, 그 안에 `absolute`로 배치되는 엘리먼트의 주된 컨테이너 역할을 한다. `ul` 엘리먼트는 `header` 엘리먼트의 위쪽과 오른쪽에서 `10px` 떨어진 절대 위치에 배치된다.

코드는 다음과 같을 것이다.

###### HTML

```html
<header>
  <ul>...</ul>
</header>
```

###### CSS

```css
header {
  position: relative;
}
ul {
  position: absolute;
  right: 10px;
  top: 10px;
}
```

### Box Offset Properties

엘리먼트의 `position`이 `static`으로 설정되지 않는 한, 박스 오프셋 속성이 사용될 수 있다. 오프셋 값은 `top`, `right`, `bottom`, `left` 등이 있다.

예를 들면, `bottom: 32px;`은 `realtive` 배치 속성값을 가진 부모 엘리먼트의 바닥에서 32 픽셀에 위치될 것이다. 반대로 `bottom: -32px;`은 `realtive` 배치 속성값을 가진 부모 엘리먼트의 아래 32 픽셀에 위치될 것이다

> #### Grids & Frameworks
>
>
사이트의 레이아웃을 만들 때 고려하는 툴과 실제예는 셀 수없이 많다. 그 중 그리드와 프레임워크가 가장 선두에 있다.
>
> **Grid**는 - vertical과 baseline 모두 - 웹사이트에 일련의 흐름을 더해주고 모든 것을 정렬하는 훌륭한 방법을 제공한다. 수년동안 인기있는 수십 개의 서로 다른 [추천 그리드][14]가 있으며, 자신의 프로젝트에 가장 알맞는 것을 선택할 수 있다.
>
> **Framework**는 미리 선정된 표준 세트를 바탕으로 웹사이트를 빠르게 만들 수 있는 방법을 제공한다. 프로젝트에 따라 프레임워크는 훌륭한 시작점을 제공하거나 완벽한 솔루션을 제공하기도 한다.

## Resources & Links

* [CSS Length Values](https://developer.mozilla.org/en/CSS/length) via Mozilla Developer Network
* [HTML Borders](http://www.quackit.com/html/codes/html_borders.cfm) via Quackit.com
* [The CSS Box Model](http://css-tricks.com/the-css-box-model/) via CSS-Tricks
* [CSS Float Theory](http://coding.smashingmagazine.com/2007/05/01/css-float-theory-things-you-should-know/) via Smashing Magazine
* [CSS Positioning 101](http://www.alistapart.com/articles/css-positioning-101/) via A List Apart
* [Resources for Grid-Based Design](http://vandelaydesign.com/blog/design/resources-grid-based-design/) via Vandelay Design

   [1]: http://learn.shayhowe.com/html-css/box-model
   [2]: http://learn.shayhowe.com/assets/courses/html-css-guide/box-model/square-elements.jpg
   [3]: http://css-tricks.com/the-css-box-model/
   [4]: http://learn.shayhowe.com/assets/courses/html-css-guide/box-model/box-model.png
   [5]: http://www.clearboth.org/28_inheritance_and_cascade/
   [6]: http://learn.shayhowe.com/html-css/terminology-syntax-intro#reset
   [7]: http://learn.shayhowe.com/assets/courses/html-css-guide/box-model/margin-padding.png
   [8]: http://www.quackit.com/html/codes/html_borders.cfm
   [9]: https://developer.mozilla.org/en/CSS/length
   [10]: http://learn.shayhowe.com/assets/courses/html-css-guide/box-model/floats.png
   [11]: http://coding.smashingmagazine.com/2007/05/01/css-float-theory-things-you-should-know/
   [12]: http://www.alistapart.com/articles/css-positioning-101/
   [13]: http://learn.shayhowe.com/assets/courses/html-css-guide/box-model/position.png
   [14]: http://vandelaydesign.com/blog/design/resources-grid-based-design/
  