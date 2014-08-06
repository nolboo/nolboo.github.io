---
layout: post
title: "깃허브로 협업하는 법"
description: "오픈소스에 공헌하기 위해서 git의 사용은 필수적이다. git의 협업 부분을 위주로 설명한 글의 번역"
category: blog
tags: [collaboration, git, github, project]
---

<div id="toc"><p class="toc_title">목차</p></div>

원문 : [How to Collaborate On GitHub][1]

필요한 부분만 완전 요약하여 번역하였으니 원문을 반드시 참조하세요!

## Learn the Ecosystem of the Project

공헌하기 위해서는 프로젝트와 관련된 모든 문서를 읽어라. 예를 들면, 깃허브는 표준화된 `CONTRIBUTING.md`를 가지고 있다. [jQuery 공헌 가이드][2]는 완벽한 예제이다. 프로젝트 생태계를 이해하는 또 다른 방법은 기존 코드베이스와 `git log`를 살펴보는 것이다. 프로젝트의 문서를 전부 읽고 어휘를 습득하라.

## The Pull-Request Workflow for Code Contribution

깃허브의 일반적인 워크플로우는 꽤 단순하다.

1. 자신의 계정으로 target 저장소를 fork한다. 
2. 로컬 컴퓨터에 저장소를 clone한다. 
3. “topic 브랜치”로 check out하고 소스를 변경한다. 
4. 자신의 fork에 topic 브랜치를 push한다. 
5. 토론을 통해 pull request를 만들기위해 깃허브의 diff 뷰어를 사용한다. 
6. 요청된 변경을 만든다. 
7. pull 요청이 (보통 master 브랜치 안으로) merge되고 topic 브랜치는 upstream(target) 저장소에서 지워진다.

워크플로우에서 각 프로젝트마다 많은 차이가 있다. 예로, topic 브랜치의 이름 규약은 서로 다르다. 어떤 프로젝트는 깃허브 이슈의 ID #가 345일 때 `bug_345`와 같은 규약을 사용한다. 어떤 프로젝트에선 더 짧은 커밋 메시지를 선호한다.

### Step 1: Forking

깃허브에서 저장소를 fork한다.

![][3]

![][4]

### Step 2: Cloning

우측 사이드바의 URL을 사용하여 저장소를 clone한다.


    git clone git@github.com:jcutrell/jquery.git


![][5]

### Step 3: Adding the Upstream Remote

클론한 디렉토리로 변경하고, 이 지점에서 upstream remote를 추가한다.


    cd jquery
    git remote add upstream git@github.com:jquery/jquery.git


이렇게 하면 로컬에서 소스 변경을 Pull하고 merge할 수 있다. 이렇게:


    git fetch upstream
    git merge upstream/master


### Step 4: Checking Out a Topic Branch

자신의 변경사항을 만들기 전에, topic 브랜치로 checkout한다.


    git checkout -b enhancement_345


### Step 5: Committing

이제 소스를 변경하고 변경에 대한 추적하는 커밋을 만든다.


    git commit -am "adding a smileyface to the documentation."


### Step 6: Pushing

자신의 fork에 topic 브랜치를 push한다.


    git push origin enhancment_345


### Step 7: Creating a Pull Request

최종적으로 pull 요청을 만들 것이다. 먼저 자신의 fork로 간다. “your recently pushed branches”에서 “Compare and Pull Request”를 선택한다. 그렇지 않으면 뜨랍다운에서 브랜치를 선택하고, 저장소 섹션의 우상에 있는 “Pull Request” 나 “Compare”를 클릭한다.

![][6]

![][7]

[“How GitHub Uses GitHub to Build GitHub”][8]에 따르면 pull 요청은 대화이다.

## GitHub Issues %2B Pull Requests = Project Management Zen

이슈의 가장 놀라운 특징은 pull 요청과의 통합이다. 사용자는 키밋 메시지에 이슈 숫자 IO를 포함하여 커밋 메시지에서 이슈를 참조할 수 있다. 예를 들면:


    git commit -am "Adding a header; fixes #3"


위의 커밋 메시지는 pull 요청이 받아들여지면 이슈 #3를 자동으로 닫는다.

## Seek Out Secondary Channels of Collaboration

pull 요청만이 공헌할 수 있는 유일한 방법이라고 생각하지 마라. 포럼이나 IRC 대화에서도 가능하다.

   [1]: http://net.tutsplus.com/tutorials/tools-and-tips/how-to-collaborate-on-github/
   [2]: https://github.com/jquery/jquery/blob/master/CONTRIBUTING.md
   [3]: http://cdn.tutsplus.com/net/uploads/2013/08/github_header.png
   [4]: http://cdn.tutsplus.com/net/uploads/2013/08/forking.png
   [5]: http://cdn.tutsplus.com/net/uploads/2013/08/clone_url.png
   [6]: http://cdn.tutsplus.com/net/uploads/2013/08/compare_pull_request.png
   [7]: http://cdn.tutsplus.com/net/uploads/2013/08/switch_branches.png
   [8]: http://zachholman.com/talk/how-github-uses-github-to-build-github/
  