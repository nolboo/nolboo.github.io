---
layout: post
title: "북마크를 대신하는 브라우저 탭 관리 확장과 워크플로우"
description: "웹브라우저 탭 관리 확장 프로그램을 소개하면서 북마크 서비스를 대신하기 위해 로컬에서 마크다운 을 활용한 텍스트 기반 워크플로우를 간단히 소개한다."
category: blog
tags: [browser, extension, bookmarklet]
---

웹에서 리서치하거나 무엇인가를 읽을 때 웹의 특성상 브라우저 탭을 여러 개 열게 마련이다. 예전에 책상에 여러 개의 책을 펼쳐 놓고 서로 참조해가면서 작업을 하던 것이 생각나는 장면인데, 링크가 많고 제한이 별로 없는 웹브라우저의 특성상 더 많은 탭을 열게 된다. 30, 40개 이상 열어놓는 경우가 많은데 시스템이 버벅대기 시작하고 너무 많은 탭을 정리해야겠다는 생각이 든다.

여러 브라우저를 동시에 지원하는 확장도 많으나 동작이나 메모리 관리가 다른 때도 있다. 또한, [애용하는 웹브라우저 확장과 북마클릿](https://nolboo.kim/blog/2015/05/02/browser-extension-bookmarklet/)에서 파이어폭스 위주로 정리한 적이 있는데 지금은 크롬을 주로 사용하고 있으므로 이 글에서는 크롬 브라우저 확장을 중심으로 소개한다.

## Onetab

[OneTab](https://chrome.google.com/webstore/detail/onetab/chphlpgkkbolifaimnlloiipkdnihall?hl=ko)은 현재 열려있는 탭을 하나의 목록으로 만들어 준다. 필요할 때 그 목록에서 전체를 복원하거나 하나씩 선택적으로 복원할 수 있어 일종의 로컬 북마크 기능을 대신 할 수 있다. 많은 탭을 하나의 페이지로 관리할 수 있어 크롬 메모리의 최대 95%를 절감한다고 주장하는데, 페이지의 전체 목록이 삼사천 개를 넘으면 크롬의 속도에 영향을 미쳐 목록을 정리해야만 한다.(응? 게으른 놀부=3=3=3) 아! 2,3년간 써왔는데 딱 한 번 오천 개 정도가 지워진 경우가 있어 속도에 영향을 미칠 정도로 쌓이면 이제는 꼭 정리한다.(게으름 방지 기능?)

목록에 이름도 지정할 수 있어 나중에 필요한 탭을 특정 목록에 바로 넣을 수 있다. 그런데 서브 메뉴의 서브 메뉴로 있어 조금 귀찮다.

옵션에서 복원할 때 현재 창에 열림, 고정 탭 제외, 브라우저 시동 시 원탭 열지 않기, 탭을 연 후에 원탭 목록에서 제거를 지정해서 사용한다. 한글로 잘 설명되어 있다.

## The Great Suspender

[The Great Suspender](https://chrome.google.com/webstore/detail/the-great-suspender/klbibkeccnjlkjkiokjodocebajanakg)는 일정 시간이 지나면 탭을 잠재워주고 다시 탭으로 돌아오면 복원해 준다. 옵션에서 시간만 변경하고 나머지는 기본으로 사용한다.

## 클라우드 서비스 

- [Pocket - Chrome 웹 스토어](https://chrome.google.com/webstore/detail/save-to-pocket/niloccemoadcdkdjlinkgdfekeahmflj?hl=ko) : 유튜브와 비메오 등의 동영상 저장용, 모바일 앱은 많은 용량을 차지하기 때문에 URL을 홈 화면에 저장하여 사용한다.
- [Evernote Web Clipper | Evernote](https://evernote.com/intl/ko/webclipper/): 웹페이지와 pdf 저장
- [Todoist](https://chrome.google.com/webstore/detail/todoist-to-do-list-and-ta/jldhpllghnbhlbpcmnajkpdmadaolakh): [Todoist for Gmail](https://chrome.google.com/webstore/detail/todoist-for-gmail/clgenfnodoocmhnlnpknojdbjjnmecff)과 함께 할일에 포함할 URL 저장

## 크롬 브라우저 보강

웹브라우저의 북마크와 히스토리는 초기보다는 훨씬 적게 사용하지만, 아직도 필수 기능이다. 그러나 UI가 너무 후져서 다음 확장으로 보강하고 있다.

- [Bookmark Manager](https://chrome.google.com/webstore/detail/bookmark-manager/gmlllbghnfkpflemihljekbapjopfjik)
- [Better History](https://chrome.google.com/webstore/detail/better-history/obciceimmggglbmelaidpjlmodcebijb)

## 마크다운 링크 확장

위에서 소개한 확장에서 몇 년간 사용해온 OneTab은 최근 사용을 대폭 줄였고, The Great Suspender는 이제 사용하지 않는다. 몇 가지 이유로 이제는 북마크까지도 될 수 있으면 로컬에서 관리하려고 전환 중이다.

### 기본 워크플로우

- 매일의 북마크는 2016-09-25.md와 같이 하나의 마크다운 파일에 전부 담는다.
- 그 중에서 필요한 링크만 열어서 읽고 중요한 내용은 복사하고 메모를 덧붙일 것은 붙인다.
- 추가 정리가 필요한 것은 헤더를 붙이고 더 자세한 메모를 붙이거나 정리한다.
- 필요가 없는 링크는 지워버리고 나머지는 나중에 더 살펴본다. 날짜.md는 `archive/` 폴더에 백업하여 향후 검색으로 찾을 수 있게 한다.

기본 워크플로우는 위와 같으며, 살을 붙여가는 중에 오늘의 포스트와 같이 어느 정도 덩치가 커지면 별도의 마크다운으로 정리하여 포스트 한다.

기본적으로 텍스트로 관리하기 때문에:

- 어떠한 서비스나 앱에도 독립적이며, 필요하다면 각각의 서비스나 앱의 장점을 활용할 수 있다.
- 차지하는 용량이 엄청 작다. 
- Dropbox 서비스를 이용하여 어떤 기기에서든 열람하거나 편집할 수 있다.
- 버전 관리를 위해 드롭박스에 더해 Git 서비스를 이용할 수 있다.(물론 텍스트만 되는 것은 아니지만 DVCS도 속도를 무시할 순 없다)
- 텍스트 검색보다 빠른 검색은 거의 없다.

등의 장점을 누릴 수 있다. 물론 이미지(스캔 이미지 포함)나 웹페이지, pdf 등은 링크만 걸어두고 에버노트나 데본싱크의 검색을 이용한다.

### TabCopy

이렇게 결정하기 위해서 결정적 역할을 담당해준 확장이 하나 있다. 오늘의 포스트 주인공인  [TabCopy](https://chrome.google.com/webstore/detail/tabcopy/micdllihgoppmejpecmkilggmaagfdmb)이다. 예전에 [소개](https://nolboo.kim/blog/2015/05/02/browser-extension-bookmarklet/)한 마크다운 링크 북마클릿은 하나의 웹페이지만 링크를 생성할 수 있었지만 TabCopy는 한 개는 물론 하나의 창에 있는 모든 탭, 더 나아가 여러 창에 열려있는 모든 탭을 한 번에 복사할 수 있다. 위의 워크플로우에서 가장 중요한 역할을 하는 확장이다.

![메뉴](https://c5.staticflickr.com/9/8332/29877571436_15ffe2daf8_c.jpg)

복사되는 링크 포맷을 여러 형태로 할 수 있으며, 첫 번째 포맷을 마크다운으로 지정하였다. 커스터마이즈 포맷까지 지원한다.

![포맷](https://c4.staticflickr.com/9/8176/29912628675_182a00ab89_z.jpg)

마크다운이 아닌 텍스트 형식으로 간단히 복사하고 여러 창을 한 번에 여는 것이 맞는 분은 [Tab Copy/Paste](https://chrome.google.com/webstore/detail/tab-copypaste/nbfccmdfpollpgjnbghmnkmgimliookh)를 추천한다.

### Open URL 단축키

여러 탭을 저장하는 것은 TabCopy로 해결하였는데 여러 탭을 한 번에 여는 방법이 아쉬웠는데 OS X의 기본 서비스가 있다는 걸 발견했다. 선택한 블록에서 url만 추출하여 기본 브라우저에서 열어주는 서비스이다. 대부분의 앱에서 우클릭한 후 나오는 서비스에서 선택할 수 있는데 앱에 따라 한 번 이상의 서브로 나타나는 경우가 있다.

![서비스 단축키 지정](https://c4.staticflickr.com/9/8558/29828478051_1e0f687ce7_c.jpg)

위와 같이 <kbd>Ctrl</kbd><kbd>Opt</kbd><kbd>Cmd</kbd><kbd>o</kbd>로 지정하면(취향에 따라 선택할 수 있다) 여러 마크다운 링크를 선택한 후 하나의 단축키로 여러 url을 기본 웹브라우저로 열 수 있다. 

OneTab으로 탭 관리를 할 때 부족한 것 중 하나가 계층적인 탭 관리인데 마크다운으로 관리하면 그냥 들여쓰기만 하면 된다는 것이 추가적인 장점이다.

> Open URL 서비스를 사용할 수 없는 상황이 있는데 터미널 기반으로 Vim을 사용할 때이다. MacVim GUI 모드에서는 잘 동작한다. 


