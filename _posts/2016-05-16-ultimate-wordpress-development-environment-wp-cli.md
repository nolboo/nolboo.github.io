---
layout: post
title: "궁극의 워드프레스 개발 환경 실전편 - WP-CLI"
description: "The Ultimate WordPress Development Environment에서 Vagrant, VVV, VV, WP-Cli를 사용하여 개발에 필요한 가상머신을 쉽고 편하게 다루는 방법"
category: blog
tags: [wordpress, development, environment, vagrant, wp-cli]
---

<div id="toc"><p class="toc_title">목차</p></div>

이 글은 [궁극의 워드프레스 개발 환경](http://nolboo.github.io/blog/2016/04/29/ultimate-wordpress-development-environment/)을 실전에서 사용해보는 시리즈 글 중의 하나입니다.

* [궁극의 워드프레스 개발 환경 실전편 - VV](http://nolboo.github.io/blog/2016/05/10/ultimate-wordpress-development-environment-vv/) 
* [궁극의 워드프레스 개발 환경 실전편 - VV Blueprints](http://nolboo.github.io/blog/2016/05/14/ultimate-wordpress-development-environment-vv-blueprints/)
* [궁극의 워드프레스 개발 환경 실전편 - WP-CLI](http://nolboo.kim/blog/2016/05/16/ultimate-wordpress-development-environment-wp-cli/)

## [WP-CLI](http://wp-cli.org/)

VVV가 설치되었다면 이미 설치되어있으니 설치과정은 참조만 한다.

```shell
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
```

다운로드 받은 파일이 제대로 동작하는지 확인한다:

```shell
php wp-cli.phar --info
```

간편하게 `wp` 명령어로 사용하기 위해 실행가능한 속성을 주고 `path` 경로로 옮긴다.

```shell
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp   // wp를 가장 많이 사용한다.
```

이제 `wp --info`명령을 내려 동작을 확인한다. 이때 워드프레스를 설치한 프로젝트 루트 디렉토리가 아니면 다음과 같은 에러가 난다.

```shell
wp -info
Error: This does not seem to be a WordPress install.
Pass --path=`path/to/wordpress` or run `wp core download`.
```

워드프레스 프로젝트 루트 디렉토리로 이동하거나 워드프레스를 설치한다. 워드프레스를 설치하려면:

```shell
wp core download
```

만약 버전 4.2.2 한글판을 다운로드하려면:

```shell
wp core download --version=4.2.2 --locale=ko_KR
```

다운로드가 끝난 후, 데이터베이스를 연결하기 위해 `wp-config.php` 파일을 만들다.

```shell
wp core config --dbname=databasename --dbuser=databaseuser --dbpass=databasepassword --dbhost=localhost --dbprefix=prfx_
```

이제 워드프레스를 설치한다.

```shell
wp core install --url=example.com  --title="WordPress Website Title" --admin_user=admin_user --admin_password=admin_password --admin_email="admin@example.com"
```

### 워드프레스 코어 업데이트

물론 업데이트하기 전에 백업을 생활화하는 것이 좋다.

```shell
wp db export backup.sql
```

이제 코어 업데이트를 한다.

```shell
wp core update
wp core update-db
```

업데이트 후에는 항상 버전을 체크한다.

```shell
wp core version
```

여러 개의 워드프레스를 업데이트하려면 아래와 같이 스크립트 파일을 만들어서 한방에 설치할 수 있다.

```shell
#!/bin/bash
declare -a sites=('/var/www/wp1' '/var/www/wp2' '/var/www/wp3')
for site in "${sites[@]}";
do
    wp --path=$site core update
done
```

### 플러그인

현재 플러그인 상태를 보려면:

```shell
wp plugin status
5 installed plugins:
 UA smooth-scroll-up        0.8.9
  I wordpress-beta-tester   1.0
  A wordpress-importer      0.6.1
  A wpcli-commands          1.0
```

여기서 I는 비활성화`Inactiveate`, A는 활성화`Activate`, U는 업데이트`Update`할 수 있다는 뜻이다.

자주 사용하는 플러그인 설치나 삭제, 활성화, 업데이트, 검색과 관련된 명령어는 다음과 같다.

```shell
wp plugin install wordpress-importer --activate
wp plugin deactivate wordpress-importer
wp plugin delete wordpress-importer
wp plugin update --all
wp plugin search import
```

만약 우커머스 플러그인을 설치하고 활성화하려면:

```shell
wp plugin install woocommerce
wp plugin activate woocommerce
```

`wp plugin install woocommerce --activate`와 같이 한번에 설치하고 활성화할 수도 있다.

### 테마

플러그인 명령어와 같아서 `plugin`을 `theme`으로 대치한다고 생각하면 된다. storefront 테마를 설치하고 활성화하려면:

```shell
wp theme install storefront --activate
```

주목할만한 명령어는 `scaffold`이다. 빈 child theme을 만드는 프로세스를 확 줄여준다.

```shell
wp scaffold child-theme my-child-theme --parent_theme=twentyfifteen --theme_name='My Child Theme' --author='Konstantinos Kouratoras' --author_uri=http://www.kouratoras.gr --theme_uri=http://wp.kouratoras.gr --activate
```

### 데이터 다루기

`post create`, `post edit`, `post delete`와 같은 단순한 명령어 말고도 WP-CLI는 포스트를 다루는 툴을 제공한다. 플러그인이나 테마 안의 코드를 테스트하기위해 많은 포스트가 필요하다면:

```shell
wp post generate --count=100
```

물론 빈 포스트이다.

현재 컨텐츠를 내보내거나 다른 워드프레스 설치본에 마이그레이션하려면 먼저 `wordpress-importer` 플러그인을 설치하고:

```shell
wp plugin install wordpress-importer --activate
```

데이타를 내보내서 원하는 설치본에서 임포트하면 된다.

```shell
wp export
wp import test.xml --authors=create
```

### 포스트 리비전

워드프레스는 기본적으로 포스트의 리비전을 데이터베이스에 저장한다.

리비전 데이터를 다루려면 [wp-revisions-cli](https://github.com/trepmal/wp-revisions-cli) 플러그인을 사용하면 된다. 일반적인 플러그인 설치와 같은 방법으로 설치하면 된다고 하지만 실제로는 zip파일 url만으로 설치할 수 있었다. `--activate` 옵션을 줄 때 에러가 나서 명령어로는 못했고, 관리자 모드에서 활성화했다. 다음과 같이 사용한다:

```shell
wp revisions list
wp revisions status
wp revisions clean 5
```

### 미디어

#### 벌크 이미지 가져오기

이미지가 `images_folder/`에 있다면:

```shell
wp media import images_folder/*
```

#### 미디어를 다시 제너레이트

개발 과정에서 새 이미지 사이즈로 변경할 때 섬네일 이미지를 다시 제너레이트할 수 있다.

```shell
wp media regenerate
```

타겟 이미지를 편집하기 위해 여러 명령어를 결합할 수 있다. 예를 들면, 특정 카테고리의 포스트에 특정 이미지를 다시 제너레이트하려면:

```shell
wp media regenerate $(wp eval 'foreach( get_posts(array("category" => 2,"fields" => "ids")) as $id ) { echo get_post_thumbnail_id($id). " "; }')
```

## 데이타베이스 작업

직접 데이터베이스를 작업할 수 있다. 예를 들면:

```shell
wp db query "SELECT id FROM wp_users;"
```

가져오기, 내보내기, 옵티마이징과 같은 데이터베이스 동작은 아래와 같다.

```shell
wp db export
wp db import backup.sql
wp db optimize
```

export 명령어는 데이터베이스 백업을 스케줄하기 위해 스크립트나 cron jon에서 사용할 수도 있다.

## Search And Replace 

로컬이나 개발 서버에서 웹사이트를 개발하다 다른 서버로 옮기는 것은 일반적인 일이다. 파일을 복사하고 데이터베이스를 마이그레이션하는 것은 쉽다. 데이터베이스 레코드에서 예전 URL을 새 것으로 바꾸는 일은 쉽지않다. URL이 serialized data로 저장되어 있기 때문이다. 일반적인 search and replace는 작동하지 않는다. WP-CLI는 이를 위해 `search-replace` 명령어가 있다.

```shell
wp search-replace 'dev.example.com' 'www.example.com'
```

WP-CLI는 JSON 데이터를 풀어서 replace 액션을 수행하고 데이터베이스 엔트리 안으로 데이터를 다시 패킹한다.

단지 데이터베이스에서 얼마나 많은 작업이 필요한지 알기위해 replace를 실행하지 않으려면 `--dry-run` 옵션을 이용한다.

```shell
wp search-replace --dry-run 'dev.example.com' 'www.example.com'
```

결과 화면이 다음과 비슷하다:

```shell
+---------------------+-----------------------+--------------+------+
| Table               | Column                | Replacements | Type |
+---------------------+-----------------------+--------------+------+
| wpcli_options       | option_value          | 2            | PHP  |
| wpcli_posts         | post_content          | 1            | SQL  |
| wpcli_posts         | guid                  | 28           | SQL  |
+---------------------+-----------------------+--------------+------+
```

## 멀티사이트

WP-CLI의 큰 강점은 스크립트를 이용하여 반복적인 작업을 자동화하는 것이다. 워드프레스 멀티사이트 네트워크일 경우에는 각 웹사이트의 대시보스에서 작업하는 것보다 명령어 스크립트로 간단히 작업할 수 있다. 워드프레스 멀티사이트에서 모든 사이트에 importer 플러그인을 설치하려면:

```shell
#!/bin/bash
for site in $(wp site list --field=url)
do
  wp plugin install wordpress-importer --url=$site --activate
done
```

파일로 만들기 싫다면 한줄 명령어로 실행할 수도 있다.

```shell
for site in $(wp site list --field=url); do wp plugin install wordpress-importer --url=$site --activate; done
```

## Using WP-CLI Remotely With SSH 

```shell
wp cli version
```

서버에 로그인할 필요없이 [WP-CLI SSH](https://github.com/xwp/wp-cli-ssh)를 이용하여 로컬에서 SSH를 통해 명령할 수 있다.

WP-CLI SSH를 설치하기 전에 `~/.wp-cli` 폴더 안에 WP-CLI 패키지 인덱스를 설정한다.

```shell
cd ~/.wp-cli    // 없으면 만든다.
```

컴포저를 설치해야 한다. 설치하지 않았다면:

```shell
curl -sS 'https://getcomposer.org/installer' | php
```

`composer.json` 파일을 만들고:

```json
php composer.phar init --stability dev --no-interaction
php composer.phar config bin-dir bin
php composer.phar config vendor-dir vendor
```

WP-CLI 패키지 인덱스를 추가한다:

```shell
php composer.phar config repositories.wp-cli composer 'http://wp-cli.org/package-index/'
```

`config.yml` 파일을 만들고 다음을 추가한다:

```yaml
require:
    - vendor/autoload.php
```

WP-CLI SSH 설치를 위한 준비가 끝났다.

```shell
php composer.phar global require x-team/wp-cli-ssh dev-master
```

설정 파일을 만들고 호스트를 설정한다. `wp-cli.yml` 파일을 만들고 다음 설정을 추가한다.

```yaml
ssh:

  production:
    # The %pseudotty% placeholder gets replaced with -t or -T depending on whether you're piping output
    # The %cmd% placeholder is replaced with the originally invoked WP-CLI command
    cmd: ssh %pseudotty% production.example.com %cmd%

    # Passed to WP-CLI on the remote server via --url
    url: production.example.com

    # We cd to this path on the remote server before running WP-CLI
    path: /var/www/production

    # WP-CLI over SSH will stop if one of these is provided
    disabled_commands:
      - db drop
      - db reset
```

`production.example.com`을 자신의 서버 URL로, `/var/www/production`는 자신의 워드프레스 설치 경로로 각각 대신한다. `disabled commands` 섹션에는 원격 서버에서 허용되지 않는 WP-CLI 명령어를 설정한다. 다른 이름을 갖는 호스트를 원하는 만큼 만들 수 있다.

정확하게 설정하였다면, `ssh` 서브 명령어를 `--host` 옵션과 함께 사용할 수 있다.

```shell
wp ssh plugin status --host=production
```

원격 서버에서 주로 작업한다면 `~/.bash_profile`에 알리아스를 추가하여, `wp` 명령어가 해당 호스트를 디폴트로 원격 작업하도록 할 수 있다:

```shell
alias wp="wp ssh --host=production"
```

## 참고링크

- [Configuration - WP-CLI](http://wp-cli.org/config/)
- [Built-in Commands - WP-CLI](http://wp-cli.org/commands/)
- [Advanced WordPress Management With WP-CLI – Smashing Magazine](https://www.smashingmagazine.com/2015/09/wordpress-management-with-wp-cli/)****
- [Automated WordPress Installation With Bash & WP CLI](https://www.ltconsulting.co.uk/automated-wordpress-installation-with-bash-wp-cli/)
    + [joshsmith01/wp-install-script: Install WordPress and a customized version of FoundationPress for developing locally.](https://github.com/joshsmith01/wp-install-script)
    + [elimc/jumpstart-install-script: Simple bash script to automate installation of WordPress with jumpstart and some of my favorite settings.](https://github.com/elimc/jumpstart-install-script)
    + [Local WordPress Development With Laravel Valet - YouTube](https://www.youtube.com/watch?v=Ai-HogVDxq4&feature=youtu.be)
- [How to Fix the Error Establishing a Database Connection in WordPress](http://www.wpbeginner.com/wp-tutorials/how-to-fix-the-error-establishing-a-database-connection-in-wordpress/)