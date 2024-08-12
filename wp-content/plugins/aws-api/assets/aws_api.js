//<script>
jQuery(document).ready(function($){
	var setHtml = '<ul class="category_list">';
	var _class = '';
	$('#SearchIndex option').each( function(){
		var attr = $(this).attr('selected');
		if (typeof attr !== typeof undefined && attr !== false) {
   			_class = 'on';
		}
		else {
			_class = '';
		}			
		setHtml += '<li class="'+_class+'"><a href="#'+$(this).val()+'" data-cat="'+$(this).val()+'">'+$(this).val()+'</a></li>';
	}) 
	setHtml += '</ul>';
	$('#SearchIndex').after(setHtml);
	
	$(document).on('click', '.category_list a', function(e){
		e.preventDefault();
		$('.category_list li').removeClass('on');
		$(this).parent().addClass('on');
		$('#SearchIndex').val($(this).data('cat')).change();
		$('#searchForm .rgt .search_title .dtxt').text($(this).data('cat'));
	})
	
	$(document).on('submit', '#searchForm', function(e){
		e.preventDefault();
		var $this = $(this);
		var fdata = $this.serialize() + '&action=aws_fetch_products';
		$.ajax({
			 type : "post",
			 dataType : "json",
			 url : awsAjax.ajaxurl,
			 data : fdata,
			 beforeSend: function(){
				$this.find('.rgt').append('<span class="wait">Please wait ...</span>');	
			 },
			 success: function(response) {
			 	if(response.status){
             		$('#tbl_import').html(response.data);
					$('html, body').animate({
						scrollTop: $("#tbl_import").offset().top
					}, 500);
				}
				else{
					alert('Please put some value in any field');
				}
				
			 },
			 complete: function(){
			 	$this.find('.rgt .wait').remove();	
			 }
		})  
	});
	$(document).on('submit', '#importForm', function(e){
		e.preventDefault();
		var $this = $(this);
		var fdata = $this.serialize();
	    fdata += '&action=aws_insert_posts';
		$.ajax({
			 type : "post",
			 dataType : "json",
			 url : awsAjax.ajaxurl,
			 data : fdata,
			 beforeSend: function(){
				$this.find('button').text('Please wait...');	
			 },
			 success: function(response) {
				 alert('Data Imported Successfully');
			 },
			 complete: function(){
			 	$this.find('button').text('Import');	
			 }
		})  
	});
	$(document).on('click', '#checkall', function(e){
		
		if($(this).is(':checked')){
			$(this).closest('table').find('.checkitems').prop('checked', true);
		}
		else {
			$(this).closest('table').find('.checkitems').prop('checked', false);
		}
	});
})
