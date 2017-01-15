---
layout: post
title: "Practical Vim 팁 요약 시리즈 - Jumps and Marks"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

![Vim 3D](/images/posts/vim.jpg)

1. 목차
{:toc}

- **프랙티컬 Vim 2판을 정리하는 페이지이며 내 편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

## CHAPTER 9.Navigate Between Files with Jumps

점프(jump)는 모션과 비슷하지만 다른 파일 사이를 이동할 수 있다.

### Tip 56. Traverse the Jump List

Vim은 점프할 때 이동 전과 후의 위치를 모두 저장하고, 그 발자취를 알 수 있는 명령을 제공한다.

웹 브라우저에서는 뒤로 버튼으로 이전에 방문했던 페이지로 이동할 수 있다. Vim은 비슷한 기능을 하는 점프 목록(jump list)이 있다. `<C-o>` 명령이 뒤로 버튼과 같으며 `<C-i>` 명령은 앞으로 버튼과 같다. 이 명령으로 점프 목록을 오갈수 있다.

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

현재 창에서 파일을 변경하는 명령은 모두 점프 명령이라고 말할 수 있다. Vim은 점프 명령을 실행하 기 전과 후의 위치를 점프 목록에 기록한다. `:edit` 명령으로 새 파일을 열었다면 두 파일을 `<C-o>`와 `<C-i>` 명령으로 오갈 수 있다.

`[count]G`로 특정 행으로 바로 이동하는 것은 점프이지만 한 행씩 이동하는 것은 점프가 아니다. 문장 단위 및 단락 단위의 모션은 점프이지만 문자와 단어의 모션은 점프가 아니다. 일반적으로 장거리 모션은 점프로 분류될 수 있지만 단거리 모션은 그냥 모션이다.

점프로 처리되는 명령을 정리한다:

| Command                       | Effect                                         |
|-------------------------------|------------------------------------------------|
| [count]G                      | Jump to line number                            |
| /pattern<CR>/?pattern<CR>/n/N | Jump to next/previous occurrence of pattern    |
| %                             | Jump to matching parenthesis                   |
| ( / )                         | Jump to start of previous/next sentence        |
| { / }                         | Jump to start of previous/next paragraph       |
| H / M / L                     | Jump to top/middle/bottom of screen            |
| gf                            | Jump to file name under the cursor             |
| <C-]>                         | Jump to definition of keyword under the cursor |
| '{mark} / `{mark}             | Jump to a mark                                 |

`<C-o>`와 `<C-i>` 명령 자체는 모션으로 처리되지 않는다. 비주얼 모드에서 선택 영역을 확장하거나 동작-대기 모드에서 이 명령을 사용할 수 없다는 뜻이다.

Vim은 여러 점프 목록을 동시에 관리 한다. 실은 각 창마다 각 점프 목록이 있다. 창 분할이나 다중 탭 페이지를 사용하고 있다면 `<C-o>`와 `<C-i>` 명령은 항상 활성 창의 점프 목록을 따라 이동한다.

>
#### Beware of Mapping the Tab Key
>
입력 모드에서 `<C-i>`는 `<Tab>`을 입력하는 것과 같다. Vim이 `<C-i>`와 `<Tab>`을 같은 것으로 보기 때문이다.
>
`<Tab>` 키의 매핑을 변경하면, `<C-i>`를 누를 때도 변경된 매핑을 실행한다.(반대도 마찬가지다) 그러므로 `<Tab>`을 다른  기능으로 변경할 때는 점프 목록을 이동하는 `<C-i>`를 포기할 만큼 중요한지 고려해야 한다. 한 방향으로만 이동하는 것은 그다지 유용하지 않기 때문이다.
>

### Tip 57. Traverse the Change List

작업을 취소하는 명령과 취소한 작업을 다시 되돌리는 명령을 실행하면 최근에 변경한 위치로 이동하는 부차적인 효과도 생긴다. 실행 취소 명령은 최근 변경 위치로 돌아가고 싶은 경우에도 유용하다. `u<C-r>`은 일종의 해킹이다.

Vim은 편집 세션 중에 각 버퍼에 대한 수정 목록을 관리한다. 이 것을 변경 목록(change list)이라고 한다.(:h changelist) `:changes` 명령으로 내용을 볼 수 있다.

`g;`와 `g,` 명령으로 변경 목록에서 앞 뒤로 이동할 수 있다. `;`와 `,` 명령이 `f{char}` 명령을 반복하거나 역반복할 수 있다는 것을 생각하면 기억하기 쉬울 것이다.

문서에서 최근 변경으로 되돌아 가려면 `g;`를 입력한다. `u<C-r>`을 입력해도 결과는 같지만, 문서에 일시적인 변경을 만든다.

#### Marks for the Last Change

Vim은 변경 목록을 보완하기 위해서 마크를 자동으로 생성한다. `` `. `` 마크는 항상 마지막 변경의 위치를 참조한다.(:h `` `. ``) `` `^ `` 마크는 입력 모드를 종료한 마지막 위치를 기록한다.

대부분의 시나리오에서 `` `. `` 마크로 이동하면 `g;` 명령과 효과가 같다. 하지만 `` `. `` 마크가 마지막 변화의 위치만을 저장하는 것과 달리 변경 목록은 여러 위치를 저장한다. `g;`를 반복 입력할 때마다 변경 목록에 저장된 위치를 순서대로 이동할 수 있다. 반면 `` `. ``는 변경 목록에서 가장 마지막 위치로만 이동한다.

`` `^ `` 마크는 마지막 _변경_ 과는 살짝 다른, 마지막 _입력_ 위치를 참조한다. 입력 모드를 벗어나서 문서를 스크롤한 후 `gi`를 입력하여 벗어난 곳으로 빠르게 갈 수 있다. `` `^ ``는 한 번의 움직임으로 커서 위치를 복원하고 입력 모드로 전환한다.

Vim은 변경 목록을 버퍼를 기준으로 관리한다. 대조적으로, 점프 목록은 창을 기준으로 만든다.

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


