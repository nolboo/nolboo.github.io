---
layout: post
title: "Composer와 워드프레스 개발 관리"
description: "가장 유명한 PHP 의존성 관리자 Composer로 워드프레스를 설치하고 개발환경을 설정하는 방법"
category: blog
tags: [wordpress, composer, stater, development, environment]
---

워드프레스는 PHP로 만들어진 가장 인기 있는 CMS이다. 2016년 6월 기준으로 전체 웹페이지의 26.4%를 차지하고 있으며, CMS 마켓 쉐어는 59.5%이다.([출처](https://w3techs.com/technologies/overview/content_management/all)) .kr로 끝나는 도메인에서도 55%를 차자하고 있다고 한다. 2위는 XpressEngine, 3위는 KimsQ이다. 그누보드는 어디로 간걸까?([출처](https://w3techs.com/technologies/segmentation/tld-kr-/content_management))

워드프레스가 일반적으로 많은 인기가 있는 이유는 워드프레스의 구조가 표준을 충실하게 따르고 있고, 생태계가 방대하다. 일반적인 스태틱 사이트보다는 무거울 수밖에 없고 기본적으로 데이터베이스를 사용하기 때문에 컨텐츠를 많이 다루는 웹 사이트나 커머스 사이트에서는 좋은 선택일 수 있다. 생태계가 방대하다는 것은 주로 테마와 플러그인이 엄청나게 많다는 것을 뜻한다. 자신의 컨텐츠를 보여줄 수 있는 방법이 많다는 것이다. 일반적으로 관리자 메뉴에서 이러한 테마와 플러그인을 다루지만 기본적으로 사용되는 필수 테마와 플러그인을 매번 관리자 메뉴에서 추가하는 것은 워드프레스를 많이 다룰 경우 귀찮은 일이다. 커맨드 라인에서 직접 설치하는 것이 훌륭한 대안인데, [앞에서 다룬 WP-CLI](http://nolboo.kim/blog/2016/05/16/ultimate-wordpress-development-environment-wp-cli/)에 이어 PHP 의존성 관리자인 컴포저를 이용하는 방법을 알아본다.

## 컴포저

[Composer](https://getcomposer.org/)는 PHP에서 의존성을 관리하기 위한 툴이다. 컴포저로 프로젝트를 위한 라이브러리들을 선언하고 의존성이 있는 라이브러리들을 설치할 수 있다. node.js의 npm과 ruby의 bundler에서 영감을 받았지만, 컴포저는 패키지 관리자가 아닙니다. 패키지 또는 라이브러리를 처리하긴 하지만 **프로젝트 단위로** 디렉터리에 설치합니다. 기본적으로 글로벌로 설치하지 않는다. PHP 5.3.2+ 이상에서 동작한다.

* [컴포저 한국어 매뉴얼](https://xpressengine.github.io/Composer-korean-docs/)

### 컴포저 설치

컴포저 설치는 [Introduction - Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)나 [소개하기](http://xpressengine.github.io/Composer-korean-docs/doc/00-intro.md/)를 참조하여 설치할 수 있으며, 맥에서는 간단한 명령으로 글로벌하게 설치할 수 있다:

```shell
$ brew install composer
```

* [Composer - 생활코딩](https://opentutorials.org/course/62/5221)

### 컴포저를 이용한 이점

컴포저를 이용한 워드프레스 설치와 관리는 다음과 같은 이점이 있다.

* 의존성을 한 곳에서 관리할 수 있다.
* 설치와 업그레이드를 툴을 이용하여서 할 수 있다.
* 프로젝트를 특정 버전으로 유지할 수 있다.
* 서드파티 코드를 VCS에 포함할 필요가 없다.

위와 같은 이점을 얻기 위해서는 `composer.json`과 `composer.lock` 파일을 VCS에 포함하고, `vendor/`를 `.gitignore`에 추가하여야 한다. 이제 프로젝트를 셋업하려면 `git clone`하고 `composer install`만 실행하면 언제든지 같은 프로젝트가 만들어진다.

최근에는 워드프레스 코어 파일을 프로젝트 루트가 아닌 `wp/`와 같은 서브 디렉터리에 설치하고, 필수 파일만 루트에 남기는 프로젝트 구조를 선호한다. 예를 들면:

```shell
wp-content
index.php
wp
wp-config.php
```

워드프레스는 `composer.json` 파일을 갖지 않기 때문에 아직 컴포저 패키지가 아니다. 추가하려는 [논의](http://core.trac.wordpress.org/ticket/23912)만 오랫동안 있었다.

## 워드프레스 설치

>**컴포저는 `composer.json`에 의존성을 선언하고 `./vendor/`디렉터리에 선언된 패키지나 라이브러리를 설치하고 `composer.lock`에 설치된 의존성을 기록한다.**

먼저 `composer.json` 파일을 만들고 다음을 입력한다:

```json
{
  "require": {
    "php": ">=5.4",
    "johnpbloch/wordpress": "4.2"
  },
  "extra": {
    "wordpress-install-dir": "wp"
  }
}
```

이제 워드프레스를 설치하기 위해 `composer install`을 하면 다음과 같은 내용이 만들어진다.

```shell
$ ls
composer.json composer.lock vendor        wp
```

`composer.lock` 파일이 추가로 만들어지고, `vendor/`에 패키지들이 설치되고, `wp/`에 워드프레스 코어 파일이 설치된 것을 확인한다.

`install` 명령어는 현재 디렉터리에 있는 `composer.json` 파일을 읽고, 의존성을 해석하여, `vendor/`에 패키지들을 설치한다. 현재 디렉터리에 `composer.lock` 파일이 없다면, 컴포저는 의존성을 해석한 후 패키지를 설치하고 새롭게 `composer.lock` 파일을 만든다. 그러나, `composer.lock` 파일이 있으면, 의존성을 해석하는 대신 - composer.json에 관계없이 - `composer.lock`에 있는 것과 일치하는 버전을 사용하여 패키지를 설치한다. 이것은 라이브러리를 사용하는 사람들이 같은 의존성 버전을 갖는다.

워드프레스를 최신 버전으로 업데이트하려면 아래와 같이 `^` 문자를 추가하고: 

```json
{
  "require": {
    "php": ">=5.4",
    "johnpbloch/wordpress": "^4.2"  // ^을 추가한다.
  },
  "extra": {
    "wordpress-install-dir": "wp"
  }
}
```

`composer update` 명령을 준다:

```shell
$ composer update
Loading composer repositories with package information
Updating dependencies (including require-dev)
  - Removing johnpbloch/wordpress (4.2)
  - Installing johnpbloch/wordpress (4.5.2)
    Loading from cache

Writing lock file
Generating autoload files
```

`johnpbloch/wordpress`를 4.2에서 4.5.2로 업데이트하고 설치된 패키지의 정확한 버전을 `composer.lock` 파일에 기록한다. 직접 버전 숫자를 지정하여 특정 버전을 설치할 수도 있다. 이렇게 패키지들의 최신 버전을 내려받고, `composer.lock` 파일을 업데이트하려면 `update` 명령어를 사용한다.

### composer.json

위에서 사용한 `composer.json`에 대해 자세히 설명한다.

require는 패키지 이름(e.g. johnpbloch/wordpress)과 패키지 버전 (e.g. ^4.2)의 맵핑 형태로 된 객체들로 선언한다. 패키지 이름은 벤더의 이름과 프로젝트의 이름으로 되어있으며, 벤더 이름을 먼저 선언하여 같은 패키지 이름이라도 구별될 수 있도록 한다. 버전에서는 `~`와 `^`의 차이점을 주목한다. `~`의 경우 다음 마이너 버전 전까지의 최신 업그레이드를 말하고, `^`는 다음 메이저 버전 전까지의 최신 업그레이드를 말한다. 자세한 설명은 [Semver: Tilde and Caret](https://nodesource.com/blog/semver-tilde-and-caret/)를 참조한다.

워드프레스는 컴포저 패키지가 아니지만, 다행히 컴포저로 추가할 수 있는 가장 인기 있는 워드프레스 포크 패키지인 [johnpbloch/wordpress](https://github.com/johnpbloch/wordpress)를 이용하는 방법이 있다. [WordPress Git 저장소](https://github.com/WordPress/WordPress)와 같이 워드프레스 공식 저장소와 15분마다 동기화하므로 거의(?) 최신 버전의 워드프레스를 설치할 수 있다.

워드프레스를 설치하기 위해서는 [johnpbloch/wordpress-core-installer](https://github.com/johnpbloch/wordpress-core-installer)가 필요하다. composer는 오직 `vendor/`에만 패키지를 설치한다. `johnpbloch/wordpress-core-installer`를 이용하여 설치 디렉토리를 `wp/`로 변경할 수 있다:

```json
"extra": {
  "wordpress-install-dir": "wp"
}
```

> `extra`는 scripts에서 사용하기 위한 임의의 데이터이다.

별도로 지정하지 않으면 `wordpress` 디렉토리에 설치된다.

## WordPress Packagist를 이용한 플러그인과 테마 설치

컴포저가 기본적으로 사용하는 PHP 패키지 저장소는 [Packagist](https://packagist.org/)이며, 워드프레스 관련된 미러링 저장소는 [WordPress Packagist](https://wpackagist.org/)이다. [WordPress Packagist](https://wpackagist.org/)는 기본적으로 모든 [워드프레스 공식 플러그인과 테마](https://wordpress.org)를 미러링 한다.

`composer.json`에 저장소 정보를 추가하고, 벤더 이름을 `wpackagist-plugin`나 `wpackagist-theme`으로 하여 원하는 테마와 플러그인 정보를 적은 후 `composer update`를 실행하면 `wp-content/plugins/`나 `wp-content/themes/`에 설치된다.

위의 json 파일에서 Woocommerce 플러그인과 StoreFront 테마를 추가로 설치하고 싶다면 wpackagist에서 검색한 후 벤더/프로젝트와 버전을 `composer.json`에 추가한다.

![우커머스 검색](https://c3.staticflickr.com/8/7109/27608412866_b2586545e1_c.jpg)

```json
{
  "repositories": [
    {
      "type": "composer",
      "url": "https://wpackagist.org"
    }
  ],
  "require": {
    "php": ">=5.4",
    "johnpbloch/wordpress": "^4.2",
    "wpackagist-plugin/woocommerce": "~2.6.0",
    "wpackagist-theme/storefront": "~2.0.3"
  },
  "extra": {
    "installer-paths": {
      "wp/wp-content/mu-plugins/{$name}/": ["type:wordpress-muplugin"],
      "wp/wp-content/plugins/{$name}/": ["type:wordpress-plugin"],
      "wp/wp-content/themes/{$name}/": ["type:wordpress-theme"]
    },
    "wordpress-install-dir": "wp"
  }
}
```

컴포저는 [composer/installers](https://github.com/composer/installers)를 이용하여 워드프레스 플러그인과 테마를 설치한다. 기본적으로 다음과 같은 타입에 대한 설치 디렉터리가 내장되어 있다.

* wordpress-plugin => wp-content/plugins/{$name}/
* wordpress-theme => wp-content/themes/{$name}/
* wordpress-muplugin => wp-content/mu-plugins/{$name}/

```shell
$ composer update
Loading composer repositories with package information
Updating dependencies (including require-dev)
  - Installing composer/installers (v1.0.25)
    Loading from cache

  - Installing wpackagist-plugin/woocommerce (2.5.5)
    Loading from cache

  - Installing wpackagist-theme/storefront (2.0.4)
    Loading from cache

Writing lock file
Generating autoload files
```

`wp-content/`에 테마와 플러그인이 설치된다. `wp/wp-content/`에 설치하고 싶다면 다음과 같이 `installer-paths`를 추가할 수 있다:

```json
  "extra": {
    "installer-paths": {
      "wp/wp-content/mu-plugins/{$name}/": ["type:wordpress-muplugin"],
      "wp/wp-content/plugins/{$name}/": ["type:wordpress-plugin"],
      "wp/wp-content/themes/{$name}/": ["type:wordpress-theme"]
    },
    "wordpress-install-dir": "wp"
  }
```

## 프로젝트 구조

앞서 말한 프로젝트 구조를 만들기 위해서는 추가적인 작업이 필요하다. 먼저 `wp/`의 `index.php`, `.htaccess` 와 `wp-config.php` 파일을 프로젝트 루트로 복사한다.

```shell
$ cp wp/wp-config-sample.php wp-config.php
$ cp wp/index.php .
```

[WordPress Codex 문서](http://codex.wordpress.org/Giving_WordPress_Its_Own_Directory)를 참조하여 `index.php`, `.htaccess`와 `wp-config.php`을 프로젝트에 맞게 설정하면 된다.

이후의 과정에는 일반적인 워드프레스 실행과 같다.

## 기타 컴포저 명령어

`composer` 또는 `composer list`를 입력하여 전체 명령어 목록을 확인한 다음에, 각 명령어 뒤에 --help를 붙이면 추가적인 정보를 확인 수 있습니다.

`composer.json`을 직접 편집하지 않고도 플러그인이나 테마를 명령어에서 제거하고 추가할 수 있다. storefront 테마를 제거하려면:

```shell
$ composer remove wpackagist-theme/storefront
```

다시 설치하려면:

```shell
$ composer require wpackagist-theme/storefront
```

`composer.json`의 설정도 컴포저가 변경한다.

`composer update johnpbloch/wordpress`와 같이 하나의 패키지만 업데이트할 수도 있다.

`search` 명령어는 현재 프로젝트의 저장소를 검색할 수 있다. 기본적으로 저장소는 패키지스트로 설정되어 있다. 여러개의 단어를 사용하여 패키지들을 찾을 수도 있다.

`composer config --list`으로 현재 컴포저 환경 설정을 볼 수 있다. 

`composer self-update`로 컴포저 자신을 업그레이드할 수 있다.

### create-project 옵션

`create-project` 옵션은 강력하다. 기존 패키지에서 새로운 프로젝트를 만들 수 있다. 버전을 지정하지 않으면 최신 버전으로 설치된다.

```shell
$ composer create-project roots/bedrock <path>
```

해당 프로젝트(여기서는 Roots의 Bedrock)를 `git clone`하고 `composer install`하는 것을 하나의 명령어로 실행할 수 있다.

## 참고 링크

* [Using Composer with WordPress](https://roots.io/using-composer-with-wordpress/)
* [WordPress Plugins with Composer](https://roots.io/wordpress-plugins-with-composer/) : 자신의 만든 커스텀 플러그인이나 3rd 파티 플러그인을 컴포저로 설치하는 방법
* [Install and manage WordPress with Composer](https://davidwinter.me/install-and-manage-wordpress-with-composer/)
* [WordPress plugin management with Composer - the Why and How](http://publishing-tech.schibsted.se/2014/05/20/WordPress-plugin-management-with-composer-the-why-and-how/)
* [Bedrock 1.1.1 Updates](https://roots.io/bedrock-1-1-1-updates/)