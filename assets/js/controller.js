$(document).ready(function(){
	loader = '<span class="spinner-border spinner-border-sm text-light "></span>';
//home subscribe
$('#sub_trigger').on('click',function(sf){
	sf.preventDefault();
	var email_id = $('#sub_email').val(), name_id = $("#sub_name").val();
	$('#sub_trigger').html('Processing '+loader);
	$.post("/processor.php", {email_id:email_id,name_id:name_id}, function(data){

		$('#sub_trigger').after(data);
		 $('#sub_email').val("");  $("#sub_name").val("");
		$('#sub_trigger').html('susbcribe');
	});
});

//servie bookings

$('select#service').on('change',function(sf){
	sf.preventDefault();
	var service_id = $(this).val();
	$('.cat-loader').show();
	$.post("/processor.php", {service_id:service_id}, function(data){

		$('select#category').html(data);
		$('select#category').removeAttr('disabled');
		$('.cat-loader').hide();
	});
});

var service_form = $('form.service-form');
service_form.on('submit',function(sf){
	sf.preventDefault();
	$('.service-btn').html('Processing'+loader);

	$.post("/processor.php", service_form.serialize(), function(data){

		service_form.after(data);
		$('.service-btn').html('Book Now');
	});
});
//signup form

var signup_form = $('form.signup-form');
signup_form.on('submit',function(sf){
	sf.preventDefault();
	$('.signup-btn').html('Processing'+loader);

	$.post("/processor.php", signup_form.serialize(), function(data){

		signup_form.after(data);
		$('.signup-btn').html('create account');
	});
});

// login form
var login_form = $('form.login-form');
login_form.on('submit',function(sf){
	sf.preventDefault();
	$('.login-btn').html('Processing'+loader);

	$.post("/processor.php", login_form.serialize(), function(data){

		login_form.after(data);
		$('.login-btn').html('login');
	});
});
//profile form
var profile_form = $('form.profile-form');
profile_form.on('submit',function(sf){
	sf.preventDefault();
	$.ajax({

		url: "/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.profile-btn').html('Processing'+loader);
		},
		success: function(data)
		{
			profile_form.after(data);
			$('.profile-btn').html('Save');
		}
	});
	
});

$("#profile_image").change(function(){
	readURL(this);
});
//academic form
var academic_form = $('form.academic-form');
academic_form.on('submit',function(sf){
	sf.preventDefault();
	$('.academic-btn').html('Processing'+loader);

	$.post("/processor.php", academic_form.serialize(), function(data){

		academic_form.after(data);
		$('.academic-btn').html('Save');
	});
});
// program form

var program_form = $('form.program-form');
program_form.on('submit',function(sf){
	sf.preventDefault();
	$('.program-btn').html('Processing'+loader);

	$.post("/processor.php", program_form.serialize(), function(data){

		program_form.after(data);
		$('.program-btn').html('Save');
	});
});
//parents form
var parents_form = $('form.parents-form');
parents_form.on('submit',function(sf){
	sf.preventDefault();
	$('.parents-btn').html('Processing'+loader);

	$.post("/processor.php", parents_form.serialize(), function(data){

		parents_form.after(data);
		$('.parents-btn').html('Save');
	});
});
//referral form
var referral_form = $('form.referral-form');
referral_form.on('submit',function(sf){
	sf.preventDefault();
	$('.referral-btn').html('Processing'+loader);

	$.post("/processor.php", referral_form.serialize(), function(data){

		referral_form.after(data);
		$('.referral-btn').html('Save');
	});
});
//documents form
var documents_form = $('form.documents-form');
documents_form.on('submit',function(df){
	df.preventDefault();
	$('div.progress').show('fadeInUp');
        
	$.ajax({
		  xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    $(".progress-bar").width(percentComplete + '%');
                    $(".progress-bar").html(percentComplete+'%');
                }
            }, false);
            return xhr;
        },
		url: "/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.documents-btn').html('Processing'+loader);
			 $(".progress-bar").width('0%');
		},
		success: function(data)
		{
			documents_form.after(data);
			$('.documents-btn').html('Save');
		}
	});
	
});
//document delete
$('.delete-document').on('click', function(){
	var deleteid = $(this).data('doc');
	$(this).html(loader);
	var tthis = $(this);
	$.post("/processor.php", {deleteid:deleteid} , function(data){

		tthis.html('<i class="fas fa-times"></i>');
		tthis.after(data);

	});
});
//review submit
var review_form = $('form.review-form');
review_form.on('submit',function(sf){
	sf.preventDefault();
	$('.review-btn').html('Processing'+loader);

	$.post("/processor.php", review_form.serialize(), function(data){

		review_form.after(data);
		$('.review-btn').html('submit for processing');
	});
});
//contact_form

var contact_form = $('form.contact-form');
contact_form.on('submit',function(sf){
	sf.preventDefault();
	$('.contact-btn').html('Processing'+loader);

	$.post("/processor.php", contact_form.serialize(), function(data){

		contact_form.after(data);
		$('.contact-btn').html('submit your message');
	});
});

//add booking

$('input[name="accomodation"]').on("change",function(){

	if (this.value == 'yes') {
		$('.book-details').fadeIn();
	} else{
		$('.book-details').fadeOut();
	}
});
var booking_form = $('form.booking-form');
booking_form.on('submit',function(sf){
	sf.preventDefault();
	$('.booking-btn').html('Processing'+loader);

	$.post("/processor.php", booking_form.serialize(), function(data){

		booking_form.after(data);
		$('.booking-btn').html('add');
	});
});
//tour form
var tour_form = $('form.tour-form');
tour_form.on('submit',function(sf){
	sf.preventDefault();
	$.ajax({

		url: "/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.tour-btn').html('Processing'+loader);
		},
		success: function(data)
		{
			tour_form.after(data);
			$('.tour-btn').html('Save changes');
		}
	});
	
});
//mail form
var mail_form = $('form.mail-form');
mail_form.on('submit',function(sf){
	sf.preventDefault();
	$('.mail-btn').html('Processing'+loader);

	$.post("/processor.php", mail_form.serialize(), function(data){

		mail_form.after(data);
		$('.mail-btn').html('save changes');
	});
});

//phone form
var phone_form = $('form.phone-form');
phone_form.on('submit',function(sf){
	sf.preventDefault();
	$('.phone-btn').html('Processing'+loader);

	$.post("/processor.php", phone_form.serialize(), function(data){

		phone_form.after(data);
		$('.phone-btn').html('save changes');
	});
});

//password form
var password_form = $('form.password-form');
password_form.on('submit',function(sf){
	sf.preventDefault();
	$('.password-btn').html('Processing'+loader);

	$.post("/processor.php", password_form.serialize(), function(data){

		password_form.after(data);
		$('.password-btn').html('save changes');
	});
});
//cancel booking
$('a.cancel-booking').on('click', function(){
	var cancelid = $(this).data('id');
	$(this).html(loader);
	var tthis = $(this);
	$.post("/processor.php", {cancelid:cancelid} , function(data){

		tthis.html('<i class="fas fa-window-close" data-toggle="tooltip" data-placement="top" title="cancel booking"></i>');
		tthis.after(data);

	});
});

//terminate form
var terminate_form = $('form.terminate-form');
terminate_form.on('submit',function(sf){
	sf.preventDefault();
	$('.terminate-btn').html('Processing'+loader);

	$.post("/processor.php", terminate_form.serialize(), function(data){

		terminate_form.after(data);
		$('.terminate-btn').html('Delete my account');
	});
});

//visa form
var visa_form = $('form.visa-form');
visa_form.on('submit',function(sf){
	sf.preventDefault();
	$('.visa-btn').html('Processing'+loader);

	$.post("/processor.php", visa_form.serialize(), function(data){

		visa_form.after(data);
		$('.visa-btn').html('Add');
	});
});

//cancel visa
$('a.cancel-visa').on('click', function(){
	var visaid = $(this).data('id');
	$(this).html(loader);
	var tthis = $(this);
	$.post("/processor.php", {visaid:visaid} , function(data){

		tthis.html('<i class="fas fa-window-close" data-toggle="tooltip" data-placement="top" title="cancel visa application"></i>');
		tthis.after(data);

	});
});
});
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('.p-image').attr('src', e.target.result).fadeIn('slow');
		}
		reader.readAsDataURL(input.files[0]);
	}
}