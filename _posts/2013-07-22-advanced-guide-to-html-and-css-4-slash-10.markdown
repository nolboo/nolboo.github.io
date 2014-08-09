---
layout: post
title: "HTML & CSS 중급자 가이드 - 4강 : 반응형 웹 디자인"
description: "모바일 인터넷 사용이 데스크탑 인터넷 사용을 올해 추월하는 트랜드가 이어지고 있다. 모바일 인터넷 사용이 계속 성장하면서 어떻게 모든 유저에게 적합한 웹사이트를 만들 것인가 하는 질문이 제기되고있다."
category: blog
tags: [Advanced, CSS, HTML, reponsive, web, design]
---

<div id="toc"><p class="toc_title">목차</p></div>

원본 : [An Advanced Guide to HTML & CSS - LESSON 4 : Responsive Web Design][1]

인터넷은 누구도 예측할 수 없을 정도로 빠르게, 미친듯이 성장했다. 최근 수 년간 모바일 성장이 현장에서 폭발하고 있다. 모바일 인터넷 사용의 성장도 일반 인터넷 사용의 성장을 훨씬 뛰어넘고 있다.

요즘 인터넷에 연결되는 모바일 기기를 하나 이상 갖고 있지 않은 사람을 찾는 것은 힘들다. 영국에선 인구보다 [모바일 폰][2]이 더 많고, 모바일 인터넷 사용이 데스크탑 인터넷 사용을 올해 추월하는 [트랜드가 이어지고 있다][3].

모바일 인터넷 사용이 계속 성장하면서 어떻게 모든 유저에게 적합한 웹사이트를 만들 것인가 하는 질문이 제기되고있다. 업계는 이 질문에 반응형 웹 디자인(responsive web design : RWD)으로 응답하고 있다.

## Responsive Overview

반응형 웹 디자인은 모바일 혹은 데스트탑의 모든 기기와 크고 작은 모든 스크린 사이즈에서 적절하게 작동하는 웹사이트를 만드는 것이다.

반응형 웹 디자인은 모든 사람에게 직관적이고 만족스런 경험을 제공하는 것에 초점을 두며, 데스크탑 유저와 폰 유저 모두에게 같은 이익을 제공한다.

반응형 웹 디자인[responsive web design][4] 용어는 Ethan Marcotte가 만들어냈고 주로 키웠다. 이 강의에서 다루는 많은 것은 Ethan 온라인과 그의 책 [Responsive Web Design][5]에서 먼저 이야기된 것이다.

![Food Sense Responsive Layout][6]

**Fig. 4.01**

[Food Sense][7]는 아름다운 웹사이트이며, 모든 다른 뷰포트 사이즈에 반응한다. 크건 작건 뷰포트에 웹사이트가 조절되어 자연스런 사용자 경험을 만든다.

역자 참조 링크

  * [Viewport][8] : 화면의 창 또는 보이는 영역

### Responsive vs. Adaptive vs. Mobile

_Responsive_(반응형) 와 _adaptive_(적응형) 웹 디자인은 밀접하게 연관되며, 종종 같은 의미로 사용된다. 반응형은 일반적으로 어떤 변화에도 빠르고 적극적으로 반응하는 것을 의미하는 반면 적응형은 (_변화_와 같은) 새로운 목적이나 상황에 쉽게 변경되는 것을 의미한다. 반응형 디자인에서는 웹사이트가 뷰포트 너비와 같은 요인에 지속적으고 유동적으로 변하지만, 적응형 웹사이트는 미리 정해진 요인들에 맞추어 만들어진다. 두 가지의 결합이 이상적이며, 기능적 웹사이트를 위한 완벽한 공식을 제공한다. 어떤 용어가 사용되는가가 특별히 커다란 차이를 만들지는 않는다.

_Mobile_은 일반적으로 모바일 유저만을 위한 새 도메인에 별도의 웹사이트를 만드는 것을 의미한다. 모바일 웹사이트는 극도로 가벼울 수 있지만 새 코드 베이스와 브라우저 스니핑에 의존한다. 이는 개발자와 유저 모두에게 장애물이 될 수 있다.

역자 주 - [Browser sniffing][9] : 유저의 브라우저가 어떤 것인지 판별하는 것

현재 가장 인기있는 기술은 다른 브라우저와 기기 뷰포트에 따라 레이아웃과 컨텐츠가 변하면서 생동적으로 적응하는 디자인을 선호하는 반응형 웹 디자인에 있다. 이러 해법은 반응형, 적응형과 모바일 모두의 이점을 가지고 있다.

## Flexible Layouts

반응형 웹 디자인은 가변(flexible) 레이아웃, 미디어 쿼리, 가변(flexible) 미디어의 세 가지 주요 부분으로 나뉜다. 첫번째 부분인 가변 레이아웃은 어떠한 너비에도 생동적으로 재조정할 수 있는 가변 그리드로 웹 사이트의 레이아웃을 만드는 것이다. 가변 그리드는 대부분 퍼센트나 `em` 등의 상대적인 길이 단위를 사용한다. 이 상대적인 길이들은 `width`, `margin`, `padding`과 같은 일반적인 그리드 속성값으로 사용된다.

#### Relative Viewport Lengths

CSS3에서는 몇 개의 새로운 상대 길이 단위가 [도입되었다][10]. 이는 브라우저나 디바이스의 뷰포트 크기와 특히 관련된 것이며, `vw`, `vh`, `vmin`, `vmax` 등을 포함한다. 이러한 새로운 단위들에 대한 전체적인 지원은 훌륭하진 않으나 확대되고 있고, 조만간 반응형 웹사이트를 만드는 데에 커다란 역할을 하는 것이다.

  * `vw` : Viewports width
  * `vh` : Viewports height
  * `vmin` : Minimum of the viewport’s height and width
  * `vmax` : Maximum of the viewport’s height and width

가변 레이아웃은 픽셀이나 인치와 같은 고정 측정 단위를 지원하지 않는다. 기기마다 뷰포트 높이와 너비가 지속적으로 변하기 때문이다. 웹사이트 레이아웃은 이런 변화에 적응할 필요가 있으며 고정 값은 너무 많은 제약이 있다. 다행히 Ethan이 상대값을 사용한 가변 레이아웃의 비율을 선언하는 것을 도와주는 쉬운 공식을 밝혀냈다.

그 공식은 엘리먼트의 목표(target) 너비를 부모 엘리먼트의 너비로 나누어 목표 엘리먼트의 상대적인 너비를 구하는 것이다.


    반응형 디자인 공식 : target ÷ context = result


### Flexible Grid

이 공식이 두 열(column) 레이아웃 안에서 어떻게 동작하는지 보자. 아래에서 `container` 클래스의 부모 `div`가 `section`과 `aside` 엘리먼트를 감싸고 있다. `section`을 왼쪽으로 `aside`를 오른쪽으로 위치하면서 둘 사이에 같은 마진을 갖게하는 것이 목표다. 보통 이러한 레이아웃의 마크업과 스타일은 다음과 유사할 것이다.

###### HTML

```html
<div class="container">
  <section>...</section>
  <aside>...</aside>
</div>
```

###### CSS

```css
    .container {
      width: 660px;
    }
    section {
      float: left;
      margin: 10px;
      width: 420px;
    }
    aside {
      float: right;
      margin: 10px;
      width: 200px;
    }
```

#### [Fixed Grid Demo][11]

가변 그리드 공식을 사용하여 길이의 고정 단위를 상대 단위로 변경할 수 있다. 이 예제에선 퍼센트를 사용하겠지만 `em` 단위도 동일하게 작동할 것이다. 부모 `container`의 너비에 상관없이 `section`과 `aside`의 마진과 너비는 비율적으로 크기가 변동될 것이다.

```css
    .container {
      max-width: 660px;
    }
    section {
      float: left;
      margin: 1.51515151%;   /*  10px ÷ 660px = .01515151 */
      width: 63.63636363%;   /* 420px ÷ 660px = .63636363 */
    }
    aside {
      float: right;
      margin: 1.51515151%;   /*  10px ÷ 660px = .01515151 */
      width: 30.30303030%;   /* 200px ÷ 660px = .30303030 */
    }
```

#### [Flexible Grid Demo][12]

가변 레이아웃 개념과 공식을 갖고 그리드의 모든 부분에 재적용하면 완벽하게 동적인 웹사이트를 만들 수 있다. 위의 부모 `container`에서 했듯이 `min-width`, `max-width`, `min-height`, `max-height` 속성을 수단으로 가변 레이아웃에서 훨씬 더 많은 컨트롤을 할 수 있다.

가변 레이아웃 접근법만으론 충분치 않다. 브라우저 뷰포트의 너비가 너무 작을 때는 레이아웃의 크기를 비율적으로 조절하더라도 열의 크기가 너무 작아 컨텐츠를 효과적으로 표시할 수 없다. 레이아웃이 너무 작거나 크면 텍스트는 읽기 어렵게 되고, 레이아웃이 깨지기 시작할 것이다. 이런 경우엔 미디어 쿼리가 더 나은 경험을 만드는데 도움이 될 수 있다.

## Media Queries

미디어 쿼리는 개별 브라우저와 디바이스 환경(예를 들면 뷰포트 너비 혹은 기기 오리엔테이션 등)에 각기 다른 스타일을 제공할 수 있는 확장 기능이다. [타겟 스타일][13]을 독자적으로 제공할 수 있다는 것은 반응형 웹 디자인에 기회과 수단의 세계를 활짝 열어준다.

### Initializing Media Queries

미디어 쿼리를 사용하는 방법은 두 가지가 있다. 기존의 스타일 시트에 `@media` 룰을 사용하고 `@import` 룰을 사용하여 새로운 스타일 시트를 들여오거나(import), HTML 문서 안에서 별도의 스타일을 링크하는 것이다. 일반적으로 추가적인 HTTP 요청을 피하기 위해 기존 스타일 시트안에 `@media` 룰을 사용하는 것이 추천된다.

###### HTML

```html
<!-- Separate CSS File -->
<link href="styles.css" rel="stylesheet" 
media="all and (max-width: 1024px)">
```

###### CSS

```css
/* @media Rule */
@media all and (max-width: 1024px) {...}

/* @import Rule */
@import url(styles.css) all and (max-width: 1024px) {...}
```

각 미디어 쿼리는 하나 또는 그 이상의 표현이 뒤따르는 미디어 타입을 포함할 수 있다. 일반적인 미디어 타입은 `all`, `screen`, `print`, `tv`, `braille`을 포함한다. HTML5 사양(specifition)은 `3d-glasses`도 포함하는 새로운 미디어 타입을 포함한다. 미디어 타입을 명시하지 않으면 미디어 쿼리는 미디어 타입을 `screen`으로 기본으로할 것이다.

미디어 쿼리 표현식은 다른 미디어 특성과 값을 포함할 수 있으며 그리고나서 참(true) 혹은 거짓(false)를 할당한다. 미디어 특성과 값이 참으로 할당될 때 해당 스타일이 적용되며, 거짓이면 해당 스타일은 무시된다.

### Logical Operators in Media Queries

미디어 쿼리에서 논리적 연산자(logical operator)는 강력한 표현식을 만들 수 있게 해준다. `and`, `not`, `only`의 세 개의 연산자를 사용할 수 있다.

`and` 논리 연산자를 사용하여 브라우저나 기기가 a,b,c 등으로 지정하여 추가적인 조건을 추가할 수 있다. 여러 개의 개별 미디어 쿼리는 콤마로 분리될 수 있으며 암묵적인 `or` 연산자처럼 동작한다. 아래 예는 `800`과 `1024` 픽셀 너비의 모든 미디어 타입을 선택한다.

```css
@media all and (min-width: 800px) and (max-width: 1024px) {...}
```

`not` 논리 연산자는 명시된 것을 제외한 모든 쿼리를 특정하여 선언된 쿼리를 부정한다. 아래 예에서는 표현식은 컬러 스크린을 갖지 않는 모든 디바이스에 적용된다. 즉, 흑백이나 모노 스크린에 적용된다.

```css
@media not screen and (color) {...}
```

`only` 논리 연산자는 새로운 연산자이며 HTML4 알고리즘을 사용하는 유저 에이전트로는 인식되지 않으므로, 미디어 쿼리를 지원하는 않는 기기나 브라우저에선 스타일이 나타나지 않는다. 아래에서 표현식은 세로 편향(portrait orientation)인 스크린만을 선택한다.

```css
@media only screen and (orientation: portrait) {...}
```

> #### Omitting a Media Type
>
> `not`과 `only` 논리 연산자를 사용할 땐 미디어 타입을 쓰지 않을 수 있다. 이 경우 미디어 타입은 `all`로 전제된다.

### Media Features in Media Queries

미디어 쿼리 문법과 논리 연산자의 작동법을 아는 것은 미디어 쿼리에 대한 훌륭한 입문이나, 실제 작업은 미디어 특성과 함께 한다. 미디어 쿼리 표현식 내에서 어떤 속성이 목표될지를 미디어 특성이 지정한다.

#### Height & Width Media Features

가장 많이 사용되는 미디어 특성 중 하나는 하나의 디바이스나 브라우저 뷰포트에 하나의 높이나 너비를 결정하는 것에 관련된다. `height`, `width`, `device-height`, `device-width`의 미디어 특성을 사용해서 높이와 너비는 찾을 수 있다. 각 미디어 특성은 `min` 혹은 `max` 수식어로 접두될 수 있어 `min-width` 혹은 `max-device-width`과 같은 특성을 만들 수 있다.

`height`와 `width` 특성은 (브라우저 창과 같은) 뷰포트 렌더링 영역의 높이와 너비에 기반하며, 한편 `device-height`와 `device-width` 특성은 (실제 렌더링 영역보다 더 클 수 있는) 출력 기기의 높이와 너비에 기반한다. 이 높이와 너비 미디어 특성 값은 (상대적이거나 절대적인) 어떠한 길이 값도 될 수 있다.

```css
    @media all and (min-width: 320px) and (max-width: 780px) {...}
```

반응형 디자인에서는 `min-width`과 `max-width`를 포함하는 특성이 가장 많이 사용된다. 이것들은 기기 특성에 혼동을 피해 데스크탑과 모바일 기기에 동일하게 반응형 웹사이트를 만드도록 해준다.

> **Using Minimum & Maximum Prefixes**
>
> `min`과 `max` 접두어는 꽤 많은 미디어 특성에서 사용될 수 있다. `min` 접두어는 보다 크거나 같은 값을 가리키며, `max` 접두어는 더 적거나 같은 값을 가리킨다. `min`과 `max` 접두어는 일반적인 HTML 문법과 충돌되지 않아 특별히 꺽쇠 심볼을 사용하지 않는다.

#### Orientation Media Feature

`orientation` 미디어 특성은 기기가 `landscape`나 `portrait` 편향(orientation)인지를 결정한다. `landscape` 모드는 화면이 가로 모드일 때, `portrait` 모드는 화면이 세로 모드일 때이며, 모바일 기기에서 널리 사용된다.

```css
@media all and (orientation: landscape) {...}
```

#### Aspect Ratio Media Features

`aspect-ratio`와 `device-aspect-ratio` 특성은 목표 렌더링 영역 혹은 출력 기기의 `width/height` 픽셀 비율을 지정한다. `min`와 `max` 접두어가 사용될 수 있다.

종횡비(aspect ratio) 값은 /로 분리되는 두 개의 양의 정수로 구성된다. 첫 정수는 픽셀 너비를, 두번째 정수는 픽셀 높이이다.

```css
    @media all and (min-device-aspect-ratio: 16/9) {...}
```

> **Pixel Ratio Media Features**
>
> 종횡비 특성에 더해 `pixel-ratio` 미디어 특성도 있다. 이 특성은 `device-pixel-ratio` 특성을 포함하며, `min`과 `max` 접두어도 가진다. 특히 픽셀비 특성은 레티나 디스플레이와 같은 고해상도 기기를 지정할 때 훌륭하며, 다음처럼 보여질 것이다.
>
> @media only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3) {…}

#### Resolution Media Feature

`resolution` 미디어 특성은 DPI(dots per inch)로 알려진 픽셀 밀도로 출력 기기의 해상도를 지정한다. `min`과 `max`를 접두할 수 있다. 게다가 `resolution` 미디어 속성은 dots per pixel (`1.3dppx`), dots per centimeter (`118dpcm`)와 같은 길이 기반 해상도 값을 가질 수도 있다.

```css
@media print and (min-resolution: 300dpi) {...}
```

#### Other Media Features

`color`, `color-index`, `monochrome` 특성은 출력 색상을, `grid` 특성은 비트맵 기기를, `scan` 특성은 텔레비전의 스캐닝 처리를 지정하며, 자주 사용하지는 않지만 필요할 땐 도움이 된다.

> **Media Query Browser Support**
>
> 불행하게도 미디어 쿼리는 인터넷 익스플로러 8 이하와 고전적인 브라우저에서는 작동하지 않는다. 그러나, 자바스크립트로 쓰여진 두 개의 알맞는 땜빵(polyfill)이 있다.
>
> [Respond.js][14]는 min/max-witdh 타입만을 위한 가벼운 땜빵이며, 미디어 쿼리 타입만 사용된다면 완벽하다. [CSS3-MediaQueries.js][15]는 더 많이 개발되고 더 무겁지만 더 복잡한 미디어 쿼리의 더 큰 배열을 지원하는 땜빵이다. 추가적으로 어떠한 땜빵이라도 성능 문제를 가져올 수 있으며, 잠재적으로 웹사이트를 느리게 할 수 있다는 것을 명심해야한다. 주어진 땜빵이 성능과 맞바꿀만한지 확인해야한다.

### Media Queries Demo

이제 미디어 쿼리를 사용하여 전에 만들었던 가변 레이아웃을 다시 코딩하자. 데모의 현재 문제점 중 하나는 `aside`가 아주 작은 뷰포트에서 사용할 수 없을 정도로 작아진다는 것이다. `420` 픽셀 너비 아래의 뷰포트를 위해 미디어 쿼리를 추가하여 `float`를 꺼버리고 `section`과 `aside`의 너비를 변화시키는 레이아웃으로 변경할 수 있다.

```css
    @media all and (max-width: 420px) {
      section, aside {
        float: none;
        width: auto;
      }
    }
```

**Fig. 4.02**  미디어 쿼리 없이는 `section`과 `aside` 너무 작아 진다. 너무 작아서 어떤 실제 컨텐츠도 담을 수 없다. 

![Demo without Media Queries][16]

**Fig. 4.03**  미디어 쿼리를 사용하여 `float`를 제거하고 너비를 변경하면, `section`과 `aside`가 뷰포트 전체 너비를 차지하고 기존의 컨텐츠에 충분한 공간이 생겼다. 

![Demo with Media Queries][17]

> #### Identifying Breakpoints
>
> 당신의 직관이 각기 다른 기기 해상도로 결정되는 공통적인 뷰포트 사이즈의 미디어 쿼리 분기점(`320px`, `480px`, `768px`, `1024px`, `1224px` 등)을 쓸지도 모르겠다. 그러나 이건 **나쁜** 아이디어이다.
>
> 반응형 웹사이트를 만들 때는 기기만아니라 다른 뷰포트 사이즈의 배열에 맞추어 조정되어야 한다. 웹사이트가 깨지거나 이상하게 보이기 시작할 때 혹은 경험이 방해받을 때에만 분기점(breakpoint)이 도입되어야 한다.
>
> 게다가 새로운 기기와 해상도는 항상 출시된다. 이러한 변화를 따라가려는 것은 끝없는 과정일 수 있다.

## Mobile First

미디어 쿼리와 함께 가장 인기있는 기술은 _mobile first_로 불리우는 것이다. [mobile first][18] 접근법은 작은 뷰포트의 스타일을 기본 웹사이트 스타일로 한 다음 뷰포트가 커짐에 따른 스타일을 추가하기위해 미디어 쿼리를 사용한다.

모바일 퍼스트 디자인의 배경에서 작동되는 믿음은 일반적으로 더 작은 뷰포트를 사용하는 모바일 기기 유저는 모바일 스타일을 덮어쓰기만을 위해 테스크탑 스타일을 로드할 필요가 없다는 것이다. 그렇게 하는 것은 대역폭(bandwidth)의 낭비이다. 쾌적한 웹사이트를 기대하는 어떤 유저에게도 귀중한 대역폭 말이다.

모바일 퍼스트 접근법은 모바일 유저의 제한을 염두에 두고 디자인하는 것을 지원하기도 한다. 오래 전에 인터넷 소비의 태반이 모바일 기기로 이루어질 것으로 예상되었다. 적절하게 그것을 계획하고 본질적인 모바일 경험을 개발하라.

모바일 퍼스트 미디어 쿼리는 다음과 같을 것이다.

```css
/* Default styles first then media queries */
@media screen and (min-width: 400px)  {...}
@media screen and (min-width: 600px)  {...}
@media screen and (min-width: 1000px) {...}
@media screen and (min-width: 1400px) {...}
```

불필요한 미디어를 다운로드하는 것은 미디어 쿼리를 사용하여 중지시킬 수 있다. 일반적으로 모바일 스타일에서 CSS3 그림자, 그라디언트, 변형(transform), 애니메이션 등을 피하는 것은 나쁜 아이디어가 아니다. 지나치게 사용되면 로딩이 무겁게되고, 기기의 배터리를 빨리 닳게할 수도 있다.

```css
/* Default media */
body {
  background: #ddd;
}
/* Media for larger devices */
@media screen and (min-width: 800px) {
  body {
    background-image: url("bg.png") 50% 50% no-repeat;
  }
}
```

### Mobile First Demo

이전 예제에 미디어 쿼리를 추가하면 `420` 픽셀 너비 미만에서 더 나은 레이아웃을 얻기위해 약간의 스타일을 겹쳐쓰자. 모바일 스타일 퍼스트를 기본으로 사용하기 위해 코드를 다시 쓰고 `420` 픽셀 이상의 뷰포트에 맞추기 위해 미디어 쿼리를 추가하면 다음과 같다.

[View this code in action.][19]

```css
section, aside {
  margin: 1.51515151%;
}
@media all and (min-width: 420px) {
  .container {
    max-width: 660px;
  }
  section {
    float: left;
    width: 63.63636363%;
  }
  aside {
    float: right;
    width: 30.30303030%;
  }
}
```

코드 양이 전과 같음을 주목하라. 여기서 유일한 예외는 모바일 기기는 **하나의** CSS 선언만 렌더링해야만 한다는 것이다. 뒤따르는 나머지 스타일은 더 큰 뷰포트에서만 로드되고 어떤 선행 스타일을 겹쳐쓰지 않는다.

## Viewport

요사이 모비일 기기는 일반적으로 웹사이트를 꽤 잘 보여주고 있다. 때때로 [뷰포트][20] 사이즈, 스케일, 웹사이트 해상도 등을 별도로 지정해주어 약간의 지원을 해줄 수 있다. 이것을 개선하기 위해 애플이 `viewport` 메타 태그를 만들었다.

**Fig. 4.04** 이 데모는 미디어 쿼리를 사용했음에도 많은 모바일 기기들이 아직 웹사이트의 최초 너비나 크기를 알 수 없어서 미디어 쿼리가 적용되지 않을지도 모른다. 

![Website without Viewport Meta Tag][21]

#### Viewport Height &amp; Width

`viewport` 메타 태그를 `height`나 `width` 값과 함께 사용하면 뷰포트의 높이나 너비를 각각 정의할 것이다. 각각의 값은 양의 정수나 키워드로 받아들인다. `height` 속성은 키워드 `device-height` 값을 받아들이고, `width` 속성은 키워드 `device-width`를 받아들인다. 이 키워드들을 이용해 기기의 기본 높이와 너비 값을 상속한다.

웹사이트가 가장 최적으로 보이는 결과를 위해 `device-height`와 `device-width` 값을 적용하여 기기 디폴트를 사용하는 것을 추천한다.

```html
<meta name="viewport" content="width=device-width">
```

**Fig. 4.05** 기기가 웹사이트의 의도된 너비(여기서는 `device-width`)를 알게하여 웹사이트를 적절한 크기로 나타내고 알맞는 미디어 쿼리를 선태할 수 있다. 

![Website with Viewport Meta Tag][22]

#### Viewport Scale

모바일 기기에서 웹사이트의 크기를 조절하고 유저가 웹사이트의 크기를 지속적으로 조절할 수 있게 통제하러면 `minimum-scale`, `maximum-scale`, `initial-scale`, `user-scalable` 속성을 사용하라.

웹사이트의 `initial-scale`은 `1`로 설정해야하고, 이것은 세로 편향일 때의 기기 높이와 뷰포트 크기 간의 비율을 정의한다. 가로 편향에선 기기 너비와 뷰포트 크기간의 비율이 된다. `initial-scale` 값은 항상 `0`과 `10` 사이의 양의 정수이어야 한다.

```html
<meta name="viewport" content="initial-scale=2">
```

**Fig. 4.06** `1`을 넘는 정수를 사용하면 웹사이트는 기본 크기보다 더 크게 확대될 것이다. 이 값을 `1`로 설정하는 것이 대부분의 공통사항이다. 

![Viewport Scale Meta Tag][23]

`minimum-scale`과 `maximum-scale` 값은 뷰포트가 얼마나 작고 커질지를 결정한다. `minimum-scale`을 사용할 경우 그 값은 `initial-scale`과 같거나 더 작은 양의 정수여야 한다. 같은 이유로 `maximum-scale` 값은 `initial-scale`과 같거나 더 큰 양의 정수여야 한다. 이 두 값도 역시 `0`과 `10` 사이여야 한다.

```html
<meta name="viewport" content="minimum-scale=0">
```

일반적으로 이 값들은 `initial-scale`과 같은 값을 설정하지 말아야 한다. 이것은 확대를 못하게 하고 `user-scalable` 값으로 수행되는 확대 기능을 불가능하게 한다. `user-scalable` 값을 `no`로 설정하면 확대하지 못하게 될 것이고, `user-scalable` 값을 `yes`로 설정하면 확대 기능(zooming)이 켜진다.

웹사이트의 크기 조절을 가능하게 하는 것은 **나쁜 아이디어**다. 웹사이트를 바라던 대로 보지 못하게 방해하여 접근성과 사용성을 해친다.

```html
<meta name="viewport" content="user-scalable=yes">
```

#### Viewport Resolution

브라우저가 모든 뷰포트 크기에 맞추어 웹사이트를 크기 조절하는 방법을 결정하게 하려면 일반적으로 트릭을 사용한다. 더 많은 제어가 요구될 때(특히, 기기 해상도 같은)는 `target-densitydpi`값이 사용될 수 있다. `target-densitydpi` 뷰포트는 `device-dpi`, `high-dpi`, `medium-dpi`, `low-dpi` 혹은 실제 DPI 수와 같은 값이 사용된다.

`target-densitydpi` 뷰포트 값은 드물게 사용되지만 픽셀 단위 제어가 필요할 땐 매우 도움이 된다.

```html
<meta name="viewport" content="target-densitydpi=device-dpi">
```

#### Combining Viewport Values

`viewport` 메타 태그는 개별 값만이 아니라 멀티 뷰포트 속성을 한번에 설정할 수 있는 멀티 값도 받아들인다. 멀티 값을 설정할 때는 `content` 속성 값 안에서 `,`로 분리해야 한다. 추천되는 뷰포트 값은 아래와 같이 `width`와 `initial-scale` 속성을 같이 사용하는 것이다.

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

**Fig. 4.07** `width=device-width`와 `initial-scale=1`의 조합은 일반적으로 요구되는 최초 크기와 줌(zoom)을 제공한다. 

![Website with Viewport Meta Tag][22]

#### CSS Viewport Rule

`viewport` 메타 태그는 웹사이트가 렌더링되어야 하는 스타일에 강하게 연관되어 있기 때문에 HTML 안의 메타태그보다는 CSS 안에서 `@` 룰로 옮길 것을 추천한다. 이렇게 하는 것은 컨텐츠에서 스타일을 분리하여 보다 시맨택적으로 접근하는 것을 도와준다.

현재 몇몇 브라우저는 이미 `@viewport` 룰을 적용했으나 전반적인 지원은 훌륭하지 않다. 위에서 추천된 `viewport` 메타 태그는 다음 CSS에서의 `@viewport` 룰과 같이 보여질 것이다.

```css
@viewport {
  width: device-width;
  zoom: 1;
}
```

## Flexible Media

마지막 반응형 웹 디자인의 중요한 측면은 가변 미디어와 관련된 것이다. 뷰포트 크기가 변하기 시작하면 미디어가 항상 알맞게 따라오는 것은 아니다. 이미지, 비디오와 같은 미디어 타입은 뷰포트 변화에 맞추어 크기를 변화시킬 필요가 있다.

미디어 크기를 조절할 수 있게 하는 빠른 방법은 `max-width` 속성을 `100%` 값으로 주는 것이다. 그렇게 하면 뷰포트가 작아질 때 미디어의 크기가 컨테이너 너비에 맞추어 작아질 것이다.

```css
img, video, canvas {
  max-width: 100%;
}
```

[Flexible Media Demo][24]

### Flexible Embedded Media

불행히도 `max-width` 속성이 모든 미디어 실례에서 잘 작동하진 않는다. `iframes`과 같이 임베딩된 미디어에서 특히 그렇다. 유투브와 같은 서드파티 웹사이트와 함께 할 때 아이프레임을 사용하여 미디어를 임베딩하면 엄청나게 실망하게 된다. 다행히 [우회 방법][25]이 있다.

반응형을 완벽히 지원하는 임베딩된 미디어를 얻으려면 임베딩된 엘리먼트는 부모 엘리먼트 안에서 절대적으로 배치될(be absolutely positioned) 필요가 있다. 뷰포트의 너비에 기반하여 크기 조절될 수 있도록 부모 엘리먼트의 `width`가 `100%`로 요구된다. 또한, 인터넷 익스플로러에서는 `hasLayout` 매커니즘을 작동시키기 위해서 부모 엘리먼트의 `height`가 `0`로 요구된다.

그런 후 부모 엘리먼트의 `padding-bottom`을 주고, 그 값을 비디오의 종횡비와 같게 설정한다. 이렇게 하면 부모 엘리먼트의 높이가 너비에 비례하게 된다. 이전의 반응형 디자인 공식을 기억하는가? 비디오의 종횡비가 16:9라면 `9`를 `16`으로 나누면 `.5625`가 되며, `padding-bottom`은 `56.25%`가 요구된다. `padding-bottom`이 사용되고 부모 엘리먼트는 절대적으로 배치된 엘리먼트로 다룬다. `padding-top`은 인터넷 익스플로어 5.5에서 깨지는 방지하기 위해 특별히 사용된다.

_원문 : Padding on the bottom and not the top is specifically used to prevent Internet Explorer 5.5 from breaking, and treating the parent element as an absolutely positioned element. - 이 부분은 무척 쉬운 듯하면서 몇번을 읽어봐도 정확하게 번역하기 힘들어 내맘대로 말그대로 막번역해버렸다. 마지막 문장이라 노력했지만 역부족이다. 고수님들이 도와주시면 좋겠는데.. ㅠㅠ_

###### HTML

```html
<div class='bogus-wrapper'><notextile><figure>
  <iframe src="https://www.youtube.com/embed/4Fqg43ozz7A"></iframe>
</figure></notextile></div>
```

###### CSS

```css
figure {
  height: 0;
  padding-bottom: 56.25%; /* 16:9 */
  position: relative;
  width: 100%;
}
iframe {
  height: 100%;
  left: 0;
  position: absolute;
  top: 0;
  width: 100%;
}
```

**[Flexible Embedded Media Demo][26]**

## Resources & Links

* [Responsive Web Design](http://www.alistapart.com/articles/responsive-web-design/) via A List Apart
* [Viewport Percentage Lengths](http://dev.w3.org/csswg/css3-values/#viewport-relative-lengths) via W3C
* [CSS Media Queries](http://css-tricks.com/css-media-queries/) via CSS-Tricks
* [Mobile First Presentation](http://www.lukew.com/presos/preso.asp?26) via Luke Wroblewski
* [An Introduction to Meta Viewport and @viewport](http://dev.opera.com/articles/view/an-introduction-to-meta-viewport-and-viewport/) via Dev.Opera

   [1]: http://learn.shayhowe.com/advanced-html-css/responsive-web-design
   [2]: http://www.gpmd.co.uk/blog/2012-mobile-internet-statistics/
   [3]: http://www.digitalbuzzblog.com/2011-mobile-statistics-stats-facts-marketing-infographic/
   [4]: http://www.alistapart.com/articles/responsive-web-design/
   [5]: http://www.abookapart.com/products/responsive-web-design/
   [6]: http://learn.shayhowe.com/assets/courses/advanced-html-css-guide/responsive-web-design/food-sense.png
   [7]: http://foodsense.is/
   [8]: http://www.w3.org/TR/CSS2/visuren.html#viewport
   [9]: http://en.wikipedia.org/wiki/Browser_sniffing
   [10]: http://dev.w3.org/csswg/css3-values/#viewport-relative-lengths
   [11]: http://learn.shayhowe.com/advanced-html-css/responsive-web-design#fixed-grid-demo
   [12]: http://learn.shayhowe.com/advanced-html-css/responsive-web-design#flexible-grid-demo
   [13]: http://css-tricks.com/css-media-queries/
   [14]: https://github.com/scottjehl/Respond/
   [15]: http://code.google.com/p/css3-mediaqueries-js/
   [16]: http://learn.shayhowe.com/assets/courses/advanced-html-css-guide/responsive-web-design/without-media-queries.png
   [17]: http://learn.shayhowe.com/assets/courses/advanced-html-css-guide/responsive-web-design/with-media-queries.png
   [18]: http://www.lukew.com/presos/preso.asp?26
   [19]: http://learn.shayhowe.com/courses/advanced-html-css/responsive-web-design/responsive-web-design-demo.html
   [20]: http://dev.opera.com/articles/view/an-introduction-to-meta-viewport-and-viewport/
   [21]: http://learn.shayhowe.com/assets/courses/advanced-html-css-guide/responsive-web-design/without-viewport.png
   [22]: http://learn.shayhowe.com/assets/courses/advanced-html-css-guide/responsive-web-design/with-viewport.png
   [23]: http://learn.shayhowe.com/assets/courses/advanced-html-css-guide/responsive-web-design/viewport-scale.png
   [24]: http://learn.shayhowe.com/advanced-html-css/responsive-web-design#flexible-media
   [25]: http://alistapart.com/article/creating-intrinsic-ratios-for-video
   [26]: http://learn.shayhowe.com/advanced-html-css/responsive-web-design#flexible-embed
  