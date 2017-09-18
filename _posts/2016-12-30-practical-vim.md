---
layout: post
title: "Practical Vim 팁 요약 시리즈 - Command-Line Mode and Range"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

![Vim 3D](/images/posts/vim.jpg)

1. 목차
{:toc}

- **프랙티컬 Vim 2판을 정리하는 페이지이며 내 편한대로 발췌하고 보충하기 때문에 원본을 반드시 참조하세요**.
- Vim은 다른 텍스트 에디터와 다르게 여러 모드를 가진다. Normal/Insert/Visual Mode의 세 가지가 주요 모드인데, 번역이 일관성이 없다. 대체로  Normal Mode는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **명령행**/ex/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

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

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


