---
layout: post
title: "Practical Vim 2판 정리 페이지"
date: 2016-11-11 17:00:00
---

<a target="_blank"  href="https://www.amazon.com/gp/product/B018T6ZVPK/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B018T6ZVPK&linkCode=as2&tag=nolbookim-20&linkId=45b16dbe20fb6e3a35a594a85f9ba1a6"><img border="0" src="//ws-na.amazon-adsystem.com/widgets/q?_encoding=UTF8&MarketPlace=US&ASIN=B018T6ZVPK&ServiceVersion=20070822&ID=AsinImage&WS=1&Format=_SL250_&tag=nolbookim-20" ></a><img src="//ir-na.amazon-adsystem.com/e/ir?t=nolbookim-20&l=am2&o=1&a=B018T6ZVPK" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />

**iBooks로 읽는 프랙티컬 Vim 2판을 정리하는 페이지이며 내편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**

`-u NONE`로 환경설정 없이 실행하면 vi 호환 모드로 실행되니, `-N`로 `nocompatible` 모드로 실행.

```shell
$ vim -u NONE -N
```

Vim 빌트인 플러그인을 요구할 때는

```vim
set nocompatible
filetype plugin on
```
`essential.vim`에 입력한 후:

```shell
$ vim -u essential.vim
```

로 실행한다. netrw, 옴니 완성 등을 실행할 수 있다.

`:version`으로 설치된 Vim의 버전과 컴파일 설정을 볼 수 있다.

- [ ] :version 으로 보니 -hangul_input이 포함되지 않고 컴파일되었네??

## 1. The Vim Way

우리 일은 본래 반복적이다. Vim은 반복에 최적화되어있다. _Vim의 효율성은 가장 최근 작업을 추적하는 방법에서 유래한다_. 작업 단위를 잘 고려하면 하나의 키로 재반복할 수 있다. 이 개념에 숙달하는 것이 Vim으로 효과적이 되는 주요한 점이다.

`.` 명령은 시작이다.

### Dot Command

`.` 명령은 가장 최근의 변경을 반복한다.([+](http://vimhelp.appspot.com/repeat.txt.html#.)) Vim에서 가장 강력하고 만능인 명령어이다. Vim의 모달 편집 모드의 핵심을 알 수 있다.

>
[Why, oh WHY, do those #?@! nutheads use vi?](http://www.viemu.com/a-why-vi-vim.html)
>
Vim을 올바르게 쓰려면 모달하게 쓰지 말고, 항상 일반모드에 있어야 한다. 편집모드에서는 텍스트만 입력하고, 입력하고 난 후에는 `Esc`로 일반모드로 돌아와야한다. 그래서, 모드를 기억해야 하는 문제는 없다: 텍스트를 입력하는 중 전화가 온다면 편집모드를 나가고 전화를 받아야 한다. 그렇지 않으면 Vim으로 돌아올 때 `Esc`를 누르도록 한다.
>
좋은 장점은 `.` 명령이 가장 최근의 _완료된, 이어진_ 편집 명령(커서 이동은 제외)을 반복한다는 것이다. 일반모드에서 `iHello<Esc>`를 입력한 후 Dot 명령은 커서의 위치에 'Hello'를 입력한다.
>

Dot 명령은 마이크로 매크로이다.

### Don’t Repeat Yourself

---

다 읽으려면 한 백일 걸릴라나?^^

![Practical Vim cover](https://c2.staticflickr.com/6/5572/30911777505_03e3ec069f_n.jpg)

