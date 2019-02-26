<?php
function pagetitle($title){
	$ttl = "SELECT title FROM pages WHERE id='".$title."' AND language='".l()."' AND deleted=0 AND visibility='true'";
	$title_pages = db_fetch($ttl);
	$out = '';
	$out .=''.$title_pages['title'].'';
	return $out;
}
function cat_title($title){
	$ttl = "SELECT title FROM ".c("table.catalogs")." WHERE catalogid='".$title."' AND language='".l()."' AND deleted=0 AND visibility='true'";
	$title_cat = db_fetch($ttl);
	$out = '';
	$out .=''.$title_cat['title'].'';
	return $out;
}

function ProductSlide()
{
	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.catalogs") . " WHERE  language = '" . l() . "' AND deleted=0  AND visibility = 'true' AND `hot`=1" );

	if( $slides )
	{
		$i = 0;
		foreach($slides as $promo)
		{
		$result1 = mysql_query("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$promo['catalogid']."'");
		$item1 = mysql_fetch_array($result1);

		$result2 = mysql_query("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
		$item2 = mysql_fetch_array($result2);
			
			if($promo["description"] == "")
				$promo["description"] = "javascript:";
            
			$out .= '<div class="list">';
			
			$out .= '<div class="name"><a href="'.$item2["slug"]."?product=".$promo["id"].'"">'.$promo["title"].'</a></div>';
			
			$out .= '<div class="img"><a href="'.$item2["slug"]."?product=".$promo["id"].'""><img src="crop.php?img='.$promo["photo1"].'&width=127&height=85" width="127" height="85" alt="" /></a></div>';
				
				$out .= '<div class="bot fix">';
				
		if($promo['saleprice']!=''){
					$out .= '<div class="price">'.$promo["price"].' '.l('val').'</div>	';
					$out .= '<div class="sale">'.$promo['saleprice'].' '.l('val').'</div>	';	
		} else {
					$out .= '<div class="sale">'.$promo['price'].' '.l('val').'</div>	';	
				}
				$out .= '</div>';
			
				
			$out .= '</div>';
			
			$i++;
		}
								
	}

	return $out;
}

function ProductSimilarSlide12($catalogid=0)
{
	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.catalogs") . " WHERE ".(($catalogid==0) ? '' : 'catalogid='.$catalogid.' AND ')." language = '" . l() . "' AND deleted=0  AND visibility = 'true'" );

	if( $slides )
	{
		
		$i = 0;
		foreach($slides as $promo)
		{
		$result1 = mysql_query("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$promo['catalogid']."'");
		$item1 = mysql_fetch_array($result1);

		$result2 = mysql_query("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
		$item2 = mysql_fetch_array($result2);
			
			if($promo["description"] == "")
				$promo["description"] = "javascript:";
            
			$out .= '<div class="list fix">';
			
			$out .= '<div class="name"><a href="'.$item2["slug"]."?product=".$promo["id"].'"">'.$promo["title"].'</a></div>';
			
			$out .= '<div class="img"><a href="'.$item2["slug"]."?product=".$promo["id"].'""><img src="crop.php?img='.$promo["photo1"].'&width=127&height=85" width="127" height="85" alt="" /></a></div>';
				
				$out .= '<div class="bot fix">';
				
		if($promo['saleprice']!=''){
					$out .= '<div class="price">'.$promo["price"].' '.l('val').'</div>	';
					$out .= '<div class="sale">'.$promo['saleprice'].' '.l('val').'</div>	';	
		} else {
					$out .= '<div class="sale">'.$promo['price'].' '.l('val').'</div>	';	
				}
					
				$out .= '</div>';
			
				
			$out .= '</div>';
			
			$i++;
		}
								
	}

	return $out;
}

function ProductSimilarSlide($id=0, $productid=0)
{
	if($id!=0) {
		$q1 = db_fetch("select * from pages where language='".l()."' and id=".$id);
		$q2 = db_fetch("select * from menus where language='".l()."' and title='".$q1["attached"]."'");
		$id = $q2["id"];
	}


	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.catalogs") . " WHERE ".(($id==0) ? '' : 'catalogid='.$id.' AND ')." id<>".$productid." and language = '" . l() . "' AND deleted=0 AND visibility = 'true'");
	if( $slides )
	{
		
		$i = 0;
		foreach($slides as $promo)
		{
		$item1 = db_fetch("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$promo['catalogid']."'");
		$item2 = db_fetch("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
			
			if($promo["description"] == "")
				$promo["description"] = "javascript:";
            
			$out .= '<div class="tour fix">';

			$out .= '<div class="img left"><a href="'.href($item2["id"])."?product=".$promo["id"].'""><img src="crop.php?img='.$promo["photo1"].'&width=210&height=130" width="210" height="130" alt="" /></a></div>';
			
			$out .= '<div class="tour-ttl">
						<h4><a href="'.href($item2["id"])."?product=".$promo["id"].'"">'.$promo["title"].'</a></h4>
					</div>';
				
			$out .= '<div class="tour-txt">'.$promo["description"].'</div>';

			if($promo["duration"]!='' || $promo["price"]!=''){

				if($promo["duration"]!=''){
				$out .= '<div class="offer fix">
					<div class="left"><span>'.((l()=='ge') ? 'ხანგრძლივობა:':'Duration:').'</span> '.$promo["duration"].'</div>';
				}

				if($promo["price"]!=''){
				$out .= '<div class="right"><span>'.((l()=='ge') ? 'ფასი:':'Price:').'</span> <span class="price">'.$promo["price"] . ' USD</span> ' .((l()=='ge') ? '/ ერთ პიროვნებაზე':'/ per person').'</div>
				</div>';	
				}
			}

			$out .= '</div>';
			
			$i++;
		}
								
	}

	return $out;
}

function getMainSlideImages()
{
    global $lang_id;
    $sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 23 AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position;";
    $out  = '';
 $promos = db_fetch_all($sql); 
 $content = array();
 if( count($promos) > 0 )
 { 
  $i = 0;
  foreach($promos as $promo)
  {    
     $i++;
     $lnk = ($promo["itemlink"]!='') ? $promo["itemlink"] : "#";
   
   $content[] = '{
    "title" : "'.$promo["title"].'",
    "image" : "'.$promo["file"].'",
    "url" : "'.$lnk.'",
    "firstline" : "'.$promo["title"].'",
    "secondline" : "'.((l()=='ge') ? 'სრულად ნახვა' : 'Read More').'",
	"href" : "'.$lnk.'"
   }';
     $i++;
  }  
    $out .= implode(',', $content);
 } 
 return $out; 
}

function getPageSlideImages($id)
{
	$p = db_fetch("select * from pages where language='".l()."' and id=".$id);
	$idx=$p["idx"];
    global $lang_id;
    $sql = "SELECT * FROM " . c("table.attached") . " WHERE page = ".$idx." ;";
    $out  = '';
 $promos = db_fetch_all($sql); 
 $content = array();
 $lnk = "";
  $content[] = '{
    "title" : "'.$p["title"].'",
    "image" : "'.$p["imagen"].'",
    "url" : "'.$lnk.'",
    "firstline" : "'.$p["title"].'",
    "secondline" : "'.((l()=='ge') ? 'სრულად ნახვა' : 'Read More').'",
	"href" : "'.$lnk.'"
   }';
 { 
  $i = 0;
  foreach($promos as $promo)
  {    
     $i++;
     $lnk = "";
   
   $content[] = '{
    "title" : "'.$promo["title"].'",
    "image" : "'.$promo["path"].'",
    "url" : "'.$lnk.'",
    "firstline" : "'.$promo["title"].'",
    "secondline" : "'.((l()=='ge') ? 'სრულად ნახვა' : 'Read More').'",
	"href" : "'.$lnk.'"
   }';
   $i++;
  }
 } 
 $out .= implode(',', $content);
 return $out; 
}

function slogd()
{
	$out = '';
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND deleted = 0 AND level = 2 AND visibility = 'true' ORDER BY position LIMIT 1;";
    $sections = db_fetch_all($sql);
	if (empty($sections))
        return NULL;
		
		
    foreach ($sections AS $slog) {
		$out .= ''.$slog["id"].''."\n";
		$out .= ''.$slog["menutitle"].''."\n";
		
	}
    return $out;
}

function slog()
{
    $storage = Storage::instance();
	$out = '';
    $page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id = '".c("section.home")."' LIMIT 1;");
	$segment = '';
    if (is_numeric($storage->segments[count($storage->segments) - 1])) {
	    $page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id = '{$storage->segments[count($storage->segments) - 2]}' LIMIT 1;");
		$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
	
	} else {
		for($i=0; $i<count($storage->segments); $i++) :
			$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
			$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE level = 2 AND language = '" . l() . "' AND slug = '{$segment}' LIMIT 1;");
			$title = $page['menutitle'];
			$out .= '' . $title . ''."\n";
		endfor;
	}
    return $out;
}


function faq_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 2 order by pagedate ASC limit 0, 4;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '<div class="list">
				 <div class="question"><a href="'.$link.'">'.$newhome['title'].'</a></div>
				 </div>';
		}								
										
    return $out;
	}

function ourteam_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid =5 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	echo '<div class="block-title"><h2><a href="'.href(5).'"> '.((l()=='ge') ? 'ჩვენი გუნდი':'our team').'</a></h2></div>';

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '
				<div class="member fix">
				<div class="bor">';
				$out .= '<a href="' . $link . '">' . $newhome['title'] . '</a>
						<p>' . $newhome['description'] . '</p>
						 </div></div>';
				}	
		
    return $out;
	}
 
function about_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id = 2;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = '<div class="img left">
                    <a href="#"><img src="_website/images/logo-small.png" height="28" width="95" alt=""></a>
                </div>
				<div class="text">
            <p>'.$newshome["meta_desc"].'</p>
			</div>';
    return $out;
	}

function product_home()
{
    $sql = "SELECT * FROM ".c("table.catalogs")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND hot=1 order by rand() limit 0, 4;";
    $homepage = db_fetch_all($sql);
    if (empty($homepage))
        return NULL;
    $out = NULL;
	$i=0;
    foreach ($homepage AS $home) {
		$cat=db_fetch("select * from menus where language='".l()."' and id=".$home["catalogid"]);
		$catpage=db_fetch("select * from pages where language='".l()."' and attached='".$cat["title"]."'");
        $i++;
		$out .= '
        		<article class="tour1 left">
				<div class="img">
						<a href="'.href($catpage["id"]).'/'.$home['id'].'"><img src="'.$home['photo1'].'" width="220" height="220" alt="" /></a>
					</div>
	        	 <header class="title">
                        <h2>'.$home["title"].'</h2>
                        <div class="price">'.$home["price"].'$</div>
                    </header>
               
					
					
				  </article>'."\n";

	}
    return $out;
}

            
function product_home2()
{
    $sql = "SELECT * FROM ".c("table.catalogs")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND top25=1 order by rand() limit 0, 6;";
    $homepage = db_fetch_all($sql);
    if (empty($homepage))
        return NULL;
    $out = NULL;
	$i=0;
    foreach ($homepage AS $home) {
		$cat=db_fetch("select * from menus where language='".l()."' and id=".$home["catalogid"]);
		$catpage=db_fetch("select * from pages where language='".l()."' and attached='".$cat["title"]."'");
        $i++;
		$out .= '
        		  <article class="tour left">
                        <div class="img">
                            <a href="'.href($catpage["id"]).'/'.$home['id'].'"><img src="'.$home['photo1'].'" height="130" width="300" alt=""></a>
                        </div>
                           <header class="title">
                            <hgroup>
                           
                               <a href="'.href($catpage["id"]).'/'.$home['id'].'">  <h2>'.$home['street'].'</h2><h3>'.$home['title'].'</h3></a>
                            </hgroup>
                            <div class="price">'.$home['price'].'$</div>
                            <div class="more">
                                <a href="'.href($catpage["id"]).'/'.$home['id'].'"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                            </div>
                        </header>
                
                    </article>      '."\n";

	}
    return $out;
}
function text_home($id)
{
    $text = db_fetch("SELECT idx FROM ".c("table.pages")." WHERE id='".$id."' AND language='".l()."' AND deleted=0");
	$hometext = db_fetch_all("SELECT * from ".c("table.pages")." where language='".l()."' and masterid=".$text["idx"]." AND visibility='true' and deleted=0 ORDER by position limit 0,6;");
    if (empty($hometext))
        return NULL;
    $out = NULL;
	$last = NULL;
	$i=0;
    foreach ($hometext AS $home) {
		$link = href($home["id"]);
        $i++;
		if ($i == 3) {$last = " last"; $i=0;} else {$last=NULL;}
			$out .= '<div class="block left'.$last.'">
                        <div class="img">
							<a href="'.$link.'"><img src="crop.php?img='.$home['imagen'].'&width=300&height=110" width="300" height="110" alt="" title="" /></a>
                        </div>
                        <!-- .img -->
                        <div class="title">
                            <div class="more right"><a href="'.$link.'">'.l('more').'</a></div>
                            <h3>'.$home["title"].'</h3>
                            '.$home["description"].'
                        </div>
                        <!-- .title -->
                    </div>
                    <!-- .block left -->'."\n";
	}
    return $out;
}

function links($idx) {
//	$sql = db_fetch("SELECT idx, id from pages where id = ".$storage->section["id"]." and language = '" . l() . "'");
	$cat = db_fetch_all("SELECT * from pages where masterid = ".$idx." and language = '" . l() . "' AND deleted = 0 AND visibility='true' order by position");
    if (empty($cat))
        return NULL;
    $out = NULL;
    $last = NULL;
	$i=0;
	foreach($cat as $s) :
		$link = href($s['id']);
		$i++;
		if ($i == 3) {$last = " last"; $i=0;} else {$last=NULL;}
			$out .= '
                                <div class="col-md-3">
                                   <div class="team-post">
								      <a href="'.$link.'">
                                      <div class="team-img">
                                         <img width="350" height="350" src="crop.php?img='.$s['imagen'].'&width=350&height=350" class="attachment-full size-full wp-post-image" alt="'.$s["title"].'" title="'.$s["title"].'" /> 
                                      </div>
									  </a>
                                      <div class="team-content">
                                         <a href="'.$link.'"><h4>'.$s["title"].'</h4></a>
                                         <p>'.$s["description"].'</p>
                                      </div>
                                   </div>
                                </div>
                                <!-- col-md-3 --> 
					'."\n";
		
	endforeach;
	return $out;	
}


function contact_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id =5;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = $newshome["description"];
    return $out;
	}


function gallery_home(){
	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.galleries") . " WHERE  language = '" . l() . "' AND deleted=0 AND galleryid=66 AND visibility = 'true' limit 6" );
	if( $slides ) {
		foreach($slides as $gal) {
			$out.='<a rel="prettyPhoto[2]" href="'.$gal["file"].'"><img src="'.$gal["file"].'" alt="" width="110" height="85" /></a>';
		}
	}
    return $out;
	}

function video_home(){
	$out  = '';	
	$slides = db_fetch("SELECT * FROM " . c("table.galleries") . " WHERE  language = '" . l() . "' AND deleted=0 AND galleryid=11 AND visibility = 'true' order by position desc limit 1" );
	$vid = str_replace('http://www.youtube.com/watch?','',str_replace('http://youtu.be/','',$slides['file']));
	$out.='
					<object width="320" height="175">
						<param name="movie" value="http://www.youtube.com/v/'.$vid.'?version=3&amp;hl=en_US"></param>
						<param name="allowFullScreen" value="true"></param>
						<param name="allowscriptaccess" value="always"></param>
						<param name="wmode" value="transparent"></param>
						<embed src="http://www.youtube.com/v/'.$vid.'?version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="320" height="175" wmode="transparent" allowscriptaccess="always" allowfullscreen="true"></embed>
					</object>';      
    return $out;
	}


function banners($banner_num)
{
	$sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = '".$banner_num."' AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position LIMIT 0,3;";
    $banners = db_fetch_all($sql);
    if (empty($banners))
        return NULL;
    $out = NULL;
	$i=0;
	foreach ($banners AS $banner) {
			if ($banner["itemlink"] == '') {
				$banner["itemlink"] = "javascript:;";
			}
           	$out .= '<div class="img">
						<a href="'.$banner["itemlink"].'" target="_blank"><img src="crop.php?img='.$banner['file'].'&width=214&height=54" width="214" height="54" alt="'.$banner['title'].'" /></a>
                    </div>
                    <!-- .img -->'."\n";
	}
    return $out;
}

function left_menu()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 5 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = '<script>visible=0;</script>', $num = count($sections); $idx < $num; $idx++)
    {
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 5 AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
	        $out .= '<li' . ($idx == ($num - 1) ? ' class="last"' : '') . '>'."\n";
	        $out .= '<a id="href'.$sections[$idx]['id'].'" href="javascript:leftmenu('.$sections[$idx]['id'].');" ' . (($idx == 0) ? ' class="first"' : '') . '>' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		} else {
	        $out .= '<li ' . ($idx == ($num - 1) ? ' class="last"' : '') . '>'."\n";
	        $out .= '<a id="href'.$sections[$idx]['id'].'" href="' . $link . '" ' . (($idx == 0) ? ' class="first"' : '') . '>' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		}
		if(count($sections_in) > 0) {
			$out .= '<ul class="sub leftsub" style="display:none;" id="sub'.$sections[$idx]['id'].'">'."\n";
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
				if($storage->section["id"]==$sections_in[$idx_in]['id'])
					$out .= '<script>
						visible = '.$sections[$idx]['id'].';
						$("#sub'.$sections[$idx]['id'].'").show();
						$("#href'.$sections[$idx]['id'].'").addClass("active");
					</script>';
            	$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 4 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<div class="sub">'."\n";
					$out .= '</div>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
            $out .= '</ul>'."\n";
		} else {
	        $out .= ''."\n";
		}
        $out .= '</li>'."\n";
    }
    return $out;
}

function left_menu2()
{
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND masterid=0 AND deleted = 0 AND visibility = 'true' ORDER BY position;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
	foreach($sections as $section) :
		$out .= '<div id="lmenu">';
		if($section['id']==19){
		$out .= '	<div class="female-title">'.$section['menutitle'].'</div>';
		}
		else if($section['id']==20){
		$out .= '	<div class="male-title">'.$section['menutitle'].'</div>';
		}
		else{
		$out .= '	<div class="fm-title">'.$section['menutitle'].'</div>';
		}
//		$out .= '	<div class="part">';
//		$out .= '		<div class="l-menu">';
		$out .= '			<ul>';
		$sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND deleted = 0 AND masterid = " . $section['idx'] . " AND visibility = 'true' ORDER BY position;";	
		$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
			{
				$link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
				$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '">' . $sections_in[$idx_in]['title'] . '</a>'."\n";
				$out .= '</li>'."\n";
				
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++) {
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li class="sub">'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['title'] . '</a>'."\n";
						$out .= '</li>'."\n";
					}
				}
			}
		}
		$out .= '			</ul>';
//		$out .= '		</div>';
//		$out .= '	</div>';				
		$out .= '	<div class="bot"></div>';
		$out .= '</div>';
	endforeach;
    return $out;
}

function bottom_menu() 
{
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND homepage = 'true' AND visibility = 'true' ORDER BY position LIMIT 0, 4;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$out .= '<div class="list"><ul>'."\n";
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
        $out .= '<li class="title"><a href="' . $link . '">' . ((l()=='ge') ? $sections[$idx]['title'] : $sections[$idx]['title']) . '</a></li>'."\n";
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$out .= '</li>'."\n";
			}
		}
		$out .= '</ul></div>'."\n";
	}
    return $out;
}

function home() 
{
	return template('home', array());
}

function getPromoImages()
{
    global $lang_id;
    $sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 11 AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position;";
    $out  = '';
	$promos = db_fetch_all($sql);	
	if( count($promos) > 0 )
	{	
		$i = 0;
		foreach($promos as $promo)
		{		  
		  	$i++;
		  	if($i==1) {
				$content = '<div id="center" class="center"><div class="img"><img src="' . $promo["file"] . '" width="920" height="380" alt="" class="pngfix" id="img'.$i.'"/></div>';
				$content .= '<div class="title"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["title"] . '</a></div></div>';
				$content .= '<div class="percent"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["description"] . '</a></div></div></div>';
				$content .= '<div id="center'.$i.'" style="display:none"><div class="img"><img src="' . $promo["file"] . '" width="920" height="380" alt="" class="pngfix" id="img'.$i.'"/></div>';
				$content .= '<div class="title"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["title"] . '</a></div></div>';
				$content .= '<div class="percent"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["description"] . '</a></div></div></div>';
			} else {
				$content = '<div id="center'.$i.'" style="display:none"><div class="img"><img src="' . $promo["file"] . '" width="920" height="380" alt="" class="pngfix" id="img'.$i.'"/></div>';
				$content .= '<div class="title"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["title"] . '</a></div></div>';
				$content .= '<div class="percent"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["description"] . '</a></div></div></div>';
			}
		  	$out .= $content;
		}		
	}	
	$out .= '<script language="javascript">maxnum='.$i.';</script>';
	return $out;	
}

function is_text()
{
    return in_array(Storage::instance()->page_type, array('text', 'about', 'sitemap'));
}


function content($content = NULL)
{
    if (empty($content))
        return NULL;
    $content = str_replace('&nbsp;', ' ', $content);
    return html_entity_decode($content);
}

function contact_info()
{
    $language = l();
    $contact_info = db_retrieve('description', c("table.pages"), 'id', c('section.contact'), "AND language = '{$language}' LIMIT 1");
    return empty($contact_info) ? NULL : $contact_info;
}

function location()
{
    $storage = Storage::instance();
	$out = '';
    $page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id= '".c("section.home")."' AND deleted= '0' LIMIT 1;");
	if($storage->section["id"]!=1)
		$out .= '<li><a href="' . href(c("section.home")) . '">' . $page["title"] . '</a><span>></span></li>'."\n";
	$segment = '';
    if (is_numeric($storage->segments[count($storage->segments) - 1])) {
		if($storage->section["category"]==16) {
			for($i=0; $i<count($storage->segments)-2; $i++) :
				$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
				$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' AND deleted= '0'  LIMIT 1;");
				$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
				$title = $page['title'];
				$out .= '<li><a href="' . $link . '">' . $title . '</a><span>></span></li>'."\n";
			endfor;
			$product = db_fetch("select * from catalogs where language='".l()."' and id=".db_escape($_GET["product"]));
			$cat=db_fetch("SELECT * from menus where language='".l()."' and id=".$product["catalogid"]);
			$catpage=db_fetch("SELECT * from pages where language='".l()."' and attached='".$cat["title"]."'");
			$out .= '<li class="active"><a href="'.href($catpage["id"], array(), l(), $product['id']).'">' . $product["title"] . '</a><span>></span></li>'."\n";
		} else {
			$menu = db_fetch("SELECT * FROM " . c("table.menus") . " WHERE language = '" . l() . "' AND id = '".$storage->section['menuid']."' LIMIT 1;");
			$group = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND attached = '".$menu['title']."' AND deleted= '0'  LIMIT 1;");
			$segments = explode("/", $group["slug"]);
			for($i=0; $i<count($segments); $i++) :
				$segment .= (($segment!='') ? '/' : '').$segments[$i];
				$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' AND deleted= '0'  LIMIT 1;");
				$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
				$title = $page['title'];
				$out .= '<li><a href="' . $link . '">' . $title . '</a><span>></span></li>'."\n";
			endfor;
			$link = (($storage->section['redirectlink'] == '') || ($storage->section['redirectlink'] == 'NULL')) ? href($storage->section['id']) : $storage->section['redirectlink'];
			$title = $storage->section['title'];
			$out .= '<li class="active"><a href="' . $link . '">' . $title . '</a><span>></span></li>'."\n";
		}
	} else {
		for($i=0; $i<count($storage->segments); $i++) :
			$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
			$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' AND deleted= '0'  LIMIT 1;");
			$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
			$title = $page['title'];
			$out .= '<li'.(($i==count($storage->segments)-1) ? ' class="active"' : '').'><a href="' . $link . '">' . $title . '</a><span>></span></li>'."\n";
		endfor;
	}
    return $out;
}

function calendar() 
{
    $storage = Storage::instance();
    $day=date("d");	 	if (isset($_GET['day']))    { $day = $_GET['day']; }    
    					if (isset($_POST['day']))   { $day = $_POST['day']; }
    $month=date("m");  	if (isset($_GET['month']))  { $month = $_GET['month']; }    
    					if (isset($_POST['month'])) { $month = $_POST['month']; }
    $year=date("Y");    if (isset($_GET['year']))   { $year = $_GET['year']; }      
    					if (isset($_POST['year']))  { $year = $_POST['year']; }
    $month=intval($month);
    $year=intval($year);
    $day=intval($day);
	
	$daysinmonth=date("t", mktime(0, 0, 0, $month, 1, $year));
	$daynumber=date("w", mktime(0, 0, 0, $month, 1, $year)); 
//	if ($daynumber==0) { $daynumber=7; }	
	$rows=ceil(($daysinmonth+$daynumber-1)/7);
	$yearp = $year;
	$monthp = $month - 1; if($monthp == 0) { $monthp = 12; $yearp = $year - 1; } 
	$dimp = date("t", mktime(0, 0, 0, $monthp, 1, $yearp));
	$yearn = $year;
	$monthn = $month + 1; if($monthn == 13) { $monthn = 1; $yearn = $year + 1; } 
	$dimn = 1;
	$out = '';

	$monthnames = c('month.names');
	$out .= '<ul class="arrow-part fix">';
	$out .= '	<li class="arrow"><a href="'.href(18, array('year'=>$yearp,'month'=>$monthp,'day'=>$dimp), l()).'"><img src="' . WEBSITE . '/images/l-arrow.png" width="6" height="9" alt="" /></a></li>';
	$out .= '	<li class="month">'.$monthnames[$month][l()].' '.$year.'</li>';
	$out .= '	<li class="arrow"><a href="'.href(18, array('year'=>$yearn,'month'=>$monthn,'day'=>$dimn), l()).'"><img src="' . WEBSITE . '/images/r-arrow.png" width="6" height="9" alt="" /></a></li>';
	$out .= '</ul>';
	$out .= '<table border="1" cellpadding="0" cellspacing="0" class="table">';
	$daytodisplay=1;
	for ($i=1; $i<=$rows; $i++) {
		$out .= '<tr>';
  		for ($j=1; $j<=7; $j++) {
			if (($i==1) && ($j<$daynumber)) {
				$out .= '<td></td>';
			} else {
				if ($daytodisplay>$daysinmonth) {
					$out .= '<td></td>';
				} else {
					$d1 = $year . '-' . $month . '-' . $daytodisplay . ' 23:59:59';
					$d2 = $year . '-' . $month . '-' . $daytodisplay . ' 00:00:00';
					$cnt= db_fetch("select count(*) as cnt from ".c("table.pages")." where menuid=6 and deleted=0 and visibility='true' and language='".l()."' and pagedate<='".$d1."' and pagedate>='".$d2."'");
                	$out .= '<td '.(($daytodisplay == $day) ? 'class="active"':'').' ><a href="'.href(18, array('year'=>$year,'month'=>$month,'day'=>$daytodisplay), l()).'" '.(($cnt["cnt"]>0) ? 'style="color:red;"' : '').' >'.$daytodisplay.'</a></td>';
				}
				$daytodisplay = $daytodisplay +1;
			}
		}
		$out .= '</tr>';
	}
	$out .= '</table>';
	return $out;
}

function home_news()
{
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 'true' AND menuid = 2 AND `deleted` = '0' ORDER BY pagedate DESC LIMIT 5;";
    $news = db_fetch_all($sql);
    if (empty($news))
        return NULL;
    $out = NULL;
	$i = 0;
    foreach ($news AS $item)
    {
		$i++;
        $link = href($item['id']);
        
        $out .= '	<div class="news">';

					if($item['imagen']!=''){
					$out .= '<div class="img left"><a href="' . $link . '"><img src="crop.php?img='.$item['imagen'].'&width=140&height=90" alt="' . $item['title'] . '" width="140" height="90" /></a></div>';
					}
		$out .= '	<div class="date">' . convert_date($item["pagedate"]) . '</div>';

		$out .= ' 	<div class="title">
						<h3><a href="' . $link . '">' . $item['title'] . '</a></h3>
					</div>
					<div class="text">' . $item['description'] . '</div>
				</div>';
    }
    return $out;
}

function home_news2()
{
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 'true' AND menuid = 5 AND `deleted` = '0' ORDER BY pagedate DESC LIMIT 4;";
    $news = db_fetch_all($sql);
    if (empty($news))
        return NULL;
    $out = NULL;
	$i = 0;
    foreach ($news AS $item)
    {
		$i++;
        $link = href($item['id']);
        
        $out .= '	<div class="project">';

					if($item['imagen']!=''){
					$out .= '<div class="img"><a href="' . $link . '"><img src="crop.php?img='.$item['imagen'].'&width=220&height=90" alt="' . $item['title'] . '" width="220" height="90" /></a></div>';
					}
		$out .= ' 	<div class="ttl">
						<h3><a href="' . $link . '">' . $item['title'] . '</a></h3>
					</div>
				</div>';
    }
    return $out;
}

function home_actions()
{
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 'true' AND menuid IN (SELECT id FROM `".c("table.menus")."` WHERE `deleted` = '0' AND type = 'events') AND `deleted` = '0' ORDER BY pagedate DESC LIMIT 2;";
    $news = db_fetch_all($sql);
    if (empty($news))
        return NULL;
    $out = NULL;
	$i = 0;
    foreach ($news AS $item)
    {
		$i++;
        $link = href($item['id']);
		$out .= '<div class="list">';
		$out .= '	<div class="name"><a href="' . $link . '">' . $item['title'] . '</a></div>';
		$out .= '	<div class="date">' . convert_date($item['pagedate']) . '</div>';
		$out .= '	<div class="text">' . $item['description'] . '</div>';
		$out .= '</div>';
    }
    return $out;
}

function home_poll_ge()
{
    $storage = Storage::instance();
	
// vote //
	$idx = 0;
	
    $ttl = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND masterid = 1400 and visibility='true' and deleted=0 order by position;");
	$poll = db_fetch("SELECT * FROM " . c("table.menus") . " WHERE language = '" . l() . "' AND type = 'poll' and deleted=0 and title = '".$ttl["attached"]."';");
	$ip = get_ip() . '-' . $_SERVER['REMOTE_ADDR'];
	$ippresent=db_fetch("select count(*) as cnt from pollips where votedate='".date("Y-m-d")."' and ip='".$ip."' and pollid='".$poll["id"]."' ");
//	$voted=0;
	$voted=($ippresent["cnt"]>0) ? 1:0;
	if(isset($_GET["vote_form_perform"])) {
		if($ippresent["cnt"]==0) 
		{
	
			db_query("insert into pollips (votedate, ip, pollid) values('".date("Y-m-d")."','".$ip."','".$poll["id"]."')");
			db_query("update pollanswers set answercounttotal=answercounttotal+1 where id='".$_GET["poll"]."'");
			db_query("update pollanswers set answercount=answercount+1 where id='".$_GET["poll"]."' and language='".l()."'");
		}
	}
	$out = '';
	$out .= '<div class="question">'.$ttl['title'].'</div>';
    $sql = "SELECT * FROM " . c("table.pollanswers") . " WHERE language = '" . l() . "' AND visibility='true' AND deleted=0 AND pollid = ".$poll["id"].";";
//	return $sql;
    $ans = db_fetch_all($sql);
	if((isset($_GET["results"]))||($voted!=0)) {
		$max = 0;
		foreach($ans as $a) :
			if($a["answercounttotal"]>$max) $max=$a["answercounttotal"];
		endforeach;
		foreach($ans as $a) :
			$w = ($max==0) ? 0:$a["answercounttotal"] * 180 / $max;
			$out .= '<div class="list fix">';
			$out .= '<div class="radio" style="">'.$a['answer'].'</div><br />';
			$out .= '<div style="float:left; width:40px; color:black; padding:5px 0 0 5px;">'.$a['answercounttotal'].'</div><div style="width:'.$w.'px; height:20px; background-color:#e03c80"></div>';
			$out .= '</div>';
		endforeach;
		$out .= '<div class="line"></div>';
	} else {
		$out .= '<form action="'.href($storage->section["id"], array(), l()).'" name="poll">';
		$out .= '<input type="hidden" name="vote_form_perform" value="1">';
		$out .= '<input type="hidden" name="results" value="1">';
		$n=0; $i=0;
		foreach($ans as $a) :
			$n=$n+1; $i++;
			$out .= '<div class="list fix">';
			$out .= '<div class="radio"><input type="radio"  name="poll" value="'.$a['id'].'" '.(($i==1) ? ' checked ':'').' /></div>';
			$out .= '<div class="answer">'.$a['answer'].'</div>';
			$out .= '</div>';
		endforeach;
		$out .= '<div class="line"></div>';
		$out .= '</form>';
	}
	if($voted==0) {$out .='<div class="button fix">';
		$out .= '<div class="result"><a href="'.href($storage->section["id"], array('results'=>1), l()).'" >შედეგები</a></div>';
		
		if(isset($_GET["results"])) 
			$out .= '<a href="'.href($storage->section["id"], array(), l()).'" class="send"><input type="submit" name="" value="ხმის მიცემა" /></a>';
		else
			$out .= '<a href="javascript:document.poll.submit();" class="send"><input type="submit" name="" value="ხმის მიცემა" /></a>';
		$out .='</div>';
	}
    return $out;
}



function timeDown($id){	
    $sql = "SELECT * FROM catalogs WHERE idx='".$id."'";
	$selectDate = mysql_query($sql);
	$fetches = mysql_fetch_array($selectDate);
	$f = $fetches['productdate'];
	$pe = explode(" ",$f);	
	$count = '<script language="JavaScript"  src="_website/countdown.php?timezone=Asia/Tbilisi&countto='.$pe[0]." ".$pe[1].'&do=t&data=დასრულდა"></script>';
	 
	return $count;
} 





/******************************************************* HELLOGEORGIA ************************************************/

function home_products($idx) {
	$products = db_fetch_all("select * from catalogs where language='" . l() . "' and visibility='true' and deleted=0 and hot=1 order by rand() limit 0,4");
	foreach($products as $p) :
		$q1=db_fetch("select * from menus where id=".$p["catalogid"]);
		$q2=db_fetch("select * from pages where attached='".$q1["title"]."'");
		$link=href($q2["id"]).'?product='.$p["id"];
?>
		<div class="list left">
			<div class="img">
				<a href="<?php echo $link; ?>"><img src="crop.php?img=<?php echo $p["photo1"]; ?>&width=210&height=130" width="210" height="130" alt="<?php echo $p["title"]; ?>" title=""></a>
			</div>
			<!-- img end -->
			<div class="list-ttl">
				<h3><a href="<?php echo $link; ?>"><?php echo $p["title"]; ?></a></h3>
			</div>
			<!-- list-ttl end -->
			<div class="list-txt">
				<div class="descr"><?php echo $p["description"]; ?></div>
			</div>
			<!-- list-txt end -->
		</div>
<?php
	endforeach;
}


function entityname($id) {
	$entity=db_fetch("select * from pages where id=".$id." and language='".l()."'");
	return $entity["pposition"];
}

function entity($id) {
	$entity=db_fetch("select * from pages where id=".$id." and language='".l()."'");
	return $entity;
}

function get_entity_field($id, $field) {
// get_entity_field(2, "description");
	$entity=db_fetch("select * from pages where id=".$id." and language='".l()."'");
	return $entity[$field];
}

function home_pages($page_num){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' AND deleted=0 AND id = '".$page_num."'; ";
    $newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
    $i=0;

    foreach($newshome AS $newhome) {
    $link1 = href($newhome['id']);
 $out .='<div class="block left">
		    <div class="img bxs">
		        <a href="'.$link1.'"><img src="'.$newhome['imagen'].'" width="214" height="154" alt="" /></a>
		    </div>
		    <!-- .img -->
		    <div class="title">
		        <h3><a href="'.$link1.'">'.$newhome['title'].'</a></h3>
		    </div>
		    <!-- .title -->
		</div>
		<!-- .block -->';
            }
    return $out;
}


//----------------------------------------- NEW ------------------------------------------------------

function main_menu()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category, masterid FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND   menuid = 1 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position asc;"; 
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$aa = $storage->section["id"];
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
		
		
//		menu-selected
		if($storage->section["id"]==12) $aa = 10;
		if($storage->section["level"]>1) $aa = db_retrieve('id', c("table.pages"), 'idx', $storage->section["masterid"], " LIMIT 1");
		if($storage->section["menuid"]==6) $aa = 3;
		if($storage->section["menuid"]==7) $aa = 4;
		if(isset($sections[$idx]['menutitle']) && $sections[$idx]['menutitle']=="მთავარი" || $sections[$idx]['menutitle']=="Home" || $sections[$idx]['menutitle']=="Главная"){ continue; }
        $out .= '<li '.(($sections[$idx]["id"] == $aa) ? 'class="menu-item active"':'menu-item').'>'."\n";
        $out .= '<a href="' . $link . '" >' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		if($sections[$idx]['category']!=12) { 
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 111 AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			$out .= '<ul class="sub-menu">'."\n";
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li class="menu-item">'."\n";
				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 111 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<div class="sub s2"><ul>'."\n";
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++)
					{
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li>'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['menutitle'] . '</a>'."\n";
						$sql_in3 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 11 AND deleted = 0 AND masterid = " . $sections_in2[$idx_in2]['idx'] . " AND visibility = 'true' ORDER BY position;";	
					$sections_in3 = db_fetch_all($sql_in3);
						if(count($sections_in3) > 0) {
							$out .= '<div class="sub s2"><ul>'."\n";
							for ($idx_in3 = 0, $num_in3 = count($sections_in3); $idx_in3 < $num_in3; $idx_in3++)
							{
								$link_in3 = (($sections_in3[$idx_in3]['redirectlink'] == '') || ($sections_in3[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in3[$idx_in3]['id']) : $sections_in3[$idx_in3]['redirectlink'];
								$out .= '<li>'."\n";
								$out .= '<a href="' . $link_in3 . '">' . $sections_in3[$idx_in3]['menutitle'] . '</a>'."\n";
								$out .= '</li>'."\n";
							}
							$out .= '</ul>'."\n";
						} else {
							$out .= ''."\n";
						}
						$out .= '</li>'."\n";
					}
					$out .= '</ul>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
            $out .= '</ul>'."\n";
		} else {
	        $out .= ''."\n";
		}
        }
		$out .= '</li>'."\n";
    }
    return $out;
}

function footer_menu2($id)
{
    $sql = "SELECT level, title, idx, redirectlink, menutitle, template, masterid FROM " . c("table.pages") . " WHERE id=".$id." and language='".l()."';";
	$lvl = db_fetch($sql);
	if($lvl["level"] == 1) $master = $lvl["idx"] ; else $master=$lvl["masterid"];
    $sql = "SELECT title FROM " . c("table.pages") . " WHERE idx=".$master.";";
	$main = db_fetch($sql);
	
	$out = '';

	$out .= '<h2>'.$main["title"].'</h2><ul>'."\n";
    $sql = "SELECT id, title, idx, redirectlink, menutitle, template FROM " . c("table.pages") . " WHERE masterid=".$master." ORDER BY position;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return $out;
    for ($idx = 0, $num = count($sections); $idx < $num; $idx++)
    {
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
        $out .= '<li><a href="' . $link . '" >'.(($sections[$idx]['menutitle']!='') ? $sections[$idx]['menutitle']:$sections[$idx]['title']).'</a></li>'."\n";
    }
	$out .= '</ul>';
    return $out;
}

function footer_menu()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category, masterid FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id = 37 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position asc;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$aa = $storage->section["id"];
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
		$out .= '<div class="foot-list left">'."\n";
		
//		menu-selected
		if($storage->section["id"]==12) $aa = 10;
		if($storage->section["level"]>1) $aa = db_retrieve('id', c("table.pages"), 'idx', $storage->section["masterid"], " LIMIT 1");
		if($storage->section["menuid"]==6) $aa = 3;
		if($storage->section["menuid"]==7) $aa = 4;
		
        $out .= '<h2>' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</h2>'."\n";
		if($sections[$idx]['category']!=12) { 
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			$out .= '<ul>'."\n";
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li>'."\n";
//				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<ul>'."\n";
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++)
					{
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li class="left" style="width:120px;">'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['menutitle'] . '</a>'."\n";
					}
					$out .= '</ul>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
            $out .= '</ul>'."\n";
		} else {
	        $out .= ''."\n";
		}
        }
		$out .= '</div>'."\n";
    }
    return $out;
}

function news_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 58 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
	$date = date_create($newhome['pagedate']);
	
		$i++;
		$out .= '
                <article class="news left">
                    <header class="title">
                        <h2><a href='.$link.'>' . $newhome['title'] . '</a></h2>
                    </header>
                    <div class="text">' . $newhome['description'] . '</div>
					
                    <div class="date">' . date_format($date, 'm/d/Y') . '</div>
                 
                </article>
				';
		}								
	return $out;
	}

function Announcements_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 24 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '
                <div class="news fix">
                    <div class="date left"><span>'.date("d", strtotime($newhome['pagedate'])).'</span> '.date("M", strtotime($newhome['pagedate'])).'</div>
                    <!-- .date left -->
                    <div class="info">
                        <div class="title">
                            <h3><a href="'.$link.'">' . $newhome['title'] . '</a></h3>
                        </div>
                        <!-- .title -->
                        <div class="text">'. strip_tags($newhome['description']) .'</div>
                        <!-- .text -->
                    </div>
                    <!-- .info -->
                </div>
				';
		}								
	return $out;
	}

function features(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 23 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '
                <div class="news fix">';
				if($newhome['imagen']!='NULL'){
                    $out .= '<div class="img left">
					 <a href="'.$link.'"><img src="crop.php?img='.$newhome['imagen'].'&width=115&height=75" width="115" height="75" alt="'.$newhome["title"].'" title="'.$newhome["title"].'"></a>
                    </div>';
				}
                    $out .= '<div class="info">
                        <div class="title">
                            <h3><a href="'.$link.'">' . $newhome['title'] . '</a></h3>
                        </div>
                        <!-- .title -->
                        <div class="text">'. strip_tags($newhome['description']) .'</div>
                        <!-- .text -->
                    </div>
                    <!-- .info -->
                </div>
				';
		}								
	return $out;
	}

function right_banners()
{
	$sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 51 AND language = '" . l() . "' AND deleted=0  AND visibility = 'true' ORDER BY position;";
    $banners = db_fetch_all($sql);
    if (empty($banners))
        return NULL;
    $out = NULL;
	$i=0;
	foreach ($banners AS $banner) {
		$i++;
		$out .= '
            <div class="banner">
                <a href="'.$banner["itemlink"].'" target="_blank"><img src="crop.php?img='.$banner['file'].'&width=378&height=138" width="378" height="138" alt="'.$banner["title"].'" title="'.$banner["title"].'" /></a>
            </div>
				 '."\n";
	}
    return $out;
}

function Alumni(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 55 order by position limit 0, 1;";
	$Alumni = db_fetch_all($sql);
    if (empty($Alumni))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($Alumni AS $Alumn) {
	$link = href($Alumn['id']);
		$i++;
		$out .= '
				<div class="inner fix">';
				if($Alumn['imagen']!='NULL'){
                    $out .= '
						<div class="img left">
							<a href="'.$link.'"><img src="crop.php?img='.$Alumn['imagen'].'&width=125&height=150" width="125" height="150" alt="'.$Alumn["title"].'"></a>
						</div>';
				}
                    $out .= '
						<div class="title">
							<h3>' . $Alumn['title'] . '</h3>
						</div>
						<!-- .title -->
						<div class="text">'. $Alumn['description'] .'</div>
						<!-- .text -->
				</div>
				';
		}								
	return $out;
	}

function main_menu2()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category, masterid FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id=8 AND menuid = 1 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position asc;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$aa = $storage->section["id"];
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
		$out .= '<li '.(($sections[$idx]["id"] == $aa) ? 'class="active"':'').'>'."\n";
		
//		menu-selected
		if($storage->section["id"]==12) $aa = 10;
		if($storage->section["level"]>1) $aa = db_retrieve('id', c("table.pages"), 'idx', $storage->section["masterid"], " LIMIT 1");
		if($storage->section["menuid"]==6) $aa = 3;
		if($storage->section["menuid"]==7) $aa = 4;
		
//        $out .= '<a href="' . $link . '" >' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		if($sections[$idx]['category']!=12) { 
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<div class="sub s1"><ul>'."\n";
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++)
					{
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li>'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['menutitle'] . '</a>'."\n";
						$out .= '</li>'."\n";
					}
					$out .= '</ul></div>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
		} else {
	        $out .= ''."\n";
		}
        }
		$out .= '</li>'."\n";
    }
    return $out;
}

/* -------------------------------------------- G Functions ------------------------------------------------------ */
function g_language(){
	$l = l();
	$language_list = array(
		"ge"=>"ge.png",
		"en"=>"en.jpg", 		 
		"ru"=>"ru.jpg"
	);
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	if(
		!preg_match('/\/ge\//', $actual_link, $matches, PREG_OFFSET_CAPTURE) &&
		!preg_match('/\/en\//', $actual_link, $matches, PREG_OFFSET_CAPTURE) && 
		!preg_match('/\/ru\//', $actual_link, $matches, PREG_OFFSET_CAPTURE) 
	){
		$actual_link = $actual_link.l()."/home";
	}
	

	switch ($l) {
		case 'en':
			$current_image = $language_list["en"];
			$input_lang = "en";
			break;
		case 'ru':
			$current_image = $language_list["ru"];
			$input_lang = "ru";
			break;
		default:
			$current_image = $language_list["ge"]; 
			$input_lang = "ge";
			break;
	}

	/* Input Language */
	$out = sprintf(
		"<input type=\"hidden\" name=\"input_lang\" id=\"input_lang\" class=\"input_lang\" value=\"%s\" />\n",
		$input_lang
	);

	/* Current Language */
	$out .= sprintf(
		"<a href=\"javascript:void(0)\"><img src=\"%s/img/%s\" /></a>\n",
		WEBSITE, 
		$current_image
	);
	/* Other languages */
	$out .= "<div class=\"AllLanguage\">\n";
	foreach ($language_list as $key => $img) {
		if($key==$l){ continue; }

		$url = str_replace("/".l()."/", "/".$key."/", $actual_link);

		$out .= sprintf(
			"<a href=\"%s\"><img src=\"%s/img/%s\" /></a>\n",
			$url, 
			WEBSITE, 
			$img
		);
	}
	$out .= "<div class=\"ForBorder\"></div>\n"; 
	$out .= "</div>\n"; 

	return $out;
}

function g_slider(){

	$slider = db_fetch_all("
		SELECT *, 
		`id` as catid,
		`city` as mycity, 
		(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."' and `pages`.`deleted`=0) as slugx, 
		(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=mycity and `catalogs`.`language`='".l()."') as cityx
		FROM 
		`catalogs` 
		WHERE 
		`deleted`=0 and 
		`visibility`='true' and 
		`language`='".l()."' and 
		`catalogid` IN(7,8,9,10,11,20) and 
		`slider`=1
		ORDER BY `position` ASC LIMIT 10;");

	$out = "";
	foreach ($slider as $value) :
		$month = ($value["sale"]==10) ? "<span>/ ".l("month")."</span>" : ""; // ქირავდება
		$month = ($value["sale"]==12) ? "<span>/ ".l("daily")."</span>" : $month; // დღიური
		$supervip = ($value["supervip"]==1) ? "SuperVIPItem" : "VIPItem"; // SuperVIPItem or VIPItem
		$price = $value["price"]; // month or total

		$out .= sprintf(
			"<a href=\"/%s/%s/%s/%d\" class=\"Item %s\">",
			l(),
			$value["slugx"], 
			str_replace(array(" "), "-", $value["title"]), 
			$value["catid"], 
			$supervip
		);
		$out .= "<div class=\"Image\">\n";
		$out .= sprintf(
			"<img src=\"%s\" />",
			g_image($value["photo1"], 449, 400)
		);
		$out .= "</div>";

		$out .= "<div class=\"Info\">";
		
		$out .= sprintf(
			"<div class=\"Price\"> %s %s %s</div>", 
			$price, 
			($value["currency"]=="GEL") ? '<div class=\"BPGLARI\">A</div>' : '$',
			$month
		);

		$out .= "<div class=\"Info2\">";
		$out .= sprintf("<div class=\"Title\">%s</div>", $value["title"]);
		
		$out .= "<div class=\"Location\">";
		$out .= sprintf(
			"<i class=\"fa fa-circle-thin\"></i> %s",
			$value["cityx"]
		);
		$out .= "</div>";

		$out .= "</div>";
		$out .= "</div>";
		$out .= "</a>";


	endforeach;

	return $out;
}

function g_supervip(){
	$out = "";

	$supervip = db_fetch_all("
	SELECT *, 
	`id` as catid,
	`city` as mycity, 
	(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."' and `pages`.`deleted`=0) as slugx, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=mycity and `catalogs`.`language`='".l()."') as cityx
	FROM 
	`catalogs` 
	WHERE 
	`deleted`=0 and 
	`visibility`='true' and 
	`language`='".l()."' and 
	`catalogid` IN(7,8,9,10,11,20) and 
	`supervip`=1
	ORDER BY `position` LIMIT 15;");

	foreach ($supervip as $value):
		$month = ($value["sale"]==10) ? "<span>/ ".l("month")."</span>" : ""; // ქირავდება
		$month = ($value["sale"]==12) ? "<span>/ ".l("daily")."</span>" : $month; // დღიური
		$currency = ($value["currency"]=='GEL') ? "<div class=\"BPGLARI\">A</div>" : "$"; // lari vs dolari

		$out .= "<div class=\"ADSItemDiv\">";
		$out .= sprintf(
			"<a href=\"/%s/%s/%s/%d\" class=\"ADSitem SuperVIPItem\">",
			l(),
			$value["slugx"], 
			str_replace(array(" "), "-", $value["title"]), 
			$value["catid"]
		);
		$out .= sprintf(
			"<div class=\"Price Su\">%s %s %s</div>",
			$value["price"],
			$currency, 
			$month
		);
		$out .= sprintf(
			"<div class=\"Image\"><img src=\"%s\" alt=\"\" /></div>",
			g_image($value["photo1"], 196, 130)
		);
		$out .= sprintf(
			"<div class=\"Title\">%s</div>",
			$value["title"]
		);
		$out .= sprintf(
			"<div class=\"Location\"><i class=\"fa fa-circle-thin\"></i>%s</div>", 
			$value["cityx"]
		);
		$out .= "</a>";
		$out .= "</div>";
	endforeach;
	return $out;
}

function g_vip(){
	$out = "";

	$supervip = db_fetch_all("
	SELECT *, 
	`id` as catid, 
	`city` as mycity, 
	(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."' and `pages`.`deleted`=0) as slugx, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=mycity and `catalogs`.`language`='".l()."') as cityx
	FROM 
	`catalogs` 
	WHERE 
	`deleted`=0 and 
	`visibility`='true' and 
	`language`='".l()."' and 
	`catalogid` IN(7,8,9,10,11,20) and 
	`vip`=1
	ORDER BY `position` LIMIT 15;");

	foreach ($supervip as $value):
		$month = ($value["sale"]==10) ? "<span>/ ".l("month")."</span>" : ""; // ქირავდება
		$month = ($value["sale"]==12) ? "<span>/ ".l("daily")."</span>" : $month; // დღიური
		$currency = ($value["currency"]=="GEL") ? '<div class=\"BPGLARI\">A</div>' : '$'; // lari vs dolari

		$out .= "<div class=\"ADSItemDiv\">";
		$out .= sprintf(
			"<a href=\"/%s/%s/%s/%d\" class=\"ADSitem\">",
			l(),
			$value["slugx"], 
			str_replace(array(" "), "-", $value["title"]), 
			$value["catid"]
		);
		$out .= sprintf(
			"<div class=\"Price Su\">%s %s %s</div>",
			$value["price"],
			$currency, 
			$month
		);
		$out .= sprintf(
			"<div class=\"Image\"><img src=\"%s\" alt=\"\" /></div>",
			g_image($value["photo1"], 196, 130)
		);
		$out .= sprintf(
			"<div class=\"Title\">%s</div>",
			$value["title"]
		);
		$out .= sprintf(
			"<div class=\"Location\"><i class=\"fa fa-circle-thin\"></i>%s</div>", 
			$value["cityx"]
		);
		$out .= "</a>";
		$out .= "</div>";
	endforeach;
	return $out;
}

function g_homepage_list($sale, $catid){
	$out = array("html"=>"", "counted"=>0);

	$forsale = db_fetch_all("
	SELECT *, 
	`id` as catid, 
	`city` as mycity, 
	(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."') as slugx, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=mycity and `catalogs`.`language`='".l()."') as cityx, 
	(SELECT COUNT(`id`) FROM `catalogs` WHERE `deleted`=0 and `language`='".l()."' and `catalogid`=".(int)$catid." and `sale`=".(int)$sale." and `deleted`=0 and `visibility`='true') as counted 
	FROM 
	`catalogs` 
	WHERE 
	`deleted`=0 and 
	`visibility`='true' and 
	`language`='".l()."' and 
	`catalogid`=".(int)$catid." and
	`sale`=".(int)$sale."
	ORDER BY `position` LIMIT 5;");

	foreach ($forsale as $value):
		$month = ($value["sale"]==10) ? "<span>/ ".l("month")."</span>" : ""; // ქირავდება
		$month = ($value["sale"]==12) ? "<span>/ ".l("daily")."</span>" : $month; // დღიური
		$currency = ($value["currency"]=="GEL") ? '<div class="BPGLARI">A</div>' : '$';

		$out["html"] .= "<div class=\"ItemDiv\">";
		$out["html"] .= sprintf(
			"<a href=\"/%s/%s/%s/%d\" class=\"Item\">",
			l(),
			$value["slugx"], 
			str_replace(array(" "), "-", $value["title"]), 
			$value["catid"]
		);
		$out["html"] .= sprintf(
			"<div class=\"Image wowowo\"><img src=\"%s\" alt=\"\" /></div>", 
			g_image($value["photo1"], 168, 110)
		);
		$out["html"] .= sprintf(
			"<div class=\"ItemTitle\">%s</div>", 
			$value["title"]
		); 
		$out["html"] .= sprintf(
			"<div class=\"Price\">%s %s %s</div>",
			$value["price"],
			$currency, 
			$month
		);
		$out["html"] .= "</a>";
		$out["html"] .= "</div>";
		$out["counted"] = $value["counted"]; 
	endforeach;
	return $out;
}

function g_search($catid = 0, $counts = 0){

	// $sql = ""; 
	$catalogTypes = db_fetch_all("SELECT title, slug, attached, meta_desc FROM " . c("table.pages") . " WHERE id!=1 AND language = '" . l() . "' AND   menuid = 1 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position desc;");

	$saletypes = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=13 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");

	$status = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=30 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");

	$conditions = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=14 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
	$projects = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=15 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
	$cities = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=22 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");


	$out = "<div class=\"container-fluid padding_0\">\n";
	$out .= "<div class=\"\">\n";
	$out .= "<div class=\"container\">\n";
	$out .= "<div class=\"SearchDiv\">\n";
	$out .= "<div class=\"SearchForms\">\n";
	
	$out .= sprintf(
		"<div class=\"SearchTitle\">%s</div>\n", 
		l("search")
	);
	$out .= "<div class=\"row\">\n";

	// ID Start
	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<div class=\"input-group\" style=\"width:100%\">\n";

	$out .= "<span class=\"input-group-btn\" style=\"width:100%\">\n";	
	$out .= sprintf(
		"<input type=\"text\" class=\"form-control search_id\" id=\"search_id\" name=\"search_id\" value=\"%s\" placeholder=\"ID\" />\n",
		(isset($_GET["id"])) ? $_GET["id"] : ''
	); 
	$out .= "</span>\n"; 

	$out .= "</div>\n";
	$out .= "</div>\n";
	// ID End

	
	// Catalog Type Start
	$out .= "<div class=\"col-sm-2\">\n";	
	
	$out .= "<select class=\"selectpicker search_catalogtype\" id=\"search_catalogtype\" name=\"search_catalogtype\" data-style=\"btn-broker\">\n";
	
	$out .= sprintf(
		"<option value=\"\">%s</option>\n",
		l("Realestatetype")
	);
	foreach($catalogTypes as $type):
		$explode = explode("catalog", $type["attached"]);
		$catalogid = (int)$explode[1];
		$selected = ($catalogid==$catid) ? ' selected="selected"' : '';
		$out .= sprintf(
			"<option class='SelectSpan' value=\"%d\"%s data-content=\"<span><i class='%s' aria-hidden='true'></i></span> %s\"></option>\n",
			$catalogid,
			$selected, 
			$type["meta_desc"],
			$type["title"]
		);
	endforeach;
	$out .= "</select>\n";
	$out .= "</div>\n";
	// Catalog Type End

	// Sale TYpe Start
	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<select class=\"selectpicker search_saletype\" id=\"search_saletype\" name=\"search_saletype\" data-style=\"btn-broker\">\n";
	$out .= sprintf(
		"<option value=\"\">%s</option>\n", 
		l("TransactionType")
	);
	foreach ($saletypes as $value):
	$out .= sprintf(
		"<option value=\"%d\"%s>%s</option>\n", 
		$value["id"],
		(isset($_GET["saletype"]) && $value["id"]==$_GET['saletype']) ? ' selected="selected"' : '', 
		$value["title"]
	);
	endforeach;
	$out .= "</select>\n";
	$out .= "</div>\n";
	// Sale TYpe End

	// Status Start
	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<select class=\"selectpicker search_status\" id=\"search_status\" name=\"search_status\" data-style=\"btn-broker\">\n";
	$out .= sprintf(
		"<option value=\"\">%s</option>\n", 
		l("status")
	);
	foreach ($status as $value):
	$out .= sprintf(
		"<option value=\"%d\"%s>%s</option>\n", 
		$value["id"],
		(isset($_GET["statusType"]) && $value["id"]==$_GET['statusType']) ? ' selected="selected"' : '', 
		$value["title"]
	);
	endforeach;
	$out .= "</select>\n";
	$out .= "</div>\n";
	// Status End

	// cities Start
	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<select class=\"selectpicker search_city\" id=\"search_city\" name=\"search_city\" data-style=\"btn-broker\">\n";
	$out .= sprintf(
		"<option value=\"\">%s</option>\n",
		l("destination")
	);
	foreach ($cities as $value):
	$out .= sprintf(
		"<option value=\"%d\"%s>%s</option>\n", 
		$value["id"],
		(isset($_GET["city"]) && $value["id"]==$_GET['city']) ? ' selected="selected"' : '', 
		$value["title"]
	);
	endforeach;
	$out .= "</select>\n";
	$out .= "</div>\n";
	// cities End


	// Price From Start
	$price = (isset($_GET["price"])) ? $_GET["price"] : ""; 
	$price = @explode(":", $_GET["price"]); 
	$price = (isset($price[0]) && isset($price[1])) ? $price : array(0,0);

	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<div class=\"input-group\">\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:40%\">\n";
	$out .= sprintf(
		"<input type=\"text\" class=\"form-control search_from_price\" id=\"search_from_price\" name=\"search_from_price\" value=\"%d\" placeholder=\"%s\">\n",
		(int)$price[0], 
		l("from")
	);
	$out .= "</span>\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:40%\">\n";
	$out .= sprintf(
		"<input type=\"text\" class=\"form-control search_to_price\" id=\"search_to_price\" name=\"search_to_price\" value=\"%d\" placeholder=\"%s\">\n",
		(int)$price[1],
		l("to")
	);
	$out .= "</span>\n";
	// ### Currency Change Start
	$currency = (isset($_GET["currency"]) && $_GET["currency"]=="USD") ? "USD" : "GEL"; 
	$out .= "<span class=\"input-group-btn\" style=\"width:20%\">\n";
	$out .= "<div class=\"btn-group\" style=\"width:100%;\">\n";
	$out .= sprintf(
		"<input type=\"hidden\" name=\"search_currency\" class=\"search_currency\" id=\"search_currency\" value=\"%s\">", 
		$currency
	);	
	
	$out .= "<button class=\"ChangeGEL btn dropdown-toggle search_currency_button\" type=\"button\" data-toggle=\"dropdown\">";
	if($currency=="USD"){
		$out .= "$";
	}else{
		$out .= "<div class=\"BPGLARI\">A</div>";
	}
	$out .= "</button>\n";
	
	$out .= "<ul class=\"dropdown-menu open ChangeGelDropdown\">\n";
	$out .= sprintf(
		"<li><a href=\"javascript:void(0)\" class=\"search_currency_change\">%s</a></li>\n", 
		($currency=="USD") ? "<div class=\"BPGLARI\">A</div>" : "$"
	);
	$out .= "</ul>\n";

	$out .= "</div> \n";
	$out .= "</span>\n";
	// ### Currency Change END

	$out .= "</div>\n";
	$out .= "</div>\n";
	// Price From End


	$out .= "<div id=\"DetailedSearch\" class=\"col-sm-12 collapse padding_0\">\n";
	$out .= "<div class=\"DetailedSearch\">\n";

	// floor start
	$floor = (isset($_GET["floor"])) ? $_GET["floor"] : ""; 
	$floor = @explode(":", $_GET["floor"]); 
	$floor = (isset($floor[0]) && isset($floor[1])) ? $floor : array(0,0);

	$out .= "<div class=\"col-sm-2\" style=\"margin-bottom:6px;\">\n";
	$out .= "<div class=\"input-group\">\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:44%\">\n";
	$out .= sprintf(
		"<button class=\"btn BtnName\" type=\"button\">%s</button>\n",
		l("floor")
	);
	$out .= "</span>\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:28%\">\n";
	
	$out .= sprintf(
		"<input type=\"text\" class=\"form-control search_from_floor\" id=\"search_from_floor\" name=\"search_from_floor\" value=\"%s\" placeholder=\"%s\">\n",
		$floor[0], 
		l("from")
	);
	$out .= "</span>\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:28%\">\n";
	$out .= sprintf(
		"<input type=\"text\" class=\"form-control search_to_floor\" id=\"search_to_floor\" name=\"search_to_floor\" value=\"%s\" placeholder=\"%s\">\n",
		$floor[1], 
		l("to")
	);
	
	$out .= "</span>\n";
	$out .= "</div>\n";
	$out .= "</div>\n";
	// floor End


	// kv metri start
	$kvm = (isset($_GET["kvm"])) ? $_GET["kvm"] : ""; 
	$kvm = @explode(":", $_GET["kvm"]); 
	$kvm = (isset($kvm[0]) && isset($kvm[1])) ? $kvm : array(0,0);

	$out .= "<div class=\"col-sm-2\" style=\"margin-bottom:6px;\">\n";
	$out .= "<div class=\"input-group\">\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:44%\">\n";
	$out .= sprintf(
		"<button class=\"btn BtnName\" type=\"button\">%s</button>\n",
		l("kvm")
	);
	$out .= "</span>\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:28%\">\n";
	
	$out .= sprintf(
		"<input type=\"text\" class=\"form-control search_from_kvm\" id=\"search_from_kvm\" name=\"search_from_kvm\" value=\"%s\" placeholder=\"%s\">\n",
		$kvm[0], 
		l("from")
	);
	$out .= "</span>\n";
	$out .= "<span class=\"input-group-btn\" style=\"width:28%\">\n";
	$out .= sprintf(
		"<input type=\"text\" class=\"form-control search_to_kvm\" id=\"search_to_kvm\" name=\"search_to_kvm\" value=\"%s\" placeholder=\"%s\">\n",
		$kvm[1], 
		l("to")
	);
	
	$out .= "</span>\n";
	$out .= "</div>\n";
	$out .= "</div>\n";
	// kv metri End

	// Condition Start
	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<select class=\"selectpicker search_condition\" id=\"search_condition\" name=\"search_condition\" data-style=\"btn-broker\">\n";
	$out .= sprintf(
		"<option value=\"\">%s</option>\n", 
		l("condition")
	);
	foreach ($conditions as $value):
	$out .= sprintf(
		"<option value=\"%d\"%s>%s</option>\n", 
		$value["id"],
		(isset($_GET["condition"]) && $value["id"]==$_GET["condition"]) ? ' selected="selected"' : '',
		$value["title"]
	);
	endforeach;
	$out .= "</select>\n";
	$out .= "</div>\n";
	// Condition End

	// rooms start
	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<select class=\"selectpicker search_room\" id=\"search_room\" name=\"search_room\" data-style=\"btn-broker\">\n";
	$out .= sprintf("<option value=\"\">%s</option>\n", l("room"));
	for($i=1; $i<=13; $i++):
	$out .= sprintf(
		"<option value=\"%d\"%s>%d</option>\n", 
		$i, 
		(isset($_GET["room"]) && $i==$_GET['room']) ? ' selected="selected"' : '', 
		$i 
	);
	endfor;
	$out .= "</select>\n";
	$out .= "</div>\n";
	// rooms end

	// Project Start
	$out .= "<div class=\"col-sm-2\">\n";
	$out .= "<select class=\"selectpicker search_project\" id=\"search_project\" name=\"search_project\" data-style=\"btn-broker\">\n";
	$out .= sprintf(
		"<option value=\"\">%s</option>\n", 
		l("project")
	);
	foreach ($projects as $value):
	$out .= sprintf(
		"<option value=\"%d\"%s>%s</option>\n", 
		$value["id"],
		(isset($_GET["project"]) && $value["id"]==$_GET["project"]) ? ' selected="selected"' : '',
		$value["title"]
	);
	endforeach;
	$out .= "</select>\n";
	$out .= "</div>\n";
	// Project End

	$out .= "</div>\n";
	$out .= "</div>\n";

	$out .= "</div>\n";
	$out .= "<div class=\"DetailedSearchButton collapsed\" data-toggle=\"collapse\" data-target=\"#DetailedSearch\">\n";
	$out .= "<span></span>\n";
	$out .= l("detailedsearch")."\n";
	$out .= "</div>\n";
	$out .= sprintf(
		"<button class=\"SearchCleanUp\">%s</button>\n",
		l("cleanup")
	);
	$out .= "</div>\n";
	$out .= sprintf(
		"<button class=\"SearchResultCount search_submit_button\">%s <span>%s</span></button>\n", 
		l("found"), 
		number_format((int)$counts, 0, '', ' ')
	);
	$out .= "</div>\n";

	$out .= "<div class=\"HomeADSSlider SuperVIP row\">";
	$out .= "<div class=\"AdsCategoryTitle Super\">";
	$out .= "<i class=\"fa fa-star\" aria-hidden=\"true\"></i>";
	$out .= sprintf("SUPER VIP %s</div>", l("ads"));
	$out .= "<div class=\"HomeDivForSlider\">";			
	$out .= g_supervip();
	$out .= "</div>";
	$out .= "</div>";


	$out .= "</div>\n";
	$out .= "</div>\n";
	$out .= "</div>\n";

	// $out .= "<script type=\"text/javascript\">\n";
	// $out .= "$('#DetailedSearch').collapse();\n";
	// $out .= "</script>\n";

	return $out;
}


function g_pagination($total, $itemPerPage, $searchpage = false){
	/* <li><a nohref>...</a></li> */
	$queryString = "";
	if($searchpage){
		$sid = (isset($_GET['id'])) ? $_GET['id'] : '';
		$scatalogtype = (isset($_GET['catalogtype'])) ? $_GET['catalogtype'] : '';
		$ssaletype = (isset($_GET['saletype'])) ? $_GET['saletype'] : '';
		$scity = (isset($_GET['city'])) ? $_GET['city'] : '';
		$sroom = (isset($_GET['room'])) ? $_GET['room'] : '';
		$sprice = (isset($_GET['price'])) ? $_GET['price'] : '';
		$scurrency = (isset($_GET['currency']) && $_GET["currency"]=="USD") ? 'USD' : 'GEL';
		$sfloor = (isset($_GET['floor'])) ? $_GET['floor'] : '';
		$scondition = (isset($_GET['condition'])) ? $_GET['condition'] : '';
		$sproject = (isset($_GET['project'])) ? $_GET['project'] : '';

		$queryString = sprintf(
			"&id=%s&catalogtype=%s&saletype=%s&city=%s&room=%s&price=%s&currency=%s&floor=%s&condition=%s&project=%s",
			$sid, 
			$scatalogtype, 
			$ssaletype, 
			$scity, 
			$sroom, 
			$sprice, 
			$scurrency, 
			$sfloor, 
			$scondition, 
			$sproject 
		);

	}

    $link = explode("?", $_SERVER['REQUEST_URI']);
    $link = $link[0];
    $pages = ceil($total / $itemPerPage);
    $current_page = (isset($_GET['page']) && $_GET['page']>0) ? (int)$_GET['page'] : 1;

	$out = "<ul>";

	// FIRST PAGE
	$out .= "<li class=\"Different left\">";
	$out .= sprintf(
		"<a href=\"%s?page=1%s\"><i class=\"fa fa-angle-left\"></i></a>", 
		$link, 
		$queryString
	);
	$out .= "</li>";

	// PREV PAGE
	$back = ($current_page>1) ? $link.'?page='.((int)$current_page-1).$queryString : $link.'?page=1'.$queryString;
	$out .= "<li class=\"Different left\">";
	$out .= sprintf("<a href=\"%s\">", $back);
	$out .= "<i class=\"fa fa-angle-left\"></i>";
	$out .= "<i class=\"fa fa-angle-left\"></i>";
	$out .= "</a>";
	$out .= "</li>";

	// PREV 2 PAGE && PREV 1 PAGE
	if((($current_page-2) > 0) && $pages>=$current_page){
		$left_prev_prev = $current_page - 2;
		$left_prev = $current_page - 1;
		$out .= sprintf("<li><a href=\"%s\">%d</a></li>", $link.'?page='.$left_prev_prev.$queryString, $left_prev_prev);
		$out .= sprintf("<li><a href=\"%s\">%d</a></li>", $link.'?page='.$left_prev.$queryString, $left_prev);
	}else if((($current_page-1) > 0) && $pages>=$current_page) {
		$left_prev = $current_page - 1;
		$out .= sprintf("<li><a href=\"%s\">%d</a></li>", $link.'?page='.$left_prev.$queryString, $left_prev);
	}

	// ACTIVE PAGE
	$out .= sprintf(
		"<li class=\"active\"><a href=\"javascript:void(0)\">%d</a></li>", 
		($current_page>=1) ? $current_page : 1
	);

	// NEXT 2 PAGE && NEXT 1 PAGE
	if((($current_page+2) <= $pages) && $pages>=$current_page){
		$left_next_next = $current_page + 2;
		$left_next = $current_page + 1;
		$out .= sprintf("<li><a href=\"%s\">%d</a></li>", $link.'?page='.$left_next.$queryString, $left_next);
		$out .= sprintf("<li><a href=\"%s\">%d</a></li>", $link.'?page='.$left_next_next.$queryString, $left_next_next);		
	}else if(($current_page+1) <= $pages && $pages>=$current_page) {
		$left_next = $current_page + 1;
		$out .= sprintf("<li><a href=\"%s\">%d</a></li>", $link.'?page='.$left_next.$queryString, $left_next);
	}

	// LAST PAGE 
	$out .= "<li class=\"Different right\">";
	$out .= sprintf(
		"<a href=\"%s\"><i class=\"fa fa-angle-right\"></i></a>", 
		$link."?page=".$pages.$queryString
	);
	$out .= "</li>";

	
	// NEXT PAGE
	$next = ($current_page<$pages) ? $link.'?page='.((int)$current_page+1).$queryString : $link.'?page='.$pages.$queryString;
	$out .= "<li class=\"Different right\">";
	$out .= sprintf("<a href=\"%s\">", $next);
	$out .= "<i class=\"fa fa-angle-right\"></i>";
	$out .= "<i class=\"fa fa-angle-right\"></i>";
	$out .= "</a>";
	$out .= "</li>";

	$out .= "</ul>";

	return $out;
}

function g_user_exists($email, $password = false){
	$passSql = ($password) ? " AND `userpass`='".md5($password)."'" : "";
	$userSql = "SELECT * FROM `site_users` WHERE `username`='".$email."' AND `deleted`=0".$passSql;

	$userFetch = db_fetch($userSql);
	if(isset($userFetch["id"]) && !empty($userFetch["id"])){
		return $userFetch;
	}
	return false;
}

function g_random_exists($random){
	$randomSql = "SELECT `id` FROM `site_users` WHERE `random`='".$random."' AND `deleted`=0";

	$randomFetch = db_fetch($randomSql);
	if(isset($randomFetch["id"]) && !empty($randomFetch["id"])){

		$updateActivation = "UPDATE `site_users` SET `active`=1, `random`='' WHERE `id`=".$randomFetch["id"];
		db_query($updateActivation); 

		return $randomFetch;
	}
	return false;
}

function g_random_recovery_exists($recover_code){
	$randomSql = "SELECT `id` FROM `site_users` WHERE `recovery_random`='".$recover_code."' AND `deleted`=0";

	$randomFetch = db_fetch($randomSql);
	if(isset($randomFetch["id"]) && !empty($randomFetch["id"])){
		return $randomFetch;
	}
	return false;
}

function g_recover_password($recovery, $password){
	$query = "UPDATE `site_users` SET `userpass`='".md5($password)."', `recovery_random`='' WHERE `recovery_random`='".$recovery."'"; 
	$dojob = db_query($query);
	return $dojob;
}

function g_send_email($args){
	if(file_exists("_plugins/PHPMailer/PHPMailerAutoload.php")){
		require_once("_plugins/PHPMailer/PHPMailerAutoload.php");
		

		$out = false;	
		$mail = new PHPMailer;
		// $mail->SMTPDebug = 1; 

		$mail->isSMTP(); 
		$mail->CharSet = 'UTF-8';
		$mail->Host = "mail.batumibroker.ge";
		$mail->SMTPAuth = true;
		$mail->Username = "hosting@batumibroker.ge";
		$mail->Password = "]ABl@ok)hv[S";
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom("hosting@batumibroker.ge", "Batumi Broker");
		$mail->addAddress($args["sendTo"]); 
		$mail->addReplyTo("hosting@batumibroker.ge");
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// $mail->addAttachment('/var/tmp/file.tar.gz');         
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   
		$mail->isHTML(true);                                  

		$mail->Subject = $args['subject'];
		$mail->Body = $args['body'];
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		    $out = false;
		} else {
		    $out = true;
		}
	}
}

function g_facebook_sdk(){
	require_once("_plugins/php-graph-sdk-5.x/src/Facebook/autoload.php"); 
	$fb = new Facebook\Facebook([
		'app_id' => '162785324322546',
		'app_secret' => 'bb51e546aa4546f8ffc747f44b363b96',
		'default_graph_version' => 'v2.2', 
		'persistent_data_handler'=>'session'
	]);
	return $fb;
}

function g_facebooklogin(){
	try{
		$fb = g_facebook_sdk();
		$oHelper = $fb->getRedirectLoginHelper();
		$oAccessToken = $oHelper->getAccessToken();
		if ($oAccessToken !== null) {
		    $oResponse = $fb->get('/me?fields=id,name,email', $oAccessToken);
		    $responce = $oResponse->getGraphUser();
		    $facebookID = $responce["id"];
		    $facebookNAME = $responce["name"];
		    $fecebookEMAIL = $responce["email"];

		    $query = "SELECT `id`, `firstname` FROM `site_users` WHERE `username`='".trim($fecebookEMAIL)."' AND `deleted`=0"; 
		    $fetch = db_fetch($query);

		    if(!empty($fetch["id"])){
		    	$_SESSION["batumibroker_username"] = $fecebookEMAIL;
		    	$firstname = ($fetch["firstname"]=="New User") ? $facebookNAME : $fetch["firstname"];
		    	$update = "UPDATE `site_users` SET `facebookid`='".$facebookID."', `firstname`='".$firstname."', `active`=1 WHERE `username`='".$fecebookEMAIL."' AND `deleted`=0";
		    	db_query($update);
		    }else{
		    	$insert = db_insert("site_users", array(
								'firstname' => $facebookNAME,
								'username' => $fecebookEMAIL,
								'facebookid' => $facebookID,
								'userpass' => md5($facebookID),
								'email' => $fecebookEMAIL,
								'active' => 1,
								'banned' => 0,
								'deleted' => 0,
								'regdate' => date("Y-m-d")
							));
				if(db_query($insert)){
					$_SESSION["batumibroker_username"] = $fecebookEMAIL;
				}
		    }
		}
	}catch(Exception $e){
		
	}
}

function g_userinfo(){
	$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
	$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;
	$userinfo = "SELECT * FROM `site_users` WHERE `username`='".$username."'";
	$query = db_fetch($userinfo);
	return $query;
}

function g_userinfo_byid($id){
	$userinfo = "SELECT * FROM `site_users` WHERE `id`='".$id."'";
	$query = db_fetch($userinfo);
	return $query;
}

function g_checkpassword(){
	$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
	$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;
	$pass = "SELECT `userpass` FROM `site_users` WHERE `username`='".$username."' AND `deleted`=0";
	$query = db_fetch($pass);
	return (isset($query["userpass"])) ? $query["userpass"] : "false";
}

function g_logoupload(){
	if(isset($_FILES["logoUploadInput"]["name"])){
		$check = getimagesize($_FILES["logoUploadInput"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	        $uploadOk = 0;
	        return false;
	    }

	    $fend = explode(".", $_FILES["logoUploadInput"]["name"]);
		$ext = end($fend);

		if(
			$ext=="jpg" || 
			$ext=="jpeg" || 
			$ext=="png" || 
			$ext=="gif"
		){
			$uploadOk = 1;
		}else{
			$uploadOk = 0;
	        return false;
		}

		$target_dir = "files/avatars/webusers/";
		$newFileName = time().".".$ext;
		$path = $target_dir . $newFileName; 
		$fullPath = WEBSITE_BASE.$path;

		if(!file_exists($path)){
			$uploadOk = 1;
		}else{
			$uploadOk = 0;
	        return false;
		}

		if (move_uploaded_file($_FILES["logoUploadInput"]["tmp_name"], $path)) {
			$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
			$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;
			
			$selectOld = "SELECT `avatar` FROM `site_users` `username`='".$username."' AND `deleted`=0"; 
			$fetch = db_fetch($selectOld);
			if(isset($fetch['avatar'])){
				$old_avatar = explode(WEBSITE_BASE, $fetch['avatar']); 
				@unlink($old_avatar); 
			}

			$updateImage = "UPDATE `site_users` SET `avatar`='".$fullPath."' WHERE `username`='".$username."' AND `deleted`=0"; 
			db_query($updateImage);	
			header("Refresh:0");	

	        exit();
	    }

	    return false;
	}
}

function g_checkiffavourites($productid){
	$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
	$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;

	$select = "SELECT `id` FROM `favourites` WHERE `catid`='".$productid."' AND `username`='".$username."' ORDER BY `id` DESC LIMIT 1";
	$fetch = db_fetch($select);
	if(isset($fetch["id"]) && !empty($fetch['id'])){
		return true;
	}
	return false;
}

function g_countfavourites(){
	$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
	$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;

	$select = "SELECT count(`id`) as counted FROM `favourites` WHERE `username`='".$username."'";
	$fetch = db_fetch($select);
	return (int)$fetch["counted"];
}

function g_myfavourites(){
	$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
	$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;

	$select = "SELECT 
	(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."') as slugx, 
	(SELECT `site_users`.`avatar` FROM `site_users` WHERE `site_users`.`active`=1 AND `site_users`.`banned`=0 AND `site_users`.`id`=1) as admin_avatar, 
	`catalogs`.* 
	FROM 
	`favourites`, `catalogs` 
	WHERE 
	`favourites`.`username`='".$username."' AND 
	`favourites`.`catid`=`catalogs`.`id` AND 
	`catalogs`.`deleted`=0 AND 
	`catalogs`.`visibility`='true' AND 
	`catalogs`.`language`='".l()."' 
	ORDER BY `favourites`.`id` DESC
	";
	$fetch = db_fetch_all($select);

	return $fetch;
}

function g_myadds(){
	$username = (isset($_SESSION["batumibroker_username"])) ? $_SESSION["batumibroker_username"] : '';
	$username = (isset($_COOKIE["batumibroker_username"])) ? $_COOKIE["batumibroker_username"] : $username;

	$select = "SELECT 
	(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."') as slugx, 
	(SELECT `site_users`.`avatar` FROM `site_users` WHERE `site_users`.`active`=1 AND `site_users`.`banned`=0 AND `site_users`.`id`=1) as admin_avatar, 
	`catalogs`.* 
	FROM 
	`site_users`, `catalogs` 
	WHERE 
	`site_users`.`username`='".$username."' AND 
	`site_users`.`id`=`catalogs`.`administrator` AND 
	`catalogs`.`deleted`=0 AND 
	`catalogs`.`language`='".l()."' 
	ORDER BY `catalogs`.`position` ASC
	";

	// echo $select;
	$fetch = db_fetch_all($select);

	return $fetch;
}

function g_search_page_items($per_page){
	$page = (isset($_GET["page"]) && !empty($_GET["page"]) && $_GET["page"]>0) ? (int)$_GET["page"] : 1;
	$limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";

	$where = "";
					
	if(isset($_GET["id"]) && !empty($_GET["id"])){
		$where .= " AND `id`=".(int)$_GET["id"];
	}else{
		if(isset($_GET["catalogtype"]) && !empty($_GET["catalogtype"])){
			$where .= " AND `catalogid`=".(int)$_GET["catalogtype"];
		}else{
			$where .= " AND `catalogid` IN(7,8,9,10,11,20)";
		}

		if(isset($_GET["saletype"]) && !empty($_GET["saletype"])){
			$where .= " AND `sale`=".(int)$_GET["saletype"];
		}

		if(isset($_GET["status"]) && !empty($_GET["status"])){
			$where .= " AND `status`=".(int)$_GET["status"];
		}

		if(isset($_GET["city"]) && !empty($_GET["city"])){
			$where .= " AND `city`=".(int)$_GET["city"];
		}

		if(isset($_GET["room"]) && !empty($_GET["room"]) && $_GET["room"]!="0"){
			$where .= " AND `rooms`=".(int)$_GET["room"];
		}

		if(isset($_GET["price"]) && !empty($_GET["price"])){
			$sprice = explode(":", $_GET["price"]); 
			if(isset($sprice[0]) && $sprice[0]>0){
				$where .= " AND convert(`price`, unsigned)>=".(int)$sprice[0];
			}

			if(isset($sprice[1]) && $sprice[1]>0){
				$where .= " AND convert(`price`, unsigned)<=".(int)$sprice[1];
			}

			if(isset($_GET["currency"]) && !empty($_GET["currency"]) && ((int)$sprice[0]>0 || (int)$sprice[1]>0) ){
				$currency = "GEL";
				if($_GET["currency"]=="USD"){ $currency = "USD"; }
				$where .= " AND `currency`='".$currency."'";
			}
		}

		

		if(isset($_GET["floor"]) && !empty($_GET["floor"])){
			$sfloor = explode(":", $_GET["floor"]); 
			if(isset($sfloor[0]) && $sfloor[0]>0){
				$where .= " AND convert(`floor`, unsigned)>=".(int)$sfloor[0];
			}

			if(isset($sfloor[1]) && $sfloor[1]>0){
				$where .= " AND convert(`floor`, unsigned)<=".(int)$sfloor[1];
			}
		}

		if(isset($_GET["kvm"]) && !empty($_GET["kvm"])){
			$sKvm = explode(":", $_GET["kvm"]); 
			if(isset($sKvm[0]) && $sKvm[0]>0){
				$where .= " AND convert(`square`, unsigned)>=".(int)$sKvm[0];
			}

			if(isset($sKvm[1]) && $sKvm[1]>0){
				$where .= " AND convert(`square`, unsigned)<=".(int)$sKvm[1];
			}
		}

		if(isset($_GET["condition"]) && !empty($_GET["condition"]) && $_GET["condition"]!="0"){
			$where .= " AND `condition`=".(int)$_GET["condition"];
		}
		
		if(isset($_GET["project"]) && !empty($_GET["project"]) && $_GET["project"]!="0"){
			$where .= " AND `project`=".(int)$_GET["project"];
		}
	}
	//AND `catalogid` IN(7,8,9,10,11)
	$sql = "SELECT 
	`catalogs`.*, 
	(SELECT count(`id`) FROM `catalogs` WHERE `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "'".$where.") as count, 
	(SELECT `site_users`.`avatar` FROM `site_users` WHERE `site_users`.`active`=1 AND `site_users`.`banned`=0 AND `site_users`.`id`=1) as admin_avatar, 
	(SELECT `pages`.`slug` FROM `pages` WHERE `pages`.`attached`=concat('catalog',`catalogs`.`catalogid`) and `pages`.`language`='".l()."' and `pages`.`deleted`=0) as slugx 
	FROM 
	`catalogs` 
	WHERE 
	`deleted`=0 AND 
	`visibility`='true' AND 
	`language` = '" . l() . "'".$where."
	ORDER BY `position` DESC {$limit};";



	$items = db_fetch_all($sql);
	return $items;
}


function g_image($f, $w, $h, $grey = false, $wt_width = 150, $wt_height = 45){
	$link = WEBSITE_BASE . "gimage.php?f=".base64_encode($f);
	$link .= "&w=".$w;
	$link .= "&h=".$h;
	// $link .= "&wt_width=".$wt_width;
	// $link .= "&wt_height=".$wt_height;
	$link .= "&grey=".$grey;

	return $link;
}

function g_add_statement_form($category){
	$sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category, masterid FROM " . c("table.pages") . " WHERE id!=1 AND language = '" . l() . "' AND   menuid = 1 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position asc;"; 
	$category = db_fetch_all($sql);

	$saletypes = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=13 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
	//$cities = db_fetch_all("SELECT `idx`, `names` FROM `cities_regions` WHERE `cid`=0 AND `language`='".l()."' ORDER BY `idx` ASC;");
	$cities = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=22 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
	$conditions = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=14 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
	$projects = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=15 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
	$aditional_info = db_fetch_all("SELECT `id`, `title` FROM `".c("table.catalogs")."` WHERE `catalogid`=16 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");


	$form = sprintf("<div class=\"ModalBackgroundTitle\">%s</div>", l("addstats"));

	$form .= "<div class=\"ModalBodyDiv\">";
	$form .= "<div class=\"AddPlaceDivModal\">";
	$form .= "<div class=\"row\">";

	$form .= "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">";
	$_SESSION["useradd_token"] = rand(100000,999999);
	$form .= sprintf(
		"<input type=\"hidden\" name=\"useradd_token\" class=\"useradd_token\" value=\"%s\" />", 
		$_SESSION["useradd_token"]
	);

	$form .= "<div class=\"col-sm-12 form-group padding_right_0 alert-danger-useradd-box\" style=\"display:none\">";
	$form .= "<div class=\"alert alert-danger\" role=\"alert\" style=\"margin-bottom:0\">";
	$form .= "<i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> ";
	$form .= "<span></span>";
	$form .= "</div>";
	$form .= "</div>";

	// select category start
	$form .= "<div class=\"col-sm-12 padding_0 padding_right_0\">";
	
	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("category"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_right_0\">";
	$form .= "<div class=\"form-group\">";
	$form .= "<select class=\"selectpicker useradd_category\" data-style=\"btn-broker\">";
	foreach($category as $cat) :
		$form .= sprintf("<option value=\"%s\">%s</option>", $cat["id"], $cat["title"]);
	endforeach;
	$form .= "</select>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// select category end

	// select saletypes start
	$form .= "<div class=\"col-sm-12 padding_0 padding_right_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("TransactionType"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_right_0\">";
	$form .= "<div class=\"form-group\">";
	$form .= "<select class=\"selectpicker useradd_saletype\" data-style=\"btn-broker\">";
	foreach($saletypes as $cat) :
		$form .= sprintf("<option value=\"%s\">%s</option>", $cat["id"], $cat["title"]);
	endforeach;
	$form .= "</select>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// select saletypes end

	// title start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("title"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_title\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// title end

	// select can be exchanged start
	$form .= "<div class=\"col-sm-12 padding_0 padding_right_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("canbeexchange"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_right_0\">";
	$form .= "<select class=\"selectpicker useradd_posiableexchange\" data-style=\"btn-broker\">";
	$form .= sprintf("<option value=\"1\">%s</option>", l("yes"));
	$form .= sprintf("<option value=\"0\">%s</option>", l("no"));
	$form .= "</select>";
	$form .= "</div>";

	$form .= "</div>";
	// select can be exchanged end

	// choose expire date start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";
	
	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("statdate"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9  padding_right_0 ForMobileInline\">";
	$form .= "<div class=\"form-group\">";
	$form .= "<div class=\"col-sm-2 padding_0 padding_right_0\">";
	$form .= "<div class=\"AddPlaceRadio radio radio-primary\">";
	$form .= "<input id=\"radio3\" type=\"radio\" class=\"useradd_statdate30\" name=\"radio3\" value=\"30\" />";
	$form .= "<label for=\"radio3\">30</label>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "<div class=\"col-sm-2 padding_0 padding_right_0\">";
	$form .= "<div class=\"AddPlaceRadio radio radio-primary\">";
	$form .= "<input id=\"radio4\" type=\"radio\" class=\"useradd_statdate60\" name=\"radio3\" value=\"60\" checked />";
	$form .= "<label for=\"radio4\">60</label>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "<div class=\"col-sm-2 padding_0 padding_right_0\">";
	$form .= "<div class=\"AddPlaceRadio radio radio-primary\">";
	$form .= "<input id=\"radio5\" type=\"radio\" class=\"useradd_statdate90\" name=\"radio3\" value=\"90\" />";
	$form .= "<label for=\"radio5\">90</label>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// choose expire date end

	// Type Code start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("procode"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_procode\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// Type Code end

	// Super Vip start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= "<label>Super VIP / VIP</label>";
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9  padding_right_0 ForMobileInline\">";
	
	$form .= "<div class=\"col-sm-2 padding_0 padding_right_0\">";
	$form .= "<div class=\"AddPlaceRadio radio radio-primary\">";
	$form .= "<input id=\"radio51\" type=\"radio\" class=\"useradd_supervip\" name=\"radio5\" value=\"1\" />";
	$form .= "<label for=\"radio51\">Super VIP</label>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "<div class=\"col-sm-2 padding_0 padding_right_0\">";
	$form .= "<div class=\"AddPlaceRadio radio radio-primary\">";
	$form .= "<input id=\"radio52\" type=\"radio\" class=\"useradd_vip\" name=\"radio5\" value=\"1\" />";
	$form .= "<label for=\"radio52\">VIP</label>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	$form .= "</div>";
	// Super Vip end

	// select city start
	$form .= "<div class=\"col-sm-12 padding_0 padding_right_0\">";
	
	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("destination"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_right_0\">";
	$form .= "<div class=\"form-group\">";
	$form .= "<select class=\"selectpicker useradd_city\" data-style=\"btn-broker\">";
	foreach($cities as $cat) :
		$form .= sprintf("<option value=\"%s\">%s</option>", $cat["id"], $cat["title"]);
	endforeach;
	$form .= "</select>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// select city end

	// type address start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("address"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_address\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// type address end

	// Google Map start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";
	$form .= "<input type=\"hidden\" name=\"latlng\" id=\"latlng\" class=\"useradd_googlemap\" value=\"\" />";
	$form .= "<div class=\"AddPlaceMap\">";
	$form .= "<div id=\"SingleMap\"></div>";
	$form .= sprintf("<div class=\"ButtonBlue\">%s</div>", l("pinmap"));
	$form .= "</div>";
	$form .= "</div>";
	// Google Map end


	// choose condition start
	$form .= "<div class=\"col-sm-12 padding_0 padding_right_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("condition"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_right_0\">";
	$form .= "<div class=\"form-group\">";
	$form .= "<select class=\"selectpicker useradd_condition\" data-style=\"btn-broker\">";
	foreach($conditions as $con) :
		$form .= sprintf("<option value=\"%s\">%s</option>", $con["id"], $con["title"]);
	endforeach;
	$form .= "</select>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// choose condition end

	// choose project start
	$form .= "<div class=\"col-sm-12 padding_0 padding_right_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("project"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_right_0\">";
	$form .= "<div class=\"form-group\">";
	$form .= "<select class=\"selectpicker useradd_project\" data-style=\"btn-broker\">";
	foreach($projects as $pro) :
		$form .= sprintf("<option value=\"%s\">%s</option>", $pro["id"], $pro["title"]);
	endforeach;
	$form .= "</select>"; 
	$form .= "</div>"; 
	$form .= "</div>"; 

	$form .= "</div>"; 
	// choose project end
	
	// floor start
	$form .= "<div class=\"form-group col-sm-12 padding_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("floor"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_floor\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// floor end

	// floor all start
	$form .= "<div class=\"form-group col-sm-12 padding_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("floorall"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_floorall\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// floor all end


	// space start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("space"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	
	$form .= "<div class=\"input-group\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_space\" value=\"\" />";
	
	$form .= "<span class=\"input-group-addon padding_0\">";
	$form .= "<div class=\"btn-group\">";
	$form .= sprintf("<button class=\"ChangeGEL btn dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\"><div class=\"Mspace\">%s</div></button>", l("kvm"));
	$form .= "<ul class=\"dropdown-menu open ChangeGelDropdown\">";
	$form .= sprintf("<li><a href=\"#\"><div class=\"Mspace\">%s</div></a></li>", l("kvm"));
	$form .= "</ul>";
	$form .= "</div>";
	$form .= "</span>";

	$form .= "</div>";
	$form .= "</div>";
	$form .= "</div>";
	$form .= "</div>";
	// space end

	// ceil height start
	$form .= "<div class=\"form-group col-sm-12 padding_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("ceilheight"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_ceilheight\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// ceil height end

	// room start
	$form .= "<div class=\"form-group col-sm-12 padding_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("room"));
	$form .= "</div>"; 

	$form .= "<div class=\"col-sm-9 padding_0\">"; 
	$form .= "<div class=\"col-sm-12 padding_right_0\">"; 
	$form .= "<input type=\"text\" class=\"form-control useradd_room\" value=\"\" />"; 
	$form .= "</div>"; 
	$form .= "</div>";

	$form .= "</div>"; 
	// room end

	// bathrooms start
	$form .= "<div class=\"form-group col-sm-12 padding_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("bathrooms")); 
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_bathroom\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// bathrooms end

	// price start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("price"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";	
	$form .= "<div class=\"input-group\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_price\" value=\"\" />";
	
	$form .= "<span class=\"input-group-addon padding_0\">";
	$form .= "<div class=\"btn-group\">";
	$form .= "<input type=\"hidden\" name=\"stat_currency\" id=\"stat_currency\" value=\"GEL\" />";
	$form .= sprintf("<button class=\"ChangeGEL currencyButton btn dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-expanded=\"false\"><div class=\"BPGLARI\">A</div></button>");
	$form .= "<ul class=\"dropdown-menu open ChangeGelDropdown\">";
	$form .= "<li><a href=\"#\" class=\"changeCurrencyx\">$</a></li>";
	$form .= "</ul>";
	$form .= "</div>";
	$form .= "</span>";

	$form .= "</div>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// price end

	// aditional information start
	$form .= "<div class=\"form-group col-sm-12 padding_0 miwisnakveti_hide\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("additionalinformation"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	foreach ($aditional_info as $add):
		$form .= "<div class=\"col-sm-6\">";
		$form .= "<div class=\"AddPlaceCheckbox checkbox checkbox-success\">";
		$form .= sprintf("<input id=\"checkbox%s\" data-addinfoid=\"%s\" type=\"checkbox\" class=\"useradd_additional additionalinformationClass\" />", $add["id"], $add["id"]);
		$form .= sprintf("<label for=\"checkbox%s\">%s</label>", $add["id"], $add["title"]);
		$form .= "</div>";
		$form .= "</div>";
	endforeach;
	$form .= "</div>";

	$form .= "</div>";
	// aditional information end

	// description start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("description"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<textarea class=\"form-control useradd_description\"></textarea>";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	// description end

	//contact number start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s <font color=\"red\">*</font></label>", l("contactphone"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";
	$form .= "<div class=\"col-sm-12 padding_right_0\">";
	$form .= "<input type=\"text\" class=\"form-control useradd_contactphone\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";
	//contact number end

	// photos start
	$form .= "<div class=\"form-group col-sm-12 padding_0\">";

	$form .= "<div class=\"col-sm-3\">";
	$form .= sprintf("<label>%s</label>", l("photosmax"));
	$form .= "</div>";

	$form .= "<div class=\"col-sm-9 padding_0\">";

	$form .= "<div class=\"col-sm-12\">";

	$form .= "<div class=\"UploadedImages\">";
	$form .= "<div class=\"FileUploadButton\">";
	$form .= "<input type=\"file\" class=\"fileUploadStats useradd_images\" id=\"fileUploadStats\" value=\"\" />";
	$form .= "</div>";
	$form .= "</div>";

	$form .= "</div>";

	$form .= "</div>";

	$form .= "</div>";
	// photos end

	// add button & empty start
	$form .= "<div class=\"col-sm-12 padding_0 padding_right_0\">";
	$form .= "<div class=\"col-sm-3\"><label></label></div>";
	$form .= "</div>";

	$form .= "<div class=\"form-group col-sm-12 padding_0 MobilePadding15px\">";
	$form .= sprintf("<button class=\"ButtonBlue useradd_button\">%s</button>", l("addstats"));
	$form .= "</div>";
	// add button & empty end

	$form .= "</form>";
	$form .= "</div>";
	$form .= "</div>";
	$form .= "</div>";

	return $form;
}

function g_destinations(){
	$cities = db_fetch_all("SELECT `id`, `title`, `photo1` FROM `".c("table.catalogs")."` WHERE `catalogid`=22 AND `visibility`='true' AND `deleted`=0 AND `language`='".l()."' ORDER BY `position` ASC;");
	$out = "";
	foreach($cities as $city):
		$out .= "<div class=\"RegionsParent\">";
		$out .= sprintf(
			"<a href=\"/ge/search?id=&catalogtype=&saletype=&city=%s&room=&price=0:0&currency=GEL&floor=0:0&condition=&project=\" class=\"RegionsItem\">",
			$city["id"]
		);
		$out .= "<div class=\"Image\">";
		$out .= sprintf("<img src=\"%s\" alt=\"\" />", $city["photo1"]);
		$out .= "</div>";
		$out .= sprintf("<div class=\"Title\">%s</div>", $city["title"]);
		$out .= "</a>";
		$out .= "</div>";
	endforeach;

	return $out;
}

function g_bannerlist($catid, $limit = 100){
	$out = array(); 

	$fetch = db_fetch_all("SELECT * FROM `galleries` WHERE `deleted`=0 and `visibility`='true' and `language`='".l()."' and `galleryid`=".(int)$catid." ORDER BY `position` ASC LIMIT ".$limit.";");
	if($fetch){
		$out = $fetch;
	}
	
	return $out;
}

function g_clear_cache(){
	$mask = '/home/batumibroker/public_html/_cache_html/*.*';
	array_map('unlink', glob($mask));
}