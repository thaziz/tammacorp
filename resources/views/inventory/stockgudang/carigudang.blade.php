<div class="table-responsive">
<table class="table tabelan table-hover table-bordered" id="data-cari">
  <thead>
    <tr>
      {{-- <th>No</th> --}}
      <th>Posisi cabang</th>
      <th>Posisi gudang</th>
      <th>Item</th>
      <th>Qty</th>
      <th>Detil</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($cari_data as $element)
        <tr>
          <td>{{ $element->cg_cabang }}</td>
          <td>{{ $element->cg_gudang }}</td>
          <td>{{ $element->i_name }}</td>
          <td>{{ $element->s_qty }}</td>
          <td><button id="edit" onclick="detail(this)" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button></td>
        </tr>
      @endforeach
  </tbody>
</table>
</div>
