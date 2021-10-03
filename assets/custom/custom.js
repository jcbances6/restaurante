

var base_url = 'http://localhost/restaurante/';

var url = base_url + getSegment(2);

var controller = getSegment(3);

var formatter = new Intl.NumberFormat('es-PE', {
      style: 'currency',
      currency: 'PEN',

});

   const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

function init_menu(){

    var url_menu = window.location;
    $('ul.nav-sidebar a').filter(function () {
        return this.href == url_menu || url_menu.href.indexOf(this.href) == 0;
    }).addClass('active');
    $('ul.nav-treeview a').filter(function() {
       return this.href == url_menu || url_menu.href.indexOf(this.href) == 0;
   }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');

}


function init_inicio() {

    if( typeof (controller) === 'undefined'){ return; }

    if( controller != 'inicio' ){ return; }


    $(".btn-mesa").on("click",function(){

        var param = $(this).val();
        $.ajax({
            url: url+'/'+controller+'/pasarela',
            type: "POST",
            data:{param: param},
            success:function(resp){
                window.location.href = url+'/'+controller+'/orden/nueva';
            }
        });
        
    });
    // $(".select2_single").select2({
    //     language: "es",
    //     width: "100%"
    // });

    $(".btn-filter-categoria").on("click",function(){

        var param = $(this).val();
        $("#listProductos.table").DataTable({

            language: {
                url: base_url+'assets/datatables/json/Spanish.json'
            },

            "responsive": true,
            "autoWidth": false,
            "searching": true, 
            "ordering": false,
            "paging": false,
            "info": false,
            "destroy": true,
            "ajax": {
                "method": "POST",
                "url"   : url+'/'+controller+'/fill_table_productos',
                "data" : function (d) {
                    return $.extend({}, d, {
                        param: param
                    });
                },
                "dataSrc": "data"
            },

            columns: [
                {
                    "mData": "Producto",
                    "mRender": function (data, type, row) {                        
                        return '<div class="text-bold">'+row.NomProducto+' </div><div class="text-gray">'+row.Descripcion+'</div>';
                    }
                },
                {
                    "mData": "Precio",
                    "mRender": function (data, type, row) {                        
                        return '<div class="text-bold text-right">'+formatter.format(row.Precio)+'</div>';
                    }
                },
                {
                    "mData": "Opciones",
                    "class": "text-center",
                    "mRender": function (data, type, row) {
                        return '<button type="button" class="btn btn-primary btn-add-product-order" value="'+ row.IDProducto +'" datas-toggle="tooltip" data-placement="bottom" title="Agregar Producto" ><i class="fas fa-plus-square"></i></button>';
                    }
                }
            ],
                 
        });
        
    });

    $("#listProductos.table").DataTable({

        language: {
            url: base_url+'assets/datatables/json/Spanish.json'
        },

        "responsive": true,
        "autoWidth": false,
        "searching": true, 
        "ordering": false,
        "paging": false,
        "info": false,
        "destroy": true,
        "ajax": {
            "method": "POST",
            "url"   : url+'/'+controller+'/fill_table_productos',
            "data" : function (d) {
                return $.extend({}, d, {
                    param: 'C00'
                });
            },
            "dataSrc": "data"
        },

        columns: [
        {
            "mData": "Producto",
            "mRender": function (data, type, row) {                        
                return '<div class="text-bold">'+row.NomProducto+' </div><div class="text-gray">'+row.Descripcion+'</div>';
            }
        },
        {
            "mData": "Precio",
            "mRender": function (data, type, row) {                        
                return '<div class="text-bold text-right" >'+formatter.format(row.Precio)+'</div>';
            }
        },
        {
            "mData": "Opciones",
            "class": "text-center",
            "mRender": function (data, type, row) {
                return '<button type="button" class="btn btn-primary btn-add-product-order" value="'+ row.IDProducto +'" datas-toggle="tooltip" data-placement="bottom" title="Agregar Producto" ><i class="fas fa-plus-square"></i></button>';
            }
        }
        ],
                 
    });


    $('#listProductos tbody').on('click', '.btn-add-product-order', function () {
        var param = $(this).val();
        
        var t = $('#selectProductos').DataTable();

        var indexes = t.rows().indexes().filter(function(value,index){
            return param === t.row(value).node().id;
        });

        if(indexes.count()===0){
            $.ajax({
                url: url+'/'+controller+'/getDatosProducto',
                type: "POST",
                dataType: "json",
                data:{idp: param},
                success:function(resp){
                    t.row.add( [
                        '<button type="button" class="btn btn-danger btn-remove-product" value="" datas-toggle="tooltip" data-placement="bottom" title="Eliminar producto"><span class="fas fa-trash-alt"></span></button>',
                        '<div class="text-bold">'+resp.data.NomProducto+' </div><div class="text-gray">'+resp.data.Descripcion+'</div>',
                        '<div class="input-group btn-group"><button type="button" class="btn btn-danger btn-minus-cant"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" name="cant'+resp.data.IDProducto+'" id="cant'+resp.data.IDProducto+'" class="form-control text-center cant" value="1" readonly style="background-color: #fff;"></input>'+
                        '<button type="button" class="btn btn-success btn-add-cant"><i class="fas fa-plus"></i></button></div>',
                        '<div id="punidad'+resp.data.IDProducto+'" class="punidad" >'+ formatter.format(resp.data.Precio) + '</div>',
                        '<div id="ptotal'+resp.data.IDProducto+'" class="ptotal" >'+ formatter.format(resp.data.Precio) + '</div>'
                        
                        ] ).node().id = param;
                    t.draw( false );
                    _calcTotal();
                }
            });
        }else{
            Toast.fire({ icon: 'error', title: 'Error Producto ya se encuentra agregado.' });
        }

        
    });


    $('#selectProductos.table').DataTable({
        language: {
            url: base_url+'assets/datatables/json/Spanish.json'
        },
        "responsive": true,
        "autoWidth": false,
        "searching": false, 
        "ordering": false,
        "paging": false,
        "info": false,
        columnDefs: [
            {
                targets: [0,2,3,4],
                className: 'text-center'
            },
            
        ]
        // "destroy": true,
    });


    $('#selectProductos tbody').on('click', '.btn-remove-product', function () {
        var t = $('#selectProductos.table').DataTable();
        t.row( $(this).parents('tr') ).remove().draw(false);
        _calcTotal();
    });


    $('#selectProductos tbody').on('click', '.btn-add-cant, .btn-minus-cant', function () {
        
        var $cantxt = $(this).closest('tr').find('.cant');
        currentVal = parseInt($cantxt.val()),
        isAdd = $(this).hasClass('btn-add-cant');
        !isNaN(currentVal) && $cantxt.val(
          isAdd ? ++currentVal : (currentVal > 1 ? --currentVal : currentVal)
          );

        var $ptotal = $(this).closest('tr').find('.ptotal');
        var $punidad = $(this).closest('tr').find('.punidad');
        
        $ptotal.text( formatter.format( parseFloat($punidad.text().replace(/[^0-9,.]*/, '') ) * parseFloat($cantxt.val())   ));

        _calcTotal();

    });

    $(".btn-guardar-orden").on("click",function(){

        if($("#nomcliente").val().trim() == ''){ Toast.fire({ icon: 'error', title: 'Falta nombre del Cliente.' }); return}

        var t = $('#selectProductos').DataTable();
        var total = 0;
        var myJSON  = [];
        t.rows().indexes().filter(function(value,index){
            const obj = {idproducto: t.row(value).node().id, cantidad: $("#cant"+t.row(value).node().id).val()};
            myJSON.push(obj);
        });

        const myJSONSend = JSON.stringify({ idmesa: $("#idmesa").val(), nomcliente: $("#nomcliente").val(), observacion: $("#observ").val(), detalle: myJSON} );

        $.ajax({
            url: url+'/'+controller+'/saveOrden',
            type: "POST",
            data:{jsonData: myJSONSend},
            success:function(resp){
                window.location.href = url+'/'+controller+'/';
                // console.log(resp);
            }
        });
        console.log(myJSONSend);
    });

    $(".btn-actualizar-orden").on("click",function(){

        if($("#nomcliente").val().trim() == ''){ Toast.fire({ icon: 'error', title: 'Falta nombre del Cliente.' }); return}

        var t = $('#selectProductos').DataTable();
        var total = 0;
        var myJSON  = [];
        t.rows().indexes().filter(function(value,index){
            const obj = {idproducto: t.row(value).node().id, cantidad: $("#cant"+t.row(value).node().id).val()};
            myJSON.push(obj);
        });

        const myJSONSend = JSON.stringify({ idorden: $("#idorden").val(), idmesa: $("#idmesa").val(), nomcliente: $("#nomcliente").val(), observacion: $("#observ").val(), detalle: myJSON });

        $.ajax({
            url: url+'/'+controller+'/updateOrden',
            type: "POST",
            data:{jsonData: myJSONSend},
            success:function(resp){
                window.location.href = url+'/'+controller+'/';
                // console.log(resp);
            }
        });

    });

    $(".btn-cerrar-orden").on("click",function(){

        if($("#nomcliente").val().trim() == ''){ Toast.fire({ icon: 'error', title: 'Falta nombre del Cliente.' }); return}

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Está seguro de cerrar la orden?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Cerrar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {

            if (result.value) {
                console.log("entro");
                 const myJSONSend = JSON.stringify({ idorden: $("#idorden").val(), idmesa: $("#idmesa").val()} );
                $.ajax({
                    url: url+'/'+controller+'/finalOrden',
                    type: "POST",
                    data:{jsonData: myJSONSend},
                    success:function(resp){
                        window.location.href = url+'/'+controller+'/';
                    }
                });
                
            }
        });

        // var t = $('#selectProductos').DataTable();
        // var total = 0;
        // var myJSON  = [];
        // t.rows().indexes().filter(function(value,index){
        //     const obj = {idproducto: t.row(value).node().id, cantidad: $("#cant"+t.row(value).node().id).val()};
        //     myJSON.push(obj);
        // });

        // const myJSONSend = JSON.stringify({ idorden: $("#idorden").val(), idmesa: $("#idmesa").val(), nomcliente: $("#nomcliente").val(), detalle: myJSON} );

        // $.ajax({
        //     url: url+'/'+controller+'/updateOrden',
        //     type: "POST",
        //     data:{jsonData: myJSONSend},
        //     success:function(resp){
        //         window.location.href = url+'/'+controller+'/';
        //         // console.log(resp);
        //     }
        // });
        // console.log(myJSONSend);
    });



    _calcTotal();

};

function _calcTotal(){

    var t = $('#selectProductos').DataTable();
    var total = 0;
    t.rows().indexes().filter(function(value,index){
        total += parseFloat($("#ptotal"+t.row(value).node().id).text().replace(/[^0-9,.]*/, '')) ;
    });

    $("#ptotalventa").text("Total " +formatter.format(total));

}


function getSegment(x){
    var segment = window.location.pathname.split("/");
    return segment[x];
};


$(function(){

    $('[datas-toggle="tooltip"]').tooltip({
        trigger : 'hover'
    });

    init_menu();
    init_inicio();

  });




