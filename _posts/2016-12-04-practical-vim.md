---
layout: post
title: "Pratical Vim 팁 요약 시리즈 - Insert Mode"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

# Insert Mode

1. 목차
{:toc}

- **iBooks로 읽는 프랙티컬 Vim 2판을 정리하는 페이지이며 내편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

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

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


