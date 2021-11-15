var id_edit=0;
$(document).on('click','.btn_city_edit',function(){
	id_edit=$(this).data('id');
	$('#inputEditCityName').val($(this).data('name'));
});
$(document).on('click', '.pagination .page-item a', function(event){
  event.preventDefault(); 
	var page = $(this).attr('href').split('page=')[1];
  if ($('#pills-transaction-tab').hasClass('active')) {
  	fetch_transaction(page);
  	
  }
  if($('#pills-retiro-tab').hasClass('active')){
  	fetch_retiros(page);
  }
  if($('#pills-payed-tab').hasClass('active')){
  	fetch_payed(page);
  }
  
});
 $(document).on('click','.btn_pay',function() {
 	var id=$(this).data("id");
 	$.ajax({
		url: 'save/payed/'+id+"?user="+$(this).data("user"),
	  	success: function(data) {
	  	$('#tr_retiro_'+id).remove();
	  	$('#pills-payed').html(data);
	  }
	});
 });
 function fetch_transaction(page)
 {
  $.ajax({
   url:"fetch/transaction?page="+page,
   success:function(data)
   {
    $('#content_transaction').html(data);
   }
  });
 }
 function fetch_retiros(page)
 {
  $.ajax({
   url:"fetch/retiro?page="+page,
   success:function(data)
   {
    $('#pills-retiro').html(data);
   }
  });
 }
  function fetch_payed(page)
 {
  $.ajax({
   url:"fetch/payed?page="+page,
   success:function(data)
   {
    $('#pills-payed').html(data);
   }
  });
 }
$(document).on('click','.btn_type_edit',function(){
	id_edit=$(this).data('id');
	$('#inputEditTypeName').val($(this).data('name'));
});

$("#formCityAdd").on("submit", function(e){
	e.preventDefault();
	var myForm = document.getElementById("formCityAdd");
	var formData = new FormData(myForm);
	$.ajax({
			type: 'POST',
			url: 'save/city',
			data: formData,  
	                    processData: false,  // tell jQuery not to process the data
	  contentType: false, // Al atributo data se le asigna el objeto FormData.
	  success: function(data) {
	  	$('#Content_City').append(data);
	  	$('#inputAddCityName').val("");
	  	$('.btn-close').click();


	  },error : function(xhr, status) {

	  }
	});

});

$("#formCityEdit").on("submit", function(e){
     e.preventDefault();
    var myForm = document.getElementById("formCityEdit");
   var formData = new FormData(myForm);
 	$.ajax({
               type: 'POST',
               url: 'edit/city/'+id_edit,
                     data: formData,  
                     processData: false,  // tell jQuery not to process the data
   					contentType: false, // Al atributo data se le asigna el objeto FormData.
                     success: function(data) {
                       $('#tr_city_'+id_edit).replaceWith(data);
                        $('#inputEditCityName').val("");
                        $('.btn-close').click();
                  
             },error : function(xhr, status) {
            
     }
           });

});

 $("#formTypeAdd").on("submit", function(e){
	e.preventDefault();
	var myForm = document.getElementById("formTypeAdd");
	var formData = new FormData(myForm);
	$.ajax({
			type: 'POST',
			url: 'save/type',
			data: formData,  
	                    processData: false,  // tell jQuery not to process the data
	  contentType: false, // Al atributo data se le asigna el objeto FormData.
	  success: function(data) {
	  	$('#Content_Type').append(data);
	  	$('#inputAddTypeName').val("");
	  	$('.btn-close').click();


	  },error : function(xhr, status) {

	  }
	});

});
 $("#formTypeEdit").on("submit", function(e){
     e.preventDefault();
    var myForm = document.getElementById("formTypeEdit");
   var formData = new FormData(myForm);
 	$.ajax({
               type: 'POST',
               url: 'edit/type/'+id_edit,
                     data: formData,  
                     processData: false,  // tell jQuery not to process the data
   					contentType: false, // Al atributo data se le asigna el objeto FormData.
                     success: function(data) {
                       $('#tr_type_'+id_edit).replaceWith(data);
                        $('#inputEditTypeName').val("");
                        $('.btn-close').click();
                  
             },error : function(xhr, status) {
            
     }
           });

 });