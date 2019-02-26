<?php
defined('DIR') OR exit;

$num = count($news);
?>
    <main id="content ">
        <section id="location">
            <div class="wrapper fix">
                <ul>
              		 <?php echo location();?>
                </ul>
            </div>
            <!-- .wrapper fix -->
        </section>
      <section id="page" class="wrapper">
            <header class="fix">
                <h1 class="title left"><?php echo $title;?></h1>
            </header>
          <div class="news fix" >
                <?php 
					$i = 0;
					foreach ($news AS $item):
						$i++;
						$link = href($item['id']);
?>		     <article class="tour left">
        			<div ><a href="<?php echo $link;?>"><?php echo $item['title'];?></a></div>
        	
        		
        			
                    </article>
        			  <?php endforeach; ?>  
        		</div>
        		<!-- .news fix -->
        </section>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->
</div>
<!-- #root -->



        <?php if (count($news) > 0) : ?> 
            <div id="pager" class="fix">

                <?php
                 if(count($news) > 0) {
                ?>

                <ul>
                <?php
                    }
                //  echo $count_sql;
                // Pager Start
                    if (isset($item_count) AND $item_count > $num):
                        if ($page_num > 1):
                ?>
                            <li><a href="<?php echo href($section["id"], array()) . '?page=1'; ?>">&lt;&lt;</a></li>
                            <li><a href="<?php echo href($section["id"], array()) . '?page=' . ($page_num - 1); ?>">&lt;</a></li>
                <?php
                        endif;
                        $per_side = c('news.page_count');
                        $index_start = ($page_num - $per_side) <= 0 ? 1 : $page_num - $per_side;
                        $index_finish = ($page_num + $per_side) >= $page_max ? $page_max : $page_num + $per_side;
                        if (($page_num - $per_side) > 1)
                            echo '<li>...</li>';
                        for ($idx = $index_start; $idx <= $index_finish; $idx++):
                ?>
                                <li><a <?php echo ($page_num==$idx) ? 'class="active"':'' ;?> href="<?php echo href($section["id"], array()) . '?page=' . $idx; ?>"><?php echo $idx ?></a></li>
                                
                <?php
                        endfor;
                        if (($page_num + $per_side) < $page_max)
                            echo '<li>...</li>';
                        if ($page_num < $index_finish):
                ?>
                                     
                        <li><a href="<?php echo href($section["id"], array()) . '?page=' . ($page_num + 1); ?>">&gt;</a></li>
                        <li><a href="<?php echo href($section["id"], array()) . '?page=' . $page_max; ?>">&gt;&gt;</a></li>
                <?php
                        endif;
                    endif;
                // Pager End
                ?>
                </ul>
            </div>
            <!-- #pager .fix -->
            <?php endif; ?>
        </div>
        <!-- .page -->
    </div>
    <!-- #content .fix -->
