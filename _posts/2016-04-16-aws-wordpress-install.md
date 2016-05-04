---
layout: post
title: "아마존 AWS 클라우드에 무료로 워드프레스 설치하기"
description: "아마존의 클라우드 서비스 AWS의 free tier EC2에 워드프레스 설치하는 방법"
category: blog
tags: [amazon, aws, ec2, wordpress, install]
---

AWS(아마존 웹 서비스:Amazon Web Services)는 웹 서비스에 관련된 사람이라면 한번쯤은 경험해야할 서비스가 되어버렸다. [Microsoft Azure](https://azure.microsoft.com/ko-kr/)가 기업시장을 중심으로 열심히 치고 올라오고 구글도 [Google Cloud Platform](https://cloud.google.com/)을 제공하고 있지만 앞으로도 AWS가 시장점유율 31%로 1위인 추세는 당분간 계속될 것 같다. 2위인 MS Azure는 2015년 기준 9% 정도다. 올해 초 [AWS Asia Pacific (Seoul) Region 정식 오픈!](https://aws.amazon.com/ko/blogs/korea/now-open-aws-asia-pacific-seoul-region/)을 계기로 국내에서도 그 수요가 더 늘어날 것이다.

현재 제공되는 클라우드 서비스의 종류는 이제 따로 공부해야만 따라갈 수 있을 정도로 많다. 그 중에서 가장 기본이 되는 가상 서버 서비스인 Amazon EC2(Amazon Elastic Compute Cloud)에서는 무료 사용량을 [AWS 프리 티어:Free Tier](https://aws.amazon.com/ko/free/)란 이름으로 제공하고 있다. 여기에 워드프레스를 올려보자. 참고로 후발자인 애저도 [무료 계정](https://azure.microsoft.com/ko-kr/free/))을 제공하고 용량도 더 많이 제공한다. 그러나 아직 써보지 않았다.

<div id="toc"><p class="toc_title">목차</p></div>

## Amazon EC2 Linux 인스턴스 생성

AWS 계정을 만들고 인스턴스를 생성하는 것은 이제 많은 가이드가 나와있으니 여기서는 생략한다. 다음 링크를 참조하여 생성한다.

* [Amazon EC2 Linux 인스턴스 시작하기](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/EC2_GetStarted.html): 아마존 공식 한글 가이드
* [인스턴스 생성 - 생활코딩](https://opentutorials.org/course/608/3056): 한글 비디오 가이드
* [아마존 웹 서비스를 다루는 기술 4장 - 3. EC2 인스턴스 생성하기](http://pyrasis.com/book/TheArtOfAmazonWebServices/Chapter04/03): AWS 한글 책을 가장 만저 출간한 저자가 책 전문을 공개했다.

위의 링크에서 기본 내용을 익히되 실제 생성은 다음 내용을 기준으로 진행한다.

### 리전 선택

[EC2 Management Console](https://console.aws.amazon.com/ec2/)에서 Launch Instance 버튼을 눌러 인스턴스 생성하기 전에 먼저 우측 위에서 Seoul 리전을 선택한다. 리전에 대한 자세한 설명은 [지역 및 가용 영역](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/using-regions-availability-zones.html)을 참고한다.

![지역 선택기](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/images/EC2_select_region.png)
*아마존 자습서에 있는 이미지는 Oregon을 선택하고 있다. 밑에서 두번째 Seoul을 선택한다.*

한국은 국내 인터넷 속도는 세계최고이나 해외 인터넷 속도는 그리 높지 않기 때문에 서버를 한국에 있는 것이 빠른 경우가 많다.

* [AWS Network latency check](http://cloudping.mobilfactory.co.kr/)

### Amazon Machine Image (AMI) 선택

아마존 머신 이미지([AMI](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/ComponentsAMIs.html))는 미리 리눅스와 같은 OS를 설치한 컴퓨터의 루트 드라이브 템플릿 같은 것이다. 당연히 OS와 데이터베이스 서버, 미들웨어, 웹서버 등과 같은 소프트웨어와 래이어를 포함하고 있다. 가상 서버를 만들 때마다 요구되는 지루한 작업을 피할 수 있다. AWS에서 리눅스를 사용할 때는 다른 익숙한 OS가 없다면 Amazon Linux AMI 2016.03.0 (HVM), SSD Volume Type을 선택한다. [Amazon Linux AMI](https://aws.amazon.com/ko/amazon-linux-ami/)는 기본적으로 AWS와 통합되어 있고, 가볍고 보안이 강화되어 있다고 한다.

### Choose an Instance Type

[EC2 인스턴스 유형](https://aws.amazon.com/ko/ec2/instance-types/) 중 프리티어가 되는 **t2.micro**((1GiB 메모리, 32비트 및 64비트 플랫폼 지원))를 선택한다. 한달에 750시간 동안 사용하는 용량을 무료로 주는데 750시간/31일이 24시간을 넘어가니 한 대만 사용할 경우 1년간은 과금이 되지 않는다. 윈도우 서버를 하나 더 무료로 만들 수 있다. 그 외 무료로 주는 것도 있으며, 자세한 것은 [프리티어 FAQ](https://aws.amazon.com/ko/free/faqs/)을 참조한다.

옵션에서 **터미네이트 제한 가능을 선택**하여 실수로 종료시키는 것을 막는다. 인스턴스 stop은 각종 데이타가 남지만 terminate하게되면 서버를 지워버려 완전히 새로 인스턴스를 시작하고 모든 설치와 설정을 다시 해야한다. stop하고 start하는 것은 컴퓨터를 재부팅하는 것과 같지만 터미네이트하고 새 인스턴스를 론칭하는 것은 쓰던 컴퓨터를 팔아버리고 새로운 컴퓨터를 사는 것과 같다고 보면 된다.

* CloudWatch detailed monitoring는 별도 과금된다.

#### Add Storage

기본인 Add New Volume 8G를 선택한다.

#### Tag Instance

Wordpress 등의 적당한 이름을 준다.

#### Configure Security Group

새로운 보안 그룹을 선택하여 SSH(포트 22), HTTP(포트 80), HTTPS(포트 443) 연결을 허용할 수 있도록 구성한다.

Create a new key pair를 선택하여 private key file(*.pem)을 **반드시 다운로드받아야 한다**. 이름은 마음대로 주어도 되나 여기서는 wordpress.pem으로 한다.

마지막으로 인스턴스를 생성하면 약간의 시간이 지난 뒤 pending되었던 인스턴스가 초록색의 running으로 바뀌면 자신의 가상 리눅스 서버를 갖게 된다.

## SSH 

상단의 Connect를 누르면 서버에 접속하는 방법이 뜬다. 그대로 하면 되나 먼저 아까 다운로드받은 개인키 파일(wordpress.pem)을 `~/.ssh`로 이동하고 파일 권한을 변경한다.

<pre class="terminal">
mv ~/Downloads/wordpress.pem ~/.ssh
chmod 400 wordpress.pem
</pre>

리눅스 서버에 터미널의 ssh 명령으로 접속한다. 첫번째는 Public DNS로 접속하는 방법이고, 두번째는 Public IP로 접속하는 방법이다. Public DNS와 Public IP는 AWS에서 인스턴스를 선택하면 아래에 여러 정보가 나오는 화면에서 얻을 수 있다.

<pre class="terminal">
ssh -i "wordpress.pem" ec2-user@ec2-52-xxx-xxx-xxx.ap-northeast-2.compute.amazonaws.com
ssh -i "wordpress.pem" ec2-user@52.xxx.xxx.xxx
</pre>

처음 연결하는 원격 서버라고 물으면 yes 선택하여 known host 파일에 리눅스 서버 인스턴스를 추가한다. 접속한 후에 연결을 끊고 싶으면 `exit` 명령어로 로컬 컴퓨터로 돌아올 수 있다.

한번 AWS 리눅스 서버를 만들면 정말 많이 접속하게 되므로 `~/.ssh/config` 파일을 만들거나 편집하여 리눅스 서버 호스트 이름을 등록한다.

* ssh 접속을 위한 개인키 파일을 `~/.ssh/`가 아닌 다른 디렉토리에 저장하여도 된다. 그런 경우에는 `~/.ssh/config` 파일을 만들 때 `IdentityFile`의 `wordpress.pem`값 앞에 디렉토리 전체 경로를 넣어주어야 한다.

<pre class="terminal">
nano ~/.ssh/config
</pre>

```
Host aws                    // aws 대신 원하는 이름을 줄 수 있다.
HostName 52.xxx.xxx.xxx     // 인스턴스에 주어진 public IP
User ec2-user
IdentityFile wordpress.pem  // 다른 디렉토리에 개인키를 저장한 경우 전체경로를 포함하여 적어야 한다.
```

저장한 후에 `~/.ssh/config` 파일에 읽고 쓰는 권한을 준다.

<pre class="terminal">
chmod 600 ~/.ssh/config
</pre>

이제 접속해본다.

<pre class="terminal">
ssh aws
sudo yum update     // 시스템을 최신으로 업데이트한다.
</pre>

### Oh-my-Zsh 설치

ssh로 접속하면 기본 쉘인 bash를 사용하게 되는데 쉘 환경을 편리하고 화려하게 만드려면 Oh-My-Zsh를 설치하면 좋다. 설치를 위해 간단히 명령어만 나열하면 다음과 같다.

<pre class="terminal">
yum install zsh
which zsh           // 쉘의 위치를 확인
/bin/zsh
sudo su             // AWS는 root 비밀번호를 제공하지 않으므로 이 명령으로 수퍼유저 권한을 잠시 획득
chsh -s /bin/zsh    // 기본 쉘을 zsh로 변경
exit
ssh aws
curl -L https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh | sh
</pre>

그 외 사용법과 추가적인 설정은 [터미널 초보의 필수품인 Oh My ZSH!를 사용하자](http://nolboo.github.io/blog/2015/08/21/oh-my-zsh/)를 참조한다.

## (L)AMP 패키지 그룹 설치

워드프레스를 설치하기 위해서는 보통 [LAMP](https://www.wikiwand.com/ko/LAMP)라고 줄여부르는 Linux(리눅스 운영체제), Apache (아파치 웹 서버), MySQL / MariaDB 데이터베이스 관리 시스템(데이터베이스 서버), PHP 프로그래밍 언어를 설치해야 한다. 이미 리눅스는 설치하였으니 나머지 AMP를 설치한다. [자습서: Amazon LinuxLAMP 웹 서버 설치](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/install-LAMP.html)에서와 같이 설치할 수도 있지만, 여기서는 yum의 패키지 그룹 설치로 한방에 설치한다.

<pre class="terminal">
sudo yum groupinstall -y "Web Server" "MySQL Database" "PHP Support"
</pre>

`-y`는 설치 중간에 물어보는 모든 질문에 yes로 대답하는 옵션이다. [패키지 설치](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/install-software.html)는 일반적으로 `yum install 패키지` 명령으로 설치한다. 패키지 그룹은 `""`으로 감싸준다. 다음 두 명령 중 하나로 설치한 그룹과 설치가능한 그룹을 확인한다.

<pre class="terminal">
yum grouplist
yum groups list
</pre>

```
Loaded plugins: priorities, update-motd, upgrade-helper
Installed groups:
   MySQL Database
   PHP Support
   Web Server
Available Groups:
   Console internet tools
   DNS Name Server
   Development Libraries
   Development tools
   Editors
   FTP Server
   Java Development
   Legacy UNIX compatibility
   Mail Server
   MySQL Database client
   NFS file server
   Network Servers
   Networking Tools
   Performance Tools
   Perl Support
   PostgreSQL Database client (version 8)
   PostgreSQL Database server (version 8)
   Scientific support
   System Tools
   TeX support
   Technical Writing
   Web Servlet Engine
Done
```

`yum groupremove` 명령으로 설치된 그룹을 삭제할 수도 있다. 조금 더 공부하고 싶다면 [How to Simplify Linux Package Installation With Yum Groups](https://www.linux.com/learn/how-simplify-linux-package-installation-yum-groups)을 보라.

php-mysql 모듈만 추가로 설치한다.

<pre class="terminal">
sudo yum install -y php-mysql
</pre>

이제 설치된 아파치 웹서버와 MySQL 데이터베이스 서버를 실행한다.

<pre class="terminal">
sudo service httpd start
sudo service mysqld start
</pre>

두 개의 주요 서버가 부팅될 때마다 자동으로 실행하게 한다. PHP는 아파치가 시작되면 자동으로 시작되니 별도로 설정할 필요가 없다.

<pre class="terminal">
sudo chkconfig httpd on
sudo chkconfig mysqld on
</pre>

`chkconfig` 명령은 성공적으로 서비스를 활성화했을 경우에는 아무런 확인 메시지를 표시하지 않는다. 다음 명령을 실행해서 `httpd`가 실행되고 있는지 확인할 수 있다.

<pre class="terminal">
chkconfig --list httpd
httpd           0:off   1:off   2:on    3:on    4:on    5:on    6:off
</pre>

`httpd`가 2, 3, 4, 5의 실행 레벨(사용자가 보기 원하는 부분)에서 on 상태다. `mysqld`도 `chkconfig --list mysqld` 명령으로 확인할 수 있다.

이제 Amazon EC2 콘솔의 Public IP를 웹브라우저에 입력하면 아래와 같은 화면이 나타난다.

![](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/images/apache_test_page2.4.png)
[자습서: Amazon LinuxLAMP 웹 서버 설치)의 이미지

이 페이지는 `/var/www/html`가 비어있는 경우에 보이는 테스트 페이지다.

## 웹사이트 폴더 설정

아파치 `httpd`는 'Acache document root'라는 디렉터리에 보관된 파일을 처리한다. Amazon Linux Apache document root는 `/var/www/html`이며, 이는 기본적으로 root가 소유권을 가지고 있다.

접속한 ec2-user가 상기 디렉터리 내 파일을 조작할 수 있도록 하려면 디렉터리의 소유권과 권한을 변경해야 한다. Apache 웹서버는 www라는 그룹의 apache라는 사용자로 돌린다. 이름은 달라도 상관 없다. 보안 상의 이유로 계정 없는 사용자를 만들어 돌리는 게 관례이다. www 그룹을 추가하고 해당 그룹에 대해 /var/www 디렉터리의 소유권을 부여하고 쓰기 권한을 추가한다. 해당 그룹의 모든 멤버는 웹 서버에 대해서 파일의 추가, 삭제, 수정을 할 수 있다.

Apache 웹서버 설정파일은 `/etc/httpd/conf` 아래에 있고 기본 설정 파일은 `/etc/httpd/conf/httpd.conf`이다. PHP 설정 파일은 `/etc/php.ini`이다.

### 권한 설정

접근 권한을 설정한다. www 그룹을 만들고 ec2-user를 추가한다. apache 라는 사용자도 www 그룹에 추가한다.

<pre class="terminal">
sudo groupadd www
sudo usermod -a -G www ec2-user
sudo usermod -a -G www apache
exit        // 접속을 끊었다가
ssh aws     // 다시 접속한다.
</pre>

www 그룹에 대한 멤버십을 확인한다.

<pre class="terminal">
groups
ec2-user wheel www
</pre>

`/var/www` 및 그 콘텐츠의 그룹 소유권을 www 그룹으로 변경한다. 하위 폴더까지 전부 적용하기 위해 -R 옵션을 준다.

<pre class="terminal">
sudo chown -R root:www /var/www
</pre>

[chmod](https://www.wikiwand.com/ko/Chmod) 명령으로 www 그룹에 쓰기 권한을 준다. 먼저 폴더부터 설정한다. 두번째 명령어는 하위 폴더를 훑어가며 쓰기 권한을 주고 앞으로 생길 폴더에도 기본으로 쓰기 권한을 주도록 설정한다.

<pre class="terminal">
sudo chmod 2775 /var/www
find /var/www -type d -exec sudo chmod 2775 {} +
</pre>

이어서 파일에도 적용한다.

<pre class="terminal">
find /var/www -type f -exec sudo chmod 0664 {} +
</pre>

* [explainshell.com](http://explainshell.com/explain?cmd=find+%2Fvar%2Fwww+-type+d+-exec+sudo+chmod+2775+%7B%7D+%2B)을 이용하여 명령어를 분석해 볼 수 있다.
* 조금 더 자세한 설명은 [What's the best way of handling permissions for apache2's user www-data in /var/www?](http://serverfault.com/questions/6895/whats-the-best-way-of-handling-permissions-for-apache2s-user-www-data-in-var/65416#65416)를 참조한다.

### LAMP 웹 서버 테스트

권한을 제대로 주었다면 Apache 문서 루트에서 간단한 PHP 파일을 생성할 수 있다.

<pre class="terminal">
echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php
</pre>

`http://52.xxx.xxx.xxx/phpinfo.php`를 웹브라우저로 확인한다.

![](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/images/phpinfo5.6.6.png)

위의 화면이 보이면 Apache, MySQL, PHP가 모두 잘 돌아가고 있는 것이다.

이 페이지가 보여주는 정보는 사용자에게 유용하지만 해커들에게 유용하므로 `phpinfo.php` 파일을 지운다.

<pre class="terminal">
rm /var/www/html/phpinfo.php
</pre>

MySQL 서버의 루트 사용자 암호를 설정한다.

<pre class="terminal">
sudo mysql_secure_installation
</pre>

현재 root 암호 넣으라고 하는데, 기본적으로 root 계정은 암호 세트를 가지고 있지 않으므로 Enter를 누른다.

루트 암호를 설정하겠냐고 물어보면, Y를 입력하고 암호를 입력한다. 익명 사용자도 제거하고, 원격 root 로그인을 허락하지 않고, test 데이터베이스도 제거한다. 마지막으로 권한 테이블을 다시 로드하고 변경사항을 저장한다.

```
Enter current password for root (enter for none):
Set root password? [Y/n] Y

Remove anonymous users? [Y/n] Y
Disallow root login remotely? [Y/n] Y
Remove test database and access to it? [Y/n] Y
Reload privilege tables now? [Y/n] Y
```

MySQL 서버 설정이 끝났다. 이제 워드프레스를 설치한다.

## WordPress 설치

[자습서: Amazon Linux를 통한 WordPress 블로그 호스팅 - Amazon Elastic Compute Cloud](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/hosting-wordpress.html)

워드프레스 최신 버전을 다운로드하여 압축을 풀어준다. **ec2-user** 홈 폴더에서:

<pre class="terminal">
wget https://wordpress.org/latest.tar.gz    // 워드프레스 최신 버전을 다운로드
tar -xzf latest.tar.gz                      // 압축을 푼다.
</pre>

홈 폴더 밑에 `wordpress` 라는 폴더에 워드프레스 파일들이 압축 해제된다.

### WordPress 설정

wordpress 폴더에서 **wp-config-sample.php**를 **wp-config.php**로 복사한다.

<pre class="terminal">
cd wordpress/
cp wp-config-sample.php wp-config.php
nano wp-config.php
</pre>

워드프레스에서 사용할 데이터베이스 이름, 사용자, 비밀번호를 입력한다. 

```
define('DB_NAME', 'wordpress-db');
define('DB_USER', 'wordpress-user');
define('DB_PASSWORD', 'strong_password');
```

#### Authentication Unique Keys and Salts

이 KEY 및 SALT 값은 WordPress 사용자가 로컬 컴퓨터에 저장하는 브라우저 쿠키에 암호 계층을 제공한다. 기본적으로 긴 무작위 값을 추가해서 사이트의 보안성을 강화할 수 있다. wordpress.org의 [https://api.wordpress.org/secret-key/1.1/salt/](https://api.wordpress.org/secret-key/1.1/salt/)에서 무작위로 생성하여 `wp-config.php` 파일로 복사한다. 아래 내용은 이런 형식으로 생성된다는 것을 보여주기 위한 것이니, 이 값을 사용하지 말라.

```conf
define('AUTH_KEY',         ' #U$$+[RXN8:b^-L 0(WU_+ c+WFkI~c]o]-bHw+)/Aj[wTwSiZ<Qb[mghEXcRh-');
define('SECURE_AUTH_KEY',  'Zsz._P=l/|y.Lq)XjlkwS1y5NJ76E6EJ.AV0pCKZZB,*~*r ?6OP$eJT@;+(ndLg');
define('LOGGED_IN_KEY',    'ju}qwre3V*+8f_zOWf?{LlGsQ]Ye@2Jh^,8x>)Y |;(^[Iw]Pi+LG#A4R?7N`YB3');
define('NONCE_KEY',        'P(g62HeZxEes|LnI^i=H,[XwK9I&[2s|:?0N}VJM%?;v2v]v+;+^9eXUahg@::Cj');
define('AUTH_SALT',        'C$DpB4Hj[JK:?{ql`sRVa:{:7yShy(9A@5wg+`JJVb1fk%_-Bx*M4(qc[Qg%JT!h');
define('SECURE_AUTH_SALT', 'd!uRu#}+q#{f$Z?Z9uFPG.${+S{n~1M&%@~gL>U>NV<zpD-@2-Es7Q1O-bp28EKv');
define('LOGGED_IN_SALT',   ';j{00P*owZf)kVD+FVLn-~ >.|Y%Ug4#I^*LVd9QeZ^&XmK|e(76miC+&W&+^0P/');
define('NONCE_SALT',       '-97r*V/cgxLmp?Zy4zUU4r99QQ_rGs2LTd%P;|_e1tS)8_B/,.6[=UK<J_y9?JWG');
```

반드시 자기만의 키를 만들어야 한다. 보안 키에 대한 자세한 내용은 [Editing wp-config.php](http://codex.wordpress.org/Editing_wp-config.php#Security_Keys)를 참조한다.

### WordPress에서 사용할 MySQL 사용자 및 데이터베이스 생성

MySQL 서버에 접속한다.

<pre class="terminal">
$ mysql -u root -p
Enter password:
</pre>

앞서 설정한 MySQL `root` 사용자 암호를 입력한다. MySQL 클라이언트가 실행되면 다음 프롬프트가 나타난다.

<pre class="terminal">
mysql>
</pre>

앞서 만든 워드프레스 사용자 이름과 비밀번호로 워드프레스가 MySQL 데이터베이스에 접속할때 사용하는 사용자를 만든다.

<pre class="terminal">
mysql> CREATE USER 'wordpress-user'@'localhost' IDENTIFIED BY 'strong_password'; 
Query OK, 0 rows affected (0.00 sec)
</pre>

localhost 즉, 리눅스 서버 인스턴스에서만 접근할 수 있도록 한다.

워드프레스가 사용할 데이터베이스를 만든다. 데이터베이스 이름을 둘러싼 기호는 백틱`backtick`(`)이다. 표준 키보드에서 Tab 키 위에 틸더(~)와 함께 있다. 백틱으로 감싸면 데이터베이스 이름에 하이픈(-) 등 허용되지 않는 문자를 사용할 수 있다.

<pre class="terminal">
mysql> CREATE DATABASE `wordpress-db`; 
Query OK, 1 row affected (0.01 sec)
</pre>

`wordpress-user` 사용자에게 `wordpress-db` 데이터베이스에 관한 전체 권한을 준다.

<pre class="terminal">
mysql> GRANT ALL PRIVILEGES ON `wordpress-db`.* TO "wordpress-user"@"localhost"; 
Query OK, 0 rows affected (0.00 sec)
</pre>

MySQL 권한을 새로고침(flush)해서 모든 변경사항이 적용되도록 한다.

<pre class="terminal">
mysql> FLUSH PRIVILEGES; 
Query OK, 0 rows affected (0.01 sec)
</pre>

물리적으로 데이터베이스에 영향을 주지않는 GRANT의 경우에는 FLUSH가 필요없다고 주장하는 글도 있는 등 헷갈리지만 [아마존 공식 가이드](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/hosting-wordpress.html)에서도 권장하므로 그냥 FLUSH한다. 관련 글:

* [When Privilege Changes Take Effect](http://dev.mysql.com/doc/refman/5.7/en/privilege-changes.html)
* [MySQL: Grant Privileges followed by Flush Privileges has not effect, no error (logged in as root)](http://stackoverflow.com/questions/12116099/mysql-grant-privileges-followed-by-flush-privileges-has-not-effect-no-error-l)
* [MYSQL's "FLUSH PRIVILEGES" equivalent in SQL Server?](http://stackoverflow.com/questions/18066155/mysqls-flush-privileges-equivalent-in-sql-server)
* [Stop using FLUSH PRIVILEGES](http://dbahire.com/stop-using-flush-privileges/)
* [MySQL flush privileges 명령어](http://www.webmadang.net/database/database.do?action=read&boardid=4003&page=1&seq=23)

mysql 클라이언트를 종료한다.

<pre class="terminal">
mysql> exit
Bye
</pre>

### 설치 파일을 Apache 문서 루트로 이동

`wordpress` 폴더에 설치된 것을 Apache 문서 루트 `/var/www/html/`로 옮긴다.

<pre class="terminal">
$ mv * /var/www/html/
</pre>

Wordpress 설치를 Apache 문서 루트로 이동시킨 후에는 WordPress 설치 스크립트가 보호되지 않기 때문에 침입자가 블로그에 액세스를 할 수 있다. `sudo service httpd stop` 명령으로 Apache 웹 서버를 중단시키거나 다음 방법에 따라 Apache 문서 루트에서 모든 재정의를 허용한다.

<pre class="terminal">
sudo nano /etc/httpd/conf/httpd.conf
</pre>

```
<Directory "/var/www/html">
...
AllowOverride All 
...
```

None을 All로 변경한다. 여러 개가 있기 때문에 반드시 `<Directory "/var/www/html">` 밑에 값만 변경해야 한다.

### Apache 웹 서버에 대한 파일 권한 수정

사용자와 그룹이 **ec2-user.ec2-user**이므로 **apache.www**로 바꿔줘야 한다. 소유 권한을 바꾸고 웹서버를 다시 시작하여 적용한다.

<pre class="terminal">
$ sudo chown -R apache.www /var/www
$ find /var/www -type d -exec sudo chmod 2775 {} +
$ find /var/www -type f -exec sudo chmod 0664 {} +
$ sudo service httpd restart
</pre>

이제 웹브라우져로 `http://54.XXX.XXX.XXX/`인 Public IP로 접속하면 아래와 같은 워드프레스 설치 화면을 볼 수있다.

![워드프레스 최초 설정화면](http://cdn.creativeworksofknowledge.com/wp-content/uploads/2014/08/aws-wordpress04-825x1024.jpg)

Welcome to WordPress

- WordPress 사이트의 이름을 `[사이트 제목]`에 입력한다.
- WordPress 관리자의 이름을 `사용자명`에 입력한다. 보안을 위해 사용자의 기본 사용자 이름(admin)보다 어려운 이름을 선택한다. 
- 강력한 비밀번호를 입력한다.
- 알림에 사용할 이메일 주소를 입력합니다.

> 위의 정보를 입력하는 페이지의 가장 마지막에 있는 Privacy 항목에서 검색엔진이 검색목록에 포함하지 않도록 한다. 사이트가 모두 완성된 후 완성된 정보가 검색목록에 포함되도록 한다.

[Install WordPress]를 클릭해서 설치를 완료한다.

## 자신만의 워드프레스 AMI 만들기(유료)

[Amazon EBS 지원 Linux AMI 생성](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/creating-an-ami-ebs.html)을 참조하여 자신만의 워드프레스 설정이 완료된 머신 이미지를 만들 수 있다.

[EC2 콘솔](https://console.aws.amazon.com/ec2/) 탐색 창에서 [Instances]를 선택하고 인스턴스를 선택합니다. [Actions] > [Image] > [Create Image]을 차례로 선택한 이후 이름과 설명을 입력하면 워드프레스 AMI가 만들어진다.

시간이 조금 지난 후 만들어진 AMI는 탐색창에서 [Images] > [AMI] > [Launch] 를 차례로 선택하고 이후 원하는 용량 타입의 인스턴스를 선택하면 새로운 서버 유형에 지금까지 만들어진 설치내용을 그대로 실은 새로운 서버를 만들 수 있다. 단, 매우 편리한 기능이나 AMI가 저장된 용량만큼 과금된다.

## 기타

- [Website speed test](http://tools.pingdom.com/fpt/)나 [YSlow - Official Open Source Project Website](http://yslow.org/?)을 이용하여 기본 속도를 체크하고 성능을 참고한다.
- 만일을 대비하여 [AWS 프리티어 사용 시 요금발생(폭탄)을 막기위한 팁](http://gun0912.tistory.com/45)
- 마침 어제 업그레이드가 있었다. [What's New in WordPress 4.5](http://www.sitepoint.com/whats-new-wordpress-4-5/)와 [워드프레스 4.5 콜맨(Coleman) 정식 버전 발표](https://ko.wordpress.org/2016/04/11/%EC%9B%8C%EB%93%9C%ED%94%84%EB%A0%88%EC%8A%A4-4-5-%EC%BD%9C%EB%A7%A8coleman-%EC%A0%95%EC%8B%9D-%EB%B2%84%EC%A0%84-%EB%B0%9C%ED%91%9C/)을 참고한다.

## 참고 링크

* [자습서: Amazon LinuxLAMP 웹 서버 설치 - Amazon Elastic Compute Cloud](http://docs.aws.amazon.com/ko_kr/AWSEC2/latest/UserGuide/install-LAMP.html)
* [아마존 웹서비스 1 - 서버 구축 - 대두족장 놀이터](http://www.creativeworksofknowledge.com/2014/08/12/aws-ec2-01/)

## TODO

- [ ] : [디지털오션 서버에 워드프레스 블로그 두 개 설치하기 (왕초보) | SEOULRAIN](http://seoulrain.net/2016/04/18/digitaloceanwordpress/): 멀티 호스트를 비롯한 자세한 설명
- [ ] : [CDN을 이용해 워드프레스 블로그에 쉽게 HTTPS 적용하기](https://blog.iamseapy.com/archives/488): SSL을 적용하자


