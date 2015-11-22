<?PHP
include_once('RequestSpamApi.class.php');
class RequestGetSpamScores extends RequestSpamApi{

	function RequestGetSpamScores(){
		$this->add('method','getSpamScores');

		$contents = new stdClass;
		$contents->item = array();
		$this->add('contents',$contents);
	}

	function addContent($content,$ip=null,$pubdate=null){
		if(!$content) return false;

		$obj = new stdClass;
		$obj->id = $this->plugin;
		$obj->content = $content;
		$obj->ip = $ip;
		$obj->pubdate = $pubdate;
		$obj->domain = $_SERVER["HTTP_HOST"];

		$contents = $this->get('contents');
		array_push($contents->item,$obj);
		$this->add('contents',$contents);

		return true;
	}
}

?>
