---
layout: post
title: "깃허브 취향의 마크다운 번역"
description: "깃허브가 유명해지면서 깃허브에서 만든 마크다운 확장인 Github Flavored Markdown(GFM) 확장이 많이 사용되고 있다. 예전 페이지 번역"
category: blog
tags: [github, markdown, extra, gfm, syntax]
---

<div id="toc"><p class="toc_title">목차</p></div>

번역할 당시에는 딱 한 페이지만 있었는데 지금은 아래와 같이 가이드와 여러 페이지로 나누어서 설명해 놓았다. 이 글은 예전 페이지의 번역이다.

- [Writing on GitHub · GitHub Help](https://help.github.com/articles/writing-on-github)
- [GitHub Flavored Markdown · GitHub Help](https://help.github.com/articles/github-flavored-markdown)
- [Mastering Markdown · GitHub Guides](http://guides.github.com/overviews/mastering-markdown/)

누군가 부탁하여 올려놓긴 하는데 시간이 되면 위의 페이지를 전체적으로 정리할 필요가 있을 것 같다.

## GitHub Flavored Markdown

깃허브는 파일, 이슈, 코멘트에 [GitHub Flavored Markdown(GFM)](https://help.github.com/articles/github-flavored-markdown)를 사용한다. standard Markdown(SM)와는 몇 가지 중요한 방법에서 차이가 있으며, 몇 가지 추가 기능이 있다.

예제로 배우는 것을 좋아하면 다음 소스와 결과를 봐라:

* [Source](http://github.github.com/github-flavored-markdown/sample_content.html)
* [Result](https://github.com/mojombo/github-flavored-markdown/issues/1)

### Newlines

GFM이 도입한 가장 큰 차이점은 줄바꿈을 다루는 것이다. SM에서는 문단을 강제 줄바꿈해도 한 개의 문단으로 결합된다. 이것이 의도치않은 포맷 에러를 엄청나게 일으킨다는 것을 알았다. GFM은 실제 줄바꿈을 의도한 대로 새로운 줄로 다룬다.

    Roses are red
    Violets are blue

### Multiple underscores in words

단어의 *부분*에서 기울어지는 것은 바람작하지 않다. 특히, 코드와 이름은 종종 여러 `_`와 함께 나타난다. 그래서, GFM은 단어들 안의 여러 언더스코어는 무시한다.

    perform_complicated_task
    do_this_and_do_that_and_another_thing

### URL autolinking

URL을 입력하면 URL에 대한 링크도 바꿔준다.

### Strikethrough

SM에는 없는 취소선 텍스트 문법을 추가한다.

    ~~Mistaken text.~~

### Fenced code blocks

마크다운은 줄 앞에 4개의 여백이 있는 텍스트를 코드블럭으로 변환한다. GFM에서도 지원되며, 울타리 블럭도 지원하다. 코드블럭을 들여쓰기 없이 `` ``` ``으로 감싸면 된다. 두 형태의 코드블럭 바로 앞에는 빈 줄이 있어야 한다는 것을 기억하라.

    Here's an example:

    ```
    function test() {
      console.log("notice the blank line before this function?");
    }
    ```

여백으로 코드블럭을 들여쓸 때에는, 코드블럭을 적절하게 표시하기 위해서는 8번의 들여쓰기가 필요하다는 것을 기억하라.

### Syntax highlighting

코드블럭에서 한발 더 나아가 필요할 때 문법 강조를 할 수 있다. 울타리 블럭에서 언어 식별자를 선택적으로 추가하면 문법 강조가 된다. 예를 들어 Ruby 코드를 문법 강조하기 위해서는:

    ```ruby
    require 'redcarpet'
    markdown = Redcarpet.new("Hello World!")
    puts markdown.to_html
    ```

언어 감지와 문법 강조를 위해 [Linguist](https://github.com/github/linguist)을 사용한다. 어떤 키워드가 유효한지 [언어 YAML 파일](https://github.com/github/linguist/blob/master/lib/linguist/languages.yml)을 숙독하라.

### Task Lists

목록 항목 앞에 `[ ]`이나 `[x]`(각각, 미결 혹은 완결)로 시작함으로서 목록을 [할일 목록](https://github.com/blog/1375-task-lists-in-gfm-issues-pulls-comments)으로 바꿀 수 있다.

    - [x] @mentions, #refs, [links](), **formatting**, and <del>tags</del> supported
    - [x] list syntax required (any unordered or ordered list supported)
    - [x] this is a complete item
    - [ ] this is an incomplete item

이 기능은 이슈와 Pull Request 설명, 코멘트에서 사용할 수 있다. Gist 마크다운 화일은 물론 코멘트에서 가능하다. 할일 목록은 체크를 키고 끌 수 있는 체크박스로 변환된다.

자세한 것은 [할일 목록 블로그 글](https://github.com/blog/1375-task-lists-in-gfm-issues-pulls-comments)을 봐라.

### Quick quoting

키보드의 `r`로 현재 이슈와 풀 리퀘스트에 답할 수 있다. `r`을 누르기 전에 토론 쓰레드에서 선택한 텍스트는 코멘트에 자동으로 추가되고 블럭인용으로 표시된다.

### Name and Team @mentions autocomplete

`@`를 누르면 프로젝트의 사람이나 팀의 목록을 불어온다. 항목은 타이핑하는 대로 걸러져 찾으려는 사람 또는 팀의 이름을 발견하게 될 것이다. 선택하기 위해 화살표를 사용할 수 있으며 엔터를 치거나 이름 완성을 위해 탭할 수도 있다. 이슈에 모든 팀원을 추가하려면 @organization/team-name을 입력한다.

결과는 저장소 협력자와 쓰레드 참가자로 제한되며, 글로벌 검색이 아니다.

[유저](https://github.com/blog/1004-mention-autocompletion)와 [팀](https://github.com/blog/1121-introducing-team-mentions)에 대한 @멘션 자동완성에 관한 더 많은 정보는 블로그 글들을 체크하라.

### Emoji autocomplete

`:`를 타이핑하면 이모티콘 추천 목록을 불러온다. :+1:

### Issue autocompletion

`#`을 타이핑하면 이슈와 풀 리퀘스트 추천 목록을 불러온다.

### Zen Mode (fullscreen) writing

글을 쓸 때 전체화면 모드가 가능하다. 코멘트, 이슈, 풀 리퀘스트 폼에서 다음과 같은 버튼을 발견할 수 있다.

![](https://f.cloud.github.com/assets/296432/93897/edc40e08-6638-11e2-8b69-d9b4d7781406.png)

자세한 것은 [Zen writing mode](https://github.com/blog/1379-zen-writing-mode)를 체크하라.

### References

특정 참조는 자동링크 된다:

    * SHA: 16c999e8c71134401a78d4d46435517b2271d6ac
    * User@SHA: mojombo@16c999e8c71134401a78d4d46435517b2271d6ac
    * User/Project@SHA: mojombo/github-flavored-markdown@16c999e8c71134401a78d4d46435517b2271d6ac
    * #Num: #1
    * User#Num: mojombo#1
    * User/Project#Num: mojombo/github-flavored-markdown#1

은 다음과 같다:

* SHA: [16c999e]()
* User@SHA: [mojombo@16c999e]()
* User/Project@SHA: [mojombo/github-flavored-markdown@16c999e]()
* #Num: [#1]()
* User#Num: [mojombo#1]()
* User/Project#Num: [mojombo/github-flavored-markdown#1]()

### Code

## 관련 글들

* [PHP 마크다운 확장 번역](http://nolboo.github.io/blog/2014/03/25/php-markdown-extra/)
* [존 그루버 마크다운 페이지 번역](http://nolboo.github.io/blog/2013/09/07/john-gruber-markdown/)
* [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/)
