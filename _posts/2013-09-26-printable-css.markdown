---
layout: post
title: "CSS로 웹사이트를 인쇄가능하게 만들기"
description: ""
category: blog
tags: [css, print]
---

<div id="toc"><p class="toc_title">목차</p></div>

_원문의 영어 단어는 쉬운데 해석하기가 어렵고 필요없는(?) 말이 많아서 필요한 부분만 발췌하였습니다._

원문 : [Make your website printable with CSS][1]

이 방법은 개발자가 적은 노력으로 인쇄 페이지를 지원할 수 있는 방법이다.

## Step 01. Getting started

우선, 소스 웹 페이지와 비교하여 사이트를 어떻게 인쇄할 것인지를 생각해보자.

![][2]

웹페이지는 무한대로 스크롤할 수 있지만, 인쇄된 페이지는 종이 크기에 제한된다. 웹페이지가 비디오, 오디오, 접촉을 통한 피드백도 가능한 접근성을 갖는 반면, 인쇄된 페이지는 철저히 보는 매체이다. 웹페이지는 비트맵 데이타(사진, 그래픽)와 벡터 데이타(서체, SVG)를 표현할 수 있지만, 일단 인쇄되면 종이 위에 비트맵 데이타일 뿐이다. 웹페이지는 인터랙티브하고 스크린 상의 엘리먼트를 변경할 수 있지만, 인쇄된 페이지는 그렇지 않다. 이러한 것들이 인쇄된 페이지의 컨텐츠에 대한 결정을 하는 요인이 되기 때문에 모두 기억해두는 것이 유용할 것이다.

![][3]  
**파이어폭스 테스크탑 브라우저에 본 예제 페이지. 오래 되었지만 아직 인쇄할만한다.**

페이지를 볼 때 사용자가 보길 원하는 것은 단 하나: 컨텐츠. 내 사이트이므로, 사용자가 인쇄할 때 유지해야할 페이지 상의 엘리먼트를 확실하게 하고 싶다:

  * 브랜딩
  * 독자가 내 페이지를 찾는 방법
  * 저작권 문구
  * 회사의 CMS와 같은 크로스 브랜딩
  * 내 컨텐츠에 대한 링크 주소

이에 반해, 대부분의 인쇄 사용자들이 보길 원하지 않는 다른 항목이 있다:

  * 주 네비게이션
  * 보조 네비게이션
  * 사이트 검색
  * 소셜 아이콘과 링크

마지막으로, 사용자나 내가 원하지 않는 몇 가지가 있다:

  * 색상(특히 모노 프린터를 위해)
  * 배경 이미지(와 색상)
  * 타이밍/상호작용하는 엘리먼트(이미지 슬라이더의 사진과 같은)
  * 로고와 같은 화이트 이미지

## Step 02. Make a home for print styles

프린트 스타일이 호출되기 위한 CSS를 설정하는 것이 첫번째 할일이다. RWD 코딩에 해봤다면, 다음은 친숙할 것이다:

```css
@media print {
  /* insert your style declarations here */
}
```

이런 접근으로만 한정되진 않는다. `<head>` 안에 `<link>`로 프린트 스타일을 호출할 수도 있다.

  <link rel="stylesheet" type="text/css" href="/css/print.css" media="print">

이 방법은 추가적인 HTTP 요청과 관련이 있다. 브라우저는 페이지를 렌더링할 때 프린트 스타일이 필요하지 않으나, 대부분 모든 CSS 화일을 내려받기 전 까지는 페이지를 렌더링하지 않을 것이다; 오페라는 예외이다. 게다가, 최신 브라우저는 모든 화일이 다운로드되기 전까지는 어떤 온로드 이벤트를 작동하지 않는다. 프린트 스타일은 매우 적은 선언만을 포함할 수 있기 때문에 화일을 분리한다고 해서 추가적인 HTTP 오버헤드와 렌더링 지연이나 이벤트 작동을 고려할 필요가 그리 잦은 것은 아니다.

![][4]  
**파이어폭스에서 PDF로 인쇄한 동일한 페이지. 몇 개가 사라지고 레이아웃이 단순해진 것을 볼 수 있다.**

## Step 03. Applying the styles

내 로고는 텍스트이며, 컬러 프린터 사용자들이 빨간색으로 인쇄할 필요없도록 검정으로 변경할 것이다.

```css
#Banner p#Title {
  font-size: 24pt;
}
#Banner p#Title a, #Banner p#Title a:link, #Banner p#Title a:visited {
  color: #000; /* change link to black text */
}
```

브라우저가 인쇄된 페이지에 페이지 주소를 포함할 수 있다는 것을 알지만, 몇몇 사용자는 그것을 무시하고 몇몇 페이지 주소는 너무 길다. 페이지에 이동경로 탐색이 있기 때문에 남기기로 선택한다. 사용자가 푸터에 인쇄될 주소를 읽을 수 없더라도, 적어도 내 사이트의 해당 페이지의 경로를 볼 수는 있다. 독자가 내 사이트에서 해당 페이지를 찾을 수 있도록 하는 두번째 목표를 달성한다.

```css
#Bread a:link, #Bread a:visited {
  text-decoration: underline; /* leave a clue that it’s a link */
  color: #000;
}
#Bread {
  color: #000;
  font-size: 6pt; /* make the text small */
}
#Bread &gt; a:after {
  content: ""; /* disable URL display if in #Content */
}
```

푸터에 있는 모든 것을 인쇄하길 원하지 않는다. 예를 들면 검색 박스를 인쇄하지 않도록 한다.

```css
#Footer {
  font-size: 6pt; /* make the text small */
  color: #000;
}
#SearchForm {
  display: none;
}
```

푸터에 CMS 로고를 남긴다. (아마 독자가 신경쓰지 않을) URL을 보여줄 필요가 없으나, 브랜드는 남긴다. 크로스 브랜딩에 대한 네번째 목표이다.

```css
#Footer img {
  float: right; /* defined elsewhere, included for completeness */
}
```

다섯번째 목표는 문맥에 따른 링크의 전체 주소를 보여주는 것이다. 모든 링크 뒤에 주소를 포함하곤한다: 그러나, 몇몇 링크 주소를 믿을 수 없이 긴 - 사용자가 다시 타이핑할 수 없을 정도로 - 문제가 있을 수 있다.

![][5]  
**크롬에서 인쇄 미리보기 대화 상자. 모든 인쇄 미리보기에서와 같이, 예상한 것에 대한 빠른 아이디어를 제공한다.**

하이퍼링크를 보여주기로 하였다면, 컨텐츠에 따라 제한하고 - 이동경로와 푸터에선 URL을 보여주지 않는다 - 가능하면 이미지에서 제외한 것 등을 기억하는 것이 중요하다.

```css
#Content a:after { /* select links in the content area only */
  content: " [" attr(href) "] ";
  text-decoration: none;
  display: inline;
}
```

이제 인쇄되길 원치않는 엘리먼트를 가려보자. 작은 화면에서 엘리먼트를 가리는 것 - RWD에선 좋은 아이디어가 아니지만 - 과 달리, 페이지는 이미 전부 다운로드되었고, 가려야 하는 엘리먼트는 인쇄 페이지에서 어떤 가치도 없어야 한다.

예제에서 네비게이션, 검색, 소셜 아이콘과 의미를 갖지 않는 다른 것들을 제거할 것이다.

```css
#Nav, #FlyOutNav, #SubNav, .NoPrint, p.CodeAlert, #SMLinks, #SearchForm {
  display: none;
}
```

아직 필요한 것을 전부한 것은 아니다.중요한 것을 까먹기지 않기 위해 거의 모든 인쇄 스타일시트를 적용할 수 있는 디폴트 스타일 세트를 가지고 있다. 사이트마다 정기적으로 조정하지만, 필요에 따른 좋은 시작점이 된다:

```css
body {
    background: #fff;
    color: #000;
    font-size: 8pt;
    line-height: 150%;
    margin: 0px;
  }
  hr {
    color: #ccc;
    background-color: #ccc;
  }
  h1, h2, h3, h4, h5, h6, code, pre {
    color: #000;
    text-transform: none; /* because sometimes I set all-caps */
  }
  h1 {
    font-size: 11pt;
    margin-top: 1em;
  }
  h2 {
    font-size: 10pt;
  }
  h3 {
    font-size: 9pt;
  }
  h4, h5, h6 {
    font-size: 8pt;
  }
  code, pre {
    font-size: 8pt;
    background-color: transparent;
    /* just in case the user configured browser to print backgrounds */
  }
  blockquote {
    background-image: none;
    /* though they may not print, I’d rather be sure */
  }
  a:link, a:visited {
    text-decoration: underline;
    color: #000;
  }
  abbr:after, acronym:after { /* some HTML4 love */
    content: " (" attr(title) ") ";
    /* I suspect I am one of the few who still use these elements */
  }
```

이 스타일시트는 몇 가지 기본적인 것을 해낸다:

  * 컨텐츠 주변의 여백을 제거한다.(사용자는 인쇄 설정에서 페이지 여백을 다룰 수 있다)
  * 서체 크기를 재설정하고 텍스트를 검정색으로 설정한다.
  * 페이지의 `<abbr>`과 `<acronym>` 타이틀 속성 값을 입력한다.(이미지의 `alt text`와 같은 엘리먼트에도 사용할 수 있지만, 적당한 것은 아니다.)

![][6]  
**다른 종이 크기에서 테스트해야 한다. 랜드스케이프는 보기도 쉽고, 크기 조절 문제를 빠르게 테스트할 수 있게 한다.**

## Step 04. Further tweaks

사이트에 이미 모바일 레이아웃이 적용되었다면, 아마 선형 레이아웃에 고려한 스타일을 이미 갖고 있을 것입니다. 아무것도 하지 않았다면 시작점으로 모바일 친화적인 레이아웃을 사용하고, 네비게이션과 유지하길 원치 않는 엘리먼트를 꺼버릴 수 있다.

이제 다른 스크린 크기의 레이아웃을 고려하기 위해 다른 스타일을 생각해보자. 좋은 예는 뷰포트 사이즈에 기반한 이미지 사이즈를 크기 변경할 때이다.

많은 사이트의 특정 미디어 쿼리에서 100% 너비로 이미지를 크기변경하는 것을 보아왔다. 이건 종이 너비에 이미지를 무심히 맞춰버릴 수 있기에(때론 종이 전체에) 인쇄된 페이지에선 문제가 될 수 있다. 사용자 페이지와 잉크를 아낄 수 있게 이미지 크기를 줄이는 것을 고려하고, 몇 가지 경우엔 필요하다면 크기를 키우는 것까지도 고려해라.

종이에 위치하지 않은 레이아웃의 엘리먼트에 대해서도 생각해라. 예로, 플래쉬, 임베딩된 유투브 혹은 플레이할 수 있는 인터랙티브 위젯이 있는가?

인쇄 페이지에서 그것들을 같이 제거하는 것을 원할 것이다. 그렇지 않으면, 임베딩된 유투브 디비오는 많은 공간을 차지하거나 여백으로 나타날 것이다.

![][7]  
**어떤 유저는 페이지를 쉽게 읽게 하기위해 텍스트 크기를 키울 수 있다. 스타일을 조정할 필요가 있는지 이런 것을 테스트해라.**

## Step 05. Testing

모든 스타일이 준비되면, 테스트해라. 페이지를 프린트하지 않고 사용하는 두 가지 테크닉이 있다. 첫번째는 브라우저 인쇄 미리보기이다. - 스타일이 어떻게 해석되는지 알아보기 위한 빠른 방법이다. 두번째는 PDF로 인쇄해서 얻는 페이지를 보는 것이다.

   [1]: http://www.creativebloq.com/responsive-web-design/make-your-website-printable-css-3132929
   [2]: http://media.creativebloq.futurecdn.net/sites/creativebloq.com/files/images/2013/05/Hannah/table.jpg
   [3]: http://media.creativebloq.futurecdn.net/sites/creativebloq.com/files/images/2013/05/Hannah/01(67).jpg
   [4]: http://media.creativebloq.futurecdn.net/sites/creativebloq.com/files/images/2013/05/Hannah/02(63).jpg
   [5]: http://media.creativebloq.futurecdn.net/sites/creativebloq.com/files/images/2013/05/Hannah/03(58).jpg
   [6]: http://media.creativebloq.futurecdn.net/sites/creativebloq.com/files/images/2013/05/Hannah/04(61).jpg
   [7]: http://media.creativebloq.futurecdn.net/sites/creativebloq.com/files/images/2013/05/Hannah/05(59).jpg
  