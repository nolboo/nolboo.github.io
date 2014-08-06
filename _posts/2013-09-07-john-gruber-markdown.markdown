---
layout: post
title: "존 그루버 마크다운 페이지 번역"
description: "마크다운 최초 제안자 존 그루버의 마크다운 문법 공식 페이지 번역"
category: blog
tags: [markdown, syntax, John-Gruber]
---

<div id="toc"><p class="toc_title">목차</p></div>

원문 : [Daring Fireball: Markdown][1]

기존 오피스에서 구글 클라우드로 모든 문서작업을 옮긴 지가 거의 4년 정도 되는 것 같다. 무겁고 복잡하여 느린 오피스에 불만이 많았고, 어디서나 어느 기기에서나 접근할 수 있다는 매력으로 한참을 사용하였지만 클라우드가 가지는 로딩 속도에 대한 불만은 없어지지 않았다.(물론 무거운 오피스에서도 가장 큰 불만이었다. 많이 사용되고 에버노트가 내겐 저장용인 가장 큰 이유이기도 하다.) 그래서 NVAlt나 simplenote와 같은 프로그램을 병행해 사용할 수 밖에 없었고 현재도 가장 애용하는 제품이다. 몇년 전부터 마크다운에 대해 피상적으로 알고 있었으나 본격으로 사용한 것은 약 6,7개월 전부터인데 사용하다보니 미래의 문서 포맷으로는 가장 최적이라고 생각되고, 아직 발전할 여지가 많다고 생각된다. 마크다운을 최초로 제안한 저널리스트(개발자가 아니다 물론 펄 프로그램을 만들어 유포하긴했어도..)인 존 그루버가 몇년째 자신의 블로그 페이지에서 공개하고 있는 표준문서에 가까운 도큐멘트를 문법(syntax)부분을 중심으로 발췌 번역한다.

## Introduction

마크다운은 웹에서 글을 쓰는 사람들을 위해 텍스트를 HTML로 변환해주는 툴이다. 읽기쉽고 쓰기편한 순수한 텍스트 형식으로 글을 쓰고난 후 XHTML(또는 HTML)로 변환한다.

마크다운 문법의 최우선 목적은 최대한 읽기 편하게 하는 것이다. 이상적인 마크다운 형식 문서는 태그나 형식 명령없이 순수한 텍스트 그대로 출판할 수 있어야 한다. 마크다운 문법은 기존의 여러 text-to-HTML 필터에 영향을 받았지만 그중 텍스트 이메일 형식에서 가장 큰 영감을 받았다.

마크다운은 BSD 오픈 라이언스 기반의 무료 소프트웨어이다.

## Acknowledgements

이 부분은 실질적인 내용이 없어 건너뛰려고 하였으나 애런 스워츠가 공동 창시자라 불리울 정도로 공헌이 많고(특히 문법부분), HTML 문서를 Markdown으로 변환해주는 [html2text][2]를 만들었다는 부분을 명시한다.

## Markdown Syntax Documentation

### Overview

#### Philosophy

마크다운은 구현 가능한한 읽기 쉽고 쓰기 쉽게 하도록 하였다.

그러나 다른 무엇보다도 가독성을 강조하였다. 마크다운 형식 문서는 태그나 형식 명령으로 마크업되는 것 같이 보이지않고, 일반 텍스트 그대로 출판할 수 있어야 한다. 마크다운 문법은 기존의 여러 텍스트-HTML 필터 - [Setext][3], [atx][4], [Textile][5], [reStructuredText][6], [Gruatext][7], [EtText][8] - 의 영향을 받았지만 마크다운 문법의 가장 큰 영감의 원천은 순수 텍스트 전자우편이다.

그 결과, 마크다운 문법은 전체적으로 구두점으로 구성되어 있으며, 구두점은 의미하는 것을 고려해서 주의깊게 선택했다. 예로, 단어를 감싸는 별표는 *강조*처럼 보이며, 마크다운 목록은 일반 목록처럼 보인다. 심지어 인용은 이메일에서 사용해오던 텍스트 메시지 인용과 같다.

### Inline HTML

마크다운 문법은 하나의 목적을 의도한다: 웹에 _글을 쓰기_ 위한 형식으로 사용한다.

마크다운은 HTML을 대체하는 것이 아니라, 오히려 HTML에 가깝다. 마크다운의 문법은 매우 적고, HTML 태그의 매우 작은 부분에 해당한다. 그 아이디어는 HTML 태그를 쉽게 넣을 수 있는 문법을 만들려는 것이 아니다. 개인적인 의견이지만 HTML은 이미 쉽게 넣을 수 있다. 마크다운의 아이디어는 글을 읽고 쓰고 편집하는 것이 편하게 하는 것이다. HTML은 _출판_ 형식이고, 마크다운은 _쓰기_ 형식이다. 따라서 마크다운의 문법은 단지 순수한 텍스트로 전달할 수 있는 문제만 다룬다.

마크다운 문법에서 다루지 않은 마크업은 그냥 HTML 그 자체를 사용하면 된다. 마크다운 형식에서 HTML 형식으로 전환하기 위해 범위를 지정하는 등의 일을 할 필요가 없습니다. 태그를 그대로 사용하면 된다.

유일한 제한은 블럭 엘리먼트 - 예. `<div>`, `<table>`, `<pre>`, `<p>` 등 - 는 주변 컨텐츠와 빈줄로 구분하고(한칸씩 띄어주고) 블럭의 시작과 끝 태그는 탭이나 공백으로 들여쓰면 안된다. 마크다운은 HTML 블럭레벨 태그 주위에 (원치않는) `<p>` 태그를 추가하지 않을 정도로 똑똑하다.

예를들어 마크다운 기사에 HTML 테이블를 추가하기 위해:

```html
<table>
    <tr>
        <td>Foo</td>
    </tr>
</table>

This is another regular paragraph.
```

블록레벨 태그 안에선 마크다운 형식의 문법이 처리되지 않는 것을 주목한다. 예를들어 HTML 블럭 안에서는 *강조*와 같은 문법을 사용할 수 없다.

스팬레벨(인라인) HTML 태그 - 예: `<span>`, `<cite>`, `<del>` - 은 마크다운 문단, 목록, 헤더 등에서 사용할 수 있다. 원하면 마크다운 형식 대신에 HTML 태그를 사용할 수 있다. 예로. 마크다운 링크나 이미지 문법 대신에 HTML `<a>`나 `<img>` 태그를 사용할 수 있다.

블럭레벨 태그와는 달리, 스팬레벨 태그에서는 마크다운 문법으로 _처리된다_.

### Automatic Escaping for Special Characters

HTML에서, 특별 처리해야할 두 개의 문자가 있다: `<`와 `&`. 왼쪽 꺽쇠 괄호는 태그를 시작하는 데에 사용하며; ampersand(`&`)는 HTML 엔티티를 표시할 때 사용한다. 만약 이들을 문자 그대로 사용하려면 이들 항목을 `&lt;`, `&amp;`처럼 예외처리를 해 주어야 한다.

특히 `&`는 웹 상에서 글을 쓸 때 곤란하다. 만약 `AT&T`를 쓰길 원하면 `AT&amp;T`로 써야 한다. 심지어 URL 안에서도 `&`를 예외처리할 필요가 있다. 따라서 다음 링크를 하려면:

    http://images.google.com/images?num=30&q=larry+bird

다음과 같이 인코딩해야 한다:

    http://images.google.com/images?num=30&amp;q=larry+bird

말할 필요도 없이 잊기 쉬운 내용이며, 아마도 이것은 잘 만들어진 웹사이트에서도 가장 흔하게 볼 수 있는 HTML 오류 중 하나일 것이다.

마크다운은 이 문자들을 주의깊게 다루어주어서 자연스럽게 사용할 수 있다. 만약 `&`를 하나의 HTML 엔티티의 부분으로 `&`를 사용하면 변경하지 않는다. 그렇지 않을 경우엔 `&amp;`로 바꾼다.

따라서 기사에 저작권 기호를 포함하고 싶다면, 다음과 같이 쓰면된다:

    &copy;

마크다운은 이것을 바꾸지 않는다. 그러나:

    AT&T

처럼 쓴다면 마크다운은 다음처럼 바꾼다:

    AT&amp;T

비슷하게 마크다운은 인라인 HTML을 지원하기 때문에 HTML 태그의 구분자로서 꺽쇠 괄호를 사용하면 마크다운은 그렇게 다룬다. 그러나 다음처럼 쓰면:

    4 < 5

마크다운은 이것을 다음처럼 바꾼다:

    4 &lt; 5

그러나 마크다운 코드 스팬과 코드 블럭에서 꺽쇠 괄호와 `&` 기호는 항상 자동적으로 인코드된다. 이것은 마크다운으로 HTML 코드에 대한 글을 쉽게 쓸 수 있게 한다. (반면 HTML 문법에 대한 글을 쓰려고 할 때 HTML만의 형식은 끔찍하다. 모든 `<`과 `&`에 대해 예외처리를 해주어야 한다.)

## BLOCK ELEMENTS

### PARAGRAPHS AND LINE BREAKS

문단은 하나 또는 그 이상의 연이은 줄이며, 하나 이상의 빈줄로 분리한다. (빈줄은 빈줄 - 공백이나 탭을 제외한 아무것도 포함하지 않은 것으로 생각한다 - 처럼 보이는 줄이다.) 일반 문단은 공백이나 탭으로 들여쓰지 말아야 한다.

“하나 이상의 연이은 텍스트 줄”이라는 규칙이 함축하는 것은 마크다운이 “강제 줄바꿈” 문단을 지원하는 것이다. 이것이 상당히 다른 부분이다. 대부분의 다른 text-to-HTML 변환 포맷터들이(무버블 타입의 줄바꿈 변환 옵션 포함하여) 하나의 문단 안에서 줄바꿈 문자는 모두 `<br />` 태그로 변환한다.

마크다운을 사용해서 `<br />`를 삽입하려면 줄 마지막에 둘 이상의 공백을 두고 엔터를 입력하면 된다.

그렇다, 
태그를 만들기 위해 좀 수고가 들지만, “모든 줄바꿈은 하나의 `<br />`이다”라는 지나치게 단순한 규칙은 마크다운에서 동작하지 않는다. 마크다운의 전자메일 형식의 인용과 다중 패러그래프 목록은 강제로 줄바꿈할 때 가장 잘 - 보기에도 낫게 - 동작한다.

HEADERS

마크다운은 두 가지 형식의 제목을 지원한다, [Setext](http://docutils.sourceforge.net/mirror/setext.html)와 [atx](http://www.aaronsw.com/2002/atx/).

Setext 형식의 헤더는 등호(큰 제목)와 빼기(작은 제목) 기호를 “밑줄”로 사용한다. 예를들어:

    This is an H1
    =============

    This is an H2
    -------------

밑줄 =, - 의 수는 여러 개이면 된다.

Atx 형식의 헤더는 줄 시작에서 1-6개의 해시 문자를 사용한다. 헤더의 수는 제목의 크기에 따른다. 예를 들어:

    # This is an H1

    ## This is an H2

    ###### This is an H6

옵션으로, atx 헤더를 닫을 수 있다. 이건 순전히 장식용이다 — 이렇게 하는 것이 더 나아 보인다면 이걸 사용할 수 있다. 닫는 해시는 시작 해시의 수와 같을 필요는 없다. (시작 해시의 수가 제목의 크기를 결정한다.):

    # This is an H1 #

    ## This is an H2 ##

    ### This is an H3 ######

### BlockQuote

마크다운은 이메일 형식의 `>` 문자를 블럭인용에 사용한다. 만약 이메일의 인용 규칙에 익숙하다면 마크다운에서 블럭인용을 만드는 법을 알고 있는 것이다. 텍스트를 강제 줄바꿈하고 각 줄 앞에 `>`를 넣으면 가장 잘 보인다.

    > This is a blockquote with two paragraphs. Lorem ipsum dolor sit amet,
    > consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus.
    > Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.
    > 
    > Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse
    > id sem consectetuer libero luctus adipiscing. 

마크다운은 강제로 줄바꿈 된 첫줄의 앞에 `>`만 두어도 인용하는 것이 가능하다.

    > This is a blockquote with two paragraphs. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus. Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.

    > Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse id sem consectetuer libero luctus adipiscing.

추가적으로 `>`를 덧붙임으로서 인용 안의 인용(nest)을 할 수 있다:

    > This is the first level of quoting.
    >
    > > This is nested blockquote.
    >
    > Back to the first level.

인용은 제목, 목록, 코드블럭과 같은 다른 마크다운 요소를 포함할 수 있다.

    > ## This is a header.
    >
    > 1.   This is the first list item.
    > 2.   This is the second list item.
    >
    > Here's some example code:
    >
    >     return shell_exec("echo $input | $markdown_script");

제대로 된 문서 편집기는 이메일 형식의 인용을 쉽게할 수 있는 방법을 제공한다. 예를들어 BBEdit는 블럭을 지정하고 텍스트 메뉴에서 인용 레벨을 선택할 수 있다.

### LISTS

마크다운은 순서있는(번호), 순서없는(글머리 기호) 목록을 지원한다.

순서없는 목록은 항목 표시로 별표, 더하기, 빼기를 - 교환가능하게 - 사용한다.

    *   Red
    *   Green
    *   Blue

은 다음과 같다:

    +   Red
    +   Green
    +   Blue

과

    -   Red
    -   Green
    -   Blue

순서있는 목록은 숫자와 점을 사용한다:

    1.  Bird
    2.  McHale
    3.  Parish

목록에 사용되는 실제 숫자는 마크다운이 처리하는 HTML 출력에 아무런 영향도 주지 않는다는 것은 알아두는 것이 중요하다. 위의 목록을 마크다운이 처리하면, HTML은 다음과 같게 된다.:

```html
<ol>
<li>Bird</li>
<li>McHale</li>
<li>Parish</li>
</ol>
```

만약 위의 예 대신에:

    1.  Bird
    1.  McHale
    1.  Parish

또는 심지어:

    3. Bird
    1. McHale
    8. Parish

도 정확히 같은 HTML을 만든다. 중요한 것은, 원한다면, 순서있는 마크다운 목록에서 소스의 숫자와 출판될 HTML의 숫자가 동일하도록 숫자를 맞출 수 있다. 그러나 마음대로 해도 된다.

그러나, 목록번호를 맘대로 매겨도 아직 숫자 1로 시작된다. 미래 어느 시점에 마크다운은 임의의 숫자로 시작하는 순서있는 목록을 지원할 것이다.(역자: 언제?)

항목 표시는 일반적으로 왼쪽 마진에서 시작하지만 최대 세개의 공백으로 들여쓸 수 있다. 목록 표시는 하나 이상의 공백이나 탭이 뒤따라야 한다.

또 목록을 보기 좋게 하기 위해 들여쓰기와 줄바꾸기를 사용할 수 있다.

    *   Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        Aliquam hendrerit mi posuere lectus. Vestibulum enim wisi,
        viverra nec, fringilla in, laoreet vitae, risus.
    *   Donec sit amet nisl. Aliquam semper ipsum sit amet velit.
        Suspendisse id sem consectetuer libero luctus adipiscing.

그러나 다음과 같이 써도 된다:

    *   Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
    Aliquam hendrerit mi posuere lectus. Vestibulum enim wisi,
    viverra nec, fringilla in, laoreet vitae, risus.
    *   Donec sit amet nisl. Aliquam semper ipsum sit amet velit.
    Suspendisse id sem consectetuer libero luctus adipiscing.

목록 항목을 빈줄로 분리하면 마크다운은 HTML 출력에서 `` 태그로 이 항목을 감싼다. 예를 들면:

    *   Bird
    *   Magic

은 다음처럼 변환된다:

```html
<ul>
<li>Bird</li>
<li>Magic</li>
</ul>
```

그러나, 다음은:

    *   Bird

    *   Magic

이렇게 변환된다:

```html
<ul>
<li><p>Bird</p></li>
<li><p>Magic</p></li>
</ul>
```

목록 항목은 여러 문단으로 이루어질 수 있다. 목록 항목에서 이어지는 문단은 적어도 4개 이상의 공백이나 하나 이상의 탭으로 들여써야 한다.

    1.  This is a list item with two paragraphs. Lorem ipsum dolor
        sit amet, consectetuer adipiscing elit. Aliquam hendrerit
        mi posuere lectus.

        Vestibulum enim wisi, viverra nec, fringilla in, laoreet
        vitae, risus. Donec sit amet nisl. Aliquam semper ipsum
        sit amet velit.

    2.  Suspendisse id sem consectetuer libero luctus adipiscing.

이어지는 각 줄을 들여쓰는 것이 보기에 좋다. 그러나 다음과 같이 느긋하게 사용힐 수 있다:

    *   This is a list item with two paragraphs.

        This is the second paragraph in the list item. You're
    only required to indent the first line. Lorem ipsum dolor
    sit amet, consectetuer adipiscing elit.

    *   Another item in the same list.

목록 항목 안에서 블록 인용하려면 `>` 구분 문자로 들여쓰게 하면 된다.

    *   A list item with a blockquote:

        > This is a blockquote
        > inside a list item.

목록 항목 안에서 코드 블럭을 넣으려면 두 번의 들여쓰기가 - 8개의 공백 또는 두번의 탭이 필요하다:

    *   A list item with a code block:

            <code goes here>

다음과 같이 씀으로서 우연히 순차목록을 만들 가능성을 없애는 것도 가능하다.

    1986. What a great season.

다시 말하자면 줄 시작 부분의 _숫자-마침표-공백_. 이것을 피하기 위해 마침표를 `\`로 예외처리할 수 있다.

    1986\. What a great season.

### CODE BLOCKS

프로그래밍이나 마크업 소스코드를 표시하기 위해 형식화된 코드 블럭을 사용할 수 있다. 일반 문단과는 달리 코드블럭의 줄은 문자 그대로 해석된다. 마크다운은 `<pre>`와 `<code>` 두 개의 태그로 코드블럭을 감싼다.

마크다운에서 코드 블럭을 만들기 위해 간단히 블럭의 모든 줄을 적어도 4개 이상의 공백이나 하나의 탭으로 들여쓰면 된다. 예를 들면, 다음 입력은:

    This is a normal paragraph:

        This is a code block.

마크다운은 다음처럼 바꾼다:

```html
<p>This is a normal paragraph:</p>

<pre><code>This is a code block.
</code></pre>
```

4개의 공백 또는 하나의 탭으로 된 한 단계의 들여쓰기는 코드 블럭 각 줄로부터 제거된다. 예를 들면, 다음은:

    Here is an example of AppleScript:

        tell application "Foo"
            beep
        end tell

은 다음처럼 바뀐다:

```html
<p>Here is an example of AppleScript:</p>

<pre><code>tell application "Foo"
    beep
end tell
</code></pre>
```

코드 블럭은 들여쓰여지지 않은 행을 만날 때(또는 글의 끝)까지 계속된다.

코드블럭에서, 앰퍼센트(`&`)와 왼쪽, 오른쪽 꺽쇠 괄호는 자동적으로 HTML 에티티로 변환된다. 그 결과, 마크다운에서 HTML 소스코드를 아주 쉽게 삽입 - 복사하고 들여쓰기 - 할 수 있다. 마크다운은 `&`와 꺽쇠 괄호를 인코딩하는 것도 잘 처리한다. 예를 들면, 다음은:

    <div class="footer">
        &copy; 2004 Foo Corporation
    </div>

다음과 같이 바뀐다:

```html
<pre><code>&lt;div class="footer"&gt;
    &amp;copy; 2004 Foo Corporation
&lt;/div&gt;
</code></pre>
```

일반 마크다운 문법은 코드블럭에서는 처리되지 않는다. 예로, 별표는 코드블럭 안에서 그대로 별표로 표시된다. 이것은 마크다운 자체의 문법을 설명할 때도 쉽게 사용할 수 있다는 것을 말한다.

### HORIZONTAL RULES

수평선 세개 이상의 빼기, 별표, 밑줄로 수평선(``)을 만들 수 있다. 만약 원하는 경우 빼기나 별표 중간에 공백을 넣을 수도 있다. 아래의 줄은 모두 수평선을 만든다:

    * * *

    ***

    *****

    - - -

    ---------------------------------------

## SPAN ELEMENTS

### LINKS

마크다운은 두가지 형식의 링크를 지원한다: _인라인_과 _참조_

두 형식 모두,에서 링크 문자열은 [대괄호]로 구분한다.

인라인 링크를 만들기 위해 링크 문자열을 대괄호로 닫고 이어서 둥근괄호 쌍을 사용한다. 둥근괄호 안에 링크 URL과 링크에 대한 설명을 추가할 수 있다. 예를 들면, 다음은:

    This is [an example](http://example.com/ "Title") inline link.

    [This link](http://example.net/) has no title attribute.

다음처럼 바뀐다:

```html
<p>This is <a href="http://example.com/" title="Title">
an example</a> inline link.</p>

<p><a href="http://example.net/">This link</a> has no
title attribute.</p>
```

만약 같은 서버의 로컬 리소스를 참조하려면 상대 경로를 사용한다:

    See my [About](/about/) page for details.

참조 형식의 링크는 두 번째에도 대괄호를 사용하며, 그 안에 링크와 대응하는 레이블을 넣는다.:

    This is [an example][id] reference-style link.

옵션으로 대괄호를 공백으로 분리할 수도 있다:

    This is [an example] [id] reference-style link.

그리고 문서 아무 곳에서나 다음과 같은 방법으로 링크를 참조할 수 있다:

    [id]: http://example.com/  "Optional Title Here"

이것은:

  * 대괄호에는 링크 ID를 포함해야 한다(옵션으로 왼쪽 마진에서 최대 세개의 공백으로 들여쓸 수 있다);
  * 콜론이 이어 지며;
  * 하나 이상의 공백(또는 탭)이 뒤따른다;
  * 링크에 대한 URL이 뒤따른다;
  * 옵션으로 링크에 대한 제목 속성이 뒤따를 수 있으며, 작은 따옴표나 큰 따옴표로 인용하거나 괄호로 감싸야 한다.

다음 세개의 링크는 모두 같다:

    [foo]: http://example.com/  "Optional Title Here"
    [foo]: http://example.com/  'Optional Title Here'
    [foo]: http://example.com/  (Optional Title Here)

_주의_: 링크 타이틀 구분에 작은 따옴표를 사용할 수 없는 버그가 Markdown.pl 1.0.1에 있다.

옵션으로 링크 URL은 꺽쇠 괄호로 감쌀 수 있다:

    [id]: <http://example.com/>  "Optional Title Here"

또 제목 속성을 다음 행에 두고 공백이나 탭으로 들여쓸 수 있다. 긴 URL은 이렇게 하는 것이 보기에 더 좋다:

    [id]: http://example.com/longish/path/to/resource/here
        "Optional Title Here"

링크 정의는 마크다운 처리 과정 중 링크를 만드는데 사용되며 HTML 출력에선 제거된다.

링크 정의 이름은 문자, 숫자, 공백, 구두점으로 구성된다 - 그러나 대소문자는 가리지 _않는다_. 예를 들어 다음 두 개 링크는 같다:

    [link text][a]
    [link text][A]

_함축적 링크 이름_을 사용하면 링크 이름을 생략할 수 있다. 이 경우 링크의 제목 그 자체가 이름으로 사용된다. 그냥 빈 대괄호를 사용하면 된다. - 예: google.com 사이트를 링크하는 “Google” 라는 단어를 링크하기 위해 간단히 다음처럼 사용할 수 있다:

    [Google][]

그리고 다음처럼 링크를 정의한다:

    [Google]: http://google.com/

링크 이름에 공백을 포함할 수 있기 때문에 링크 제목으로 여러 단어를 사용해도 잘 동작한다:

    Visit [Daring Fireball][] for more information.

그리고 다음처럼 링크를 정의한다:

    [Daring Fireball]: http://daringfireball.net/

링크 정의는 마크다운 문서 어디에든 둘 수 있다. 나는 링크가 사용된 문단 바로 아래에 두는 경향이 있다. 그러나 원한다면 주석처럼 문서 끝에 모두 넣어도 된다.

이것은 실제 동작하는 참조 링크의 예이다:

    I get 10 times more traffic from [Google] [1] than from
    [Yahoo] [2] or [MSN] [3].

      [1]: http://google.com/        "Google"
      [2]: http://search.yahoo.com/  "Yahoo Search"
      [3]: http://search.msn.com/    "MSN Search"

함축적 이름을 사용한다면 다음처럼 쓸 수 있다:

    I get 10 times more traffic from [Google][] than from
    [Yahoo][] or [MSN][].

      [google]: http://google.com/        "Google"
      [yahoo]:  http://search.yahoo.com/  "Yahoo Search"
      [msn]:    http://search.msn.com/    "MSN Search"

위의 예는 모두 다음과 같은 HTML 출력을 만든다:

```html
<p>I get 10 times more traffic from <a href="http://google.com/"
title="Google">Google</a> than from
<a href="http://search.yahoo.com/" title="Yahoo Search">Yahoo</a>
or <a href="http://search.msn.com/" title="MSN Search">MSN</a>.</p>
```

비교를 위해 다음과 같이 마크다운의 인라인 링크 형식을 사용해서 쓴 같은 문장이 있다:

    I get 10 times more traffic from [Google](http://google.com/ "Google")
    than from [Yahoo](http://search.yahoo.com/ "Yahoo Search") or
    [MSN](http://search.msn.com/ "MSN Search").

참조 형식의 링크가 더 쉬운 것은 아니다. 중요한 것은 참조 형식의 링크로 소스 문서의 가독성이 엄청나게 올라간다는 것이다. 위의 예를 비교해 보면: 참조 링크를 사용하면 문단은 81자 길이다; 인라인 링크 형식으로는 176자이고, HTML 만으론 234자이다. HTML 만으로는 텍스트보다 마크업이 더 많다.

마크다운의 참조 형식 링크의 소스문서는 가독성이 올라가며, 브라우저로 랜더링한 최종 출력과 훨씬 더 비슷하게 된다. 문단의 마크업에 관련된 메타데이타를 이동할 수 있도록 함으로서 글을 쓰는 자연스런 흐름을 방해받지 않고 링크를 추가할 수 있다.

### EMPHASIS

마크다운은 별표(`*`)와 밑줄(`_`)을 강조 문자로 다룬다. 하나의 `*`나 `_`로 감싼 문자열은 HTML `<em>` 태그로 감싸게 된다. 두개의 `*`나 `_`로 감싸면 HTML `<strong>` 태그로 감싸게 된다. 예로, 다음은:

    *single asterisks*

    _single underscores_

    **double asterisks**

    __double underscores__

다음과 같이 출력된다:

```html
<em>single asterisks</em>

<em>single underscores</em>

<strong>double asterisks</strong>

<strong>double underscores</strong>
```

좋아하는 형식을 사용할 수 있다; 유일한 제한은 열고 닫을 때 같은 문자를 사용해야 한다는 것이다.

강조는 단어 중간에도 사용할 수 있다:

    un*frigging*believable

그러나, 만약 *나 _를 공백으로 감싸면 별표와 밑줄 문자 그대로 처리된다.

강조 구분자로 사용하지 않으려면 사용된 위치에서 별표와 밑줄을 표시하기 위해 역슬래시로 예외 처리하면 된다:

    \*this text is surrounded by literal asterisks\*

### CODE

문자 코드를 삽입하기 위해서는 역따옴표(`)로 감싼다. 정형화된 코드블럭과는 달리 문자 코드는 일반 문단에 삽입되는 코드를 의미한다. 예를 들면:

    Use the `printf()` function.

는 다음처럼 출력된다:

```html
<p>Use the <code>printf()</code> function.</p>
```

문자 코드에 역따옴표를 포함하기 위해 여러 개의 역 따옴표를 사용할 수 있다:

    ``There is a literal backtick (`) here.``

이렇게 출력된다:

```html
<p><code>There is a literal backtick (`) here.</code></p>
```

문자 코드를 감싼 역따옴표 구분자는 공백을 포함할 수 있다 - 열기 전 한개, 닫기 전 한개. 이렇게 함으로서 문자 코드의 시작 또는 끝에 역따옴표를 글자 그대로 표시할 수 있다:

    A single backtick in a code span: `` ` ``

    A backtick-delimited string in a code span: `` `foo` ``
    다음과 같이 출력된다:

```html
<p>A single backtick in a code span: <code>`</code></p>

<p>A backtick-delimited string in a code span: <code>`foo`</code></p>
```

문자 코드에서 `&`와 꺽쇠 괄호는 엔티티로 자동 인코드된다. 이것으로 HTML 코드를 포함하기 쉽다. 마크다운은 다음을:

    Please don't use any `<blink>` tags.

다음과 같이 변환한다:

```html
<p>Please don't use any <code>&lt;blink&gt;</code> tags.</p>
```

다음과 같이 쓸 수도 있다:

    `&#8212;` is the decimal-encoded equivalent of `&mdash;`.

다음과 같이 출력된다:

```html
<p><code>&amp;#8212;</code> is the decimal-encoded equivalent of <code>&amp;mdash;</code>.</p>
```

### IMAGES

인정하건대, 순수 텍스트 문서에 이미지를 배치할 수 있는 “자연스런” 문법을 만드는 것은 상당히 어렵다.

마크다운은 링크 문법과 유사하도록 의도된 이미지 문법을 사용한다: _인라인_과 _참조_

인라인 이미지 문법은 다음과 같다:

    ![Alt text](/path/to/img.jpg)

    ![Alt text](/path/to/img.jpg "Optional title")

말하자면:

* 하나의 감탄사 부호: `!`;
* 이미지 `alt` 속성 텍스트을 포함하는, 대괄호가 뒤따른다;
* 이미지의 URL이나 경로를 포함하는, 괄호가 뒤따른다. 옵션으로 작은 따옴표나 큰 따옴표로 에워싼 타이틀 속성을 줄 수도 있다.

참조 형식의 이미지 문법은 다음과 같다:

    ![Alt text][id]

여기서 “id”는 정의된 이미지 참조의 이름이다. 이미지 참조는 링크 참조와 동일한 문법으로 정의된다:

    [id]: url/to/image  "Optional title attribute"

이 글에선 마크다운은 이미지 크기를 지정하는 문법이 없다. 이미지의 크기가 중요하다면 그냥 일반적인 HTML `<img>` 태그를 사용할 수 있다.

## MISCELLANEOUS

### AUTOMATIC LINKS

마크다운은 URL과 이메일 주소를 위한 “자동” 링크를 만드는 간단한 형식을 지원한다: 간단히 URL과 이메일 주소를 꺽쇠 괄호로 감싼다. URL과 이메일 주소의 실제 텍스트를 표시하면서 클릭 가능한 링크로 만들고 싶다면, 다음과 같이 하면 된다:

    <http://example.com/>

마크다운은 이것을 다음처럼 바꾼다:

```html
<a href="http://example.com/">http://example.com/</a>
```

전자우편 주소에 대한 자동 링크도 비슷하지만 전자우편 주소는 스팸 봇의 접근을 막기위해 랜덤의 10진, 16진 인코딩을 한다는 점이 차이가 있다. 예를 들어 마크다운은 다음을:

    <address@example.com>

이렇게 바꾼다:

```html
<a href="&#x6D;&#x61;i&#x6C;&#x74;&#x6F;:&#x61;&#x64;&#x64;&#x72;&#x65;
&#115;&#115;&#64;&#101;&#120;&#x61;&#109;&#x70;&#x6C;e&#x2E;&#99;&#111;
&#109;">&#x61;&#x64;&#x64;&#x72;&#x65;&#115;&#115;&#64;&#101;&#120;&#x61;
&#109;&#x70;&#x6C;e&#x2E;&#99;&#111;&#109;</a>
```

브라우저에선 `address@example.com`로 클릭가능한 링크로 렌더링된다.

(이런 종류의 항목 인코딩 기법은 사실 많은 이메일-수집 봇을 실제 바보로 만드나, 모든 봇을 확실하게 바보로 만들 수는 없을 것이다. 하지않는 것 보단 낫다, 그러나 이렇게 공개된 이메일 주소는 결국 스팸을 받기 시작할 것이다.)

### BACKSLASH ESCAPES

마크다운 문법에서 특별한 의미를 갖는 문자를 글자 그대로 사용하려면, 역 슬래시(`\`) 예외처리(escape)를 사용할 수 있다. 예를들어 HTML의 `<em>` 태그 대신에 별표 문자로 하나의 단어를 감싸려면 별표 앞에 역 슬래시를 두면 된다.

    \*별표 문자\*

마크다운은 다음과 같은 문자에 대해 이스케이프를 지원한다:

    \   backslash
    `   backtick
    *   asterisk
    _   underscore
    {}  curly braces
    []  square brackets
    ()  parentheses
    #   hash mark
    +   plus sign
    -   minus sign (hyphen)
    .   dot
    !   exclamation mark

---
막상 번역하고 보니 쉬운 내용을 약간 어렵고 지루하게 표시한 결과가 아닌가 생각되지만 실제 마크다운을 사용할 때는 위의 내용을 다 알아야 하는 것이 아니다. #과 *, 들여쓰기 이 세가지만 알아도 블로깅하거나 문서를 작성하는 데 거의 불편함이 없다.

그러나, 마땅히 표준 문서에 가까운 글이 몇년 간 제대로 번역되지 않는(?) 것이 안타까워 번역해보았다.(거의 노가다:;)

## 관련 글들

* [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/)
* [PHP 마크다운 확장 번역](http://nolboo.github.io/blog/2014/03/25/php-markdown-extra/)
* [깃허브 냄새나는 마크다운 번역](http://nolboo.github.io/blog/2014/03/25/github-flavored-markdown/)

   [1]: http://daringfireball.net/projects/markdown/ (Permalink to Daring Fireball: Markdown)
   [2]: http://www.aaronsw.com/2002/html2text/
   [3]: http://docutils.sourceforge.net/mirror/setext.html
   [4]: http://www.aaronsw.com/2002/atx/
   [5]: http://textism.com/tools/textile/
   [6]: http://docutils.sourceforge.net/rst.html
   [7]: http://www.triptico.com/software/grutatxt.html
   [8]: http://ettext.taint.org/doc/
  