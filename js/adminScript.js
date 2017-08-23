( function( $ ) {
    
    $(document).ready(function(){
        $.fn.datepicker.setDefaults({ startDate:true,language: 'es-ES',format: 'd-mm-yyyy'})
        var formAdmin = $('.muelle-form')
        formAdmin.find('#date').mask('00/00/0000')
        formAdmin.find('#ton').mask('000.000.000.000.000', {reverse: true})        
        $('[data-toggle="datepicker"]').datepicker()
    })
    
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