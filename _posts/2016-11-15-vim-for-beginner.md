---
layout: post
title: "완전 초보를 위한 Vim"
description: "Vim을 처음 접하는 사용자가 어려움 없이 Vim을 사용할 수 있도록 GUI Vim을 위주로 설명하였다."
category: blog
tags: [vim, macvim, beginner]
---

[Vim](https://www.wikiwand.com/en/Vim_(text_editor))은 Emacs와 함께 어렵기로 소문난(?) 에디터이다. 얼마나 어려운지 나가는 것을 몰라서 2년간 계속 사용하고 있다는 풍자 트윗을 [@iamdevloper](https://twitter.com/iamdevloper)이 올리자 수천 명이 리트윗하기도 했다. 나도 처음 Vim을 무턱대고 실행하고선 나가질 못해서 터미널을 꺼버렸던 기억이 있다.ㅎ

![imdevloper tweet](http://i.imgur.com/VOe71EA.png)

아래 그림도 풍자이긴 하지만 꾸준히 회자하고 있는 주요 에디터 학습 곡선 그래프이다. Vim은 한가운데에 있다.

![editor learning curves](http://www.manuelmagic.me/resources/Geek/Text-editors/text_editors.jpg)

세상에! 뭔 그래프가 직각이냐!! 처음에 저 수준까지 배우지 않으면 하나도 이용하지 못한다는 얘기인가?

터미널을 꺼버린 지 몇 년이 지나고 Vim을 배우기 시작한 지 아직 두 달이 되지 않은 사람이 판단하기에 이를지는 모르나, Vim을 시작하는 것은 그렇게 어렵지 않다고 생각한다. 물론 고수가 되는 것은 어려울지 모르나, 이 글에서 설명하려고 하는 정도는 7시간이면 충분하고, 웬만한 상용 에디터 수준으로 사용하기까지는 한두 달이면 충분하다고 생각한다.(ㅎㅎ 감히^^)

>
- [Vim 학습 곡선은 순시리다!](https://robots.thoughtbot.com/the-vim-learning-curve-is-a-myth): 이 글에서는 기본 제공되는 Vimtutor로 30분이면 사용할 수 있다고 주장한다.

이런저런 텍스트 에디터를 경험해봤지만, Vim은 마냥 어렵다기보다는 설계가 잘된 텍스트 에디터이다. 특별한 점은 편집과 입력과 선택을 위한 모드가 별도로 있는 것이다. 흔히 복붙으로 대표되는 편집을 뛰어넘는 다양한 편집 명령이 준비되어 있는 훌륭한 오픈소스 에디터다.

그러나, 이 모드라는 개념이 Vim을 처음 접하는 사람을 어리둥절하게 만들기도 한다. Vim을 처음 실행하면 일반모드로 시작하기 때문에 Vim 명령을 모르는 사람은 대부분 에디터와 같이 텍스트 입력을 하려고 이것저것 누르다보면 텍스트 입력은 안 되고 모르는 명령이 입력되어 가끔 삑삑대는 행동을 하는 바람에 당황하게 된다.

>
Vim과 같이 특화된 모드를 가지는 에디터를 [Modal editor](https://wincent.com/wiki/modal_editor)라고 한다. 대부분 에디터는 non-modal(modeless)이며, 대표적인 것으로는 [GNU Emacs](https://www.gnu.org/software/emacs/)가 있다. 이 두 에디터는 수십 년 간 각 사용자가 [에디터 전쟁](https://www.wikiwand.com/en/Editor_war)을 벌이는 것도 유명하다.
>
명장은 도구를 가리지 않는다기보다는 것이 각 도구의 특성을 잘 파악하고 용도에 맞게 사용할 줄 아는 것으로 생각한다. 싸우지 마라. 특성을 파악해서 용도에 맞게 써라. - 개드립

## 닭치고 구이

모달 에디터인 Vim에 쉽게 접근하는 방법의 하나는 기본으로 제공되는 GUI용 Vim을 사용하는 것이다. 대표적인 것으로는 [gvim](http://www.vim.org/download.php#pc)이 있고, 맥용으로는 [MacVim](http://macvim-dev.github.io/macvim/)이 있다. 나는 맥 사용자이므로, 이 글에서는 MacVim을 위주로 설명한다.

MacVim의 GUI로 시작하면 터미널 모드에 비해 다른 GUI 에디터처럼 다음 항목을 누릴 수 있다:

- 맥에서 제공하는 기본적인 편집 단축키(Cmd+c/x/v와 같은 익숙한 단축키)와 시스템 클립보드 기능을 사용할 수 있다.
- 파인더에서 드래그앤드랍으로 파일을 열 수 있고, 여러 개의 파일을 끌어서 여러 탭으로 열 수도 있다.
- 마우스와 화살표 키를 사용할 수 있다.

Vim을 빨리 배우려면 화살표 키는 물론 마우스를 절대 사용하지 말라고 한다. GUI가 7.3버전부터 기본으로 제공되는 현재로썬 맞지 않는다고 생각한다. 모드 개념은 쉽게 익힐 수 있지만, 화살표 키와 마우스를 사용하던 습관은 쉽게 고쳐지지 않는다. 또한, 에디터 생산성과도 가장 밀접하므로 Vim 사용을 포기하게 되는 주요 요인이다. 포기하는 것보다는 차근차근 접근하면서 하나씩 익혀가며, Vim의 파워을 경험하는 것이 더 좋은 방법이라고 생각한다. 익숙해지면 마우스와 화살표 키는 자연히 멀어진다. 이런 견해를 제목에서 격하게 표현한 글도 있다:  [Everyone Who Tried to Convince Me to use Vim was Wrong](http://yehudakatz.com/2010/07/29/everyone-who-tried-to-convince-me-to-use-vim-was-wrong/)

## 설치

Vim이 최근에 버전 8으로 업그레이드되었다. [MacVim과 Vim 8 설치](https://nolboo.kim/blog/2016/09/16/vim-8-upgrade/)로 설치방법을 정리하였는데 다음 명령으로 설치할 수 있다.

```
brew install macvim --override-system-vim
brew linkapps
```

두 번째 명령은 `Applicccations` 폴더에 설치된 MacVim의 심볼릭 링크를 만들어준다. 이제 다른 맥 앱처럼 Spotlight나 알프레드에서 MacVim을 실행하면 GUI 버전이 실행된다.

## 세 가지 주요 모드와 커서 이동키

모달 에디터인 Vim은 여러 모드를 가진다. Normal, Insert, Visual Mode의 세 가지가 주요 모드이다.

>
안타깝게도 이런 모드를 구분하는 이름의 번역에 일관성이 없다. 대체로  Normal Mode(Command Mode)는 **일반**/명령 모드, Insert Mode는 **입력**/편집 모드, Visual Mode는 **비주얼**/선택 모드, 일반 모드에서 `:`로 진입하는 모드는 **ex**/명령어 모드 등으로 번역되는데, 이 글에서는 앞의 굵은 글씨의 모드로 사용한다.

이제 Vim을 처음 실행하면 일반 모드(Normal Mode)이다. 여기서 (_i_nsert의 준말인) `i` 키를 누른 후에야 여러분이 경험한 대부분 에디터의 텍스트 입력 상태인 입력 모드(Insert Mode)가 된다. `Esc` 키를 누르면 다시 일반 모드로 돌아간다. (_v_isual의 준말인) `v`를 누르면 비주얼 모드(Visual Mode)가 된다. 화면의 제일 밑줄에 `-- INSERT --`, `-- VISUAL --`로 현재 모드를 알려준다.

다시 `Esc`를 눌러 일반 모드인 상태에서 `:`를 누르면 ex Mode로 들어간다. 모드 상태를 보여주던 제일 밑줄에서 `:` 다음에 커서가 놓이면서 명령어를 기다리는 것을 볼 수 있다. 그래서, ex Mode는 명령어 모드라고도 한다. 단어(또는 축약어)로 된 명령어를 사용하여 거의 모든 환경설정과 Vim 액션 명령, 파일 열기/저장과 종료, 탭/버퍼 관련 명령, 심지어 외부 쉘 명령 실행과 터미널에서의 오토메이션까지 실행할 수 있다. (조금 복잡하게 느낄 수 있으나 그만큼 중요한 모드라고 생각하고 사용하면서 하나씩 배우면 된다.)

주요 모드와 모드 전환 키와 함께 그림으로 간단히 표현하면:

![Vim 모드](https://c7.staticflickr.com/6/5513/30834600622_2e9a75538d_c.jpg)

처음에는 입력 모드는 `i`, 비주얼 모드는 `v`만을 기억해도 된다. 나머지 키들은 사용하면서 조금씩 익히면 된다. 일반 모드로 돌아가려면 `Esc`만 누르면 된다. 그래서 Vim에서는 `Esc`를 자주 사용하게 된다. 그러나 최근의 출시되는 키보드는 `Esc`가 너무 멀리 있다. Vim의 선조 격인 vi 에디터가 무려 1976년에 출시된 [ADM-3A](https://www.wikiwand.com/en/ADM-3A)에 처음 탑재되었기 때문이다. 이 기종의 키보드는 59 키이며, 다음과 같이 생겼다.

![ADM-3A 키보드](https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/KB_Terminal_ADM3A.svg/1024px-KB_Terminal_ADM3A.svg.png)

`Esc`가 지금의 `Tab` 위치에 있다. 화살표 키도 `H`, `J`, `K`, `L`에 추가로 할당하고 있다. 그래서 `vi`의 일반 모드 전환 키는 - 지금은 멀게만 느껴지는 - `Esc`가 되었고, 화살표키는 - 지금 봐서는 도무지 이해할 수 없는 -  `h`, `j`, `k`, `l`이 되었다. _유래를 알면 조금 덜 억울하다;;_

![hjkl](https://c7.staticflickr.com/9/8138/29831678110_39867512ab_n.jpg)

`j` 키가 아래 화살표와 비슷하게 생긴 것을 힌트 삼아 외우라고 한다;; 한글을 아는 우리는 `ㄱㄴ`으로 외우는 것이 더 낫다고 생각하여 위와 같이 그려봤다. (평가는 반사한다^^) 외우기 힘들거나 익숙지 않으면 화살표 키를 써도 된다. 마우스와 터치패드를 사용해도 된다. `hjkl`과 달리 화살표 키와 마우스 모두 입력 모드에서도 사용할 수 있고, 화면상의 어떤 위치에도 커서를 한 번에 갔다 놓을 수도 있다. 게다가 맥북의 터치패드는 키보드 바로 밑에 붙어 키 입력과의 단절도 거의 없다.

## 최소의 명령어

이제 2년간 계속 켜놓는 일은 없게 편집한 내용을 저장하고 나가는 방법을 배우자.

### 저장과 종료

`:`로 시작하는 ex 모드에서 `write`(`w`)를 입력하면 저장한다. 새로운 파일이라면 `:w 파일명`과 같이 파일명을 지정해야 한다. 물론 MacVim GUI이므로, `Cmd+s`로 저장할 수도 있다. MacVim을 종료하려면 일반 맥앱처럼 `Cmd+q`로 종료한다. ex 모드 명령어는 `:quit`(`:q`)를 입력하면 된다. 두 개의 명령을 조합하여 `:wq`를 입력하면 저장한 후에 종료한다. 저장하지 않고 종료하려면 `:q!`와 같이 `!`를 덧붙여준다. `:w!`는 파일을 덮어쓴다.

### 파일 열기와 탭

편집하고 싶은 파일을 열려면 `:edit 파일명`으로 열 수 있다. `:tabnew 파일명`으로 새 탭에서 파일을 열 수 있다.

여러 개의 파일을 한꺼번에 열고 싶다면 터미널에서 다음 명령을 입력해야 한다.

```shell
$ mvim 파일명1 파일명2 파일명3
```

`:n`으로 열린 파일을 하나씩 보거나 편집할 수 있다.

파일을 탭으로 열고 싶다면 `-p` 옵션을 붙이면 된다. 제일 윗줄에 탭이 나타난다. 물론 아래 글과 같이 Vim의 탭은 조금 다르지만, 처음엔 그냥 쓰자. 파일명을 마우스로 클릭하여 선택할 수도 있고, `:tabnext`나 `:tabn`으로 탭을 변경할 수 있다.

- [Vim의 탭은 그렇게 쓰는 게 아니다. 버퍼와 탭의 사용법](http://bakyeono.net/post/2015-08-13-vim-tab-madness-translate.html)

### 외부 쉘 명령

외부 쉘 명령을 ex 모드에서 실행할 수도 있다. `:! ls`나 `:! pwd`를 입력하여 맛만 보자.

**이제 기본적으로 쓸 수 있다. 기본 텍스트 에디터처럼 사용해보면서 Vim이 조금 익숙해진 후에 다른 내용을 보는 것도 좋다**.

추가로 키 변환을 위한 Karabiner-Elements와 한글 치트시트, 그리고 도움이 될만한 링크를 소개한다.

## 구름 입력기와 주요 키 변경

사용하다 보면 입력 모드에서 한글을 입력하다가 일반모드 명령을 입력할 때 한영전환이 거슬린다. 이것은 구름 입력기를 사용하면 쉽게 해결된다. 더 자세한 사항은 [Vim에서 한글 입출력](https://nolboo.kim/blog/2016/11/07/vim-korean/)을 참조한다.

`Esc`의 키의 위치가 거슬리는 상황이 올 수도 있다. 그래서 탭과 `Esc`를 치환하는 방법을 찾게 되는데 [Karabiner-Elements](https://github.com/tekezo/Karabiner-Elements)로 해결할 수 있다.

![Karabiner-Elements 설정](https://c1.staticflickr.com/6/5443/22818267928_54e5d6e3f6_z.jpg)

`Tab` 키를 `Esc`와 서로 바꾸고 몇 가지 키를 자신의 환경에 맞게 변경한다.

- `Esc`는 `Ctrl-C`나 `Ctrl-[`로 대체할 수 있으나 구름 입력기의 편리한 기능은 사용할 수 없다.
- `Tab`은 `Ctrl-i`로 대체할 수 있다.

## 기본 치트시트

![Vim 이동 치트시트](http://cfile8.uf.tistory.com/image/141F57474F4732890DE706)

Vim에는 이동과 관련된 명령이 많이 준비되어 있다. 만약 위의 내용을 전부 익히고 [텍스트 개체](https://nolboo.kim/blog/2016/10/13/vim-text-objects-definitive-guide/)를 이해하고 사용하게 되면 Vim의 매력에 푹 빠질 수 있다.

![Vim_명령어_단축키](http://i0.wp.com/www.insightbook.co.kr/wp-content/uploads/2012/04/Vim_%EB%AA%85%EB%A0%B9%EC%96%B4_%EB%8B%A8%EC%B6%95%ED%82%A4.jpg?zoom=2&resize=614%2C450)

키보드에 매핑한 것을 [인사이트](http://www.insightbook.co.kr/%eb%8f%84%ec%84%9c-%eb%aa%a9%eb%a1%9d/programming-insight/%ec%86%90%ec%97%90-%ec%9e%a1%ed%9e%88%eb%8a%94-vim)에서 번역하고 이쁘게 만든 것이다. Vim에 대한 유일한 한글책에 대한 유명 IT 블로거들의 후기는 [1](https://blog.outsider.ne.kr/631), [2](http://1004lucifer.blogspot.kr/2015/04/vim.html), [3](http://devnote.tistory.com/237), [4](http://ohyecloudy.com/pnotes/archives/997/)에 있다. 인사이트와 아무런 관계가 없다. 치트시트를 설명하려다 구글 검색에서 후기를 검색했는데 상위에 전부 유명 블로거들이 나와서^^

- [Vim Cheat Sheet - 한국어](http://vim.rtorr.com/lang/ko/): 치트시트의 내용이 많아서 키보드에 매핑한 것보다 이렇게 텍스트로 된 것에서 검색하는 것을 선호한다.

## 추가 링크

- [Interactive Vim tutorial](http://www.openvim.com/tutorial.html): 30분이면 끝낼 수 있다.
- [Vim Tutorial](https://linuxconfig.org/vim-tutorial)
- [How to Learn Vim - The Best Tutorials for Vim Beginners](http://www.labnol.org/internet/learning-vim-for-beginners/28820/): 가이드 라인 소개
- [Getting Started with Vim](https://www.sitepoint.com/getting-started-vim/)
- [Vim에 대해 점진적으로 학습하기](http://www.mimul.com/pebble/default/2014/07/15/1405420918073.html)
- [VIM Adventures](http://vim-adventures.com/): 게임으로 배우는 Vim
- [Vimdoc : the online source for Vim documentation](http://vimdoc.sourceforge.net/)
- [Why Vim?](http://jaywon.org/why-vim/)

