<script type="text/javascript">

function simpan(){
  $('.simpanCus').attr('disabled','disabled');
  var a = $('#save_customer').serialize();
  $.ajax({
    url : baseUrl + "/penjualan/POSgrosir/grosir/store",
    type: 'get',
    data: a,
    success:function(response){
      if (response.status=='sukses') {
      $('#myModal').modal('hide');
        $("input[name='nama_cus']").val('');
        $("input[name='tgl_lahir']").val('');
        $("input[name='email']").val('');
        $("input[name='tipe_cust']").val('');
        $("input[name='no_hp']").val('');
        $("textarea[name='alamat']").val('');
        alert('Data Tersimpan');
        window.location.href = baseUrl+"/penjualan/POSgrosir/index";
        }else{
        alert('Mohon melengkapi data!!!');
       $('.simpanCus').removeAttr('disabled','disabled');
        }
      }
    })
  }

$("input[name='s_member']").focus();

function sal_save_final(){
  $('.simpanFinal').attr('disabled','disabled');
  var bb = $('#save_sform :input').serialize();
  var cc = $('#save_item :input').serialize();
  var data=tableDetail.$('input').serialize();
  $.ajax({
    url : baseUrl + "/penjualan/POSgrosir/grosir/sal_save_final",
    type: 'get',
    data: bb+'&'+cc+'&'+data,

    success:function(response){
      if (response.status=='sukses') {
          $('#proses').modal('hide');
            $("input[name='s_member']").val('');
            $("input[name='s_net']").val('');
            $("input[name='s_disc_percent']").val('');
            $("input[name='s_disc_value']").val('');
            $("input[name='s_pajak']").val('');
            $("input[name='s_net']").val('');
            $("input[name='sd_qty[]']").val('');
            $("input[name='sd_sell[]']").val('');
            $("input[name='s_dibayarkan']").val('');
            $("input[name='s_kembalian']").val('');
            $("input[name='sd_disc_percent[]']").val('');
            $("input[name='sd_disc_value[]']").val('');
            $("input[name='sp_method[]']").val('');
            $("input[name='sp_nominal[]']").val('');
            var id = $('#idfatkur').val();
            if (confirm("Berhasil!, Ingin langsung cetak nota?")) {
              window.open(baseUrl+"/penjualan/POSgrosir/print/"+id,"_blank");
              window.open(baseUrl+"/penjualan/POSgrosir/print_surat_jalan/"+id,"_blank");
              window.location.href = baseUrl+"/penjualan/POSgrosir/index";

            } else {
              window.location.href = baseUrl+"/penjualan/POSgrosir/index";
            }
          }else{
            alert('Mohon melengkapi data penjualan!!!');
            $('.simpanFinal').removeAttr('disabled','disabled');
          }
        }
      })
    }

function sal_save_onProgres(){
  $('.simpanProgres').attr('disabled','disabled');
  var bb = $('#save_sform :input').serialize();
  var cc = $('#save_item :input').serialize();
  var data=tableDetail.$('input').serialize();
  $.ajax({
    url : baseUrl + "/penjualan/POSgrosir/grosir/sal_save_onprogres",
    type: 'get',
    data: bb+'&'+cc+'&'+data,
    success:function(response){
      if (response.status=='sukses') {
          $('#proses').modal('hide');
          $("input[name='s_member']").val('');
          $("input[name='s_net']").val('');
          $("input[name='s_pajak']").val('');
          $("input[name='s_net']").val('');
          $("input[name='sd_qty[]']").val('');
          $("input[name='sd_sell[]']").val('');
          $("input[name='sd_disc_percent[]']").val('');
          $("input[name='sd_disc_value[]']").val('');
          alert('Berhasil Menyimpan On_Progres');
          window.location.href = baseUrl+"/penjualan/POSgrosir/index";
        }else{
          alert('Mohon melengkapi data penjualan!!!');
          $('.simpanProgres').removeAttr('disabled','disabled');
        }
      }         
    })
  }

function sal_save_draft(){
  $('.simpanDraft').attr('disabled','disabled');   
  var bb = $('#save_sform :input').serialize();
  var cc = $('#save_item :input').serialize();
  var data=tableDetail.$('input').serialize();
  $.ajax({
    url : baseUrl + "/penjualan/POSgrosir/grosir/sal_save_draft",
    type: 'get',
    data: bb+'&'+cc+'&'+data,
    success:function(response){
    if (response.status=='sukses') {
        $("input[name='id_cus']").val('');
        $("input[name='s_gross']").val('');
        $("input[name='s_net']").val('');
        $("input[name='totalDiscount']").val('');
        $("input[name='s_disc_percent']").val('');
        $("input[name='s_disc_value']").val('');
        $("input[name='s_pajak']").val('');
        $("input[name='sd_qty[]']").val('');
        $("input[name='sd_sell[]']").val('');
        $("input[name='s_pembayaran[]']").val('');
        $("input[name='s_dibayarkan']").val('');
        $("input[name='s_kembalian']").val('');
        $("input[name='sd_disc_percent[]']").val('');
        $("input[name='sd_disc_value[]']").val('');
        alert('di simpan sebagai draft');
        window.location.href = baseUrl+"/penjualan/POSgrosir/index";
      }else{
        alert('Mohon melengkapi data penjualan!!!');
        $('.simpanDraft').removeAttr('disabled','disabled');;
    }
    }
  })
}

function sal_save_finalUpdate(){
  $('.simpanFinal').attr('disabled','disabled');
  var bb = $('#save_sform :input').serialize();
  var cc = $('#save_item :input').serialize();
  var data=tableDetail.$('input').serialize();
  $.ajax({
    url : baseUrl + "/penjualan/POSgrosir/grosir/sal_save_finalupdate",
    type: 'get',
    data: bb+'&'+cc+'&'+data,

    success:function(response){
      if (response.status=='sukses') {
        $('#proses').modal('hide');
          $("input[name='s_member']").val('');
          $("input[name='s_gross']").val('');
          $("input[name='s_disc_percent']").val('');
          $("input[name='s_disc_value']").val('');
          $("input[name='s_pajak']").val('');
          $("input[name='s_net']").val('');
          $("input[name='sd_qty[]']").val('');
          $("input[name='sd_sell[]']").val('');
          $("input[name='s_pembayaran[]']").val('');
          $("input[name='s_dibayarkan']").val('');
          $("input[name='s_kembalian']").val('');
          $("input[name='sd_disc_percent[]']").val('');
          $("input[name='sd_disc_value[]']").val('');
          var id = $('#no_fakturId').val();
          if (confirm("Berhasil!, Ingin langsung cetak nota?")) {
              window.open(baseUrl+"/penjualan/POSgrosir/print/"+id,"_blank");
              window.open(baseUrl+"/penjualan/POSgrosir/print_surat_jalan/"+id,"_blank");
              window.location.href = baseUrl+"/penjualan/POSgrosir/index";
          } else {
              window.location.href = baseUrl+"/penjualan/POSgrosir/index";
            }
        }else{
          alert('Mohon melengkapi data penjualan!!!');
          $('.simpanFinal').removeAttr('disabled','disabled');;
        }        
    }
  });
}  

function sal_save_onProgresUpdate(){
  $('.simpanProgres').attr('disabled','disabled');
  var bb = $('#save_sform :input').serialize();
  var cc = $('#save_item :input').serialize();
  var data=tableDetail.$('input').serialize();
  $.ajax({
    url : baseUrl + "/penjualan/POSgrosir/grosir/sal_save_onProgresUpdate",
    type: 'get',
    data: bb+'&'+cc+'&'+data,

    success:function(response){
      if (response.status=='sukses') {
        $('#proses').modal('hide');
          $("input[name='s_member']").val('');
          $("input[name='s_gross']").val('');
          $("input[name='s_disc_percent']").val('');
          $("input[name='s_disc_value']").val('');
          $("input[name='s_pajak']").val('');
          $("input[name='s_net']").val('');
          $("input[name='sd_qty[]']").val('');
          $("input[name='sd_sell[]']").val('');
          $("input[name='s_pembayaran[]']").val('');
          $("input[name='s_dibayarkan']").val('');
          $("input[name='s_kembalian']").val('');
          $("input[name='sd_disc_percent[]']").val('');
          $("input[name='sd_disc_value[]']").val('');
          alert('Berhasil');
          window.location.href = baseUrl+"/penjualan/POSgrosir/index";
        }else{
          alert('Mohon melengkapi data penjualan!!!');
          $('.simpanProgres').removeAttr('disabled','disabled');
        }   
    }
  });
}  
</script>