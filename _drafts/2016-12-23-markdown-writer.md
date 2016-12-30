---
layout: post
title: markdown writer
date: '2016-12-23 18:49'
---

## 개요

깃허브에서 지킬로 블로그를 호스팅하고 있고, 마크다운으로 글을 쓰고 포스팅하고 있다. Atom보다는 Vim을 에디터로 사용하고 있다. 오늘 괜찮은 아톰 패키지를 만나서 정리한다.

* [markdown-writer](https://atom.io/packages/markdown-writer)

제일 첫 줄에 이런 말이 나온다.

**아톰을 마크다운/아스키독 에디터보다 훨씬 낫게 만들어 준다. 지킬, 옥토프레스, 헥소와 같은 정적 블로깅 엔진과도 잘 작동한다.**

apm install markdown-writer

Go to Settings (cmd-,) -> Packages -> markdown-writer -> Settings -> Set siteLocalDir and related.

## 키보드

To add the original default keymaps, run command (`cmd + shift + p`), enter `Markdown Writer: Create Default Keymaps`.

`keymap.cson`에 다음 내용이 추가된다.

```
".platform-darwin atom-text-editor:not([mini])":
  "shift-cmd-K": "markdown-writer:insert-link"
  "shift-cmd-I": "markdown-writer:insert-image"
  "cmd-i":       "markdown-writer:toggle-italic-text"
  "cmd-b":       "markdown-writer:toggle-bold-text"
  "cmd-'":       "markdown-writer:toggle-code-text"
  "cmd-k":       "markdown-writer:toggle-keystroke-text"
  "cmd-h":       "markdown-writer:toggle-strikethrough-text"
  'cmd->':       "markdown-writer:toggle-blockquote"
  'cmd-"':       "markdown-writer:toggle-codeblock-text"
  "ctrl-alt-1":  "markdown-writer:toggle-h1"
  "ctrl-alt-2":  "markdown-writer:toggle-h2"
  "ctrl-alt-3":  "markdown-writer:toggle-h3"
  "ctrl-alt-4":  "markdown-writer:toggle-h4"
  "ctrl-alt-5":  "markdown-writer:toggle-h5"
  "shift-cmd-O": "markdown-writer:toggle-ol"
  "shift-cmd-U": "markdown-writer:toggle-ul"
  "cmd-j cmd-p": "markdown-writer:jump-to-previous-heading"
  "cmd-j cmd-n": "markdown-writer:jump-to-next-heading"
  "cmd-j cmd-d": "markdown-writer:jump-to-reference-definition"
  "cmd-j cmd-t": "markdown-writer:jump-to-next-table-cell"
```

![이미지 링크](https://i.github-camo.com/216ebba971ab38d17d6eabdaf236d042a55b35b8/687474703a2f2f692e696d6775722e636f6d2f7339656b4d6e732e676966)

![새 포스트](http://i.imgur.com/BwntxhB.gif)

![참조 링크](http://i.imgur.com/L67TqyF.gif)

![참조 링크 지우기](http://i.imgur.com/TglzeJV.gif)

[tool-bar-markdown-writer](https://atom.io/packages/tool-bar-markdown-writer) [tool-bar](https://atom.io/packages/tool-bar) 아이콘 크기 12로

화면 캡처


[Atom 을 마크다운(Markdown) 에디터로 사용하기 | Writer, IT Blog](http://futurecreator.github.io/2016/06/14/atom-as-markdown-editor/)

---


[Quick Start · zhuochun/md-writer Wiki](https://github.com/zhuochun/md-writer/wiki/Quick-Start)
[vim-mode-plus](https://atom.io/packages/vim-mode-plus)
[Why Atom Can’t Replace Vim – Medium](https://medium.com/@mkozlows/why-atom-cant-replace-vim-433852f4b4d1#.jek1sufh1)
[Learn Vim, Use Atom - Coding Creativity at Revelry](http://revelry.co/learn-vim-use-atom/)
[edsko.net - Switching from Vim to Atom<br><i>(A Haskeller's Perspective)</i>](http://www.edsko.net/2015/03/07/vim-to-atom/)
[Vim to Atom - YouTube](https://www.youtube.com/watch?v=hCml8r_odN4)
[Getting started with the Atom Editor (and tips for switching from Vim)](http://blog.blakesimpson.co.uk/read/84-getting-started-with-the-atom-editor-and-tips-for-switching-from-vim-)
[Best Text Editor? Atom vs Sublime vs Visual Studio Code vs Vim | Codementor](https://www.codementor.io/mattgoldspink/tutorials/best-text-editor-atom-sublime-vim-visual-studio-code-du10872i7)
