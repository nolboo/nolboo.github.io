<?PHP
include_once('RequestSpamApi.class.php');
class RequestPutSpamContents extends RequestSpamApi{

	function RequestPutSpamContents(){
		$this->add('method','putSpamContents');

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

		$contents = $this->get('contents');
		array_push($contents->item,$obj);
		$this->add('contents',$contents);

		return true;
	}
}
?>
