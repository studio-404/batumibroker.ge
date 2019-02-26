 <?php  
 db_query("UPDATE ".c("table.catalogs")." SET `views`=`views`+1 WHERE id='".$product["id"]."'");
 $p = db_fetch("SELECT 
    `catalogs`.`condition` as condd, 
    `catalogs`.`project` as projj, 
    `catalogs`.`sale` as saleType, 
    `catalogs`.`city` as mycity, 
    (SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=mycity and `catalogs`.`language`='".l()."') as cityx, 
    (SELECT `catalogs`.`title` FROM `".c("table.catalogs")."` WHERE `id`=condd AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."') as conditiontitle, 
    (SELECT `catalogs`.`title` FROM `".c("table.catalogs")."` WHERE `id`=projj AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."') as projecttitle, 
    (SELECT `catalogs`.`title` FROM `".c("table.catalogs")."` WHERE `id`=saleType AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."') as transactionType, 
    (SELECT `site_users`.`id` FROM `site_users` WHERE `site_users`.`active`=1 AND `site_users`.`banned`=0 AND `site_users`.`id`=`catalogs`.`administrator`) as admin_id,  
    `catalogs`.*
    FROM ".c("table.catalogs")." 
    WHERE 
    language = '" . l() . "' AND 
    id='".$product["id"]."' 
    LIMIT 0, 1"
);
$aditional_info = db_fetch_all("SELECT `id`, `title`, `short_description` FROM `".c("table.catalogs")."` WHERE `catalogid`=16 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
?>
<!-- Add Place -->
<div class="modal fade" id="imagePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 10px; top: 10px; z-index:10000;">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body mainImageContainer"> 
      </div>
    </div>
  </div>
</div>


 <div class="container">
    <div class="InsidePageDiv">
        <div class="row MobileRow">
            <div class="col-sm-7">
                <div class="BreadCrumbs">
                    <?php echo location(); ?> 
                </div>
            </div>
        </div>
        

        
        <div class="InsideTopContent">
            <div class="SingleTopDiv">
                <div class="SingleSlider">
                    <div class="SingleSlider slider-for my-gallery">
                        <?php 
                        for ($i=1; $i <= 10; $i++):
                            if(isset($p["photo".$i])){
                                $bigImage = g_image($p["photo".$i], 0, 0);
                                $thumb = g_image($p["photo".$i], 60, 50, false, 25, 7);
                                printf(
                                    "<img data-sgallery='group1' data-full=\"%s\" data-thumb=\"%s\" src=\"%s\" alt=\"\" itemprop=\"thumbnail\" />", 
                                    $bigImage,
                                    $thumb,
                                    g_image($p["photo".$i], 560, 380)
                                );
                            }
                        endfor;
                        ?>
                    </div>
                    <div class="SingleSlider slider-nav">
                        <?php 
                        for ($i=1; $i <= 10; $i++):
                            if(isset($p["photo".$i])){
                                printf("<div><img src=\"%s\"/></div>", g_image($p["photo".$i], 140, 95, 100, 30));
                            }
                        endfor;
                        ?>
                    </div>
                </div>
                <div class="SingleRight">
                    <div class="InsideIDViewDate">
                        <span>ID: <?=$p['id']?></span>
                        <span><?=l('view')?>: <?=$p['views']?></span>
                        <span><?=date("d.m.Y / h:m", (int)$p['date'])?></span>
                    </div>
                    <div class="Icons">
                        <?php if(isset($_SESSION["batumibroker_username"]) || isset($_COOKIE["batumibroker_username"])) : ?>
                        <a href="javascript:void(0)" class="addOrRemoveFavourites" data-productid="<?=$product["id"]?>"><i class="fa fa-heart" style="color:<?=(g_checkiffavourites($product["id"])) ? '#f33f01' : '#8e92a0'?>"></i></a>
                        <?php endif; ?>

                        <?php if(!isset($_SESSION["batumibroker_username"]) && !isset($_COOKIE["batumibroker_username"])) : ?>
                        <a href="#" data-toggle="modal" data-target="#LoginModal"><i class="fa fa-heart"></i></a>
                        <?php endif; ?>

                        <a href="javascript:window.print();"><i class="fa fa-file-pdf-o"></i></a>
                        <?php 
                        $actual_link = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                        ?>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$actual_link?>" target="_blank"><i class="fa fa-share-alt"></i></a>
                    </div>
                    <div class="Location">
                        <i class="fa fa-circle-thin"></i> <?=$p["cityx"]?>
                    </div>
                    <div class="Title"><?=$p["title"]?></div>
                    
                    <div class="priceAndCurrency">
                        <div class="Price"><?=number_format((int)$p["price"], 0, '', ' ')?> <?=($p["currency"]=="GEL") ? '<div class="BPGLARI">A</div>' : '$'?></div>
                        <?php 
                        $squarePrice = ($p["price"]>0 && $p["square"]>0) ? number_format( ((int)$p["price"] / $p["square"]), 2, '.', ' ') : 0;

                        if($p["square"]<=0){
                            $squarePrice = number_format($p["price"], 2, '.', ' ');
                        }
                        ?>
                        <div class="Size">/  1<?=l('kvm')?> - <?=$squarePrice?><?=($p["currency"]=="GEL") ? '<div class="BPGLARI">A</div>' : '$'?></div>
                    </div>

                    <div class="converter">
                        <div class="changeCurrency">
                            <label>$</label>
                            <i class="fa fa-toggle-off"></i>
                            <label><div class="BPGLARI">A</div></label>
                        </div>
                        

                        <script type="text/javascript">
                            var format = "";
                            var currency = parseFloat("<?=s("currencyUsdGel")?>").toFixed(2);
                            var price = parseFloat("<?=$p["price"]?>").toFixed(0);
                            var squire = parseInt("<?=$p["square"]?>");
                            var squarePrice = parseFloat(price / squire).toFixed(2);
                            
                            if(squire<=0 || isNaN(squire)){
                                squarePrice = parseFloat(price).toFixed(2);
                            }
                            $(document).on("click", ".changeCurrency i", function(){
                                if($(this).hasClass("fa-toggle-off")){
                                    var gelPrice = parseFloat(price * currency).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                                    var gelPriceSquare = parseFloat(squarePrice * currency).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                                    format = "<div class=\"Price\">"+gelPrice+" <div class=\"BPGLARI\">A</div></div>";
                                    format += "<div class=\"Size\">/  1<?=l('kvm')?> - "+gelPriceSquare+"<div class=\"BPGLARI\">A</div></div>";
                                    $(this).removeClass("fa-toggle-off").addClass("fa-toggle-on");
                                }else{
                                    format = "<div class=\"Price\">"+price.replace(/\B(?=(\d{3})+(?!\d))/g, " ")+" $</div>";
                                    format += "<div class=\"Size\">/  1<?=l('kvm')?> - "+squarePrice.replace(/\B(?=(\d{3})+(?!\d))/g, " ")+"$</div>";
                                    $(this).removeClass("fa-toggle-on").addClass("fa-toggle-off");
                                }
                                
                                $(".priceAndCurrency").html(format);
                            });
                            

                        </script>
                    </div>


                    <div class="HomeParameter">
                        <li class="type"><span><?=l("TransactionType")?></span><label><?=$p["transactionType"]?></label></li>
                        <?php if(!empty($p["address"]) && $p["address"]!=' ') : ?>
                        <li class="home"><span><?=l("address")?></span><label><?=$p["address"]?></label></li>
                        <?php endif; if(!empty($p["square"]) && $p["square"]!=' ') : ?>
                        <li class="space"><span><?=l("space")?></span><label><?=$p["square"]?> <span><?=l('kvm')?></span></label></li>
                        <?php endif; if(!empty($p["floor"]) && $p["floor"]!=0) : ?>
                        <li class="floor"><span><?=l("floor")?></span><label><?=(int)$p["floor"]?>/<?=(int)$p["floor_all"]?></label></li>
                        <?php endif; if(!empty($p["rooms"]) && $p["rooms"]!=0) : ?>
                        <li class="room"><span><?=l("room")?></span><label><?=(int)$p["rooms"]?></label></li>
                        <?php endif; if(!empty($p["bathrooms"]) && $p["bathrooms"]!=0) : ?>
                        <li class="bathroom"><span><?=l("wetpoint")?></span><label><?=(int)$p["bathrooms"]?></label></li>
                        <?php endif; if(!empty($p["conditiontitle"]) && $p["conditiontitle"]!=' ') : ?>
                        <li class="condition"><span><?=l("condition")?></span><label><?=$p["conditiontitle"]?></label></li>
                        <?php endif; if(!empty($p["projecttitle"]) && $p["projecttitle"]!=' ') : ?>
                        <li class="homeproject"><span><?=l("project")?></span><label><?=$p['projecttitle']?></label></li>
                        <?php endif; if(!empty($p["ceilheight"]) && $p["ceilheight"]>0) : ?>
                        <li class="ceiling"><span><?=l("ceilheight")?></span><label><?=$p['ceilheight']?></label></li>
                        <?php endif; ?>
                    </div>
                    <div class="AddedAdsUserInfo showOnMobile">
                        <div class="row">
                            <div class="col-sm-5 ">
                                <div class="UserImage">
                                    <img src="<?=s('avatar')?>" alt="" />
                                </div>
                                <div class="UserInfo">
                                    <span><?=s("adminname")?></span><br/>
                                    <label><?=s("adminaddress")?></label>
                                </div>
                            </div>
                            <div class="col-sm-3 padding_0">
                                <a href="javascript:void(0)"><?=s("phone1")?></a>
                                <a href="javascript:void(0)"><?=s("phone2")?></a>
                            </div>
                            <div class="col-sm-4 padding_0">
                                <!-- <a href="#"><i class="fa fa-skype"></i> <?=s("skype")?></a> -->
                                <a href="javascript:void(0)"><i class="fa fa-envelope"></i><?=s('email')?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="InsideBottomContent">
            <div class="InfoContent">
                <div class="Title"><?=l('additionalinformation')?></div>
                <div class="MoreParameters">
                    <?php 
                    $aditionalinformation = (isset($p['aditionalinformation']) && $p['aditionalinformation']!="") ? explode(",", $p['aditionalinformation']) : array(); 
                    foreach ($aditional_info as $info): 
                        $IsNot = (is_array($aditionalinformation) && in_array($info["id"], $aditionalinformation)) ? '' : ' IsNot';
                    ?>
                    <li class="icon <?=trim($info["short_description"]).$IsNot?>"><span><?=$info["title"]?></span></li>
                    <?php endforeach; ?>
                </div>
                <div class="Title"><?=l('description')?></div>
                <div class="SingleDescription">
                    <?=strip_tags($p["description"], "<p><span><br><strong><b><a><ul><ol><li>")?>
                </div>
                <div id="SingleMap"></div>
            </div>
            
            <?php 
            $g_lands_forsale = g_homepage_list(9,10);
            $g_lands_forrent = g_homepage_list(10,10);
            $g_lands_gira = g_homepage_list(11,10);
            $g_lands_daily = g_homepage_list(12,10);
            ?>
            
            <div class="TabsContent">
                <div class="TitleTabs"><i class="fa fa-circle-thin"></i> <?=l('lands')?></div>
                <div class="HomeTabsMenu">
                    <select class='TabsSelect TabsSelect1'>
                        <option value='0'><?=l("forsale")?> (<?=$g_lands_forsale["counted"]?>) </option>
                        <option value='1'><?=l("forrent")?> (<?=$g_lands_forrent["counted"]?>)</option>
                        <option value='2'><?=l("mortgage")?> (<?=$g_lands_gira["counted"]?>)</option>
                        <option value='3'><?=l("blog")?> (<?=$g_lands_daily["counted"]?>)</option>
                    </select>
                    <ul class="nav TabsMenu TabsMenu1" role="tablist">
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
    
        </div>
        
        

        
        <div class="SingleSIdebarBanners">
            <div class="SidebarBanners">
                <?php 
                $g_bannerlist = g_bannerlist(28, 3);
                if(!empty($g_bannerlist)){
                    foreach ($g_bannerlist as $value) {
                        echo sprintf(
                            "<div class=\"Banner220x190\" style=\"padding:0\">
                                <a href=\"%s\" target=\"_blank\"><img src=\"%s\" alt=\"\" /></a>
                            </div>",
                            strip_tags($value["itemlink"]),
                            $value["file"]
                        );
                    }
                }else{
                    echo sprintf(
                        "<div class=\"Banner220x190\">Banner 220x190</div>"
                    );
                }
                ?>
                
                <div class="row SmallBannersDiv">
                    <?php 
                    $g_bannerlist2 = g_bannerlist(26, 6);
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
<script>
function initMap() {
    <?php  $coords = (isset($p['map_coordinates'])) ? explode(":", $p['map_coordinates']) : array("41.7063576","44.8042906"); ?>
    var uluru = {lat: <?=$coords[0]?>, lng: <?=$coords[1]?>};
    var catalogid = "<?=$p['catalogid']?>";

    var iconImage = "";
    if(catalogid==7){
        iconImage = "<?=WEBSITE?>/img/icons/binebi.png";
    }else if(catalogid==8){
        iconImage = "<?=WEBSITE?>/img/icons/kerdzosaxlebi.png";
    }else if(catalogid==9){
        iconImage = "<?=WEBSITE?>/img/icons/agarakebi.png";
    }else if(catalogid==10){
        iconImage = "<?=WEBSITE?>/img/icons/miwisnakveTebi.png";
    }else if(catalogid==11){
        iconImage = "<?=WEBSITE?>/img/icons/komerciuli.png";
    }else if(catalogid==20){
        iconImage = "<?=WEBSITE?>/img/icons/sastumroebi.png";
    }

    var map = new google.maps.Map(document.getElementById('SingleMap'), {
      zoom: 16,
      center: uluru
    });
    var marker = new google.maps.Marker({
      position: uluru,
      map: map, 
      icon: iconImage
    });
}
$("body").addClass("SingleBodyClass");
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRfxE_YhbYvFodzMKSPz0s4OQ7l3uukMw&amp;callback=initMap"></script>