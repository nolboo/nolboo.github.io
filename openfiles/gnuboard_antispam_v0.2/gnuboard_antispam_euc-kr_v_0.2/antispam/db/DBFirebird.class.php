<?php
    /**
     * @class DBFriebird
     * @author 김현식 (dev.hyuns@gmail.com)
     * @brief Firebird DBMS를 이용하기 위한 class
     * @version 0.3
     *
     * firebird handling class
     **/

    class DBFireBird extends DB {

        /**
         * @brief Firebird DB에 접속하기 위한 정보
         **/
        var $hostname = '127.0.0.1'; ///< hostname
        var $userid   = NULL; ///< user id
        var $password   = NULL; ///< password
        var $database = NULL; ///< database
        var $prefix   = NULL; ///< XE에서 사용할 테이블들의 prefix  (한 DB에서 여러개의 XE 설치 가능)
        var $idx_no = 0; // 인덱스 생성시 사용할 카운터
		var $comment_syntax = '/* %s */';

        /**
         * @brief firebird에서 사용될 column type
         *
         * column_type은 schema/query xml에서 공통 선언된 type을 이용하기 때문에
         * 각 DBMS에 맞게 replace 해주어야 한다
         **/
        var $column_type = array(
            'bignumber' => 'BIGINT',
            'number' => 'INTEGER',
            'varchar' => 'VARCHAR',
            'char' => 'CHAR',
            'text' => 'BLOB SUB_TYPE TEXT SEGMENT SIZE 32',
            'bigtext' => 'BLOB SUB_TYPE TEXT SEGMENT SIZE 32',
            'date' => 'VARCHAR(14)',
            'float' => 'FLOAT',
        );

        /**
         * @brief constructor
         **/
        function DBFireBird() {
            $this->_setDBInfo();
            $this->_connect();
        }
		
		/**
		 * @brief create an instance of this class
		 */
		function create()
		{
			return new DBFireBird;
		}

        /**
         * @brief 설치 가능 여부를 return
         **/
        function isSupported() {
            if(!function_exists('ibase_connect')) return false;
            return true;
        }

        /**
         * @brief DB정보 설정 및 connect/ close
         **/
        function _setDBInfo() {
			require('db.config.php');
            $this->hostname = $db_info->db_hostname;
            $this->port = $db_info->db_port;
            $this->userid   = $db_info->db_userid;
            $this->password   = $db_info->db_password;
            $this->database = $db_info->db_database;
            $this->prefix = $db_info->db_table_prefix;
            if(!substr($this->prefix,-1)!='_') $this->prefix .= '_';
        }

        /**
         * @brief DB 접속
         **/
        function _connect() {
            // db 정보가 없으면 무시
            if(!$this->hostname || !$this->port || !$this->userid || !$this->password || !$this->database) return;

            //if(strpos($this->hostname, ':')===false && $this->port) $this->hostname .= ':'.$this->port;

            // 접속시도

            $host = $this->hostname."/".$this->port.":".$this->database;

            $this->fd = @ibase_connect($host, $this->userid, $this->password);
            if(ibase_errmsg()) {
                $this->setError(ibase_errcode(), ibase_errmsg());
                return $this->is_connected = false;
            }

            // Firebird 버전 확인후 2.0 이하면 오류 표시
            if (($service = ibase_service_attach($this->hostname, $this->userid, $this->password)) != FALSE) {
                // get server version and implementation strings
                $server_info  = ibase_server_info($service, IBASE_SVC_SERVER_VERSION);
                ibase_service_detach($service);
            }
            else {
                $this->setError(ibase_errcode(), ibase_errmsg());
                @ibase_close($this->fd);
                return $this->is_connected = false;
            }

            $pos = strpos($server_info, "Firebird");
            if($pos !== false) {
                $ver = substr($server_info, $pos+strlen("Firebird"));
                $ver = trim($ver);
            }

            if($ver < "2.0") {
                $this->setError(-1, "XE cannot be installed under the version of firebird 2.0. Current firebird version is ".$ver);
                @ibase_close($this->fd);
                return $this->is_connected = false;
            }

            // 접속체크
            $this->is_connected = true;
			$this->password = md5($this->password);
        }

        /**
         * @brief DB접속 해제
         **/
        function close() {
            if(!$this->isConnected()) return;
            @ibase_commit($this->fd);
            @ibase_close($this->fd);
            $this->transaction_started = false;
        }

        /**
         * @brief 쿼리에서 입력되는 문자열 변수들의 quotation 조절
         **/
        function addQuotes($string) {
//            if(get_magic_quotes_gpc()) $string = stripslashes(str_replace("\\","\\\\",$string));
//            if(!is_numeric($string)) $string = str_replace("'","''", $string);
            return $string;
        }

        /**
        * @brief 쿼리에서 입력되는 table, column 명에 더블쿼터를 넣어줌
        **/
        function addDoubleQuotes($string) {
            if($string == "*") return $string;

            if(strpos($string, "'")!==false) {
                $string = str_replace("'", "\"", $string);
            }
            else if(strpos($string, "\"")!==false) {
            }
            else {
                $string = "\"".$string."\"";
            }

            return $string;
        }

        /**
         * @brief 쿼리에서 입력되는 table, column 명에 더블쿼터를 넣어줌
         **/
        function autoQuotes($string){
            $string = strtolower($string);

            // substr 함수 일경우
            if(strpos($string, "substr(") !== false) {
                $tokken = strtok($string, "(,)");
                $tokken = strtok("(,)");
                while($tokken) {
                    $tokkens[] = $tokken;
                    $tokken = strtok("(,)");
                }

                if(count($tokkens) !== 3) return $string;
                return sprintf("substring(%s from %s for %s)", $this->addDoubleQuotes($tokkens[0]), $tokkens[1], $tokkens[2]);
            }

            // as
            $as = false;
            if(($no1 = strpos($string," as ")) !== false) {
                $as = substr($string, $no1, strlen($string)-$no1);
                $string = substr($string, 0, $no1);

                $as = str_replace(" as ", "", $as);
                $as = trim($as);
                $as = $this->addDoubleQuotes($as);
            }

            // 함수 사용시
            $tmpFunc1 = null;
            $tmpFunc2 = null;
            if(($no1 = strpos($string,'('))!==false && ($no2 = strpos($string, ')'))!==false) {
                $tmpFunc1 = substr($string, 0, $no1+1);
                $tmpFunc2 = substr($string, $no2, strlen($string)-$no2+1);
                $string = trim(substr($string, $no1+1, $no2-$no1-1));
            }

            // (테이블.컬럼) 구조 일때 처리
            preg_match("/((?i)[a-z0-9_-]+)[.]((?i)[a-z0-9_\-\*]+)/", $string, $matches);

            if($matches) {
                $string = $this->addDoubleQuotes($matches[1]).".".$this->addDoubleQuotes($matches[2]);
            }
            else {
                $string = $this->addDoubleQuotes($string);
            }

            if($tmpFunc1 != null) $string = $tmpFunc1.$string;
            if($tmpFunc2 != null) $string = $string.$tmpFunc2;

            if($as !== false) $string = $string." as ".$as;
            return $string;
        }

        function autoValueQuotes($string, $tables){
            $tok = strtok($string, ",");
            while($tok !== false) {
                $values[] = $tok;
                $tok = strtok(",");
            }

            foreach($values as $val1) {
                // (테이블.컬럼) 구조 일때 처리
                preg_match("/((?i)[a-z0-9_-]+)[.]((?i)[a-z0-9_\-\*]+)/", $val1, $matches);
                if($matches) {
                    $isTable = false;

                    foreach($tables as $key2 => $val2) {
                        if($key2 == $matches[1]) $isTable = true;
                        if($val2 == $matches[1]) $isTable = true;
                    }

                    if($isTable) {
                        $return[] = $this->addDoubleQuotes($matches[1]).".".$this->addDoubleQuotes($matches[2]);
                    }
                    else {
                        $return[] = $val1;
                    }
                }
                else if(!is_numeric($val1)) {
                    if(strpos($val1, "'") !== 0)
                        $return[] = "'".$val1."'";
                    else
                        $return[] = $val1;
                }
                else {
                    $return[] = $val1;
                }
            }

            return implode(",", $return);
        }

        /**
         * @brief 트랜잭션 시작
         **/
        function begin() {
            if(!$this->isConnected() || $this->transaction_started) return;
            $this->transaction_started = true;
        }

        /**
         * @brief 롤백
         **/
        function rollback() {
            if(!$this->isConnected() || !$this->transaction_started) return;
            @ibase_rollback($this->fd);
            $this->transaction_started = false;
        }

        /**
         * @brief 커밋
         **/
        function commit() {
            if(!$force && (!$this->isConnected() || !$this->transaction_started)) return;
            @ibase_commit($this->fd);
            $this->transaction_started = false;
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
        function _query($query, $params=null) {
            if(!$this->isConnected()) return;

            if(count($params) == 0) {
                // 쿼리 시작을 알림
                $this->actStart($query);

                // 쿼리 문 실행
                 $result = ibase_query($this->fd, $query);
            }
            else {
                // 쿼리 시작을 알림
                $log = $query."\n\t\t\t";
                $log .= implode(",", $params);
                $this->actStart($log);

                // 쿼리 문 실행 (blob type 입력하기 위한 방법)
                $query = ibase_prepare($this->fd, $query);
                $fnarr = array_merge(array($query), $params);
                $result = call_user_func_array("ibase_execute", $fnarr);
            }

            // 오류 체크
            if(ibase_errmsg()) $this->setError(ibase_errcode(), ibase_errmsg());

            // 쿼리 실행 종료를 알림
            $this->actFinish();

            // 결과 리턴
            return $result;
        }

        /**
         * @brief 결과를 fetch
         **/
        function _fetch($result, $output = null) {
            if(!$this->isConnected() || $this->isError() || !$result) return;

            while($tmp = ibase_fetch_object($result)) {
                foreach($tmp as $key => $val) {
                    $type = $output->column_type[$key];

                    // type 값이 null 일때는 $key값이 alias인 경우라 실제 column 이름을 찾아 type을 구함
                    if($type == null && $output->columns && count($output->columns)) {
                        foreach($output->columns as $cols) {
                            if($cols['alias'] == $key) {
                                // table.column 형식인지 정규식으로 검사 함
                                preg_match("/\w+[.](\w+)/", $cols['name'], $matches);
                                if($matches) {
                                    $type = $output->column_type[$matches[1]];
                                }
                                else {
                                    $type = $output->column_type[$cols['name']];
                                }
                            }
                        }
                    }

                    if(($type == "text" || $type == "bigtext") && $tmp->{$key}) {
                        $blob_data = ibase_blob_info($tmp->{$key});
                        $blob_hndl = ibase_blob_open($tmp->{$key});
                        $tmp->{$key} = ibase_blob_get($blob_hndl, $blob_data[0]);
                        ibase_blob_close($blob_hndl);
                    }
                    else if($type == "char") {
                        $tmp->{$key} = trim($tmp->{$key});	// DB의 character set이 UTF8일때 생기는 빈칸을 제거
                    }
                }

                $return[] = $tmp;
            }

            if(count($return)==1) return $return[0];
            return $return;
        }

        /**
         * @brief 1씩 증가되는 sequence값을 return (firebird의 generator 값을 증가)
         **/
        function getNextSequence() {
            $gen = "GEN_".$this->prefix."sequence_ID";
            $sequence = ibase_gen_id($gen, 1);
            return $sequence;
        }

        /**
         * @brief 테이블 기생성 여부 return
         **/
        function isTableExists($target_name) {
            $query = sprintf("select rdb\$relation_name from rdb\$relations where rdb\$system_flag=0 and rdb\$relation_name = '%s%s';", $this->prefix, $target_name);
            $result = $this->_query($query);
            $tmp = $this->_fetch($result);
            if(!$tmp) {
                if(!$this->transaction_started) @ibase_rollback($this->fd);
                return false;
            }
            if(!$this->transaction_started) @ibase_commit($this->fd);
            return true;
        }

        /**
         * @brief 특정 테이블에 특정 column 추가
         **/
        function addColumn($table_name, $column_name, $type='number', $size='', $default = '', $notnull=false) {
            $type = $this->column_type[$type];
            if(strtoupper($type)=='INTEGER') $size = null;
            else if(strtoupper($type)=='BIGINT') $size = null;
            else if(strtoupper($type)=='BLOB SUB_TYPE TEXT SEGMENT SIZE 32') $size = null;
            else if(strtoupper($type)=='VARCHAR' && !$size) $size = 256;

            $query = sprintf("ALTER TABLE \"%s%s\" ADD \"%s\" ", $this->prefix, $table_name, $column_name);
            if($size) $query .= sprintf(" %s(%s) ", $type, $size);
            else $query .= sprintf(" %s ", $type);
            if(!is_null($default)) $query .= sprintf(" DEFAULT '%s' ", $default);
            if($notnull) $query .= " NOT NULL ";

            $this->_query($query);
            if(!$this->transaction_started) @ibase_commit($this->fd);
        }

        /**
         * @brief 특정 테이블에 특정 column 제거
         **/
        function dropColumn($table_name, $column_name) {
            $query = sprintf("alter table %s%s drop %s ", $this->prefix, $table_name, $column_name);
            $this->_query($query);
            if(!$this->transaction_started) @ibase_commit($this->fd);
        }


        /**
         * @brief 특정 테이블의 column의 정보를 return
         **/
        function isColumnExists($table_name, $column_name) {
            $query = sprintf("SELECT RDB\$FIELD_NAME as \"FIELD\" FROM RDB\$RELATION_FIELDS WHERE RDB\$RELATION_NAME = '%s%s'", $this->prefix, $table_name);
            $result = $this->_query($query);
            if($this->isError()) {
                if(!$this->transaction_started) @ibase_rollback($this->fd);
                return false;
            }

            $output = $this->_fetch($result);
            if(!$this->transaction_started) @ibase_commit($this->fd);

            if($output) {
                $column_name = strtolower($column_name);
                foreach($output as $key => $val) {
                    $name = trim(strtolower($val->FIELD));
                    if($column_name == $name) return true;
                }
            }
            return false;
        }

        /**
         * @brief 특정 테이블에 특정 인덱스 추가
         * $target_columns = array(col1, col2)
         * $is_unique? unique : none
         **/
        function addIndex($table_name, $index_name, $target_columns, $is_unique = false) {
            // index name 크기가 31byte로 제한으로 index name을 넣지 않음
            // Firebird에서는 index name을 넣지 않으면 "RDB$10"처럼 자동으로 이름을 부여함
            // table을 삭제 할 경우 인덱스도 자동으로 삭제 됨

            if(!is_array($target_columns)) $target_columns = array($target_columns);

            $query = sprintf('CREATE %s INDEX "" ON "%s%s" ("%s");', $is_unique?'UNIQUE':'', $this->prefix, $table_name, implode('", "',$target_columns));
            $this->_query($query);

            if(!$this->transaction_started) @ibase_commit($this->fd);
        }

        /**
         * @brief 특정 테이블의 특정 인덱스 삭제
         **/
        function dropIndex($table_name, $index_name, $is_unique = false) {
            $query = sprintf('DROP INDEX "%s" ON "%s%s"', $index_name, $this->prefix, $table_name);
            $this->_query($query);

            if(!$this->transaction_started) @ibase_commit($this->fd);
        }


        /**
         * @brief 특정 테이블의 index 정보를 return
         **/
        function isIndexExists($table_name, $index_name) {
            $query = "SELECT\n";
            $query .= "   RDB\$INDICES.rdb\$index_name AS Key_name\n";
            $query .= "FROM\n";
            $query .= "   RDB\$INDICES, rdb\$index_segments\n";
            $query .= "WHERE\n";
            $query .= "   RDB\$INDICES.rdb\$index_name =  rdb\$index_segments.rdb\$index_name AND\n";
            $query .= "   RDB\$INDICES.rdb\$relation_name = '";
            $query .= $this->prefix;
            $query .= $table_name;
            $query .= "' AND\n";
            $query .= "   RDB\$INDICES.rdb\$index_name = '";
            $query .= $index_name;
            $query .= "'";

            $result = $this->_query($query);
            if($this->isError()) return;
            $output = $this->_fetch($result);

            if(!$output) {
                if(!$this->transaction_started) @ibase_rollback($this->fd);
                return false;
            }

            if(!$this->transaction_started) @ibase_commit($this->fd);

            if(!is_array($output)) $output = array($output);
            for($i=0;$i<count($output);$i++) {
                if(trim($output[$i]->KEY_NAME) == $index_name) return true;
            }

            return false;
        }

        /**
         * @brief xml 을 받아서 테이블을 생성
         **/
        function createTableByXml($xml_doc) {
            return $this->_createTable($xml_doc);
        }

        /**
         * @brief xml 을 받아서 테이블을 생성
         **/
        function createTableByXmlFile($file_name) {
            if(!file_exists($file_name)) return;
            // xml 파일을 읽음
            $buff = FileHandler::readFile($file_name);
            return $this->_createTable($buff);
        }

        /**
         * @brief schema xml을 이용하여 create table query생성
         *
         * type : number, varchar, text, char, date, \n
         * opt : notnull, default, size\n
         * index : primary key, index, unique\n
         **/
        function _createTable($xml_doc) {
            // xml parsing
            $oXml = new XmlParser();
            $xml_obj = $oXml->parse($xml_doc);

            // 테이블 생성 schema 작성
            $table_name = $xml_obj->table->attrs->name;
            if($this->isTableExists($table_name)) return;
            $table_name = $this->prefix.$table_name;

            if(!is_array($xml_obj->table->column)) $columns[] = $xml_obj->table->column;
            else $columns = $xml_obj->table->column;

            foreach($columns as $column) {
                $name = $column->attrs->name;
                $type = $column->attrs->type;
                $size = $column->attrs->size;
                $notnull = $column->attrs->notnull;
                $primary_key = $column->attrs->primary_key;
                $index = $column->attrs->index;
                $unique = $column->attrs->unique;
                $default = $column->attrs->default;
                $auto_increment = $column->attrs->auto_increment;

                if($this->column_type[$type]=='INTEGER') $size = null;
                else if($this->column_type[$type]=='BIGINT') $size = null;
                else if($this->column_type[$type]=='BLOB SUB_TYPE TEXT SEGMENT SIZE 32') $size = null;
                else if($this->column_type[$type]=='VARCHAR' && !$size) $size = 256;

                $column_schema[] = sprintf('"%s" %s%s %s %s',
                    $name,
                    $this->column_type[$type],
                    $size?'('.$size.')':'',
                    is_null($default)?"":"DEFAULT '".$default."'",
                    $notnull?'NOT NULL':'');

                if($auto_increment) $auto_increment_list[] = $name;

                if($primary_key) $primary_list[] = $name;
                else if($unique) $unique_list[$unique][] = $name;
                else if($index) $index_list[$index][] = $name;
            }

            if(count($primary_list)) {
                $column_schema[] = sprintf("PRIMARY KEY(\"%s\")%s", implode("\",\"", $primary_list), "\n");
            }

            if(count($unique_list)) {
                foreach($unique_list as $key => $val) {
                    $column_schema[] = sprintf("UNIQUE(\"%s\")%s", implode("\",\"", $val), "\n");
                }
            }

            $schema = sprintf("CREATE TABLE \"%s\" (%s%s); \n", $table_name, "\n", implode($column_schema, ",\n"));

            $output = $this->_query($schema);
            if(!$this->transaction_started) @ibase_commit($this->fd);
            if(!$output) return false;

            if(count($index_list)) {
                foreach($index_list as $key => $val) {
                    // index name 크기가 31byte로 제한으로 index name을 넣지 않음
                    // Firebird에서는 index name을 넣지 않으면 "RDB$10"처럼 자동으로 이름을 부여함
                    // table을 삭제 할 경우 인덱스도 자동으로 삭제 됨

                    $schema = sprintf("CREATE INDEX \"\" ON \"%s\" (\"%s\");",
                            $table_name, implode($val, "\",\""));
                    $output = $this->_query($schema);
                    if(!$this->transaction_started) @ibase_commit($this->fd);
                    if(!$output) return false;
                }
            }

            foreach($auto_increment_list as $increment) {
                $schema = sprintf('CREATE GENERATOR GEN_%s_ID;', $table_name);
                $output = $this->_query($schema);
                if(!$this->transaction_started) @ibase_commit($this->fd);
                if(!$output) return false;

                // Firebird에서 auto increment는 generator를 만들어 insert 발생시 트리거를 실행시켜
                // generator의 값을 증가시키고 그값을 테이블에 넣어주는 방식을 사용함.
                // 아래 트리거가 auto increment 역할을 하지만 쿼리로 트리거 등록이 되지 않아 주석처리 하였음.
                // php 함수에서 generator 값을 증가시켜 주는 함수가 있어 XE에서는 굳이
                // auto increment를 사용 할 필요가 없어보임.
                /*
                $schema = 'SET TERM ^ ; ';
                $schema .= sprintf('CREATE TRIGGER "%s_BI" FOR "%s" ', $table_name, $table_name);
                $schema .= 'ACTIVE BEFORE INSERT POSITION 0 ';
                $schema .= sprintf('AS BEGIN IF (NEW."%s" IS NULL) THEN ', $increment);
                $schema .= sprintf('NEW."%s" = GEN_ID("GEN_%s_ID",1);', $increment, $table_name);
                $schema .= 'END^ SET TERM ; ^';

                $output = $this->_query($schema);
                if(!$output) return false;
                */
            }
        }

        /**
         * @brief 조건문 작성하여 return
         **/
        function getCondition($output) {
            if(!$output->conditions) return;
            $condition = $this->_getCondition($output->conditions,$output->column_type,$output->_tables);
            if($condition) $condition = ' where '.$condition;
            return $condition;
        }

        function getLeftCondition($conditions,$column_type,$tables){
            return $this->_getCondition($conditions,$column_type,$tables);
        }


        function _getCondition($conditions,$column_type,$tables) {
            $condition = '';
            foreach($conditions as $val) {
                $sub_condition = '';
                foreach($val['condition'] as $v) {
                    if(!isset($v['value'])) continue;
                    if($v['value'] === '') continue;
                    if(!in_array(gettype($v['value']), array('string', 'integer', 'double'))) continue;

                    $name = $v['column'];
                    $operation = $v['operation'];
                    $value = $v['value'];
                    $type = $this->getColumnType($column_type,$name);
                    $pipe = $v['pipe'];

                    $value = $this->getConditionValue('"'.$name.'"', $value, $operation, $type, $column_type);
                    if(!$value) $value = $v['value'];

                    $name = $this->autoQuotes($name);
                    $value = $this->autoValueQuotes($value, $tables);

                    $str = $this->getConditionPart($name, $value, $operation);
                    if($sub_condition) $sub_condition .= ' '.$pipe.' ';
                    $sub_condition .=  $str;
                }
                if($sub_condition) {
                    if($condition && $val['pipe']) $condition .= ' '.$val['pipe'].' ';
                    $condition .= '('.$sub_condition.')';
                }
            }

            return $condition;
        }

        /**
         * @brief insertAct 처리
         **/
        function _executeInsertAct($output) {
            // 테이블 정리
            foreach($output->tables as $key => $val) {
                $table_list[] = '"'.$this->prefix.$val.'"';
            }

            // 컬럼 정리
            foreach($output->columns as $key => $val) {
                $name = $val['name'];
                $value = $val['value'];

                $value = str_replace("'", "`", $value);

                if($output->column_type[$name]=="text" || $output->column_type[$name]=="bigtext"){
                    if(!isset($val['value'])) continue;
                    $blh = ibase_blob_create($this->fd);
                    ibase_blob_add($blh, $value);
                    $value = ibase_blob_close($blh);
                }
                else if($output->column_type[$name]!='number') {
//                    if(!$value) $value = 'null';
                }
                else $this->_filterNumber(&$value);

                $column_list[] = '"'.$name.'"';
                $value_list[] = $value;
                $questions[] = "?";
            }

            $query = sprintf("insert into %s (%s) values (%s);", implode(',',$table_list), implode(',',$column_list), implode(',', $questions));

            $result = $this->_query($query, $value_list);
            if(!$this->transaction_started) @ibase_commit($this->fd);
            return $result;
        }

        /**
         * @brief updateAct 처리
         **/
        function _executeUpdateAct($output) {
            // 테이블 정리
            foreach($output->tables as $key => $val) {
                $table_list[] = '"'.$this->prefix.$val.'"';
            }

            // 컬럼 정리
            foreach($output->columns as $key => $val) {
                if(!isset($val['value'])) continue;
                $name = $val['name'];
                $value = $val['value'];

                $value = str_replace("'", "`", $value);

                if(strpos($name,'.')!==false&&strpos($value,'.')!==false) $column_list[] = $name.' = '.$value;
                else {
                    if($output->column_type[$name]=="text" || $output->column_type[$name]=="bigtext"){
                        $blh = ibase_blob_create($this->fd);
                        ibase_blob_add($blh, $value);
                        $value = ibase_blob_close($blh);
                    }
                    else if($output->column_type[$name]=='number' ||
                            $output->column_type[$name]=='bignumber' ||
                            $output->column_type[$name]=='float') {
                        // 연산식이 들어갔을 경우 컬럼명이 있는 지 체크해 더블쿼터를 넣어줌
                        preg_match("/(?i)[a-z][a-z0-9_]+/", $value, $matches);

                        foreach($matches as $key => $val) {
                            $value = str_replace($val, "\"".$val."\"", $value);
                        }

                        if($matches != null) {
                            $column_list[] = sprintf("\"%s\" = %s", $name, $value);
                            continue;
                        }
                    }

                    $values[] = $value;
                    $column_list[] = sprintf('"%s" = ?', $name);
                }
            }

            // 조건절 정리
            $condition = $this->getCondition($output);

            $query = sprintf("update %s set %s %s;", implode(',',$table_list), implode(',',$column_list), $condition);
            $result = $this->_query($query, $values);
            if(!$this->transaction_started) @ibase_commit($this->fd);
            return $result;
        }

        /**
         * @brief deleteAct 처리
         **/
        function _executeDeleteAct($output) {
            // 테이블 정리
            foreach($output->tables as $key => $val) {
                $table_list[] = '"'.$this->prefix.$val.'"';
            }

            // 조건절 정리
            $condition = $this->getCondition($output);

            $query = sprintf("delete from %s %s;", implode(',',$table_list), $condition);

            $result = $this->_query($query);
            if(!$this->transaction_started) @ibase_commit($this->fd);
            return $result;
        }

        /**
         * @brief selectAct 처리
         *
         * select의 경우 특정 페이지의 목록을 가져오는 것을 편하게 하기 위해\n
         * navigation이라는 method를 제공
         **/
        function _executeSelectAct($output) {
            // 테이블 정리
            $table_list = array();
            foreach($output->tables as $key => $val) {
                $table_list[] = sprintf("\"%s%s\" as \"%s\"", $this->prefix, $val, $key);
            }

            $left_join = array();
            // why???
            $left_tables= (array)$output->left_tables;

            foreach($left_tables as $key => $val) {
                $condition = $this->getLeftCondition($output->left_conditions[$key],$output->column_type,$output->_tables);
                if($condition){
                    $left_join[] = $val . ' "'.$this->prefix.$output->_tables[$key].'" as "'.$key.'" on (' . $condition . ')';
                }
            }

            $click_count = array();
            if(!$output->columns){
				$output->columns = array(array('name'=>'*'));
			}

			$column_list = array();
			foreach($output->columns as $key => $val) {
				$name = $val['name'];
				$alias = $val['alias'];
				if($val['click_count']) $click_count[] = $val['name'];

				if($alias == "")
					$column_list[] = $this->autoQuotes($name);
				else
					$column_list[$alias] = sprintf("%s as \"%s\"", $this->autoQuotes($name), $alias);
			}
			$columns = implode(',',$column_list);

            $condition = $this->getCondition($output);

			$output->column_list = $column_list;
            if($output->list_count && $output->page) return $this->_getNavigationData($table_list, $columns, $left_join, $condition, $output);

            // list_order, update_order 로 정렬시에 인덱스 사용을 위해 condition에 쿼리 추가
            if($output->order) {
                $conditions = $this->getConditionList($output);
                if(!in_array('list_order', $conditions) && !in_array('update_order', $conditions)) {
                    foreach($output->order as $key => $val) {
                        $col = $val[0];
                        if(!in_array($col, array('list_order','update_order'))) continue;
                        if($condition) $condition .= sprintf(' and "%s" < 2100000000 ', $col);
                        else $condition = sprintf(' where "%s" < 2100000000 ', $col);
                    }
                }
            }

            // list_count를 사용할 경우 적용
            if($output->list_count['value']) $limit = sprintf('FIRST %d', $output->list_count['value']);
            else $limit = '';


            if($output->groups) {
                foreach($output->groups as $key => $val) {
                    $group_list[] = $this->autoQuotes($val);
					if($column_list[$val]) $output->arg_columns[] = $column_list[$val];
                }
                if(count($group_list)) $groupby_query = sprintf(" group by %s", implode(",",$group_list));
            }

            if($output->order) {
                foreach($output->order as $key => $val) {
                    $index_list[] = sprintf("%s %s", $this->autoQuotes($val[0]), $val[1]);
					if(count($output->arg_columns) && $column_list[$val[0]]) $output->arg_columns[] = $column_list[$val[0]];
                }
                if(count($index_list)) $orderby_query = sprintf(" order by %s", implode(",",$index_list));
            }

			if(count($output->arg_columns))
			{
				$columns = array();
				foreach($output->arg_columns as $col){
					if(strpos($col,'"')===false && strpos($col,' ')==false) $columns[] = '"'.$col.'"'; 
					else $columns[] = $col;
				}
				
				$columns = join(',',$columns);
			}

            $query = sprintf("select %s from %s %s %s %s", $columns, implode(',',$table_list),implode(' ',$left_join), $condition, $groupby_query.$orderby_query);
            $query .= ";";
			$query .= (__DEBUG_QUERY__&1 && $output->query_id)?sprintf(' '.$this->comment_syntax,$this->query_id):'';
            $result = $this->_query($query);
            if($this->isError()) {
                if(!$this->transaction_started) @ibase_rollback($this->fd);
                return;
            }

            $data = $this->_fetch($result, $output);
            if(!$this->transaction_started) @ibase_commit($this->fd);

            if(count($click_count)>0 && count($output->conditions)>0){
                $_query = '';
                foreach($click_count as $k => $c) $_query .= sprintf(',%s=%s+1 ',$c,$c);
                $_query = sprintf('update %s set %s %s',implode(',',$table_list), substr($_query,1),  $condition);
                $this->_query($_query);
            }

            $buff = new Object();
            $buff->data = $data;
            return $buff;
        }

        /**
         * @brief query xml에 navigation 정보가 있을 경우 페이징 관련 작업을 처리한다
         *
         * 그닥 좋지는 않은 구조이지만 편리하다.. -_-;
         **/
        function _getNavigationData($table_list, $columns, $left_join, $condition, $output) {
           require_once('./util/PageHandler.class.php');

			$column_list = $output->column_list;

            $query_groupby = '';
            if ($output->groups) {
                foreach ($output->groups as $key => $val){
                    $group_list[] = $this->autoQuotes($val);
					if($column_list[$val]) $output->arg_columns[] = $column_list[$val];
				}
                if (count($group_list)) $query_groupby = sprintf(" GROUP BY %s", implode(", ", $group_list));
            }

            /*
            // group by 절이 포함된 SELECT 쿼리의 전체 갯수를 구하기 위한 수정
            // 정상적인 동작이 확인되면 주석으로 막아둔 부분으로 대체합니다.
            //
            $count_condition = strlen($query_groupby) ? sprintf('%s group by %s', $condition, $query_groupby) : $condition;
            $total_count = $this->getCountCache($output->tables, $count_condition);
            if($total_count === false) {
                $count_query = sprintf('select count(*) as "count" from %s %s %s', implode(', ', $table_list), implode(' ', $left_join), $count_condition);
                if (count($output->groups))
                    $count_query = sprintf('select count(*) as "count" from (%s) xet', $count_query);
                $result = $this->_query($count_query);
                $count_output = $this->_fetch($result);
                $total_count = (int)$count_output->count;
                $this->putCountCache($output->tables, $count_condition, $total_count);
            }
            */

            // 전체 개수를 구함
            $count_query = sprintf("select count(*) as \"count\" from %s %s %s", implode(',',$table_list),implode(' ',$left_join), $condition);
			$count_query .= (__DEBUG_QUERY__&1 && $output->query_id)?sprintf(' '.$this->comment_syntax,$this->query_id . ' count(*)'):'';
			$result = $this->_query($count_query);
			$count_output = $this->_fetch($result);
			if(!$this->transaction_started) @ibase_commit($this->fd);

			$total_count = (int)$count_output->count;

            $list_count = $output->list_count['value'];
            if(!$list_count) $list_count = 20;
            $page_count = $output->page_count['value'];
            if(!$page_count) $page_count = 10;
            $page = $output->page['value'];
            if(!$page) $page = 1;

            // 전체 페이지를 구함
            if($total_count) $total_page = (int)( ($total_count-1) / $list_count) + 1;
            else $total_page = 1;

            // 페이지 변수를 체크
            if($page > $total_page) $page = $total_page;
            $start_count = ($page-1)*$list_count;

            // list_order, update_order 로 정렬시에 인덱스 사용을 위해 condition에 쿼리 추가
            if($output->order) {
                $conditions = $this->getConditionList($output);
                if(!in_array('list_order', $conditions) && !in_array('update_order', $conditions)) {
                    foreach($output->order as $key => $val) {
                        $col = $val[0];
                        if(!in_array($col, array('list_order','update_order'))) continue;
                        if($condition) $condition .= sprintf(' and "%s" < 2100000000 ', $col);
                        else $condition = sprintf(' where "%s" < 2100000000 ', $col);
                    }
                }
            }

            $limit = sprintf('FIRST %d SKIP %d ', $list_count, $start_count);


            if($output->order) {
                foreach($output->order as $key => $val) {
                    $index_list[] = sprintf("%s %s", $this->autoQuotes($val[0]), $val[1]);
					if(count($output->arg_columns) && $column_list[$val[0]]) $output->arg_columns[] = $column_list[$val[0]];
                }
                if(count($index_list)) $orderby_query = sprintf(" ORDER BY %s", implode(",",$index_list));
            }

			if(count($output->arg_columns))
			{
				$columns = array();
				foreach($output->arg_columns as $col){
					if(strpos($col,'"')===false && strpos($col,' ')==false) $columns[] = '"'.$col.'"'; 
					else $columns[] = $col;
				}
				
				$columns = join(',',$columns);
			}

            $query = sprintf('SELECT %s %s FROM %s %s %s, %s', $limit, $columns, implode(',',$table_list), implode(' ',$left_join), $condition, $groupby_query.$orderby_query);
            $query .= ";";
			$query .= (__DEBUG_QUERY__&1 && $output->query_id)?sprintf(' '.$this->comment_syntax,$this->query_id):'';
            $result = $this->_query($query);
            if($this->isError()) {
                if(!$this->transaction_started) @ibase_rollback($this->fd);

                $buff = new Object();
                $buff->total_count = 0;
                $buff->total_page = 0;
                $buff->page = 1;
                $buff->data = array();

                $buff->page_navigation = new PageHandler($total_count, $total_page, $page, $page_count);
                return $buff;
            }

            $virtual_no = $total_count - ($page-1)*$list_count;
            while($tmp = ibase_fetch_object($result)) {
                foreach($tmp as $key => $val){
                    $type = $output->column_type[$key];

                    // type 값이 null 일때는 $key값이 alias인 경우라 실제 column 이름을 찾아 type을 구함
                    if($type == null && $output->columns && count($output->columns)) {
                        foreach($output->columns as $cols) {
                            if($cols['alias'] == $key) {
                                // table.column 형식인지 정규식으로 검사 함
                                preg_match("/\w+[.](\w+)/", $cols['name'], $matches);
                                if($matches) {
                                    $type = $output->column_type[$matches[1]];
                                }
                                else {
                                    $type = $output->column_type[$cols['name']];
                                }
                            }
                        }
                    }

                    if(($type == "text" || $type == "bigtext") && $tmp->{$key}) {
                        $blob_data = ibase_blob_info($tmp->{$key});
                        $blob_hndl = ibase_blob_open($tmp->{$key});
                        $tmp->{$key} = ibase_blob_get($blob_hndl, $blob_data[0]);
                        ibase_blob_close($blob_hndl);
                    }
                }

                $data[$virtual_no--] = $tmp;
            }

            if(!$this->transaction_started) @ibase_commit($this->fd);

            $buff = new Object();
            $buff->total_count = $total_count;
            $buff->total_page = $total_page;
            $buff->page = $page;
            $buff->data = $data;

            $buff->page_navigation = new PageHandler($total_count, $total_page, $page, $page_count);
            return $buff;
        }
    }

return new DBFireBird;
?>
