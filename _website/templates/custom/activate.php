<?php 
if(isset($_GET["a"]) && !empty($_GET["a"])){
	if(g_random_exists($_GET["a"])){
		$alert = "alert-success"; 
		$text = l("welldone");
	}else{
		$alert = "alert-danger"; 
		$text = l("error");
	}
}else{
	$alert = "alert-danger"; 
	$text = l("error");
}
?>

<div class="container" style="min-height: 1000px;">
	<div class="form-group col-sm-12 alert-danger-registration-box" style="padding-top: 80px">
		<div class="alert <?=$alert?>" role="alert" style="margin-bottom:0">
		<i class="fa fa-info-circle" aria-hidden="true"></i>
		<span><?=$text?></span>
		</div>
	</div>
</div>
<script>
$("body").css({"overflow-y":"hidden"});
</script>