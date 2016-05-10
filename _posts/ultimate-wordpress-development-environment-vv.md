---
layout: post
title: "궁극의 워드프레스 개발 환경 - VV"
description: "The Ultimate WordPress Development Environment에서 Vagrant, VVV, VV, WP-Cli를 사용하여 개발에 필요한 가상머신을 쉽고 편하게 만드는 방법"
category: blog
tags: [wordpress, development, environment, vagrant, vvv, vv]
---



시간이 오래 걸리니 인터넷 속도가 좋은 곳에서 설치한다.

brew cask install virtualbox vagrant


box 파일은 VM을 만들기 위한 기본 OS 이미지를 포함한 VM 설정(CPU,메모리 사이즈등)에 대한 기본 템플릿이다.


현재 디렉토리에 `Vagrantfile`을 만들기 위해 다음 명령을 친다.

vagrant init

기존 프로젝트 디렉토리도 설정할 수도 있다.

하나의 박스로 여러 독립 가상머신에서 설치하여 사용할 수 있다.



### [bradp/vv: Variable VVV - a VVV Site Creation Wizard](https://github.com/bradp/vv#blueprints)