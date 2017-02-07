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

두 번째 "content" 단어에 커서를 놓고 `*`로 세 번째 "content"로 이동한 후 `cw`copy`<Esc>`를 실행하여 "content"를 "copy"로 변경한다. `*`로 첫 번째 "content"로 이동한 후에 `.` 명령을 실행한다.

`:set hls`로 검색 하일라이트를 해보라.

"content"를 한번 검색한 후에는 `n` 키로 다음 검색을 진행할 수 있다. 이 경우에는 `*nn`으로 모든 경우를 순환한다.

`cw` 명령은 단어를 지우고 입력 모드로 바꾼다. "copy"를 입력하면 Vim은 입력 모드를 벗어나기 전까지를 기록한다. `cw`copy`<Esc>`가 하나의 변경이다. `.` 명령을 누르면 커서 밑의 단어를 지우고 "copy"를 입력하게 된다.

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

대부분의 일반 모드 명령는 횟수를 앞에 붙일 수 있다. 그 횟수만큼 반복실행한다.

커서 밑에 있는 숫자를 `<Ctrl-a>` 명령으로 증가시키거나 `<Ctrl-x>` 명령으로 감소시킬 수 있다. 숫자를 앞에 붙이면 그 수만큼 증감한다. 5 문자에 커서를 놓고 10`<Ctrl-a>`를 실행하면 15로 증가한다.

커서 밑이 숫자가 아닐 때는 이후에 있는 숫자로 이동해 앞에 입력한 [숫자]만큼 증감한다.

`normal_mode/sprite.css`의 마지막 줄에서 `yyp`로 줄을 복사하고, `180<Ctrl-x>`로 숫자로 이동해 -180px로 번경한다.

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
Operator-Pending 모드는 간과하기 쉬운 모드 중 하나이다. 하루에 여러 번 사용하지만, 짧게 지속되기 때문이다. 예로 `dw`에서 `d`와 `w` 키를 누르는 사이의 짧은 순간이다. Operator-Pending 모드는 모션 명령만 받은 상태이다. `<Esc>`를 눌러 취소할 수 있다.
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
| `<Ctrl-h>` | Delete back one character (backspace) |
| `<Ctrl-w>` | Delete back one word                  |
| `<Ctrl-u>` | Delete back to start of line          |

이 명령은 입력 모드나 Vim에만 힌정된 것이 아니다. Vim의 명령행은 물론 bash 셸에서도 사용할 수 있다.

### Tip 14. Get Back to Normal Mode

일반 모드로 돌아가는 표준 방법은 `<Esc>` 키다. 많은 키보드에서 멀리 있어서, 정확히 같은 기능인 `C-[`를 누를 수 있다.

| Keystrokes | Effect                       |
|------------|------------------------------|
| `<Esc>`    | Switch to Normal mode        |
| `<Ctrl-[>` | Switch to Normal mode        |
| `<Ctrl-o>` | Switch to Insert Normal mode |

#### Meet Insert Normal Mode

입력-일반 모드는 일반 모드의 특별판이며, 총알 하나만 주는 것이다. 즉, 명령 하나만 발사하고 바로 입력 모드로 돌아온다.

입력 중인 행이 창의 상단 또는 하단에 있을 때 추가 맥락을 보기위해 화면을 스크롤하고 싶을 때 `<Ctrl-o>zz`를 자주 사용한다. 입력 모드로 바로 돌아와 끊김없이 타이핑을 계속할 수 있다.

### Tip 15. Paste from a Register Without Leaving Insert Mode

`insert_mode/practical-vim.txt`에서 마지막 줄에 첫 줄의 내용을 복사한 후 붙여넣는다.
`yt,`로 첫 줄의 ","전까지를 복사하고, `jA `로 이동하고, `<Ctrl-r>0`로 레지스터 0의 내용을 붙여넣는다. `.<Esc>`로 마미표를 찍고 일반 모드로 돌아온다.

>
#### Remap the Caps Lock Key
>
Vim 사용자에게 Caps Lock은 골치거리다. Caps Lock이 켜져 있으면 `k`, `j`로 이동하려면 `K`, `J` 명령으로 동작한다. `K`는 커서 밑의 단어를 매뉴얼에서 찾아주고(:h K), `J`는 현재 행과 다음 행을 하나로 합친다(:h J). Caps Lock 키를 실수로 키면 버퍼에 있는 문서가 순식간에 엉망이 된다.
>
많은 사용자들이 Caps Lock 키를 `<Esc>`나 `<Ctrl>`로 재설정한다.
>

#### Use `<Ctrl-r>{register}` for Character-wise Registers

`C-r>{register}` 명령은 입력 모드에서 몇 단어를 붙여넣을 때 편리하다. 레지스터 내용이 많으면, 화면 갱신 전 약간 지연이 있을 수 있다. Vim이 레지스터로부터 한 번에 한 글자씩 삽입하기 때문이다. 'textwidth'나 'autoindent'가 켜져있으면, 원하지않는 개행이나 불필요한 들여쓰기가 추가될 수 있다.

`<Ctrl-r><Ctrl-p>{register}` 명령이 더 똑똑하다(:h i_CTRL-R_CTRL-P 참고). 여러 줄의 내용이 있는 레지스터를 붙여넣는다면 일반 모드로 전환하고 put 명령을 사용한다.

### Tip 16. Do Back-of-the-Envelope Calculations in Place

표현식`exporession` 레지스터로 계산을 하고 그 결과를 문서에 바로 입력할 수 있다.

대부분의 Vim 레지스터는 문자열이나 행 전체 내용을 포함한다. 삭제나 복사를 하면 레지스터에 저장된다. 붙여넣기는 레지스터 내요을 가져와 본문에 입력한다.

표현식 레지스터는 다르다. Vim 스크립트 코드를 실행하고 그 결과를 돌려준다. 계산기처럼 사용할 수 있다. 1+1과 같은 간단한 산술 표현식을 전달하면 2라는 결과가 나온다. 표현식 레지스터에서 받은 값을 일반 레지스터에 저장된 내용처럼 사용할 수 있다.

표현식 레지스터는 `=` 기호로 참조한다. 입력 모드에서 `<Ctrl-r>=`로 접근할 수 있다. 계산하길 원하는 표현식을 입력할 수 있는 프롬프트가 화면 하단에 열린다. 입력을 끝내고 `<CR>`을 누르면 Vim이 현재 위치에 결과를 입력한다.

`insert_mode/back-of-envelope.txt`에서 `A`로 줄의 끝에서 입력 모드로 전환하고, `<Ctrl-r>=6*35<CR>`로 결과값을 입력한다.

### Tip 17. Insert Unusual Characters by Character Code

숫자 코드로 어떤 문자라도 입력할 수 있다. 입력 모드에서 `<Ctrl-v>{code}`만 입력하면 된다. 숫자 코드는 3개의 숫자이다. "A"의 문자 코드는 65이며, `<Ctrl-v>065`를 입력하면 된다.

유니코드 기본 다국어 목록은 65,535 문자까지 사용할 수 있는데, 세 자리보다 큰 문자는 4자리의 16진수인 `<Ctrl-v>u{1234}`로 입력한다(숫자 앞에 _u_ 를 붙여야 한다). 뒤집어진 물음표 ("¿")는 `<Ctrl-v>u00bf`를 입력한다. :h i_CTRL-V_digit 참조.

커서를 문자 위에 놓고 `ga` 명령을 실행하면 화면 하단에 십진수와 16진수, 8진수 코드를 출력한다(:h ga 참조).

`<Ctrl-v>` 명령 뒤에 숫자가 아닌 키를 입력하는 방법도 있다. 'expandtab' 옵션이 활성된 상태에서 `<Tab>` 키를 누르면 탭문자 대신 공백 문자를 추가한다. 그러나, `<Ctrl-v><Tab>`은 탭 문자를 그대로 입력한다.

| Keystrokes               | Effect                                                      |
|--------------------------|-------------------------------------------------------------|
| `<Ctrl-v>{123}`          | Insert character by decimal code                            |
| `<Ctrl-v>u{1234}`        | Insert character by hexadecimal code                        |
| `<Ctrl-v>{nondigit}`     | Insert nondigit literally                                   |
| `<Ctrl-k>{char1}{char2}` | Insert Unusual Characters by Digraph {char1}{char2} digraph |

Table 3—Inserting Unusual Characters

### Tip 18. Insert Unusual Characters by Digraph

이중자`digraph`로 입력할 수도 있다: 이중자는 기억하기 쉬운 문자쌍이다.

입력 모드에서 `<Ctrl-k>{char1}{char2}`를 입력하면 된다. `¿ `를 입력하고 싶다면, `<Ctrl-v>?I`를 입력한다.

이중자에서 사용하는 문자 쌍은 문자를 묘사하게 선택하였으므로 기억하거나 추측하기 쉽다. 예를 들어 겹화살 괄호인 `«`와 `»`는 이중자 `<<`, `>>`으로 입력할 수 있다; 분수 ½, ¼, ¾는 이중자 12, 14, 34로 입력할 수 있다. Vim 이중자의 기본 목록은 `:h digraphs-default`에 요약되어 있다. `:digraphs`에서 가능한 목록을 볼 수도 있지만 살펴보기 어렵다. `:h digraph-table`로 더 많은 가능한 목록을 볼 수 있다.

### Tip 19. Overwrite Existing Text with Replace Mode

바꾸기 모드`Replace Mode`는 입력 모드와 같지만, 문서의 기존 내용을 덮어쓴다.

`insert_mode/replace.txt`의 문서 처음에서 `f.`으로 다음 "."으로 이동한다. `R, b<Esc>`로 ". B"를 ", b"로 바꾸어 하나의 문장으로 변경한다.

`<Insert>`로 입력 모드와 바꾸기 모드를 전환할 수도 있다.

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
비주얼 모드와 선택 모드는 `<Ctrl-g>`로 전환할 수 있다. 화면 하단에 `-- VISUAL --`과 `-- SELECT --`로 구분할 수 있다. 선택 모드에서 문자를 입력하면 선택된 영역이 지워진 후 입력 모드로 들어가서 문자를 입력할 수 있다. 물론 비주얼 모드에서 `c` 키로 선택 영역을 변경할 수도 있다.
>
Vim의 모달 본성을 좋아한다면 선택 모드는 되도록 사용하지 말아야 한다. 선택 모드를 계속 사용하게되는 시간은 한 가지이다. TextMate의 스니핏 기능을 에뮬레이트하는 플러그인 사용할 때, 선택 모드가 활성화된다.
>

### Tip 21. Define a Visual Selection

Vim은 세 가지 비주얼 모드가 있다. 문자 단위 비주얼 모드에서는 단일 문자에서 여러 줄에 걸친 문자까지 선택할 수 있다. 줄 전체를 선택하고 싶다면 행 단위 비주얼 모드를 사용할 수 있다. 마지막으로 블록 단위 비주얼 모드는 문서의 열 영역을 선택할 수 있다.

#### Enabling Visual Modes

`v` 키는 비주얼 모드로의 통로이다. 일반 모드에서 `v`를 누르면 문자 단위 비주얼 모드, `V`로 행 단위 비주얼 모드, `<Ctrl-v>`로 블록 단위 비주얼 모드를 활성한다.

| Command    | Effect                             |
|------------|------------------------------------|
| v          | Enable character-wise Visual mode  |
| V          | Enable line-wise Visual mode       |
| `<Ctrl-v>` | Enable block-wise Visual mode      |
| gv         | Reselect the last visual selection |

`gv` 명령은 비주얼 모드에서 마지막으로 선택했던 범위를 다시 선택해주는 단축키다. 문자 단위, 행 단위, 블럭 단위인지는 상관없지만, 선택 영역이 지워진 상황에서 사용하면 혼란스러울 수 있다.

#### Switching Between Visual Modes

| Command              | Effect                                                     |
|----------------------|------------------------------------------------------------|
| `<Esc>` / `<Ctrl-[>` | Switch to Normal mode                                      |
| v / V /              | Switch to Normal mode (when used from character-, line- or |
| `<Ctrl-v>`           | block-wise Visual mode, respectively                       |
| v                    | Switch to character-wise Visual mode                       |
| V                    | Switch to line-wise Visual mode                            |
| `<Ctrl-v>`           | Switch to block-wise Visual mode                           |
| o                    | Go to other end of highlighted text                        |

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

`visual_mode/chapter-table.txt`에서 `<Ctrl-v>`로 비주얼 블록 모드로 전환. `3j`로 아래 3열을 추가한 후 `x`를 눌러서 선택한 열을 제거하고 `.` 명령을 여러 번 눌러서 같은 범위를 여러 번 지운다. 두 열의 간격이 적당해질 때까지 반복한다. 넓은 범위를 선택해서 한번에 지워도 되지만 한 열씩 지우면 시각적으로 바로 확인할 수 있으므로 한 열씩 제거하는 방법이 낫다. 마지막으로 선택했던 범위를 `gv` 명령으로 다시 선택하여 `r|`로 선택한 범위를 모두 파이프 문자로 바꾼다. 행 단위 복사, 붙여넣기로 최상단 행을 복제한 후에(`yyp`) 복제한 행에서 모든 문자를 대시(-) 문자로 치환한다(`Vr-`).

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

## Chapter 5. Command-Line Mode

### Tip 27. Meet Vim’s Command Line

명령행 모드는 Ex 명령, 검색 패턴, 표현식을 입력했을 때 활성된다. `:`을 누르면 명령행 모드로 바뀐다. 이 모드는 쉘 명령행과 비슷하다. 명령을 입력한 후 `<CR>`을 눌러 실행한다. 명령행 모드에서 다시 일반 모드로 돌아가려면 `<Esc>`를 누른다.
`/`를 눌러 검색 프롬프트(search prompt)를 불러오거나 `<Ctrl-r>=`로 표현식 레지스터에 접근할 때에도 활성된다.

| Command                                         | Effect                                                                          |
|-------------------------------------------------|---------------------------------------------------------------------------------|
| :[range]delete [x]                              | Delete specified lines [into register x]                                        |
| :[range]yank [x]                                | Yank specified lines [into register x]                                          |
| :[line]put [x]                                  | Put the text from register x after the specified line                           |
| :[range]copy {address}                          | Copy the specified lines to below the line specified by {address}               |
| :[range]move {address}                          | Move the specified lines to below the line specified by {address}               |
| :[range]join                                    | Join the specified lines                                                        |
| :[range]normal {commands}                       | Execute Normal mode {commands} on each speci- fied line                         |
| :[range]substitute/{pat- tern}/{string}/[flags] | Replace occurrences of {pattern} with {string} on each specified line           |
| :[range]global/{pattern}/[cmd]                  | Execute the Ex command [cmd] on all specified lines where the {pattern} matches |

Table 7—Ex Commands That Operate on the Text in a Buffer

파일을 읽거나 쓸 때도 Ex 명령을 사용할 수 있으며(`:edit`와 `:write`), 탭을 만들거나(`:tabnew`), 창을 나누거나(`:split`), 또는 인자 목록을 이동하거나(`:prev`/`:next`) 버퍼 목록을 이동하는 경우(`:bprev`/`:bnext`)에도 사용할 수 있다. Vim의 모든 명령은 Ex 명령으로도 있다.(`:h ex-cmd-index`).

>
#### On the Etymology of Vim (and Family)
>
ed는 원래 유닉스(Unix) 문서 편집기이다. 비디오 디스플레이가 흔지 않던 시절에 쓰여졌다. 소스 코드를 롤 용지에 출력하고 텔레타이프(teletyep) 터미널로 편집했다.[Teleprinter](https://www.wikiwand.com/en/Teleprinter) 하드웨어의 제약 때문에 ed는 간결한 문법이 필수였다.
>
ed는 여러 세대에 걸친 진보를 통해서 만들어졌다.[참고](http://www.theregister.co.uk/2003/09/11/bill_joys_greatest_gift/) 비디오 디스플레이가 흔해져서 ex는 터미널 스크린으로 파일 내용을 보여주는 기능을 추가했다. 이제 편집 내용을 실시간으로 확인할 수 있었다. 스크린 편집 모드는 `:visual` 또는 짧게 `:vi` 명령으로 활성할 수 있었다. `vi`라는 이름은 이 명령에서 온 것이다.
>
Vim은 향상된 vi(vi improved)라는 뜻이다. 과소평가된 것이다! vi는 고통스럽다. Vim의 기능 목록 중 vi에서 사용할 수 없는 부분을 `:h vi-differences`에서 확인할 수 있다. Vim의 기능 향상은 필수였지만 여전히 유산도 많이 가지고 있다. Vim이 선조에게 물려받은 디자인적 제한은 매우 효율적인 명령 세트를 우리에게 주었고, 오늘날 여전히 가치 있다.
>

#### Special Keys in Vim’s Command-Line Mode

입력 모드는 입력 내용이 버퍼에 작성되지만 명령행 모드는 프롬프트에 나타난다. 두 모드에서는 `<Ctrl>` 조합 키로 명령을 호출할 수 있다. 두 모드는 몇 가지 명령을 공유한다. 예를 들어 `<Ctrl-w>`와 `<Ctrl-u>`는 각각 이전 단어까지, 또는 행의 시작까지 역방향으로 지운다. `<Ctrl-v>`와 `<Ctrl-k>`는 키보드에 없는 문자를 입력할 수 있다. `<Ctrl-r>{register}` 명령으로 명령행에 어떤 레지스터의 내용을 입력할 수 있다.

명령행 프롬프트에서는 이동이 제한적이다. `<left>`와 `<right>` 방향키를 사용하여 한 글자씩 이동할 수 있지만 일반 모드보다 많이 제한된다. 그러나 프롬프트에서 복잡한 명령들을 작성하길 원한다면 명령행 창으로 모든 편집 기능을 사용할 수 있다.

#### Ex Commands Strike Far and Wide

같은 일도 Vim의 일반 명령보다 Ex 명령을 사용하여 더 빨리 처리할 수도 있다. 일반 명령은 현재 문자나 현재 행에 동작하는 경향이 있지만, Ex 명령은 어디서든 실행할 수 있다. 커서를 움직이지 않고도 변경할 수도 있다. 특히 여러 행에 걸쳐 동시에 실행하는 능력이 Ex 명령의 가장 훌륭한 특징이다.

일반적으로 말해서, Ex 명령은 넓은 범위와 한 번의  동작으로 많은 행을 변경하는 능력을 가지고 있다. 훨씬 더 응축해서 말하면, Ex 명령은 멀리 그리고 넓게 동작한다.

### Tip 28. Execute a Command on One or More Consecutive Lines

대부분의 Ex 명령은 [range]를 지정해서 명령이 실행될 영역을 지정할 수 있다. 범위의 시작과 끝을 지정할 때는 행 번호, 마크(mark), 패턴을 이용할 수 있다.

`cmdline_mode/practical-vim.html`

```html
<!DOCTYPE html>
<html>
  <head><title>Practical Vim</title></head>
  <body><h1>Practical Vim</h1></body>
</html>
```

#### Use Line Numbers as an Address

숫자만 Ex명령으로 입력하면 행번호로 해석하여 지정한 행으로 커서가 이동한다.

파일의 끝으로 이동하고 싶다면 `$`를 입력한다.

```vim
:3p
```

위의 명령은 3번 행으로 이동하여 행의 내용을 출력한다.

`:3d`를 입력하면, 3번 행으로 이동하여 행을 삭제한다. 일반 모드에서 `3G`를 입력한 다음에 `dd`를 입력하는 것과 같다. Ex 명령이 일반 모드 명령보다 더 빠르게 사용하는 예이다.

#### Specify a Range of Lines by Address

```vim
:2,5p
2 <html>
3   <head><title>Practical Vim</title></head>
4   <body><h1>Practical Vim</h1></body>
5 </html>
```

이 명령은 2번 행부터 5번 행까지의 내용을 출력한다. 실행한 후 커서는 5번 행으로 이동한다. 범위는 일반적으로 다음 형태로 지정한다.

:{start},{end}

{start}과 {end}는 모두 주소이다. 패턴이나 마크를 주소로 사용할 수도 있다.

현재 행을 말하는 주소로 `.` 기호를 사용할 수 있다. 현재부터 파일의 끝이라는 범위를 쉽게 만들 수 있다.

```vim
:2
:.,$p
2 <html>
3   <head><title>Practical Vim</title></head>
4   <body><h1>Practical Vim</h1></body>
5 </html>
```

`%` 기호도 특별한 의미를 갖고 있다. 이 기호는 현재 파일의 모든 행을 뜻한다. `:%p` 명령은 `:1,$p` 와 결과가 동일하다. 보통 `:substitute` 명령과 같이 사용한다.

#### Specify a Range of Lines by Visual Selection

숫자로 행의 범위를 지정하는 대신 비주얼 선택(visual selection)을 할 수 있다. `2G`와 `VG` 명령으로 2행부터 파일의 끝까지 선택한다. 영역을 선택한 상태에서 `:`을 누르면 명령행 프롬프트에 `:'<,'>`라는 범위가 미리 입력된다. 암호처럼 보일지도 모르겠지만 비주얼 선택의 범위이다. 이제 Ex 명령을 입력하면 선택한 모든 행에서 실행될 것이다.

`:'<,'>p`

`'<`는 비주얼 선택의 첫 행이고, `'>`는 마지막 행이다. 이 마크는 비주얼 모드(visual mode)를 벗어나도 사용할 수 있다. 일반 모드에서 `:'<,'>p`를 사용하면, 가장 최근에  비주얼 모드의 선택 영역을 기준으로 동작한다.

#### Specify a Range of Lines by Patterns

`:/<html>/,/<\/html>/p`

복잡하게 보이지만, 일반적인 범위 형식인 `:{start},{end}`이다. {start} 주소가 `/<html>/` 패턴이고, {end} 주소는 `/<\/html>/`이다. 달리 말해 `<html>` 태그가 열린 행부터 닫힌 행까지이다.

```vim
:/<html>/+1,/<\/html>/-1p
```

#### Modify an Address Using an Offset

오프셋의 형태는 다음과 같다.

`:{address}+n`

n이 생략되면 기본값으로 1이 적용된다. `{address}`는 행 번호, 마크, 패턴을 사용할 수 있다.

```vim
:2
:.,.+3p
```

`.` 기호는 현재 행이다. 그러므로, 이 경우에는 `:.,.+3`은 `:2,5`와 같은 역할을 한다.

범위 문법은 매우 유연하여 행 번호, 마크, 패턴을 섞을 수 있고, 오프셋을 어떤 곳에도 적용할 수 있다.

| Symbol | Address                                                                     |
|--------|-----------------------------------------------------------------------------|
| 1      | First line of the file                                                      |
| $      | Last line of the file                                                       |
| 0      | Virtual line above first line of the file . Line where the cursor is placed |
| .      | line where the cursor is placed                                             |
| 'm     | Line containing mark m                                                      |
| '<     | Start of visual selection                                                   |
| '>     | End of visual selection                                                     |
| %      | The entire file (shorthand for :1,$)                                        |

0번 행은 실제로 존재하지 않지만, 맥락에 따라 주소로 사용할 수 있다. 특히 `:copy {adress}`나 `:move {adress}` 명령의 마지막 인자로 사용하여, 하나의 범위를 파일의 최상단으로 복사하거나 이동할 수 있다.

[range]는 항상 연속하는 행이지만, `:global` 명령을 사용하여 연속하지 않는 행에서 Ex 명령을 실행할 수도 있다.

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

## Chapter 7. Open Files and Save Them to Disk

### Tip 42. Open a File by Its Filepath Using ‘:edit’

:edit 명령과 파일의 절대 경로와 상대 경로를 사용하여 파일을 열 수 있다. `files/mvc` 폴더로 이동하여 vim을 실행한다.

#### Open a File Relative to the Current Working Directory

Vim에서는 bash 및 다른 셸과 마찬가지로 작업 디렉토리라는 개념이 있다. Vim은 시작될 때 쉘과 동일한 작업 디렉토리를 채택한다. `:pwd` Ex 명령(print working directory)으로 확인할 수 있다.

```vim
:pwd
/Users/drew/practical-vim/code/files/mvc
```

`:edit {file}` 명령은 작업 디렉토리에 상대 경로로 파일을 열 수 있다. `lib/framework.js` 파일을 열려면:

```vim
:edit lib/framework.js
```

`app/controllers/Navigation.js` 파일을 열려면 `:edit a<Tab>c<Tab>N<Tab>`으로 탭 키로 자동완성할 수 있다.

```vim
:edit app/controllers/Navigation.js
```

#### Open a File Relative to the Active File Directory

현재 활성 버퍼와 같은 디렉토리에 있는 파일을 열 때, 현재 버퍼에 열린 파일의 경로를 기준으로 삼는다면 이상적일 것이다.

```vim
:edit %<Tab>
```

% 기호는 활성 버퍼의 파일 경로를 뜻하는 준말이다.(:h cmdline-special). `<Tab>` 키를 누르면 활성 버퍼의 파일 경로가 나타난다. 원하는 것은 아니지만 가까워졌다.

```vim
:edit %:h<Tab>
```

:h 수정자는 파일 경로에서 파일명을 제거한다(:h ::h).

```vim
:edit app/controllers/
```

이제 `Main.js`를 입력하여(탭 키로 자동완성하자) 파일을 연다. 전체적으로 다음 키만 입력했다:

```vim
:edit %:h<Tab>M<Tab><Tab>
```

%:h 확장은 아주 유용하기 때문에 맵핑을 만들자.

>
#### Easy Expansion of the Active File Directory
>
`vimrc` file에 다음을 넣는다:
>
`cnoremap <expr> %% getcmdtype() == ':' ? expand('%:h').'/' : '%%'`
>
이제 : 명령행 프롬프트에서 `%%`를 입력하면 `%:h<Tab>`을 입력한 것과 같이 활성 버퍼의 경로로 확장한다. `:edit` 뿐만아니라 `:write`, `:saveas`, `:read`와 같은 다른 Ex 명령에서도 사용할 수 있다
>
[The :edit command](http://vimcasts.org/episodes/the-edit-command/)
>

### Tip 43. Open a File by Its Filename Using ‘:find’

`:find` 명령으로 경로 전체를 입력하지 않고 파일명만으로 파일을 열 수 있다. 이 기능을 사용하기 위해서는 먼저 `path`를 설정해야 한다.

`:find` 명령을 지금 사용하면 경로에서 `Main.js` 파일을 찾을 수 없다고 한다:

```vim
:find Main.js
E345: Can't find file "Main.js" in path
```

#### Configure the ‘path’

`path` 옵션으로 `:find` 명령을 사용할 때, Vim이 검색할 디렉토리 집합을 지정할 수 있다.(:h 'path'). app의 서브 디렉토리를 추가하려면:

```vim
:set path+=app/**
```

`**` 와일드카드는 `app/` 아래에 있는 모든 서브 디렉터리이다. 'path' 설정의 문맥에 따라 `*`와 `**`의 처리 방식이 약간 다르ㄴ다.(:h file-searching). 와일드카드는 셸이 처리하는 것이 아니고 Vim이 처리한다.

>
#### Smart Path Management with rails.vim
>
[tpope/vim-rails: rails.vim](https://github.com/tpope/vim-rails)는 레일즈 프로젝트를 쉽게 탐색할 수 있게 하는 플러그인이다. 일반적인 레일즈 프로젝트에서 볼 수 있는 모든 디렉토리를 자동으로 `path`를 설정한다. `path`를 설정할 필요없이 `:find` 명령을 사용할 수 있다.
>
여기서 그치는 것이 아니라, `:Rcontroller`, `:Rmodel`, `:Rview`과 같은 편리한 명령도 제공한다. `:find`의 특화된 버전이다, scoping its search to the corresponding directory.
>

#### Use ':find' to Look up Files by Name

이제 'path'를 설정했기 때문에 파일명만 입력하면 디렉터리 안의 파일을 열 수 있다.

`app/controllers/Navigation.js` 파일을 열려면:

```vim
:find Navigation.js
```

탭 키로 눌러 파일명을 자동완성할 수 있다. `find nav<Tab>`을 입력하고 엔터 키를 누르면 된다.

같은 이름을 가진 파일이 여러 개라면 탭 키를 누를 때마다 전체 경로와 파일명을 보여준다. 탭 키로 전체 파일 경로로 확장하지 않고 엔터 키를 누르면 처음 일치 파일을 연다.

'wildmode' 설정을 기본값 `full`에서 변경하면 탭-완성 동작이 조금 다를 수 있다.

### Tip 44. Explore the File System with netrw

Vim에 포함되어 있는 netrw 플러그인을 이용하여 파일 시스템을 탐색할 수 있다.

#### Preparation

Vim의 핵심 소스 코드에 포함되어 있지는 않지만 netrw라는 플러그인에서 제공하는 기능이다. 이 플러그인은 Vim과 함께 표준으로 제공하기 때문에 플러그인을 사용하도록 설정만 하면 아무것도 설치할 필요가 없다. `vimrc` 파일에 다음 설정만 추가하면 된다:

`essential.vim`

```vim
set nocompatible
filetype plugin on
```

#### Meet netrw—Vim’s Native File Explorer

```shell
$ cd code/file/mvc
$ ls
app app.js index.html lib
$ vim .
```

일반 Vim 버퍼이지만 파일 내용이 아니라 디렉토리의 내용을 보여준다. `k`와 `j` 키로 위아래로 이동할 수 있다. 디렉토리에서 `<CR>` 키를 누르면 그 디렉토리 내용을, 파일이면 현재 창의 버퍼로 불러온다. 부모 디렉터리로 이동하려면 `-`를 누르거나, 또는 .. 항목으로 이동해서 `<CR>`을 누른다.

`j`와 `k` 키 이외에 일반 Vim 버퍼에서 사용할 수 있는 모든 모션을 사용할 수 있다. 예를 들면, `index.html` 파일을 열고 싶다면 /html`<CR>`로 검색하여 원하는 파일명 위로 이동할 수 있다.

#### Opening the File Explorer

`:edit {path}` 명령으로 파일 탐색 창을 열 수 있다. `.` 기호는 현재 작업 디렉토리이며, `:edit .` 명령은 프로젝트 루트를 파일 탐색기로 열 수 있다.

현재 파일의 경로를 파일 탐색기로 열려면 `:edit %:h` 명령을 사용한다. netrw 플러그인은 `:Explore`라는 더 편한 명령을 제공한다(:h :Explore).

`:edit .` 대신 `:e.`의 단축 명령도 사용할 수 있다. `.` 앞에 빈칸이 필요없다. `:Explore`는 `:E`로 사용할 수 있다.(안되는데?)

netrw은 `:Sexplore`와 `:Vexplore` 명령도 있다. 각각 창을 수평이나 수직으로 나누고 파일 탐색기를 연다.

#### Working with Split Windows

텍스트 에디터의 기본 GUI는 사이드 바에 _project drawer_ 라는 파일 탐색기를 표시한다. 이런 인터페이스에 익숙하다면 Vim 의 `:E`와 `:e`이 현재 창의 내용을 파일 탐색기로 _대체하는 것이_ 이상할 수 있다. 분할 창에서도 잘 동작한다. 파일 탐색기를 열었다가 다시 원래 버퍼로 돌아가고 싶다면 `<Ctrl-^>` 명령을 누른다.

Vim의 창은 두 가지 모드를 있다고 말할 수 있다. 파일 모드와 디렉터리 모드. 이것은 분할 창 인터페이스와 완벽하게 작동하지만, project drawer 개념과 실제로 들어맞지는 않는다.

#### Doing More with netrw

netrw 플러그인으로 파일 탐색만 할 수 있는 것은 아니다. 새 파일이나(:h netrw-%) 디렉토리를(:h netrw-d) 만들고, 파일명을 바꾸거나(:h netrw-rename), 지운다(:h netrw-del). [The file explorer](http://vimcasts.org/episodes/the-file-explorer/)

netrw 이름에서 보이는 킬러 기능은 손대지 않았다: netrw는 네트워크의 파일을 읽고 쓸 수 있다. 시스템에서 사용할 수 있는 `scp`, `ftp`, `curl`, `wget`을 포함한 많은 프로토콜을 사용할 수 있다.(:h netrw-ref)

### Tip 45. Save Files to Nonexistent Directories

`:edit {file}` 명령은 이미 존재하는 파일을 여는 것이 가장 일반적이다. 파일의 경로가 일치하지 않으면, Vim은 새 빈 버퍼를 만든다. `<Ctrl-g>`를 누르면 "new file"로 표시된다(:h ctrl-G). `:write` 명령을 실행하면 Vim은 현재 버퍼 내용을 지정한 파일 경로의 새 파일에 쓰려고 한다.

`:edit {file}`을 실행할 때, 존재하지 않는 디렉터리를 파일 경로를 지정하면, 조금 이상할 것이다.

```vim
:edit madeup/dir/doesnotexist.yet
:write
"madeup/dir/doesnotexist.yet" E212: Can't open file for writing
```

madeup/dir 디렉토리가 존재하지 않는다. Vim은 새 버퍼를 만들려고 하지만, 디렉터리가 존재하지 않으면 "new DIRECTORY"로 표시한다. 외부 mkdir 프로그램을 호출하여 이 상황을 해결할 수 있다.

```vim
:!mkdir -p %:h
:write
```

`-p` 플래그는 mkdir 명령에서 중간 디렉토리를 만드는 옵션이다.

### Tip 46. Save a File as the Super User

파일의 변경 사항을 저장하기 위해 관리자 권한(sudo)이 필요한 경우가 있다. Vim을 다시 시작하지 않고 sudo 셸 명령을 사용할 수 있다.

이 팁은 GVim에서 동작하지 않을 수 있고 윈도에서 동작하지 않는다. 유닉스 터미널에서 Vim을 실행했을 때 동작하는 시나리오이다.

`/etc/hosts` 파일로 설명한다. 이 파일은 root가 소유자이나, 우리는 "drew"라는 사용자명으로 로그인하였기 때문에 이 파일을 읽을 수 있는 권한만 갖고 있다.

```shell
$ ls -al /etc/ | grep hosts
-rw-r--r--  1   root    wheel       634 6   Apr 15:59 hosts
$ whoami
drew
$ vim /etc/hosts
```

`<Ctrl-g>`로 파일 상태를 확인하면 `[readonly]`으로 표시된다. 파일을 변경하면 "W10: Warning: Changing a readonly file." 메시지를 보여주지만 상관없이 변경할 수 있다. 그러나, 저장하지 못할 것이다.

```vim
:write
E45: 'readonly' option is set (add ! to override)
```

메시지가 안내하는 대로 명령 끝에 뱅(!) 기호를 붙여서 다시 실행한다. 뱅 기호는 "이번에는 실행한다!"로 읽을 수 있다.

```vim
:write!
"/etc/hosts" E212: Can't open file for writing
```

여기에서 문제는 `/etc/hosts` 파일을 쓸 권한이 없다는 점이다. root가 소유하고 있고 사용자 drew Vim을 실행했다는 것을 기억하라. 해결책은 다음 이상하게 보이는 명령이다:

```vim
:w !sudo tee % > /dev/null
Password:
W12: Warning: File "hosts" has changed and the buffer was
changed in Vim as well
[O]k, (L)oad File, Load (A)ll, (I)gnore All:
```

이 명령을 입력하면 두 자기를 더 요구한다. 먼저 drew의 비밀번호를 입력해야 한다. 그 후 Vim은 파일이 변경되었다는 점을 경고하고 선택 메뉴를 제시한다. 일단 `l`을 눌러 파일을 다시 버퍼로 불러오는 것을 권한다.

어떤 원리로 동작할까? `:write !{cmd}` 명령은 버퍼 내용을 `{cmd}`로 호출한 외부 프로그램의 표준 입력으로 전송한다(:h :write_c). Vim은 여전히 drew 사용자 권한으로 사용하고 있지만 외부 프로세스는 관리자 권한으로 실행하도록 요청할 수 있다. 여기에서는 `/etc/hosts` 파일을 작성할 수 있도록 sudo 권한으로 유틸리티 `tee`를 실행했다.

Vim의 명령행에서 `%` 기호는 특별한 의미로 사용한다. 이 기호는 현재 버퍼의 경로를 의미한다(:h :_%). 여기에서는 `/etc/hosts`이다. 그래서 최종적으로 `tee /etc/hosts > / dev/null` 명령을 실행한다. 이 명령은 버퍼 내용을 표준 입력으로 받아서 `/etc/hosts` 파일의 내용을 덮어쓴다.

외부 프로그램이 파일을 변경하면 Vim은 그 변경을 감지한다. 즉, 지금 상황 에서는 버퍼를 생성할 때의 파일 내용과 실제 파일 내용이 일치하지 않는 것을 감지했기 때문에 Vim이 현재 버퍼의 변경 내역을 유지할지, 아니면 디스크의 파일을 불러올지 물어보게 된다. 이 예제에서는 파일과 버퍼의 내용이 같다.

## Part III. Getting Around Faster

모션(Motion)은 커서 이동에 더해 동작-대기 모드에서 문서 범위를 조작할 수도 있다.

## CHAPTER 8. Navigae Inside Files with Motions

텍스트 개체(text object)는 동작-대기 모드의 꽃이다.(:h motion.txt)

### Tip 47. Keep Your Fingers on the Home Row

빔은 터치 타이피스트(touch typist)에 최적이다. 키보드 중앙(home row)에서 손을 띠지 않고 그 주위를 움직이는 것을 배우면 빔을 더 빨리 작동할 수 있다. 쿼티(qwerty) 키보드에서 왼손은 a, s, d, f에 오른손은 j, k, l, ;에 놓는 것을 말하고, 이 위치에서 다른 키 대부분을 손을 움직이지 않고도 닿는다. 가장 이상적인 키보드 입력 자세이다.[참고](http://www.catonmat.net/blog/why-vim-uses-hjkl-as-arrow-keys/) j가 아래 방향을 가리키는 화살표처럼 생겼다고 기억한다.

#### Leave Your Right Hand Where It Belongs

커서를 왼쪽으 로 이동하는 데 h를 두 번 이상 누르는 것보다 대신에 문자 검색 명령을 사용한다. `;`를 새끼 손가락으로 누를 수 있는 기본 위치가 더 편하다. 수평으로 움직일 때는 단어 단위 모션, 문자 검색 모션을 활용한다.

### Tip 48. Distinguish Between Real Lines and Display Lines

Vim에는 실제 행과 표시 행이 있다. 줄바꿈(wrap) 설정을 기본으로 사용하기 때문에,창의 너비보다 내용은 줄을 바꿔 모든 내용을 화면에 보여준다. 하나의 행이 여러 줄로 표시된다.

실제 행과 표시 행의 차이를 가장 간단히 알아볼 수 있는 방법은 행 번호(number) 설정을 켜는 것이다.
`j`와 `k`는 실제 행을 기준으로 이동한다. `gj`와 `gk`은 표시 행을 기준으로 이동한다.

| Command | Move Cursor                                                       |
|---------|-------------------------------------------------------------------|
| j       | Down one real line                                                |
| gj      | Down one display line                                             |
| k       | Up one real line                                                  |
| gk      | Up one display line                                               |
| 0       | To first character of real line                                   |
| g0      | To first character of display line                                |
| ^       | To first nonblank character of real line                          |
| g^      | To first nonblank character of display line $ To end of real line |
| g$      | To end of display line                                            |

`j`, `k`, `O`, `$`는 실제 행을 대상으로 사용하는 명령이다. 이 명령 앞에 `g`를 붙이면 표시 행을 대상으로 사용하는 명령이 된다.

>
#### Remap Line Motion Commands
>
motions/cursor-maps.vim
nnoremap k gk
nnoremap gk k
nnoremap j gj
nnoremap gj j
>
이 설정은 `j`, `k`가 표시 행을 이동하고, `gj`, `gk`가 실제 행을 이동하도록 변경한다. 기본 동작과 반대로 설정한 것이다. 그러나 Vim을 여러 환경에서 자주 사용하고 있다면 설정을 바꾸는 것보다는 기본 동작과 친숙해지는 편이 낫다.
>

### Tip 49. Move Word-Wise

Vim은 단어 단위로 빠르게 이동할 수 있는 모션을 제공한다(:h word-motions).

| Command | Move Cursor                                                                      |
|---------|----------------------------------------------------------------------------------|
| w       | Forward to start of next word                                                    |
| b       | Backward to start of current/previous word e Forward to end of current/next word |
| ge      | Backward to end of previous word                                                 |

`w`, `b`는 단어의 처음으로, `e`와 `ge`는 단어의 마지막으로 이동한다. `w`와 `e`는 커서를 앞으로 이동하고 `b`, `ge`는 뒤로 이동한다. 전진을 뜻하는 (for-)word와 후진을 뜻하는 backword를 생각하면 도움이 된다.

`ea`는 현재 단어의 끝에 덧붙인다. 하나의 명령처럼 사용되곤 한다. `gea`는 이전 단어 끝에 덧붙인다.

#### Know Your Words from Your WORDS

Vim에는 단어에 대한 두 가지 정의가 있다. word와 WORD이다. 앞서 살펴 본 word 단위 모션은 WORD 단위 모션에도 호환된다. `W`, `B`, `E`, `gE`가 해당한다. 다만 word와 WORD는 정의가 조금 다르다. word는 문자, 숫자, 밑줄(_) 또는 다른 블럭 아닌(nonblock) 문자의 연속으로 이뤄지고 공백으로 분리된 단위이다.(:h word). 반면에 WORD는 단순하다. 블럭아닌 문자의 연속이며 공백으로 분리된 경우를 WORD로 정의한다(:h WORD). WORD는 단어보다 크다. 빠르게 이동하고 싶다면 WORD 단위로, 섬세하게 이동하고 싶다면 word 단위로 이동한다.

### Tip 50. Find by Character

문자 검색 명령으로 행 안에서 빠르게 이동할 수 있다. 이 문자 검색 명령은 동작-대기 모드에서 작동한다. `f{char}` 명령은 특정 문자를 검색하는 명령으로 현재 커서 위치에서 현재 행의 끝까지 검색한다. 일치하는 문자를 찾으면 커서는 그 문자로 이동한다. 일치하는 문자를 찾지 못하면 커서가 움직이지 않는다(:h f).

Vim은 가장 최근의 `f{char}` 검색을 기억하기 때문에 `;` 명령을 사용해서 마지막 검색을 반복하면 된다(:h ;). `;`를 입력하다가 원하는 위치를 지나쳤다. 위치를 다시 되돌리기 위해 `,` 명령을 사용할 수 있다. 이 명령은 마지막 `f{char}` 검색을 똑같이 수행하지만 반대 방향으로 진행한다(:h , 참고).

>
#### Don’t Throw Away the Reverse Character Search Command
>
Vim에서 키보드에 있는 키 대부분에 기능이 배정되어 있다. 만약 자신만의 특별한 기능을 추가하고 싶다면 사용자 정의 명령의 네임스페이스로 사용할 수 있는 리더 키(`<Leader>`)를 제공한다. 아래 설정을 추가하면 `<Leader>`를 사용하여 자신만의 커스텀 설정을 만들 수 있다:
>
noremap <Leader>n nzz
noremap <Leader>N Nzz
>
기본 리더 키는 `\`다. 따라서 위에서 만든 커스텀 설정은 `\n`, `\N`으로 사용할 수 있다. 여기에 사용된 zz가 무슨 역할을 하는지 궁금하면 `:h zz`를 확인하자.
키보드 종류에 따라 `\` 명령을 사용하기 불편할 수도 있다. 이런 경우 리더 키를 다른 키로 변경하여 사용한다(:h mapleader 참고). 일반적으로 쉼표 키를 사용한다. 리더 키를 쉼표 키로 바꾼다면, 이미 쉼표에는 역방향 문서 검색 명령이 배정되어 있기 때문에 이 기능을 다른 키에 배정하기를 권한다.
>
let mapleader=","
noremap \ ,
>
단어 검색 명령인 `;`와 `,` 명령은 서로 보완하는 관계다. 두 명령 중 하나만 사용한다면 단어 검색의 유용성이 많이 떨어진다.
>

#### Character Searches Can Include or Exclude the Target

`f{char}`, `;`, `,` 명령은 문자 검색 명령 중 일부이다. 다음 표는 모든 문자 검색 명령 목록이다.

| Command | Effect                                                            |
|---------|-------------------------------------------------------------------|
| f{char} | Forward to the next occurrence of {char}                          |
| F{char} | Backward to the previous occurrence of {char}                     |
| t{char} | Forward to the character before the next occurrence of {char}     |
| T{char} | Backward to the character after the previous occurrence of {char} |
| ;       | Repeat the last character-search command                          |
| ,       | Reverse the last character-search command                         |

`t{char}`와 `T{char}`는 검색하는 문자가 나타날 때까지(till) 검색한다고 생각하자. `f{char}`, `F{char}`는 해당 문자가 나타나는 위치로 커서가 이동하지만 `t{char}`, `T{char}` 명령은 `{char}`의 한 글자 앞으로 커서가 이동한다.

`,`문자에서 문장의 마지막 문자 직전까지 삭제하려면 `f,dt.`을 사용할 수 있다.

일반 모드에서 `f{char}`와 `F{char}` 명령은 현재 행에서 빠르게 커서를 이동할 때 자주 사용한다. 그리고 `d{motion}`과 `c{motion}`을 사용할 때 `t{char}`, `T{char}` 명령과 함께 사용하는 편이다. 이 설명을 다른 방향에서 보면, 일반 모드에서는 `f` 또는 `F`를 주로 사용하고, 동작-대기모드에서는 `t` 또는 `T`를 주로 사용한다고 말할 수 있다.

#### Think Like a Scrabble® Player

Improve your writing by deleting excellent adjectives.

excellent로 이동하기 위해서 `fe`를 사용하면 `;`을 세 번이나 더 눌러야 한다. `fx`를 사용한다면 한 번에 원하는 단어로 이동하여 `daw`로 단어를 삭제한다.

## CHAPTER 9.Navigate Between Files with Jumps

점프(jump)는 모션과 비슷하지만 다른 파일 사이를 이동할 수 있다.

### Tip 56. Traverse the Jump List

Vim은 점프할 때 이동 전과 후의 위치를 모두 저장하고, 그 발자취를 알 수 있는 명령을 제공한다.

웹 브라우저에서는 뒤로 버튼으로 이전에 방문했던 페이지로 이동할 수 있다. Vim은 비슷한 기능을 하는 점프 목록(jump list)이 있다. `<Ctrl-o>` 명령이 뒤로 버튼과 같으며 `<Ctrl-i>` 명령은 앞으로 버튼과 같다. 이 명령으로 점프 목록을 오갈수 있다.

모션은 파일 안에서 이동할 때 사용하고, 점프는 파일 사이를 이동할 때 사용한다.(모션 중 점프로 구분되는 일부 모션이 있지만)

점프 목록을 보려면:

```vim
:jumps
jump line col file/text
   4   12   2 <recipe id="sec.jump.list">
   3  114   2 <recipe id="sec.change.list">
   2  169   2 <recipe id="sec.gf">
   1  290   2 <recipe id="sec.global.marks">
>
Press Enter or type command to continue
```

현재 창에서 파일을 변경하는 명령은 모두 점프 명령이라고 말할 수 있다. Vim은 점프 명령을 실행하 기 전과 후의 위치를 점프 목록에 기록한다. `:edit` 명령으로 새 파일을 열었다면 두 파일을 `<Ctrl-o>`와 `<Ctrl-i>` 명령으로 오갈 수 있다.

`[count]G`로 특정 행으로 바로 이동하는 것은 점프이지만 한 행씩 이동하는 것은 점프가 아니다. 문장 단위 및 단락 단위의 모션은 점프이지만 문자와 단어의 모션은 점프가 아니다. 일반적으로 장거리 모션은 점프로 분류될 수 있지만 단거리 모션은 그냥 모션이다.

점프로 처리되는 명령을 정리한다:

| Command                           | Effect                                         |
|-----------------------------------|------------------------------------------------|
| [count]G                          | Jump to line number                            |
| /pattern`<CR>`/?pattern`<CR>`/n/N | Jump to next/previous occurrence of pattern    |
| %                                 | Jump to matching parenthesis                   |
| ( / )                             | Jump to start of previous/next sentence        |
| { / }                             | Jump to start of previous/next paragraph       |
| H / M / L                         | Jump to top/middle/bottom of screen            |
| gf                                | Jump to file name under the cursor             |
| `<Ctrl-]>`                        | Jump to definition of keyword under the cursor |
| '{mark} / `{mark}                 | Jump to a mark                                 |

`<Ctrl-o>`와 `<Ctrl-i>` 명령 자체는 모션으로 처리되지 않는다. 비주얼 모드에서 선택 영역을 확장하거나 동작-대기 모드에서 이 명령을 사용할 수 없다는 뜻이다.

Vim은 여러 점프 목록을 동시에 관리 한다. 실은 각 창마다 각 점프 목록이 있다. 창 분할이나 다중 탭 페이지를 사용하고 있다면 `<Ctrl-o>`와 `<Ctrl-i>` 명령은 항상 활성 창의 점프 목록을 따라 이동한다.

>
#### Beware of Mapping the Tab Key
>
입력 모드에서 `<Ctrl-i>`는 `<Tab>`을 입력하는 것과 같다. Vim이 `<Ctrl-i>`와 `<Tab>`을 같은 것으로 보기 때문이다.
>
`<Tab>` 키의 매핑을 변경하면, `<Ctrl-i>`를 누를 때도 변경된 매핑을 실행한다.(반대도 마찬가지다) 그러므로 `<Tab>`을 다른  기능으로 변경할 때는 점프 목록을 이동하는 `<Ctrl-i>`를 포기할 만큼 중요한지 고려해야 한다. 한 방향으로만 이동하는 것은 그다지 유용하지 않기 때문이다.
>

### Tip 57. Traverse the Change List

작업을 취소하는 명령과 취소한 작업을 다시 되돌리는 명령을 실행하면 최근에 변경한 위치로 이동하는 부차적인 효과도 생긴다. 실행 취소 명령은 최근 변경 위치로 돌아가고 싶은 경우에도 유용하다. `u<Ctrl-r>`은 일종의 해킹이다.

Vim은 편집 세션 중에 각 버퍼에 대한 수정 목록을 관리한다. 이 것을 변경 목록(change list)이라고 한다.(:h changelist) `:changes` 명령으로 내용을 볼 수 있다.

`g;`와 `g,` 명령으로 변경 목록에서 앞 뒤로 이동할 수 있다. `;`와 `,` 명령이 `f{char}` 명령을 반복하거나 역반복할 수 있다는 것을 생각하면 기억하기 쉬울 것이다.

문서에서 최근 변경으로 되돌아 가려면 `g;`를 입력한다. `u<Ctrl-r>`을 입력해도 결과는 같지만, 문서에 일시적인 변경을 만든다.

#### Marks for the Last Change

Vim은 변경 목록을 보완하기 위해서 마크를 자동으로 생성한다. `` `. `` 마크는 항상 마지막 변경의 위치를 참조한다.(:h `` `. ``) `` `^ `` 마크는 입력 모드를 종료한 마지막 위치를 기록한다.

대부분의 시나리오에서 `` `. `` 마크로 이동하면 `g;` 명령과 효과가 같다. 하지만 `` `. `` 마크가 마지막 변화의 위치만을 저장하는 것과 달리 변경 목록은 여러 위치를 저장한다. `g;`를 반복 입력할 때마다 변경 목록에 저장된 위치를 순서대로 이동할 수 있다. 반면 `` `. ``는 변경 목록에서 가장 마지막 위치로만 이동한다.

`` `^ `` 마크는 마지막 _변경_과는 살짝 다른, 마지막 _입력_ 위치를 참조한다. 입력 모드를 벗어나서 문서를 스크롤한 후 `gi`를 입력하여 벗어난 곳으로 빠르게 갈 수 있다. `` `^ ``는 한 번의 움직임으로 커서 위치를 복원하고 입력 모드로 전환한다.

Vim은 변경 목록을 버퍼를 기준으로 관리한다. 대조적으로, 점프 목록은 창을 기준으로 만든다.

## Part IV. Registers

Vim의 레지스터는 단순히 텍스트를 담는 보관함이다. 클립보드처럼 텍스트를 자르고, 복사하고 붙여 넣을 수 있으며, 일련의 키 입력을 저장하여 하나의 매크로로 기록할 수 있다.

## CHAPTER 10. Copy and Paste

### Tip 60. Delete, Yank, and Put with Vim’s Unnamed Register

보통 잘라내기, 복사하기, 붙여넣기에 대해 이야기할 때는 클립보드에 텍스트를 넣는 것을 이야기한다. 하지만 Vim에서는 클립보드 대신에 _레지스터_ 를 사용한다.

#### Transposing Characters

오타를 내는 최대 이유는 문자 두 개의 순서가 바뀌는 것이다. Vim에서는 이런 실수를 쉽게 고칠 수 있다.

![두 글자 바꾸기](/images/posts/Transposing_Charaters.gif)

`F␣` 명령으로 바꾸길 원하는 두 문자의 처음으로 이동한다. `x` 명령으로 커서 밑의 문자를 잘라내서 무명 레스트로 복사한다. `p` 명령으로 커서 다음에 무명 레지스터의 내용을 붙여넣는다. 함께 사용하면 `xp` 명령은 "다음 두 문자 서로 바꾸기"로 생각할 수 있다.

#### Transposing Lines

![두 줄 바꾸기](/images/posts/Transpoing_Lines.gif)

`x` 명령으로 현재 문자를 잘라내는 대신 `dd` 명령으로 줄을 잘라낼 수 있다. 이번에는 `p` 명령은 줄 단위로 텍스트를 다루어야 한다는 것을 안다. 현재 줄 아래에 무명 레지스터 내용을 붙여넣는다.

`ddp`는 :현재 줄과 다음 줄의 순서를 서로 바꾸기"로 생각할 수 있다.

#### Duplicating Lines

`yyp`는 줄 단위 복사하고 붙여넣기 기능으로 동작하고 줄 단위로 복제하는 데 유용하다.

#### Oops! I Clobbered My Yank

`copy_and_paste/collection.js`:

```javascript
collection = getCollection();
process(somethingInTheWay, target);
```

`yiw` 를 입력해서 `collection`을 무명 레지스터에 복사한다. 이제 `jww`로 복사한 단어를 넣을 위치인 `somethungIhTheWay`로 이동한다. `diw` 명령으로 `somethungIhTheWay`를 지운다. `P`를 눌러 무명 레지스터에 있는 내용을 커서 앞에 붙여넣는다. 하지만 `collection`이 아니라 `somethungIhTheWay`가 나타난다.

`diw` 명령은 단어를 단순히 지우기만 하는 게 아니라 지운 단어를 무명 레지스터에 복사하기도 한다. 익숙한 표현으로는 `diw`는 단어를 잘라낸다(_cut_ the word).

이 문제를 해결하려면 Vim 레지스터가 어떻게 동작하는지 더 깊이 이해해야 한다.

### Tip 61. Grok Vim’s Registers

보통 잘라하기(cut), 복사하기(copy), 붙여넣기(paste)는 한 개의 클립보드와 동작하지만, Vim에는 여러 레지스터가 있다.

#### Addressing a Register

Vim의 지우기(cut), 복사하기(yank), 넣기(pu) 명령을 사용할 때 명령 앞에 `"{register}`를 붙이면 어느 레지스터를 사용할지 지정할 수 있다. 레지스터를 지정하지 않으면 무명 레지스터를 사용한다.

>
#### Vim’s Terminology Versus the World
>
잘라내기(cut), 복사하기(copy), 붙여넣기(paste)는 대부분의 데스크탑 운영 체제와 소프트웨어 프로그램에서 보편적으로 사용할 수 있다. Vim에서도 제공되지만, 용어가 다르다: 제거하기(delete), 복사하기(yank), 붙여넣기(put)
>
Vim의 붙여넣기(put) 명령은 일반적인 붙여넣기(paste)와 동일하게 동작한다. 다행히 두 단어 모두 _p_ 문자로 시작하기 때문에 어느 용어를 사용해도 된다.
>
Vim의 복사하기(yank) 명령은 일반적인 복사하기(copy)처럼 동작하는데, 역사적인 이유가 있다. `c` 명령이 이미 교체하기(change) 동작에 배정되어 있어 복사하기(copy)를 대체할 이름을 찾아야 했다. `y` 키가 있어서 복사하기 동작이 yank 명령이 되었다.
>
Vim의 제거하기(delete) 명령은 표준 잘라내기(cut) 동작과 같다. 이 명령은 특정 텍스트를 레지스터에 저장한 다음 문서에서 제거한다.
>
실제 제거하기(delete) 기능은 Vim에 없을까? Vim에는 블랙 홀이라 부르는 특별한 레지스터가 있다. 이 레지스터는 아무 것도 반환하지 않는다. 블랙 홀 레지스터는 `_` 기호로 참조할 수 있다(:h quote_). `"_d{motin}`으로 진짜로 제거(delete)할 수 있다.
>

현재 단어를 `a` 레지스터에 복사하려면 `"ayiw`를 입력하면 된다. 현재 행을 레지스터 `b`에 잘라내려면 `"bdd`라고 입력한다. 레지스터 `a`에 저장한 단어를 문서에 붙여넣으려면 `"ap` 명령을, 레지스터 `b`에 저장한 행을 붙여넣으려면 `"bp` 명령을 사용한다.

일반 모드 명령뿐 아니라, Ex 명령으로도 사용할 수 있다. 현재 행을 잘라내서 `c` 레지스터에 저장하 려면 `:delete c`를 실행하면 된다. 현재 행 밑에 붙여 넣으려면 `:put c`를 입력한다. 일반 모드 명령에 비해서 거창하게 느껴질 수 있지만 Vim 스크립트에서 다른 Ex 명령과 함께 조합하면 유용하다.

#### The Unnamed Register ("")

레지스터를 지정하지 않으면, Vim은 무명 레지스터를 사용한다. 이 무명 레지스터는 " 기호로 참조할 수 있다(:h quote_quote). 이 레지스터를 명시적으로 참조하려면 두 개의 큰 따옴표를 사용해야한다. 예를 들면, `""p`는 `p`와 같다.

`x`, `s`, `d{motion}`, `c{motion}`, `y{motion}` 명령(대문자 명령도 같다)은 모두 무명 레지스터를 사용한다. 명령 앞에 `"{register}`를 붙이면 해당 레지스터를 사용하지만, 무명 레지스터를 기본 값이다. 무명 레지스터의 내용을 쉽게 덮어쓸 수 있으니, 주의해야 한다.

사실 Vim이 선택한 용어는 적절하지 않다. `x`와 `d{motion}` 명령은 일반적으로 "지우기(delete)" 명령이라고 하는데 잘못된 명칭이다. "잘라내기(cut)" 명령으로 생각하는 게 더 낫다. 무명 레지스터는 종종 우리가 기대하는 텍스트를 가지고 있지 않다. 그러나 다행히도 복사하기(yank) 레지스터는 더 신뢰할 수 있다.

#### The Yank Register ("0)

`y{motion}` 명령을 사용하면 선택한 텍스트가 무명 레지스터 뿐만 아니라 복사하기 레지스터에도 저장한다. 복사하기 레지스터는 `0` 기호로 참조할 수 있다(:h quote0).

레지스터 이름처럼 이 레지스터는 `y{motion}` 명령을 사용했을 때만 저장한다. 다시 말해서 `x`, `s`, `c{motion}`, `d{motion}` 명령은 저장하지 않는다. 텍스트를 복사하면, 다른 텍스트를 복사해서 명시적으로 덮어 쓸 때까지 레지스터 `0`에 계속 보관된다. 무명 레지 스터는 쉽게 날아가지만 복사하기 레지스터는 신뢰할 수 있다.

앞에서의 문제를 해결하기 위해 복사하기 레지스터를 사용할 수 있다.

![단어 복사하고 단어 대체하기](/images/posts/Copy_word_and_replace_word.gif)

아직도 `diw` 명령은 무명 레지스터를 덮어쓰지만, 복사하기 레지스터는 건드리지 않는다. `"OP` 명령으로 복사하기 레지스터에서 안전하게 붙여넣을 수 있다. 원하는 대로 동작했다.

무명 레지스터와 잘라내기 레지스터의 내용을 확인하면, 어떤 본문을 제거하고 복사 했는지 확인할 수 있다:

```vim
:reg "0
--- Registers ---
""  somethingInTheWay
"0  collection
```

#### The Named Registers ("a–"z)

Vim에서는 알파벳 모든 문자에 해당하는 이름(named) 레지스터를 제공한다(:h quote_alpha). 26 조각의 텍스트를 잘라내기(`"ad{motion}`), 복사하기(`"ay{motion}`), 붙여넣기(`"ap`)할 수 있다는 것을 말한다.

이름 레지스터를 사용하려면 추가적인 키 입력이 있어야 하니 간단한 상황에서는 복사하기 레지스터("0)가 더 낫다. 이름 레지스터는 하나 이상의 텍스트 조각을 여러 위치에서 붙여넣기를 원할 때 아주 유용하다.

이름 레지스터를 소문자로 참조하면 지정된 레지스터를 덮어쓰지만, 대문자로 참조하면 지정한 레지스터에 추가한다.

#### The Black Hole Register ("_)

블랙홀 레지스터는 아무 내용도 반환하지 않는다. 이 레지스터는 밑줄 기호로 참조한다(:h quote_). `"_d{motion}` 명령을 실행하면 Vim은 복사본을 하나도 저장하지 않고 지정한 텍스트를 제거한다. 이 기능은 무명 레지스터의 내용을 덮어쓰지 않고 텍스트를 지우고 싶을 때 유용할 수 있다.

#### The System Clipboard ("+) and Selection ("*) Registers

지금까지 다룬 모든 레지스터는 Vim 내부에서 사용하는 레지스터이다. Vim에서 복사한 텍스트를 외부 프로그램에 붙여넣으려면(또는 그 반대) 시스템 클립보드를 사용해야 한다.

Vim의 플러스 레지스터는 시스템 클립보드를 참조하며 `+` 기호로 사용할 수 있다(:h quote+).

외부 애플리케이션에서 복사하거나 잘라낸 텍스트를 Vim에서 사용하려면 `"+p` 명령으로 붙여넣을 수 있다. (또는 입력 모드에서 `<Ctrl-r>+` 명령을 사용) 반대로 Vim의 복사 또는 삭제 명령 앞에 `"+`를 붙이면 그 텍스트를 시스템 클립 보드에 저장되어 다른 애플리케이션에서 쉽게 붙여넣을 수 있다.

X11 윈도우 시스템에는 원시(primary) 클립보드라고 하는 다른 종류의 클립 보드가 있다. 이 클립보드는 가장 최근에 선택한 내용을 저장하며 마우스 가운데 버튼을 (만약 있다면) 눌러 붙여넣을 수 있다. Vim에서는 인용별(quotestar) 레지스터가 이 원시 클립보드와 연결되어 있으며 `*` 기호로 참조할 수 있다(:h quotestar).

윈도와 맥 OS X에는 원시 클립보드가 없기 때문에 `"+`,`"*` 레지스터는 둘 다 시스템 클립보드를 참조한다.

#### The Expression Register ("=)

Vim의 레지스터는 단순히 텍스트 블록을 저장하는 보관함이라고 생각할 수 있지만, `=` 기호로 참조하는 표현식 레지스터는 예외이다(:h quote=). 표현식 레지스터를 사용하면 Vim은 명령행 모드로 전환되고 `=` 프롬프트에 보여준다. Vim 스크립트 표현식을 입력한 다음에 `<CR>`을 눌러 스크립트를 실행할 수 있다. 표현식이 문자열(또는 쉽게 문자열로 강제 변환될 수 있는 값)을 반환하면 Vim은 그 결과를 사용한다.

#### More Registers

제거하기 명령 또는 복사하기 명령을 사용해서 이름 레지스터, 무명 레지스터, 복사 레지스터의 내용을 명시적으로 설정할 수 있다. Vim은 암시적으로 값이 설정된 레지스터도 제공한다. 전체적으로 읽기전용 레지스터로 알려져 있다(:h quote.).

| Register | Contents                   |
|----------|----------------------------|
| "%       | Name of the current file   |
| "#       | Name of the alternate file |
| ".       | Last inserted text         |
| ":       | Last Ex command            |
| "/       | Last search pattern        |

기술적으론 `"/` 레지스터는 읽기 전용이 아니며, `:let` 명령을 사용하여 명시적으로 검색 패턴을 저장할 수 있다(:h quote/). 하지만 편의상 이 표에 포함한다.

### Tip 62. Replace a Visual Selection with a Register

비주얼 모드에서 붙여넣기 명령을 사용하는 경우에 독특한 특징이 있다.

비주얼 모드에서 `p` 명령을 사용하면 특정 레지스터에 있는 내용으로 _선택한 영역을 대체한다_(:h v_p). 이 기능을 Tip.60의 "악! 복사한 내용을 날렸다" 문제를 해결할 때 사용할 수 있다.

`copy_and_paste/collection.js`

```javascript
collection = getCollection();
process(somethingInTheWay, target);
```

`yiw`를 입력해서 collection 단어를 무명 레지스터에 복사한다. 이제 `jww`로 복사한 단어를 넣을 위치인 somethungIhTheWay로 커서를 이동한다. `ve` 명령으로 somethungIhTheWay을 선택한다.
`p`를 눌러 선택 영역을 무명 레지스터에 있는 내용으로 대체한다.

이 해결책은 내가 가장 선호하는 방법이다. 삭제 단계가 없으므로 무명 레지스터를 사용하여 yank 및 put 작업을 수행 할 수 있다. 대신 삭제 및 붙여넣는 작업을 선택 영역을 대체하는 하나의 단계로 결합한다.

이 기법의 부가적인 효과를 이해하는 것도 중요하다. `u`를 눌러서 마지막 변경을 취소해보자. 이제 `gv`를 눌러서 마지막 선택 영역을 다시 선택하고 `p`를 입력한다. 무슨 일이 일어났는가? 아무 일도 일어나지 않았다!

이 작업을 다시 실행할 때는 `"0p` 명령을 사용해서 복사 레지스터의 내용으로 선택 영역을 대체해야 한다. 처음 `p` 명령을 사용했을 때는 무명 레지스터에 원하는 텍스트가 있었다. 두 번째에는 `p` 명령으로 지워진 문자열이 무명 레지스터에 덮어 쓰인다.

이 기능이 얼마나 이상한지는 표준 잘라내기, 복사하기, 붙여넣기 모델의 API와 비교해보면 더 명확하다. 이 API는 `setClipboard()`와 `getClipboard()`라는 메소드가 있다. 잘라내기와 복사하기 동작은 둘 다 `setClipboard()`를 호출하고 붙여넣기 동작은 `getClipboard()`를 호출한다. 비주얼 모드에서 `p` 명령을 사용하면 두 메소드를 동시에 사용한다: 무명 레지스터의 내용을 _가져오고_, 무명 레지스터의 내용을 _설정한다_. 즉, 무명 레지스터에서 붙여넣을 내용을 가져온 다음, 제거한 내용을 다시 무명 레지스터에 입력한다.

이 기능은 문서의 선택 영역과 레지스터에 있는 텍스트가 _서로의 위치를 맞바꾼다고_ 생각할 수 있다. 이 특징이 하나의 기능일까, 아니면 버그일까? 각자의 판단에 맡긴다.

#### Swap Two Words

이 부분은 실제 쓸 일이 없다. 저자도 그냥 두 단어를 `c3w`로 전부 지우고 다시 쓰는 게 빠르다고 함.(놀부)

### Tip 63. Paste from a Register

_일반 모드에서 붙여넣기 명령은 어떤 텍스트를 붙여넣는가에 따라서 다르게 동작할 수 있다. 행 단위 또는 문자 단위인지에 따라 다른 전략을 채택하는 것이 도움이 될 수 있다._

`p` 명령은 커서 다음에 레지스터에 있는 텍스트를 붙여넣는다(:h p). 대문자 `P` 명령은 커서 앞에 붙여넣는다.

행 단위 복사나 삭제 동작(`dd`, `yy`, `dap` 등)은 행 단위 레지스터를 만들고, 문자 단위 복사나 삭제 동작(`x`, `diw`, `das` 등)은 문자 단위 레지스터를 만든다. 보통 `p` 명령의 출력 결과는 상당히 직관적으로 동작한다(:h linewise-register).

#### Pasting Character-wise Regions

`p`와 `P`를 사용해야 하는 상황을 직관적으로 판단하기가 쉽지 않다. 실제로 잘못 입력하는 경우가 많아 `puP` 또는 `Pup`를 실제 체득하고 있다.

문자 단위로 선택할 필요가 없다. 일반 모드 `p`와 `P` 명령보다는 입력 모드에서 `<Ctrl-r>{register}` 명령으로 붙여 넣는 것을 자주 이용한다. 이 기법을 사용하면 레지스터에 있는 텍스트를 항상 커서 앞에 붙여넣는다. 마치 입력 모드에서 계속 타자하는 것과 같은 느낌이다.

입력 모드에서 `<Ctrl-r>"`로 무명 레지스터의 내용을 넣을 수 있고, `<Ctrl-r>0`로 복사 레지스터의 내용을 넣을 수 있다.

![단어 복사하고 입력 모드에서 대체하기](/images/posts/Copy_word_and_replace_word_I_Mode.gif)

`ciw` 명령을 사용하면 부수적인 혜택도 있다. 이제부터 `.` 명령이 현재 단어를 "collection"으로 대체한다.

#### Pasting Line-Wise Regions

행 단위 레지스터를 붙여넣으면 `p`는 현재 행 아래에, `P`는 현재 행 위에 텍스트를 붙여넣는다. 단어 단위 동작에 비해서 더 직관적이다.
`gp`와 `gP` 명령도 기억해둘만 하다. `p`, `P` 명령처럼 현재 행의 위 또는 아래에 텍스트를 붙여넣지만, 커서가 붙여넣은 텍스트의 시작 대신 끝에 위치한다. `gP` 명령은 특히 여러 행을 복사할 때 유용하다.

![코드 블럭 복사하고 붙여넣기](/images/posts/Copy_code_block_Paste.gif)

복사한 텍스트를 템플릿처럼 사용해서 표의 셀 내용만 원하는 대로 변경할 수 있다.

### Tip 64. Interact with the System Clipboard

_Vim의 내장된 put 명령 외에도 가끔 시스템  붙여넣기(paste) 기능을 사용할 때가 있다. 그러나 이것을 사용하면 터미널에서 Vim을 실행할 때 예기치 않은 결과가 발생할 수 있다. 시스템 붙여넣기 명령을 사용하기 전에 'paste' 옵션을 활성 상태로 하면 이러한 문제를 피할 수 있다._

다음과 같이 vim을 터미널에서 구동해보자.

```shell
$ vim -u NONE -N
```

시스템 클립보드를 붙여넣을 때 문제가 발생하는 경우는 대부분 'autoindent' 설정이 활성 상태이기 때문이다. 이 현상을 관찰하기 위해 다음처럼 설정을 활성한다.

```vim
:set autoindent
```

이제 다음 코드를 시스템 클립보드로 복사한다.

`copy_and_paste/fizz.rb`

```ruby
[1,2,3,4,5,6,7,8,9,10].each do |n|
  if n%5==0
    puts "fizz"
  else
    puts n
  end
end
```

#### Locating the System Paste Command

시스템 붙여넣기 명령을 사용하려면 자신의 시스템에 맞는 단축키를 사용해야 한다. OS X는 시스템 붙여넣기를 `Cmd-v`로 실행할 수 있다. 터미널이나 MacVim에서 사용하면 시스템 클립보드의 내용을 삽입한다.

리눅스와 윈도에서는 그리 깔끔하지 않다. 시스템 붙여넣기의 표준 키는 보통 `Ctrl-v`이다. 일반 모드에서 비주얼-블록 모드로 전환하고, 입력 모드에서는 문자를 문자 그대로 추가하거나 숫자 코드로 입력한다.

Linux의 터미널 에뮬레이터 중에는 시스템 클립보드에서 붙여넣는 동작을 하도록 수정된 버전의 `Ctrl-v`를 지원하기도 한다. 그러나, 몰라도 걱정하지 말자. 이 팁의 마지막에 나오는 `"*` 레지스터를 사용하는 대안이 있다.

#### Using the System Paste Command in Insert Mode

입력 모드로 전환하고 시스템 붙여넣기 명령을 사용하면 이상한 결과가 나타난다. 들여쓰기가 잘못된다. 입력 모드에서 시스템 붙여넣기 명령을 사용하면, 각각의 문자를 손으로 직접 입력한 것처럼 처리된다. 'autoindent' 설정이 켜져 있으면 새 행을 시작할 때마다 이전 행과 동일한 계층의 들여쓰기로 열을 맞춘다. 그러나 클립보드에 있는 코드는 이미 들여쓰기가 있는 코드이기 때문에 자동 들여쓰기에 더해진다. 그래서 결과에서 매번 줄이 오른쪽으로 점점 더 쏠린다.

GVim은 클립 보드에서 텍스트를 붙여 넣을 때 구분할 수 있고 그에 따라 동작을 조정할 수 있지만 Vim이 터미널 내부에서 실행될 때이 정보는 사용할 수 없습니다.

GVim은 클립보드에서 텍스트을 붙여넣는 것을 식별하고 그에 따라 처리하지만, 터미널에서 실행되는 Vim은 이 정보를 사용할 수 없다. 'paste' 옵셔능로 Vim에게 시스템 붙여넣기를 사용한다고 수동으로 경고할 수 있다. 'paste' 옵션을 켜면 Vim은 모든 입력 단축키, 축약을 끄고, 'autoindent'을 포함한 붙여넣기 옵션들을 재설정한다.(:h 'paste'). 이것으로 놀라지 않고 안전하게 붙여넣을 수 있다.

시스템 붙여넣기 명령을 완료하면 'paste' 옵션을 다시 꺼야 한다. 일반 모드로 돌아와 Ex 명령 `:set paste!`를 실행해야 한다. 입력 모드에서 벗어나지 않고 이 옵션을 쉽게 전환하는 방법은 없을까?

'paste' 옵션이 활성 상태이면 입력 모드의 커스텀 단축키를 사용할 수 없다. 대신 'pastetoggle' 옵션에 키를 배정할 수 있다(:h 'pastetoggle').

```vim
:set pastetoggle=<f5>
```

명령행을 실행하면 `<f5>`으로 붙여넣기 옵션을 전환할 수 있다. 입력 모드와 일반 모드 모두에서 동작한다. 단축키가 유용하다고 생각하면 `vimrc`에 추가한다.

#### Avoid Toggling 'paste' by Putting from the Plus Register

시스템 클립보드가 통합된 Vim을 사용하고 있다면 'paste' 옵션을 사용하지 않을 수 있다. 일반 모드 `"+p` 명령은 시스템 클립보드를 반영하는 플러스 레지스터의 내용을 붙여넣는다. 이 명령은 클립보드에 있는 들여쓰기를 그대로 지키기 때문에 아무 문제없이 클립보드의 내용을 붙여넣을 수 있다. 'paste'와 'autoindent' 옵션을 고민할 필요가 없다.

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

그 대신에 `<Ctrl-r>/`로 검색 필드를 현재 패턴의 값으로 채울 수 있다. 검색 결과는 어느 쪽이든 같지만 명령 히스토리는 다르다.

```vim
:vim /<Ctrl-r>//g ##
```

`:vimgrep` 명령을 다시 사용하더라도 패턴이 명령 히스토리에 포함되어 있기 때문에 더 유용할 것이다.

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

<p style="display: none"><img src="https://c2.staticflickr.com/6/5572/30911777505_03e3ec069f_n.jpg" alt="Practical Vim cover"></p>


