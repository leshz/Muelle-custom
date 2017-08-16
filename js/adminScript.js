var $j = jQuery.noConflict(true)

var formAdmin = $j('.muelle-form')

$j(".button-primary.moreInfo").click(function(ev){
    var content = $j(this).parents(".bar-unity")
    var subForm = content.find(".completeform")
       // complex.css("background-color", "red")//hasClass("hiden")   
        
      if(subForm.hasClass('hiden')){
            subForm.addClass('actived').removeClass('hiden');
        }
        else{
            subForm.addClass('hiden').removeClass('actived');
        } 
    })