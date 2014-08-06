---
layout: post
title: "객체에 대한 이해"
description: "프론트엔드 개발자를 위한 자바스크립트 프로그래밍 6.1장 객체에 대한 이해 요약"
category: blog
tags: [javascript, jquery, beginner, guide, study, studyjs, facebook, group]
---

<div id="toc"><p class="toc_title">목차</p></div>

이 포스팅은 "프론트엔드 개발자를 위한 자바스크립트(2013 인사이트, 한선용 옮김)"에서 발췌 요약한 것이며, 인사이트와 저작권에 대한 부분을 의논하여 사전 허락을 받은 것입니다. 자세한 내용은 페이스북 [자바스크립트 제대로 하기 스터디 그룹](https://www.facebook.com/groups/learnjsproperly/)의 [해당 포스트](https://www.facebook.com/groups/learnjsproperly/permalink/364077967076150/?stream_ref=2)를 참조하시기 바랍니다.

## 6장. 객체 지향 프로그래밍

객체지향 언어는 일반적으로 클래스를 통해 같은 프로퍼티와 메서드를 가지는 객체를 여러 개 만든다는 특징이 있지만, ECMAScript에는 클래스라는 개념이 없다.

ECMA-262의 객체 정의는 "프로퍼티의 순서 없는 컬렉션이며 각 프로퍼티는 원시값이나 객체, 함수를 포함한다"이며, *특별한 순서가 없는 값의 배열*이란 의미이다. ECMAScript 객체는 해시 테이블이며, 이름-값 쌍의 그룹이며 각 값은 데이터나 함수가 될 수 있다.

모든 객체는 참조 타입을 바탕으로 생성된다.

### 6.1 객체에 대한 이해

객체를 만드는 가장 단순한 방법은 Object의 인스턴스를 만들고 프로퍼티와 메서드를 추가하는 것이다.

```javascript
var person = new Object();
person.name = "Nicholas";
person.age = 29;
person.job = "Software Engineer";

person.sayName = function() {
    alert(this.name);
};
```

초기에는 위의 패턴을 자주 사용했으나 몇 년이 지나면서 객체 리터럴 패턴을 더 많이 쓴다:

```javascript
var person = {
    name: "Nicholas",
    age: 29,
    job: "Software Engineer",

    sayName: function() {
        alert(this.name);
    }
};
```

#### 프로퍼티 타입

ECMA-262 5판에서는 프로퍼티의 특징을 내부적으로만 유효한 속성에 따라 설명하며, 속성이 자바스크립트 엔진 내부에서 구현하므로 자바스크립트에서 직접적으로 접근할 수 없다. [[]]로 감싸서 내부 속성임을 나타낸다.

##### 데이터 프로퍼티

* [[Configurable]] - 삭제/변경/변환. 기본값은 true.
* [[Enumerable]] - for-in 루프에서 반환. 기본값은 true.
* [[Writable]] - 값 변경. 기본값은 true.
* [[Value]] - 실제 데이터 값. 기본값은 undefined

Object.defineProperty() 메서드를 써서 속성 값을 바꿀 수 있다. Object.defineProperty()를 여러 번 호출할 수 있지만, *일단 Configurable을 false로 지정하면 제한이 생긴다.* 프로퍼티 값을 따로 명시하지 않는다면 기본 값은 false이다.

##### 접근자 프로퍼티

* [[Configurable]]
* [[Enumerable]]
* [[Get]] - 프로퍼티를 읽을 때 호출할 함수. 기본 값은 undefined.
* [[Set]] - 프로퍼티를 바꿀 때 호출할 함수. 기본 값은 undefined.

접근자 포로퍼티는 일반적으로 프로퍼티의 값을 바꿨을 때 해당 프로퍼티만 바뀌는 게 아니라 부수적인 절차가 필요한 경우에 사용한다.

getter 함수만 지정하면 해당 프로퍼티는 읽기 전용이 되고, 수정 시도는 모두 무시되거나 스트릭트 모드에선 에러가 발생한다. setter만 지정된 프로퍼티는 읽으려 하면 undefined를 반환하며 스트릭트 모드에선 에러가 발생한다.

#### 다중 프로퍼티 정의

#### 프로퍼티 속성 읽기

Object.getOwnPropertyDescriptor() 메서드로 프로퍼티의 서술자 프로퍼티를 읽을 수 있다.

## 관련 글들

* [변수와 스코프, 메모리](http://nolboo.github.io/blog/2014/04/01/javascript-for-web-developer-4/)
* [자바스크립트 제대로 배우기](http://nolboo.github.io/blog/2014/03/13/how-to-learn-javascript-properly/)
* [자바스크립트 제대로 배우기 스터디 그룹](http://nolboo.github.io/blog/2014/03/18/how-to-learn-javascript-properly-study/)