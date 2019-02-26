<?php defined('DIR') OR exit; ?>

<div class="container">
    <div class="FAQPageDiv">
        <div class="row">
            <div class="col-sm-12">
                <div class="BreadCrumbs">
                    <?php echo location(); ?>
                </div>
            </div>
        </div>
        
        <div class="FAQROWS">
            <div class="row">
                <div class="col-sm-6">
                    <?php 
                    $x = 1;
                    foreach ($news AS $item): 
                        $val = $x / 2;
                        if(floor($val)==$val){ $x++; continue; }
                        $x++;
                    ?>
                    <div class="FAQItemDiv collapsed" data-toggle="collapse" href="#FaqMore<?=$x?>" aria-expanded="false" aria-controls="FaqMore<?=$x?>">
                        <div class="TItle"><?=strip_tags($item["title"])?><i class="fa fa-plus"></i></div>
                        <div class="Text collapse" id="FaqMore<?=$x?>"> 
                            <div class="TextPadding">
                                <?=strip_tags($item["content"])?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-sm-6">
                    <?php 
                    $y = 1;
                    foreach ($news AS $item): 
                        $val = $y / 2;
                        if(floor($val)!=$val){ $y++; continue; }
                        $y++;
                    ?>
                    <div class="FAQItemDiv collapsed"data-toggle="collapse" href="#FaqMore<?=$y?>" aria-expanded="false" aria-controls="FaqMore<?=$y?>">
                        <div class="TItle"><?=strip_tags($item["title"])?><i class="fa fa-plus"></i></div>
                        <div class="Text collapse" id="FaqMore<?=$y?>"> 
                            <div class="TextPadding">
                                <?=strip_tags($item["content"])?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
$("body").addClass("SingleBodyClass");
</script>