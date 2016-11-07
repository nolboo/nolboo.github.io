---
layout: post
title: "Vim에서 한글 입출력"
description: "Vim에서 한글을 입력하고 출력하는 방법을 정리"
category: blog
tags: [editor, vim, tip, korean, input, output, display, iterm]
---

가끔 텍스트 에디터에서 한글입출력을 제대로 지원하지 않는 경우가 많다. (그래도 최근엔 많이 좋아졌지만 사용 앱도 그러니 아쉬운 놈이 우물을 팔 수밖에) 널리 사용되는 유명한 프로그램도 그런 경우가 많은데, 최근 익히기 시작한  Vim에서도 불편한 점이 있다. 그래서 한글을 입력하고 출력하는 방법을 아는 한도 내에서 정리한다.

## 한글 입력

Vim은 일반모드와 편집모드, 비주얼모드 등의 주요 모드가 분리된 것이 큰 장점이나, 한글 입력은 편집모드에서만 필요하고 나머지 모드에서는 거의 필요가 없다. 편집모드에서 다른 모드로의 전환은 주로 `Esc`로 이루어지므로, `Esc` 키를 입력할 때 무조건 영문입력으로 바꿔주는 방법과 편집모드를 빠져나가는 훅을 이용하는 방법 등이 있다.

### 구름 입력기

[구름 입력기](http://gureum.io/)는 `Esc` 키를 눌렀을 때 영문 입력 상태로 만들어서 일반모드에서 편집 명령을 바로 내릴 수 있다. 모드와 상관없이 동작하기 때문에 `Esc` 키를 애용하는 맥 사용자는 필수 앱이다. 구름 입력기를 처음 만들었을 때 Vim에 빠져있어서 이 기능을 넣게 되었다고 한다.

![구름 환경설정](https://c7.staticflickr.com/6/5667/30428916990_dc765919c6.jpg)

### Hook을 이용하는 방법

이 방법은 MacVim GUI 모드에서만 작동하거나 어떤 부분은 아예 작동하지 않는다. 내 경우만 그런 것인지 확인하기 힘들어 정리 차원에서 링크만 남겨둔다.

- [input-source-switcher: Command line input source switcher for Mac.](https://github.com/vovkasm/input-source-switcher)를 이용하여 [vim 명령모드에서 영문 키보드로 자동으로 전환되게 만들기](http://yisangwook.tumblr.com/post/106780445189/vim-insert-mode-keyboard-switch)를 참조한다.
- [myshov/xkbswitch-macosx: Console keyboard layout switcher for Mac OS X](https://github.com/myshov/xkbswitch-macosx)
- [lyokha/vim-xkbswitch: vim plugin for automatic keyboard layout switching in insert mode](https://github.com/lyokha/vim-xkbswitch): 되돌아올 때 입력모드의 입력상황을 되살려준다고 한다.

### 한글 입력할 때 문제점

MacVim에서 한글 입력 도중에 화살표 키로 움직이면 마지막 한 글자를 먹어버린다. 원래 Vim은 h,j,k,l로 움직이고, Esc로 일반모드로 갈 때는 그런 현상이 나타나지 않는다.(물론 개인적인 문제일 수도 있다.) 터미널 모드에서는 입력 중인 한글을 잡아먹지는 않지만, 조합을 완성하기 위해 한 번의 키 입력이 지체된다. 그래서 터미널 모드를 주로 사용하며 이 포스트도 작성했다.

## 한글 출력

[GUI에서 폰트를 설정하는 법](http://vim.wikia.com/wiki/Setting_the_font_in_the_GUI)을 참조하여 줄간과 인코딩, GUI 영문 폰트와 비영문 폰트를 각각 지정할 수 있다.

```vim
set linespace=3
set encoding=utf-8
set fileencoding=utf-8
set guifont=Menlo:h14
set guifontwide=NanumGothicCoding:h16
```

만약 D2코딩 글꼴을 좋아한다면 마지막 줄을 `set guifontwide=D2Coding:h14`로 지정하고 알맞는 높이를 지정하면 된다.

## iTerm 폰트

그러나, 터미널 모드에서는 Vim 자체에서 한글 폰트를 지정할 수 없다. 그래서 터미널 앱이나 iTerm을 이용하여 폰트를 지정하는 방법이 남았는데, iTerm에서는 Non-ASCII 폰트를 추가로 지정할 수 있고, 자간과 줄간도 지정할 수 있다. 그래서 지금과 같이 한글로 포스트나 위키를 작성할 때 iTerm에서 `mvim -v`를 이용해서 터미널 모드로 사용한다.

![iTerm font](https://c5.staticflickr.com/6/5699/30012955532_5b764033a8_c.jpg)

영문 폰트를 Andale Mono로 한글 폰트(Non-ASCII Font)를 나눔고딕코딩으로 지정하였다.

![iTerm font space](https://c1.staticflickr.com/9/8600/30012949472_ff0e3a317a.jpg)

자간과 줄간을 지정할 수 있다. Character Spacing의 Horizontal을 80%로 Vertical을 120%로 지정했다. 한글을 이쁘게 보기 위해서 자간을 80%로 하였기 때문에 이젠 영문 폰트가 제한된다. 자간이 넓은 폰트를 선택해야 하는데, Andale Mono를 최종 선택하였다. 그런대로 보기 편한 영문 폰트는 다음과 같다.

- DejaVu Sans Mono for Powerline: 기울임체
- Droid Sans Mono Slashed for Powerline
- Inconsolata-dz for Powerline: 작다. H=80
- Fira Mono for Powerline: 볼드체가 너무 겹친다.
- Hack 일반체: 볼드체가 너무 겹친다.
- Roboto Mono Light for Powerline: 약간 가는체인데 좋음.
- Source Code Pro 가는체

아쉽게나마 이렇게 사용하고 있었는데, 문득 생각이 나서 영문 폰트와 한글 폰트의 크기를 다르게 주기로 하였다. 일반 맥용 GUI에서나 볼 수 있는 한글 자간과 줄간이 볼 수 있게 되었다.

![iTerm font 2](https://c1.staticflickr.com/6/5607/29982593264_fc4b53bae5_z.jpg)

한글 폰트를 16pt로 변경하였다.

![iTerm Hangul font](https://c7.staticflickr.com/9/8681/30497254782_88dcf4680a_z.jpg)

줄간을 130%로 더 크게 변경하였다. 흡족한 화면이 나왔다.

![](https://c3.staticflickr.com/6/5560/30533427810_3a84f695c9_c.jpg)

물론 영문 폰트가 약간 작고, 특히 링크 밑줄이 표시되는 테마일 경우 줄이 일정하지 않지만 이게 어딘가? 마크다운 용 앱을 수십 개를 구매하고 공짜 앱까지 많은 에디터를 사용해보았지만, Vim을 뛰어넘는 편집 기능이 없어서 이렇게 사용하기로 하였고, 정 마음에 들지 않으면 [Marked 2](http://marked2app.com/)를 같이 사용한다. 폴더 와치 기능 때문에 Vimwiki를 사용할 때도 즐겨 쓴다.

![미리보기](https://c8.staticflickr.com/6/5602/30199615823_6ffc680650_c.jpg)

## 맺음말

이로써 내가 사용하는 주 텍스트 에디터는 서브라임 3와 MacVim이 되었다. 서브라임에서의 사용법은 아래 링크에 정리하였다.

- [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](https://nolboo.kim/blog/2014/04/15/how-to-use-markdown/)
