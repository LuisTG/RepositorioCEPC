$(function () {
	$(document).on('click','.language',function(){
		var lang=$(this).attr('id');
		$.post('index.php?r=site/language',{'lang':lang},function(data){
			location.reload();
		});
	});

	$(document).on('click','.fc-day',function(){
		var date=$(this).attr('data-date');
		$.get('index.php?r=event/create',{'date':date},function(data){
			$('#modal').modal('show').find('#modalContent').html(data);
		});
	});

	$('#modalButton').click(function(){
		
		$('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
	});

	  /*  $('.enlace').on('click',function (e) {
	    	console.log("hola");
        var id = $(this).data('id');
            location.href = 'index.php?r=post/view&id=' + id;
    });*/


});