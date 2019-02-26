<?php 
$sql = "SELECT 
`catalogs`.*, 
(SELECT count(`id`) FROM `catalogs` WHERE `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "' AND `catalogid` IN(7,8,9,10,11,20)) as count, 
(SELECT `site_users`.`avatar` FROM `site_users` WHERE `site_users`.`active`=1 AND `site_users`.`banned`=0 AND `site_users`.`id`=1) as admin_avatar, 
(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."' and `pages`.`deleted`=0) as slugx 
FROM 
`catalogs` 
WHERE 
`deleted`=0 AND 
`visibility`='true' AND 
`catalogid` IN(7,8,9,10,11,20) AND 
`language` = '" . l() . "'
ORDER BY `position` ASC;";
$items = db_fetch_all($sql);

$sql = "SELECT id, title, attached FROM " . c("table.pages") . " WHERE id!=1 AND language = '" . l() . "' AND   menuid = 1 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position asc;"; 
$category = db_fetch_all($sql);

// echo "<pre>";
// print_r($items);
// echo "</pre>";
?>
 

<div id="map" style="width:100%;"></div>
<div class="map-search">
	<div class="title">ძიება</div>
	<form action="" method="" class="mapForm">
		<?php 
		foreach($category as $cat) :
		$attached = explode("catalog", $cat["attached"]);
		?>
		<div class="item">
			<input type="checkbox" id="chk<?=$cat["id"]?>" class="mapsearchcheck" data-id="<?=$attached[1]?>" value="1" checked="checked" />
			<label for="chk<?=$cat["id"]?>"><?=$cat["title"]?></label>
		</div>
		<?php endforeach; ?>
	</form>
</div>
<script>
	
	$(document).ready(function(){
		$(".Footer").hide();
		$("body").css("overflow","hidden");


		var h = $(window).height();

		// var wi = $(window).height(); 
		var fromTop = h-152;
		$("#map").css("height", fromTop+"px");
	});

	var locations = [
	<?php 
	foreach($items as $item) : 
		$mapsCoords = explode(":",$item["map_coordinates"]); 
		$url = l()."/".$item["slugx"]."/".urlencode($item["title"])."/".$item['id'];
		if(isset($mapsCoords[0]) && isset($mapsCoords[1])) : 
		$content = sprintf(
			"<a href='%s' style='margin:0; padding:0; width: 320px; color:#000;'>", 
			$url
		);
		
		$content .= "<div style='margin:0; padding:0; float: left'>";
		$content .= sprintf(
			"<img src='%s' alt='' style='width:120px;' />",
			g_image($item["photo1"], 150, 150)
		);
		$content .= "</div>";

		$content .= "<div style='margin:0; padding:0 10px; float: left'>";
		$content .= sprintf(
			"<span style='font-family: BPGCaps2010; font-size: 14px'>%s</span>",
			$item["title"]
		);
		$content .= sprintf("<p style='margin:5px 0 0 0; font-family: BPGArial2010; font-size: 12px'>%s %s</p>", $item["price"], $item["currency"]);
		$content .= sprintf("<p class='space' style='margin:5px 0 0 0; font-family: BPGArial2010; font-size: 12px; padding-left: 25px; line-height: 25px'>%s: %s %s</p>", l("space"), (int)$item["square"], l('kvm'));
		$content .= "</div>";

		$content .= "</a>";

	?>
	[<?=json_encode($item["title"])?>, <?=$mapsCoords[0]?>, <?=$mapsCoords[1]?>, <?=json_encode($content)?>, <?=json_encode($item["catalogid"])?>],
	<?php endif; endforeach; ?>
	];

	function initMap() {
		var myOptions = {
			center: new google.maps.LatLng(33.890542, 151.274856),
			zoom: 11,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map"), myOptions);
	    setMarkers(map,locations);
	}
	var markers = [];
	function setMarkers(map,locations){
		var i; 		
		for (i = 0; i < locations.length; i++)
		{  
			
			var title = locations[i][0];
			var lat = locations[i][1];
 			var long = locations[i][2];
 			var content =  locations[i][3];

 			latlngset = new google.maps.LatLng(lat, long);
 			var iconImage = "";
 			if(locations[i][4]==7){
 				iconImage = "<?=WEBSITE?>/img/icons/binebi.png";
 			}else if(locations[i][4]==8){
 				iconImage = "<?=WEBSITE?>/img/icons/kerdzosaxlebi.png";
 			}else if(locations[i][4]==9){
 				iconImage = "<?=WEBSITE?>/img/icons/agarakebi.png";
 			}else if(locations[i][4]==10){
 				iconImage = "<?=WEBSITE?>/img/icons/miwisnakveTebi.png";
 			}else if(locations[i][4]==11){
 				iconImage = "<?=WEBSITE?>/img/icons/komerciuli.png";
 			}else if(locations[i][4]==20){
 				iconImage = "<?=WEBSITE?>/img/icons/sastumroebi.png";
 			}

  			var marker = new google.maps.Marker({  
          		map: map, title: title , position: latlngset, icon: iconImage, catalogid:locations[i][4] 
        	});

        	marker.id = locations[i][4];

        	markers.push(marker);


        
        	map.setCenter(marker.getPosition()); 

			// var content = "Loan Number: " + loan +  '</h3>' + "Address: " + add;
			var infowindow = new google.maps.InfoWindow()

			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
	        	return function() {
	           		infowindow.setContent(content);
	           		infowindow.open(map,marker);
	        	};
    		})(marker,content,infowindow)); 

  		}
	}

	$('.mapsearchcheck').change(function() {
		var dataid = $(this).attr("data-id"); 
		
        if($(this).is(":checked")) {

        	for (var i = 0; i < markers.length; i++) {
        		console.log(markers[i].id + " " + dataid);
            	if (markers[i].id == dataid) {
                	markers[i].setVisible(true);
            	}
        	}
        }else{
        	for (var i = 0; i < markers.length; i++) {
            	if (markers[i].id == dataid) {
                	markers[i].setVisible(false);
            	}
        	}
        }

    });
	
	$("body").addClass("SingleBodyClass");
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRfxE_YhbYvFodzMKSPz0s4OQ7l3uukMw&amp;callback=initMap"></script>
