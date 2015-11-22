<?php
    /**
     * @class DBCubrid
     * @author NHN (developers@xpressengine.com)
     * @brief Cubrid DBMS를 이용하기 위한 class
     * @version 0.1p1
     *
     * CUBRID2008 R1.3 에 대응하도록 수정 Prototype (prototype@cubrid.com) / 09.02.23
     * 7.3 ~ 2008 R1.3 까지 테스트 완료함.
     * 기본 쿼리만 사용하였기에 특화된 튜닝이 필요
     **/

    class DBCubrid extends DB
    {

        /**
         * @brief Cubrid DB에 접속하기 위한 정보
         **/
        var $hostname = '127.0.0.1'; ///< hostname
        var $userid = NULL; ///< user id
        var $password = NULL; ///< password
        var $database = NULL; ///< database
        var $port = 33000; ///< db server port
        var $prefix = NULL; ///< XE에서 사용할 테이블들의 prefix  (한 DB에서 여러개의 XE 설치 가능)
        var $cutlen = 12000; ///< 큐브리드의 최대 상수 크기(스트링이 이보다 크면 '...'+'...' 방식을 사용해야 한다
        var $comment_syntax = '/* %s */';

        /**
         * @brief cubrid에서 사용될 column type
         *
         * column_type은 schema/query xml에서 공통 선언된 type을 이용하기 때문에
         * 각 DBMS에 맞게 replace 해주어야 한다
         **/
        var $column_type = array(
            'bignumber' => 'numeric(20)',
            'number' => 'integer',
            'varchar' => 'character varying',
            'char' => 'character',
            'tinytext' => 'character varying(256)',
            'text' => 'character varying(1073741823)',
            'bigtext' => 'character varying(1073741823)',
            'date' => 'character varying(14)',
            'float' => 'float',
        );

        /**
         * @brief constructor
         **/
        function DBCubrid()
        {
            $this->_setDBInfo();
            $this->_connect();
        }
		
		/**
		 * @brief create an instance of this class
		 */
		function create()
		{
			return new DBCubrid;
		}

        /**
         * @brief 설치 가능 여부를 return
         **/
        function isSupported()
        {
            if (!function_exists('cubrid_connect')) return false;
            return true;
        }

        /**
         * @brief DB정보 설정 및 connect/ close
         **/
        function _setDBInfo()
        {
            //$db_info = Context::getDBInfo();
			require('db.config.php');
            $this->hostname = $db_info->db_hostname;
            $this->userid   = $db_info->db_userid;
            $this->password   = $db_info->db_password;
            $this->database = $db_info->db_database;
            $this->port = $db_info->db_port;
            $this->prefix = $db_info->db_table_prefix;

            if (!substr($this->prefix, -1) != '_') $this->prefix .= '_';
        }

        /**
         * @brief DB 접속
         **/
        function _connect()
        {
            // db 정보가 없으면 무시
            if (!$this->hostname || !$this->userid || !$this->password || !$this->database || !$this->port) return;

            // 접속시도
            $this->fd = @cubrid_connect ($this->hostname, $this->port, $this->database, $this->userid, $this->password);

            // 접속체크
            if (!$this->fd) {
                $this->setError (-1, 'database connect fail');
                return $this->is_connected = false;
            }

            $this->is_connected = true;
            $this->password = md5 ($this->password);
        }

        /**
         * @brief DB접속 해제
         **/
        function close()
        {
            if (!$this->isConnected ()) return;

            @cubrid_commit ($this->fd);
            @cubrid_disconnect ($this->fd);
            $this->transaction_started = false;
        }

        /**
         * @brief 쿼리에서 입력되는 문자열 변수들의 quotation 조절
         **/
        function addQuotes($string)
        {
            if (!$this->fd) return $string;

            if (version_compare (PHP_VERSION, "5.9.0", "<") &&
              get_magic_quotes_gpc ()) {
                $string = stripslashes (str_replace ("\\","\\\\", $string));
            }

            if (!is_numeric ($string)) {
            /*
                if ($this->isConnected()) {
                    $string = cubrid_real_escape_string($string);
                }
                else {
                    $string = str_replace("'","\'",$string);
                }
                */

                $string = str_replace("'","''",$string);
            }

            return $string;
        }

        /**
         * @brief 트랜잭션 시작
         **/
        function begin()
        {
            if (!$this->isConnected () || $this->transaction_started) return;
            $this->transaction_started = true;
        }

        /**
         * @brief 롤백
         **/
        function rollback()
        {
            if (!$this->isConnected () || !$this->transaction_started) return;
            @cubrid_rollback ($this->fd);
            $this->transaction_started = false;
        }

        /**
         * @brief 커밋
         **/
        function commit()
        {
            if (!$force && (!$this->isConnected () ||
              !$this->transaction_started)) return;

            @cubrid_commit($this->fd);
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
        function _query($query)
        {
            if (!$query || !$this->isConnected ()) return;

            // 쿼리 시작을 알림
            $this->actStart ($query);

            // 쿼리 문 실행
            $result = @cubrid_execute ($this->fd, $query);
            // 오류 체크
            if (cubrid_error_code ()) {
                $code = cubrid_error_code ();
                $msg = cubrid_error_msg ();

                $this->setError ($code, $msg);
            }

            // 쿼리 실행 종료를 알림
            $this->actFinish ();

            // 결과 리턴
            return $result;
        }

        /**
         * @brief 결과를 fetch
         **/
        function _fetch($result)
        {
            if (!$this->isConnected() || $this->isError() || !$result) return;

            $col_types = cubrid_column_types ($result);
            $col_names = cubrid_column_names ($result);
            $max = count ($col_types);

            for ($count = 0; $count < $max; $count++) {
                if (preg_match ("/^char/", $col_types[$count]) > 0) {
                    $char_type_fields[] = $col_names[$count];
                }
            }

            while ($tmp = cubrid_fetch ($result, CUBRID_OBJECT)) {
                if (is_array ($char_type_fields)) {
                    foreach ($char_type_fields as $val) {
                        $tmp->{$val} = rtrim ($tmp->{$val});
                    }
                }

                $output[] = $tmp;
            }

            unset ($char_type_fields);

            if ($result) cubrid_close_request($result);

            if (count ($output) == 1) return $output[0];
            return $output;
        }

        /**
         * @brief 1씩 증가되는 sequence 값을 return (cubrid의 auto_increment는 sequence테이블에서만 사용)
         **/
        function getNextSequence()
        {
            $this->_makeSequence();

            $query = sprintf ("select \"%ssequence\".\"nextval\" as \"seq\" from db_root", $this->prefix);
            $result = $this->_query($query);
            $output = $this->_fetch($result);

            return $output->seq;
        }

        /**
         * @brief 마이그레이션시 sequence  가 없을 경우 생성
         **/
        function _makeSequence()
        {
            if($_GLOBALS['XE_EXISTS_SEQUENCE']) return;

            // check cubrid serial
            $query = sprintf('select count(*) as "count" from "db_serial" where name=\'%ssequence\'', $this->prefix);
            $result = $this->_query($query);
            $output = $this->_fetch($result);

            // if do not create serial
            if ($output->count == 0) {
                $query = sprintf('select max("a"."srl") as "srl" from '.
                                 '( select max("document_srl") as "srl" from '.
                                 '"%sdocuments" UNION '.
                                 'select max("comment_srl") as "srl" from '.
                                 '"%scomments" UNION '.
                                 'select max("member_srl") as "srl" from '.
                                 '"%smember"'.
                                  ') as "a"', $this->prefix, $this->prefix, $this->prefix);

                $result = $this->_query($query);
                $output = $this->_fetch($result);
                $srl = $output->srl;
                if ($srl < 1) {
                    $start = 1;
                }
                else {
                    $start = $srl + 1000000;
                }

                // create sequence
                $query = sprintf('create serial "%ssequence" start with %s increment by 1 minvalue 1 maxvalue 10000000000000000000000000000000000000 nocycle;', $this->prefix, $start);
                $this->_query($query);
            }

            $_GLOBALS['XE_EXISTS_SEQUENCE'] = true;
        }


        /**
         * @brief 테이블 기생성 여부 return
         **/
        function isTableExists ($target_name)
        {
            if($target_name == 'sequence') {
                $query = sprintf ("select \"name\" from \"db_serial\" where \"name\" = '%s%s'", $this->prefix, $target_name);
            }
            else {
                $query = sprintf ("select \"class_name\" from \"db_class\" where \"class_name\" = '%s%s'", $this->prefix, $target_name);
            }

            $result = $this->_query ($query);
            if (cubrid_num_rows($result) > 0) {
                $output = true;
            }
            else {
                $output = false;
            }

            if ($result) cubrid_close_request ($result);

            return $output;
        }

        /**
         * @brief 특정 테이블에 특정 column 추가
         **/
        function addColumn($table_name, $column_name, $type = 'number', $size = '', $default = '', $notnull = false)
        {
            $type = strtoupper($this->column_type[$type]);
            if ($type == 'INTEGER') $size = '';

            $query = sprintf ("alter class \"%s%s\" add \"%s\" ", $this->prefix, $table_name, $column_name);

            if ($type == 'char' || $type == 'varchar') {
                if ($size) $size = $size * 3;
            }

            if ($size) {
                $query .= sprintf ("%s(%s) ", $type, $size);
            }
            else {
                $query .= sprintf ("%s ", $type);
            }

            if ($default) {
                if ($type == 'INTEGER' || $type == 'BIGINT' || $type=='INT') {
                    $query .= sprintf ("default %d ", $default);
                }
                else {
                    $query .= sprintf ("default '%s' ", $default);
                }
            }

            if ($notnull) $query .= "not null ";

            $this->_query ($query);
        }

        /**
         * @brief 특정 테이블에 특정 column 제거
         **/
        function dropColumn ($table_name, $column_name)
        {
            $query = sprintf ("alter class \"%s%s\" drop \"%s\" ", $this->prefix, $table_name, $column_name);

            $this->_query ($query);
        }

        /**
         * @brief 특정 테이블의 column의 정보를 return
         **/
        function isColumnExists ($table_name, $column_name)
        {
            $query = sprintf ("select \"attr_name\" from \"db_attribute\" where ".  "\"attr_name\" ='%s' and \"class_name\" = '%s%s'", $column_name, $this->prefix, $table_name);
            $result = $this->_query ($query);

            if (cubrid_num_rows ($result) > 0) $output = true;
            else $output = false;

            if ($result) cubrid_close_request ($result);

            return $output;
        }

        /**
         * @brief 특정 테이블에 특정 인덱스 추가
         * $target_columns = array(col1, col2)
         * $is_unique? unique : none
         **/
        function addIndex ($table_name, $index_name, $target_columns, $is_unique = false)
        {
            if (!is_array ($target_columns)) {
                $target_columns = array ($target_columns);
            }

            $query = sprintf ("create %s index \"%s\" on \"%s%s\" (%s);", $is_unique?'unique':'', $this->prefix .$index_name, $this->prefix, $table_name, '"'.implode('","',$target_columns).'"');

            $this->_query ($query);
        }

        /**
         * @brief 특정 테이블의 특정 인덱스 삭제
         **/
        function dropIndex ($table_name, $index_name, $is_unique = false)
        {
            $query = sprintf ("drop %s index \"%s\" on \"%s%s\"", $is_unique?'unique':'', $this->prefix .$index_name, $this->prefix, $table_name);

            $this->_query($query);
        }

        /**
         * @brief 특정 테이블의 index 정보를 return
         **/
        function isIndexExists ($table_name, $index_name)
        {
            $query = sprintf ("select \"index_name\" from \"db_index\" where ".  "\"class_name\" = '%s%s' and \"index_name\" = '%s' ", $this->prefix, $table_name, $this->prefix .$index_name);
            $result = $this->_query ($query);

            if ($this->isError ()) return false;

            $output = $this->_fetch ($result);

            if (!$output) return false;
            return true;
        }

        /**
         * @brief xml 을 받아서 테이블을 생성
         **/
        function createTableByXml ($xml_doc)
        {
            return $this->_createTable ($xml_doc);
        }

        /**
         * @brief xml 을 받아서 테이블을 생성
         **/
        function createTableByXmlFile ($file_name)
        {
            if (!file_exists ($file_name)) return;
            // xml 파일을 읽음
            $buff = FileHandler::readFile ($file_name);

            return $this->_createTable ($buff);
        }

        /**
         * @brief schema xml을 이용하여 create class query생성
         *
         * type : number, varchar, tinytext, text, bigtext, char, date, \n
         * opt : notnull, default, size\n
         * index : primary key, index, unique\n
         **/
        function _createTable ($xml_doc)
        {
            // xml parsing
            $oXml = new XmlParser();
            $xml_obj = $oXml->parse($xml_doc);

            // 테이블 생성 schema 작성
            $table_name = $xml_obj->table->attrs->name;

			// if the table already exists exit function
            if ($this->isTableExists($table_name)) return;

            // 만약 테이블 이름이 sequence라면 serial 생성
            if ($table_name == 'sequence') {
                $query = sprintf ('create serial "%s" start with 1 increment by 1'.
                                  ' minvalue 1 '.
                                  'maxvalue 10000000000000000000000000000000000000'.  ' nocycle;', $this->prefix.$table_name);

                return $this->_query($query);
            }


            $table_name = $this->prefix.$table_name;

            $query = sprintf ('create class "%s";', $table_name);
            $this->_query ($query);

            if (!is_array ($xml_obj->table->column)) {
                $columns[] = $xml_obj->table->column;
            }
            else {
                $columns = $xml_obj->table->column;
            }

            $query = sprintf ("alter class \"%s\" add attribute ", $table_name);

            foreach ($columns as $column) {
                $name = $column->attrs->name;
                $type = $column->attrs->type;
                $size = $column->attrs->size;
                $notnull = $column->attrs->notnull;
                $primary_key = $column->attrs->primary_key;
                $index = $column->attrs->index;
                $unique = $column->attrs->unique;
                $default = $column->attrs->default;

                switch ($this->column_type[$type]) {
                    case 'integer' :
                        $size = null;
                        break;
                    case 'text' :
                        $size = null;
                        break;
                }

                if (isset ($default) && ($type == 'varchar' || $type == 'char' ||
                  $type == 'text' || $type == 'tinytext' || $type == 'bigtext')) {
                    $default = sprintf ("'%s'", $default);
                }

                if ($type == 'varchar' || $type == 'char') {
                    if($size) $size = $size * 3;
                }


                $column_schema[] = sprintf ('"%s" %s%s %s %s',
                                    $name,
                                    $this->column_type[$type],
                                    $size?'('.$size.')':'',
                                    isset($default)?"default ".$default:'',
                                    $notnull?'not null':'');

                if ($primary_key) {
                    $primary_list[] = $name;
                }
                else if ($unique) {
                    $unique_list[$unique][] = $name;
                }
                else if ($index) {
                    $index_list[$index][] = $name;
                }
            }

            $query .= implode (',', $column_schema).';';
            $this->_query ($query);

            if (count ($primary_list)) {
                $query = sprintf ("alter class \"%s\" add attribute constraint ".  "\"pkey_%s\" PRIMARY KEY(%s);", $table_name, $table_name, '"'.implode('","',$primary_list).'"');
                $this->_query ($query);
            }

            if (count ($unique_list)) {
                foreach ($unique_list as $key => $val) {
                    $query = sprintf ("create unique index \"%s\" on \"%s\" ".  "(%s);", $this->prefix .$key, $table_name, '"'.implode('","', $val).'"');
                    $this->_query ($query);
                }
            }

            if (count ($index_list)) {
                foreach ($index_list as $key => $val) {
                    $query = sprintf ("create index \"%s\" on \"%s\" (%s);", $this->prefix .$key, $table_name, '"'.implode('","',$val).'"');
                    $this->_query ($query);
                }
            }
        }

        /**
         * @brief 조건문 작성하여 return
         **/
        function getCondition ($output)
        {
            if (!$output->conditions) return;
            $condition = $this->_getCondition ($output->conditions, $output->column_type, $output);
            if ($condition) $condition = ' where '.$condition;

            return $condition;
        }

        function _getCondition ($conditions, $column_type, &$output)
        {
            $condition = '';

            foreach ($conditions as $val) {
                $sub_condition = '';

                foreach ($val['condition'] as $v) {
                    if (!isset ($v['value'])) continue;
                    if ($v['value'] === '') continue;
                    if(!in_array(gettype($v['value']), array('string', 'integer', 'double', 'array'))) continue;

                    $name = $v['column'];
                    $operation = $v['operation'];
                    $value = $v['value'];
                    $type = $this->getColumnType ($column_type, $name);
                    $pipe = $v['pipe'];
                    $value = $this->getConditionValue ($name, $value, $operation, $type, $column_type);

                    if (!$value) {
                        $value = $v['value'];
                        if (strpos ($value, '(')) {
                            $valuetmp = $value;
                        }
                        elseif (strpos ($value, ".") === false) {
                            $valuetmp = $value;
                        }
                        else {
                            $valuetmp = '"'.str_replace('.', '"."', $value).'"';
                        }
                    }
                    else {
                        $tmp = explode('.',$value);

                        if (count($tmp)==2) {
                            $table = $tmp[0];
                            $column = $tmp[1];

                            if ($column_type[$column] && (in_array ($table, $output->tables) ||
                              array_key_exists($table, $output->tables))) {
                                $valuetmp = sprintf('"%s"."%s"', $table, $column);
                            }
                            else {
                                $valuetmp = $value;
                            }
                        }
                        else {
                            $valuetmp = $value;
                        }
                    }

                    if (strpos ($name, '(') > 0) {
                        $nametmp = $name;
                    }
                    elseif (strpos ($name, ".") === false) {
                        $nametmp = '"'.$name.'"';
                    }
                    else {
                        $nametmp = '"'.str_replace('.', '"."', $name).'"';
                    }
                    $str = $this->getConditionPart ($nametmp, $valuetmp, $operation);
                    if ($sub_condition) $sub_condition .= ' '.$pipe.' ';
                    $sub_condition .= $str;
                }

                if ($sub_condition) {
                    if ($condition && $val['pipe']) {
                        $condition .= ' '.$val['pipe'].' ';
                    }
                    $condition .= '('.$sub_condition.')';
                }
            }

            return $condition;
        }

        /**
         * @brief insertAct 처리
         **/
        function _executeInsertAct ($output)
        {
            // 테이블 정리
            foreach ($output->tables as $val) {
                $table_list[] = '"'.$this->prefix.$val.'"';
            }

            // 컬럼 정리
            foreach ($output->columns as $key => $val) {
                $name = $val['name'];
                $value = $val['value'];
                //if ($this->getColumnType ($output->column_type, $name) != 'number')
                if ($output->column_type[$name] != 'number') {
                    if (!is_null($value)) {
                        $value = "'" . $this->addQuotes($value) ."'";
                    }
                    else {
                        if ($val['notnull']=='notnull') {
                            $value = "''";
                        }
                        else {
                            //$value = 'null';
                            $value = "''";
                        }
                    }
                }
                else $this->_filterNumber(&$value);

                $column_list[] = '"'.$name.'"';
                $value_list[] = $value;
            }

            $query = sprintf ("insert into %s (%s) values (%s);", implode(',', $table_list), implode(',', $column_list), implode(',', $value_list));

            $query .= (__DEBUG_QUERY__&1 && $output->query_id)?sprintf (' '.$this->comment_syntax, $this->query_id):'';
            $result = $this->_query ($query);
            if ($result && !$this->transaction_started) {
                @cubrid_commit ($this->fd);
            }

            return $result;
        }

        /**
         * @brief updateAct 처리
         **/
        function _executeUpdateAct ($output)
        {
            // 테이블 정리
            foreach ($output->tables as $key => $val) {
                $table_list[] = '"'.$this->prefix.$val.'" as "'.$key.'"';
            }

            $check_click_count = true;

            // 컬럼 정리
            foreach ($output->columns as $key => $val) {
                if (!isset ($val['value'])) continue;
                $name = $val['name'];
                $value = $val['value'];

                if (substr ($value, -2) != '+1' || $output->column_type[$name] != 'number') {
                    $check_click_count = false;
                }

                for ($i = 0; $i < $key; $i++) {
                    /* 한문장에 같은 속성에 대한 중복 설정은 큐브리드에서는 허용치 않음 */
                    if ($output->columns[$i]['name'] == $name) break;
                }
                if ($i < $key) continue; // 중복이 발견되면 이후의 설정은 무시

                if (strpos ($name, '.') !== false && strpos ($value, '.') !== false) {
                    $column_list[] = $name.' = '.$value;
                }
                else {
                    if ($output->column_type[$name] != 'number') {
                        $check_column = false;
                        $value = "'".$this->addQuotes ($value)."'";
                    }
					else $this->_filterNumber(&$value);

                    $column_list[] = sprintf ("\"%s\" = %s", $name, $value);
                }
            }

            // 조건절 정리
            $condition = $this->getCondition ($output);

            $check_click_count_condition = false;
            if ($check_click_count) {
                foreach ($output->conditions as $val) {
                    if ($val['pipe'] == 'or') {
                        $check_click_count_condition = false;
                        break;
                    }

                    foreach ($val['condition'] as $v) {
                        if ($v['operation'] == 'equal') {
                            $check_click_count_condition = true;
                        }
                        else {
                            if ($v['operation'] == 'in' && !strpos ($v['value'], ',')) {
                                $check_click_count_condition = true;
                            }
                            else {
                                $check_click_count_condition = false;
                            }
                        }

                        if ($v['pipe'] == 'or') {
                            $check_click_count_condition = false;
                            break;
                        }
                    }
                }
            }

            if ($check_click_count&& $check_click_count_condition && count ($output->tables) == 1 && count ($output->conditions) > 0 && count ($output->groups) == 0 && count ($output->order) == 0) {
                foreach ($output->columns as $v) {
                    $incr_columns[] = 'incr("'.$v['name'].'")';
                }

                $query = sprintf ('select %s from %s %s', join (',', $incr_columns), implode(',', $table_list), $condition);
            }
            else {
                $query = sprintf ("update %s set %s %s", implode (',', $table_list), implode (',', $column_list), $condition);
            }

            $result = $this->_query ($query);
            if ($result && !$this->transaction_started) @cubrid_commit ($this->fd);

            return $result;
        }

        /**
         * @brief deleteAct 처리
         **/
        function _executeDeleteAct ($output)
        {
            // 테이블 정리
            foreach ($output->tables as $val) {
                $table_list[] = '"'.$this->prefix.$val.'"';
            }

            // 조건절 정리
            $condition = $this->getCondition ($output);

            $query = sprintf ("delete from %s %s", implode (',',$table_list), $condition);
            $result = $this->_query ($query);
            if ($result && !$this->transaction_started) @cubrid_commit ($this->fd);

            return $result;
        }

        /**
         * @brief selectAct 처리
         *
         * select의 경우 특정 페이지의 목록을 가져오는 것을 편하게 하기 위해\n
         * navigation이라는 method를 제공
         **/
        function _executeSelectAct ($output)
        {
            // 테이블 정리
            $table_list = array ();
            foreach ($output->tables as $key => $val) {
                $table_list[] = '"'.$this->prefix.$val.'" as "'.$key.'"';
            }
            $left_join = array ();
            // why???
            $left_tables = (array) $output->left_tables;

            foreach ($left_tables as $key => $val) {
                $condition = $this->_getCondition ($output->left_conditions[$key], $output->column_type, $output);
                if ($condition) {
                    $left_join[] = $val.' "'.$this->prefix.$output->_tables[$key].  '" "'.$key.'" on ('.$condition.')';
                }
            }

            $click_count = array();
            if(!$output->columns){
                $output->columns = array(array('name'=>'*'));
            }

            $column_list = array ();
            foreach ($output->columns as $key => $val) {
                $name = $val['name'];

                $click_count = '%s';
                if ($val['click_count'] && count ($output->conditions) > 0) {
                    $click_count = 'incr(%s)';
                }

                $alias = $val['alias'] ? sprintf ('"%s"', $val['alias']) : null;
                $_alias = $val['alias'];

                if ($name == '*') {
                    $column_list[] = $name;
                }
                elseif (strpos ($name, '.') === false && strpos ($name, '(') === false) {
                    $name = sprintf ($click_count,$name);
                    if ($alias) {
                        $column_list[$alias] = sprintf('"%s" as %s', $name, $alias);
                    }
                    else {
                        $column_list[] = sprintf ('"%s"', $name);
                    }
                }
                else {
                    if (strpos ($name, '.') != false) {
                        list ($prefix, $name) = explode('.', $name);
                        if (($now_matchs = preg_match_all ("/\(/", $prefix, $xtmp)) > 0) {
                            if ($now_matchs == 1) {
                                $tmpval = explode ("(", $prefix);
                                $tmpval[1] = sprintf ('"%s"', $tmpval[1]);
                                $prefix = implode ("(", $tmpval);
                                $tmpval = explode (")", $name);
                                $tmpval[0] = sprintf ('"%s"', $tmpval[0]);
                                $name = implode (")", $tmpval);
                            }
                        }
                        else {
                            $prefix = sprintf ('"%s"', $prefix);
                            $name = ($name == '*') ? $name : sprintf('"%s"',$name);
                        }
                        $xtmp = null;
                        $now_matchs = null;
                        if($alias) $column_list[$_alias] = sprintf ($click_count, sprintf ('%s.%s', $prefix, $name)) .  ($alias ? sprintf (' as %s',$alias) : '');
                        else $column_list[] = sprintf ($click_count, sprintf ('%s.%s', $prefix, $name));
                    }
                    elseif (($now_matchs = preg_match_all ("/\(/", $name, $xtmp)) > 0) {
                        if ($now_matchs == 1 && preg_match ("/[a-zA-Z0-9]*\(\*\)/", $name) < 1) {
                            $open_pos = strpos ($name, "(");
                            $close_pos = strpos ($name, ")");

                            if (preg_match ("/,/", $name)) {
                                $tmp_func_name = sprintf ('%s', substr ($name, 0, $open_pos));
                                $tmp_params = sprintf ('%s', substr ($name, $open_pos + 1, $close_pos - $open_pos - 1));
                                $tmpval = null;
                                $tmpval = explode (',', $tmp_params);

                                foreach ($tmpval as $tmp_param) {
                                    $tmp_param_list[] = (!is_numeric ($tmp_param)) ? sprintf ('"%s"', $tmp_param) : $tmp_param;
                                }

                                $tmpval = implode (',', $tmp_param_list);
                                $name = sprintf ('%s(%s)', $tmp_func_name, $tmpval);
                            }
                            else {
                                $name = sprintf ('%s("%s")', substr ($name, 0, $open_pos), substr ($name, $open_pos + 1, $close_pos - $open_pos - 1));
                            }
                        }

                        if($alias) $column_list[$_alias] = sprintf ($click_count, $name).  ($alias ? sprintf (' as %s', $alias) : '');
                        else $column_list[] = sprintf ($click_count, $name);
                    }
                    else {
                        if($alias) $column_list[$_alias] = sprintf($click_count, $name).  ($alias ? sprintf(' as %s',$alias) : '');
                        else $column_list[] = sprintf($click_count, $name);
                    }
                }
                $columns = implode (',', $column_list);
            }

            $condition = $this->getCondition ($output);

            $output->column_list = $column_list;
            if ($output->list_count && $output->page) {
                return ($this->_getNavigationData($table_list, $columns, $left_join, $condition, $output));
            }

            if ($output->order) {
                $conditions = $this->getConditionList($output);
                //if(in_array('list_order', $conditions) || in_array('update_order', $conditions)) {
                    foreach($output->order as $key => $val) {
                        $col = $val[0];
                        if(!in_array($col, array('list_order','update_order'))) continue;
                        if ($condition) $condition .= sprintf(' and %s < 2100000000 ', $col);
                        else $condition = sprintf(' where %s < 2100000000 ', $col);
                    }
                //}
            }


            if (count ($output->groups)) {
                foreach ($output->groups as $key => $value) {
                    if (strpos ($value, '.')) {
                        $tmp = explode ('.', $value);
                        $tmp[0] = sprintf ('"%s"', $tmp[0]);
                        $tmp[1] = sprintf ('"%s"', $tmp[1]);
                        $value = implode ('.', $tmp);
                    }
                    elseif (strpos ($value, '(')) {
                        $value = $value;
                    }
                    else {
                        $value = sprintf ('"%s"', $value);
                    }
                    $output->groups[$key] = $value;


                    if(count($output->arg_columns))
                    {
                        if($column_list[$value]) $output->arg_columns[] = $column_list[$value];
                    }
                }
                $groupby_query = sprintf ('group by %s', implode(',', $output->groups));
            }


            // list_count를 사용할 경우 적용
            if ($output->list_count['value']) {
                $start_count = 0;
                $list_count = $output->list_count['value'];

                if ($output->order) {
                  foreach ($output->order as $val) {
                      if (strpos ($val[0], '.')) {
                          $tmpval = explode ('.', $val[0]);
                          $tmpval[0] = sprintf ('"%s"', $tmpval[0]);
                          $tmpval[1] = sprintf ('"%s"', $tmpval[1]);
                          $val[0] = implode ('.', $tmpval);
                      }
                      elseif (strpos ($val[0], '(')) $val[0] = $val[0];
                      elseif ($val[0] == 'count') $val[0] = 'count (*)';
                      else $val[0] = sprintf ('"%s"', $val[0]);
                      $index_list[] = sprintf('%s %s', $val[0], $val[1]);
                  }
                  if (count($index_list))
                      $orderby_query = ' order by '.implode(',', $index_list);
                      $orderby_query = sprintf ('%s for orderby_num() between %d and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
                }
                else {
                    if (count ($output->groups)) {
                        $orderby_query = sprintf ('%s having groupby_num() between %d'.  ' and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
                    }
                    else {
                        if ($condition) {
                            $orderby_query = sprintf ('%s and inst_num() between %d'.  ' and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
                        }
                        else {
                            $orderby_query = sprintf ('%s where inst_num() between %d'.  ' and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
                        }
                    }
                }
            }
            else {
                if ($output->order) {
                    foreach ($output->order as $val) {
                        if (strpos ($val[0], '.')) {
                            $tmpval = explode ('.', $val[0]);
                            $tmpval[0] = sprintf ('"%s"', $tmpval[0]);
                            $tmpval[1] = sprintf ('"%s"', $tmpval[1]);
                            $val[0] = implode ('.', $tmpval);
                        }
                        elseif (strpos ($val[0], '(')) $val[0] = $val[0];
                        elseif ($val[0] == 'count') $val[0] = 'count (*)';
                        else $val[0] = sprintf ('"%s"', $val[0]);
                        $index_list[] = sprintf('%s %s', $val[0], $val[1]);

                        if(count($output->arg_columns) && $column_list[$val]) $output->arg_columns[] = $column_list[$key];
                    }

                    if (count ($index_list)) {
                        $orderby_query = ' order by '.implode(',', $index_list);
                    }
                }
            }


            if(count($output->arg_columns))
            {
                $columns = array();
                foreach($output->arg_columns as $col){
                    if(strpos($col,'"')===false && strpos($col,' ')===false) $columns[] = '"'.$col.'"';
                    else $columns[] = $col;
                }

                $columns = join(',',$columns);
            }

            $query = sprintf ("select %s from %s %s %s %s", $columns, implode (',',$table_list), implode (' ',$left_join), $condition, $groupby_query.$orderby_query);
            $query .= (__DEBUG_QUERY__&1 && $output->query_id)?sprintf (' '.$this->comment_syntax, $this->query_id):'';
            $result = $this->_query ($query);
            if ($this->isError ()) return;
            $data = $this->_fetch ($result);

            $buff = new Object ();
            $buff->data = $data;

            return $buff;
        }

        /**
         * @brief 현재 시점의 Stack trace를 보여줌.결과를 fetch
         **/
        function backtrace ()
        {
            $output = "<div style='text-align: left;'>\n";
            $output .= "<b>Backtrace:</b><br />\n";
            $backtrace = debug_backtrace ();

            foreach ($backtrace as $bt) {
                $args = '';
                foreach ($bt['args'] as $a) {
                    if (!empty ($args)) {
                        $args .= ', ';
                    }
                    switch (gettype ($a)) {
                    case 'integer':
                    case 'double':
                        $args .= $a;
                        break;
                    case 'string':
                        $a = htmlspecialchars (substr ($a, 0, 64)).
                            ((strlen ($a) > 64) ? '...' : '');
                        $args .= "\"$a\"";
                        break;
                    case 'array':
                        $args .= 'Array ('. count ($a).')';
                        break;
                    case 'object':
                        $args .= 'Object ('.get_class ($a).')';
                        break;
                    case 'resource':
                        $args .= 'Resource ('.strstr ($a, '#').')';
                        break;
                    case 'boolean':
                        $args .= $a ? 'True' : 'False';
                        break;
                    case 'NULL':
                        $args .= 'Null';
                        break;
                    default:
                        $args .= 'Unknown';
                    }
                }
                $output .= "<br />\n";
                $output .= "<b>file:</b> ".$bt['line']." - ".  $bt['file']."<br />\n";
                $output .= "<b>call:</b> ".$bt['class'].  $bt['type'].$bt['function'].$args."<br />\n";
            }
            $output .= "</div>\n";
            return $output;
        }

        /**
         * @brief query xml에 navigation 정보가 있을 경우 페이징 관련 작업을 처리한다
         *
         * 그닥 좋지는 않은 구조이지만 편리하다.. -_-;
         **/
        function _getNavigationData ($table_list, $columns, $left_join, $condition, $output) {
            require_once('./util/PageHandler.class.php');


            $column_list = $output->column_list;

            $count_condition = count($output->groups) ? sprintf('%s group by %s', $condition, implode(', ', $output->groups)) : $condition;
            $count_query = sprintf('select count(*) as "count" from %s %s %s', implode(', ', $table_list), implode(' ', $left_join), $count_condition);
            if (count($output->groups)) {
                $count_query = sprintf('select count(*) as "count" from (%s) xet', $count_query);
            }

            $count_query .= (__DEBUG_QUERY__&1 && $output->query_id)?sprintf (' '.$this->comment_syntax, $this->query_id):'';
            $result = $this->_query($count_query);
            $count_output = $this->_fetch($result);
            $total_count = (int)$count_output->count;

            $list_count = $output->list_count['value'];
            if (!$list_count) $list_count = 20;
            $page_count = $output->page_count['value'];
            if (!$page_count) $page_count = 10;
            $page = $output->page['value'];
            if (!$page) $page = 1;

            // 전체 페이지를 구함
            if ($total_count) {
                $total_page = (int) (($total_count - 1) / $list_count) + 1;
            }
            else {
                $total_page = 1;
            }

            // 페이지 변수를 체크
            if ($page > $total_page) $page = $total_page;
            $start_count = ($page - 1) * $list_count;

            if ($output->order) {
                $conditions = $this->getConditionList($output);
                //if(in_array('list_order', $conditions) || in_array('update_order', $conditions)) {
                    foreach ($output->order as $key => $val) {
                        $col = $val[0];
                        if(!in_array($col, array('list_order','update_order'))) continue;
                        if($condition) $condition .= sprintf(' and %s < 2100000000 ', $col);
                        else $condition = sprintf(' where %s < 2100000000 ', $col);
                    }
                //}
            }


            if (count ($output->groups)) {
                foreach ($output->groups as $key => $value) {
                    if (strpos ($value, '.')) {
                        $tmp = explode ('.', $value);
                        $tmp[0] = sprintf ('"%s"', $tmp[0]);
                        $tmp[1] = sprintf ('"%s"', $tmp[1]);
                        $value = implode ('.', $tmp);
                    }
                    elseif (strpos ($value, '(')) $value = $value;
                    else $value = sprintf ('"%s"', $value);
                    $output->groups[$key] = $value;
                }

                $groupby_query = sprintf (' group by %s', implode (',', $output->groups));
            }

            if ($output->order) {
                foreach ($output->order as $val) {
                    if (strpos ($val[0], '.')) {
                        $tmpval = explode ('.', $val[0]);
                        $tmpval[0] = sprintf ('"%s"', $tmpval[0]);
                        $tmpval[1] = sprintf ('"%s"', $tmpval[1]);
                        $val[0] = implode ('.', $tmpval);
                    }
                    elseif (strpos ($val[0], '(')) $val[0] = $val[0];
                    elseif ($val[0] == 'count') $val[0] = 'count (*)';
                    else $val[0] = sprintf ('"%s"', $val[0]);
                    $index_list[] = sprintf ('%s %s', $val[0], $val[1]);
                }

                if (count ($index_list)) {
                    $orderby_query = ' order by '.implode(',', $index_list);
                }

                $orderby_query = sprintf ('%s for orderby_num() between %d and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
            }
            else {
                if (count($output->groups)) {
                    $orderby_query = sprintf ('%s having groupby_num() between %d and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
                }
                else {
                    if ($condition) {
                        $orderby_query = sprintf ('%s and inst_num() between %d and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
                    }
                    else {
                        $orderby_query = sprintf('%s where inst_num() between %d and %d', $orderby_query, $start_count + 1, $list_count + $start_count);
                    }
                }
            }

            if(count($output->arg_columns))
            {
                $columns = array();
                foreach($output->arg_columns as $col){
                    if(strpos($col,'"')===false) $columns[] = '"'.$col.'"';
                    else $columns[] = $col;
                }

                $columns = join(',',$columns);
            }

            $query = sprintf ("select %s from %s %s %s %s", $columns, implode (',',$table_list), implode (' ',$left_join), $condition, $groupby_query.$orderby_query);
            $query .= (__DEBUG_QUERY__&1 && $output->query_id)?sprintf (' '.$this->comment_syntax, $this->query_id):'';
            $result = $this->_query ($query);

            if ($this->isError ()) {
                $buff = new Object ();
                $buff->total_count = 0;
                $buff->total_page = 0;
                $buff->page = 1;
                $buff->data = array ();

                $buff->page_navigation = new PageHandler ($total_count, $total_page, $page, $page_count);

                return $buff;
            }

            $virtual_no = $total_count - ($page - 1) * $list_count;
            while ($tmp = cubrid_fetch ($result, CUBRID_OBJECT)) {
                if ($tmp) {
                    foreach ($tmp as $k => $v) {
                        $tmp->{$k} = rtrim($v);
                    }
                }
                $data[$virtual_no--] = $tmp;
            }

            $buff = new Object ();
            $buff->total_count = $total_count;
            $buff->total_page = $total_page;
            $buff->page = $page;
            $buff->data = $data;

            $buff->page_navigation = new PageHandler ($total_count, $total_page, $page, $page_count);

            return $buff;
        }
    }

return new DBCubrid;
?>
