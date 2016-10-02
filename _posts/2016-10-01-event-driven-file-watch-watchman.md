---
layout: post
title: "cron 보단 이벤트 드리븐 파일 와치 Watchman"
description: "타임 드리븐 방식의 cron보다 이벤트 드리븐 파일 와치인 페이스북의 Watchman을 사용하는 방법"
category: blog
tags: [cron, event-driven, file-watch, watchman, wiki]
---

[마크다운 파일로 위키를 관리](https://nolboo.kim/blog/2013/12/17/markdown-wiki-bitbucket-gollum/)하다 보니 깃푸시를 자주해야 하는데 그렇지 못했다. 얼마 전에 심플노트가 오픈소스로 공개하여 다시 심플노트 동기화를 켰더니 크기가 큰 파일 위주로 300여 개의 파일을 삭제하는 [참사](https://nolboo.kim/blog/2014/04/15/how-to-use-markdown/#nvalt-2--)를 당했다. 다행히 동기화를 하기 며칠 전 기존 위키 서비스를 검토하는 과정에서 저장소로 푸시한 것이 있어 거의 복구했다. 다시 되풀이하지 않기 위해서 푸시를 자동화하는 것을 고려했다.

시간 주기(time-driven)로 반복적인 작업을 처리할 때 운영체제에서 기본으로 제공하는 [Cron](https://www.wikiwand.com/en/Cron)을 많이 쓰는 것 같다. [crontab](http://ss64.com/osx/crontab.html)에서 시간 설정하는 법만 눈여겨보면 그리 어렵지 않게 사용할 수 있다. 

> - [Mac OS X startup jobs with crontab, er, launchd](http://alvinalexander.com/mac-os-x/mac-osx-startup-crontab-launchd-jobs): 크론 위주로 자세하게 잘 설명되어 있으니 크론 사용하실 분은 참고하세요.(영어)

그러나, 시간 주기를 설정하는 것도 애매하고 사용하지 않을 때 쓸데없이 돌아가는 것도 맘에 들지 않아서 파일이 변경되었을 때 실행하는 것을 찾다 보니 [inotify](https://www.wikiwand.com/ko/Inotify)가 제일 먼저 눈에 들어왔는데 리눅스 전용이다.

맥에서 사용할 수 있는 것으로는 [fswatch](https://github.com/emcrisostomo/fswatch), [Lingon](https://www.peterborgapps.com/lingon/), [Watchman](https://facebook.github.io/watchman/)이 레이더에 들어왔다.

fswatch는 포어그라운드 방식이고 한번 작업이 트리거되면 영원히 반복한다. 터미널을 꺼야 한다. Lingon은 유료 GUI 앱인데 저장이 안 되는 데모용을 내려받아서 살펴보는데 GUI만 제공되지 CLI 방식보다 더 어렵다. 페이스북이 오픈소스로 내놓은 watchman은 홈페이지도 정돈되어 있고, 무엇보다 공식문서가 상세하게 갖춰져 있다. 또한, cron 처럼 서버와 클라이언트가 나뉘어 있다.

## Watchman

- 공식 페이지: [Watchman - A file watching service](https://facebook.github.io/watchman/)

페이스북에서 만든 오픈소스이고 [React Native에서 기본으로 권장](https://facebook.github.io/react-native/docs/getting-started.html)하는 툴이다. 메인테이너를 구하고 있지만, 올해 9월 10일 최신 버전이 나올 정도로 관리되고 있다. 자체적으로 모든 기능을 다시 만든 것이 아니고 각 시스템에서 사용할 수 있는 것을 이용하기 때문에 모든 OS에서 되는 것은 아니다. 그래도 자주 사용하는 시스템은 다 된다.

Linux는 `inotify`를 이용하고, OS X는 10.7 이상은 `FSEvents`를, 그 이전 버전은 `kqueue(2)`를 이용한다. Windows 서버는 알파 상태이다. BSD와 Illumos, Solaris 시스템에서도 사용할 수 있다.

### 설치

```shell
brew update
brew install watchman
```

홈브루를 사용하면 이게 끝이다. 다른 방법은 [Installation](https://facebook.github.io/watchman/docs/install.html)을 참조한다. 단, OS X 10.6 이전 사용자는 다음을 참조한다.

> - [MacOS Max OS File Descriptor Limits](https://facebook.github.io/watchman/docs/install.html#max-os-file-descriptor-limits)

### 실행과 로그

실행도 간단해서 아래 두 줄로 끝난다. 홈페이지 첫 화면에서도 자랑하고 있다.

```shell
watchman watch ~/Dropbox/synapse
watchman -- trigger ~/Dropbox/synapse sync -- ~/Dropbox/synapse/sync.sh
```

첫 번째 명령은 watch 서버를 구동시키면서 지정된 폴더를 지켜보도록 한다. 두 번째 명령은 트리거를 생성하여 이름과 후속 명령을 지정한다. `~/Dropbox/synapse`와 `~/Dropbox/synapse/sync.sh` 부분을 자신이 와치하길 원하는 폴더와 명령으로 바꾸면 된다. 

> $PATH가 변경되는 것을 와치맨이 인지하지 못하므로 명령어는 절대 경로를 지정하는 것이 좋다. 단, 와치 루트에 트리거 스크립트를 등록했다면 루트의 상대경로를 지정할 수 있다.

실행해보니 500여 개 파일의 폴더에 대해서 3MB 정도의 메모리를 차지하고 속도도 빠르다. 와치맨은 백그라운드로 실행되기 때문에 출력은 `log` 파일에 쌓이고, 모든 와치와 결합한 트리거를 기억하며, `state` 파일에 저장한다. 이 파일들의 위치는 

> The default location for logfile will be <STATEDIR>/<USER>.log.

이라고 공식문서에 적혀있고 [Troubleshooting](https://facebook.github.io/watchman/docs/troubleshooting.html#where-are-the-logs)에도 brew의 경우가 나와 있지만, 다음 명령으로 쉽게 찾을 수 있다.

```shell
ps ax | grep watchman
 3081   ??  S<     0:08.50 /usr/local/Cellar/watchman/4.7.0/libexec/bin/watchman --foreground --logfile=/usr/local/var/run/watchman/유저-state/log --log-level=1 --sockname=/usr/local/var/run/watchman/유저-state/sock --statefile=/usr/local/var/run/watchman/유저-state/state --pidfile=/usr/local/var/run/watchman/유저-state/pid
```

`/usr/local/var/run/watchman/유저-state/`에 `log` 파일이 있는 것을 알 수 있다.

```shell
tail -n 100 /usr/local/var/run/watchman/*/log
```

위와 같은 명령이나 원하는 방법으로 로그파일을 볼 수 있다.

### 무한루프 해결

트리거 명령의 기본적인 형태는 다음과 같다.

```shell
watchman -- trigger /path/to/dir triggername [patterns] -- [cmd]
watchman -- trigger ~/Dropbox/synapse sync *.md -- ~/Dropbox/synapse/sync.sh
```

이번에는 마크다운 위키이니 `*.md`라는 패턴을 줬다. 패턴을 주지 않았던 이전 명령어는 모든 파일을 와치하게되어 fswatch와 같이 무한루프에 빠지게 되지만 두 번째 것은 마크다운 파일만 와치하고, 변경되면 `sync.sh` 스크립트를 한 번만 실행하였다. 그러나 마크다운 위키라 해서 마크다운만 있는 것은 아니고 이미지와 pdf 등 파일 확장자가 다른 것도 있었다. 무엇보다 이벤트 드리븐이라고 하는 것들이 왜 무한루프에 자꾸 빠지는지 이해가 가질 않았다. 그래서 다른 것도 찾아보고 결국 공식문서를 이리저리 뒤져보기 시작했다. (3시간 넘게 헤맸다.)

처음 명령이 무한루프에 빠진 이유는 `.git` 폴더 때문이다. `sync.sh`가 저장소로 푸시하는 명령을 가지는 스크립트 파일이므로 폴더 안의 파일이 변경되면 `sync.sh`가 실행되고 이것은 히든 폴더이지만 `.git` 폴더의 내용을 변경한다. 그래서 다시 트리거가 작동된다. 그래서 무한루프에 빠진 것이다. 그러니 **후속 명령은 시스템 내의 파일을 변경하지 않도록 해야 한다.** 이건 공식문서나 인터넷에도 잘 설명되어 있지 않은 것 같다.

한 가지 더 주의할 점은 symlink는 팔로하지 않으며, 리포트만 한다. 내 위키에는 심링크도 있으나 이것은 그리 중요하지는 않다.

> 덕분에 watchman-wait와 [watchman-make](https://facebook.github.io/watchman/docs/watchman-make.html)도 일일이 다 해봤지만 포어그라운드로 실행되기 때문에 공부만 했다.

### 설정 파일

`*.md` 파일 이외의 파일도 와치할 수 있도록 설정하려면 [설정 파일](https://facebook.github.io/watchman/docs/config.html)을 이용하면 된다.

주로 서버가 참조하는 글로벌 설정 파일은 `/etc/watchman.json`이고 해당 루트 설정 파일은 `.watchmanconfig`이다. 

> 루트라는 것은 트리거를 설정한 폴더를 말하며, 여러 개를 만들 수 있다. 이 포스트에서는 `~/Dropbox/synapse sync` 폴더이다.

**설정을 변경하면 루트는 watch를, 글로벌은 watchman을 재시작해야 한다.**

루트 `.watchmanconfig`을 만들고 설정 옵션을 json 형식으로 지정하고 저장한다.

```json
{
    "settle": 60
    "ignore_dirs": [".git"]
}
```

트리거를 replace한다.

```shell
watchman -- trigger ~/Dropbox/synapse sync -- ~/Dropbox/synapse/sync.sh
```

이번에는 트리거에 아무런 패턴을 지정하지 않았다. 무한루프되지 않는다.

설정 파일 옵션을 몇 가지 소개한다.

- settle: 트리거를 실행하기 전 기다리는 시간. 기본값은 20 millisecond이다.
- ignore_dirs: 완전히 무시할 폴더. 폴더 밑의 모든 것을 무시한다. macOS에서는 처음 8개 폴더를 우선순위로 처리한다.
- fsevents_latency: OS X의 FSEventStreamCreated의 지연 파라미터. 0.01초가 기본값이며 루트마다 다르게 줄 수 있다. kFSEventStreamEventFlagUserDropped 문제가 보이면 값을 높여준다.

서버 옵션은 서버를 시작할 때 사용한다. 클라이언트도 인지한다. 서버가 이미 실행되어 있으면 영향을 미치지 못하니 서버를 재시작해야 한다.

## 서브 명령

와치맨은 watchman에 이은 서브 명령과 옵션을 여러 개 가지고 있다. 도움말은 `watchman -h`로 볼 수 있다. 필수 서브 명령을 몇 개 소개하면 다음과 같다.

와치맨 서버를 끈다.

```shell
watchman shutdown-server
```

가끔 안 꺼져서 `killall -9 watchman`으로 끄기도 함.

현재 동작하고 있는 트리거의 목록을 본다.

```shell
watchman trigger-list ~/Dropbox/synapse
```

원하지 않는 트리거를 삭제한다.

```shell
watchman trigger-del /root triggername
```

현재 서버가 와치하고 있는 리스트(루트)를 보여준다.

```shell
watchman watch-list
```

원하지 않는 루트를 삭제한다.

```shell
watchman watch-del /path/to/dir
```

루트를 와치를 모두 삭제한다.

```shell
watchman watch-del-all
```

한번 설정된 와치맨은 재부팅을 해도 잘 실행된다. :)

## 추가링크

- [How to install and use Watchman – Code Yarns](https://codeyarns.com/2015/02/10/how-to-install-and-use-watchman/) 삭제 방법. 소스 이용.
- [Watchman » ADMIN Magazine](http://www.admin-magazine.com/Archive/2015/26/Look-for-file-changes-and-kick-off-actions-with-Watchman/) 자세한 시리즈 글


