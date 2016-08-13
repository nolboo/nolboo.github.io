---
layout: post
title: "리눅스 모니터링 오픈소스 Monit 사용법"
description: "리눅스 서버를 모니터링하기 위한 오픈소스인 Monit의 사용하는 방법을 살펴본다"
category: blog
tags: [linux, monitoring, monit]
---

아마존과 같은 클라우드 서비스를 이용할 때 필수적인 것이 장애 대응이다. 요즘은 Node가 인기라 관련 모니터링 프로그램이 많이 회자하는 것 같다. 동료가 [forever](https://blog.outsider.ne.kr/590)를 많이 썼었는데 요즘은 [PM2](https://blog.outsider.ne.kr/1197)가 더 인기를 끌고 있는 것 같다. [nodemon](http://nodemon.io/)도 비슷한 것 같았는데 이건 Livereload 기능에 가깝다.

Node에 국한되지 않은 일반적인 용도의 오픈소스로는 [Monit](https://mmonit.com/monit/)과 [Supervisor](http://supervisord.org/)가 많이 사용되는 것 같다. 여기서는 Monit의 간단한 사용법을 정리한다.

아파치와 MySQL이 있는 서버가 왜 이리도 자주 죽는지.. 게시판 수준의 가벼운 것인데도 한두 달에 한 번씩은 웹서버와 MySQL이 스스로 죽는 경우를 경험했다. 죽을 때마다 아래 명령으로 간단히 살릴 수는 있다:

```shell
sudo service httpd restart
sudo service mysqld restart
```

한두 달에 한 번도 귀찮다. 그래서 새로 설정하는 김에 정리한다.

## Monit?

[공식문서](https://mmonit.com/monit/documentation/monit.html) 또는 `man monit`를 보면 데몬 프로세스를 모니터링하고 죽으면 다시 살려준다고 한다. Dos 공격으로 웹서버가 리소스를 많이 차지하게 될 때도 알려주고 웹서버를 재시작할 수 있다. 그 외 메모리나 CPU가 얼마나 사용되는지, 파일이나 디렉토리, 파일 시스템까지 모니터링하여 타임스탬프, 체크섬, 크기가 변경하는 것까지 모니터링할 수 있다. 네트워크 연결 모니터링, 특정 시간에 프로그램이나 스크립트를 테스트할 수도 있다.

## 설치

다음 명령으로 쉽게 설치할 수 있다.

```shell
# On RedHat/CentOS(AMI)/Fedora/

yum install monit

# On Ubuntu/Debian/Linux Mint

sudo apt-get install monit
```

monit의 기본 설정 파일은 `/etc/monit.conf`이나 `/etc/monit/monitrc`에 있다. 아마존 리눅스에서 기본 환경 설정 파일은 `/etc/monit.conf` 이고 `/etc/monit.d/` 폴더의 모든 파일을 인클루드하고 있다. 자신의 사용자 설정을 `/etc/monit.d/`에 만들면 모두 읽어 들여 실행한다.

> monit과 관련한 작업은 거의 다 sudo 권한을 요구하므로 `sudo su`를 한 후에 다음 작업을 `sudo`없이 실행하는 것이 편하다.

```shell
sudo nano /etc/monit.conf
```

주석 처리된 것 중 원하는 설정을 맨 앞의 `#`을 없애서 활성화한다.

```
...
set daemon  120           # check services at 2-minute intervals
...

```

2분마다 서비스를 모니터링하는 것과 `/var/log/monit`에 로그를 기록하도록 한다. 로그 설정은 `/etc/monit.d/logging`에 이미 지정되어 있다.

Monit은 2812 포트를 이용하여 웹에서 관리할 수도 있고, 알림을 메일로 받을 수도 있다. 그러려면 다음 부분을 비주석 처리해야 한다.

```
set httpd port 2812 and
     use address localhost  # only accept connection from localhost
     allow localhost        # allow localhost to connect to the server and
#     allow admin:monit      # require user 'admin' with password 'monit'
#     allow @monit           # allow users of group 'monit' to connect (rw)
#     allow @users readonly  # allow users of group 'users' to connect readonly
```

AWS EC2에서는 localhost에서 메일을 보내는 것은 [배보다 배꼽이 더 큰 일이다](https://www.elprespufferfish.net/blog/aws,mail/2015/09/03/mail-server-ec2.html). 만약 웹 인터페이스로 관리하려면 보안그룹에 2812 포트를 추가해줘야 한다. 그러나 이 설정을 해주지 않으면 데몬으로 실행되지 않는다. 여기서는 그냥 allow localhost까지만 비주석 처리하였다. 원하면 같이 활성화한다.

## 실행

이제 monit 데몬을 실행하려면 `sudo monit`하거나:

```shell
sudo monit start
```

하면 데몬으로 실행할 수 있다. monit 서비스가 실행되었는지는 로그 파일을 체크해보면 된다.

```shell
sudo tail -f /var/log/monit.log
```

## 사용자 설정

이제 아파치에 대해 설정한다. 파일 이름은 자유롭게 줄 수 있으나 나중에 식별하기 좋도록 서비스와 밀접하게 준다.

```shell
sudo nano /etc/monit.d/httpd
```

아래 내용을 입력한다:

```
check process httpd with pidfile /var/run/httpd/httpd.pid
start program = "/etc/init.d/httpd start"
stop program = "/etc/init.d/httpd stop"
```

만약 Nginx라면 다음을 입력한다:

```
check process nginx with pidfile /var/run/nginx.pid
start program = "/etc/init.d/nginx start"
stop program = "/etc/init.d/nginx stop"
```

만약 자신의 웹서버가 무엇인지 정확히 모를 경우엔 다음 명령으로 간단하게 알 수 있다:

```shell
curl -I 내도메인.
HTTP/1.1 200 OK
Date: Fri, 12 Aug 2016 09:33:12 GMT
Server: Apache/2.2.31 (Amazon)
X-Powered-By: PHP/5.3.29
.
.
.
```

MySQL 사용자 설정은:

```shell
sudo nano /etc/monit.d/mysql
```

아래 내용을 입력한다:

```
check process mysqld with pidfile /var/run/mysqld/mysqld.pid
group mysql
start program = "/etc/init.d/mysqld start"
stop program = "/etc/init.d/mysqld stop"
if failed host 127.0.0.1 port 3306 then restart
if 5 restarts within 5 cycles then timeout
```

원하는 설정을 모두 입력하였으면 다음 명령으로 문법 검사를 한다:

```shell
sudo monit -t
Control file syntax OK
```

환경설정의 문법 검사를 통과하면 재시작해야 한다:

```shell
sudo /etc/init.d/monit restart
```

`monit reload` 명령도 같다.

## 주요 명령

`monit -h`으로 실행가능한 명령과 옵션이 나온다.

모니터링 상황을 보려면 `status` 옵션을 사용한다:

```
monit status
The Monit daemon 5.2.5 uptime: 4m

Process 'mysqld'
  status                            running
  monitoring status                 monitored
  pid                               1892
  parent pid                        1688
  uptime                            4m
  children                          0
  memory kilobytes                  67232
  memory kilobytes total            67232
  memory percent                    11.0%
  memory percent total              11.0%
  cpu percent                       0.0%
  cpu percent total                 0.0%
  port response time                0.000s to 127.0.0.1:3306 [DEFAULT via TCP]
  data collected                    Sat Aug 13 08:13:48 2016

Process 'httpd'
  status                            running
  monitoring status                 monitored
  pid                               1947
  parent pid                        1
  uptime                            4m
  children                          9
  memory kilobytes                  23648
  memory kilobytes total            213176
  memory percent                    3.9%
  memory percent total              35.1%
  cpu percent                       0.0%
  cpu percent total                 0.0%
  data collected                    Sat Aug 13 08:13:48 2016

System 'system_ip-xxx-xxx-xxx-xxx.ap-northeast-1.compute.internal'
  status                            running
  monitoring status                 monitored
  load average                      [0.00] [0.02] [0.00]
  cpu                               0.1%us 0.0%sy 0.3%wa
  memory usage                      138896 kB [22.9%]
  swap usage                        0 kB [0.0%]
  data collected                    Sat Aug 13 08:13:48 2016
```

실행상황만을 간략히 보려면 `summary` 옵션을 사용한다:

```shell
monit summary
The Monit daemon 5.2.5 uptime: 4m

Process 'mysqld'                    running
Process 'httpd'                     running
System 'system_ip-xxx-xxx-xxx-xxx.ap-northeast-1.compute.internal' running
```

`monit quit`은 monit 데몬을 중지한다

## EC2 부팅 시 실행

서버를 부팅할 때도 실행하도록 설정한다:

```
sudo nano /etc/rc.d/rc.local
```

마지막에 다음을 입력한다:

```shell
#!/bin/sh
#
# This script will be executed *after* all the other init scripts.
# You can put your own initialization stuff in here if you don't
# want to do the full Sys V style init stuff.

/usr/bin/monit
```

대부분의 monit 관련 명령은 `sudo`로 실행해야 하지만 [AWS 공식 문서](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/user-data.html#user-data-shell-scripts)에서 사용자 데이터로 입력된 스크립트는 root 사용자 권한으로 실행되므로 스크립트에 `sudo` 명령을 사용하지 않도록 권하고 있어서 위에서 `sudo`를 생략하였다.

`monit`이 실행되지 않았어도 서비스 상태를 보려면 다음 `service` 명령을 실행해서 확인한다:

```shell
sudo service monit status
monit (pid  1624) is running...
```

## 참고링크

- [monit install and setup](http://aws-labs.com/monit-install-setup/)
- [monit: error connecting to the monit daemon](http://www.idimmu.net/2013/03/28/monit-error-connecting-to-the-monit-daemon/)

## 추가 링크

- [서버, 프로세스, 모니터링 그리고 오픈소스](http://www.smallake.kr/?p=18392)
- [20 Command Line Tools to Monitor Linux Performance](http://www.tecmint.com/command-line-tools-to-monitor-linux-performance)
- [리눅스용 공짜 모니터링 툴 6개 링크](http://www.myservlab.com/99)