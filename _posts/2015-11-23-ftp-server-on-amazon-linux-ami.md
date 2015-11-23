---
layout: post
title: "아마존 리눅스 AMI에 FTP 서버 설정하기"
description: "아마존 AWS는 보안을 위해 기본적으로 외부 포트가 열리지 않아 있다. 아마존 리눅스 AMI에 FTP 서버를 설정하는 방법을 간단하게 번역하였다"
category: blog
tags: [amazon, linux, ftp]
---

AWS EC2에 무료로 제공되는 아마존 리눅스 AMI([Amazon Machine Image](https://en.wikipedia.org/wiki/Amazon_Machine_Image))에 FTP 서버를 설정하는 방법을 간결하게 설명하고, 스택오버플로우에서도 많은 호응을 얻은 [글](http://stackoverflow.com/a/11404078)이 있어 번역한다.

원문 : [Setting up an FTP server on your Amazon Linux AMI](http://cafeandrew.com/archives/2339)

## 1단계: vsftpd 설치

EC2 서버에 SSH 접속한 후 vsftpd를 설치한다.

<pre class="terminal">
sudo yum install vsftpd
</pre>

## 2단계: EC2 인스턴스의 FTP 포트를 연다.

EC2 서버의 FTP 포트를 연다. AWS EC2 관리 콘솔에 로그인하고 왼쪽의 내비게이션 메뉴에서 보안 그룹(Security Groups)을 선택한다. EC2 인스턴스에 할당된 보안 그룹을 선택하고 Inbound 탭에서 20-21 범위의 포트를 추가한다.

![](http://i.stack.imgur.com/4OKWe.png)

1024-1048 포트 범위도 추가한다:

![](http://i.stack.imgur.com/MVtT4.png)

## 3단계: vsftpd.conf 파일 업데이트

vsftpd 환경 설정 파일을 편집한다.

<pre class="terminal">
sudo nano /etc/vsftpd/vsftpd.conf
</pre>

익명으로 FTP를 접속하는 것을 막는다:

<pre class="terminal">
anonymous_enable=YES
</pre>

를

<pre class="terminal">
anonymous_enable=NO
</pre>

로 고친다.

`vsftpd.conf` 파일의 마지막에 다음을 추가한다:

<pre class="terminal">
pasv_enable=YES
pasv_min_port=1024
pasv_max_port=1048
pasv_address=자신의 인스턴스 공인 IP
</pre>

`vsftpd.conf` 파일이 다음과 비슷해 보여야 한다. - 단, `pasv_address` 값은 자신의 공인(Public) IP 주소여야 한다.

![](http://i.stack.imgur.com/MqGmg.jpg)

## 4단계: vsftpd 재시작

<pre class="terminal">
sudo /etc/init.d/vsftpd restart
</pre>

다음과 같은 메시지가 보여야 한다.

![](http://i.stack.imgur.com/oGWgL.jpg)

## 5단계: FTP 사용자 만들기

`/etc/vsftpd/user_list`를 보면 다음과 같을 것이다:

```
# vsftpd userlist
# If userlist_deny=NO, only allow users in this file
# If userlist_deny=YES (default), never allow users in this file, and
# do not even prompt for a password.
# Note that the default vsftpd pam config also checks /etc/vsftpd/ftpusers
# for users that are denied.
root
bin
daemon
adm
lp
sync
shutdown
halt
mail
news
uucp
operator
games
nobody
```

이건 기본적으로 "이 사용자들은 FTP 접근을 허락하지 않는다"라고 말하는 것이다. vsftpd는 이 목록에 없는 사용자가 FTP에 접근할 수 있게 한다.

그러므로 새 FTP 계정을 만들기 위해서, 서버에 사용자를 새로 만들어야 한다.(만약 `/etc/vsftpd/user_list`에 열거되지 않은 사용자 계정(예를 들어 ec2-user: 역자주)을 이미 가지고 있다면 다음 단계로 넘어간다.)

EC2 인스턴스에 사용자를 새로 만드는 것은 매우 간단하다. 예를 들어 사용자 `bret`을 만들려면:

<pre class="terminal">
sudo adduser bret
sudo passwd bret
</pre>

다음과 같이 보일 것이다.

![](http://i.stack.imgur.com/A7Dad.jpg)

## 6단계: 사용자의 홈 디렉토리를 제한한다.

이 시점에서의 FTP 사용자는 홈 디렉토리에 제한이 없다. 이것은 보안상 좋지 않으나, 매우 쉽게 고칠 수 있다.

`vsftpd.conf` 파일을 편집한다:

<pre class="terminal">
sudo nano /etc/vsftpd/vsftpd.conf
</pre>

다음 라인을 주석해제한다:

```
chroot_local_user=YES
```

다음과 같이 보일 것이다:

![](http://i.stack.imgur.com/5atwI.jpg)

vsftpd 서버를 재시작한다:

<pre class="terminal">
sudo /etc/init.d/vsftpd restart
</pre>

이제 다 했다!

## 부록 A: 리부트에서 살아남기

vsftpd는 서버가 부트할 때 자동으로 시작되지 않는다. 다음과 같이 한다:

<pre class="terminal">
sudo chkconfig --level 345 vsftpd on
</pre>

## 부록 A: vsftpd 제거하기(역자)

<pre class="terminal">
sudo yum remove vsftpd
</pre>

우분투와 달리 위의 명령어로 환경설정까지 제거되고, 서비스도 정지된다.


