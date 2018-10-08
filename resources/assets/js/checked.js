$('input[type=checkbox]').on('change', function(){
  if($(this).is(':checked')){
    var parent = $(this).parents('.image-container');
    parent.addClass('border border-success checked');
  }else{
    var parent = $(this).parents('.image-container');
    if(parent.hasClass('border')){
      parent.removeClass('border border-success checked');
    }
  }
});
