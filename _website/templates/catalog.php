<?php 
defined('DIR') OR exit; 
$counts = (isset($items[0]["count"]) && !empty($items[0]["count"])) ? $items[0]["count"] : 0;
echo g_search($catalogid, $counts);
?>
 
<div class="container-fluid padding_0">
    <div class="SearchPageDiv">
        <div class="container">
  
                <div class="SearchPage">
                    <?php 
                    $x = 0;
                    if(isset($items) && !empty($items)):
                    foreach($items as $item): 
                        $vipStat = "";
                        $link=href($id);
                        $x++;

                        if($item['supervip']==1){
                            $vipStat = sprintf("<i class=\"fa fa-star\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"%s\"></i>", l('supervipstat'));
                        }else if($item['vip']==1){
                            $vipStat = sprintf("<i class=\"fa fa-star\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"%s\"></i>", l('vipstat'));
                        }

                        $squarePrice = ($item["price"]>0 && $item["square"]>0) ? number_format( ((int)$item["price"] / $item["square"]), 2, '.', ' ') : 0;

                        if($item["square"]<=0){
                            $squarePrice = number_format($item["price"], 2, '.', ' ');
                        }
                    ?>
                        <div class="SaerchItem SuperVip">
                            <div class="Image">
                                <a href="<?php echo href(($id), array(), l(), $item['id']);?>">
                                    <img src="<?php echo g_image($item["photo1"], 210, 150); ?>" />
                                </a>
                            </div>
                            <div class="Info1">
                                <div class="Title">
                                    <a href="<?php echo href(($id), array(), l(), $item['id']);?>" style="color: #000000"><?php echo $item["title"]; ?> <?=$vipStat?></a>
                                </div>
                                <div class="priceAndCurrency" style="display: inline-block;">
                                    <div class="Price price<?=$item['id']?>">
                                        <?=number_format((int)$item["price"], 0, '', ' ')?> <?=($item["currency"]=="GEL") ? '<span class="BPGLARI">A</span>' : '$'?>
                                        <span class="Size">/  1<?=l('kvm')?>  - <?=$squarePrice?> <?=($item["currency"]=="GEL") ? '<span class="BPGLARI">A</span>' : '$'?></span>
                                    </div>

                                </div>

                                <div class="converter" style="display: inline-block; padding-left: 20px;">
                                    <div class="changeCurrency currency<?=$item['id']?>" data-cur="USD" onclick="changeCurrency('price<?=$item['id']?>', 'currency<?=$item['id']?>', '<?=$item["price"]?>', '<?=$item["square"]?>')">
                                        <label>$</label>
                                        <i class="fa fa-toggle-off"></i>
                                        <label><div class="BPGLARI">A</div></label>
                                    </div>
                                </div>
                                
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
                                            <a href="<?php echo href(($id), array(), l(), $item['id']);?>" style="padding-left: 0"><?=s("phone1")?></a>
                                            <a href="<?php echo href(($id), array(), l(), $item['id']);?>" style="padding-left: 0"><?=s("phone2")?></a>
                                        </div>
                                        <div class="col-sm-12 padding_0">
                                            <a href="<?php echo href(($id), array(), l(), $item['id']);?>" style="padding-left: 0"><i class="fa fa-list-ol"></i> <?=$item['id']?></a>
                                            <a href="<?php echo href(($id), array(), l(), $item['id']);?>" style="padding-left: 0"><i class="fa fa-eye"></i> <?=$item["views"]?></a>
                                            <!-- <a href="#"><i class="fa fa-skype"></i> <?=s("skype")?></a> -->
                                            <!-- <a href="#"><i class="fa fa-envelope"></i><?=l('sendmessage')?></a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; endif; ?>
                    
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
                    
                    <div class="Pagination"> 
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <?php 
                                if(isset($items[0]["count"])):
                                echo g_pagination((int)$items[0]["count"], $per_page);
                                endif;
                                ?>
                            </div>
                        </div>                      
                    </div>                   
                    
                </div>
  
  
                <div class="SidebarBanners">
                    <div class="row SmallBannersDiv">
                        <?php 
                        $g_bannerlist2 = g_bannerlist(27);
                        if(!empty($g_bannerlist2)){
                            foreach ($g_bannerlist2 as $value) {
                                echo sprintf(
                                    "<div class=\"Banner220x350\" style=\"padding:0\">
                                        <a href=\"%s\" target=\"_blank\"><img src=\"%s\" alt=\"\" /></a>
                                    </div>",
                                    strip_tags($value["itemlink"]),
                                    $value["file"]
                                );
                            }
                        }else{
                            echo sprintf(
                                "<div class=\"Banner220x350\">220 X 350</div>"
                            );
                        }
                        ?>

                        <?php 
                        $g_bannerlist3 = g_bannerlist(26, 4);
                        if(!empty($g_bannerlist3)){
                            foreach ($g_bannerlist3 as $value) {
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
$("body").addClass("SingleBodyClass");
function changeCurrency(priceContainer, currencyContainer, price, squire){
    var DOLL_OR_GELL = ($("."+currencyContainer).attr("data-cur")=="USD") ? "USD" : "GEL";
    var format = "";
    var currency = parseFloat("<?=s("currencyUsdGel")?>").toFixed(2);
    var squarePrice = parseFloat(price / squire).toFixed(2);
     
    if(squire<=0){
        squarePrice = parseFloat(price).toFixed(2);
    }

    if(DOLL_OR_GELL=="USD"){
        var gelPrice = parseFloat(price * currency).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        var gelPriceSquare = parseFloat(squarePrice * currency).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        format = gelPrice+" <div class=\"BPGLARI\">A</div>";
        format += "<span class=\"Size\">/  1კვ.მ - "+gelPriceSquare+"<span class=\"BPGLARI\">A</span></span>";
        $("."+currencyContainer+" i").removeClass("fa-toggle-off").addClass("fa-toggle-on");
        $("."+currencyContainer).attr("data-cur", "GEL");
    }else{
        format = price.replace(/\B(?=(\d{3})+(?!\d))/g, " ")+" $";
        format += "<span class=\"Size\">/  1კვ.მ - "+squarePrice.replace(/\B(?=(\d{3})+(?!\d))/g, " ")+"$</span>";
        $("."+currencyContainer+" i").removeClass("fa-toggle-on").addClass("fa-toggle-off");
        $("."+currencyContainer).attr("data-cur", "USD");
    }

    $(".priceAndCurrency ."+priceContainer).html(format);
}                       
</script>

