---
layout: post
title: "궁극의 워드프레스 개발 환경 실전편 - VV Blueprints"
description: "The Ultimate WordPress Development Environment에서 Vagrant, VVV, VV, WP-Cli를 사용하여 개발에 필요한 가상머신을 쉽고 편하게 다루는 방법"
category: blog
tags: [wordpress, development, environment, vagrant, vvv, vv, blueprints]
---

## VV

[궁극의 워드프레스 개발 환경](http://nolboo.github.io/blog/2016/04/29/ultimate-wordpress-development-environment/)을 실제로 구현해보기 위해 [궁극의 워드프레스 개발 환경 실전편 - VV](http://nolboo.github.io/blog/2016/05/10/ultimate-wordpress-development-environment-vv/)에 이어서 VV의 기능을 살펴본다.

* [궁극의 워드프레스 개발 환경 실전편 - VV](http://nolboo.github.io/blog/2016/05/10/ultimate-wordpress-development-environment-vv/) 
* [궁극의 워드프레스 개발 환경 실전편 - VV Blueprints](http://nolboo.github.io/blog/2016/05/14/ultimate-wordpress-development-environment-vv-blueprints/)
* [궁극의 워드프레스 개발 환경 실전편 - WP-CLI](http://nolboo.kim/blog/2016/05/16/ultimate-wordpress-development-environment-wp-cli/)

### Blueprints

VV의 블루프린트에서 새로 만들 워드프레스 가상머신의 플러그인, 테마, 옵션, 위젯, 메뉴, 상수를 설정할 수 있다. VVV 디렉토리에 `vv-blueprints.json`을 처음 만들려면 `vv --blueprint-init` 명령을 사용한다. 이 파일을 편집하여 여러 개의 블루프린트를 설정한 후 필요할 때마다 불러서 워드프레스 가상머신을 만들 수 있다.

블루프린트 예제:

```json
{
  "sample": {
    "themes": [
      {
        "location": "automattic/_s",
        "activate": true
      }
    ],
    "mu_plugins": [
      {
        "location": "https://github.com/WebDevStudios/WDS-Required-Plugins.git"
      }
    ],
    "plugins": [
      {
        "location": "https://github.com/clef/wordpress/archive/master.zip",
        "version": null,
        "force": false,
        "activate": true,
        "activate_network": false
      },
      {
        "location": "cmb2",
        "version": "2.0.5",
        "force": false,
        "activate": true,
        "activate_network": false
      }
    ],
    "options": [
      "current_theme::_s"
    ],
    "widgets": [
      {
        "name": "meta",
        "location": "sidebar-1",
        "position": 1,
        "options": {
          "title": "Site login or logout"
        }
      },
      {
        "name": "text",
        "location": "sidebar-2",
        "position": 4,
        "options": {
          "title": "Hello world.",
          "text": "I'm a new widget."
        }
      }
    ],
    "menus": [
      {
        "name": "Example Menu",
        "locations": [
          "primary",
          "social"
        ],
        "items": [
          {
            "type": "post",
            "post_id": 2,
            "options": {
              "title": "Read the 'Sample Post'"
            }
          },
          {
            "type": "custom",
            "title": "Our Partner Site",
            "link": "//example.com/",
            "options": {
              "description": "Check out our partner's awesome website."
            }
          },
          {
            "type": "term",
            "taxonomy": "category",
            "term_id": 1,
            "options": {
              "title": "Example category"
            }
          }
        ]
      }
    ],
    "demo_content": [
      "link::https://raw.githubusercontent.com/manovotny/wptest/master/wptest.xml"
    ],
    "defines": [
      "WP_CACHE::false"
    ]
  }
}
```

테마와 플러그인, [mu-plugins](http://www.sitepoint.com/wordpress-mu-plugins/)을 지정하려면 다음 형식을 사용할 수 있다:

Github username/repo
Full git url
Url to zip file
WordPress.org slug

플러그인, 테마, 위젯, 메뉴의 옵션은 [WP-CLI](http://wp-cli.org/) 옵션과 같다.

옵션, 데모 콘텐츠, 상수는 키와 값 사이의 구분자로 `::`를 사용한다.

커스텀 데모 콘텐츠는 [이것](https://raw.githubusercontent.com/manovotny/wptest/master/wptest.xml)과 같이 xml code를 지정하는 링크만 사용해야 한다.

멀티 사이트 네트워크 설정은 network_options 배열을 사용해 설정한다.

* [Create A Network « WordPress Codex](https://codex.wordpress.org/Create_A_Network)
* [Multisite Network Administration « WordPress Codex](https://codex.wordpress.org/Multisite_Network_Administration)

'SITENAME', 'SITEDOMAIN'으로 실제 사이트 이름과 로컬 도메인을 지정할 수 있다.

#### 블루프린터로 새 워드프레스 사이트 만들기

`vv create` 후에 안내되는 마법사에서 입력해도 되지만, 다음 명령어 옵션으로 지정할 수 있다.

```shell
vv create -b {blueprint name}  // `vv-blueprints.json` 파일에서 blueprint 설정 이름
```

위의 예제 파일을 예로 든다면:

```shell
vv create -b sample
```



### 멀티 사이트 설정

멀티 사이트 네트워크 안에 각 서브 사이트를 설정할 수 있다. 예로, 멀티사이트 네트워크에서 특정 플러그인이나 테마가 전체 네트워크에 걸쳐 활성화하거나 특정 서브사이트에서만 활성화할 수 있다.

멀티 사이트를 지원하기 위해서는 특정 블루프린트에 다음과 같이 사이트 키를 추가한다:

```json
"sites": {
  "site2": {
    "plugins": [
      ...(same as above)...
    ]
  }
}
```

사이트 객체는 서브사이트 정의를 담고 있으며, 이는 일반적인 블루프린트와 정확히 같다. 또한, WP-CLI의 wp site create 명령을 위한 키를 포함할 수 있다. 예로, 관리자의 이메일이 `subsite2admin@localhost.dev`이고 robot.txt 예외이며, `subsite2`란 slug를 갖고 `Second Subsite`란 제목을 가진 사이트를 만들려면:

```json
"sites": {
  "subsite2": {
    "title": "Second Subsite",
    "email": "subsite2admin@localhost.dev"
  }
}
```

멀티사이트 네트워크가 서브도메인을 사용하면 `BLUEPRINT_NAME::subdomains`와 같은 블루프린트 레벨 키를 포함할 수 있다. `BLUEPRINT_NAME`은 블루프린트 이름과 일치해야 하며 그 값은 서브사이트 slug와 일치하는 서브도메인을 스페이스로 분리한 목록이다. 지금까지 설명한 서브도메인 기반의 멀티사이트 설정은 아래와 같다.

```json
{
  "sample": {
    "sample::subdomains": "site2 site3",
    "sites": {
      "site2": {
        "title": "Child Site (subsite2)",
        "plugins": [
          {
            "location": "buddypress",
            "activate": true
          }
        ]
      },
      "site3": {
        "title": "Private Child Site",
        "private": true,
        "email": "site2admin@local.dev",
        "themes": [
          {
            "location": "https://github.com/glocalcoop/anp-network-main-child/archive/master.zip",
            "activate": true
          }
        ]
      }
    },
    "themes": [
      {
        "location": "automattic/_s",
        "enable_network": true
      },
      {
        "location": "glocalcoop/anp-network-main-v2",
        "activate": true
      }
    ],
    "mu_plugins": [
      {
        "location": "https://github.com/WebDevStudios/WDS-Required-Plugins.git"
      }
    ],
    "plugins": [
      {
        "location": "https://github.com/clef/wordpress/archive/master.zip",
        "version": null,
        "force": false,
        "activate": true,
        "activate_network": false
      },
      {
        "location": "cmb2",
        "version": "2.0.5",
        "force": false,
        "activate": true,
        "activate_network": false
      },
    ],
    "demo_content": [
      "link::https://raw.githubusercontent.com/manovotny/wptest/master/wptest.xml"
    ],
    "defines": [
      "WP_CACHE::false"
    ]
  }
}
```

위 예에서 BuddyPress는 site2에만 활성화하였고, _s 테마는 전체 네트워크에서 가능하나 anp-network-main-v2는 네트워크 메인 사이트에서 활성화하였고, site3는 anp-network-main-child가 활성화되고, 고유의 admin 사용자가 있다.

이렇게 블루프린트를 사용할 때는 `--multisite` 서브도메인 옵션과 함께 vv를 실행해야 한다.

### Vagrant Proxy

vv는 VVV가 어디에 설치되어 있는지 알기 때문에 어디서든 vv를 실행할 수 있다. `vv vagrant <command>`으로 VVV 위치에 명령어를 넘길 수 있다. `vv vagrant halt`는 어디서 실행하든지 VVV vagrant를 중지한다.

매우 다양한 [vv 옵션](https://github.com/bradp/vv#vv-options), 
[vv 명령어](https://github.com/bradp/vv#commands), 
[vv 사이트 옵션](https://github.com/bradp/vv#options-for-site-creation)이 있으며, 사이트 삭제 옵션과 배포 옵션도 있다.

### vv Hooks

훅 시스템을 이용하여 vv를 확장할 수 있다. 즉, vv 프로세스 앞뒤로 자신의 코드를 실행하도록 훅 파일을 만들 수 있다.

vv 명령어에 `--show-hooks` 옵션을 붙이면 사용할 수 있는 훅의 리스트를 볼 수 있다.

```shell
vv list --show-hooks
[Hook] post_list_site_woocommerce
[Hook] pre_list_site_wordpress-default
[Hook] list_site wordpress-default
  * wordpress-default   ( local.wordpress.dev ) [VVV default]
[Hook] post_list_site_wordpress-default
[Hook] pre_list_site_wordpress-develop
[Hook] list_site wordpress-develop
  * wordpress-develop   ( src.wordpress-develop.dev ) [VVV default]
[Hook] post_list_site_wordpress-develop
[Hook] pre_list_site_wordpress-trunk
[Hook] list_site wordpress-trunk
  * wordpress-trunk     ( local.wordpress-trunk.dev ) [VVV default]
[Hook] post_list_site_wordpress-trunk
[Hook] pre_list_site_wpkr
[Hook] list_site wpkr
[Hook] list_custom_site wpkr
```

훅 코드를 위한 디렉토리는 VVV 폴더 밑에 `vv` 폴더를 만들면 된다. 이 폴더에 추가하려는 훅 이름을 가진 파일을 만들어 실행하려는 명령어를 추가한다. 이 파일은 실행할 수 있는 명령어들을 한 줄씩 나열한 것이다. 헬로를 출력하는 훅 파일은:

    #! /usr/bin/php
    echo 'Hello'

모든 새로운 사이트의 wp-content 안에서 npm install을 실행하려면,

`post_site_creation_finished`라는 파일을 만든다. 훅 이름, 사이트 폴더명, 사이트 도메인, VVV 경로의 4가지 변수를 넘겨받는다.

    #!/bin/bash
    cd www/"$2"/htdocs/wp-content || exit
    npm install

## 맺음말

VV 추가기능으로 vv deployment가 있으나 실제로 충분히 사용하지 못했기 때문에 이번 포스트에서는 생략한다. vv 프로세스가 편하기는 하나 기본적으로 하나씩 해보기에는 시간이 오래 걸리는 부분이 있으며, 개인적으로는 deployment는 git을 이용하는 다른 배치 시스템이 낫지 않을까 하는 막연한 생각이 든다. 아무튼 배치는 이것저것 해보고 포스트하기로 한다.

## 참고링크

* [bradp/vv: Variable VVV - a VVV Site Creation Wizard](https://github.com/bradp/vv#blueprints)
* [What are WordPress MU-Plugins?](http://www.sitepoint.com/wordpress-mu-plugins/)
* [vv-blueprints for woocommerce work at needmore](https://gist.github.com/brigleb/b2c2f288a9dba77d5a4d)
* [VV Blueprints](https://gist.github.com/Mte90/6420e68a61816ad3b42a)
