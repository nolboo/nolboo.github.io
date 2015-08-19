---
layout: post
title: "리눅스 사용자와 그룹 - 린노드 가이드"
description: "리눅스 초보가 제일 헷갈려하는 사용자와 그룹에 대한 린노드 가이드를 번역"
category: blog
tags: [linux, users, groups]
---

원문 : [Linux Users and Groups - Linode Guides & Tutorials](https://www.linode.com/docs/tools-reference/linux-users-and-groups)

* 원문의 < > 기호는 모두 [ ] 기호로 변경함.

# Linux Users and Groups

리눅스/유닉스가 처음이라면 권한`permission` 개념이 혼란스러울 것이다. 이 가이드는 권한이 무엇인지, 어떻게 작동하고, 권한을 다루는 법을 설명한다. 많은 예제가 사용자`users`와 그룹`groups`의 권한을 설정하고 변경하는 법을 설명한다.

## What are User and Group Permissions?

리눅스/유닉스 운영체제는 다른 운영체제와 비슷한 방법으로 멀티태스킹한다. 그러나, 다른 운영체제에 비해 리눅스의 주요 차이점은 여러 사용자를 가질 수 있는 것이다. 리눅스는 시스템에 동시에 접근할 수 있는 여러 사용자를 허용하도록 설계되어있다. 이 멀티사용자 설계가 제대로 작동하기 위해서는 다른 사용자로부터 사용자를 보호하는 방법이 필요하다. 이것이 권한이 제 역할을 발휘하는 부분이다.

### Read, Write & Execute Permissions

권한은 파일이나 디렉토리에 작용할 수 있는 "권리`rights`"이다. 기본 권리는 읽기`read`, 쓰기`write`, 실행`execute`이다.

* 읽기 - 보여지는 파일의 컨텐츠를 읽을 수 있는 권한. 디렉토리에 대한 읽기 권한은 디렉토리의 컨텐츠 항목들을 볼 수 있게 해준다.
* 쓰기 - 파일에 대한 쓰기 권한은 그 파일의  컨텐츠를 변경할 수 있게 해준다. 디렉토리의 경우 쓰기 권한은 디렉토리 컨텐츠를 편집할 수 있게 해준다. (예: 파일의 추가/삭제)
* 실행 - 파일의 경우, 실행 권한은 파일을 실행하거나 프로그램이나 스크립트를 실행할 수 있게 해준다. 디렉토리의 경우 실행 권한은 다른 디렉토리로 변경하거나 그것을 현재 작업 디렉토리로 만들 수 있게 해준다. 사용자는 보통 디폴트 그룹을 가지고 있으나 여러 추가적인 그룹에도 속할 수 있다.

### Viewing File Permissions

파일이나 디렉토리의 권한을 보려면, `ls -l [directory/file]` 명령어를 사용하라. **[ ]** 안은 실제 파일이나 디렉토리 명으로 바꿔야 한다. 아래는 `ls` 명령어의 예제 출력이다:

<pre class="terminal">
-rw-r--r-- 1 root root 1031 Nov 18 09:22 /etc/passwd
</pre>

처음 10개의 문자가 접근 권한을 보여준다. 첫 번째 대시(-)는 파일의 형식(d는 디렉토리, s는 특별 파일, -는 보통파일)을 나타낸다. 그다음 세 문자(**rw-**)는 파일에 대한 소유자의 권한을 정의한다. 이 예제에서는 파일 소유자가 읽고 쓰는 권한만을 가진다. 그다음 세 문자(**r–-**)는 파일 소유자와 같은 그룹의 멤버에 대한 권한이다(이 예제에서는 오직 읽을 수만 있다). 그다음 세 문자(**r–-**)는 다른 모든 사용자에 대한 권한을 보여주며 이 예제에서는 읽을 수만 있다.

## Working with Users, Groups, and Directories

다음 섹션에서는 사용자 계정을 만들고, 지우고, 변경할 때 필요한 명령어로 넘어갈 것이다. 그룹이 다뤄질 것이고, 디렉토리를 만들고 지우는 명령어도 다룰 것이다. 사용자, 그룹, 디렉토리와 작업할 때 필요한 명령어와 설명도 할 것이다.

### Creating and Deleting User Accounts

새로운 표준 사용자를 만들려면, `useradd` 명령어를 사용해라. 문법은 다음과 같다:

<pre class="terminal">
useradd [name]
</pre>

useradd 명령어는 다양한 변수를 활용할 수 있으며, 그중 몇 개를 아래 테이블에서 보여준다:

| Option          | Description | Example |
| --------------- | ------------------------ | ------ |
| `-d [home_dir]` | home_dir은 사용자의 로그인 디렉토리 값으로 사용된다 | `useradd [name] -d /home/[user's home]` |
| `-e [date]`     | 계정이 만료`expire`되는 시간 | `user add [name]** -e <yyyy-mm-dd>`     |
| `-f [inactive]` | 게정이 만료되기 전까지의 날자 수 | `useradd [name] -f [0 or -1]`           |
| `-s [shell]`    | 디폴트 쉘`shell` 타입을 설정한다 | `useradd [name] -s /bin/[shell]` |

`passwd` 명령어를 사용하여 새 사용자의 패스워드를 설정할 수 있다. 사용자 패스워드를 변경하려면 루트 특권`root privileges`이 필요하다. 문법은 다음과 같다:

<pre class="terminal">
passwd [username]
</pre>

사용자는 `passwd` 명령어를 사용하여 언제든지 자신의 패스워드를 변경할 수 있다. 하나의 예제이다:

<pre class="terminal">
$ passwd
Changing password for lmartin.
(current) UNIX password:
Enter new UNIX password:
Retype new UNIX password:
passwd: password updated successfully
</pre>

처음으로 관리자가 된 사람이 더 쉽게 사용자 계정을 만드는 방법이 있다. 그러나, 새로운 패키지를 설치해야 한다. Debian/Ubuntu에서의 설치 명령어는 다음과 같다:

<pre class="terminal">
apt-get install adduser
</pre>

adduser 명령어는 자동으로 홈 디렉토리를 만들고 디폴트 그룹과 쉘 등을 설정한다. `adduser`로 표준 사용자를 만드는 문법은 다음과 같다:

<pre class="terminal">
adduser [name]
</pre>

일단 명령어를 입력하면 연속적인 프롬프트를 받을 것이다. 대부분 정보는 선택사항이다. 그러나 적어도 사용자 이름(예제에서는 cjones)과 패스워드는 입력해야한다.

<pre class="terminal">
root@localhost:~# adduser cjones
  Adding user `cjones' ...
  Adding new group `cjones' (1001) ...
  Adding new user `cjones' (1001) with group `cjones' ...
  Creating home directory `/home/cjones' ...
  Copying files from `/etc/skel' ...
  Enter new UNIX password:
  Retype new UNIX password:
  passwd: password updated successfully
  Changing the user information for cjones
  Enter the new value, or press ENTER for the default
      Full Name []: Chuck Jones
      Room Number []: 213
      Work Phone []: 856-555-1212
      Home Phone []:
      Other []:
  Is the information correct? [Y/n] Y
</pre>

보안`security`는 언제나 매우 심각하게 받아들여져야 한다. 각 계정에 오직 하나뿐인 패스워드를 사용할 것을 강력하게 추천한다. 절대 자신의 패스워드를 다른 사용자와 공유하거나 주지 말라.

사용자 계정을 제거하려면 다음 명령어를 입력한다:

<pre class="terminal">
userdel [name]
</pre>

위의 명령어는 사용자의 계정을 지우기만 한다. 사용자의 파일과 홈 디렉토리는 지워지지 않는다.

사용자와 홈 폴더와 파일을 지우려면 이 명령어를 사용하라:

<pre class="terminal">
userdel -r [name]
</pre>

### Understanding Sudo

루트`root`는 슈퍼 사용자이며, 한 시스템에 대한 어떤 일이든 할 수 있는 능력을 갖췄다. 그러므로 잠재적 손상을 보호하기 위해 sudo는 루트에서 사용되어야 한다. sudo는 사용자와 그룹에게 그들이 일반적으로 사용할 수 없는 명령어에 접근할 수 있게 한다. sudo는 사용자가 root로 로그인하지 않고도 관리자 특권을 가질 수 있게 한다. sudo 명령어의 예제는 다음과 같다:

<pre class="terminal">
sudo apt-get install <package>
</pre>

sudo를 사용하기 전에 자신의 배포판에 없다면 설치하여야 한다. Debian에서의 명령어는 다음과 같다:

<pre class="terminal">
apt-get install sudo
</pre>

CentOS에서의 명령어는 다음과 같다:

<pre class="terminal">
yum install sudo
</pre>

한 사용자에게 sudo 능력을 제공하려면, 사용자 이름을 sudoers 파일에 추가하여야 한다. 이 파일은 매우 중요하며 텍스트 에디터에서 직접 편집하지 않아야 한다. sudoers 파일을 정확하게 편집하지 않으면 시스템에 접근할 수 없게 될 것이다.

그러므로 sudoers 파일을 편집하려면 `visudo` 명령어를 사용해야 한다. 커맨드 라인에서 시스템에 로그인하고 `visudo` 명령어를 입력해라.

아래는 sudoers 파일에서 sudo 접근을 할 수 있는 사용자를 보여주는 부분이다.

<pre class="terminal">
# User privilege specification
root    ALL=(ALL:ALL) ALL
cjones  ALL=(ALL:ALL) ALL
kbrown  ALL=(ALL:ALL) ALL
lmartin ALL=(ALL:ALL) ALL
</pre>

자신의 사용자 계정에 sudo 특권을 준 다음, sudoers 파일을 저장하고 루트에서 로그아웃한다. 이제 자신의 사용자 계정으로 로그인하여 sudo 접근할 수 있는 특권을 테스트하라. 새 사용자가 sudo 접근이 필요하다면, 이제 자신의 계정으로 아래 명령으로 sudoers 파일을 편집할 수 있다.

<pre class="terminal">
sudo visudo
</pre>

### Working with Groups

리눅스는 그룹을 사용자들을 조직하는 방법의 하나로 사용한다. 그룹은 주로 보안 조치의 하나로서 계정들의 집합을 조직한다. 그룹 멤버십의 제어는 `/etc/group` 파일을 통해 관리한다. 모든 사용자는 디폴트`default` 또는 primary 그룹을 가진다. 사용자가 로그인하면 그룹 멤버십은 primary 그룹으로 설정된다. 이것은 사용자가 프로그램을 실행하거나 파일을 만들 때, 그 파일과 실행된 프로그램은 사용자의 현재 그룹 멤버십과 결합하는 것을 의미한다. 사용자가 다른 그룹의 멤버이고 접근 권한이 설정되어 있다면, 다른 그룹의 파일에 접근할 수 있다. 다른 그룹의 프로그램을 실행하거나 파일을 만들려면, 그 사용자는 `newgrp` 명령어를 실행하여 그 그룹으로 전환해야 한다. newgrp 명령어의 예제는 다음과 같다:

<pre class="terminal">
$ newgrp [marketing]
</pre>

`/etc/group` 파일 안의 **marketing** 그룹의 멤버인 사용자가 위와 같은 명령어를 입력하면, 현재 그룹 멤버십이 변경된다. 이제부터 만들어지는 모든 파일은 사용자의 primary 그룹이 아닌 **marketing** 그룹과 결합한다는 것은 중요하다. 사용자는 `chgrp` 명령어를 사용하여 그들의 그룹을 변경할 수도 있다. chgrp 명령어의 예제는 다음과 같다:

<pre class="terminal">
$ chgrp [newgroup]
</pre>

### Creating and Removing Directories

디렉토리를 만드는 명령어는:

<pre class="terminal">
mkdir [directory name]
</pre>

디렉토리를 만들면서 동시에 권한을 설정하려면 다음 옵션과 문법을 사용해라:

<pre class="terminal">
mkdir -m a=rwx [directory name]
</pre>

**-m** 옵션은 mode의 줄임말이고, **a=rwx**은 모든 사용자가 디렉토리에 읽기, 쓰기, 실행 권한을 갖는다는 것을 뜻한다. mkdir 명령어의 모든 옵션의 완전한 목록을 보려면 명령어 프롬프트에서 `man mkdir`을 입력한다.

파일을 제거하는 명령어는:

<pre class="terminal">
rm [file]
</pre>

디렉토리를 제거하려면:

<pre class="terminal">
rm -r [directory name]
</pre>

디렉토리를 제거하면 그 안의 모든 파일도 제거된다는 것을 알아두어라.

### Changing Directory and File Permissions

파일 권한과 파일과 디렉토리의 소유권을 보려면 `ls -al` 명령어를 사용한다. `a` 옵션은 숨겨진 파일 또는 모든 파일을 보여주는 것이고, `l` 옵션은 긴 설명의 목록`long listing`을 보여준다. 다음과 같이 출력된다:

<pre class="terminal">
drwxr-xr-x 2 user user 4096 Jan  9 10:11 documents
-rw-r--r-- 1 user user  675 Jan  7 12:05 .profile
drwxr-xr-x 4 user user 4096 Jan  7 14:55 public
</pre>

열 개의 문자와 대시로 된 첫 컬럼은 파일/디렉토리의 권한을 보여준다. (하나의 숫자로 된) 두번째 컬럼은 디렉토리에 포함된 파일/디렉토리의 수를 말한다. 그다음 컬럼은 소유자를 말하고, 그다음은 그룹명, 크기, 최종 접근 날짜와 시간, 마지막은 파일의 이름이다. 예를 들면, 위의 출력에서 첫번째 줄을 상세하게 설명하면 다음과 같다:

    ``drwxr-xr-x`` 은 권한이다.
    ``2`` 는 파일/디렉토리의 수이다.
    ``user`` 은 소유자
    ``user`` 은 그룹
    ``4096`` 은 크기
    ``Jan  9 10:11`` 은 최종 접근 날짜/시간
    ``documents`` 은 디렉토리

>#### Note

>디렉토리 자체도 하나의 파일이기 때문에, 모든 디렉토리는 항상 `4096`의 크기를 보여준다. 이것은 디렉토리 컨텐츠들의 크기를 반영하지는 않는다.

### Chmod Command

`chmod`는 모드 변경(change mode)의 준말이다. chmod는 파일과 디렉토리의 권한을 변경할 때 사용한다. `chmod` 명령어는 권한을 설정하기 위해 (팔진법으로 알려진) 문자나 숫자와 함께 사용된다. chmod와 함께 사용되는 문자는 아래 표와 같다:

| Letter | Permission                                  |
| ------ | ------------------------------------------- |
| r      | 읽기`read`                                   |
| w      | 쓰기`write`                                  |
| x      | 실행`execute`                                |
| X      | 실행`execute` (파일이 디렉토리일 경우에만)          |
| s      | 실행할 때 사용자와 그룹 ID 설정(set)               |
| t      | swap 장치에 프로그램 텍스트 저장                   |
| u      | 소유자의 파일에 대한 현재 권한                     |
| g      | 같은 그룹(group)에 있는 사용자의 파일에 대한 현재 권한 |
| o      | 그룹에 있지 않은 사용자(others)의 파일에 대한 현재 권한|

파일 목록의 첫 번째 컬럼의 첫 문자가 디렉토리나 파일을 나타낸다는 것은 중요하다. 나머지 9개 문자는 파일/디렉토리의 권한이다. 첫 세 문자는 사용자, 다음 세 개는 그룹, 마지막 세 개는 다른 사용자(others)에 대한 것이다. **drwxrw-r–-**을 예로 들어 풀면 다음과 같다:

>**d** 는 디렉토리  
>**rwx** 사용자가 읽기, 쓰기, 실행 권한을 가졌다  
>**rw-** 그룹은 읽기, 쓰기 권한을 가졌다  
>**r–-** 다른 사용자(others)는 읽기 권한만 가졌다  

대시(-)는 권한이 제거된 것을 나타낸다. 그러므로 다른 사용자에 대한 r--은 읽기 권한만 가졌고, 쓰기와 실행 권한은 제거된 것이다.

반대로 플러스 사인(+)은 권한을 주는 것과 같다: `chmod u+r,g+x <filename>`

위의 예제는 다음과 같이 해석한다:

    u is for user
    r is for read
    g is for group
    x is for execute

다른 말로, 그 파일에 대하여 사용자에게는 읽기 권한을 주었고 그룹에는 실행 권한을 주었다. 한 번의 설정에서 여러 권한을 줄 때는 설정 사이에 쉼표(,)를 넣어야 한다.

### Chmod Octal Format

팔진법 형식을 사용하려면 파일이나 디렉토리 각 부분에 대한 권한을 계산해야 한다. 위에서 언급 첫 10문자는 팔진법으로 네 개의 숫자에 해당한다. 실행 권한은 숫자 (1)과 같고, 쓰기 권한은 숫자 (2)와 같고, 읽기 권한은 숫자 (4)와 같다. 그러므로 팔진법 형식을 사용할 때는 0과 7 사이의 숫자를 계산할 필요가 있다. 설명을 위해 아래 표를 제공한다:

| Octal Value | Read | Write | Execute |
|:-----------:|:----:|:-----:|:-------:|
| 7           | r    | w     | x       |
| 6           | r    | w     | -       |
| 5           | r    | -     | x       |
| 4           | r    | -     | -       |
| 3           | -    | w     | x       |
| 2           | -    | w     | -       |
| 1           | -    | -     | x       |
| 0           | -    | -     | -       |

팔진법 형식이 이해하기 어려운 것 같으나, 일단 요점을 익히면 사용하기 쉽니다. 그러나 r, w, x로 권한을 설정하는 것이 더 쉽다. 아래는 권한을 설정할 때 문자와 팔진법 형식을 사용하는 예제들이다.

>Sample syntax: `chmod [octal or letters] [file/directory name]`
>Letter format: `chmod go-rwx Work` (그룹과 others에게 rwx 권한을 취소)

위의 chmod 명령어 이후의 `ls -al`의 출력은 다음과 같이 보일 것이다:

<pre class="terminal">
dr-------- 2 user user 4096 Dec 17 14:38 Work
</pre>

팔진법 형식: `chmod 444 Work`

chmod 명령어 이후의 `ls -al`의 출력은 다음과 같이 보일 것이다:

<pre class="terminal">
dr--r--r-- 2 user user 4096 Dec 17 14:38 Work
</pre>

아래 팔진법 테이블은 권한에 해당하는 숫자를 보여준다.

| Permission string | Octal code | Meaning |
|:------------------|:----------:|---------|
| rwxrwxrwx         | 777        | 모든 사용자에게 읽기/쓰기/실행 권한.        |
| rwxr-xr-x         | 755        | 모든 사용자에게 읽기/실행 권한. 소유자는 쓰기 권한도.|
| rwxr-x---         | 750        | 소유자와 그룹에 읽기/실행 권한. 소유자는 쓰기 권한도. 소유자나 그룹의 멤버가 아닌 사용자는 접근 불가능.|
| rwx------         | 700        | 소유자만 읽기/쓰기/실행 권한. 다른 사용자는 접근 불가능.|
| rw-rw-rw-         | 666        | 모든 사용자에게 읽기/쓰기 권한. 누구도 실행 불가능.|
| rw-rw-r--         | 664        | 소유자와 그룹에 읽기/쓰기 권한. 다른 사용자는 읽기 권한만.|
| rw-rw----         | 660        | 소유자와 그룹에 읽기/쓰기 권한. 다른 사용자는 접근 불가능.|
| rw-r--r--         | 644        | 소유자에게 읽기/쓰기 권한. 다른 사용자는 읽기 권한만.|
| rw-r-----         | 640        | 소유자에게 읽기/쓰기 권한. 그룹은 읽기 권한만. 다른 사용자는 접근 불가능.|
| rw-------         | 600        | 소유자에게 읽기/쓰기 권한. 다른 사람 모두 접근 불가능|
| r--------         | 400        | 소유자에게 읽기 권한. 다른 사람 모두 접근 불가능.|

### Additional File Permissions

가장 일반적인 읽기/쓰기/실행 파일 권한에 더하여, 유용하다고 볼만한 몇 가지 추가적인 모드가 있다. 특히, _+t_ 모드(_sticky bit_)와 _+s_ 모드(_setuid bit_) 등은 멀티유저 상황에서 파일과 실행자들을 설명한다.

파일이나 디렉토리를 _sticky bit_이나 _+t_ 모드로 설정하면 소유자(혹은 root)만 파일을 지울 수 있다는 것을 뜻한다, 사용자가 그룹 멤버십이나 오너십으로 이 파일에 쓰기 접근을 가지고 있음에도 불구하고. 이것은 많은 사용자가 파일들에 쓰기 접근을 공유하고 있는 그룹이 소유하고 있는 파일이나 디렉토리의 경우에 유용하다.

`/root/sticky.txt`라는 파일에 sticky bit을 설정하려면 다음 명령을 내린다:

<pre class="terminal">
chmod +t /root/sticky.txt
</pre>

파일에서 sticky bit을 제거하려면, `chmod -t` 명령어를 사용해라. sticky bit을 변경하려면 root 거나 파일 소유자이어야 한다는 것에 주의해라. root 사용자는 sticky bit의 상태와 관계없이 파일을 지울 수 있다.

_setuid_ bit나 _+s_는, 사용자들이 소유자 권한으로 파일을 실행할 수 있도록 설정하는 경우이다. 예를 들면, `root` 사용자와 `marketing` 그룹이 `work` 파일을 소유하고 있다면, `marketing` 그룹은 마치 그들이 root 사용자인 것처럼 `work` 프로그램을 실행할 수 있다. 이것은 어떤 경우에는 잠재적인 보안 위험을 일으킬 수 있으며, 실행자들은 `+s` 플래그를 주기 전에 적절하게 평가해야 한다. `/usr/bin/work`라는 파일에 `+s` bit을 설정하는 명령어는 다음과 같다:

<pre class="terminal">
chmod g+s /usr/bin/work
</pre>

파일의 오너십에 대한 _+s_ 모드와 대비하여, 디렉토리에 대한 _+s_ 모드의 효과는 약간 다르다. _+s_ 디렉토리에 생성된 파일은 - 파일을 생성한 사용자와 그들의 디폴트 그룹의 오너십이 아닌 - 디렉토리 사용자와 그룹의 오너십을 받는다. 디렉토리에 _setguid_ (group id) 옵션을 설정하려면 다음 명령어를 사용한다:

<pre class="terminal">
chmod g+s /var/doc-store/
</pre>

`/var/doc-store`라는 디렉토리에 _setuid_ (user id)를 설정하려면 다음 명령을 내린다:

<pre class="terminal">
chmod o+s /var/doc-store/
</pre>

### Changing File Ownership

기본적으로 모든 파일은 그것을 만든 사용자와 그 사용자의 디폴트 그룹에 의해 "소유된다". 파일의 오너십을 변경하려면 `chown user:group /path/to/file` 형식으로 `chown` 명령어를 사용한다. 다음 예제에서는, "list.html" 파일의 오너십이 "marketing" 그룹의 "cjones"로 변경된다.

<pre class="terminal">
chown cjones:marketing list.html
</pre>

디렉토리와 그 안의 모든 파일의 오너십을 변경하려면, `-R` 플래그로 recursive 옵션을 사용해라. 다음 예제에서는, `/srv/smb/leadership/`의 오너십을 "marketing" 그룹의 "cjones"로 변경한다.

<pre class="terminal">
chown -R cjones:marketing /srv/smb/leadership/
</pre>

## Leveraging Users and Groups

많은 경우에 사용자 권한은 자신의 시스템에 어떤 직접적인 상호작용 없이 더 훌륭한 보안을 제공하곤 한다. 많은 운영체제는 설치 과정 동안 다른 패키지에 대한 특정 시스템 사용자 계정을 만든다.

Best practice는 각 사용자에게 여러분의 시스템에 대한 그들 각각의 로그인을 주는 것이다. 이것은 각각의 사용자의 파일을 다른 모든 사용자로부터 보호한다. 게다가 사용자에게 특정 계정을 사용하는 것은 - 특히, `sudo`와 같은 툴과 결합할 경우 - 더 정확한 시스템 로깅을 할 수 있다. 최대의 보안을 위해서 한 명 이상이 한 사용자 계정의 패스워드를 아는 상황을 피하는 것을 권한다.

대비하여, 그룹은 여러 독립 사용자 계정이 협업하고 파일을 공유할 수 있게 한다. 일반적인 업무 기준(예: 웹 에디터, 공헌자, 컨텐츠 제출자, 지원자)으로 시스템에 그룹을 만들려면, 관련 그룹에 관련 사용자를 추가하라. 이 사용자들은 - 파일을 공유하지 않고도 - 같은 설정의 파일들을 편집하고 실행할 수 있다. 770과 740 파일 권한과 함께 `chown` 명령어를 사용하면 이 목표를 달성할 수 있다.

## More Information

You may wish to consult the following resources for additional information on this topic. While these are provided in the hope that they will be useful, please note that we cannot vouch for the accuracy or timeliness of externally hosted materials.

* [User Account and Group Management @ UWISC’s Center for Computer Aided Engineering](http://www.cae.wisc.edu/cae-account-management/)
* [Users and Groups Administration in Linux @ DebianAdmin](http://www.debianadmin.com/users-and-groups-administration-in-linux.html)
* [Online Chmod Calculator](http://www.onlineconversion.com/html_chmod_calculator.htm)

This guide is published under a [CC BY-ND 3.0](http://creativecommons.org/licenses/by-nd/3.0/us/) license.

## 역자 참고 링크

* [리눅스 파일 퍼미션 | Linux System Engineer's Blog](http://root.so/archives/51)
* [리눅스포커스 : 파일접근권한](http://www.linuxfocus.org/Korean/January1999/article77.html)
* [리눅스 - 소유권과 허가권 알아보기](http://bit.ly/1Kvjtga) : SetUID(4),SetGID(2),sticky bit(1)에 대한 설명이 명확함.