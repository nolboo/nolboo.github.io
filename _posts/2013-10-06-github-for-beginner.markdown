---
layout: post
title: "완전 초보를 위한 깃허브"
description: "git을 전혀 모르던 디자이너가 10분 안에 자신의 디자인 화일을 회사의 저장소에 올려 협업할 수 있도록 안내하는 글의 번역. 이 블로그에서 가장 많이 읽혀진 대박글!"
category: blog
tags: [beginner, git, github]
---

원문 :  1. [GitHub For Beginners: Don’t Get Scared, Get Started][1] 2. [GitHub For Beginners: Commit, Push And Go][2]

<div id="toc"><p class="toc_title">목차</p></div>

[중략] 깃의 필요성 등에 대해 역설함.

컴퓨터를 사용하는 모든 지식 근로자는 깃허브를 사용할 이유가 있다. 만약, 당신이 깃허브 사용법을 이해하는 것을 포기했다면, 이 글은 당신을 위한 것이다.

깃허브에 대한 중 주된 오해 중 하나는 그것이 컴퓨터 언어나 컴파일러나 마찬가지로 코딩과 관련된 개발툴이라는 것이다. 그러나, 페이스북이나 플리커와 같은 소셜 네트워크와 크게 다르지 않다. 프로필을 만들고 공유할 프로젝트를 올릴 수 있고, 다른 계정들을 팔로우하여 다른 사용자들과 소통할 수 있다. 많은 사용자가 프로그램과 코드 프로젝트를 저장하지만, 당신이 자랑할만한 프로젝트 폴더의 텍스트 문서나 다른 형식의 화일을 저장하는 것을 막는 것도 없다.

[중간요약] : 깃허브에 올리는 모든 것은 사용자가 지적재산권을 갖으며, 코드에 대한 어떤 지식이 없어도 깃허브를 사용할 수 있다.

## 깃이 뭐지?

깃허브의 심장에서 작동되는 소프트웨어인 깃(Git: 재수없고 멍청한 놈, 자식)을 만든 유명한 소프트웨어 개발자 리누스 토발즈에 감사한다. 깃은 프로젝트의 어떤 부분도 겹쳐쓰지 않게 프로젝트의 변경을 관리하는 버전관리 소프트웨어이다.

왜 깃같은 것을 사용해야 하나? 당신과 동료가 동시에 같은 웹사이트에서 페이지를 업데이트하고 있다고 하자. 당신이 무언가를 변경하고 저장한 다음 웹사이트에 그것을 업로드한다. 지금까지는 좋았다. 문제는 동료가 동시에 같은 페이지에서 작업할 때이다. 누군가의 작업은 겹쳐쓰여질 것이고 지워질 것이다.

깃과 같은 버전관리 앱은 그런 일을 방지한다. 당신과 동료는 같은 페이지에 각자의 수정사항을 각각 업로드할 수 있고, 깃은 두 개의 복사본을 저장한다. 나중에, 당신들은 그대로 어떤 작업도 잃어버리지 않고 변경사항들을 병합할 수 있다. 깃은 이전에 만들어진 모든 변경사항의 “스냅샷”을 저장하기 때문에 이전 시점의 어떤 버전으로 되돌릴 수도 있다.

깃을 사용할 때 어려운 점은 90년대 해커와 같이 코드를 타이핑하는 명령어(커맨드 라인 - 맥 사용자라면 터미널)를 사용하여 접근해야하는 것이다. 이것은 요즘 컴퓨터 사용자에겐 까다로운 일일 수는 있다. 이제 깃허브를 들여다보자.

깃허브는 두 가지 방식으로 깃을 더 편리하게 해준다. 먼저, [깃허브 소트프웨어를 다운로드][3]하면, 로컬에서 당신의 프로젝트를 관리할 수 있게하는 비주얼 인터페이스를 제공한다. 두번째는, Github.com에 계정을 생성하면 웹에서 프로젝트를 버전관리할 수 있으며, 평가측정 등의 소셜 네트워크 기능을 사용할 수 있다.

다른 깃허브 사용자의 프로젝트를 둘러볼 수 있고, 그것들을 변경하거나 배우기 위해 자신만의 복사본을 다운로드할 수도 있다. 다른 사용자도 당신의 공개 프로젝트에 대해 같은 걸 할 수 있으며 에러를 발견해서 해결책을 제안할 수도 있다. 어느 경우든, 깃이 모든 변경사항에 대한 “스냅샷”을 저장하기 때문에 어떤 데이타도 잃어버리지 않는다.

깃을 배우지 않고 깃허브를 사용할 수 있지만, 사용하는 것과 이해하는 것은 큰 자이점이 있다. 깃을 이해하기 전에도 깃허브를 사용할 수 있으며, 나도 진짜로 이해하는 것은 아니다. 이 튜토리얼에선, 커맨드 라인에서 깃을 사용하는 것을 배울 것이다.

## 기본 용어

이 튜토리얼에서 반복적으로 사용하려고 하는 몇 개의 용어가 있다. 나도 배우기 시작하기 전에는 들어본 적이 없는 것들이다. 여기 중요한 것들이 있다:

**커맨트 라인(Command Line):** 깃 명령어를 입력할 때 사용하는 컴퓨터 프로그램. 맥에선 터미널이라고 한다. PC에선 기본적인 프로그램이 아니어서 처음엔 깃을 다운로드해야 한다(다음 섹션에서 다룰 것이다). 두 경우 모두 마우스를 사용하는 것이 아닌 프롬프트로 알려진 텍스트 기반 명령어를 입력한다.

**저장소(Repository):** 프로젝트가 거주(live)할 수 있는 디렉토리나 저장 공간. 깃허브 사용자는 종종 “repo”로 줄여서 사용한다. 당신의 컴퓨터 안의 로컬 폴더가 될 수도 있고, 깃허브나 다른 온라인 호스트의 저장 공간이 될 수도 있다. 저장소 안에 코드 화일, 텍스트 화일, 이미지 화일을 저장하고, 이름붙일 수 있다.

**버전관리(Version Control):** 기본적으로, 깃이 서비스되도록 고안된 목적. MS 워드 작업할 때, 저장하면 이전 화일 위에 겹쳐쓰거나 여러 버전으로 나누어 저장한다. 깃을 사용하면 그럴 필요가 없다. 프로젝트 히스토리의 모든 시점의 “스냅샷”을 유지하므로, 결코 잃어버리거나 겹쳐쓰지 않을 수 있다.

**커밋(Commit):** 깃에게 파워를 주는 명령이다. 커밋하면, 그 시점의 당신의 저장소의 “스냅샷”을 찍어, 프로젝트를 이전의 어떠한 상태로든 재평가하거나 복원할 수 있는 체크포인트를 가질 수 있다.

**브랜치(Branch):** 여러 명이 하나의 프로젝트에서 깃 없이 작업하는 것이 얼마나 혼란스러울 것인가? 일반적으로, 작업자들은 메인 프로젝트의 브랜치를 따와서(branch off), 자신이 변경하고 싶은 자신만의 버전을 만든다. 작업을 끝낸 후, 프로젝트의 메인 디렉토리인 “master”에 브랜치를 다시 “Merge”한다.

## 주요 명령어

깃은 리눅스와 같은 큰 프로젝트를 염두에 두고 디자인되었기 때문에, 깃 명령어는 아주 많다. 그러나, 깃의 기본을 사용할 때에는 몇 개의 명령어만 알면된다. 모두 “git”이란 단어로 시작된다.

**git init:** 깃 저장소를 초기화한다. 저장소나 디렉토리 안에서 이 명령을 실행하기 전까지는 그냥 일반 폴더이다. 이것을 입력한 후에야 추가적인 깃 명령어들을 줄 수 있다.

**git config:** “configure”의 준말, 처음에 깃을 설정할 때 가장 유용하다.

**git help:** 명령어를 잊어버렸다? 커맨드 라인에 이걸 타이핑하면 21개의 가장 많이 사용하는 깃 명령어들이 나타난다. 좀 더 자세하게 “git help init”이나 다른 용어를 타이핑하여 특정 깃 명령어를 사용하고 설정하는 법을 이해할 수도 있다.

**git status:** 저장소 상태를 체크. 어떤 화일이 저장소 안에 있는지, 커밋이 필요한 변경사항이 있는지, 현재 저장소의 어떤 브랜치에서 작업하고 있는지 등을 볼 수 있다.

**git add:** 이 명령이 저장소에 새 화일들을 추가하진 _않는다_. 대신, 깃이 새 화일들을 지켜보게 한다. 화일을 추가하면, 깃의 저장소 “스냅샷”에 포함된다.

**git commit:** 깃의 가장 중요한 명령어. 어떤 변경사항이라도 만든 후, 저장소의 “스냅샷”을 찍기 위해 이것을 입력한다. 보통 “git commit -m “Message hear.” 형식으로 사용한다. `-m`은 명령어의 그 다음 부분을 메시지로 읽어야 한다는 것을 말한다.

**git branch:** 여러 협업자와 작업하고 자신만의 변경을 원한다? 이 명령어는 새로운 브랜치를 만들고, 자신만의 변경사항과 화일 추가 등의 커밋 타임라인을 만든다. 당신의 제목이 명령어 다음에 온다. 새 브랜치를 “cats”로 부르고 싶으면, `git branch cats`를 타이핑한다.

**git checkout:** 글자 그대로, 현재 위치하고 있지 않은 저장소를 “체크아웃”할 수 있다. 이것은 체크하길 원하는 저장소로 옮겨가게 해주는 탐색 명령이다. master 브랜치를 들여다 보고 싶으면, `git checkout master`를 사용할 수 있고, `git checkout cats`로 또 다른 브랜치를 들여다 볼 수 있다.

**git merge:** 브랜치에서 작업을 끝내고, 모든 협업자가 볼 수 있는 master 브랜치로 병합할 수 있다. `git merge cats`는 “cats” 브랜치에서 만든 모든 변경사항을 master로 추가한다.

**git push:** 로컬 컴퓨터에서 작업하고 당신의 커밋을 깃허브에서 온라인으로도 볼 수 있기를 원한다면, 이 명령어로 깃허브에 변경사항을 “push”한다.

**git pull:** 로컬 컴퓨터에서 작업할 때, 작업하고 있는 저장소의 최신 버전을 원하면, 이 명령어로 깃허브로부터 변경사항을 다운로드한다(“pull”).

## 처음으로 깃/깃허브 설정하기

먼저, [GitHub.com][4]에 가입한다. 다른 소셜 네트워크에 가입하는 것처럼 간단하다.

로컬 컴퓨터에서 작업하려면 깃을 설치해야 한다. [필요에 따라][5] 윈도우, 맥, 리눅스 용 깃을 설치하라.

이제 커맨드 라인으로 넘어갈 시점이다. 윈도우에선 방금 설치한 Git Bash 앱으로, OS X에선 터미널로 시작한다. 깃에 자신을 소개할 차례이다. 다음 코드를 타이핑한다:


    git config --global user.name "Your Name Here"


물론, “Your Name Here”의 인용부호 안에 자신의 이름을 넣어야 한다.

다음엔, 당신의 이메일을 말해준다. 조금 전에 GitHub.com을 가입할 때 사용한 이메일이어야 한다. 다음과 같이 한다:


    git config --global user.email "your_email@youremail.com"


이것이 로컬 컴퓨터에서 깃을 사용할 때 필요한 모든 것이다. 원한다면, 깃과 소통할 때마다 GitHub.com 계정에 로드인하는 것을 요청하지 않도록 깃을 설정할 수 있다. 이것과 관련된 풀 튜토리얼은 [깃허브에 있다][6].

![](http://a5.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjIxNTQ5OTgwOTUz.png)

## 온라인 저장소 만들기

이제 프로젝트가 거주할 장소를 만들 시점이다. 깃과 깃허브는 당신의 프로젝트와 그 화일들, 깃이 저장한 화일들의 모든 버전에 접근할 수 있는 디지털 디렉토리나 저장공간을 저장소(repository 줄여서 repo)라고 한다.

GitHub.com으로 돌아가서 사용자명 다음에 있는 작은 책 아이콘을 클릭한다. 혹은, 모든 아이콘이 다 똑같아 보인다면 [new repository page][8]로 간다. 저장소에 짧고 기억할만한 이름을 준다. 재미삼아 public으로 해본다.

![](http://a3.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjI0MjM0MDc4ODIy.png)

“Initialize this repository with a README.” 앞의 체크박스는 신경쓰지 않는다. Readme 화일은 보통 프로젝트에 관해 설명하는 텍스트 화일이다. 여기선 연습삼아 로컬에서 자신의 Readme 화일을 만들 것이다.

녹색의 “Create Repository” 버튼을 클릭한다. 이제 프로젝트가 거주할 온라인 공간을 가진 것이다.

## 로컬 저장소 만들기

온라인에서 거주하는 프로젝트의 공간을 방금 만들었다. 그러나, 그 곳이 작업할 공간은 아니다. 컴퓨터에서 작업할 것이므로, 로컬 디렉토리에 만들 저장소에 실제로 미러링해야 한다.

먼저 다음을 타이핑한다:


    mkdir ~/MyProject


`mkdir`은 make directory의 준말이다. 깃 명령어는 아니고 비주얼 인터페이스 이전 시대에 일반적인 탐색 명령어이다. `~/`는 나중에 찾기쉽게 컴퓨터 화일 구조의 최상위 단계에 저장소를 만드는 것이다. 브라우저에서 `~/`를 입력하면 로컬 컴퓨터의 최상위 단계 디렉토리가 보일 것이다. 맥의 크롬인 경우 Users 폴더를 보여준다.

깃허브 저장소와 동일하게 MyProject로 이름짓는 것을 주목한다. 당신도 그렇게 해라.

타이핑한다:


    cd ~/MyProject


`cd`는 change directory를 뜻하며, 역시 탐색 명령어이다. 방금 디렉토리를 만들었고, 그 디렉토리로 옮겨 들어갔다.

이제 마침내 깃 명령어를 사용한다. 다음 줄에 타이핑한다:


    git init


`init`은 “initialize(초기화)”를 뜻한다. 이 코드를 입력하면 이 디렉토리를 로컬 깃 저장소라고 컴퓨터에게 말해주는 것이다. 폴더를 열면 - 이 새로운 깃 디렉토리는 전용 저장소 안에 숨겨진 화일 하나이기 때문에 - 어떤 차이를 보지 못할 것이다.

![](http://a4.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjI2MTEzMTI3MDE0.png)

그러나, 컴퓨터는 이제 이 디렉토리를 Git-ready로 인식하고, 깃 명령어를 입력할 수 있다. 이제 프로젝트가 거주할 온라인과 로컬 저장소를 모두 가졌다.

이제는 깃허브에 첫번째 커밋을 만들어서 프로젝트의 첫 부분을 추가하자. 다음 화면과 같은 MyProject라는 저장소를 만들었었다.

![](http://a4.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjEwODEyMzAwNTY5.png)

다음을 입력한다:


    touch Readme.txt


역시 깃 명령어가 아니다. 또 하나의 기본 탐색 명령어이다. `touch`는 “create 만드는 것”을 뜻한다. 그 뒤에 무엇을 적던지 간에 만들어지는 것의 이름이다. 파인더나 시작메뉴에서 해당 폴더로 가보면 Readme.txt 화일이 만들어진 것을 볼 것이다.

다음을 입력:


    git status


커맨드 라인에서 다음과 유사한 몇 개의 텍스트 줄을 응답할 것이다:


    # On branch master
    # Untracked files:
    #   (use "git add ..." to include in what will be committed)
    #
    #         Readme.txt


![](http://a3.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjE1Mzc1Nzc0MzEw.png)

뭐지? 먼저, 당신은 프로젝트의 master 브랜치 상에 있다. “branched off”하지 않았기 때문에 당연하다. 두번째론, Readme.txt이 “untracked” 화일로 리스트되었다. 현재는 깃이 무시한다는 것을 뜻한다. 깃이 주목하게 하기 위해, 다음을 입력한다:


    git add Readme.txt


커맨드 라인이 주는 힌트를 보면 첫번째 화일을 추가했다는 것을 알 수 있다. 지금까지의 프로젝트 “스냅샷”을 찍거나, “커밋”할 시점이다.


    git commit -m “Add Readme.txt”


![](http://a1.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjE3NzkxNjI3ODc4.png)

-m 플래그는 이미 말했듯이, 뒤따르는 텍스트는 메시지로 읽어야 한다. 커밋 메시지가 현재형인 것을 주목한다. 버전관리는 시간에 대해 유연성을 가지므로 현재형으로 작성해야 한다. 더 이전 버전으로 되돌아갈 수 있으므로 _커밋을 했던_ 것을 적는 것이 아니라, _커밋한_ 것을 적어야 한다.

이제, 로컬에서 작은 작업을 하고 깃허브에 첫 커밋을 ‘push’할 때이다.

“잠깐, 온라인 저장소를 로컬 저장소와 연결하지 않았다.”라고 생각할지 모르겠다. 당신이 맞다. 로컬 저장소와 온라인 저장소의 첫번째 실제 연결을 만들어보자.

## 로컬 저장소와 깃허브 저장소 연결하기

먼저, 깃에게 온라인 어딘가가 실제 원격(remote) 저장소인지를 말해주어야 한다. `git add` 명령어를 사용하기 전까지는 깃이 우리 화일을 인식하지 않는 것과 마찬가지로, 원격 저장소도 인식하지 않을 것이다.

`https://github.com/username/myproject.git`에 “MyProject”라는 이름의 깃허브 저장소가 있다고 가정해보자. 물론, `username`은 자신의 깃허브 사용자명으로 바꿔야 한며, 저장소 제목도 자신의 깃허브 저장소 제목으로 바꿔야한다.


    git remote add origin https://github.com/username/myproject.git


첫 부분은 익숙하다; `git add`를 이미 화일과 써봤다. 화일이 비롯된(originated) 곳에서 새로운 위치를 가리키기 위해 `origin`이란 단어를 더했다.(해석이 약간 명료하지 못함. 원문: We’ve tacked the word origin onto it to indicate a new place from which files will originate.) `remote`는 `origin`의 설명자(descriptor)이며, `origin`이 로컬 컴퓨터가 아닌 온라인 어딘가를 가리킨다는 것이다.

역자주: 간단히 말하면, 온라인에 있는 `https://github.com/username/myproject.git` 저장소를 `origin`으로 지정한다.

이제 깃이 원격 저장소가 있는 곳과 로컬 저장소가 변경사항을 어디로 보낼지 알게되었다. 확인하기 위해, 다음을 입력:


    git remote -v


![](http://a4.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjIwMjA3Njc4MDU0.png)

이 명령어는 로컬 저장소가 알고있는 원격 `origin`에 대한 모든 항목을 보여준다. 지금까지 함께 하였다면, 단 하나이어야 한다. 두 개가 리스트된 것은 정보를 _push_하고 _fetch_할 수 있는 것을 뜻한다.

이제 깃허브 원격 저장소로 변경사항을 업로드나 “push” 해보자. 쉽다. 입력:


    git push


커맨드 라인에서 여러 줄에 걸쳐 연달아 내놓을 것이고, 마지막으로 “everything up-to-date.”과 같은 것을 밷아낼 것이다.

![](http://a5.files.readwrite.com/image/upload/c_fit,w_620/MTIyMzA0MjIyNjIzNDY2MDg2.png)

단순 명령어만 입력했기 때문에 주의(warning) 메시지가 나온다. 내 저장소의 master 브랜치를 지정하도록 하려면 `git push origin master`로 입력할 수 있다. 지금은 하나의 브랜치만 있기 때문에 그렇게 하지 않았다.

깃허브에 다시 로그인한다. 이제 오늘 만든 커밋이 얼마나 되는지 깃허브가 추적하는 것을 알 수 있다. 저장소를 클릭해보면 로컬 저장소에서 만들었던 동일한 Reame.txt를 가지고 있을 것이다.

## All Together Now!

축하한다, 이제 공식적으로 깃 사용자가 되었다! 저장소를 만들고 변경사항을 커밋할 수 있다. 이것이 대부분의 입문 튜토리얼의 끝나는 지점이다.

[중략] 이 정도면 회사에서 사장이 깃을 사용할 것을 요구하면 당장 디자인 화일을 깃허브에 올릴 정도는 될 것이라고 이야기하면서 디자인 화일 명 하나를 중심으로 여태 해온 것을 반복함.

## 역자 요약

<pre class="terminal">
git config --global user.name "이름"
git config --global user.email "깃허브 메일주소" // 매번 물어보는 귀찮음을 피하기 위해 설정.

mkdir ~/MyProject   // 로컬 디렉토리 만들고
cd ~/myproject      // 디렉토리로 들어가서
git init            // 깃 명령어를 사용할 수 있는 디렉토리로 만든다.
git status          // 현재 상태를 훑어보고
git add 화일명.확장자  // 깃 주목 리스트에 화일을 추가하고 or
git add .           // 이 명령은 현재 디렉토리의 모든 화일을 추가할 수 있다.
git commit -m “현재형으로 설명” // 커밋해서 스냅샷을 찍는다.

git remote add origin https://github.com/username/myproject.git // 로컬과 원격 저장소를 연결한다.
git remote -v // 연결상태를 확인한다.
git push origin master // 깃허브로 푸시한다.
</pre>

## Git Resources

  * [Pro Git][16]. 깃을 배우고 사용하는 법에 대한 오픈소스 북. 분량이 많지만, 기본을 배우기 위해서는 3장까지만 읽으면 된다.
  * [Try Git][17]. 코드스쿨과 깃허브가 팀을 짜서 이 속성 튜토리얼을 만들었다. 기본에 대해 좀 더 연습하길 원하면 도움이 될 것이다.
  * [GitHub Guides][18]. 비주얼 학습자라면 깃허브의 공식 유투브 채널에서 시간을 보낼만하다. 특히 [Git Basics][19] 네개의 시리즈에서 많은 것을 얻을 수 있다.
  * [Git Reference][20]. 명령어를 잊어버렸을 때는 용어 참조하기 좋은 사이트다.
  * [Git - the simple guide][21]. 이 튜토리얼은 짧고 달콤하다. 깃의 기초에 대해 되살리고 싶다면 필요할 것이다.
  * [GitHub Glossary][22]. 역자가 추가한 깃허브 공식 용어 사전
  * [코드로 디자인하기](http://spoqa.github.io/2015/01/16/design-with-code.html) : 스포카(Spoqa) 사례
  * 버전관리를 들어본적 없는 사람들을 위한 DVCS - Git : 잘 정리된 슬라이드(역자 추가)

<iframe src="//www.slideshare.net/slideshow/embed_code/37077214" width="427" height="356" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%;" allowfullscreen> </iframe> <div style="margin-bottom:5px"> <strong> <a href="https://www.slideshare.net/ibare/dvcs-git" title="버전관리를 들어본적 없는 사람들을 위한 DVCS - Git" target="_blank">버전관리를 들어본적 없는 사람들을 위한 DVCS - Git</a> </strong> from <strong><a href="http://www.slideshare.net/ibare" target="_blank">민태 김</a></strong> </div>

   [1]: http://j.mp/1g3el6I
   [2]: http://j.mp/GzCMeO
   [3]: http://github.com/
   [4]: https://github.com/
   [5]: http://git-scm.com/downloads
   [6]: https://help.github.com/articles/set-up-git
   [7]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.01.04%20PM.png
   [8]: https://github.com/new
   [9]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.06.48%20PM.png
   [10]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.10.04%20PM.png
   [11]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.10.04%20PM_0.png
   [12]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.24.55%20PM.png
   [13]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.28.11%20PM.png
   [14]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.36.22%20PM.png
   [15]: http://readwrite.com/files/Screen%20Shot%202013-09-25%20at%205.52.53%20PM.png
   [16]: http://git-scm.com/book
   [17]: http://www.codeschool.com/courses/try-git
   [18]: http://www.youtube.com/GitHubGuides
   [19]: http://www.youtube.com/watch?v=8oRjP8yj2Wo&amp;list=PLg7s6cbtAD165JTRsXh8ofwRw0PqUnkVH
   [20]: http://gitref.org/
   [21]: http://rogerdudler.github.io/git-guide
   [22]: https://help.github.com/articles/github-glossary

