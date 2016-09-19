---
layout: post
title: "코드블럭 하일라이트 테스트"
category: blog
published: false
---

지킬은 기본 마크다운 엔진이 [Maruku](http://maruku.rubyforge.org/)로 현재 설정되어 있으나 개발이 중단될 것으로 보여 [지킬에서도 대안을 찾고 있다](https://twitter.com/jekyllrb/status/404701427253399552). 그래서 제외하였다.

Maruku 0.7.0 업데이트하여 지킬 1.4.0에 포함됨.
http://rdoc.info/github/bhollis/maruku/master/file/CHANGELOG.md
  fenced_code_blocks 옵션으로 백틱과 틸데 코드 블록 지원
  [Maruku 공식 페이지](http://maruku.rubyforge.org/)에선 아직 0.6.1을 소개

#### 리퀴드 코드 블럭

{% highlight ruby linenos %}
def foo
  puts 'foo'
end
{% endhighlight %}

{{ excerpt_separator }}

## [kramdown]() 확장 테스트

* [quick reference](http://kramdown.gettalong.org/quickref.html)를 보면 필요에 따라 기본 마크다운보다 엄격하거나 유연한 문법을 구현하고 있다. [전체적인 문서](http://kramdown.gettalong.org/syntax.html)를 정독할 필요가 있을 것 같다. rdiscount나 redcarpet보다 header ID, inline math, abbreviations 등을 추가로 지원한다.

#### 울타리 코드 블럭

백틱 방식은 안되고, 틸데 방식이며 지정 언어를 한칸 띄워 입력한다.

```ruby
def foo
  puts 'foo'
end
```

~~~ ruby
def foo
  puts 'foo'
end
~~~

공식 문서에서 이해가 안되는 것:

> 코드 블록 테두리와 Pygments 를 모두 활성화하면, 동적인 구문 강조가 불가능하다; Pygments 를 쓰지 않으면, `<code>` 요소에 `class="LANGUAGE"` 속성이 추가되어 다양한 자바스크립트 코드 구문 강조 라이브러리를 사용할 수 있다.

smart 를 제외한 다른 모든 렌더링 옵션들은 사용할 수 없다.

#### 표

| Feature            | Redcarpet v2 | Kramdown | rdiscount |
| --------           | :----------: | :------: | :-------: |
| fenced code Blocks | ✓            | ✓        | ✓         |
| table              | ✓            | ✓        | ✓         |
| no_intra_emphasis  | ✓            | ✓        | ✓         |
| ~~strikethrough~~  | ✓            | -        | ✓         |
| superscript        | ✓            | -        | ✓         |
| autolink           | ✓            | -        | ✓         |
| footnote           | -            | ✓        | ✓         |
| highlight          | ✓            | ✓        | -         |
| TOC                | -            | -        | -         |


#### no_intra_emphasis

#### pygments

지원되지 않으나 coderay로 대체된다. 줄번호에 링크가 있으나 스타일이 후졌다.

#### ~~strikethrough~~

지원되지 않는듯.

#### superscript

2^2 + 3^3 = ?

지원되지 않는듯

#### 오토링크

https://github.com/vmg/redcarpet/blob/v2.2.2/README.markdown#and-its-like-really-simple-to-use

지원되지 않는듯.

#### highlight

이것은 ==하일라이트== 기능이다. 지원되지 않는다.

#### 주석

이것은 주석이다.[^1] 잘된다.

#### generate_toc

[TOC]

지원되지 않는듯.


## [RDiscount](http://dafoster.net/projects/rdiscount/) 확장 테스트

공식 문서의 지킬 설정은 아래와 같으며, [전체 목록은 여기에 있다](http://rdoc.info/github/davidfstr/rdiscount/RDiscount).

    rdiscount:
      extensions:
        - autolink      # greedily urlify links
        - footnotes     # footnotes
        - smart         # typographic substitutions with SmartyPants

#### 울타리 코드 블럭

```ruby
def foo
  puts 'foo'
end
```

#### 표

|Feature |Maruku|Redcarpet v2|Kramdown|rdiscount|
|--------|------|---------|--------|---------|
|fenced code Blocks| | ✓ | | ✓ |
|table| | ✓ | | ✓ |
|no_intra_emphasis| | ✓ | | ✓ |
|~~strikethrough~~| | ✓ | | ✓ |
|superscript| | ✓ | | ✓ |
|autolink| | ? | | ✓ |
|highlight| | - | | - |
|footnote| | - | | ✓ |
|pygments| | ✓ | | - |
|images with sizes| | | | |
|TOC| | | | ✓ |
|| | | | |

#### no_intra_emphasis

#### ~~strikethrough~~

#### superscript

2^2 + 3^3 = ?

#### 오토링크

https://github.com/vmg/redcarpet/blob/v2.2.2/README.markdown#and-its-like-really-simple-to-use

#### highlight

이것은 ==하일라이트== 기능이다. 지원되지 않는다.

#### 주석

이것은 주석이다.[^1] 잘된다.

#### generate_toc

[TOC]

위와 같은 문법으로는 해석되지 않는다. [2년 전](https://github.com/mojombo/jekyll/pull/333)에 해결된 것 같은데.. 3rd party [플러그인](https://github.com/dafi/jekyll-toc-generator)을 3개월 전에 추가하였으나, 깃허브에선 사용할 수 없다.

## redcarpet 확장 테스트

* 지킬은 [2.2.x 버전](https://github.com/vmg/redcarpet/blob/v2.2.2/README.markdown#and-its-like-really-simple-to-use)을 지원하기 때문에 주석, 하일라이트 등을 지원하지 않는다.
* 인기있다고 하는 오토링크 옵션을 주면 지킬에선 제너레이트 에러가 난다. - feed.xml 의 보여지는 포스트 수를 25에서 10으로 줄여서 해결함.
* [지킬문서](http://jekyllrb.com/docs/configuration/) 내용과는 달리 pygments를 켜야 하일라이트가 된다. 깃허브에선 하일라이트가 되는 것 같다.(제너레이트 딜레이 때문에 즉시 확인이 안되는 불편함;;)

#### 울타리 코드 블럭

```ruby
def foo
  puts 'foo'
end
```

#### 표

|      Feature       | Maruku | Redcarpet | Kramdown | Pandoc |
|--------------------|--------|-----------|----------|--------|
| Fenced code blocks | –      | ✓         | ✓        | ✓      |
| Footnotes          | ✓      | –         | ✓        | ✓      |
| Jekyll integration | ✓      | ✓         | ✓        | –      |
| Header IDs         | ✓      | –         | ✓        | ✓      |
| Inline math        | –      | –         | ✓        | ✓      |
| Abbreviations      | ✓      | –         | ✓        | ✓      |
| Pygments           | ✓      | –         | –        | ✓      |

#### no_intra_emphasis

#### ~~strikethrough~~

#### superscript

2^2 + 3^3 = ?

#### 오토링크

지킬에선 오토링크에서 feed.xml UTF-8 에러가 나버리나 깃허브에선 오토링크 잘 작동된다. 2.2.2 버전에도 포함되어 있는 기능이다.  pygments를 꺼도 마찬가지다. ==> 일단 feed.xml을 제거해 버리니 잘 작동한다.
https://github.com/vmg/redcarpet/blob/v2.2.2/README.markdown#and-its-like-really-simple-to-use

#### smart

"인용부호"를 잘 바꾸어준다고? -- 나 --- 를 쓸 수 있는 기능이란다.

#### highlight

이것은 ==하일라이트== 기능이다. 2.2.2 버전에 없어서 해석되지 않는다. 깃허브에서도 안된다.

#### 주석

이것은 주석이다.[^1]
주석이 수퍼스크립트로 해석되거나, 수퍼스크립트를 빼도 레퍼런스 링크 또는 아예 해석되지 않는다. 깃허브에서도 지원되지 않는다.

[^1]: 
주석이 안먹는다.

최종적으로 선택한 옵션은 다음과 같다.

- no_intra_emphasis
- fenced_code_blocks
- tables
- strikethrough
- superscript
- autolink
- hard_wrap

## 코드블럭 하일라이트

https://github.com/vmg/redcarpet
    하일라이트 등의 설정이 안먹는군. 
    Liquid Exception: invalid byte sequence in UTF-8 in feed.xml 에러로 제너레이팅 실패.

http://bloerg.net/2013/03/07/using-kramdown-instead-of-maruku.html 마크다운 엔진 비교표 있음.

|      Feature       | Maruku | Redcarpet | Kramdown | Pandoc |
|--------------------|--------|-----------|----------|--------|
| Fenced code blocks | –      | ✓         | ✓        | ✓      |
| Footnotes          | ✓      | –         | ✓        | ✓      |
| Jekyll integration | ✓      | ✓         | ✓        | –      |
| Header IDs         | ✓      | –         | ✓        | ✓      |
| Inline math        | –      | –         | ✓        | ✓      |
| Abbreviations      | ✓      | –         | ✓        | ✓      |
| Pygments           | ✓      | –         | –        | ✓      |

kramdown은 pygment 대신 [CodeRay](http://coderay.rubychan.de/)를 사용.

라인 넘버는 이쁘지 않아서 사용하지 않음.