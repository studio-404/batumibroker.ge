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
$idx = 0;
$num = count($photos);
$idx = 0;
foreach ($photos AS $item):
	if($idx == 0) $idx = 1; else $idx = 0;
    $link = $item['file'];
?>                    
                        <div class="menu-post gallery-post">
                           <a href="<?php echo $item['file'];?>" class="lightbox" rel="prettyPhoto[<?php echo $item['galleryid'];?>]" title="<?php echo $item['title'];?>">
                              <div class="item-content-bkg gallery-bkg">
                                 <div class="gallery-img" style="background-image:url('<?php echo 'crop.php?img=' . $item['file'] . '&width=900&height=500';?>');"></div>
                                 <div class="menu-post-desc">
                                    <div class="gallery-mglass"><i class="fa fa-search"></i></div>
                                 </div>
                              </div>
                           </a>
                        </div>
<?php
endforeach;
?>
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
