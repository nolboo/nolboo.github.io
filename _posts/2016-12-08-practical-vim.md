---
layout: post
title: "Practical Vim 팁 요약 시리즈 - Buffer and Argument List"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

1. 목차
{:toc}

- **iBooks로 읽는 프랙티컬 Vim 2판을 정리하는 페이지이며 내편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

# Buffer and Argument List

## Part II. Files

## Chapter 6. Manage Multiple Files

### Tip 37. Track Open Files with the Buffer List

편집 세션에서 여러 파일을 열 수 있다. 버퍼 목록으로 파일을 관리할 수 있다.

#### Understand the Distinction Between Files and Buffers

Vim에서 실제로 파일을 편집하는 것이 아니다. 사실은 메모리 공간에 파일을 복사해서 편집하는 것이다. 메모리에 존재하는 파일의 사본을 Vim에서는 버퍼(buffer)라고 한다.

파일은 디스크에 보관하고 버퍼는 메모리에 보관한다. 파일을 열면 같은 이름으로 내용을 버퍼에 불러온다. 처음에는 버퍼와 파일의 내용이 일치하지만 버퍼의 내용을 수정하는 순간부터 달라진다. 만약 버퍼에서 변경한 사항을 유지하고 싶다면 버퍼의 내용을 다시 파일로 저장하면 된다. Vim 명령은 대부분 버퍼에서 동작하지만 `:write`, `:update`, `:saveas` 명령처럼 파일을 위한 명령도 있다.

#### Meet the Buffer List

Vim이 실행되면서 파일을 불러오면 첫 번째 파일을 창에 출력한다. 두 번째 파일은 버퍼로 불러온 후 백그라운드에 놓이기 때문에 보이지 않는다. `:ls` 명령으로 현재 메모리에 존재하는 모든 버퍼 목록을 확인할 수 있다 (:h :ls 참고).

다음 버퍼를 현재 창으로 불러오고 싶다면 `:bnext` 명령을 사용한다. 버퍼목록에서 `%` 기호는 현재 창에서 볼 수 있는 버퍼를 표시한다. `#` 기호는 현재 활성된 버퍼와 교대한 버퍼를 나타낸다. `<Ctrl-^>`로 현재 버퍼와 이전 버퍼를 전환할 수 있다.

#### Use the Buffer List

버퍼 목록에서 `:bprev`, `:bnext`로 전후 이동을 할 수 있으며, `:bfirst`와 `:blast` 명령으로 목록의 처음과 끝으로 이동할 수 있다. 팀 포프의 unimpaired.vim1 플러그인에서는 다음과 같은 맵핑을 사용하고 있다.

```vim
nnoremap <silent> [b :bprevious<CR>
nnoremap <silent> ]b :bnext<CR>
nnoremap <silent> [B :bfirst<CR>
nnoremap <silent> ]B :blast<CR>
```

* `:h [`도 참고

unimpaired.vim 플러그인은 인자 목록([a와 ]a), 퀵 픽스 목록([q, ]q), 위치 목록([l, ]l), 태그 목록([t, ]t)에서 사용할 수 있다.

`:ls` 버퍼 목록 앞의 숫자를 사용해서 `:buffer N`으로 숫자에 해당하는 버퍼로 이동할 수 있다(:h :b 참고). `:buffer {bufname}`이 좀 더 직관적이다. {bufname}은 파일 경로를 기준으로 각각의 버퍼를 구분할 수 있는 명칭을 사용해야 한다. 입력한 버퍼명이 둘 이상인 경우에는 탭 완성을 사용할 수 있다.

`:bufdo` 명령으로 버퍼 목록에 있는 모든 버퍼를 대상으로 Ex 명령을 사동할 수 있다(:h :bufdo 참고). 실제로는 `:argdo` 명령을 더 자주 사용한다.

#### Deleting Buffers

버퍼를 제거하고 싶다면 `:bdelete` 명령을 사용할 수 있다.

```vim
:bdelete N1 N2 N3
:N,M bdelete
```

5번 버퍼부터 10번 버퍼까지 연속된 버퍼를 제거하려면 `:5,10bd` 명령을 사용한다. 8번 버퍼는 유지하고 싶다면 `:bd 5 6 7 9 10`으로 입력해서 8번을 제외하고 제거할 수 있다.

버퍼 목록을 다시 조정할 수 있는 기능이 없다. 대신에 작업 환경을 창이나 탭, 인자목록으로 나눠서 관리할 수 있다.

#### Group Buffers into a Collection with the Argument List

:args으로 인자 목록을 확인할 수 있다.

실행할 때 *.txt라는 인자로 실행했어도 셸은 * 와일드 카드를 확장해서 패턴이 일치하는 파일 다섯 개를 인자로 집어넣는다. 출력된 인자 목록에서 볼 수 있는 `[]` 문자는 현재 열려 있는 파일을 표시한다.

버퍼 목록은 Vim에서 개선된 기능이지만, 인자 목록은 vi에서도 제공했던 기능이다.

인자 목록의 내용은 언제든 수정할 수 있다. 다시 말해 `:args`의 목록은 Vim을 실행할 당시의 인자를 항상 반영하는 것은 아니란 뜻이다. 다른 명령도 마찬가지다. `:compiler`와 `:make`는 컴파일 언어만을 위한 것이 아니다.

#### Populate the Argument List

`:args {arglist}` 명령으로 인자 목록을 갱신할 수 있다(:h :args_f 참고). `{arglist}`은 파일명이나 와일드카드, 셸 명령의 출력을 포함할 수 있다.

인자 목록에 파일명을 입력하는 가장 간단한 방법은 하나씩 직접 입력 하는 것이다.

와일드카드를 이용해서 인자 목록에 등록할 수 있다.(:h wildcard 참고). `**` 와일드카드도 파일명에 문자가 없거나 하나 이상 존재하는 경우를 뜻한다. 차이가 있다면 특정 디렉터리 안에 존재하는 부 디렉터리까지 모두 재귀적으로 검색해서 파일을 찾는다는 점이다(:h starstar-wildcard 참고). 이렇게 요청한 경로와 일치하는 파일 목록을 불러오기 위해 와일드카드 조합을 사용할 수 있는데 이 방법을 글롭(glob)이라 한다.

파일 목록을 일반 문서 파일로 작성해서 관리할 수 있다. `files/.chapters`로 작성하면 ``:args `cat .chapters` ``과 같이 사용할 수 았다.

cat 명령을 사용했지만 셸에서 구동할 수 있는 명령은 어떤 것이든 인자 목록 명령과 함께 사용할 수 있다. 모든시스템에서 동작하지는 않는다(:h backtick-expansion 참고).

#### Use the Argument List

인자 목록은 버퍼 목록보다 간단하다. 파일을 필요에 따라 마음대로 묶어서 관리할 수도 있다. `:args {arglist}` 명령으로 인자 목록을 비우고 다시 입력할 수 있다. `:next`와 `:prev`으로 인자 목록에 있는 다음 또는 이전 파일을 버퍼로 불러낼 수 있다. `:argdo`로 인자 목록의 각각 버퍼에 동일한 명령을 실행할 수 있다.

버퍼 목록은 바탕 화면처럼 언제나 난장판이 된다. 인자 목록은 분리된 작업 공간처럼 작업 환경을 단정하게 유지할 수 있고 필요에 따라 작업 공간을 확장하는 것도 가능하다.

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


