<?php defined('DIR') OR exit;
// $message = '';
// if (post('contact_form_perform') !== FALSE)
// {
// 	if (!empty($_SESSION[CAPTCHA_SESSION_ID]) && strtoupper($_POST['captchaEnteredCode']) == strtoupper($_SESSION[CAPTCHA_SESSION_ID])) {
// 		$message =  post('message') . '<br />' . 
// 					post('name') . '<br />' . 
// 					post('email') . '<br />' . 
// 					post('subject') . '<br />' ; 
// 		if (email(post('email'), s('feedback'), 'Message from  website',$message))
// 			$message = l('contact.sent');
// 		else
// 			$message = l('contact.not_sent');
// 	} else {
// 		$message = 'Incorrect Captcha Code';
// 	}
// }
?>
<div class="container">
   <div class="ContactPageDiv">
      <div class="row">
         <div class="col-sm-12">
            <div class="BreadCrumbs">
               <li><a href="<?=href().l()?>/home"><?=l("home")?></a><span>></span></li>
               <li><a href="/<?=l()?>/contact"><?=$title?></a></li>
            </div>
         </div>
      </div>
      
      <div class="ContactROWS">
         <div class="row">
            <div class="col-sm-6">
               <div class="ContactLeftDiv">
                  <div class="Title"><?=l('contactdata')?></div>
                  <div class="ContactList">
                     <li class="padding"><?=l("workinghours")?>: <span><?=s("workinghours")?></span></li>
                     <li class="padding"><?=l("mobile")?>: <span><?=s("phone1")?>; <?=s("phone2")?></span></li>
                     <li class="padding"><?=l("phoneemail")?>: <span><?=s("email")?></span></li>
                     <li class="padding"><?=l("address")?>: <span><?=s("adminaddress")?></span></li>
                  </div>
                  <div class="contactMap" id="contactMap">
                     google map
                  </div>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="ContactRightDiv">
                  <div class="Title"><?=l("sendmessage")?></div>
                  <div class="ContactForm row">
                     <div class="form-group col-sm-12 alert-danger-contactmessage-box" style="display: none">
                        <div class="alert alert-danger" role="alert" style="margin-bottom:0">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span>&nbsp;</span>
                        </div>
                     </div>
                     <div class="form-group col-sm-12">
                        <input type="text" class="InpucClass1 contact-email" placeholder="<?=l("phoneemail")?>"/>
                     </div>
                     <div class="form-group col-sm-12">
                        <input type="text" class="InpucClass1 contact-subject" placeholder="<?=l("subject")?>"/>
                     </div>
                     <div class="form-group col-sm-12">
                        <textarea class="InpucClass1 contact-message" placeholder="<?=l("message")?>"></textarea>
                     </div>
                     <div class="col-sm-12">
                        <button class="ButtonBlue contactButton"><?=l("sendmessage")?></button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
   </div>
</div>
<script>
function initMap() {
   <?php $maps = @explode(",", s("maps")); ?>
   var uluru = {lat: <?=$maps[0]?>, lng: <?=$maps[1]?> };
   var map = new google.maps.Map(document.getElementById('contactMap'), {
      zoom: 16,
      center: uluru
   });
   var marker = new google.maps.Marker({
     position: uluru,
     map: map
   });
}
$("body").addClass("SingleBodyClass");
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRfxE_YhbYvFodzMKSPz0s4OQ7l3uukMw&amp;callback=initMap"></script>