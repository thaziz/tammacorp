  <table class="table tabelan table-bordered table-striped" id="tableAksi">
    <thead>
      <tr>
        <th>Nomor SPK</th>
        <th>Nama Item</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th width="10%">Jumlah Item</th>
        <th>Status</th>
        <th width="15%">Aksi</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>

<script>
var x = {{ $getid[0]->pr_id }};
var oTable = $('#tableAksi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : baseUrl + "/produksi/o_produksi/getdata/"+x,
        },
        columns: [
        {data: 'spk_code', name: 'spk_code'},
        {data: 'i_name', name: 'i_name'},
        {data: 'prdt_date', name: 'prdt_date', orderable: false},
        {data: 'prdt_time', name: 'prdt_time', orderable: false},
        {data: 'prdt_qty', name: 'prdt_qty', orderable: false, searchable: false},
        {data: 'prdt_status', name: 'prdt_status'},
        {data: "action" },
    ],
    });

function hapus(id1,id2){
  if(!confirm("Hapus Jumlah Hasil Produksi?")) return false;
  $.ajax({
    type: "get",
    url : baseUrl + "/produksi/o_produksi/distroy/"+id1+'/'+id2,
    success: function(){
      oTable.ajax.reload();
    }
  });
}

function kirim(id1,id2){
  if(!confirm("Apakah Barang Siap di Kirim?")) return false;
  $('.buttonKirim').attr('disabled','disabled');
  $.ajax({
    type: "get",
    url : baseUrl + "/produksi/o_produksi/sending/"+id1+'/'+id2,
    success: function(response){
      if (response.status=='sukses') {
        oTable.ajax.reload();
        alert('Status Barang Telah Terkirim!!!');
    }else{
      alert('Barang Belum Bisa di Kirim');
        $('.buttonKirim').removeAttr('disabled','disabled');
    }
    }
  });
}


</script>