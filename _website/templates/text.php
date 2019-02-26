<?php defined('DIR') OR exit ?>
      <section class="topSingleBkg topPageBkg wow">
         <div class="item-content-bkg">
            <div class="item-img"  style="background-image:url('<?php echo content($imagen); ?>');" ></div>
            <div class="inner-desc">
               <h1 class="post-title single-post-title"><?php echo $title;?> xxxxxx</h1>
               <span class="post-subtitle"> <?php echo content($description); ?> </span>
            </div>
         </div>
      </section>
      
      <section id="wrap-content" class="blog-1col-list-left">
         <div class="container">
            <div class="row">
               <div class="col-md-10 col-md-offset-1">
               
                  <article class="blog-item blog-item-1col" >
                     <!--post-image-->
                     <div class="post-holder post-holder-all">
                        <div class="post-content">
                           <?php echo content($content); ?>
                        <!-- TEAM HOLDER -->            
                          <div class="team-holder">
                          
                             <div class="row">
                                <?php echo links($idx); ?>                                
                             </div>
                             <!--end row-->    
                              
                          </div>
                          <!--/TEAM HOLDER-->
                        </div>
                     </div>
                  </article>
               </div>
            </div>
         </div>
      </section>