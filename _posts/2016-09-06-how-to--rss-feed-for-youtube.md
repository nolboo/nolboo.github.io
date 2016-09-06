---
layout: post
title: "유투브 채널 RSS 구독"
description: "RSS 구독을 지원하지 않는 YouTube Channel을 RSS 리더로 구독하는 방법을 예시와 함께 소개한다"
category: blog
tags: [youtube, rss, feed, subscribe]
---

유튜브 구독 UX는 많이 불편하다. 제대로 추천도 못 해주고 구독을 했는데도 어디서 찾아야 할지 데스크톱에서도 조금 헤매야 할 정도로 불편하다. 최근에는 소셜미디어가 흥하고 있지만, 그 전에는 RSS 구독이 나의 정보 습득에서 독보적인 부분을 차지하였다. 이제는 트위터와 병행하고 있지만 그래도 하나도 빼놓지 않고 구독하고 싶은 것은 Reeder 맥앱으로 RSS 구독을 한다. 트위터는 블로그 포스트 외에도 여러 코멘트가 섞이기 때문에 포스트 소개에 비해 그런 트윗이 너무 많으면 별도의 리스트로 관리한다. 유튜브는 최근엔 배우기 위해 많이 검색하고 보고 있어서 좋은 채널을 발견하면 RSS를 제공하지 않아 불편했는데, [유튜브 채널을 구독하는 방법](http://www.makeuseof.com/tag/how-to-create-an-rss-feed-for-any-youtube-channel/)이라는 글을 만나 소개하고 덧붙인다.

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

![채널 소스 보기](TED-YouTube-channel-src-view.jpg)

또는 채널 URL의 마지막 값을 복사한다.

![](TED-YouTube-channel.jpg)

* `https://www.youtube.com/feeds/videos.xml?channel_id=UCAuUUnT6oDeKwE6v1NGQxug`을 RSS 리더의 구독 url로 등록한다.

끝!

