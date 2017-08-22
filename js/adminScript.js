( function( $ ) {
    
    $(document).ready(function(){
        $.datetimepicker.setLocale('en');
        
        var formAdmin = $('.muelle-form')
        formAdmin.find('#date').mask('00/00/0000')
        formAdmin.find('#ton').mask('000.000.000.000.000', {reverse: true})
    
       $('#date').datetimepicker({
            dayOfWeekStart: 1,
            lang: 'en',
            disabledDates: ['1986/01/08', '1986/01/09', '1986/01/10'],
            startDate: '1986/01/05'
        })
    
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