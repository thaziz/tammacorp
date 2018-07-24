    <table class="table tabelan table-bordered table-striped" id="detailItem">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Item</th>
          <th>Jumlah di Kirim</th>
          <th>Jumlah di Terima</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>

<script>
    var id = {{ $data->do_id }};
    $('#detailItem').DataTable({
    responsive:true,
    destroy: true,
    processing: true,
    serverSide: true,
      ajax: {
          url : baseUrl + "/produksi/pengambilanitem/itemkirim/tabel/"+id,
      },
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
      {data: 'dod_item', name: 'dod_item'},
      {data: 'dod_qty_send', name: 'dod_qty_send', orderable: false},
      {data: 'dod_qty_received', name: 'dod_qty_received', orderable: false},
      {data: 'dod_status', name: 'dod_status', orderable: false, searchable: false},
      ],
    });
</script>