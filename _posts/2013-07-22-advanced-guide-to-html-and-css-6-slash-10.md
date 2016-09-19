---
layout: post
title: "HTML & CSS 중급자 가이드 - 6강 : jQuery"
description: "상위 10,000 웹사이트에서 자바스크립트는 92%가 넘게 사용되고, jQuery는 63%를 넘게 사용되고 있다."
category: blog
tags: [Advanced, CSS, HTML, jQuery]
---

<div id="toc"><p class="toc_title">목차</p></div>

원본 : [An Advanced Guide to HTML &amp; CSS - LESSON 6 : jQuery][1]

웹 디자이너나 프론트 엔드 개발자가 되려면 일반적으로 어느 정도는 (종종 JS라고 불리우는) 자바스크립트와 jQuery에 부딪칠 것이다. 상위 10,000 웹사이트에서 자바스크립트는 [92%가 넘게][2] 사용되고, jQuery는 [63%를 넘게][3] 사용되고 있다. 말할 필요도 없이 매우 인기가 있다. 미래의 어떤 시기에 자신의 행동을 구축하기위해 자바스크립트나 jQuery를 [코딩하길][4] 열망할 수도 있다.

자바스크립트와 jQuery가 정확히 무엇인지 묻고 있다면, 두려워말라. 이 단원에서 자바스크립트의 간략한 개요를 보여줄 것이고 jQuery도 살펴볼 것이다.

## JavaScript Intro

[자바스크립트][5]는 웹사이트에 상호작용성을 추가할 수 있게 해주고 유저 경험을 풍부하게 하는 것을 돕는다. HTML은 페이지에 **구조**를 제공하고 CSS는 **외모**를 제공하고 자바스크립트는 **행동**을 제공한다.  CSS처럼, 자바스크립트는 `.js` 화일 확장자로 외부 화일에 저장해야하며, `script` 엘리먼트를 사용하여 HTML 문서 안에서 참조(reference)된다. HTML 안의 자바스크립트 참조가 어디에 있느냐는 그것이 언제 실행되야하는가에 따라 다르다. 일반적으로 말하면 자바스크립트 화일이 연급되는 가장 좋은 위치는 - 모든 HTML이 파싱되고난 후에 자바스크립트가 로드되도록 - ``태그가 끝나기 바로 전이다. 그러나, 때론 HTML을 렌더링하거나 그것의 행동을 결정하는 것을 도와야하기 때문에 문서의 `head` 안에서 참조될 수 있다.

```js
<script src="script.js"></script>
```

### Values & Variables

값(value)과 변수(variable)는 자바스크립트 기초의 일부다. 일반적으로 값은 자바스크립트가 인식할 다양한 종류의 값이고, 변수는 이 값들을 저장하고 공유하기 위해 사용된다.

값은 문자열, 참/거짓 불린(Boolean), 숫자, `undefined`, `null`, 혹은 함수와 객체 같은 값들도 포함할 수 있다.

변수가 정의되는 인기있는 방법 중 하나는 `var` 키워드와 뒤따르는 변수명, 등호 기호 (`=`), 그리고 값과 세미콜론 (`;`)으로 마친다. 변수 이름은 문자, 밑줄 (`_`)이나 달러 기호 (`$`)로 시작되어야 한다. 변수는 숫자로 시작될 수 없으나 시작 이후에는 사용될 수 있다. 어떤 경우에도 하이픈은 사용할 수 없다. 더불어 자바스크립트는 대소문자를 구분하기 때문에 문자는 `a`에서 `z`까지의 대/소문자 모두가 포함된다.

역자 참조 : MDN [Values, variables, and literals][6]

변수를 명하는 일반적인 규칙은 대쉬나 밑줄을 젼혀 사용하지 않고 캐멀케이스([camelCase][7])를 사용하는 것이다. 캐멀케이스는 빈칸을 없애고 첫 단어를 제외한 각 단어를 대문자로 시작하여 단어들을 조합한다. 예를 들면 `shay_is_awesome`은 `shayIsAwesome`으로 이름짓는 것이 더 일반적이다.

```js
var theStarterLeague = 125;
var food_truck = 'Coffee';
var mixtape01 = true;
var vinyl = ['Miles Davis', 'Frank Sinatra', 'Ray Charles'];
```

### Statements

전반적으로 자바스크립트는 쓰여진 순서대로 브라우저에 의해 실행되는 문장(statement)의 집합이다. 이 문장들은 수행될 댜양한 행동들을 결정하는 명령을 제공한다. 문장들은 다양한 형태와 크기가 되고, 여러 문장은 세미콜론 `;`으로 나뉜다. 새로운 문장은 새로운 줄에서 시작되어야하며 들여쓰기는 문장들을 더 읽기쉽게 하기위해 사용해야하지만, 반드시 요구되는 것은 아니다.

```js
log(polaroid);
return('bicycle lane');
alert('Congratulations, you ' %2B outcome);
```

### Functions

자바스크립트 기초에 더해, 함수(function)을 살펴보는 것은 중요하다. 함수는 지금, 또는 나중을 위해 저장된, 다른 인수(argument)를 받아들이기도 하는 함수에 의존하는, 기술된 일련의 행동을 수행하는 방법을 제공한다.

함수는 `function` 키워드와 뒤따르는 함수명, 필요할 경우, 쉼표로 분리된 인수 목록(전체가 소괄호로 감싸진다)과 함수를 정의하는 자바스크립트 문장 또는 문장들(전체가 중괄호 `{}`로 둘러싸여진다)을 사용해 정의된다.

```js
function sayHello(name) {
  return('Hello ' %2B name);
}
```

### Arrays

인정하듯이 몇몇 값은 배열로 반환될 수 있다. 배열은 항목이나 값의 목록을 저장하는 방법을 포함한다. 여러 가지 이유로 배열은 다양한 매서드와 연산자로 팀색할 수 있어 도움이 된다. 게다가 상황에 따라 배열은 다양한 값을 저장하고 반환하는 데 사용될 수 있다.

일반적으로 말하면 배열은 대괄호 `[]`와 쉼표로 분리된 항목들로 식별된다. 항목은 `0`에서 시작되어 증가한다. 한 목록에서 세번째 아이템을 식별할 때는 실제 `[2]`로서 식별된다.

### Objects

자바스크립트는 키/값의 한 쌍인 객체의 기초 위에 만들어진 것이기도 하다. 예를 들어 `school`로 이름지어진 객체가 있고, 이 객체가 `name`, `location`, `students`, `teachers` 키들(프로퍼티/속성으로도 알려짐)과 그들의 값을 포함하고 있다고 하자.

아래 예제에서 변수 `school`은 여러 속성을 보유하는 객체로 설정된다. 각 속성은 하나의 키와 값을 가진다. 전체 객체는 중괄호 `{}`로 감싸졌고, 속성은 쉽표로 분리되며, 각 속성은 콜론과 값이 뒤따르는 하나의 키를 갖는다.

OBJECTS

```js
var school = {
  name: 'The Starter League',
  location: 'Merchandise Mart',
  students: 120,
  teachers: ['Jeff', 'Raghu', 'Carolyn', 'Shay']
};
```

ARRAY

```js
var school = ["Austin", "Chicago", "Portland"];
```

![Web Inspector Console][8]

**Fig. 6.01**  크롬 웹브라우저 안에 내장된 개발자 도구를 사용하면 자바스크립트를 콘솔 안에서 실행시킬 수 있다.

## jQuery Intro

자바스크립트와 그 기초의 일부에 대한 기본적인 이해와 함께 jQuery를 살펴볼 차례다. jQuery는 HTML, CSS와 자바스크립트 간의 상호 작용을 단순화시키기 위해 존 레식이 작성한 오픈소스 자바스크립트 라이브러리다. jQuery가 출시된 2006년 이후 급성장하였고 크고 작은 웹사이트와 기업에서 사용되고 있다.

jQuery를 그렇게 인기있게 만든 것은 CSS를 닯은 실렉션과 동작의 알기쉬운 분리와 같은 [손쉬운 사용][9]이었다. jQuery의 이점은 막대하지만 우리 목적은 엘리먼트를 찾고 그것들과 작업을 수행하는 능력에 대해서만 고려해볼 것이다.

### Getting Started with jQuery

jQuery 사용의 첫걸음은 HTML 문서 안에 그것을 참조하는 것이다. 자바스크립트에서 이전에 말했듯이 `` 태그의 바로 앞에 `script` 엘리먼트를 사용함으로 행해진다. jQuery는 자신이 라이브러리이기 때문에 다른 자바스트립트가 쓰여진 것과는 전부 분리시키는 것이 가장 좋다.

jQuery를 참조하는 것은 몇 가지 옵션이 있다. 특히, 축소되거나 압축되지 않은 버전을 사용할지 여부, 그리고 [구글 호스팅 라이브러리][10]와 같은 컨텐츠 전송 네트워크(CDN)을 사용할지 여부와 같은 옵션이 있다. 라이브 프로덕션 환경에서 코드가 쓰여지는 경우에는 더 나은 로딩 시간을 위해 축소된 버전을 사용하는 것이 권장된다. 게다가 구글과 같은 CDN은 로딩 시간과 잠재적인 캐싱 이득에 도움이 된다.

```js
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="script.js"></script>
```

위의 코드 예제에서 두번째 `script` 엘리먼트는 또 하나의 자바스크립트 화일을 참조하고 있는 것을 주목하라. 모든 커스텀, 직접 쓴 자바스크립트과 JQuery는 이 화일에서 쓰여져야한다. 더불어 이 화일은 이미 정의된 JQuery 함수를 참조할 수 있도록 jQuery 화일 뒤에 명확하게 위치하여야 한다.

> #### Where is the leading http?
>
> 위 예제에서 구글 CDN 참조 안에 선행하는(leading) `http`가 없는 것을 발견할 수 있다. `http`와 `https` 연결을 모두 허용하기위해, `http`를 의도적으로 생략한 것이다. 웹 서버의 이점없이 로컬에서 동작할 때는 시스템의 로컬 디스크 드라이브의 화일을 찾는 것을 방지하려면 선행하는 `http`가 필요할 것이다.

### jQuery Object

jQuery는 자신의 객체 - 달러 기호 `$`, `jQuery`라고도 알려진 - 와 함께 제공된다. `$` 객체는 엘리먼트를 선택하고 작업을 수행하려하는 엘리먼트 노드를 반환하기위해 특별히 만들어졌다. 이 선택과 행동은 실제 jQuery 라이브러리의 바깥에서 참조되는 새로운 화일에 작성되어야 한다.

```js
$();
jQuery();
```

### Document Ready

페이지를 탐색하고 조작하기위해 jQuery를 시동하기(역자주 : trigging은 triggering의 오타인듯) 전에 DOM의 로딩이 끝날 때까지 기다리는 것이 가장 좋다. 다행히 jQuery는 `.ready()` 이벤트를 가지고 있다. 우리가 손수 쓴 jQuery 코드를 이 함수 안에 모두 배치하여 페이지가 로드되어 DOM이 준비될 때 까지 그것이 실행되지 않을 것을 보장할 수 있다.

```js
$(document).ready(function(event){
  // jQuery code
});
```

## Selectors

앞에서 언급하였듯이 jQuery의 핵심 개념 중 하나는 [엘리먼트를 선택][11]하는 것과 작업을 수행하는 것이다. jQuery는, CSS를 모방함으로써 극도로 쉽게, 선택 작업과 엘리먼트나 엘리먼트들의 작업을 훌륭하게 해왔다. 일반적인 CSS 실렉터에 뛰어넘어 jQuery는 사용 브라우저에 상관없이 작동하는 고유 CSS3 실렉터를 모두 지원한다.

jQuery 객체 `$()`를 호출할 때 실렉터를 포함하면 그것을 조작할 수 있는 DOM 노드를 반환할 것이다. 실렉터는 소괄호 `('...')` 안에 넣고 CSS의 실렉터와 똑같은 엘리먼트를 선택할 수 있다.

```js
$('.feature');              // Class selector
$('li strong');             // Descendant selector
$('em, i');                 // Multiple selector
$('a[target="_blank"]');    // Attribute selector
$('p:nth-child(2)');        // Pseudo-class selector
```

### This Selection Keyword

jQuery 함수 안에서 작업할 때 원래의 실렉터 안에서 참조되었던 엘리먼트를 선택하고 싶을 것이다. 이 경우에는 `this` 키워드가 현재 핸들러에서 선택된 엘리먼트를 참조하는 데 사용될 수 있다.

```js
$('div').click(function(event){
  $(this);
});
```

> #### jQuery Selection Filters
>
> CSS 실렉터가 충분치 못하다면 JQuery에 내장된 커스텀 [필터들][12]이 도움이 될 것이다. 이 필터들은 CSS의 확장이고 엘리먼트나 관련자를 선택할 때 더 많은 제어할 수 있다.
>
>
>       $('div:has(strong)');
>
>
> 있는 그대로 이 필터들은 실렉터 안에서 사용될 수 있지만, DOM에 순수하지(native) 않기 때문에 약간 느려진다. 필터를 사용할 때 최고의 결과는 jQuery 탐색 기능 중 `:filter()` 매서드를 이용하여 얻어진다.

## Traversing

종종 일반적인 CSS 실렉터만으로는 잘라내듯 선택되지 않아 좀 더 세세한 제어가 요구된다. 다행히 jQuery는 DOM 트리를 위아래로 탐색(traverse)하여 필요한 대로 엘리먼트를 걸러내고 선택하는 몇 가지 매서드를 제공한다.

DOM 내부의 엘리먼트를 걸러내기 시작하려면 상대적으로 탐색하는 것이 필요하다. 아래 예에서 애초의 선택은 DOM의 모든 `div` 엘리먼트를 찾고 난 후, `.not()` 매서드를 사용하여 필터링한다. 이 구체적인 매서드로 `type`나 `collection` 클래스를 갖지 않는 `div` 엘리먼트가 선택될 것이다.

```js
$('div').not('.type, .collection');
```

### Chaining Methods

선택된 엘리먼트를 훨씬 더 많이 제어하기 위해, 다양한 탐색 매서드들을 단순히 점을 사용하여 서로 연결할 수 있다.

아래 코드 예제는 `.not()` 매서드와 `.parent()`를 모두 사용한다. 함께 결합해서 `type` 혹은 `collection` 클래스를 갖지않는 `div` 엘리먼트의 부모 엘리먼트만을 선택할 것이다.

```js
$('div').not('.type, .collection').parent();
```

### Traversing Methods

JQuery는 상당수의 [탐색][13] 매서드를 사용할 수 있다. 그것들은 일반적으로 필터링(filtering), 기타 탐색(miscellaneous traversing), DOM 트리 탐색(DOM tree traversing)의 세가지 범주에 속한다. 각 범주의 구체적인 메서드는 아래와 같다.

#### Filtering

  * `.eq()`
  * `.filter()`
  * `.first()`
  * `.has()`
  * `.is()`
  * `.last()`
  * `.map()`
  * `.not()`
  * `.slice()`

#### Miscellaneous Traversing

  * `.add()`
  * `.andSelf()`
  * `.contents()`
  * `.end()`

#### DOM Tree Traversal

  * `.children()`
  * `.closest()`
  * `.find()`
  * `.next()`
  * `.nextAll()`
  * `.nextUntil()`
  * `.offsetParent()`
  * `.parent()`
  * `.parents()`
  * `.parentsUntil()`
  * `.prev()`
  * `.prevAll()`
  * `.prevUntil()`
  * `.siblings()`

## Manipulation

DOM에서 엘리먼트를 선택하고 탐색하는 것은 jQuery가 제공하는 것의 부분일 뿐이고, 또 다른 주요 부분은 일단 찾아낸 엘리먼트와 뭘 할 수있는 것인가이다. 가능한 것 중 하나는 이 엘리먼트들을 읽거나 추가하고, 속성이나 스타일을 변경하여 [조작][14]하는 것이다. 추가적으로 엘리먼트는 DOM 안에서 변경되고, 위치를 바꾸고, 제거하고, 새 엘리먼트를 추가하는 것 등을 할 수 있다. 전반적으로 엘리먼트를 조작하는 옵션은 매우 광대하다.

### Getting &amp; Setting

주목해야힐 조작 매서드는 정보를 얻거나(_getting_) 혹은 설정하는(_setting_) 두 개의 지시자 중 하나로 사용된다는 것이 매우 일반적이다. 정보를 얻는다는 것은 가져올 정보 조각이 무엇인지를 결정하기 위해 매서드와 함께 실렉터를 사용하게 되는 것이다. 더불어 똑같은 실렉터와 매서드를 정보 조각을 설정하는 데에도 사용할 수 있다.

```js
// Gets the value of the alt attribute
$('img').attr('alt');

// Sets the value of the alt attribute
$('img').attr('alt', 'Wild kangaroo');
```

뒤따르는 예제와 스니핏에서, 매서드는 주로 설정 모드에서 사용되지만, getting 모드에서도 사용될 수 있다.

### Attribute Manipulation

검사되고 조작될 수 있는 엘리먼트의 한 부분은 속성이다. 몇 가지 선택사항은 속성이나 값을 추가, 제거, 변경할 수 있는 것이다. 아래 예제에서 `.addClass()` 매서드는 모든 짝수번 째의 `li` 항목에 클래스를 추가한다. `.removeClass()` 매서드는 모든 단락에서 클래스를 모두 제거하고 마지막으로 `.attr()` 매서드는 `abbr` 엘리먼트의 `title` 속성을 찾아서 그것을 `Hello World`로 설정한다.

```js
$('li:even').addClass('even-item');
$('p').removeClass();
$('abbr').attr('title', 'Hello World');
```

#### Attribute Manipulation Methods

  * `.addClass()`
  * `.attr()`
  * `.hasClass()`
  * `.prop()`
  * `.removeAttr()`
  * `.removeClass()`
  * `.removeProp()`
  * `.toggleClass()`
  * `.val()`

### Style Manipulation

속성을 조작하는 것에 더해, 엘리먼트의 스타일도 다양한 매서드로 조작될 수 있다. 엘리먼트의 높이, 너비, 위치를 읽거나 설정할 때 몇몇 특정 매서드를 사용할 수 있고, `.css()` 매서드를 사용하면 어떤 CSS 스타일 변경도 다룰 수 있다.

특별히 `.css()` 매서드는 하나 또는 여러 개의 속성을 설정하거나, 각 변화에 대한 문법을 설정할 수 있다. 하나의 속성을 설정하려면 속성 이름과 값은 각각 따옴표와 쉼표로 분리되어야 한다. 여러 속성을 설정하려면 속성은 중괄호 안에 포함되어야 한다. 속성명은 캐멀케이스되어야 하고, 필요한 경우 하이픈은 제거된다. 그 뒤에 콜론과 인용부호로 감싼 값이 따른다. 속성과 값으로 짝지워진 각 쌍은 쉼표로 분리된다.

높이, 너비, 위치 매서드는 모두 픽셀값을 기본으로 하나, 다른 측정 단위도 사용될 수 있다. 아래에서 보여지듯이, 측정 단위를 변경하면 값 다음에 더하기 부호와 뒤따르는 인용부호된 측정단위를 사용하여 식별한다.

```js
$('h1 span').css('font-size', 'normal');
$('div').css({
  fontSize: '13px',
  background: 'http://nolboo.github.io#f60'
});
$('header').height(200);
$('.extend').height(30 %2B 'em');
```

#### Style Manipulation Methods

  * `.css()`
  * `.height()`
  * `.innerHeight()`
  * `.innerWidth()`
  * `.offset()`
  * `.outerHeight()`
  * `.outerWidth()`
  * `.position()`
  * `.scrollLeft()`
  * `.scrollTop()`
  * `.width()`

### DOM Manipulation

마지막으로, 엘리먼트의 위치를 변경하거나 추가하고 제거하고, 노골적으로 엘리먼트를 변경하여 DOM을 검사하고 조작할 수 있다. 여기서의 선택사항은 DOM 안에서 어떤 잠재적인 변화도 허용할 정도로 깊고 다양하다.

각 개개의 DOM 조작 매서드는 자신의 문법을 가지고 있지만, 아래 예에서 그 중 일부를 대강 설명해본다. `.prepend()` 매서드는 모든 `section`에 `h3` 엘리먼트를 새로 추가하고, `.after()` 매서드는 링크 바로 뒤에 `em` 엘리먼트를 새로 추가하며, `.text()` 매서드는 모든 `h1` 엘리먼트의 문자를 `Hello World`로 바꾼다.

```js
$('section').prepend('Featured');
$('a[target="_blank"]').after('New window.');
$('h1').text('Hello World');
```

#### DOM Manipulation Methods

  * `.after()`
  * `.append()`
  * `.appendTo()`
  * `.before()`
  * `.clone()`
  * `.detach()`
  * `.empty()`
  * `.html()`
  * `.insertAfter()`
  * `.insertBefore()`
  * `.prepend()`
  * `.prependTo()`
  * `.remove()`
  * `.replaceAll()`
  * `.replaceWith()`
  * `.text()`
  * `.unwrap()`
  * `.wrap()`
  * `.wrapAll()`
  * `.wrapInner()`

## Events

jQuery의 아름다움 중 하나는 벌어지는 특정 이벤트나 액션에서만 호출되는 매서드인 [이벤트 핸들러][15]를 쉽게 추가하는 수 있는 것이다. 예를 들어, 엘리먼트에 클래스를 추가하는 매서드를 클릭된 엘리먼트에서 발생되도록 설정될 수 있다.

아래에서 모든 `li` 항목을 잡아채는 표준 실렉터가 있다. `.click()` 이벤트 매서드는 `li` 아이템 실렉터에 구속되어 있으며(binding), `li` 아이템을 클릭할 때 발생되는 액션을 설정한다. `.click()` 이벤트 매서드 안에 실행될 액션을 보장하는 함수가 있다. 함수 바로 다음의 소괄호는 함수를 위한 패러미터(속성)를 전달할 수있으며, 이 예제에서는 `event` 객체가 사용되었다.

함수 안에 `.addClass()` 매서드가 구속된 또하나의 실렉터가 있다. 이제 `li` 항목이 클릭되면 `this` 키워드를 통해 `li` 항목은 `saved-item` 클래스를 받을 수 있다.

```js
$('li').click(function(event){
  $(this).addClass('saved-item');
});
```

### Event Flexibility

`.click()` 이벤트 매서드는, 소수의 다른 이벤트 매서드와 함께, jQuery 1.7부터 도입된 `.on()` 매서드를 사용하는 숏핸드 매서드이다. `.on()` 매서드는, 페이지에 동적으로 추가되는 엘리먼트를 위한 자동 위임을 사용하여, 상당한 유연성을 제공한다.

`.on()` 매서드를 이용하여 첫번째 인수는 네이티브 이벤트 이름이어야 하는 반면 두번째 인수는 이벤트 핸들러 함수이어야 한다. 이전의 예제를 살펴보면 `.on()` 매서드가 `.click()` 매서드의 자리에서 호출되고 있다. 이제 `click` 이벤트 이름은 전과 똑같이 자리잡은 이벤트 핸들러 함수와 함께 `.on()` 매서드 안에서 첫번째 인수로서 전달된다.

```js
$('li').on('click', function(event){
  $(this).addClass('saved-item');
});
```

### Nesting Events

또 다른 하나 안에 하나를 품게함으로써 여러 개의 이벤트 핸들러와 트리거를 가질 수 있다. 예재로 `.on()` 이벤트 매서드 밑으로 `hover` 인수를 전달하여 `pagination` 클래스를 가진 엘리먼트 위를 호버할 때 호출될 수 있다. `.on()` 이벤트를 호출하면 `.click()` 아벤트 `up` ID를 가진 앵커를 호출된다.

```js
$('.pagination').on('hover', function(event){
  $('a#up').click();
});
```

### Event Demo

데모로서 경고 메시지를 사용하여 다음 코드 스니핏은 경고 메시지를 만들고나서 닫기 아이콘을 클릭하면 메시지를 제거하는 방법을 보여준다.

###### HTML

```html
<div class="alert-warning">
  <strong>Warning!</strong> I’m about to lose my cool.
  <div class="alert-close">×</div>
</div>
```

###### JavaScript

```js
$('.alert-close').on('click', function(event){
  $('.alert-warning').remove();
});
```

**[Demo][16]**

### Event Methods

jQuery는 브라우저와 상호작용할 때 유저 행동을 등록하는 데에 기반을 둔 모든 매서드를 아주 많이 제공한다. 이런 매서드들은 아주 인기가 많지만 브라우저, 폼, 키보드, 마우스 등의 이벤트에 제한적이지 않은 꽤 많은 이벤트를 등록한다. 가장 인기있는 매서드들은 다음과 같다:

#### Browser Events

* `.resize()`
* `.scroll()`

#### Document Loading

* `.ready()`

#### Event Handler Attachment

* `.off()`
* `.on()`
* `.one()`
* `jQuery.proxy()`
* `.trigger()`
* `.triggerHandler()`
* `.unbind()`
* `.undelegate()`

#### Event Object

* `event.currentTarget`
* `event.preventDefault()`
* `event.stopPropagation()`
* `event.target`
* `event.type`

#### Form Events

* `.blur()`
* `.change()`
* `.focus()`
* `.select()`
* `.submit()`

#### Keyboard Events

* `.focusin()`
* `.focusout()`
* `.keydown()`
* `.keypress()`
* `.keyup()`

#### Mouse Events

* `.click()`
* `.dblclick()`
* `.focusin()`
* `.focusout()`
* `.hover()`
* `.mousedown()`
* `.mouseenter()`
* `.mouseleave()`
* `.mousemove()`
* `.mouseout()`
* `.mouseover()`
* `.mouseup()`

## Effects

이벤트와 버금가게, jQuery는 소수의 커스터마이징 가능한 효과도 제공한다. 이 효과들은 다양한 매서드로 행해지며, 컨텐츠를 보여주고 숨기고, 페이드 인/아웃, 슬라이드 업/다운 등을 위한 이벤트 매서드를 포함한다. 이들 모두가 사용될 매서드가 준비되어 있으며 최적으로 보이도록 커스터마이징될 수 있다.

각 이펙트 매서드는 자신만의 구문을 가지고 있어서, 각 매서드의 특정 구문은 jQuery [효과 문서][17]를 참조하는 것이 가장 좋다. 그렇지만, 일반적으로 효과는 지속기간(duraton), 이징(easing 역자주: 움직일 때의 애니메이션 [효과][18]), 콜백함수(역자주 : 애니메이션이 끝난 후 실행되는 함수) 지정 등을 허용한다.

> #### jQuery CSS Animations
>
> CSS 자체가 최근 애니메이션을 다루는 것과는 관계가 좀 떨어지지만, 다양한 CSS 속성의 맞춤형 애니메이션이 jQuery에서 수행될 수 있다. CSS 애니메이션은 브라우저 처리 관점에서 더 나은 성능을 제공하며, 가능한 곳에선 더 선호된다. jQuery 애니메이션 효과는 - Modernizr의 도움을 받아 - CSS 애니메이션을 지원하는 브라우저에 완벽한 백업 솔루션을 만들어준다.

### Effect Duration

예로서 `.show()` 매서드를 사용하면, (선택적으로) 대입할 수 있는 첫 패러미터는 지속시간이며, 키워드와 밀리초 값을 사용해 수행될 수 있다. `slow` 키워드는 `600` 밀리초를, `fast` 키워드는 `200` 밀리초를 기본으로 한다. 키워드 값을 사용하는 건 완벽하지만, 밀리초 값을 직접 대입할 수도 있다. 키워드 값은 인용부호로 감싸지만, 밀리초 값은 그러지 않는다.

```js
$('.error').show();
$('.error').show('slow');
$('.error').show(500);
```

### Effect Easing

지속시간을 설정함과 더불어, 애니메이션 안에서 다양한 시간 동안 애니메이션이 처리되는 이징(easing) 혹은 속도 등도 설정될 수 있다. 기본적으로 jQuery는 두 개의 이징 키워드 값이 있다. 기본값은 `swing`이고 추가적인 값은 `linear`이다. 기본 `swing` 값은 느린 속도로 애니메이션을 시작하여 애니메이션 되는 중에 속도를 내지만, 끝나기 전에는 속도를 늦춘다. `linear` 값은 처움부터 끝까지 하나의 일정한 속도로 애니메이션이 진행된다.

```js
$('.error').show('slow', 'linear');
$('.error').show(500, 'linear');
```

> #### jQuery UI
>
> jQuery에서 제공되는 두 개의 이징 값은 추가적인 값을 제공할 수 있는 다양한 플러그인을 사용하여 확장될 수 있다. 가장 인기있는 플러그인 중 하나는 [jQuery UI][19] 이다.
>
> 새 이징 값에 더해 jQuery UI는 살펴볼만한 소수의 다른 상호작용, 효과, 위젯과 도움되는 리소스를 제공한다.

### Effect Callback

애니메이션이 끝나면 콜백 함수라 불리는 또 다른 함수를 실행할 수 있다. 콜백 함수는, 존재한다면, 지속시간(duration)이나 이징(easing) 뒤에 배치해야 한다. 이 함수에서 새로운 이벤트나 효과가 배치될 수 있으며, 각각 자신의 필요한 구문을 따른다.

```js
$('.error').show('slow', 'linear', function(event){
  $('.error .status').text('Continue');
});
```

### Effect Syntax

전에 언급되었듯이 각 효과 매서드는 jQuery [효과 문서][17]에서 찾을 수 있는 자신의 구문을 가진다. 여기서 약술한 지속시간, 이징, 콜백 매개변수는 일반적인 것이고 모든 매서드에서 쓸 수 있는 것은 아니다. 관련해서 의문 사항이 생기면 매서드의 구문을 재검토하는 것이 가장 좋다.

### Effects Demo

위에서와 같은 이벤트 데모를 취하면, 여기서 `.remove()` 매서드는 `.fadeOut()` 매서드에서 콜백 함수의 부분으로 사용된다. `.fadeOut()` 매서드를 사용하면 경고 메시지가 재빨리 사라지기 보단 점차로 페이드 아웃되게 하며, 애니메이션이 완료된 후 DOM에서 제거된다.

###### HTML

```html
<div class="alert-warning">
  <strong>Warning!</strong> I’m about to lose my cool.
  <div class="alert-close">×</div>
</div>
```

###### JavaScript

```js
$('.alert-close').on('click', function(event){
  $('.alert-warning').fadeOut('slow', function(event){
    $(this).remove();
  });
});
```

**[Demo][20]**

#### Basic Effects

  * `.hide()`
  * `.show()`
  * `.toggle()`

#### Custom Effects

  * `.animate()`
  * `.clearQueue()`
  * `.delay()`
  * `.dequeue()`
  * `jQuery.fx.interval`
  * `jQuery.fx.off`
  * `.queue()`
  * `.stop()`

#### Fading Effects

  * `.fadeIn()`
  * `.fadeOut()`
  * `.fadeTo()`
  * `.fadeToggle()`

#### Sliding Effects

  * `.slideDown()`
  * `.slideToggle()`
  * `.slideUp()`

### Slide Demo

###### HTML

```html
<div class="panel">
  <div class="panel-stage"></div>
  <a href="#" class="panel-tab">Open <span>▼</span></a>
</div>
```

###### JavaScript

```js
$('.panel-tab').on('click', function(event){
  event.preventDefault();
  $('.panel-stage').slideToggle('slow', function(event){
    if($(this).is(':visible')){
      $('.panel-tab').html('Close ▲');
    } else {
      $('.panel-tab').html('Open ▼');
    }
  });
});
```

**[Demo][21]**

### Tabs Demo

###### HTML

```html
<ul class="tabs-nav">
  <li><a href="#tab-1">Features</a></li>
  <li><a href="#tab-2">Details</a></li>
</ul>
<div class="tabs-stage">
  <div id="tab-1">...</div>
  <div id="tab-2">...</div>
</div>
```

###### JavaScript

```js
// Show the first tab by default
$('.tabs-stage div').hide();
$('.tabs-stage div:first').show();
$('.tabs-nav li:first').addClass('tab-active');
// Change tab class and display content
$('.tabs-nav a').on('click', function(event){
  event.preventDefault();
  $('.tabs-nav li').removeClass('tab-active');
  $(this).parent().addClass('tab-active');
  $('.tabs-stage div').hide();
  $($(this).attr('href')).show();
});
```

**[Demo][22]**

## Resources & Links

* [JavaScript For Cats](http://jsforcats.com/)
* [A Re-introduction to JavaScript](https://developer.mozilla.org/en-US/docs/JavaScript/A_re-introduction_to_JavaScript) via Mozilla Developer Network
* [30 Days to Learn jQuery](https://tutsplus.com/course/30-days-to-learn-jquery/) via Tuts+ Premium
* [Google Hosted Libraries](https://developers.google.com/speed/libraries/devguide)
* [jQuery Documentation](http://docs.jquery.com/)
* [jQuery Fundamentals](http://jqfundamentals.com/) via Bocoup
* [jQuery UI](http://jqueryui.com/)


### 역자참조링크

* [jQuery API 한글 번역](http://www.jquerykorea.pe.kr/xe/?mid=document&CT=All)
* [한글 jQuery 시리즈 강좌 리스트 : PDF와 동영상 링크](http://direct.co.kr/cs/jQuery.pdf)

   [1]: http://learn.shayhowe.com/advanced-html-css/jquery
   [2]: http://trends.builtwith.com/docinfo/Javascript
   [3]: http://trends.builtwith.com/javascript/jQuery
   [4]: http://jsforcats.com/
   [5]: https://developer.mozilla.org/en-US/docs/JavaScript/A_re-introduction_to_JavaScript
   [6]: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Values,_variables,_and_literals#Variables
   [7]: http://en.wikipedia.org/wiki/CamelCase
   [8]: http://learn.shayhowe.com/assets/courses/advanced-html-css-guide/jquery/console.png
   [9]: https://tutsplus.com/course/30-days-to-learn-jquery/
   [10]: https://developers.google.com/speed/libraries/devguide
   [11]: http://api.jquery.com/category/selectors/
   [12]: http://api.jquery.com/category/selectors/jquery-selector-extensions/
   [13]: http://api.jquery.com/category/traversing/
   [14]: http://api.jquery.com/category/manipulation
   [15]: http://api.jquery.com/category/events/
   [16]: http://j.mp/19Lrgr1
   [17]: http://api.jquery.com/category/effects/
   [18]: http://gsgd.co.uk/sandbox/jquery/easing/
   [19]: http://jqueryui.com/
   [20]: http://j.mp/ZExZyB
   [21]: http://j.mp/11Cl156
   [22]: http://j.mp/1052YX1
  