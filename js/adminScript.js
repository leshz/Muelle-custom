( function( $ ) {
    
    var formAdmin = $('.muelle-form')
    
    $(".button-primary.moreInfo").click(function(ev){
        var content = $(this).parents(".bar-unity")
        var subForm = content.find(".completeform") 
        if(subForm.hasClass('hiden')){
            subForm.addClass('actived').removeClass('hiden');     
        }
        else{
            subForm.addClass('hiden').removeClass('actived');
        } 
    })
} )( jQuery );
