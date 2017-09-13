(function($) {
    
    $(window).ready(function(){
        $(".shipinfo").hide(); 
    })
    
    $(window).load(function (){
        setTimeout(function(){
            $(".loader").addClass("bye")
        }, 1000)
        setTimeout(function(){
            $(".loader").hide()
        }, 2000)
    })
    $(".ship").click(function(ev){
        $(".ship").removeClass('selected')
        $(this).addClass('selected')
        var idship= $(this).attr("id")
        var infomuelle = $(".infomuelle")
        while(idship.charAt(0) === ' '){
            idship = idship.substr(1);
        }
        $(".shipinfo").hide(1000)
        infomuelle.find('#'+idship).show(1000) 
        var position = $("#info-ship").offset().top
        $('html,body').animate( {scrollTop :position}, 1200 );
    })
    
    
    $(".filepicker button").click(function (ev){
        d=$(".filepicker select").val()
        if (d != 'Descargar Situacion portuaria'){
            window.open(d)
            } 
    })
    
})(jQuery);

