$(document).ready(function(){

var	loader = '<span class="spinner-border spinner-border-sm text-danger "></span>';
var loader_white =  '<span class="spinner-border spinner-border-sm text-white "></span>';

	/*login controller*/
	var login_form = $('form.login-form'), login_btn = $('.login-btn');

	login_form.on('submit', function(lf){

		lf.preventDefault();
		login_btn.html("Processing "+loader);

		$.post("processor.php", login_form.serialize(),function(data){
			login_btn.text("Let's Go");
			login_form.after(data);
		});
	});
	//notif read
	$('a.notif-read').on('click',function(nf){
		nf.preventDefault();
		var nfid = $(this).data('id');
		var tthis = $(this);

		$.post("processor.php", {nfid:nfid}, function(data){
			tthis.after(data);
		});
	});
	//update user
	var update_form = $('form.update-form'), update_btn = $('.update-btn');

	update_form.on('submit', function(uf){

		uf.preventDefault();
		update_btn.html("Processing "+loader_white);

		$.post("/admin-cp/processor.php", update_form.serialize(),function(data){
			update_btn.text("Update user");
			update_form.after(data);
		});
	});
	// delete user
	$('button.delete-user').on('click',function(du){
		var udel = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure about that?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {udel:udel},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });
	//update application progress
	$('button.update-progress').on('click', function(up){
		up.preventDefault();
		var uid = $(this).data("its") , sid = $(this).data('student'), tthis = $(this);
		tthis.html("Processing "+loader_white);
		$.post("/admin-cp/processor.php",{uid:uid,sid:sid}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.text("Update progress");
		});
	});
	//destination form
	var destination_form = $('form.destination-form');
	destination_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.destination-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			destination_form.after(data);
			$('.destination-btn').html('Add');
		}
	});
	
});
	//delete destination
		$('a.del-des').on('click',function(du){
		var deldes = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove destination?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {deldes:deldes},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });
		//edit destination
		$('a.edit-des').on('click', function(up){
		up.preventDefault();
		var editdes = $(this).data("id") , tthis = $(this);
		tthis.html(loader);
		$.post("/admin-cp/processor.php",{editdes:editdes}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.html('<i class="material-icons">create</i>');
		});
	});
//visa form
	var visa_form = $('form.visa-form');
	visa_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.visa-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			visa_form.after(data);
			$('.visa-btn').html('Add');
		}
	});
	
});
	//delete visa type
		$('a.del-vis').on('click',function(du){
		var delvis = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove visa type?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delvis:delvis},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });
		//edit destination
		$('a.edit-vis').on('click', function(up){
		up.preventDefault();
		var editvis = $(this).data("id") , tthis = $(this);
		tthis.html(loader);
		$.post("/admin-cp/processor.php",{editvis:editvis}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.html('<i class="material-icons">create</i>');
		});
	});
	//course form
	var course_form = $('form.course-form'), course_btn = $('.course-btn');

	course_form.on('submit', function(uf){

		uf.preventDefault();
		course_btn.html("Processing "+loader_white);

		$.post("/admin-cp/processor.php", course_form.serialize(),function(data){
			course_btn.text("Add");
			course_form.after(data);
		});
	});

	//delete course
		$('a.del-course').on('click',function(du){
		var delcourse = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove this course?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delcourse:delcourse},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });
		//edit course
		$('a.edit-course').on('click', function(up){
		up.preventDefault();
		var editcourse = $(this).data("id") , tthis = $(this);
		tthis.html(loader);
		$.post("/admin-cp/processor.php",{editcourse:editcourse}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.html('<i class="material-icons">create</i>');
		});
	});
		//slug
		$('input#school_name').on("keyup",function(){
			var slug = $(this).val();
			$('input#school_slug').val(slugGen(slug));
		});
		function slugGen(str) {
  str = str.replace(/^\s+|\s+$/g, ""); // trim
  str = str.toLowerCase();

  // remove accents, swap ñ for n, etc
  var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to = "aaaaaaeeeeiiiioooouuuunc------";

  for (var i = 0, l = from.length; i < l; i++) {
  	str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
  }

  str = str
    .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
    .replace(/\s+/g, "-") // collapse whitespace and replace by -
    .replace(/-+/g, "-") // collapse dashes
    .replace(/^-+/, "") // trim - from start of text
    .replace(/-+$/, ""); // trim - from end of text

    return str;
}

//school form
var school_form = $('form.school-form');
	school_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.school-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			school_form.after(data);
			$('.school-btn').html('Add');
		}
	});
	
});

//delete school
		$('.del-school').on('click',function(du){
		var delschool = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove this school?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delschool:delschool},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });

		//school update form
var updatesch_form = $('form.updatesch-form');
	updatesch_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.updatesch-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			updatesch_form.after(data);
			$('.updatesch-btn').html('update school');
		}
	});
	
});
//review update
$('a.rev-u').on("click",function(data){
	var revid = $(this).data("id"), pos = $(this).data("position"), role = $(this).data("role"), tthis = $(this);
	$("button#"+pos).html(loader_white);
	$.post("/admin-cp/processor.php", {revid:revid,role:role}, function(data){
		$("button#"+pos).text(role);
		tthis.after(data);
	});
});

//service form
	var services_form = $('form.services-form'), services_btn = $('.services-btn');

	services_form.on('submit', function(uf){

		uf.preventDefault();
		services_btn.html("Processing "+loader_white);

		$.post("/admin-cp/processor.php", services_form.serialize(),function(data){
			services_btn.text("Add");
			services_form.after(data);
		});
	});

	//delete service
		$('a.del-service').on('click',function(du){
		var delservice = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove this service?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delservice:delservice},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });
		//edit service
		$('a.edit-service').on('click', function(up){
		up.preventDefault();
		var editservice = $(this).data("id") , tthis = $(this);
		tthis.html(loader);
		$.post("/admin-cp/processor.php",{editservice:editservice}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.html('<i class="material-icons">create</i>');
		});
	});
		//service category form
	var category_form = $('form.category-form'), category_btn = $('.category-btn');

	category_form.on('submit', function(uf){

		uf.preventDefault();
		category_btn.html("Processing "+loader_white);

		$.post("/admin-cp/processor.php", category_form.serialize(),function(data){
			category_btn.text("Add");
			category_form.after(data);
		});
	});

	//delete service
		$('a.del-category').on('click',function(du){
		var delcategory = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove this category?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delcategory:delcategory},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });
		//edit service
		$('a.edit-category').on('click', function(up){
		up.preventDefault();
		var editcategory = $(this).data("id") , tthis = $(this);
		tthis.html(loader);
		$.post("/admin-cp/processor.php",{editcategory:editcategory}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.html('<i class="material-icons">create</i>');
		});
	});

		//service bookings update
$('a.serv-u').on("click",function(data){
	var servid = $(this).data("id"), pos = $(this).data("position"), role = $(this).data("role"), name = $(this).data("name"), service = $(this).data("service"), category = $(this).data("category"), email = $(this).data("email"), tthis = $(this);
	$("button#"+pos).html(loader_white);
	$.post("/admin-cp/processor.php", {servid:servid,role:role,name:name,service:service,category:category,email:email}, function(data){
		$("button#"+pos).text(role);
		tthis.after(data);
	});
});
//blog slug
$('input#blog_title').on("keyup",function(){
			var slug = $(this).val();
			$('input#blog_slug').val(slugGen(slug));
		});

//blog form
var blog_form = $('form.blog-form');
	blog_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.blog-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			blog_form.after(data);
			$('.blog-btn').html('Add');
		}
	});
	
});

	//delete blog
		$('.del-blog').on('click',function(du){
		var delblog = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to delete this post?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delblog:delblog},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });

		//blog update form
var updateblog_form = $('form.updateblog-form');
	updateblog_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.updatesch-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			updateblog_form.after(data);
			$('.updateblog-btn').html('update blog');
		}
	});
	
});
	//staff form
var staff_form = $('form.staff-form');
	staff_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.staff-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			staff_form.after(data);
			$('.staff-btn').html('Add');
		}
	});
	
});

	//delete staff
		$('.del-staff').on('click',function(du){
		var delstaff = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove this staff?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delstaff:delstaff},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });

		//staff update form
var updatestaff_form = $('form.updatestaff-form');
	updatestaff_form.on('submit',function(sf){
	sf.preventDefault();
	$.ajax({
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.updatestaff-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			updatestaff_form.after(data);
			$('.updatestaff-btn').html('update staff');
		}
	});
	
});

	//testimony form
var testimony_form = $('form.testimony-form');
	testimony_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.testimony-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			testimony_form.after(data);
			$('.testimony-btn').html('Add');
		}
	});
	
});

	//delete testimony
		$('.del-testimony').on('click',function(du){
		var deltestimony = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to delete this testimony?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {deltestimony:deltestimony},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });

		//testimony update form
var updatetestimony_form = $('form.updatetestimony-form');
	updatetestimony_form.on('submit',function(sf){
	sf.preventDefault();
	$.ajax({
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.updatetestimony-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			updatetestimony_form.after(data);
			$('.updatetestimony-btn').html('update testimony');
		}
	});
	
});

	//delete subscriber
			$('.del-subscriber').on('click',function(du){
		var delsub = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to remove this subscriber?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delsub:delsub},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });


	//settings form
var settings_form = $('form.settings-form');
	settings_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.settings-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			settings_form.after(data);
			$('.settings-btn').html('Add');
		}
	});
	
});
	//compose form
	var compose_form = $('form.compose-form'), compose_btn = $('.compose-btn');

	compose_form.on('submit', function(uf){

		uf.preventDefault();
		compose_btn.html("Processing "+loader_white);

		$.post("/admin-cp/processor.php", compose_form.serialize(),function(data){
			compose_btn.text("Send message");
			compose_form.after(data);
		});
	});

	//my profile
var profile_form = $('form.profile-form');
	profile_form.on('submit',function(sf){
	sf.preventDefault();
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
		url: "/admin-cp/processor.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function()
		{
			$('.profile-btn').html('Processing '+loader_white);
		},
		success: function(data)
		{
			profile_form.after(data);
			$('.profile-btn').html('Update profile');
		}
	});
	
});

	//update tour booking progress
	$('button.tour-progress').on('click', function(up){
		up.preventDefault();
		var tuid = $(this).data("its") , tsid = $(this).data('tourist'), tthis = $(this);
		tthis.html("Processing "+loader_white);
		$.post("/admin-cp/processor.php",{tuid:tuid,tsid:tsid}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.text("Update progress");
		});
	});

	//update visa progress
	$('button.visa-progress').on('click', function(up){
		up.preventDefault();
		var vuid = $(this).data("its") , vsid = $(this).data('visa'), tthis = $(this);
		tthis.html("Processing "+loader_white);
		$.post("/admin-cp/processor.php",{vuid:vuid,vsid:vsid}, function(data){
			$(".loadResponse").html(data);
			$("#loadResponse").modal("show");
			tthis.text("Update progress");
		});
	});

	//delete contact message
			$('.del-contact').on('click',function(du){
		var delcon = $(this).data("id");
		var tthis = $(this);
	iziToast.question({
    timeout: false,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Hey',
    message: 'Are you sure you want to delete this message?',
    position: 'center',
    buttons: [
        ['<button><b>YES</b></button>', function (instance, toast) {
           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
		$.post("/admin-cp/processor.php", {delcon:delcon},function(data){
			tthis.after(data);
		});
 
        }, true],
        ['<button>NO</button>', function (instance, toast) {
 
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
 
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
});

  });

});

$('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
      });