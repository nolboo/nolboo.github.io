---
layout: post
title: "Practical Vim 팁 요약 시리즈 - Normal Mode: Operator + Motion"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

1. 목차
{:toc}

- **iBooks로 읽는 프랙티컬 Vim 2판을 정리하는 페이지이며 내편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

# Operator + Motion

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

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


