---
layout: post
title: "모던 워드프레스 서버 스택"
description: "워드프레스 서버로서 LAMP가 대표 서버 스택인 시대를 뛰어넘어 이제는 다양한 현대적인 서버 스택이 필요해졌다. 스매싱에 좋은 글이 올라와서 발번역했다"
category: blog
tags: [wordpress, server, stack, development, environment]
---

원문 : [A Look At The Modern WordPress Server Stack – Smashing Magazine](https://www.smashingmagazine.com/2016/05/modern-wordpress-server-stack/)

아파치 서버와 PHP만으로 "빠른" 워드프레스 웹사이트를 돌릴 수 있을 때를 기억하는가? 그런 시절이 있었다!

이젠, 모든 것이 엄청 빨라야 한다. 방문자가 예전 같은 로딩 시간을 기대하진 않는다. 느린 웹사이트는 자신 혹은 고객에게 심각한 영향을 줄 수 있다.

따라서, 이러한 속도에 대한 요구를 따라잡기 위해 **워드프레스 서버 스택은 몇 년에 걸쳐 진화해야 했다**. 이러한 진화 일부로서, 일부 장치는 엔진에 추가해야 했다. 예전 장치의 일부는 변화해야 했다.

그 결과로 워드프레스 서버 스택은 몇 년 전 그것과는 오늘날 매우 달라 보인다. 더 이해하기 위해서, 새로운 스택을 세세하게 다뤄볼 것이다. 워드프레스 웹사이트를 빠르게 하도록 다양한 부분이 서로 조합되는 것을 살펴볼 것이다.

### Overview

파고들기 전에 큰 그림을 보자. 새로운 서버 스택은 어떻게 보일까? 여기 답이 있다:

![WordPress server stack diagram](https://media-mediatemple.netdna-ssl.com/wp-content/uploads/2016/05/WordPress-server-stack-diagram.png)

이 다이어그램은 모던 워드프레스 서버 스택의 모습의 좋은 개요를 보여준다. 고수준에서 세 가지 영역으로 나눌 수 있다:

* 브라우저와 워드프레스 간의 요청-응답 사이클;
* 워드프레스(PHP 런타임 실행하는 스크립트로서);
* 워드프레스와 MySQL 데이터베이스 간의 쿼리-결과 사이클.

모던 워드프레스 서버 스택의 역할은 이들 세 영역을 최적화하는 것이다. 이러한 최적화는 모든 것이 빨리 로드되도록 하는 것이다. 그리고 가장 중요한 부분은 이렇게 할 여러가지 방법이 있다는 것이다.(야호!)

대부분은 이러한 최적화는 서버에 새로운 서비스를 설치하는 것을 필요로 한다. 때때로, 이러한 서비스는 워드프레스와 상호작용하는 플러그인의 도움이 필요하다. 플러그인을 설치만 하는 일도 있다. 이 글 전반에 걸쳐 다양한 옵션을 볼 수 있을 것이다.

### The Request-Response Cycle

모든 것이 브라우저와 시작한다. `modern.wordpress-stack.org`의 홈페이지를 보길 원한다고 가정해보자. 브라우저는 [HTTP request](https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Request_message)를 홈페이지를 호스팅하는 웹서버에 보내면서 시작된다. 다른 쪽에서는 웹서버가 요청을 받을 것이고 [HTTP response](https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Response_message)로 변환할 것이다.

첫 번째 응답은 `modern.wordpress-stack.org` 홈페이지의 HTML 콘텐츠가 되어야만 한다(오류가 없다면). 그러나 브라우저의 작업은 수행되지 않는다. 아니, 그 홈페이지는 아직 더 많은 파일, 일반적으로 CSS, 자바스크립트, 이미지 파일이 필요하다.

그래서, 브라우저는 그런 파일에 대한 요청을 보낸다. 웹서버는 요청된 파일로 (에러가 없는 한) 응답한다. 이 사이클은 브라우저가 홈페이지를 렌더링하기 위한 충분한 정보를 얻을 때까지 계속된다.

지금, 이것은 명백한 단순화이지만, 대부분의 워드프레스 웹사이트에서 동작하는 방법이다.

### Optimizing The Request-Response Cycle Link

좋다, 이것은 어떻게 웹서버가 이 사이클을 더 빠르게 수행하느냐는 명백한 질문을 던진다. 좋은 질문이고 모던 워드프레스 서버 스택의 존재 이유 중 한 부분이다.

웹서버를 더 빠르게 만들 수가 없어서 스택이 존재한다. 웹서버는 발송자이기도 하다. 요청을 받고 다른 서비스에 그것을 전달만 할 수도 있다.

이러한 다른 서비스는 종종 이 요청-응답 사이클의 병목이 되기도 한다. 워드프레스에서는 이러한 병목이 PHP이다. 요청-응답 사이클을 최적화하는 이유는 두 가지이다. 웹서버가 하기를 원하는 것은:

* 되도록 적은 요청을 받는다,
* PHP에 되도록 적은 요청을 전달한다.

모던 워드프레스 서버 스택은 후자에 초점을 맞춘다. 되도록 적은 요청을 PHP에 전달하려고 한다. 그것이 스택을 최적화하는 주요 목표이다.

스택은 첫 번째와는 많은 것을 할 수 없으므로 두 번째 목표에 초점을 둔다; 직접적인 영향을 주지 않는다. 두 번째는 웹서버의 환경설정이나 모던 개발 기술에 의해 다루어진다.

### Stack Elements For The Request-Response Cycle

그래서, PHP로 전달되는 요청을 줄이는 스택 요소는 무엇인가? 특히 두 가지의 스택 요소가 그 목표를 달성하는 데에 도움이 된다: 웹서버와 HTTP cache.

#### Web Server

이미 웹서버에 대해 많이 말했다. 웹서버에는 세 개의 중요한 플레이어가 있다:

* [Apache](https://en.wikipedia.org/wiki/Apache_HTTP_Server)
* [Internet Information Services (IIS)](https://en.wikipedia.org/wiki/Internet_Information_Services)
* [nginx](https://en.wikipedia.org/wiki/Nginx)

다 합치면, 인터넷 웹서버 시장의 90%를 차지한다. Apache와 nginx에 초점을 맞출 것이다. IIS에서도 워드프레스를 돌릴 수 있지만, 윈도에서만 사용되고 대부분의 워드프레스 서버는 리눅스를 사용한다.

워드프레스 생애 전반에 걸쳐, 아파치는 추천되는 웹서버였다. 컴퓨터와 서버 모두에서 워드프레스를 실행했던 LAMP 스택(Linux, Apache, MySQL and PHP)이 있다.

그러나, 무대 뒤에서 상황이 변하였다. 새로운 선수가 있었고, 그 이름은 nginx였다. 오토매틱과 워드프레스닷컴은 [2008년부터](http://www.wired.co.uk/news/archive/2013-09/09/nginx) 사용해왔다. [트래픽이 높은 웹사이트의 가장 큰 비율](http://w3techs.com/blog/entry/25_percent_of_the_web_runs_nginx_including_46_6_percent_of_the_top_10000_sites)을 돌리는 웹서버이다(그중 많은 곳이 워드프레스를 사용한다). 많은 최고급 호스팅 회사와 상위 워드프레스 에이전시가 nginx를 웹서버로 사용하는 이유다.

아파치가 나쁜 웹서버가 아니다. 많은 트래픽에서 아파치 전문가가 훌륭하게 아파치를 운영할 수 있다. 게다가 고정관념 탈피나 표준 워드프레스 설정으로 되는 것이 아니다.

한편 nginx의 유일한 목적은 많은 트래픽을 처리하는 것이다. 그것이 [Igor Sysoev](https://en.wikipedia.org/wiki/Igor_Sysoev)가 [Rambler](https://en.wikipedia.org/wiki/Rambler_(portal))에서 일하면서 프로젝트를 시작한 이유이다.

Nginx가 더 나은 트래픽을 처리하는 이유 중 하나는 PHP와 통신하기 위해 [FastCGI](https://en.wikipedia.org/wiki/FastCGI)를 사용한다는 것이다. FastCGI가 무엇일까? 웹서버로부터 분리된 서비스로서 PHP를 실행하도록 하는 프로토콜이다.

아파치는 디폴트로 이것을 하지는 않는다. 웹서버가 요청을 받을 때마다 PHP 런타임 프로세스를 시작하는 것이 필요하다 - 심지어 이미지이든, 자바스크립트이든, CSS이든. 이것은 서버가 처리할 수 있는 요청의 수를 줄이고 그것을 빨리 처리할 수 있도록 한다.

아파치의 이것은 앞서 살펴본 모던 워드프레스 서버 스택의 목표 중 하나와 맞지 않는다. 스택은 요청-응답 사이클 시간을 되도록 작게 유지해야 한다. 모든 요청에 필요하지도 않은 PHP를 로드하는 것은 이 목표에 반한다. 만약 아파치를 사용한다면 FastCGI를 살펴봐라.

[**HTTP/2**](https://en.wikipedia.org/wiki/HTTP/2)는 알아 두어야 할 또 다른 중요한 웹서버 기능이다. HTTP의 다음 버전이고, 전체 요청-응답 사이클을 강력하게 한다.

HTTP/2가 나타나기 전엔 하나의 브라우저가 웹 서버에 오직 여섯 개의 연결을 가질 수 있었다. 그리고 각 연결은 한 번에 하나의 요청만 처리할 수 있었다. 그래서, 실제로 하나의 요청-응답 사이클은 사이클 당 여섯 개의 요청으로 제한되었다.

그것은 현실적인 문제이다. 대부분의 웹사이트는 사이클 안의 수십 개의 요청을 받는다. 개발자와 시스템 관리자는 이 제한을 해결하는 영리한 방법을 발견했다.

꽤 유명한 차선책 중 하나는 CSS와 자바스크립트 파일을 병합하는 것이다. 이상적인 시나리오라면 이것은 CSS와 자바스크립트 파일을 두 개(자바스크립트 하나와 CSS 하나)로 만들어 준다.

HTTP/2에서는 이럴 필요가 없다. HTTP/2는 연결 당 요청을 무제한으로 허용할 수 있다. 이것은 초기 HTML 응답 후의 모든 추가적인 요청을 허용한다.

이것은 거대한 성능 향상을 한다. 서버 스택을 최적화하려는 많은 작업이 요청-응답 사이클에 중점을 두고 있다. 단지 사이클의 숫자를 줄이는 것만으로도 HTTP/2는 엄청난 일을 한 것이다.

#### HTTP Cache

모던 워드프레스 서버 스택의 가장 중요한 부분은 HTTP 캐시다. 워드프레스 세계에서는 이걸 페이지 캐싱이라고도 부른다. HTTP 캐시의 목적은 요청에 대한 응답을 캐싱한다. 이것은 무엇을 의미하는가?

다시 앞의 예제에 돌아가자. 브라우저는 `modern.wordpress-stack.org`의 홈페이지에 요청을 보내고 웹서버는 요청을 받아서 PHP로 전달한다.

이 시나리오의 문제점은 웹서버가 더미라는 것이다. 언제나 수신한 모든 요청을 PHP로 전달한다 - 대부분의 요청이 같은 응답을 생성해도.

이것은 방문자가 로그인하지 않았을 때도 정확히 일어난다. 웹서버에는 모두 다른 요청이며 신경을 쓰지 않는다. 같은 응답을 생성하는 모든 요청을 PHP에게 전달할 것이다.

끔찍하다! 앞서 보았듯이, PHP는 요청-응답 사이클에서 실제 병목현상이다. 브라우저는 초기 홈페이지 응답을 받기 전까지 후속 요청을 보낼 수 없다. 디폴트로 PHP로 모든 것을 보내는 웹서버를 가질 수는 없다.

그곳이 HTTP 캐시가 끼어드는 곳이다. 웹서버와 PHP 사이에 위치한다. 하는 일은 웹서버가 받는 모든 요청을 확인하고 캐시된 응답을 찾는다. 없다면 PHP로 요청을 전달하고 PHP가 생성한 응답을 캐시한다.

이것은 응답-요청 사이클을 과감하게 감소시키고, 웹사이트가 더 빨리 로드하게 한다. 또한, 웹서버가 잘못되지 않으면서 더 많은 동시 요청을 다루게 한다.

### The Different Flavors Of HTTP Cache

이 시점에서 궁금해야 한다, "내 서버에 최대한 빨리 이 소중한 것을 얻을 수 있을까?!" 좋은 소식은 워드프레스 서버에 HTTP 캐시를 설치하기가 매우 쉽다는 것이다. 넓은 범위의 선택 요소가 있다.

#### Install a Page-Caching Plugin

가장 쉬운 방법은 페이지-캐싱 플러그인을 설치하는 것이다. 선택할 몇 가지 옵션이 있다:

* [Batcache](https://wordpress.org/plugins/batcache/)
* [Hyper Cache](https://wordpress.org/plugins/hyper-cache/)
* [Cache Enabler](https://wordpress.org/plugins/cache-enabler/)
* [WP Rocket](https://wp-rocket.me/)
* [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/)
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/)

WP Rocket을 제외하면 워드프레스 디렉토리에서 무료 플러그인으로 사용할 수 있다. 그래서, 하나씩 설치하고 즉시 테스트할 수 있다. 그중 최고인 것은 WP Rocket이라고 말할 수 있다. 유료 플러그인이지만, HTTP 캐시를 만드는 것 이상의 많은 것을 수행한다. 이 나머지 장점은 HTTP 캐시가 하는 작업을 확대한다.

#### How Does a Page-Caching Plugin Work?

이러한 모든 플러그인은 캐싱할 수 있도록 워드프레스가 만드는 drop-in을 활용한다. 이 캐싱 drop-in은 플러그인이 워드프레스 내부에 HTTP 캐시 시스템을 만들 수 있도록 한다. 캐싱 drop-in이 작동하려면 두 가지가 필요하다.

첫째, `advanced-cache.php` drop-in 파일이 `wp-content` 폴더 안에 있어야 한다. 실제 파일이다. 그러나, 대부분의 워드프레스 drop-in과 다르게, 이것은 디폴트로 있지 않다. 워드프레스에서 drop-in이 로드되도록 `WP_CACHE` 상수를 `true`로 주어야 한다. 대부분은 `wp-config.php` 안에서 설정할 수 있을 것이다.

![Plugin HTTP Cache \(loading\)](https://media-mediatemple.netdna-ssl.com/wp-content/uploads/2016/05/Plugin-HTTP-Cache-loading-opt-1.png)

위의 다이어그램은 캐싱 플러그인으로 drop-in을 사용하도록 설정하면 어떻게 되는지 보여준다. 워드프레스는 [로드 프로세스](https://carlalexander.ca/wordpress-adventurous-loading/) 동안 `wp-settings.php` 안의 drop-in을 로드한다. 워드프레스가 시간이 오래 걸리는 작업을 아무것도 하지 않는 단계에선 충분히 이르다.

캐싱 플러그인은 요청에 대한 응답이 이미 캐시되어있는지 확인할 것이다. 있으면, 캐시된 응답을 반환한다. 없으면, [PHP 출력 버퍼링](https://php.net/manual/en/outcontrol.setup.php)이 켜지고 워드프레스는 계속 로드될 것이다.

출력 버퍼링이 흥미로운 시스템이다. 하는 일은 문자열 변수에서 다음 두 가지 중 하나가 일어날 때까지 PHP 스크립트의 모든 출력을 캡처한다:

* 내장 함수 중 하나를 사용하여 PHP에 출력 버퍼링을 중지하도록 한다,
* PHP 스크립트가 끝나고 브라우저에 응답을 반환할 필요가 있다.

캐싱 플러그인은 후자의 시나리오를 기대한다. 워드프레스가 작업하고 난 후 PHP가 다시 브라우저에 보내기 전에 전체 출력을 캐시하기를 원한다. 아래 다이어그램에서 해당 프로세스를 볼 수 있다.

![Plugin HTTP Cache \(shutdown\)](https://media-mediatemple.netdna-ssl.com/wp-content/uploads/2016/05/Plugin-HTTP-Cache-shutdown-opt-1.png)

#### Have the Web Server Do It

다음 옵션은 웹서버 레벨에서 HTTP 캐시를 추가하는 것이다. 작동 방법은 웹서버가 PHP로 전달되는 모든 요청에 대한 응답을 캐시하는 것이다. PHP를 건드릴 필요가 전혀 없으므로 이 해결책이 캐싱 플러그인보다 낫다.

![Web server HTTP cache](https://media-mediatemple.netdna-ssl.com/wp-content/uploads/2016/05/Web-server-HTTP-cache-opt-1.png)

위의 다이어그램은 웹 서버에서 무슨 일이 일어나고 있는지에 대한 개요를 제공한다. 웹서버가 요청을 받으면 HTTP 캐시로 체크한다. 이미 응답이 캐시되어있다면, HTTP 캐시는 그것을 다시 보낼 것이다.

그렇지 않으면, PHP 모듈(보통은 FastCGI)에 요청을 전달한다. 응답을 생성할 수 있도록 워드프레스에 요청을 전달한다. HTTP 캐시 모듈은 돌아오는 길에 그 응답을 캐시할 것이다.

아파치와 nginx 모두 HTTP 캐시 시스템을 추가할 수 있다. nginx는 내장되어 있다. 아파치는 아파치 설치 시 추가해야 하는 분리된 [모듈](https://httpd.apache.org/docs/2.4/mod/mod_cache.html)로 있다.

PHP 혹은 워드프레스와 아파치 모듈을 사용하는 방법에 대한 많은 정보가 있는 것은 아니다. 아파치 대중에게 인기가 없거나 아마 몇 가지 이슈를 가지고 있기 때문일 것이다. 아직 오픈된 채로 [오래 지속하는 적어도 하나의 이슈](https://bz.apache.org/bugzilla/show_bug.cgi?id=48364)가 있다.

한편, nginx HTTP 캐시 시스템은 강력하고 잘 설명되어 있다. [정상적인 HTTP 캐시](https://www.nginx.com/blog/nginx-caching-guide/)나 작고 효율적인 [마이크로 캐시](https://www.nginx.com/blog/benefits-of-microcaching-nginx/)로 사용할 수 있다. 요즘 Nginx가 더 선호되는 웹서버인 추가적인 이유다.

#### Add Varnish to the Stack

[Varnish](https://en.wikipedia.org/wiki/Varnish_(software)가 무엇인가? 그것은 전용 HTTP 캐시 서버(혹은, 개발자가 부르고 싶어 하는, HTTP 가속기)이다. 대부분의 트래픽이 높은 웹사이트와 프리미엄 호스팅 회사가 HTTP 캐시 솔루션으로 사용한다.

강력하고 유연성을 가장 많이 제공하기 때문에 사용한다. Varnish는 VCL라는 자체 설정 언어를 가지고 있다. 캐싱 프로세스의 모든 요소를​​ 제어할 수 있다. Varnish는 캐시가 하는 일과 수행하는 방법을 분석할 수 있는 많은 도구가 포함되어 있다.

Varnish를 사용하는 것과 내장 웹서버 HTTP 캐시만을 사용하는 것은 주요 차이점이 있다. 내장 웹서버 HTTP 캐시는 초성과적이고 아주 기본적이다. 몇 가지 설정 옵션이외에는 제어를 다양하게 할 수는 없다.

그런데도, 이 강력함과 유연성이 가격과 함께 온다. Varnish는 가장 복잡한 HTTP 캐시 옵션이다. 캐시 HTTP 응답 외에는 아무것도 하지 않는다. 대부분의 워드프레스 개발자가 원하는(또는 원해야 하는) [SSL 종료를 다루지 않는다](https://www.varnish-cache.org/docs/trunk/phk/ssl_again.html). 이것은 모던 워드프레스 서버 스택이 점점 복잡해져 간다는 것을 뜻한다.

![Varnish HTTP cache](https://media-mediatemple.netdna-ssl.com/wp-content/uploads/2016/05/Varnish-HTTP-cache.png)

위의 다이어그램은 이러한 추가적인 복잡성을 보여준다. 이제 워드프레스 서버 스택에서 두 가지 요소를 더 가진다: Varnish와 [역 프락시](https://en.wikipedia.org/wiki/Reverse_proxy).

역 프락시는 SSL에서 Varnish가 가지는 제한을 극복한다. Varnish의 앞에서 서버가 받는 요청을 해독한다. 이런 역 프락시 유형을 [SSL 종료 프락시](https://en.wikipedia.org/wiki/SSL_termination_proxy)라고 부를 수 있다. 프락시는 이러한 해독한 요청을 Varnish에게 처리하도록 전달한다.

하나의 요청이 Varnish를 때리면, VCL 설정 파일이 개입한다. 그것들이 Varnish의 뇌이다. 예를 들어, 이런 것을 말해준다:

* 들어오는 요청을 분석, 정리, 수정하는 법;
* 캐시된 응답을 찾는 법;
* 워드프레스에서 돌아오는 응답을 분석, 정리, 수정하는 법;
* 이러한 반환 응답을 캐시하는 법;
* 캐시로부터 하나 이상의 응답을 제거하기 위해 요청을 처리하는 법.

마지막 것이 특히 중요하다. 그것 자체로는 Varnish는 워드프레스가 언제 캐시에서 페이지를 제거하기를 원하는 지 알 수 있는 방법이 없다. 그래서, 디폴트로, 포스트를 변경하고 업데이트하면, 방문자는 똑같은 캐시된 페이지만 보게 될 것이다. 다행인 것은 Varnish 캐시에서 페이지를 제거하는 [플러그인이 있다](https://en-ca.wordpress.org/plugins/varnish-http-purge/).

### WordPress

`modern.wordpress-stack.org` 홈페이지에 요청이 워드프레스를 때렸다. 우리가 이제 막 언급한 요청-응답 사이클에 걸쳐 프로세스되었다. HTTP 캐시는 HTTP 응답을 되돌려줄 수 있는 모든 것을 했다.

그러나, 브라우저로 되돌려 줄 캐시된 HTTP 응답이 없었다. 그 시점에서 HTTP 캐시는 다른 선택이 없었다. 워드프레스에 HTTP 응답을 전달해야 했다.

워드프레스는 HTTP 요청을 HTTP 응답으로 변환하고 HTTP 캐시에 되돌려주어야 한다. 앞서 봤듯이 이것이 전체 모던 워드프레스 서버 스택의 주요 병목이다.

이 병목의 원인은 두 가지이다. 워드프레스가 수행할 PHP 코드가 많다. 이는 시간 소모적이며 더 느린 PHP가 수행할 때는 더 시간이 걸린다.

나머지 병목은 워드프레스가 수행하는 데 필요한 데이터베이스 쿼리다. 데이터베이스 쿼리는 비싼 작업이다. 더 많을수록 워드프레스는 더 느려진다. 쿼리-결과 사이클이 마지막 섹션의 초점이 될 것이다.

### Optimizing The PHP Runtime

PHP로 돌아가자. 이 순간, 워드프레스의 최소 요구 사항은 PHP5.2이다. 이 PHP 버전은 거의 10살이다!(PHP 팀은 2011년에 지원을 중단했다.)

PHP 팀이 그 수년 동안 한가하게 앉아있지 않았다. 수많은 성능 향상이 특히 최근 몇 년간 있었다. 오늘날 최적화를 위해 할 수 있는 일을 살펴보자.

#### Use the Latest Version of PHP

할 수 있는 가장 쉬운 방법은 PHP 버전을 업그레이드하는 것이다. 버전 5.4, 5.5, 5.6 모두 성능 향상을 보였다. 5.3에서 5.4가 가장 많은 향상이 있었다. 버전 업그레이드는 워드프레스의 성능을 상당히 증가시켰다.

#### Install Opcode Caching

Opcode 캐싱은 PHP를 빠르게 하는 또 다른 방법이다. [서버 사이드 스크립팅](https://en.wikipedia.org/wiki/Server-side_scripting) 언어로서, PHP는 큰 약점을 가지고 있다: 실행할 때마다 PHP 스크립트를 컴파일해야 한다.

이 문제에 대한 해결책은 컴파일된 PHP 코드를 캐싱하는 것이다. 그런 식으로, 실행할 때마다 PHP를 컴파일할 필요가 없다. 이것이 [opcode 캐시](https://php.net/manual/en/intro.opcache.php)가 하는 일이다.

PHP 5.5 이전에, PHP는 opcode 캐시를 번들로 제공하지 않았다. 서버에 직접 설치해야 한다. 이것이 PHP의 최신 버전을 사용해야 하는 또 다른 이유이다.

#### Switch to a Next-Generation Compiler

할 수 있는 마지막은 두 개의 차세대 컴파일러 중 하나로 전환하는 것이다: 페이스북의 [HHVM](http://hhvm.com/)이나 PHP의 최근 버전인 [PHP 7](http://php7.zend.com/). (왜 PHP 7일까? 긴 이야기이다.)

페이스북과 PHP 팀은 이 두 컴파일러를 바닥부터 완전히 새로 만들었다. 그들은 모던 컴파일 전략을 활용하고 싶어 했다. HHVM은 [just-in-time compilation](https://en.wikipedia.org/wiki/Just-in-time_compilation)을 사용하고, 반면 PHP 7은 [ahead-of-time compilation](https://en.wikipedia.org/wiki/Ahead-of-time_compilation)을 사용한다. 둘 다 PHP5를 뛰어넘는 [믿을 수 없는 성능 향상](https://wpengine.com/blog/php-7-the-way-of-the-future/)을 제공한다.

HHVM은 몇 년 전에 현장에 도착한 첫 번째다. 많은 최상위 호스트가 주요 PHP 컴파일러로 제공하고 많은 성공을 거두었다.

HHVM이 공식적인 PHP 컴파일러가 아니지만 강조할 가치가 있다. PHP와 100% 호환되는 것은 아니다. 그 이유는 HHVM이 PHP만 지원하도록 설계되지 않았기 때문이다; 그것은 페이스북의 [Hack](https://en.wikipedia.org/wiki/Hack_(programming_language)) 프로그래밍 언어를 위한 컴파일러이기도 하다.

PHP 7은 공식 PHP 컴파일러이다. PHP 팀은 [2015년 12월](http://php.net/archive/2015.php#id2015-12-03-1)에 그것을 출시했다. 몇몇 워드프레스 호스팅 회사가 미리 지원하는 것을 방해하지는 않았다.

좋은 소식은 워드프레스 자체는 두 컴파일러 모두와 100% 호환된다는 것이다. 나쁜 소식은 모든 플러그인과 테마가 호환되는 것은 아니다. 워드프레스의 최소 PHP 버전이 아직 5.2이기 때문이다.

제작자가 그들의 플러그인이나 테마가 이 컴파일러와 작동하도록 강제할 수 없다. 그래서 그중 하나로 완전히 가버릴 수는 없다. 여러분의 스택은 항상 PHP 5로 돌아와야 할 것이다.

### Query-Result Cycle

이 시점에서, PHP 런타임은 워드프레스 PHP 파일을 모두 통과하고 실행한다. 그러나, 이러한 워드프레스 PHP 파일은 데이터를 포함하지 않는다. 워드프레스 코드만 포함하고 있다.

문제는 워드프레스가 MySQL 데이터베이스에 모든 데이터를 저장한다는 것이다. 데이터를 얻으려면 PHP 런타임은 데이터베이스를 쿼리해야 한다. MySQL 서버는 쿼리 결과를 반환하고 PHP 런타임은 다시 데이터를 필요할 때까지 워드프레스 PHP 파일을 계속 실행해야 한다.

이러한 들락날락은 수십 번에서 수백 번까지 일어날 수 있다.(후자의 경우 개발자와 의논하고 싶을 것이다!) 주요 병목 현상인 이유이다.

### Optimizing The Query-Result Cycle

여기서 최적화 목표는 PHP에 의한 워드프레스 파일 실행 시간을 단축하는 것이다. 이것이 데이터베이스 쿼리가 문제가 되는 곳이다. (코드가 미쳐 날뛰는 일을 하지 않는다면) 순수한 PHP 코드를 실행하는 것보다 더 많은 시간이 걸리는 경향이 있다.

이 문제를 해결하는 명백한 방법은 워드프레스가 수행해야 하는 쿼리 수를 줄이는 것이다. 그리고 그것은 언제나 가치가 있다! 그러나, 모던 워드프레스 서버 스택이 도울 수 있는 것은 없다.

워드프레스가 만드는 쿼리 수를 줄이지 못할 수도 있다, 그러나 선택할 수 없는 것은 아니다. 스택이 쿼리-결과 사이클을 최적화하는 것을 돕는 두 가지 방법이 아직 있다. 첫 번째는 데이터베이스에 만들어지는 쿼리 수를 줄일 수 있다. 그리고 그 쿼리를 데이터베이스로 만들어 실행되는 시간을 줄일 수 있다.

이 두 옵션은 똑같은 일을 하기 위한 것이다: 데이터베이스로부터의 결과를 위해 PHP가 되도록 작게 기다리게 한다. 워드프레스 자체를 더 빠르게 할 것이다.

### Stack Elements For The Query-Result Cycle

쿼리-결과 사이클과 관련된 다른 스택 요소를 살펴보자. 스택의 이 부분은 덜 복잡하다. 그러나 하나 이상의 구성 요소와 관련되어 있다 - 즉, MySQL 데이터베이스 서버와 object 캐시.

#### MySQL Database Server Link

몇 년 전, MySQL 데이터베이스 서버는 모든 사람에게 같은 것을 의미했을 것이다. [MySQL](https://en.wikipedia.org/wiki/MySQL)이 설치된 서버였다. 그러나 최근 몇 년 동안 많은 것이 바뀌었다.

다양한 그룹이 [오라클](https://en.wikipedia.org/wiki/Oracle_Corporation)이 MySQL 프로젝트를 관리하는 방법에 대해 행복해하지 않았다. 그래서, 각 그룹은 그것을 포크했고 자체 버전을 만들었다. 그 결과로 이제 여러 MySQL 데이터베이스 서버가 있다.

새로운 "공식적인" MySQL 서버는 [MariaDB 서버](https://en.wikipedia.org/wiki/MariaDB)이다. MySQL 서버의 커뮤니티 개발 버전이다. 커뮤니티는 MySQL 서버 프로젝트와 완전한 호환성을 유지할 계획이다.

또 다른 인기 있는 MySQL 대안은 [Percona 서버](https://en.wikipedia.org/wiki/Percona_Server)이다. MariaDB와 달리, Percona는 MySQL의 브랜치 이상이다. 개발자가 MySQL 프로젝트 자체에 반하지 않는다; 그들은 MySQL의 성능 개선에 초점을 맞추길 원한다. MariaDB 팀은 나중에 MariaDB 프로젝트로 이러한 성능 향상의 일부를 합병했다.

결국, 여러분이 선호하는 것을 선택할 수 있다. Percona 서버와 MariaDB 서버 간의 성능 차이는 없다. 둘 다 MySQL 보다 성능이 뛰어나다. 그러나, Percona는 오라클 프로젝트와 더 가까운 호환성을 유지한다.

성능에 영향을 주는 것은 워드프레스 데이터베이스가 사용하는 [스토리지 엔진](https://en.wikipedia.org/wiki/Database_engine)이다. 스토리지 엔진은 데이터베이스 서버가 저장 데이터를 관리하는 방법을 제어한다. 데이터베이스 테이블마다 다른 스토리지 엔진을 설정할 수도 있고; 전체 데이터베이스를 위해 같은 하나를 사용할 필요도 없다.

데이터베이스 서버는 여러 스토리지 엔진을 보유한다. 모두 살펴보지는 않겠다. 두 개만이 흥미롭다: [InnoDB](https://en.wikipedia.org/wiki/InnoDB)와 [MyISAM](https://en.wikipedia.org/wiki/MyISAM).

기본적으로, 워드프레스는 기본 MySQL 데이터베이스 엔진을 사용한다. MySQL 5.5 이전에는 엔진이 MyISAM이었다. 작은 워드프레스 웹사이트를 돌린다면 MyISAM도 괜찮다. 웹사이트 크기가 증가하면 MyISAM은 성능이 문제가 된다. 그 시점에서 InnoDB는 데이터베이스 엔진을 위한 유일한 선택이다.

InnoDB의 유일한 문제는 최상으로 수행하기위해 약간의 튜닝이 필요한 것이다. 대규모 데이터베이스 서버를 실행한다면, 조정이 필요할 수도 있다. 다행히, 그것을 도와주는 툴이 있다.

[MySQLTuner](http://mysqltuner.com/)는 데이터베이스 서버를 분석하는 작은 스크립트이다. 보고서를 생성하고 튜닝 권장사항을 줄 것이다.

#### Object Cache

쿼리-결과 사이클을 최적화하는 작업의 주력은 [object cache](https://codex.wordpress.org/Class_Reference/WP_Object_Cache)이다. object 캐시 작업은 얻거나 생성하는 데 시간이 많이 소요되는 데이터를 저장하는 것이다. 추측할 수 있듯이, 데이터베이스 쿼리는 완벽한 후보이다.

워드프레스는 object 캐시를 많이 사용한다. 데이터베이스에서 옵션을 얻기 위해 [`get_option`](http://codex.wordpress.org/get_option)을 많이 사용한다고 가정해보자. 워드프레스는 한 번만 그 옵션에 대한 데이터베이스 쿼리를 할 것이다. 다른 누군가가 필요로 하는 그 다음번에는 다시 쿼리하지 않을 것이다.

그 대신에 워드프레스는 object 캐시로부터 쿼리 결과를 얻을 것이다. 이것이 워드프레스가 만드는 데이터베이스 쿼리를 줄이기 위해 사전에 하는 절차이다. 그러나 확실한 해결책은 아니다.

워드프레스가 object 캐시를 활용하기 위해 최선을 다하겠지만, 플러그인이나 테마는 그러지 않을 것이다. 플러그인과 테마가 많은 데이터베이스 쿼리를 만들고 결과를 캐시하지 않는다면 스택은 그것에 대해 할 수 있는 것이 없다.

그런 경우, 데이터베이스 쿼리의 대부분은 워드프레스 자체에서 올 것이다. 그래서, 워드프레스에 내장된 object 캐시로부터 훌륭한 마일리지를 얻을 것이다. object 캐시가 모던 워드프레스 서버 스택의 중요한 요소인 이유이다. 

object 캐시의 문제는 저장하는 데이터를 유지하지 않는 것이 디폴트인 것이다. PHP가 모든 워드프레스 파일을 실행하는 동안 메모리에 데이터를 저장하기만 한다. 그러나 PHP 프로세스가 종료하면, 메모리에 저장된 모든 데이터를 삭제한다.

이것은 전혀 이상적이지 않다. object 캐시는 오랜 시간 동안 유효하게 유지될 수 있으며, 하나의 요청에 제한하지 않는다. 해결책은 **영속 object 캐시를 사용**하는 것이다.

영속 object 캐시는 자주 플러그인 형태로 제공된다. 그 플러그인은 작업하기 위해 `object-cache.php` drop-in을 사용한다. 이 drop-in은 작성자가 object 캐시의 기본 행동을 변경하도록 한다.

플러그인은 영구 데이터 저장소에 object 캐시를 연결한다. 그것들은 기본 object 캐시의 반입과 저장 기능을 대신한다. 데이터를 메모리에 저장하고 가져오는 대신, object 캐시는 스토어에서 작업을 한다.

### Persistent Object Cache Plugins

요즘, 영속 object 캐싱을 위한 두 가지 인기 있는 데이터 스토어 옵션이 있다:

* [Memcached](https://en.wikipedia.org/wiki/Memcached) ([plugin](https://wordpress.org/plugins/memcached/))
* [Redis](https://en.wikipedia.org/wiki/Redis) ([plugin](https://wordpress.org/plugins/redis-cache/))

이 데이터 스토어는 모두 스토리지로 [RAM](https://en.wikipedia.org/wiki/Random-access_memory)을 사용하며, 정말 빠르게 만들어준다. 사실, 성능은 기본 object 캐시에 필적한다.

유일한 문제점은 서버에 사전 설치되지 않는 것이다. 그리고 둘 다 PHP 확장을 하지 않는다(Redis는 선택적이다). 대응하는 워드프레스 플러그인을 사용하기 전에 설치할 필요가 있다.

어느 것을 설치해야 할 것인가? 실제로 object 캐싱을 위한 둘 사이의 차이점은 많지 않다. 과거에 인기 있는 옵션은 Memcached이었다. 최근 몇 년간 변했다. Redis가 object 캐시를 위한 대단히 믿음직한 옵션을 만드는 기능을 많이 추가하였다.

### Getting Your Own Modern WordPress Server

그래서 자신의 서버를 어떻게 얻을 것인가? 확실한 방법은 최상위의 워드프레스 호스팅 회사에서 하나를 얻는 것이다. 이러한 회사들은 최신의 혁신과 기술을 채택하도록 동기부여하기 위해 워드프레스 호스팅 비즈니스의 최전선에 있기를 원한다.

그러나 은행 계좌를 깨지않고 얻길 원한다면? 직접 수행하고 호스팅 비용을 덜 지불하고 싶은 사람은 몇 개의 툴을 사용할 수 있다. 그것들을 살펴보자.

#### DebOps for WordPress Link

[DebOps for WordPress](https://github.com/carlalexander/debops-wordpress)는 내가 모던 워드프레스 서버를 만들기를 원하는 사람을 돕는 툴이다. 그 임무는 [커뮤니티의 모든 사람이 사용할 수 있는](https://carlalexander.ca/give-wordpress-an-apple-experience/) 모던 워드프레스 서버 스택을 만드는 것이다. 그것이 내가 가능한 한 사용하기 쉽게 만들려는 이유이다. 사용하기 위해 어떤 시스템 관리 지식이 필요하지 않다.

DebOps for WordPress는 다음과 같이 서버를 구성한다:

* HHVM (PHP 7이 공식 리눅스 저장소로 만들어지기 전까지)
* MariaDB
* nginx
* Redis
* Varnish

이 툴은 최신 기술로 서버를 설정하는 것 이상을 할 수 있다. 서버의 보안을 맡기도 한다. 사람들이 자신의 서버를 관리할 때 자주 관대히 넘어가는 것이다.

#### EasyEngine Link

[EasyEngine](https://easyengine.io/)은 서버에서 워드프레스 웹사이트를 설정하게 도와주도록 설계된 명령어 툴이다. EasyEngine의 훌륭한 점은 유연성이다: 지금까지 검토한 서버 기술의 거의 모든 조합을 설정할 수 있다.

예를 들어, 서버를 HHVM이나 PHP7으로 설정할 수 있다. 영속 데이터 스토어로 Memcached와 Redis에서 선택할 수 있다. [phpMyAdmin](http://www.phpmyadmin.net/)과 같은 관리자 툴도 설치할 수 있다.

워드프레스 웹사이트를 만들 때 많은 옵션을 제공하기도 한다. 플러그인을 사용하는 HTTP 캐시 혹은 nginx와 함께 하는 웹사이트를 설정하도록 할 수 있다. 이러한 유연성이 EayEngine이 아주 유명한 툴인 이유이다.

#### Trellis

[Trellis](https://roots.io/trellis/)는 [Roots](https://roots.io/)가 개발한 툴이다. DebOps와 마찬가지로 서버 기술의 특정한 세트로 서버를 설정한다:

* MariaDB
* Memcached
* nginx
* nginx HTTP cache (optional)
* PHP 7

Trellis에 대해 알아야 할 것은 Roots가 만든 또 다른 툴인 [Bedrock](https://roots.io/bedrock/)과의 관계이다. Bedrock는 "[Twelve-Factor App](http://12factor.net/)" 원칙을 표방하는 워드프레스 웹사이트를 구조화하는 보일러 플레이트이다.

Roots 팀은 Trellis가 Bedrock 구조의 워드프레스 웹사이트를 사용하는 서버를 설정할 수 있도록 만들었다. 일반적인 워드프레스 설치에서 사용할 수 없다는 것을 기억하라.

### Times Have Changed

봐왔듯이, 워드프레스 서버는 오늘날 많은 부분을 이동해왔다! 그러나 절망의 원인이 될 필요는 없다. 항상 이 모든 것이 필요하지는 않기 때문에 보이는 만큼 나쁘지는 않다.

그것이 이 글의 많은 부분이 각 부분이 서로 어떻게 작동하는가에 대해 논의하고 있는 이유다.  여러분의 의사결정을 도와줄 것이다. 어떤 부분을 언제 사용해야 하는지 결정하기 위해 이 지식을 사용하라. 여러분도 빠른 워드프레스 웹사이트를 가지게 될 것이다.
