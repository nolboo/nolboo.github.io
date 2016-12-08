
## Chapter 5. Command-Line Mode

### Tip 27. Meet Vim’s Command Line

명령행 모드는 Ex 명령, 검색 패턴, 표현식을 입력했을 때 활성화된다.
:을 누르면 명령행 모드로 전환된다. 이 모드는 셸 명령행과 사용하 는 방법이 비슷하다. 명령 이름을 입력한 후 <CR>을 눌러 실행한다. 이 명령행 모드에서 다시 일반 모드로 돌아가려면 <Esc>를 누른다.
명령행 모드에서 실행할 수 있는 명령을 Ex 명령
/를 눌러 검색 프롬프트(search prompt)를 불러오거나 <C-r>=로 표현식 레지스터에 접 근했을 때 활성화된다.

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

파일을 읽거나 쓸 때도 Ex 명령을 사용할 수 있으며(:edit와 :write), 탭 문자 를 생성하거나(:tabnew), 창을 분할할 때(:split), 또는 인자 목록을 이동하거나 (:prev/:next) 버퍼 목록을 이동하는 경우(:bprev/:bnext)에도 사용할 수 있다. Vim에서 사용할 수 있는 모든 명령이 Ex 명령으로도 제공된다(전체 목록은 :h ex-cmd-index 참고).

>
#### On the Etymology of Vim (and Family)
>

#### Special Keys in Vim’s Command-Line Mode

끼워넣기 모드에서 는 입력한 내용이 버퍼에 작성되지만 명령행 모드에서는 프롬프트에 나타난다. 두 모드에서 전부 <Ctrl>와 조합해서 호출 명령으로 사용할 수 있다.
끼워넣기 모드와 명령행 모드는 몇 가지 명령을 공유하고 있다. 예를 들어 <C-w>와 <C-u>는 끼워넣기 모드와 명령행 모드에서 모두 지원한다. <C-w>는 이 전 단어까지 <C-u>는 행의 시작까지 역방향으로 지우는 기능이다. <C-v>와 <C- k> 명령은 키보드에 없는 문자를 삽입할 때 사용하는 명령이다.
<C-r>{     } 명령으로 내용이 어떤 레지스터에 저장되었든 상관없이 명령행에서 입력할 수있다.명령행모드에서가능한명령중에는끼워넣기모드에서사용할수없는 명령도 몇 가지 있다.

명령행 프롬프트에서는 이동할 수 있는 영역이 다소 제한적이다. <left>와
<right> 방향키를 사용하면 각각 방향에 따라 한 글자씩 이동할 수 있다.
명령행프롬프 트대신에명령행창도제공한다.Vim의명령행창은프롬프트서쓸수있는명 령을조합해서활용할수있는창으로강력한편집기능을제공한다.

### Tip 28. Execute a Command on One or More Consecutive Lines

대부분의 Ex 명령은 [  ]를 지정해서 명령이 실행될 영역을 지정할 수 있다. 범위의 시작과 끝을 지정할 때는 행 번호, 마크(mark), 패턴을 이용할 수 있다.
Ex 명령의 강점 중 하나는 여러 범위의 행에서 동시에 실행할 수 있다는 점이 다.

`cmdline_mode/practical-vim.html`

:{start},{end}

{start}과 {end} 모두 주소에 해당한다. 행 번호를 주소로 사용 하긴 했지만 패턴이나 표시를 사용하는 것도 가능하다.
. 기호도 주소로 사용할 수 있다. 이 기호를 {범위}에서 사용하면 현재 커서가 놓인 행을 의미한다.

현재 커서가 있는 행부터 파일 마지막까지 범위를 다음과 같이 표시할 수 있다.

:2
:.,$p

`%` 기호도특별한의미를갖고있다.이기호는현재파일의모든행을뜻한다. `:%p` 명령은 `:1,$p` 와 결과가 동일하다.

이렇게 영역을 선택한 상태에서 :을 누르면 명령행 프롬프트에 :'<,'>라는 범위 가 미리 입력된 채로 나타난다. 이 기호가 암호처럼 보일지도 모르겠지만 방금 선택한비주얼선택의범위를의미한다.이선택범위기호뒤에, 선택한범위 의 각 행에서 실행할 Ex 명령을 입력할 수 있다.

:'<,'>p

'<와'> 표시는각각비주얼선택영역의첫행과마지막행을의미한다
이 표시는 비주얼 모드 (visual mode)를 벗어나도 사용할 수 있다. 일반 모드에서 :'<,'>p를 사용한다 면, 마지막 비주얼 모드에서 선택했던 영역을 기준으로 동작한다.

:/<html>/,/<\/html>/p

보기에 복잡하게 느껴질지도 모르지만, 꼼꼼하게 보면 다른 범위 형식과 마찬가 지로 `:{start},{end}`을 사용하고 있다. {  } 주소는 /<html>/ 패턴과 일치하는 행이고, {end} 주소는 /<\/html>/와 일치하는 행이다. <html> 태그가 열린 행부터 닫힌 행까지 해당한다.

:/<html>/+1,/<\/html>/-1p

오프셋을 넣은 형태는 일반적으로 다음과 같다.

:{address}+n

n이 입력되지 않으면 기본값으로 1이 적용된다. {address}는 행 번호, 표시, 패턴을 사용할 수 있다.

:2
:.,.+3p

.는 현재 행을 의미한다. 즉 여기에서  :.,.+3은 :2,5와 같은 역할을 한다.

| Symbol | Address                                                                     |
|--------|-----------------------------------------------------------------------------|
| 1      | First line of the file                                                      |
| $      | Last line of the file                                                       |
| 0      | Virtual line above first line of the file . Line where the cursor is placed |
| m      | Line containing mark m                                                      |
| <      | Start of visual selection                                                   |
| >      | End of visual selection                                                     |
| %      | The entire file (shorthand for :1,$)                                        |

문서에서 0번 행이 실제로 존재하지 않지만 주소를 지정할 때 맥락에 따라 유용 한 경우가 있다. 일반적으로 :copy {  }나 :move {  } 같은 명령을 사용할 때, 범위를 파일의 최상단으로 복사하거나 이동하기 위한 인자로 많이 사용한다.

[range]는 항상 연속하는 행을 표시한다. 하지만 :global 명령을 이용해 연속하 지 않는 행에서 Ex 명령을 실행하는 것도 가능하다.

### Tip 29. Duplicate or Move Lines Using `:t` and `:m` Commands

:copy 명령은문서한부분에서하나이상의행을다른위치에복제할때사용한 다(짧은 표기로 :t). :move는 하나 이상의 행을 다른 위치로 이동할 때 사용할 수 있다(짧은 표기로 :m).

#### Duplicate Lines with the ‘:t’ Command

`cmdline_mode/shopping-list.todo`

Shopping list
    Hardware Store
        Buy nails
        Buy new hammer
    Beauty Parlor
        Buy nail polish remover
        Buy nails

복사하기 명령의 양식은 다음과 같다(:h :copy 참고).

:[range]copy {address}

:copy 명령은 :co로 줄여 쓸 수 있다. 더 간결한 형태의 :t 명령도 제공한다.
이 명령은 어디론가 복사하기 위한 동작(copy TO)이라 생각하면 기억하기 쉽 다.

#### Move Lines with the ‘:m’ Command

:move 명령은 :copy 명령과 사용법이 유사하다(:h :move 참고).
:[range]move {address}
한 글자로 줄여서 :m으로 사용할 수 있다.
비주얼 모드에서 영역을 선택한 후에 :'<,'>m$ 명령을 사용하면 원하는 대로 행을이동할수있을것이다.물론이명령대신dGp 명령도사용할수있다.이 명령의 뜻을 풀어보면 d로 선택된 영역의 범위를 제거한 후에 G로 파일 끝으로 이동한 다음, p로 제거한 본문을 붙여넣는다는 의미다.

가장 마지막에 사용한 Ex 명령을 반 복하려면 간단하게 @:를 사용하면 된다

### Tip 30. Run Normal Mode Commands Across a Range

연속한 행을 대상으로 일반 모드 명령을 사용하려면 :normal 명령을 활용하 면 된다.

`cmdline_mode/foobar.js`에서 첫 줄에 `A;<Esc>`로 마지막에 `;`를 추가하였다. 나머지 줄에 모두 한번에 적용하려면 `jVG`로 나머지 줄을 선택한 후 `:'<,'>normal .` 명령으로 한 번에 적용할 수 있다.`:'<,'>normal .` 명령은 ‘비주얼 선택 영역의 각 행에 대해서 일반 모드 점 명령을 실행한다’로 읽을 수 있다. 이 기법은 행의 개수에 상관없이 사용할 수 있다. 이 방식의 진정한 아름다움은 각 행을 직접 셀 필요 없이 비주얼 모드에서 일괄적 으로 처리할 수 있다는 점이다.

위의 작업을 `:%normal A;` 한 번의 명령으로 처리할 수 있다. % 기호는 파일 전체 영역을 의미한다. 즉 :%normal A;을 사용하면 파일 전체 모 든행의끝에세미콜론을붙이라는명령을내릴수있다.이방식을사용하면자 동으로 끼워넣기 모드로 전환해서 작업을 처리한 다음에 다시 일반 모드로 돌아 오게 된다.
:normal은 지정한 일반 모드 명령을 각각 행에 실행하기 전에 커서를 행의 시 작점으로 옮긴다. 따라서 명령을 실행할 때, 커서의 위치를 신경 쓸 필요가 없 다. 아래 명령은 자바스크립트 파일 전체에 주석을 처리할 때 사용할 수 있다.

```vim
:%normal i//
```

### Tip 31. Repeat the Last Ex Command

점 명령은 가장 마지막에 실행한 일반 모드 명령을 반복하는 데 사용한다. 만약 마지막 Ex 명령을 반복하려고 한다면 @:을 사용할 수 있다(:h @:참고).
참고로 이 방법과 매크로를 실행하 는 방식은 둘 다 @ 기호를 사용한다는 점에서 유사한 면이 있다
: 레지스터는 항상 가장 마지 막에 실행했던 명령행에 위치하고 있다(:h quote_: 참고). @:을 사용해서 저장 된매크로를실행한다음에그매크로를반복하려면@@명령을사용할수있다.

### Tip 32. Tab-Complete Your Ex Commands

<C-d> 명령을 누르면 Vim에서 사용할 수 있는 자동완성 목록을 확인할 수 있다 (:h c_CTRL-D 참고).

```
:col<C-d>
colder colorscheme
```

만약 <Tab>을 눌렀다면 프롬프트는 키를 매번 누를 때마다 colder, colorscheme 그리고 원래의 col로 돌아오게 된다. <S-Tab>을 사용하면 추천 목록을 역순으로 보여준다.

:colorscheme <C-d>

<C-d> 명령을 누르면 사용 가능한 색상 조합이 추천 목록으로 전부 출력된다.

#### Choosing from Multiple Matches

배시 셸이 익숙하다면 `set wildmode=longest,list`, zsh가 익숙하다면:

```vim
set wildmenu
set wildmode=full
```

위 방식대로 'wildmenu' 설정을 켜면 커서를 이동해서 선택할 수 있는 형태의 추천 목록을 사용할 수 있다. 이 목록에서는 <Tab>, <C-n>, <Right>를 사용해 서 각각의 항목을 확인할 수 있다. 역방향으로 목록을 이동하려면 <S-Tab>, <C- p>, <Left>를 사용할 수 있다.

### Tip 33. Insert the Current Word at the Command Prompt

cmdline_mode/loop.js
var tally;
for (counter=1; tally <= 10; tally++) {
  // do something with tally
};

Vim의 명령행 모드는 <C-r><C-w> 명령으로 커서 밑에 있는 단어를 복사해서 명령행 프롬프트에 삽입하는 것이 가능하다. 이 기능을 사용하면 직접 내용을 입력하는 시간을 아낄 수 있다.

커서를 tally에 위치시킨 다음에 * 명령을 입력하면 다음에 있는 tally의 위치 로 커서가 이동한다. * 명령은 /\<<C-r><C-w>\><CR>을 직접 입력하는 것과 결 과가 동일하다.

이제 나머지 본문을 변경하는 작업은 :substitute 명령을 사용하자. 커서의 위치가 “counter”에 있기 때문에 이 내용을 다시 입력할 필요는 없다. 앞서 배웠 던 <C-r><C-w>를 이용해서 커서가 위치한 곳의 단어를 명령행 프롬프트로 바 로 입력할 수 있다.

:%s//<C-r><C-w>/g

<C-r><C-w>가 커서 밑에 있는 단어를 사용할 수 있게 하는데 대신 <C-r><C-a>로 WORD를 사용하는 것도 가능하다(:h c_CTRL-R_CTRL-W 참고).

<C-r><C-w> 명령은 vimrc 설정을 작성하는 경우에도 사용할 수 있다. vimrc 에서 알고 싶은 설정 위로 커서를 이동한 후에 :help<C-r><C-w>를 입력하면 그 설정을 위한 문서를 바로 확인할 수 있다.

### Tip 34. Recall Commands from History

Vim은 명령행 모드에서 사용한 모든 명령을 기록한다. 이 명령을 다시 호출하 는 방법은 두 가지가 있다. 명령행에서 방향키를 이용해 이전 명령을 다시 살펴 보고 호출하는 방법과 명령행 창을 이용해서 이전 명령을 다시 사용하는 방법 이다.

Vim의 기본 설정은 마지막 20개 명령만 히스토리로 저장한다.

set history=200

Vim은 저장한 Ex 명령의 히스토리를 검색 히스토리와는 별도로 구분해서 저 장한다. /를 누르면 검색 프롬프트가 나타나는데 이 프롬프트에서도 이전에 검 색했던 항목을 <Up>, <Down>으로 탐색할 수 있다. 이 검색 프롬프트까지도 모두 다른 형태의 명령행 모드에 해당한다.

#### Meet the Command-Line Window

간단한 루비 코드를 작성하고 있다고 생각해보자. 매번 내용을 수정할 때마다 다음 두 가지 명령을 계속 사용하고 있다.

:write
:!ruby %

:write | !ruby %

따지고 본다면 각각 명령은 이미 히스토리에 남아 있기 때문에 모든 명령을 직 접 하나하나 입력할 필요가 없다. 그렇다면 히스토리에 기록된 명령 레코드 두 항목을 어떻게 하나로 합쳐서 실행할까? 먼저 q:을 입력해서 명령행 창을 연다 (:h cmdwin 참고).

열린 명령행 창에서 지금까지 저장된 명령 히스토리를 전부 확인할 수 있다. 이 명령행 창은 일반 Vim 버퍼와 같이 동작한다. 다시 말해 일반적인 버퍼와 동 일하게 k, j를 사용해서 히스토리를 전후로 살펴볼 수 있다는 뜻이다. 일반 버퍼 처럼 Vim의 검색 기능을 사용해서 명령을 검색하는 것도 가능하다. 이 히스토리 목록에서 실행할 명령행에 커서를 위치한 다음에 <CR>을 누르면 현재 행에 있 는 Ex 명령을 실행한다.
명령행 창의 아름다움은 Vim의 모든 문서 편집 기능을 사용해서 이 명령 히 스토리를수정할수있다는점이다.일반모드에서사용했던모든모션을이명 령행창에서탐색할때활용할수있다.이창내에서비주얼모드를사용하거나 끼워넣기 모드로 전환할 수 있다. 심지어 명령행의 히스토리를 제공하는 명령행 창에서 Ex 명령을 사용하는 것도 가능하다.

명령행 모드에서는 <C-f>를 입력하는 것으로 명령행을 명령행 창으로 전환할 수 있다. 전환할 때는 프롬프트에서 미리 입력 했던 내용도 복사되어 창에 함께 나타난다.

| Command | Action                                                   |
|---------|----------------------------------------------------------|
| q/      | Open the command-line window with history of searches    |
| q:      | Open the command-line window with history of Ex commands |
| ctrl-f  | Switch from Command-Line mode to the command-line window |

### Tip 35. Run Commands in the Shell

Vim을 벗어나지 않고도 간단하게 외부 프로그램을 실행할 수 있다. 이 기능을 이용하면 버퍼에 있는 본문을 표준 입력으로 전송하거나 외부 명령을 실행해서 나오는 표준 출력을 버퍼에 출력할 수 있다.
터미널에서 Vim을 사용할 때 강력하게 활용할 수 있는 기능을 이 팁에서 살펴 보려고 한다. 만약 GVim(또는 MacVim)을 사용한다면 이 기능이 부드럽게 동 작하지 않을 가능성이 높다.
터미널에서 사용하는 Vim과 비 교했을 때 GVim이 더 나은 경우도 있지만 이 기능만큼은 터미널에서 구동하는 Vim에서 더 강력하다.

#### Executing Programs in the Shell

령행 모드에서 외부 프로그램을 실행하려면 셸에서 사용하는 명령 앞에 느낌 표를 붙여서 입력하면 된다(:h :! 참고).
:!ls
참고로 셸에서 명령을 입력하는 것처럼 :!ls 대신 :ls를 입력하면 셸에서 실행하 는 명령과 다르게 Vim에 내장된 명령이 실행된다. :ls는 버퍼에 열려있는 항목 목록을 보여준다.
Vim의 명령행에서 % 기호는 현재 파일명을 의미한다(:h cmdline-special 참 고). 외부 명령을 실행할 때나 현재 파일명을 전달해야 할 필요가 있을 때 이 기
호를 사용할 수 있다.
:!{cmd}
문법은 명령 하나만 실행하기에는 적합한 방법이다. 하지만 셸에서 여러 명령을 사용하고 싶은 경우에도 과연 그럴까? 명령이 여러 개일 경우에는 :shell 명령으로 인터렉티브 셸을 시작할 수 있다(:h :shell 참고). exit으로 돌아온다.

>
#### Putting Vim in the Background
>
Ctrl-z로 Vim 프로세스를 중지하고 쉘로 들어간다.
$jobs 로 확인할 수 있다.
fg 명령으로 일시 중지한 Vim을 그대로 되살린다.
위의 :shell과 exit보다 빠르고 쉽다.
>

#### Using the Contents of a Buffer for Standard Input or Output

:read !{cmd}이있다.이명령을사용하면 {cmd}의 결과를 현재 버퍼에 입력한다(:h :read! 참고).
:write !{cmd}은 반대로 동작한다. 이 명령을 사용하면 버퍼에 있는 내용을 표 준 입력으로 사용해서 {cmd}에 전달할 수 있다(:h :write_c를 참고).

:write !sh
:write ! sh
:write! sh

앞의두명령은버퍼에있는내용을표준입력으로외부sh 명령을실행한다.마 지막 :write!는 버퍼의 내용을 sh라는 파일에 작성하는 명령이다. 이 명령에서 느낌표는 이미 존재하는 파일이 있다면 그 내용을 덮어쓰라는 의미에서 사용했 다. 이 예제에서 보다시피 느낌표의 위치에 따라 극단적으로 다른 결과가 발생 한다. 그러므로 이런 종류의 명령과 느낌표 기호를 조합해서 사용할 때는 유의 해야 한다.

#### Filtering the Contents of a Buffer Through an External Command









---

옵셥키 영문 입력


