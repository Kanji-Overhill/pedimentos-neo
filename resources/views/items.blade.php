@extends('layouts.app')

@section('content')
      <div class="row">
        <div class="col-12 text-center"><h1 class="mt-4 mb-4">Items</h1>
          <table class="table">
          <thead class="thead-dark">
            <tr>
              <th>SKU</th>
              <th>Nombre</th>
              <th>Cantidad</th>
              <th>Pedimento</th>
              <th>FechaPedimento</th>
              <th>Aduana</th>
            </tr>
          </thead>
          <tbody>
              @foreach($items as $item)
              <tr>
                  <td>{{ $item->Sku }}</td>
                  <td>{{ $item->Nombre }}</td>
                  <td>{{ $item->Cantidad }}</td>
                  <td>{{ $item->Pedimento }}</td>
                  <td>{{ $item->FechaPedimento }}</td>
                  <td>{{ $item->Aduana }}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
        </div>
      </div>
@endsection