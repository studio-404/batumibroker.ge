<?php defined('DIR') || exit;
function treeview ($parid=0, $lang, $link = null, $pl = null) {	// Tree View for Sitemap
	$qry = "SELECT " . c("table.pages") . ".id as dd," . c("table.pages") . ".* FROM " . c("table.pages") . "," . c("table.menus") . " WHERE " . c("table.pages") . ".menuid=" . c("table.menus") . ".id AND " . c("table.pages") . ".language='".$lang."' AND " . c("table.menus") . ".language='".$lang."' AND " . c("table.menus") . ".type='pages' AND " . c("table.pages") . ".visibility='true' AND " . c("table.pages") . ".menuid=1 AND " . c("table.pages") . ".deleted='0' AND " . c("table.pages") . ".masterid='".$parid."' order by position";
	$result = mysql_query($qry) or die (mysql_error());
	if (mysql_num_rows($result)>0) { 
		while($row = mysql_fetch_array($result)) {
			$level = $row["level"];
			$pad = ($level - 1) * 30;
?>
        <li style="margin-left:<?php echo $pad;?>px;"> 
            <a href="<?php echo href($row["dd"]);?>"><?php echo $row["title"];?></a>
        </li>					
<?php 
			treeview ($row["idx"], $lang);
		}
	}
}
?>

    <div id="content" class="fix">
        <div class="page">
            <div class="page-title fix" style="background:#<?php echo ($color2!='') ? $color2 : '00b0dc';?>;">
                <h2><?php echo $title; ?></h2>
                <div id="location">
                    <ul>
<?php echo location(); ?>
                    </ul>
                </div>
                <!-- #location .right -->
            </div>
            <!-- .page-title fix -->
            <div id="read" class="fix">
                <ul class="sitemap">
                    <?php
                        treeview (0, l());
                    ?>
                </ul>
            </div>
            <!-- #read .fix -->

        </div>
        <!-- .page -->
    </div>
    <!-- #content .fix -->



