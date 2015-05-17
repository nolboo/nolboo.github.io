---
layout: post
title: "코드캐더미로 배우는 레일즈 기초 1부"
description: "코드캐더미에서 새롭게 레일즈 무료 강좌를 출시했다. 내용이 친절하고 자세하다. 브라우저 환경이 아닌 맥을 기준을 더 자세하게 풀어보았다."
category: blog
tags: [codecademy, course, rails, ruby]
---

코드캐더미 강좌는 볼 때마다 친절하게 잘 짜여져 있다는 생각이 든다. 레일즈 기초 강좌도 앞서 포스팅한 코세라 강좌인 [루비 온 레일즈로 블로그 만들기](http://nolboo.github.io/blog/2015/05/05/web-application-architecture/)를 들을 때 이해하지 못한(들을 때는 이해한 듯 했지만;;) 부분까지 잘 설명해준다. 이에 필받아서 [Learn Ruby on Rails | Codecademy](http://www.codecademy.com/learn/learn-rails) 강좌를 오프라인에서도 따라할 수 있게 좀 더 자세하게 풀어서 설명한다.

루비를 모른다면 [Ruby | Codecademy](http://www.codecademy.com/tracks/ruby)를 먼저 하길 권한다.

코드캐더미에서는 모든 것이 웹브라우저에서 인터렉티브하게 진행되기 때문에 레일즈의 설치와 기본 디렉토리 구조는 [루비 온 레일즈로 블로그 만들기](http://nolboo.github.io/blog/2015/05/05/web-application-architecture/)의 "루비온 레일즈 설치" 부분을 참조하는 것으로 대치한다.

## MySite

<pre class="terminal">
    rails new MySite
    cd MySite
    bundle install
    rails server
</pre>

웹브라우저 주소창에 `http://localhost:3000`을 입력하면 레일즈 앱을 볼 수 있다.

- `rails new` 명령은 모든 레일즈 프로젝트의 시작점이다.
- `bundle install` 명령은 새로운 레일즈 앱에 필요한 모든 소프트웨어 패키지를 설치한다. 소프트웨어 패키지를 gem이라고 부르며, `Gemfile` 파일 안에 나열된다.
- `rails server` 명령은 레일즈 개발 서버를 시작한다. 이 개발 서버는 `WEBrick`이다.

### request/response cycle

`http://localhost:3000`을 방문하면 어떠한 일이 발생하는가?

1. 브라우저가 `http://localhost:3000` URL에 요청`request`한다.
2. 요청은 `config/routes.rb` 안의 레일즈 라우터를 hit한다. 라우터는 URL을 인식하고 컨트롤러에 요청을 보낸다.
3. 컨트롤러가 요청을 받고 처리한다.
4. 컨트롤러가 뷰`view`에 요청을 넘긴다.
5. 뷰는 HTML 페이지를 렌더링한다.
6. 컨트롤러가 사용자가 보고 있는 브라우저에 HTML을 다시 보낸다.

request/response cycle을 보려면 레일즈앱을 만드는 세 부분이 필요하다: 컨트롤러, 라우트, 뷰

먼저 컨트롤러를 만들자.

### Controller

<pre class="terminal">
    rails generate controller Pages
</pre>

위의 명령은 `Pages`라는 새로운 컨트롤러를 제너레이트하며, `app/controllers/pages_controller.rb` 파일을 만들어 준다.

`app/controllers/pages_controller.rb`을 열고 `PagesController` 클래스 안에 `home` 매서드를 추가한다.

```ruby
def home
end
```

레일즈에서 매서드는 컨트롤러 액션`action`으로 불리기도 한다. `Pages` 컨트롤러에 `home` 액션을 추가한 것이다.

### Route

이제 컨트롤러를 가졌으니, request/response cycle의 두 번째 부분으로 넘어가서 라우트를 만들자.
`config/routes.rb` 파일을 열고 다음을 추가한다:

```ruby
get 'welcome' => 'pages#home'
```

이제 `http://localhost:3000/welcome` 방문했을 때 위의 라우트가 레일즈에게 `Pages` 컨트롤러의 `home` 액션으로 이 요청을 보내라고 말한다.

### View

컨트롤러와 라우트를 가졌으니, request/response cycle의 세 번째 부분으로 넘어가서 뷰를 만들자. `app/views/pages/home.html.erb`을 만들고 다음 HTML을 입력한다. 자신의 이름으로 채워라.

```html
<div class="main">
  <div class="container">
    <h1>Hello my name is Nolboo Kim</h1>
    <p>I make Rails apps.</p>
  </div>
</div>
```

`app/assets/stylesheets/pages.css.scss`에 CSS를 입력할 수 있다. 파일명을 `pages.scss`로 하여도 결과는 같다.

* 미리 준비된 [CSS](https://github.com/nolboo/rails-codecademy-static/blob/master/app/assets/stylesheets/pages.scss)를 입력하여야 제대로 된 페이지를 볼 수 있다.

### 워크플로우 정리

지금까지가 [Request-Response Cycle](http://www.codecademy.com/articles/request-response-cycle-static)를 가이드로 한, 레일즈 앱을 만들때 일반적인 워크플로우이다.

1. 새 레일즈 앱을 제너레이트한다.
2. 컨트롤러를 제너레이트하고 액션을 추가한다.
3. 라우트를 만들고 컨트롤러 액션에 URL을 매핑한다.
4. HTML, CSS로 뷰를 만든다.
5. 로컬 웹서버를 실행하고 브라우저에서 앱을 미리보기한다.

정적`static` 페이지를 가진 레일즈앱을 만들었으며, 컨트롤러, 라우트, 뷰를 사용하였다. 정적 페이지를 가진 레이즈 앱은 모든 사용자가 같은 화면을 보게 된다. 

* 전체 소스를 [깃허브 저장소](https://github.com/nolboo/rails-codecademy-static)에 올려놓았다.

## 메신저 앱

이제 데이타베이스와 함께 정보를 저장하는 앱을 만들어 보자. 데이타베이스에 맞는 Request-Response Cycle은 다음과 같다. 다이어그램은 [Request-Response Cycle II](http://www.codecademy.com/articles/request-response-cycle-dynamic)을 참조한다.

1. 브라우저에 `http://localhost:3000/welcome`를 입력하면 브라우저가 `/welcome` URL을 위한 요청을 만든다.
2. 요청은 레일즈 라우터를 hit한다.
3. 라우터는 요청을 핸들링하기위해 그 URL을 컨트롤러 액션에 매핑한다.
4. 컨트롤러 액션은 요청을 받고, 데이터베이스에서 데이터를 불러오도록 모델`model`에게 요청한다.
5. 모델은 컨트롤러 액션에게 데이터를 리턴한다.
6. 컨트롤러 액션은 뷰에 데이터를 넘긴다.
7. 뷰가 HTML 페이지를 렌더링한다.
8. 컨트롤러서 HTML을 브라우저에게 보낸다.

<pre class="terminal">
    rails new MessengerApp
    cd MessengerApp
    bundle install
    rails server
</pre>

MessengerApp이라는 레일즈 앱을 만들었다. 

[Request-Response Cycle II](http://www.codecademy.com/articles/request-response-cycle-dynamic)를 보라. 레일즈을 만드는 네 부분이 필요하다 - 모델, 라우트, 컨트롤러, 뷰

### Model

모델을 만들자. 터미널에서 다음 명령어로 `Message`라는 새로운 모델을 제너레이트한다.

<pre class="terminal">
    rails generate model Message
</pre>

이러면 레일즈는 두 개의 파일을 만든다.

1. `app/models/message.rb`라는 모델 파일. 데이터베이스의 테이블을 기술한다.
2. `db/migrate/`안의 마이그레이션 파일. 마이그레이션은 데이터베이스를 업데이트하는 방법이다.
<br />

#### 마이그레이션

메시지 테이블을 위해 `db/migrate/` 안의 마이그레이션 파일을 연다. 마이그레이션 파일명은 생성일시  timestamp로 시작된다. `change` 매서드 안의 line4에 다음을 추가한다:

```ruby
    t.text :content
```

`change` 메서드는 데이터베스에 무엇을 변경할 것인가를 레일즈에게 말해준다. 여기서는 데이터베이스에 메시지를 저장할 새로운 테이블을 만들기 위해 `create_table`을 이용한다. 

`create_table` 안에 `t.text :content`추가한 것은 메시지 테이블 안에 `content`라는 텍스트 컬럼을 만든 것이다.

마지막 줄 `t.timestamps`는 메시지 테이블에 `create_at`과 `update_at`이라는 두개의 컬럼을 만드는 레일즈 명령어이다. 이 컬럼들은 메시지가 만들어지고 업데이트될 때 자동으로 설정된다.

<pre class="terminal">
    rake db:migrate
</pre>

`rake db:migrate` 명령어는 새로운 메시지 데이터 모델을 데이터베이스에 업데이트한다.

`rake db:seed` 명령어는 `db/seeds.rb`로부터 샘플 데이터를 공급`seed`해준다. 먼저 `db/seeds.rb`에 샘플 데이터를 다음과 같이 데이터를 추가한다:

```ruby
m1 = Message.create(content: "We're at the beach so you should meet us here! I make a mean sandcastle. :)")

m2 = Message.create(content: "Let's meet there!")
```

입력된 후의 모습은 [`db/seeds.rb`](https://github.com/nolboo/rails-codecademy-MessengerApp/blob/d2e00afb030d938230f60bd873ed78190922f757/db/seeds.rb)에서 확인할 수 있다.

다음 명령어로 샘플 데이터를 seed한다:

<pre class="terminal">
    rake db:seed
</pre>

### Controller

이제 모델을 가졌으니 request/response cycle의 두번째와 세번째 부분으로 넘어가서 컨트롤러와 라우트를 만들자.

<pre class="terminal">
    rails generate controller Messages
</pre>

`config/routes.rb` 파일을 열고 다음을 추가하여 `/messages` URL을 Messages 컨트롤러의 `index` 액션에 매핑하는 라우트를 만든다:

```ruby
get '/messages' => 'messages#index'
```

`app/controllers/messages_controller.rb`에 `index` 액션을 추가한다:

```ruby
def index
    @messages = Message.all
end
```

Messages 컨트롤러의 액션명을 `index`로 한 이유는? [Standard Controller Actions](http://www.codecademy.com/articles/standard-controller-actions)를 참조하라. 레일즈는 데이터를 일반적으로 조작하기 위한 7가지의 표준 컨트롤러 액션을 제공한다.(`index`, `show`, `new`, `create`, `edit`, `update`, `destroy`) 여기서는 모든 메시지의 목록을 보여주길 원해서 `index` 액션을 사용했다.

이제 사용자가 `http://localhost:3000/messages`를 방문하면 라우트 파일은 이 요청을 Messages 컨트롤러의 `index` 액션으로 매핑한다. `index` 액션은 데이터베이스의 모든 메시지를 가져와 `@messages` 변수에 저장한다.

### View

`@messages` 변수는 뷰로 넘겨지고 뷰는 각각의 메시지를 보여줘야 한다.

`app/views/messages/index.html.erb`를 만들고, 다음을 입력한다:

```html
<div class="header">
  <div class="container">
    <img src="http://s3.amazonaws.com/codecademy-content/courses/learn-rails/img/logo-1m.svg">
    <h1>Messenger</h1>
  </div>
</div>

<div class="messages">
  <div class="container">

    <% @messages.each do |message| %> 
        <div class="message"> 
          <p class="content"><%= message.content %></p> 
          <p class="time"><%= message.created_at %></p> 
        </div> 
    <% end %>
    
  </div>
</div>
```

`index.html.erb`은 일종의 웹 템플릿`template`이다. 웹 템플릿은 변수와 컨트롤 플로우 선언을 포함하는 HTML 파일이다. 각 메시지를 반복해서 같은 HTML을 쓰는 대신에 데이터베이스에서 데이터를 루핑하여 보여주기 위해 웹 템플릿을 사용할 수 있다.

1. `<% @messages.each do |message| %>`는 `@messages` 배열의 각각의 메시지를 반복하여 실행한다. 우린 Messages 컨트롤러의 `index` 액션에서 `@messages`를 만들었었다.
2. 각각의 메시지에 대하여, 메시지 내용와 만들어진 시간을 보여주기 위해 `<%= message.content %>`와 `<%= message.created_at %>`를 사용했다.

스타일링을 위해서 [`/app/assets/stylesheets/messages.scss`](https://github.com/nolboo/rails-codecademy-MessengerApp/blob/d2e00afb030d938230f60bd873ed78190922f757/app/assets/stylesheets/messages.scss)를 보고 CSS 코드를 입력한다.

이제 `rails server`를 실행하고 `http://localhost:3000/messages`를 방문하면 메시지앱을 볼 수 있다.

![메시지앱 실행화면](https://c2.staticflickr.com/6/5348/17405198039_6ca59aa12a_b.jpg)

### Route

지금까지 메시지를 데이터베이스에서 로드하고 뷰에서 보여주었다. 그럼 어떻게 새로운 메시지를 만들고 그것을 데이터베이스에 저장할까? [Standard Controller Actions](http://www.codecademy.com/articles/standard-controller-actions)를 참조하면, `new`와 `create` 액션을 사용할 필요가 있다.

라우트 파일 `config/routes.rb`에 `message/new` 요청을 Message 컨트롤러의 `new` 액션과 매핑하는 라우트를 만들어 준다:

```ruby
get '/messages/new' => 'messages#new'
```

Messages 컨트롤러 `app/controllers/messages_controller.rb`에 `index` 액션 밑에 `new` 액션을 추가한다:

```ruby
def new
    @message = Message.new
end
```

라우트 파일 `config/routes.rb`에 다음 라우트를 추가하여 Messages 컨트롤러의 `create` 액션에 요청을 매핑한다.

```ruby
post 'messages' => 'messages#create'
```

Messages 컨트롤러 `app/controllers/messages_controller.rb`에 `new` 액션 밑에 `message_params`라는 개인`private` 매서드를 추가한다:

```ruby
private 
  def message_params 
    params.require(:message).permit(:content) 
  end
```

`new` 액션과 개인 매서드 사이에 `create` 액션을 추가한다:

```ruby
def create
  @message = Message.new(message_params) 
  if @message.save 
    redirect_to '/messages' 
  else 
    render 'new' 
  end 
end
```

### Form

다음에 `app/views/messages/new.html.erb`를 만들고 다음을 입력한다:

```html
<div class="header">
  <div class="container">
    <img src="http://s3.amazonaws.com/codecademy-content/courses/learn-rails/img/logo-1m.svg">
    <h1>Messenger</h1>
  </div>
</div>

<div class="create">
  <div class="container">
    
    <%= form_for(@message) do |f| %>  
      <div class="field"> 
        <%= f.label :message %><br> 
        <%= f.text_area :content %> 
      </div> 
      <div class="actions"> 
        <%= f.submit "Create" %> 
      </div> 
    <% end %>

  </div>
</div>
```

마지막으로 `app/views/messages/index.html.erb`의 `<% @messages.each do |message| %>...<% end %>` 블록 밑에 다음을 추가한다:

```html
<%= link_to 'New Message', "messages/new" %>
```

`http://localhost:3000/messages`를 방문하여 New Message를 클릭하여 자신만의 메시지를 만들어 보자.

### Workflow

[Request-Response Cycle III](http://www.codecademy.com/articles/request-response-cycle-forms)를 가이드 삼아 사용자 요청이 앱 전체에 걸쳐 어떻게 흐르는지 살펴보라.

새 메시지를 만들기위해서 `http://localhost:3000/messages/new`를 방문했을 때 request/response cycle의 첫번째 turn이 트리거`trigger` 된다.

1. 브라우저가 `/messages/new` URL을 위한 HTTP GET 요청을 만든다.
2. 레일즈 라우터가 이 URL을 Messages 컨트롤러의 `new` 액션으로 매핑한다. `new` 액션은 새로운 `Message` 객체 `@message`를 만들고 `app/views/messages/new.html.erb`의 뷰로 넘긴다.
3. 뷰에서 `form_for`가 `@message` 객체의 필드들로 폼을 만든다.

폼을 다 채우고 Create를 누르면 request/response cycle의 두번째 turn이 트리거`trigger` 된다.

1. 브라우저가 `/messages` URL에 대한 HTTP POST 요청을 통해 레일즈 앱에 데이터를 보낸다.
2. 이번에는 레일즈 라우터가 이 URL을 `create` 액션에 매핑한다.
3. `create` 액션은 폼에서 데이터를 안전하게 모으고 데이터베이스를 업데이트하기 위해 `message_param`을 사용한다.

여기서 `/messages/new`로의 링크를 만들기 위해 `link_to`를 사용했다. `<a>` 엘리먼트를 하드코딩하는 대신 링크를 제너레이트하기위해 `link_to`를 사용할 수 있다:

- 첫번째 패러미터는 링크 텍스트이다.
- 두번째 패어미터는 URL이다.

축하한다! 메시지를 저장하기위해 데이터베이스를 사용하는 메시징앱을 만들었다. 여기까지 일반화할 수 것은 무엇인가?

- 모델은 데이터베이스 안의 테이블을 기술한다.
- 마이그레이션은 새로운 테이블로 데이터베이스를 업데이트하거나 기존의 테이블을 변경하는 방법이다.
- 레일즈는 데이터를 보여주거나 만드는 등의 그런 일반적인 일을 하기위해 [7가지 표준 컨트롤러 액션](http://www.codecademy.com/articles/standard-controller-actions)을 제공한다.
- 데이터는 ERB 웹 템플레이팅을 사용하여 뷰에서 보여질 수 있다.
- 데이터는 웹 폼을 이용하여 데이터베이스 안에 저장될 수 있다.

* MessageApp 전체 소스는 [깃허브 저장소](https://github.com/nolboo/rails-codecademy-MessengerApp)에 올려놓았다.

## 맺음말

일단 포스트가 길어져서 50% 진도 부분만을 먼저 포스팅한다. 뒷부분은 배우는 대로 포스팅할 예정이다.
