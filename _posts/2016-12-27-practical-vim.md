---
layout: post
title: "Practical Vim 팁 요약 시리즈 - Motion"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

![Vim 3D](/images/posts/vim.jpg)

1. 목차
{:toc}

- **프랙티컬 Vim 2판을 정리하는 페이지이며 내 편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

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


### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


