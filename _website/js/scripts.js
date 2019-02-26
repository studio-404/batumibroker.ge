function rmDel(id, ajxType){
	var input_lang = $("#input_lang").val();
	$(".emptyModalActionButton").append("...");
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:ajxType, input_lang:input_lang, productid:id } 
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			location.reload();
		}
	});
}

function count_item(){
	var input_lang = $("#input_lang").val();
	var search_id = $("#search_id").val();
	var search_catalogtype = $("#search_catalogtype").val();
	var search_saletype = $("#search_saletype").val();
	var search_status = $("#search_status").val();
	var search_city = $("#search_city").val();
	var search_room = $("#search_room").val();
	var search_from_price = $("#search_from_price").val();
	var search_to_price = $("#search_to_price").val();
	var search_currency = $("#search_currency").val();
	var search_from_floor = $("#search_from_floor").val();
	var search_to_floor = $("#search_to_floor").val();
	var search_from_kvm = $("#search_from_kvm").val();
	var search_to_kvm = $("#search_to_kvm").val();
	var search_condition = $("#search_condition").val();
	var search_project = $("#search_project").val();

	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { 
			type:"count_items", 
			input_lang:input_lang, 
			search_id:search_id,  
			search_catalogtype:search_catalogtype,  
			search_saletype:search_saletype,  
			search_status:search_status,  
			search_city:search_city,  
			search_room:search_room,  
			search_from_price:search_from_price,  
			search_to_price:search_to_price,  
			search_currency:search_currency,  
			search_from_floor:search_from_floor,  
			search_to_floor:search_to_floor,
			search_from_kvm:search_from_kvm,  
			search_to_kvm:search_to_kvm,  
			search_condition:search_condition,  
			search_project:search_project  
		} 
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			$(".search_submit_button span").html(obj.Success.Counted);
		}else{
			$(".search_submit_button span").html(obj.Error.Counted);
		}
	});
}

$(document).ready(function() {
	if (document.documentElement.clientWidth > 992) { 
		$('.selectpicker').selectpicker();
	}


	$(".ShowMobileDiv").click(function(){
	    $(".MobileDivShow").toggleClass("active");
	    $("body").toggleClass("ActiveBody");
	});
	$(".MobileDivShow ").click(function(){
	    $(".MobileDivShow").removeClass("active"); 
	    $("body").removeClass("ActiveBody"); 
	});

	$('.TabsSelect1').on('change', function (e) {
		$('.TabsMenu1 li a').eq($(this).val()).tab('show'); 
	});
	$('.TabsSelect2').on('change', function (e) {
		$('.TabsMenu2 li a').eq($(this).val()).tab('show'); 
	});
	
	$('.HomeItemSlider').slick({
		autoplay: true,
  		autoplaySpeed: 2000,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: true
			  }
			}
		]
	});
	
	$('.HomeDivForSlider').slick({
		autoplay: true,
  		autoplaySpeed: 3000,
		slidesToShow: 5,
		slidesToScroll: 1,
		dots: true,
		responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: true
			  }
			}
		]
	});
	
	$('.slider-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		fade: true,
		dots: false,
		asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.slider-for',
		dots: false,
		centerMode: false,
		focusOnSelect: true,
		responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				dots: true
			  }
			}
		]
	});
	
	$('.RegionsDiv').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: true
			  }
			}
		]
	});

	$(document).on("click", ".SearchCleanUp", function(){
		$("#search_id").val('');
		$("#search_catalogtype").val('default');
		$("#search_catalogtype").selectpicker("refresh");
		$("#search_saletype").val('default');
		$("#search_saletype").selectpicker("refresh");
		$("#search_status").val('default');
		$("#search_status").selectpicker("refresh");
		$("#search_city").val('default');
		$("#search_city").selectpicker("refresh");
		$("#search_room").val('default');
		$("#search_room").selectpicker("refresh");

		$("#search_from_price").val('');
		$("#search_to_price").val('');		
		$("#search_currency").val('');
		$("#search_from_floor").val('');
		$("#search_to_floor").val('');
		$("#search_from_kvm").val('');
		$("#search_to_kvm").val('');
		$("#search_condition").val('default');
		$("#search_condition").selectpicker("refresh");
		$("#search_project").val('default');
		$("#search_project").selectpicker("refresh");

		count_item(); 
	});
	
});

$(function () {
	$('[data-toggle="tooltip"]').tooltip()
}); 

$(document).on("click", ".registrationButtom", function(){
		var input_lang = $("#input_lang").val();
		var phoneemail = $("#phoneemail").val();
		var password = $("#password").val();
		var rpassword = $("#rpassword").val();
		var siterules = (document.getElementById('siterules').checked) ? 1 : 0;
		var register_token = $("#register_token").val();
		$(".alert-danger-registration-box").fadeOut("slow");
		$.ajax({
			type: "POST",
			url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
			data: { type:"registration", phoneemail:phoneemail, password:password, rpassword:rpassword, siterules:siterules, register_token:register_token } 
		}).done(function( msg ) {
			var html = "";
			var obj = $.parseJSON(msg);
			if(obj.Success.Code==1){
				html = obj.Success.Text;
				$(".alert-danger-registration-box .alert").removeClass("alert-danger").addClass("alert-success");
				$("#phoneemail").val('');
				$("#password").val('');
				$("#rpassword").val('');
			}else if(obj.Error.Code==1){
				html = obj.Error.Text;
				$(".alert-danger-registration-box .alert").removeClass("alert-success").addClass("alert-danger");
			}

			$(".alert-danger-registration-box .alert span").html(html);
			$(".alert-danger-registration-box").fadeIn("slow");
		});
});

$(document).on("click", ".signin", function(){
	var input_lang = $("#input_lang").val();
	var auth_username = $("#auth_username").val();
	var auth_password = $("#auth_password").val();
	var save = (document.getElementById('save').checked) ? 1 : 0;
	var auth_token = $("#auth_token").val();
	$(".alert-danger-auth-box").fadeOut("slow");

	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"login", auth_username:auth_username, auth_password:auth_password, save:save, auth_token:auth_token } 
	}).done(function( msg ) {
		var html = "";
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			html = obj.Success.Text;
			$(".alert-danger-auth-box .alert").removeClass("alert-danger").addClass("alert-success");
			$("#phoneemail").val('');
			$("#password").val('');
			$("#rpassword").val('');
			location.reload();
		}else if(obj.Error.Code==1){
			html = obj.Error.Text;
			$(".alert-danger-auth-box .alert").removeClass("alert-success").addClass("alert-danger");
		}

		$(".alert-danger-auth-box .alert span").html(html);
		$(".alert-danger-auth-box").fadeIn("slow");
	});
	
});

$(document).on("click", ".signout", function(){
	$(".signout").append("...");
	var input_lang = $("#input_lang").val();
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"signout" } 
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			location.reload();
		}
	});
});


$(document).on("click", ".recover_button1", function(){
	var input_lang = $("#input_lang").val();
	var recover1_token = $("#recover1_token").val();
	var recover_email = $("#recover_email").val();
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"recover_step_one", input_lang:input_lang, recover1_token:recover1_token, recover_email:recover_email } 
	}).done(function( msg ) {
		var html = "";
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			html = obj.Success.Text;
			$(".alert-recovery-step1 .alert").removeClass("alert-danger").addClass("alert-success");
			$("#recover_email").val('');

			$(".step1").hide(); 
			$(".step2").show(); 
		}else if(obj.Error.Code==1){
			html = obj.Error.Text;
			$(".alert-recovery-step1 .alert").removeClass("alert-success").addClass("alert-danger");
		}

		$(".alert-recovery-step1 .alert span").html(html);
		$(".alert-recovery-step1").fadeIn("slow");
	});
});

$(document).on("click", ".recover_button2", function(){
	var input_lang = $("#input_lang").val();
	var recover2_token = $("#recover2_token").val();
	var recover_code = $("#recover_code").val();
	var new_password = $("#new_password").val();
	var rnew_password = $("#rnew_password").val();
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"recover_step_two", input_lang:input_lang, recover2_token:recover2_token, recover_code:recover_code, new_password:new_password, rnew_password:rnew_password } 
	}).done(function( msg ) {
		var html = "";
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			html = obj.Success.Text;
			$(".alert-recovery-step2 .alert").removeClass("alert-danger").addClass("alert-success");
			$("#recover_code").val('');
			$("#new_password").val('');
			$("#rnew_password").val('');
		}else if(obj.Error.Code==1){
			html = obj.Error.Text;
			$(".alert-recovery-step2 .alert").removeClass("alert-success").addClass("alert-danger");
		}

		$(".alert-recovery-step2 .alert span").html(html);
		$(".alert-recovery-step2").fadeIn("slow");
	});
});

$(document).on("click", ".FBButton", function(){
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"facebook_login"} 
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			var url = obj.Success.Text;
			location.href = url.replace("&amp;", "&");
		}else if(obj.Error.Code==1){
			var html = obj.Error.Text;
			$(".alert-danger-auth-box .alert").removeClass("alert-success").addClass("alert-danger");
			$(".alert-danger-auth-box .alert span").html(html);
			$(".alert-danger-auth-box").fadeIn("slow");
		}		
	});
});


$(document).on("click", ".verification_button", function(){
	$(".verification_box").removeClass("ErrorValidation");
	$(this).append("<span>...</span>");
	var input_lang = $("#input_lang").val();
	var verification_code = $("#verification_code").val();
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"email_verification", input_lang:input_lang, verification_code:verification_code } 
	}).done(function( msg ) {
		$(".verification_button span").remove();
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			location.reload();
		}else if(obj.Error.Code==1){
			$(".verification_box").addClass("ErrorValidation");
		}		
	});
});

$(document).on("click", ".editinputButton", function(){
	var firstname = $(".firstname-input").val();
	var personalid = $(".personalid-input").val();
	var companyname = $(".companyname-input").val();
	var address = $(".address-input").val();
	var mobile = $(".mobile-input").val();
	var skype = $(".skype-input").val();

	var input_lang = $("#input_lang").val();
	$(".form-group").removeClass("ErrorValidation"); 
	$(".form-group .InputErrorMessage").remove(); 

	$(".alert-danger-profileedit-box").hide();
	
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"edit_profile", input_lang:input_lang, firstname:firstname, personalid:personalid, companyname:companyname, address:address, mobile:mobile, skype:skype } 
	}).done(function( msg ) {
		var html = "";
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			html = obj.Success.Text;
			$(".alert-danger-profileedit-box .alert").removeClass("alert-danger").addClass("alert-success");
		}else if(obj.Error.Code==1){
			$(".alert-danger-profileedit-box .alert").removeClass("alert-success").addClass("alert-danger");
			var errorBox = obj.Error.Container;
			html = obj.Error.Text;

			$(errorBox).addClass("ErrorValidation"); 
			$(errorBox).append('<div class="InputErrorMessage">'+html+'</div>')
		}
		
		$(".alert-danger-profileedit-box .alert span").html(html);
		$(".alert-danger-profileedit-box").fadeIn("slow");
	});
});

$(document).on("click", ".editpasswordButton", function(){
	var currentpassword = $(".currentpassword-input").val();
	var newpassword = $(".newpassword-input").val();
	var rnewpassword = $(".rnewpassword-input").val();
	var input_lang = $("#input_lang").val();

	$(".form-group").removeClass("ErrorValidation"); 
	$(".form-group .InputErrorMessage").remove(); 

	$(".alert-danger-profileeditpassword-box").hide();
	
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"edit_profile_password", input_lang:input_lang, currentpassword:currentpassword, newpassword:newpassword, rnewpassword:rnewpassword } 
	}).done(function( msg ) {
		var html = "";
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			html = obj.Success.Text;
			$(".currentpassword-input").val('');
			$(".newpassword-input").val('');
			$(".rnewpassword-input").val('');
			$(".alert-danger-profileeditpassword-box .alert").removeClass("alert-danger").addClass("alert-success");
		}else if(obj.Error.Code==1){
			html = obj.Error.Text;
			$(".alert-danger-profileeditpassword-box .alert").removeClass("alert-success").addClass("alert-danger");
			
			var errorBox = obj.Error.Container;
			if(errorBox!=""){
				$(errorBox).addClass("ErrorValidation"); 
				$(errorBox).append('<div class="InputErrorMessage">'+html+'</div>')
			}
		}
		
		$(".alert-danger-profileeditpassword-box .alert span").html(html);
		$(".alert-danger-profileeditpassword-box").fadeIn("slow");
	});
});

$(document).on("click", ".UserPageDiv .UserPage .UserLeftDiv .UserInfo .UserImage", function(){
	$("#logoUploadInput").click();
	return;
});

$(document).on("change", "#logoUploadInput", function(e){
	var files = e.target.files; 
    if(typeof files[0] !== "undefined"){
    	$("#logoUpload").submit();
    }
});

$(document).on("click", ".addOrRemoveFavourites", function(){
	var input_lang = $("#input_lang").val(); 
	var productid = $(this).attr("data-productid"); 
	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"addOrRemoveFavourites", input_lang:input_lang, productid:productid } 
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			location.reload();
		}
	});
});

function emptyModal(title, text, footer, footerCloseText, footerActionText, footerActionOnclick){
	$("#emptyModal").modal("hide");
	$("#emptyModal").remove();
	var html = '<div class="modal fade" id="emptyModal" tabindex="-1" labelledby="smallModal" role="dialog" style="font-family: BPGCaps2010">';
	html += '<div class="modal-dialog" role="document" style="width:320px;">';
	html += '<div class="modal-content">';
	html += '<div class="modal-header">';
	html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	html += '<h4 class="modal-title">'+title+'</h4>';
	html += '</div>';
	html += '<div class="modal-body">';
	html += '<p style="padding: 20px;">'+text+'</p>';
	html += '</div>';

	if(footer==true){
		html += '<div class="modal-footer">';
		html += '<button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 30px">'+footerCloseText+'</button>';
		if(footerActionText!=""){
			html += '<button type="button" class="btn btn-primary emptyModalActionButton" onclick="'+footerActionOnclick+'" style="background-color: #007af7; border-radius: 30px">'+footerActionText+'</button>';
		}
		html += '</div>';
	}

	html += '</div>';
	html += '</div>';
	html += '</div>';
	return html;
}

$(document).on("click", ".removeFavourite", function(){
	// alert("xxx");
	var productid = parseInt($(this).attr("data-productid")); 
	var title = $(this).attr("data-title"); 
	var text = $(this).attr("data-text"); 
	var footerCloseText = $(this).attr("data-footerCloseText"); 
	var footerActionText = $(this).attr("data-footerActionText"); 

	var modal = emptyModal(title, text, true, footerCloseText, footerActionText, 'rmDel('+productid+',\'removeFavourite\')');
	$("body").append(modal);
	$("#emptyModal").modal("show"); 
});

$(document).on("click", ".removeMyAdds", function(){
	// alert("xxx");
	var productid = parseInt($(this).attr("data-productid")); 
	var title = $(this).attr("data-title"); 
	var text = $(this).attr("data-text"); 
	var footerCloseText = $(this).attr("data-footerCloseText"); 
	var footerActionText = $(this).attr("data-footerActionText"); 

	var modal = emptyModal(title, text, true, footerCloseText, footerActionText, 'rmDel('+productid+',\'removeMyAdds\')');
	$("body").append(modal);
	$("#emptyModal").modal("show"); 
});

$(document).on("click", ".waitingfor", function(){
	// alert("xxx");
	var title = $(this).attr("data-title"); 
	var text = $(this).attr("data-text"); 
	var footerCloseText = $(this).attr("data-footerCloseText"); 

	var modal = emptyModal(title, text, true, footerCloseText, "", false);
	$("body").append(modal);
	$("#emptyModal").modal("show"); 
});


$(document).on("click", ".contactButton", function(){
	// alert("xxx");
	var input_lang = $("#input_lang").val();
	var email = $(".contact-email").val();
	var subject = $(".contact-subject").val();
	var message = $(".contact-message").val();

	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { type:"send_contact_message", input_lang:input_lang, email:email, subject:subject, message:message } 
	}).done(function( msg ) {
		var html = "";
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			html = obj.Success.Text;
			$(".contact-email").val('');
			$(".contact-subject").val('');
			$(".contact-message").val('');
			$(".alert-danger-contactmessage-box .alert").removeClass("alert-danger").addClass("alert-success");
		}else if(obj.Error.Code==1){
			html = obj.Error.Text;
			$(".alert-danger-contactmessage-box .alert").removeClass("alert-success").addClass("alert-danger");
		}
		
		$(".alert-danger-contactmessage-box .alert span").html(html);
		$(".alert-danger-contactmessage-box").fadeIn("slow");
	});
});

$(document).on("click", ".search_currency_change", function(){
	var search_currency = $("#search_currency").val(); 

	if(search_currency=="GEL"){
		$("#search_currency").val("USD");
		$(".search_currency_button").html("$");
		$(".search_currency_change").html("<div class=\"BPGLARI\">A</div>");
	}else{
		$("#search_currency").val("GEL");
		$(".search_currency_button").html("<div class=\"BPGLARI\">A</div>");
		$(".search_currency_change").html("$");
	}

	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("click", ".search_submit_button", function(){
	var input_lang = $("#input_lang").val();
	var search_id = $("#search_id").val();
	var search_catalogtype = $("#search_catalogtype").val();
	var search_saletype = $("#search_saletype").val();
	var search_status = $("#search_status").val();
	var search_city = $("#search_city").val();
	var search_room = $("#search_room").val();
	var search_from_price = $("#search_from_price").val();
	var search_to_price = $("#search_to_price").val();
	var search_currency = $("#search_currency").val();
	var search_from_floor = $("#search_from_floor").val();
	var search_to_floor = $("#search_to_floor").val();
	var search_from_kvm = $("#search_from_kvm").val();
	var search_to_kvm = $("#search_to_kvm").val();
	var search_condition = $("#search_condition").val();
	var search_project = $("#search_project").val();

	var genurl = "/"+input_lang+"/search?id="+search_id+"&catalogtype="+search_catalogtype+"&saletype="+search_saletype+"&status="+search_status+"&city="+search_city+"&room="+search_room+"&price="+search_from_price+":"+search_to_price+"&currency="+search_currency+"&floor="+search_from_floor+":"+search_to_floor+"&kvm="+search_from_kvm+":"+search_to_kvm+"&condition="+search_condition+"&project="+search_project; 
	location.href = genurl;
});

$(document).on("click", ".mainImage", function(){
	var target = $(this).attr("data-target");
	var mainImage = "<img src=\""+target+"\" alt=\"\" width=\"100%\" />";
	$(".mainImageContainer").html(mainImage);
	$("#imagePopup").modal("show"); 
});

$(document).on("keyup", "#search_id", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("change", "#search_catalogtype", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("change", "#search_saletype", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("change", "#search_status", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("change", "#search_city", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("change", "#search_room", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("keyup", "#search_from_price", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("keyup", "#search_to_price", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("keyup", "#search_from_floor", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("keyup", "#search_to_floor", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("keyup", "#search_from_kvm", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("keyup", "#search_to_kvm", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("change", "#search_condition", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

$(document).on("change", "#search_project", function(){
	$(".search_submit_button span").html("..."); 
	count_item();
});

var scrollTop = function(el){
	var body = $(el);
	body.stop().animate({scrollTop:0}, '500', 'swing', function() { });
};


$(document).on("click", ".useradd_button", function(){
	var input_lang = $("#input_lang").val();
	var useradd_token = $(".useradd_token").val();
	var useradd_category = $(".useradd_category").find("option:selected").val(); 
	var useradd_saletype = $(".useradd_saletype").find("option:selected").val(); 
	var useradd_title = $(".useradd_title").val();
	var useradd_posiableexchange = $(".useradd_posiableexchange").find("option:selected").val(); 
	var useradd_procode = $(".useradd_procode").val(); 
	
	var useradd_expireday = 60;
	if($(".useradd_statdate30").is(":checked")){
		useradd_expireday = 30;
	}else if($(".useradd_statdate90").is(":checked")){
		useradd_expireday = 90;
	}

	var useradd_supervip = ($(".useradd_supervip").is(":checked")) ? 1 : 0;
	var useradd_vip = ($(".useradd_vip").is(":checked")) ? 1 : 0;

	var useradd_city = $(".useradd_city").find("option:selected").val(); 
	var useradd_address = $(".useradd_address").val(); 

	// MAP
	var useradd_googlemap = $(".useradd_googlemap").val(); 

	var useradd_condition = $(".useradd_condition").find("option:selected").val(); 
	var useradd_project = $(".useradd_project").find("option:selected").val(); 
	var useradd_floor = $(".useradd_floor").val();
	var useradd_floorall = $(".useradd_floorall").val(); 
	var useradd_space = $(".useradd_space").val(); 
	var useradd_ceilheight = $(".useradd_ceilheight").val(); 
	var useradd_room = $(".useradd_room").val(); 
	var useradd_bathroom = $(".useradd_bathroom").val(); 
	var useradd_price = $(".useradd_price").val(); 
	var stat_currency = $("#stat_currency").val(); 
	

	var useradd_additional = "";
	$(".useradd_additional").each(function(){
		if($(this).is(":checked")){
			useradd_additional += $(this).attr("data-addinfoid")+",";
		}
	});
	useradd_additional = useradd_additional.replace(/,\s*$/, "");

	var useradd_contactphone = $(".useradd_contactphone").val();
	var useradd_description = $(".useradd_description").val();
	
	
	$(".alert-danger-useradd-box").fadeIn();
	$(".alert-danger-useradd-box .alert span").text("...");

	$.ajax({
		type: "POST",
		url: "http://batumibroker.ge/"+input_lang+"/?ajax=true",
		data: { 
			type:"useraddstatement", 
			input_lang:input_lang, 
			useradd_token:useradd_token, 
			useradd_category:useradd_category, 
			useradd_saletype:useradd_saletype,  
			useradd_title:useradd_title,  
			useradd_posiableexchange:useradd_posiableexchange, 
			useradd_expireday:useradd_expireday, 
			useradd_procode:useradd_procode,  
			useradd_supervip:useradd_supervip, 
			useradd_vip:useradd_vip,  
			useradd_city:useradd_city, 
			useradd_address:useradd_address,  
			useradd_googlemap:useradd_googlemap,  
			useradd_condition:useradd_condition,   
			useradd_project:useradd_project,   
			useradd_floor:useradd_floor,    
			useradd_floorall:useradd_floorall,    
			useradd_space:useradd_space,    
			useradd_ceilheight:useradd_ceilheight,    
			useradd_room:useradd_room,     
			useradd_bathroom:useradd_bathroom,     
			useradd_price:useradd_price,      
			stat_currency:stat_currency,      
			useradd_additional:useradd_additional,   
			useradd_contactphone:useradd_contactphone,   
			useradd_description:useradd_description    
		} 
	}).done(function( msg ) {
		var html = "";
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			html = obj.Success.Text;
			$(".contact-email").val('');
			$(".contact-subject").val('');
			$(".contact-message").val('');
			$(".alert-danger-useradd-box .alert").removeClass("alert-danger").addClass("alert-success");
		}else if(obj.Error.Code==1){
			html = obj.Error.Text;
			$(".alert-danger-useradd-box .alert").removeClass("alert-success").addClass("alert-danger");
		}
		
		$(".alert-danger-useradd-box .alert span").html(html);
		scrollTop('#AddPlacePopup');
	});

	
	return false;
});

$(document).on("change", ".useradd_category", function(){
	var useradd_category = $(".useradd_category").find("option:selected").val(); 
	if(useradd_category==43){
		$(".miwisnakveti_hide").fadeOut();
	}else{
		$(".miwisnakveti_hide").fadeIn();
	}
});


var xhrUpload = function(id, file){
	var input_lang = $("#input_lang").val();
	var fileName = file.name;
	var ex = fileName.split(".");
	var extLast = ex[ex.length - 1].toLowerCase();

	xhr = new XMLHttpRequest();
	xhr.open("post", "http://batumibroker.ge/"+input_lang+"/?ajax=true&f="+id+"&e="+extLast, true);

	var rforeign = /[^\u0000-\u007f]/;
	if (rforeign.test(file.name)) {
	  alert("File name error !");
	  return false;
	}

	xhr.setRequestHeader('Content-Type','multipart/form-data'); 
	xhr.setRequestHeader('X-File-Name',file.name);
	xhr.setRequestHeader('X-File-Size',file.size);
	xhr.setRequestHeader('X-File-Type',file.type);
	if(extLast!="jpeg" && extLast!="jpg" && extLast!="png" && extLast!="gif"){
		alert("Please drop jpeg, jpg, gif or png file !");
		$('#img').html('<p>No Image</p>');
		return false;
	}

	//send file
	xhr.send(file);

	xhr.onreadystatechange = function(e){
		if(xhr.readyState == 4){
			if(xhr.status == 200){
				return true;
			}
		}
	}

};

var initPhotoSwipeFromDOM = function(gallerySelector) {

    // parse slide data (url, title, size ...) from DOM elements 
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for(var i = 0; i < numNodes; i++) {

            figureEl = thumbElements[i]; // <figure> element

            // include only element nodes 
            if(figureEl.nodeType !== 1) {
                continue;
            }

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute('data-size').split('x');

            // create slide object
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };



            if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            }

            if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            } 

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });

        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }

            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
};

	