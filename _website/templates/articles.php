<?php defined('DIR') OR exit ?>
      <section class="topSingleBkg topPageBkg">
         <div class="item-content-bkg">
            <div class="item-img"  style="background-image:url('<?php echo content($imagen); ?>');" ></div>
            <div class="inner-desc">
               <h1 class="post-title single-post-title"><?php echo $title;?></h1>
            </div>
         </div>
      </section>
      
      <!-- MAIN WRAP CONTENT -->
      <section id="wrap-content" class="blog-1col-list-left">
         <div class="container">
            <div class="row">
               <div class="col-md-10 col-md-offset-1">
<?php
$i = 0;
foreach ($news AS $item):
    $i++;
    $link = href($item['id']);
?>               
                  <article class="blog-item blog-item-1col" >
                     <!--post-category-->
                     <h2 class="article-title"><?php echo $item['title'] ?></h2>
                     <ul class="post-meta">
                        <li class="meta-date"><?php echo convert_date($item['pagedate']) ?></li>
                     </ul>
                     <div class="post-image">
                        <img width="900" height="" src="<?php echo $item['imagen']; ?>" class="img-responsive img-featured" alt="<?php echo $item['title'] ?>" title="<?php echo $item['title'] ?>" />      
                     </div>
                     <!--post-image-->
                     <div class="post-holder post-holder-all">
                        <div class="post-content">
                           <?php echo $item['description'] ?>
                        </div>
                        <!--post-content-->
                        <div class="more-btn">
                           <a class="view-more" href="<?php echo $item['redirectlink']; ?>" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook Event</a>
                        </div>
                     </div>
                     <!--post holder-->
                  </article>
<?php endforeach;?>
               </div>
               <!--col-md-10-->
            </div>
            <!--row-->
         </div>
         <!--container-->
      </section>
      <!-- /MAIN WRAP CONTENT -->