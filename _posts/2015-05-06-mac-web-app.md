---
layout: post
title: "주로 사용하는 맥앱과 웹앱"
description: "현재 주로 사용하거나 관심있는 맥앱과 웹앱을 정리하였다"
category: blog
tags: [macapp, webapp]
---

현재 주로 사용하고 있는 맥앱과 웹앱을 한 곳에 정리한다. 관심은 있으나 아직 많이 사용하지 않은 앱도 포함하였으며, 지속적으로 업데이트하면서 관리할 예정이다.

여러 앱과 환경설정을 자동화하는 방법은 이 [포스트](http://nolboo.github.io/blog/2015/05/07/mac-setup/)에 별도로 정리하였다.

## [Sublime Text 3](http://www.sublimetext.com/3)

- [패키지 컨트롤 설치](https://sublime.wbond.net/installation)
- 터미널에서 `subl .` 등으로 편하게 사용하기 위해 단축키를 지정한다. 상세 참조 : [subl 터미널 명령어 설정](http://blog.outsider.ne.kr/867)

<pre class="terminal">
ln -s "/Applications/Sublime Text.app/Contents/SharedSupport/bin/subl" /usr/local/bin/subl
</pre>

mackup으로 환경설정을 복원했다면 이 때 아래 패키지들이 한꺼번에 설치되는 것을 경험할 수 있다. Mackup에 관해서는 [맥 설치와 환경 설정을 최대한 자동화하기](http://nolboo.github.io/blog/2015/05/07/mac-setup/)에서 설명하였다.

### Markdown 패키지

서브라임에서의 자세한 방법을 알고 싶은 분은 [놀부의 마크다운 사용법 - 무료 툴을 중심으로 한 워크플로우](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/)를 참조하기 바란다.

- [MarkdownEditing](https://github.com/SublimeText-Markdown/MarkdownEditing)
- [OmniMarkupPreviewer](https://github.com/timonwong/OmniMarkupPreviewer)
- [Open URL](https://github.com/noahcoad/open-url)
- [Table Editor](https://github.com/vkocubinsky/SublimeTableEditor)

### 웹 디자인 패키지

- [ColorHighlighter](https://github.com/Monnoroch/ColorHighlighter)
- [BracketHighlighter](https://sublime.wbond.net/packages/BracketHighlighter)
- [Emmet](https://sublime.wbond.net/packages/Emmet)
- [Emmet Css Snippets](https://sublime.wbond.net/packages/Emmet%20Css%20Snippets)
- [LiveReload](https://sublime.wbond.net/packages/LiveReload)
- [SCSS](https://sublime.wbond.net/packages/SCSS)
- [TrailingSpaces](https://sublime.wbond.net/packages/TrailingSpaces)

### Git 패키지

- [GitHub](https://github.com/bgreenlee/sublime-github)
- [Gist](https://sublime.wbond.net/packages/Gist)

### 참고할만한 글

- [A Designer’s Sublime Text Setup — Design Notes — Medium](https://medium.com/design-notes/a-designers-sublime-text-setup-e3963f8d79da)
- [My Sublime Text 3 Development Setup](http://josephralph.co.uk/my-sublime-text-3-development-setup/)
- [The Zen of Sublime Text Configuration](http://proletariat.com/2014/12/02/zen-sublime-text-configuration/)
- [Sublime Text](http://likejazz.com/post/102824813705/sublime-text)
- [EditorConfig](http://editorconfig.org/)

## 개발관련 맥앱

- [Dash - API Docs & Snippets](https://itunes.apple.com/us/app/dash/id458034879?ls=1&mt=12)
- [RubyMine](https://www.jetbrains.com/ruby/)
- [WebStorm](http://www.jetbrains.com/webstorm/)
- [Download Python](https://www.python.org/download)
- [SourceTree](https://www.sourcetreeapp.com/)
    - [GitHub for Mac](https://mac.github.com/)
- [Anvil for Mac - Run your sites locally](http://anvilformac.com/) 
- [Pow: Zero-configuration Rack server for Mac OS X](http://pow.cx/)를 GUI로 간단하게 사용할 수 있도록 루트디렉토리.dev 
    - locally 설치 : `npm install -g locally`
    - [xip.io: wildcard DNS for everyone](http://xip.io/)를 http://amoeba.192.168.0.6.xip.io/
    - 터미널에서 간단히 웹서버 띄우는 방법 2가지
        - python -m SimpleHTTPServer 8000
        - ruby -run -e httpd . -p 8000

- [Sip](http://macnews.tistory.com/2018) : 화면에서 색상 코드를 추출할 수 있는 인기 맥용 컬러피커 프로그램. 
    - 기본적인 컬러피커 패널에 [Developer Color Picker](http://download.panic.com/picker/)도 추가해놓는다. 다운로드한 후에 `~/Library/ColorPickers`로 앱을 이동한다. 디렉토리가 없으면 만든다.
- [ImageOptim — better Save For Web](https://imageoptim.com/)
- [Pingendo](http://www.pingendo.com/): 부트스트랩 프로토타이핑

## 맥앱

- [SmoothMouse](http://smoothmouse.com/)
- [AppCleaner](http://www.freemacsoft.net/appcleaner/)
- [Alfred](http://www.alfredapp.com/)
- [nosleep](https://code.google.com/p/macosx-nosleep-extension/)
- [Day-O](http://www.shauninman.com/archive/2011/10/20/day_o_mac_menu_bar_clock) : 기본 날자 아이콘을 숨기고 날짜 형식을 `h:mm`으로 설정하여 보여준다.
- [Bartender](http://www.macbartender.com/) : 메뉴바 정리 앱
- [HyperSwitch](http://bahoom.com/hyperswitch/): [OS X 앱 전환 방식의 불편함을 완벽히 보완해주는 HyperSwitch](http://macnews.tistory.com/1022)
- [Turbo Boost Switcher](http://www.rugarciap.com/turbo-boost-switcher-for-os-x/): [CPU 터보 부스트를 강제로 비활성화 시켜 맥북 배터리 더 오래 사용하기](http://macnews.tistory.com/3393) 
- [OptOpt](https://itunes.apple.com/app/optopt/id989799277?mt=12): [프로그램마다 단축키를 지정할 수 있는 응용 프로그램 전환기](http://macnews.tistory.com/3330)
- [Anki](http://ankisrs.net/): 플래시 카드
- [Noizio](https://itunes.apple.com/kr/app/noizio/id928871589?mt=12): [[추천 무료앱] 이제 소음도 섞어서 듣자? 상황에 따른 8가지 소리를 자유롭게 조합할 수 있는 집중력 향상 앱 'Noizio'](http://macnews.tistory.com/2703)
- [Commander One - free dual-pane file manager](https://itunes.apple.com/kr/app/commander-one-free-dual-pane/id1035236694?mt=12)

- [GIMP](http://www.gimp.org/downloads/)
- [리디북스](http://ridibooks.com/support/app/download): 전자책 뷰어
- [VLC media player](http://www.videolan.org/vlc/download-macosx.html)
- [곰플레이어](http://gom2.gomtv.com/release/gom_player_mac.htm)
- [Scrivener](https://www.literatureandlatte.com/download_mac.php): [Scrivener 튜토리얼 가이드 한글번역본](http://macnews.tistory.com/2494)

### 앱스토어

#### 유료

- [Boom](https://itunes.apple.com/us/app/boom-experience-best-audio/id415312377?mt=12): 맥프레를 홈시어터로 바꿔주는 사운드 향상 앱
- [Kuvva wallpapers](https://itunes.apple.com/app/id451557061?mt=12)
- [Window Tidy](https://itunes.apple.com/kr/app/window-tidy/id456609775?mt=12)
- [Bartender](http://www.macbartender.com/)
- [PomodoroApp](https://itunes.apple.com/kr/app/pomodoroapp-simple-pomodoro/id705103149?mt=12)
- [Copy'em Paste](https://itunes.apple.com/us/app/fun-math-games/id876540291?mt=12)
- [TextExpander 4](http://smilesoftware.com/TextExpander)
- [AutoKeyboard](https://itunes.apple.com/kr/app/autokeyboard/id908553210?mt=12): [응용 프로그램을 전환할 때 입력기를 자동으로 전환해주는 편리한 유틸리티](http://macnews.tistory.com/2606)
- [Total Manager](https://itunes.apple.com/app/id796275163?mt=12)
- [Scapple](https://itunes.apple.com/kr/app/scapple/id568020055?mt=12) 
    - [Scapple 사용기(1) - Scapple의 특징, 구매, 설치까지](http://reinia.net/916)
- [iThoughtsX | toketaWare](http://toketaware.com/)
- [Fantastical](https://flexibits.com/fantastical)
    - [[추천 무료앱] OS X 메뉴 막대에 깔끔한 달력을 달아 드립니다 'Itsycal'](http://macnews.tistory.com/3023)
    - [1년치 일정을 한눈에 살펴보고 관리할 수 있는 'popCalendar'](http://macnews.tistory.com/2480)

- [PopClip](https://itunes.apple.com/us/app/popclip/id445189367?mt=12)

bitly, Todoist, Dash, Pocket 확장 등을 설치하고, 단디 한글 맞춤법 검사기 확장은 [숩님이 제작하신 것](http://soooprmx.com/wp/archives/3863)을 자주 사용했지만, 최근엔 [미남이님이 제작하신 것](https://twitter.com/seoulrain/statuses/541397266066440193)을 주로 사용한다.(두 분 모두 고맙습니다!)

- [무비스트](https://itunes.apple.com/kr/app/mubiseuteu/id461788075?mt=12)
- [DaisyDisk](https://itunes.apple.com/app/daisydisk/id411643860?mt=12&ign-mpt=uo%3D4): 하드디스크 분석과 삭제, 뛰어난 그래픽으로 한눈에 디스크를 정리할 수 있다.
- [Day One](https://itunes.apple.com/kr/app/day-one-ilgi-daieoli/id422304217?mt=12): 일기 다이어리 작성
- [Ulysses](https://itunes.apple.com/kr/app/id623795237?mt=12): 마크다운 에디터앱
- [Airmail](https://itunes.apple.com/app/airmail/id573171375?mt=12)

#### 무료

- [f.lux](https://justgetflux.com/): 자동 화면 밝기 조절
- [Todoist](https://todoist.com/macApp): 최고의 무료 맥 할일 목록 및 작업 목록 관리 앱
- [Telegram Desktop](https://desktop.telegram.org/): 최고의 메시징 앱
- [mysms](https://itunes.apple.com/en/app/id545578261): SMS 문자 보내기와 동기화
- [Janetter for Twitter](https://itunes.apple.com/us/app/janetter-for-twitter/id478844335?ls=1&mt=12)
- [Monosnap](https://www.monosnap.com/welcome) : Free Screenshot Tool
- [Simplenote](https://itunes.apple.com/us/app/simplenote/id692867256?ls=1&mt=12)
- [laplock](http://www.laplock.co/): 맥북 잠금 앱. 현재 배포 중단이며 앱스토어에 올린다고 한다.

### 참고할만한 글

- [The Best Mac Apps and Utilities for Mac OS x](http://www.labnol.org/software/essential-mac-utilities/9479/)
- [Awesome OS X](https://github.com/iCHAIT/awesome-osx)

## 웹앱

- [inoreader](https://www.inoreader.com/): 하루 한 두번은 사용하는 RSS 리더. 안드/iOS 앱도 있다.
- [Pocket](https://getpocket.com/)
- [Workflowy](http://bit.ly/UDCz17): 최고의 아웃라이너 앱!
- [Trello](https://trello.com/)

## 검토용 앱

- [Zoommy](http://zoommyapp.com/): ALL FREE STOCK PHOTOS IN ONE PLACE