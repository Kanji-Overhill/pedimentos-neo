<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transparentia Pedimentos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ab58011517.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header></header>
        <main>
            <div class="container-fluid main-app">
                <div class="row h-100-vw">
                    <div class="col-md-2 main-menu">
                        <img src="{{ url('images/logo.jfif') }}" alt="" class="img-fluid p-4">
                        <ul class="p-4">
                            <li><a href="{{ url('/') }}">Inicio</a></li>
                            <li><a href="{{ route('index-items') }}">Items</a></li>
                            <li><a href="{{ route('orden-venta') }}">Generar Paquete y Factura</a></li>
                        </ul>
                    </div>
                    <div class="col-md-10">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
        <footer></footer>
    </div>
</body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ url('js/main.js') }}"></script>
    <script>
        $( document ).ready(function() {
            var line_items = [];
            var items_id = [];
            var pedimentos = [];
            var customer_id = "";
            $("#update-items").click(function(e){
                e.preventDefault();
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{route('update-items')}}",
                        type: 'POST',
                        data: {
                           "id": 0
                        },
                        success: function(response){
                            if(response === "Success"){
                                $(".message").html('<div class="alert alert-success" role="alert"><strong>Items</strong> actualizados correctamente</div>');
                            }else{
                                $(".message").html('<div class="alert alert-danger" role="alert"><strong>Error</strong> ocurrio un error al actualizar los items</div>');
                            }
                        },error:function(error){ 
                            console.log(error);
                        }
                });
            });
            $("#obtener").click(function(e){
                $("#line_items").html();
                $("#modals").html();
                e.preventDefault();
                let invoice_number = $("#invoice_number").val();
                var pedimentos = "";
                var modal_pedimentos = "";
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{route('obtener-datos')}}",
                        type: 'POST',
                        async : false,
                        data: {
                           "invoice_number": invoice_number
                        },
                        success: function(response){
                          
                            $(".datos_salesorder").removeClass("d-none")
                            $("#orden_venta").html(response.salesorder.salesorder_number);
                            $("#invoice_id").val(response.salesorder.salesorder_id);
                            $("#nombre_cliente").html(response.salesorder.customer_name);
                            $("#fecha_pedido").html(response.salesorder.date);
                            let items = response.salesorder.line_items;
                            customer_id = response.salesorder.customer_id;
                            line_items = [];
                            items_id = [];
                            $.each( items, function( key, item ) {
                                line_items.push(item.line_item_id);
                                items_id.push(item.item_id);
                                pedimentos = pedimentos.concat('<tr><th>'+item.sku+'</th><td>'+item.group_name+'</td><td>'+item.quantity+'</td><td><textarea class="form-control" id="s_'+item.line_item_id+'" data-sku="'+item.sku+'"></textarea>');
                                $("#line_items").append('<input type="hidden" id="c_item_'+item.line_item_id+'" value="'+item.quantity+'">');

                               /* modal_pedimentos = modal_pedimentos.concat('<div class="modal" id="'+item.line_item_id+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <div class="modal-dialog modal-lg" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Selecciona el pedimento</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> <div class="modal-body"><div class="container"><div class="row"><div class="col-md-4"><p>Número de pedimento</p></div><div class="col-md-3">Fecha de pedimento</div><div class="col-md-3">Aduana</div><div class="col-md-2">Cantidad</div></div></div>'); */
                                    /*$.ajax({
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            url: "{{route('verificar-item')}}",
                                            type: 'POST',
                                            async : false,
                                            data: {
                                               "item": item.group_name
                                            },
                                            success: function(articulos){
                                                if (articulos === null) {
                                                }else{ 
                                                    $.each( articulos, function( key2, articulo ) {
                                
                                                        modal_pedimentos = modal_pedimentos.concat('<div class="container"><div class="row"><div class="col-md-4"><div class="form-check"><input class="r_pedimento form-check-input" type="checkbox" data-line="'+item.line_item_id+'" data-item="'+articulo.IDItem+'" id="p_item_'+item.line_item_id+'" name="pedimentos[]" value="'+articulo.Pedimento+'"> <label class="form-check-label"> '+articulo.Pedimento+'</label> </div></div><div class="col-md-3">'+articulo.FechaPedimento+'</div><div class="col-md-3">'+articulo.Aduana+'</div><div class="col-md-2">'+articulo.Cantidad+'</div></div></div>');
                                                        var numbersString = articulo.No_Serie;
                                                        var numbersArray = numbersString.split(',');
                                                        $.each( numbersArray, function( key3, series ) {
                                                            let articulo_pedimento = articulo.Pedimento.replace(" ","_");
                                                            pedimentos = pedimentos.concat('<option class="'+articulo_pedimento+'_'+item.line_item_id+' series_display d-none" value="'+series+'">'+series+'</option>');
                                        
                                                        });
                                    
                                                    });
                                                    
                                                }
                                            },error:function(error_2){ 
                                                console.log(error);
                                                pedimentos = pedimentos.concat("</select></td></tr>");
                                            }
                                    });*/
                                /*modal_pedimentos = modal_pedimentos.concat('</div></div></div></div>');*/
                                pedimentos = pedimentos.concat("</td></tr>");           

                            });
                            $("#line_items").append(pedimentos); 
                            $("#modals").append(modal_pedimentos); 
                            $('.r_pedimento').change(function() {
                                if(this.checked) {
                                    let class_pedimento = $(this).val();
                                    let class_item = $(this).attr("data-line");
                                    class_pedimento = class_pedimento.replace(" ","_");
                                    $("option."+class_pedimento+"_"+class_item).removeClass("d-none");
                                }     
                            });
                        },error:function(error){ 
                            console.log(error);
                        }
                });
                $(".select-pedimentos").click(function(e){
                    e.preventDefault();
                });
                
            });
            $('.items').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var nameSelected = $(this).find('option:selected').text();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{route('get-item')}}",
                        type: 'POST',
                        data: {
                            id: valueSelected,
                        },
                        success: function(response){
                            let series = response.No_Serie.split(",");
                            $(".series").html("");
                            $(".series").attr("id",valueSelected);
                            $.each( series, function( key, value ) {
                         
                              $("#"+valueSelected).append('<option value="'+valueSelected+'|'+value+'" selected>'+value+'</option>');
                            });
                        },
                        error: function(xhr, textStatus, error) {
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        }
                    });
            });
            $('#addMore').click(function(e){
                e.preventDefault();
                let options = "";
                let x = Math.floor((Math.random() * 1000) + 1);
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{route('get-items')}}",
                        type: 'POST',
                        data: {
                            
                        },
                        success: function(response){
                            $.each( response, function( key, value ) {
                                options = options+"<option value='"+value.IDItem+"' selected>"+value.Nombre+" | "+value.Pedimento+"</option>";
                            });
                            $(".items-seleccion").append('<div class="form-group row justify-content-center border-dark"> <div class="col-md-4"> <select name="items[]" class="items custom-select"><option value="" selected hidden>Selecciona un item</option>'+options+' </select> </div> <div class="col-md-2"><input class="form-control" name="number[]" type="text" class="number" placeholder="Cantidad:"> </div> <div class="col-md-3"> <select name="series[]" id="'+x+'" class="custom-select" multiple> <option value="" selected hidden>Número de serie</option> </select> </div> </div>');
                            $('.items').on('change', function (e) {
                                var optionSelected = $("option:selected", this);
                                var valueSelected = this.value;
                                var nameSelected = $(this).find('option:selected').text();
                                    $.ajax({
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        url: "{{route('get-item')}}",
                                        type: 'POST',
                                        data: {
                                            id: valueSelected,
                                        },
                                        success: function(response){
                                            let series = response.No_Serie.split(",");
                                            $("#"+x).html("");
                                            $.each( series, function( key, value ) {
                                              $("#"+x).append('<option value="'+valueSelected+'|'+value+'" selected>'+value+'</option>');
                                            });
                                        },
                                        error: function(xhr, textStatus, error) {
                                            console.log(xhr.responseText);
                                            console.log(xhr.statusText);
                                            console.log(textStatus);
                                            console.log(error);
                                        }
                                    });
                            });
                        },
                        error: function(xhr, textStatus, error) {
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        }
                    });
            });
            $('.submit_invoice').click(function(e){
                e.preventDefault();
                var url_send = "";
                var invoice_number = $("#invoice_id").val();
                var invoice_id = $("#invoice_id").val();
                url_send = url_send.concat("&customer_id="+customer_id);
                url_send = url_send.concat("&sales_order_id="+invoice_id);
                url_send = url_send.concat("&line_items=");
                var contador_items = 0;
                

                $('textarea').each(function() {
                    var textarea = $(this).val();
                    var sku = $(this).attr("data-sku");
                    textarea = textarea.split(" ");
                    let primero = textarea[0];
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{route('getPedimento')}}",
                        type: 'POST',
                        async : false,
                        data: {
                            serial: primero,
                            sku: sku
                        },
                        success: function(response){
                            let pedimento_text = response["Pedimento"];
                            pedimentos.push(pedimento_text);
                        },
                        error: function(xhr, textStatus, error) {
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        }
                    });
                      
                });

                console.log(pedimentos);
             
                $.each( line_items, function( key, item ) {
                    var pedimentos_number = $("#p_item_"+item+":checked").val();
                    var quantity_number = $("#c_item_"+item).val();
                    var serial_selectec = $("#s_"+item).val().toString();
                    if (pedimentos[contador_items] == null) {
                        var pedimentos_value = "";
                    }else{
                        var pedimentos_value = pedimentos[contador_items];
                    }
                    
                    url_send = url_send.concat(items_id[contador_items]+"/"+quantity_number+"/"+serial_selectec+"/"+pedimentos_value+";");
                    contador_items++;
                });
              
                console.log(url_send);
               
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{route('sendFactura')}}",
                        type: 'POST',
                        data: {
                            url: url_send,
                        },
                        success: function(response){
                            alert(response.message);
                        },
                        error: function(xhr, textStatus, error) {
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        }
                });

               
            });
        });
    </script>
</html>
