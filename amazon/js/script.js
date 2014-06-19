

//$(document).ready(function(){
$(function(){

	main_path='?route=';

    var init = true, 
        state = window.history.pushState !== undefined;
            
    var handler = function(data) {

		//$('.section').hide().html(data.view).fadeIn();
		$('.section').html(data.view);
		$('#header').html(data.header);		
 
    };
			

	$.address.state('').init(function() {

		$('.ajax').address();

	}).change(function(event) {

		handling(event)
	
	}); 


	function find_slide(event, callback){

		if(typeof event.parameterNames[0] !== "undefined") {	

			slide=event.parameterNames[0];

			event.queryString
			arr = event.queryString.split ("&");
			slide_val='';
			for (var i=0; i<arr.length; i++) {
				arr_slide = arr[i].split ("=");
				
				if(arr_slide[0]==slide){
					callback(arr_slide[1])
				}

			}
		}
	}


	function handling(event){

		//if(event.pathNames.length>0){

		
				url='';
				for (var i=0; i<event.pathNames.length; i++) {
					if(i>0) s='/'; else s='';
					url+=s+event.pathNames[i];

				}

				if(url=='') url='main';


				url=main_path+url;

				if(event.queryString!='') url+='&'+event.queryString;

				a={};
				a.address=true;

				get( url, a, function(data){

					if(typeof data.href_url !== "undefined") {
						window.location.href = data.href_url;
					}
					
					if(typeof data.address_url !== "undefined"){

						$.address.value(data.address_url);
					
					}else{

						handler(data);
						find_slide(event, function(slide){
							 goToByScroll(slide);
						});

						
					}
				});


		//}
	}
	

    function goToByScroll(dataslide) {
    	//alert(dataslide)
        htmlbody.animate({
//
            scrollTop: $('.slide[data-slide="' + dataslide + '"]').offset().top-55
        }, 800, 'easeInOutQuint');
    }


/*	$('body').on('click', '.navigation li', function(e){
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });
*/



	$('body').on('click', '.href', function(e){ 
	
		href=$(this).attr('href');
		
		document.location.replace(href);
	});


	$('body').on('click', '.submit', function(e){ 
		submit(e, $('#massege'));
	});



	$('body').on('submit', 'form', function(e){
		submit(e, $(this));
	});
	


 	function submit(e, element){

		var postData = element.serializeArray();
		var formURL = element.attr("action");
		e.preventDefault(); 
		
		arr={};
		for (var i=0;i<postData.length;i++){ 
			name=postData[i]['name'];
			val=postData[i]['value'];

			if(typeof arr[name] === "undefined") {
				arr[name]={};
				j=0;
			}

			arr[name][j]=val;
			j++;
		}

		formURL=main_path+formURL+'&post=true';
	
		$.ajax(
		{
			url : formURL,
			type: "POST",
			data : arr,
			success:function(data) 
			{
				console.log(data);
				json_obj = JSON.parse(data);
				
				if(!json_obj.succ)	{
					jAlert('Error', json_obj.error)
				}else{

					$('.bottom-right').notify({
					    message: { text: json_obj.data.notification, fadeIn: { enabled: true, delay: 3000 }}
					}).show();
					$('input, textarea').val('');
				}
			   
			},
			error: function(){
				jAlert('Error', 'Error 404')
			}
		});

		e.preventDefault(); 
 	}

 


  

	function get(url, a, callback){

		$.ajax({

			type:"GET",
			data:{a:a},
			url:url,
			success:function(data){
				console.log(data);
					json_obj = JSON.parse(data);


					if(!json_obj.succ)	{
						jAlert('Error', json_obj.error)
					}else{
						callback(json_obj.data);
					}

			},
			error: function() {
				jAlert('Error', 'Error 404')
			 
			}

		});
	
	}



	mywindow = $(window);
    mywindow.stellar();
    htmlbody = $('html,body');

	mywindow.scroll(function (e) { 
		//console.log(e)



        if (mywindow.scrollTop() < 100) {
        	$('.top_header').css('min-height',140).css('border-bottom','3px solid  #ff4545');
        	$('.name').css('font-size', 30).css('margin-top', '25px');
        	$('.status').css('margin-top', '40px');
        	$('.navigation li').css('margin-top', '40px');
        	$('.name img').css('max-height', 50);

        }else{//alert('1')
        	$('.top_header').css('min-height',52).css('border-bottom',0);
        	$('.name').css('font-size',20).css('margin-top', '-3px');
        	$('.status').css('margin-top', '2px');
        	$('.navigation li').css('margin-top', '0');
        	$('.name img').css('max-height', 30);

        }
    });



/*	$('body').on('click', '.button', function(e){
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);

    });*/


	



});