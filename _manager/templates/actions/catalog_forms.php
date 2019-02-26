    <div id="title" class="fix">
        <div class="icon"><img src="_manager/img/edit.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo ($subaction=='add') ? a('addcatalogitem') : a('editcatalogitem');?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
            </div>
            <div id="t1" style="display:inline; visibility:visible;">
                <div id="news">
<?php $ulink = ($subaction=="add") ? ahref('catalog', 'add', array('menu' => $menu)) : ahref('catalog', 'edit', array('menu' => $menu, 'idx' => $idx)); ?>
                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
					<input type="hidden" name="tabstop" id="tabstop" value="close" />
                   	<input type="hidden" name="catalog_form_perform" value="1" />
                        <div class="list2 fix">
                            <div class="icon"><a href="#"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></a></div>								
                            <div class="title"><?php echo a("info");?>: <span class="star">*</span></div>								
                        </div>		
                        <?php if(isset($administrator)) : ?>
                        <div class="list fix">
                            <div class="name" style="color: red">განცხადება დაამატა:</div>                   
                            <?php $userinfo = g_userinfo_byid($administrator); ?>
                            <a href="/<?=l()?>/iadmin?action=siteusers&amp;subaction=edit&amp;id=<?=$userinfo["id"]?>"><?=$userinfo["username"]?></a>
                        </div>
                        <?php endif;?>

                        <div class="list fix">
                            <div class="name"><?php echo a("title");?>: <span class="star">*</span></div>					
                            <input type="text" id="title" name="title" value="<?php echo ($subaction=='edit') ? $title : '' ?>" class="inp"/>
                        </div>	
                        <div class="list fix">
                            <div class="name">მოკლე აღწერა: <span class="star">*</span></div>					
                            <input type="text" id="short_description" name="short_description" value="<?php echo ($subaction=='edit') ? $short_description : '' ?>" class="inp"/>
                        </div>	
                        <div class="list2 fix">
                            <div class="name">დამატების თარიღი: <span class="star">*</span></div>                    
                            <input type="text" name="date" value="<?php echo ($subaction=='edit') ? date('Y-m-d', $date) : date('Y-m-d'); ?>" id="date" class="inp-small" />
                            <script language="JavaScript">
                                new tcal ({
                                    'formname': 'catform',
                                    'controlname': 'date',
                                });
                            </script>
                        </div>  
                        <div class="list2 fix">
                            <div class="name">ვადის გასვლის თარიღი: <span class="star">*</span></div>                    
                            <input type="text" name="expire_date" value="<?php echo ($subaction=='edit') ? date('Y-m-d', $expire_date) : date('Y-m-d'); ?>" id="expire_date" class="inp-small" />
                            <script language="JavaScript">
                                new tcal ({
                                    'formname': 'catform',
                                    'controlname': 'expire_date',
                                });
                            </script>
                        </div> 

                        <div class="list fix">
                            <div class="name">საკადასტრო კოდი:</div>                   
                            <input type="text" id="cadastralcode" name="cadastralcode" value="<?php echo ($subaction=='edit') ? $cadastralcode : '' ?>" class="inp"/>
                        </div>  

                        <div class="list2 fix">
                            <div class="name" style="width:125px;">Super vip:</div>                   
                            <input type="checkbox" name="supervip" class="inp-check" style="margin-top:10px;margin-right:155px;" <?php echo (($subaction=='edit')&&($supervip=='1')) ? 'checked' : '' ?> />
                        </div>

                        <div class="list2 fix">
                             <div class="name" style="width:125px;">Vip:</div>                   
                            <input type="checkbox" name="vip" class="inp-check" style="margin-top:10px;margin-right:155px;" <?php echo (($subaction=='edit')&&($vip=='1')) ? 'checked' : '' ?> />
                        </div>

                        <div class="list2 fix">
                             <div class="name" style="width:125px;">Slider:</div>                   
                            <input type="checkbox" name="slider" class="inp-check" style="margin-top:10px;margin-right:155px;" <?php echo (($subaction=='edit')&&($slider=='1')) ? 'checked' : '' ?> />
                        </div>

                        <div class="list2 fix">
                             <div class="name" style="width:125px;">შესაძლოა გაცვლა:</div>                   
                            <input type="checkbox" name="possibleexchange" class="inp-check" style="margin-top:10px;margin-right:155px;" <?php echo (($subaction=='edit')&&($possibleexchange=='1')) ? 'checked' : '' ?> />
                        </div>

                        

                        <div class="list2 fix">
                            <div class="name" style="width:125px;">გარიგების ტიპი: </div>
                            <select name="sale" id="sale" class="inp-small" style="width:210px;">
                                <?php foreach ($saletypes as $sal): ?>
                                <option value="<?=$sal['id']?>"<?php echo ($subaction=='edit' && $sal['id']==$sale) ? " selected='selected'" : ""?>><?=$sal['title']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="list2 fix">
                            <div class="name" style="width:125px;">სტატუსი: </div>
                            <select name="status" id="status" class="inp-small" style="width:210px;">
                                <?php foreach ($statusTypes as $st): ?>
                                <option value="<?=$st['id']?>"<?php echo ($subaction=='edit' && $st['id']==$status) ? " selected='selected'" : ""?>><?=$st['title']?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>

                        <div class="list2 fix">
                            <div class="name" style="width:125px;">მდებარეობა: </div>
                            <select name="city" id="city" class="inp-small" style="width:210px;">
                                <?php foreach ($cities as $ci): ?>
                                <option value="<?=$ci['id']?>"<?php echo ($subaction=='edit' && $ci['id']==$city) ? " selected='selected'" : ""?>><?=$ci['title']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="list fix">
                            <div class="name">მისამართი: </div>                   
                            <input type="text" id="address" name="address" value="<?php echo ($subaction=='edit') ? $address : '' ?>" class="inp"/>
                        </div> 

                        <div class="list fix">
                            <div class="name">ოთახების რაოდენობა: </div>                   
                            <input type="text" id="rooms" name="rooms" value="<?php echo ($subaction=='edit') ? $rooms : '' ?>" class="inp"/>
                        </div> 
                        
                        <div class="list2 fix">
                            <div class="name"><?php echo a("price");?>: </div>					
                            <input type="text" id="price" name="price" value="<?php echo ($subaction=='edit') ? $price : '' ?>" class="inp-small"/>
                        </div>

                        <div class="list2 fix">
                            <div class="name">ვალუტა: </div>                  
                            <select name="currency" id="currency" class="inp-small" style="width:210px;">
                                <option value="GEL"<?php echo ($subaction=='edit' && $currency=="GEL") ? " selected='selected'" : ""?>>GEL</option>
                                <option value="USD"<?php echo ($subaction=='edit' && $currency=="USD") ? " selected='selected'" : ""?>>USD</option>
                            </select>
                        </div>

                        <div class="list2 fix">
                            <div class="name">სართული:</div>                   
                            <input type="text" id="floor" name="floor" value="<?php echo ($subaction=='edit') ? $floor : '' ?>" class="inp-small"/>
                        </div>

                        <div class="list2 fix">
                            <div class="name">სულ სართულები:</div>                   
                            <input type="text" id="floor_all" name="floor_all" value="<?php echo ($subaction=='edit') ? $floor_all : '' ?>" class="inp-small"/>
                        </div>

                        

                        <div class="list2 fix">
                            <div class="name" style="width:125px;">მდგომარეობა:</div>
                            <select name="condition" id="condition" class="inp-small" style="width:210px;">
                                <option value="0"></option>
                                <?php foreach ($conditions as $co): ?>
                                <option value="<?=$co['id']?>"<?php echo ($subaction=='edit' && $co['id']==$condition) ? " selected='selected'" : ""?>><?=$co['title']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="list2 fix">
                            <div class="name" style="width:125px;">პროექტი:</div>
                            <select name="project" id="project" class="inp-small" style="width:210px;">
                                <?php foreach ($projects as $proj): ?>
                                <option value="<?=$proj['id']?>"<?php echo ($subaction=='edit' && $proj['id']==$project) ? " selected='selected'" : ""?>><?=$proj['title']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        
                        <div class="list fix">
                            <div class="name">კვადრატი:</div>                   
                            <input type="text" id="square" name="square" value="<?php echo ($subaction=='edit') ? $square : '' ?>" class="inp"/>
                        </div> 

                        <div class="list fix">
                            <div class="name">სველი წერტილები: </div>                   
                            <input type="text" id="bathrooms" name="bathrooms" value="<?php echo ($subaction=='edit') ? $bathrooms : '' ?>" class="inp"/>
                        </div>

                        <div class="list fix">
                            <div class="name">ჭერის სიმაღლე: </div>                   
                            <input type="text" id="ceilheight" name="ceilheight" value="<?php echo ($subaction=='edit') ? $ceilheight : '' ?>" class="inp"/>
                        </div> 


                        <div class="list fix">
                            <div class="name">დამატებითი ინფორმაცია: </div>    
                            <div style="float: left; width:800px">
                                <?php 
                                $addinfo = (!empty($aditionalinformation)) ? explode(",", $aditionalinformation) : array();
                                foreach ($aditional_info as $ai): 
                                    $checked = ($subaction=='edit' && in_array($ai["id"], $addinfo)) ? 'checked="checked" ' : ''; 
                                ?>            
                                    <div class="name" style="width: 155px;">
                                        <label style="cursor: pointer"><?=$ai["title"]?> 
                                            <input type="checkbox" name="aditionalinformation[]" value="<?=$ai["id"]?>" <?=$checked?>/>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div> 


                        
                        

                        <div class="list fix">
                            <div class="name"><?php echo a("visibility");?>: <span class="star" title="<?php echo a('tt.visibility');?>">*</span></div>                 
                            <input type="checkbox" name="visibility" class="inp-check" style="margin-top:10px;" <?php echo (($subaction=='edit')&&($visibility=='true')) ? 'checked' : '' ?> />
                        </div>

                        <div class="list2 fix">
                            <div class="name">რუკის კორდინატები: <span class="star">*</span></div>                 
                            <input type="text" name="map_coordinates" id ="map_coordinates" value="<?php echo ($subaction=='edit') ? $map_coordinates : '' ?>" class="inp" readonly="readonly" />
                            <div id="map" style="width:100%; height: 350px;"></div>
                            <script>
                                <?php 
                                $ex = (isset($map_coordinates)) ? explode(":", $map_coordinates) : array();
                                $lat = ($subaction=='edit' && isset($ex[0]) && isset($ex[1])) ?  $ex[0] : '41.63514628349129';
                                $lng = ($subaction=='edit' && isset($ex[0]) && isset($ex[1])) ?  $ex[1] : '41.62310082006843';
                                ?>
                                var myLatLng = {lat: <?=$lat?>, lng: <?=$lng?>};
                                $("#map_coordinates").val(myLatLng.lat + ":" + myLatLng.lng);
                                function initMap() {
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 12,
                                        center: myLatLng
                                    });

                                    // Place a draggable marker on the map
                                    var marker = new google.maps.Marker({
                                        position: myLatLng,
                                        map: map,
                                        draggable:true,
                                        title:"Drag me!"
                                    });

                                    // on drag sent info to parent
                                    google.maps.event.addListener(marker, 'dragend', function(e) { 
                                      var lat = marker.getPosition().lat();
                                      var lng = marker.getPosition().lng();

                                      $("#map_coordinates").val(lat + ":" + lng);
                                    });
                                } 
                            </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRfxE_YhbYvFodzMKSPz0s4OQ7l3uukMw&amp;callback=initMap"></script>
                        </div>
                        
                        
                        <div class="list2 fix">
                            <div class="name"><?php echo a("keywords");?> </div>					
                            <input type="text" name="meta_keys" id ="meta_keys" value="<?php echo ($subaction=='edit') ? $meta_keys : '' ?>" class="inp"/>
                        </div>                        	                        
                   
                        <div class="list2 fix">
                            <div class="icon"><a href="#"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></a></div>								
                            <div class="title"><?php echo a("general");?>: <span class="star">*</span></div>								
                        </div>	

                        <div class="list2 fix">
                            <div class="name">საკონტაქტო ნომერი </div>                    
                            <input type="text" name="contactphone" id ="contactphone" value="<?php echo ($subaction=='edit') ? $contactphone : '' ?>" class="inp"/>
                        </div> 
        
                        <div class="list fix">
                            <div class="name" style="line-height:16px;">აღწერა: <span class="star">*</span></div>					
	                        <textarea id="description" name="description" style="width:800px; height:300px; margin-top:2px; margin-bottom:2px;"><?php echo ($subaction=='edit') ? $description : '' ?></textarea>
                        </div>	

                        <div class="list fix">
                            <div class="name"><?php echo a("image");?> 1: <span class="star">*</span></div>					
                            <input type="text" id="photo1" name="photo1" value="<?php echo ($subaction=='edit') ? $photo1 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo1');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>	

                        <div class="list fix">
                            <div class="name"><?php echo a("image");?> 2: <span class="star">*</span></div>       
                            <input type="text" id="photo2" name="photo2" value="<?php echo ($subaction=='edit') ? $photo2 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo2');" class="button br" ><?php echo a("browse");?></a>
                       </div>

                        <div class="list fix">
                            <div class="name"><?php echo a("image");?> 3: <span class="star">*</span></div>                   
                            <input type="text" id="photo3" name="photo3" value="<?php echo ($subaction=='edit') ? $photo3 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo3');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                        </div>

                        <div class="list2 fix">
                            <div class="name"><?php echo a("image");?> 4: <span class="star">*</span></div>
                            <input type="text" id="photo4" name="photo4" value="<?php echo ($subaction=='edit') ? $photo4 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo4');" class="button br" ><?php echo a("browse");?></a>
                        </div>
                        <div class="list2 fix">
                            <div class="name"><?php echo a("image");?> 5: <span class="star">*</span></div>					
                            <input type="text" id="photo5" name="photo5" value="<?php echo ($subaction=='edit') ? $photo5 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo5');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>

                       <div class="list2 fix">
                            <div class="name"><?php echo a("image");?> 6: <span class="star">*</span></div>                   
                            <input type="text" id="photo6" name="photo6" value="<?php echo ($subaction=='edit') ? $photo6 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo6');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>

                       <div class="list2 fix">
                            <div class="name"><?php echo a("image");?> 7: <span class="star">*</span></div>                   
                            <input type="text" id="photo7" name="photo7" value="<?php echo ($subaction=='edit') ? $photo7 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo7');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>	

                       <div class="list2 fix">
                            <div class="name"><?php echo a("image");?> 8: <span class="star">*</span></div>                   
                            <input type="text" id="photo8" name="photo8" value="<?php echo ($subaction=='edit') ? $photo8 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo8');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>

                       <div class="list2 fix">
                            <div class="name"><?php echo a("image");?> 9: <span class="star">*</span></div>                   
                            <input type="text" id="photo9" name="photo9" value="<?php echo ($subaction=='edit') ? $photo9 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo9');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>

                       <div class="list2 fix">
                            <div class="name"><?php echo a("image");?> 10: <span class="star">*</span></div>                   
                            <input type="text" id="photo10" name="photo10" value="<?php echo ($subaction=='edit') ? $photo10 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo10');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>

                       <!-- <div class="list fix">
                            <div class="name"><?php echo a("video");?>: <span class="star">*</span></div>					
                            <input type="text" id="video1" name="video1" value="<?php echo ($subaction=='edit') ? $video1 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('video1');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>

                            <input type="text" id="video2" name="video2" value="<?php echo ($subaction=='edit') ? $video2 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('video2');" class="button br" ><?php echo a("browse");?></a>
                       </div> -->

        			</form>
                </div>
            </div>

            <div id="bottom" class="fix">
                <a href="javascript:save();" class="button br"><?php echo a("save");?></a>
                <a href="javascript:v_saveclose();" class="button br"><?php echo a("save&close");?></a>
                <a href="javascript:history.back(-1);" class="button br"><?php echo a("cancel");?></a>
                <!-- <a href="<?php echo ahref('uploadfiles', 'show', array('menu'=>$menu, 'id'=>$id, 'idx'=>$idx));?>" id="b3" class="button br">Upload Slider Images</a> -->
            </div>					
        </div>		
    </div>
    <link rel="stylesheet" type="text/css" href="<?php echo JSPATH;?>calendar/calendar-mos.css" title="green" media="all" />
    

<script language="javascript" type="text/javascript">
	function save() {
		$("#tabstop").val('edit');
		var validate = 0;
		var msg = "";
		if($("#pagetitle").val()=='') {
			msg = "<?php echo a('error.title');?>";
			validate = 0; 
		} else {
			validate = 1;
		}
		if(validate == 1) {		
			this.catform.submit();
		} else {
			alert(msg);
		}
	}

	function v_saveclose() {
		$("#tabstop").val('close');
		var validate = 0;
		var msg = "";
		if($("#pagetitle").val()=='') {
			msg = "<?php echo a('error.title');?>";
			validate = 0; 
		} else {
			validate = 1;
		}
		if(validate == 1) {		
			this.catform.submit();
		} else {
			alert(msg);
		}
	}
</script>

<script language="JavaScript">
		function browse(fieldname) {
			 aFieldName = fieldname, aWin = window;
			 if($('#elfinder').length == 0) {
				 $('body').append($('<div/>').attr('id', 'elfinder'));
				 $('#elfinder').elfinder({
					 url : '<?php echo c('site.url') . JAVASCRIPT;?>/elfinder/connectors/php/connector.php',
					 dialog : { width: 750, modal: true, title: 'Files', zIndex: 400001 }, 
					 editorCallback: function(url) {
						 aWin.document.forms[0].elements[aFieldName].value = url;
					 },
					 closeOnEditorCallback: true
				 });
			 } else {
				 $('#elfinder').elfinder('open');
			 }
		 };
</script>
