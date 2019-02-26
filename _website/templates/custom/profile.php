<?php 
if(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"])){
	echo "<meta http-equiv=\"refresh\" content=\"0; url=".WEBSITE_BASE."\" />";
	exit();
}
g_logoupload();
$userinfo = g_userinfo();
?>
<!-- Add Place -->
<div class="modal fade" id="AddPlacePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body">
        <?=g_add_statement_form(40);?>
      </div>
    </div>
  </div>
</div>





<!-- Balance -->
<div class="modal fade" id="AddBalance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content"> 
      <div class="modal-body">
        <div class="ModalBodyDiv">
          <div class="ModalTitle">ბალანსის შევსება
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="ModalContactDiv">
            <div class="row">
              <div class="form-group col-sm-12">
                <input type="text" class="InpucClass1" placeholder="შეიყვანეთ თანხა"/>
              </div>              
              <div class="form-group col-sm-12">
                <button class="ButtonBlue">გაგრძელება</button>
              </div>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<div class="container">
	<div class="UserPageDiv">
		<div class="row">
			<div class="col-sm-12">
				<div class="BreadCrumbs">
					<?php echo location(); ?>
				</div>
			</div>
		</div>
		
		<div class="UserPage"> 	   
			<div class="UserLeftDiv">
				<div class="UserInfo">
					<div class="UserImage" title="<?=l("uploadimage")?>">
						<?php 
						$image = (!empty($userinfo["avatar"])) ? explode(WEBSITE_BASE, $userinfo["avatar"]) : "";
						$image = (isset($image[1]) && file_exists($image[1])) ? $userinfo["avatar"] : WEBSITE."/img/dummy_user.png";
						?>
						<img src="<?=$image?>" alt="Avatar" />
					</div>
					<form action="" id="logoUpload" method="post" enctype="multipart/form-data" style="position:absolute; visibility:hidden">
							<input type="file" name="logoUploadInput" id="logoUploadInput" value="" />
					</form>
					<div class="Info">
						<span><?=$userinfo["firstname"]?></span><br/>
						<label>ID <span><?=$userinfo["id"]?></span></label>
					</div>
				</div>
				<div class="UserMenu">
					<li class="<?=((isset($_GET["view"]) && $_GET["view"]=="edit") || !isset($_GET["view"])) ? 'active' : ''?>">
						<a href="/<?=l()?>/profile?view=edit">
							<i class="fa fa-user-circle"></i>
							<?=l("editprofile")?>
						</a>
					</li>
					<li>
						<a href="#" class="ModalAddPlacePopup">
							<i class="fa fa-plus-square-o"></i>
							<?=l("addstats")?>
						</a>
					</li>
					<li class="<?=(isset($_GET["view"]) && $_GET["view"]=="myadds") ? 'active' : ''?>">
						<a href="/<?=l()?>/profile?view=myadds">
							<i class="fa fa-list-ul"></i>
							<?=l("mystats")?>
						</a>
					</li>
					<li class="<?=(isset($_GET["view"]) && $_GET["view"]=="favourites") ? 'active' : ''?>">
						<a href="/<?=l()?>/profile?view=favourites">
							<i class="fa fa-heart-o"></i>
							<?=l("myfavourites")?> (<?=g_countfavourites()?>)
						</a>
					</li>
					
					<li>
						<a href="javascript:void(0)" data-toggle="modal" data-target="#AddBalance" data-dismiss="modal">
							<i class="fa fa-usd"></i>
							<?=l("fillbalance")?>
						</a>
					</li>
					<li class="<?=(isset($_GET["view"]) && $_GET["view"]=="changepassword") ? 'active' : ''?>">
						<a href="/<?=l()?>/profile?view=changepassword">
							<i class="fa fa-key"></i>
							<?=l("changepassword")?>
						</a>
					</li>

		            <li><a href="javascript:void(0)" class="signout"><i class="fa fa-sign-out" aria-hidden="true"></i> <?=l("signout")?></a></li>
		          
				</div>
			</div>
		
			<div class="UserContent">				
						
				<!--////////////////////////   Profile Page   //////////////////////////////////-->
				<?php if( (isset($_GET["view"]) && $_GET["view"]=="edit") || !isset($_GET["view"])) : ?>

				<div class="UserProfilePage">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="form-group alert-danger-profileedit-box" style="display: none">
								<div class="alert alert-danger" role="alert" style="margin-bottom:0">
								<i class="fa fa-info-circle" aria-hidden="true"></i>
								<span>&nbsp;</span>
								</div>
				            </div>
							<div class="form-group<?=($userinfo["active"]!=1) ? ' ErrorValidation' : ''?>">
								<input type="text" class="InpucClass1" value="<?=$userinfo["username"]?>" placeholder="<?=l("username")?>" readonly="readonly" />
								<?=($userinfo["active"]!=1) ? '<div class="InputErrorMessage"><a href="javascript:void(0)" class="sendverificationcode">'.l("sendverificationcode").'</a></div>' : ''?>
							</div>
							<?php if($userinfo["active"]!=1): ?>
							<div class="form-group verification_box">
								<input type="text" class="InpucClass1" id="verification_code" value="" placeholder="<?=l("verificationcode")?>" />
							</div>
							<div style="margin-bottom: 20px;">
								<button class="ButtonBlue verification_button"><?=l("verification")?></button>
							</div>
							<?php endif; ?>



							<div class="form-group firstname-box"> <!-- ErrorValidation -->
								<input type="text" class="InpucClass1 firstname-input" value="<?=$userinfo["firstname"]?>" placeholder="<?=l("firstname")?>" />
							</div>
							<div class="form-group personalid-box">
								<input type="text" class="InpucClass1 personalid-input" value="<?=$userinfo["personalid"]?>" placeholder="<?=l("personalnumber")?>" />
							</div>

							<div class="form-group companyname-box">
								<input type="text" class="InpucClass1 companyname-input" value="<?=$userinfo["companyname"]?>" placeholder="<?=l("companyname")?>" />
							</div>

							<div class="form-group address-box">
								<input type="text" class="InpucClass1 address-input" value="<?=$userinfo["address"]?>" placeholder="<?=l("address")?>" />
							</div>

							<div class="form-group mobile-box">
								<input type="text" class="InpucClass1 mobile-input" value="<?=$userinfo["mobile"]?>" placeholder="<?=l("mobile")?>" />
							</div>

							<div class="form-group skype-box">
								<input type="text" class="InpucClass1 skype-input" value="<?=$userinfo["skype"]?>" placeholder="Skype" />
							</div>

							<div class="">
								<button class="ButtonBlue editinputButton"><?=l("edit")?></button>
							</div>
						</div>
						<div class="col-sm-3"></div>
					</div>
				</div>
				<?php endif; ?>

				<?php if(isset($_GET["view"]) && $_GET["view"]=="myadds") : ?>
				<div class="UserPageAds">					
					<?php
					$items = g_myadds();
					if($items):
						foreach ($items as $item) :
						$vipStat = ($item['supervip']==1) ? sprintf("<i class=\"fa fa-star\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"%s\"></i>", l('supervipstat')) : ''; // 
                        $vipStat = ($item['vip']==1) ? sprintf("<i class=\"fa fa-star\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"%s\"></i>", l('vipstat')) : $vipStat; // 
                        $squarePrice = ($item["price"]>0 && $item["square"]) ? number_format( ((int)$item["price"] / $item["square"]), 2, '.', ' ') : 0;
                        $main_class = "";
                        if($item['supervip']==1){
                        	$main_class = " SuperVip";
                        }else if($item['vip']==1){
                        	$main_class = " VIP";
                        }
					?>
					<div class="SaerchItem<?=$main_class?>" style="<?=($item["visibility"]=="false") ? 'border: solid #ff0000 5px;' : ''?>">
						<div class="SearchItemHover">
							<ul>
								<?php
								if($item["visibility"]=="false"){
									?>
									<a href="javascript:void(0)" data-title="<?=l('message')?>" data-text="<?=l('waitingfor')?>" data-footerCloseText="<?=l('close')?>" class="waitingfor">
									<?php
								}else{
									?>
									<a href="/<?=l()?>/<?=$item["slugx"]?>/<?=str_replace(" ","-",utf82lat($item["title"]))?>/<?=$item["id"]?>" target="_blank">
									<?php
								}
								?>
									<i class="fa fa-eye"></i>
									<?=l("view")?>
								</a> 
								<span>|</span>
								<a href="javascript:void(0)" data-productid="<?=$item["id"]?>" data-title="<?=l('message')?>" data-text="<?=l('wouldyoulikedelete')?>" data-footerCloseText="<?=l('close')?>" data-footerActionText="<?=l('delete')?>" class="removeMyAdds">
									<i class="fa fa-times-circle"></i>
									<?=l("delete")?>
								</a>
							</ul>
						</div>
						<div class="Image">
							<img src="<?=$item["photo1"]?>" alt="" />
						</div>
						<div class="Info1">
							<div class="Title"><?=$item["title"]?> <?=$vipStat?></div>
							<div class="Price"><?=$item["price"]?> <?=($item["currency"]=="GEL") ? '<div class="BPGLARI">A</div>' : '$'?></div>
							<div class="Size">/  1<?=l('kvm')?>  - <?=$squarePrice?> <?=($item["currency"]=="GEL") ? '<div class="BPGLARI">A</div>' : '$'?></div>
							<div class="HomeParameter">
								<?php if(!empty($item["square"]) && $item["square"]!=0) : ?>
								<li class="space"><span><?=l("space")?></span><label><?=$item["square"]?> <span><?=l('kvm')?></span></label></li>
                                <?php endif; if(!empty($item["floor"]) && $item["floor"]!=0) : ?>
                                <li class="floor"><span><?=l("floor")?></span><label><?=(int)$item["floor"]?>/<?=(int)$item["floor_all"]?></label></li>
                                <?php endif; if(!empty($item["rooms"]) && $item["rooms"]!=0) : ?>
                                <li class="room"><span><?=l("room")?></span><label><?=(int)$item["rooms"]?></label></li>
                            	<?php endif; ?>
							</div>
						</div>
						<div class="Info2">
							<div class="AddedAdsUserInfo">
								<div class="row">
									<div class="col-sm-12 padding_0">
										<div class="UserImage">
											<img src="<?=$item["admin_avatar"]?>" alt="" />
										</div>
										<div class="UserInfo">
											<span><?=s("adminname")?></span><br/>
                                            <label><?=s("adminaddress")?></label>
										</div>
									</div>
									<div class="col-sm-12 padding_0">
										<a href="#"><?=s("phone1")?></a>
                                        <a href="#"><?=s("phone2")?></a>
									</div>
									<div class="col-sm-12 padding_0">
										 <a href="#"><i class="fa fa-skype"></i> <?=s("skype")?></a>
                                         <a href="#"><i class="fa fa-envelope"></i><?=l('sendmessage')?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<!--////////////////////////   Profile password change   //////////////////////////////////-->
				<?php if( isset($_GET["view"]) && $_GET["view"]=="changepassword") : ?>
				<div class="UserProfilePage">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="form-group alert-danger-profileeditpassword-box" style="display: none">
								<div class="alert alert-danger" role="alert" style="margin-bottom:0">
								<i class="fa fa-info-circle" aria-hidden="true"></i>
								<span>&nbsp;</span>
								</div>
				            </div>

							<div class="form-group currentpassword-box"> <!-- ErrorValidation -->
								<input type="password" class="InpucClass1 currentpassword-input" value="" placeholder="<?=l("password")?>" />
							</div>
							<div class="form-group newpassword-box"> <!-- ErrorValidation -->
								<input type="password" class="InpucClass1 newpassword-input" value="" placeholder="<?=l("newpassword")?>" />
							</div>
							<div class="form-group rnewpassword-box"> <!-- ErrorValidation -->
								<input type="password" class="InpucClass1 rnewpassword-input" value="" placeholder="<?=l("rpassword")?>" />
							</div>
							<div class="">
								<button class="ButtonBlue editpasswordButton"><?=l("changepassword")?></button>
							</div>

						</div>
						<div class="col-sm-3"></div>
					</div>
				</div>
				<?php endif; ?>


				<!--////////////////////////   Profile favourites   //////////////////////////////////-->
				<?php if( isset($_GET["view"]) && $_GET["view"]=="favourites") : ?>
				<div class="UserPageAds">					
					<?php
					$items = g_myfavourites();
					if($items):
						foreach ($items as $item) :
						$vipStat = ($item['supervip']==1) ? sprintf("<i class=\"fa fa-star\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"%s\"></i>", l('supervipstat')) : ''; // 
                        $vipStat = ($item['vip']==1) ? sprintf("<i class=\"fa fa-star\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"%s\"></i>", l('vipstat')) : $vipStat; // 
                        $squarePrice = ($item["price"]>0 && is_numeric($item["square"]) && $item["square"]>0) ? number_format( ((int)$item["price"] / $item["square"]), 2, '.', ' ') : 0;
                        $main_class = "";
                        if($item['supervip']==1){
                        	$main_class = " SuperVip";
                        }else if($item['vip']==1){
                        	$main_class = " VIP";
                        }
					?>
					<div class="SaerchItem<?=$main_class?>">
						<div class="SearchItemHover">
							<ul>
								<a href="/<?=l()?>/<?=$item["slugx"]?>/<?=str_replace(" ","-",utf82lat($item["title"]))?>/<?=$item["id"]?>" target="_blank">
									<i class="fa fa-eye"></i>
									<?=l("view")?>
								</a> 
								<span>|</span>
								<a href="javascript:void(0)" data-productid="<?=$item["id"]?>" data-title="<?=l('message')?>" data-text="<?=l('wouldyoulikedelete')?>" data-footerCloseText="<?=l('close')?>" data-footerActionText="<?=l('delete')?>" class="removeFavourite">
									<i class="fa fa-times-circle"></i>
									<?=l("delete")?>
								</a>
							</ul>
						</div>
						<div class="Image">
							<img src="<?=$item["photo1"]?>" alt="" />
						</div>
						<div class="Info1">
							<div class="Title"><?=$item["title"]?> <?=$vipStat?></div>
							<div class="Price"><?=$item["price"]?> <?=($item["currency"]=="GEL") ? '<div class="BPGLARI">A</div>' : '$'?></div>
							<div class="Size">/  1<?=l('kvm')?>  - <?=$squarePrice?> <?=($item["currency"]=="GEL") ? '<div class="BPGLARI">A</div>' : '$'?></div>
							<div class="HomeParameter">
								<?php if(!empty($item["square"]) && $item["square"]!=0) : ?>
								<li class="space"><span><?=l("space")?></span><label><?=$item["square"]?> <span><?=l('kvm')?></span></label></li>
                                <?php endif; if(!empty($item["floor"]) && $item["floor"]!=0) : ?>
                                <li class="floor"><span><?=l("floor")?></span><label><?=(int)$item["floor"]?>/<?=(int)$item["floor_all"]?></label></li>
                                <?php endif; if(!empty($item["rooms"]) && $item["rooms"]!=0) : ?>
                                <li class="room"><span><?=l("room")?></span><label><?=(int)$item["rooms"]?></label></li>
                            	<?php endif; ?>
							</div>
						</div>
						<div class="Info2">
							<div class="AddedAdsUserInfo">
								<div class="row">
									<div class="col-sm-12 padding_0">
										<div class="UserImage">
											<img src="<?=$item["admin_avatar"]?>" alt="" />
										</div>
										<div class="UserInfo">
											<span><?=s("adminname")?></span><br/>
                                            <label><?=s("adminaddress")?></label>
										</div>
									</div>
									<div class="col-sm-12 padding_0">
										<a href="#"><?=s("phone1")?></a>
                                        <a href="#"><?=s("phone2")?></a>
									</div>
									<div class="col-sm-12 padding_0">
										<a><i class="fa fa-list-ol"></i> <?=$item['id']?></a>
										<a href="/<?=l()?>/<?=$item["slugx"]?>/<?=str_replace(" ","-",utf82lat($item["title"]))?>/<?=$item["id"]?>"><i class="fa fa-eye"></i> <?=$item["views"]?></a>
										<!-- <a href="#"><i class="fa fa-skype"></i> <?=s("skype")?></a> -->
                                        <!-- <a href="#"><i class="fa fa-envelope"></i><?=l('sendmessage')?></a> -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>


						
				
			</div>				 
		</div>
		
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRfxE_YhbYvFodzMKSPz0s4OQ7l3uukMw"></script>
<script>
	$(document).on('click', '.ModalAddPlacePopup', function(e) {
		e.preventDefault(); 
		$("#AddPlacePopup").modal("show");        
    });

    $(document).on('click', '.changeCurrencyx', function(e) {
		e.preventDefault(); 
		var stat_currency = $("#stat_currency").val();
		if(stat_currency=="GEL"){
			$("#stat_currency").val("USD");
			$(".currencyButton").html("$");
			$(this).html("<div class=\"BPGLARI\">A</div>");
		}else{
			$("#stat_currency").val("GEL");
			$(".currencyButton").html("<div class=\"BPGLARI\">A</div>");
			$(this).html("$");
		}
    });

    var ix = 0;
    $(document).on("change", "#fileUploadStats", function(e){
		e.stopPropagation();
		e.preventDefault();
		var input_lang = $("#input_lang").val();
		var files = e.target.files;
		var counts = $(".UploadedImages .item").length;

		if(files.length >= 2){ alert("Multiple file not allowed!"); }
		else if(counts>=10){ alert("Too much images"); }
		else{
			var file = files[0];

			var fileName = file.name;
			var ex = fileName.split(".");
			var extLast = ex[ex.length - 1].toLowerCase();

			xhrUpload(ix, file);
		}

		var append = '<div class="item" id="fx'+ix+'">';
		append += '<img src="'+URL.createObjectURL(file)+'" alt="" />';
		append += '<div class="delete deleteImage" data-ext="'+extLast+'" data-imageid="fx'+ix+'"><i class="fa fa-times"></i></div>';
		append += '</div>';

		$(".UploadedImages").append(append);
		ix++;
    	
    });

    $(document).on("click", ".deleteImage", function(){
    	var input_lang = $("#input_lang").val();
    	var imageid = $(this).attr("data-imageid");
    	var justID = imageid.split("fx");
    	console.log(justID);
    	var ext = $(this).attr("data-ext");

    	$.ajax({
			type: "POST",
			url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
			data: { type:"removeImage", imageid:justID[1], ext:ext } 
		}).done(function( msg ) {
			$("#"+imageid).remove();
		});    	
    });

	$('#AddPlacePopup').on('shown.bs.modal', function () {
		var myLatlng = new google.maps.LatLng(41.7268374, 44.7703052);
		var myOptions = {
			center: myLatlng,
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("SingleMap"), myOptions);

		var marker = new google.maps.Marker({
		    position: myLatlng, 
		    map: map, // handle of the map 
		    draggable:true
		});

		google.maps.event.trigger(map, "resize");

		google.maps.event.addListener(
		    marker,
		    'drag',
		    function() {
		        document.getElementById('latlng').value = marker.position.lat()+":"+marker.position.lng();
		    }
		);
	});
</script>