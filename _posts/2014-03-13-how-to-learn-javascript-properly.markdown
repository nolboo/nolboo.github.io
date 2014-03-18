---
layout: post
title: "자바스크립트 제대로 배우기"
description: "자바스크립트를 처음 배우는 사람에게 모범이 될만한 가이드의 번역. 레딧 등에서 이 가이드를 기준으로 많은 사람들이 자바스크립트를 배우고 있다."
category: blog
tags: [javascript, jquery, beginner, guide, studyjs]
---

올해는 본격적으로 프로그래밍을 배워보려고 했는데 역시 생각같이 진행되지 않았다.(블로그도 거의 두 달 간 방치ㅠㅠ) 자바스크립트부터 출발하려고 작년 후반 부에 Codecademy [자바스크립트 트랙](http://www.codecademy.com/tracks/javascript)을 며칠간에 걸쳐 완료했는데, 끝낸 후 느낌은 '이제 뭘 하지?'였다. 그런 약간의 멘붕을 겪은 후 이래저래 시간만 보냈다. 자바스크립트라고 마냥 쉬울 리는 없을 터이고, 최고 유명인도 자바스크립트를 [Javascript: 세상에서 제일 잘못 이해되고 있는 언어](http://vandbt.tistory.com/36)라고 이야기하는 것을 보니 아무래도 혼자서 온라인으로만 배우는 것은 한계가 있어 싸부를 모실 생각을 했고, 현역 프로그래머 한 분한테 제자 허락을 받았다^^ 씬난다~

Codecademy의 트랙같이 시간을 허무하게 보내지 않고(적어도 나한테는 그랬다ㅠㅠ) 기본이 될 튜토리얼을 찾는데 [굉장한 자바스크립트 강좌(영문) 소개](http://blog.wystan.net/2011/08/02/great-javascript-articles), [The Best Way to Learn JavaScript](http://code.tutsplus.com/tutorials/the-best-way-to-learn-javascript--net-21954)([한글 요약](http://blog.nundefined.com/38))와 [자바스크립트 제대로 배우기](http://javascriptissexy.com/how-to-learn-javascript-properly/) 등의 글이 눈에 들어왔으나, 첫 번째는 조금 오래되었고 두 번째와 세 번째 중에서 선택하려고 훑어보았는데 - 세 번째 가이드를 기반으로 진행하기로 마음먹었다.

[자바스크립트 제대로 배우기](http://javascriptissexy.com/how-to-learn-javascript-properly/)는 처음 글이 올라왔을 때 소셜에 [소개한 적](https://twitter.com/n0lb00/status/300800128535633921)이 있는데, 자신의 13살 딸한테 적용했다는 말도 빠지고 글이 **엄청나게** 버전업되었다. 번역 글 내용에는 포함하지 않았지만, 레딧같은 유명 커뮤니티 서비스에서 [>>>New Study Group Starting January 2014!<<< : learn_js_in_seattle](http://www.reddit.com/r/learn_js_in_seattle/comments/1tziaa/new_study_group_starting_january_2014/)와 같이 계속해서 이 가이드 기준으로 온라인 협업 스터디가 여러 번 진행되는 것 같다. 그래서 기본 가이드로 잡고 번역을 블로그에 올리기로 했다.(예전에 요약한 적이 있는데 그 요약을 다시 쓸 수 없을 정도로 개편돼서 처음부터 다시 번역ㅠㅠ) 

처음 글을 본 한 트위터 사용자가 어느 정도의 시간이 걸릴 것 같으냐고 저자한테 물어보았는데 주당 20~25시간 정도면 충분하다고 [트윗으로 멘션](https://twitter.com/jsissexy/status/300688774445273089)하기도 하였다. 업데이트된 가이드는 어느 정도의 시간이 걸릴지 알 수 없지만, 일단 시작해보자!(어차피 주당 20~25시간은 나한테는 무리;;)

---

원문 : [자바스크립트 제대로 배우기](http://javascriptissexy.com/how-to-learn-javascript-properly/)

* 기간: 6~8주
* 전제: 프로그래밍 경험 필요 없음.

이 코스 개요는 여러분을 완전 초보자에서 조예가 깊은 사람까지, 자바스크립트를 제대로 철저하게 배우는 방법에 대한 체계적이고 교육적인 로드맵을 준다.

여러분은 자바스크립를 배우고 싶어한다; 그것이 여러분이 여기 있는 이유이고 현명한 결정을 한 것이다. 현대적인 웹사이트와 웹앱(인터넷 스타트업을 포함해서)을 개발하길 원한다면 자바스크립트를 알 필요가 있다. 여러분에게 자바스크립트를 가르쳐줄만한 온라인 리소스는 이미 충분하고도 넘치지만, "웹의 언어"를 배울 가장 효율적이고 유익한 방법을 찾는 것은 쉬운 일도 아니며 좌절할 수도 있다.

확장 가능한, 다이내믹한, 데이터베이스 주도의 웹앱을 개발하기 위해 - PHP, Rails, Java, Python, 혹은 Perl과 같은 - 진짜 서버 사이드 언어를 알아야만 했던 수년 전과 달리, 오늘날엔 자바스크립트만으로 훨씬 더 많은 것을 할 수 있다는 것은 주목할만하다.

## How NOT To Learn JavaScript

* 처음부터 관련 없거나 관련된 자바스크립트 온라인 튜토리얼로부터 자바스크립트를 배우려고 하지 마라. - 이건 프로그래밍 언어를 배우는 가장 나쁜 방법이다. 셀 수도 없는 그런 튜토리얼에서 일부가 도움될 수는 있으나, 한 주제 내용을 철저하게 공부할 필요가 있는 적절한 계층적 구조가 부족한 비효율적인 과정이다. 그리고 이것은 언어로 웹사이트나 웹앱을 만들기 시작할 때, 여러분을 매우 자주 애먹게 할 수 있다. 간단히 말하면, 그 언어를 도구로서 - 여러분의 도구로서 - 사용할 때 필요한 노하우를 가지지 못할 것이다.

* 또한, 일부는 존경받는 자바스크립트 대부인 더글러스 크락포드의 "자바스크립트 핵심 가이드 - JavaScript: The Good Parts"로 자바스크립트를 배우는 것을 추천할 것이다. 크락포드씨는 자바스크립트에 엄청난 식견을 가지고 있고, 자바스크립트 세계의 아인슈타인으로 여겨지지만, 그의 책은 초보자에게 좋은 자바스크립트 책이 아니다. 철저하거나 명백하게 또는 쉽게 소화할 수 있는 형식으로 자바스크립트의 핵심 개념을 설명하고 있지 않다. 그러나 나는 고급 로드맵에서 크락포드의 고급 비디오를 따르라고 추천한다.

* 그리고 Codecademy만을 이용해서 언어를 배우려고 하지 마라. 여러분이 매우 작은 자바스크립트 태스크들을 프로그래밍하는 법만을 알게 될 것이므로, 절대적으로 하나의 웹앱을 만들 만큼 충분히 알지 **못하게** 된다. 그러나 보충적인 학습 리소스로서 Codecademy를 아래에 추천한다.(역자: 처음 글엔 이 말이 전혀 없었고, 댓글에 다른 사람들이 추천한 것을 보고 그것부터 따라 했다:;)

## Resources For This Course

두 개의 자바스크립트 책을 사용할 것이다. 하나는 프로그래밍 초보자들에게 이상적인 책이고, 다른 하나는 적어도 약간의 프로그래밍 경험이 있다면 더 좋은 책이다.

* 여러분은 다음 두개의 책 중 하나를 이용할 수 있다.

첫 번째 책은 저자가 주제들을 매우 잘 설명하고, 고급 자바스크립트 주제까지 커버하기 때문에 개인적으로 선호하는 것이다. 여러분이 적어도 웹 개발에 대한 약간의 기본적인 이해가 있다면 최고로 활용된다. 그러므로 프로그래밍이나 웹 개발에 약간의 경험이 있다면 - 자바스크립트일 필요는 없다, 이 책을 사라:

- 페이퍼백 버전: [Professional JavaScript for Web Developers: 아마존](http://www.amazon.com/gp/product/1118026691/ref=as_li_tf_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=1118026691&linkCode=as2&tag=interhaptic-20) - 번역본: [프론트엔드 개발자를 위한 자바스크립트 프로그래밍 : 도서출판 인사이트](http://www.insightbook.co.kr/post/5765)
- 킨들 버전: [Professional JavaScript for Web Developers eBook](http://www.amazon.com/gp/product/B006PW2URI/ref=as_li_tf_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B006PW2URI&linkCode=as2&tag=interhaptic-20)

혹은:
프로그래밍 경험이 없다면 이 책을 사라:

- 페이퍼백 버전: [JavaScript: The Definitive Guide: 아마존](http://www.amazon.com/gp/product/0596805527/ref=as_li_tf_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=0596805527&linkCode=as2&tag=interhaptic-20) - 번역본: [자바스크립트 완벽 가이드 | 도서출판 인사이트](http://www.insightbook.co.kr/books/programming-insight/%EC%9E%90%EB%B0%94%EC%8A%A4%ED%81%AC%EB%A6%BD%ED%8A%B8-%EC%99%84%EB%B2%BD-%EA%B0%80%EC%9D%B4%EB%93%9C)(역자주: 댓글을 보면 알겠지만 6판은 5판에 비해 번역이 좋지 않아 욕을 많이 먹고 있다)
- 킨들 버전: [JavaScript: The Definitive Guide](http://www.amazon.com/gp/product/B004XQX4K0/ref=as_li_tf_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B004XQX4K0&linkCode=as2&tag=interhaptic-20)

* [스택오버플로우](http://stackoverflow.com/)(무료 서비스)에 계정을 만든다. 프로그래밍 관련 질문을 하고 대답하는 일종의 포럼이다. 이 웹사이트는 여러분의 프로그래밍 질문에 대한 대답을 듣기 위해 - 아주 기초적인 멍청해 보이는(**멍청한 질문은 결코 없다는 것을 기억하라**) 질문에 대해서도 - Codecademy 보다 훨씬 더 쓸모가 있을 것이다.
* [Codecademy](http://www.codecademy.com/)에 계정을 만든다. 프로그래밍을 배우는 온라인 플랫폼이다: 여러분은 브라우저에서 저 웹사이트에 코드를 쓴다.(역시 무료 서비스이다.)
* Objects, Closures, Variable Scope and Hoisting, Functions 등에 관한 JavaScriptIsSexy 블로그 글

## The Roadmap to JavaScript Attainment

이 전체 코스 개요를 끝낸다면, 여러분은 자바스크립트 언어 전체에 대한 것을(그리고 jQuery와 HTML5 일부)을 **6~8주** 동안 배울 것이다. 6주 동안(상대적으로 공격적인 일정이다) 모든 섹션을 전념할 충분한 시간이 없어도, 8주 이상을 넘기려 하지 마라. 오래 걸릴수록 배우는 모든 것을 이해하고 기억하기가 어려울 것이다.

## Weeks 1 and 2 (Introduction, Data Types, Expressions, and Operators

1. HTML과 CSS를 잘 알지 못하면 먼저 Codecademy의 [Web Fundamentals](http://www.codecademy.com/tracks/web) 트랙을 끝낸다.

2. *JavaScript: The Definitive Guide*의 서문, 1장과 2장을 읽는다.
> - 혹은 *프론트엔드 개발자를 위한 자바스크립트 프로그래밍*의 도입, 1장과 2장을 읽는다.  

3. **매우 중요:** 책에서 마주치는 모든 예제 코드를 타자하고, 파이어폭스나 크롬의 브라우저 콘솔에서 테스트하고 조정해본다(실험한다). 혹은 [JSFiddle](http://jsfiddle.net/)을 이용한다. 사파리는 이용하지 마라. 나는 파이어폭스를 추천한다. - [Firebug Add on](https://addons.mozilla.org/en-us/firefox/addon/firebug/)을 파이어폭스에 추가하고, 코드를 테스트하고 디버깅해본다. 브라우저 *콘솔*은 여러분이 자바스크립트 코드를 쓰고 실행할 수 있는 브라우저의 영역이다. 
그리고 [JSFiddle](http://jsfiddle.net/)은 브라우저를 사용해서 온라인에서 코드를 쓰고 테스트할 수 있는 웹앱이다. HTML, CSS 그리고 자바스크립트(그리고 jQuery)의 조합을 포함하여, 모든 종류의 코드를 테스트할 수 있다.

4. Codecademy의 [자바스크립트 트랙](http://www.codecademy.com/tracks/javascript) 중 *Introduction to JavaScript* 섹션을 공부한다.

5. *JavaScript: The Definitive Guide*의 3장과 4장을 읽는다.
> - 혹은 *프론트엔드 개발자를 위한 자바스크립트 프로그래밍* 서문, 3장과 4장을 읽는다. “비트 연산자(Bitwise Operators)”는 건너뛸 수 있다; 여러분의 자바스크립트 커리어에서 그것들을 사용하는 경우가 거의 없을 것이다.
>
> - 그리고 다시, 멈추고 브라우저 콘솔(혹은 JSFiddle)에 예제 코드를 쓰고 실험한다. - 일부 변수와 코스를 약간 조정해본다.

6. *JavaScript: The Definitive Guide*의 5장을 읽는다. *프론트엔드 개발자를 위한 자바스크립트 프로그래밍*은 읽지 않는다, 이전 장에서 이미 배웠다.

7. Codecademy의 [자바스크립트 트랙](http://www.codecademy.com/tracks/javascript) 중 섹션 2에서 섹션 5까지 죽 공부한다.(역자주: 트랙에 붙은 작은 숫자가 기준이 아니다. Functions에서 Control Flow를 말한다.)

## Weeks 3 and 4 (Objects, Arrays, Functions, DOM, jQuery)

1. 내 글 [JavaScript Objects in Detail](http://javascriptissexy.com/javascript-objects-in-detail/)을 읽는다.
> - 혹은 *JavaScript: The Definitive Guide*의 6장을 읽는다.
>
> - 혹은 *프론트엔드 개발자를 위한 자바스크립트 프로그래밍*의 6장을 읽는다. 주: "객체에 대한 이해(Understanding Objects)" 섹션만 읽는다.
>
> - 3가지 중 어떤 것도 좋다, 두 책이 더 자세하지만: 내 글을 읽고 완전히 이해한다면 자신 있게 추가 세부사항은 건너뛸 수 있다.

2. *JavaScript: The Definitive Guide*의 7장과 8장을 읽는다.
> - 혹은 *프론트엔드 개발자를 위한 자바스크립트 프로그래밍*의 5장과 7장을 읽는다.

3. 이 시점에서, 여러분은 브라우저 콘솔에 코드를 쓰고 if-else 선언, for loops, Arrays, Functions, Objects 등을 테스트하는 것에 많은 시간을 소비해야만 한다. 여러분이 브라우저에서 (Codecademy의 도움 없이) 독립적으로 코딩하는 법을 아는(계속 연습하는) 것이 매우 중요하다. Codecademy로 되돌아갈 즈음엔 어떤 도움이나 힌트가 필요하지 않아야 한다. 모든 숙제도 쉬워야 한다.
> - Codecademy가 아직 어렵다면, 브라우저도 돌아가서 계속 해킹한다. 이것이 가장 잘 배울 수 있는 곳이다. [레브론 제임스](http://en.wikipedia.org/wiki/LeBron_James)가 "거리"(이웃 농구 코트)에서 젊은 시절에 기술을 연마하거나, 빌 게이츠가 지하에서 홀로 해킹하는 것과 유사하다.
>
> - 여러분 스스로 조금씩 외로이 해킹하고 배우는 것은 엄청난 가치가 있다. 여러분은 이 전략 속에 있는 가치를 알아야 하고, 기꺼이 받아들여야 하고, 작동될 것이라고 믿어야 한다.  
> 
> **Codecademy를 사용했을 때 성취에 대한 잘못된 인식**
> 
> - Codecademy의 가장 큰 문제점은 힌트와 작은 코드들이 여러분에게 매우 도움이 되어서 쉽게 연습을 진행하는 경우, 여러분이 성취에 잘못된 인식을 하도록 하는 것이다. 그 경우 여러분은 알지 못할 것이며, 여러분이 행한 많은 것이 여러분 것이 아니다.
>
> - 자, Codecademy는 아직도 여러분이 코딩하는 법을 배우는 것에 훌륭하다, 특히 if 선언, for loops, functions, and variables 같은 매우 기본적인 코드로 작은 프로젝트나 작은 앱을 개발하는 프로세스를 통해 여러분을 안내하는 방식으론.

4. Codecademy로 돌아가서 자바스크립트 트랙의 6, 7, 8 섹션(Data Structures에서 Object 2까지)을 공부한다.

5. Codecademy를 하는 동안, [프로젝트](http://www.codecademy.com/tracks/projects) 트랙으로 가서, 다섯 개의 작은 Basic Projects를 만든다. 이러면, Codecademy는 다 끝냈다. 여러분 스스로 더 많이 공부할수록, 더욱 빨리 배우고, 스스로 프로그래밍하는 것을 더욱 잘 준비할 수 있기 때문에, 이건 좋은 것이다.

6. *JavaScript: The Definitive Guide*의 13장, 15장, 16장과 19장을 읽는다.
> - 혹은 *프론트엔드 개발자를 위한 자바스크립트 프로그래밍*의 8장, 9장, 10장, 11장, 13장과 14장을 읽는다. 이 책은 jQuery를 다루지 않고 있고, Codecademy의 jQuery도 충분하지 않다. 이 jQuery 과정을 따른다 - 무료다: [Code School - Try jQuery](http://try.jquery.com/)
>
> - 그리고, 책을 가지고 있다면 jQuery에 대해 더 많이 알기위해, *JavaScript: The Definitive Guide*의 19장을 읽을 수도 있다.

7. [Code School - Try jQuery](http://try.jquery.com/)에 있는 전체 jQuery 과정을 따라서 공부한다.

## Get The Ultimate JavaScript Editor: WebStorm

* 첫번째 프로젝트를 만들기 전에, 여러분이 자바스크립트 개발자가 되거나 자바스크립트를 자주 사용하려고 한다면, 여기서 잠시 쉬고, [웹스톰 : WebStorm](http://www.jetbrains.com/webstorm/)의 평가판을 내려받는다. 웹스톰을 시작하는 법을 [여기에서](http://2oahu.com/blog/webstorm-javascript/)(이 과정을 위해 별도로 쓰였다) 배운다.

> 웹스톰은 의심할 여지 없이 자바스크립트 프로그래밍에 절대적으로 최고의 에디터(IDE)이다. 30일 평가 기간이 끝나면 $49의 비용이 들지만, 여러분이 자바스크립트 개발자로서 할 수 있는 최고의 투자가 될 것이다.

* 웹스톰에서 **JSHint**를 사용하도록 설정한다. JSHint는 "자바스크립트 코드에서 에러와 잠재적인 문제점들을 감지하고, 여러분 팀의 코딩 규칙을 적용해주는 툴"이다. 웹스톰을 사용할 때 멋진 점은 JSHint가 여러분 코드의 에러 밑에 - 워드프로세서 앱에서 철자법 검사기와 같이 - 빨간 줄을 자동으로 추가하는 것이다. 그래서 JSHint는 여러분 코드에서 (HTML 에러를 포함하여) 보여주고, 여러분을 더 나은 자바스크립트 프로그래머로 만들어 줄 것이다, 배울 때조차도. **이것은 매우 중요하다**. 웹스톰과 JSHint가 여러분을 더 나은 프로그래머로 되는 것을 도와준다는 것을 인식하게 될 때 나한테 고마워할 것이다.

* 게다가 웹스톰은 전문적인 자바스크립트 웹앱을 코딩할 수 있는 세계적 수준, 전문가 수준의 IDE이며, 여러분은 그것을 많이 사용하게 될 것이다. 그리고 Node.js, Git과 다른 자바스크립트 프레임워크를 통합하고 있어서, 여러분이 록스타 자바스크립트 개발자가 된 후까지도 그것을 사용할 것이다.

* 그다음으로 베스트 자바스크립트 에디터인 [Sublime Text 2](http://www.sublimetext.com/2)도 언급하는 것이 공평할 것이다. 그러나, - 수많은 확장 패키지를 갖고 있음에도 - 웹스톰만큼 기능이 풍부하고 완벽하지 않다. 나는 JS 파일을 포함한 다른 프로그래밍 언어 파일들을 작게 편집할 때 Sublime Text 2를 사용한다. 그러나 전체 자바스크립트 웹앱을 프로그래밍하기 위해 사용하지는 않는다.

## Your First Project—A Dynamic Quiz

이 시점에, 여러분은 관리할 수 있는 견고한 웹앱을 만들 수 있을 정도로 배웠다. 내가 아래에 기술한 이 앱을 성공적으로 만들 수 있을 때까지 어떤 추가적인 진행을 하지 마라. 막히면, Stack Overflow에 질문하고, 개념을 제대로 이해하기 위해 책의 섹션들을 다시 읽어라.

(HTML과 CSS도 사용하여) 자바스크립트 퀴즈 앱을 만들 것이다. 기능은 다음과 같다:

* 라디오 버튼 선택을 하는 간단한 퀴즈이다, 완료하면 사용자에게 점수를 보여준다.

* 퀴즈는 퀴즈 문항 수와 선택 문항 수를 원하는 대로 보여줄 수 있다.

* 사용자 점수를 기록하고, 마지막 페이지에 최종 점수를 보여준다. 마지막 페이지에선 점수만 보여주므로, 마지막 질문은 제거한다.

* 모든 질문을 저장하는 배열을 사용한다. 각 질문은 - 선택과 정답이 함께 - 한 객체에 저장되어야 한다. 질문의 배열은 이와 비슷하게 보여야 한다:

```javascript
// Only one question is in this array, but you will add all the questions.
var allQuestions = [{question: "Who is Prime Minister of the United Kingdom?", choices: ["David Cameron", "Gordon Brown", "Winston Churchill", "Tony Blair"], correctAnswer:0}];
```

* 사용자가 "Next" 버튼을 누르면, (document.getElementById 혹은 jQuery를 사용해서) 동적으로 다음 질문을 추가하고 화면에서 현재 질문을 제거한다. Next 버튼은 이번 버전의 퀴즈를 탐색하는 유일한 버튼이 될 것이다.

* 여러분은 이 글의 댓글 혹은 될 수 있으면 스택오버플로우에서 도움을 요청할 수 있다. 스택오버플로우에서 신속하고 정확한 답변을 얻을 수 있을 것이다.

## Weeks 5 and 6 (Regular Expressions, Window Object, Events, jQuery)

1. *JavaScript: The Definitive Guide*의 10장, 14장, 17장과 20장을 읽는다.
> - 혹은 *프론트엔드 개발자를 위한 자바스크립트 프로그래밍*의 20장과 23장을 읽는다.

2. 파이어폭스 콘솔에 모든 예제 코드를 계속 타자하고, 그것이 어떻게 동작하고 무엇인지를 진짜 이해하기 위해 실험하면서 코드의 각 부분을 계속 조정해야 하는 것을 기억하라.

3. 이즈음에, 여러분은 자바스크립트가 - 아마 [제다이 : Jedi](http://en.wikipedia.org/wiki/Jedi)와 같이 - 매우 편안해져야 한다. 여러분은 아직 제다이가 아니다, 계속 배우고 개선하기 위해 새로 습득한 지식과 기술을 할 수 있는 한 자주 사용하여야 한다.

4. 이전의 퀴즈 앱을 개선한다:
> - 클라이언트 측의 데이터 유효성 검사를 추가한다: 다음 질문으로 진행하기 전에 사용자가 각각의 질문에 대답해야 한다.
>
> - 사용자가 되돌아가서 대답을 수정할 수 있도록 "Back" 버튼을 추가한다. 사용자는 최초의 질문으로 되돌아갈 수 있다. 사용자가 이미 대답한 질문에선 다시 질문에 답하지 않도록, 선택한 라디오 버튼을 보여주어야 한다.
>
> - 애니메이션을 추가하기 위해 jQuery를 사용한다(현재의 질문을 페이드아웃하고 다음 질문을 페이드인한다.)
>
> - 퀴즈를 IE 8과 9에서 테스트하고, 버그를 고친다. 여러분에게 좋은 연습을 줄 것이다 :)
>
> - 하나의 외부 JSON 파일에 퀴즈 질문을 저장한다.
>
> - 사용자 인증을 추가한다: 사용자가 로그인하고 로그인 인증을 로컬 저장소(HTML5 브라우저 저장소)에 저장하도록 한다.
>
> - 사용자를 기억하기 위해 쿠키를 사용하고, 사용자가 퀴즈로 되돌아왔을 때 "Welcome, First Name" 메시지를 보여준다.

## Weeks 7 and, if necessary 8 (Classes, Inheritance, more HTML5)

1. *JavaScript: The Definitive Guide*의 9장, 18장, 21장과 22장을 읽는다.
> - 혹은 내 블로그 글 [OOP In JavaScript: What You NEED to Know](http://javascriptissexy.com/oop-in-javascript-what-you-need-to-know/)를 읽는다.
>
> - 혹은 *프론트엔드 개발자를 위한 자바스크립트 프로그래밍*의 6장(이번에는 "객체 생성 : Object Creation"과 "상속 : Inheritance"만), 16장, 22장과 24장을 읽는다. 주: 이 섹션을 읽는 것이 전체 로드맵에서 마주치는 가장 기술적인 독서이다. 모두 읽기를 원한다면 여러분한테 달려있다. 적어도 Prototype Pattern, Factory Pattern과 Prototypal Inheritance은 읽어야 한다. 모든 패턴을 알 필요는 없다.

2. **퀴즈 앱을 한층 더 개선한다:**
> - 좀 더 전문적으로 보이도록, 퀴즈 엘리먼트를 포함한 전체 페이지 레이아웃을 위해 [트위터 부트스트랩](http://twitter.github.com/bootstrap/)을 사용한다. 추가 보너스로서, 트위터 부트스트랩의 [탭](http://twitter.github.com/bootstrap/javascript.html#tabs) 유저 인터페이스 컴포넌트를 사용하고 각각의 탭에 4개의 퀴즈 중 하나씩 보여준다.
>
> - [Handlebars.js를 배우고](http://javascriptissexy.com/handlebars-js-tutorial-learn-everything-about-handlebars-js-javascript-templating/), Handlebar.js 템플릿을 퀴즈에 추가한다. 더는 자바스크립트 코드 안에 어떠한 HTML도 있어선 안 된다. 여러분의 퀴즈는 조금씩 진보하고 있다.
>
> - 퀴즈를 수행하는 모든 사용자를 계속 기록하고, 각 사용자에게 다른 퀴즈 수행자의 점수 중 자신의 점수 순위를 보여준다.

3. 나중에(Backbone.js와 Node.js를 배운 후), 여러분은 퀴즈 앱을 리팩터링하고 최신 자바스크립트 프레임워크를 사용하여 만들어진 - 복잡하고 모던한 싱글페이지 웹앱으로 만들기 위해 이 두 기술을 사용할 것이다. 사용자 인증 증명과 점수를 MongoDB 데이터베이스에 저장할 것이다.

4. 다음: 개인 프로젝트를 결정하고 즉시 여러분의 프로젝트를 만든다. 어려움이 닥치면 *JavaScript: The Definitive Guide*(혹은 "프론트엔드 개발자를 위한 자바스크립트 프로그래밍")를 이용한다. 그리고 물론 스택오버플로우의 적극적인 사용자가 되어라: 질문하고 다른 프로그래머의 질문에 답하라.

## Continue Improving

1. [Backbone.js를 완전히 배운다](http://javascriptissexy.com/learn-backbone-js-completely/)

2. [중급과 고급 자바스크립트를 배운다](http://javascriptissexy.com/learn-intermediate-and-advanced-javascript/)

3. [자신감을 갖고 Node.js를 완전히 배운다](http://javascriptissexy.com/learn-node-js-completely-and-with-confidence/)

4. 곧 올라올 내 포스트 *Getting Started with Meteor.js*를 읽는다. (역자주: 언제 올라올지 모르니 최근 한글 번역이 완료된 [Discover Meteor](http://kr.discovermeteor.com/)를 무료로 읽을 것이다^^)

5. 곧 올라올 내 포스트 the Three Best Front-end JavaScript Frameworks를 읽는다.

## Words of Encouragement

**역자 요약**: 처음에 어렵더라도 절대 포기하지 마라. 나중에 성취감이 보상해줄 것이다. 아무리 작은 프로젝트라도 만들면 링크를 공유해다오!

### 역자 참조 링크

관심 있으신 분들은 [자바스크립트 제대로 배우기 스터디 그룹](https://www.facebook.com/groups/learnjsproperly/)에 가입신청을 하시면 가입 시기에 상관없이 승인해드리고 있습니다.

* [JS: The Right Way](http://bit.ly/1hzQN9S)
* [Best of JavaScript, HTML & CSS – 2013](http://flippinawesome.org/2014/01/06/best-of-javascript-html-css-2013/)
* [디자이너를 위한 자바스크립트](http://j.mp/1e9Ptev)


