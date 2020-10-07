<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	include 'simple_html_dom.php';

	$url = "https://card.nmc.gov.gh:7070/";
	if (isset($_POST['md5'])) {
		$num = $_POST['md5'];

		$num = md5($num);

		$link = $url."sample.php?value=".$num;

		$html = file_get_html($link);
		$reg_no = $html->find('div[class=reg]',0);
		$pin = $html->find('div[class=pin]',0);
		$issue = $html->find('div[class=issue]',0);
		$name = $html->find('div[class=name]',0);
		$expiry = $html->find('div[class=expiry]',0);
		$image = $html->find('div[class=photo] img',0)->getAttribute("src");

		$filename = $name->plaintext.'_'.time();

		if(!empty($image)) {
		$ch = curl_init($url.$image);
		$fp = fopen('nmcpix/'.$filename.'.jpg', 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		} else{
			// do nothing
		}
		
		$data ="Name: ". $name->plaintext."\r\n". "Reg No: ".$reg_no->plaintext."\r\n"."Pin: ".$pin->plaintext."\r\n"."Date issued: ".$issue->plaintext."\r\n"."Date of expiry: ".$expiry->plaintext."\r\n"."Image Name: ".$filename;

		file_put_contents("txt/".$filename.".txt", $data);

		if ($html->save("html/".$filename.".htm")) {
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong>'.$name->plaintext.'\'s data is saved!</strong> <a href="txt/'.$filename.'.txt">Download Text data </a>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>';
		exit();
		}
		
	} else {
	echo "404 - page not found";
	
}

}else {
	echo "404 - page not found";
	
}
?>

