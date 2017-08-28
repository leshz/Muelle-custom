(function($) {

    $(document).ready(function() {
        $.fn.datepicker.setDefaults({ startDate: true, language: 'es-ES', format: 'd-mm-yyyy' })
        var formAdmin = $('.muelle-form')
        formAdmin.find('#date').mask('00/00/0000')
        formAdmin.find('#ton').mask('000.000.000.000', { reverse: true })
        $('[data-toggle="datepicker"]').datepicker()
    })

    $(".content-form").on("click", ".moreInfo", function(ev) {
        var content = $(this).parents(".bar-unity")   
        var subForm = content.find(".completeform")
        $(".completeform").removeClass("actived")
        $(".bar-unity").removeClass("actived")
        if (subForm.hasClass('hiden')) {
            $(".bar-unity").addClass("blured")
            content.removeClass("blured").addClass("actived")  
            subForm.addClass('actived').removeClass('hiden')
        } else {
            $(".bar-unity").removeClass("blured")
            content.removeClass("actived")
            subForm.addClass('hiden').removeClass('actived')
        }
    })
    
    $(".content-form").on("focus","#date",function (){
     $('[data-toggle="datepicker"]').datepicker()    
    })

    $("#submit").click(function(ev) {
        
       $("#submit").html('')
    
        
        
        
        
    })

    $("#addField").click(function(ev) {
        var num = $(".bar-unity").length
        if (num >= 12) {
            alert("No pueden existir más de 12 barcos")
        } else {
            num+= 1 
            var barUnityNew= $(".bar-unity").eq(0).clone();
            barUnityNew.find('input,select').each(function() {
            this.name= this.name.replace('0',num)
            });
            barUnityNew.find('input,select').val("")
            $('.content-form').append(barUnityNew);
        }
    })
    
    $(".content-form").on("click", ".delete", function(ev) {
        
        var content = $(this).parents(".bar-unity")   
        var subForm = content.find('input[type="hidden"]')
        var num = $(".bar-unity").length
        var idvalue=subForm.val()
        
        if(idvalue ==""){
            if(num!==1){
                content.remove()  
            }
            else {
                alert("no puedes eliminar el unico campo")
            } 
        }
        else {
            if(confirm("Seguro deseas eliminar este campo")){
                $.ajax({
                type: "POST",
                url: "/wp-admin/admin-ajax.php", 
                data: {'action':'deleteField','id':idvalue},
                    success: function(msg){
                        console.log(msg)
                        location.reload()
                    },
                    error: function(msg){
                    console.log(msg.statusText)
                    }
                })
            }   
        }     
    })
})(jQuery);