---
layout: post
title: "Vim의 플러그인 관리자 Vundle과 플러그인 설치"
description: "14000여 개의 Vim 플러그인을 설치하고 관리하는 플러그인 관리자 Vundle을 설치하고 플러그인 설치하는 법"
category: blog
tags: [editor, vim, plugin, manager]
---

[MacVim과 Vim 8 설치](https://nolboo.kim/blog/2016/09/16/vim-8-upgrade/)하였다. 본격적으로 Vim을 사용하기 위해 플러그인을 활용하자. 플러그인 검색 사이트인 [Vim Awesome](http://vimawesome.com/)을 보면 14,000여 개의 플러그인들이 기다리고 있다. 먼저 플러그인을 쉽게 관리할 수 있는 [Vundle](https://github.com/VundleVim/Vundle.Vim)을 설치한다.

## Vundle(Vim Bundle) 설치

먼저 Git을 설치해야 하는데 만약 설치되지 않았거나 Git을 처음 접하는 분은 [완전 초보를 위한 깃허브](https://nolboo.kim/blog/2013/10/06/github-for-beginner/)를 보고 천천히 따라 하면 된다. 깃을 설치한 후 Vundle 저장소를 클론한다.

<pre class="terminal">
git clone https://github.com/VundleVim/Vundle.vim.git ~/.vim/bundle/Vundle.vim
</pre>

이제 `vi .vimrc`로 Vim 설정 파일을 열고 [Vundle Quick Start](https://github.com/VundleVim/Vundle.Vim#quick-start)의 플러그인 설정 샘플을 가장 위에 붙여넣는다.

```vim
call vundle#begin()
Plugin 'VundleVim/Vundle.vim'
...
" Plugin 'git://git.wincent.com/command-t.git'
" Plugin 'file:///home/gmarik/path/to/plugin'
...
call vundle#end()
```

샘플의 Plugin 두 줄은 위와 같이 `" `로 주석처리 한다. 설명하기 위해 넣은 것이라 에러가 난다.

자신이 원하는 플러그인을 추가하려면 `call vundle#begin()`과 `call vundle#end()` 인을 `Plugin 'GitHub repo'` 형식으로 추가할 수 있다. [Vim Awesome](http://vimawesome.com/)의 개별 플러그인 페이지에 보면 대부분 예시가 나와 있어 어렵지 않게 추가할 수 있다.

> OS X에 내장된 vim을 사용할 때 주의사항이 [위키](https://github.com/VundleVim/Vundle.vim/wiki#mac-osx-problems)에 적혀있으나 [ Vim 8을 설치](https://nolboo.kim/blog/2016/09/16/vim-8-upgrade/)했으니 참고만 한다.

설정을 추가한 후에 `:w`로 저장한 후 변경된 `.vimrc` 파일을 `:source %` 또는 `:so %` 명령으로 재로드한다.(%는 현재 버퍼에 있는 내용이라는 뜻)

vim 명령 모드에서 `:PluginInstall`을 실행하거나 터미널에서 `vim +PluginInstall +qall`로 플러그인을 설치한다.

Helptags 까지 끝나고 Done! 이라고 메시지가 나오면 완료된 것이다. Helptags는 도움말을 만드는 것이다. 새로 설치된 플러그인 앞에는 + 표시가 보인다.

![Vundle](https://c1.staticflickr.com/9/8265/29696429672_29555c3282_c.jpg)

`q` 로 Vundle 창을 닫는다.

플러그인을 삭제하려면 `.vimrc`에서 플러그인을 삭제한 후 `so %`로 파일을 재로드한 후 `:PluginClean` 명령으로 삭제할 수 있다.

## 테마

이제 테마를 설치해보자. [Vim Awesome](http://vimawesome.com/) 사이트에서 "theme"으로 검색해보면 1위가 [vim-colors-solarized](http://vimawesome.com/plugin/vim-colors-solarized-ours)이다. `Plugin 'altercation/vim-colors-solarized'`을 추가하고 재로드하면 바로 적용되는 것처럼 보인다.

그러나 다음 설정을 `.vimrc` 파일 마지막에 추가하는 것이 정확하다.

```vim
syntax enable
set background=dark
colorscheme solarized
```

> MacVim GUI에서는 메뉴에 "Solarized" 항목이 추가되어 메뉴에서 직접 설정을 변경할 수 있다.

## NERDTree

Vim에는 Netrw라는 파일 브라우저가 기본적으로 내장되어 있어 :Explore 라는 명령으로 폴더를 이동하고 파일을 선택할 수 있다. 이 기능을 확장해주는 NERDTree를 설치해보자. [Vim Awesome](http://vimawesome.com/) 사이트에서 플러그인 전체 1위이다.

[The NERD tree 페이지](http://vimawesome.com/plugin/nerdtree-red)에 자세한 설명이 있으니 그대로 따라서 설치한다.

Vim 명령모드에서 `:NERDTree`로 실행한다. 왼쪽으로 내비게이션 창이 뜨면서 폴더와 파일을 조작할 수 있다. `?`로 NERDTree 전용 명령에 대한 Help를 볼 수 있다. 물론 `h/j/k/l` 키로 이동할 수 있고, `Enter`로 파일을 선택할 수 있다. `/`로 파일 검색을 할 수도 있다.

특별한 키는 `C`는 선택한 폴더를 root 폴더로 만들어준다.

내비게이션을 끝내는 명령어는 `q`이다.

## 마크다운

마크다운 플러그인은 사용법이 조금 복잡한 것이 많다. 더 테스트한 후에 별도의 포스트로 작성하려고 한다. 작성하면 이곳에 링크를^^

## 추가 링크

* [junegunn/vim-plug: Minimalist Vim Plugin Manager](https://github.com/junegunn/vim-plug) Vundle을 뛰어넘는 병령처리 플러그인 관리 플러그인. 엄청나게 빠름.
