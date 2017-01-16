---
layout: post
title: "Practical Vim 팁 요약 시리즈 - grep and vimgrep"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

![Vim 3D](/images/posts/vim.jpg)

1. 목차
{:toc}

## CHAPTER 18. Search Project-Wide with grep, vimgrep, and Others

Vim의 검색 명령은 파일 내의 모든 패턴을 찾는 데 탁월하다. 그러나 전체 프로젝트에서 일치하는 항목을 찾으려면 어떻게 해야 할까? 많은 파일을 살펴봐야 한다. 전통적으로 이것은 유닉스 검색 전용 도구 인 grep의 영역이다.

편집기를 떠나지 않고도 외부 프로그램을 호출할 수 있는 `:grep` 명령을 살펴본다. 이 명령은 기본적으로 grep을 호출하지만, `ack`와 같은 다른 검색 전용 프로그램을 사용하도록 설정할 수 있다.

외부 프로그램을 사용할 때의 한 가지 단점은 정규식 구문이 대부분의 Vim 검색에 사용되는 구문과 호환되지 않을 수 있다. `:vimgrep` 명령을 사용하면 Vim의 기본 검색 엔진을 사용하여 여러 파일의 패턴을 찾을 수 있다. `vimgrep`은 전용 프로그램만큼 빠르지 않다.

### Tip 109. Call grep Without Leaving Vim

`:grep` 명령은 외부의 `grep` (또는 grep 같은) 프로그램을 사용할 수 있는 래퍼(wrapper)처럼 동작한다. 이 래퍼를 사용하여 Vim을 벗어나지 않고 여러 파일에 걸쳐 `grep` 패턴 검색을 할 수 있고, 퀵픽스 목록을 사용하여 검색 결과를 오갈 수 있다.

#### Using grep from the Command Line

```shell
$ grep -n {text} *
```

기본적으로 `grep`은 일치하는 행의 내용과 파일명을 한 줄로 보여준다. `-n` 플래그는 `grep`에게 출력에 행 번호를 표시한다.

검색 결과 항목을 표처럼 다룰 수 있다. 결과 목록의 각 항목에서 파일을 열 수 있고, 행 번호를 지정할 수 있다. goldrush.txt의 9행을 열고 싶다면:

```shell
$ vim contain-result.txt +9
```

#### Calling grep from Inside Vim

`:grep` 명령은 외부 `grep` 프로그램의 레퍼(wrapper)이다(:h :grep). 셸에서 `grep`을 실행하는 대신에 Vim에서 직접 실행할 수 있다.

```vim
:grep {text} *
```

Vim이 `grep -n {text} *`을 셸에서 실행한다. Vim은 `grep` 검색 결과를 해석해서 퀵픽스 목록으로 만든다. `:cnext`, `:cprev` 명령으로 결과를 탐색할 수 있으며 모든 기능을 사용할 수 있다.

Vim은 자동으로 `-n` 플래그를 추가해서 grep 결과에 행 번호도 출력한다. 퀵픽스 목록을 탐색할 때, 일치하는 각 행으로 바로 이동할 수 있는 이유이다.

대소문자를 구분하지 않으려면 `-i` 플래그를 사용한다.

### Tip 110. Customize the grep Program

`:grep` 명령은 외부 `grep` 프로그램을 실행하기 위한 래퍼이다. Vim이 이 명령을 처리하는 방법을 'grepprg'와 'grepformat' 설정을 수정하여 변경할 수 있다.

#### Vim’s Default grep Settings

'grepprg' 설정은 `:grep` 명령을 실행할 때 셸에서 실행하는 명령을 지정한다(:h 'grepprg'). 'grepformat' 설정은 Vim이 `:grep` 명령의 출력 결과를 해석하는 방법을 지장한다(:h 'grepformat'). Unix 시스템에서는 기본 값이 다음과 같다:

```shell
grepprg="grep -n $* /dev/null"
grepformat="%f:%l:%m,%f:%l%m,%f %l%m"
```

'grepprg' 설정에서는 $* 기호를 플레이스홀더로 사용하는데 `:grep` 명령의 인자가 위치하는 곳을 뜻한다.
'grepformat' 설정은 `:grep`이 반환하는 결과 메시지의 구조를 토큰으로 작성한 문자열이다. 'grepformat' 문자열에서 사용되는 특수 토큰은 'errorformat'에 사용 된 것과 같다.

이제 `%f:%l %m` 기본 형식을 사용한 grep 결과를 확인한다.

```shell
department-store.txt:1:Waldo is beside the boot counter.
goldrush.txt:6:Waldo is studying his clipboard.
goldrush.txt:9:The penny farthing is 10 paces ahead of Waldo.
```

각 레코드에서, `%f`가 파일명(department-store.txt나 goldrush.txt)에 해당하고, `%l`은 행 번호, `%m`은 행의 일치하는 문자열이다.

'grepformat' 문자열은 쉼표로 구분된 여러 형식을 포함할 수 있다. 기본 일치는 `%f:%l %m` 또는 `%f %l%m`이다. Vim은 `:grep` 출력과 일치하는 첫 번째 형식을 사용한다.

#### Make `:grep` Call ack

`ack`는 grep 대용이고 특히 개발자를 대상으로 한다.(http://betterthangrep.com)

먼저 ack를 설치해야 한다. 우분투에서:

```shell
$ sudo apt-get install ack-grep
$ sudo ln -s /usr/bin/ack-grep /usr/local/bin/ack
```

첫 명령은 프로그램을 설치하고 `ack-grep` 명령을 사용할 수 있게 한다. 두 번째 명령은 `ack`로 호출할 수 있도록 심볼릭링크를 생성한다.

OS X에서는 Homebrew로 설치할 수 있다:

```shell
$ brew install ack
```

이제 'grepprg'와 'grepformat' 설정을 변경해서 `:grep`이 `ack`를 사용하도록 설정 한다. `ack`에서는 파일명을 한 줄로 출력하고, 행 번호와 일치하는 행의 내용이 뒤따른다:

```shell
$ ack Waldo *
department-store.txt
1:Waldo is beside the boot counter.

goldrush.txt
6:Waldo is studying his clipboard.
9:The penny farthing is 10 paces ahead of Waldo.
```

`--nogroup` 스위치와 함께 `ack`를 실행하면 `grep -n`의 결과처럼 출력을 쉽게 변경할 수 있다.

```shell
$ ack --nogroup Waldo *
department-store.txt:1:Waldo is beside the boot counter.
goldrush.txt:6:Waldo is studying his clipboard.
goldrush.txt:9:The penny farthing is 10 paces ahead of Waldo.
```

이 출력은 `grep -n`의 형식과 일치한다. Vim의 기본 'grepformat' 설정은 변경할 필요 없다. 'grepprg'만 다음처럼 변경한다:

```vim
:set grepprg=ack\ --nogroup\ $*
```

>
#### Alternative grep Plugins
>
Vim에서는 외부 프로그램을 사용해서 여러 파일의 본문을 쉽게 검색할 수 있다. 단순히 'grepprg'와 'grepfotmat' 설정을 변경한 다음에 `:grep` 명령을 사용하면 끝이다. 그 결과는 퀵픽스 목록에서 확인할 수 있다. 어떤 프로그램을 호출하는지에 상관없이 사용할 수 있기 때문에 거의 이상적인 인터페이스이다.
>
그러나 중요한 차이가 있다. `grep`은 POSIX 정규표현식을 사용하나 `ack`는 펄의 정규표현식을 사용한다. `:grep` 명령을 사용하여 `ack`를 호출하면 이 차이 때문에 제대로 호출되지 않는다. `:Ack`라는 명령을 직접 만들어서 이름처럼 `ack`를 호출하는 것은 어떨까?
>
이런 접근 방법으로 개발된 `Ack.vim` 플러그인이 있다.[mileszs/ack.vim: Vim plugin for the Perl module / CLI script 'ack'](https://github.com/mileszs/ack.vim) 또한, `git-grep`을 사용할 수 있도록 `:Ggrep` 명령을 제공하는 `fugitive.vim` 플러그인도 있다.[tpope/vim-fugitive: fugitive.vim: a Git wrapper so awesome, it should be illegal](https://github.com/tpope/vim-fugitive)
>
이렇게 여러 플러그인을 설치할 수 있고, `:grep` 명령을 대체하는 방식보다 각 플러그인의 커스텀 명령을 만들어 서로 충돌없이 공존할 수 있다.
>

#### Make ack Jump to Line and Column

그러나 `ack`는 또 다른 기법을 소매 속에 숨기고 있다. `--column` 옵션과 함께 실행하면 `ack`는 일치하는 행과 _열 번호_ 를 출력한 다.

```shell
$ ack --nogroup --column Waldo *
department-store.txt:1:1:Waldo is beside the boot counter.
goldrush.txt:6:1:Waldo is studying his clipboard.
goldrush.txt:9:41:The penny farthing is 10 paces ahead of Waldo.
```

'grepformat'이 추가 정보를 추출할 수 있도록 설정하면 일치하는 행으로 이동하는 것뿐만 아니라 일치하는 정확한 위치로 이동할 수 있다. 다음 설정으로 쉽게 된다:

```vim
:set grepprg=ack\ --nogroup\ --column\ $*
:set grepformat=%f:%l:%c:%m
```

`%c` 항목이 일치하는 열 번호이다.

### Tip 111. Grep with Vim’s Internal Search Engine

`:vimgrep` 명령으로 Vim의 내장 정규표현식 엔진을 사용해서 여러 파일을 검색할 수 있다.

`grep/quotes` 폴더에서 각 파일은 단어 "going"을 하나 이상 포함하고 있다. `:vimgrep` 명령을 사용하여 이 단어를 어떤 파일이 포함하고 있는지 찾으려면:

```vim
:vimgrep /going/ clock.txt tough.txt where.txt
(1 of 3): Don't watch the clock; do what it does. Keep going.
:cnext
(2 of 3): When the going gets tough, the tough get going.
:cnext
(3 of 3): If you don't know where you are going,
```

`:vimgrep` 명령은 일치한 항목을 각각 한 줄씩 퀵픽스 목록을 만든다. `:cnext`, `:cprev`와 같은 명령을 사용해서 결과를 탐색한다.

`tough.txt` 파일은 "going"이 두 번 나타난다. 하지만 `:vimgrep` 명령은 첫 일치하는 것만 고려한다. 모든 항목을 찾으려면 `g` 플래그를 패턴 뒤에 추가한다.

```vim
:vim /going/g clock.txt tough.txt where.txt
(1 of 4): Don't watch the clock; do what it does. Keep going.
```

이번에는 "going" 단어가 나타나는 모든 항목이 퀵픽스 목록에 포함한다. `:substitute` 명령이 동작하는 방식이 기억날 것이다: 기본적으로는 행에서 첫 번째 일치하는 항목에 대해서만 치환을 수행한다. `g` 플래그를 제공했을 때 주어진 행에서 일치하는 모든 것에 대해 수행한다. 필자는 `:substitute`나 `:vimgrep` 명령을 사용 할 때 거의 항상 `g` 플래그를 넣어서 사용한다.

#### Specifying Which Files to Look Inside

다음은 `:vimgrep` 명령 형식이다(:h :vimgrep).

```vim
:vim[grep][!] /{pattern}/[g][j] {file} ...
```

`{file}` 인자는 빈칸으로 남겨둘 수 없다. 이 인자에는 파일명이나 와일드카드, 역따옴표 표현식, 그리고 이 모든 것을 조합할 수도 있다. 인자 목록을 불러올 때 사용할 수 있던 그 기법을 여기에서도 사용할 수 있다.

와일드카드를 사용해서 동일한 검색을 수행할 수 있다:

```vim
:vim /going/g *.txt
```

`*`과 `**` 와일드카드를 사용한 것처럼 인자 목록에 있는 파일을 모두 열기 위해서 `##` 기호를 사용할 수 있다(:h cmdline-special). 이 기호를 사용하면 조금 다른 방식으로도 작업을 진행할 수 있다. 먼저 인자 목록에 검사할 파일을 불러온다. 그런 다음 인수 목록의 각 파일에 대해 `:vimgrep`을 실행한다.

```vim
:args *.txt
:vim /going/g ##
(1 of 4): Don't watch the clock; do what it does. Keep going.
```

Ex 명령 두 개로 분리해서 실행하기 때문에 더 일하는 것 같지만 `:vimgrep`을 사용할 때는 이 방식을 종종 선호한다. 어느 파일을 검색하고 싶은가, 그리고 어떤 패턴을 검색하고 싶은가로 분리해서 생각할 수 있기 때문이다. 인자 목록으로 파일을 불러 온 후에 `:vimgrep` 명령을 사용하고 싶은 만큼 반복할 수도 있다.

#### Search in File, Then Search in Project

`:vimgrep`에 패턴 필드를 비워두면 현재 검색 패턴을 다시 사용할 수 있다. `:substitute` 명령과 `:global` 명령에서도 같은 트릭을 사용할 수 있다. 이 방법은 여러 파일에 걸쳐 정규표현식을 사용할 때 유용하다. 현재 파일에서 정규표현식을 조합하고 적합한 정규표현식을 작성할 때까지 반복한다. 패턴 결과가 마음에 들 때 `:vimgrep` 명령을 사용한다. 다음은 "don't"와 "Don't" 모두 일치하는 정규표현식을 현재 파일 내에서 검색한 후 `:vimgrep`을 사용한다:

```vim
/[Dd]on't
:vim //g *.txt
(1 of 2): Don't watch the clock; do what it does. Keep going.
```

`:vimgrep`의 가장 큰 장점은 Vim의 검색 명령과 같은 패턴을 사용할 수 있다는 것이다. 검색 패턴을 사용한 후에 같은 검색 패턴으로 `:grep`으로 프로젝트 기준 검색을 수행하려면 먼저 POSIX 정규표현식으로 번역해야 한다. 간단한 정규표현식은 오래 걸리지 않겠지만, 복잡한 정규표현식은 하고 싶지 않을 것이다.

#### Search History and :vimgrep

인자 목록에서 현재 검색 패턴과 일치하는 파일이 얼마나 있는지 확인하기 위해 다음 명령을 사용할 수 있다:

```vim
:vim //g ##
```

주의 깊게 봐야 하는 부분은 항상 인자 목록(##)과 검색 히스토리의 현재 정보를 사용한다는 것이다. 만약 이 명령을 나중에 반복하면 인자 목록과 검색 히스토리에 따라서 다르게 동작할 것이다.

그 대신에 `<C-r>/`로 검색 필드를 현재 패턴의 값으로 채울 수 있다. 검색 결과는 어느 쪽이든 같지만 명령 히스토리는 다르다.

```vim
:vim /<C-r>//g ##
```

`:vimgrep` 명령을 다시 사용하더라도 패턴이 명령 히스토리에 포함되어 있기 때문에 더 유용할 것이다.

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


