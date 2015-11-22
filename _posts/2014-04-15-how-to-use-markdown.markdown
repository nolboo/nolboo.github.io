---
layout: post
title: "놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우"
description: "마크다운으로 문서 작업을 하는 가장 큰 장점은 빠르고 쉽다는 것이다. 블로그, 위키, 이메일 등의 문서작업을 중심으로 놀부의 마크다운 워크플로우를 소개한다."
category: blog
tags: [markdown, workflow, blog, wiki, email]
---

<div id="toc"><p class="toc_title">목차</p></div>

마크다운으로 문서 작업할 때 가장 큰 장점은 **빠르고 쉽다**는 것이다.(마크다운 툴을 고를 때에도 빠른 속도에 중점을 둔다.) 마크다운을 지원하는 앱이나 서비스는 많다. 최근에는 쏟아져 나온다는 표현이 적당할 정도이다. 블로그 플랫폼만 보더라도 유명서비스인 텀블러, 워드프레스 등이 마크다운을 지원하게 되었고, [Scriptogr.am](http://scriptogr.am/), [Calepin](http://calepin.co/), [Svbtle](https://svbtle.com/), [Ghost](https://ghost.org/) 등의 마크다운 전용 블로그 플랫폼이 앞다퉈 선보이고 있다. 이러한 마크다운의 최근 인기는 아는 사람은 알고 모르는 사람만 모른다.(응?) 그래서, 이 글에선 마크다운이 왜 그렇게 인기가 있는지 간략하게나마 살펴보고, 현재 내가 마크다운을 활용하고 있는 워크플로우를 설명한다.

마크다운에 대한 글을 이미 [여러 번 블로그에 올렸기](http://nolboo.github.io/search/?tags=markdown) 때문에 이 글에서는 마크다운을 실제 활용할 때 느낀 장단점부터 살펴보자.

## 마크다운의 장점

1. **쉽다:**
일반인들도 5분이면 배울 수 있을 정도로 쉽고 간단하다. 구조적인 글을 빠르게 작성할 수 있고 나중에 읽기도 쉽다. 또한, 작성한 마크다운 파일을 HTML 페이지나 PDF 등으로 한 방에 변환하여 배포하는 것도 쉽다.

2. **키보드 중심:**
글을 마우스로 작성하는 사람은 없을 것이다. 대부분의 디지털 글쓰기는 키보드를 중심으로 이루어진다. 마크다운은 글의 꾸밈을 키보드만으로도 조작할 수 있어 쉽게 구조적인 글쓰기를 할 수 있다. *특히 모바일에서 글을 쓸 때는 키보드 중심이라는 것이 더 큰 장점이 된다.*

3. **빠르다:**
마크다운은 순수 텍스트(plain text) 기반이기 때문에 텍스트 에디터만 있으면 마크다운 문서를 작성할 수 있다. 대부분의 마크다운 에디터가 가벼워서 프로그램 실행도 빠르지만, 내 경우엔 메모리를 적게 차지하는 에디터를 선택하여 계속 실행해 놓는다.

4. **검색과 백업:**
플레인 텍스트 기반이라는 것은 검색할 때에도 장점이다. 아무리 많은 파일이 있더라도 적합한 툴만 선택하면 순식간에 원하는 내용을 검색하여 찾아낼 수 있다. 또한, 화일 크기가 매우 작아서 로컬 디스크 보관이나 드랍박스 등을 이용한 백업도 가볍고 빠르다. 수천 라인의 마크다운 파일 1,000개라 할지라도 100MB도 되지 않아 드랍박스에서 무료로 제공되는 2기가 용량의 1/10도 차지하지 않는다.

5. **지원:**
아직 마크다운을 접하지 못한 분들은 의외겠지만, 마크다운을 지원하는 소프트웨어 및 서비스는 일일이 열거하기 어려울 정도로 많다. 마크다운 전용이 아닌 경우에는 플러그인이나 모듈 형식으로 지원되는 경우가 많다. 마크다운 서비스나 앱에 대한 참조 링크들:
    - [Useful Markdown Editors and Tools](http://codegeekz.com/markdown-editors-and-tools/)
    - [78 Tools for Writing and Previewing Markdown](http://mashable.com/2013/06/24/markdown-tools/)
    - [35+ Markdown Apps for the Mac](http://mac.appstorm.net/roundups/productivity-roundups/35-markdown-apps-for-the-mac/)

### 단점

1. **표준의 부재:**
존 그루버가 10년 전 [기본 문법](http://daringfireball.net/projects/markdown/)([번역](http://nolboo.github.io/blog/2013/09/07/john-gruber-markdown/))을 제안한 이후로 손 놓고 있다. [스택오버 플로우의 공동 창업자 제프 앳우드가 존 그루버의 관심을 호소](http://blog.codinghorror.com/responsible-open-source-code-parenting/)하기도 하였지만 별무소식인 것 같다. 이러한 것을 보완하려고 [Markdown Extra](http://michelf.ca/projects/php-markdown/extra/))([번역](http://nolboo.github.io/blog/2014/03/25/php-markdown-extra/)), [GitHub Flavored Markdown(GFM)](https://help.github.com/articles/github-flavored-markdown)([번역](http://nolboo.github.io/blog/2014/03/25/github-flavored-markdown/)), [MultiMarkdown](http://fletcherpenney.net/multimarkdown/) 등이 나왔으나 문법이 서로 다른 부분이 조금 있다. 때로는 구현하는 서비스나 앱에서 조차도 보완 부분에 대해서는 제각각인 경우가 많다. 그러나 기본 문법과 많이 쓰이는 확장 문법은 대부분 동일하게 구현하니 일반적인 사용에는 그리 큰 문제가 없다.

2. **실시간 뷰어가 대체로 느리다:** 
마크다운이 익숙하지 않는 초기에는 뷰어에서 실시간 확인하면서 작업하고 싶은 경우가 많다. 그러나 어느 정도 익숙해지면 실시간 뷰어가 그리 필요치 않다.

## 간단한 마크다운 문법

|                   보기                  |                     문법                    |
|-----------------------------------------|---------------------------------------------|
| **볼드체**                              | `**볼드체**`                                |
| *이탤릭체*                              | `*이탤릭체*`                                |
| [링크](http://nolboo.github.io)         | `[링크명](http://some-url.com)`               |
| ![마크다운 로고](http://bit.ly/1nmhGjE) | `![대체 텍스트](http://some-url.com/a.png)` |
| 블럭 인용                               | 각 문단의 첫 줄 앞에 `>`                    |
| 목록                                    | 줄의 처음을 `- ` 또는 `1. `로 시작          |
| 코드블럭                                | 줄의 처음을 `Tab`으로 시작                  |

위의 내용만 알면 메일은 물론 웬만한 블로그 글을 작성할 수 있다. 아래에서 추천하는 마크다운 에디터 중의 하나를 선택하여 실시간 뷰어 모드를 켜놓고 하나씩 입력해보면 5분도 안되어서 다 익힐 수 있다. 마크다운이 어느 정도 익숙해지고 위의 문법만으로 부족하다고 생각되는 분들을 위해 마크다운 문법 문서들을 번역해 놓았다.

* [존 그루버 마크다운 페이지 번역](http://nolboo.github.io/blog/2013/09/07/john-gruber-markdown/)
* [PHP 마크다운 확장 번역(Markdown Extra)](http://nolboo.github.io/blog/2014/03/25/php-markdown-extra/)
* [깃허브 냄새나는 마크다운 번역(Github Flavored Markdown:GFM)](http://nolboo.github.io/blog/2014/03/25/github-flavored-markdown/)

## 데스크탑 환경

맥북에어에서 주로 글을 쓰기 때문에 맥용 앱을 고르는 것에 신경을 많이 썼고, 지금도 지속적으로 모니터링을 하고 있다. 여기서는 주로 사용하는 서브라임 텍스트 3와 플러그인들, 심플노트와 NVAlt 2, 그 외 때때로 사용하는 에디터와 유틸리티를 설명한다.

### 서브라임 텍스트 3와 플러그인들

#### Sublime Text

[서브라임 텍스트 3(ST3)](http://www.sublimetext.com/)는 빠른 속도와 수많은 플러그인 등의 장점으로 프로그래밍 에디터로 많이 사용하지만, 마크다운 에디터로서도 손색이 없어서 내가 글을 쓸 때 가장 애용하는 도구이다. 커다란 마크다운 파일을 다룰 때에도 거의 느려지지 않고 ST3가 가진 강력한 속도를 그대로 누릴 수 있다. 또한, 문서 검색이나 디렉터리(서브 디렉터리를 포함) 내에서의 검색 기능(<kbd>⌘</kbd>+<kbd>⇧</kbd>+<kbd>F</kbd>)도 강력해서 많은 양의 마크다운 문서 중에서 내가 원하는 것을 빠르게 찾을 수 있다.

ST3 자체의 속도와 검색 외에도 플러그인으로 여러 가지 기능을 추가할 수 있다. 주요 플러그인을 살펴보자.

#### MarkdownEditing: 편집

[MarkdownEditing](https://github.com/SublimeText-Markdown/MarkdownEditing)은 마크다운 문법 하이라이트와 그 외 편리한 기능을 추가해주기 때문에 필수 플러그인이다. 문법 하이라이트는 밋밋한 마크다운에 강약을 주어 구조적으로 볼 수 있게 해준다. 마치 실시간 프리뷰와 편집 모드의 중간 정도로 보는 느낌이 든다. 플러그인 설치 후에 확장자가 .md, .markdown인 파일을 열어보면 한눈에 알 수 있다. 아래 그림은 light 테마를 적용한 문법 하이라이트 예:

![마크다운에디팅 라이트 테마](https://raw.github.com/SublimeText-Markdown/MarkdownEditing/master/screenshots/light.png)

- 기본 마크다운, 깃허브의 GFM, 멀티 마크다운의 문법을 지원한다.
- 괄호 및 백틱 페어링, 문자열을 선택하고 `*` 또는 `**`로 글자 강조, 자동 목록 등의 편리 기능을 제공한다.
- 문자열을 선택한 후 클립보드의 링크를 <kbd>⌘</kbd>+<kbd>⌥</kbd>+<kbd>V</kbd> 단축키로 붙여 넣으면 마크다운 링크가 한 번에 완성되는 등의 편리한 단축키들이 준비되어 있다.

#### OmniMarkupPreviewer: 실시간 미리보기

실시간 미리보기를 제공하는 툴도 많지만 대부분 파일 크기가 커지면 매우 느려지는 단점이 있다. [OmniMarkupPreviewer](https://github.com/timonwong/OmniMarkupPreviewer) 플러그인은 느려지는 현상이 가장 적고 저장을 하지 않아도 실시간으로 웹 브라우저에서 보여주며, 한글이 조합되는 도중에도 자소 단위로 보여준다. 웬만한 유료 뷰어보다 낫다!

- 웹 브라우저에서 실시간 미리보기 단축키는 <kbd>⌘</kbd>+<kbd>⌥</kbd>+<kbd>O</kbd>이다.
- Markdown 뿐만아니라 reStructuredText, WikiCreole 등의 마크업 언어를 지원한다.

#### Open URL: 웹브라우저에서 링크 열기

ST3를 마크다운 에디터로 사용할 때 불편한 점 중 하나가 오트링크(url를 자동으로 인식하여 클릭할 수 있게 해주는 기능)가 지원되지 않는다는 것이다. [Open URL](https://github.com/noahcoad/open-url) 플러그인은 url을 <kbd>⌥</kbd>+`더블클릭`하거나 우클릭하여 선택하면 웹 브라우저에서 url을 열어준다. url 이외에도, 폴더라면 파인더에서 해당 폴더를 열어주고, 파일이라면 편집하거나 실행할 수 있고, 일반 텍스트라면 구글 검색을 수행한다.

#### Table Editor: 표 만들기

마크다운에서 표를 그리기는 쉽지만 예쁘게 그리기가 쉽지 않다. 물론 문법만 바르면 미리보기나 변환된 HTML/PDF에선 예쁘게 나온다. [Table Editor](https://github.com/vkocubinsky/SublimeTableEditor) 플러그인은 에디터 모드에서 표를 자동으로 정렬해주고 `tab`키를 누르면 다음 셀에 정확히 위치시켜주어 편리하게 표를 작성할 수 있게 해준다. 단, 아직은 한글 지원이 알파 버전 상태라 나눔고딕코딩과 같은 고정폭 글꼴을 사용해야(폰트 크기를 짝수로 설정) 예쁘게 사용할 수 있다.

    | Name | Phone |
    |-

플러그인을 설치하고 위의 표 예제를 복사한 다음 `tab` 키를 눌러보면 반할 것이다. 기존의 정렬되지 않은 표가 있다면 아무 셀에서 `tab` 키를 누르면 더욱 반하게 될 것이다. <kbd>⌥</kbd>+<kbd>⇧</kbd>+`네 개의 화살표키`로 행/열의 삽입과 삭제도 가능하다.

csv를 표로 바꾸는 것도 가능하다고 하나 어찌 된 일인지 잘 안된다. 그래서 (특히 큰 테이블의 경우에는) 구글 스프레드시트에서 작성하여 .csv로 내보내고 [Markdown Tables generator](http://www.tablesgenerator.com/markdown_tables)에서 임포트하는 것을 선호한다. 그렇게 작성한 중 하나가 [자바스크립트 제대로 배우기 스터디 그룹 포스트](http://nolboo.github.io/blog/2014/03/18/how-to-learn-javascript-properly-study/)의 마지막 커리큘럼 표이다. 170 셀을 가진 표를 뚝딱! 만들 수 있었다.

#### 링크 북마클릿

링크 : [A Markdown Link Bookmarklet](http://walterhiggins.net/blog/A-Markdown-Link-Bookmarklet.html)

오토링크 기능이 있는 에디터는 웹 브라우저의 링크를 복사해서 그대로 붙여 넣으면 되지만, 아무래도 누드 링크 주소를 그대로 보여주는 것은 보기에도 좋지 않고 나중에 포스트 등을 작성할 때 마크다운 링크로 변환해야 하는 것도 귀찮다. 이럴 때는 MarkdownEditing의 링크 붙여넣기 단축키도 좋지만, 웹페이지에서 제목과 링크를 한 번에 복사하는 것이 더 편하다. 웹 브라우저의 북마크바에 원하는 이름의 북마크를 하나 만들고 주소란에 다음의 코드를 복사하여 북마클릿을 만들면 된다.

```javascript
javascript:void(prompt("","["+document.title+"]("+location.href+")"));
```

원문에는 참조링크를 만드는 북마클릿 코드도 있다.

> **서브라임 사용할 때 주의할 점**
>
> 위와 같은 환경을 구축하면 용량이 큰 마크다운 파일도 빠르고 직관적으로 다룰 수 있게 된다. 한 가지 단점은 서브라임 텍스트 3에서 한글 오토마타를 완벽하게 지원하지 않기 때문에 가끔 입력 중인 글자를 먹어버리고 다른 곳에서 입력을 시작하면 그곳에다 먹어버린 글자를 풀어놓는다. 이 점을 보완하기 위해서는 입력한 글자가 문장의 마지막이라면 마침표를 찍고, 그렇지 않을 때에는 화살표 키로 움직여서 입력완료를 ST3에 알려줘야 한다. 현재로선 주의해서 사용하는 수밖에;;

### nvALT 2 와 심플노트

[nvALT 2](http://brettterpstra.com/projects/nvalt/)는 가볍고 빨라서 노트 앱 중에서 가장 자주 사용하는 맥앱이며, 여러 가지 정보를 저장해두거나 글을 쓰기 시작하는 출발점이다. 파일이 수천 라인을 넘어가면 버벅대기 시작하지만 그럴 때는 외부 에디터로 설정한 서브라임 텍스트 3를 불러(<kbd>⌘</kbd><kbd>⇧</kbd><kbd>E</kbd>) 글쓰기를 이어간다. 심플노트로 동기화하도록 설정하면 백업이나 버전 관리도 같이 활용할 수 있다.

[Simplenote](http://simplenote.com/)는 [작년에 워드프레스에 인수된](http://techcrunch.com/2013/01/24/wordpress-simperium-simplenote/) 서비스이며, [Simperium](http://simperium.com/)이라는 독자적인 데이터 레이어를 기반으로 하고 있다. 필자는 느려터진 에버노트 - 많이 개선되었지만, 아직도 느리다고 생각해서 웹페이지 저장용으로만 사용한다 *[2015년 9월에는 곧 망하는 유니콘이라는 글도 올라온다](https://syrah.co/joshdickson40/55e1beac15970d6c01395d9d)* -  대신 심플노트를 윈도 시절부터 사용해 왔고, 맥으로 넘어와서도 심플노트를 사용하기 위해 제일 먼저 찾은 것이 nvALT이다.

![nvALT 2](http://brettterpstra.com/uploads/2011/01/nvALT2.0Screenshot.jpg)

nvALT 앱의 최상단에 있는 "search or create" 란(<kbd>⌘</kbd><kbd>L</kbd> 단축키로 이동)에서 빠른 검색이 가능하다. 노트 제목과 노트 내용에서 검색어를 찾을 수 없으면 검색어를 제목으로 하는 새로운 노트나 마크다운 문서를 만들 수 있다.(매우 편하고 강력한 UI이며, 가장 좋아하는 부분이다.) 노트 안에서의 검색은 <kbd>⌘</kbd><kbd>F</kbd>로 추가로 검색할 수 있고, <kbd>esc</kbd>키로 단계적으로 윗 단계로 벗어날 수 있다.

url을 복사한 후 <kbd>⌘</kbd><kbd>⇧</kbd><kbd>V</kbd> 단축키로 "search or create" 란에 붙여넣으면 해당 url의 웹페이지 내용을 자동으로 가져오는 기능도 있다. 같은 기능을 웹 브라우저에서 원클릭으로 할 수 있는 [북마클릿](http://jots.mypopescu.com/post/8529405944/nvalt-bookmarklet)도 준비되어 있다.

nvALT는 자체 마크다운 뷰어(<kbd>⌘</kbd><kbd>^</kbd><kbd>P</kbd>)도 가지고 있다. 그러나 필자는 속도와 실시간 동기화 면에서 성능이 좋은 ST3의 OmniMarkupPreviewer를 이용하는 것을 더 선호한다.

#### 환경 설정과 동기화 연동

사실 nvALT와 ST3를 애용하고 있었지만 유명한 맥 블로거인 원님의 글 [ONE™의 노트작성 레시피](http://macnews.tistory.com/2008)를 보기 전에는 두 앱을 연동할 생각을 못하고 nvALT에선 말 그대로 노트와 정보 저장을, ST3에선 블로그 글과 위키를 사용하고 있었다. 두 앱을 연동하려면 환경설정(<kbd>⌘</kbd><kbd>,</kbd>)에서 개별 텍스트 화일로 저장하고, `.md` 확장자를 사용할 수 있도록 설정한다. 저장폴더도 드랍박스 안의 폴더로 설정하여 드랍박스의 동기화와 버전 관리 기능을 사용함과 동시에 다른 기기에서도 마크다운 파일을 사용할 수 있도록 한다:

![저장 설정 화면](/images/posts/nvalt-store.jpg)

외부에디터로 ST3를 사용하도록 설정한다:

![외부에디터 설정 화면](/images/posts/nvalt-ex-editor.jpg)

#### nvALT 주요 단축키

|                단축키                |            기능           |
|--------------------------------------|---------------------------|
| <kbd>⌘</kbd><kbd>L</kbd>             | 검색창으로 커서 이동      |
| <kbd>⌘</kbd><kbd>R</kbd>             | 문서 제목 편집            |
| <kbd>⌘</kbd><kbd>⇧</kbd><kbd>R</kbd> | 파인더에서 보기           |
| <kbd>⌘</kbd><kbd>⇧</kbd><kbd>E</kbd> | 외부 에디터 프로그램 실행 |
| <kbd>⌘</kbd><kbd>^</kbd><kbd>P</kbd> | 자체 마크다운 미리보기    |
| <kbd>⌘</kbd><kbd>,</kbd>             | 환경설정창                |

#### 위키

ST3와 [Bitbucket](https://bitbucket.org)을 이용하여 *마크다운 문법만으로* 위키를 활용하는 법을 ["빠르고 가벼운 개인용 마크다운 위키 - 비트버킷과 골룸을 활용"](http://nolboo.github.io/blog/2013/12/17/markdown-wiki-bitbucket-gollum/)에서 설명한 적이 있다. nvALT와 ST3를 연동하여 사용하니 꼭 마크다운 링크를 고집할 필요가 없어졌다. 

**nvALT에서 지원되는 `[[문서 제목]]` 형식의 위키링크는 비트버킷은 물론이고 깃허브에서도 지원된다**. nvALT에선 기존의 문서 제목을 추천까지 해준다.(한글 문서 제목도 잘된다) 다만, 위키링크를 사용하면 서브디렉터리의 파일은 링크할 수 없다. 그래서 하나의 디렉터리에 모든 위키 문서를 때려 넣었다.(서브 디렉터리를 아직 많이 만들지 않아서 다행이었다)

이젠 마크다운으로 작성한 위키를 드랍박스와 비트버킷(혹은 깃허브)에 이중으로 백업하고 접근할 수 있다. (*가끔 드랍박스와 ST3가 충돌하는 현상이 있다. 약간의 불편이 있어 빨리 고쳐지길 바란다.*)

## 모바일

마크다운은 키보드만으로도 구조적인 문서를 작성할 수 있어서 모바일 친화적이고 각종 유무료앱이 많이 나와있다. 그 중 필자가 이용하는 앱은 [Nocs](https://itunes.apple.com/app/nocs-text-editor-dropbox-markdown/id396073482?mt=8)이다. 마크다운 프리뷰도 되고 드랍박스를 지원하기 때문에 현재로선 마크다운 문서를 다루기에 부족함이 없다. 

마크다운을 지원하지 않지만 [심플노트](http://simplenote.com/)도 가끔 사용한다. 심플노트는 안드로이드와 킨들도 지원한다.

*필자는 안드로이드 기기는 충분히 써보지 못했기 때문에 plain text와 드랍박스를 지원하는 유무료 앱을 독자가 직접 선택해보는 것도 좋을 것 같다.*

## 기타 마크다운 앱

### Markdown Here: 특히 이메일

링크 : [Markdown Here](http://markdown-here.com/)

웹 페이지의 리치 텍스트 에디터에서 마크다운으로 작성한 글을 리치 텍스트로 즉석에서 변환해주는 웹 브라우저 확장이다. 마크다운으로 글을 작성한 다음 변환할 부분을 선택한 후 마크다운 히어의 아이콘을 클릭하면(또는 우클릭으로 Markdown toggle 선택) 원클릭으로 변환된다.

- 크롬, 파이어폭스, 사파리, 오페라, 썬더버드 등을 지원
- 표, 울타리 코드 블록, 수식까지 지원하는 다양한 문법을 사용할 수 있다.
- 지메일과 같은 웹메일은 물론 리치 텍스트 에디터를 제공하는 모든 서비스에서 작동된다.(워드프레스 글을 작성할 때도 종종 이용했었다.)

> 긴 이메일을 작성할 때 애용하였었으나 웹 브라우저의 확장을 모두 제거하고 북마크릿 위주로 사용하고 있어서 현재는 OmniMarkupPreviewer를 이용한 웹 브라우저 미리보기를 긁어서 지메일 편집기에 복사하는 방법을 많이 쓰고 있다.

### 기타 유용한 앱과 유틸리티

- [ResophNotes](http://resoph.com/ResophNotes/Welcome.html)와 [nvPY](https://github.com/cpbotha/nvpy): ResophNotes는 윈도용 노트 앱이고 nvPY는 리눅스용 노트 앱이며 모두 심플노트와의 동기화를 지원한다. ResophNotes는 마크다운을 직접 지원하지 않으나 기존의 마크다운 파일을 편집하는 용도로 사용한다면 윈도에서 맥용 nvALT 대신 사용할 수 있다. nvPY는 마크다운을 지원하며 브라우저로 렌더링도 가능하다고 한다.(ResophNotes는 맥으로 넘어오기 전에 애용하던 앱이지만 nvPY는 써보지 못했으나 다른 블로거들이 많이 추천하는 앱이어서 소개한다.)
- [LightPaper](http://clockworkengine.com/): 속도나 디자인도 예쁜 맥용 마크다운 앱이며, 폴더 내비게이션 바가 있어 폴더에 있는 여러 마크다운 파일을 보면서 정리할 때 유용하다.
- [Haroopad](http://pad.haroopress.com/): 국내 개발자가 만든 앱으로 맥, 윈도, 리눅스를 지원한다. 비교적 용량이 큰 파일도 무리 없이 다루며, 미리보기 또한 부드럽고 빠르다. 앞으로 블로그 플랫폼인 하루프레스와 유기적으로 연동되는 것이 많이 기대된다.
- [StackEdit](https://stackedit.io/): 크롬 앱이며 속도와 UI가 좋은 편이며, 드랍박스/구글 드라이브 싱크를 지원하고, 깃허브/블로거/워드프레스/텀블러 등에 바로 포스팅할 수 있다.
- [Heck Yes Markdown](http://heckyesmarkdown.com/): url만 입력하면 웹페이지의 콘텐츠를 마크다운 문법으로 변환해준다. 번역할 때 주로 이용한다.
- [Mark It Down](http://markitdown.medusis.com/): 웹페이지나 에디터의 Rich 컨텐츠를 마크다운으로 변환해준다.
- [GitBook](http://www.gitbook.io/): 마크다운으로 e북을 만들고 인터렉티브한 교육 과정을 만들 수 있다.
- [MultiMarkdown Quick Look with Style](https://github.com/ttscoff/MMD-QuickLook): 파인더의 훑어보기(Quick Look)에서 마크다운 파일을 바로 볼 수 있다.
- [reveal.js](http://lab.hakim.se/reveal-js), [Swipe](http://swipe.to/): 마크다운으로 멀티미디어 프리젠테이션을 쉽게 만들 수 있다. 한번 사용법을 익히면 다시는 파워포인트로 돌아가고 싶지 않을 것이다.
- [Markdown Slides](https://github.com/asanzdiego/markdownslides): 하나의 마크다운 파일에서 Reveal.js, Deck.js, PDF 슬라이드를 제너레이트하고, HTML, ODT, DOCX 문서 파일도 제너레이트하는 오픈소스이다.
- [Brett's PopClip Extensions](http://brettterpstra.com/projects/bretts-popclip-extensions/): 팝클립을 사용한다면 고려해볼만한 마크다운 확장이다.

## 맺음말과 링크

내가 마크다운 위주로 글을 쓰고, 위키를 관리하는 가장 큰 이유는 [내 글과 정보를 내가 소유할 수 있다](http://yoonjiman.net/2014/03/25/own-your-words/)는 점이다. 또한, 사용하는 기기, OS, 서비스로부터 자유로울 수 있다. 현재 맥과 iOS 기기 위주로 사용하고 있지만, 궁극적인(?) 자유로움을 느낄 수 있다. 또한, 백업을 이중삼중으로 함으로써 게으른 성격에 딱 맞는 안전한 워크플로우를 만들어 보았다. 이 글을 읽는 분들도 각자에게 최적화된 활용 방법을 찾으시길 바라며, 도움될 링크 2개를 남겨본다.

* [마크다운(Markdown)으로 글을 써보자](http://blog.kalkin7.com/2014/02/10/lets-write-using-markdown/)
* [ONE™의 노트작성 레시피](http://macnews.tistory.com/2008)


