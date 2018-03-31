(function($) {
    $(document).ready(function() {
        $.fn.datepicker.setDefaults({ startDate: false, language: 'es-ES', format: 'dd/mm/yyyy' })
        var formAdmin = $('.muelle-form')
        formAdmin.find('#date').mask('00/00/0000')
        formAdmin.find('#ton').mask('000.000.000.000,000', { reverse: true })
        formAdmin.find('#slora').mask('000.000.000,00', { reverse: true })
        formAdmin.find('#calado').mask('000.000.000,00', { reverse: true })
        $('[data-toggle="datepicker"]').datepicker()
        $(".timepickband").timepicki()
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
    
    $(".content-form").on("focus","#time",function (){
        $("#time").timepicki()
    })
    
    $("#submit").click(function(ev) {       
        var form =  $(".motonave")
        var check = checkCampos(form)
        
        if(check){
            $("#submit").html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>&nbsp;&nbsp;Guardando..')
            $("#adminInfo").submit()
        }
    })

    $("#addField").click(function(ev) {
        var num = $(".bar-unity").length
        if (num >= 14) {
            alert("No pueden existir más de 14 barcos")
        } else {
            num+= 1 
            var barUnityNew= $(".bar-unity").eq(0).clone();
            barUnityNew.find('input,select').each(function() {
            this.name= this.name.replace('0',num)
            });
            barUnityNew.find('input,select').val("")
            $('.content-form').append(barUnityNew);
            $(".timepickband").timepicki()
        }
    })
    function checkCampos(obj) {
        var camposRellenados = true;
        obj.each(function() {
        var $this = $(this);
                if( $this.val().length <= 0 ) {
                    $this.addClass("error")
                    camposRellenados = false;
                    return false;
                }
        });
        if(camposRellenados == false) {
            return false;
        }
        else {
            return true;
        }
    }
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