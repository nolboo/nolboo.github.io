---
layout: post
title: "유투브 채널 RSS 구독"
description: "RSS 구독을 지원하지 않는 YouTube Channel을 RSS 리더로 구독하는 방법을 예시와 함께 소개한다"
category: blog
tags: [youtube, rss, feed, subscribe]
---

유튜브 서비스의 자체 구독 UX는 불편하다. 추천도 맘에 안들고 구독한 채널도 찾아 보기가 그리 편하지 않다. 최근에는 소셜미디어가 흥하고 있지만, 예전에는 RSS 구독이 정보 습득에서 독보적인 부분을 차지했었다. 지금은 트위터와 병행하고 있지만 하나도 빼놓지 않고 구독하고 싶은 블로그 등은 Reeder 맥앱으로 RSS 구독을 한다. 트위터는 블로그 포스트 외에도 여러 코멘트가 섞이기 때문에 다른 의미가 있다. 유튜브는 좋은 채널을 발견하면 지속적으로 지켜보고 싶어도 RSS와 같은 방법을 제공하지 않아 불편했는데, [유튜브 채널을 구독하는 방법](http://www.makeuseof.com/tag/how-to-create-an-rss-feed-for-any-youtube-channel/)이라는 글을 만나 소개하고 덧붙인다.

## 유튜브 채널 구독 방법

* 채널의 메인 페이지 방문한다.
* 우클릭하여 페이지 소스 보기를 선택한다.
* `data-channel-external-id`를 검색하여 바로 다음에 오는 값을 찾아서 복사한다.(인용부호는 제외한다.)
* 그 값을 `https://www.youtube.com/feeds/videos.xml?channel_id=` 뒤에 붙인다.
* RSS 리더에 방금 만든 URL로 구독한다.

## 구독 예시 - TED 채널

* [유튜브 채널 페이지](https://www.youtube.com/channel/UCAuUUnT6oDeKwE6v1NGQxug)를 방문한다.
* 우클릭하여 페이지 소스 보기를 선택한다.
* `data-channel-external-id`을 검색하여 바로 다음에 오는 값을 찾아서 복사한다.(인용부호는 제외한다.)

![채널 소스 보기](/images/posts/TED-YouTube-channel-src-view.jpg)

또는 채널 URL의 마지막 값을 복사한다.

![채널 URL](/images/posts/TED-YouTube-channel.jpg)

* `https://www.youtube.com/feeds/videos.xml?channel_id=UCAuUUnT6oDeKwE6v1NGQxug`을 RSS 리더의 구독 url로 등록한다.

끝!

---

## 2018년3월25일 추가

* `https://www.youtube.com/feeds/videos.xml?channel_id=` 이후에 원하는 채널 아이디를 추가하면 됩니다.
* 채널 아이디는 원하는 채널의 홈 URL의 `https://www.youtube.com/channel/` 다음에 나오는 아이디입니다.


