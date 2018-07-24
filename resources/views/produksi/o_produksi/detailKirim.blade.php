  <table class="table tabelan table-bordered table-striped" id="tableAksiKirim">
  <thead>
    <tr>
      <th>Nomor SPK</th>
      <th>Nama Item</th>
      <th>Tanggal</th>
      <th>Waktu</th>
      <th width="10%">Jumlah Item</th>
      <th>Status</th>
{{--       <th>Aksi</th> --}}
    </tr>
  </thead>
  <tbody>

  </tbody>
  </table>

<script>
var y = {{ $getid[0]->pr_id }};
var oTable = $('#tableAksiKirim').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : baseUrl + "/produksi/o_produksi/getdata/kirim/"+y,
        },
        columns: [
        {data: 'spk_code', name: 'spk_code'},
        {data: 'i_name', name: 'i_name'},
        {data: 'prdt_date', name: 'prdt_date', orderable: false},
        {data: 'prdt_time', name: 'prdt_time', orderable: false},
        {data: 'prdt_qty', name: 'prdt_qty', orderable: false, searchable: false},
        {data: 'prdt_status', name: 'prdt_status'},
        // {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    });
</script>