---
layout: post
title: "지킬 블로그에 페이지네이션과 태그 등 추가"
description: "지킬 블로그에 Liquid와 js를 이용해 페이지네이션, 태그 검색을 추가하고 전역변수 등을 설정한다."
category: blog
tags: [jekyll, blog, liquid, pagination, tag, category]
---

<div id="toc"><p class="toc_title">목차</p></div>

[블로그를 지킬로 변경](http://nolboo.github.io/blog/2013/12/10/change-to-jekyll/)하고 꼭 필요한 기능을 중심으로 서서히 진화시켜 나가고 있다. 그런데 어찌된 일인지 이 블로그 저장소를 스타하신 분이 88분, 포크하신 분이 9분, 와치하시는 분이 33분이나 된다. 덜덜;; 블로그 때문인지 번역글 위키 때문인지는 모르겠지만 둘다 열심히 해야한다는 생각은 마구마구 들었지만, 연말과 새해에 걸쳐 거의 한달간 심한 담걸림증과 감기로 글 하나도 제대로 쓰기 힘들었다 - 고 변명해본다. :-)

며칠 전 깃허브는 [CDN 호스팅 속도를 더욱 높이고](https://github.com/blog/1715-faster-more-awesome-github-pages), [트래픽 분석](https://github.com/blog/1672-introducing-github-traffic-analytics)을 선보이고, 부트스트랩 비주얼 툴 [Easel을 인수](http://blog.easel.io/blog/2014/01/06/easel-acquired-by-github/)하는 등 놀라운 발전을 거듭하고 있는 것 같다.

블로그 기능 중 오늘까지 추가한 부분은 초기 화면의 페이지네이션, 태그 검색, 소셜 전역 변수 등이다. 거의 다른 분들의 글이나 공식문서 등을 참고하여 내 블로그에 맞도록 고쳤기 때문에 여기선 과정을 중심으로 간략히 설명한다.

### Liquid Template System

지킬은 다른 정적사이트 제러레이터와 마찬가지로 두 개의 중괄호로 변수를 표현하는 템플릿 시스템을 사용한다. 예를 들어 `site.name`을 두 개의 중괄호로 감싸면 웹사이트 이름을 출력한다는 식이다.

지킬은 Shopify가 만든 [Liquid 템플릿 시스템](https://github.com/Shopify/liquid)을 사용하고 있으며, (역사가 오래되어서) 많이 쓰이고 있는 [Mustache.js](http://mustache.github.io/)나 이를 확장하여 최근 각광받고 있는 [Handlebars.js](http://handlebarsjs.com/)와 같은 템플릿 라이브러리와 유사하다.

지킬은 세 개의 주요 글로벌 변수를 가진다 : `site`, `page`, `content`.

`site` 변수의 값은 환경설정 화일인 `_config.yml`에 지정한다. `_config.yml` 화일의 `name` 필드는 `site.name` 형식으로 가져올 수 있다. 마친가지로 각 페이지의 front matter에서도 가져올 수 있다. 중괄호로 감싼 `page.title`는 페이지 front matter의 `title` 필드 값을 가져온다.

자세한 설명은 [Liquid for Designers](https://github.com/Shopify/liquid/wiki/Liquid-for-Designers)를 읽어보면 된다. 리퀴드가 작동하는 방법을 이해해야 지킬을 마스터할 수 있다고하니 계속 배울 예정이다.

## 초기 화면 페이지네이션

[페이지네이션](http://jekyllrb.com/docs/pagination/) - [한글](http://svperstarz.github.io/jekyll-docs-ko/docs/pagination/)을 활성화하기 위해 `_config.yml`에 다음을 추가한다.

    paginate: 10

위 설정값은 페이지 당 10개의 포스트를 보여준다. 숫자값은 변경할 수 있다.

이제 지킬의 `paginator` 글로벌 변수를 적용해보자. 단, `paginator`는 홈페이지(`index.html`)에서만 작동한다.

이전에는 사이트의 모든 포스트를 나타내는 `site.posts`를 사용하였지만 이젠 `_config.yml`의 `paginate`의 값에 따라 포스트 개수를 나누어서 나타내는 `paginator.posts`를 사용한다.

`paginator` 글로벌 변수는 `previous_page`와 `next_page` 속성을 가진다. `total_pages`는 모든 블로그 포스트를 보여주는 데 필요한 페이지의 총수이다. 예를 들어 26개의 블로그 포스트가 있고 페이지 당 10 포스트라면, `paginator.total_pages`는 3이다.

[지킬 페이지네이션 문서](http://jekyllrb.com/docs/pagination/)([한글](http://svperstarz.github.io/jekyll-docs-ko/docs/pagination/))에서 추천하는 방법을 따르되 페이지네이션 링크는 두번째 예시를 취한다. `div` `ul` 형식으로 변환하고, 적절한 css 클래스를 적용한 `index.html`은 다음과 같다.

```html
{% raw  %}
<section>
  <ul class="posts">
    <!-- This loops through the paginated posts -->
    {% for post in paginator.posts %}
      <li>
        <h2>
          <a href="{{ post.url }}">{{ post.title }}</a>
        </h2>
        <p>
          <span class="date">{{ post.date | date_to_string }}</span>
          <span class="description">{{ post.description }}</span>
        </p>
        <ul class="tags cf">
          {% for tag in post.tags %}
          <li><a href="/search/?tags={{ tag }}">{{ tag | downcase }}</a></li>
          {% endfor %}
        </ul>
      </li>
    {% endfor %}
  </ul>

  <!-- Pagination links -->
  <ul class="pagination clearfix">
    {% if paginator.previous_page %}
      {% if paginator.previous_page == 1 %}
      <li><a href="/">Prev</a></li>
      {% else %}
      <li><a href="/page{{ paginator.previous_page }}">Prev</a></li>
      {% endif %}
    {% else %}
    <li><span class="disabled">Prev</span></li>
    {% endif %}
    {% if paginator.page == 1 %}
    <li><span class="active">1</span></li>
    {% else %}
    <li><a href="/">1</a></li>
    {% endif %}
    {% for count in (2..paginator.total_pages) %}
      {% if count == paginator.page %}
      <li><span class="active">{{ count }}</span></li>
      {% else %}
      <li><a href="/page{{ count }}">{{ count }}</a></li>
      {% endif %}
    {% endfor %}
    {% if paginator.next_page %}
    <li><a href="/page{{ paginator.next_page }}">Next</a></li>
    {% else %}
    <li><span class="disabled">Next</span></li>
    {% endif %}
  </ul>
</section>>
{% endraw %}
```

## 검색

### 태그와 카테고리

포스트의 분류를 위해 태그를 사용하기로 하였다. 지킬의 `pretty` 퍼머링크 모드에선 카테고리를 별도의 페이지로 만들기 때문에 블로그의 소스 디렉토리가 산만해질 위험이 있어 카테고리는 조금 신중하게 사용하려고 한다. 검색해보니 간단하고 딱 원하는대로 구현한 [포스트](http://alexpearce.me/2012/04/simple-jekyll-searching/)가 있어서 따라해 보았다.

아래와 같은 순서로 구현하는 것을 설명해 놓았는데:

1. `search.json`과 `post.json`을 만들어 각 포스트의 태그를 포함하는 일종의 데이타베이스 역할을 하는 화일을 만다. 
2. 각 태그 검색의 결과 페이지인 `search.html`을 만든다.
3. 필요한 자바스크립트를 적용한다.

단, 내 블로그는 `pretty` 퍼머링크 모드를 사용하므로, 자바스크립트의 `/search.html?tags=` 부분을 `/search/?tags=`로 변경해야 한다.

* 태그와 관련된 CSS를 조절하여 좋아하던 미니멀리즘식으로 CSS 스타일링하였다.
* **여러 단어로 이루어진 태그에서는 제대로 작동하지 않으므로 한 단어의 태그만 사용하거나 `-` 등으로 단어를 연결해야 한다.**
* 참조 링크 : [Simple Jekyll Searching](http://alexpearce.me/2012/04/simple-jekyll-searching/)

### 풀텍스트 검색

워낙 정보를 쌓아놓는 성격이어서 풀텍스트 검색을 좋아하지만, 지킬의 검색 인덱스 생성 방식이 첫 영문자 두 개의 JSON을 생성하는 방법이라 한글이 지원되지 않는다. 몇 개의 글을 읽어보고 대충 적용해 보았으나 대부분이 플러그인 방식이라서 깃허브의 `safe` 모드에선 작동되지 않는다. 이 블로그는 아직 포스트 수도 많지 않으니, 태그 검색만을 적용하고 풀텍스트 검색은 일단 보류하기로 하였다. 블로그를 내가 사용하는 on-the-fly 방식이 아닌 제너레이트한 후에 깃허브나 다른 호스팅에 올리는 것을 선호하는 분들을 위해 링크만 남겨놓는다.

* [아주 빠른 필터링 검색](http://jzhang.io/add-search-to-jekyll)이나 페이지네이션에선 동작하지 않는다니 `archive` 페이지에 구현할까 망설인 것.
* [일종의 인스턴트 검색](http://christian-fei.com/simple-jekyll-search-jquery-plugin/)
* [반응형 풀텍스트 검색](http://www.marran.com/tech/jquery-full-text-indexing-on-jekyll/)
* [Lunr 적용](http://dreamand.me/web/fulltext-search-at-jekyll-site/)
* [Lunr 적용2](https://github.com/slashdotdash/jekyll-lunr-js-search)

## 소셜 전역 변수

트위터 계정과 같은 새로운 전역 변수를 만들려면, `_config.yml` 화일에 다음과 같이 YAML을 추가하면 된다.

```
author:
    twitter: n0lb00
    github: nolboo
```

이제 `site.author.twitter` 리퀴드 태그로 트위터 계정을 접근할 수 있다.

오늘은 여기까지입니다. 이 글을 보시는 모든 분들께 

<mark>새해 복 많이 받으시길 바랍니다!!</mark>