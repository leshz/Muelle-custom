(function($) {
    
    $(window).ready(function(){
        $(".shipinfo").hide(); 
    })
    $(".ship").click(function(ev){
        $(".ship").removeClass('selected')
        $(this).addClass('selected')
        var idship= $(this).attr("id")
        var infomuelle = $(".infomuelle")
        while(idship.charAt(0) === ' '){
            idship = idship.substr(1);
        }
         $(".shipinfo").hide(1000); 
        infomuelle.find('#'+idship).show(1000) 
    })
})(jQuery);