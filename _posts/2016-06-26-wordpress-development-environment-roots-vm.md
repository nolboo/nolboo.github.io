---
layout: post
title: "워드프레스 DevOps를 위한 Roots Suite의 Trellis, Bedrock, Sage 로컬 VM 설치"
description: "워드프레스 DevOps를 위한 Roots Suite를 이용하여 로컬 VM을 설치한다."
category: blog
tags: [wordpress, devops, development, environment, roots, trellis, bedrock, sage, vagrant]
---

## 로컬 개발 환경

[워드프레스 DevOps를 위한 Roots Suite의 Trellis, Bedrock, Sage 설치](http://nolboo.kim/blog/2016/06/23/wordpress-development-environment-roots-install/)에서 소개한 방법 중 `example.com`으로 설치한 방법을 채택하여 `roots.nolboo.kim`란 도메인을 기준으로 상세한 설정과 설치를 진행한다.

Trellis는 "sites"를 중심으로 만들어졌다. 트렐리스가 관리하는 서버(로컬 개발 머신이나 원격 서버)는 하나 또는 그 이상의 워드프레스 사이트를 지원할 수 있다. 트렐리스는 워드프레스 사이트를 호스트할 때 필요한 모든 것(데이타베이스, Nginx vhost, 폴더 디렉터리 등)을 자동으로 설정한다.

일반적인 설정은 `group_vars/development/wordpress_sites.yml`에서 패스워드/보안 설정은 `group_vars/development/vault.yml`에서 할 수 있다.

첫 key인 사이트 이름을 여러 변수의 기본 값으로 사용하기 때문에 도메인명을 사용하는 것이 좋다. 여기서는 `example.com` 대신 `roots.nolboo.kim`을 사용한다.

```yaml
# group_vars/development/wordpress_sites.yml
wordpress_sites:
  roots.nolboo.kim:
    site_hosts:
      - roots.nolboo.app
    local_path: ../site # 로컬 Bedrock 사이트 폴더를 Ansible 루트에 대한 상대적인 경로로 적어야 하며, 필수 항목이다.
    admin_email: nolboo.kim@gmail.com
    multisite:
      enabled: false
    ssl:
      enabled: false
    cache:
      enabled: false
```

공식문서에서 관행적으로 `roots.nolboo.dev`와 같은 url명을 주었지만, 여기서는 VVV와 구별하기 위해 `roots.nolboo.app`와 같이 app을 지정한다. 간단히 `nolboo.app`과 같은 이름을 주어도 되며, 사실 도메인 형식의 어떤 이름을 주어도 상관없다.

`group_vars/development/vault.yml`는 다음과 같다.

```yaml
#  group_vars/development/vault.yml
vault_wordpress_sites:
  roots.nolboo.kim:
    admin_password: admin
    env:
      db_password: example_dbpassword
```

`wordpress_sites`와 `vault_wordpress_sites`의 사이트 키가 `roots.nolboo.kim`로 같아야 한다. 나머지는 로컬 개발 머신이므로 그냥 디폴트값으로 놔둔다.(자신만의 것으로 변경해도 좋다)

[공식 문서](https://roots.io/trellis/docs/wordpress-sites/)에 설정할 수 있는 다양한 옵션이 있다.

설정파일을 편집하고난 다음에 `vagrant up` 명령으로 가상 머신을 만든다. 브라우저에서 `roots.nolboo.app`으로 접근한다. 관리자 모드는 `http://roots.nolboo.app/wp/wp-admin/`로 접근할 수 있다. 시간대/날자와 한글판 사이트로 변경한다.

>만약, `.app`의 호스트명을 변경하면 `vagrant hostmanager` 명령으로 `/etc/hosts` 파일에 반영하여야 한다. `vagrant up --provision` 명령으로 가상머신을 다시 provision해야 한다.

`vagrant ssh` 명령으로 가상머신에 접속할 수 있다. 실제 사이트는 `/srv/www/roots.nolboo.kim`로 접근할 수 있다. 로컬 프로젝트 폴더명과는 상관없이 사이트 키로 서버 폴더를 만든 것을 알 수 있다.

## 플러그인과 테마 설치

이제 자신의 플러그인과 테마를 설치한다. 여기서는 우커머스 플러그인과 스토어프론트 테마를 컴포저로 설치한다.

### WooCommerce와 StoreFront 설치

`site/` 디렉터리에서 컴포저를 이용하여 설치한다:

```shell
composer require wpackagist-plugin/woocommerce wpackagist-theme/storefront
```

위의 명령어를 풀어서 설명하고 순서대로 실행하면 다음과 같다: 

`site/composer.json`에 버전과 함께 입력한다.

```json
  "require": {
    "php": ">=5.5",
    "composer/installers": "~1.0.12",
    "vlucas/phpdotenv": "^2.0.1",
    "johnpbloch/wordpress": "4.5.2",
    "oscarotero/env": "^1.0",
    "roots/wp-password-bcrypt": "1.0.0",
    "wpackagist-plugin/woocommerce": "^2.5.5",
    "wpackagist-theme/storefront": "^2.0.3"
  },
```

추가하기를 원하는 워드프레스 플러그인과 테마를 미러링 사이트인 [http://wpackagist.org](http://wpackagist.org)에서 검색하여 추가한다.

플러그인과 테마를 설치하고 `composer.lock` 파일에 추가한다:

```shell
composer update
```

컴포저로 워드프레스 플러그인과 테마를 관리하는 보다 자세한 방법은 아래 포스팅에 별도로 정리하였다.

* [Composer와 워드프레스 개발 관리](http://nolboo.kim/blog/2016/06/19/wordpress-composer/)

### StoreFront 자식 테마와 Sage 개발 환경

[워드프레스 공식 문서](https://codex.wordpress.org/ko:Child_Themes)에서는 
StoreFront 테마가 업데이트될 때 덮어씌워지기 때문에 Child Theme을 이용하여 원하는 코드를 추가하거나 변경할 것을 권한다.

자식테마 디렉터리를 직접 만들어도 되지만, 미리 만들어진 빈 자식테마인 [stuartduff/storefront-child-theme](https://github.com/stuartduff/storefront-child-theme)를 `themes` 디렉토리에 클론한다.

```shell
git clone https://github.com/stuartduff/storefront-child-theme.git
```

`site/config/application.php`에서 `define('WP_DEFAULT_THEME', 'storefront-child-theme');`을 추가하여 디폴트 테마로 지정한다.

Sage와 같은 현대적인 프론트엔드 개발환경을 갖추기 위해 설정파일들을 복사하고 패키지를 설치한다.

```shell
cd storefront-child-theme
cp ../sage/package.json .
cp ../sage/bower.json .
cp ../sage/gulpfile.js .
cp ../sage/assets/manifest.json assets/
npm install && bower install && gulp
```

BrowserSync를 사용하려면 `assets/manifest.json`의 `devUrl`의 값을 편집한다.

```json
  "config": {
    "devUrl": "http://roots.nolboo.app"
  }
```

>보다 자세한 내용은 번역글 [Sage를 사용하여 워드프레스 테마 개발을 현대화하기](http://nolboo.kim/blog/2016/05/19/modernizing-wordpress-theme-development-with-sage/)을 참조한다.

`roots.nolboo.app`에서 로컬 VM에 설치가 잘 되었는지 체크한다.

`roots.nolboo.app/wp/wp-admin` 관리자 모드에서 우커머스 플러그인을 활성화하고 위저드를 실행한다.

>#### 우커머스 한글

>우커머스 한글 파일은 [여기](https://translate.wordpress.org/projects/wp-plugins/woocommerce/stable/ko/default)에서, 관리자용 한글 파일은 [비공식](http://martian36.tistory.com/1268)으로 얻을 수 있다.

이제 `storefront-child-theme` 디렉토리에서 `gulp watch`를 실행하면 자동으로 `localhost:3000`을 띄워준다.

에디터에서 코드를 편집한 후 실시간으로 반영되는지를 테스트한다.

`sage/.gitignore`를 참고하거나 [gitignore.io](https://github.com/joeblau/gitignore.io)를 이용하여 자신의 `.gitignore` 파일을 작성한 후 깃 저장소로 첫번째 푸시를 한다. 깃에 대한 지식이 전혀 없다면 [완전 초보를 위한 깃허브](http://nolboo.kim/blog/2013/10/06/github-for-beginner/)를 참조한다.

## TODO

* [Using WooCommerce with Sage](https://roots.io/using-woocommerce-with-sage/)
* [impressa/woopress](https://packagist.org/packages/impressa/woopress)
