<?php
	require_once('DBMysql.class.php');

    /**
     * @class DBMysql_innodb
     * @author NHN (developers@xpressengine.com)
     * @brief MySQL DBMS를 이용하기 위한 class
     * @version 0.1
     *
     * mysql innodb handling class
     **/

    class DBMysql_innodb extends DBMysql {

        /**
         * @brief constructor
         **/
        function DBMysql_innodb() {
            $this->_setDBInfo();
            $this->_connect();
        }
		
		/**
		 * @brief create an instance of this class
		 */
		function create()
		{
			return new DBMysql_innodb;
		}

        /**
         * @brief DB접속 해제
         **/
        function close() {
            if(!$this->isConnected()) return;
            $this->_query("commit");
            @mysql_close($this->fd);
        }

        /**
         * @brief 트랜잭션 시작
         **/
        function begin() {
            if(!$this->isConnected() || $this->transaction_started) return;
            $this->transaction_started = true;
            $this->_query("begin");
        }

        /**
         * @brief 롤백
         **/
        function rollback() {
            if(!$this->isConnected() || !$this->transaction_started) return;
            $this->_query("rollback");
            $this->transaction_started = false;
        }

        /**
         * @brief 커밋
         **/
        function commit($force = false) {
            if(!$force && (!$this->isConnected() || !$this->transaction_started)) return;
            $this->_query("commit");
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
        function _query($query) {
            if(!$this->isConnected()) return;

            // 쿼리 시작을 알림
            $this->actStart($query);

            // 쿼리 문 실행
            $result = @mysql_query($query, $this->fd);

            // 오류 체크
            if(mysql_error($this->fd)) $this->setError(mysql_errno($this->fd), mysql_error($this->fd));

            // 쿼리 실행 종료를 알림
            $this->actFinish();

            // 결과 리턴
            return $result;
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

                $column_schema[] = sprintf('`%s` %s%s %s %s %s',
                $name,
                $this->column_type[$type],
                $size?'('.$size.')':'',
                isset($default)?"default '".$default."'":'',
                $notnull?'not null':'',
                $auto_increment?'auto_increment':''
                );

                if($primary_key) $primary_list[] = $name;
                else if($unique) $unique_list[$unique][] = $name;
                else if($index) $index_list[$index][] = $name;
            }

            if(count($primary_list)) {
                $column_schema[] = sprintf("primary key (%s)", '`'.implode($primary_list,'`,`').'`');
            }

            if(count($unique_list)) {
                foreach($unique_list as $key => $val) {
                    $column_schema[] = sprintf("unique %s (%s)", $key, '`'.implode($val,'`,`').'`');
                }
            }

            if(count($index_list)) {
                foreach($index_list as $key => $val) {
                    $column_schema[] = sprintf("index %s (%s)", $key, '`'.implode($val,'`,`').'`');
                }
            }

            $schema = sprintf('create table `%s` (%s%s) %s;', $this->addQuotes($table_name), "\n", implode($column_schema,",\n"), "ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci");

            $output = $this->_query($schema);
            if(!$output) return false;
        }
    }

return new DBMysql_innodb;
?>
