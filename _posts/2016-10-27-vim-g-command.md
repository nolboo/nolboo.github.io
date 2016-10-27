---
layout: post
title: "Vim의 g 명령"
description: "Vim에서 g 명령을 사용하는 방법을 정리"
category: blog
tags: [editor, vim, command]
---

[Vim의 비주얼 모드와 텍스트 블록 저장과 파일 임포트](https://nolboo.kim/blog/2016/09/19/vim-visula-mode-block-export-import/)에서 `gvd`라는 명령을 알았는데 정확한 뜻을 알기 위해 `g` 명령을 검색한 것을 정리한다.

## `gj`/`gk`: 커서를 다음/이전 "row"로

`j`/`k`는 다음/이전 "줄"로 움직인다. 특히, 긴 줄이 똬리를 틀고 있을 때(wrapping) 매우 귀찮은데, row 단위로 움직이는 것이 더 낫다. `.vimrc`에 지정하여 기본값으로 설정할 수 있다.

```vim
noremap j gj
noremap k gk
```

## `gg`: 커서를 파일의 최상위로

이전 편집한 곳으로 돌아가려면 `''`를 사용한다. 파일을 전체 선택할 때 `ggVG`도 자주 사용한다. 그다음 `:!sort`로 파이핑하거나 `gw`로 형태를 바꾸거나 클립보드로 복사하곤 한다.

숫자를 앞에 붙이면 숫자 줄로 커서를 옮긴다. `10gg`는 10번째 줄로 옮기며, `10G`와 `:10<CR>`도 같다.

## `gt`와 `gT`: 다음/이전 탭으로

## `gf`: goto file. 커서 밑의 파일을 편집한다.

## `gw`: 비주얼 모드에서 선택한 블록을 줄 바꿈 한다.(hard wrapping)

`v`로 비주얼 모드로 전환한 후에 `gw`를 누르면 커서가 위치한 줄을 줄 바꿈 한다. 일반 모드에서 `gwv<CR>`하는 것도 같다. 

## `gv`: 이전 선택했던 블록을 다시 선택

`gv`는 비주얼 모드로 돌아가서 최근 선택한 것을 다시 선택한다. 이전 선택을 다시 조작할 때 매우 유용한다. `gvd`는 이전 선택을 지운다. `v` 앞에 숫자를 붙이면 최근 선택을 재선택하고 숫자만큼 선택의 길이를 늘인다. 

## 참고 링크

- [Code Kills : You and Your Editor: Vim normal mode commands g, : and d (3 of N)](http://blog.codekills.net/2009/12/05/you-and-your-editor--vim-normal-mode-commands-g,---and-d-(3-of-n)/): 이 필자는 [Code Kills : You and Your Editor: Data from vim-logging (2 of N)](http://blog.codekills.net/2009/12/05/you-and-your-editor--data-from-vim-logging-(2-of-n)/)에서 보듯이 `g` 명령을 다른 명령보다 수십배 많이 쓴다.
- [Vim 101: Visual Mode](http://usevim.com/2012/05/11/visual/)
