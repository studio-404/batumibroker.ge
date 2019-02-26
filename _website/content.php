<?php defined('DIR') OR exit; ?>
<?php
	$url="";
	$urlparts=array();
	foreach($_GET as $k=>$v) {
        if($k!='product')
		  $urlparts[]=$k."=".$v;
	}
	if(count($urlparts)>0)
		$url='?'.implode("&",$urlparts);
    $product=NULL;
    if(isset($_GET["product"])) 
        $product=$_GET["product"];

	$photo = "";
	$desc = "";
	$producttitle = "";
	$prod = 0;
	if(isset($_GET["product"])) {
		$prod = $_GET["product"];
		$cat = db_fetch("select * from catalogs where id = '".$_GET["product"]."' and language = '".l()."'");
		$photo = $cat["photo1"];
		$producttitle = $cat["title"];
		$desc = $cat["description"];
		if($desc=="") $desc = $producttitle;
	}
	if($photo=="") $photo = href().WEBSITE."/images/logo.png";
	$pageid = href($storage->section['id']).(($prod>0) ? "?product=".$_GET["product"]:"");

?>
<!DOCTYPE html>
<html>
<head>
    <base href="<?php echo href(); ?>" />
	   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="google-site-verification" content="" />
<?php
?>
    <meta name="keywords" content="<?php echo s('keywords') .', ' . $storage->section["meta_keys"]; ?>" />
    <meta name="description" content="<?php echo s('description') . ', ' . $storage->section["meta_desc"]; ?>" />
    <meta name="robots" content="Index, Follow" />
<?php
	$pagetitle = $storage->section['title'];
	if(isset($_GET["product"])) {
		$prod = db_fetch("select * from catalogs where language='".l()."' and id=".db_escape($_GET["product"]));
		$pagetitle = $prod["title"];
	}

  if(isset($photo) && !empty($photo)){
    // $ex = explode("http://batumibroker.ge/files/", $photo);
    // $photo = "http://batumibroker.ge/files/".urlencode($ex[1]);
    $photo = g_image($photo, 600, 315);
  }
?>
	  <title><?php echo s('adminname').' - '.$storage->section['title']; ?></title>
    <meta property="fb:app_id" content="162785324322546" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo WEBSITE;?>/images/favicon.ico">
    <link rel="image_src" type="image/gif" href="<?php echo WEBSITE;?>/images/logo.png" />   

    <meta property="og:image" content="<?php echo ($storage->section["imagen"]!="") ? $storage->section["imagen"] : $photo;?>" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />
    <meta property="og:title" content="<?php echo $producttitle;?>" />
    <meta property="og:description" content="<?php echo mb_substr(strip_tags($storage->section['content']),0,800,'UTF-8'); ?>"/>
    <meta property="og:url" content="<?php echo href($storage->section['id']).(($prod>0) ? "?product=".$_GET["product"]:"");?>" />
    <meta property="og:site_name" content="<?php echo s('adminname').' - '.$pagetitle; ?>" />
    <meta property="og:type" content="website" />

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="<?php echo WEBSITE;?>/js/jquery-3.2.1.min.js" ></script>
    <script src="<?php echo WEBSITE;?>/js/bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo WEBSITE;?>/js/bootstrap-select.js" type="text/javascript"></script>
    <script src="<?php echo WEBSITE;?>/js/slick.min.js" type="text/javascript"></script>
    <script src="<?php echo WEBSITE;?>/js/scripts.js" type="text/javascript"></script>
   
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/bootstrap-select.css">
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/slick.css">
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/forms.css">
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/style.css">
    <link rel="stylesheet" href="<?php echo WEBSITE;?>/css/custom_res.css">

    <?php 
    if(isset($_GET["product"])):
    ?>
    <!-- Product Page JS & CSS file links  -->
    <?php
    endif;
    ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-77706931-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-77706931-4');
</script>
    
</head>
<body>
<?php 
g_facebooklogin();
if(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"])){
?>
<!-- Login -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content"> 
      <div class="modal-body">
        <div class="ModalBodyDiv">
          <div class="ModalTitle"><?=l("signin")?>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="ModalContactDiv">
            <div class="row">
              <div class="form-group col-sm-12 alert-danger-auth-box" style="display: none">
                <div class="alert alert-danger" role="alert" style="margin-bottom:0">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span>&nbsp;</span>
                </div>
              </div>
              <div class="form-group col-sm-12">
                <input type="hidden" class="auth_token" id="auth_token" name="auth_token" value="<?=$_SESSION["auth_token"]?>" />
                <input type="text" class="InpucClass1 auth_username" id="auth_username" name="auth_username" placeholder="<?=l("phoneemail")?>"/>
              </div>
              <div class="form-group col-sm-12">
                <input type="password" class="InpucClass1 auth_password" id="auth_password" name="auth_password" placeholder="<?=l("password")?>"/>
              </div>
              <div class="form-group col-sm-6">
                <div class="checkbox checkbox-success">
                  <input id="save" name="save" class="save" type="checkbox">
                  <label for="save"><?=l("save")?></label>
                </div>
              </div>
              <div class="form-group col-sm-6 text-right">
                <a href="#" class="PassRecoveryLink" data-toggle="modal" data-target="#RecoverModal" data-dismiss="modal"><?=l("recoverpassword")?></a>
              </div>              
              <div class="form-group col-sm-12">
                <button class="ButtonBlue signin"><?=l("signin")?></button>
              </div>
              <div class="form-group col-sm-12">
                <button class="FBButton"><i class="fa fa-facebook"></i> <?=l("fbsignin")?></button>
              </div>
            </div>
            <div class="row row40">
              <a href="#" class="PopupButton" data-toggle="modal" data-target="#RegisterModal" data-dismiss="modal"><?=l("registration")?></a>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<!-- Recover password -->
<div class="modal fade" id="RecoverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content"> 
      <div class="modal-body">
        <div class="ModalBodyDiv">
          <div class="ModalTitle"><?=l("recoverpassword")?>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="ModalContactDiv">
            <div class="row">
              <div class="form-group col-sm-12 alert-danger-auth-box" style="display: none">
                <div class="alert alert-danger" role="alert" style="margin-bottom:0">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span>&nbsp;</span>
                </div>
              </div>

              <div class="step1">
                <div class="form-group col-sm-12 alert-recovery-step1" style="display:none">
                  <div class="alert alert-success" role="alert" style="margin-bottom:0">
                  <i class="fa fa-info-circle" aria-hidden="true"></i>
                  <span>&nbsp;</span>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                  <input type="hidden" class="recover1_token" id="recover1_token" name="recover1_token" value="<?=$_SESSION["recover1_token"]?>" />
                  <input type="text" class="InpucClass1 recover_email" id="recover_email" name="recover_email" placeholder="<?=l("phoneemail")?>"/>
                </div>                           
                <div class="form-group col-sm-12">
                  <button class="ButtonBlue recover_button1"><?=l("recoverpassword")?></button>
                </div>
              </div>
              
              <div class="step2" style="display:none">
                <div class="form-group col-sm-12 alert-recovery-step2">
                  <div class="alert alert-success" role="alert" style="margin-bottom:0">
                  <i class="fa fa-info-circle" aria-hidden="true"></i>
                  <span><?=l("checkemailinbox")?></span>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                  <?php  ?>
                  <input type="hidden" class="recover2_token" id="recover2_token" name="recover2_token" value="<?=$_SESSION["recover2_token"]?>" />
                  <input type="text" class="InpucClass1 recover_code" id="recover_code" name="recover_code" placeholder="<?=l("recovercode")?>"/>
                </div>
                <div class="form-group col-sm-12">
                  <input type="password" class="InpucClass1 new_password" id="new_password" name="new_password" placeholder="<?=l("newpassword")?>"/>
                </div>
                <div class="form-group col-sm-12">
                  <input type="password" class="InpucClass1 rnew_password" id="rnew_password" name="rnew_password" placeholder="<?=l("rpassword")?>"/>
                </div>
                
                            
                <div class="form-group col-sm-12">
                  <button class="ButtonBlue recover_button2"><?=l("recoverpassword")?></button>
                </div>
              </div>
              
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<!-- Register -->
<div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content"> 
      <div class="modal-body">
        <div class="ModalBodyDiv">
          <div class="ModalTitle"><?=l("registration")?>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="ModalContactDiv">
            <div class="row">
              <div class="form-group col-sm-12 alert-danger-registration-box" style="display: none">
                <div class="alert alert-danger" role="alert" style="margin-bottom:0">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span>&nbsp;</span>
                </div>
              </div>
              <div class="form-group col-sm-12">
                <input type="hidden" class="register_token" id="register_token" name="register_token" value="<?=$_SESSION["register_token"]?>" />
                <input type="text" class="InpucClass1 phoneemail" id="phoneemail" name="phoneemail" placeholder="<?=l("phoneemail")?>"/>
              </div>
              <div class="form-group col-sm-12">
                <input type="password" class="InpucClass1 password" id="password" name="password" placeholder="<?=l("password")?>"/>
              </div>
              <div class="form-group col-sm-12">
                <input type="password" class="InpucClass1 rpassword" id="rpassword" name="rpassword" placeholder="<?=l("rpassword")?>"/>
              </div>
              <div class="form-group col-sm-12">
                <div class="checkbox checkbox-success">
                  <input id="siterules" class="siterules" name="siterules" type="checkbox" value="1" />
                  <label for="siterules">
                  <?=l("iagree")?> <a href="#" class="popupLink"><?=l("siterules")?></a>
                  </label>
                </div>
              </div>              
              <div class="form-group col-sm-12">
                <button class="ButtonBlue registrationButtom" id="registrationButtom"><?=l("registration")?></button>
              </div>
              <div class="form-group col-sm-12">
                <button class="FBButton"><i class="fa fa-facebook"></i> <?=l("fbsignin")?></button>
              </div>
            </div>
            <div class="row row40">
              <a href="#" class="PopupButton" data-toggle="modal" data-target="#LoginModal" data-dismiss="modal"><?=l("signin")?></a>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>
<?php
}
?>
<img src="/_website/img/logo.png" class="showOnPrint" alt="" />
<div class="Header"> 
  <div class="container-fluid padding_0">
    <div class="HeaderDiv">
      <div class="hamburger ShowMobileDiv"></div>
      <div class="container">
        <div class="row">
          <div class="col-sm-3 mobile-header">
            <a href="<?php echo "/" . l(); ?>/home" class="LogoDiv"></a> 
          </div>
          <div class="col-sm-9 text-right mobile-header-right">
            <div class="HeaderRight">
              <ul>
                <li><a href="/<?=l()?>/faq"><?=l("Help")?></a></li>
                <li><a href="#"><?=l("advertisement")?></a></li>
                <li><a href="/<?=l()?>/contact"><?=l("contact")?></a></li>
                <li class="heartButton"><a href="/<?=l()?>/profile?view=favourites"><i class="fa fa-heart-o"></i></a></li>
              </ul>
              <ul>
                <?php 
                if(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"])){
                ?>
                <li class="loginButton signinbutton-desktop"><a href="#" data-toggle="modal" data-target="#LoginModal"><?=l("signin")?></a></li>
                <?php
                }else{
                  $userinfo = g_userinfo();
                  $image = (!empty($userinfo["avatar"])) ? explode(WEBSITE_BASE, $userinfo["avatar"]) : "";
                  $image = (isset($image[1]) && file_exists($image[1])) ? $userinfo["avatar"] : WEBSITE."/img/dummy_user.png";
                ?>
                <li class="profilepage-button" style="position:relative">
                  <a href="/<?=l()?>/profile">
                    <img src="<?=$image?>" alt="Avatar" style="width:38px; height:38px; border-radius:100%;" />
                  </a>

                  <div class="gdropdownNav">
                    <a href="/<?=l()?>/profile"><?=l("profilepage")?></a>
                    <a href="javascript:void(0)" class="signout"><?=l("signout")?></a>
                  </div>
                </li>
                <?php 
                }
                ?>
                
                
                <li class="LanguageDiv">
                  <?php echo g_language(); ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="MainMenu MobileDivShow">
      <div class="container">
        <ul>
          <?php echo main_menu();?>
          <li><a href="/<?=l()?>/search-on-map"><i class="fa fa-circle-thin"></i> <?=l("searchonmap")?></a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


<?php echo html_decode($storage->content); ?>


<div class="Footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="copyRight">&copy; 2017 All Right Reserved</div>
      </div>
      <div class="col-sm-4 text-center">
        <div class="FooterSocial">
          <a href="<?=s("facebook")?>" target="_blank"><i class="fa fa-facebook"></i></a>
          <a href="skype:<?=s("skype")?>?action=chat"><i class="fa fa-skype"></i></a>
          <a href="<?=s("youtube")?>" target="_blank"><i class="fa fa-youtube"></i></a>
        </div>
      </div>
      <div class="col-sm-4 text-right">
        <div class="copyRight">Power By <a href="#">Shindi</a></div>
      </div>
    </div>
  </div>
</div>

      

</body>      
</html>