---
layout: post
title: "구글 웹폰트를 빠르게 로드하는 팁 7가지"
description: "웹 타이포그래피의 대세인 구글 웹폰트를 웹사이트에서 빠르게 로딩하는 방법"
category: blog
tags: [css, font, google, html, webfont]
---

원문 : [7 Tips to Load Google Web Fonts Faster][1]

<div id="toc"><p class="toc_title">목차</p></div>

어떻게 사이트에서 [구글 폰트][2]를 빠르게 로드할 수 있을까? 스타일되지 않거나 다른 기본 폰트가 로드된 다음에 번쩍거리며 구글 웹 폰트로 대치되는 경우를 보는 것은 그리 드문 현상이 아니다. 이것은 방문자에게 초기 몇 초 동안이라도 당신의 웹사이트 디자인 경험을 망치고 방문자들을 괴롭힌다. 그러므로 웹폰트를 더 빠르고 정확한 방법으로 보여줄 필요가 있다.

표제에서는 Oswald, 본문에서는 Open Sans를 예로 설명한다.

## Load Google Fonts First

구글 임포트 코드를 `HEAD` 태그의 가장 첫번째 - CSS 화일보다 더 앞 - 에 위치시킨다. 이렇게 하면 CSS보다 먼저 폰트를 로드한다.

## Use Link Format

구글 웹폰트를 도딩하는 방법은 `@import`, 참조 링크, 자바스크립트 3가지이다. 참조 링크를 이용하면 HTML의 최상에 코드를 넣을 수 있으며, CSS 화일보다 가장 빠르게 로드할 수 있다.

```html
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
```

`@import` 코드는 CSS 화일 안에 넣어야한다. CSS 화일의 최상단에 넣어도 스타일되지 않은 텍스트가 번쩍거릴 수 있다.(flash of unstyled text:FOUT) 이건 방문자에게 형편없는 웹 경험이다.

## Load Fewer Fonts

표제를 위한 볼드 타입과 기사를 위한 가독성이 좋은 폰트 - 최대 2개의 폰트를 선정하는 것이 좋은 생각이다. 폰트를 많이 선정할수록 로딩 시간은 더 길어진다.

## Combine Font Codes

코드 한 줄에 여러 구글 폰트를 로드할 수 있다. 로드하려는 각 폰트마다 한 줄 코드를 넣을 필요가 없다. Open Sans와 Oswald 폰트를 결합하는 방법은 아래와 같디:

```html
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Oswald' rel='stylesheet' type='text/css'>
```

## Load Default Variants

폰트 옵션으로 폰트를 여러가지 스타일로 로드할 수 있다. 여러 옵션으로 로딩하는 것은 여러 폰트를 로드하는 것과 똑같다. 폰트의 디폴트 스타일을 선택하면 하나의 옵션으로만 로드된다.

예 - Open Sans 폰트를 기본 옵션으로 로드하면 15 로딩타임의 임팩트를 준다.

![][3]

모든 옵션을 선택하면 10배의 페이지 로드 임팩트가 증가할 것이다.

![][4]

## Load Faster Fonts

구글 폰트의 페이지는 폰트가 로드하는 시간을 매우 명확히 하고 있다. 폰트 옆의 로드 측정기는 각 폰트가 얼마나 빨리 로드되는지 보여준다. 폰트를 더 많이 로드할수록 로드되는 시간은 더 길어진다. 몇몇 폰트는 무겁고 로드 시간이 거의 두배가 걸릴 수 있다. 그러므로 빠르게 로딩되는 폰트를 현명하게 선택하라. 예로, Open Sans는 15 페이지 임팩트이지만 Droid Sans는 25 이상이다!

## Use Web Font Loader

단순히 CSS가 로드되기 전에 구글 폰트가 로드되길 원하고, 스타일되지 않은 텍스트가 번쩍거리지 않게 하려면, 웹 폰트 로더를 사용하라. 웹 폰트 로더는 사이트의 나머지가 로드되기 전에 로드하고, 스타일되지 않은 텍스트가 번쩍되는 것을 확실하게 피해준다. 비동기 스크립트도 사용할 수 있지만, 폰트가 먼저 로드되는 것을 확실하게 하기위해 동기 스크립트를 사용하는 것이 좋다.

```html
<script src="//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
<script>
  WebFont.load({
    google: {
      families: ['Open Sans', 'Oswald']
    }
  });
</script>
```

이런 구글 폰트 트릭을 사용하여 더 훌륭한 인상을 주는 웹사이트로 바꾸자.

## 추가링크

* [Using Web Fonts The Best Way (in 2015). – Anselm Hannemann, Freelance HTML & CSS Contractor](https://helloanselm.com/2015/using-webfonts-in-2015/?ref=webdesignernews.com)
* [Coderifleman – 한글 웹 폰트 경량화해 사용하기](http://blog.coderifleman.com/post/111825720099/%ED%95%9C%EA%B8%80-%EC%9B%B9-%ED%8F%B0%ED%8A%B8-%EA%B2%BD%EB%9F%89%ED%99%94%ED%95%B4-%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0)

   [1]: http://www.quickonlinetips.com/archives/2013/10/load-google-web-fonts-faster/
   [2]: http://www.google.com/fonts
   [3]: http://www.quickonlinetips.com/archives/wp-content/uploads/single-font.png
   [4]: http://www.quickonlinetips.com/archives/wp-content/uploads/all-fonts.png
  