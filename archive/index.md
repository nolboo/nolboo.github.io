---
layout: default
title: Nolboo's Blog
description: 호모스터디쿠스를 꿈꾸는 놀부
---

<ul>
  {% for post in site.posts %}
    <li>
      <a href="{{ post.url }}">{{ post.title }}</a>
      <div><small>{{ post.date | date_to_string }}</small></div>
    </li>
  {% endfor %}
</ul>