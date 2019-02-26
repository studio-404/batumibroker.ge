<?php
	defined('DIR') OR exit;
	$out = array(
		"Error" => array(
			"Code"=>1, 
			"Text"=>l("error"),
			"Details"=>""
		),
		"Success"=>array(
			"Code"=>0, 
			"Text"=>"",
			"Details"=>""
		)
	); 

	if(isset($_GET["e"]) && !empty($_GET["e"]) && isset($_SESSION["batumibroker_username"])){
		$g_userinfo = g_userinfo();
		$dir = "files/user-images/".$g_userinfo["username"];
		$dir_pre = "files/user-images/".$g_userinfo["username"]."/pre";
		if(!file_exists($dir)){
			mkdir($dir);
		}

		if(!file_exists($dir_pre)){
			mkdir($dir_pre);
		}

		$f = isset($_GET["f"]) ? (int)$_GET["f"] : 0;
		$str = file_get_contents("php://input");
		$filename = $f.".".$_GET["e"];
		$path = $dir_pre."/".$filename;
		file_put_contents($path, $str);

		echo "Success";

		exit();
	}

	if(isset($_POST["type"])){
		$type = $_POST["type"];

		switch ($type) {
			case 'registration':
				if(
					empty($_POST["phoneemail"]) || 
					empty($_POST["password"]) || 
					empty($_POST["rpassword"]) 
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$successText = "";
				}else if($_SESSION["register_token"]!=$_POST["register_token"]){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}else if(!filter_var($_POST["phoneemail"], FILTER_VALIDATE_EMAIL)){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("emailerror");
					$successText = "";
				}else if(g_user_exists($_POST["phoneemail"])){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("userexists");
					$successText = "";
				}else if(strlen($_POST["password"]) <= 4){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("passworderror");
					$successText = "";
				}else if($_POST["password"]!==$_POST["rpassword"]){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("passwordmatch");
					$successText = "";
				}else if($_POST["siterules"]!=1){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("pleaseagree");
					$successText = "";
				}else{
					$random_number = rand(50000,100000);

					$insert = db_insert("site_users", array(
									'firstname' => "New User",
									'username' => $_POST["phoneemail"],
									'userpass' => md5($_POST["password"]),
									'email' => $_POST["phoneemail"],
									'active' => 0,
									'random' => $random_number,
									'banned' => 0,
									'deleted' => 0,
									'regdate' => date("Y-m-d")
								));
					db_query($insert);

					$activate_account_link = sprintf(
						"<a href=\"%s%s/activate-account/?a=%s\">%s</a>", 
						WEBSITE_BASE, 
						l(),
						$random_number, 
						$random_number 
					);

					$email_text = sprintf(
					  l("registrationemailtext"), 
					  "<strong>Batumi Broker</strong>",
					  $activate_account_link
					);

					g_send_email(array(
					  "sendTo"=>$_POST["phoneemail"], 
					  "subject"=>"Registration", 
					  "body"=>$email_text 
					));

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}
				
				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);

				break;

			case "login":
				if(
					empty($_POST["auth_username"]) || 
					empty($_POST["auth_password"]) 
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$successText = "";
				}else if($_SESSION["auth_token"]!=$_POST["auth_token"]){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}else if($user = g_user_exists($_POST["auth_username"], $_POST["auth_password"])){
					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
					$_SESSION["batumibroker_username"] = $_POST["auth_username"];

					if($_POST["save"]==1):
					$cookie_name = "batumibroker_username";
					$cookie_value = $_SESSION["batumibroker_username"];
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
					endif;
				}else{
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("wronguser");
					$successText = "";
				}
				
				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "signout":
				$errorCode = 0;
				$successCode = 1;
				$errorText = "";
				$successText = l("welldone"); 

				unset($_SESSION["batumibroker_username"]);
				if(isset($_COOKIE["batumibroker_username"])) {
					setcookie("batumibroker_username", "", 1, "/");
				}
				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;

			case "recover_step_one": 
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["recover_email"]) 
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$successText = "";
				}else if($_SESSION["recover1_token"]!=$_POST["recover1_token"]){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}else if(!filter_var($_POST["recover_email"], FILTER_VALIDATE_EMAIL)){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("emailerror");
					$successText = "";
				}else if(!g_user_exists($_POST["recover_email"])){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("usernotexists");
					$successText = "";
				}else if(g_user_exists($_POST["recover_email"])){
					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("weldone");

					$recovery_random = rand(10000, 99000);
					$updateRandomSql = "UPDATE `site_users` SET `recovery_random`='".$recovery_random."' WHERE `username`='".$_POST["recover_email"]."' AND `deleted`=0";
					db_query($updateRandomSql); 

					$email_text = sprintf(l("emailpasswordrecovery"), $recovery_random);

					g_send_email(array(
					  "sendTo"=>$_POST["recover_email"], 
					  "subject"=>"Recover password", 
					  "body"=>$email_text 
					));

				}else{
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;

			case "recover_step_two":
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["recover_code"]) ||
					empty($_POST["new_password"]) ||
					empty($_POST["rnew_password"]) 
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$successText = "";
				}else if(!g_random_recovery_exists($_POST["recover_code"])){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}else if(strlen($_POST["new_password"]) <= 4){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("passworderror");
					$successText = "";
				}else if($_POST["new_password"]!==$_POST["rnew_password"]){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("passwordmatch");
					$successText = "";
				}else if(g_random_recovery_exists($_POST["recover_code"])){
					g_recover_password(
						$_POST["recover_code"], 
						$_POST["new_password"]
					);

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "facebook_login":
				try{
					$fb = g_facebook_sdk();
					$helper = $fb->getRedirectLoginHelper();
					$permissions = ['email']; // Optional permissions
					$loginUrl = $helper->getLoginUrl(WEBSITE_BASE.l().'/home', $permissions);
					$url = str_replace("&amp;","&",htmlspecialchars($loginUrl));

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = $url;
				}catch(Exception $e){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}
				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "email_verification": 
				if(
					empty($_POST["input_lang"]) ||   
					empty($_POST["verification_code"]) ||
					(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"]))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}else if(g_random_exists($_POST["verification_code"])){
					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}else{
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}
				

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "edit_profile": 
				$errorCode = 1;
				$successCode = 0;
				$errorText = l("error");
				$containerCode = "";
				$successText = "";

				if(
					empty($_POST["input_lang"]) ||   
					empty($_POST["firstname"]) ||
					(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"]))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("firstnameerror");
					$containerCode = ".firstname-box";
					$successText = "";
				}else{
					$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
					$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;
					$update = "UPDATE `site_users` SET 
						`firstname`='".$_POST["firstname"]."', 
						`personalid`='".$_POST["personalid"]."', 
						`companyname`='".$_POST["companyname"]."', 
						`address`='".$_POST["address"]."', 
						`mobile`='".$_POST["mobile"]."', 
						`skype`='".$_POST["skype"]."' 
						WHERE 
						`username`='".$username."' AND 
						`deleted`=0
					"; 
					if(db_query($update)){
						$errorCode = 0;
						$successCode = 1;
						$errorText = "";
						$containerCode = "";
						$successText = l("welldone");
					}
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Container"=>$containerCode,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "edit_profile_password": 
				$errorCode = 1;
				$successCode = 0;
				$errorText = l("error");
				$containerCode = "";
				$successText = "";

				if(
					empty($_POST["input_lang"]) ||   
					empty($_POST["currentpassword"]) ||
					empty($_POST["newpassword"]) ||
					empty($_POST["rnewpassword"]) ||
					(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"]))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$containerCode = "";
					$successText = "";
				}else if(strlen($_POST["newpassword"]) <= 4){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("passworderror");
					$successText = "";
				}else if($_POST["newpassword"]!==$_POST["rnewpassword"]){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("passwordmatch");
					$successText = "";
				}else if(md5($_POST["currentpassword"])!=g_checkpassword()){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("oldpasswordmatch");
					$successText = "";
				}else{
					$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
					$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;
					$update = "UPDATE `site_users` SET 
						`userpass`='".md5($_POST["newpassword"])."' 
						WHERE 
						`username`='".$username."' AND 
						`userpass`='".md5($_POST["currentpassword"])."' AND 
						`deleted`=0
					"; 
					if(db_query($update)){
						$errorCode = 0;
						$successCode = 1;
						$errorText = "";
						$containerCode = "";
						$successText = l("welldone");
					}
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Container"=>$containerCode,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "removeFavourite":
				g_clear_cache();
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["productid"]) || 
					(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"]))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$containerCode = "";
					$successText = "";
				}else{
					$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
					$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;

					$check = "SELECT `id` FROM `favourites` WHERE `catid`='".(int)$_POST["productid"]."' AND `username`='".$username."'"; 
					$fetch = db_fetch($check);
					if(isset($fetch["id"])){
						$remove = "DELETE FROM `favourites` WHERE `catid`='".(int)$_POST["productid"]."' AND `username`='".$username."'";
						db_query($remove);
					}

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "addOrRemoveFavourites": 
				g_clear_cache();
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["productid"]) || 
					(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"]))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$containerCode = "";
					$successText = "";
				}else{
					$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
					$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;

					$check = "SELECT `id` FROM `favourites` WHERE `catid`='".(int)$_POST["productid"]."' AND `username`='".$username."'"; 
					$fetch = db_fetch($check);
					if(isset($fetch["id"])){
						$remove = "DELETE FROM `favourites` WHERE `catid`='".(int)$_POST["productid"]."' AND `username`='".$username."'";
						db_query($remove);
					}else{
						$add = "INSERT INTO `favourites` SET `catid`='".(int)$_POST["productid"]."', `username`='".$username."'";
						db_query($add);
					}

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "removeMyAdds":
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["productid"]) || 
					(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"]))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$containerCode = "";
					$successText = "";
				}else{
					$userinfo = g_userinfo();
					
					$remove = "UPDATE `catalogs` SET `deleted`=1 WHERE `id`='".(int)$_POST["productid"]."' AND `administrator`='".(int)$userinfo["id"]."'";
					db_query($remove);					

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["productid"]) || 
					(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"]))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$containerCode = "";
					$successText = "";
				}else{
					$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
					$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;
					
					$remove = "DELETE FROM `favourites` WHERE `catid`='".(int)$_POST["productid"]."' AND `username`='".$username."'";
					db_query($remove);					

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "send_contact_message":
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["email"]) || 
					empty($_POST["subject"]) || 
					empty($_POST["message"]) 
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("allfields");
					$containerCode = "";
					$successText = "";
				}else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("emailerror");
					$successText = "";
				}else{

					$body = "<h1>შეტყობინება</h1>";
					$body .= sprintf("<strong>ელ-ფოსტა: </strong> <span>%s</span><br />", $_POST["email"]);
					$body .= sprintf("<strong>სათაური: </strong> <span>%s</span><br />", $_POST["subject"]);
					$body .= sprintf("<strong>ტექსტი: </strong><br />%s", $_POST["message"]);
					
					g_send_email(array(
					  "sendTo"=>s("email"), 
					  "subject"=>"შეტყობინება - Batumi Broker", 
					  "body"=>$body 
					));		

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "count_items":
				$where = "";
				
				if(isset($_POST["search_id"]) && !empty($_POST["search_id"])){
					$where .= "AND `id`=".(int)$_POST["search_id"];
				}else{
					if(isset($_POST["search_catalogtype"]) && !empty($_POST["search_catalogtype"])){
						$where .= "AND `catalogid`=".(int)$_POST["search_catalogtype"];
					}

					if(isset($_POST["search_saletype"]) && !empty($_POST["search_saletype"])){
						$where .= " AND `sale`=".(int)$_POST["search_saletype"];
					}

					if(isset($_POST["search_status"]) && !empty($_POST["search_status"])){
						$where .= " AND `status`=".(int)$_POST["search_status"];
					}

					if(isset($_POST["search_city"]) && !empty($_POST["search_city"])){
						$where .= " AND `city`=".(int)$_POST["search_city"];
					}

					if(isset($_POST["search_room"]) && !empty($_POST["search_room"]) && $_POST["search_room"]!="0"){
						$where .= " AND `rooms`=".(int)$_POST["search_room"];
					}

					if(isset($_POST["search_from_price"]) && !empty($_POST["search_from_price"]) && $_POST["search_from_price"]!="0"){
						$where .= " AND convert(`price`, unsigned)>=".(int)$_POST["search_from_price"];
					}

					if(isset($_POST["search_to_price"]) && !empty($_POST["search_to_price"]) && $_POST["search_to_price"]!="0"){
						$where .= " AND convert(`price`, unsigned)<=".(int)$_POST["search_to_price"];
					}

					if(isset($_POST["search_currency"]) && !empty($_POST["search_currency"]) && ((int)$_POST["search_from_price"]>0 || (int)$_POST["search_to_price"]>0)){
						$currency = "GEL";
						if($_POST["search_currency"]=="USD"){ $currency = "USD"; }
						$where .= " AND `currency`='".$currency."'";
					}

					if(isset($_POST["search_from_floor"]) && !empty($_POST["search_from_floor"]) && $_POST["search_from_floor"]!="0"){
						$where .= " AND convert(`floor`, unsigned)>=".(int)$_POST["search_from_floor"];
					}

					if(isset($_POST["search_to_floor"]) && !empty($_POST["search_to_floor"]) && $_POST["search_to_floor"]!="0"){
						$where .= " AND convert(`floor`, unsigned)<=".(int)$_POST["search_to_floor"];
					}

					if(isset($_POST["search_from_kvm"]) && !empty($_POST["search_from_kvm"]) && $_POST["search_from_kvm"]!="0"){
						$where .= " AND convert(`square`, unsigned)>=".(int)$_POST["search_from_kvm"];
					}

					if(isset($_POST["search_to_kvm"]) && !empty($_POST["search_to_kvm"]) && $_POST["search_to_kvm"]!="0"){
						$where .= " AND convert(`square`, unsigned)<=".(int)$_POST["search_to_kvm"];
					}

					if(isset($_POST["search_condition"]) && !empty($_POST["search_condition"]) && $_POST["search_condition"]!="0"){
						$where .= " AND `condition`=".(int)$_POST["search_condition"];
					}
					
					if(isset($_POST["search_project"]) && !empty($_POST["search_project"]) && $_POST["search_project"]!="0"){
						$where .= " AND `project`=".(int)$_POST["search_project"];
					}
				}

				$sql = "SELECT COUNT(`id`) AS counted FROM `catalogs` WHERE `visibility`='true' AND `deleted`=0 AND `language`='".l()."' AND `catalogid` IN(7,8,9,10,11,20) ".$where;
				
				$fetch = db_fetch($sql); 

				if(isset($fetch["counted"])){
					$counted = (int)$fetch["counted"];

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";
					$successText = l("welldone");
				}else{
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
					$counted = 0;
				}
				

				$out = array(
					"Error" => array( 
						"SqlQuery"=>$sql, 
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Counted"=>0,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Counted"=>$counted,
						"Details"=>""
					)
				);
				break;
			case "useraddstatement":
				if(
					empty($_POST["input_lang"]) || 
					empty($_POST["useradd_token"]) || 
					!isset($_SESSION["useradd_token"]) || 
					!isset($_SESSION["batumibroker_username"]) || 
					$_SESSION["useradd_token"]!=$_POST["useradd_token"]
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}else if(
					empty($_POST["useradd_category"]) || 
					empty($_POST["useradd_saletype"]) || 
					empty($_POST["useradd_title"]) || 
					empty($_POST["useradd_expireday"]) || 
					empty($_POST["useradd_city"]) || 
					empty($_POST["useradd_address"]) || 
					empty($_POST["useradd_space"]) || 
					empty($_POST["useradd_price"]) || 
					empty($_POST["stat_currency"]) || 
					empty($_POST["useradd_contactphone"]) || 
					empty($_POST["useradd_description"]) 
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("fillrequiredfields");
					$successText = "";
				}else if(
					!in_array($_POST["useradd_category"], array(40,41,42,43,44,66)) || 
					!in_array($_POST["useradd_saletype"], array(9,10,11,12)) || 
					!in_array($_POST["useradd_expireday"], array(30,60,90)) || 
					!in_array($_POST["stat_currency"], array("GEL","USD"))
				){
					$errorCode = 1;
					$successCode = 0;
					$errorText = l("error");
					$successText = "";
				}else{
					$id=db_fetch('select max(id) as maxid from `'.c("table.catalogs").'`');
					$catalogid=db_fetch('select `attached` from `'.c("table.pages").'` WHERE `id`='.$_POST["useradd_category"].' AND `language`="'.l().'" AND `deleted`=0 AND `visibility`="true" ');
					$catalogid=explode("catalog", $catalogid["attached"]);
					$catalogid=(is_numeric($catalogid[1]) ? $catalogid[1] : 0);
					$vis = 'false';
					$supervip = ((isset($_POST["useradd_supervip"])) && ($_POST["useradd_supervip"] == 'on')) ? '1' : '0';
					$vip = ((isset($_POST["useradd_vip"])) && ($_POST["useradd_vip"] == 'on')) ? '1' : '0';
					$possibleexchange = $_POST["useradd_posiableexchange"];
					$cadastralcode = (!empty($_POST["useradd_procode"])) ? $_POST["useradd_procode"] : ' ';

					$sale = (!empty($_POST["useradd_saletype"])) ? (int)$_POST["useradd_saletype"] : ' ';
					$city = (!empty($_POST["useradd_city"])) ? (int)$_POST["useradd_city"] : ' ';
					$rooms = (!empty($_POST["useradd_room"])) ? $_POST["useradd_room"] : ' ';
					$price = (!empty($_POST["useradd_price"])) ? $_POST["useradd_price"] : ' ';
					$address = (!empty($_POST["useradd_address"])) ? $_POST["useradd_address"] : ' ';
					$currency = (!empty($_POST["stat_currency"])) ? $_POST["stat_currency"] : 'GEL';
					$floor = (!empty($_POST["useradd_floor"])) ? $_POST["useradd_floor"] : ' ';
					$floor_all = (!empty($_POST["useradd_floorall"])) ? $_POST["useradd_floorall"] : ' ';
					$condition = (!empty($_POST["useradd_condition"])) ? (int)$_POST["useradd_condition"] : ' ';
					$project = (!empty($_POST["useradd_project"])) ? (int)$_POST["useradd_project"] : ' ';
					$square = (!empty($_POST["useradd_space"])) ? $_POST["useradd_space"] : ' ';
					$bathrooms = (!empty($_POST["useradd_bathroom"])) ? $_POST["useradd_bathroom"] : ' ';
					$ceilheight = (!empty($_POST["useradd_ceilheight"])) ? $_POST["useradd_ceilheight"] : ' ';
					$aditionalinformation = (!empty($_POST["useradd_additional"])) ? $_POST["useradd_additional"] : ' ';
					$map_coordinates = (!empty($_POST["useradd_googlemap"])) ? $_POST["useradd_googlemap"] : " ";
					$contactphone = (!empty($_POST["useradd_contactphone"])) ? $_POST["useradd_contactphone"] : ' ';
					$description = (!empty($_POST["useradd_description"])) ? $_POST["useradd_description"] : ' ';
					$meta_keys = ' ';
					$newid=$id["maxid"]+1;
					$idx=0;
					$g_userinfo = g_userinfo();



					$fromFile = "files/user-images/".$g_userinfo["username"]."/pre";
					$moveTo = "files/user-images/".$g_userinfo["username"];

					if(!file_exists($moveTo)){
						mkdir($moveTo);
					}

					if(!file_exists($fromFile)){
						mkdir($fromFile);
					}


					$photo = array();

					$scandir = scandir($fromFile);
					$x = 1;
					foreach($scandir as $entry):
			        if ($entry != "." && $entry != "..") {
			        	$fileExt = explode(".", $entry);
			        	$oldFileName = $fromFile."/".$entry;
			            $newFileName = $moveTo."/".$g_userinfo['id']."_".$x.md5(time()).".".$fileExt[1];
			            copy($oldFileName, $newFileName);
			            $photo[] = "http://batumibroker.ge/".$newFileName;
			            unlink($oldFileName);
			            $x++;
		        	}
		        	endforeach;
					   


					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.catalogs"), array(
							'id' => $newid,
							'catalogid' => (int)$catalogid,
							'visibility' => $vis,
							'position' => $newid,
							'language' => $language,
							'title' => strip_tags($_POST['useradd_title']),
							'short_description' => " ",	
							'date' => time(),	
							'expire_date' => time()+($_POST["useradd_expireday"]*24*60*60),									
							'cadastralcode' => $cadastralcode,
							'supervip' => $supervip,
							'vip' => $vip,
							'possibleexchange' => $possibleexchange,						
							'sale' => $sale,							
							'city' => $city,							
							'rooms' => $rooms,							
							'price' => $price,							
							'address' => $address,							
							'currency' => $currency,							
							'floor' => $floor,							
							'floor_all' => $floor_all,							
							'condition' => $condition,							
							'project' => $project,
							'square' => $square,
							'bathrooms' => $bathrooms,
							'ceilheight' => $ceilheight,
							'aditionalinformation' => $aditionalinformation,
							'map_coordinates' => $map_coordinates,							
							'contactphone' => $contactphone,							
							'description' => $description, 
							'photo1' => isset($photo[0]) ? $photo[0] : '', 
							'photo2' => isset($photo[1]) ? $photo[1] : '', 
							'photo3' => isset($photo[2]) ? $photo[2] : '', 
							'photo4' => isset($photo[3]) ? $photo[3] : '', 
							'photo5' => isset($photo[4]) ? $photo[4] : '', 
							'photo6' => isset($photo[5]) ? $photo[5] : '', 
							'photo7' => isset($photo[6]) ? $photo[6] : '', 
							'photo8' => isset($photo[7]) ? $photo[7] : '', 
							'photo9' => isset($photo[8]) ? $photo[8] : '', 
							'photo10' => isset($photo[9]) ? $photo[9] : '', 
							'meta_keys' => $meta_keys, 
							'administrator'=>$g_userinfo["id"]						
						));
						// echo $insert;
						db_query($insert);
					endforeach;

					$cat = "";
					if($_POST["useradd_category"]==40){
						$cat = "ბინები";
					}else if($_POST["useradd_category"]==41){
						$cat = "კერძო სახლები";
					}else if($_POST["useradd_category"]==42){
						$cat = "აგარაკები";
					}else if($_POST["useradd_category"]==43){
						$cat = "მიწის ნაკვეთები";
					}else if($_POST["useradd_category"]==44){
						$cat = "კომერციული ფართები";
					}else if($_POST["useradd_category"]==66){
						$cat = "სასტუმროები";
					}

					$sal = "";
					if($_POST["useradd_saletype"]==9){
						$sal = "იყიდება";
					}else if($_POST["useradd_saletype"]==10){
						$sal = "ქირავდება";
					}else if($_POST["useradd_saletype"]==11){
						$sal = "გირავდება";
					}else if($_POST["useradd_saletype"]==12){
						$sal = "დღიური";
					}

					$body = "<h1>შეტყობინება</h1>";
					$body .= sprintf("<strong>ვებ გვერდზე დაემატა ახალი განცხადება !</strong>");
					$body .= sprintf("<p><em>კატეგორია: </em> %s</p>", $cat);
					$body .= sprintf("<p><em>გარიგების ტიპი: </em> %s</p>", $sal);
					$body .= sprintf("<p><em>დასახელება: </em> %s</p>", strip_tags($_POST['useradd_title']));
					
					g_send_email(array(
					  "sendTo"=>s("email"),
					  "subject"=>"შეტყობინება - Batumi Broker", 
					  "body"=>$body 
					));

					g_clear_cache();

					$errorCode = 0;
					$successCode = 1;
					$errorText = "";					
					$successText = l("welldone");
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "filepreupload":
				if(isset($_FILES['file']['name'])){
					$errorCode = 0;
					$errorText = "";
					$successCode = 1;
					$successText = "File received !";
				}else{
					$errorCode = 1;
					$errorText = "ERROR";
					$successCode = 0;
					$successText = "";
				}

				$out = array(
					"Error" => array(
						"Code"=>$errorCode, 
						"Text"=>$errorText,
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>$successCode, 
						"Text"=>$successText,
						"Details"=>""
					)
				);
				break;
			case "removeImage": 
				$g_userinfo = g_userinfo();
				$imageid = isset($_POST["imageid"]) ? (int)$_POST["imageid"] : 0;
				$ext = isset($_POST["ext"]) ? $_POST["ext"] : "jpg";
				$file = "files/user-images/".$g_userinfo["username"]."/pre/".$imageid.".".$ext;
				if(file_exists($file)){
					unlink($file);
				}
				break;
			default:
				# code...
				break;
		}


	}

	// if(isset($_FILES['file']['name'])){
	// 	echo "aaa";
	// }
	// print_r($_REQUEST);
	echo json_encode($out);
?>