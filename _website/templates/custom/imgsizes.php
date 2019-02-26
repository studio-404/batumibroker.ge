<?php 
$fetch = db_fetch_all("SELECT `idx`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`, `photo6`, `photo7`, `photo8`, `photo9`, `photo10` FROM `catalogs` WHERE `deleted`!=1 AND `visibility`='true' AND `photo1`!=''");

foreach ($fetch as $v) {
	
	$photo1 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo1']);
	$photo2 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo2']);
	$photo3 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo3']);
	$photo4 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo4']);
	$photo5 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo5']);
	$photo6 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo6']);
	$photo7 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo7']);
	$photo8 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo8']);
	$photo9 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo9']);
	$photo10 = str_replace("http://batumibroker.ge/", "/home/batumibroker/public_html/", $v['photo10']);

	$photosize = "[";
	
	if(file_exists($photo1)){
		list($width, $height) = getimagesize($photo1);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo2)){
		list($width, $height) = getimagesize($photo2);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo3)){
		list($width, $height) = getimagesize($photo3);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo4)){
		list($width, $height) = getimagesize($photo4);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo5)){
		list($width, $height) = getimagesize($photo5);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo6)){
		list($width, $height) = getimagesize($photo6);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo7)){
		list($width, $height) = getimagesize($photo7);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo8)){
		list($width, $height) = getimagesize($photo8);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo9)){
		list($width, $height) = getimagesize($photo9);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	if(file_exists($photo10)){
		list($width, $height) = getimagesize($photo10);
		$photosize .= $width."x".$height.",";
	}else{
		$photosize .= "0x0,";
	}

	$photosize .= "]";
	/*
	\[(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)(\d+x\d+\,)\]
	*/
	db_query("UPDATE `catalogs` SET `photosize`='".$photosize."' WHERE `idx`='".(int)$v['idx']."'");
} 

echo date("d.m.Y h:i:s")." - Updated";