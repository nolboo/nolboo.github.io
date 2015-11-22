<?php
	require_once('DBMysql.class.php');
    /**
     * @class DBMysqli
     * @author NHN (developers@xpressengine.com)
     * @brief MySQL DBMS를 mysqli_* 로 이용하기 위한 class
     * @version 0.1
     *
     * mysql handling class
     **/
	

    class DBMysqli extends DBMysql {

        /**
         * @brief constructor
         **/
        function DBMysqli() {
            $this->_setDBInfo();
            $this->_connect();
        }

        /**
         * @brief 설치 가능 여부를 return
         **/
        function isSupported() {
            if(!function_exists('mysqli_connect')) return false;
            return true;
        }
		
		/**
		 * @brief create an instance of this class
		 */
		function create()
		{
			return new DBMysqli;
		}

        /**
         * @brief DB 접속
         **/
        function _connect() {
            // db 정보가 없으면 무시
            if(!$this->hostname || !$this->userid || !$this->password || !$this->database) return;

            // 접속시도
			if($this->port){
	            $this->fd = @mysqli_connect($this->hostname, $this->userid, $this->password, $this->database, $this->port);
			}else{
	            $this->fd = @mysqli_connect($this->hostname, $this->userid, $this->password, $this->database);
			}
			$error = mysqli_connect_errno();
            if($error) {
                $this->setError($error,mysqli_connect_error());
                return;
            }
			mysqli_set_charset($this->fd,'utf8');

            // 접속체크
            $this->is_connected = true;
			$this->password = md5($this->password);
        }

        /**
         * @brief DB접속 해제
         **/
        function close() {
            if(!$this->isConnected()) return;
            mysqli_close($this->fd);
        }

        /**
         * @brief 쿼리에서 입력되는 문자열 변수들의 quotation 조절
         **/
        function addQuotes($string) {
            if(version_compare(PHP_VERSION, "5.9.0", "<") && get_magic_quotes_gpc()) $string = stripslashes(str_replace("\\","\\\\",$string));
            if(!is_numeric($string)) $string = mysqli_escape_string($this->fd,$string);
            return $string;
        }

        /**
         * @brief : 쿼리문의 실행 및 결과의 fetch 처리
         *
         * query : query문 실행하고 result return\n
         * fetch : reutrn 된 값이 없으면 NULL\n
         *         rows이면 array object\n
         *         row이면 object\n
         *         return\n
         **/
        function _query($query) {
            if(!$this->isConnected()) return;

            // 쿼리 시작을 알림
            $this->actStart($query);

            // 쿼리 문 실행
            $result = mysqli_query($this->fd,$query);
            // 오류 체크
			$error = mysqli_error($this->fd);
            if($error){
				$this->setError(mysqli_errno($this->fd), $error);
			}

            // 쿼리 실행 종료를 알림
            $this->actFinish();

            // 결과 리턴
            return $result;
        }

		function db_insert_id()
		{
            return  mysqli_insert_id($this->fd);
		}

		function db_fetch_object(&$result)
		{
			return mysqli_fetch_object($result);
		}
    }

return new DBMysqli;
?>
