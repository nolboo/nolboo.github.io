---
layout: post
title: "Sage를 사용하여 워드프레스 테마 개발을 현대화하기"
description: "Roots의 워드프레스 스타터 테마 Sage를 이용하여 HTML5, gulp, Bower, BootStrap을 이용하여 테마를 개발하는 현대적인 워크플로우를 배워본다."
category: blog
tags: [wordpress, stater, theme, sage, development, environment]
---

원문 : [Modernizing WordPress Theme Development with Sage](https://www.sitepoint.com/modernizing-wordpress-theme-development-with-sage/)

몇 년 전, [Roots, A HTML5 WordPress Theme Framework](https://www.sitepoint.com/roots-a-html5-wordpress-theme-framework/)란 기사를 발행했었다. 이제 Roots는 하나의 회사로 바뀌었고, Roots Theme framework을 [Sage](https://roots.io/sage/)와 [Bedrock](https://roots.io/bedrock/)이라 불리는 두 세트의 툴로 바꿨다.

여기서는 Sage에 둘러볼 수 있게 할 것이다. Sage는 HTML5 보일러파이트, gulp, Bower, 부트스트랩 프론트엔드 프레임워크를 사용한다. 먼저 각 툴에 대해 간단히 살펴보고, 설치와 프레임워크 커스터 마이징을 할 것이다. 마지막으로 기본 Sage 워크플로우로 갈 것이다.

![Sage Homepage](https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2016/03/1458234267Sage-1024x548.png)

## Tools

* **HTML5 Boilerplate** – 프론트엔드 템플릿
* **Gulp** – 프론트엔드 asset 최소화와 병합, 이미지 최적화, 테스트 돌리기와 같은 작업을 자동화하는 빌드 시스템 
* **Bower** – 프론트엔트 asset 패키지 관리자. jQuery나 Lodash 같은 라이브러리를 프로젝트로 당겨온다.
* **Browsersync** – 여러 디바이스에서 파일 변경과 인터랙션을 동기화
* **asset-builder** – 테마의 asset를 모아주고 같이 넣어준다.
* **wiredep** – 메인 테마 스타일시트에 Sass와 Less 의존성을 주입한다.
* **Bootstrap** – 반응형 웹사이트를 쉽게 만들 수 있는 프론트엔드 프레임워크

## Installation

워드프레스 테마 디렉토리로 가서 다음 명령을 준다. `theme-name`을 자신의 테마 이름으로 바꾸는 것을 잊지마라.

```shell
git clone https://github.com/roots/sage.git {theme-name}
```

깃이 설치되지 않았다면 [깃 저장소](https://github.com/roots/sage)에서 zip 파일을 내려받아 워드프레스 테마 디렉토리에 새 폴더를 만들고 압축을 푼 파일을 복사한다.

`wp-config.php`에 다음을 추가할 필요가 있다:

```php
define('WP_ENV', 'development');
```

워드프레스를 개발 환경으로 설정한다.

## Directory Structure

디렉토리 구조는 다른 워드프레스 테마와 꽤 많이 비슷하다. 테마의 루트에는 친숙하게 보이는 파일들이 있을 것이다:

* index.php
* functions.php
* 404.php
* search.php
* single.php
* page.php

유일한 차이점은 테마 설정과 유틸리티가 저장되는 `lib` 디렉토리를 가진 것이다. 프론트엔드 asset을 포함하는 것이 `functions.php`가 아닌 `assets.php`라는 것을 주목한다. 위젯, 메뉴의 등록, 테마 지원 추가는 `setup.php`에서 한다. 페이지 제목을 지정하는 것은 `titles.php`에서 한다.

또한, 나중에 하나의 `main.css`로 컴파일되는 `.scss` 파일들을 포함하는 `assets` 디렉토리가 있다. gulp로 `.scss` 파일을 병합하고 압축할 것이다. `lang` 디렉토리는 Sage 안에 사용된 텍스트를 번역하는 `sage.pot` 파일을 포함한다. 기본적으로 번역될 텍스트만 있고, 번역은 없다. 테마에서 다른 언어를 지원하려면 [sage-translations](https://github.com/roots/sage-translations) 저장소를 점검한다. 원하는 언어를 `sage.pot` 파일로 복사한다. 번역하려는 다른 텍스트를 사용하려면 이 파일에 추가할 수도 있다.

마지막으로, 워드프레스 테마에서 보통 가지고 있는 모든 템플릿이 있는 `templates` 디렉토리가 있다. 유일한 차이점은 테마의 접근성을 향상하는 몇 가지 기본적인 ARIA 역할을 가지는 HTML5 Boilerplate에 기반을 두는 템플릿이라는 것이다.

## Customization

이제 자신의 필요에 맞게 Sage를 커스터마이징하자. `lib/setup.php` 파일을 열고 몇 가지를 커스터마이징할 수 있다:

### Title Tag

`title-tag`로 웹페이지의 [title tag](https://codex.wordpress.org/Title_Tag)를 변경할 수 있다. 워드프레스 4.1부터 추가된 기능이며, 다음을 더하거나 빼서 기능을 토글할 수 있다.

```php
add_theme_support('title-tag')
```

### Navigation Menus

기본적으로 Sage는 내비게이션 메뉴에 primary 내비게이션을 추가한다. 다음과 같이 추가할 수 있다.

```php
register_nav_menus([
  'primary_navigation' => __('Primary Navigation', 'sage')
]);
```

### Post Thumbnails

[Post Thumbnails](https://codex.wordpress.org/Post_Thumbnails) - 또는 워드프레스 3에서 Featured Image로 더 잘 알려진 - 는 포스트, 페이지, 커스텀 포스트 타입을 대표하는 이미지이다. 다음을 추가하여 이 기능을 토글할 수 있다:

```php
add_theme_support('post-thumbnails')
```

### Post Formats

기본적으로 가능한 포스트 타입이다. 필요에 따라 배열에 항목을 더하거나 뺄 수 있다.

```php
add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
```

### HTML5 Markup

HTML5 마크업에 대한 지원을 추가할 수 있다. 기본적으로 caption, comment form, comment list는 허용한다.

```php
add_theme_support('html5', ['caption', 'comment-form', 'comment-list']);
```

### Editor Stylesheet

워드프레스에 사용된 TinyMCE 에디터를 커스터마이징하는 스타일시트의 경로를 설정할 수 있다.

```php
add_editor_style(Assets\asset_path('styles/editor-style.css'));
```

### Register Sidebars

마지막으로, `widgets_init`에 등록할 사이드바의 코드를 넣을 수 있다. 기본적으로 Sage는 두 개의 사이드바가 있다: primary, footer

```php
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');
```

## Workflow

이제 워크플로우로 넘어가자. 이 섹션에서는 Sage로 워드프레스를 개발할 때 앞서 언급한 툴을 사용하는 법을 배울 것이다.

먼저, 개발 머신에 툴을 설치하자. 사용할 대부분의 툴의 주요 의존성은 Node.js이다. 다행히 설치 툴로 쉽게 설치할 수 있다. 플랫폼에 맞는 [설치 툴을 다운로드](https://nodejs.org/en/download/)하여 지시에 따라 'Next'만 클릭하면 설치될 것이다. 이제 터미널에서 `npm install` 명령으로 나머지 툴을 설치할 수 있다.

```shell
npm install gulp bower browser-sync asset-builder wiredep --save
```

### Using Bower

Bower를 사용할 때 `search`, `install`, `list`, `uninstall` 명령을 기억해야 한다. 첫 번째는 `search` 명령어다. 설치하려는 패키지의 이름이 확실하지 않을 때 사용한다. 정확할 필요도 없다. 예를 들어 `jQuery`를 검색할 때 `query`만 사용하여 이름에 문자열이 있는 모든 패키지 목록을 불러온다. jQuery도 같이 나열될 것이다.

```shell
bower search query
```

패키지 명을 이미 알고 있다면 `install` 명령으로 설치할 수 있다.

```shell
bower install jquery
```

`bower_components` 디렉토리에 jQuery가 설치된다. 다른 곳에 설치하고 싶다면 워드프레스 테마 루트의 `.bowerrc` 파일을 편집하여 `directory`에서 설치 경로를 변경한다.

다음은 `list` 명령어다. Bower를 사용하여 설치한 패키지 목록을 트리 형식으로 보여준다. 특정 패키지가 다른 패키지에 의존하고 있는 것도 보여준다.

마지막으로 `uninstall` 명령어를 프로젝트에서 Bower 패키지를 제거할 수 있다. 예를 들어 jQuery를 더는 원하지 않으면:

```shell
bower uninstall jquery
```

### Using gulp

gulp를 사용하려면 먼저 Sage에 사용된 gulp 플러그인을 설치해야 한다:

```shell
npm install gulp-autoprefixer gulp-changed gulp-imagemin gulp-less --save
```

다 설치하면, `gulp` 명령을 사용하여 프로젝트 asset을 컴파일하고 옵티마이즈할 수 있다. `gulp` 명령을 실행하면 다음 출력을 보여준다:

```shell
[14:33:33] Using gulpfile ~/www/sage/htdocs/wp-content/themes/my-theme/gulpfile.js
[14:33:33] Starting 'clean'...
[14:33:33] Finished 'clean' after 11 ms
[14:33:33] Starting 'default'...
[14:33:33] Starting 'build'...
[14:33:33] Starting 'wiredep'...
[14:33:33] Finished 'default' after 149 ms
[14:33:33] Finished 'wiredep' after 180 ms
[14:33:33] Starting 'styles'...
[14:33:37] Finished 'styles' after 3.98 s
[14:33:37] Starting 'jshint'...
[14:33:38] Finished 'jshint' after 176 ms
[14:33:38] Starting 'scripts'...
[14:33:40] Finished 'scripts' after 2.18 s
[14:33:40] Starting 'fonts'...
[14:33:40] Starting 'images'...
[14:33:40] gulp-imagemin: Minified 0 images
[14:33:40] Finished 'images' after 5.98 ms
[14:33:40] Finished 'fonts' after 49 ms
[14:33:40] Finished 'build' after 6.58 s
```

첫 줄에서 `gulpfile.js`를 사용하는 것을 볼 수 있다. 이 파일은 Gulp가 수행할 모든 명령을 갖고 있다. 첫 번째 작업은 `clean`으로 `dist` 디렉토리 안의 모든 파일을 지운다. 이 디렉토리에는 컴파일되고 옵티마이징된 모든 파일을 저장한다. 다음으로 `default` 작업이 호출된다. 기본적으로 이것은 `build` 작업을 호출하기만 한다. 그러면 `build` 작업은 스타일, 스크립트, 폰트, 이미지 작업을 호출한다.

이 시점에서 `gulpfile.js`를 열어보자. 첫 번째는 'styles'이다. 이것은 'wiredep'에 의존하며, `dist/styles` 디렉토리 안의 `main.css` 파일로 Less와 Sass Bower 의존성을 주입할 수 있다. 그리고 나면 `asset/styles` 디렉토리 안에 있는 Sass와 Less 파일을 컴파일한다.

```javascript
gulp.task('styles', ['wiredep'], function() {
  var merged = merge();
  manifest.forEachDependency('css', function(dep) {
    var cssTasksInstance = cssTasks(dep.name);
    if (!enabled.failStyleTask) {
      cssTasksInstance.on('error', function(err) {
        console.error(err.message);
        this.emit('end');
      });
    }
    merged.add(gulp.src(dep.globs, {base: 'styles'})
      .pipe(cssTasksInstance));
  });
  return merged
    .pipe(writeToManifest('styles'));
});
```

특정 페이지의 CSS를 추가하려면, `asset` 디렉토리의 루트에서 찾을 수 있는 `manifest.json` 파일을 통해 할 수 있다.

`other-page.css`를 추가한 예제이다. `files` 속성 안에 경로의 배열을 설정하여 소스로 사용할 파일을 지정할 수 있다. 이 경우엔 `styles` 디렉토리 안에 `other-page.less`를 사용하기만 했다.

```json
{
  "dependencies": {
    "main.js": {
      "files": [
        "scripts/main.js"
      ],
      "main": true
    },
    "main.css": {
      "files": [
        "styles/main.scss"
      ],
      "main": true
    },
    "editor-style.css": {
      "files": [
        "styles/editor-style.scss"
      ]
    },
    "other-page.css": {
      "files": [
        "styles/other-page.less"
      ]
    },
    "modernizr.js": {
      "bower": ["modernizr"]
    }
  },
  "config": {
    "devUrl": "http://example.dev"
  }
}
```

다음은 'scripts' 작업이다. 이것은 자바스크립트 코드의 품질을 체크하는 'jshint' 작업에 의존한다.

```javascript
gulp.task('scripts', ['jshint'], function() {
  var merged = merge();
  manifest.forEachDependency('js', function(dep) {
    merged.add(
      gulp.src(dep.globs, {base: 'scripts'})
        .pipe(jsTasks(dep.name))
    );
  });
  return merged
    .pipe(writeToManifest('scripts'));
});
```

테마의 루트 디렉토리에 있는 `.jshintrc` 파일을 편집하여 JSHint를 커스터마이징할 수 있다. 이미 Sage는 기본적으로 몇가지 옵션을 추가했으며, [모든 가능한 옵션](http://jshint.com/docs/options/) 목록을 확실히 체크하여 자신의 JSHint를 커스터마이징해야 한다.

```shell
{
  "bitwise": true,
  "browser": true,
  "curly": true,
  "eqeqeq": true,
  "eqnull": true,
  "esnext": true,
  "immed": true,
  "jquery": true,
  "latedef": true,
  "newcap": true,
  "noarg": true,
  "node": true,
  "strict": false
}
```

코드 품질을 체크한 후, 'scripts' 작업은 Bower 의존성 안에 있는 모든 자바스크립트 파일을 `scripts/main.js`로 병합한다. 마지막으로 uglify.js로 병합된 스크립트를 최소화한다. `manifest.json`을 통해 기본적인 행동을 커스터마이징할 수 있다는 것을 주목하라. 예로, 모든 Bower 의존성 파일을 main script로 병합하기를 원하지 않는다면, `main.js`의 `main` 속성을 제거할 수 있다. `bower` 속성을 추가하여 스크립트가 의존할 Bower 컴포넌트의 배열을 지정할 수 있다. 아래 예제에선 의존성으로 jQuery를 설정했다.

```json
"main.js": {
  "files": [
    "scripts/main.js"
  ],
  "main": true, //remove this line
  "bower": ["jquery"]
},
```

다음은 'fonts' 작업이다. 여기서 하는 것은 `assets/fonts` 디렉토리 안의 폰트는 물론 Bower 의존성으로 사용되는 모든 폰트를 `dist/fonts` 디렉토리로 모두 넣는다. 이 작업은 디렉토리 구조를 편평하게 하는 `gulp-flatten`을 사용한다. `dist/fonts` 디렉토리 안에서만 폰트를 찾을 수 있다는 의미이다. 폰트를 링크할 때 여러 디렉토리를 지정할 필요가 없다.

```json
gulp.task('fonts', function() {
  return gulp.src(globs.fonts)
    .pipe(flatten())
    .pipe(gulp.dest(path.dist + 'fonts'))
    .pipe(browserSync.stream());
});
```

마지막으론, 'images' 작업이다. 손실 없는 압축을 사용하여 `assets/images` 디렉토리 안의 이미지를 압축한다. 옵티마이즈된 이미지는 `dist/images`에 저장된다.

```javascript
gulp.task('images', function() {
  return gulp.src(globs.images)
    .pipe(imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}]
    }))
    .pipe(gulp.dest(path.dist + 'images'))
    .pipe(browserSync.stream());
});
```

`gulp` 명령 외에 `gulp watch` 명령을 실행할 수 있다. asset에 약간의 변경이 만들어지면, 방금 만든 변경을 브라우저가 반영하게 한다. 이것은 환경설정에 지정한 devUrl에 프락시 URL을 만들어서 작동한다. 페이지에 변경한 부분을 반영하는 스크립트를 포함하고 있다.

```
http://localhost:3000/wordpress/
```

홈 네트워크와 연결된 또 다른 디바이스를 동시에 테스트하기를 원한다면, 컴퓨터의 로컬 IP 주소를 지정하여 다른 디바이스의 브라우저로 접근할 수 있다. URL이 다음과 비슷한 것이 되어야 한다.

```
http://192.168.xxx.xxx:3000/wordpress/
```

### Speeding Things Up

내가 Sage를 테스트하는 동안, `gulp watch`가 모든 작업을 끝내는 데에 10초 정도 걸렸다. 변화를 즉시 볼 수 없어서 좋지 않았다. 그 이유로 `gulpfile.js`에 몇 가지 변화를 주어야 했다. 첫 번째는 `enabled` 변수다. `gulp watch` 명령을 사용할 때 옵션을 지정하여 특정 작업을 키거나 끌 수 있다.

```javascript
var enabled = {
  // Enable static asset revisioning when `--production`
  rev: argv.production,
  // Disable source maps when `--production`
  maps: argv.maps,
  // Fail styles task on error when `--production`
  failStyleTask: argv.production,
  // minify only when `--minify` is specified
  minify: argv.minify
};
```

위의 코드에서 소스맵과 디폴트로 된 파일 최소화를 껐다. **이 작업을 사용하려면 옵션으로 지정하여 사용하면 된다** 역자 - 여기서부터 에러가 난다. 아무리 검색해도 답을 얻을 수가 없어서 전부 테스트하기 전에 번역 내용을 온라인 올린다ㅠㅠ 아래를 실행하면:

```shell
gulp watch --minify --maps
~/Sites/example.com/site/web/app/themes/sage/gulpfile.js:66
  minify: argv.minify
  ^^^^^^

SyntaxError: Unexpected identifier
    at exports.runInThisContext (vm.js:53:16)
    at Module._compile (module.js:387:25)
    at Object.Module._extensions..js (module.js:422:10)
    at Module.load (module.js:357:32)
    at Function.Module._load (module.js:314:12)
    at Module.require (module.js:367:17)
    at require (internal/module.js:16:19)
    at Liftoff.handleArguments (/usr/local/lib/node_modules/gulp/bin/gulp.js:116:3)
    at Liftoff.<anonymous> (/usr/local/lib/node_modules/gulp/node_modules/liftoff/index.js:181:16)
    at module.exports (/usr/local/lib/node_modules/gulp/node_modules/liftoff/node_modules/flagged-respawn/index.js:17:3)
```

> **위와 같은 에러가 난다. 걸프 도사님들 도와주세요!!!!!!**


이제 `cssTasks`와 `jsTasks`를 변경해야 하는데, 우리가 만든 `enabled` 변수를 이용한다. 첫번째는 소스맵인데, `gulpif`를 사용해서 소스맵이 켜져있는지 체크하고 켜져있을 때만 함수를 부른다.

```javascript
.pipe(function() {
  return gulpif(enabled.maps, sourcemaps.init());
})
```

다음은 'minify' 작업이다.

```javascript
.pipe(function(){
  return gulpif(enabled.minify, minifyCss({
    advanced: false,
    rebase: false
  }));
})
```

`cssTasks`가 다음과 같아야 한다:

```javascript
var cssTasks = function(filename) {
  return lazypipe()
    .pipe(function() {
      return gulpif(!enabled.failStyleTask, plumber());
    })
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.init());
    })
    .pipe(function() {
      return gulpif('*.less', less());
    })
    .pipe(function() {
      return gulpif('*.scss', sass({
        outputStyle: 'nested', // libsass doesn't support expanded yet
        precision: 10,
        includePaths: ['.'],
        errLogToConsole: !enabled.failStyleTask
      }));
    })
    .pipe(concat, filename)
    .pipe(autoprefixer, {
      browsers: [
        'last 2 versions',
        'ie 8',
        'ie 9',
        'android 2.3',
        'android 4',
        'opera 12'
      ]
    })
    .pipe(function(){
      return gulpif(enabled.minify, minifyCss({
        advanced: false,
        rebase: false
      }));
    })
    .pipe(function() {
      return gulpif(enabled.rev, rev());
    })
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.write('.'));
    })();
};
```

다음은 `jsTasks`, 스크립트를 최소화하는 함수를 수행하기 전에 minify가 켜져있는지 먼저 체크하도록 'uglify' 작업을 변경한다:

```javascript
.pipe(function(){
  return gulpif(enabled.minify, uglify())
})
```

`jsTasks`가 다음과 같아야 한다:

```javascript
var jsTasks = function(filename) {
  return lazypipe()
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.init());
    })
    .pipe(concat, filename)
    .pipe(function(){
      return gulpif(enabled.minify, uglify())
    })
    .pipe(function() {
      return gulpif(enabled.rev, rev());
    })
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.write('.'));
    })();
};
```

## Conclusion

이 튜토리얼에서 워드프레스 테마를 개발하는 프로세스를 현대화하기 위해 Sage와 작업하는 법을 배웠다. Bower, gulp, Browsersync와 같은 툴을 사용해서 개발 속도를 올리는 법을 배웠다.
