---
layout: post
title: "유용한 bash 명령어 101"
description: "HaydenJames.io의 리눅스 명령어 101개"
category: blog
tags: [linux, bash, command]
---

출처 : [HaydenJames.io](HaydenJames.io)

몇몇 명령어는 (sudo) 권한이 필요하다.

1. 바로 전 명령어 실행하기:  

    !!

2. 특정 문자로 시작하는 이전 명령어 실행하기. 예:  

    !s

3. 편집했던 파일을 복사하거나 백업하기. 예로, nginx.conf 복사:  

    cp nginx.conf{,.bak}

4. 현재 디렉토르와 최근 디렉토리 사이를 왔다갔다 하기  

    cd -

5. 부모 디렉토리로 가기. 공백 주위!  

    cd ..

6. 홈 디렉토리로 가기   

    cd ~

7. 홈 디렉토리로 가기   

    cd $HOME

8. 홈 디렉토리로 가기   
    
    cd

9. 755 권한 설정. (owner-group-other) 순으로 (-rwx-r-x-r-x) 권한을 준다.   

    chmod 755 `filename`

10. 모든 유저에게 실행권한 추가하기   

    chmod a+x `filename`

11. 파일이나 . 디렉토리의 소유권 변경   

    chown `username`

12. file.backup으로 백업 복사본 만들기   

    cp `file` `file`.backup

13. file1을 복사하여 file2 만들기   

    cp `file1` `file2`

14. directory1의 모든 컨텐트를 directory2로 복사하기 (recursively)   

    cp -r `directory1` `directory2`/

15. 날짜 보기   

    date

16. Zero the sdb drive. You may want to use GParted to format the drive afterward. You need elevated permissions to run this (sudo).  

    dd if=/dev/zero of=/dev/sdb

17. 디스크 사용량 보기  

    df -h

18. OS의 상세한 메시지를 텍스트 파일에 넣기  

    dmesg>dmesg.txt

19. Display a LOT of system information. I usually pipe output to less. You need elevated permissions to run this (sudo).  

    dmidecode

20. Display BIOS information. You need elevated permissions to run this (sudo).  
    dmidecode -t 0

21. Display CPU information. You need elevated permissions to run this (sudo).  
    dmidecode -t 4

22. Search for installed packages related to Apache  

    dpkg –get-selections | grep apache

23. Shows you where in the filesystem the package components were installed  

    dpkg -L `package_name`

24. 각 서브디렉토리의 상세한 디스크 사용을 보기  

    du / -bh | less

25. 환경변수 PATH 값을 보기  

    echo $PATH

26. USER, LANG, SHELL, PATH, TERM과 같은 환경변수 보기  

    env

27. Opens a picture with the Eye of Gnome Image Viewer  

    eog `picture_name`

28. 터미널 끝내기 (혹은 sudo su로 하고 있었다면 수퍼유저 포기하기)  

    exit

29. Display memory usage  

    free

30. Easy way to view all the system logs.  

    gnome-system-log

31. 파일을 찾아 string이 매칭된 라인 보기  

    grep `string` `filename`

32. Get the number of seconds since the OS was started  

    grep btime /proc/stat | grep -Eo “[[:digit:]]+”

33. 이전 명령어 1000개 보기  

    history | less

34. 로컬 호스트 이름 보기  

    hostname

35. Display time.  

    hwclock –show

36. 사용자 id (uid) 와 그룹 id (gid) 보기  

    id

37. 로컬 IP 주소와 netmask 보기  
    
    ifconfig

38. Wireless network interface  

    iwconfig

39. Display wireless network information  

    iwlist

40. Kill process by name. You need elevated permissions to run this (sudo).  

    killall process

41. Get the date and time of the last system shutdown  

    last -x | grep shutdown | head -1 | grep -Eo “[A-Z][a-z]{2} [[:digit:] ][[:digit:]] [[:digit:]]{2}:[[:digit:]]{2}”

42. 쉘 세션 끝내기 (버추얼 콘솔의 하나로 로그인한 쉘만)  

    logout

43. 현재 디렉토리의 숨겨지지 않은 파일과 서브폴더 목록 보기. -R은 recursive이고 -a는 숨긴 파일을 포함한다.  

    ls

44. 현재 디렉토리의 모든 파일의 파일 접근 권한 보기. 권한의 포맷은 drwxrwxrwx이고, 순서는 owner-group-other, 숫자값은 read=4, write=2, execute=1이다.  

    ls -l `filename`

45. 가능한 모든 어플리케이션의 목록 보기  

    ls /usr/bin | less

46. Display more networking information  

    lshw -C network

47. Display kernel modules currently loaded  

    lsmod

48. Display sound, video, and networking hardware  

    lspci -nv | less

49. Display usb-connected hardware  

    lsusb

50. 명령어 man 페이지 읽기 (manual)  

    man `command`

51. 새 디렉토리 만들기  

    mkdir `dirname`

52. 특정 디렉토리에 파일 옮기기  

    mv `file` `dir`

53. file1을 file2로 이름바꾸기  

    mv `file1` `file2`

54. 라우팅 테이블 보기  

    netstat -rn  

55. 환경 변수 보기  

    printenv

56. 사용자가 현재 실행하고 프로세스 목록 보기. 유용한 옵션이 많으니 ps –help 로 보라.  

    ps -Af

57. 작업 디렉토리 보기  

    pwd

58. 파일 지우기  

    rm `filename`

59. 디렉토리와 디렉토리의 모든 컨텐트 지우기  

    rm -rf `dir`

60. 현재 디렉토리의 txt로 끝나는 모든 파일 지우기  

    rm *.txt

61. 디렉토리 지우기 (비어있지 않을 때에만 동작한다)  

    rmdir `dir`

62. Display your default gateway listed under “default”  

    route

63. Completely destroy all traces of the file. This takes a while. -n 7 means seven overwrites, -z means zero the bits afterward to hide shredding, -u means delete the file when done, and -v means verbose.  

    shred -zuv -n 7 `file`

64. 지금 컴퓨터 끄기  

    shutdown -h now

65. 지금 컴퓨터 재시작  

    shutdown -r now

66. 원격 컴퓨터에 로그인하기  

    ssh `IP address`

67. 루트 쉘을 열고 exit할 때까지 수퍼유저 권한을 갖는다. sudo su와 달리 사용자 환경변수에 상관없이 루트 쉘을 시작한다.  

    sudo -i

68. sudo -i와 같이 루트 쉘을 연다. 그러나 이 방법은 사용자 환경변수 유지한다. exit으로 일반 쉘로 돌아간다.  

    sudo su

69. 특정 디렉토리와 그 안의 모든 파일의 압축 파일을 만들기  

    tar czf `dirname`.tgz `dirname`

70. 현재 디렉토리에 압축 파일을 풀기  

    tar zxvf `archive`

71. cpu 사용량 기준으로 현재 프로세스 목록 보기. 끝내려면 q를, 도움말은 h를 누른다.  

    top

72. 빈 파일 만들기. 단, 파일이 없어야 한다.  

    touch `filename`

73. 현재 터미널 이름 보기  

    tty

74. 리눅스 커널 보기  

    uname -a

75. 컴퓨터의 프로세스 아키텍처 보기  

    uname -m

76. 명령어의 man 페이지의 한줄 요약 보기  

    whatis `command`

77. 프로그램의 파일 시스템 위치 보기  

    whereis `command`

78. 어플리케이션의 경로 보기  

    which `command`

79. 컴퓨터에 로그인한 사용자 보기  

    who

80. 내 로그인 이름 보기  

    whoami

81. This will display the output of test.log as it is being written to by another program  

    tail –follow test.log

82. 디렉토리 쉘을 오가면서 디렉토리의 파일이나 어플리케이션을 열고 싶다면 파일명 앞에 이 명령어를 붙여라. 예.   

    ./filename.txt

83. 이스케이프 연산자. 이름에 공백이 있는 파일을 열 때 공백 바로 전에 사용하라.  

    \

84. 물결표는 홈 디렉토리를 말한다.  

    ~

85. Run any command when the system load is low  

    batch `command`

86. Display cpu info  

    cat /proc/cpuinfo

87. Display memory usage  

    cat /proc/meminfo

88. Display networking devices  

    cat /proc/net/dev

89. Display performance information  

    cat /proc/uptime

90. Display kernel version  

    cat /proc/version

91. 파일 내용 보기  

    cat `filename`

92. 파티션 테이블 목록 보기  

    fdisk -l

93. Show the properties/compression of a file or package  

    file `package_name`

94. 파일 찾기  

    find / -name `filename`  

95. *.gz로 압축 파일 만들기  

    gzip test.txt

96. *.gz 파일 압축 풀기  

    gzip -d test.txt.gz

97. 압축 파일의 압축비 보기  

    gzip -l *.gz  

98. 파일 상태 보기  

    stat filename.txt

99. 인터넷에서 파일 받기  

    wget `http://remote_file_url`

100. Show list of last 10 logged in users.  

    last -n 10

101. Display a tree of processes  

    pstree

## 참고링크

* [Bash Shell Script - GitBook](https://www.gitbook.com/book/mug896/shell-script/details)