---
layout: post
title: "Markdoc 설치"
description: "마크다운으로 위키를 운영할 수 있는 오픈소스 Markdoc을 설치하는 방법"
category: blog
tags: [markdown, wiki]
---

<div id="toc"><p class="toc_title">목차</p></div>

* [Markdoc 공식 사이트](http://markdoc.org/)

터미널에서

    $ easy_install Markdoc

    Finished processing dependencies for Markdoc

위의 메시지가 나오면 성공.

## 위키 만들기

### 위키 초기화

    $ markdoc init my-wiki --vcs-ignore hg

    markdoc.vcs-ignore: INFO: Writing ignore file to .hgignore
    markdoc.init: INFO: Wiki initialization complete
    markdoc.init: INFO: Your new wiki is at: .../my-wiki

    $ cd .../my-wiki 

### 페이지 편집

wiki/ 서브 디렉토리에 문서가 위치하며, 마크다운 파일이다. .md 확장자를 가지며, wiki configuration에서 추가할 수 있다. wiki/ 디렉토리에서 마크다운 화일 작성.

### 빌드

아래 명령을 내리면 .html/ 서브디렉토리에 모든 HTML이 제너레이트된다.

    $ markdoc build

### 보기

    $ markdoc serve
    markdoc.serve: INFO: Serving on http://127.0.0.1:8008


웹브라우저에서 를 열면 보인다.

## 기타 기능

  * 구글 애널리틱스를 한줄 코드로 삽입
  * rsync를 이용해 원격 서버와 동기화
  * Pygments 지원 문법  