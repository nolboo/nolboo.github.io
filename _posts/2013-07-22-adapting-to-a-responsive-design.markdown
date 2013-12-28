---
layout: post
title: "반응형 디자인 적용하기(케이스 스터디)"
description: "사이버덕 회사의 홈페이지를 반응형 디자인으로 변경한 경험을 자세하게 소개한 스매싱 기사의 번역"
category: blog
tags: [case, responsive, web, design]
---

원본: [Adapting To A Responsive Design (Case Study)][1]

## Why Adapt To A Responsive Design?

### CHANGING OUR APPROACH

새로운 폼팩터가 엄청나게 유입되면서 좀 더 future-friendly한, 동시에 관리하기 쉬운 웹사이트를 만들게 되었다.

### SETTING GOALS FOR THE RESPONSIVE DESIGN

**반응형 디자인의 목표**

  1. 속도
  2. 스타일, 백그라운드 혹은 자바스크립트와 상관없는 접근성
  3. 하나의 컨텐츠
  4. 플랫폼 독립성
  5. [미래지향][2] - 계속 유지보수하기 싫다.  먼저 신뢰할만한 고객에게 의견을 구했고, [구글 애널리틱스][3], [리드포렌식][4], [크레이지에그][5] 등을 이용해 기존 웹사이트를 분석했다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

디자인 팀이 기존 컨텐츠를 재구성하기 위해 카드 소팅을 사용하고 있다.

## Making Performance A Priority

특정 스크린 너비에서 보이지않게만 하는 방법은 성능이 문제가 된다. 모바일 breadpoint에서 40 HTTP 요청과 500KB 데이타를 넘지않길 원했다.

### THIRD-PARTY SCRIPTS

[Zurb에 의하면][6], 총 19개의 요청으로 페이스북, 트위터, 구글 소셜 미디어 버튼을 로드하는 것이 대역폭에서 246.7 KB를 잡아먹는다고 한다. 그래서 무거운 소셜미디어 플러그인을 가벼운 소셜미디어 링크로 대치하였다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

몇개의 필수적인 트래킹 스크립트는 남겨야 했는데, HTML의 `body` 엘리먼트의 바닥과 외부 스크립트 화일에 집어넣어서 컨텐츠 이후에 로딩되도록 하였다.

### DID WE REALLY NEED A CMS?

토의 초기에 CMS가 필요한가에 검토하였는데 우리 대부분은 HTML, CSS, Git에 익숙하기 때문에 CMS 없이 컨텐츠를 관리하기로 했다.

[New Relic][7]과 같은 서버사이드 성능 모니터링 툴을 사용해서, 이전에 사용하던 CMS가 페이지 로딩 타임을 느리게하는 주요 요인이라는 것을 알 수 있었다. 그래서 웹사이트에서 CMS를 완전히 제거해버렸다. 블로그는 제외했는데, 올리는 컨텐츠의 양과 주기때문에 효과적으로 관리하기 위해서는 아직 CMS가 필요했다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

이전 홈페이지 2.34초의 총 실행시간 동안 1,459번의 데이타베이스 서버를 쿼리했다.

이전 웹사이트는 워드프레스 CMS와 연결된 MVC 아키텍트로 구축되었었다. 예로 들었듯이 하나의 일반적인 페이지가 로드하되기위해 600 ~ 1,500 쿼리를 사용했다. 단순히 CMS를 제거함으로써 수백번의 데이타베이스 쿼리가 한방에 0으로 줄었다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

초기 프로토타입을 개발하고 있다.

정적 페이지를 위한 CMS를 제거하여 데이타베이스와 동적인 템플릿에 대한 니즈를 생략했다. 인기 있는 PHP 프레임워크인 Laravel을 사용해 커스텀 동적 루트와 정적 템플릿 시스템을 적용했다. 이것은 템플릿 이름과 URL을 매칭시켜 웹사이트에서 URL이 호출될 때마다 Laravel 라우터가 로드될 템플릿을 정확하게 안다는 것을 의미한다. 또한, 그 템플릿은 HTML에서 정적으로 레이아웃된 컨텐츠를 이미 가지고 있다는 것을 의미한다.

이것만으로, 웹사이트 처리 속도를 3,900% 넘게 개선할 수 있었다. 평균 2.2초에서 56 밀리초로 서버 처리속도가 개선되었다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

서버 처리 속도가 이제 단지 56밀리초이며, 데이타베이스 쿼리는 0이다. - 전보다 대략 40배 더 빨라졌다.

자연히 우리는 매 프로젝트의 시작에서 어떤 CMS가 가장 적합하고 필요한지 자문해야한다. 물론 다른 옵션도 있다. [Kirby][8]와 [Statamic][9]와 같은 화일 베이스 CMS, [Perch][10]와 같은 경량 CMS를 구축하거나 커스터마이징, [Varnish][11]와 같은 것을 이용해 더 나은 서버사이드 캐싱만을 적용하는 것 등이다.

결국, 가장 경량이더라도, 영리한 캐싱과 함께 CMS를 최적화 시키는 것조차도 오버헤드이고 성능과 정적화일의 서버 족적에 맞출 수 없어서 CMS를 제거하기로 결정했다.

### AVOIDING OFF-THE-SHELF CSS FRAMEWORKS

[Twitter Bootstrap][12]과 [Foundation][13]과 같은 CSS 프레임워크는 인터렉티브한 프로토타입을 재빠르게 구축하는 데에 훌륭하지만 대부분의 프로젝트에 필요한 것보단 종종 훨씬 더 복잡하다. 이들 프레임워크가 민감하고 광범위한 유즈 케이스에 맞추어져 있고 프로젝트의 특별한 요구에 맞추어져 있지 않기 때문이다.

우리는 단순하고 빠르고 우리 요구에 극도로 유연한 커스텀 반응형 그리드를 만들어 스타일 시트의 크기를 줄였다.

컨텐츠를 정의하는 레이아웃에 반해 컨텐츠가 레이아웃과 그리드를 모양짓는 것을 디자인하였다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

위에서 부터 시계방향(놀부주: 시계반대방향인 듯)으로: 데스크탑에서 레이아웃은 3개의 행이고 모바일에선 하나의 행으로된 스택(쌓아놓은 더미)로 된다. 태블릿에선 컨텐츠 왼쪽에 이미지를 띄워 추가 공간의 이점을 살렸다.

```css
@media only screen and (min-width: 120px) and (min-device-width: 120px) {

   // Uses mobile grid
   .container {
      width: 100%;
   }
   .col12, .col11, .col10, .col9, .col8, .col7, .col6, .col5, .col4, .col3 {
      width: 92%;
      margin: 0 4% 20px 4%;
   }
   .col2 {
      width: 46%;
      float: left;
      margin: 0 4% 20px 4%;
   }
}

@media only screen and (min-width: 600px) and (min-device-width: 600px) {

   // Uses custom grid to accomodate content
   .home-content {
      article {
         width: 92%;
         clear: both;
         margin: 0 4% 20px 4%;
      }
      .image {
         float: left;
         width: 40%;
      }
      .text {
         float: left;
         width: 50%;
         margin-left: 5%;
         .btn {
            @include box-sizing(content-box);
            width: 100%;
         }
      }
   }
}

@media only screen and (min-width: 1024px) and (min-device-width: 1024px) {

   // Uses regular desktop grid system
   .container {
      width:960px;
      margin:0 auto;
   }
   .col4 {
      width: 300px;
      float: left;
      margin: 0 10px;
   }
}
```

코드 중복을 피하려고 [Sass][14]를 사용했고, 모든 CSS 코드가 실제로 사용되도록 했다. Sass에선 CSS를 가능한한 작게하기 위해 minify할 수도 있다.


    $sass --watch --style compressed scss:css


커스텀 그리드를 만들기 위해 Sass 안의 함수를 사용하기도 했다. 아래는 테스크탑 그리드를 위한 코드이다.

```css
@import "vars";

// Grid system
$wrap: $col * 12 %2B $gutter * 11;
@for $i from 2 through 12 {
   .col#{$i} {
      width: $col * $i %2B $gutter * $i - $gutter;
      float: left;
      margin: 0 $gutter/2 $vgrid $gutter/2;
   }
}
@for $i from 1 through 11 {
   .pre#{$i} {
      padding-left: $col * $i %2B $gutter * $i;
   }
}
@for $i from 1 through 11 {
   .suf#{$i} {
      padding-right: $col * $i %2B $gutter * $i;
   }
}
.container {
   width: $wrap %2B $gutter;
   margin: 0 auto;
   padding-top: 1px;
}
.colr {
   float: right;
   margin: 0 $gutter;
}
.alpha {
   margin-left: 0;
}
.omega {
   margin-right: 0;
}
```

여기서, 단순히 `vars` 화일을 편집함으로써 그리드의 `column`과 `gutter`의 너비를 커스터마이징할 수 있다.


```sass
// Grid
$vgrid:      20px;
$col:        60px;
$gutter:     20px;
```


[깃허브][15]에 오픈소스화 하였으니, 포크하여 당신의 프로젝트에 적용해 보고 어떤지 알려달라!

### CONDITIONALLY LOADING JAVASCRIPT

속도 향상을 필요로 하고 지원될 때만 자바스크립트가 로드되길 원했고, [RequireJS][16]를 이용했다. 자바스크립트 화일을 줄여주는 [UglifyJS][17]도 포함되어있다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

최적화로 자바스크립트 크기가 411 KB에서 106 KB로 줄었다.

### OPTIMIZING IMAGE ASSETS

우리 웹사이트는 작업을 전시하기 위해 꽤 이미지가 무거운 실례이기 때문에 대부분의 웹사이트에서 가장 무거운 자산인 이미지 다운로드를 개선하길 원했다.

Adobe Firework의 [selective quality options][18]을 사용해 웹사이트의 전체 이미지를 수작업으로 최적화했다. 압축, blur, desaturation 등의 더 세세한 조정을 통해 이미지 화일 크기를 줄이기도 했다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

이미지의 부분들을 desaturation하고 blur하는 것은 꼭 필요한 것은 아니지만 이미지 크기를 상당히 줄였다.

[ImageOptim][19]와 [TinyPNG][20]를 사용해 이미지와 스프라이트를 압축하기도 했다. 이 툴들은 이미지 질 저하없이 모든 불필요한 데이타를 제거한다. 예로 메인 이미지 스프라이트의 무게를 111 KB를 40 KB까지 줄였다.

홈페이지의 슬라이드쇼 배너에서는 미디어 쿼리를 이용해 적합한 크기의 이미지만 로드하여 다양한 스크린 크기에 최적화했다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

위의 이미지는 모바일에서 볼 수 있고, 슬라이드쇼는 훨씬 더 가벼워졌다.

CSS는:

```css
    @media only screen and (min-width: 120px) and (min-device-width: 120px) {
       .item-1 {
          background: $white url('carousel/dmd/background-optima-m.jpg') 50% 0 no-repeat;
          .computer, .tablet, .phone, .eiffel, .bigben, .train {
             display: none;
          }
       }
       /* Total loaded: 27 KB */
    }
```

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

데스크탑에선 더 많은 자산을 로드한다.

데스크탑에서는 더 큰 스크린 크기의 대부분을 사용하도록 더 많은 자산을 로드한다.

CSS는:

```css
    @media only screen and (min-width: 1024px) and (min-device-width: 1024px) {
       .item-1 {
          background: $white url('carousel/dmd/background.jpg') center -30px no-repeat;
          .computer {
             background: url('carousel/dmd/computer.png') center top no-repeat;
             div {
                background: url('carousel/dmd/sc-computer.jpg') center top no-repeat;
             }
          }
          .tablet {
             background: url('carousel/dmd/tablet.png') center top no-repeat;
             div   {
                background:  url('carousel/dmd/sc-tablet.jpg') center top no-repeat;
             }
          }
          .phone {
             background: url('carousel/dmd/phone.png') center top no-repeat;
             div {
                background: url('carousel/dmd/sc-mobile.jpg') center top no-repeat;
             }
          }
          .eiffel {
             background: url('#{$img}carousel/dmd/eiffel.png') center top no-repeat;
          }
          .bigben {
             background: url('#{$img}carousel/dmd/bigben.png') center top no-repeat;
          }
          .train {
             background: url('#{$img}carousel/dmd/train.png') center top no-repeat;
          }
       }
       /* Total loaded: 266 KB */
    }
```

### DELIVERING CONTENT FASTER

[야후의 성능 황금률][21]에서는 엔드유저 반응 시간의 80-90%는 페이지의 모든 구성요소(이미지, 스타일 시트, 스크립트, 플래쉬 등)를 다운로드하는 것에 소비된다고 한다. 간략히, 각 요청은 처리하는 시간이 걸린다; 그러므로 서버에서 화일을 제공되는 것과 같은 각 요청은 로딩 시간을 불가피하게 증가시킬 것이다.

[CloudFlare의 CDN][22]을 이용하여 웹사이트 처리에서 웹 서버의 화일 제공 작업을 분리하였다. 이것은 우리 웹 서버를 정적 화일을 제공하기 보단 애플리케이션에 집중하도록 하는 것을 의미한다. 모든 정적인 자산을 분리된 서브도메인(우리 경우 `static.cyber-duck.co.uk`)으로 옮겼다. 각 자산에 요구되는 대역폭을 차례로 줄여 하나의 자산을 요청하는 각 요청과 함께 보내지는 쿠키를 최소로 줄이기 위한 것이다.

CDN은 캐싱하고, 유저 위치에 가장 가까운 서버에서 화일이 제공되도록 하게하고, 데이타가 더 짧은 거리에서 제공되기 때문에 네트워크 지연을 최소화하여 로딩 시간을 줄여준다.

CDN에 더해, Gzip 룰을 사용했고 [HTML5 Boilerplate의 `.htaccess` 화일][23]에서 헤더를 죽였다.(expire) This uses Apache’s mod_deflate module to compress the output of files to the browser and also sets an expiration on headers far into the future, to ensure better caching of the website for returning visitors.

## Creating A Truly Responsive Design

진정한 반응형 디자인을 전달하기 위해, 모든 스타일링과 디스플레이 작업을 - 자바스크립트를 직접 사용해 엘리먼트를 숨기거나 보여주지 않고, CSS 클래스를 추가하거나 제거하여 엘리먼트의 상태만을 변경하기 위해 자바스크립트를 사용하고 - CSS 에만 위임했다.

### THE RIGHT CODE FOR THE TASK

이 방법을 사용해 모바일 방문자가 전화하거나 사무실을 빠르게 찾을 수 있도록 전화와 지도 버튼을 갖도록 모바일의 탑 메뉴를 변형하는 등의 모바일에 특정한 최적화를 할 수 있었다.

이 접근법으로 웹사이트 전체에서 엘리먼트를 다이내믹하게 활성화하거나 비활성화하여 자바스크립트가 가능하지 않을 때에 페이지에 이 엘리먼트가 존재하도록 하였다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

상단 GUI의 오른쪽에서 지도와 전화 버튼을 볼 수 있으며, 페이지의 나머지 부분을 접근할 수 있는 표준 컨트롤을 둘 수 있다.

자바스크립트 코드:

```js
$('#menu').addClass('closed');
$('.btn-menu').click(function(e){
   e.preventDefault();
   $('#menu').toggleClass('closed');
});
```

테스크탑 CSS:

```css
.nav {
   display: block;
   float: right;
}
.btn-menu, .btn-call, .btn-map {
   display: none;
}
```

모바일 CSS:

```css
.menu {
   display: block;
   height: auto;
   overflow: hidden;
}
.menu.closed {
   height: 0;
}
.btn-menu, .btn-call, .btn-map {
   display: block;
}
```

### ANIMATIONS AS AN ENHANCEMENT

애니메이션 슬라이드쇼를 위해 HTML과 CSS만을 사용하는 슬라이드쇼를 만들기 위해 [SequenceJS][24]를 사용했다. 자바스크립트를 이용할 수 없거나 스크린 크기가 너무 작을 경우엔 애니메이션에 필요한 모든 자산을 다운로드할 필요가 없다.

다른 경우에도, **애니메이션에는 CSS3만을 사용하기로 했다.**

이것은 CPU 작업을 GPU로 옮기는 하드웨어 가속을 사용해 애니메션 성능을 향상시켰다. 스마트폰이나 태블릿 사용자에게는 제한된 CPU 자원의 소비를 줄여 성능에 막대한 차이를 만들 수 있다.

CSS에 애니메이션을 위임하여 최고의 하드웨어 가속을 만들 수 있었따.

```css
.menu {
   height: auto;
   transition: height 200ms linear;
}
.menu.closed {
   height: 0;
   transition: height 200ms linear;
}
```

### BREAKPOINTS BASED ON CONTENT AND DESIGN, NOT DEVICE

구분점(breakpoint)들에서 크고 작은 스크린에 최적화된 컨텐츠 표현을 반응적으로 전달하기 위해 다양한 CSS 미디어 쿼리를 사용했다.

이 기기 종속적이지 않은 접근법으로 다른 기기가 시장에 나올 때마다 코드를 최적화할 필요가 없게 되었다. 우리는 120, 240, 600, 760, 980, 1360에 구분점을 잡았다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

웹사이트는 각 구분점 사이에서 유동적으로 반응한다.

미래 친화성을 더 확실히 하기위해 특정 기기에 기반한 구분점을 디자인하지 않고, 우리가 손에 넣을 수 있는 데스크탑 브라우저와 다양한 폰과 태블릿에서, Lynx, 플레이스테이션 3, 킨들 페이퍼 화이트, PSP Vita 등등의 많은 기기와 브라우저에서 테스트하였다. 오래된 노키아 기기에서도 테스트하였고 웹사이트는 잘 동작하였다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

우리 디자이너와 프론트엔드 팀이 노키아 X2와 같은 오래된 모델을 포함한 매우 다양한 기기에서 테스트하였다.

## Being More Accessible

웹 디자이너와 개발자로서 반응성은 웹 사이트를 더 접근하기 쉽게 만드는 것이 아니라 우리 고객과 동료가 왜 배려받아야 하는지에 관해 교육하는 것이다.

우리 웹사이트에 적용한 접근성에 대해 얻은 것 몇가지가 아래에 있다.

### TEXT

  * 텍스트는 배경에 대해 읽기쉬워야 한다. 헤딩에는 3:1, `body` 텍스트엔 4.5:1의 대조비를 준다.
  * 텍스트는 적절한 헤딩과 의미있는 순서로 구조되어야 하고 컨텐츠의 주제나 목적을 설명한다.
  * 텍스트는 컨텐츠나 기능성을 잃지 않고 크기를 변경할 수 있어야 한다.

### LINKS

  * 모든 링크의 목적은 설명하는 텍스트와 함께 명료해야하고 할 수 없는 경우에는 대안 텍스트를 제공해야 한다.
  * 모든 페이지의 첫번째 링크는 컨텐츠로 직접 이동할 수 있는 내비게이션을 제공해야 한다.
  * 페이지 주소(즉, URL)은 사람이 읽기쉬워야 하고, 가능한 경우에는 영구적이어야 한다.
  * 중요한 페이지와 기능에 빠른 내비게이션을 위해 접근 관문을 제공했다.

네비게이션 링크를 스킵하는 HTML:

```html
<a href="#content" title="Skip to content" accesskey="s" class="btn-skip">Skip navigation</a>
```

그리고 CSS:

```css
.btn-skip {
   position: absolute;
   left: -9999px;
}
```

### IMAGES

  * 모든 컨텐츠 이미지는 이미지가 불가하거나 지원되지 않을 때 보여주는 (`alt` 속성과 함께하는) 대안 텍스트를 가져야한다.
  * 컨텐츠는 이미지가 불가하거나 지원되지 않을 때에도 접근할 수 있거나 이해될 수 있어야 한다.

### VIDEO

  * 모든 비디오는 말하는 부분이 있으면 캔셥이나 자막을 갖고, YouTube에 호스팅한다.

### FORMS

  * 모든 폼 컨트롤과 필드는 적절하고 명료하게 레이블한다.
  * 폼 입력은 터치 스크린에서 정확한 키보드가 로드되도록 형식과 속성을 할당한다.
  * 모든 중요한 폼 필드는 폼이 제출 될 때 에러를 체크하도록 한다.
  * 발견된 에러는 정정하는 방법에 대한 제안과 함께 유저에게 텍스트로 설명되어야 한다.
  * 모든 폼은 키보드에서 `tab`키로 내비게이션할 수 있도록 적절한 포커스 순서를 가져야 한다.
  * 모든 폼은 `Return`이나 `Enter`키로 제출할 수 있어야 한다.

`required`나 `placeholder`와 같은 적절한 input 타입과 속성을 사용하면 폼을 더 접근하기 쉽게 만들 수 있다.

```html
<input type="email" id="email" name="email" value="" required="" placeholder="Pop your email address in here">
```

## Just Getting Started

몇 주전 새 웹사이트를 띄운 결과가 인상적이었다. 모바일 트래픽이 200% 넘게 증가하였고(모든 트래픽 평균에선 82%가 증가), 평균 방문 시간이 18% 증가혔다. 모바일 사용자의 exit 비율이 4,000% 감소하였다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

구글 애널리틱스에 의하면 서버 반응 속도가 평균 1.21 초에서 170 밀리초로 감소하였다. 비슷하게 페이지 로딩 시간도 평균 9.19 초에서 1.82 초로 감소하였다.

여기서 중요한 것은 단지 시작이라는 것이다. 성능 최적화, 화일 크기 줄이기, 터치 제스처, [adaptive images][25]과 같은 서버 사이드 솔루션 등을 더 사용할 수 있다.

_링크를 허락하지 않으며 문맥에 큰 상관이 없으니 원본 그림 참조 바랍니다._

반응형으로 가는 것은 우리 웹사이트의 첫번째 단계일 뿐이다.

벤자민 플랭클린이 가로되, 당신이 변화를 끝낼 때 당신은 끝난 것이다.

   [1]: http://mobile.smashingmagazine.com/2013/06/18/adapting-to-a-responsive-design-case-study/
   [2]: http://futurefriend.ly/
   [3]: http://www.google.co.uk/analytics/
   [4]: http://www.leadforensics.com/
   [5]: http://www.crazyegg.com/
   [6]: http://zurb.com/article/883/small-painful-buttons-why-social-media-bu
   [7]: http://newrelic.com/
   [8]: http://getkirby.com/
   [9]: http://statamic.com/
   [10]: http://grabaperch.com/
   [11]: https://www.varnish-cache.org/
   [12]: http://twitter.github.com/bootstrap/
   [13]: http://foundation.zurb.com/
   [14]: http://sass-lang.com/
   [15]: https://github.com/Cyber-Duck/hoisin.scss
   [16]: http://requirejs.org/
   [17]: https://github.com/mishoo/UglifyJS
   [18]: http://help.adobe.com/en_US/fireworks/cs/using/WS3f28b00cc50711d9-73dfa65f133a490f3b9-8000.html
   [19]: http://imageoptim.com/
   [20]: http://tinypng.org/
   [21]: http://developer.yahoo.com/performance/rules.html
   [22]: http://www.cloudflare.com/features-cdn
   [23]: https://github.com/h5bp/html5-boilerplate/blob/master/.htaccess
   [24]: http://www.sequencejs.com/
   [25]: http://adaptive-images.com/
  