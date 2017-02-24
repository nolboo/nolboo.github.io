---
layout: post
title: "Vim을 시작하는 법"
description: "처음 Vim을 시작하는 방법"
category: blog
tags: [practical, vim, beginner]
---

![Vim 3D](/images/posts/vim.jpg)

1. 목차
{:toc}

원문 : [Getting started with Vim](http://lucapette.me/getting-started-with-vim)

이 글의 목표는 불안과 좌절 없이 Vim을 시작하기위한 길을 제안하는 것이며,각 주제의 세부 사항에 대해 설명하지 않을 것이다. 훌륭한 자료가 있으며 각 섹션의 끝 부분에 링크할 것이다.

## vimtutor

Vim에는 멋진 튜토리얼이 있다. 이미 기본을 알고 있다고 생각하더라도 튜토리얼에서 시작하는 것이 좋다. 25-30 분이 걸리고 한방에 끝내는 것이 좋다. 시스템에 Vim이 있으면 `vimtutor`를 입력하고 바로 시작할 수 있다. 이 튜토리얼는 모든 기본 명령과 개념을 가르쳐 주도록 고안되었다. Vim은 다양한 [모드](https://en.wikibooks.org/wiki/Learning_the_vi_Editor/Vim/Modes)를 가진 [모달 편집기](http://unix.stackexchange.com/questions/57705/modeless-vs-modal-editors#57708)이다. 이 특성이 새로울 것이고 튜토리얼은 천천히 진행될 것이다.

## Vim has no shortcuts

다음 단계는 Vim을 매일 사용하는 것이다. 그러나 Vim에서의 텍스트 편집이 어색하고 외울 것이 많고 대부분의 명령이 기억하기 쉽지 않기 때문에 쉬운 목표는 아니다. 이러한 이유로 "Vim way"에 대한 이해를 공유하고 싶다. 이 접근법을 통해 Vim을 좀 더 친숙하게 만들 수 있다고 확신한다.

대학에서 C 프로그래밍 및 운영 체제에 대한 랩 수업에서 Vim을 만났다. 압도적이었다. Vim을 전혀 이해하지 못했고, 교수님도 우호적이거나 도움이 되지 않다. `dd`, `yy`, `A`와 같은 모든 것들은 도대체 왜  Vim을 사용하는지 의아하게 만들었다. 어떻게 모든 단축키를 기억할 수 있을까? 모든 종류의 단축키가 있는 IDE에 쓰기도 했지만, 그것들은 기억하기 쉬웠다. 또한, 잊어 버렸을 때는 직관적인 레이블이 있는 메뉴가 있었다. Vim 명령은 기억하기 쉽지 않았고 이 문제는 몇 주 동안 나를 괴롭혔다. Vim에 겁먹었고 결국 IDE로 돌아갔다.

충격적인 경험이 있은지 2년 후에 Vim을 다시 사용해 보았다. 그 때는 Perl과 Ruby를 사용하고 있었고 IDE는 터미널 중심의 워크플로우에 맞지 않았다. 그러던 어느 날 나는 [텍스트 개체](http://vimdoc.sourceforge.net/htmldoc/motion.html#object-select)를 만났다. 전환점이 되었다. 요즘에는 텍스트 개체가 다른 편집기로 코드를 편집 할 수 없는 이유다. 텍스트의 범위를 설명 할 수 있다. 몇 가지 예다:

* A word(단어)
* A sentence(문장)
* A paragraph(단락)
* A HTML tag(태그)
* A function(함수)

Vim에는 텍스트 삭제 명령, 붙여 넣기 명령 등의 명령이 있다. 명령을 텍스트 개체와 결합하여 텍스트 편집용 강력한 작은 언어를 얻을 수 있다. 다음과 같이 말할 수 있다:

* 다음 세 단어 제거하기(Remove the next three words)
* 이 단락 복사하기(Copy this paragraph)
* 이 HTML 태그의 내용을 변경하기(Change the content of this HTML tag)

Vim에 단축키가 없다고 말하는 이유다. 이렇게 설명하고 싶다:

>Vim은 작은 사용자 인터페이스를 가진 텍스트 편집을 위한 작은 언어다.

작은 사용자 인터페이스가 편집기(editor)다. 이 관점에서 보면 깨달을 수 있습니다. 표준 라이브러리를 배우는 대신 언어가 작동하는 방법을 배우는 데 집중할 수 있다. "Vim way"로 텍스트를 편집하는 것에 집중할 수 있다. 이 방법으로 Vim에 접근하는 것 더 쉽고 학습 곡선이 더 점진적이라고 생각한다.

시작했을 때 누군가 설명해주기를 바랐던 Vim의 또 다른 측면은 일반 모드에 초점을 맞추는 것이다. Vim에는 여러 모드가 있지만 이름 때문에 두드러지는 모드이다. 이 모드에서 Vim을 사용하는 것이 보통(normal)이므로 "일반(normal)" 모드라고 한다. 대부분의 편집은 이 모드에서 수행한다: 텍스트를 이동하거나 붙여넣거나 삭제할 수 있다. 모두 일반 모드에서 한다. Vim이 작은 언어라는 생각과 텍스트 개체와 일반 모드에서의 초점을 결합할 수 있다.

>Vim은 텍스트 개체를 통해 텍스트를 조작하는 일반 모드가 있다.

링크:

- [Vim Text Objects: The Definitive Guide](http://blog.carbonfive.com/2011/10/17/vim-text-objects-the-definitive-guide/), [Vim 텍스트 개체: 궁극의 가이드](https://nolboo.kim/blog/2016/10/13/vim-text-objects-definitive-guide/)
- [:h text-objects](http://vimdoc.sourceforge.net/htmldoc/motion.html#object-select)
- [Your problem with Vim is that you don’t grok vi.](http://stackoverflow.com/questions/1218390/what-is-your-most-productive-shortcut-with-vim/1220118#1220118)

## Vim plugins

Vim에 필요한 모든 것이 있지 않지만 생태계에서 방법을 찾는 것이 까다로울 수 있다. 같은 문제를 해결하려는 많은 플러그인이 있으며 하나를 꼭집어 선택하기도 까다롭다. 예전에 Vim을 [설정하는](http://lucapette.me/vim-for-rails-developers-lazy-modern-configuration) 방법에 관해 썼다. 그러나 오늘 같은 기사를 쓴다면 플러그인 관리에 더 집중할 것이다: 더 쉬워졌다. [Vundle.vim](http://lucapette.me/[https://github.com/VundleVim/Vundle.vim)을 사용하고 있고, 행복하다. Vundle도 사용하라고 제안한다. 플러그인 설치, 업데이트 및 제거를 수행 할 수있는 몇 가지 간단한 명령이 있으므로 아무 것도 기억하지 않아도된다. 단순성이 핵심이다. 많은 플러그인을 가지고 놀 수 있기 때문에 플러그인을 추가하거나 제거하는 것이 쉽다.

사람마다 워크플로우가 매우 다르므로 "놓칠 수없는 100 개의 Vim 플러그인" 목록을 열거하지는 않을 것이다. 그러나 시작할 수 있게 최소한의 도움을 주려고 한다.

### fugitive.vim

[fugitive.vim](https://github.com/tpope/vim-fugitive)은 git과 관련하여 완벽한 동반자다. 저자의 말:

>거짓말하지 않겠다; fugitive.vim은 사상 최고의 Git 래퍼(wrapper)다.

대담한 주장처럼 들릴지 모르겠지만, 나는 그렇게 생각하지 않는다. 이 플러그인은 정말 멋지고 유쾌한 기능을 가지고 있다. 사용법을 배우는 가장 좋은 방법은 좋은 [스크린 캐스트](http://vimcasts.org/blog/2011/05/the-fugitive-series/)를 보는 것이다.

### tpope plugins

[tpope](https://github.com/tpope)는 fugitive.vim의 저자일뿐만 아니라, 믿을 수 없을 정도로 긴 목록의 필수 플러그인을 만들고 관리한다. 제 제안은 저장소 목록을 훑어보면서 필요한 모든 플러그인을 사용해보라는 것이다. 하나 골라야한다면, 그것은 [surround.vim](https://github.com/tpope/vim-surround)이다. 코드 편집은 종종 "주변(surroundings)"을 다루는 것을 뜻한다: 괄호, 대괄호, 따옴표 등. Surround.vim은 이런 걸 다루는 데 엄청난 도움이 된다.

링크:

* [Vim Awesome](http://vimawesome.com/)

## Practical Vim

[Drew Neil](https://twitter.com/nelstrom)은 [Practical Vim](https://pragprog.com/book/dnvim/practical-vim)을 썼다. Vim 지식을 심화하고자하는 사람에게 완벽한 책이다. 매일 Vim을 사용하는 것에 익숙해지면 이 책을 추천한다. 훌륭한 팁 모음이며 학습 경로를 빠르게 한다. 더 좋은 자료를 상상할 수 없다. "Practical Vim"을 읽기 _전_ 과 _후_ 가 있다고 생각한다.

Drew Neil은 [vimcasts](http://vimcasts.org/)에서 꽤 많은 스크린 캐스트를 올려놨고, 그것들도 추천한다. Drew의 설명은 명확하고 따라하기 쉽다.

## Again, how do I get into Vim?

제안하는 단계는 다음과 같다:

* 튜터(Vimtutor)를 끝낸다.
* Vim way로 텍스트에 관해 생각한다.
* 플러그인 생태계를 배운다.
* 베스트 책을 읽고 저자의 모든 스크린 캐스트 본다.

Happy editing!

### 추가링크

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)
* [완전 초보를 위한 Vim](https://nolboo.kim/blog/2016/11/15/vim-for-beginner/)


