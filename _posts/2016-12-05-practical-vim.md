---
layout: post
title: "Pratical Vim 팁 요약 시리즈 - Visual Mode"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

# Visual Mode

1. 목차
{:toc}

- **iBooks로 읽는 프랙티컬 Vim 2판을 정리하는 페이지이며 내편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

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

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


