---
layout: post
title: "서브라임 텍스트 3에서 에버노트 사용하기"
description: "서브라임 텍스트 3에서 에버노트를 작성/검색/보기/업데이트할 수 있는 플러그인에 대한 간단한 설명"
category: blog
tags: [sublime, evernote, markdown]
---

## 서브라임 텍스트 3에서 에버노트를 작성하기

에버노트는 크로스 플랫폼 클라우드 노트를 최초로 안정적으로 구현하였고, 프리미엄 요금체계를 용량제로 처음 도입한 것이 매우 인상적이었다. 노트앱에 관심이 많은 사람으로서 일찍부터 사용을 했고, 기능은 물론 비즈니스 모델을 어떻게 발전시키고 사업을 어떤 식으로 전개해 나가는가에 주목을 하고 있던 서비스였다. 그러나 노트앱을 끼고 사는 사용자로선 클라이언트와 웹을 가리지 않고 로딩 시간이 매우 느려서 웹페이지 전체나 일부를 클립하여 저장하는 용도로만 사용하였다. 최근에는 로딩 속도가 비약적으로 빨라졌지만 그래도 성질이 급한데다가 로딩이 느리면 뭘 적을지 까먹기 일쑤인 나와는 맞지 않아서 [nvALT와 서브라임 텍스트를 주로 사용하고 있다](http://nolboo.github.io/blog/2014/04/15/how-to-use-markdown/). 

<blockquote class="twitter-tweet" lang="en"><p>Sublime에서 에버노트 불러오기/새노트 전송 가능한 패키지: Evernote - Packages <a href="http://t.co/edMqxKp489">http://t.co/edMqxKp489</a> ShareX로 이미지 같은 거 마크다운으로 본문에 삽입해서 바로 전송! PC에서 에버노트에 메모 편해짐 <a href="https://twitter.com/hashtag/lk?src=hash">#lk</a></p>&mdash; 서울비 (@seoulrain) <a href="https://twitter.com/seoulrain/status/544701734161874944">December 16, 2014</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

오늘 [서울비](https://twitter.com/seoulrain/)님의 [트윗](https://twitter.com/seoulrain/status/544701734161874944)을 보고 서브라임에서 마크다운을 사용하면서도 에버노트를 좀 더 편리하게 사용할 수 있다는 것을 알고 간단하게 정리해본다.

## 설치

서브라임 텍스트에서 [Evernote](https://github.com/bordaigorl/sublime-evernote) 플러그인을 설치한다.
설치가 끝나면 아래 콘솔 창에 에버노트 `개발자 토큰`과 `NoteStore URL`을 차례로 입력한다. 이때 서브라임 메뉴의 Preference>Package Setting>Evernote>Reconfigure Authorization를 선택하거나 Command Palette에서 `Command Palette > Evernote: Reconfigure` 명령으로 해당 웹페이지를 열면 편리하다.

위와 같이 설치와 설정이 완료되면 `CMD+Shift+P`를 눌러 Command Palette을 부른 후 `e`를 누르면 사용할 수 있는 에버노트 플러그인 명령들이 보인다.

## 노트 작성 및 저장(클라우드 업데이트)

`Command Palette > Evernote: New empty note` 명령을 선택하면 메타데이터를 입력할 수 있으며, 기존의 노트북과 태그에서 자동 선택할 수 있다. 여러 개의 태그는 `,`로 구분한다.

여기까지 작성한 후 `Command Palette > Evernote: Update Evernote Note`로 작성된 노트를 업데이트할 수 있다. 또는 서브라임의 메뉴에서 `File > Save`를 이용해 로컬에 `.enmd` 확장자로 저장할 수도 있다.

1. 에버노트의 기존 노트를 열거나 검색하여 편집할 수 있다. 
2. 첨부화일을 다운로드해서 열람하거나 추가할 수 있다.
3. 선택한 부분을 (코드 스니핏처럼 하일라이트하여) 새로운 에버노트로 추가할 수 있다.
4. 노트를 링크할 수 있다.(이 기능은 거의 써보지 않음)
5. 에버노트 클라이언트나 웹에서 현재 노트를 볼 수 있다.(먼저 업데이트해야 편집된 부분이 반영된다)

## Supported Markdown

기본적인 마크다운은 물론 울타리 코드 블록, 체크박스, 주석, 테이블 등을 지원한다. 그러나, 인라인 코드 블록이나 HTML 등은 약간 제한된다. 노트에서 사용되는 마크다운으로는 충분할 것 같다. 자세한 것은 [공식 위키 페이지](https://github.com/bordaigorl/sublime-evernote/wiki)에 설명되어 있다.

## 기타

그 외 Command Palette 명령에 단축키를 지원하거나 인라인 CSS를 추가할 수도 있다. 자세한 것은 [README 파일](https://github.com/bordaigorl/sublime-evernote/blob/master/README.md)에 설명되어 있다.

전반적으로 마크다운 사용자가 에버노트를 **빠르게** 검색하고 열고 간단한 편집을 하기에는 최고의 플러그인 같다. 공유된 에버노트는 다음과 같다.

- [서브라임 텍스트 3에서 에버노트 사용하기](http://bit.ly/1yXgcW0)

## 참고링크

* [Geeknote - Evernote console client for Linux, FreeBSD, OS X](http://www.geeknote.me/)