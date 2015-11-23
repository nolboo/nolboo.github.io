---
layout: post
title: "훌륭한 자바스크립트 개발자 되는 법"
description: "훌륭한 자바스크립트 개발자가 무엇인지부터 정의해야겠지만 추천되는 책, 라이브러리, 웹 리소스를 참고하기 위해 발췌번역"
category: blog
tags: [javascript, learning, resource]
---

<div id="toc"><p class="toc_title">목차</p></div>

원문 : [How to Become a Great JavaScript Developer](http://blog.ustunozgur.com/javascript/programming/books/videos/2015/06/17/how_to_be_a_great_javascript_software_developer.html)

몇가지 참고할 것이 있어서 메모하다보니 조금 길어져서 포스팅합니다. 전체 내용은 아니니 흥미가 가시는 분은 원문을 보시길 바랍니다.

## Read Books

웹기술의 전문가가 되려면 책을 읽어라. 웹은 혼란스러운 미디어다.

자바스크립트 바이블인 [JavaScript: The Good Parts](http://shop.oreilly.com/product/9780596517748.do)를 읽기 시작해라. [JavaScript: The Definitive Guide](http://shop.oreilly.com/product/9780596805531.do)도 필수이고 참고서로 가지고 있어야 할 것이다. JQuery 만든 존 레식의 [Secrets of the JavaScript Ninja](http://www.manning.com/resig/)도 뛰어나다. 온라인에서 무료 공개되는 좋은 책을 찾는다면 [JavaScript Allongé](https://leanpub.com/javascript-allonge/), [You Dont Know JS](https://github.com/getify/You-Dont-Know-JS), [Eloquent JavaScript](http://eloquentjavascript.net/)를 봐라. 책은 아니지만 모질라 재단의 [JavaScript Guide](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide)도 좋다.

## Learn, Use and Read Libraries

책이 언어를 읽는 법을 가르쳐 준다면 라이브러리는 말하는 법을 가르쳐준다. 라이브러리와 함께 할 수 있는 두 가지 중요한 것은 라이브러리를 사용하는 것과 그 소스코드를 읽는 것이다.

라이브러리를 사용하려면 jQuery, Backbone, underscore 그리고 React, Angular, Ember 중 하나와 숙지해라. 이 라이브러리들을 사용해야 한다는 것이 아니라 괜츈한 자바스크립트 개발자는 적어도 이것들을 어느 정도 경험하고 있다.

두번째 중요한 소스코드 읽기는 아름답게 쓰여진 Backbone과 underscore을 추천한다. underscore를 읽고 이해하는 것은 functional programming 스킬을 향상시킬 것이다. 난 경험이 없지만 여러 개발자가 추천하는 것 중에서는 mootols이다.

React, Ember와 같은 것을 이해하는 것은 더 어렵지만 노력할 가치가 있다. 훑어봐서 코드 베이스 구조와 패턴을 알아볼 필요가 있다. 다른 사용하고 읽어볼 유명한 라이브러리는 d3, highcharts, moment.js 등이 있다.

## Do Exercises and Ask Questions to Yourself

좋은 자바스크립트 개발자가 되는 다음 단계는 많은 연습을 하는 것이다. 이상적으로 이 연습들은 DOM이 아닌 언어에 초첨을 맞추는 것이다. 작게 하고, node.js에서 충분한 연습을 하라. Do katas and go through different ways of using JavaScript: closures, prototypes, array-extras (map, filter) etc. 연습하면서 항상 자바스크립의 기초 아이디어의 목록을 염두에 둬야 한다.

내 친구 책도 괜찮다. [Pro JavaScript Design Patterns - Apress IT eBooks](http://www.apress.com/9781590599082)

다음과 같은 질문에 답해보라: How does prototypal inheritance work? What defines a closure? How does the meaning of this keyword change? How does one use apply/bind/map/filter/call?

“What if?” 시나리오를 시도해보라. 예를 들면 “What is the meaning of “this” if I use bind twice? How does jQuery make sure that the this keyword refers to the jQuery object and not the global object? How does this library achieve a certain feature?”

## Learn the standards

다음 단계는 EcmaScript 표준에 대해 더 파고드는 것이다. 동시에 자바스크립트의 곧 나올 기능에 대해서도 공부해봐라. 요즘엔 promises, modules, generators, comprehensions와 같은 새로운 기능이 밀려들고 있다. [Understanding ECMAScript 6](https://leanpub.com/understandinges6), [Exploring ES6](http://exploringjs.com/)이 도움될 것이다.

## Use Resources on the Web

처음에 웹을 사용하는 위험에 대해 말했지만 마지막 추천은 웹에서 베스트 리소스를 얻는 법이다. 해커뉴스는 좋은 소스지만 계속 쫓아가기엔 시간이 많이 들고, 노이즈 비율도 높다. 대신 JavaScript Weekly와 같은 주간 뉴스 다이제스트를 겨냥해라. 영향력있는 자바스크립트 개발자의 트위터 계정을 팔로해라. Tuts+의 [팔로할만한 33 자바스크립트 개발자](http://code.tutsplus.com/articles/33-developers-you-must-subscribe-to-as-a-javascript-junkie--net-18151)가 좋은 시작점이 될 것이다. 다른 웹 리소스는 [Toptal](http://www.toptal.com/section/front-end), [Adventures in JavaScript Development](http://rmurphey.com/), [A Baseline for Front-End [JS] Developers: 2015](http://rmurphey.com/blog/2015/03/23/a-baseline-for-front-end-developers-2015/), [NCZOnline](http://www.nczonline.net/) 등이다.

또 다른 중요한 웹 리소스는 컨퍼런스 동영상과 교육 동영상이다. 컨퍼런스는 JSConf 시리즈가 고퀄이다. 교육 동영상은 Pluralsight를 강력히 추천한다.(그 사이트와 관련없다.)

이 글에 대한 토론은 [How to Become a Great JavaScript Developer | Hacker News](https://news.ycombinator.com/item?id=9731230)에서 볼 수 있다.

## 추가 링크

- [훌륭한 JavaScript 개발자가 되는 법](https://item4.github.io/2015-10-12/How-to-Become-a-Great-JavaScript-Developer.html) : 저는 요약 번역을 했는데 풀 번역을 하신 분들이 생겼네요.
