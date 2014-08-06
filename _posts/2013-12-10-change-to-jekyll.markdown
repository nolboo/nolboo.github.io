---
layout: post
title: "옥토프레스에서 pure 지킬로 갈아타다"
description: "발전이 거의 없는 옥토프레스에서 깃허브 기본 엔진인 지킬로 블로그 엔진을 변경. 블로그 속도는 3배, 로컬 제너레이트는 10배, 온라인에서 직접 포스트를 변경할 수 있게 되었다"
category: blog
tags: [jekyll, blog, redcarpet, markdown, octopress]
---

<div id="toc"><p class="toc_title">목차</p></div>

맥북 에어가 끊임없이 재부팅되는 현상 때문에 하드를 깨끗이 포맷하고 매버릭스 인터넷 복구로 OS X 부터 전부 다시 설치하였다. 그런데 옥토프레스에서 `source` 브랜치에 백업해둔다고 매번 푸시한 자료가 하나도 없는 것 아닌가? 깃허브에서 서비스되고 있는 옥토프레스의 컴파일 버전 - HTML, CSS, js 파일만 남은 상황이다. 옥토프레스를 처음 사용할 때에는 git도 처음 시작하여서 그냥 하라는 대로 하고 확인도 해보지 않은 것이 결정적인 실수이다ㅠㅠ

## 옥토프레스에서 지킬로~

옥토프레스는 블로깅을 위한 대부분의 기능이 구현되어 있어 편리하다. 그러나 포스트를 작성할 때마다 제너레이트한 후에 깃허브 페이지에 푸시해야 하기 때문에 시간도 시간이지만 번거로운 느낌이 많이 들었다. 그래서 이참에 [jekyll](http://jekyllrb.com/)로 갈아타기로 했다.

물론 인기있는 static 사이트 제너레이터인 [DocPad](http://docpad.org/)도 검토하고 최근 발견하여 [간단히 소개](http://nolboo.github.io/blog/2013/10/17/start-blog-with-harp/)한 적이 있는 Harp도 좀 더 깊게 검토해보았지만 DocPad는 기본 부트스트랩 템플릿을 제너레이트할 때 20초 정도 걸려서 탈락! harp는 기본 마크다운 라이브러리인 marked에서 지원되지 않는 기능이 많았고, 코드 하일라이트도 지원되지 않았다.

깃허브에서는 지킬을 static 사이트 기본 엔진으로 사용하고 있어서, 사이트를 로컬에서 제너레이트하지 않고 그냥 푸시하기만 해도 자동으로 서버에서 제너레이트해준다. 로컬에서 테스트할 때만 사이트를 제너레이트하고 올릴 때는 그냥 제너레이트한 `_site` 부분은 빼고 올리면 된다.([지킬에 대한 기본 설명은 예전에 글을 올린 것이 있으니 처음 접하시는 분은 참조](http://nolboo.github.io/blog/2013/10/15/free-blog-with-github-jekyll/)) 단점이 있다면 지킬의 safe 모드 - 플러그인을 사용할 수 없는 모드만을 지원하기 때문에 지킬의 다양한 플러그인은 사용할 수 없다. 만약, 플러그인을 사용하고 싶다면 사이트를 제너레이트하여 `_site` 안의 파일들만 호스팅할 수도 있다.

## 기존 블로그 글 살리기

깃허브 블로그에 남아있는 예전 블로그글은 html 로만 남았기 때문에 마크다운으로 변환해야 했다. 물론, 지킬은 html 파일도 처리할 수 있지만 옥토프레스 테마와 플러그인이 적용된 상태라 html 파일을 수정하는 시간과 알고 있는 툴로 마크다운으로 변환하는 것이 비슷할 것 같아서 마크다운으로 변환하기 결했다. 사용한 툴은 다음과 같다:

1. [Heck Yes Markdown](http://heckyesmarkdown.com/): url을 입력하면 마크다운으로 변환한다.
2. [Html2MarkDown](http://html2markdown.com/): html 코드를 복사하여 넣으면 마크다운으로 변환한다.

1번을 주로 사용하고 제대로 변경되지 않는 부분을 군데군데 2번으로 변환하였다. 시간은 예상보다 많이 걸렸다.(아.. 노가다.. 내 시간;;)

## 테마 선정

새롭게 만들기보다는 오픈소스 테마 중에서 선택하기로 맘먹고 [이전 글](http://nolboo.github.io/blog/2013/10/15/free-blog-with-github-jekyll/)의 참고사항에 정리해 둔 링크들을 돌아다녔으나 막상 맘에 드는 것이 없었는데 우연히 맘에 드는 [sebastien.saunier.me](http://sebastien.saunier.me/)을 발견하고 로컬에 클론하여 이것저것 살펴보았다. 이 테마에는 사이트 대화 기능의 [Olark](http://www.olark.com/), 분석을 위한 구글 애널리틱스, 댓글을 위한 Disqus가 추가되어 있었다. 그런데 로컬에서 띄워놓은 블로그에 세바스찬이 Olark으로 갑자기 대화를 걸어와서 깜짝 놀랐다. 자신의 Olark 모듈을 내려달라고 해서 얼른 내렸다. 구글 애널리틱스와 디스커스도 얼른 죽였다. 자신의 블로그를 어떻게 알았냐고 물어서 경로를 약간 설명하고 테마 사용 허락을 받으니 (일견 당연하지만) 흔쾌히 허락해주었다.

깃허브 등에서 **다른 사람의 오픈소스 테마를 테스트할 때는 위와 같은 모듈은 먼저 체크하여 disable한 후 테스트해야 한다.**

## 마크다운과 퍼머링크 설정

지킬은 여러가지 마크다운 엔진을 지원하는 데 그 중에서 맘에 드는 3 가지를 주요 기능 위주로 직접 비교 테스트한 결과 `redcarpet`을 사용하기로 하였다. 지킬은 기본으로 `maruku`를 사용하고, 깃허브는 기본으로 `redcarpet`을 사용하는데 그 중에서도 2.2.x를 지원한다. 아래 표는 비교결과이다.

### 마크다운 비교

| Feature            | Redcarpet v2 | Kramdown | rdiscount |
| --------           | :----------: | :------: | :-------: |
| fenced code Blocks | ✓            | ✓        | ✓         |
| table              | ✓            | ✓        | ✓         |
| no_intra_emphasis  | ✓            | ✓        | ✓         |
| ~~strikethrough~~  | ✓            | -        | ✓         |
| superscript        | ✓            | -        | ✓         |
| autolink           | ✓            | -        | ✓         |
| footnote           | -            | ✓        | ✓         |
| pygments           | ✓            | CodeRay  | -         |
| TOC                | -            | -        | -         |

### 퍼머링크(영구주소)

옥토프레스에선 기본으로 각 포스트 글의 영구주소를 `blog/년도/월/일/포스트-제목/`으로 만들어준다. 기존의 옥토프레스의 url을 그대로 가져와 지킬에서도 지속성을 가지기 위해서

1.  `_config.yml`에 `permalink: pretty`를 넣어주었다.(`permalink: /:categories/:year/:month/:day/:title/` 도 동일하다).
2. 각 포스트의 프론트 메터에 `category: blog`를 넣는다.

자세한 내용은 [Permalinks](http://jekyllrb.com/docs/permalinks/) 또는 [고유주소](http://svperstarz.github.io/jekyll-docs-ko/docs/permalinks/)를 참조하면 된다.

### 기본 환경 설정

결과적으로 `_config.yml`의 내용은 다음과 같다:

```yaml
title: Nolboo's Blog

# Oveerriden by GitHub Pages: https://help.github.com/articles/using-jekyll-with-pages#configuring-jekyll
safe: true
pygments: true
lsi: false

permalink: pretty

markdown:     redcarpet

redcarpet:
    extensions: 
      - no_intra_emphasis
      - fenced_code_blocks
      - tables
      - strikethrough
      - superscript
      - autolink
      - hard_wrap
```

## 홈페이지

테마를 가져온 [sebastien.saunier.me](http://sebastien.saunier.me/)의 주인장인 세바스찬은 개인 홈페이지를 위주로 블로깅을 하고 있지만, 나는 블로그가 주목적이기 때문에 초기화면을 변경하였다. 루트 디렉토리의 `index.html`을 다음과 같이 변경하여 포스트 제목과 날자, 그리고 포스트 설명이 표시되도록 하였다.


    ---
    layout: default
    title: Nolboo's Blog
    description: 호모스터디쿠스를 꿈꾸는 놀부
    ---
{% raw  %}
    <section>
      <ul class="posts">
        {% for post in site.posts %}
          <li>
            <h2>
              <a href="{{ post.url }}">{{ post.title }}</a>
            </h2>
            <p>
              <span class="date">{{ post.date | date_to_string }}</span>
              <span class="description">{{ post.description }}</span>
            </p>
          </li>
        {% endfor %}
      </ul>
    </section> 
{% endraw %}

포스트 글의 발췌본이 자동 생성되는 `excerp`는 한글이나 코드와 충돌하는 문제가 있었고, 컨텐츠의 처음부터 원하는 곳까지를 사용자가 직접 지정할 수 있는 `{% raw  %}{{ excerpt_separator }}{% endraw %}`을 삽입하는 방법도 잘 되지 않았다. 대안으로 각 포스트의 프론트매터에 `description`를 변수로 두어 직접 원하는 설명을 써넣는 방법을 사용하였다. `excerp`를 사용할 때보다 오히려 깔끔해서 더 마음에 들었다. 예를 들면:

```yaml
---
layout: post
title: "완전 초보를 위한 깃허브"
description: "git을 전혀 모르던 디자이너가 10분 안에 자신의 디자인 파일을 회사의 저장소에 올려 협업할 수 있도록 안내하는 글의 번역. 이 블로그에서 가장 많이 읽혀진 대박글!"
category: blog
---
```

## 기타 페이지

한글 번역글 중에서 북마크해서 계속 읽어볼만한 글을 모아둔 [페이지](http://nolboo.github.io/trans/)를 운영하고 있는데, 나름 많은 분들이 꾸준히 찾아주는 곳이다. 지킬에서 페이지를 생성하는 방법은 간단하다. 블로그 루트 디렉토리 밑에 원하는 이름의 디렉토리를 만들고 `index.md`나 `index.html`을 넣으면 된다.

`trans`란 디렉토리를 만들고 마크다운 형식으로 작성한 페이지를 `index.md`로 이름을 바꾸어 넣어준다. `index.md`는 파일명에 날자가 없기 때문에 프론트 메터에 `date:` 변수를 추가한다. 아래처럼 **시간까지 모두 입력해야 한다.**

    date: 2013-11-29 14:40:45

추가로 `archive`란 디렉토리를 만들고 `index.md`에 다음과 같이 넣어 전체 포스트 목록을 볼 수 있도록 하였다.


    ---
    layout: default
    title: Nolboo's Blog
    description: 호모스터디쿠스를 꿈꾸는 놀부
    ---
{% raw  %}
    <ul>
      {% for post in site.posts %}
        <li>
          <a href="{{ post.url }}">{{ post.title }}</a>
          <div><small>{{ post.date | date_to_string }}</small></div>
        </li>
      {% endfor %}
    </ul>
{% endraw %}

`_layout` 디렉토리의 내비게이션 바도 맞게 수정하고, 사이트 제목이나 설명 등의 나머지 내용도 전부 내 것으로 수정하였다. 물론 어렵게 살려낸 글들도 변경된 프론트매터를 추가하여 `_posts` 디렉토리에 넣었다.

## Deploy

이제 깃허브에 올리면 된다. 올리기 전에 로컬 테스트하면서 제너레이트된 `_site` 디렉토리를 제외한다. 텍스트에디터로 `.gitignore` 파일을 만들고 `_site/`를 삽입하고 저장한다.

현재 서비스되고 있는 블로그의 저장소를 `nolboo.github.io.backup`으로 이름을 변경하여 백업하고, 새롭게 `nolboo.github.io` 저장소를 만든다.

    git remote add origin 저장소URL
    git add . -A
    git commit -m "change to jekyll"
    git push orgin master

로컬에서 `jekyll serve`로 확인할 때 에러가 나지 않았다면 대부분 잘 올라간다. 단, 깃허브에 static 사이트를 푸시하면 바로 적용되는 경우도 있지만 2,3분 또는 최대 10분 정도를 기다려야 한다.

## 그 외

### RSS

기존 테마의 `feed.xml`에서 `description`부분에 블로그 글의 내용이 모두 들어가도록 되어 있어, 내 경우에 맞게 [수정](https://github.com/nolboo/nolboo.github.io/blob/master/feed.xml.old)하였다. 추가적으로 [이상한 모임 팀블로그](http://we.weirdmeetup.com/)에서 발췌 목록이 나오도록 하기 위해 옥토프레스 [atom.xml](https://github.com/imathis/octopress/blob/master/.themes/classic/source/atom.xml)을 파보려는데 [@armv9](https://twitter.com/armv9)님이 추천하신 [gist](https://gist.github.com/aahan/5228376)로 대체하였더니 팀블로그 플랫폼인 워드프레스와 궁합이 잘 맞게 설정되었다.

### CSS

코드 하일라이트 스타일 시트인 `syntax.css`가 너무 밋밋했다. 검색해보니 지킬 버전 [Solarized Light Pygments CSS](https://gist.github.com/edwardhotchkiss/2005058)를 공개한 gist가 있어 얼른 가져왔다. 하일라이트되는 부분의 보더가 너무 두꺼워 보이고 긴 줄의 글자가 넘쳐서 그 부분의 css를 약간 수정하였다.

## 변경 소감

- 블로그의 속도가 3배 이상 빨라졌다.
- 테마가 산뜻하고 좋으며 직접 변경하기도 쉽다.
- 포스트를 한 글자만 변경하여도 매번 제너레이트시켜야 하는 불편함이 사라졌고, CSS나 테마 등을 변경한 후 로컬 테스트를 위해 제너레이트하더라도 그 속도가 체감상 10배 정도 향상되었다. 지킬이 왜 가장 인기가 있는지 알 수 있는 대목이다.
- 마크다운 형태의 블로그 글이 그대로 올라가기 때문에 소스를 별도로 백업할 필요가 없어졌으며, 포스트의 변경사항을 깃허브 에디터나 [prose.io](http://prose.io/) 등을 이용해 온라인에서 직접 변경할 수 있다.

### 참조 링크

* [지킬 공식 사이트 한글 번역](http://svperstarz.github.io/jekyll-docs-ko/)
* [지킬로 깃허브에 무료 블로그 만들기](http://nolboo.github.io/blog/2013/10/15/free-blog-with-github-jekyll/)
* [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/)
