---
layout: post
title: "자바스크립트 객체 상세"
description: "JavaScript is Sexy: JavaScript Objects in Detail 번역"
category: blog
tags: [javascript, jquery, beginner, guide, study, studyjs, facebook, group]
---

<div id="toc"><p class="toc_title">목차</p></div>

페이스북 [자바스크립트 제대로 하기 스터디 그룹](https://www.facebook.com/groups/learnjsproperly/)에서 기본 가이드인 [자바스크립트 제대로 배우기](http://nolboo.github.io/blog/2014/03/13/how-to-learn-javascript-properly/) 중 자바스크립트 객체에 대한 [JavaScript is Sexy: JavaScript Objects in Detail](http://javascriptissexy.com/javascript-objects-in-detail/)를 번역하였습니다.

## 자바스크립트 객체 상세

원본: [JavaScript Objects in Detail](http://javascriptissexy.com/javascript-objects-in-detail/)

자바스크립트의 - 가장 자주 사용되고 가장 기본적인 - 핵심 데이터 타입은 객체 데이터 타입이다. 자바스크립트는 한 개의 복잡한 데이터 타입인 객체 데이터 타입이 있으며, 5개의 단순한 데이터 타입이 있다: 숫자, 문자열, 불린, undefined, null. 단순한 (원시적인) 데이터 타입은 불변 즉, 변경할 수 없으나, 객체는 변경할 수 있다.

### 객체란 무엇인가

객체는 이름-값 쌍으로 저장되는 원시 데이터(때때로 참조 데이터 타입)의 순서 없는 목록이다. 목록의 각 항목은 프로퍼티라고 불리며(함수는 메서드로 불린다), 각 프로퍼티의 이름은 유일해야 하고, 하나의 문자열 또는 숫자가 될 수 있다.

간단한 객체:

```javascript
var myFirstObject = {firstName: "Richard", favoriteAuthor: "Conrad"};
```

반복하면: 객체를 이름-값 쌍으로 저장된 목록 안에 항목과 프로퍼티를 포함하는 목록으로 생각하라. 위의 예제의 프로퍼티 이름은 firstName과 favoriteAuthor이다. 각각의 값은 "Richard"와 "Conrad"이다.

프로퍼티 이름은 문자열이나 숫자가 될 수 있으나, 프로퍼티 이름이 하나의 숫자라면 대괄호 표기법으로 접근되어야 한다. 대괄호 표기법은 나중에 더 자세히. 프로퍼티 이름이 숫자로 된 객체의 예제:

```javascript
var ageGroup = {30: "Children", 100:"Very Old"};
console.log(ageGroup.30) // 에러가 발생한다.
// "Children" 값을 얻기 위해서는 프로퍼티 30의 값은 다음과 같이 접근해야 한다.
console.log(ageGroup["30"]); // Children

//프로퍼티 이름에 숫자를 사용하길 피하는 것이 가장 좋다.
```

자바스크립트 개발자로서 여러분은 주로 데이터를 저장하고 여러분 자신의 커스텀 메서드와 함수를 만들기 위해, 매우 자주 객체 데이터 타입을 사용할 것이다.

### 참조 데이터 타입과 원시 데이터 타입

참조 데이터 타입과 원시 데이터 타입의 주요 차이점 중 하나는 참조 데이터 타입의 값은 변수에 직접 저장되지 않고, 참조로 저장되며, 원시 데이터 타입은 값으로 저장된다는 것이다.
예로:

```javascript
    // 원시 데이터 타입 문자열은 값으로 저장된다.
    var person = "Kobe";
    var anotherPerson = person; // anotherPerson = person의 값
    person = "Bryant"; // person의 값이 바뀌었다.

    console.log(anotherPerson); // Kobe
    console.log(person); // Bryant
```

"Bryant"로 _person_을 변경했을지라도, _anotherPerson_ 변수는 person이 가졌던 값을 그대로 유지하는 것을 주목할 필요가 있다.

위에서 예시한 값으로 저장되는 원시 데이터와 참조로 저장되는 객체를 비교하라:

```javascript
    var person = {name: "Kobe"};
    var anotherPerson = person;
    person.name = "Bryant";

    console.log(anotherPerson.name); // Bryant
    console.log(person.name); // Bryant
```

이 예제에선, _person_ 객체를 _anotherPerson_으로 복사하였다. 그러나 person의 값이 실제 값이 아닌 참조로 저장되었기 때문에 person.name 프로퍼티를 "Bryant"로 변경하면 anotherPerson이 변경된다. person 프로퍼티 값의 실제 사본을 저장하지 않고 참조만 하기 때문이다.

### 객체 데이터 프로퍼티는 속성(attribute)이 있다

각 데이터 프로퍼티(데이터를 저장하는 객체 프로퍼티)는 이름-값 쌍과 (기본값이 true인) 세 가지 속성이 있다:

-  **Configurable Attribute:** 프로퍼티가 삭제되거나 변경될 수 있는지를 지정한다.
- **Enumerable:** 프로퍼티가 for/in 루프에서 반환될 수 있는지를 지정한다.
- **Writable:** 프로퍼티가 변경될 수 있는지를 지정한다.

ECMAScript 5는 위의 데이터 프로퍼티와 함께 접근자 프로퍼티를 명시하고 있음을 주목하라. 접근자 프로퍼티는 함수(getter와 setter)이다. 2월 15일에 이미 예정된 포스트에서 ECMAScript 5를 더 배울 것이다.

### 객체 만들기

객체를 만드는 두 가지 일반적인 방법이 있다:

#### 1. 객체 리터럴

객체를 만드는 가장 일반적이고 가장 쉬운 방법은 객체 리터럴로 만드는 것이다:

```javascript
// 객체 리터럴을 사용해서 빈 객체를 초기화시킨다.
var myBooks = {};

// 객체 리터럴을 사용해서 4개의 항목을 가진 객체
var mango = {
color: "yellow",
shape: "round",
sweetness: 8,

howSweetAmI: function () {
console.log("Hmm Hmm Good");
}
}
```

#### 2. 객체 생성자(constructor)

두 번째 가장 일반적인 방법은 객체 생성자로 만드는 것이다. 생성자는 새 객체를 초기화하는 함수이며, 생성자를 호출하기 위해 새 키워드를 사용한다.

```javascript
var mango =  new Object ();
mango.color = "yellow";
mango.shape= "round";
mango.sweetness = 8;

mango.howSweetAmI = function () {
console.log("Hmm Hmm Good");
}
```

객체의 프로퍼티 이름으로 "for"와 같은 몇몇 예약어를 사용할 수 있지만, 피하는 것이 현명하다.

객체는 숫자, 배열과 심지어 다른 객체를 포함하는 모든 데이터 타입을 수용할 수 있다.

#### 객체를 만드는 실용적인 패턴

데이터를 저장하기 위해 여러분의 앱에서 한 번만 사용될 수도 있는 간단한 객체를 위해서, 위의 두 가지 방법으로 객체를 만드는데 충분하다.

과일과 각 과일에 대한 상세를 보여주는 앱을 상상해보라. 모든 과일은 다음과 같은 프로퍼티를 가진다: color, shape, sweetness, cost와 showName 함수. 새로운 과일 객체를 만들려고 할 때마다 다음 코드를 적는 것은 매우 지루하고 비생산적이다.

```javascript
var mangoFruit = {
color: "yellow",
sweetness: 8,
fruitName: "Mango",
nativeToLand: ["South America", "Central America"],

showName: function () {
console.log("This is " + this.fruitName);
},
nativeTo: function () {
 this.nativeToLand.forEach(function (eachCountry)  {
            console.log("Grown in:" + eachCountry);
        });
}
}
```

10개의 과일이 있다면, **같은** 코드를 10번 추가해야 할 것이다. nativeTo 함수를 변경해야 한다면? 10개의 다른 장소에서 변경해야 한다. Now extrapolate this to adding objects for members on a website and suddenly you realized the manner in which we have created objects so far is not ideal objects that will have instances, particularly when developing large applications.

이런 반복적인 문제를 해결하기 위해, 소프트웨어 엔지니어들은 앱을 더 효율적이고 능률적으로 개발하기 위해 패턴(반복적이고 일상적인 작업을 위한 해법)을 발명했다.

객체를 만들기 위한 두 가지 일반적인 패턴이 있다. 여러분이 자바스크립트 제대로 배우기 과정을 하고 있다면 코드 아카데미의 레슨에서 첫 번째 패턴이 자주 사용되는 것을 본 적이 있을 것이다:

#### 1. 객체 만들기 생성자 패턴

```javascript
function Fruit (theColor, theSweetness, theFruitName, theNativeToLand) {

    this.color = theColor;
    this.sweetness = theSweetness;
    this.fruitName = theFruitName;
    this.nativeToLand = theNativeToLand;

    this.showName = function () {
        console.log("This is a " + this.fruitName);
    }

    this.nativeTo = function () {
    this.nativeToLand.forEach(function (eachCountry)  {
       console.log("Grown in:" + eachCountry);
        });
    }


}
```

이 패턴을 적절히 사용하여, 모든 종류의 과일을 만드는 것은 매우 쉽다.
이를테면:

```javascript
var mangoFruit = new Fruit ("Yellow", 8, "Mango", ["South America", "Central America", "West Africa"]);
mangoFruit.showName(); // Mango
mangoFruit.nativeTo();
// Grown in:South America
// Grown in:Central America
// Grown in:West Africa

var pineappleFruit = new Fruit ("Brown", 5, "Pineapple", ["United States"]);
pineappleFruit.showName(); // Pineapple
```

fruitName 함수를 변경해야 한다면, 한 곳에서만 하면 된다. 패턴은 한 개의 과일 함수와 상속을 이용해서 모든 과일의 모든 기능성과 특징을 캡슐화한다.

주의사항:

- 상속 프로퍼티는 객체의 프로토타입 프로퍼티에 정의된다. 예로: 
```javascript
someObject.prototype.firstName = "rich";
```

- 자신의 프로퍼티는 객체 그 자체에 직접 정의된다, 예로:
```javascript
// 먼저 객체를 만든다:
var aMango = new Fruit ();
// 이제 aMango 객체에 직접 mangoSpice 프로퍼티를 정의한다.
// aMango 객체에 직접 mangoSpice 프로퍼티를 정의했기 때문에 상속된 프로퍼티가 아닌 aMango 자신의 프로퍼티이다.
aMango.mangoSpice = "some value";
```

- 객체의 프로퍼티에 접근하기 위해서, object.property를 사용한다. 예로:
```javascript
console.log(aMango.mangoSpice); // "some value"
```

- 객체의 매서드를 적용하려면(invoke), object.method()를 사용한다. 예로:
```javascript
// 먼저 메서드를 추가한다.
aMango.printStuff = function () {return "Printing";}

// 이제 printStuff 메서드를 적용할 수 있다:
aMango.printStuff ();
```

#### 2. 객체 만들기 프로토타입 패턴

```javascript
function Fruit () {

}

Fruit.prototype.color = "Yellow";
Fruit.prototype.sweetness = 7;
Fruit.prototype.fruitName = "Generic Fruit";
Fruit.prototype.nativeToLand = "USA";

Fruit.prototype.showName = function () {
console.log("This is a " + this.fruitName);
}

Fruit.prototype.nativeTo = function () {
            console.log("Grown in:" + this.nativeToLand);
}
```

그리고 아래는 이 프로토타입 패턴에 Fruit () 생성자를 호출하는 방법이다:

```javascript
var mangoFruit = new Fruit ();
mangoFruit.showName(); //
mangoFruit.nativeTo();
// This is a Generic Fruit
// Grown in:USA
```

#### 추가 읽기

이 두 가지 패턴의 완전한 논의와 각각의 동작법과 단점에 대한 철저한 설명을 위해, _Professional JavaScript for Web Developers_의 6장을 읽어라. 여러분은 자카스가 어떤 것을 최고로 추천하는지 배울 수 있을 것이다.(힌트: 위의 두 가지 다 아니다.)

### 객체 프로퍼티 접근하는 법

객체의 프로퍼티에 접근하는 두 가지 주요 방법은 점 표기법과 대괄호 표기법이다.

#### 1. 점 표기법

```javascript
// 지금까지의 예제에서 점 표기법을 사용해왔다. 여기 또 하나의 예제가 있다:
var book = {title: "Ways to Go", pages: 280, bookMark1:"Page 20"};

// 점 표기법을 사용해서 book 객체의 프로퍼티에 접근하려면, 이렇게 한다:
console.log (book.title); // Ways to Go
console.log (book.pages); // 280
```

#### 2. 대괄호 표기법

```javascript
// 대괄호 표기법으로 book 객체의 프로퍼티에 접근하려면, 이렇게 한다:
console.log (book["title"]); //Ways to Go
console.log (book["pages"]); // 280

//혹은, 변수로 프로퍼티 이름을 가질 수도 있다:
var bookTitle = "title";
console.log (book[bookTitle]); // Ways to Go
console.log (book["bookMark" + 1]); // Page 20 
```

존재하지 않는 객체의 프로퍼티에 접근하면 _undefined_ 결과가 나올 것이다.

#### 고유와 상속 프로퍼티

객체는 상속 프로퍼티와 고유 프로퍼티를 가진다. 고유 프로퍼티는 객체에 정의되는 프로퍼티이고, 상속 프로퍼티는 프로토타입 객체로부터 상속된다.

객체에 프로퍼티(상속이던 고유이던)가 존재하는지를 알아내려면 연산자를 사용한다:

```javascript
// schoolName이란 프로퍼티를 가진 새로운 school 객체를 만든다.
var school = {schoolName:"MIT"};

// schoolName은 school 객체의 고유 프로퍼티이므로 true를 출력한다.
console.log("schoolName" in school);  // true

// school 객체에 schoolType 프로퍼티가 정의되지 않았고, Object.prototype 프로토타입 객체로부터 schoolType 프로퍼티를 상속하지 않았기 때문에 false를 출력한다.
console.log("schoolType" in school);  // false

// school 객체가 Object.prototype으로부터 toString 메서드를 상속받았기 때문에 true를 출력한다.
console.log("toString" in school);  // true
```

#### hasOwnProperty

객체가 특정 프로퍼티를 고유 프로퍼티 중 하나로 가졌는지 알아내려면 hasOwnProperty 메서드를 사용한다. 이 메서드는 객체를 하나하나 열거하거나 상속이 아닌 고유 프로퍼티만을 원할 때 매우 유용하다.

```javascript
// schoolName 프로퍼티를 갖는 새로운 school 객체를 만든다.
var school = {schoolName:"MIT"};

// schoolName이 school 객체의 고유 프로퍼티이므로 true를 출력한다.
console.log(school.hasOwnProperty ("schoolName"));  // true

// school 객체가 toString 메서드는 Object.prototype으로 상속되었으며, toString이 school 객체의 고유 프로퍼티가 아니므로 false를 출력한다.
console.log(school.hasOwnProperty ("toString"));  // false
```

#### 객체 프로퍼티 접근하고 열거하기
열거할 수 있는 (고유와 상속) 프로퍼티를 접근하기 위해서는 for/in 루프나 일반 for 루프를 사용한다.

```javascript
// schoolName, schoolAccredited, schoolLocation의 세 가지 고유 프로퍼티를 갖는 새로운 school 객체를 만든다.
var school = {schoolName:"MIT", schoolAccredited: true, schoolLocation:"Massachusetts"};

//school 객체의 프로퍼티를 접근하기 위해 for/in 루프를 사용하라.
for (var eachItem in school) {
console.log(eachItem); // schoolName, schoolAccredited, schoolLocation를 출력한다.

}
```

#### 상속 프로퍼티 접근하기

Object.prototype에서 상속된 프로퍼티는 열거할 수 없으며, for/in 루프가 그것들을 보여주지 않는다. 그러나 열거할 수 있는 상속 프로퍼티는 for/in 루프 반복으로 보인다.
예로:

```javascript
// school 객체의 프로퍼티를 접근하기 위해서 for/in 루프를 사용하라.
for (var eachItem in school) {
console.log(eachItem); // schoolName, schoolAccredited, schoolLocation를 출력한다.

}

// school 객체가 상속할 새로운 HigherLearning 함수를 만든다.
/* 사이드 노트: 날카로운 독자인 윌슨이 밑의 댓글에 정확하게 지적하였듯이, educationLevel 프로퍼티는 HigherLearning 생성자를 사용한 객체에 실제로 상속되지 않았다; 대신, educationLevel 프로퍼티는 HigherLearning 생성자를 사용한 각 객체에 새로운 프로퍼티로서 만들어졌다. 프로퍼티가 상속되지 않은 이유는 프로퍼티를 정의하기 위해 "this" 키워드를 사용하기 때문이다.
*/


function HigherLearning () {
this.educationLevel = "University";
}

// HigherLearning 생성자로 상속한다.
var school = new HigherLearning ();
school.schoolName = "MIT";
school.schoolAccredited = true;
school.schoolLocation = "Massachusetts";


// school 객체의 프로퍼티를 접근하기 위해 for/in 루프를 사용하라.
for (var eachItem in school) {
console.log(eachItem); // educationLevel, schoolName, schoolAccredited, schoolLocation를 출력한다.
}
```

마지막 예제에서, HigherLearning 함수로 정의된 educationLevel 프로퍼티가 school의 프로퍼티 중 하나로 열거된 것을 주목하라. educationLevel은 고유 프로퍼티가 아니며, 상속되었다.

### 객체의 프로토타입 속성과 프로토타입 프로퍼티

객체의 프로토타입 속성과 프로토타입 프로퍼티는 자바스크립트를 이해하기 위해 결정적으로 중요한 개념이다. 추가로 내 포스트 [JavaScript Prototype in Plain, Detailed Language](http://javascriptissexy.com/javascript-prototype-in-plain-detailed-language/)를 읽어라.

#### 객체의 프로퍼티 삭제하기

객체로부터 프로퍼티를 삭제하려면, delete 연산자를 사용한다. 상속된 프로퍼티는 지울 수 없으며, configurable 속성으로 설정된 프로퍼티도 지울 수 없다. (프로퍼티가 정의되었던 곳인) 프로토타입 객체에서 상속된 프로퍼티를 지워야 한다. 또한, (var 키워드로 선언되었던) 전역 객체의 프로퍼티는 지울 수 없다.

delete 연산자는 삭제가 성공적이면 true를 반환한다. 그리고 놀랍게도 삭제할 프로퍼티가 존재하지 않거나 프로퍼티가 지워질 수 없어도(non-configurable이나 객체에 의해 소유되지 않은 등) 역시 true를 반환한다.

이러한 예를 설명하면:

```javascript
var christmasList = {mike:"Book", jason:"sweater" }
delete christmasList.mike; // mike 프로퍼티를 지운다.

for (var people in christmasList) {
    console.log(people);
}
// jason만 출력한다.
// mike 프로퍼티는 지워졌다.

delete christmasList.toString; // true를 반환한다, 그러나 toString은 상속된 메서드이기 때문에 지워지지 않는다.

// 여기서 toString 메서드를 호출하면 잘 동작한다-지워지지 않았다.
christmasList.toString(); //"[object Object]"

// 프로퍼티가 그 인스턴스의 고유 프로퍼티라면 인스턴스의 프로퍼티를 지울 수 있다. 예로, educationLevel 프로퍼티는 인스턴스에 정의되었기 때문에 school 객체에서 educationLevel 프로퍼티를 지울 수 있다: HigherLearning 함수를 선언할 때 프로퍼티를 정의하기 위해 "this" 키워드를 사용하였다. HigherLearning 함수의 프로토타입에서 educationLevel 프로퍼티를 정의하지 않았다.

console.log(school.hasOwnProperty("educationLevel")); true
// educationLevel은 school에서 고유 프로퍼티이며, 지울 수 있다.
delete school.educationLevel; true

// educationLevel 프로퍼티는 school 인스턴스로부터 지워졌다.
console.log(school.educationLevel); undefined

// 그러나 HigherLearning 함수에 educationLevel 프로퍼티는 아직 존재한다.
var newSchool = new HigherLearning ();
console.log(newSchool.educationLevel); // University

// 다음의 educationLevel2 프로퍼티처럼 HigherLearning 함수의 프로토타입으로 정의했다면:
HigherLearning.prototype.educationLevel2 = "University 2";

// HigherLearning 인스턴스의 educationLevel2 프로퍼티는 고유 프로퍼티가 아니다.

// educationLevel2 프로퍼티는 school 인스턴스의 고유 프로퍼티가 아니다.
console.log(school.hasOwnProperty("educationLevel2")); false
console.log(school.educationLevel2); // University 2

// 상속된 educationLevel2 프로퍼티를 지워보자.
delete school.educationLevel2; true (앞에서 언급하였듯이 항상 true를 반환한다)

// 상속된 educationLevel2 프로퍼티는 지워지지 않는다.
console.log(school.educationLevel2); University 2
```

### Serialize and Deserialize Objects

HTTP를 통해 객체를 전송하거나 문자열로 변환하기 위해서, 시리얼라이즈할(문자열로 변환할) 필요가 있을 것이다; JSON를 사용할 수 있다. 객체를 시리얼라이즈하기 하려면 함수를 문자열화하라. ECMAScript 5 전에는 JSON을 얻기 위해 (더글러스 크락포드의) 인기 있는 json2 라이브러리를 사용해야 했다는 것을 주목하라. 함수를 문자열화하는 것은 이제 ECMAScript 5에서는 표준이다.

객체를 디시리얼라이즈하기(문자열에서 객체로 변환하기) 위해서는, 같은 json2 라이브러리에서 JSON.parse 함수를 사용한다. 이 함수도 ECMAScript 5에서 표준이 되었다.

JSON.stringify 예제:

```javascript
var christmasList = {mike:"Book", jason:"sweater", chelsea:"iPad" }
JSON.stringify (christmasList);
// 다음 문자열을 출력한다:
// "{"mike":"Book","jason":"sweater","chels":"iPad"}"  

// 문자열화된 객체를 포매팅과 함께 출력하려면, 패러미터로 "null"과 "4"를 추가한다:
JSON.stringify (christmasList, null, 4);
/*
"{
    "mike": "Book",
    "jason": "sweater",
    "chels": "iPad"
}"
*/

// JSON.parse 예제 \\
 // 다음은 JSON 문자열이다, 그래서 (christmasListStr.mike와 같이) 점 표기법으로 접근할 수 없다.
var christmasListStr = '{"mike":"Book","jason":"sweater","chels":"iPad"}';

// 객체로 변환하자.
var christmasListObj = JSON.parse (christmasListStr);

// 이제 객체이므로 점 표기법을 사용한다.
console.log(christmasListObj.mike); // Book
```

객체를 다루기 위한 ECMAScript 5 추가사항을 포함하여, 자바스크립트 객체를 좀 더 상세히 커버하기 위해서는 JavaScript: The Definitive Guide 6th Edition의 6장을 읽어라.

