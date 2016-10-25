---
layout: post
title: "맥 파인더에서 터미널 여는 방법들"
description: "맥 파인더에서 단축키로 터미널을 여는 방법과 서드파티앱을 사용하는 방법을 간단히 기록"
category: blog
tags: [macos, sierra, finder, terminal, iterm]
---

## 맥 파인더에서 터미널 여는 방법

파인더에서 터미널을 여는 경우가 종종 있는 편인데, macOS 시에라 출시 이후에 업그레이드가 되지 않아서 불편했던 앱 중의 하나가 TermHere였다. 대안을 찾던 중에 cdto라는 오픈소스 앱을 알게 되어 그런대로 사용하고 있였는데, 오늘 다른 것을 설정하다가 우연히 맥 기본 서비스에 "폴더에서 새로운 터미널 열기"와 "폴더에서 새로운 터미널 탭 열기" 서비스가 있는 걸 발견했다. 그걸 계기로 맥 파인더에서 터미널을 열고 해당 폴더로 바로 이동하는 방법을 아는 한도 내에서 간단히 정리한다.

## 맥 기본 서비스

시스템 환경설정의 키보드를 연 다음, 단축키 탭에서 서비스를 선택하고 "폴더에서 새로운 터미널 열기"와 "폴더에서 새로운 터미널 탭 열기"를 체크하여 활성화한다. 여기서도 단축키를 바로 지정할 수 있을 것 같아서 해보았지만 안된다. 내 경우에는 다음 단계를 더 거쳐야 했다.

![](https://c3.staticflickr.com/6/5765/30518894146_57d08dc790_z.jpg)

왼쪽 마지막의 앱 단축키를 선택하고 `+`를 누른다. `응용 프로그램`에는 Finder.app을 선택하고, `메뉴 제목`에 다음 항목을 각각 넣는다. 이때 실제 메뉴명과 정확히 같게 입력해야 하며, 서브로 열리는 메뉴는 `->`로 표시해야 한다.

```
Finder->서비스->폴더에서 새로운 터미널 열기
Finder->서비스->폴더에서 새로운 터미널 탭 열기
```

원하는 `키보드 단축키`를 지정한다. 기본적으로 파인더에서 이미 지정된 단축키를 피해야 한다. 새로운 터미널 윈도우를 연다는 뜻으로 `Cmd+Shift+w`로 지정했다. 탭 열기를 자주 사용하지 않기 때문에 지정하지 않았다.

![](https://c5.staticflickr.com/6/5569/30438367132_618bdcebdb_z.jpg)

파인더에서 폴더를 선택한 상태에서 단축키를 누르면 작동한다.  Commander One PRO 등 파인더와 유사한 앱에서도 동일하게 설정하여 실행할 수 있다.

## 쉘 스크립트 function

이 글을 올린 후 얼마 되지 않아 트위터의 [@miname님이 좋은 팁](https://twitter.com/miname/status/790927908382478338)을 알려주셨다.(감사합니다^^) 쉘 스크립트의 함수 정의를 이용하는 방법이며, 터미널에서 `cdf`를 입력하여  현재 파인더의 폴더로 이동할 수 있다.

자신의 `.bash_profile`이나 `.zshrc`에 다음 함수를 추가한다.

```shell
# cd into whatever is the forefront Finder window.
cdf() {  # short for cdfinder
  cd "`osascript -e 'tell app "Finder" to POSIX path of (insertion location as alias)'`"
}
```

그런 후에 쉘을 다시 시작하면 `cdf` 명령을 사용할 수 있다.

## 써드파티  앱

위의 방법을 사용하기 전에는 써드파티 앱을 사용하였다. 필요한 분도 있을 것 같아 기록의 의미로 남긴다.

3rd party 앱은 전부 무료이고, 앱을 링크에서 내려받아 애플리케이션 폴더로 옮긴 후 커맨드 키를 누른 상태에서 파인더의 툴바로 드래그앤드랍으로 옮기면 된다. 이제 원하는 폴더에서 해당 아이콘을 클릭하면 터미널이나 iTerm이 열리고, 폴더로 이동한다.

- [Go2Shell - ZipZapMac](http://zipzapmac.com/Go2Shell)
    - [Go2Shell on the Mac App Store](https://itunes.apple.com/app/go2shell/id445770608?mt=12)
    - [[추천 무료앱] OS X 파인더에 열린 폴더 경로로 새로운 터미널 창을 띄워 주는 'Go2Shell'](http://macnews.tistory.com/1216)
- [TermHere on the Mac App Store](https://itunes.apple.com/us/app/termhere/id1114363220?ls=1&mt=12): 
- [ealeksandrov/cdto: Finder Toolbar app to open the current directory in the Terminal (or iTerm, X11)](https://github.com/ealeksandrov/cdto)
- [XtraFinder](http://www.trankynam.com/xtrafinder/): 시에라에서 사용하려면 [링크](http://www.trankynam.com/xtrafinder/sip.html)를 참조해서 복구 모드를 거쳐야 한다.

![](https://c1.staticflickr.com/6/5833/30438366992_ce42c56f7c_z.jpg)

위에서 소개한 앱 중 3가지를 설치한 모습이다. 이제 다 지워야지~
