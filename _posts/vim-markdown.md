
[plasticboy/vim-markdown: Markdown Vim Mode](https://github.com/plasticboy/vim-markdown/)

Vundle을 사용해서 `~/.vimrc` 파일에 추가

```vim
Plugin 'godlygeek/tabular'
Plugin 'plasticboy/vim-markdown'
```

vim에서

:so ~/.vimrc
:PluginInstall

플러그인을 인스톨한다.

다른 설치 방법은 [공식문서](https://github.com/plasticboy/vim-markdown/#installation)를 참조한다.

마크다운 문서가 처음 열릴 때 문단이 접히는 것이 싫고, YAML 프론트매터를 하일라이트하고


```vim
let g:vim_markdown_folding_disabled = 1
let g:vim_markdown_frontmatter = 1
```

	Enable TOC window auto-fit

	Allow for the TOC window to auto-fit when it's possible for it to shrink. It never increases its default size (half screen), it only shrinks.

	let g:vim_markdown_toc_autofit = 1

gx로 커서 위치 줄의 링크를 열 수 있다. 줄에 여러 링크가 있으면 동작하지 않으며, [vim-open-url](https://github.com/henrik/vim-open-url) 플러그인을 이용하면 된다.

ge: open the link under the cursor in Vim for editing. Useful for relative markdown links. <Plug>Markdown_EditUrlUnderCursor

]]: go to next header. <Plug>Markdown_MoveToNextHeader
[[: go to previous header. Contrast with ]c. <Plug>Markdown_MoveToPreviousHeader
][: go to next sibling header if any. <Plug>Markdown_MoveToNextSiblingHeader
[]: go to previous sibling header if any. <Plug>Markdown_MoveToPreviousSiblingHeader
]c: go to Current header. <Plug>Markdown_MoveToCurHeader
]u: go to parent header (Up). <Plug>Markdown_MoveToParentHeader

map 설정으로 키를 변경할 수도 있다.

## Toc

:Toc: create a quickfix vertical window navigable table of contents with the headers.
Hit <Enter> on a line to jump to the corresponding line of the markdown file.

:Toch: Same as :Toc but in an horizontal window.
:Toct: Same as :Toc but in a new tab.
:Tocv: Same as :Toc for symmetry with :Toch and :Tocv

## 미리보기

[junegunn/vim-xmark: Markdown preview on OS X](https://github.com/junegunn/vim-xmark)

```vim
Plug 'junegunn/vim-xmark', { 'do': 'make' }
```

[기계인간 John Grib on Twitter: "@n0lb00 혹시 VIM으로 마크다운 편집을 하신다면 xmark 플러그인을 써보세요. https://t.co/eJhbqWCzzw 화면 한쪽에 자동으로 웹브라우저에 github 스타일의 마크다운 뷰를 열어주고 저장할 때마다 뷰를 갱신해 줍니다."](https://twitter.com/John_Grib/status/777854650607280128) 소개

`:w`로 저장할 때마다 화면을 갱신한다.

    [Markdown syntax - Vim Awesome](http://vimawesome.com/plugin/markdown-syntax)

[vim-airline/vim-airline: lean & mean status/tabline for vim that's light as air](https://github.com/vim-airline/vim-airline)

[vim-pencil - Vim Awesome](http://vimawesome.com/plugin/vim-pencil)
    [vim-colors-pencil - Vim Awesome](http://vimawesome.com/plugin/vim-colors-pencil-the-story-of-us)

[mmai/vim-markdown-wiki: Vim plugin wich eases links manipulation and navigation in markdown pages](https://github.com/mmai/vim-markdown-wiki) 작동하지 않아 안타깝다.

---

[vim-markdown - Vim Awesome](http://vimawesome.com/plugin/vim-markdown-sad-beautiful-tragic)
