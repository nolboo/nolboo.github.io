---
layout: post
title: "웹 서핑과 북마클릿을 키보드로"
description: "웹 서핑과 북마클릿을 키보드 조작하는 방법"
category: blog
tags: [vim, bookmarklet, web, browser, extension]
---

이제 어떤 작업을 하든 데스크톱 웹 브라우저를 많이 사용한다. Vim을 사용한 후에는 마우스에서 점점 멀어진다. 웹 브라우저도 키보드를 중심으로 사용한다. 애용하게 된 키보드 웹 서핑 확장과 북마클릿 단축키 확장을 소개한다.

# 키보드 서핑

Vim을 주요 텍스트 에디터로 사용하게 되면서 사용하는 앱에 Vim 플러그인/확장이 있으면 모조리 깔고 있다. 웹 브라우저도 예외가 아니어서, 최근 나온 [Surfingkeys](https://chrome.google.com/webstore/detail/surfingkeys/gfbliohnnapiefjpjlpjnehglfpaknnc) 확장을 몇 달 사용해 봤는데 스크롤이나 검색, 탭 관리, 거추장스럽게 마케팅 추적용 URL 리소스를 단축키로 제거하는 등의 기능이 너무 맘에 드는 확장이다. 지원 단축키는 `?`로 볼 수 있다. 기능이 너무 많아서 조금씩 익혀나갔다.

그러나 같이 소개하는 북마크릿 단축키 확장과 충돌이 있어서 눈물을 머금고, [Vimium](http://vimium.github.io/)으로 갈아탔다. `?`로 지원 단축키를 볼 수 있고, 옵션에서 자신만의 키를 매핑(map)할 수 있다. 기능은 Surfingkeys보다 단순하지만 그래도 쓸만하다. [공식 위키](https://github.com/philc/vimium/wiki)도 참조할 만하다.

파이어폭스에도 비슷한 기능을 하는 [VimFx](https://addons.mozilla.org/ko/firefox/addon/vimfx/) 확장이 있다.

# 북마클릿 단축키

최근의 웹 브라우저는 너무 무겁기 때문에(메모리를 말도 못하게 차지한다) 북마크릿을 선호한다. 북마클릿의 단점은 북마크바가 화면을 차지한다는 것이고 마우스로 클릭해야 한다는 것이다.

그래서 찾은 것이[Bookmarks Bar Keyboard Shortcuts](https://chrome.google.com/webstore/detail/bookmarks-bar-keyboard-sh/omgmmhpgegfcifjmhpenmjpignkegpal) 확장이다. Ctrl+1-0까지 북마크 바의 왼쪽에서 차례대로 실행된다. 북마클릿이면 실행되고 북마크면 그 사이트로 이동한다.(근데 북마클릿이 열 개를 다 차지했;;) 북마크 바는 `<Cmd+Shiift+b>`로 토글할 수 있고, 북마크 바가 보이지 않아도 동작한다.

확장보다 다른 방법을 선호하는 글도 있다.

- [Launch Chrome Bookmarklets With Keyboard Shortcuts – MacStories](https://www.macstories.net/links/launch-chrome-bookmarklets-with-keyboard-shortcuts/): 애플 스크립트를 사용하는 방법
- [How To Create Custom Keyboard Shortcuts For Browser Actions and Extensions in Google Chrome](http://www.howtogeek.com/127162/how-to-create-custom-keyboard-shortcuts-for-browser-actions-and-extensions-in-google-chrome/)

# 관련 글

- [주로 사용하는 맥앱과 웹앱](https://nolboo.kim/blog/2015/05/06/mac-web-app/)
- [애용하는 웹브라우저 확장과 북마클릿](https://nolboo.kim/blog/2015/05/02/browser-extension-bookmarklet/)


