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
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

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

입력 모드에서 레지스터 내용을 붙여넣을 수 있는 단축키, 특수 기호를 입력하는 방법, 바꾸기 모드, 입력-일반 모드라는 서브 모드를 배운다.

### Tip 13. Make Corrections Instantly from Insert Mode

입력 모드에서 백스페이스 키는 예상대로 커서 앞에 있는 한 문자를 제거한다. 아래 명령을 사용할 수도 있다.

| Keystrokes | Effect                                |
|------------|---------------------------------------|
| <C-h>      | Delete back one character (backspace) |
| <C-w>      | Delete back one word                  |
| <C-u>      | Delete back to start of line          |

이 명령은 입력 모드나 Vim에만 힌정된 것이 아니다. Vim의 명령행은 물론 bash 셸에서도 사용할 수 있다.

### Tip 14. Get Back to Normal Mode

일반 모드로 돌아가는 표준 방법은 `<Esc>` 키다. 많은 키보드에서 멀리 있어서, 정확히 같은 기능인 `C-[`를 누를 수 있다.

| Keystrokes | Effect                       |
|------------|------------------------------|
| <Esc>      | Switch to Normal mode        |
| <C-[>      | Switch to Normal mode        |
| <C-o>      | Switch to Insert Normal mode |

#### Meet Insert Normal Mode

입력-일반 모드는 일반 모드의 특별판이며, 총알 하나만 주는 것이다. 즉, 명령 하나만 발사하고 바로 입력 모드로 돌아온다.

입력 중인 행이 창의 상단 또는 하단에 있을 때 추가 맥락을 보기위해 화면을 스크롤하고 싶을 때 `<C-o>zz`를 자주 사용한다. 입력 모드로 바로 돌아와 끊김없이 타이핑을 계속할 수 있다.

### Tip 15. Paste from a Register Without Leaving Insert Mode

`insert_mode/practical-vim.txt`에서 마지막 줄에 첫 줄의 내용을 복사한 후 붙여넣는다.
`yt,`로 첫 줄의 ","전까지를 복사하고, `jA `로 이동하고, `<C-r>0`로 레지스터 0의 내용을 붙여넣는다. `.<Esc>`로 마미표를 찍고 일반 모드로 돌아온다.

>
#### Remap the Caps Lock Key
>
Vim 사용자에게 Caps Lock은 골치거리다. Caps Lock이 켜져 있으면 `k`, `j`로 이동하려면 `K`, `J` 명령으로 동작한다. `K`는 커서 밑의 단어를 매뉴얼에서 찾아주고(:h K), `J`는 현재 행과 다음 행을 하나로 합친다(:h J). Caps Lock 키를 실수로 키면 버퍼에 있는 문서가 순식간에 엉망이 된다.
>
많은 사용자들이 Caps Lock 키를 `<Esc>`나 `<Ctrl>`로 재설정한다.
>

#### Use <C-r>{register} for Character-wise Registers

`C-r>{register}` 명령은 입력 모드에서 몇 단어를 붙여넣을 때 편리하다. 레지스터 내용이 많으면, 화면 갱신 전 약간 지연이 있을 수 있다. Vim이 레지스터로부터 한 번에 한 글자씩 삽입하기 때문이다. 'textwidth'나 'autoindent'가 켜져있으면, 원하지않는 개행이나 불필요한 들여쓰기가 추가될 수 있다.

`<C-r><C-p>{register}` 명령이 더 똑똑하다(:h i_CTRL-R_CTRL-P 참고). 여러 줄의 내용이 있는 레지스터를 붙여넣는다면 일반 모드로 전환하고 put 명령을 사용한다.

### Tip 16. Do Back-of-the-Envelope Calculations in Place

표현식`exporession` 레지스터로 계산을 하고 그 결과를 문서에 바로 입력할 수 있다.

대부분의 Vim 레지스터는 문자열이나 행 전체 내용을 포함한다. 삭제나 복사를 하면 레지스터에 저장된다. 붙여넣기는 레지스터 내요을 가져와 본문에 입력한다.

표현식 레지스터는 다르다. Vim 스크립트 코드를 실행하고 그 결과를 돌려준다. 계산기처럼 사용할 수 있다. 1+1과 같은 간단한 산술 표현식을 전달하면 2라는 결과가 나온다. 표현식 레지스터에서 받은 값을 일반 레지스터에 저장된 내용처럼 사용할 수 있다.

표현식 레지스터는 `=` 기호로 참조한다. 입력 모드에서 `<C-r>=`로 접근할 수 있다. 계산하길 원하는 표현식을 입력할 수 있는 프롬프트가 화면 하단에 열린다. 입력을 끝내고 `<CR>`을 누르면 Vim이 현재 위치에 결과를 입력한다.

`insert_mode/back-of-envelope.txt`에서 `A`로 줄의 끝에서 입력 모드로 전환하고, `<C-r>=6*35<CR>`로 결과값을 입력한다.

### Tip 17. Insert Unusual Characters by Character Code

숫자 코드로 어떤 문자라도 입력할 수 있다. 입력 모드에서 `<C-v>{code}`만 입력하면 된다. 숫자 코드는 3개의 숫자이다. "A"의 문자 코드는 65이며, `<C-v>065`를 입력하면 된다.

유니코드 기본 다국어 목록은 65,535 문자까지 사용할 수 있는데, 세 자리보다 큰 문자는 4자리의 16진수인 `<C-v>u{1234}`로 입력한다(숫자 앞에 _u_ 를 붙여야 한다). 뒤집어진 물음표 ("¿")는 `<C-v>u00bf`를 입력한다. :h i_CTRL-V_digit 참조.

커서를 문자 위에 놓고 `ga` 명령을 실행하면 화면 하단에 십진수와 16진수, 8진수 코드를 출력한다(:h ga 참조).

`<C-v>` 명령 뒤에 숫자가 아닌 키를 입력하는 방법도 있다. 'expandtab' 옵션이 활성된 상태에서 `<Tab` 키를 누르면 탭문자 대신 공백 문자를 추가한다. 그러나, `<C-v><Tab>은 탭 문자를 그대로 입력한다.

| Keystrokes          | Effect                                                      |
|---------------------|-------------------------------------------------------------|
| <C-v>{123}          | Insert character by decimal code                            |
| <C-v>u{1234}        | Insert character by hexadecimal code                        |
| <C-v>{nondigit}     | Insert nondigit literally                                   |
| <C-k>{char1}{char2} | Insert Unusual Characters by Digraph {char1}{char2} digraph |

Table 3—Inserting Unusual Characters

### Tip 18. Insert Unusual Characters by Digraph

이중자`digraph`로 입력할 수도 있다: 이중자는 기억하기 쉬운 문자쌍이다.

입력 모드에서 `<C-k>{char1}{char2}`를 입력하면 된다. `¿ `를 입력하고 싶다면, `<C-v>?I`를 입력한다.

이중자에서 사용하는 문자 쌍은 문자를 묘사하게 선택하였으므로 기억하거나 추측하기 쉽다. 예를 들어 겹화살 괄호인 «와 »는 이중자 <<, >>으로 입력할 수 있다; 분수 ½, ¼, ¾는 이중자 12, 14, 34로 입력할 수 있다. Vim 이중자의 기본 목록은 `:h digraphs-default`에 요약되어 있다. `:digraphs`에서 가능한 목록을 볼 수도 있지만 살펴보기 어렵다. `:h digraph-table`로 더 많은 가능한 목록을 볼 수 있다.

### Tip 19. Overwrite Existing Text with Replace Mode

바꾸기 모드`Replace Mode`는 입력 모드와 같지만, 문서의 기존 내용을 덮어쓴다.

`insert_mode/replace.txt`의 문서 처음에서 `f.`으로 다음 "."으로 이동한다. `R, b<Esc>`로 ". B"를 ", b"로 바꾸어 하나의 문장으로 변경한다.

`<Insert>로 입력 모드와 바꾸기 모드를 전환할 수도 있다.

#### Overwrite Tab Characters with Virtual Replace Mode

탭 문자는 'tabstop` 설정(:h 'tabstop' 참고)에 정의된 만큼 열을 차지한다. 태 영역에서 바꾸기 모드를 시작하면 입력한 문자가 탭 문자를 덮어쓴다. 현재 줄의 길이가 급격히 줄어들게 된다.

`gR` 명령으로 시작하는 Virtual 바꾸기 모드에서는 탭 문자를 일반 공백 문자처럼 처리한다.

Virtual 바꾸기 모드에서는 실제 파일에 있는 문자를 처리하지 않고 화면에 표시된 문자를 덮어쓴다. 가능하면 Virtual 바꾸기 모드를 사용하길 권한다.

바꾸기 모드와 Virtual 바꾸기 모드의 일발성 버전도 있다. `r{char}`와 `gr{char}`는 한 문자만 덮어쓴 후 다시 일반 모드로 돌아온다(:h r 참고).

## Chapter 4. Visual Mode

비주얼 모드`Visual Mode`는 선택 영역을 지정하고 조작할 수 있다. 매우 직관적이어서 이후 많은 편집 소프트웨어의 모델이 되고 있다.

Vim은 문자, 행, 사각형 영역과 동작하는 세 가지 비주얼 모드가 있다.

비주얼 모드 명령을 반복할 때 `.` 명령을 사용할 수 있다.

비주얼-블록 모드는 사각형으로 열을 선택할 수 있다.

### Tip 20. Grok Visual Mode

비주얼 모드에서 내용의 범위를 선택하고 조작할 수 있으나, Vim의 관점은 다른 에디터와 다르다. 비주얼 모드는 또 다른 모드이다: 이는 각 키는 하나의 다른 기능을 수행한다는 것이다.

일반 모드에서 익숙해진 많은 명령은 비주얼 모드에서 똑같이 동작한다. `h`, `j`, `k`, `l`도 커서 키로 사용할 수 있고, `f{char}`으로 이동하고, `;`, `,`의 이동 반복도 가능하다. 패턴 일치하는 곳으로 이동하는 검색 명령(과 `n`/`N`)로 사용할 수있다. 비주얼 모드에서 커서가 이동할 때마다 선택 영역은 변경된다.

몇 가지 비주얼 모드 명령은 일반 모드와 같지만 약간 다르게 동작한다. 예로, 일반 모드에서 `c` 명령은 `c`를 먼저 입력한 다음 모션으로 범위를 지정해야 한다. 비주얼 모드에서는 영역을 먼저 선택한 후 `c` 명령을 실행한다. 대부분 비주얼 모드의 접근 방식을 더 직관적으로 느낀다.

`viw`로 단어를 선택한다. `c` 명령을 입력하면 선택된 단어가 지워지고 입력 모드로 전환된다.

>
#### Meet Select Mode
>
선택 모드`Select Mode`는 내장 문서에서 "마이크로소프트 윈도우에서의 고르기 모드와 닮았다"고 한다(:h Select-mode 참고).
>
비주얼 모드와 선택 모드는 `<C-g>`로 전환할 수 있다. 화면 하단에 `-- VISUAL --`과 `-- SELECT --`로 구분할 수 있다. 선택 모드에서 문자를 입력하면 선택된 영역이 지워진 후 입력 모드로 들어가서 문자를 입력할 수 있다. 물론 비주얼 모드에서 `c` 키로 선택 영역을 변경할 수도 있다.
>
Vim의 모달 본성을 좋아한다면 선택 모드는 되도록 사용하지 말아야 한다. 선택 모드를 계속 사용하게되는 시간은 한 가지이다. TextMate의 스니핏 기능을 에뮬레이트하는 플러그인 사용할 때, 선택 모드가 활성화된다.
>

### Tip 21. Define a Visual Selection

Vim은 세 가지 비주얼 모드가 있다. 문자 단위 비주얼 모드에서는 단일 문자에서 여러 줄에 걸친 문자까지 선택할 수 있다. 줄 전체를 선택하고 싶다면 행 단위 비주얼 모드를 사용할 수 있다. 마지막으로 블록 단위 비주얼 모드는 문서의 열 영역을 선택할 수 있다.

#### Enabling Visual Modes

`v` 키는 비주얼 모드로의 통로이다. 일반 모드에서 `v`를 누르면 문자 단위 비주얼 모드, `V`로 행 단위 비주얼 모드, <C-v>로 블록 단위 비주얼 모드를 활성한다.

| Command | Effect                             |
|---------|------------------------------------|
| v       | Enable character-wise Visual mode  |
| V       | Enable line-wise Visual mode       |
| <C-v>   | Enable block-wise Visual mode      |
| gv      | Reselect the last visual selection |

`gv` 명령은 비주얼 모드에서 마지막으로 선택했던 범위를 다시 선택해주는 단축키다. 문자 단위, 행 단위, 블럭 단위인지는 상관없지만, 선택 영역이 지워진 상황에서 사용하면 혼란스러울 수 있다.

#### Switching Between Visual Modes

| Command       | Effect                                                     |
|---------------|------------------------------------------------------------|
| <Esc> / <C-[> | Switch to Normal mode                                      |
| v / V /       | Switch to Normal mode (when used from character-, line- or |
| <C-v>         | block-wise Visual mode, respectively                       |
| v             | Switch to character-wise Visual mode                       |
| V             | Switch to line-wise Visual mode                            |
| <C-v>         | Switch to block-wise Visual mode                           |
| o             | Go to other end of highlighted text                        |

#### Toggling the Free End of a Selection

비주얼 모드에서 명령을 실행하면 일반 모드로 돌아가고 선택 영역은 해제된다. 비주얼 모드 명령을 범위는 같지만 위치는 다른 선택 영역에서 똑같이 동작하게 하려면 어떻게 해야할까?

`visual_mode/fibonacci-malformed.py`는 4칸 들여쓰기를 한다. Vim이 이 들여쓰기와 맞추도록 설정하려고 한다.

##### Preparation

`<`와 `>`이 제대로 동작하도록 'shiftwidth'와 'softtabstop'의 설정을 4로 지정하고 'expandtab'을 활성한다. 이 한 줄이면 된다:

```vim
:set shiftwidth=4 softtabstop=4 expandtab
```

##### Indent Once, Then Repeat

들여쓰기할 행의 처음에서 `Vj`로 두 줄을 선택한 후 `>.`으로 두 번 들여쓴다. 한번의 `2>`를 입력해도 같은 결과를 만들 수 있지만 `.` 명령은 실행 결과를 화면에서 확인할 수 있다. 들여쓰기를 한번 더 하려면 `.`을 다시 입력하면 된다.신나서 누르다가 지나쳤다면 `u`로 되돌릴 수 있다.

비주얼 모드에서 `.` 명령은 사용하면 가장 마지막에 선택한 영역에 대해 동작한다. 행 단위 선택을 가정하고 동작하는 경향이 있어 문자 단위 선택에서는 예기치 않은 결과가 나올 수도 있다.

### Tip 23. Prefer Operators to Visual Commands Where Possible

비주얼 모드는 일반 모드보다 직관적이지만 약점도 있다: 점 명령이 항상 올바르게 동작하는 것은 아니다. 일반 모드 오퍼레이터가 적합할 때도 있다.

`visual_mode/list-of-links.html`에서 `vit`로 태그 안의 내용을 선택한다: visually select inside the tag.

#### Using a Visual Operator

`U` 명령으로 대문자로 전환한다. `j.`으로 다음 행에서 같은 명령을 반복한다. 다시 `j.`을 실행하면 같은 길이인 세 글자만 동작한다(:h visual-repeat 참고).

#### Using a Normal Operator

비주얼 모드 `U` 명령은 일반 모드 `gU{motion}`와 같다(:h gU 참고). 이 명령으로 변경하면 점 공식을 사용해서 나머지 편집을 끝낼 수 있다.

파일에 시작에서 `gUit`하여 첫 태그 안의 문자를 대문자로 변경하고 `j.`으로 두 번째 줄을, `j.`으로 세 번째 줄을 변경한다.

#### Discussion

`vitU`와 `gUit`는 모두 네 번의 키 입력이지만, 내재된 의미는 매우 다르다. 두 개의 명령으로 구부하면: `vit`는 선택이고, `U`로 바꾼다. 반면, `gU`는 오퍼레이터이고, `it`는 모션이다.

`.` 명령은 비주얼 모드보다 일반 모드에서 오퍼레이터를 사용하는 것이 더 낫다. 일회성 변경에는 비주얼 모드가 더 낫다.

### Tip 24. Edit Tabular Data with Visual-Block Mode

`visual_mode/chapter-table.txt`에서 `<C-v>`로 비주얼 블록 모드로 전환. `3j`로 아래 3열을 추가한 후 `x`를 눌러서 선택한 열을 제거하고 `.` 명령을 여러 번 눌러서 같은 범위를 여러 번 지운다. 두 열의 간격이 적당해질 때까지 반복한다. 넓은 범위를 선택해서 한번에 지워도 되지만 한 열씩 지우면 시각적으로 바로 확인할 수 있으므로 한 열씩 제거하는 방법이 낫다. 마지막으로 선택했던 범위를 `gv` 명령으로 다시 선택하여 `r|`로 선택한 범위를 모두 파이프 문자로 바꾼다. 행 단위 복사, 붙여넣기로 최상단 행을 복제한 후에(`yyp`) 복제한 행에서 모든 문자를 대시(-) 문자로 치환한다(`Vr-`).

![표만들기](https://c2.staticflickr.com/6/5330/30646444713_04a5a31265_z.jpg)

### Tip 25. Change Columns of Text

비주얼 블록 모드를 사용하면 동시에 여러 행에 내용을 추가하는 것도 가능 하다.
비주얼 블록 모드는 표 형식의 자료를 작업할 때만 유용한 것이 아니다. 코드 작업을 할 때도 종종 요긴하게 활용할 수 있다.

`visual_mode/sprite.css`에서 파일의 디렉토리를 여러 줄에 걸쳐 변경해야 할 때 변경하려는 범위를 비주얼 블록을 사용해서 지정한다. `c`를 누르면 선택 영역의 내용이 지워지고 입력 모드로 전환된다. "components"를 입력하면 가장 상단의 행에서만 입력한 내용이 나타날 것이다. 나머지 두 행에서는 아무런 반응이 없지만 `<Esc>`를 눌러 일반 모드로 돌아가는 순간 입력했던 내용이 나머지 두 행에 추가되는 것을 확인할 수 있다.

### Tip 26. Append After a Ragged Visual Block

`the_vim_way/2_foo_bar.js`는 세 줄이고 행의 길이가 다르다. 세 행의 끝에 세미콜론을 붙이려고 한다. 비주얼 블록 모드로 진입한 다음에 선택 영역을 행의 마지막까지 늘리기 위해 `$` 명령을 사용한다. 사각형으로만 제한에서 벗어나서 각 행의 선택 영역을 오른쪽 끝까지, 행의 길이에 맞춰 확장한다.

`A` 명령을 누르면 입력 모드로 전환되며 가장 상단 행의 끝에 커서가 놓이게 된다. 입력 모드에 있는 동안에 입력한 내용은 가장 상단의 행에서만 나타나지만 입력 모드를 벗어나면 선택한 모든 행에 반영된다.

>
#### "i"와 "a" 사용법
>
`i`와 `a` 명령은 일반 모드에서 입력 모드로 전환하는 명령이고, 각각 현재 문자 앞에, 뒤에 커서를 갖다놓는다. `I`와 `A`는 비슷하지만, 각각 커서를 현재 줄의 처음과 마지막으로 이동한다.
>
비주얼 블록 모드에서도 비슷하다. `I`와 `A` 명령은 선택한 영역의 시작 또는 끝으로 커서를 이동한 후 입력 모드로 전환한다.
>
비주얼 모드와 동작 대시 모드에서 `i`와 `a` 명령은 텍스트 개체를 선택할 때 사용하는 명령이므로 전혀 다르게 동작한다. 비주얼 모드에서 `i`로 입력 모드로 전환하지 않는다면 `I`를 입력해보라.
>

## Part II. Files

## Chapter 6. Manage Multiple Files

### Tip 37. Track Open Files with the Buffer List

편집 세션에서 여러 파일을 열 수 있다. 버퍼 목록으로 파일을 관리할 수 있다.

#### Understand the Distinction Between Files and Buffers

Vim에서 실제로 파일을 편집하는 것이 아니다. 사실은 메모리 공간에 파일을 복사해서 편집하는 것이다. 메모리에 존재하는 파일의 사본을 Vim에서는 버퍼(buffer)라고 한다.

파일은 디스크에 보관하고 버퍼는 메모리에 보관한다. 파일을 열면 같은 이름으로 내용을 버퍼에 불러온다. 처음에는 버퍼와 파일의 내용이 일치하지만 버퍼의 내용을 수정하는 순간부터 달라진다. 만약 버퍼에서 변경한 사항을 유지하고 싶다면 버퍼의 내용을 다시 파일로 저장하면 된다. Vim 명령은 대부분 버퍼에서 동작하지만 `:write`, `:update`, `:saveas` 명령처럼 파일을 위한 명령도 있다.

#### Meet the Buffer List

Vim이 실행되면서 파일을 불러오면 첫 번째 파일을 창에 출력한다. 두 번째 파일은 버퍼로 불러온 후 백그라운드에 놓이기 때문에 보이지 않는다. `:ls` 명령으로 현재 메모리에 존재하는 모든 버퍼 목록을 확인할 수 있다 (:h :ls 참고).

다음 버퍼를 현재 창으로 불러오고 싶다면 `:bnext` 명령을 사용한다. 버퍼목록에서 `%` 기호는 현재 창에서 볼 수 있는 버퍼를 표시한다. `#` 기호는 현재 활성된 버퍼와 교대한 버퍼를 나타낸다. `<C-^>`로 현재 버퍼와 이전 버퍼를 전환할 수 있다.

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

---

다 읽으려면 한 백일 걸릴라나?^^

<p style="display: none"><img src="https://c2.staticflickr.com/6/5572/30911777505_03e3ec069f_n.jpg" alt="Practical Vim cover"></p>


