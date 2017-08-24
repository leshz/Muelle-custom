(function($) {

    $(document).ready(function() {
        $.fn.datepicker.setDefaults({ startDate: true, language: 'es-ES', format: 'd-mm-yyyy' })
        var formAdmin = $('.muelle-form')
        formAdmin.find('#date').mask('00/00/0000')
        formAdmin.find('#ton').mask('000.000.000.000.000', { reverse: true })
        $('[data-toggle="datepicker"]').datepicker()
    })

    $(".content-form").on("click", ".moreInfo", function(ev) {
        var content = $(this).parents(".bar-unity")
        var subForm = content.find(".completeform")
        if (subForm.hasClass('hiden')) {
            subForm.addClass('actived').removeClass('hiden');
        } else {
            subForm.addClass('hiden').removeClass('actived');
        }
    })

    $("#submit").click(function(ev) {
        ev.preventDefault()

        var num = $(".bar-unity").length
        console.log(num)

    })

    $("#addField").click(function(ev) {

        var num = $(".bar-unity").length
        console.log(num)
        if (num >= 12) {
            alert("no pueden haber mas de 12 barcos")
        } else {
            $.ajax({
                type: "POST",
                url: "/wp-admin/admin-ajax.php",
                data: { 'action': 'addFieldForm' },
                success: function(msg) {
                    $(".content-form").append(msg)
                },
                error: function(msg) {
                    console.log(msg.statusText);
                }
            })
        }
    })
})(jQuery);