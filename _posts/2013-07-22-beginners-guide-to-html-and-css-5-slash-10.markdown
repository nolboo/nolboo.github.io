---
layout: post
title: "HTML & CSS 초보자 가이드 - 5강 : 백그라운드와 그라디언트"
description: "백그라운드(배경)은 작게 쓰이거나 크게 쓰이거나 웹사이트 전체 디자인에 중요한 시각적 효과를 준다. CSS3에서는 그라디언트 백그라운드, 하나의 엘리먼트에 여러 백그라운드 이미지 적용 등의 새로운 백그라운드 특성이 도입되었다."
category: blog
tags: [Beginner, CSS, HTML, background, gradient]
---

<div id="toc"><p class="toc_title">목차</p></div>

원본 : [A Beginner’s Guide to HTML & CSS - LESSON 5 : Backgrounds & Gradients][1]

백그라운드(배경)은 작게 쓰이거나 크게 쓰이거나 웹사이트 전체 디자인에 중요한 시각적 효과를 준다.

CSS3에서는 그라디언트 백그라운드, 하나의 엘리먼트에 여러 백그라운드 이미지 적용 등의 새로운 [백그라운드 특성][1]이 도입되었다.

## Adding a Background Color

엘리먼트에 백그라운드 적용하는 가장 빠른 방법은 `background`나 `background-color` 속성으로 한 가지 색의 백그라운드를 적용하는 것이다. `background` 속성은 색상과 이미지를, `background-color`는 백그라운드 색상만을 위해 사용된다.

```css
div {
  background: #f60;
  background-color: #f60;
}
```

백그라운드 속성을 선언할 때 16진값, RGB, RGBa, HSL, HSLa의 키워드를 사용한다. 보통 16진수를 사용하며, 알파 채널을 통한 불투명도를 주는 경우는 RGBa와 HSLa를 사용한다. 만약 30% 불투명한 검정을 기대한다면 `rgba(0, 0, 0, 0.3)`를 사용하면 된다. RGBa와 HSLa는 모든 브라우저에서 지원되는 것은 아니기 때문에 다음과 같이 불투명값을 사용하는 선언 바로 위에 대체 CSS를 선언해야 한다.

```css
div {
    background: #b2b2b2;
    background: rgba(0,0,0,0.3);
}
```

## Adding a Background Image

백그라운드 색상처럼 `background` 속성이나 `background-image` 속성을 사용하여 백그라운드 이미지를 추가할 수 있다. 어떤 속성을 사용하던지 간에 백그라운 이미지의 경로 즉, 이미지 소스를 정의하는 `url` 값을 사용해야 한다.

```css
div {
  background: url('alert.png');
  background-image: url('alert.png');
}
```

`url` 값만 사용하면 컨테이너 엘리먼트의 좌상에서부터 수평과 수직 방향으로 반복될 것이다. 다행히 `background-repeat` 와 `background-position` 속성을 사용해서 이를 해결할 수 있다.

### Background Repeat

기본적으로 백그라운 이미지는 수평과 수직 방향으로 무한 반복된다. `background` 속성의 `url` 값 뒤에 반복 값을 추가하거나 `background-repeat` 속성으로 반복 값을 지정할 수 있다.

```css
div {
  background: url('alert.png') no-repeat;
  background-image: url('alert.png');
  background-repeat: no-repeat;
}
```

백그라운드 반복(repeat)은 `repeat`, `repeat-x`, `repeat-y`, `no-repeat`의 네 가지 값을 갖는다. `repeat` 값이 디폴트이며, 수직과 수평 방향으로 이미지를 반복한다. `repeat-x`는 수평방향으로 이미지를 반복하며, `repeat-y`는 수직방향으로 반복한다. `no-repeat`는 백그라운드 이미지를 한번만 표시하며, 반복하지 않는다.

### Background Position

`background-position` 속성을 사용하면 백그라운드 이미지가 어디에 위치할지와 어디서부터 반복할지를 조정할 수 있다. 다른 백그라운드 속성과 마찬가지로 `background` 속성의 `url` 값 뒤에서 지정하거나 `background-position` 속성으로 별도로 지정할 수 있다.

```css
div {
  background: url('alert.png') 10px 10px no-repeat;
  background-image: url('alert.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
}
```

백그라운드 포지션은 수평 오프셋(첫번째)과 수직 오프셋(마지막)의 두 가지 값이 필요하다. `top`, `right`, `bottom`, `left` 키워드 값을 사용할 수 있다. 이 키워드 값은 퍼센트와 매유 유사하게 작동한다. `top left` 키워드는 `0 0` 퍼센트와 동일하고, `right bottom`은 `100% 100%` 퍼센트와 동일하다.

`50%` 값을 이용하면 백그라운드 이미지를 중앙에 정렬할 수 있다.엘리먼트의 상단에 백그라운드 이미지를 중양 정렬하려면 `50% 0` 값을 사용하면 된다. 정확한 조정을 위해 픽셀을 사용하는 것도 인기있는 방법이다.

![Background Percentages][2]

**Fig. 5.01** 백그라운드 이미지의 위치를 조정하기 위해 퍼센트와 키워드를 사용

### Alert Message Background Example

###### HTML

```html
<p><strong>Warning!</strong> You are walking on thin ice.</p>
```

###### CSS

```css
p {
  background: #fff6cc url('warning.png') 15px 50% no-repeat;
  border-radius: 6px;
  border: 1px solid #ffd100;
  color: #000;
  padding: 10px 10px 10px 38px;
}
```

#### Demo : [jsfiddle 링크](http://jsfiddle.net/nolboo/gWUuR/)

## Gradient Backgrounds with CSS3

그라디언트 백그라운드는 CSS3와 함께 도입되었으며, 모든 브라우저에서 지원되지는 않지만 최신 브라우저에서는 전부 지원된다.

그라디언트 백그라운드는 백그라운드 이미지처럼 다뤄지며, `background`나 `background-image` 속성을 이용하여 linear, radial 두 가지 형태로 만들 수 있다.

> #### Browser Specific Property Values
>
>
브라우저들이 CSS3를 다른 특성들을 서서히 지원하였기 때문에 각 브라우저 제작사는 약간씩 다른 방법으로 새로운 속성을 적용하였다. 새로운 속성이 정확하게 작동하게 하기 위해 vendor prefix를 사용했다. 대부분의 브라우저가 그라디언트 백그라운드를 표준으로 정했지만 아직은 대체 지원을 할 필요가 있다.
>
> vendor prefixe가 점점 상관없어지고 있지만 오래된 브라우저 때문에 그것들을 사용하는 것이 더 안전한다.
>
>   * Mozilla Firefox: `-moz-`
>   * Microsoft Internet Explorer: `-ms-`
>   * Opera: `-o-`
>   * Webkit (Chrome &amp; Safari): `-webkit-`

### Linear Gradient Background

수년간 디자이너와 개발자들은 이미지 화일을 잘라내 선형(linear) 그라디언트 백그라운드로 사용해왔다. 잘 작동하기는 했지만 적용하는 시간이 걸렸고, 변경하기가 어려웠다. 다행히 그런 시절은 가버렸고 이젠 CSS안에서 [linear gradient][3]를 지정할 수 있다. 색상을 변경하려고 이미지를 다시 자르고 서버에 업로드할 필요가 없으며, CSS 안에서 빠르게 변경할 수 있다.

```css
div {
  background: #70bf32;
  background: url('linear-gradient.png') 0 0 repeat-x;
  background: -webkit-linear-gradient(#a1e048, #6a942f);
  background:    -moz-linear-gradient(#a1e048, #6a942f);
  background:     -ms-linear-gradient(#a1e048, #6a942f);
  background:      -o-linear-gradient(#a1e048, #6a942f);
  background:         linear-gradient(#a1e048, #6a942f);
}
```

기본적으로 리니어 백그라운드는 엘리먼트의 위에서부터 아래로 전이된다. 그 방향은 색상 값 앞에 키워드나 각도(degree) 값을 사용하여 변경할 수 있다. 예를 들어 왼쪽에서 오른쪽으로 전이시키려면 `to right` 키워드 값을 사용하며, 좌상에서 우하로 전이시키려면 `to bottom right` 키워드 값을 사용한다.

```css
div {
  background: linear-gradient(to bottom right, #a1e048, #6a942f);
}
```

대각선 그라디언트를 사용할 때 엘리먼트가 정확하게 사각형이 아니라면 그라디언트는 한 구석에서 다른 쪽으로 직접 진행되지 않을 것이다. 대신에 그라디언트는 엘리먼트의 정중앙을 확인할 것이고 진행되야 할 곳으로부터 수식 코너에 닻을 내릴 것이다. 그리고 그 값 안에서 윤곽된 구성으로 움직일 것이다. 그라이디언트가 향하는 구석을 “magic corners”라 부르지만 절대적인 것은 아니다. 에릭 마이어가 [outlining this syntax][4]란 훌륭한 작업을 했다.

키워드에 더해 degree 값을 사용할 수도 있으며, `left top`에서 부터 그라디언트가 시작하길 원하면 `315deg` 값을 사용할 수 있다.

> #### Old Linear Gradient Keyword Syntax
>
> 예전엔 리니어 그라디언트의 키워드 문법은 `to` 키워드를 사용하지 않았다. 키워드(들)를 선언하는 대신 그라디언트의 시작점을 선언하였고 그 반대방향으로 진행되었다. 위의 대각선 리니어 그라디언트 예제에서 예전 문법은 `to bottom right`가 아닌 `top left`가 될 것이다.
>
> 새로운 키워드 문법으로 다른 브라우저들 사이에서 지원될 수 있게 되었다. 새로운 문법이 작동되지 않으면 예전 문법이 작동되는지 확인해볼 필요가 있다. 그러나, 곧 업데이트되야 할 것이라는 것을 염두에 두어라.

### Radial Gradient Background

리니어 그라디언트는 한 방향으로 퍼지는 그라디언트를 만들기엔 완벽하지만 종종 radial 그라디언트에 대한 요구도 있다. 리니어 백그라운드와 유사하지만 위치, 크기, 반경 값 등으로 좀 더 복잡할 수 있다. 여기선 기본적인 것만 다루고 [여기서][5] 좀 더 깊게 살펴 볼 수 있다.

```css
    div {
      background: #70bf32;
      background: url('radial-gradient.png') 50% 50% no-repeat;
      background: radial-gradient(circle, #a1e048, #6a942f);
    }
````

> #### CSS3 Gradient Background Generator
>
> CSS3 그라디언트를 직접 프로그래밍하는 것은 숙달하지 않으면 꽤 힘든 작업이다. 다행히 [CSS3 그라디언트 제너레이터][6]와 같은 것들이 나타났다. 제너레이터들마다 약간 다르게 동작하지만 어떤 것은 프리셋과 예제가 있고, 어떤 것은 확장할 수 있는 옵션 목록을 가지고 있다. 관심이 있다면 필요에 맞는 적절한 제너레이터를 조사해볼 것을 추천한다.

### Gradient Background Stops

지금까지 하나의 색상에서 다른 색으로 전이되는 그라디언트에 관해 논의했으나, 두 가지 이상의 색상에서 전이되길 원하면 “color stop”을 사용할 수 있다. 두 개의 색상값을 선언하는 대신에 여러 개의 값을 선언할 수 있으며, 차례대로 하나에서 다음 색으로 전이할 것이다. 컬러 스톱에 길이 값을 추가하면 전이의 위치와 길이가 결정된다. 길이값이 선언되지 않으면 그라디언트는 선언된 모든 색상 사이에 평등하게 전이될 것이다.

```css
    div {
      background: #6c9730;
      background: url('linear-gradient-stops.png') 0 0 repeat-y;
      background: linear-gradient(left, #8dc63f, #d8ad45, #3b4b94);
    }
```

### Navigation Background Example

###### HTML

```html
<ul>
  <li class="play"><a href="#">Play</a></li>
  <li class="back"><a href="#">Skip Backward</a></li>
  <li class="stop"><a href="#">Pause/Stop</a></li>
  <li class="forward"><a href="#">Skip Forward</a></li>
</ul>
```

###### CSS

```css
ul {
  background: #f4f4f4;
  background: linear-gradient(#fff, #eee);
  border: 1px solid #ccc;
  border-radius: 6px;
  display: inline-block;
  height: 22px;
  list-style: none;
  margin: 0 0 20px 0;
  padding: 0 4px 0 0;
}
li {
  height: 16px;
  float: left;
  padding: 3px;
  text-indent: -9999px;
  width: 16px;
}
.play {
  background: #f4f4f4;
  background: linear-gradient(#fff, #eee);
  border: 1px solid #ccc;
  border-radius: 30px;
  left: -4px;
  padding: 7px;
  position: relative;
  top: -5px;
}
li a {
  background: url('controls.png') 0 0 no-repeat;
  display: block;
  height: 16px;
  width: 16px;
}
.play a:hover {
  background-position: 0 -16px;
}
.back a {
  background-position: -16px 0;
}
.back a:hover {
  background-position: -16px -16px;
}
.stop a {
  background-position: -32px 0;
}
.stop a:hover {
  background-position: -32px -16px;
}
.forward a {
  background-position: -48px 0;
}
.forward a:hover {
  background-position: -48px -16px;
}
```

#### Demo : [jsfiddle 링크](http://jsfiddle.net/nolboo/yTM63/)

## Multiple Background Images with CSS3

예전엔 하나의 엘리먼트에 한 개 이상의 백그라운드를 원한다면 또다른 엘리먼트로 감싸고 그 엘리먼트에 백그라운드를 할당해야 했다. 이것 때문에 백그라운드를 추가하는 단순한 사용으로도 코드가 비대해지곤 했다. CSS3에선 백그라운드 값들을 연달아(chain) 선언하여 하나의 엘리먼트에 여러 개의 백그라운드 이미지를 사용할 수 있다.

```css
div {
  background:
    url('foreground.png') no-repeat 0 0,
    url('middle-ground.png') no-repeat 0 0,
    url('background.png') no-repeat 0 0;
}
```

`background` 속성 값을 연달어 선언할 수 있을 뿐아니라, `background-repeat`, `background-position`와 같은 다른 백그라운드 관련 속성들도 연달아 선언할 수 있다.

### Multiple Background Images Example

###### HTML

```html
<div>Dinosaur with Grass and Clouds</div>
```

###### CSS

```css
div {
  background:
    url('dyno.png') no-repeat 380px 18px,
    url('grass.png') no-repeat 0 100%,
    url('sky.jpg') no-repeat 0 0;
  border-radius: 6px;
  height: 200px;
}
```

#### Demo : [Dinosaur with Grass and Clouds][7]

## New CSS3 Background Properties

그라디언트 백그라운드와 여러 개의 백그라운드 이미지와 함께 `background-size`, `background-clip`, `background-origin`의 세 가지 새로운 CSS 속성이 추가되었다.

### CSS3 Background Size

`background-size` 속성은 백그라운드 이미지에 특정한 크기를 줄 수 있다. 선언되는 첫번째 값은 이미지의 너비이며, 두번째 값은 높이이며, 어떠한 길이 값이나 키워드도 사용할 수 있다. 만약 하나의 값만 선언된다면 적절한 이미지 비율을 유지해주는 `auto` 키워드가 사용된다.

```css
    div {
      background: url('shay.jpg') 0 0 no-repeat;
      background-size: 85% auto;
      border: 1px dashed #8c9198;
      height: 240px;
      width: 200px;
    }
```

> #### Cover &amp; Contain Values
>
> `cover` 키워드 값은 (백그라운드가) 엘리먼트 전체를 완전히 덮는 비율적 크기로 재조정되어야 한다. 백그라운드를 얼마나 재조정하느냐는 백그라운드와 엘리먼트의 차원(dimension)에 달려있다. 백그라운드는 비율적으로 차원을 가지지만 이미지 퀄리티(질)는 다소간 왜곡되게 재조정될 수 있다. 항상 작업을 체크하라.
>
> `contain` 키워드 값은 엘리먼트의 경계 범위 안에 백그라운드 이미지를 비율적 크기로 재조정할 것이다. 이것은 엘리먼트의 일부분이 백그라운드가 없는 것을 의미하지만, 전체 백그라운드 이미지는 보여진다. `cover` 키워드 값처럼 백그라운드 이미지의 크기 재조정은 이미지의 차원에 비율적일 것이나 이미지는 왜곡될 수 있다.

역자참조링크 :

* [background-size 속성 알아보기](http://dolly77.tistory.com/entry/CSS3-backgroundsize-%EC%86%8D%EC%84%B1%EC%95%8C%EC%95%84%EB%B3%B4%EA%B8%B0)
* [background-size 속성 사용법](http://blog.naver.com/PostView.nhn?blogId=poppymanye&logNo=60161713731)

### CSS3 Background Clip & Background Origin

`background-clip` 속성은 백그라운 이미지가 적용되는 영역을 지정하며, `background-origin` 속성은 `background-position`이 어디서부터 시작되는지 지정한다. 이 두 속성이 도입되면서 `border-box`, `padding-box`, `content-box`의 세 값이 포함되었으며, 각각 `background-clip`과 `background-origin` 속성값으로 사용될 수 있다.

```css
div {
  background: url('shay.jpg') 0 0 no-repeat;
  background-clip: padding-box;
  background-origin: border-box;
}
```

**Fig. 5.03** The `border-box` 값은 엘리먼트의 경계선안까지 확장된다. 

![Border Box Value][8]

**Fig. 5.04** `padding-box` 값은 엘리먼트의 패딩 안까지 확장되지만, 경계선 안까지만 포함된다. 

![Padding Box Value][9]

**Fig. 5.05** `content-box` 값은 엘리먼트의 경계선과 패딩 안까지 포함된다. 

![Content Box Value][10]

## Resources & Links

* [CSS3 Background](http://www.slideshare.net/maxdesign/css3-backgrounds) via Russ Weakley
* [CSS3 Linear Gradients](http://dev.opera.com/articles/view/css3-linear-gradients/) via Dev.Opera
* [CSS3 Radial Gradients](http://dev.opera.com/articles/view/css3-radial-gradients/) via Dev.Opera
* [CSS Gradient Background Maker](http://ie.microsoft.com/testdrive/graphics/cssgradientbackgroundmaker/default.html)

   [1]: http://learn.shayhowe.com/html-css/backgrounds-gradients
   [2]: http://learn.shayhowe.com/assets/courses/html-css-guide/backgrounds-gradients/background-percentages.png
   [3]: http://dev.opera.com/articles/view/css3-linear-gradients/
   [4]: http://meyerweb.com/eric/thoughts/2012/04/26/lineargradient-keywords/
   [5]: http://dev.opera.com/articles/view/css3-radial-gradients/
   [6]: http://ie.microsoft.com/testdrive/graphics/cssgradientbackgroundmaker/default.html
   [7]: http://jsfiddle.net/nolboo/vtgqy/
   [8]: http://learn.shayhowe.com/assets/courses/html-css-guide/backgrounds-gradients/border-box.png
   [9]: http://learn.shayhowe.com/assets/courses/html-css-guide/backgrounds-gradients/padding-box.png
   [10]: http://learn.shayhowe.com/assets/courses/html-css-guide/backgrounds-gradients/content-box.png
  