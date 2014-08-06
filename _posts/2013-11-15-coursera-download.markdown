---
layout: post
title: "코세라 온라인 강의 자료를 로컬 디스크에 다운로드 받기"
description: "자신이 수강한 코세라 코스의 비디오, pdf, 웹페이지 등을 모두 로컬 디스크에 저장하여 수강 종료 후에도 언제든지 재열람할 수 있는 간단한 방법"
category: blog
tags: [coursera, download, python, script]
---

<div id="toc"><p class="toc_title">목차</p></div>

몇 달전 코세라에서 스타트업 엔지니어링이란 온라인 강의를 들었을 때 강의가 무척이나 유익하다는 생각이 들었고, 그 이후 처음 여러 개의 온라인 강의를 신청하였다. 그러나, 스타트업 엔지니어링을 수강할 때와는 달리 혼자서 진행하였고, 일들이 갑자기 많아져서 강의를 제대로 듣지를 못했다.

오늘 존스 홉킨즈 대학의 Computing for Data Analysis 강좌가 내일부턴 온라인 접근을 할 수 없다고 공지를 받았다. 제대로 듣질 못해서 아쉬운 마음에 예전에 사용했던 [파이썬 스크립트][1]를 이용해서 로컬에 저장해두려고 하였으나 매버릭스 업데이트 때문에 제대로 동작하지 않았다. 검색을 해서 해결책을 찾아 다운로드할 수 있었다. 다시 검색하는 시간을 들이지 않기 위해(?) 블로그에 적어둔다.

## 설치

파이썬 패키지 관리자인 `pip`를 먼저 설치해야 한다. [pip 설치][2]를 참조하여 재설치하였지만 제대로 동작하지 않아서 스택오버플로우에서 [OS X 10.8 업그레이드][3]를 참조하여 pip를 재설치한다. 맥에서 설치가 되지 않으면 명령어 제일 앞에 `sudo`를 붙여주면 대부분 잘 설치된다.

    sudo pip install coursera-dl

재설치가 되면 이제 코스의 모든 데이타를 다운로드할 차례이다.

## 다운로드

잘 설치되었는지 확인할 겸 도움말을 한번 보자.


    coursera-dl -h


일반적인 사용법은 아래와 같다.


    coursera-dl -u myusername -p mypassword -d destination coursename


`-u` 다음의 `myusername` 대신 자신의 코세라 계정(이메일)을 입력하여야 하고, `-p` 다음의 `mypassword` 대신 자신의 비밀번호를 입력해야 한다. `-d` 다음의 `destination` 대신 코스데이타를 다운로드할 디렉토리를 입력하고 `coursename`은 코세라의 해당 강좌명을 입력한다. 조금 복잡해 보이면 아래과 같이 먼저 다운로드할 디렉토리를 만든 다음 다운로드하도록 한다. 여기서는 Startup Engineering을 예로 든다:


    mkdir startup-engineering // 다운로드 디렉토리를 만든다.
    cd startup-engineering // 디렉토리를 옮긴다.
    coursera-dl -u myusername -p mypassword -d . startup-001 // 현재 디렉토리에 startup-001 강좌를 다운로드 받는다.


강좌명은 웹에서 해당 강좌의 Home으로 들어가면 URL이 `https://class.coursera.org/startup-001/class`라고 되어있는데, 여기서 `startup-001`이 강좌명이다. Computing for Data Analysis의 경우엔 `compdata-003`이다.

웹페이지와 데이타를 하나하나 긁어오는 방식이라서 그런지 다운로드 시간은 생각보다 오래 걸린다. 스타트업 엔지니어링은 비디오까지 약 800메가, 데이타 분석은 650메가 정도의 용량이다.

   [1]: https://github.com/dgorissen/coursera-dl
   [2]: http://www.pip-installer.org/en/latest/installing.html
   [3]: http://stackoverflow.com/questions/11704379/python-pip-broken-after-os-x-10-8-upgrade
  