<?php defined('DIR') OR exit; ?>
      <!-- TOP IMAGE HEADER -->
      <section class="topSingleBkg topPageBkg">
         <div class="item-content-bkg">
            <div class="item-img"  style="background-image:url('<?php echo content($imagen); ?>');" ></div>
            <div class="inner-desc">
               <h1 class="post-title single-post-title"><?php echo $title;?></h1>
            </div>
         </div>
      </section>
            
      <!-- MAIN WRAP CONTENT -->
      <section id="wrap-content" class="page-content">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
               
                  <!-- GALLERY -->
                  <div class="gallery-3colgrid-content">
                     <div class="menu-holder menu-3col-grid-image gallery-holder clearfix">
<?php 
	$i=0;
	foreach($children as $item) { 
		$link = (($item['redirectlink'] == '') || ($item['redirectlink'] == 'NULL')) ? href($item['id']) : $item['redirectlink'];
		$i++;
?>                   
                        <div class="menu-post gallery-post">
                           <a href="<?php echo $link; ?>" class="lightbox" title="<?php echo $item['title'];?>">
                              <div class="item-content-bkg gallery-bkg">
                                 <div class="gallery-img" style="background-image:url('<?php echo 'crop.php?img=' . $item['imagen'] . '&width=900&height=500';?>');"></div>
                                 <div class="menu-post-desc">
                                 	<h4><?php echo $item['title'];?></h4>
                                    <div class="gallery-mglass"><i class="fa fa-search"></i></div>
                                 </div>
                              </div>
                           </a>
                        </div>
<?php } ?>
                     </div>
                   </div>
                   <!-- /GALLERY -->
                   
               </div>
               <!--col-md-12-->
            </div>
            <!--row-->
         </div>
         <!--container-->
      </section>
       <!-- /MAIN WRAP CONTENT -->