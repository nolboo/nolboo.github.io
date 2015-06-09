---
layout: post
title: "루비 언어 기초"
description: "코세라 웹 앱 아키텍처 중 루비 언어에 대한 기초 부분"
category: blog
tags: [Coursera, ruby, basic]
---

뉴멕시코 대학의 Greg Heileman 교수의 코세라 강좌 [Web Application Architectures](https://class.coursera.org/webapplications-003) 중에서 루비 언어 기초만 별도로 정리하였다. 나머지는 [루비 온 레일즈로 블로그 만들기](http://nolboo.github.io/blog/2015/05/05/web-application-architecture/)에서 볼 수 있다.

## Ruby Programming Language

Yukihiro Matsumoto(“Matz”)는 90년 중반에 루비를 만들었다. "펄보다 강력하고 파이썬 보다 객체지향적인 스크립트 언어를 만들길 원했다." 루비는 기계보단 프로그래머에 초점을 맞쳤고, 설계 목표도 프로그래머의 효율(즉, 생산성)을 최대화하기 위한 것이었다. "루비가 세상의 모든 프로그래머가 생산적이고, 프로그래밍을 즐기고, 행복해지는 것을 돕길 원했다. 그게 루비 언어의 주요 목적이다."

Matz’s guiding philosophy for Ruby:
“Ruby is designed to make programmers happy.”

- [Yukihiro "Matz" Matsumoto | Ruby Design Principles](http://web.archive.org/web/20130729205129id_/http://itc.conversationsnetwork.org/shows/detail1638.html)
- [Ruby의 철학에 관한 마츠모토 유키히로의 인터뷰](http://we.weirdmeetup.com/ruby%EC%9D%98-%EC%B2%A0%ED%95%99%EC%97%90-%EA%B4%80%ED%95%9C-%EB%A7%88%EC%B8%A0%EB%AA%A8%ED%86%A0-%EC%9C%A0%ED%82%A4%ED%9E%88%EB%A1%9C%EC%9D%98-%EC%9D%B8%ED%84%B0%EB%B7%B0-part-1/)

<pre class="terminal">
ruby --version
gem list
gem install rails

ruby -e ’puts "Hello World!"’
Hello World!
</pre>

* `-e` 프롬프트로 인터프리터가 `''`안의 루비 코드를 실행한다.
* `''`안의 루비 코드를 hello.rb 파일 안에 넣고 실행하면 같은 결과가 나온다.

<pre class="terminal">
ruby hello.rb
Hello World!
</pre>

### Interactive Ruby Shell(IRB)

<pre class="terminal">
irb
2.0.0p195 :001 >
</pre>

* 루비 앱 디렉토리의 루트에서 다음 명령으로 IRB를 실행하여, 콘솔 커맨트 라인에서 루비 앱을 직접 조작할 수 있다.

<pre class="terminal">
rails console
Loading development environment (Rails 4.0.0.rc1)
2.0.0-p195 :001 >
</pre>

Ruby is a multi-paradigm programming language:

* Scripting – It can be used to write scripts that automate the execution
of tasks within some environment.
* Imperative (procedure-oriented) programming – It has the traditional control structures found in imperative programs. You can create functions with variables (that store state); however, defining functions/variables outside classes actually makes them methods of the root Object class.
* Object-oriented programming – Everything is an object, derived from
the Object class.
* Functional programming – Computation proceeds via the evaluation of
functions that depend only on their input, not the program state.

### Classes and Inheritance

#### Classes

- 클래스는 `class` 키워드와 이름으로 정의된다. 이름은 대문자로 시작하고, 캐멀케이스(CamelCase)를 사용한다.
- `def` 키워드로 매서드를 정의한다. 매서드 이름은 대문자 없이 단어를 `_`로 연결한다.
- 클래스와 매서드는 `end` 키워드로 끝낸다.  

Ex. 

```ruby
class MyClass
    @boo            # an instance variable
    def my_method 
        @foo = 2    # an instance variable
    end
end 

in IRB:

> mc = MyClass.new  # create a MyClass object 
> mc.my_method      # => 2 
> mc.boo            # => error 
```

#### Methods

- 인스턴스 변수는 매서드 정의 안에서만 접근하거나 변경할 수 있다. 아래에서는 setter 매서드로 값을 지정한 후 getter 매서드로 값을 얻을 수 있다.  

Ex. 

```ruby
class MyClass 
    def boo     # a getter method 
        return @boo 
    end 
    def boo=(val)   # setter method 
        @boo = val 
    end 
end 

> mc = MyClass.new  # create a MyClass object 
> boo = 1   # => 1 
> boo       # => 1
```

루비 매서드는 implicit 리턴 값을 갖는다 - 매서드 안에서 마지막 표현식의 값이 리턴값이다. `return` 선언이 있지만 사용할 필요는 없다.

Ex. 두 개의 수를 비교하여 작은 것을 리턴해주는 min 매서드.

```ruby
def min(x,y) 
    if x < y then x else y end 
end
```

매서드를 호출할 때 괄호는 선택사항이다.

##### 클래스 매서드

클래스 매서드는 `self` 키워드를 앞에 놓으며, 나머지는 일반 매서드와 같다.

Ex. 

```ruby
class MyClass 
    def self.cls_method 
        "MyClass type" 
    end 
end 

> MyClass.cls_method # => "MyClass type"
```

`Array.methods` 명령으로 Array 클래스의 모든 매서드를 볼 수 있다.

매서드 이름의 마지막 문자가 매서드의 행동을 가리쳐주기도 한다. 물음표`?`로 끝나는 매서드는 리턴값이 불린값이다. 감탄사`!`로 끝나는 매서드는 객체의 상태를 변경할 수 있으며, 객체의 본사본을 변경할 수 있는 비감탄사 버전의 매서드도 제공된다. `self` 키워드는 현재 객체를 참조하도록 객체 안에서 사용할 수 있다. 

#### Inheritance, Mixins and Extending Classes

루비에선 하나의 상속만 지원된다. 멀티 상속을 위해서는 `mixin`이 기본적으로 제공된다. 클래스는 절대 닫히지 않아서 기존 클래스에 매서드를 추가할 수 있다.(작성한 클래스에도 표준 내장 클래스같이 적용된다) 

Ex. 

```ruby
class Fixnum 
    def previous 
        return self-1 
    end 
end
```

#### Specifying Access

클래스를 정의할 때 `public`, `private`, `protected` 키워드로 접근 레벨을 특정할 수 있다. C++ 이나 Java와는 약간 다르다.

– public : 누구나 호출할 수 있다. (C++ 이나 자바와 같다)
– protected : 정의된 클래스와 그 서브클래스의 객체에 의해서만 호출할 수 있다.
– private : 현재 객체의 컨택스트 안에서만 호출할 수 있다. 같은 클래스의 두 개의 객체는 서로의 private 매서드를 호출활 수 없다. private 매서드를 받는 것은 항상 `self`이다.

기본적으로 클래스의 모든 매서드는 `public`이며, 모든 인스턴스 변수는 `protected`이다.

객체의 속성에 접근하는 방법 중 getter, setter를 이용하는 방법이 있지만, 이건 고통이다. `attr_accessor`를 이용한 빠른 방법이 있다.

```ruby
class MyClass
    attr_accessor :boo
end
```

boo라고 불리는 인스턴스 변수를 만들고, getter, setter 매서드를 만든다.

```ruby
class Person
    attr_accessor :first_name, :last_name
end
```

first_name, last_name 인스턴스 변수를 만들고, 각각의 getter, setter 매서드를 만든다.

getter 매서드만을 원하면 `attr_reader`를 사용하고, setter 매서드만을 원하면 `attr_writer`를 사용한다.

상속의 문법은 다음과 같다:

```ruby
class NewClass < SuperClass 
    ... 
end
```

`initialize` 매서드는 `a = Array.new`와 같이 클래스 이름과 `new`를 호출하여 사용한다. 항상 private이다.

`module` 키워드를 사용하여 여러 클래스를 포함하는 네임스페이스를 만들 수 있다. `require` 키워드를 사용하여 다른 프로그램 안에 모듈을 포함할 수 있다. 예) require ’module_name’

클래스에서 `include` 키워드를 사용해서 모듈을 mixin할 수 있다. mixin한 모듈 안에 있는 모든 매서드를 클래스의 한 부분으로 만들 수 있다.

### Objects 

루비에선 모든 것이 객체이다. `Object` 클래스는 모든 클래스의 부모 클래스이다. 모든 객체에서 'Object'의 매서드를 사용할 수 있다.

`Object` 클래스의 중요한 매서드는 `class()`이다. 객체의 "type"을 리턴한다.

    > 1.class()     # => Fixnum 
    > 1.class       # => Fixnum 
    > 1.0.class     # => Float 
    > "Foo".class   # => String 

괄호는 선택사항이며 일반적으로 생략된다.

루비 문법은 대소문자를 구별한다. 대부분의 경우 대문자로 시작한 변수는 상수다.

### Variables

루비는 변수 선언을 사용하지 않는다. 적절한 변수명에 값을 주면 변수가 만들어진다.(duck-typing)

Ex.

    > a = 2 # => 2 
    > a     # => 2

`a.class`로 type을 보면 Fixnum 즉, 루비의 정수 데이타이다. 나머지 하나의 정수 타입은 Bignum(임의 크기의 수)이다.

Ex. 

    > a = "2" # => "2" 
    > a # => "2"

이제 a는 문자열(String) 변수이다.

**중요**: 루비에서 모든 할당은 참조로 이루어진다.(C나 C++에서는 기본적으로 할당은 값으로 이루어진다.) 즉, 변수는 객체의 참조를 갖고 있을 뿐이고, 객체의 타입은 상관하지 않는다. 

루비는 병렬 할당을 지원한다.

Ex. 두 변수의 값을 쉽게 스왑할 수 있다: 

    > a = 2     # => 2 
    > b = 1     # => 1 
    > puts a, b # 2 
                # 1 
                # => nil 
    > a, b = b, a # => [1, 2]

루비는 변수의 스코프와 타입를 나타내기 위한 간단한 네이밍 규약을 사용한다:

    - name      : 지역 변수
    - @name     : 인스턴스 변수
    - @@name    : 클래스 변수
    - $Name     : 전역 변수(대문자로 시작)

@과 $ 도장(sigil)은 프로그래머가 각 변수의 역할을 쉽게 지정할 수 있어 읽기 쉽게 한다.

지역 변수는 소문자로 시작하며, 여러 단어는 밑줄로 연결한다. 
상수는 대문자로 시작하며 밑줄을 사용한다. 
클래스와 모듈은 상수로 취급되어 대문자로 시작하고 CamelCase를 사용한다.

### String

큰따옴표`""`나 작은따옴표`''`를 사용하여 문자열을 만들 수 있다. 큰따옴표로 좀 더 많은 것을 할 수 있다. 큰따옴표로 문자열을 만들 때 `#{루비 코드}`을 삽입하여 실행시킨 문자열을 만들 수 있다.
Ex.

    > "360 degrees=#{2*Math::PI} radians" 
    => "360 degrees=6.283185307179586 radians" 

백틱````으로 문자열을 감싸면 백그라운드 OS(OS X 등)에서 명령어를 실행한다.
Ex. 

    > `date` 
    => "Tue Oct 15 09:10:21 MDT 2013n" 

루비 문자열은 가변적이다. 루비가 새문자열을 다룰 때마다 새로운 `String` 객체를 만든다. 즉, 루프에서 문자열을 만들면, 각 반복문에서 새로운 `String` 객체가 만들어진다. 주의해야한다.

`String` 클래스는 문자열을 다룰 수 있는 많은 매서드를 가지고 있다.
Ex. 

    > name = "Homer Blimpson" # => "Homer Blimpson" 
    > name.length # => 14 
    > name[6] # => "B" 
    > name[6..14] # => "Blimpson" 
    > "Bart " + name[6..14] # => "Bart Blimpson" 
    > name.encoding # => #<Encoding:UTF-8>

### Regular Expression Class

루비는 문자열과 밀접한 `Regexp`라는 정규식 클래스를 가지고 있다. 정규식은 텍스트의 문자열 매칭(특정 문자, 단어, 문자 패턴)을 위한 간결하면서 유연한 방법을 제공한다.

루비의 정규식은 `/pattern/modifiers`의 형식으로 쓴다. “pattern”은 정규식 자체이며, “modiﬁers”는 다양한 옵션 문자들이며, 선택적이다. Perl에서 빌려온 문법이다. 특정 정규식을 테스트하려면 `=~` 연산자를 사용하며, 매칭되는 문자열의 첫 문자의 위치를 리턴하거나 매칭되는 것이 없으면 `nil`을 리턴한다.
Ex. "Homer" =~ /er/ # => 3

패턴에 대한 갖는 의미를 몇 가지만 살펴보면:

| 기 호       | 의 미                      |
|------------|---------------------------|
| [ ]        | 범위 지정 예: [a-z]는 a부터 z사이의 모든 문자|
| \w         | word 문자, [0-9A-Za-z]와 동일|
| \W         | \w와 반대                   |
| \s         | 공백 문자, [\t\n\r\f]와 동일  |
| \S         | \s와 반대                   |
| \d         | digit 문자, [0-9]와 동일     |
| \D         | /d와 반대                   |
| \b         | 백스페이스(범위 지정에서 사용될 때)|
| \b         | 단어 경계(boundary)(범위 지정에서 사용되지 않을 때)|
| \B         | \b와 반대로 일치              |
| *          | 문자가 없는 경우나 하나 이상 연속하는 문자 찾기|
| +          | 하나 이상 연속하는 문자 찾기     |
| {m, n}     | at least m and at most n  |
| ?          | at most 1, {0,1}과 동일     |
| |(버티컬 바) | 왼쪽 혹은 오른쪽과 일치         |
| ( )        | 그룹핑                      |

정규식은 문자열을 처리할 때 종종 사용된다. 다음 루비 정규식은 전화번호에서 숫자가 아닌 모든 문자를 ""로 바꾼다. 즉, 전화번호에서 숫자를 제외한 모든 문자를 제거한다:

    phone = phone.gsub!(/D/, "") 

정규식은 일반적으로 이메일, 전화번호 같은 사용자 입력을 검증하기 위해 사용한다.
Ex. 다음 정규식은 이메일 주소를 검증하기 위해 사용할 수 있다: 

    /A[w._%–]+@[w.-]+.[a-zA-Z]{2,4}z/ 

### Symbols 

루비 symbol도 문자열과 밀접하며, 루비에서 문자열은 가변적이고, 루비 symbol은 비가변적인 것을 기억하라.
루비 인터프리터는 심볼 테이블에 모든 클래스, 매서드, 변수를 저장한다. 이 테이블에 자신만의 심볼을 추가할 수 있다. 특별히 심볼은 이름 앞에 콜론`:`을 붙여 만든다.
    Ex. attr_reader :row, :col 

루비 심볼은 이름과 문자열을 대표하곤 한다; 그러나 `String` 객체와는 다르게 같은 이름의 심볼은 하나의 루비 세션 동안 단 한번만 초기화되며 메모리에 존재한다. 루비 심볼은 비가변적이며, 런타임 동안 변경할 수 없다.
    Ex. :name = "Homer" # => will yield an error

심볼은 메모리에 단 한번만 저장되어 메모리 공간 활용에 유리하다. 같은 이름을 가진 여러 개의 문자열이 메모리에 존재할 수 있다.
Ex. 

    > puts :name.object_id # => yields 20488 
    > puts :name.object_id # => yields 20488 
    > puts "name".object_id # => yields 2168472820 
    > puts "name".object_id # => yields 2168484060 

언제 문자열을 사용하고 언제 심볼을 사용하는가? 주먹구구 지침:
    - 만약 객체의 컨텐츠(즉, 일련의 문자들)가 중요하면 이 문자들을 다루려면 문자열을 사용하라.
    - 객체의 아이덴티티가 중요하면(이 경우에는 아마 문자들을 다루고 싶지 않을듯), 심볼을 사용하라.

### Expressions

루비 문법은 표현식 지향적이다. 루비의 모든 것은 하나의 표현식으로 다루어지므로 무언가를 계산한다.

Ex. 조건적인 실행이나 루핑 구조가 다른 언어에서는 명령문으로 취급되지만 루비에서는 표현식으로 취급된다.

루비에서 `if`, `case`, `for` 구조는 계산된 마지막 표현식의 값을 리턴한다.

### Control Structures – Conditional Execution

루비는 조건을 표현하기 위한 풍부한 문법을 가지고 있다. 가장 기본적인 것은:

```ruby
if expression
    code
end 
```

조건식이 `false` 나 `nil`이 아닌 값이면 code가 실행된다.

else 절은 if 조건식이 참이 아닐 경우 실행되어야 하는 코드를 추가할 수 있다:

```ruby
if expression1
    code
elsif expression2
    code
else 
    code
end
```

* elsif는 오타가 아니다.

There’s a shorthand way of expressing the if conditional that treats it as an expression modiﬁer: 

```ruby
code if expression
```

루비는 C/C++ 처럼 `?:` 연산자도 있다.

비교 연산자: 

```ruby
==, !=, =∼, !∼, === 
```

There is a case structure in Ruby, === is the case-equality operator.

표준적인 조건식에 더하여, 루비는 코드의 가독성과 이해를 증가하기 위해 몇 가지를 추가한다.
예로, 다음은 if 문의 반대이다:

```ruby
until expression
    code
end
```

조건식이 `false` 나 `nil`아닐 때까지 code가 수행된다.

until 조건식에 else 절을 붙일 수 없다.

### Control Structures – Iteration

`for`/`in` 루프는 가산 누적되면서 반복한다: 

```ruby
for var in collection do 
    body
end 
```

Exit condition loop: 

```ruby
while condition do 
    body
end 
```

Exit condition loop, while과 반대: 

```ruby
until condition do 
    body
end 
```

In Ruby, it’s more common to use iterators (next lecture).

### Collections 

루비에는 많은 컬렉션 클래스가 있어 데이타의 컬렉션을 하나의 편리한 곳에 저장하고 참조할 수 있다. 

제일 중요한 컨렉션 클래스는 배열`Array`과 해시`Hash`이다. `Set` 클래스가 최근에 추가되었다. 

각각의 컬렉션 클래스는 `Enumerable` 모듈을 믹신으로 포함하며, `Enumerable`에 있는 모든 매서드들을 공유한다.

`Enumerable` 모듈은 `iterator` 매서드를 제공하는데 한 컬렉션의 모든 요소들에 걸쳐 반복 실행할 수 있다.

배열은 레일즈 컨트롤러에서 널리 사용된다:

```ruby
def index 
    @posts = Post.all 
end
```

`/app/controllers/post_controller.rb`의 도입 부분에 있는 위의 index 매서드에서 인스턴트 변수인 `@post`는 배열이다.

### Array

배열은 0에서 시작하는 정수로 인덱스할 수 있는(zero-based addressing) 객체 참조의 컬렉션을 담고있다.
Ex. 

    > a = [33.3, "hi", 2] 
    > a[0]          # => 33.3 

Array 클래스에는 아주 많은 매서드가 있다. 예를 들면, 배열의 시작부터 증가되는 수, 끝에서 감소되는 수, 범위 `a[1..2]`, `sort`, `include?`, `reverse`, `length`, `first`, `last`, `<<`, `push`, `pop`, 등. 
Ex. 

    > a[1..2]       # => ["hi", 2] 
    > a << 5        # => [33.3, "hi", 2, 5] 
    > a[-1]         # => 5 
    > a.include? 2  #=> true

#### Hashes 

해시는 결합(associative) 배열이며, 키와 값이 `=>` 심볼로 분리된 객체이다. 키를 사용하여 값을 인덱스한다. 배열에서 키는 정수이고, 해시의 키는 객체이다. 배열은 `[]`을 사용하지만 해시는 `{}`를 사용한다.
Ex. 

    phone = {’home’=> 1, ’mobile’=> 2, ’work’=> 3}

혹은 심볼을 사용하여 더 낫게: 

    phone = {:home => 1, :mobile => 2, :work => 3} 
    > phone[:home]      # => 1 
    > phone.key(1)      # => :home 
    > phone.key?(:home) #=> true 
    > phone.value?(1)   #=> true

#### Nested Collections 

다차원의 컬렉션을 만들려면 컬렉션들을 들여쓰기한다.
Ex. 

    > ary = [["red", "green", "blue"], [1,2,3], ["Alpha", "Beta", "Gamma"]] 
    > ary[2][1]      # => "Beta" 
    > hsh = {"Chicago"=>{"nickname"=>"The Windy City", "state"=>"IL"}, "New York City"=>{"nickname"=>" The Big Apple", "state"=>"NY"}} 
    > hsh["Chicago"]["nickname"] # => "The Windy City"

### Code Blocks 

블럭은 `{}`로 둘러싸인 여러 줄의 코드로 되어있으며, 매서드에 매개변수를 넘길 수 있다. 

Using this feature it is easy to build code libraries which can delegate varying functionality to code blocks to be built later. 

**Important**: A block may appear only in the source if it is adjacent to a method call (on the same line as the method call’s last parameter). 

A block is invoked using the `yield` statement. 
Ex. 

```ruby
def three_times 
    yield 
    yield 
    yield 
end 
```

* `three_times {puts "Hello"}` 는 "Hello"를 세번 출력한다.

#### Iterators 

루비에서 다양한 루프 구조는 드물게 사용하며, 반복을 사용하는 것이 더 일반적인다. 반복 매서드를 정의하는 특징은 컬렉션의 각 요소에 블럭 코드를 적용하는 것이다. The deﬁning feature of an iterator method is that it invokes a block of code, applying it to each element in a collection. 

A collection class that includes the Enumerable module is required to supply an each method. This method must yield the successive members of the collection.

Iterators work because you can pass parameters into blocks. 

Ex. The each method in the Enumerable module works something like: 

```ruby
def each 
    for each item in the collection # this is psuedocode 
        yield(item) 
    end 
end 
```
    > a = [33.3, "hi", 2] 
    > a.each {|element| puts element} 
    33.3 
    "hi" 
    2 
    => [33.3, "hi", 2]

레일즈 뷰에서 사용한 반복문이다:

```html
<tbody> 
    <% @posts.each do |post| %> 
        <tr> 
            <td><%= post.title %></td> 
            <td><%= post.body %></td> 
            <td><%= link_to ’Show’, post %></td> 
            <td><%= link_to ’Edit’, edit_post_path(post) %></td> 
            <td><%= link_to ’Destroy’, post, method: :delete , data: { confirm: ’Are you sure?’ } %></td> 
        </tr> 
    <% end %> 
</tbody>
```

/views/posts/index.html.erb 안에 있는 소스이다. `<%`와 `%>`로 둘러싸인 부분은 뷰에서 실행되는 루비 코드(embedded Ruby)이며, `<%=`로 시작되는 것은 실행 결과를 HTML 코드로 삽입한다.

## 참고링크

- [Python & Ruby](https://opentutorials.org/module/1569): Ruby와 Python을 동시에 배우는 병렬학습