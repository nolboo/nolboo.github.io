---
layout: post
title: "빠르고 가벼운 개인용 마크다운 위키 - 비트버킷과 골룸을 활용"
description: "정보 홍수 속에서 살아남는 방법 중에 하나로 위키를 활용하기로 하였다. 개인 위키를 기준으로 하였을 때 기존의 위키 앱 대부분이 너무 무겁고 복잡하다고 생각하고 있었으며, 골룸과 비트버킷으로 빠르고 날쌘 마크다운 위키를 로컬과 온라인 모두에 구현하는 방법을 설명한다."
category: blog
tags: [markdown, wiki, bitbucket, gollum, git, github]
---

<div id="toc"><p class="toc_title">목차</p></div>

위키 쪽은 오래 전부터 기웃거렸지만 막상 사용하려면 맘에 드는 제품이나 서비스가 없어서, 해오던 대로 가볍고 쓸만한 메모 앱 여러 개를 용도에 따라 나누어 사용하는 것으로 대신하고 있었다. 그러나, 이젠 왠만한 메모앱으로 커버할 수 없을 정도로 저장된 정보가 많아져서 성능조차 느려졌고, 좀 더 체계적으로 정리할 필요성을 강하게 느끼고 있었다.

[위키](http://en.wikipedia.org/wiki/Wiki_software)는 1994년에 워드 커닝엄의 위키위키웹이 최초이며, 현재는 [많은 위키 소프트웨어가 나와있다](http://en.wikipedia.org/wiki/List_of_wiki_software). [위키 소프트웨어의 비교](http://en.wikipedia.org/wiki/Comparison_of_wiki_software)와 [마법사](http://www.wikimatrix.org/wizard.php) 등을 이용해 여러가지를 비교하면서 내가 생각하는 기존 위키 앱의 단점을 열거해보았다.

## 기존 위키 앱의 단점

*개인적으로 위키를 사용할 때의 지극히 주관적인 기준임.*

1. 아파치 등의 웹서버가 필요하다.
2. 데이타베이스가 필요하다.
3. 대부분 무겁고 느리다.
4. 마크다운과 코드 하일라이트 등의 필수적인(?) 문법이 지원되지 않는다.

단, 4번 항목은 플러그인으로 지원되는 것도 있다. 그러나, 위키를 웹에 올린다는 것을 전제로 하는 것이 많기 때문에 컴파일을 해야하고 시간도 걸린다. 최초의 위키앱이 웹에서 출발하고 대부분 협업을 전제로 하다보니 가지는 기능이겠지만, 개인 위키앱에선 아무래도 꺼리게 되었다.

[VoodooPad](https://plausible.coop/voodoopad/)와 같은 유명한(?) 맥용 위키 앱도 있다. 유료이기도 하지만, 별도의 화일 포맷을 사용하고, 내부문서 링크가 문서 내 모든 단어에 일괄적으로 적용되는 것을 보고 - 자세한 사용법을 익히기도 전에 질려서 - 바로 던져버렸다. 더 유명한 [DEVONthink](http://www.devontechnologies.com/products/devonthink/)도 있지만 위키 초보자인 나에겐 가격도 기능도 과한 것 같았다.(사실은 깊게 안써봐서 모름ㅎㅎ)

최근 마크다운을 지원하는 텍스트 기반의 위키 앱들이 하나둘 씩 눈에 띄여 사용해보려고 기본적인 설치법을 [블로깅](http://nolboo.github.io/blog/2013/07/22/install-markdoc/)하기도 했지만, 이마저도 제너레이트해야하는(즉, 마크다운을 지원하지만 결국 HTML로 변환해야한다) 등의 제약사항이 있어 잘 쓰지 않게 되었다.

그러던 중 애용하고 있는 메모앱 [NVAlt 2](http://brettterpstra.com/projects/nvalt/)에 개인적으로 수집하고 있던 IT 관련 한글 번역글 모음을 블로그의 [페이지](http://nolboo.github.io/trans/)로 공개하였다. 몇 가지 반응이 있었는데 [트친 중 한분이 위키로 만들어 누구나 참여할 수 있도록 하면 좋겠다고 의견을 주었다](https://twitter.com/naruter/status/364251953045708800).

게으름과 바쁨을 핑계로 차일피일 미루다가 깃허브 위키가 마크다운을 지원하고 [골룸](https://github.com/gollum/gollum)이란 위키 엔진을 기반으로 돌아간다는 것을 알게 되었고, 조금 공부를 해보았다.(*된장! 이 때부터 삽질이 시작될 줄은 몰랐다ㅠㅠ*)

## Gollum 설치

로컬 컴퓨터(맥 기준)에서 위키를 사용하기 위해 깃허브의 위키엔진인 [골룸](https://github.com/gollum/gollum)을 설치한다. 골룸은 깃 화일 시스템을 기반으로 한다.

먼저 루비와 파이썬 최신 버전이 설치되어 있어야 한다. 또한, [grit](https://github.com/github/grit) 때문에 윈도에서는 사용할 수 없다.(그러나, 로컬에서는 마음에 드는 마크다운 에디터를 위주로 사용하면 된다.)

터미널에서 다음과 같이 입력한다.

    sudo gem install gollum

Github Flavored Markdown(GFM)을 위해 다음을 설치한다.

    gem install github-markdown

### 실행

원하는 위키 디렉토리를 만들고

    mkdir my-wiki
    cd my-wiki
    git init
    touch Home.md
    git add -A
    git commit -m "Create Home.md"
    gollum

이제 웹브라우저 주소창에 `http://localhost:4567`을 입력하면 `Home.md`의 내용을 볼 수 있다.

![골룸 홈 화면](/images/posts/gollum-Home.jpg)

물론, 아직 아무런 내용이 없다. 여기서 우측 위의 `Edit` 버튼을 눌러 내용을 편집할 수도 있다. **골룸 안에서 편집하거나 생성한 화일은 커밋과 함께 저장된다. 즉, 터미널에서 별도의 커밋 명령을 할 필요가 없다.**

### 깃허브로 푸시

깃허브에 위키 전용 저장소를 만들고 위키를 활성화한 다음, 로컬의 내용을 푸시하여 여러 가지로 테스트를 해보았다. 잘되는 듯했으나 내부 마크다운 문서/이미지/화일 등의 상대주소가 잘 작동하지 않는다는 것과 골룸에서 만든 화일이 로컬에서 보이지 않는다는 것이다. 꽤 많은 시간을 버린 결과 깃허브 위키에서 마크다운만으론 위키를 편하게 사용하기 힘들다는 것을 알았다. 또한, 깃허브는 공개(비공개는 유료이다.)가 기본이다 보니 위키를 공개하면서 운영할 것도 아니기 때문에 비공개가 무료인 비트버킷 위키를 사용하기로 하였다. 

* *깃허브 위키 사용법은 협업 위키를 만드는 포스팅으로 올릴 예정이다.*

### 비트버킷으로 전환!

[bitbucket](https://bitbucket.org)은 깃허브와 유사한 분산버전관리 서비스이며, GUI 사용법도 깃허브와 거의 유사하다. 일단 비트버킷에 위키를 위한 저장소를 만들어 보자. 

![비트버킷 저장소 만들기](/images/posts/create-Bitbucket-wiki-repository.jpg)

`Project management`의 `Wiki` 항목을 체크한 후 `Create repository`를 눌러 저장소와 위키를 만든다. `Wiki` 탭을 클릭하여 주소를 얻는다.

![비트버킷 위키 저장소 주소](/images/posts/Bitbucket-wiki-home.jpg)

`Clone wiki`를 클릭해도 얻을 수 있고, 주소창에서 얻을 수도 있다. 가장 쉬운 방법은 저장소 주소에 `/wiki`를 추가하는 것이지만, 여기서 유념해야 할 것은 **위키는 항상 별도의 저장소(repository)로 취급된다**는 것이다. 이제 위키 주소를 원격저장소로 지정한다.

로컬의 위키 디렉토리에서:

    git remote add origin https://사용자명@bitbucket.org/사용자명/my-wiki.git/wiki

를 입력하여 로컬 위키의 원격 저장소를 지정한다.

자 이제, 로컬에선 서브라임 텍스트와 같은 에디터의 프리뷰나 골룸의 웹브라우징을 이용하여 편집하면서 컨텐츠를 미리보고, 온라인에선 비트버킷으로 편집하고 볼 수 있는 **마크다운 기반의 개인용 위키 시스템**이 만들어졌다.

## 기본 위키 문법 - 마크다운과 확장

깃허브 위키는 도움말이 매우 빈약하나 비트버킷은 잘 정리되어 있는 편이다. 자세한 것은 [비트버킷 위키 도움말](https://confluence.atlassian.com/display/BITBUCKET/Use+a+wiki)을 참조하면 된다.

Creole, Markdown, reStructuredText, Textile 등의 문법을 지원한다. 주로 사용할 마크다운 문법은 [GitHub Flavored Markdown](https://help.github.com/articles/github-flavored-markdown)와 유사하다. 상세한 마크다운 문법은 [마크다운 데모](https://bitbucket.org/tutorials/markdowndemo/overview)에 설명되어있다.

비트버킷 위키는 [파이썬 마크다운](https://pypi.python.org/pypi/Markdown)의 [안전모드](http://pythonhosted.org/Markdown/reference.html#safe_mode)로 작동하기 때문에, `<table>`와 같은 임의의 HTML 태그는 대체 또는 제거된다. - 물론 마크다운의 [표 문법](https://bitbucket.org/tutorials/markdowndemo/overview#markdown-header-tables)으로 표를 표현할 수 있다.

### 마크다운 링크

위키 내부문서 링크는 기본 마크다운 링크 문법을 그대로 따른다. 또한, 마크다운 화일의 확장자인 `.md` 또는 `.markdown`은 생략할 수 있다. 서브디렉토리도 `subdir/filename(.md)`와 같이 상대주소로 지정하면 위키의 내부링크 기능을 구현할 수 있다. 물론 외부 웹문서 링크도 가능하다.

### 이미지와 화일 링크

비트버킷에 이미지와 pdf 등의 화일을 업로드하고 링크할 수 있다. 

#### 이미지 링크

이미지를 하나의 디렉토리에 몰아넣거나 여러 디렉토리에 나누어서 관리할 수도 있지만, 서브 디렉토리마다 이미지를 넣은 후 상대주소로 지정하는 것을 선호한다. 예를 들어, 각 서브 디렉토리 밑에 `image`라는 디렉토리를 만들어 이미지를 넣은 후 다음과 같은 문법으로 링크하여 이미지를 문서에 직접 표현할 수 있다.

    ![Alt text](image/img.jpg "Optional title")

* [도움말](https://confluence.atlassian.com/display/BITBUCKET/Add+images+to+a+wiki+page)에는 `![Alt text](/path/to/img.jpg "Optional title")`처럼 절대주소 형태로 나와있으나 이대로 하면 실패하니 주의한다.

* **jpg와 gif를 지원하고 png는 지원하지 않으며, 링크할 경우 확장자까지 모두 입력해야 한다.**

#### 화일 링크

화일 링크는 마크다운 링크 문법을 그대로 따르고, 상대주소 형식으로 화일명과 확장자를 모두 적어준다. 서브 디렉토리 밑에 별도의 디렉토리를 만들고 링크한다. 예를 들면:

    [pdf 설명](pdf/filename.pdf)

크롬과 같은 브라우저는 pdf 미리보기를 지원하므로, 브라우저에서 바로 볼 수 있으며, 그렇지 않은 경우에는 다운로드 된다.

### 코드 블록

울타리 코드 블록(Fenced Code Block)은 아래의 두 가지 형식을 모두 지원한다.

#### 세개의 백틱 형식

    ```ruby
    require 'redcarpet'
    markdown = Redcarpet.new("Hello World!")
    puts markdown.to_html
    ```

#### Shebang 형식

    ```
    #!python

    def wiki_rocks(text):
        formatter = lambda t: "funky"+t
        return formatter(text)
    ```

골룸에선 두 번째 형식은 `#!python`이 나타나긴 하지만, 골룸은 혼자만 보는 용도라 그리 큰 문제는 아니라고 생각된다.

#### 코드 하일라이트

[Pygments](http://www.pygments.org/)를 이용한 코드 하일라이트가 지원된다.

### 기타

* 표는 아래와 같이 나타나며, 더 자세한 것은 [표 문법](https://bitbucket.org/tutorials/markdowndemo/overview#markdown-header-tables)을 참조한다.


| Right      | Left   | Center  |
| ---------: | :----- | :-----: |
| Computer   | $1600  | one     |
| Phone      | $12    | three   |
| Pipe       | $1     | eleven  |


* 주석과 페이지 목차인 `[TOC]` [문법](http://pythonhosted.org/Markdown/extensions/toc.html)를 지원한다. 단, 골룸에선 지원되지 않는다.

## 주의사항

* 새 화일을 추가하였을 때와 기존 화일을 변경하였을 경우엔 바로 커밋해야 한다. 그렇지 않으면 골룸이나 비트버킷에 변경사항이 나타나지 않는다. *단, 골룸이나 비트버킷에서 변경한 경우에는 별도의 커밋을 하지 않아도 된다.*
* 온라인에서 변경한 것을 놓치지 않기 위해 커밋하기 전에 `git pull`로 원격저장소의 변경사항을 합친다.
* 골룸에서 만든 문서가 로컬 디렉토리에는 보이질 않는다. 그러나, push하면 비트버킷에선 정상적으로 보인다. 아직 이유를 몰라서 골룸에선 새 글을 만들지 않는다. 편집하는 것은 잘된다. - *깃 화일 시스템에 대한 이해 부족인 것 같다.ㅠㅠ*

## 편리한 사용을 위한 보완

### 랜딩페이지

* 비트버킷은 저장소의 랜딩페이지를 wiki로 지정할 수 있다. 

![랜딩페이지 설정](/images/posts/Bitbucket-wiki-settings.jpg)

### 인덱스 보기

골룸에서 전체화일을 디렉토리형식으로 볼 수 있는 Files 메뉴가 비트버킷에선 지원되지 않는다. `index.wiki`라는 화일을 디렉토리마다 생성하여 다음 내용을 입력하여, `Home.md`의 처음이나 끝에 링크해두면 보완할 수 있다. (`<<toc / 2>>`이 핵심이며, 나머진 설명이다.)

    == Index ==

    An auto-generated list of all* pages. (* All pages in the root directory of the Wiki.)

    <<toc / 2>>

### 쉘 스크립트

주의사항에도 말하였듯이 매번 커밋을 하고 푸시하는 것도 번거로운데 그 때마다 여러 개의 명령을 입력하는 것은 매우 번거롭다. 다음과 같이 쉘 스크립트 화일을 만들어 한번에 실행하면 편리할 것이다.

텍스트 에디터로 `sync.sh`와 같은 화일을 만들어 다음과 같이 입력한다.

    #!/bin/bash -v
    git pull
    git add . -A
    echo -n "Input commit message: "
    read input
    git commit -m "$input"
    git push origin master

sync.sh를 실행할 수 있도록 다음 명령으로 화일 속성을 변경한다.

    chmod +rx sync.sh

실행한다.

    ./sync.sh

* 위의 과정이 익숙해질 경우 `#!/bin/bash -v`에서 `-v` 옵션을 제거하면 좀 더 조용하게 진행된다.

## 편리해진 점

* 마크다운이 지원되는 - 사실은 지원이 되지 않아도 상관없다 - 임의의 에디터로 로컬에서 편집 가능해졌다.
* 온오프라인 편집과 미리보기가 가능해졌다. 단, 비트버켓 위키 페이지는 모바일에 최적화되어 있지는 않다.
* 데이타베이스가 필요치 않아 마크다운 만으로 위키를 구성하여 가볍고 쉬우며, 향후 마크다운이 가능한 모든 플랫폼에 이식이 가능하다.
* 골룸의 검색 기능을 이용하여 필요한 내용을 신속하게 검색할 수 있다. 또한, `grep`이나 서브라임 텍스트의 검색 기능을 이용하여 좀 더 파워풀한 검색을 할 수도 있다.
* 마크다운 문서간 내부 링크 지원과 서브 디렉토리를 지원하여 위키를 보다 구조적이면서 규모있게 관리할 수 있다.
* 비트버켓 위키는 private 모드에선 혼자 또는 팀원들만 사용할 수 있지만, 언제든지 public으로 전환하여 모든 사람이 보고 편집할 수 있도록 만들 수 있다.

### 관련글

* [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/)

### 관련툴

* [Torchpad](http://torchpad.com/) : 깃을 기반으로 하는 마크다운/Latex/위키 문법을 지원하는 위키 서비스. 협업과 비공개를 지원하며, 드래그앤드랍으로 이미지를 쉽게 삽입 가능하고, 코드 하일라이트와 MathJax 문법을 지원한다. 현재 베타이며, 무료이다.