---
layout: post
title: "John Gruber Markdown Cheatsheet Test"
---

## Syntax Cheatsheet:

### Phrase Emphasis

*italic*   **bold**

_italic_   __bold__

*no-italic_ **no-bold__ 

_no-italic* __no-bold**

문장 중간에라도 * 나 _ 를 공백으로 감싸면 그대로 나타난다. 임의의 위치에서는 \* 또는 \_와 같이 예외처리할 수 있다.

### Links

Inline:    An [example](http://url.com/ "Title")

같은 서버안에서는 상대경로로 [link text](/same_server.ext "optional title")

Reference-style labels (titles are optional):

An [example][id]. Then, anywhere else in the doc, define the link:

   [id]: http://example.com/  "Title"

옵션으로 [example] [id] 처럼 공백을 넣을 수 있으며,

   [id]: http://example.com/  '추가 제목은 여기에'
   [id]: http://example.com/  (추가 제목은 여기에)
   [id]: <http://example.com/>  "optional title"
   [id]: http://example.com/longish/path/to/resource/here
       "추가 제목은 여기에"

등도 가능하다.

다음과 같이 함축된 링크명으로 간단히 줄일 수 있다. 링크명은 여러 단어도 가능하며 대소문자를 구분하지 않는다.

[Daring Fireball][]
[daring fireball]: http://daringfireball.net/

### Images

Inline (titles are optional):

![alt text](/path/img.jpg "Title")

Reference-style:

![alt text][id]

[id]: /url/to/img.jpg "Title"

### Headers

[Setext-style](http://docutils.sourceforge.net/mirror/setext.html):

Header 1
========

Header 2
--------


[atx-style](http://www.aaronsw.com/2002/atx/) (closing #'s are optional):

# Header 1 #

## Header 2 ####

### 헤더 3 ##

#### 헤더 4 #

##### 헤더 5

###### Header 6


### Lists

Ordered, without paragraphs:

1.  Foo
2.  Bar

단락이 있는 순차 항목:

3. 사랑

   사랑은 자기를 잃어버리는 것.

1. 결혼
   자신의 재산을 물려줄 사람을 지정하는 것.

Unordered, with paragraphs:

*   A list item.

    With multiple paragraphs.

*   Bar

    > 즐기는 곳이거나 먹는 것이거나 환영!

        들여쓰기 두번이면  코드블럭이 된다.

*   Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
    Aliquam hendrerit mi posuere lectus. Vestibulum enim wisi,
    viverra nec, fringilla in, laoreet vitae, risus.

You can nest them:

*   Abacus
    * answer
*   Bubbles
    1.  bunk
    2.  bupkis
        * BELITTLER
    3. burper
*   Cunning

다음과 같이 항목 중간에 빈줄이 있으면 항목들은 `<p>`로 감싸진다.

*   새

*   마술

1986\. What a great season. 은 리스트가 되지않는다.

### Blockquotes

> Email-style angle brackets
> are used for blockquotes.

> > And, they can be nested.

> > > 몇 개까지 될까?
> > > > 4개
> > > > > 5개
> > > > > > > > > > 10개
> > > > > > > > > > > > > > > > > > > > 20개

> #### Headers in blockquotes
>
> * You can quote a list.
> * Etc.

> > Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus. Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.

### Code Spans

`<code>` spans are delimited by backticks.

You can include literal backticks like `` `this` ``.

### Preformatted Code Blocks

Indent every line of a code block by at least 4 spaces or 1 tab.

This is a normal paragraph.

    This is a preformatted
    code block.

탭문자 들여쓰기

    탭을 입력할 수가 없으니 수동으로 테스트해야..

다음 코드블럭은 

    <div class="footer">
        &copy; 2004 Foo Corporation
    </div>

은 다음과 같이 바뀌어야 한다.

    <pre><code>&lt;div class="footer"&gt;
        &amp;copy; 2004 Foo Corporation
    &lt;/div&gt;
    </code></pre>

### Horizontal Rules

Three or more dashes or asterisks:

---

- - - 

***

* * *

___

____

_ _ _ 

-------------------------------

### Manual Line Breaks

End a line with two or more spaces:

Roses are red,  
Violets are blue.

### Automatic Link

<http://example.com/> 와 십진/16진 인코딩되는 <address@example.com>이 있다.

### Backslash Escapes

\\   backslash  
\`   backtick  
\*   asterisk  
\_   underscore  
\{}  curly braces  
\[]  square brackets  
\()  parentheses  
\#   hash mark  
\+   plus sign  
\-   minus sign (hyphen)   
\.   dot         
\!   exclamation mark