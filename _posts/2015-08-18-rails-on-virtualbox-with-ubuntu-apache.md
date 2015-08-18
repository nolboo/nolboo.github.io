---
layout: post
title: "버추얼박스 우분투에서 아파치와 패신저로 레일즈 프로덕션 모드 실행하기"
description: "가상서버인 버추얼박스에 우분투 14.04를 설치하고 아파치와 패신저로 레일즈앱을 프로덕션 모드로 항상 실행되도록 하는 방법을 정리하였다."
category: blog
tags: [virtualbox, ubuntu, linux, apache, passenger, rails, mysql, production]
---

오라클에서 만든 버추얼박스[VirtualBox](https://www.virtualbox.org/wiki/Downloads)를 다운로드하여 설치한다. 가상머신를 만들어서 우분투 서버를 설치하는 것을 사진과 함께 단계마다 자세하게 설명한 가이드가 있으니 보고 그대로 따라 하면 된다. 시간도 우분투 서버를 다운받는 시간보다 적게 걸린다.

* [우분투 14.04 서버 세팅하기 (Virtual Box) | 초보자를 위한 레일스 가이드북](http://rorlab.gitbooks.io/railsguidebook/content/appendices/ubuntu14server.html) : 우분투를 설치하기위해 가상머신을 시작하기 전에 브리지 어댑터로 설정하는 것을 빼먹으면 처음부터 다시 설치해야하는 불상사가 일어날 수 있다. "서버 웹운영 환경 설정"은 책의 예제에 맞추어져 있기 때문에 자신의 웹앱에 필요한 것을 설치해야한다.
* [우분투 서버 가이드](https://help.ubuntu.com/lts/serverguide/)는 참고용.

## 프로그램 설치

<pre class="terminal">
ssh [user_id]@[서버IP주소]   # user_id와 서버IP주소는 []없이 자신의 것으로 입력

# 여기서부터의 모든 명령어는 별도의 언급이 없는 한 서버에서 실행해야한다.

# 최초 시스템 업데이트
sudo apt-get update
sudo apt-get upgrade

# 자신이 필요한 앱 설치
sudo apt-get install apache2 curl git libmysqlclient-dev mysql-server nodejs
</pre>

<!-- * 최초 시스템 엡데이트 시에 로케일 에러가 나면 `sudo nano /etc/ssh/sshd_config`에서 `AcceptEnv LANG LC_*`을 제외시킨다. [참고링크](http://stackoverflow.com/a/2510548) -->
* mysql-server를 설치할 경우 루트 패스워드를 입력한다. 그렇지 않으면 계속 물어보기 때문에 설치할 때 신중하게 생각해서 입력한다.
* 레일즈의 애셋 파이프라인 컴파일러는 자바스크립트 런타입을 요구하므로 Node.js를 설치해야한다.

웹브라우저에 서버IP주소를 입력하면 다음과 같은 아파치 기본화면을 볼 수 있다.

![](https://farm1.staticflickr.com/684/20407517979_b731fb515b_b.jpg)


### RVM, Ruby 설치

<pre class="terminal">
# 요구되는 앱 설치
sudo apt-get install -y curl gnupg build-essential

# RVM 설치
gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3
curl -L https://get.rvm.io | bash -s stable

sudo addgroup rvm
sudo usermod -a -G rvm [user_id]  :user_id는 []없이 자신의 것으로 입력

if sudo grep -q secure_path /etc/sudoers; then sudo sh -c "echo export rvmsudo_secure_path=1 >> /etc/profile.d/rvm_secure_path.sh" && echo Environment variable installed; fi

exit
</pre>

RVM을 작동시키기위해 서버에 재로그인한다. `service ssh reload`로도 해결될 것 같지만 우분투 깔기 귀찮아서 패스한다.(다른 분이 해보고 제보해주셨으면 합니다:)

<pre class="terminal">
ssh [user_id]@[서버IP주소]   # user_id와 서버IP주소는 []없이 자신의 것으로 입력

# 특정 OS에서 RVM 구동 시 요구되는 라이브러리 설치
rvm requirements --autolibs=enabled
</pre>

원하는 버전의 루비를 설치한다. 최신 버전을 설치하려면:

<pre class="terminal">
rvm install ruby
rvm --default use ruby
rvm list
</pre>

특정 버전(X.X.X)을 설치하려면:

<pre class="terminal">
rvm install ruby-X.X.X
rvm --default use ruby-X.X.X
rvm list
</pre>

## Passenger 설치

Rails Server와 SQLite는 가볍고 간편해서 개발환경에는 적합하나 대량 사용자와 트랙잭션의 서비스에는 적합하지 않다. 그러한 프러덕션 서비스 환경에서 강력한 웹서버와 애플리케이션 서버가 필요하며, Apache와 Passenger가 그 중의 하나이다.

Nginx와 Apache는 웹서버이며, HTTP 트랜잭션을 핸들링하고 정적 파일을 서비스한다. 그러나 루비 애플리케이션 서버가 아니어서 루비 애플리케이션을 직접 돌릴 수 없다. NignX와 Apache는 Passenger와 같은 애플리케이션 서버와 함께 사용되야 한다.

Passenger는 독립실행모드와 Nginx/Apache 결합모드가 있으며, 결합모드에서는 동시에 여러 앱을 호스트할 수 있다. 독립실행모드와 Nginx 결합모드가 Apache 결합모드보다 약간 빠르다.

이제 Passenger를 설치해보자:

<pre class="terminal">
# PGP 키를 설치하고 APT HTTPS 지원을 추가한다.
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys 561F9B9CAC40B2F7
sudo apt-get install -y apt-transport-https ca-certificates

# APT 저장소 추가
sudo sh -c 'echo deb https://oss-binaries.phusionpassenger.com/apt/passenger trusty main > /etc/apt/sources.list.d/passenger.list'
sudo apt-get update

# Passenger + Apache 모듈 설치
sudo apt-get install -y libapache2-mod-passenger
</pre>

패신저 아파치 모듈을 enable하고(이미 되어 있을 수도 있다) 아파치를 재시작한다.

<pre class="terminal">
sudo a2enmod passenger
sudo apache2ctl restart
</pre>

설치를 검증한다. 단 하나의 에러도 나면 안된다.

<pre class="terminal">
sudo passenger-config validate-install
</pre>

아파치가 패신저 코어 프로세스를 시작시켰는지 확인한다. 다음 명령어로 패신저 프로세스와 아파치 프로세스를 모두 볼 수 있어야 한다.

<pre class="terminal">
sudo passenger-memory-stats

sudo apt-get update     # 업데이트는 자주!
sudo apt-get upgrade
</pre>

## 비트버킷을 이용하여 서버에 코드 복사

비트버킷 저장소에 코드를 푸시한다. 비트버킷이나 깃허브에 사용하지 않았던 분은 [완전 초보를 위한 깃허브](https://nolboo.github.io/blog/2013/10/06/github-for-beginner/)를 참조한다. 물론 코드를 서버에 직접 복사하는 방법도 있다.

로컬컴퓨터에서:

<pre class="terminal">
git push
</pre>

푸시한 코드를 서버에서 받기 위해서는 먼저 비트버킷의 설정에서 Deployment key를 설정해야 한다.

* [참고용 비트버킷 가이드](https://confluence.atlassian.com/display/BITBUCKET/Set+up+SSH+for+Git)

우분투 서버에서:

<pre class="terminal">
ssh-keygen
# 이 다음은 그냥 엔터로 답하여 기본값으로 넘어간다.
Generating public/private rsa key pair.
Enter file in which to save the key (/home/user_/.ssh/id_rsa):
Created directory '/home/user_id/.ssh'.
Enter passphrase (empty for no passphrase):
Enter same passphrase again:
Your identification has been saved in /home/user_id/.ssh/id_rsa.
Your public key has been saved in /home/user_id/.ssh/id_rsa.pub.
The key fingerprint is:
.
.
.

cat ~/.ssh/id_rsa.pub
</pre>

cat 명령으로 출력된 부분을 비트버킷의 Deployment 키로 등록하여 우분투 서버가 비트버킷 저장소를 읽을 수 있도록 한다.

* [참고용 비트버킷 가이드](https://confluence.atlassian.com/display/BITBUCKET/Use+deployment+keys)  


<pre class="terminal">
cd /var/www/
sudo git clone [https://user_id@github.com/user_id/myapp.git]   #[]은 비트버킷 저장소의 이름
cd [myapp]                                      #myapp은 []없이 자신의 앱 이름
</pre>

* 비트버킷 연결 프로토콜은 HTTPS를 확실히 선호하게 되었다. SSH로 시도하는 동안 계속해서 키 에러가 나서 [Troubleshoot SSH Issues](https://confluence.atlassian.com/display/BITBUCKET/Troubleshoot+SSH+Issues)에 있는 것을 전부 시도했지만 점점 꼬여만 갈뿐이었다.

Bundler 설치하고 실행하여, 앱 의존성`dependency`을 모두 설치한다.

<pre class="terminal">
gem install bundler
bundle install
</pre>

## MySQL과 세션 암호화 키 설정

<pre class="terminal">
sudo nano Gemfile
</pre>

`Gemfile`에서 프로덕션 그룹에서 사용할 데이터베이스 gem를 지정한다.

```ruby
group :production do
  gem 'mysql2'
end
```

mysql 명령을 실행하여 데이터베이스를 만든다. 데이터베이스 이름으로 myapp_production을 사용했으나, 자신이 선호하는 이름으로 지정할 수 있다. 단, 설정 파일에도 적어야 하니 기억은 해놓아야 한다.

<pre class="terminal">
mysql -u root -pPASSWORD  # PASSWORD는 설치 시 입력하였던 루트 비밀번호
mysql> CREATE DATABASE myapp_production DEFAULT CHARACTER SET utf8;
mysql> GRANT ALL PRIVILEGES ON myapp_production.*
    ->   TO 'username'@'localhost' IDENTIFIED BY 'password';  # username과 password는 자신의 것으로 하여 사용자를 추가한다.
mysql> EXIT;
</pre>

이제 루트 유저가 아닌 `mysql -u username -ppassword`로도 mysql을 실행할 수 있다. 

<pre class="terminal">
sudo nano config/database.yml
</pre>

`config/database.yml`의 프로덕션 섹션에 다음과 같이 MySQL 관련 정보를 입력한다.

```ruby
production:
  adapter: mysql2
  encoding: utf8
  reconnect: false
  database: myapp_production
  pool: 5
  username: username
  password: password
  host: localhost
```

username, password, database는 자신의 것으로 바꾼다.

레일즈에서는 세션을 암호화하기 위해 특정 시크릿 키를 필요로 한다. 이것을 `config/secrets.yml`에 저장한다. 개발과 테스트용 시크릿 키는 로컬에서 자동으로 생성되지만, 프로덕션용 시크릿 키는 수동으로 생성해야 한다.

<pre class="terminal">
rake secret
698b2bfc9e8e1...    # 이 줄을 복사
</pre>

생성된 시크릿 키를 복사하여 `config/secrets.yml`의 `<%= ENV["SECRET_KEY_BASE"] %>` 부분을 지우고 붙여넣는다.

```yaml
production:
  secret_key_base: 698b2bfc9e8e1... # 여기에 값으로 붙여넣는다
```

시스템의 다른 유저가 앱의 민감한 정보를 방해하지 못하도록 설정 디렉토리와 데이터베이스 디렉토리의 보안을 강화한다.

<pre class="terminal">
chmod 700 config db
chmod 600 config/database.yml config/secrets.yml
</pre>

이제 마이그레이션을 적용한다.

<pre class="terminal">
rake db:setup RAILS_ENV="production"
</pre>

출력된 메시지로 데이타베이스가 제대로 생성되었는지 알 수 있지만, 확인하기 위해 기본적인 SQL 명령어로 데이터베이스를 볼 수도 있다.

<pre class="terminal">
mysql -u username -ppassword
mysql> SHOW TABLES;         # 생성된 테이블 목록을 본다
mysql> EXPLAIN tablename;   # 테이블 구조를 본다.
mysql> status               # 현재 상태 보기
mysql> exit
</pre>

## 아파치와 패신저 설정

<pre class="terminal">
passenger-config about ruby-command
passenger-config was invoked through the following Ruby interpreter:
  Command: /home/user_id/.rvm/gems/ruby-2.0.0-p643/wrappers/ruby    # 이 경로
  Version: ruby 2.0.0p643 (2015-02-25 revision 49749) [x86_64-linux]
  ...
</pre>

`Command:` 뒤에 나온 경로는 뒤에서 사용해야 하니 별도로 복사해 놓는다.

앱의 아파치 설정 파일을 만들고 버추얼 호스트가 자신의 앱을 지정하도록 설정한다.

<pre class="terminal">
sudo nano /etc/apache2/sites-available/myapp.conf
</pre>

`myapp`은 자신의 것으로 바꾼다. 아래 설정 내용에서도 자신의 것으로 바꾼다.

```apache
<VirtualHost *:80>
   ServerName yourserver.com

   DocumentRoot /var/www/myapp/public

   PassengerRuby /home/user_id/.rvm/gems/ruby-2.0.0-p643/wrappers/ruby

   <Directory /var/www/myapp/public>
      Allow from all
      Options -MultiViews
      Require all granted
   </Directory>
</VirtualHost>
```

* `ServerName`은 자신의 서버 호스팅 이름 또는 서버IP주소를 입력해야한다. 
* `DocumentRoot`는 반드시 자신의 레일즈 앱의 _public_ 디렉토리를 입력해야 한다. 
* `PassengerRuby`는 위에서 복사해 놓은 루비 경로 `/home/user_id/.rvm/gems/ruby-2.0.0-p643/wrappers/ruby`를 입력한다. 
* `Require all granted`는 아파치 2.4 이상에서 필요하다.

더 자세한 설정은 패신저 [Configuration reference](https://www.phusionpassenger.com/library/config/apache/reference/)을 참조한다.

이제 기본 아파치 서버를 내리고 자신의 레일즈앱 myapp을 올릴 순간이다.

<pre class="terminal">
sudo a2dissite 000-default
sudo a2ensite myapp.conf
sudo apachectl restart
</pre>

웹브라우저에 자신의 서버 주소를 입력하면 자신의 레일즈앱이 떠야 정상이다. 이 글을 쓰면서 두세번의 설치를 했는데 아래와 같은 에러가 낫다. (아래 화면은 패신저 친화적 에러 옵션을 킨 상태이고 이는 프로덕션 모드에서는 지양해야 하는 일이다. 에러가 해결되면 다시 원래대로 돌려놓아야 한다.)

### 패신저와 아파치가 자동으로 앱을 찾는 방법

버추얼 호스트 루트를 앱의 정적 에셋 디렉토리로 지정하면 Ruby, Python, Node.js 웹앱을 시작하는 방법을 패신저가 자동으로 추리한다. 그런 방식으로 "convention over configuration" 철학을 따른다. 루비와 루비온레일즈의 경우 앱의 루트에 `config.ru` 파일이 있는지도 체크한다. 몇 개의 환경변수 옵션으로 직접 지정하는 방법도 있다. 자세한 것은 [How Passenger + Apache autodetects applications](https://www.phusionpassenger.com/library/indepth/ruby/app_autodetection/apache/)을 참조한다.

### 경험한 에러와 해결

![](https://farm6.staticflickr.com/5771/19999626564_d891f6d8b4_z.jpg)

위와 같은 에러가 나서 로그파일을 봤더니 권한 문제가 있어서 아래와 같이 해결하였다.

<pre class="terminal">
sudo chown -R username:group /var/www/myapp/
sudo apachectl restart
</pre>

`username:group /var/www/myapp/`은 자신의 것으로 입력한다. chown 등의 권한 관리에 익숙치 않으면 간단한 번역글 [리눅스 사용자와 그룹](http://nolboo.github.io/blog/2015/08/18/linux-users-groups/)을 참고한다.

## 참고링크

* [Deploying a Ruby app with Passenger to production - Passenger Library](https://www.phusionpassenger.com/library/walkthroughs/deploy/ruby/)
* [Agile Web Development with Rails 4](https://pragprog.com/book/rails4/agile-web-development-with-rails-4)

## TODO

* 패신저와 웹앱을 돌릴 경우에 `user switching`이라고도 알려진 `user account sandboxing`을 추천하고있다.(출처: [Sandboxing apps with Unix user accounts (user switching)](https://www.phusionpassenger.com/library/deploy/apache/user_sandboxing.html)) 다음 번에는 이 글을 유저 스위칭으로 업그레이드하려고 한다.
* AWS EC2에 올려본다.