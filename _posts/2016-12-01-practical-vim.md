---
layout: post
title: "Practical Vim 팁 요약 시리즈 - DRY: Dot"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

1. 목차
{:toc}

- **iBooks로 읽는 프랙티컬 Vim 2판을 정리하는 페이지이며 내편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

# DRY: Dot

## Use Vim’s Factory Settings

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

우리 일은 본래 반복적이다. Vim은 반복 작업에 최적이다. _Vim의 효율성은 가장 최근 작업을 추적하는 방법에서 유래한다_. 작업 단위를 잘 고려하면 하나의 키로 반복할 수 있다. 이 개념에 숙달하는 것이 Vim을 효과적으로 사용하는 비결이다.

`.` 명령은 시작이다.

### Tip 1. Dot Command

`.` 명령은 가장 최근의 변경을 반복한다.([+](http://vimhelp.appspot.com/repeat.txt.html#.)) Vim에서 가장 강력하고 만능인 명령어이다. Vim의 모달 편집 모드의 핵심을 알 수 있다.

>
[Why, oh WHY, do those #?@! nutheads use vi?](http://www.viemu.com/a-why-vi-vim.html)
>
Vim을 올바르게 쓰려면 모달하게 쓰지 말고, 항상 일반 모드에 있어야 한다. 입력 모드에서는 텍스트만 입력하고, 입력하고 난 후에는 `Esc`로 일반 모드로 돌아와야한다. 그래서, 모드를 기억해야 하는 문제는 없다: 텍스트를 입력하는 중 전화가 온다면 입력 모드를 나가고 전화를 받아야 한다. 그렇지 않으면 Vim으로 돌아올 때 `Esc`를 누르도록 한다.
>
좋은 장점은 `.` 명령이 가장 최근의 _완료된, 이어진_ 편집 명령(커서 이동은 제외)을 반복한다는 것이다. 일반 모드에서 `iHello<Esc>`를 입력한 후 Dot 명령은 커서의 위치에 'Hello'를 입력한다.
>

- `x`를 `.`으로 반복하고 `u`로 undo한다.
- `dd`로 현재 줄을 지우고, `x`로 반복한다.
- `>G`로 현재 줄을 들여쓰고, `j`로 이동한 후 `.j`(=`>Gj`)로 반복한다.

Dot 명령은 마이크로 매크로이다.

### Tip 2. Don’t Repeat Yourself

* 소스 코드는 [여기](https://pragprog.com/titles/dnvim/source_code)에서 내려받을 수 있다.

`the_vim_way/2_foo_bar.js`의 줄 끝에 `;`를 추가할 때, `$`로 첫줄의 끝으로 이동한 후 `a;`로 `;`을 추가한다. `j$`로 다음 줄의 끝으로 이동한 후 `.`(=`a;`), 다시 `j$`로 다음 줄로 이동, `.`을 입력한다.

`A`는 `$a`와 같다. Vim에는 여러 복합 명령(둘 또는 그 이상의 명령을 하나로 압축한 명령)이 있다. 아래 표에 몇 개의 보기를 모았다.

| 복합 명령 | 동일 명령 |
|-----------|-----------|
| C         | c$        |
| s         | cl        |
| S         | ^C        |
| I         | ^i        |
| A         | $a        |
| o         | A`<CR>`   |
| O         | ko        |

`ko`(더 나쁘게는 `k$a<CR>`)보다는 `O` 명령을 대신 사용한다.

위의 명령은 모두 일반 모드에서 입력 모드로 전환한다. dot 명령에 어떻게 영향을 미칠지 생각하라.

이제 이전 보기를 세련되게 해본다. `A;<Esc>`로 첫줄 끝에 `;`를 추가한다. 두번의 `j.`로 끝낸다.

### Tip 3. Take One Step Back, Then Three Forward

`the_vim_way/3_concat.js`의

```javascript
var foo = "method("+argument1+","+argument2+")";
```

를

```javascript
var foo = "method(" + argument1 + "," + argument2 + ")";
```

처럼 만들어 본다. 줄의 처음에서 `f+`로 이동하여 `s`로 커서 밑의 글자를 지우고 입력 모드로 들어간다. ` + `를 입력하고 `<Esc>`로 일반 모드로. 한 보 뒤로 세 보 앞으로. 직관적이진 않지만 `.` 명령으로 반복할 수 있다. `;`로 다음 `+`로 이동하고 `.`로 계속 반복하여 끝낸다.

> `;`                       Repeat latest f, t, F or T [count] times
> `:browse old`             최근 편집한 파일 목록을 보고, 선택하여 연다.

#### Make the Motion Repeatable

다른 트릭이 있다. `f{char}` 명령은 다음 특정 문자로 커서를 이동한다. `f+`는 다음 `+`로 이동한다. `;` 명령은 `f` 명령이 수행한 마지막 검색을 반복한다. `f+`를 네번 반복하지 않고 한번만 실행하고`;`를 세번 사용했다.

`;`이 다음 대상으로 이동하고, `.`로 최근 변경을 반복한다. 세 번의 `;.`로 완료한다.

Vim의 모달 입력 모델과 싸우지말고, 같이 작업하면서 일을 더 쉽게 만드는 법을 보라.

### Tip 4. Act, Repeat, Reverse

반복적인 일을 마주하면 이동과 변경을 반복적으로 만들어 최적의 편집 전략을 수행할 수 있다. Vim은 비결을 갖고 있다.

Table 1. Repeatable Actions and How to Reverse Them

| Intent                           | Act                   | Repeat | Reverse |
|----------------------------------|-----------------------|--------|---------|
| Make a change                    | {edit}                | .      | u       |
| Scan line for next character     | f{char}/t{char}       | ;      | ,       |
| Scan line for previous character | F{char}/T{char}       | ;      | ,       |
| Scan document for next match     | /pattern`<CR>`        | n      | N       |
| Scan document for previous match | ?pattern`<CR>`        | n      | N       |
| Perform substitution             | :s/target/replacement | &      | u       |
| Execute a sequence of changes    | qx{changes}q          | @x     | u       |

`.` 명령이 마지막 *변경*을 반복한다는 것을 알았다. 몇 명령은 다른 방법으로 반복할 수 있다. 예로, `@:`는 Ex 명령을 반복하고, `&`는 마지막 `:substitute`를 반복할 수 있다.

한번 실행하고 반복한다.

`.` 명령의 경우 `u` 키로 마지막 변경을 되돌릴 수 있다. `F{char}` 명령을 사용한 후 `;` 키를 너무 많이 누른 경우엔 `,`로 되돌릴 수 있다. `,`은 반대 방향으로 `f{char}` 검색을 반복한다.

### Tip 5. Find and Replace by Hand

`the_vim_way/1_copy_content.txt`의 내용에 "content"란 단어가 줄마다 있다. "content" 대신 "copy"를 사용하기 원하면 substitut 명령을 사용할 수 있다:

```vim
:%s/content/copy/g
```

이것은 세 개의 "content"를 "copy"로 모두 변경한다. 그러나 두 번째 "content"는 만족하는 이라는 동철 이음 이의어`heteronym`이다.

 `*` 명령은 커서 밑의 단어를 찾는다. `/content`로 "content"를 검색할 수도 있다.

 두 번째 "content" 단어에 커서를 놓고 `*`로 세 번째 "content"로 이동한 후 `cw`copy`<Esc>`를 실행하여 "content"를 "copy"로 변경한다. `n`로 첫 번째 "content"로 이동한 후에 `.` 명령을 실행한다.

 `:set hls`로 검색 하일라이트를 해보라.

 "content"를 한번 검색한 후에는 `n` 키로 다음 검색을 진행할 수 있다. 이 경우에는 `*nn`으로 모든 경우를 순환한다.

 `cw` 명령은 단어를 지우고 입력 모드로 바꾼다. "copy"를 입력하면 Vim은 입력 모드를 벗어나기 전까지를 기록한다. `cw`copy`<Esc>`가 하나의 변경이다. `.` 명령을 누르면 커서 밑의 단어를 지우고 "copy"를 입력하게 된다.

 `n.n.n.`은 `:%s/content/copy/g`와 같다. 그래서 원하는 경우에만 `.`을 사용한다.

 ### Tip 6. Meet Dot formular

 #### 이상적 해결책: 한 키로 이동, 한 키로 실행

 이런 이상적 패턴을 편의상 Dot Fomular라고 말하겠다.

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


