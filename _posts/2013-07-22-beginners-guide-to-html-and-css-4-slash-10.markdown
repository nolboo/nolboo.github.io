---
layout: post
title: "HTML & CSS 초보자 가이드 - 4강 : Typography"
description: "웹 타이포그래피는 최근 몇년 동안 지속적으로 성장해왔다. 사이트에 자신의 웹 폰트를 (얼마나 쉽게) 적용(emded)할 수 있는가가 가장 큰 이유이다."
category: blog
tags: [Beginner, CSS, HTML, typography]
---

<div id="toc"><p class="toc_title">목차</p></div>

원본 : [A Beginner’s Guide to HTML &amp; CSS - LESSON 4 : Typography”][1]

웹 타이포그래피는 최근 몇년 동안 지속적으로 성장해왔다. 이러한 대중적 성장은 몇 가지 이유가 있지만, 웹 사이트에 자신의 웹 폰트를 (얼마나 쉽게) 적용(emded)할 수 있는가가 가장 큰 이유이다.

역자참조링크 :

* [타이포그래피](http://ko.wikipedia.org/wiki/%ED%83%80%EC%9D%B4%ED%8F%AC%EA%B7%B8%EB%9E%98%ED%94%BC)
* [캘리그래피](http://ko.wikipedia.org/wiki/%EC%BA%98%EB%A6%AC%EA%B7%B8%EB%9E%98%ED%94%BC)
* [그라피티](http://ko.wikipedia.org/wiki/%EB%82%99%EC%84%9C)

과거엔 웹사이트에 사용할 수 있는 타입페이스(글꼴)의 수가 작고 한정되어 있었다. 이러한 글꼴들은 컴퓨터에 공통적으로 설치되어 화면에 적절하게 표현된다. 최근에는 임베딩 폰트를 사용할 수 있어 디자이너들이 휠씬 많은 글꼴을 선택할 수 있다.  폰트 임베딩의 문이 새로운 글꼴들에 활짝 열리면서 디자이너들에게 타이포그래피의 기본적인 원칙을 아는 것이 필요하게 되었다. 이러한 기본 원칙을 HTML과 CSS로 변환하는 것은 온라인 타이포그래피와 [텍스트 스타일링][2]의 핵심에 기여한다.

> #### Typeface vs. Font
>
> 타입페이스와 폰트는 자주 혼용해서 사용되기 때문에 혼선을 준다. 아래에 각 용어가 무엇을 뜻하는지와 두 용어가 어떻게 사용되어 컨텍스트를 더하는지 적었다.
>
> **typeface** 는 보이는 것이다. 문자가 어떻게 보이고, 느끼고, 읽히는지에 대한 예술적 인상이다.
>
> **font** 는 타입페이스를 포함하는 화일이다. 컴퓨터에서 하나의 폰트를 사용하는 것은 컴퓨터가 그 타입페이스에 접근할 수 있는 것이다.
>
> 타입페이스와 폰트의 차이는 [노래와 MP3][3]의 차이와 같다. 타입페이스는 예술 작품이라는 측면에서 노래와 매우 유사하다. 한 명의 아티스트나 아티스트들에 의해 만들어지고 해석은 열려있다. 반면에 폰트는 예술적 감상이 아닌 예술적 가치를 전달하는 방법이라는 측면에서 MP3와 매우 유사하다.

## Formatting Content

### Headings

`h1`은 가장 중요한 헤딩이며 나머지 `h2`~`h6`는 `h1`을 지원하고 필요에 따라 여러 번 사용할 수 있다.

### Paragraphs

단락마다 `p` 태그로 둘러싸인 컨텐츠

### Bolding Text

`strong` 엘리먼트는 텍스트를 굵은체로 만들 뿐아니라 문맥적으로도 중요한 텍스트임을 알린다.

### Italicizing Text

`em` 엘리먼트는 텍스트를 기울임체로 만들어 주고 문맥적으로 강조된 중요성을 의미한다.

## Text Color

디자이너나 개발자가 웹사이트를 만들 때 일반적으로 제일 먼저 하는 것이 텍스트 색상과 글꼴을 고르는 것이다. 페이지의 외관이란 측면에서 이 두 가지는 가장 적은 시간에 가장 큰 효과를 줄 수 있다. 브라우저의 디폴트 값을 제거하고 자신만의 텍스트 색상과 글꼴을 사용하여 즉시 페이지의 기조를 정하게 된다.

텍스트 색상을 지정할 때 필요한 유일한 것은 `color` 속성이다. `color` 속성은 하나의 값만 허용된다. 그러나, 형식은 여러가지가 사용되며, 키워드, 16진값, RGB, RGBa, HSL, HSLa 등이 있다. 가장 많이 볼 수 있는 것은 최소의 노력으로 가장 큰 조작을 할 수 있는 16진값([hexadecimal][4])이다.

RGBa값은 투명 색상을 제공하기 때문에 CSS3와 함께 부상하고 있으나, 모든 브라우저에서 지원되지 않기 때문에 16진값 대체(fallback)과 적절하게 사용되어야 한다.

```css
body {
  color: #555;
}
```

> #### Shorthand Hexadecimal Color Values
>
> 16진 색상 값은 숏핸드 값을 사용할 수 있다. 16진 색상은 파운드 기호(#)와 뒤따르는 6개의 문자로 선언된다. 이 문자들은 첫 두 글자, 중간 두 글자, 마지막 두 글자로 두개의 문자씩 짝을 이루는 패턴을 가지고 사용되면서 각각 하나의 특정한 색상을 지정한다. 이러한 패턴은 6개에서 3개로 축약될 수 있다. 예를 들면 `#555555`는 `#555`로 축약될 수 있으며, `#ff6600`은 `#f60`으로, `#ffff00`은 `#ff0` 등으로 축약될 수 있다.

## Font Properties

CSS는 텍스트의 룩앤픽을 편집할 수 있는 수많은 속성을 제공하며, 크게 `font` 기반 속성과 `text` 기반 속성의 두 가지 범주로 나뉜다. 이 범주의 대부분의 속성은 `font-*` 나 `text-*`로 접두될 것이다.

### Font Family

`font-family` 속성은 텍스트가 디스플레이될 때 사용되는 폰트와 대체 폰트를 선언한다. `font-family` 값은 `,`로 구분되는 여러 개의 폰트 이름을 포함한다. 가장 왼쪽에 선언된 첫번째 폰트는 가장 우선적인 폰트이다. 첫번째 폰트를 사용할 수 없다면 왼쪽에서 오른쪽 순으로 선언된 대체 폰트가 사용된다. 두 개이상의 단어로 된 폰트 이름은 인용부호로 감싸져야 한다. 가장 마지막 폰트는 특정 형식의 시스템 디폴트 폰트를 지칭하는 키워드 값이어야 한다.

```css
p {
  font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif;
}
```

### Font Size

`font-size` 속성은 픽셀, em, 퍼센트, 포인트, `font-size` 키워드 등의 [길이값][5]을 사용하여 텍스트의 크기를 지정할 수 있다. 픽셀 값이 점점 더 자주 사용되고 있다. 전에는 사용자가 브라우저 안의 페이지를 확대할 때 상대적으로 확장되는 em과 퍼센트 값이 꽤 인기가 있었다. 최근엔 대부분의 브라우저가 픽셀을 확장할 수 있기 때문에 em과 퍼센트 값을 사용할 필요가 없어졌다.

```css
p {
  font-size: 13px;
}
```

### Font Style

텍스트를 기울이거나 그 반대로 하기위해 `font-style` 속성이 사용된다. `font-style` 속성은 `normal`, `italic`, `oblique`, `inherit` 4가지 키워드 값을 받아들이며, `normal`, `italic`이 가장 대중적으로 사용된다. `italic`은 텍스트를 이탤릭으로 지정할 때 `normal`은 보통으로 되돌릴 때 사용된다.

```css
p {
  font-style: italic;
}
```

### Font Variant

자주는 아니지만 때때로 텍스트를 작은 대문자로 지정할 필요가 있을 때 `font-variant` 속성을 사용한다. `font-variant` 속성은 `normal`, `small-caps`, `inherit`의 3가지 값을 허용한다. 타입페이스가 작은 대문자를 지원하지 않으면 아무런 변화가 없을 것이다. 이 속성을 이용하기 전에 타입페이스 지원여부를 체크해야한다.

```css
p {
  font-variant: small-caps;
}
```

### Font Weight

텍스트를 굵게하거나 굵은 정도를 지정할 때 `font-weight` 속성을 사용한다. 일반적으로 말하면 `font-weight` 속성은 `normal`, `bold`, `bolder`, `lighter`, `inherit`의 키워드 속성 값과 사용된다. 이 중 `bold`와 `normal`이 굵게 바꾸거나 보통으로 되돌릴 때 우선적으로 추천된다.

위의 키워드에 추가하여 `100`, `200`, `300`, `400`, `500`, `600`, `700`, `800`, `900`의 숫자 값이 있다. 굵은 정도를 나타내는 weight의 순서는 가장 가는 `100`에서 가장 두꺼운 `900`으로 확장된다. 이 값들은 normal (`400`)과 bold(`700`) 이상의 여러 weight를 값는 타입페이스와 특별히 관련되므로, 숫자 값을 사용하기 전에 타입페이스가 지원하는 것을 정확히 체크하라. 그렇지 않으면 작동하지 않을 수 있다.

```css
p {
  font-weight: bold;
}
```

### Line Height

줄간격(leading)으로 알려진 두 텍스트 줄 사이의 거리는 `line-height` 속성으로 선언한다. 갸장 읽기 쉬운 `line-height`는 `font-size`의 1.5배이며 `line-height`를 150%로 설정하면 된다. 그러나, 그리드와 작업할 때는 `line-height`를 픽셀로 사용하는 것을 선호할 수 있다.

`line-height`를 엘리먼트의 `height`와 같게 설정하면 텍스트가 수직적 중앙에 위치한다. 버튼, 알림 메시지, 한 줄 텍스트 블럭 등에서 흔히 볼 수 있다.

```css
p {
  line-height: 20px;
}
```

### Shorthand Font Properties

위의 모든 폰트 기반 속성은 하나의 `font` 속성과 [숏핸드 값][6]으로 합칠 수 있다. 속성의 순서는 왼쪽부터 `font-style`, `font-variant`, `font-weight`, `font-size`, `line-height`, `font-family` 순이며, 컴마없이 나열한다.(폰트 이름들은 예외이며 컴마로 나열된다.) `font-size`와 `line-height` 속성값은 값 사이는 /로 나눈다.

`font-size`와 `font-family` 속성값을 제외한 나머지 속성값은 선택적이기 때문에 `font-size`와 `font-family` 값만을 가진 `font` 속성을 종종 볼 수 있다.

```css
p {
  font: italic small-caps bold 13px/20px 'Helvetica Neue',
  Arial, Helvetica, sans-serif;
}
```

### Font Properties Example

###### HTML

```html
<h2><a href="#" title="Sample Blog Post Title">Sample Blog Post Title</a></h2>

<p class="byline">Posted by Shay Howe on February 5th, 2012</p>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla fringilla vehicula nisi vitae rutrum. Donec laoreet, arcu in elementum, dui mi auctor tortor, et lorem massa orci… <a href="#" title="Sample Blog Post Title">Continue reading →</a></p>
```

###### CSS

```css
h2, p {
  color: #555;
  font: 13px/20px Arial, 'Helvetica Neue', 'Lucida Grande', sans-serif;
}
a {
  color: #8ec63f;
}
a:hover {
  color: #f7941d;
}
h2 {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 6px;
}
.byline {
  color: #8c8c8c;
  font-family: Georgia, Times, 'Times New Roman', serif;
  font-style: italic;
}
```

## Text Properties

이제 반 왔다.

### Text Align

텍스트 정렬은 페이지의 리듬과 흐름을 만드는 중요한 부분이며, `text-align` 속성으로 지정한다. `left`, `right`, `center`, `justify`, `inherit`의 5가지 값을 갖는다. `text-align` 속성은 `float` 속성과 혼동하지 말아야 한다. `text-align`의 `left`와 `right` 값은 엘리먼트 안의 텍스트를 정렬하는 반면 `float`의 `left`와 `right` 값은 엘리먼트 전체를 이동시킨다.

```css
p {
  text-align: center;
}
```

### Text Decoration

`text-decoration` 속성은 텍스트를 치장해주며, `none`, `underline`, `overline`, `line-through`, `blink`, `inherit` 키워드 값을 갖는다. 가장 인기있는 사용법은 링크에 밑줄을 치는 것이다. `blink` 값은 극도로 어지럽히므로 추천하지 않는다. 시맨틱적으로 `line-though` 값은 문서에서 제거된 텍스트를 나타내는 `del` 엘리먼트와 정확하지않거나 상관없는 텍스트를 나타내는 `s` 엘리먼트 대신 사용될 수 있다.

```css
p {
  text-decoration: underline;
}
```

### Text Indent

`text-indent` 속성은 텍스트를 안과 밖으로 들여쓸 수 있게 한다.

```css
p {
  text-indent: 20px;
}
```

### Text Shadow

`text-shadow` 속성은 텍스트에 하나 또는 여러 개의 그림자를 추가할 수 있게 한다. 4개의 값들이 왼쪽에서 오른쪽 순으로 나열되어야 한다. 처음 3개 값은 길이이며 마지막 값은 색상이다. 3개의 길이 값 중 첫번째는 그림자의 horizontal offset, 두번째는 vertical offset, 세번째는 blur radius를 결정한다. 네번째 즉, 마지막 값은 그림자의 색상이며, `color` 속성에서 사용되는 모든 컬러 값을 사용할 수 있다.

여러 개의 텍스트 그림자들은 컴마로 구분된다.

```css
p {
  text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
}
```

### Text Transform

`text-transform`은 `font-variant` 속성과 유사하다. `font-variant`는 타입페이스의 작은 대문자를 가져오지만 `text-transform` 속성은 인라인으로 텍스트를 변경한다. `none`, `capitalize`, `uppercase`, `lowercase`, `inherit` 값을 갖는다.

`capitalize` 값은 각 단어의 첫번째 글자를 대문자로 만들고, `uppercase` 값은 모든 글자를 대문자로 만들며, `lowercase`는 모든 문자를 소문자로 만든다. `none`은 상속되는 값을 없애고 디폴트 값으로 되돌린다.

```css
p {
  text-transform: uppercase;
}
```

### Letter Spacing

`letter-spacing` 속성으로 페이지의 글자 간격을 조정할 수 있다. `none` 속성은 자간을 보통 거리로 되돌린다.

```css
p {
  letter-spacing: -.5em;
}
```

역자참조링크 : [1em은 현재 사용되는 글꼴의 16포인트 크기의 대문자 “M”의 넓이](http://j.mp/17oGhiK)

### Word Spacing

단어들의 간격을 조정할 수 있다.

```css
p {
  word-spacing: .25em;
}
```

### Text Properties Example

###### HTML

```html
<h2><a href="#" title="Sample Blog Post Title">Sample Blog Post Title</a></h2>

<p class="byline">Posted by Shay Howe on February 5th, 2012</p>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla fringilla vehicula nisi vitae rutrum. Donec laoreet, arcu in elementum, dui mi auctor tortor, et lorem massa orci… <a href="#" title="Sample Blog Post Title">Continue reading →</a></p>
```

###### CSS

```css
h2, p {
  color: #555;
  font: 13px/20px Arial, 'Helvetica Neue', 'Lucida Grande', sans-serif;
}
a {
  color: #8ec63f;
}
a:hover {
  color: #f7941d;
}
h2 {
  font-size: 22px;
  font-weight: bold;
  letter-spacing: -.9px;
  margin-bottom: 6px;
}
h2 a {
  text-shadow: 1px 1px 0 #75a334;
}
h2 a:hover {
  text-shadow: 1px 1px 0 #d48019;
}
p {
  text-indent: 15px;
}
.byline {
  color: #8c8c8c;
  font-family: Georgia, Times, 'Times New Roman', serif;
  font-style: italic;
  text-indent: 0;
}
p a {
  font-size: 11px;
  font-weight: bold;
  text-decoration: underline;
  text-transform: uppercase;
}
```

## Web Safe Fonts

모든 컴퓨터, 태블릿, 폰 혹은 브라우징이 가능한 기기에는 디폴트로 미리 설치된 몇 개의 특정 폰트들이 있다. 모든 기기에 설치되면 폰트들은 온라인에서 무료로 사용될 수 있으며 브라우저 기기와 상관없이 적절하게 보여질 것이다. 이러한 폰트들이 “web safe fonts.”이다. 그 목록은 아래와 같다.

  * Arial
  * Courier New, Courier
  * Garamond
  * Georgia
  * Lucida Sans, Lucida Grande, Lucida
  * Palatino Linotype
  * Tahoma
  * Times New Roman ,Times
  * Trebuchet
  * Verdana

## Embedding Web Fonts

최근에 web safe fonts에 대한 대안이 뜨고있다. 이제는 폰트를 서버에 업로드하여 CSS `@font-face` 속성을 통해 웹사이트에 포함시킬 수 있다. 이것은 온라인 타이포그래피에 경이로운 일이며, 이제 활자가 온라인으로 올라왔다.

```css
@font-face {
  font-family: 'Bryant Normal';
  src: url('bryant-normal.eot');
  src: url('bryant-normal.eot') format('embedded-opentype'),
       url('bryant-normal.woff') format('woff'),
       url('bryant-normal.ttf') format('truetype'),
       url('bryant-normal.svg') format('svg');
}
body {
  font-family: 'Bryant Normal', 'Helvetica Neue', Arial, Helvetica, sans-serif;
}
```

그러나 몇 가지 작은 함정이 있다. 웹사이트에 모든 타입페이스를 사용할 수 있다는 것이 합법적인 권리를 승인받았다는 것을 의미하지는 않는다. 타입페이스는 예술 작품이므로 그것을 라이센스 없이 서버에 올릴 수 없다.

다행히 새로운 타입페이스의 가치가 인식되고 회사들이 웹사이트에 새로운 폰트들을 라이센스하여 포함할 수 있도록 하고 있다. [Typekit][7]과 [Fontdeck][8]과 같은 회사들은 폰트 라이센싱을 서브스크립션 모델로 팔고있고, [Google Fonts][9]는 무료로 폰트를 라이센싱하고 있다.

또 다른 함정은 브라우저 지원이다. `@font-face` 속성은 오래된 브라우저에서 지원되지 않을 수 있다. 다행히 폰트를 사용할 때 `font-family` 속성에서 대체 폰트를 지정할 수 있다.

## Citations &amp; Quotes

`cite`, `q`, `blockquote` 엘리먼트를 사용한다.

`cite` 엘리먼트는 a title of work를 참조할 때 사용되고, `q` 엘리먼트는 짧은 인라인 인용에, `blockquote`는 더 길고 외부 인용에 사용된다.

### Citing a Title of Work

`cite` 엘리먼트는 `cite` 속성과 혼동하지 말아야 한다. **element**는 시맨틱 문맥을 제공하고 **attribute**는 참조 소스로서 URI 값을 가진다. `cite` 엘리먼트는 특별히 a title of work을 위해 예약되어 있으며 소스와 관련된 다른 컨텍스트를 포함하지 말아야 한다. A title of work는 하나의 책, 영화, 노래 등이다. 관련된 원본 소스의 하이퍼링크를 포함할 수 있다.

```html
<p><cite><a href="http://www.amazon.com/Steve-Jobs-Walter-Isaacson/dp/1451648537" title="Steve Jobs">Steve Jobs</a></cite> by Walter Isaacson is truly inspirational.</p>
```

> #### Citing a Title of Work Demo
>
> [Steve Jobs][10] by Walter Isaacson is truly inspirational.

### Dialog & Prose Quotation

`q` 엘리먼트는 대화나 문장을 시맨틱하게 지정할 때 사용되며 다른 인용 목적으로 사용되지 말아야 한다.


    Steve Jobs once said, “One home run is much better than two doubles.”


### Dialog &amp; Prose Citation

`q` 엘리먼트에서 선택적으로 사용하는 속성은 `cite` 속성이다. `cite` 속성은 URI를 인용부호로 감싸는 형태이다. 이 속성은 엘리먼트의 외양을 변화시키지 않으며, 단순히 스크린 리더와 같은 기기에 가치를 제공한다. 속성은 브라우저 내에서 볼 수 없기 때문에 가능하다면 소스를 포함한 하이퍼링크를 제공하는 것이 추천된다.

```html
<p>Steve Jobs once said, <q>“One home run is much better than two doubles.”</q></p>
```

### External Quotation

커다란 텍스트 블럭을 인용하기 위해, 외부 소스와 여러 줄을 차지하는 `blockquote` 엘리먼트가 사용된다. `blockquote`는 헤딩과 단락 등의 다른 블럭 레벨 엘리먼트를 포함할 수 있는 블럭 레벨 엘리먼트이다.

```html
<blockquote>
  <p>“In most people’s vocabularies, design is a veneer. It’s interior decorating. It’s the fabric of the curtains, of the sofa. But to me, nothing could be further from the meaning of design. Design is the fundamental soul of a human-made creation that ends up expressing itself in successive outer layers of the product.”</p>
  <p>— Steve Jobs in Fortune Magazine</p>
</blockquote>
```

### External Citation

`blockquote` 엘리먼트 안에서 사용된 긴 인용들은 항상 인용처를 포함해야 한다. 이 인용처는 저자와 소스처럼 지극히 단순할 수 있으나 여러 개의 인용처와 추가 적인 레퍼런스를 위한 링크를 포함하는 훨씬 많은 정보일 수 있다.

`cite` 속성은 `blockquote` 엘리먼트 안에 포함될 수 있으며, `cite` 엘리먼트는 인용문 다음에 위치하여 관련된 title of work을 지정하는 것을 도울 수 있다.

`cite` 속성과 `cite` 엘리먼트는 순수하게 시맨틱하고 유저에게 어떠한 시각적인 참조를 추가하지 않기에 하이퍼링크가 선호된다. These hyperlinks should highlight both the origin of the quote (author, artist, etcetera) and the title of work in which it first appeared.

```html
<blockquote cite="http://money.cnn.com/magazines/fortune/
fortune_archive/2000/01/24/272277/index.htm">
  <p>“In most people’s vocabularies, design is a veneer. It’s interior decorating. It’s the fabric of the curtains, of the sofa. But to me, nothing could be further from the meaning of design. Design is the fundamental soul of a human-made creation that ends up expressing itself in successive outer layers of the product.”</p>
  <p>— <a href="http://en.wikipedia.org/wiki/Steve_Jobs" title="Steve Jobs">Steve Jobs</a> in <cite><a href="http://money.cnn.com/magazines/fortune/fortune_archive/2000/01/24/272277/index.htm" title="Apple's One-Dollar-a-Year Man">Fortune Magazine</a></cite></p>
</blockquote>
```

#### Automating Quotation Marks with CSS

HTML에 인용부호를 추가하기 보다는 CSS에서 자동으로 추가하는 방법이 있다. 예전에는 브라우저의 언어 지원 때문에 CSS에서 적절하게 표현되지 못했지만 최근 브라우저의 언어 지원이 더 좋아졌다.

아래는 `q` 엘리먼트에 `before`, `after` 가상엘리먼트와 속성을 이용하여 인용부호를 추가하는 방법이다. 좀 더 자세한 것은 [가상 엘리먼트][11] 와 [인용부호 사용하는 방법][12].

```css
    q {
      quotes: '“' '”' '‘' '’';
    }
    q:before {
      content: '“';
      content: open-quote;
    }
    q:after {
      content: '”';
      content: close-quote;
    }
```

## Resources & Links

* [Text styling with CSS](http://dev.opera.com/articles/view/29-text-styling-with-css/) via Dev.Opera
* [Quoting and citing with blockquote, q, cite, and the cite attribute](http://html5doctor.com/blockquote-q-cite/) via HTML5 Doctor
* [CSS Font Shorthand Property Cheat Sheet](http://www.impressivewebs.com/css-font-shorthand-property-cheat-sheet/) via Impressive Webs
* [The Elements of Typographic Style](http://www.amazon.com/Elements-Typographic-Style-Robert-Bringhurst/dp/0881791326) by Robert Bringhurst

### 역자참조링크

* [What is typography? Learn the basic rules and terms of type!](http://www.creativebloq.com/typography/what-is-typography-123652)

   [1]: http://learn.shayhowe.com/html-css/typography
   [2]: http://dev.opera.com/articles/view/29-text-styling-with-css/
   [3]: http://fontfeed.com/archives/font-or-typeface/ (Font or Typeface?)
   [4]: http://www.quackit.com/css/css_color_codes.cfm
   [5]: http://css-tricks.com/css-font-size/
   [6]: http://www.impressivewebs.com/css-font-shorthand-property-cheat-sheet/
   [7]: https://typekit.com/
   [8]: http://fontdeck.com/
   [9]: http://www.google.com/webfonts
   [10]: http://www.amazon.com/Steve-Jobs-Walter-Isaacson/dp/1451648537
   [11]: http://css-tricks.com/pseudo-element-roundup/
   [12]: http://html5doctor.com/blockquote-q-cite/
  