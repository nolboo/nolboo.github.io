---
layout: post
title: "모든 디자이너와 프런트 개발자가 숙달하고 있어야할 CSS 스니핏 50"
description: "웹 프로들에게 편리한 50개의 편리한 CSS2/CCS3 코드 스니핏으로 기본적인 것에서부터 작고 큰 내용을 알려주는 영문의 번역"
category: blog
tags : [CSS, snippet]
---

원본 : [50 Useful CSS Snippets Every Designer Should Have][1]

[Complete Guide To Cross-Browser Compatibility Check][2]

![][3]

이 기사가 모든 웹 프로들에게 **50개의 편리한 CSS2/CCS3 코드 스니핏을** 선물하기를 바란다.

#### 1. CSS Resets

```css
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
  font: inherit;
  vertical-align: baseline;
  outline: none;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
html { height: 101%; }
body { font-size: 62.5%; line-height: 1; font-family: Arial, Tahoma, sans-serif; }

article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section { display: block; }
ol, ul { list-style: none; }

blockquote, q { quotes: none; }
blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }
strong { font-weight: bold; }

table { border-collapse: collapse; border-spacing: 0; }
img { border: 0; max-width: 100%; }

p { font-size: 1.2em; line-height: 1.0em; color: #333; }
```

[에릭 마이어의 리셋 코드][4]를커스터마이징한 스니핏이다. 반응형 이미지에 대한 추가하고 모든 핵심 엘리먼트에 **border-box**를 설정하고, 마진과 패딩 수치가 알맞게 정렬되게 한다.

#### 2. Classic CSS Clearfix

```css
.clearfix:after { content: "."; display: block; clear: both; visibility: hidden; line-height: 0; height: 0; }
.clearfix { display: inline-block; }

html[xmlns] .clearfix { display: block; }
* html .clearfix { height: 1%; }
```

이 clearfix 코드는 정통한 웹 개발자들 사이에 몇년 간 돌아다닌 것이다. 플로팅된 엘리먼트를 담는 컨테이너에 이 클래스를 적용해야한다. 뒤에 오는 어떤 컨텐츠도 **플로트되지 않아 끌어내려지지 않고 명확해질 것이다.**

#### 3. 2011 Updated Clearfix

```css
.clearfix:before, .container:after { content: ""; display: table; }
.clearfix:after { clear: both; }

/* IE 6/7 */
.clearfix { zoom: 1; }
```

새 버전과 클래식 버전 간의 주요 렌더링 차이점을 말할 수는 없지만 두 버전 모두 플로트를 효과적으로 지울 것이며, IE 6~8을 포함한 모든 최신 브라우저에서 작동할 것이다.

#### 4. Cross-Browser Transparency

```css
.transparent {
    filter: alpha(opacity=50); /* internet explorer */
    -khtml-opacity: 0.5;      /* khtml, old safari */
    -moz-opacity: 0.5;       /* mozilla, netscape */
    opacity: 0.5;           /* fx, safari, opera */
}
```

_[Code Source][5]_

모든 곳에 적용하고 싶어지는 CSS3 속성 중 하나인 불투명도(opacity)를 **필터 속성을 추가해서** IE의 예전 버전에서도 우아하게 다룰 수 있다.

#### 5. CSS Blockquote Template

```css
blockquote {
    background: #f9f9f9;
    border-left: 10px solid #ccc;
    margin: 1.5em 10px;
    padding: .5em 10px;
    quotes: "\201C""\201D""\2018""\2019";
}
blockquote:before {
    color: #ccc;
    content: open-quote;
    font-size: 4em;
    line-height: .1em;
    margin-right: .25em;
    vertical-align: -.4em;
}
blockquote p {
    display: inline;
}
```

_[Code Source][6]_

**블로그나 웹페이지에서 인용되거나 반복되는 컨텐츠를 분리하기 위해** HTML 엘리먼트에 아주 훌륭한 코드라고 생각한다.

#### 6. Individual Rounded Corners

```css
#container {
    -webkit-border-radius: 4px 3px 6px 10px;
    -moz-border-radius: 4px 3px 6px 10px;
    -o-border-radius: 4px 3px 6px 10px;
    border-radius: 4px 3px 6px 10px;
}

/* alternative syntax broken into each line */
#container {
    -webkit-border-top-left-radius: 4px;
    -webkit-border-top-right-radius: 3px;
    -webkit-border-bottom-right-radius: 6px;
    -webkit-border-bottom-left-radius: 10px;

    -moz-border-radius-topleft: 4px;
    -moz-border-radius-topright: 3px;
    -moz-border-radius-bottomright: 6px;
    -moz-border-radius-bottomleft: 10px;
}
```

**모서리 각각에 다른 값을 설정하고 싶을 경우** 이 코드 스니핏을 사용해라. 숏버전과 롱버전을 같이 포함하였다.

#### 7. General Media Queries(범용 미디어 쿼리)

```css
/* Smartphones (portrait and landscape) ----------- */
@media only screen
and (min-device-width : 320px) and (max-device-width : 480px) {
  /* Styles */
}

/* Smartphones (landscape) ----------- */
@media only screen and (min-width : 321px) {
  /* Styles */
}

/* Smartphones (portrait) ----------- */
@media only screen and (max-width : 320px) {
  /* Styles */
}

/* iPads (portrait and landscape) ----------- */
@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
  /* Styles */
}

/* iPads (landscape) ----------- */
@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
  /* Styles */
}

/* iPads (portrait) ----------- */
@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) {
  /* Styles */
}

/* Desktops and laptops ----------- */
@media only screen and (min-width : 1224px) {
  /* Styles */
}

/* Large screens ----------- */
@media only screen and (min-width : 1824px) {
  /* Styles */
}

/* iPhone 4 ----------- */
@media only screen and (-webkit-min-device-pixel-ratio:1.5), only screen and (min-device-pixel-ratio:1.5) {
  /* Styles */
}
```

_[Code Source][7]_

위의 소스에서 얻을 수 있는 아주 훌륭한 템플릿이어서 몽땅 복사해왔다. 이 코드는 `min-device-pixel-ratio`을 사용해 레티나 베이스 기기도 목표로 할 수도 있다.

#### 8. Modern Font Stacks(최신 폰트 스택 모음)

```css
/* Times New Roman-based serif */
font-family: Cambria, "Hoefler Text", Utopia, "Liberation Serif", "Nimbus Roman No9 L Regular", Times, "Times New Roman", serif;

/* A modern Georgia-based serif */
font-family: Constantia, "Lucida Bright", Lucidabright, "Lucida Serif", Lucida, "DejaVu Serif," "Bitstream Vera Serif", "Liberation Serif", Georgia, serif;

/*A more traditional Garamond-based serif */
font-family: "Palatino Linotype", Palatino, Palladio, "URW Palladio L", "Book Antiqua", Baskerville, "Bookman Old Style", "Bitstream Charter", "Nimbus Roman No9 L", Garamond, "Apple Garamond", "ITC Garamond Narrow", "New Century Schoolbook", "Century Schoolbook", "Century Schoolbook L", Georgia, serif;

/*The Helvetica/Arial-based sans serif */
font-family: Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;

/*The Verdana-based sans serif */
font-family: Corbel, "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", "Bitstream Vera Sans", "Liberation Sans", Verdana, "Verdana Ref", sans-serif;

/*The Trebuchet-based sans serif */
font-family: "Segoe UI", Candara, "Bitstream Vera Sans", "DejaVu Sans", "Bitstream Vera Sans", "Trebuchet MS", Verdana, "Verdana Ref", sans-serif;

/*The heavier "Impact" sans serif */
font-family: Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", sans-serif;

/*The monospace */
font-family: Consolas, "Andale Mono WT", "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", "DejaVu Sans Mono", "Bitstream Vera Sans Mono", "Liberation Mono", "Nimbus Mono L", Monaco, "Courier New", Courier, monospace;
```

_[Code Source][8]_

새로운 웹페이지를 디자인할 때 자신만의 CSS 폰트 스택을 브레인스토밍하는 것은 어렵다. 이 스니핏이 고민을 덜어 시작하기 위한 템플릿들이 되길 바란다. 더 많은 예를 원한다면 내가 좋아하는 리소스 중 하나인 [CSS Font Stack][9]을 확인해라.

#### 9. Custom Text Selection(하일라이트 색상 변경)

```css
::selection { background: #e2eae2; }
::-moz-selection { background: #e2eae2; }
::-webkit-selection { background: #e2eae2; }
```

몇몇 최신 웹 브라우저는 웹페이지의 하일라이트 색상을 정의할 수 있다. **이 (원본)페이지는 light blue가 디폴트로 되어있다.** 이 스니핏은 웹킷과 모질라의 업체 접두어(vendor prefixes)와 함께하는 전형적인 `::selection`을 포함한다.

#### 10. Hiding H1 Text for Logo(로고의 H1 텍스트 숨기기)

```css
h1 {
    text-indent: -9999px;
    margin: 0 auto;
    width: 320px;
    height: 85px;
    background: transparent url("images/logo.png") no-repeat scroll;
}
```

이 기술이 오래된 [Digg layout][10]에서 적용된 것을 맨 먼저 알았었다. 웹사이트 이름을 SEO 목적으로 순수 텍스트로 주어서 H1 태그를 배치할 수 있다. CSS로 **이 텍스트를 보이지 않게 움직이고 로고 이미지로 대치할 수 있다.**

#### 11. Polaroid Image Border(폴라로이드형 이미지 테두리)

```css
img.polaroid {
    background:#000; /*Change this to a background image or remove*/
    border:solid #fff;
    border-width:6px 6px 20px 6px;
    box-shadow:1px 1px 5px #333; /* Standard blur at 5px. Increase for more depth */
    -webkit-box-shadow:1px 1px 5px #333;
    -moz-box-shadow:1px 1px 5px #333;
    height:200px; /*Set to height of your image or desired div*/
    width:200px; /*Set to width of your image or desired div*/
}
```

_[Code Source][11]_

이 기본 스니핏으로 이미지에 **폴라로이드** 클래스를 적용할 수 있으며, **큰 백색 경계선과 약간의 박스 그림자와 함께 오래된 사진 스타일을 만들 것이다.** 이미지 차원과 웹사이트 레이아웃에 어울리게 너비/높이 값을 변경할 수 있다.

#### 12. Anchor Link Pseudo Classes(초심자용 앵커 링크)

```css
a:link { color: blue; }
a:visited { color: purple; }
a:hover { color: red; }
a:active { color: yellow; }
```

_[Code Source][12]_

대부분의 CSS 개발자는 앵커 링크 스타일과 `:hover` 효과를 알고있으나, 초심자들은 이 코드 스니핏을 참조로서 사용하길 권한다. 앵커 링크와 다른 HTML 엘리먼트 몇 개에 네 가지 기본 상태를 준다.

#### 13. Fancy CSS3 Pull-Quotes(멋진 별도 인용)

```css
.has-pullquote:before {
    /* Reset metrics. */
    padding: 0;
    border: none;

    /* Content */
    content: attr(data-pullquote);

    /* Pull out to the right, modular scale based margins. */
    float: right;
    width: 320px;
    margin: 12px -140px 24px 36px;

    /* Baseline correction */
    position: relative;
    top: 5px;

    /* Typography (30px line-height equals 25% incremental leading) */
    font-size: 23px;
    line-height: 30px;
}

.pullquote-adelle:before {
    font-family: "adelle-1", "adelle-2";
    font-weight: 100;
    top: 10px !important;
}

.pullquote-helvetica:before {
    font-family: "Helvetica Neue", Arial, sans-serif;
    font-weight: bold;
    top: 7px !important;
}

.pullquote-facit:before {
    font-family: "facitweb-1", "facitweb-2", Helvetica, Arial, sans-serif;
    font-weight: bold;
    top: 7px !important;
}
```

_[Code Source][13]_

Pull-quote는 블로그와 뉴스 기사의 옆쪽으로 떨여져 보이게되어blockquotes와는 다르다. 종종 기사에서 인용된 텍스트를 언급하며 blockquote와는 약간 다르게 보인다. 이 기본 클래스는 3개의 폰트패밀리를 포함했으니 적용할 때는 하나만 선택하라.

#### 14. Fullscreen Backgrounds with CSS3

```css
html {
    background: url('images/bg.jpg') no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
```

_[Code Source][14]_

이 코드는 CSS3 문접을 지원하지 않는 오래된 브라우저에서는 잘 동작하지 않는다. 그러나, 오랜 브라우저 지원을 신경쓰지 않고 빠른 해법을 원한다면 최고다! **웹 사이트 배경에 커다란 사진을 추가하고도 크기 변경과 스크롤에도 잘 유지되어 훌륭한 코드다.**

#### 15. Vertically Centered Content(수직적 중앙 정렬)

```css
.container {
    min-height: 6.5em;
    display: table-cell;
    vertical-align: middle;
}
```

_[Code Source][15]_

`margin: 0 auto` 기술을 사용하여 컨텐츠를 페이지의 수평적 중앙에 끼워넣는 것은 매우 쉽다. 그러나 수직 컨텐츠는 훨씬 더 어렵다. 이것은 자바스크립트없이도 완벽하게 작동하는 순수 CSS 해법이다.

#### 16. Force Vertical Scrollbars(수직 스크롤바 강제)

```css
html { height: 101% }
```

페이지 컨텐츠가 브라우저 창의 전체 높이를 채우지 않는다면 결국 스크롤바를 얻지 못한다. 이 스니핏은 스크롤바가 항상 남도록 HTML 엘리먼트가 브라우저보다 아주 약간 높도록 해준다.

#### 17. CSS3 Gradients Template

```css
#colorbox {
    background: #629721;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#83b842), to(#629721));
    background-image: -webkit-linear-gradient(top, #83b842, #629721);
    background-image: -moz-linear-gradient(top, #83b842, #629721);
    background-image: -ms-linear-gradient(top, #83b842, #629721);
    background-image: -o-linear-gradient(top, #83b842, #629721);
    background-image: linear-gradient(top, #83b842, #629721);
}
```

CSS3 그라디언트는 새로운 스펙의 놀라운 부분 중 하나다. 많은 업체 접두어가 기억하기 힘들며, 이 코드 스니핏이 프로젝트 시간을 줄여줄 것이다.

#### 18. @font-face Template

```css
@font-face {
    font-family: 'MyWebFont';
    src: url('webfont.eot'); /* IE9 Compat Modes */
    src: url('webfont.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
    url('webfont.woff') format('woff'), /* Modern Browsers */
    url('webfont.ttf')  format('truetype'), /* Safari, Android, iOS */
    url('webfont.svg#svgFontName') format('svg'); /* Legacy iOS */
}

body {
    font-family: 'MyWebFont', Arial, sans-serif;
}
```

_[Code Source][16]_

여기 기억하기 힘든 CSS3가 또 있다. `@font-face`를 사용하여 자신의 TTF/OTF/SVG/WOFF 파일을 웹사이트에 끼워넣고 별도의 폰트 패밀리를 만들어낼 수 있다. 향후 프로젝트의 기본예제로 이 템플릿을 사용하라.

#### 19. Stitched CSS3 Elements

```css
p {
    position:relative;
    z-index:1;
    padding: 10px;
    margin: 10px;
    font-size: 21px;
    line-height: 1.3em;
    color: #fff;
    background: #ff0030;
    -webkit-box-shadow: 0 0 0 4px #ff0030, 2px 1px 4px 4px rgba(10,10,0,.5);
    -moz-box-shadow: 0 0 0 4px #ff0030, 2px 1px 4px 4px rgba(10,10,0,.5);
    box-shadow: 0 0 0 4px #ff0030, 2px 1px 6px 4px rgba(10,10,0,.5);
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}

p:before {
    content: "";
    position: absolute;
    z-index: -1;
    top: 3px;
    bottom: 3px;
    left :3px;
    right: 3px;
    border: 2px dashed #fff;
}

p a {
    color: #fff;
    text-decoration:none;
}

p a:hover, p a:focus, p a:active {
    text-decoration:underline;
}
```

_[Code Source][17]: 사이트 운영 안함_

  * 역자추가링크 : [Create cool stitched effects with CSS3](http://www.techrepublic.com/blog/web-designer/create-cool-stitched-effects-with-css3/1964/)

#### 20. CSS3 Zebra Stripes(얼룩말 줄무늬)

```css
tbody tr:nth-child(odd) {
    background-color: #ccc;
}
```

_[Code Source][18]_

얼룩말 줄무늬를 포함하는 것은 데이타 표 안에서 가장 많이 사용된다. 사용자가 40 혹은 50개의 열을 훑어 볼 때 어느 셀이 어느 열에 속하는지 정확히 구별하기가 어렵다. 기본으로 얼룩말 줄무늬를 추가해서 홀수 열의 백그라운드 색상을 변화를 줄 수 있다.

#### 21. Fancy Ampersand(근사한 `&amp;`)

```css
.amp {
    font-family: Baskerville, 'Goudy Old Style', Palatino, 'Book Antiqua', serif;
    font-style: italic;
    font-weight: normal;
}
```

_[Code Source][19]_

이 클래스는 페이지 내용에서 `&amp;` 기호 주위를 감싸는 `span` 엘리먼트를 적용한다. 고전적인 세리프 폰트와 `&amp;` 기호를 강하게 보여주기 위한 이탤릭체가 적용될 것이다.

#### 22. Drop-Cap Paragraphs(문단의 큰 첫글자)

```css
p:first-letter{
    display: block;
    margin: 5px 0 0 5px;
    float: left;
    color: #ff3366;
    font-size: 5.4em;
    font-family: Georgia, Times New Roman, serif;
}
```

신문과 책 같은 인쇄된 매체에선 일반적으로 크게 처리된 문단의 첫글자를 일반적으로 볼 수 있다. 웹과 블로그에서도 레이아웃 안에 충분한 여기가 있다면 단정한 효과를 줄 수 있다. 이 CSS 규칙은 모든 문단을 목표로 하고 있으나 특정 한 클래스나 ID로 제한할 수도 있다.

#### 23. Inner CSS3 Box Shadow(안쪽 박스 그림자)

```css
-moz-box-shadow: inset 2px 0 4px #000;
-webkit-box-shadow: inset 2px 0 4px #000;
box-shadow: inset 2px 0 4px #000; }
```

박스 그림자 속성은 웹사이트를 만드는 방법에 굉장한 변화를 주었다. 거의 모든 엘리먼트에 박스 그림자를 그릴 수 있고 모두 훌륭하게 보인다. 이 코드는 디자인하기가 훨씬 더 어렵지만 제대로된 경우 청순하게 보이는 안쪽 그림자를 만들 것이다.

#### 24. Outer CSS3 Box Shadow(바깥쪽 박스 그림자)

```css
#mydiv {
    -webkit-box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.52);
    -moz-box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.52);
    box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.52);
}
```

바깥쪽 CSS3 그림자의 세번째 숫자는 흐리는 거리(blur)을 나타내고 4번째 숫자는 그림자 크기(spread)를 나타낸다. 이 값들은 [W3Schools][20]에서 더 많이 배울 수 있다.

#### 25. Triangular List Bullets(삼각형 글머리 기호)

```css
ul {
    margin: 0.75em 0;
    padding: 0 1em;
    list-style: none;
}
li:before {
    content: "";
    border-color: transparent #111;
    border-style: solid;
    border-width: 0.35em 0 0.35em 0.45em;
    display: block;
    height: 0;
    width: 0;
    left: -1em;
    top: 0.9em;
    position: relative;
}
```

_[Code Source][21]_

믿거나 말거나 실제로 **CSS3만으로 삼각형 글머리 기호를 만들어 낼 수 있다.** 평판있는 브라우저에서 아주 멋지게 보이는 쿨한 기술이다. 유일한 잠재적인 이슈는 대체(fallback) 방법이 없다는 것이다.

#### 26. Centered Layout Fixed Width(고정폭 중앙 정렬 레이아웃)

```css
#page-wrap {
    width: 800px;
    margin: 0 auto;
}
```

_[Code Source][22]_

고정폭 레이아웃에 완벽한 **수평 배치 스니핏**이다.

#### 27. CSS3 Column Text(CSS3 텍스트 열)

```css
#columns-3 {
    text-align: justify;
    -moz-column-count: 3;
    -moz-column-gap: 12px;
    -moz-column-rule: 1px solid #c4c8cc;
    -webkit-column-count: 3;
    -webkit-column-gap: 12px;
    -webkit-column-rule: 1px solid #c4c8cc;
}
```

_[Code Source][23]_

CSS3 `columns`은 컬럼(열) 형식으로 텍스트를 분할할 수 있다. 이 스니핏을 사용하여 단락을 원하는 개수의 컬럼으로 나눌 수 있다.

#### 28. CSS Fixed Footer(고정 푸터)

```css
#footer {
    position: fixed;
    left: 0px;
    bottom: 0px;
    height: 30px;
    width: 100%;
    background: #444;
}

/* IE 6 */
* html #footer {
    position: absolute;
    top: expression((0-(footer.offsetHeight)%2B(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)%2B(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))%2B'px');
}
```

_[Code Source][24]_

웹사이트에 고정 푸터를 매다는 것은 아주 쉽다. 유저의 스크롤을 따니면서 사이트에 도움이 되는 정보 혹은 상세한 연락처를 보여줄 것이다. 이상적으론 유저 인터페이스에 실제로 가치가 있는 경우에만 적용될 것이다.

#### 29. Transparent PNG Fix for IE6(IE6용 투명 PNG 교정)

```css
.bg {  
    width:200px;  
    height:100px;  
    background: url(/folder/yourimage.png) no-repeat;  
    _background:none;  
    _filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/folder/yourimage.png',sizingMethod='crop');  
}  
  
  
/* 1px gif method */  
img, .png {  
    position: relative;  
    behavior: expression((this.runtimeStyle.behavior="none")&&(this.pngSet?this.pngSet=true:(this.nodeName == "IMG" && this.src.toLowerCase().indexOf('.png')>-1?(this.runtimeStyle.backgroundImage = "none",  
       this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.src + "', sizingMethod='image')",  
       this.src = "images/transparent.gif"):(this.origBg = this.origBg? this.origBg :this.currentStyle.backgroundImage.toString().replace('url("','').replace('")',''),  
       this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.origBg + "', sizingMethod='crop')",  
       this.runtimeStyle.backgroundImage = "none")),this.pngSet=true));  
}
```

_[Code Source][25]_

웹사이트에 투명한 이미지를 사용하는 것은 매우 일반적인 일이다. gif 이미지로 시작되어 알파 투명 PNG로 진화해왔다. 불행히 아주 오랜 버전의 IE는 투명도를 전혀 지원하지 않는다. 이 CSS 스니핏이 문제를 해결해줄 것이다.

#### 30. Cross-Browser Minimum Height

```css
#container {
    min-height: 550px;
    height: auto !important;
    height: 550px;
}
```

많은 최신 브라우저는 `min-height`를 완벽하게 다루어주나, IE와 오래된 Firefox는 문제가 있다. 이 코드 세트는 관련된 어떤 버그에도 교정해줄 것이다.

#### 31. CSS3 Glowing Inputs(빛나는 Input 엘리먼트)

```css
input[type=text], textarea {  
    -webkit-transition: all 0.30s ease-in-out;  
    -moz-transition: all 0.30s ease-in-out;  
    -ms-transition: all 0.30s ease-in-out;  
    -o-transition: all 0.30s ease-in-out;  
    outline: none;  
    padding: 3px 0px 3px 3px;  
    margin: 5px 1px 3px 0px;  
    border: 1px solid #ddd;  
}  
   
input[type=text]:focus, textarea:focus {  
    box-shadow: 0 0 5px rgba(81, 203, 238, 1);  
    padding: 3px 0px 3px 3px;  
    margin: 5px 1px 3px 0px;  
    border: 1px solid rgba(81, 203, 238, 1);  
}  
```

_[Code Source][26]_

크롬과 사파리 유저는 폼에서 인풋 외곽선이 거슬리다는 것을 안다. 스타일 시트에 이 스니핏을 넣으면 기본 인풋 엘리먼트를 완전히 새로운 디자인으로 만들어줄 것이다.

#### 32. Style Links Based on Filetype(화일 형식에 따른 링크 스타일링)

```css
/* external links */
a[href^="http://"] {
    padding-right: 13px;
    background: url('external.gif') no-repeat center right;
}

/* emails */
a[href^="mailto:"] {
    padding-right: 20px;
    background: url('email.png') no-repeat center right;
}

/* pdfs */
a[href$=".pdf"] {
    padding-right: 18px;
    background: url('acrobat.png') no-repeat center right;
}
```

_[Code Source][27]_

CSS 실렉터와 백그라운드 이미지 아이콘을 사용하여 링크의 화일 형식을 결정할 수 있다. 다양한 프로토콜(HTTP, FTP, IRC, mailto) 혹은 단순히 화일 형식 자체(mp3, avi, pdf)를 포함할 수 있다.

#### 33. Force Code Wraps(코드 줄바꿈 강제)

```css
pre {
    white-space: pre-wrap;       /* css-3 */
    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
    white-space: -pre-wrap;      /* Opera 4-6 */
    white-space: -o-pre-wrap;    /* Opera 7 */
    word-wrap: break-word;       /* Internet Explorer 5.5%2B */
}
```

_[Code Source][28]_

pre 태그는 많은 양의 코드를 보여주는 레이아웃에서 사용된다. 이 CSS는 노트패드나 텍스트에디터에서 보는 것과 같이 줄이 길 때 수평 스크롤바를 하지않게 코드를 보여준다. 즉, 컨테이너 바깥으로 튀어나가지 않고 **모든 pre 태그가 코드를 줄바꿈하게 한다.**

#### 34. Force Hand Cursor over Clickable Items(클릭 항목에 손모양 커서 강제)

```css
a[href], input[type='submit'], input[type='image'], label[for], select, button, .pointer {
    cursor: pointer;
}
```

_[Code Source][29]_

손 모양 아이콘을 항상 표시하지 않는 클릭 HTML 엘리먼트가 많다. 이 CSS 실렉터 세트는 핵심 엘리먼트와 **.pointer** 클래스를 사용하는 객체에 포인터를 강제한다.

#### 35. Webpage Top Box Shadow(웹페이지 탑 박스 그림자)

```css
body:before {
    content: "";
    position: fixed;
    top: -10px;
    left: 0;
    width: 100%;
    height: 10px;

    -webkit-box-shadow: 0px 0px 10px rgba(0,0,0,.8);
    -moz-box-shadow: 0px 0px 10px rgba(0,0,0,.8);
    box-shadow: 0px 0px 10px rgba(0,0,0,.8);
    z-index: 100;
}
```

_[Code Source][30]_

`body` 엘리먼트에 이 CSS 코드를 추가하면 **웹페이시 상단에서부터 아래로 어두워지는 그림자가 생긴다.**

#### 36. CSS3 Speech Bubble(말 풍선)

```css
.chat-bubble {
    background-color: #ededed;
    border: 2px solid #666;
    font-size: 35px;
    line-height: 1.3em;
    margin: 10px auto;
    padding: 10px;
    position: relative;
    text-align: center;
    width: 300px;
    -moz-border-radius: 20px;
    -webkit-border-radius: 20px;
    -moz-box-shadow: 0 0 5px #888;
    -webkit-box-shadow: 0 0 5px #888;
    font-family: 'Bangers', arial, serif;
}
.chat-bubble-arrow-border {
    border-color: #666 transparent transparent transparent;
    border-style: solid;
    border-width: 20px;
    height: 0;
    width: 0;
    position: absolute;
    bottom: -42px;
    left: 30px;
}
.chat-bubble-arrow {
    border-color: #ededed transparent transparent transparent;
    border-style: solid;
    border-width: 20px;
    height: 0;
    width: 0;
    position: absolute;
    bottom: -39px;
    left: 30px;
}
```

_[Code Source][31]_

이것은 토론 댓글 혹은 게시판 혹은 인용 문구에 편리한다.

#### 37. Default H1-H5 Headers

```css
h1,h2,h3,h4,h5{
    color: #005a9c;
}
h1{
    font-size: 2.6em;
    line-height: 2.45em;
}
h2{
    font-size: 2.1em;
    line-height: 1.9em;
}
h3{
    font-size: 1.8em;
    line-height: 1.65em;
}
h4{
    font-size: 1.65em;
    line-height: 1.4em;
}
h5{
    font-size: 1.4em;
    line-height: 1.25em;
}
```

_[Code Source][32]_

이 템플릿은 H1 ~ H5의 모든 주요 헤딩 엘리먼트에 기본 스타일을 준다. 난 결코 본 적이 없지만, H6를 추가하는 것을 고려할 수도 있다.

#### 38. Pure CSS Background Noise(CSS만의 배경 노이즈)

```css
body {  
    background-image: url(data:image/png;base64,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);  
    background-color: #0094d0;  
} 
```

_[Code Source][33]_

알파투명도와 타일 이미지를 반복사용했더라도 디자이너들은 이 효과를 오래동안 웹사이트 추가해왔다. 그러나, 최신 이미지를 만들기 위해 Base64 코드를 CSS에 집어넣을 수 있다. 위의 스니핏에선 `body` 배경에 노이즈 텍스처를 만들어냈다. [NoiseTextureGenerator][34]를 이용하여 맞춤 노이즈 배경을 만들 수 있다.

#### 39. Continued List Ordering(항목 번호 이어가기)

```css
ol.chapters {
    list-style: none;
    margin-left: 0;
}

ol.chapters &gt; li:before {
    content: counter(chapter) ". ";
    counter-increment: chapter;
    font-weight: bold;
    float: left;
    width: 40px;
}

ol.chapters li {
    clear: left;
}

ol.start {
    counter-reset: chapter;
}

ol.continue {
    counter-reset: chapter 11;
}
```

_[Code Source][35]_

아주 인기있는 스니핏은 아니지만 개발자들 사이에선 나름 사용되고 있다. **두 개의 분리된 UL 엘리먼트에서 CSS만으로 항목 번호를 이어지게 한다.**

#### 40. CSS Tooltip Hovers(CSS 툴팁 호버)

```css
a {
    border-bottom:1px solid #bbb;
    color:#666;
    display:inline-block;
    position:relative;
    text-decoration:none;
}
a:hover,
a:focus {
    color:#36c;
}
a:active {
    top:1px;
}

/* Tooltip styling */
a[data-tooltip]:after {
    border-top: 8px solid #222;
    border-top: 8px solid hsla(0,0%,0%,.85);
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    content: "";
    display: none;
    height: 0;
    width: 0;
    left: 25%;
    position: absolute;
}
a[data-tooltip]:before {
    background: #222;
    background: hsla(0,0%,0%,.85);
    color: #f6f6f6;
    content: attr(data-tooltip);
    display: none;
    font-family: sans-serif;
    font-size: 14px;
    height: 32px;
    left: 0;
    line-height: 32px;
    padding: 0 15px;
    position: absolute;
    text-shadow: 0 1px 1px hsla(0,0%,0%,1);
    white-space: nowrap;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 5px;
}
a[data-tooltip]:hover:after {
    display: block;
    top: -9px;
}
a[data-tooltip]:hover:before {
    display: block;
    top: -41px;
}
a[data-tooltip]:active:after {
    top: -10px;
}
a[data-tooltip]:active:before {
    top: -42px;
}
```

_[Code Source][36]_

웹사이트에 적용할 수 있는 오프소스 jQuery 기반의 툴팁은 많다. 그러나, CSS 기반의 툴팁은 드물고 내가 선호하는 스니핏 중 하나다. 스타일시트에 복사하고 HTML data 속성을 사용하여 `data-tooltip`으로 툴팁 문구를 설정할 수 있다.

#### 41. Dark Grey Rounded Buttons(짙은 회색 라운드 버튼)

```css
.graybtn {
    -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
    -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
    box-shadow:inset 0px 1px 0px 0px #ffffff;
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #d1d1d1) );
    background:-moz-linear-gradient( center top, #ffffff 5%, #d1d1d1 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#d1d1d1');
    background-color:#ffffff;
    -moz-border-radius:6px;
    -webkit-border-radius:6px;
    border-radius:6px;
    border:1px solid #dcdcdc;
    display:inline-block;
    color:#777777;
    font-family:arial;
    font-size:15px;
    font-weight:bold;
    padding:6px 24px;
    text-decoration:none;
    text-shadow:1px 1px 0px #ffffff;
}
.graybtn:hover {
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #d1d1d1), color-stop(1, #ffffff) );
    background:-moz-linear-gradient( center top, #d1d1d1 5%, #ffffff 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#d1d1d1', endColorstr='#ffffff');
    background-color:#d1d1d1;
}
.graybtn:active {
    position:relative;
    top:1px;
}
```

_[Code Source][37]_

클래스 이름을 색상과 맞는 **.graybtn**를 사용하였지만, 여러분의 웹사이트에 맞게 스타일을 변경할 수 없는 것은 아니다.

#### 42. Display URLS in a Printed Webpage(인쇄된 웹페이지에 URL 표시하기)

```css
@media print   {
  a:after {
    content: " [" attr(href) "] ";
  }
}
```

_[Code Source][38]_

뉴스 웹사이트나 인쇄할 게 많은 리소스를 운영하고 있다면 정말 훌륭한 스니핏 중 하나가 될 수 있다. 웹페이지의 앵커 링크는 정확히 보통으로 보이고 표현될 것이다. 그러나 인쇄될 때에는 사용자가 풀 하이퍼링크 URL을 볼 수 있을 것이다. 방문자가 링크해 놓은 웹페이지에 접근할 필요가 있으나 **일반적인 인쇄된 문서에선 URL를 볼 수 없을 때** 편리하다.

#### 43. Disable Mobile Webkit Highlights(모바일 웹킷 하일라이트 제거)

```css
body {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
```

사파리나 웹킷 기반 엔진에서 모바일 웹사이트에 접근할 때 탭한 엘리먼트 주위로 회색 박스가 생기는 것을 눈여겨볼 수 있다. 웹사이트에 이 스타일을 추가하기면 하면 **모든 모바일 브라우저의 하일라이트를 제거할** 것이다.

#### 44. CSS3 Polka-Dot Pattern(CSS3 폴카-점 패턴)

```css
body {
    background: radial-gradient(circle, white 10%, transparent 10%),
    radial-gradient(circle, white 10%, black 10%) 50px 50px;
    background-size: 100px 100px;
}
```

_[Code Source][39]_

CSS3만으로 급하게 배경 패턴을 만들어내는 정말 재밌는 방법이다. 기본적으로 `body` 엘리먼트를 목표로 하지만 웹페이지의 어떤 컨테이너 `div`에도 적용할 수 있다.

#### 45. CSS3 Checkered Pattern

```css
body {
    background-color: white;
    background-image: linear-gradient(45deg, black 25%, transparent 25%, transparent 75%, black 75%, black),
    linear-gradient(45deg, black 25%, transparent 25%, transparent 75%, black 75%, black);
    background-size: 100px 100px;
    background-position: 0 0, 50px 50px;
}
```

_[Code Source][40]_

폴카-점 패턴과 비슷하게 체커보드 패턴을 만들 수 있다. 이 방법은 약간 더 많은 문법이 필요하지만 모든 CSS3 지원 브라우저에서 완벽하게 보인다. 웹사이트 컬러스킴에 맞게 흑백 색상 값을 변경할 수 있다.

#### 46. Github Fork Ribbon(깃허브 포크 리본)

```css
.ribbon {
    background-color: #a00;
    overflow: hidden;
    /* top left corner */
    position: absolute;
    left: -3em;
    top: 2.5em;
    /* 45 deg ccw rotation */
    -moz-transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    /* shadow */
    -moz-box-shadow: 0 0 1em #888;
    -webkit-box-shadow: 0 0 1em #888;
}
.ribbon a {
    border: 1px solid #faa;
    color: #fff;
    display: block;
    font: bold 81.25% 'Helvetiva Neue', Helvetica, Arial, sans-serif;
    margin: 0.05em 0 0.075em 0;
    padding: 0.5em 3.5em;
    text-align: center;
    text-decoration: none;
    /* shadow */
    text-shadow: 0 0 0.5em #444;
}
```

_[Code Source][41]_

CSS3 `transform` 속성을 사용하여 웹사이트에 깃허브 코너 리본을 빠르게 만들어낼 수 있다.

#### 47. Condensed CSS Font Properties(CSS 폰트 속성 요약)

```css
p {
  font: italic small-caps bold 1.2em/1.0em Arial, Tahoma, Helvetica;
}
```

_[Code Source][42]_

웹 개발자들이 이 요약된 폰트 속성을 항상 사용하지는 않는 주요 이유는 모든 설정이 필요하지 않기 때문이다. 그러나, 이 숏핸드를 이해하면 많은 시간과 스타일시트의 공간을 절약할 것이다.

#### 48. Paper Page Curl Effect(종이 페이지 휘는 효과)

```css
ul.box {
    position: relative;
    z-index: 1; /* prevent shadows falling behind containers with backgrounds */
    overflow: hidden;
    list-style: none;
    margin: 0;
    padding: 0;
}

ul.box li {
    position: relative;
    float: left;
    width: 250px;
    height: 150px;
    padding: 0;
    border: 1px solid #efefef;
    margin: 0 30px 30px 0;
    background: #fff;
    -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.06) inset;
    -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.06) inset;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.06) inset;
}

ul.box li:before,
ul.box li:after {
    content: '';
    z-index: -1;
    position: absolute;
    left: 10px;
    bottom: 10px;
    width: 70%;
    max-width: 300px; /* avoid rotation causing ugly appearance at large container widths */
    max-height: 100px;
    height: 55%;
    -webkit-box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    -webkit-transform: skew(-15deg) rotate(-6deg);
    -moz-transform: skew(-15deg) rotate(-6deg);
    -ms-transform: skew(-15deg) rotate(-6deg);
    -o-transform: skew(-15deg) rotate(-6deg);
    transform: skew(-15deg) rotate(-6deg);
}

ul.box li:after {
    left: auto;
    right: 10px;
    -webkit-transform: skew(15deg) rotate(6deg);
    -moz-transform: skew(15deg) rotate(6deg);
    -ms-transform: skew(15deg) rotate(6deg);
    -o-transform: skew(15deg) rotate(6deg);
    transform: skew(15deg) rotate(6deg);
}
```

_[Code Source][43]_

이 페이지 휘는 효과는 웹사이트 컨텐츠를 담는 거의 모든 컨테이너에 적용될 수 있다. 이미지 미디어, 인용 문구 등을 즉시 생각해낼 수 있지만 실제로는 모든 것에 가능할 것이다. 링크된 소스코드 페이지에 데모를 체크해보라.

#### 49. Glowing Anchor Links(빛나는 앵커 링크)

```css
a {
    color: #00e;
}
a:visited {
    color: #551a8b;
}
a:hover {
    color: #06e;
}
a:focus {
    outline: thin dotted;
}
a:hover, a:active {
    outline: 0;
}
a, a:visited, a:active {
    text-decoration: none;
    color: #fff;
    -webkit-transition: all .3s ease-in-out;
}
a:hover, .glow {
    color: #ff0;
    text-shadow: 0 0 10px #ff0;
}
```

_[Code Source][44]_

CSS3 텍스트 그림자는 웹페이지 타이포그래피를 스타일링하는 유일한 방법이다. 이 스니핏은 **링크가 빛나는 호버 효과가 나도록 한다.**

#### 50. Featured CSS3 Display Banner(주목받는 CSS3 배너)

```css
.featureBanner {
    position: relative;
    margin: 20px
}
.featureBanner:before {
    content: "Featured";
    position: absolute;
    top: 5px;
    left: -8px;
    padding-right: 10px;
    color: #232323;
    font-weight: bold;
    height: 0px;
    border: 15px solid #ffa200;
    border-right-color: transparent;
    line-height: 0px;
    box-shadow: -0px 5px 5px -5px #000;
    z-index: 1;
}

.featureBanner:after {
    content: "";
    position: absolute;
    top: 35px;
    left: -8px;
    border: 4px solid #89540c;
    border-left-color: transparent;
    border-bottom-color: transparent;
}
```

_[Code Source][45]_

일반적으론 이 효과를 대체할 배경 이미지를 설정할 필요가 있지만 CSS3 지원 엔진에선 **이미지 없이 컨텐츠 래퍼의 가장자리에 걸리는 동적 배너**를 만들어낼 수 있다. 전자상거래 상품이나 이미지 섬네일, 비디오 프리뷰 혹은 블로그 기사 위에 붙여져 멋져 보일 수 있다.

### Final Thoughts

모든 독자는 여기의 스니핏을 어떤 의무나 권한도 요구되지않고 복사하거나 저장할 수 있다. 대부분의 CSS 코드가 오픈소스 라이센스이며 무료로 제공된다.

#### 역자 추가 링크

* [Web Design Issues That You Can Solve With CSS Snippets](http://www.designresourcebox.com/web-design-issues-that-you-can-solve-with-css-snippets/)
* [Master your CSS3! Ultimate CSS code snippets](http://www.djavupixel.com/development/css-development/master-css3-ultimate-css-code-snippets/)
* [31 CSS Code Snippets To Make You A Better Coder](http://www.designyourway.net/blog/resources/31-css-code-snippets-to-make-you-a-better-coder/)

   [1]: http://www.hongkiat.com/blog/css-snippets-for-designers/
   [2]: http://www.hongkiat.com/blog/complete-guide-to-cross-browser-compatibility-check/
   [3]: http://media02.hongkiat.com/css-snippets-for-designers/css-snippets.jpg
   [4]: http://meyerweb.com/eric/tools/css/reset/
   [5]: http://perishablepress.com/cross-browser-transparency-via-css/
   [6]: http://css-tricks.com/snippets/css/simple-and-nice-blockquote-styling/
   [7]: http://css-tricks.com/snippets/css/media-queries-for-standard-devices/
   [8]: http://www.sitepoint.com/eight-definitive-font-stacks/
   [9]: http://cssfontstack.com/
   [10]: http://web.archive.org/web/20080229090645/http://digg.com/
   [11]: http://www.smipple.net/snippet/kettultim/Polaroid%20Image%20Border%20-%20CSS3
   [12]: http://www.ahrefmagazine.com/web-design/30-useful-css-snippets-for-developers
   [13]: http://miekd.com/articles/pull-quotes-with-html5-and-css/
   [14]: http://css-tricks.com/perfect-full-page-background-image/
   [15]: http://www.w3.org/Style/Examples/007/center
   [16]: http://css-tricks.com/snippets/css/using-font-face/
   [17]: http://kitmacallister.com/2011/css3-stitched-elements/
   [18]: http://css-tricks.com/snippets/css/css3-zebra-striping-a-table/
   [19]: http://css-tricks.com/snippets/css/fancy-ampersand/
   [20]: http://www.w3schools.com/cssref/css3_pr_box-shadow.asp
   [21]: http://jsfiddle.net/chriscoyier/yNZTU/
   [22]: http://css-tricks.com/snippets/css/centering-a-website/
   [23]: http://www.djavupixel.com/development/css-development/master-css3-ultimate-css-code-snippets/
   [24]: http://www.flashjunior.ch/school/footers/fixed.cfm
   [25]: http://css-tricks.com/snippets/css/png-hack-for-ie-6/
   [26]: http://css-tricks.com/snippets/css/glowing-blue-input-highlights/
   [27]: http://www.designyourway.net/blog/resources/31-css-code-snippets-to-make-you-a-better-coder/
   [28]: http://css-tricks.com/snippets/css/make-pre-text-wrap/
   [29]: http://css-tricks.com/snippets/css/give-clickable-elements-a-pointer-cursor/
   [30]: http://css-tricks.com/snippets/css/top-shadow/
   [31]: http://html5snippets.com/snippets/35-css3-comic-bubble-using-triangle-trick
   [32]: https://snipt.net/freshmaker99/headers/
   [33]: https://coderwall.com/p/m-uwvg
   [34]: http://www.noisetexturegenerator.com/
   [35]: http://timmychristensen.com/css-ordered-list-numbering-examples.html
   [36]: http://www.impressivewebs.com/pure-css-tool-tips/
   [37]: http://html5snippets.com/snippets/1-a-css-rounded-gray-button
   [38]: http://www.smipple.net/snippet/bramloquet/Print%20the%20url%20after%20your%20links
   [39]: http://dabblet.com/gist/1457668
   [40]: http://dabblet.com/gist/1457677
   [41]: http://unindented.org/articles/2009/10/github-ribbon-using-css-transforms/
   [42]: http://www.csspop.com/view/542
   [43]: http://www.csspop.com/view/524
   [44]: http://www.csspop.com/view/625
   [45]: http://www.csspop.com/view/553
  