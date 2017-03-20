---
layout: post
title: "Docker for mac 훑어보기"
description: "안정 버전이 나온 맥용 도커를 설치하고 빠르게 사용법을 익힌 후 워드프레스와 마리아디비 컨테이너를 만들어 본다."
category: blog
tags: [docker, mac, docker-compose, wordpress, devops, development, environment]
---

![Docker for Mac and Windows](http://img.scoop.it/qJ-H5ZRk89m2xeq5QyncsrnTzqrqzN7Y9aBZTaXoQ8Q=)

드디어 [맥용 도커가 출시되었다](https://blog.docker.com/2016/07/docker-for-mac-and-windows-production-ready/)고 한다. [Boot2docker](http://boot2docker.io/)로 사용할 수 있었지만 이제 도커가 직접 지원한다고 하니 궁금해서 얼른 설치하고 사용법을 거칠게 살펴보았다.

도커는 리눅스를 기반으로 설계되어 각 리눅스 배포판`distro`에 따른 [Docker Engine](https://docs.docker.com/engine/installation/linux/)을 설치하면 된다.

맥과 윈도우에서는 [Docker for Mac](https://docs.docker.com/docker-for-mac/), [Docker for Windows](https://docs.docker.com/docker-for-windows/)를 설치하거나 [Docker Toolbox](https://www.docker.com/products/docker-toolbox)를 설치하여 사용할 수 있다.

## 설치

맥에서의 설치 방법은 일반 맥앱 설치와 거의 같다. [이 곳](https://docs.docker.com/docker-for-mac/)에서 Stable 버전을 다운로드 받아서 설치하면 된다. `Application`으로 드래그앤 드랍하고 도커 앱을 실행한다.

![Docker for Mac](https://docs.docker.com/docker-for-mac/images/docker-app-drag.png)

메뉴바에 고래 모양이 나타나며, 실행 중이면 애니메이션이 보이고 실행 완료면 멈춘다.

![도커 아이콘](https://docs.docker.com/docker-for-mac/images/whale-in-menu-bar.png)

Docker Engine, Docker CLI client, Docker Compose와 Docker Machine이 설치된다. 다음 명령으로 확인한다.

```shell
docker --version
docker-compose --version
docker-machine --version
```

`run` 옵션으로 헬로월드 `이미지`에서 `컨테이너`를 실행하여 설치가 제대로 되었는지 확인한다:

```shell
docker run hello-world
```

이번엔 우분투 이미지를 설치하고 bash를 실행한다:

```shell
docker run -it ubuntu bash
cat /etc/issue

Ubuntu 16.04 LTS \n \l
```

순식간에 우분투 최신판이 다운로드되고 컨테이너에 접속할 수 있다.

```shell
rm -rf /etc
```

위와 같이 무슨 짓을 하든..

```
exit

docker run -it ubuntu bash
cat /etc/issue

Ubuntu 16.04 LTS \n \l
```

다운로드된 우분투 이미지에서 몇초만에 우분투 컨테이너가 실행된다.

## Images and containers

컨테이너는 이미지를 실행한 것이다. OOP에 비유하면 이미지는 클래스이고 컨테이너는 클래스의 인스턴스다.

현재 설치된 이미지들을 보려면:

```shell
docker images
REPOSITORY          TAG                 IMAGE ID            CREATED             SIZE
ubuntu              latest              42118e3df429        10 days ago         124.8 MB
hello-world         latest              c54a2cc56cbb        4 weeks ago         1.848 kB
```

현재 실행되고 있는 컨테이너 목록을 보려면:

```shell
docker ps
```

지금까지 만든 컨테이너 전체 목록을 보려면 `a` 옵션을 붙인다:

```shell
docker ps -a
```

도커를 훑어보니 공식문서가 잘 되어있다. 나머지는 [Get Started with Docker](https://docs.docker.com/engine/getstarted/)에서부터 편하게 읽어가면 된다.

> 이쯤에서 Oh-My-Zsh의 docker와 docker-compose 플러그인을 추가한다. 자세한 사용법은 [터미널 초보의 필수품인 Oh My ZSH!를 사용하자](http://nolboo.kim/blog/2015/08/21/oh-my-zsh/)를 참조한다.

## Docker Compose

위와 같이 Docker CLI로 Docker 데몬과 통신하면서 작업하는 것보다 Docker-Compose로 작업하는 것이 편리하다. [공식 워드프레스 이미지](https://hub.docker.com/_/wordpress/)를 이용하여 컨테이너를 만들어 보고 실행을 확인해본다.

프로젝트 루트에 `docker-compose.yml`을 만들어 컨테이너들을 관리할 수 있다. Docker CLI가 데몬과 대화하는 방법과 비슷하다.

```yaml
version: '2'

services:

  wordpress:
    image: wordpress
    ports:
      - 8080:80
    environment:
      WORDPRESS_DB_PASSWORD: example

  mysql:
    image: mariadb
    environment:
      MYSQL_ROOT_PASSWORD: example
```

백그라운드로 실행:

다음 명령으로 워드프레스 이미지를 다운받고 `wordpress` 컨테이너와 `mysql` 컨테이너를 만들 수 있다.

```
docker-compose up -d
Creating network "dockerwordpress_default" with the default driver
Pulling wordpress (wordpress:latest)...
latest: Pulling from library/wordpress
357ea8c3d80b: Pull complete
85537f80f73d: Pull complete
3d821ad560e1: Pull complete
.
.
.
e79ff17c8979: Pull complete
8674b9fe92e1: Pull complete
1b3cfb10002c: Pull complete
Digest: sha256:56cd7233bf69a580d823d29ad16c085392abf3fc00b1e4ed7b955b83db2544f7
Status: Downloaded newer image for wordpress:latest
Pulling mysql (mariadb:latest)...
latest: Pulling from library/mariadb
357ea8c3d80b: Already exists
256a92f57ae8: Pull complete
.
.
.
ea263152aba1: Pull complete
Digest: sha256:c5984a0db84a3eaef09bb25af32052686ffa976e15e59789bceb7b5d1678433d
Status: Downloaded newer image for mariadb:latest
Creating dockerwordpress_wordpress_1
Creating dockerwordpress_mysql_1
```

`dockerwordpress_wordpress_1`와 `dockerwordpress_mysql_1`의 두 개의 컨테이너가 만들어졌다. 컨테이너 이름은 도커가 프로젝트 디렉토리와 이미지를 합성하여 만들어준다.

이제 웹브라우저에서 `http://localhost:8080/` 주소를 입력하면 일반적인 워드프레스 설치화면을 볼 수 있다.

## 기타 명령

`docker logs [container_name]`으로 각 컨테이너의 로그를 볼 수 있다. 각 컨테이너에 직접 접속하려면 `exec` 옵션을 사용한다.

```shell
sudo docker exec -i -t [container_name] bash
```

새롭게 컨테이너 만들 때는 아래와 같이 `/bin/bash`를 실행하도록 지정한다:

```shell
docker run -i -t [container_name] /bin/bash
```

컨테이너에 대한 자세한 정보를 보려면:

```shell
docker inspect {컨테이너명}
```

컨테이너를 중지할 때는:

```shell
docker stop [container_name]
```

특정 버전의 이미지를 다운로드할 때는 다음과 같이 태그로 버전을 지정한다:

```shell
docker pull ubuntu:14.04
```

`14.04`와 같이 태그가 주어지지 않으면 `lastest`로 지정되어 최신판을 가져온다.

도커를 연습하면서 쓸모없는 이미지와 컨테이너가 많아졌다. `docker ps -a`로 컨테이너명을 확인하여 삭제한다:

```shell
docker rm {컨테이너명}
docker ps -a
```

다운로드된 이미지를 확인하려면:

```shell
docker images
```

필요없는 이미지를 삭제하려면:

```
docker rmi {이미지 ID}
```

자세한 것은 다음 링크를 참고한다.

- [Overview of docker-compose CLI](https://docs.docker.com/compose/reference/overview/#overview-of-docker-compose-cli)
- [Compose File Reference](https://docs.docker.com/compose/compose-file/)

마지막으로 도커 데몬 프로그램을 끄면 다 내려간다. 편리하다^^

## 참고 링크

- [Understanding Docker, Containers and Safer Software Delivery](https://www.sitepoint.com/docker-containers-software-delivery/)

## 추가 링크

- [Docker로 워드프레스 설치하기](https://wpguide.usefulparadigm.com/posts/257)
- [도커를 이용한 웹서비스 무중단 배포하기](http://subicura.com/2016/06/07/zero-downtime-docker-deployment.html)
- [Introduction to Docker – Medium](https://medium.com/@BuddyWorks/introduction-to-docker-a7d9e1f6c0b3#.814ssi7sj): from Buddy.works
- [초보를 위한 도커 안내서 - 도커란 무엇인가?](https://subicura.com/2017/01/19/docker-guide-for-beginners-1.html)
- [Docker Swarm을 이용한 쉽고 빠른 분산 서버 관리](https://subicura.com/2017/02/25/container-orchestration-with-docker-swarm.html)
