---
layout: post
title: "모든 앱에서 Vim을 사용하는 법 - QuickCursorKM과 vim-anywhere"
description: "모든 맥앱에서 Vim을 사용하는 방법을 키보드 마에스트로 매크로와 스크립트 두 가지 방법을 소개한다"
category: blog
tags: [vi, vim, tip]
---

![Vim 3D](/images/posts/vim.jpg)


Vim에 익숙해진다는 것은 먼저 Vim의 키바인딩에 익숙해지는 것이다. 이 때부터 다른 텍스트 에디터의 키 바인딩을 옵션에서 Vim 키 바인딩으로 바꾸고, 옵션으로 제공하지 않는 에디터는 플러그인을 찾아서라도 키 바인딩을 바꾼게 된다. 더 나아가 웹브라우저는 물론 다른 모든 앱에서 Vim 키 바인딩을 사용하고 싶은 욕구가 넘치게 된다(적어도 필자는).

## 키보드 마에스트로 매크로 QuickCursorKM

거의 모든 앱에서 Vim을 사용하는 방법으로 이제까지 사용하고 있는 것은 키보드 마에스트로에서 [keyboard-maestro-quickcursorkm](https://github.com/chauncey-garrett/keyboard-maestro-quickcursorkm)를 사용하는 것이다.

매크로 저자가 여러 에디터를 선호하는지 꽤 많은 에디터를 선택할 수 있지만, Vim을 가장 많이 사용하는 필자는 Vim만의 단축키를 별도로 지정해서 사용하고 있다.

단축키를 누르면 현재 앱의 에디터에서 모든 텍스트를 선택해서 `.quickcursor_km.txt`에 저장하고 MacVim을 불러온다. 텍스트를 편집한 후에 MacVim을 종료하면 이전 앱의 에디터로 전체 텍스트를 붙여넣는다.

물론 앱의 에디터에서 일부 선택해서 그 부분만 편집할 수도 있다.

### 단점

- MacVim을 종료해야 매크로의 나머지 부분이 제대로 동작한다.
- 원래 에디터가 MacVim의 이전 앱이어야 한다. 다른 앱으로 전환한 적이 있다면 다시 편집하던 앱으로 전환한 후 MacVim으로 다시 돌아가 종료해야 한다.

## vim-anywhere

나랑 같은 Vim 중독 증후군(?)이 있는 사람이 스크립트를 이용하는 [vim-anywhere](https://github.com/cknadler/vim-anywhere)를 만들어서 공개한 것을 발견하였다.

동작하는 방식은 QuickCursorKM보다 간결하다. 지정한 단축키로 호출하면 임시 버퍼를 열고, 창을 닫으면 편집하던 버퍼의 내용을 클립 보드에 복사하고 이전 앱으로 다시 돌아간다. 편집한 텍스트를 붙여넣으면 끝! 간결해서 오히려 QuickCursorKM의 단점을 확실히 커버한다.

리눅스에서도 사용

### 설치

MacVim을 설치해야 한다.

```shell
brew install macvim
curl -fsSL https://raw.github.com/cknadler/vim-anywhere/master/install | bash
```

OSX에서 vim-anywhere를 호출하는 키보드 단축키는 스크립트로 지정할 수 없다. 단, 설치 스크립트가 자동으로 시스템 환경설정>키보드>단축키를 연다.

![키보드 단축키](https://raw.githubusercontent.com/cknadler/vim-anywhere/master/assets/shortcut.png)

`일반>VimAnyWhere>단축키 추가` 버튼을 클릭한 후 원하는 단축키를 지정한다. `Cmd+Ctrl+V`를 권장하고 있다.

참고로 업데이트는,

```shell
~/.vim-anywhere/update
```

삭제는,

```shell
~/.vim-anywhere/uninstall
```

시스템을 종료하기 전까지 제공하는 임시 history를 보고 싶다면,

```shell
ls /tmp/vim-anywhere
```

최근에 편집하뎐 파일을 다시 열려면,

```shell
vim $( ls /tmp/vim-anywhere | sort -r | head -n 1 )
```

즐빔!

