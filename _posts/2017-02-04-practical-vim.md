---
layout: post
title: "Practical Vim 팁 요약 시리즈 - find and netrw"
description: "Vim 전문가는 어떻게 생각하는지를 팁 중심으로 설명하는 책 Practical Vim 2판을 요약하는 시리즈"
category: blog
tags: [practical, vim, tip, beginner, advance]
---

![Vim 3D](/images/posts/vim.jpg)

1. 목차
{:toc}

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

### 시리즈 포스트를 한 장의 페이지로도 정리합니다.

* [Practical Vim 2판 정리 페이지](https://nolboo.kim/practical-vim/)


