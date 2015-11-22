<?php
    /**
     * @class Object
     * @author NHN (developers@xpressengine.com)
     * @brief Base class design to pass the Object instance between XE Modules 
     *
     * @remark Every modules inherits from Object class. It includes error, message, and other variables for communicatin purpose
     **/

    class Object {

        var $error = 0; ///< 에러 코드 (0이면 에러 아님)
        var $message = 'success'; ///< 에러 메세지 (success이면 에러 아님)

        var $variables = array(); ///< 추가 변수

        /**
         * @brief constructor
         **/
        function Object($error = 0, $message = 'success') {
            $this->setError($error);
            $this->setMessage($message);
        }

        /**
         * @brief Setter to set error code
         * @param[in] $error error code
         **/
        function setError($error = 0) {
            $this->error = $error;
        }

        /**
         * @brief Getter to retrieve error code
         **/
        function getError() {
            return $this->error;
        }

        /**
         * @brief Setter to set set the error message
         * @param[in] $message a messge string
         * @return return True
         * @remark this method always returns True. We'd better remove it
         **/
        function setMessage($message = 'success') {
            //if(Context::getLang($message)) $message = Context::getLang($message);
            $this->message = $message;
            return true;
        }

        /**
         * @brief getter to retrieve an error message
         **/
        function getMessage() {
            return $this->message;
        }

        /**
         * @brief setter to set a key/value pair as an additional variable
         * @param[in] $key a variable name
         * @param[in] $val a value for the variable
         **/
        function add($key, $val) {
            $this->variables[$key] = $val;
        }

        /**
         * @brief method to set multiple key/value pairs as an additional variables
         * @param[in] $object either object or array containg key/value pairs to be added
         **/
        function adds($object) {
            if(is_object($object)) {
                $vars = get_object_vars($object);
                foreach($vars as $key => $val) $this->add($key, $val);
            } elseif(is_array($object)) {
                foreach($object as $key => $val) $this->add($key, $val);
            }
        }

        /**
         * @brief method to retrieve a corresponding value to a given key
         **/
        function get($key) {
            return $this->variables[$key];
        }


        /**
         * @brief method to retrieve an object containing a key/value paris 
         * @return Returns an object containing key/value pairs    
        **/
        function gets() {
            $num_args = func_num_args();
            $args_list = func_get_args();
            for($i=0;$i<$num_args;$i++) {
                $key = $args_list[$i];
                $output->{$key} = $this->get($key);
            }
            return $output;
        }

        /**
         * @brief method to retrieve an array of key/value pairs
         * @return Return a list of key/value pairs
         **/
        function getVariables() {
            return $this->variables;
        }

        /**
         * @brief method to retrieve an object of key/value pairs
         * @return Return an object of key/value pairs
         **/
        function getObjectVars() {
            foreach($this->variables as $key => $val) $output->{$key} = $val;
            return $output;
        }

        /**
         * @brief method to return either true or false depnding on the value in a 'error' variable
         * @remark this method is misleading in that it returns true if error is 0, which should be true in
         * boolean representation.
         **/
        function toBool() {
            return $this->error==0?true:false;
        }


        /**
         * @brief method to return either true or false depnding on the value in a 'error' variable
         **/
        function toBoolean() {
        return $this->toBool();
        }
    }
?>
