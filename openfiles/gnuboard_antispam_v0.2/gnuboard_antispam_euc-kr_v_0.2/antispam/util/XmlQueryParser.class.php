<?php
    /**
     * @class XmlQueryParser
     * @author NHN (developers@xpressengine.com)
     * @brief case to parse XE xml query 
     * @version 0.1
     *
     * @todo need to support extend query such as subquery, union
     **/
	require_once("_common.php");
	require_once("$base/antispam/util/FileHandler.class.php");
	require_once("$base/antispam/util/Handler.class.php");
	require_once("$base/antispam/db/db.config.php");

    class XmlQueryParser extends XmlParser {

        var $default_list = array();
        var $notnull_list = array();
        var $filter_list = array();

        /**
         * @brief parse a xml query file and save the result as a new file specified by cache_file
         * @param[in] $query_id name of query
         * @param[in] $xml_file file path of a xml query file to be loaded
         * @param[in] $cache_file file path of a cache file to store resultant php code after parsing xml query
         * @return Nothing is requred.
         * @remarks {there should be a way to report an error}
         **/
        function parse($query_id, $xml_file, $cache_file) {
            // query xml 파일을 찾아서 파싱, 결과가 없으면 return
            $buff = FileHandler::readFile($xml_file);
            $xml_obj = parent::parse($buff);
            if(!$xml_obj) return;
            unset($buff);

            $id_args = explode('.', $query_id);
            if(count($id_args)==2) {
                $target = 'modules';
                $module = $id_args[0];
                $id = $id_args[1];
            } elseif(count($id_args)==3) {
                $target = $id_args[0];
                if(!in_array($target, array('modules','addons','widgets'))) return;
                $module = $id_args[1];
                $id = $id_args[2];
            }

            // insert, update, delete, select등의 action
            $action = strtolower($xml_obj->query->attrs->action);
            if(!$action) return;

            // 테이블 정리 (배열코드로 변환)
            $tables = $xml_obj->query->tables->table;
            $output->left_tables = array();

            $left_conditions = array();

            if(!$tables) return;
            if(!is_array($tables)) $tables = array($tables);
            foreach($tables as $key => $val) {

                // 테이블과 alias의 이름을 구함
                $table_name = $val->attrs->name;
                $alias = $val->attrs->alias;
                if(!$alias) $alias = $table_name;

                $output->tables[$alias] = $table_name;

                if(in_array($val->attrs->type,array('left join','left outer join','right join','right outer join')) && count($val->conditions)){
                    $output->left_tables[$alias] =  $val->attrs->type;
                    $left_conditions[$alias] = $val->conditions;
                }

                // 테이블을 찾아서 컬럼의 속성을 구함
                $table_file = sprintf('%s%s/%s/schemas/%s.xml', _XE_PATH_, 'modules', $module, $table_name);
                if(!file_exists($table_file)) {
                    $searched_list = FileHandler::readDir(_XE_PATH_.'modules');
                    $searched_count = count($searched_list);
                    for($i=0;$i<$searched_count;$i++) {
                        $table_file = sprintf('%s%s/%s/schemas/%s.xml', _XE_PATH_, 'modules', $searched_list[$i], $table_name);
                        if(file_exists($table_file)) break;
                    }
                }

                if(file_exists($table_file)) {
                    $table_xml = FileHandler::readFile($table_file);
                    $table_obj = parent::parse($table_xml);
                    if($table_obj->table) {
                        if(isset($table_obj->table->column) && !is_array($table_obj->table->column))
                        {
                            $table_obj->table->column = array($table_obj->table->column);
                        }

                        foreach($table_obj->table->column as $k => $v) {
                            $buff .= sprintf('$output->column_type["%s"] = "%s";%s', $v->attrs->name, $v->attrs->type, "\n");
                        }
                    }
                }
            }


            // 컬럼 정리
            $columns = $xml_obj->query->columns->column;
            $out = $this->_setColumn($columns);
            $output->columns = $out->columns;

            $conditions = $xml_obj->query->conditions;
            $out = $this->_setConditions($conditions);
            $output->conditions = $out->conditions;

            foreach($output->left_tables as $key => $val){
                if($left_conditions[$key]){
                    $out = $this->_setConditions($left_conditions[$key]);
                    $output->left_conditions[$key] = $out->conditions;
                }
            }

            $group_list = $xml_obj->query->groups->group;
            $out = $this->_setGroup($group_list);
            $output->groups = $out->groups;

            // 네비게이션 정리
            $out = $this->_setNavigation($xml_obj);
            $output->order = $out->order;
            $output->list_count = $out->list_count;
            $output->page_count = $out->page_count;
            $output->page = $out->page;

            $column_count = count($output->columns);
            $condition_count = count($output->conditions);

            $buff .= '$output->tables = array( ';
            foreach($output->tables as $key => $val) {
                if(!array_key_exists($key,$output->left_tables)){
                    $buff .= sprintf('"%s"=>"%s",', $key, $val);
                }
            }
            $buff .= ' );'."\n";

            // php script 생성
            $buff .= '$output->_tables = array( ';
            foreach($output->tables as $key => $val) {
                $buff .= sprintf('"%s"=>"%s",', $key, $val);
            }
            $buff .= ' );'."\n";

            if(count($output->left_tables)){
                $buff .= '$output->left_tables = array( ';
                foreach($output->left_tables as $key => $val) {
                    $buff .= sprintf('"%s"=>"%s",', $key, $val);
                }
                $buff .= ' );'."\n";
            }

            // column 정리
            if($column_count) {
                $buff .= '$output->columns = array ( ';
                $buff .= $this->_getColumn($output->columns);
                $buff .= ' );'."\n";
            }

            // conditions 정리
            if($condition_count) {
                $buff .= '$output->conditions = array ( ';
                $buff .= $this->_getConditions($output->conditions);
                $buff .= ' );'."\n";
            }

            // conditions 정리
            if(count($output->left_conditions)) {
                $buff .= '$output->left_conditions = array ( ';
                foreach($output->left_conditions as $key => $val){
                    $buff .= "'{$key}' => array ( ";
                    $buff .= $this->_getConditions($val);
                    $buff .= "),\n";
                }
                $buff .= ' );'."\n";
            }

			// args 변수 확인
			$arg_list = $this->getArguments();
			if($arg_list)
			{
				foreach($arg_list as $arg)
				{
					$pre_buff .= 'if(is_object($args->'.$arg.')){ $args->'.$arg.' = array_values(get_method_vars($args->'.$arg.')); }'. "\n";
					$pre_buff .= 'if(is_array($args->'.$arg.') && count($args->'.$arg.')==0){ unset($args->'.$arg.'); };'."\n";
				}
			}

            // order 정리
            if($output->order) {
                $buff .= '$output->order = array(';
                foreach($output->order as $key => $val) {
                    $buff .= sprintf('array($args->%s?$args->%s:"%s",in_array($args->%s,array("asc","desc"))?$args->%s:("%s"?"%s":"asc")),', $val->var, $val->var, $val->default, $val->order, $val->order, $val->order, $val->order);
                }
                $buff .= ');'."\n";
            }

            // list_count 정리
            if($output->list_count) {
                $buff .= sprintf('$output->list_count = array("var"=>"%s", "value"=>$args->%s?$args->%s:"%s");%s', $output->list_count->var, $output->list_count->var, $output->list_count->var, $output->list_count->default,"\n");
            }

            // page_count 정리
            if($output->page_count) {
                $buff .= sprintf('$output->page_count = array("var"=>"%s", "value"=>$args->%s?$args->%s:"%s");%s', $output->page_count->var, $output->page_count->var, $output->page_count->var, $output->list_count->default,"\n");
            }

            // page 정리
            if($output->page) {
                $buff .= sprintf('$output->page = array("var"=>"%s", "value"=>$args->%s?$args->%s:"%s");%s', $output->page->var, $output->page->var, $output->page->var, $output->list->default,"\n");
            }

            // group by 정리
            if($output->groups) {
                $buff .= sprintf('$output->groups = array("%s");%s', implode('","',$output->groups),"\n");
            }

            // minlength check
            if(count($minlength_list)) {
                foreach($minlength_list as $key => $val) {
                    $pre_buff .= 'if($args->'.$key.'&&strlen($args->'.$key.')<'.$val.') return new Object(-1, sprintf($lang->filter->outofrange, $lang->'.$key.'?$lang->'.$key.':\''.$key.'\'));'."\n";
                }
            }

            // maxlength check
            if(count($maxlength_list)) {
                foreach($maxlength_list as $key => $val) {
                    $pre_buff .= 'if($args->'.$key.'&&strlen($args->'.$key.')>'.$val.') return new Object(-1, sprintf($lang->filter->outofrange, $lang->'.$key.'?$lang->'.$key.':\''.$key.'\'));'."\n";
                }
            }

            // filter check
            if(count($this->filter_list)) {
                foreach($this->filter_list as $key => $val) {
                    $pre_buff .= sprintf('if(isset($args->%s)) { unset($_output); $_output = $this->checkFilter("%s",$args->%s,"%s"); if(!$_output->toBool()) return $_output; } %s',$val->var, $val->var,$val->var,$val->filter,"\n");
                }
            }

            // default check
            if(count($this->default_list)) {
                foreach($this->default_list as $key => $val) {
                    $pre_buff .= 'if(!isset($args->'.$key.')) $args->'.$key.' = '.$val.';'."\n";
                }
            }

            // not null check
            if(count($this->notnull_list)) {
                foreach($this->notnull_list as $key => $val) {
                    $pre_buff .= 'if(!isset($args->'.$val.')) return new Object(-1, sprintf($lang->filter->isnull, $lang->'.$val.'?$lang->'.$val.':\''.$val.'\'));'."\n";
                }
            }

            $buff = "<?php \n"
                  . sprintf('$output->query_id = "%s";%s', $query_id, "\n")
                  . sprintf('$output->action = "%s";%s', $action, "\n")
                  . $pre_buff
                  . $buff
                  . 'return $output; ?>';

            // 저장
            FileHandler::writeFile($cache_file, $buff);
        }

        /**
        * @brief transfer given column information to object->columns
        * @param[in] column information
        * @result Returns $object 
        */

        function _setColumn($columns){
            if(!$columns) {
                $output->column[] = array("*" => "*");
            } else {
                if(!is_array($columns)) $columns = array($columns);
                foreach($columns as $key => $val) {
                    $name = $val->attrs->name;
                    /*
                    if(strpos('.',$name)===false && count($output->tables)==1) {
                        $tmp = array_values($output->tables);
                        $name = sprintf('%s.%s', $tmp[0], $val->attrs->name);
                    }
                    */

                    $output->columns[] = array(
                        "name" => $name,
                        "var" => $val->attrs->var,
                        "default" => $val->attrs->default,
                        "notnull" => $val->attrs->notnull,
                        "filter" => $val->attrs->filter,
                        "minlength" => $val->attrs->minlength,
                        "maxlength" => $val->attrs->maxlength,
                        "alias" => $val->attrs->alias,
                        "click_count" => $val->attrs->click_count,
                    );
                }
            }
            return $output;
        }

        /**
        * @brief transfer condition information to $object->conditions
        * @param[in] SQL condition information
        * @result Returns $output
        */
        function _setConditions($conditions){
            // 조건절 정리

            $condition = $conditions->condition;
            if($condition) {
                $obj->condition = $condition;
                unset($condition);
                $condition = array($obj);
            }
            $condition_group = $conditions->group;
            if($condition_group && !is_array($condition_group)) $condition_group = array($condition_group);

            if($condition && $condition_group) $cond = array_merge($condition, $condition_group);
            elseif($condition_group) $cond = $condition_group;
            else $cond = $condition;

            if($cond) {
                foreach($cond as $key => $val) {
                    unset($cond_output);

                    if($val->attrs->pipe) $cond_output->pipe = $val->attrs->pipe;
                    else $cond_output->pipe = null;

                    if(!$val->condition) continue;
                    if(!is_array($val->condition)) $val->condition = array($val->condition);

                    foreach($val->condition as $k => $v) {
                        $obj = $v->attrs;
                        if(!$obj->alias) $obj->alias = $obj->column;
                        $cond_output->condition[] = $obj;
                    }

                    $output->conditions[] = $cond_output;
                }
            }
            return $output;
        }

        /**
        * @brief transfer condition information to $object->groups
        * @param[in] SQL group information
        * @result Returns $output
        */
        function _setGroup($group_list){
            // group 정리

            if($group_list) {
                if(!is_array($group_list)) $group_list = array($group_list);
                for($i=0;$i<count($group_list);$i++) {
                    $group = $group_list[$i];
                    $column = trim($group->attrs->column);
                    if(!$column) continue;
                    $group_column_list[] = $column;
                }
                if(count($group_column_list)) $output->groups = $group_column_list;
            }
            return $output;
        }


        /**
        * @brief transfer pagnation information to $output
        * @param[in] $xml_obj xml object containing Navigation information
        * @result Returns $output
        */
        function _setNavigation($xml_obj){
            $navigation = $xml_obj->query->navigation;
            if($navigation) {
                $order = $navigation->index;
                if($order) {
                    if(!is_array($order)) $order = array($order);
                    foreach($order as $order_info) {
                        $output->order[] = $order_info->attrs;
                    }
                }

                $list_count = $navigation->list_count->attrs;
                $output->list_count = $list_count;

                $page_count = $navigation->page_count->attrs;
                $output->page_count = $page_count;

                $page = $navigation->page->attrs;
                $output->page = $page ;
            }
            return $output;
        }

        /**
        * @brief retrieve column information from $output->colums to generate corresponding php code 
        * @param[in] $column 
        * @remarks the name of this method is misleading.
        * @result Returns string buffer containing php code
        */
        function _getColumn($columns){
            $buff = '';
			$str = '';
			$print_vars = array();

            foreach($columns as $key => $val) {
				$str = 'array("name"=>"%s","alias"=>"%s"';
				$print_vars = array();
				$print_vars[] = $val['name'];
				$print_vars[] = $val['alias'];

                $val['default'] = $this->getDefault($val['name'], $val['default']);
                if($val['var'] && strpos($val['var'],'.')===false) {

                    if($val['default']){
						$str .= ',"value"=>$args->%s?$args->%s:%s'; 
						$print_vars[] = $val['var'];
						$print_vars[] = $val['var'];
						$print_vars[] = $val['default'];
					}else{
						$str .= ',"value"=>$args->%s'; 
						$print_vars[] = $val['var'];
					}

                } else {
                    if($val['default']){
						$str .= ',"value"=>%s'; 
						$print_vars[] = $val['default'];
					}
                }

				if($val['click_count']){
					$str .= ',"click_count"=>$args->%s';
					$print_vars[] = $val['click_count'];
				}

				$str .= '),%s';
				$print_vars[] = "\n";

				$buff .= vsprintf($str, $print_vars);
            }
            return $buff;
        }

        /**
        * @brief retrieve condition information from $output->condition to generate corresponding php code 
        * @param[in] $conditions array containing Query conditions
        * @remarks the name of this method is misleading.
        * @return Returns string buffer containing php code
        */
        function _getConditions($conditions){
            $buff = '';
            foreach($conditions as $key => $val) {
                $buff .= sprintf('array("pipe"=>"%s",%s"condition"=>array(', $val->pipe,"\n");
                foreach($val->condition as $k => $v) {
                    $v->default = $this->getDefault($v->column, $v->default);
                    if($v->var) {
                        if(strpos($v->var,".")===false) {
                            if($v->default) $this->default_list[$v->var] = $v->default;
                            if($v->filter) $this->filter_list[] = $v;
                            if($v->notnull) $this->notnull_list[] = $v->var;
                            if($v->default) $buff .= sprintf('array("column"=>"%s", "value"=>$args->%s?$args->%s:%s,"pipe"=>"%s","operation"=>"%s",),%s', $v->column, $v->var, $v->var, $v->default, $v->pipe, $v->operation, "\n");
                            else $buff .= sprintf('array("column"=>"%s", "value"=>$args->%s,"pipe"=>"%s","operation"=>"%s",),%s', $v->column, $v->var, $v->pipe, $v->operation, "\n");

							$this->addArguments($v->var);
                        } else {
                            $buff .= sprintf('array("column"=>"%s", "value"=>"%s","pipe"=>"%s","operation"=>"%s",),%s', $v->column, $v->var, $v->pipe, $v->operation, "\n");
                        }
                    } else {
                        if($v->default) $buff .= sprintf('array("column"=>"%s", "value"=>%s,"pipe"=>"%s","operation"=>"%s",),%s', $v->column, $v->default ,$v->pipe, $v->operation,"\n");
                        else $buff .= sprintf('array("column"=>"%s", "pipe"=>"%s","operation"=>"%s",),%s', $v->column, $v->pipe, $v->operation,"\n");
                    }
                }
                $buff .= ')),'."\n";
            }
            return $buff;
        }

		function addArguments($args_name)
		{
			$this->args[] = $args_name;
		}
		
		function getArguments()
		{
			return $this->args;
		}

        /**
        * @brief returns predefined default values correspoding to given parameters 
        * @param[in] $name 
        * @param[in] $value
        * @return Returns a default value for specified field
        */
        function getDefault($name, $value) {
         //   $db_info = Context::getDBInfo ();
            if(!isset($value)) return;
            $str_pos = strpos($value, '(');
            if($str_pos===false) return '"'.$value.'"';

            $func_name = substr($value, 0, $str_pos);
            $args = substr($value, $str_pos+1, strlen($value)-1);

            switch($func_name) {
                case 'ipaddress' :
                        $val = '$_SERVER[\'REMOTE_ADDR\']';
                    break;
                case 'unixtime' :
                        $val = 'time()';
                    break;
                case 'curdate' :
                        $val = 'date("YmdHis")';
                    break;
                case 'sequence' :
                        $val = '$this->getNextSequence()';
                    break;
                case 'plus' :
                        $args = abs($args);
                        if ($db_info->db_type == 'cubrid') {
                            $val = sprintf ('"\\"%s\\"+%d"', $name, $args);
                        } else {
                            $val = sprintf('"%s+%d"', $name, $args);
                        }
                    break;
                case 'minus' :
                        $args = abs($args);
                        if ($db_info->db_type == 'cubrid') {
                            $val = sprintf ('"\\"%s\\"-%d"', $name, $args);
                        } else {
                            $val = sprintf('"%s-%d"', $name, $args);
                        }
                        break;
                case 'multiply' :
						$args = intval($args);
                        if ($db_info->db_type == 'cubrid') {
                            $val = sprintf ('"\\"%s\\"*%d"', $name, $args);
                        } else {
                            $val = sprintf('"%s*%d"', $name, $args);
                        }
                    break;
            }

            return $val;
        }
    }
?>
