---
layout: post
title: "Vim 텍스트 개체: 궁극의 가이드"
description: "Vim으로 빠르게 편집하려면 반드시 기억해야 할 텍스트 개체에 대한 가이드를 번역"
category: blog
tags: [editor, vim, text-objects, guide]
---

원본 : [Vim Text Objects: The Definitive Guide](http://blog.carbonfive.com/2011/10/17/vim-text-objects-the-definitive-guide/)

Vim에서 편집을 효율적으로 하려면 문자를 뛰어넘어 단어, 문장, 문단으로 편집해야 한다. Vim에서 이런 하이레벨 컨텍스트를 텍스트 개체(text objects)라고 한다.

Vim은 일반텍스트와 프로그래밍 언어 구성체를 위한 텍스트 개체가 있다. Vim 스크립트를 이용해서 새로운 텍스트 개체를 정의할 수도 있다.

텍스트 개체를 배우면 Vim 편집이 완전히 새로운 단계의 정확도와 속도를 가질 수 있다.

## 편집 명령의 구조

Vim에서 편집 명령의 구조는 다음과 같다:

```
<숫자><명령><텍스트 개체 또는 모션>
```

*숫자*는 여러 텍스트 개체 또는 모션에 걸쳐 명령을 실행한다, 예를 들어 역방향 세 개의 단어, 순방향 두 개의 문단. 숫자는 선택사항이며 명령의 앞이나 뒤에 쓸 수 있다.

*명령*은 변경, 삭제(잘라내기), yank(복사) 등의 작용이다. 명령도 선택사항이다; 그러나 없으면 편집 명령이 아닌 모션 명령만 쓸 수 있다.

*텍스트 개체*나 *모션*은 하나의 단어, 문장, 문단 등의 텍스트 구성이나 순방향 한 줄, 역방향 한 페이지, 줄의 끝과 같은 모션이다.

*편집 명령*은 명령에 텍스트 개체나 모션을 더한 것이다, 예로, 단어 지우기, 다음 문장 변경, 문단 복사.

## Plaintext 텍스트 개체

Vim은 일반텍스트의 세 가지 빌딩 블록(building blocks)을 제공한다: 단어, 문장, 문단

### 단어(Words)

* aw - 한 단어(뒤따르는 여백`whitespace`을 포함)
* iw - inner 단어(뒤따르는 여백을 *포함하지 않음*)

```
Lorem ipsum dolor sit amet...
```

`daw`

```
Lorem dolor sit amet...
```

`a`로 시작하는 텍스트 개체는 텍스트 개체에 뒤따르는 여백을 포함한다. `i`로 시작하는 것은 포함하지 않는다. 이 규칙은 모든 텍스트 개체가 따른다.

모션 `w`는 텍스트 개체 `aw`와 비슷하나, 실행을 허용하는 커서 위치가 다르다. 예를 들어 `dw`는 커서가 단어의 시작에 있어야 한다. 다른 위치에서는 단어의 부분만 지운다; 그러나, `daw`는 커서가 단어의 어떤 위치에 있어도 된다.

### 문장(Sentences)

* as - 한 문장
* is - inner 문장

```
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
```

`cis`

```
 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat.
```

"inner" 텍스트 개체는 뒤따르는 여백을 포함하지 *않는다*.

`as`는 모션 쌍인 `(`와 `)` - 순방향과 역방향 한 문장 - 를 넘어 `aw`와 같이 커서 위치의 장점을 제공한다. 이전 문장 전체에 작동하려면 `(`는 문장의 끝에 커서가 있어야 하고; 다음 문장 전체에 작동하려면 `)`는 문장의 처음에 커서가 있어야 한다.

### 문단(Paragraphs)

* ap - 한 문단
* ip - inner 문단

```
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis 
nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
mollit anim id est laborum.
```

`dap`

```
Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
mollit anim id est laborum.
```

또 다시, `ap`와 `ip`는 Vim의 문장과 단어 텍스트 개체가 제공하는 커서위치 장점을 가진다: 커서가 문단의 어느 곳에 있어도 작동한다.

## Motion Commands vs. Text Objects Commands

`cw`와 같이 모션을 사용한 명령은 현재 커서 위치부터 작동한다. `ciw`와 같이 텍스트 개체를 사용한 명령은 커서 위치에 상관없이 전체 개체에 작동한다. 한 자가 더 필요하지만, 커서를 정확한 위치로 옮기는데 필요한 시간과 노력을 덜어준다.

## Programming Language Text Objects

Vim은 일반적인 프로그래밍 언어 구성체에 기반한 여러 텍스트 개체를 제공한다.

### Strings

* a" - 인용부호 문자열
* i" - inner 인용부호 문자열
* a' - 작은인용부호 문자열
* i' - inner 작은인용부호 문자열
* a` - 백틱 문자열
* i` - inner 백틱 문자열

```
puts 'Hello "world"'
```

`ci"`

```
puts 'Hello ""'
```

커서가 인용부호 구문("world") 안에 없어도 된다; 줄의 첫번째 인용부호 문자열을 변경한다.

```
puts 'Hello "world"'
```

`ci'`

```
puts ''
```

현재 줄 검색은 인용부호 구문을 지우는 다른 방법을 제공한다. 앞의 예제에서 첫 `'`에 커서를 위치하고 `ct'`를 실행하면 작은 인용부호 문자을 내용을 지우고 입력모드로 들어간다. 그러나  시작하는 `'`에 커서를 위치해야하므로 텍스트 개체를 사용하는 서보다 덜 유연한다.

`/'` 검색 패턴도 사용할 수 있지만, 시작 `'`에 커서를 위치해야하고, 닫는 `'`를 지우기도 한다.

검색 명령은 검색에만 사용하고 편집에는 사용하지 않는 것이 가장 좋다.

### Parentheses

* a) - 괄호 블록
* i) - inner 괄호 블록

```
Project.all(:conditions => { :published => true })
```

`da)`

```
Project.all
```

`ab`와 `ib`도 가능하지만, 괄호문자를 포함하는 버전을 사용하는 것보다 덜 직관적이다.

`%` 모션은 괄호쌍을 매치하는 또 다른 방법이다. 여는 괄호에서 `%`를 입력하면 닫는 괄호로 커서가 이동한다. 명령과 결합하면 `a)`와 같이 작동한다. 예로, `c%`는 `ca)`와 같다. 그러나, `%`를 사용하는 단점은 커서가 괄호에 있어야 한다는 것이다; `a)`는 괄호 문자열 중 어떤 곳에서도 가능하다. `%`를 사용하여 `i)`를 대치할 수 있는 방법은 없다.

### Brackets

* a] - 대괄호 블록
* i] - inner 대괄호 블록

```
(defn sum [x y]
  (+ x y))
```

`di]`

```
(defn sum []
  (+ x y))
```

`%` 이동을 `[]`와 같이 사용할 수 있다. 그러나, `()`와 같이 사용할 때와 같은 제한이 있다.

### Braces

* a} - 중괄호 블록
* i} - inner 중괄호 블록

```
puts "Name: #{user.name}"
```

`ci}`

```
puts "Name: #{}"
```

`aB`와 `iB`도 역시 가능하나, 중괄호 문자를 포함하는 버전을 사용하는 것보다 덜 직관적이다.

또 다시, `%` 이동을 `{}`와 같이 사용할 수 있다. 그러나, `()` 혹은 `[]` 와 같이 사용할 때와 같은 제한이 있다.


### Markup Language Tags

* at - 태그 블록
* it - inner 태그 블록

```
<h2>Sample Title</h2>
```

`cit`

```
<h2></h2>
```

커서가 `<h2>` 안에 없어도 된다. 태그 내용을 빠르게 대체하는 매우 효율적인 방법이다.

* a> - 싱글 태그
* i> - inner 싱글 태그

```
<div id="content"></div>
```

`di>`

```
<></div>
```

이 텍스트 개체는 싱글 태그와 그 속성에 빠르게 작동할 수 있다.

## Vim Scripts Providing Additional Text Objects

Vim 스크립트를 사용하여 새로운 텍스트 개체를 만들 수 있다. 가장 좋아하는 스크립트를 몇 개 소개한다.

### CamelCaseMotion

[CamelCaseMotion](https://github.com/bkad/CamelCaseMotion)은 camel 혹은 snake-cased 단어 텍스트 개체를 제공한다.

* i,w - inner camel 혹은 snake-cased 단어

```
BeanFactoryTransactionAttributeSourceAdvisor
```

`ci,w`

```
FactoryTransactionAttributeSourceAdvisor
```

### VimTextObj

[VimTextObj](https://github.com/vim-scripts/argtextobj.vim)는 함수 인자 텍스트 개체를 제공한다.

* aa - 인자
* ia - inner 인자

```
foo(42, bar(5), 'hello');
```

`cia`

```
foo(42, , 'hello');
```

### Indent Object

[Indent Object](https://github.com/michaeljsmith/vim-indent-object)는 들여쓰기 레벨에 기반한 텍스트 개체를 제공한다. 파이썬과 커피스크립트와 같이 코드 블록의 범위에서 여백이 중요한 프로그래밍 언어를 위한 스크립트이며, 들여쓰기 레벨의 마지막 줄 바로 다음 줄을 포함하지 않는다.

* ai - 현재 들여쓰기 레벨 + 그 윗줄
* ii - 현재 들여쓰기 레벨 - 그 위줄

```
def foo():
  if 3 > 5:
    return True
  return "foo"
```

`dai`

```
def foo():
  return "foo"
```

### Ruby Block

[Ruby Block](https://github.com/nelstrom/vim-textobj-rubyblock)은 루비 블록 텍스트 개체를 제공한다. 즉, `end` 키워드로 끝나는 블록이다.

* ar - 루비 블록
* ir - inner 루비 블록

```ruby
hash.each do |key, value|
  puts key
  puts value
end
```

`cir`

```ruby
hash.each do |key, value|
   
end
```

## Vi Command Line Editing

쉘에서 Vi 명령어 라인 편집을 사용하려면 bash에서는 `set -o vi`, zsh에서는 `bindkey -v`로 할 수 있다. Vim의 텍스트 개체는 사용할 수 없다. 텍스트 개체는 Vim에서 도입된 것이나 쉘 명령어 라인 편집은 Vi에 기반한 것이다.

## Precision Editing

Vim의 텍스트 개체는 믿을 수 없을 레벨의 정확도를 제공한다. 주요점은 항상 텍스트 개체로 편집을 해보는 것이다. 모션으로 편집하는 것은 지루하고 어색하고 느리다. 문자 단위로 오자를 정정하는 대신 전체 워드를 변경하고 다시 타이핑하라.

대량의 텍스트 개체에 기죽지 마라. 규칙이 직관적이고, 배우기 쉽다. 다른 Vim 명령과 같이 조금 연습하면 빠르게 또 하나의 기억 근육이 될 것이다.

## 역자 요약

* `<숫자><명령><텍스트 개체 또는 모션>`
*  `a` 뒷여백 포함, `i`는 개체만
*  개체는 커서 위치가 모션보다 유연하다.
*  `"`와 `'`는 다음 첫부호에서  작동한다.
*  모션보다는 텍스트 개체를 사용해라.


