@extends('layouts.app')

@section('content')
      <div class="row">
        <div class="col-12 text-center">
          <h1 class="text-center pt-4">Módulo de Pedimentos</h1>
          <form action="{{ route('sendFactura') }}" method="post">
            @csrf
            <div class="row justify-content-center">
              <div class="col-md-3">
                <div class="form-group">
                  <input type="text" placeholder="No de orden de venta" name="invoice_number" id="invoice_number" class="form-control">
                  <input type="hidden" name="invoice_id" id="invoice_id" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <button type="button" class="btn btn-primary" id="obtener">Obtener Datos</button>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-8 datos_salesorder d-none text-left">
                <p><b>Orden de Venta:</b> <span id="orden_venta"></span></p>
                <p><b>Nombre del cliente:</b> <span id="nombre_cliente"></span></p>
                <p><b>Fecha del pedido:</b> <span id="fecha_pedido"></span></p>
              </div>
              <div class="col-md-8 datos_salesorder d-none text-left">
                <div class="row justify-content-center">
                  <div class="col-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>SKU</th>
                          <th>Descripción</th>
                          <th>Cantidad</th>
                          <th>Números de serie</th>
                        </tr>
                      </thead>
                      <tbody id="line_items">
                        
                      </tbody>
                    </table>
                  </div>  
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12 text-center">
                <a href="" class="btn btn-success submit_invoice">Generar Paquete y Factura</a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <section id="modals">
        
      </section>
@endsection