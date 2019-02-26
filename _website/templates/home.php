<?php defined('DIR') OR exit; ?>

<div class="HomeItemSlider">
	<?=g_slider()?>
</div>



<?php echo g_search(false); ?>


<div class="container">
	<div class="RegionsDiv row">
		<?=g_destinations()?> 
	</div>	
</div>






<div class="container-fluid padding_0">
	<div class="HomeBottomDiv">
		<div class="container">
			<div class="HomeADSSlider row">
				<div class="AdsCategoryTitle"><i class="fa fa-star" aria-hidden="true"></i> VIP <?=l("ads")?></div>
				<div class="HomeDivForSlider">	
					<?=g_vip()?>			
				</div>
			</div>			
		</div>	
	</div>	
</div>

<?php 
$g_flats_forsale = g_homepage_list(9,7);
$g_flats_forrent = g_homepage_list(10,7);
$g_flats_gira = g_homepage_list(11,7);
$g_flats_daily = g_homepage_list(309,7);
?>
<div class="container-fluid padding_0">
	<div class="HomeBottomADS">
		<div class="container">
			<div class="DivWidth80 TabsContent">
				<div class="TitleTabs"><i class="fa fa-circle-thin"></i> <?=l("flats")?></div>
				<div class="HomeTabsMenu">
					<select class='TabsSelect TabsSelect1'>
						<option value='0'><?=l("forsale")?> (<?=$g_flats_forsale["counted"]?>) </option>
						<option value='1'><?=l("forrent")?> (<?=$g_flats_forrent["counted"]?>)</option>
						<option value='2'><?=l("mortgage")?> (<?=$g_flats_gira["counted"]?>)</option>
						<option value='3'><?=l("blog")?> (<?=$g_flats_daily["counted"]?>)</option>
					</select>
					<ul class="nav TabsMenu TabsMenu1" role="tablist">
						<li role="presentation" class="active"><a href="#HomeTab1" aria-controls="HomeTab1" role="tab" data-toggle="tab"><?=l("forsale")?> (<?=$g_flats_forsale["counted"]?>) </a></li>  
						<li role="presentation"><a href="#HomeTab2" aria-controls="HomeTab2" role="tab" data-toggle="tab"><?=l("forrent")?> (<?=$g_flats_forrent["counted"]?>)</a></li>  
						<li role="presentation"><a href="#HomeTab3" aria-controls="HomeTab3" role="tab" data-toggle="tab"><?=l("mortgage")?> (<?=$g_flats_gira["counted"]?>)</a></li>  
						<li role="presentation"><a href="#HomeTab4" aria-controls="HomeTab4" role="tab" data-toggle="tab"><?=l("blog")?> (<?=$g_flats_daily["counted"]?>)</a></li>
					</ul>	
				</div>
				
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="HomeTab1">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_flats_forsale["html"]?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="HomeTab2">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_flats_forrent["html"]?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="HomeTab3">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_flats_gira["html"]?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="HomeTab4">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_flats_daily["html"]?>
							</div>
						</div>
					</div>
				</div>	


				<div class="TabsContent">
					<?php 
					$g_bannerlist = g_bannerlist(29);
					if(!empty($g_bannerlist)){
						foreach ($g_bannerlist as $value) {
							echo sprintf(
								"<div class=\"Banner920\" style=\"padding:0\">
									<a href=\"%s\" target=\"_blank\"><img src=\"%s\" alt=\"\" /></a>
								</div>",
								strip_tags($value["itemlink"]),
								$value["file"]
							);
						}
					}else{
						echo sprintf(
							"<div class=\"Banner920\"><span>%s 920x90</span></div>",
							l("banner")
						);
					}
					?>					
				</div>

<?php 
$g_lands_forsale = g_homepage_list(9,10);
$g_lands_forrent = g_homepage_list(10,10);
$g_lands_gira = g_homepage_list(11,10);
$g_lands_daily = g_homepage_list(12,10); //309
?>				
				<div class="TitleTabs"><i class="fa fa-circle-thin"></i> <?=l("lands")?></div>
				<div class="HomeTabsMenu">
					<select class='TabsSelect TabsSelect2'>
						<option value='0'><?=l("forsale")?> (<?=$g_lands_forsale["counted"]?>) </option>
						<option value='1'><?=l("forrent")?> (<?=$g_lands_forrent["counted"]?>)</option>
						<option value='2'><?=l("mortgage")?> (<?=$g_lands_gira["counted"]?>)</option>
						<option value='3'><?=l("blog")?> (<?=$g_lands_daily["counted"]?>)</option>
					</select>
					<ul class="nav TabsMenu TabsMenu2" role="tablist">
						<li role="presentation" class="active"><a href="#HomeTab5" aria-controls="HomeTab5" role="tab" data-toggle="tab"><?=l("forsale")?> (<?=$g_lands_forsale["counted"]?>) </a></li>  
						<li role="presentation"><a href="#HomeTab6" aria-controls="HomeTab6" role="tab" data-toggle="tab"><?=l("forrent")?> (<?=$g_lands_forrent["counted"]?>)</a></li>  
						<li role="presentation"><a href="#HomeTab7" aria-controls="HomeTab7" role="tab" data-toggle="tab"><?=l("mortgage")?> (<?=$g_lands_gira["counted"]?>)</a></li>  
						<li role="presentation"><a href="#HomeTab8" aria-controls="HomeTab8" role="tab" data-toggle="tab"><?=l("blog")?> (<?=$g_lands_daily["counted"]?>)</a></li>
					</ul>	
				</div>
				
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="HomeTab5">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_lands_forsale["html"]?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="HomeTab6">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_lands_forrent["html"]?>
							</div>
						</div>	
					</div>
					<div role="tabpanel" class="tab-pane" id="HomeTab7">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_lands_gira["html"]?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="HomeTab8">
						<div class="HomeBottomADSContent">
							<div class="row">
								<?=$g_lands_daily["html"]?>
							</div>
						</div>
					</div>
				</div>				
			</div>
			
 
 
 
 
			<div class="HomeSidebarBanners">
				<div class="SidebarBanners">
					<div class="row SmallBannersDiv">
						<?php 

						$g_bannerlist2 = g_bannerlist(26);
						if(!empty($g_bannerlist2)){
							foreach ($g_bannerlist2 as $value) {
								echo sprintf(
									"<div class=\"Banner106x90\" style=\"padding:0\">
										<a href=\"%s\" target=\"_blank\"><img src=\"%s\" alt=\"\" /></a>
									</div>",
									strip_tags($value["itemlink"]),
									$value["file"]
								);
							}
						}else{
							echo sprintf(
								"<div class=\"Banner106x90\">106 X 90</div>"
							);
						}
						?>						
					</div>			
				</div>
			</div>
			
 
			
			
			
		</div>
	</div>
</div>	