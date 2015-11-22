<?

$g4_path  = "../..";
include_once("$g4_path/common.php");
$base = $g4[admin_path];

if (!file_exists("./db/db.config.php")){
	echo"<script>
		alert('설치를 시작합니다');
	    location.href = './install/install.php';
		 </script>";
}


?>