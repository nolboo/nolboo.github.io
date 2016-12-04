---
layout: post
title: "Practical Vim 2판 정리 페이지"
date: 2016-11-16 17:00:00
tags: [practical-vim, book, summary, editor, vim]
---

<a target="_blank"  href="https://www.amazon.com/gp/product/B018T6ZVPK/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B018T6ZVPK&linkCode=as2&tag=nolbookim-20&linkId=45b16dbe20fb6e3a35a594a85f9ba1a6"><img border="0" src="//ws-na.amazon-adsystem.com/widgets/q?_encoding=UTF8&MarketPlace=US&ASIN=B018T6ZVPK&ServiceVersion=20070822&ID=AsinImage&WS=1&Format=_SL250_&tag=nolbookim-20" ></a><img src="//ir-na.amazon-adsystem.com/e/ir?t=nolbookim-20&l=am2&o=1&a=B018T6ZVPK" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />

1. 목차
{:toc}

- **iBooks로 읽는 프랙티컬 Vim 2판을 정리하는 페이지이며 내편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **ex**/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

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
| o         | A<CR>     |
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
| Scan document for next match     | /pattern<CR>          | n      | N       |
| Scan document for previous match | ?pattern<CR>          | n      | N       |
| Perform substitution             | :s/target/replacement | &      | u       |
| Execute a sequence of changes    | qx{changes}q          | @x     | u       |

`.` 명령이 마지막 _변경_을 반복한다는 것을 알았다. 몇 명령은 다른 방법으로 반복할 수 있다. 예로, `@:`는 Ex 명령을 반복하고, `&`는 마지막 `:substitute`를 반복할 수 있다.

한번 실행하고 반복한다.

`.` 명령의 경우 `u` 키로 마지막 변경을 되돌릴 수 있다. `F{char}` 명령을 사용한 후 `;` 키를 너무 많이 누른 경우엔 `,`로 되돌릴 수 있다. `,`은 반대 방향으로 `f{char}` 검색을 반복한다.

### Tip 5. Find and Replace by Hand

`the_vim_way/1_copy_content.txt`의 내용에 "content"란 단어가 줄마다 있다. "content" 대신 "copy"를 사용하기 원하면 substitut 명령을 사용할 수 있다:

```vim
:%s/content/copy/g
```

이것은 세 개의 "content"를 "copy"로 모두 변경한다. 그러나 두 번째 "content"는 만족하는 이라는 동철 이음 이의어`heteronym`이다.

 `*` 명령은 커서 밑의 단어를 찾는다. `/content`로 "content"를 검색할 수도 있다.

두 번째 "content" 단어에 커서를 놓고 `*`로 세 번째 "content"로 이동한 후 `cw`copy<Esc>를 실행하여 "content"를 "copy"로 변경한다. `*`로 첫 번째 "content"로 이동한 후에 `.` 명령을 실행한다.

`:set hls`로 검색 하일라이트를 해보라.

"content"를 한번 검색한 후에는 `n` 키로 다음 검색을 진행할 수 있다. 이 경우에는 `*nn`으로 모든 경우를 순환한다.

`cw` 명령은 단어를 지우고 입력 모드로 바꾼다. "copy"를 입력하면 Vim은 입력 모드를 벗어나기 전까지를 기록한다. `cw`copy<Esc>가 하나의 변경이다. `.` 명령을 누르면 커서 밑의 단어를 지우고 "copy"를 입력하게 된다.

`n.n.n.`은 `:%s/content/copy/g`와 같다. 그래서 원하는 경우에만 `.`을 사용한다.

### Tip 6. Meet Dot formular

#### 이상적 해결책: 한 키로 이동, 한 키로 실행

이런 이상적 패턴을 편의상 Dot Fomular라고 말하겠다.

## Part 1. Modes

Vim은 모달 유저 인터페이스를 제공한다. 키보드의 키를 누른 결과가 현재 어떤 모드인지에 따라 다르다는 것을 뜻한다. 어떤 모드인지와 Vim 모드 사이를 전환하는 방법을 아는 것이 필수다.

## Chapter 2. Normal Mode(일반 모드)

일반 모드는 Vim의 휴식 상태다. 이 책의 대부분이 일반 모드를 사용하는 법에 대한 것이기 때문에 이 장은 아주 짧고, 핵심 개념과 일반 팁만 다룬다.

다른 텍스트 에디터는 입력 모드 비슷한 것에서 대부분의 시간을 보낸다. 그래서 Vim 입문자는 일반 모드가 기본인 것이 낯설다. 팁 7에서 화사의 작업 공간과의 유사한지를 설명한다.

많은 일반 모드 명령은 여러 번 실행하라는 횟수와 함께 사용된다. 팁 10에서 증가/감소 숫자값 명령과 이 명령들이 횟수와 결합할 수 있다는 것을 알게 된다.

일반 모드의 강력함은 동작 명령이 motion과 결합할 수 있다는 것에서 온다.

### Tip 7. Pause with Your Brush Off the Page

화가가 페인트 붓을 캔버스와 얼마나 많이 접촉하는 생각해 본 적이 있나? 작업에 쓰는 시간의 반을 사용한다.

화가가 그리기 외에 하는 모든 것을 생각해보라. 주제를 연구하고, 빛을 조절하고, 새로운 색조의 물감을 섞는다. 물감을 캔버스에 적용할 때 붓을 사용해야 한다고 누가 그러는가? 화가는 다른 질감을 위해 팔레트 칼을 바꾸고, 이미 걱용된 물감을 덧붙이기 위해 면 안감을 사용할 수도 있다.

화가는 캔버스에 대어놓고 붓을 쉬지 않는다.

Vim에서도 그렇다. 일반 모드는 자연적인 휴식 상태다. 단서는 그 이름에 있다, 정말로.

화가가 그리기에 시간의 일부를 쓰듯이 프로그래머도 코드 작성에 시간의 일부를 쓴다. 생각하고, 일고, 코드베이스 한 부분에서 다른 부분으로 옮기는 것에 시간을 더 쓴다. 누가 입력 모드로 바꿔야 한다고 하는가? 우리는 기존 코드를 재포맷하고 복사하고 이동하거나 지운다. 일반 모드에서 마음대로 사용할 수 있는 도구가 많이 있다.

### Tip 8. Chunk Your Undos

다른 텍스트 에디터에서는 몇 단어를 입력한 후 undo 명령으로 마지막 입력한 단어 혹은 문자를 되돌린다. 그러나, Vim에서는 undo 명령의 덩어리를 조절할 수 있다.

`u` 키는 가장 최근 변경을 되돌린다. 단일 변경은 문서에 문자를 변경한 것이다. 일반, 비주얼, 명령행 모드에서 실행한 명령을 포함한다. 그러나, 입력 모드에서 입력하거나 지운 텍스트도 포함할 수 있다. `i{문자 입력}<Esc>`는 단일 변경이 될 수 있다.

Vim에서는 undo 명령의 덩어리를 조절할 수 있습니다. 입력 모드로 들어가는 순간부터 일반 모드로 돌아갈 때까지 입력 (또는 삭제)한 모든 것이 단일 변경이다. 따라서 `<Esc>` 키 사용을 조절하여 undo 명령을 단어, 문장 또는 단락에 적용할 수 있다.

얼마나 자주 입력 모드를 떠나는가? 선호의 문제이지만, 나는 각각의 "되돌릴 덩어리"를 생각과 일치시키려고 한다. 이 텍스트를 쓰면서 (물론 Vim에서!), 나는 문장의 끝에 잠시 멈추고 다음에 쓸 내용을 생각한다. 시간이 아무리 짧아도 각 멈춤은 자연스러운 중단점을 만들고 입력 모드를 떠나는 단서를 준다. 글 쓸 준비가되면, 나는 `A`를 누르고 내가 중단 한 곳에서 계속한다.

잘못되었다고 생각되면, 일반 모드로 전환하고 `u`를 누릅니다. undo할 때마다 원본 텍스트를 쓰면서 생각대로 내 텍스트를 일관된 덩어리로 분해한다. 즉, 한 두 문장을 쉽게 쓰고 두개의 키 입력으로 버릴 수 있다.

입력 모드에서 커서가 줄 끝 부분에 있는 경우 새 줄을 여는 가장 빠른 방법은 `<CR>`을 누르는 것이다. 때로는 undo 명령에서 추가 세분화를 원할 것으로 기대하기 때문에 `<Esc>o`를 누르기를 선호한다. 어려울 수 있지만 Vim에 익숙해지면 모드 전환이 점점 더 가볍게 느껴진다.

#### 입력 모드에서 이동하면 변경이 재설정된다.

undo 명령이 입력 모드로 들어가고 나오는 동안 입력한 (또는 지운) 모든 문자를 되돌릴 수 있다고 말했다. 입력 모드에서 `<Up>`, `<Down>`, `<Left>`, `<Right>` 커서 키를 사용하면 새로운 undo 덩어리가 만들어 진다. 입력 모드를 벗어나지 않는다는 것을 제외하고는 `h`, `j`, `k`, `l` 명령으로 이동하려고 일반 모드로 다시 전환한 것과 같다. 이것은 dot 명령에도 영향을 미친다.

### Tip 9. Compose Repeatable Changes

_Vim은 반복작업에 최적이다. 이것을 이용하려면 변경을 구성하는 방법을 마음에 새겨야 한다._

Vim에서 어떤 것을 하는 방법이 하나 이상 있다. 어떤 방식이 최고인지를 평가할 때 가장 확실한 척도는 효율성이다: 가장 적은 키 작업(VimGolf)이 필요하다.

"nigh"라는 단어의 "h"에 커서가 있다면:

`db`는 단어의 시작까지 지운다. `x`는 커서 밑의 한 글자를 지운다.

`b` 모션은 커서를 단어의 처음으로 움직인다. `dw`는 단어를 지운다.

모션 대신 `aw` 텍스트 개체를 사용할 수 있다. `daw`는 _delete a word_로 쉽게 기억할 수 있다. 단어만 지우는 것이 아닌 여백 문자까지 지운다. dot 명령을 사용하여 (`.` == `daw`) 유용하게 반복할 수 있다. 그래서 이 방법이 승자다.

### Tip 10. Use Counts to Do Simple Arithmetic

_여기서부터는 인사이트에서 Practical Vim 번역본의 리뷰를 부탁받았습니다. 그래서 며칠 동안 독서를 멈추었지만 12일까지 완료해야 하므로, 앞으로의 진행은 더 빨라지게 되었습니다. 원본과 3차 리뷰 번역본을 동시에 읽으면서 요약합니다_

대부분의 일반 모드 명령는 횟수를 앞에 붙일 수 있다. 그 횟수만큼 반복실행한다.

커서 밑에 있는 숫자를 <C-a> 명령으로 증가시키거나 <C-x> 명령으로 감소시킬 수 있다. 숫자를 앞에 붙이면 그 수만큼 증감한다. 5 문자에 커서를 놓고 10<C-a>를 실행하면 15로 증가한다.

커서 밑이 숫자가 아닐 때는 이후에 있는 숫자로 이동해 앞에 입력한 [숫자]만큼 증감한다.

`normal_mode/sprite.css`의 마지막 줄에서 `yyp`로 줄을 복사하고, `180<C-x>`로 숫자로 이동해 -180px로 번경한다.

>
#### 숫자 포맷
>
0이 앞에 있는 숫자는 8진수로 해석하기 때문에 007+001 = 010이다. `:set nrformats=`하면 십진수로 해석한다.
>

### Tip 11. Don’t Count If You Can Repeat

횟수를 지정하여 키를 최소로 할 수 있지만, 반드시 해야 하는 것은 아니다.

두 단어를 지울 때 `d2w`와 `2dw`가 유용하다. `d2w`는 삭제한 후 모션으로 `2w`를 주었다. "delete two words."로  읽을 수 있다. `2dw`는 삭제 명령에 횟수가 적용되었으며, 모션은 한 단어에서 실행된다. "delete a word two times."로 읽을 수 있다. 의미를 다르지만, 결과는 같다.

`dw.`는 "Delete a word and then repeat."로 읽을 수 있다.

7 단어를 지울 때 `d7w`와 `dw......`(`dw`를 `.`로 6회 반복)은 키 입력 수로 보면 확실한 승자를 알 수 있다. 숫자를 세는 것은 지루하다. 눌러야 하는 키의 숫자를 줄이기 위해 미리 헤아리기보다 `.` 명령을 6번 입력하는 것을 선호한다.

### Tip 12. Combine and Conquer

Vim의 강력함은 오퍼레이터와 모션을 조합하는 방법에서 나온다.

**Operator + Motion = Action**

`d{motion}`에서 지우는 범위는 모션이 정한다. `dl`는 한 문자, `daw`는 한 단어, `dap`는 한 문단을 지운다. `c{motion}`, `y{motion}`도 같다. 이런 명령을 오퍼레이터라 한다. `:h operator`로 전체 목록을 찾아볼 수 있다.

`g~`, `gu`, `gU`는 두 번의 키 입력으로 실행한다. `g`는 다음 키의 행동을 수정하는 접두어로 생각할 수 있다.

오퍼레이터와 모션의 조합은 일종의 문법이다. 첫 규칙은 간단하다: 행동`action`은 오퍼레이터와 뒤따르는 모션의 조합이다.

| Trigger | Effect                                            |
|---------|---------------------------------------------------|
| c       | Change                                            |
| d       | Delete                                            |
| y       | Yank into register                                |
| g~      | Swap case                                         |
| gu      | Make lowercase                                    |
| gU      | Make uppercase                                    |
| >       | Shift right                                       |
| <       | Shift left                                        |
| =       | Autoindent                                        |
| !       | Filter {motion} lines through an external program |
Table 2. Vim Operator Commands

`gUaw`는 현재 단어를 대문자로 만든다. `gUap`는 문단을 대문자로 만든다.

Vim 문법은 하나의 규칙이 더 있다: 오퍼레이터 명령을 반복하면 현재 줄에 동작한다. `dd`는 현재 줄을 지우고, `>>`는 줄을 들여쓴다. `gU`는 `gUgU`, 줄여서 `gUU`로 할 수 있다.

#### Extending Vim’s Combinatorial Powers

자신의 모션과 오퍼레이터로 더 확장할 수 있다.

##### Custom Operators Work with Existing Motions

표준 오퍼레이터를 새롭게 정의할 수 있다. commentary.vim이 좋은 예이다. 모든 언어에서 코드를 주석으로 만들거나 주석을 해제하는 명령을 더한다.

`gc{motion}` 명령으로 주석을 토글한다. 오퍼레이터이므로, 모든 일반 모션과 조합할 수 있다. `gcap`로 현재 문단을 주석을 토글한다. `gcG`는 현재 줄부터 파일 끝까지 주석을 토글한다. `gcc`는 현재 줄을 주석처리한다. 커스텀 오퍼레이터는 `:h :map-operrator`를 참조한다.

##### Custom Motions Work with Existing Operators

Kana Natsuno의 textobj-entire 플러그인이 좋은 예이다. 두 개의 새로운 텍스개체를 더한다: 전체 파일에 동작하는 `ie`와 `ae`

`=` 명령으로 전체 파일을 들여쓰기하려면 `gg=G`(`gg`로 파일 처음으로 이동하고 `=G`로 파일 끝까지를 들여쓴다). 이 플러그인을 설치하면 `=ae`로 간단히 동작한다.

두 플러그인을 모두 설치하면 `gcae`로 파일 전체를 주석처리하거나 토글할 수 있다.

커스텀 모션을 만들고 싶다면 `:h omap-info`를 읽어라.

>
##### Meet Operator-Pending Mode
>
Operator-Pending 모드는 간과하기 쉬운 모드 중 하나이다. 하루에 여러 번 사용하지만, 짧게 지속되기 때문이다. 예로 `dw`에서 `d`와 `w` 키를 누르는 사이의 짧은 순간이다. Operator-Pending 모드는 모션 명령만 받은 상태이다. <Esc>를 눌러 취소할 수 있다.
>
`:h g`, `:h z`, `:h ctrl-w`, `:h [`에서 처음 입력은 두 번째 입력의 접두어와 같이 행동한다. 이 명령은 Operator-Pending 모드를 초기화하지 않는다. 여러 명령을 모은 namespace라고 생각할 수 있다. 오퍼레이터 명령만 Operator-Pending 모드를 초기화한다.
>
이렇게 짧은 모드를 둔 이유가 궁금할 수 있다. Operator-Pending 모드를 초기화하거나 전환하는 커스텀 매핑을 만들 수 있기 때문이다. 이로써 커스텀 오퍼레이터와 모션을 만들어 Vim의 어휘를 확장할 수 있다.
>

## Chapter 3. Insert Mode(입력 모드)


---

다 읽으려면 한 백일 걸릴라나?^^

<p style="display: none"><img src="https://c2.staticflickr.com/6/5572/30911777505_03e3ec069f_n.jpg" alt="Practical Vim cover"></p>


