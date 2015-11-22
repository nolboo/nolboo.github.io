<?

function strcut_utf8($str, $len, $checkmb=false, $tail='') { 
	preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match); // target for BMP 

	$m = $match[0]; 
   
	$slen = strlen($str); // length of source string 
	    
	$tlen = strlen($tail); // length of tail string 
    
	$mlen = count($m); // length of matched characters 
    
	if ($slen <= $len) return $str; 
    
	if (!$checkmb && $mlen <= $len) return $str; 
    
	$ret = array(); 
    
	$count = 0; 
    
	for ($i=0; $i < $len; $i++) { 
        
	$count += ($checkmb && strlen($m[$i]) > 1)?2:1; 
        
	if ($count + $tlen > $len) break; 
        
	$ret[] = $m[$i]; 
    
	} 
    
	return join('', $ret).$tail; 
}

?>