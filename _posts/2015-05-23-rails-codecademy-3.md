---
layout: post
title: "코드캐더미로 배우는 레일즈 기초 3부"
description: "many-to-many 모델을 사용한 영화와 배우 정보를 보여주는 앱을 만든다."
category: blog
tags: [codecademy, course, rails, ruby]
---

[코드캐더미로 배우는 레일즈 기초 2부](http://nolboo.github.io/blog/2015/05/17/rails-codecademy-2/)에서 두 개의 모델을 사용하여 데이터를 저장하는 앱을 만들었다. 데이터 간에 one-to-many 관계를 만들기 위해 `has_many` / `belongs_to` 를 사용하였다.

## MovieApp

영화는 배역을 맡은 많은 배우가 있고, 각 배우는 역시 출연한 많은 영화가 있다. 이러한 데이터를 모델링하기 위해서는 many-to-many 관계가 필요하다. 영화 웹사이트를 위한 레일즈앱을 만들어 보자.

<pre class="terminal">
    rails new MovieApp
    cd MovieApp
    bundle install
</pre>

### Model

Movie, Actor, Part 모델을 제너레이트한다.

<pre class="terminal">
    rails generate model Movie
    rails generate model Actor
    rails generate model Part
</pre>

`app/models/movie.rb`에 다음 매서드를 추가한다:

```ruby
has_many :parts 
has_many :actors, through: :parts
```

`Movie` 모델과 `Actor` 모델을 `Part` 모델을 통해서 연결하기 위해 `has_many :through`를 사용한다. `has_many :through`가 영화와 배우 간의 many-to-many 관계를 만든다.

`app/models/actor.rb`에 다음 매서드를 추가한다:

```ruby
has_many :parts 
has_many :movies, through: :parts
```

`app/models/part.rb`에 다음 매서드를 추가한다:

```ruby
belongs_to :movie 
belongs_to :actor
```


![](http://s3.amazonaws.com/codecademy-content/courses/learn-rails/img/has-many-through.svg)

계속해서 `db/migrate/` 안의 movies 테이블을 위한 마이그레이션 파일에 다음 컬럼을 추가한다:

```ruby
t.string :title
t.string :image
t.string :release_year
t.string :plot
```

actors 테이블을 위한 마이그레이션 파일에 다음 컬럼을 추가한다:

```ruby
t.string :first_name
t.string :last_name
t.string :image
t.string :bio
```

parts 테이블을 위한 마이그레이션 파일에 다음을 추가하여 영화와 배우 테이블을 가리키는 foreign keys를 추가한다:

```ruby
t.belongs_to :movie, index: true 
t.belongs_to :actor, index: true
```

세 가지 테이블로 데이터베이스를 업데이트한다:

<pre class="terminal">
    rake db:migrate
    rake db:migrate:status // 세 모델이 만들어졌는지 상태를 확인할 수 있다.
</pre>

[미리 준비된 seed.rb](https://github.com/nolboo/rails-codecademy-MovieApp/blob/master/db/seeds.rb)로 영화와 배우에 대한 데이터를 공급한다:

<pre class="terminal">
    rake db:seed
</pre>

### Route

<pre class="terminal">
    rails generate controller Movies
</pre>

라우터 파일 `config/routes.rb`에 `/movies` URL을 Movies 컨트롤러의 index 액션을 매핑한다:

```ruby
get '/movies' => 'movies#index'
```

Movies 컨트롤러 안에 모든 영화를 보여주는 `index` 액션을 추가한다:

```ruby
def index
    @movies = Movie.all
end
```

`app/views/movies/index.html.erb`를 만들고 뷰에 해당하는 코드를 입력한다:

```html
<div class="hero">
  <div class="container">
    <h2>Interstellar</h2>
    <p>Former NASA pilot Cooper (Matthew McConaughey) and a team of researchers travel across the galaxy to find out which of three planets could be mankind's new home.</p>
    <a href="#">Read More</a>
  </div>
</div>

<div class="main">
  <div class="container">
  <h2>Popular Films</h2>

    <% @movies.each do |m| %>
    <div class="movie">
      <%= image_tag m.image %>
      <h3><%= m.title %></h3>
      <p><%= m.release_year %></p>
    </div>
    <% end %>
  </div>
</div>
```

스타일링을 위해 [applcation.css](https://github.com/nolboo/rails-codecademy-MovieApp/blob/master/app/assets/stylesheets/application.css)를 입력한다.

이제 `http://localhost:3000/movies`을 방문하면 아래와 같은 멋진 앱이 뜬다.

![](https://c1.staticflickr.com/9/8869/17703985109_63e7ed1ae9_b.jpg)

라우트 파일에 `/movies/1`과 같은 URL에 대한 요청을 Movie 컨트롤러의 `show` 액션으로 보내고, 이 라우트를 "movie"라고 부른다:

```ruby
get '/movies/:id' => 'movies#show', as: :movie
```

Movies 컨트롤러 파일에 특정 영화와 그 배우들을 보여주는 `show` 액션을 추가한다.

- `id`로 영화를 찾기 위해 `Movie.find`를 먼서 사용하고,
- 영화에 속한 모든 배우를 가져와서, `@actors`에 저장한다:

```ruby
def show
  @movie = Movie.find(params[:id])
  @actors = @movie.actors
end
```

`app/view/movies/show.html.erb`를 만들고 다음을 입력한다:

```html
<div class="main movie-show">
  <div class="container">
    <div class="movie">
      
      <!-- Display the movie's info here -->
      <div class="info">
        <%= image_tag @movie.image %>
        <h3 class="movie-title"><%= @movie.title %></h3>
        <p class="movie-release-year"><%= @movie.release_year %></p>
        <p class="movie-plot"><%= @movie.plot %></p>
      </div>
    </div>

    <h2>Cast</h2>
    <% @actors.each do |actor| %>
    <div class="actor">
      <%= image_tag actor.image %>
      <h3 class="actor-name"><%= actor.first_name %> <%= actor.last_name %></h3>
      <p class="actor-bio"><%= actor.bio %></p>
    </div>
    <% end %>
  </div>
</div>
```

`app/views/movies/index.html.erb`의 movie's plot 밑에 `link_to`를 이용하여 "Learn more" 텍스트 링크를 만들고, `show` 라우트를 "movie"로 명명하였기 때문에 레일즈가 만들어주는 `movie_path` 헬퍼 매서드를 사용하여 각 영화의 패스로 URL을 제너레이트해주는 것을 이용한다:

```html
<p><%= movie.plot %></p>
<%= link_to "Learn more", movie_path(movie) %>
```

* 여기서 `m` 변수를 `movie` 변수로 갑자기 바꿨는데, 가독성이 좀 더 나은 것 같아서 그대로 다 변경하였다.

이제 "Learn more"를 클릭하면 영화 정보와 배우들의 정보를 볼 수 있다:

![](https://c4.staticflickr.com/8/7695/17998355281_896652d302_b.jpg)

이제 배우가 출연한 모든 영화를 볼 수 있도록 해보자.

"Actors"라는 컨트롤러를 제너레이트한다:

<pre class="terminal">
  rails generate controller Actors
</pre>

라우트 파일에 `/actors` URL을 Actors 컨트롤러의 `index` 액션에 매팅하는 라우트를 추가한다:

```ruby
  get '/actors' => 'actors#index'
```

컨트롤러에 모든 배우 목록을 보여주는 `index` 액션을 추가한다.

```ruby
def index
  @actors = Actor.all
end
```

`app/views/actors/index.html.erb`를 만들고 다음을 입력한다:

```html
<div class="main actor-index">
  <div class="container">
    <div class="row">
      <% @actors.each do |actor| %>
       <div class="actor col-xs-2">
         <%= image_tag actor.image %>
         <h3><%= actor.first_name + " " + actor.last_name %></h3>
        <p><%= actor.bio %></p>
      </div>
      <% end %>
  </div>
</div>
```

라우트 파일로 돌아가서 `/actors/1`과 같은 URL에 대한 요청을 Actors 컨트롤러의 `show` 액션으로 보내주는 라우트를 추가하고, "actor"로 명명한다:

```ruby
get '/actors/:id' => 'actors#show', as: :actor
```

그리고 컨트롤러에 각 배우와 출연한 영화를 보여주는 `show` 액션을 추가한다. id로 배우를 먼저 찾고, 배우가 출연한 모든 여와를 보여준다:

```ruby
def show
  @actor = Actor.find(params[:id])
  @movies = @actor.movies
end
```

`app/views/actors/show.html.erb`를 만들고 다음을 입력한다:

```html
<div class="main actor-show">
  <div class="container">
    
    <!-- Display an actor's info here -->
    <div class="actor">
      <%= image_tag @actor.image %>
      <div class="info">
        <h3 class="actor-name"><%= @actor.first_name + " " + @actor.last_name %></h3>
        <p class="actor-bio"><%= @actor.bio %></p>
      </div>
    </div>

    <h2>Movies</h2>
    <!-- Display each movie's info here -->
    <% @movies.each do |movie| %>
    <div class="movie">
      <%= image_tag movie.image %>
      <h3 class="movie-title"><%= movie.title %></h3>
      <p class="movie-release-year"><%= movie.release_year %>/p>
      <p class="movie-plot"><%= movie.plot %></p>
    </div>
    <% end %>
  </div>
</div>
```

마지막으로 `app/views/actors/index.html.erb`를 만들고 "Learn more" 이름의 링크를 `link_to`를 사용하여 만들고 `actor_path`를 이용한다:

```html
<%= link_to "Learn more", actor_path(actor) %>
```

소스코드의 위치와 내용을 [깃허브](https://github.com/nolboo/rails-codecademy-MovieApp)에 올려놓았다.

배우와 영화가 many-to-many 관계를 사용하여 모델링할 수 있다 레일즈에서는 `has_many:through`를 사용하는 것도 제공된다. `has_many:through` 관계는 세번째 모델을 이용하여 두 모델을 조인한다.

축하한다! 코드캐더미 레일즈 코스를 다 마친 것이다.

## 맺음말

코드캐더미의 레일즈 강좌는 레일즈의 MVC 속성을 쉬운 앱부터 시작하여 여러 형태의 앱을 반복해서 만들어 볼 수 있다. 비슷한 코드를 계속해서 입력하게 하기 때문에 나름대로 처음 접한 MVC의 이해도를 높을 수 있었다. 그런데 3개의 글을 그냥 읽기만하는 블로그 독자에게는 매우 지루한 일일수도 있을 것 같다는 생각이 든다. 직접 강좌를 하면서 참고용으로 삼기 바란다=3=3=3

## 추천 링크

- [Ruby/Rails 4.0 - Lecture 1/29 - Intro to Rails - YouTube](https://www.youtube.com/watch?v=MrGYKo50Dqg&list=PLSXDqiI4sC5PsASjJy7dBncALnhjud2fx): 
여기저기 기웃거리다가 괜찮은 동영상을 만났다. 설명도 자세한 편이고 무엇보다 실수를 많이 하면서(때론 유도하면서) 그걸 해결하는 것을 직접 보여주는 것이 익살스럽다. 총 29개의 비디오로 구성되어 있으며 23번째를 보기 시작하면서 추천하는 것이다.
- [레일스와 함께 하는 애자일 웹 개발 개정판 | 도서출판 인사이트](http://www.insightbook.co.kr/books/programming-insight/%EB%A0%88%EC%9D%BC%EC%8A%A4%EC%99%80-%ED%95%A8%EA%BB%98-%ED%95%98%EB%8A%94-%EC%95%A0%EC%9E%90%EC%9D%BC-%EC%9B%B9-%EA%B0%9C%EB%B0%9C-%EA%B0%9C%EC%A0%95%ED%8C%90) - 원본 : [Agile Web Development with Rails 4 (Facets of Ruby): Sam Ruby, Dave Thomas, David Heinemeier Hansson](http://www.amazon.com/Agile-Development-Rails-Facets-Ruby/dp/1937785564/ref=sr_1_1?ie=UTF8&qid=1434097925&sr=8-1&keywords=agile-web-development-with-rails-4)
- [Ruby on Rails Tutorial (3rd Ed.)](https://www.railstutorial.org/book)

