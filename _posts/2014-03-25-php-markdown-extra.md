---
layout: post
title: "PHP 마크다운 확장 번역"
description: "가장 많이 사용되는 마크다운 확장 PHP Markdown Extra 번역"
category: blog
tags: [php, markdown, extra, syntax]
---

<div id="toc"><p class="toc_title">목차</p></div>

예전에 [존 그루버 마크다운 페이지 번역](http://nolboo.github.io/blog/2013/09/07/john-gruber-markdown/) 포스트에 이어 마크다운에 관한 글은 참 오래간만에 올린다. 존 그루버가 마크다운 페이지가 워낙 오랫동안 업데이트되지 않아 여러 가지 확장 버전이 나왔는데 그 중 깃허브를 빼놓고는 가장 많이 사용되는 PHP Markdown Extra 페이지를 번역해보았다. 문맥이 이상하지 않는 선에서 발췌했으니 정확하게 알고 싶은 사람은 반드시 원본을 참조하기 바란다.

원본: [PHP Markdown Extra](http://michelf.ca/projects/php-markdown/extra/)

## PHP Markdown Extra

[Markdown Extra](http://michelf.ca/projects/php-markdown/extra/)는 순수 마크다운 문법에서 제공하지 않는 몇 가지 기능을 제공하는 PHP 마크다운 확장이다. 이 문서를 읽기 전에 [마크다운 문법](http://nolboo.github.io/blog/2013/09/07/john-gruber-markdown/)에 이미 친숙해야 한다.

### Inline HTML

마크다운에선 텍스트 중간에 HTML을 입력할 수 있으나, 블럭 엘리먼트에선 심각한 제한을 가지고 있다. 마크다운 문법 문서에서:

> 블럭 엘리먼트 - 예. `<div>`, `<table>`, `<pre>`, `<p>` 등 - 는 주변 콘텐츠와 빈 줄로 구분하고(한 칸씩 띄어주고) 블럭의 시작과 끝 태그는 탭이나 공백으로 들여쓰면 안된다.

이 제한은 PHP Markdown Extra에서 해제되고 다음의 덜 제한적인 두 가지로 대치된다:

1. 블럭 엘리먼트의 시작 태그 세 개 이상의 여백으로 들여 쓰지 말아야 한다. 그 이상으로 들여쓴 태그는 표준 마크다운 규칙에 따라 코드블럭으로 다루어진다.

2. 목록 안에서의 블럭 엘리먼트는 목록 항목이 들여쓰기 된 같은 크기의 여백으로 들여 쓰여야 한다.(추가적인 들여쓰기는 첫 시작 태그가 너무 많이 들여 쓰지 않는 한 코드블럭이 된다. - 첫 번째 규칙을 보라)

### Markdown Inside HTML Blocks

블럭레벨 태그 안에서 마크다운 형식의 텍스트를 넣을 수 있다. `markdown` 속성에 `1` 값을 줌으로 써 - `markdown="1"` 준다 - 다음은:

    <div markdown="1">
    This is *true* markdown text.
    </div>

다음으로 바뀐다:

    <div>

    <p>This is <em>true</em> markdown text.</p>

    </div>

PHP Markdown Extra는 `markdown` 속성을 넣은 블럭 엘리먼트에 따른 정확한 포매팅을 제공할 정도로 똑똑하다. 예를 들어 `<p>`태그에 `markdown` 속성을 적용하면, 스팬레벨 엘리먼트만을 만들어낸다. - 목록, 블럭인용, 코드블럭은 허용하지 않는다.

그러나, 몇 가지 애매모호한 경우가 있다. 예를 들면:

    <table>
    <tr>
    <td markdown="1">This is *true* markdown text.</td>
    </tr>
    </table>

테이블 셀은 스팬과 블럭 엘리먼트를 모두 포함할 수 있다. 위의 예에선 PHP Markdown Extra에선 스팬 레벨 규칙만을 적용한다. 블럭이 되길 원하면, `markdown="block"`을 대신 입력한다.

### Special Attributes

속성 블럭을 이용하여 id와 클래스 속성을 설정할 수 있다. 예로, 줄의 끝에서 헤더 다음에 중괄호안 해쉬로 시작하는 원하는 id를 다음과 입력한다:

    Header 1            {#header1}
    ========

    ## Header 2 ##      {#header2}

그런 후에 동일한 문서의 다른 부분에서 다음과 같이 링크를 만들 수 있다:

    [Link back to header 1](#header1)

클래스 이름을 넣으려면, 다음과 같이 하나의 점을 사용한다:

    ## The Site ##    {.main}

같은 특정 속성 블럭을 추가하여 id와 여러 클래스 이름을 결합할 수 있다.

    ## The Site ##    {.main .shine #the-site}

이 경우, 특정 속성 블럭은 다음과 함께 사용될 수 있다.

* headers,
* fenced code blocks,
* links, and
* images.

이미지와 링크에선 특정 속성 블럭을 주소 괄호 바로 다음에 넣는다.

    [link](url){#id .class}  
    ![img](url){#id .class}

또는 참조 스타일의 링크와 이미지를 사용할 경우엔, 다음과 같이 참조 라인 끝에 넣는다:

    [link][linkref] or [linkref]  
    ![img][linkref]

    [linkref]: url "optional title" {#id .class}

### Fenced Code Blocks

울타리 코드블럭은 마크다운의 코드블럭과 유사하나, 코드블럭을 구분하기 위해 들여 쓰지 않고 시작과 끝 울타리 라인을 넣는다. 코드블럭은 3 새 이상의 물결표 `~` 문자로 시작하고, 같은 수의 물결표 `~`로 끝난다. 예로:

    This is a paragraph introducing:

    ~~~~~~~~~~~~~~~~~~~~~
    a one-line code block
    ~~~~~~~~~~~~~~~~~~~~~

물결표 대신에 ``` 문자를 사용할 수도 있다:

    ``````````````````
    another code block
    ``````````````````

들여쓰기와 다르게, 울타리 코드 블럭은 빈줄로 시작하고 끝낼 수 있다.

    ~~~

    blank line before
    blank line after

    ~~~

들여쓴 코드블럭은 목록 들여쓰기가 우선하기 때문에 목록 다음에 바로 사용될 수 없다; 울타리 코드블럭은 그런 제한이 없다:

    1.  List item

        Not an indented code block, but a second paragraph
        in the list item

    ~~~~
    This is a code block, fenced-style
    ~~~~

울타리 코드블럭은 편집기에서 코드를 붙여 넣을 필요가 있을 때 텍스트 블럭의 들여쓰기를 증가시키지 않기 때문에 이상적이다.

드블럭에 적용할 클래스 이름을 특정할 수 있다. 이것은 언어에 따른 스타일을 달리 적용할 때 유용한다. 혹은 사용한 문법에 문법 강조를 지정할 때도 유용하다.

    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ .html
    <p>paragraph <b>emphasis</b>
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~

클래스 이름은 첫 울타리의 마지막에 둔다. 점이 시작할 수 있으나 필수는 아니다. 특정 속성 블럭을 사용할 수도 있다:

    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ {.html #example-1}
    <p>paragraph <b>emphasis</b>
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~

더 자세한 것은 [configuration](http://michelf.ca/projects/php-markdown/configuration/)를 참조한다.

### Tables

PHP Markdown Extra는 간단한 표를 위한 고유 문법이 있다. "간단한" 표는 다음과 같다:

    First Header  | Second Header
    ------------- | -------------
    Content Cell  | Content Cell
    Content Cell  | Content Cell

첫번째 줄은 행 제목이고; 두번째 줄은 제목과 내용 사이의 구분줄이다; 뒤따르는 줄은 테이블의 열이다. 행은 파이프(`|`) 문자로 나뉜다. HTML로 변환된 결과는 다음과 같다:

    <table>
    <thead>
    <tr>
      <th>First Header</th>
      <th>Second Header</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Content Cell</td>
      <td>Content Cell</td>
    </tr>
    <tr>
      <td>Content Cell</td>
      <td>Content Cell</td>
    </tr>
    </tbody>
    </table>

원한다면, 테이블 각 줄에 머리와 꼬리 파이프를 추가할 수 있다. 다음은 위와 같은 결과를 줄 것이다:

    | First Header  | Second Header |
    | ------------- | ------------- |
    | Content Cell  | Content Cell  |
    | Content Cell  | Content Cell  |

주의: 각 줄에 적어도 하나의 파이프가 필요하다. 즉, 하나의 행만을 가진 표를 만들려면 각 줄에 머리나 꼬리 파이프 또는 둘다를 추가해야 한다.

구분선에 콜론을 추가해서 각 행의 정렬을 지정할 수 있다. 구분선의 왼쪽에 콜론은 왼쪽 정렬될 것이며; 오른쪽의 콜론은 오른쪽 정렬이 될 것이다; 양쪽 모두의 콜론은 중앙 정렬된다.

    | Item      | Value |
    | --------- | -----:|
    | Computer  | $1600 |
    | Phone     |   $12 |
    | Pipe      |    $1 |

관련 행의 각 셀에 `align` HTML 속성이 적용된다.

마크다운 문법을 사용하여 각 셀의 컨텐츠에 스팬레벨 형식을 적용할 수 있다:

    | Function name | Description                    |
    | ------------- | ------------------------------ |
    | `help()`      | Display the help window.       |
    | `destroy()`   | **Destroy your computer!**     |

### Definition Lists

정의 목록은 사전과 같이 용어(term)와 용어의 정의(definition)로 구성된다.

PHP Markdown Extra에서 간단한 정의 목록은 한 줄의 용어와 이어지는 콜론과 그 용어에 대한 정의로 이루어진다.

    Apple
    :   Pomaceous fruit of plants of the genus Malus in 
        the family Rosaceae.

    Orange
    :   The fruit of an evergreen tree of the genus Citrus.

용어는 앞의 정의로부터 빈 줄로 구분되어야 한다. 정의는 여러 줄에 걸쳐 쓸 수 있으며, 이 경우 반드시 들여쓰여야 한다. 그러나 반드시 그렇게 하지 않아도 작동한다.

    Apple
    :   Pomaceous fruit of plants of the genus Malus in 
    the family Rosaceae.

    Orange
    :   The fruit of an evergreen tree of the genus Citrus.

위의 정의 목록은 각각 같은 HTML 결과를 가져온다:

    <dl>
    <dt>Apple</dt>
    <dd>Pomaceous fruit of plants of the genus Malus in 
    the family Rosaceae.</dd>

    <dt>Orange</dt>
    <dd>The fruit of an evergreen tree of the genus Citrus.</dd>
    </dl>

정의 표시자로서의 콜론은 왼쪽 마진에서 시작하고 세 개까지 들여 쓰일 것이다. 정의 표시자는 반드시 하나의 이상의 여백과 하나의 탭이 이어져야 한다.

정의 목록은 하나의 용어에 하나 이상의 정의를 가질 수 있다:

    Apple
    :   Pomaceous fruit of plants of the genus Malus in 
        the family Rosaceae.
    :   An American computer company.

    Orange
    :   The fruit of an evergreen tree of the genus Citrus.

하나의 정의에 하나 이상의 용어를 결부시킬 수도 있다:

    Term 1
    Term 2
    :   Definition a

    Term 3
    :   Definition b

정의 앞에 빈줄이 있다면 PHP Markdown Extra는 `<p>` 태그로 정의를 감쌀 것이다. 예를 들면:

    Apple

    :   Pomaceous fruit of plants of the genus Malus in 
        the family Rosaceae.

    Orange

    :    The fruit of an evergreen tree of the genus Citrus.

는 다음과 같이 변환된다:

```html
<dl>
<dt>Apple</dt>
<dd>
<p>Pomaceous fruit of plants of the genus Malus in 
the family Rosaceae.</p>
</dd>

<dt>Orange</dt>
<dd>
<p>The fruit of an evergreen tree of the genus Citrus.</p>
</dd>
</dl>
```

일반적인 목록 항목과 같이, 정의는 여러 문단을 포함할 수 있으며, 블럭인용, 목록, 다른 정의 목록과 같은 블럭레벨 엘리먼트를 포함할 수 있다.

    Term 1

    :   This is a definition with two paragraphs. Lorem ipsum 
        dolor sit amet, consectetuer adipiscing elit. Aliquam 
        hendrerit mi posuere lectus.

        Vestibulum enim wisi, viverra nec, fringilla in, laoreet
        vitae, risus.

    :   Second definition for term 1, also wrapped in a paragraph
        because of the blank line preceding it.

    Term 2

    :   This definition has a code block, a blockquote and a list.

            code block.

        > block quote
        > on two lines.

        1.  first list item
        2.  second list item

## Footnotes

각주(footnote)는 참조 링크처럼 작동한다. 각주는 두 가지로 이루어진다: 위첨자 숫자가 될 문자가 들어있는 표시자; 문서의 끝에 각주의 목록으로 위치되는 각주 정의. 각주는 다음과 같이 보인다:

    That's some text with a footnote.[^1]

    [^1]: And that's the footnote.

각주 정의는 문서의 아무 곳에나 있을 수 있으나, 각주는 텍스트 안에 링크될 순서대로 나열되어야 한다. 같은 각주에 두 개의 링크를 만들 수 없다는 것을 주의하라: 그렇게 한다면 두번째 각주 참조는 그냥 일반 텍스트로 남겨질 것이다.

각 각주는 다른 이름을 가져야 한다. 그 이름은 각주 정의에 각주 참조를 링크하기 위해 사용될 것이나, 각주의 번호부여에는 영향이 없다. 이름은 HTML의 ID 속성에 유효한 모든 문자를 사용할 수 있다.

각주는 블럭레벨 엘리먼트를 포함할 수 있다, 즉, 여러 단락, 목록, 블럭인용 등을 사용할 수 있다. 목록 항목에서 처럼 작동한다: 각주 정의에서 네 개의 여백으로 단락을 들여쓰기만 하라:

    That's some text with a footnote.[^1]

    [^1]: And that's the footnote.

        That's the second paragraph.

더 낫게 정렬하려면, 아래와 같이 각주의 첫 줄을 비우고 첫 번째 단락을 그 밑에 넣는다:

    [^1]:
        And that's the footnote.

        That's the second paragraph.

#### OUTPUT

현재 버전에서 출력은 [존 그루버 방식](http://daringfireball.net/2005/07/footnotes)을 따른다. 위의 첫번째 예의 기본 출력은 다음과 같다:

```html
<p>That's some text with a footnote.
   <sup id="fnref-1"><a href="#fn-1" class="footnote-ref">1</a></sup></p>

<div class="footnotes">
<hr />
<ol>

<li id="fn-1">
<p>And that's the footnote.
   <a href="#fnref-1" class="footnote-backref">&#8617;</a></p>
</li>

</ol>
</div>
```

링크에서 `class="footnote-ref"` 와 `class="footnote-backref">` 속성은 링크하고 있는 엘리먼트에 대한 관계를 표현한다. 다음과 같은 CSS 규칙으로 엘리먼트를 스타일링할 수 있다.

    a.footnote-ref { ... }
    a.footnote-backref { ... }

각주 링크와 백링크에서 `class`와 `title` 속성을 커스터마이징할 수 있다. 자세한 내용은 [환경설정](http://michelf.ca/projects/php-markdown/configuration/)을 참조하라.

### Abbreviations

HTML tag `<abbr>`에 해당하는 약어를 지원한다. 다음과 같이 약어 정의를 만든다:

    *[HTML]: Hyper Text Markup Language
    *[W3C]:  World Wide Web Consortium

그리고 문서의 어딘가에 텍스트를 쓴다:

    The HTML specification
    is maintained by the W3C.

그러면 해당 단어들은 다음과 같이 된다:

    The <abbr title="Hyper Text Markup Language">HTML</abbr> specification
    is maintained by the <abbr title="World Wide Web Consortium">W3C</abbr>.

약어는 대소문자를 구별하고 정의될 때 여러 단어에 걸칠 수 있다. 빈 정의도 가질 수 있으며, 이 경우 `<abbr>` 태그는 추가되고 `title` 속성은 생략된다.

    Operation Tigra Genesis is going well.

    *[Tigra Genesis]:

약어 정의는 문서 어디에나 있을 수 있으며, 최종 문서에선 제거된다.

### Emphasis

한 단어 중간의 밑줄은 문자 그래도 취급된다. 밑줄 강조는 전체 단어에 대해서만 작동한다. 단어의 어떤 부분만 강조할 필요가 있으면, 별표(`*`)를 사용할 수 있다.

예로, 다음은:

    Please open the folder "secret_magic_box".

PHP Markdown Extra는 단어의 중간에 밑줄이 있기 때문에 강조하지 않는다. HTML 결과는 다음과 같다:

    <p>Please open the folder "secret_magic_box".</p>

밑줄 강조는 다음과 같이 전체 단어들을 강조할 때만 작동한다:PHP

    I like it when you say _you love me_.

### Backslash Escapes

PHP Markdown Extra는 콜론(`:`)과 파이프(`|`)를 백슬래쉬 예외처리에 추가한다. 정의 목록과 표로 변환되는 것을 예방한다.

### Thanks

## 관련 글들

* [깃허브 냄새나는 마크다운 번역](http://nolboo.github.io/blog/2014/03/25/github-flavored-markdown/)
* [존 그루버 마크다운 페이지 번역](http://nolboo.github.io/blog/2013/09/07/john-gruber-markdown/)
* [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/)