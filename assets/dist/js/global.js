
var base_url = 'http://www.cesarreyes.com.pe/intranet/';

var url = base_url;

var controller = getSegment(2);


function init_registro(){

    if( typeof (controller) === 'undefined'){ return; }

    if( controller != 'registro' ){ return; }

        // [ Daterangepicker ]
        try {

            $('input[name="fnacimiento"]').daterangepicker({

                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1940,
                maxYear: parseInt(moment().format('YYYY'),10) - 18,
                locale: {
                format: 'DD-MM-YYYY',
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Setiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },

            }, function(start, end, label) {

            });

            var myCalendar = $('input[name="fnacimiento"]');
            var isClick = 0;

            $(window).on('click',function(){
                isClick = 0;
            });

            $(myCalendar).on('apply.daterangepicker',function(ev, picker){
                isClick = 0;
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
    
            });

            $('.js-btn-calendar').on('click',function(e){
                e.stopPropagation();

                if(isClick === 1) isClick = 0;
                else if(isClick === 0) isClick = 1;

                if (isClick === 1) {
                    myCalendar.focus();
                }
            });

            $(myCalendar).on('click',function(e){
                e.stopPropagation();
                isClick = 1;
            });

            $('.daterangepicker').on('click',function(e){
                e.stopPropagation();
            });

            


        } catch(er) {console.log(er);}
    /*[ Select 2 Config ]
    ===========================================================*/
    
    try {

        var selectSimple = $('.js-select-simple');
        selectSimple.each(function () {
            var that = $(this);
            var selectBox = that.find('select');
            var selectDropdown = that.find('.select-dropdown');
            selectBox.select2({
                dropdownParent: selectDropdown,
                placeholder: 'SELECCIONE OPCIÓN',
            });
        });

        $('.select-provincia').on("select2:select", function (event) {
            $(".select-distrito").empty();
            var param = $(".select-provincia option:selected").val();
            $.ajax({
                url: url+'/'+controller+'/list_distrito',
                data: {param: param},
                type: 'POST',
                cache: false,
                dataType: "json",
                success: function (result) {
                    var dbSelect = $('.select-distrito');
                    dbSelect.empty();
                    for (var i = 0; i < result.length; i++) {
                        dbSelect.append($('<option/>', {
                            value: result[i].ubigeo,
                            text: result[i].nomdistrito
                        }));
                    }
                    dbSelect.val(0).trigger('change');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

    } catch (err) {
        console.log(err);
    }
}


(function ($) {
    'use strict';

    init_registro();
    

})(jQuery);

function getSegment(x){
    var segment = window.location.pathname.split("/");
    return segment[x];
};