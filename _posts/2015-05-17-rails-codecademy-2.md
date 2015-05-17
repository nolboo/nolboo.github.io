---
layout: post
title: "코드캐더미로 배우는 레일즈 기초 2부"
description: "코드캐더미에서 새롭게 레일즈 무료 강좌를 출시했다. 내용이 친절하고 자세하다. 브라우저 환경이 아닌 맥을 기준을 더 자세하게 풀어보았다."
category: blog
tags: [codecademy, course, rails, ruby]
---

[코드캐더미로 배우는 레일즈 기초 1부](http://nolboo.github.io/blog/2015/05/13/rails-codecademy/)에 이어서 두 개의 모델을 가진 TravelApp을 만들어본다.

## TravelApp

한 가지 종류 이상의 데이터를 가진 앱을 만들고 싶을 때 다른 컬럼을 갖기 때문에 하나의 모델로 기술하기에는 혼란스러울 수 있다. 대신 두 개 이상의 모델로 기술할 수 있다.

새로운 TravelApp앱을 만든다:

<pre class="terminal">
    rails new TravelApp
    cd TravelApp
</pre>

### Model

Tag와 Destination이라는 두 개의 모델을 만든다:

<pre class="terminal">
    rails generate model Tag
    rails generate model Destination
</pre>

두 개의 모델 사이의 관계를 정의한다.

`app/models/tag.rb`에:

```ruby
has_many :destination
```

`app/models/destination.rb`에

```ruby
belongs_to :tag
```

`has_many`/`belongs_to` 쌍은 일대다 관계를 정의하기 위해 자주 쓰인다. 몇 가지를 예로 들면:

- a Library has many Books; a Book belongs to a Library : 책과 도서관
- an Album has many Photos; a Photo belongs to an Album : 사진과 앨범
- a Store has many Products; a Product belongs to a Store : 상품과 상점

`db/migrate` 안의 tags 테이블에 `title`과 `image`란 string 컬럼들을 추가한다:

```ruby
t.string :title
t.string :image
```

destinations 테이블에 `name`, `image`, `descripton`이란 string 컬럼을 추가하고, 
tags 테이블에 foreign key pointing을 추가하기위해 `t.references :tag`를 추가한다:

```ruby
t.string :name
t.string :image
t.string :description
t.references :tag
```

<pre class="terminal">
    rake db:migrate
</pre>

`db/seeds.rb`에 [데이터를 입력]()한다.

<pre class="terminal">
    rake db:seed
</pre>

### controller, route, view

`Tags` 컨트롤러를 제너레이트한다.

<pre class="terminal">
    rails generate controller Tags
</pre>

`config/routes.rb`에 `/tags` 요청을 `Tags` 컨트롤러의 `index` 액션에 매핑하는 새로운 라우트를 추가한다:

```ruby
get '/tags' => 'tags#index'
```

`app/controllers/messages_controller.rb`에 모든 태그 목록을 보여주는 `index` 액션을 추가한다:

```ruby
def index
    @tags = Tag.all
end
```

뷰를 만들기 위해서 `app/views/tags/index.html.erb`를 만들고, 다음을 입력한다:

```html
<div class="header">
  <div class="container">
    <img src="http://s3.amazonaws.com/codecademy-content/courses/learn-rails/img/logo-1tm.svg" width="80">
    <h1>BokenjiKan</h1>
  </div>
</div>

<div class="tags">
  <div class="container">
    <div class="cards row">
      <% @tags.each do |t| %>
      <div class="card col-xs-4">
        <%= image_tag t.image %>
        <h2><%= t.title %></h2>
        <%= link_to "Learn more", tag_path(t) %>
      </div>
      <% end %>
    </div>
  </div>
</div>
```

`app/assets/stylesheets/application.css`에 CSS를 입력한다:[github]()

이제 `http://localhost:8000/tags`을 방문해서 TravelApp에 웹페이지를 요청한다.

![](https://c1.staticflickr.com/9/8742/17537708420_0e2dfb0165_b.jpg)

이제 특정 태그를 보여주는 액션을 추가해보자. [7가지 표준 컨트롤러 액션 문서](http://www.codecademy.com/articles/standard-controller-actions)를 참조하고, 라우트 화일에 다음 라우트를 추가한다:

```ruby
get '/tags/:id' => 'tags#show', as: :tag
```

**이 라우트를 "tag"라고 부르기 위해 `as:`를 사용하였다.**

`app/views/tags/show.html.erb`을 만든다:

```html
<div class="header">
  <div class="container">
    <img src="http://s3.amazonaws.com/codecademy-content/courses/learn-rails/img/logo-1tm.svg" width="80">
    <h1>BokenjiKan</h1>
  </div>
</div>

<div class="tag">
  <div class="container">
    <h2><%= @tag.title %></h2>

    <div class="cards row">
      <% @destinations.each do |d| %>
      <div class="card col-xs-4">
        <%= image_tag d.image %>
        <h2><%= d.name %></h2>
        <p><%= d.description %></p>
      </div>
      <% end %>
    </div>

  </div>
</div>
```

`app/views/tags/index.html.erb`에 다음을 추가한다:

```html
<%= link_to "Learn more", tag_path(t) %>
```

**위에서 라우트에 "tag"라는 이름을 주었기 때문에, 레일즈는 `tag_path`라는 헬퍼 매서드를 자동으로 만든다. `tag_path(t)`는 특정 태그의 패스(예를 들면 `/tag/1`)로 URL을 제너레이트한다.**

<pre class="terminal">
    rails generate controller Destinatins
</pre>

라우트 파일에 다음 라우트를 추가한다:

```ruby 
get '/destinations/:id' => 'destinations#show', as: :destination
```

Destinations 컨트롤러 파일에 `show` 액션을 추가한다:

```ruby
def show 
  @destination = Destination.find(params[:id])
end
```

뷰 파일 `app/views/destinations/show.html.erb`을 만들고, 목적지의 사진, 이름, 소개를 보여주도록 한다:

```html
<div class="header">
  <div class="container">
    <img src="http://s3.amazonaws.com/codecademy-content/courses/learn-rails/img/logo-1tm.svg" width="80">
    <h1>BokenjiKan</h1>
  </div>
</div>

<div class="destination">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <%= image_tag @destination.image %>
        <h2><%= @destination.name %></h2>
        <p><%= @destination.description %></p>
      </div>
    </div>
  </div>
</div> 
```

마지막으로 `app/views/tags/show.html.erb`에 다음을 추가한다:

```html
<p><%= link_to "See more", destination_path(d) %></p>
```

- "See more"를 링크 텍스트로 준다.
- `show` 라우트를 "destination"는 이름을 주었기 때문에, 레일즈는 `destination_path`라는 헬퍼 매서드를 자동으로 만든다. 특정 목적지의 패스를 URL로 제너레이트하기 위해 `destination_path`를 사용한다.

이제 앱이 특정 목적지를 보여준다. 목적지의 이름과 설명을 업데이트하는 액션을 추가해보자. [7가지 표준 컨트롤러 액션 문서](http://www.codecademy.com/articles/standard-controller-actions)을 참조하면 `edit`과 `update`를 사용해야한다.

라우트 파일에 다음 라우트를 추가한다:

```ruby
get '/destinations/:id/edit' => 'destinations#edit', as: :edit_destination 
patch '/destinations/:id' => 'destinations#update'
```

Destinations 컨트롤러의 `show` 액션 밑에 `edit` 액션을 추가한다:

```ruby
def edit 
  @destination = Destination.find(params[:id]) 
end
```

`edit` 액션 밑에 `destination_params`라는 private 매서드를 추가한다:

```ruby
private 
  def destination_params 
    params.require(:destination).permit(:name, :description) 
  end
```

`edit` 액션과 private 매서드 사이에 `update` 액션을 추가한다:

```ruby
def update 
  @destination = Destination.find(params[:id]) 
  if @destination.update_attributes(destination_params) 
    redirect_to(:action => 'show', :id => @destination.id) 
  else 
    render 'edit' 
  end 
end
```

`app/views/destinations/edit.html.erb`를 만들고 다음 코드를 입력한다:

```html
<div class="header">
  <div class="container">
    <img src="http://s3.amazonaws.com/codecademy-content/courses/learn-rails/img/logo-1tm.svg" width="80">
    <h1>BokenjiKan</h1>
  </div>
</div>

<div class="destination">
  <div class="container">
    <%= image_tag @destination.image %>
    
    <%= form_for(@destination) do |f| %>
      <%= f.text_field :name %>
      <%= f.text_field :description %>
      <%= f.submit "Update", :class => "btn" %>
    <% end %>

  </div>
</div>
```

마지막으로 `app/views/destinations/show.html.erb`에 `edit_destination_path`와 `link_to`를 이용하여 링크를 만든다:

```html
<%= link_to "Edit", edit_destination_path(@destination) %>
```

소스코드의 위치와 내용을 깃허브의 [커밋 페이지](https://github.com/nolboo/rails-codecademy-TravelApp/commit/3ea65d4068a7abf58375cf19725cbb08ffd02945)에서 자세하게 볼 수 있게 올려놓았다.