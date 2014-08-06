---
layout: post
title: "CSS 프리프로세서 LESS 튜토리얼과 프리젠테이션"
description: "왜 LESS를 사용하나? - 시간 절약, 실수 줄이기, 반복 줄이기(DRY), CSS를 여러 화일로 쪼개 logical sense하게 관리한다. CSS @import는 각 화일마다 새로운 HTTP 요청을 발생시켜 성능에 좋지 않다."
category: blog
tags: [CSS, LESS]
---

<div id="toc"><p class="toc_title">목차</p></div>

원본 : [LESS tutorial and presentation][1]

### LESS란?

[css-tricks에서 2012년 6월 실시한 조사][2]에 의하면 46%의 사람들이 CSS preprocessor를 경험하지 않았다. LESS가 51%이다.

  * LESS는 프로그래밍이다.
  * LESS는 CSS로 컴파일된다.
  * LESS는 CSS 프리프로세서다.
  * LESS 문법은 전통적인 CSS 모델을 따른다.
  * LESS는 다이내믹 CSS로 불리기도 한다.

### 왜 LESS를 사용하나?

  * 시간 절약
  * 실수 줄이기
  * 반복 줄이기(DRY)
  * CSS를 여러 화일로 쪼개 logical sense하게 관리한다. CSS @import는 각 화일마다 새로운 HTTP 요청을 발생시켜 성능에 좋지 않다.
  * LESS는 쿨하다!

CSS 프리프로세서는 CSS를 기능적으로 확장시키진 않는다. 대신에 개발 플로우를 더 쉽게 해준다. CSS를 압축하고 있다면, CSS 프리프로세서를 사용하는 것이 다음 단계다.

### LESS 설치


    npm install less --global


### LESS로 뭘 할 수 있나?

LESS는 CSS가 제공하지 않는 기능을 제공한다.

  * 변수
  * Mixins : 룰셋을 재사용할 수 있게 해주는 함수
  * DOM 구조와 유사한 스타일 nesting
  * 간단한 수학적 연산자 : 숫자와 컬러의 %2B,-,*,/
  * floor(), ceilling(), round()와 같은 수학적 연산자
  * darken(), lighten(), fadein(), fadeour()과 같은 컬러 연산자

### 변수

  * @로 시작
  * `#333` 혹은 `#fefefe`와 같은 헥사컬러값을 저장할 수 있다.
  * “Webcubator, Inc”와 같은 문자열을 저장할 수 있다.
  * 10px와 같은 사이즈를 저장할 수 있다. 
  
![][3]

### Mixins

  * 여러 곳에 쓰일 수 있는 룰셋의 속성들을 가지고 있다.
  * 코드 재사용
  * 패러미터를 줄 수 있으나, 필수는 아니다.
  * 패러미터의 기본값을 줄 수 있다.
  * @argument는 모든 패러미터에 저장된 순서대로의 값을 포함하는 특별한 변수다. 
  
![][4]

### Cascading + Nesting

  * cascading(들여쓰기)으로 룰셋을 nest한다.
  * 기존의 cascading 접근 방식과 함께 사용할 수 있다.
  * DOM 구조와 유사하게 할 수 있다.
  * cascading된 룰셋으로 _컴파일할 수 있다._ 

![](http://uploads.brianflove.com/wp-content/uploads/2012/10/nested-styles-in-less.png)

### & 연결자(combinator)

  * &연결자가 쓰이면 nesting된 실렉터는 부모 실렉터와 연쇄적으로 해석한다.
  * `:focus`나 `:hover`와 같은 의사 클래스에 매우 유용하다. 

![&연결자][5]

그림은 @.inline으로 설명은 `&.inline`으로 _일치하지 않음_

### 연산자(Operations)

  * 모든 사이즈와 컬러 변수에서 작동한다.
  * `+`,`-`,`*`,`/`
  * 컬러 함수
  * 수학 함수

![][6]

  * padding: @padding * 10% // outputs “padding: 20px;”
  * padding: ((@padding * 10%) / 2) %2B 5px; //outputs “padding: 15px;”
  * adding: @padding %2B (2 * @padding); //outputs “padding:6px;”

LESS에는 여러 수학 함수가 있다.

  * round()
  * ceiling()
  * floot()
  * percentage()

### 컬러 함수

여러 함수를 적용하여 새로운 컬러를 만들거나 기존 컬러에 대한 정보를 얻을 수 있다.

  * darken(@color, 20%); //20% 어둡게 한다.
  * lighten(@color, 20%); //20% 밝게 한다.
  * fadein(@color, 20%); //20% 더 투명하게 한다.
  * fadeout(@color, 20%); //20% 덜 투명하게 한다.
  * fade(@color, 80%); //80%투명도를 가진다.
  * hue(@color); //색상 채널
  * saturation(@color); //채도(chroma) 채널
  * lightness(@color); //명도(value) 채널
  * alpha(@color); //알파(투과도) 채널

참조 : [색 공간][7], [색 목록][8]

![][9]

여러 줄의 주석은 컴파일된 CSS에 유지되지만 한줄 주석은 유지되지 않는다. 그러므로 컴파일된 CSS에 포함되기를 원하지 않는 경우에는 한줄 주석을 일반적으로 이용해야 한다.

    /* 이 주석은 컴파일된 CSS에 유지된다. */
    //이 주석은 컴파일된 CSS에서 빠진다.

### @Import

CSS에서 @import()으 사용은 의심할 필요도 없이 아주 나쁜 생각이다. import된 각 화일 마다 서버에 추가적인 HTTP 요청을 하기 때문이다. CSS를 5개의 화일로 나누면 5번 요청한다. 사이트의 성능때문에 클라이언트에서 요청하는 CSS 화일은 하나로 해야한다.

또한, 인라인 스타일의 사용은 널리 알려진대로 최고로 피해야할 규칙이다. 클라이언트에서 요청된 CSS 화일은 브라우저에 의해 캐싱되므로 서브 페이지 방문에서는 다운로드되지 않는다. HTML은 일반적으로 캐쉬되지 않으므로 인라인 CSS 코드는 매번 포함되어 다운로드된다.

LESS에서는?

  * @import하면 하나의 화일로 모두 복사되어 컴파일된다.
  * 모든 변수와 mixin 선언된 이후 _are available to main file or files imported after declarations_
  * _Order matters_
  * .less 확장자는 포함하거나 생략할 수 있다.
  * .css 확장자를 사용하여 CSS화일을 import할 수 있다.

다음과 같이 필요한 모든 CSS화일을 하나의 .less 화일에 포함하는 것을 추천한다.

```css
// import normalize for CSS resets
@import "normalize";  // same as @import “normalize.less”;

// import mixins for all of my "global" variables and mixins
@import "mixins";

// base for mobile devices
@import "base";

//tablets
@media only screen and (min-width: 768px) {
@import "768";
}

//desktops
@media only screen and (min-width: 1030px) {
@import "1030";
    }
```

### 문자열 삽입

  * @{name} 구성을 사용
  * 선언시 변수값을 임베딩

![][10]

### Escaping

  * 유효한 CSS 문법이 아닌 CSS 출력이 필요하면
  * Proprietary syntax not recognized by LESS
  * If not used, LESS compiler will throw an error
  * Simple prefix with ~ symbol and put in quotes (string)

For example, you might be using IE specific code that is not valid CSS to create a gradient:

    filter: ~”progid:DXImageTransform.Microfilter: ~”progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#f8f8f8')”;soft.gradient(startColorstr='#dfdfdf', endColorstr='#f8f8f8')”;

“”앞에 ~를 붙이면 LESS 컴파일러가 코드 문자열을 무시한다.

### Pre-compile

  * LESS를 CSS3로 컴파일하면 웹앱에서는 하나의 CSS화일만 로드된다.
  * 포로덕션에만 사용되어져야 한다.
  * 개발할 때는 덜 편리하다.
  * LESS 컴파일러가 디렉토리를 “watch”하게 하면 디렉토리에 저장될 때마다 재컴파일하게 할 수 있다.

```
$ lessc style.less > ../css/style.css
```

### Post-compile

* less.js 사용할 수 있으며, HTML에 less 화일을 포함해라.
* 프로덕션에는 사용하지 말아야 한다.
* 개발할 때 가장 편리하다.

```js
<!--LESS stylesheets first-->
 
<!---Post-compile LESS to CSS3--->
<script type="text/javascript" src="less.js"></script><script type="text/javascript">// <![CDATA[
less.watch();
// ]]></script>
```

### LESS Elements

LESS 화일은 크로스 브라우저되는 몇몇 유용한 mixin을 포함한다.

  * .gradient
  * .rounded
  * .opacity
  * .box-shadow
  * .inner-shadow

### Minification and compression

프로덕션 사용으로는 CSS 코드를 minimize하고 compress하는 것이 가장 좋다. 코드를 가볍게 만들어 웹 사이트를 더 빠르게 할 것이다. LESS 컴파일러 -x 옵션을 사용하여 minify할 수 있다. -yui-compress 플래그를 사용하여 YUI CSS 컴프레서를 사용하여 컴파일할 수 있다.


    $ lessc -x styles.less &gt; ../css/styles.css
    $ lessc -x --yui-compress styles.less &gt; ../css/styles.css


### LESS 대안

* [SASS: Syntactically Awesome StyleSheets](SASS: Syntactically Awesome StyleSheets)
* SCSS: v2 of SASS
* [Stylus](Stylus)

### Presentation(영문)

* [영문 Less.pdf](https://s3.amazonaws.com/uploads.brianflove.com/wp-content/uploads/2013/01/less.pdf)

### 추가 자료

* [LESS 공식 홈페이지](http://lesscss.org/)
* [개발자 영어 한글 번역 및 강좌](http://opentutorials.org/course/253/1748)


   [1]: http://brianflove.com/2012/10/03/less-tutorial-and-presentation/
   [2]: http://css-tricks.com/poll-results-popularity-of-css-preprocessors/
   [3]: http://uploads.brianflove.com/wp-content/uploads/2012/10/string-variables-in-less.png
   [4]: http://uploads.brianflove.com/wp-content/uploads/2012/10/mixins-in-less.png
   [5]: http://uploads.brianflove.com/wp-content/uploads/2012/10/combinator-in-less.png (&amp;연결자)
   [6]: http://uploads.brianflove.com/wp-content/uploads/2012/10/math-operators-in-less.png
   [7]: http://ko.wikipedia.org/wiki/%EC%83%89_%EA%B3%B5%EA%B0%84 (위키피디어 - 색 공간)
   [8]: http://ko.wikipedia.org/wiki/%EC%83%89_%EB%AA%A9%EB%A1%9D (위키피디어 - 색 목록)
   [9]: http://uploads.brianflove.com/wp-content/uploads/2012/10/color-functions-in-less.png
   [10]: http://uploads.brianflove.com/wp-content/uploads/2012/10/string-interpolation-in-less.png
  