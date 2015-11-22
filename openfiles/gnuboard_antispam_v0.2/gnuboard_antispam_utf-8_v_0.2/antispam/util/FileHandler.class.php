<?php
    /**
    * @class FileHandler
    * @author NHN (developers@xpressengine.com)
    * @brief contains methods for accessing file system
    **/
	require_once("_common.php");
	require_once("$base/antispam/util/Handler.class.php");

    class FileHandler extends Handler {
        /**
         * @brief changes path of target file, directory into absolute path
         * @param[in] $source path
         * @return absolute path 
         **/
        function getRealPath($source) {
            $temp = explode('/', $source);
            if($temp[0] == '.') $source = $base.substr($source, 2);
            return $source;
        }

        /**
         * @brief copy a directory to target 
         * @param[in] $source_dir path of source directory
         * @param[in] $target_dir path of target dir
         * @param[in] $filter
         * @param[in] $type
         * @remarks if target directory does not exist, this function creates it 
         * @return none
         **/
        function copyDir($source_dir, $target_dir, $filter=null,$type=null){
            $source_dir = FileHandler::getRealPath($source_dir);
            $target_dir = FileHandler::getRealPath($target_dir);
            if(!is_dir($source_dir)) return false;

            // target이 없을땐 생성
            if(!file_exists($target_dir)) FileHandler::makeDir($target_dir);

            if(substr($source_dir, -1) != '/') $source_dir .= '/';
            if(substr($target_dir, -1) != '/') $target_dir .= '/';

            $oDir = dir($source_dir);
            while($file = $oDir->read()) {
                if(substr($file,0,1)=='.') continue;
                if($filter && preg_match($filter, $file)) continue;
                if(is_dir($source_dir.$file)){
                    FileHandler::copyDir($source_dir.$file,$target_dir.$file,$type);
                }else{
                    if($type == 'force'){
                        @unlink($target_dir.$file);
                    }else{
                        if(!file_exists($target_dir.$file)) @copy($source_dir.$file,$target_dir.$file);
                    }
                }
            }
        }

        /**
         * @brief copy a file to target 
         * @param[in] $source path of source file
         * @param[in] $target path of target file
         * @param[in] $force Y: overwrite
         * @return none
         **/
        function copyFile($source, $target, $force='Y'){
            setlocale(LC_CTYPE, 'en_US.UTF8', 'ko_KR.UTF8'); 
            $source = FileHandler::getRealPath($source);
            $target_dir = FileHandler::getRealPath(dirname($target));
            $target = basename($target);
            if(!file_exists($target_dir)) FileHandler::makeDir($target_dir);
            if($force=='Y') @unlink($target_dir.'/'.$target);
            @copy($source, $target_dir.'/'.$target);
        }

        /**
         * @brief returns the content of the file 
         * @param[in] $file_name path of target file
         * @return the content of the file. if target file does not exist, this function returns nothing.
         **/
        function readFile($file_name) {
            $file_name = FileHandler::getRealPath($file_name);

            if(!file_exists($file_name)) return;
            $filesize = filesize($file_name);
            if($filesize<1) return;

            if(function_exists('file_get_contents')) return file_get_contents($file_name);

            $fp = fopen($file_name, "r");
            $buff = '';
            if($fp) {
                while(!feof($fp) && strlen($buff)<=$filesize) {
                    $str = fgets($fp, 1024);
                    $buff .= $str;
                }
                fclose($fp);
            }
            return $buff;
        }

        /**
         * @brief write $buff into the specified file
         * @param[in] $file_name path of target file
         * @param[in] $buff content to be writeen
         * @param[in] $mode a(append) / w(write)
         * @return none
         **/
        function writeFile($file_name, $buff, $mode = "w") {
            $file_name = FileHandler::getRealPath($file_name);

            $pathinfo = pathinfo($file_name);
            $path = $pathinfo['dirname'];
            if(!is_dir($path)) FileHandler::makeDir($path);

            $mode = strtolower($mode);
            if($mode != "a") $mode = "w";
            if(@!$fp = fopen($file_name,$mode)) return false;
            fwrite($fp, $buff);
            fclose($fp);
            @chmod($file_name, 0644);
        }

        /**
         * @brief remove a file
         * @param[in] $file_name path of target file
         * @return returns true on success or false on failure.
         **/
        function removeFile($file_name) {
            $file_name = FileHandler::getRealPath($file_name);
			return (file_exists($file_name) && @unlink($file_name));
        }

        /**
         * @brief rename a file
         * @param[in] $source path of source file
         * @param[in] $target path of target file
         * @remarks In order to move a file, use this function.
         * @return returns true on success or false on failure.
         **/
        function rename($source, $target) {
            $source = FileHandler::getRealPath($source);
            $target = FileHandler::getRealPath($target);
            return @rename($source, $target);
        }

		/**
		 * @brief Move a file
         * @param[in] $source path of source file
         * @param[in] $target path of target file
         * @return returns true on success or false on failure.
		 */
		function moveFile($source, $target) {
			$source = FileHandler::getRealPath($source);
			return (file_exists($source) && FileHandler::removeFile($target) && FileHandler::rename($source, $target));
		}

        /**
         * @brief move a directory 
         * @param[in] $source_dir path of source directory
         * @param[in] $target_dir path of target directory
         * @remarks this function just wraps rename function.
         * @return none
         **/
        function moveDir($source_dir, $target_dir) {
            FileHandler::rename($source_dir, $target_dir);
        }

        /**
         * @brief return list of the files in the path
         * @param[in] $path path of target directory
         * @param[in] $filter if specified, return only files matching with the filter
         * @param[in] $to_lower if true, file names will be changed into lower case.
         * @param[in] $concat_prefix if true, return file name as absolute path
         * @remarks the array does not contain files, such as '.', '..', and files starting with '.'
         * @return array of the filenames in the path 
         **/
        function readDir($path, $filter = '', $to_lower = false, $concat_prefix = false) {
            $path = FileHandler::getRealPath($path);

            if(substr($path,-1)!='/') $path .= '/';
            if(!is_dir($path)) return array();

            $oDir = dir($path);
            while($file = $oDir->read()) {
                if(substr($file,0,1)=='.') continue;

                if($filter && !preg_match($filter, $file)) continue;

                if($to_lower) $file = strtolower($file);

                if($filter) $file = preg_replace($filter, '$1', $file);
                else $file = $file;

                if($concat_prefix) {
                    $file = sprintf('%s%s', str_replace(_XE_PATH_, '', $path), $file);
                }

                $output[] = $file;
            }
            if(!$output) return array();

            return $output;
        }

        /**
         * @brief creates a directory
         * @param[in] $path_string path of target directory
         * @return true if success. it might return nothing when ftp is used and connection to the ftp address failed.
         * @remarks This function creates directories recursively, which means that if ancestors of the target directory does not exist, they will be created too.
         **/
        function makeDir($path_string) {
            static $oFtp = null;

            // if safe_mode is on, use FTP 
            if(ini_get('safe_mode')) {
				$ftp_info = Context::getFTPInfo();
				if($oFtp == null) {
					if(!Context::isFTPRegisted()) return;

					require_once(_XE_PATH_.'libs/ftp.class.php');
					$oFtp = new ftp();
					if(!$ftp_info->ftp_host) $ftp_info->ftp_host = "127.0.0.1";
					if(!$ftp_info->ftp_port) $ftp_info->ftp_port = 21;
					if(!$oFtp->ftp_connect($ftp_info->ftp_host, $ftp_info->ftp_port)) return;
					if(!$oFtp->ftp_login($ftp_info->ftp_user, $ftp_info->ftp_password)) {
						$oFtp->ftp_quit();
						return;
					}
				}
				$ftp_path = $ftp_info->ftp_root_path;
				if(!$ftp_path) $ftp_path = "/";
            }

            $path_string = str_replace(_XE_PATH_,'',$path_string);
            $path_list = explode('/', $path_string);

            $path = _XE_PATH_;
            for($i=0;$i<count($path_list);$i++) {
                if(!$path_list[$i]) continue;
                $path .= $path_list[$i].'/';
				$ftp_path .= $path_list[$i].'/';
                if(!is_dir($path)) {
                    if(ini_get('safe_mode')) {
                        $oFtp->ftp_mkdir($ftp_path);
                        $oFtp->ftp_site("CHMOD 777 ".$ftp_path);
                    } else {
                        @mkdir($path, 0755);
                        @chmod($path, 0755);
                    }
                }
            }

            return is_dir($path_string);
        }

        /**
         * @brief remove all files under the path
         * @param[in] $path path of the target directory
         * @return none
         **/
        function removeDir($path) {
            $path = FileHandler::getRealPath($path);
            if(!is_dir($path)) return;
            $directory = dir($path);
            while($entry = $directory->read()) {
                if ($entry != "." && $entry != "..") {
                    if (is_dir($path."/".$entry)) {
                        FileHandler::removeDir($path."/".$entry);
                    } else {
                        @unlink($path."/".$entry);
                    }
                }
            }
            $directory->close();
            @rmdir($path);
        }

        /**
         * @brief remove a directory only if it is empty 
         * @param[in] $path path of the target directory
         * @return none
         **/
        function removeBlankDir($path) {
            $item_cnt = 0;

            $path = FileHandler::getRealPath($path);
            if(!is_dir($path)) return;
            $directory = dir($path);
            while($entry = $directory->read()) {
                if ($entry == "." || $entry == "..") continue;
                if (is_dir($path."/".$entry)) $item_cnt = FileHandler::removeBlankDir($path.'/'.$entry);
            }
            $directory->close();

            if($item_cnt < 1) @rmdir($path);
        }


        /**
         * @biref remove files in the target directory.  
         * @param[in] $path path of the target directory
         * @remarks This function keeps the directory structure. 
         * @return none
         **/
        function removeFilesInDir($path) {
            $path = FileHandler::getRealPath($path);
            if(!is_dir($path)) return;
            $directory = dir($path);
            while($entry = $directory->read()) {
                if ($entry != "." && $entry != "..") {
                    if (is_dir($path."/".$entry)) {
                        FileHandler::removeFilesInDir($path."/".$entry);
                    } else {
                        @unlink($path."/".$entry);
                    }
                }
            }
            $directory->close();
        }

        /**
         * @brief makes file size byte into KB, MB according to the size
         * @param[in] $size number of the size
         * @return file size string
         **/
        function filesize($size) {
            if(!$size) return "0Byte";
            if($size < 1024) return ($size."Byte");
            if($size >= 1024 && $size < 1024*1024) return sprintf("%0.1fKB",$size / 1024);
            return sprintf("%0.2fMB",$size / (1024*1024));
        }

        /**
         * @brief return remote file's content via HTTP
         * @param[in] $url the address of the target file 
         * @param[in] $body HTTP request body
         * @param[in] $timeout connection timeout
         * @param[in] $method GET/POST
         * @param[in] $content_type content type header of HTTP request
         * @param[in] $headers headers key vaule array.
         * @param[in] $cookies cookies key value array.
         * @param[in] $post_data request arguments array for POST method
         * @return if success, the content of the target file. otherwise: none
         * @remarks if the target is moved (when return code is 300~399), this function follows the location specified response header.
         **/
        function getRemoteResource($url, $body = null, $timeout = 3, $method = 'GET', $content_type = null, $headers = array(), $cookies = array(), $post_data = array()) {
			requirePear();
            require_once('HTTP/Request.php');

			$parsed_url = parse_url(__PROXY_SERVER__);
			if($parsed_url["host"]) {
                $oRequest = new HTTP_Request(__PROXY_SERVER__);
                $oRequest->setMethod('POST');
                $oRequest->_timeout = $timeout;
                $oRequest->addPostData('arg', serialize(array('Destination'=>$url, 'method'=>$method, 'body'=>$body, 'content_type'=>$content_type, "headers"=>$headers, "post_data"=>$post_data)));
            } else {
                $oRequest = new HTTP_Request($url);
                if(count($headers)) {
                    foreach($headers as $key => $val) {
                        $oRequest->addHeader($key, $val);
                    }
                }
                if($cookies[$host]) {
                    foreach($cookies[$host] as $key => $val) {
                        $oRequest->addCookie($key, $val);
                    }
                }
                if(count($post_data)) {
                    foreach($post_data as $key => $val) {
                        $oRequest->addPostData($key, $val);
                    }
                }
                if(!$content_type) $oRequest->addHeader('Content-Type', 'text/html');
                else $oRequest->addHeader('Content-Type', $content_type);
                $oRequest->setMethod($method);
                if($body) $oRequest->setBody($body);

                $oRequest->_timeout = $timeout;
            }

            $oResponse = $oRequest->sendRequest();

            $code = $oRequest->getResponseCode();
            $header = $oRequest->getResponseHeader();
            $response = $oRequest->getResponseBody();
            if($c = $oRequest->getResponseCookies()) {
                foreach($c as $k => $v) {
                    $cookies[$host][$v['name']] = $v['value'];
                }
            }

            if($code > 300 && $code < 399 && $header['location']) {
                return FileHandler::getRemoteResource($header['location'], $body, $timeout, $method, $content_type, $headers, $cookies, $post_data);
            } 

            if($code != 200) return;

            return $response;
        }

        /**
         * @brief retrieves remote file, then stores it into target path.
         * @param[in] $url the address of the target file
         * @param[in] $target_file the location to store
         * @param[in] $body HTTP request body
         * @param[in] $timeout connection timeout
         * @param[in] $method GET/POST
         * @param[in] $content_type content type header of HTTP request
         * @param[in] $headers headers key vaule array.
         * @return true: success, false: failed 
         **/
        function getRemoteFile($url, $target_filename, $body = null, $timeout = 3, $method = 'GET', $content_type = null, $headers = array()) {
            $body = FileHandler::getRemoteResource($url, $body, $timeout, $method, $content_type, $headers);
            if(!$body) return false;
            $target_filename = FileHandler::getRealPath($target_filename);
            FileHandler::writeFile($target_filename, $body);
            return true;
        }

        /**
         * @brief convert size in string into numeric value 
         * @param[in] $val size in string (ex., 10, 10K, 10M, 10G )
         * @return converted size
         */
        function returnBytes($val)
        {
            $val = trim($val);
            $last = strtolower(substr($val, -1));
            if($last == 'g') $val *= 1024*1024*1024;
            else if($last == 'm') $val *= 1024*1024;
            else if($last == 'k') $val *= 1024;

            return $val;
        }

        /**
         * @brief check available memory to load image file 
         * @param[in] $imageInfo image info retrieved by getimagesize function 
         * @return true: it's ok, false: otherwise 
         */
        function checkMemoryLoadImage(&$imageInfo)
        {
            if(!function_exists('memory_get_usage')) return true;
            $K64 = 65536;
            $TWEAKFACTOR = 2.0;
            $channels = $imageInfo['channels'];
            if(!$channels) $channels = 6; //for png
            $memoryNeeded = round( ($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $channels / 8 + $K64 ) * $TWEAKFACTOR );
            $availableMemory = FileHandler::returnBytes(ini_get('memory_limit')) - memory_get_usage();
            if($availableMemory < $memoryNeeded) return false;
            return true;
        }

        /**
         * @brief moves an image file (resizing is possible)
         * @param[in] $source_file path of the source file
         * @param[in] $target_file path of the target file
         * @param[in] $resize_width width to resize 
         * @param[in] $resize_height height to resize
         * @param[in] $target_type if $target_type is set (gif, jpg, png, bmp), result image will be saved as target type
         * @param[in] $thumbnail_type thumbnail type(crop, ratio)
         * @return true: success, false: failed 
         **/
        function createImageFile($source_file, $target_file, $resize_width = 0, $resize_height = 0, $target_type = '', $thumbnail_type = 'crop') {
            $source_file = FileHandler::getRealPath($source_file);
            $target_file = FileHandler::getRealPath($target_file);

            if(!file_exists($source_file)) return;
            if(!$resize_width) $resize_width = 100;
            if(!$resize_height) $resize_height = $resize_width;

            // retrieve source image's information
            $imageInfo = getimagesize($source_file);
            if(!FileHandler::checkMemoryLoadImage($imageInfo)) return false;
            list($width, $height, $type, $attrs) = $imageInfo;

            if($width<1 || $height<1) return;

            switch($type) {
                case '1' :
                        $type = 'gif';
                    break;
                case '2' :
                        $type = 'jpg';
                    break;
                case '3' :
                        $type = 'png';
                    break;
                case '6' :
                        $type = 'bmp';
                    break;
                default :
                        return;
                    break;
            }

            // if original image is larger than specified size to resize, calculate the ratio 
            if($resize_width > 0 && $width >= $resize_width) $width_per = $resize_width / $width;
            else $width_per = 1;

            if($resize_height>0 && $height >= $resize_height) $height_per = $resize_height / $height;
            else $height_per = 1;

            if($thumbnail_type == 'ratio') {
                if($width_per>$height_per) $per = $height_per;
                else $per = $width_per;
                $resize_width = $width * $per;
                $resize_height = $height * $per;
            } else {
                if($width_per < $height_per) $per = $height_per;
                else $per = $width_per;
            }

            if(!$per) $per = 1;

            // get type of target file
            if(!$target_type) $target_type = $type;
            $target_type = strtolower($target_type);

            // create temporary image with target size
            if(function_exists('imagecreatetruecolor')) $thumb = imagecreatetruecolor($resize_width, $resize_height);
            else if(function_exists('imagecreate')) $thumb = imagecreate($resize_width, $resize_height);
			else return false;
			if(!$thumb) return false;

            $white = imagecolorallocate($thumb, 255,255,255);
            imagefilledrectangle($thumb,0,0,$resize_width-1,$resize_height-1,$white);

            // create temporary image having original type
            switch($type) {
                case 'gif' :
                        if(!function_exists('imagecreatefromgif')) return false;
                        $source = imagecreatefromgif($source_file);
                    break;
                // jpg
                case 'jpeg' :
                case 'jpg' :
                        if(!function_exists('imagecreatefromjpeg')) return false;
                        $source = imagecreatefromjpeg($source_file);
                    break;
                // png
                case 'png' :
                        if(!function_exists('imagecreatefrompng')) return false;
                        $source = imagecreatefrompng($source_file);
                    break;
                // bmp
                case 'wbmp' :
                case 'bmp' :
                        if(!function_exists('imagecreatefromwbmp')) return false;
                        $source = imagecreatefromwbmp($source_file);
                    break;
                default :
                    return;
            }

            // resize original image and put it into temporary image
            $new_width = (int)($width * $per);
            $new_height = (int)($height * $per);

            if($thumbnail_type == 'crop') {
                $x = (int)($resize_width/2 - $new_width/2);
                $y = (int)($resize_height/2 - $new_height/2);
            } else {
                $x = 0;
                $y = 0;
            }

            if($source) {
                if(function_exists('imagecopyresampled')) imagecopyresampled($thumb, $source, $x, $y, 0, 0, $new_width, $new_height, $width, $height);
                else imagecopyresized($thumb, $source, $x, $y, 0, 0, $new_width, $new_height, $width, $height);
            } else return false;

            // create directory 
            $path = dirname($target_file);
            if(!is_dir($path)) FileHandler::makeDir($path);

            // write into the file
            switch($target_type) {
                case 'gif' :
                        if(!function_exists('imagegif')) return false;
                        $output = imagegif($thumb, $target_file);
                    break;
                case 'jpeg' :
                case 'jpg' :
                        if(!function_exists('imagejpeg')) return false;
                        $output = imagejpeg($thumb, $target_file, 100);
                    break;
                case 'png' :
                        if(!function_exists('imagepng')) return false;
                        $output = imagepng($thumb, $target_file, 9);
                    break;
                case 'wbmp' :
                case 'bmp' :
                        if(!function_exists('imagewbmp')) return false;
                        $output = imagewbmp($thumb, $target_file, 100);
                    break;
            }

            imagedestroy($thumb);
            imagedestroy($source);

            if(!$output) return false;
            @chmod($target_file, 0644);

            return true;
        }

        /**
         * @brief reads ini file, and puts result into array
         * @param[in] $filename path of the ini file
         * @return ini array (if the target file does not exist, it returns false)
         **/
        function readIniFile($filename){
            $filename = FileHandler::getRealPath($filename);
            if(!file_exists($filename)) return false;
            $arr = parse_ini_file($filename, true);
            if(is_array($arr) && count($arr)>0) return $arr;
            else return array();
        }


        /**
         * @brief write array into ini file
         * @param[in] $filename target ini file name
         * @param[in] $arr array
         * @return if array contains nothing it returns false, otherwise true
         **/
        function writeIniFile($filename, $arr){
            if(count($arr)==0) return false;
            FileHandler::writeFile($filename, FileHandler::_makeIniBuff($arr));
            return true;
        }

        function _makeIniBuff($arr){
            $return = '';
            foreach($arr as $key => $val){
                // section
                if(is_array($val)){
                    $return .= sprintf("[%s]\n",$key);
                    foreach($val as $k => $v){
                        $return .= sprintf("%s=\"%s\"\n",$k,$v);
                    }
                // value
                }else if(is_string($val) || is_int($val)){
                    $return .= sprintf("%s=\"%s\"\n",$key,$val);
                }
            }
            return $return;
        }

        /**
         * @brief return file object 
         * @param[in] $filename target file name
         * @param[in] $mode file mode for fopen
         * @remarks if the directory of the file does not exist, create it.
         * @return file object 
         **/
        function openFile($filename, $mode)
        {
            $pathinfo = pathinfo($filename);
            $path = $pathinfo['dirname'];
            if(!is_dir($path)) FileHandler::makeDir($path);

            require_once("FileObject.class.php");
            $file_object = new FileObject($file_name, $mode);
            return $file_object;
        }

		/**
		 * @brief  check whether the given file has the content.
		 * @param[in] $file_name target file name
		 * @return return true if the file exists and contains something.
		 */
		function hasContent($filename)
		{
			return (is_readable($filename) && !!filesize($filename));
		}
    }
?>
