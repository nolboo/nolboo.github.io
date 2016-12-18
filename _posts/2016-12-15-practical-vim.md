---
layout: post
title: "Practical Vim 팁 요약 시리즈 - Setting and .vimrc file"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

1. 목차
{:toc}

- **프랙티컬 Vim 2판을 정리하는 페이지이며 내 편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

# Setting and .vimrc file

## APPENDIX 1. Customize Vim to Suit Your Preferences

Vim의 설정은 유연하다.

### Change Vim’s Settings on the Fly

Vim의 기능과 동작 방식을 변경할 수 있는 수백 가지 설정이 있다(`:h option-list`). 이 설정은 `:set` 명령을 사용한다.

'ignorecase'는 불린(boolean) 값이고, 켜고 끌 수 있다. 기능을 활성하려면:

```vim
:set ignorecase
```

비활성하려면 "no"를 앞에 붙인다:

```vim
:set noignorecase
```

뒤에 느낌표(!)를 붙이면 설정을 토글할 수 있다:

```vim
:set ignorecase!
```

뒤에 물음표(?)를 붙이면 현재 설정 값을 확인할 수 있다:

```vim
:set ignorecase?
ignorecase
```

기본 설정으로 재설정하려면 끝에 `&`를 붙인다:

```vim
:set ignorecase&
:set ignorecase?
noignorecase
```

Vim 설정 중에는 문자열이나 숫자를 값으로 사용하기도 한다. 예를 들어 'tabstop' 설정은 탭 문자가 나타내는 열 수를 설정한다(`:h 'tabstop'`):

```vim
:set tabstop=2
```

set 구문 하나로 여러 설정을 지정할 수도 있다:

```vim
:set ts=2 sts=2 sw=2 et
```

'softtabpstop', 'shiftwidth', 'expandtab' 설정은 들여쓰기에도 영향을 준다. 더 많은 것을 알려면 Vimcasts의 에피소드인 [탭과 공백](http://vimcasts.org/episodes/tabs-and-spaces/)을 보라.

설정은 대부분 축약어도 있다. 'ignorecase' 설정은 `ic`로 줄일 수 있어 `:se ic!`로 토글하거나 `:se noic`로 비활성할 수 있다. 즉석에서 설정을 변경하는 경우는 축약어로 변경하지만, `vimrc` 파일에 입력할 때는 가독성을 위해 긴 이름을 사용한다.

Vim 설정은 대부분 전역으로 동작하지만, 일부 설정은 창이나 버퍼로만 제한해서 사용할 수 있다. `:setlocal tabstop=4`는 활성 버퍼에만 적용된다. 동시에 여러 파일을 열고 있다면 서로 다른 'tabstop' 설정을 각각 지정할 수도 있다. 같은 설정을 모든 버퍼에 적용하려면 다음과 같이 실행한다:

```vim
:bufdo setlocal tabstop=4
```

'number'설정은 창 단위로 설정할 수 있다. `:setlocal number`를 입력하면 활성 창에서 행 번호를 표시한다. 모든 창에서 행 번호를 표시하려면 다음 명령을 사용한다:

```vim
:windo setlocal number
```

`:setlocal` 명령은 현재 창이나 현재 버퍼에서만 설정을 변경할 때 사용할 수 있다(전역으로 사용할 수 있는 설정도 해당한다). `:set number`를 실행하면 현재 창에서 행 번호를 활성할 뿐만 아니라 전역 기본값도 설정한다. 현재 열려 있는 창은 지역 설정을 유지하지만 새로 열리는 창은 새 전역 설정에 따라 행 번호가 활성된다.

#### Save Your Configuration in a vimrc File

즉석에서 변경한 Vim 설정이 모두 잘 동작한다. 변경한 설정 중에서 특히 마음에 드는 기능이 있다면 파일로 저장할 수 있다. `:source {file}` 특정 `{file}`로부터 설정을 현재 편집 세션으로 불러올 수 있다(`:h :source`). 파일을 불러오면 파일의 각 행을 Ex 명령으로 여기고 실행한다.

들여쓰기를 두 칸 공백으로 사용하려면 다음과 같이 파일을 생성해서 저장해놓고 필요할 때마다 사용할 수 있다:

customizations/two-space-indent.vim

```vim
" Use two spaces for indentation
set tabstop=2
set softtabstop=2
set shiftwidth=2
set expandtab
```

이 설정을 현재 버퍼에 적용하고 싶다면:

```vim
:source two-space-indent.vim
```

명령행 가장 앞에 붙이는 콜론은 파일로 저장할 때는 필요 없다. `:source` 명령은 실행 파일의 각 행을 이미 Ex 명령으로 가정한다.

Vim을 시작하면 `vimrc` 파일이 존재하는지 먼저 확인한다. 파일이 있으면 존재하면 파일의 내용을 자동으로 실행한다.

Vim은 여러 위치에서 `vimrc`를 찾는다(`:h vimrc`). 유닉스 시스템에서는 `~/.vimrc` 파일을 찾는다. 윈도에서는 `$HOME/_vimrc` 파일을 찾는다. 시스템과 상관없이 `vimrc` 파일을 다음 명령으로 열 수 있다:

```vim
:edit $MYVIMRC
```

`$MYVIMRC`는 Vim에서 사용하는 환경변수로 `vimrc` 파일의 경로로 확장한다. `vimrc` 파일을 변경한 후 새로운 설정을 Vim 세션에 반영하려면 다음 명령을 실행한다:

```vim
:source $MYVIMRC
```

`vimrc` 파일이 활성 버퍼에 열려 있다면 `:so %`로 줄일 수 있다.

#### Apply Customizations to Certain Types of Files

설정을 파일 타입에 따라 적용할 수 있다. 예를 들어 루비(Ruby)는 2칸 들여쓰기를 사용하고 자바스크립트(JavaScript)는 4칸 들여쓰기를 사용하는 사내 규정이 있을 수 있다. 다음 설정을 vimrc에 추가할 수 있다:

customizations/filetype-indentation.vim

```vim
if has("autocmd")
  filetype on
  autocmd FileType ruby setlocal ts=2 sts=2 sw=2 et
  autocmd FileType javascript setlocal ts=4 sts=4 sw=4 noet
endif
```

`autocmd` 문은 이벤트가 발생하면, 특정 명령을 실행하는 선언문이다(`:h :autocmd`). 이 경우에는 `FileType` 이벤트를 기다리고 있다가 Vim이 현재 파일의 타입을 감지하면 지정한 명령을 실행한다.

같은 이벤트를 감지하는 하나 이상의 자동 명령(autocommand)을 사용할 수 있다. `nodelint`를 자바스크립트 파일의 컴파일러로 사용하려면 다음 예제처럼 이벤트를 하나 더 추가할 수 있다:

```vim
autocmd FileType javascript compiler nodelint
```

자바스크립트 파일을 열어서 `FileType` 이벤트를 호출할 때마다 두 가지 자동 명령을 모두 실행할 것이다.

한두 개 정도의 파일 타입을 설정할 때는 자동 명령을 `vimrc`에 추가하면 잘 동작한다. 특정 타입의 파일에 설정을 많이 하면 혼란스러워질 것이다. `ftplugin`은 파일 타입에 따라 설정을 적용할 수 있는 대안 구조이다. 이 플러그인을 사용하면 자바스크립트 설정을 vimrc에 선언하는 대신 `~/.vim/after/ftplugin/javascript.vim` 파일 안에 설정을 넣을 수 있다:

`customizations/ftplugin/javascript.vim`

```vim
setlocal ts=4 sts=4 sw=4 noet
compiler nodelint
```

이 파일은 일반 vimrc 파일과 같지만, 자바스크립트 파일에만 적용한다. 루비 설정을 위해 `ftplugin/ruby.vim` 파일을 만들 수도 있고 다른 파일 타입에도 적용할 수 있다(`:h ftplugin-name`).

`ftplugin` 구조를 사용하기 위해서는 파일 타입 감지와 플러그인을 모두 활성해야 한다. 다음 내용이 vimrc 파일에 있는지 확인한다:

```Vim
filetype plugin on
```

![Vim 3D](/images/posts/vim.jpg)

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


