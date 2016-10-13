---
layout: post
title: "MacVim과 Vim 8 설치"
description: "맥에서 가장 많이 사용하는 Vim 버전인 MacVim을 설치하는 방법과 Vim 8으로 업그레이드하는 방법"
category: blog
tags: [editor, vim, macvim, install, upgrade]
---

모든 맥 버전에 vi가 아니 정확히는 [Vim](https://www.wikiwand.com/en/Vim_(text_editor):Vi IMproved)이 기본으로 설치되어있다. 왕초보일 때 터미널 `vi` 명령으로 실행시키고 나서 나가질 못해서 터미널을 꺼버린 참극을 빚었던 텍스트 에디터이다.

스택오버플로우 개발자 설문에서 텍스트 에디터 부문에서 [2015년 3위](http://stackoverflow.com/research/developer-survey-2015#tech-editor), [2016년엔 4위](http://stackoverflow.com/research/developer-survey-2016#technology-development-environments)를 기록한 인기 있는 에디터이다.

그런데 며칠 전 10년 만에 [버전 8이 출시되었다](https://groups.google.com/forum/#!topic/vim_announce/EKTuhjF3ET0). channels, JSON, Jobs, Timers, Partials, Lambdas, Closures, Packages 기능이 새로 추가되고 많은 버그가 수정되었다고 한다. 자세한 내용은 [여기](https://github.com/vim/vim/blob/master/runtime/doc/version8.txt)에서 볼 수 있다. 그래도 맥이라 [MacVim](http://macvim-dev.github.io/macvim/)을 설치했더니 터미널 버전은 버전 7.3이 설치된다. 버전 8은 별도로 설치해야 했다. 그 과정을 간단히 적었다.

## Homebrew

MacVim을 Homebrew로 설치하면 터미널 버전도 같이 설치할 수 있다고 한다.

<pre class="terminal">
brew install macvim --override-system-vim
brew linkapps
</pre>

이제 버전을 확인해보면:

<pre class="terminal">
mvim --version
VIM - Vi IMproved 8.0 (2016 Sep 12, compiled Sep 14 2016 09:39:40)
MacOS X (unix) version
Included patches: 1-3
Compiled by Homebrew
...
</pre>

으로 잘 나오지만,

<pre class="terminal">
vi --version
VIM - Vi IMproved 7.3 (2010 Aug 15, compiled Jun 14 2016 16:06:49)
Compiled by root@apple.com
Normal version without GUI.
</pre>

터미널 버전은 아직 7.3이다.

Vim도 Homebrew로 설치하는 방법이 있었다.

<pre class="terminal">
brew install mercurial
brew install vim --with-override-system-vi
vi --version
VIM - Vi IMproved 7.3 (2010 Aug 15, compiled Jun 14 2016 16:06:49)
</pre>

mercurial을 먼저 설치하지 않으면 Vim 패키지를 찾지도 못한다. 그러나, 이 방법으로 설치해도 버전 8이 설치되지 않았다.

>   아래의 절차를 거치지 않고도 `-v` 옵션을 이용하면 MacVim을 터미널 모드로 실행할 수 있다.
>   참고: [MacVim은 터미널에서도 돌아간다.](http://seorenn.blogspot.kr/2011/06/vim-macvim.html) + [osx - How to run mvim (MacVim) from Terminal? - Stack Overflow](http://stackoverflow.com/questions/2056137/how-to-run-mvim-macvim-from-terminal)
>   다음과 같이 alias를 설정하면 아래의 경로 설정을 거치지 않아도 된다.
>   
>   ```shell
>   alias vi=mvim -v
>   ```

## Vim 8 업그레이드

`brew`로 설치된 버전이 `/usr/local/bin/`에 설치되고, 내 시스템 경로에 7.3버전이 있는 `/usr/bin/` 보다 뒤에 있어 `/usr/bin/vim`을 불러오는 것이 이유였다.

<pre class="terminal">
sudo mv /usr/bin/vim /usr/bin/vim73
mv: rename /usr/bin/vim to /usr/bin/vim73: Operation not permitted
</pre>

위와 같이 기본 Vim을 이름을 변경하려 하였으나 에러. 이유는 OS X 10.11 엘 캐피탄에 도입된 새로운 보안체계 루트리스(Rootless)가 원인이다. 루트 권한으로도 `/usr/bin`을 건드리지 못한다. [복구모드로 부팅하여 모든 권한을 가지는 방법](http://macnews.tistory.com/3408)이 있지만 번거롭다고 생각하여 `/usr/bin/local`의 관련 파일 이름을 변경하였다.

<pre class="terminal">
mv /usr/local/bin/vim /usr/local/bin/vim8
mv /usr/local/bin/vimdiff /usr/local/bin/vimdiff8
mv /usr/local/bin/vimtutor /usr/local/bin/vimtutor8
ln -s /usr/local/bin/vim8 /usr/local/bin/vi8
</pre>

이제 `vi8`, `vim8`, `vimdiff8`, `vimtutor8`로 버전 8을 실행할 수 있다. 복구 모드로 들어가는 방법과 이 방법 중 어느 것이 좋을지는 아직 모르겠다. 짧게나마 정리하는 목적이기도 하다.

### 패스 변경

$PATH 경로 값에서 `/usr/bin/local`을 `/usr/bin`보다 앞에 위치하도록 변경하는 방법도 좋을 것 같다. 어찌보면 제일 간단한 방법인데 처음 이 포스트를 올렸을 때는 왠지 꺼림칙하였는데 트친인 [기계인간 (@John_Grib)](https://twitter.com/John_Grib)님이 자신은 그렇게 사용하고 있다고 하여 생각해보니 그게 애플의 루트리스 보안체계에도 적합한 것 같다. 사용자 추가/변경 내용이 시스템에 override되니 합리적인 것 같아서 최종적으로 경로값을 변경하였다.(`/etc/paths` 파일로 local이 앞에 있다) 혹시 나중에 문제가 생기면 그 때 업데이트하겠다. :smile: 

## 참고링크

* [Upgrading Vim on OS X – Prioritized.net](http://www.prioritized.net/blog/upgrading-vim-on-os-x)
* [download : vim online](http://www.vim.org/download.php)
* [MacOSX Vim - Browse Files at SourceForge.net](https://sourceforge.net/projects/macosxvim/files/)
* [Vim 8.0 Arrives With New Features — First Major Release In 10 Years](https://fossbytes.com/vim-8-0-released-how-to-install-new-features/)
* [How To Install Vim 8 On Ubuntu 16.04/16.10 Systems](http://sourcedigit.com/20798-vim-vi-improved-for-linux-ubuntu-how-to-install-vim-8-on-ubuntu-16-0416-10-systems/)


