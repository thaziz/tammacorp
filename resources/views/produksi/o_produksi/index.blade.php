@extends('main')
@section('content')
<link href="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Form Manajemen Output Produksi</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Manajemen Output Produksi</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen Output Produksi&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <div class="page-content fadeInRight">
        <div id="tab-general">
            <div class="row mbl">
                <div class="col-lg-12">
                    
                    <div class="col-md-12">
                        <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                        </div>
                    </div>
                <ul id="generalTab" class="nav nav-tabs">
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen Output Produksi</a></li>
                  <li><a href="#note-hasil-produksi" data-toggle="tab">Form Hasil Produksi</a></li>
                </ul>
                <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
              
               <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                 <div class="col-md-5 col-sm-6 col-xs-8" >
                   <h4>Form Manajemen Output Produksi</h4>
                 </div>
               </div>
             <div class="col-md-12 col-sm-12 col-xs-12">
                <form onsubmit="return false" autocomplete="off">
                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                            <div class="col-md-3 col-sm-12 col-xs-12">  
                                    <label class="tebal">Tanggal Produksi</label>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input value="{{ date('d-m-Y') }}" class="form-control datepicker1 input-sm" type="text">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Nama Petugas</label>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" readonly="" class="form-control input-sm" name="" value="{{ Auth::user()->name }}">
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                              <a href="#" data-toggle="modal" data-target="#create" class="btn btn-box-tool" style="margin-bottom: 15px;"><i class="fa fa-plus"></i>&nbsp;Tambah Hasil Produksi</a>
                        </div>
                        <!-- Modal -->
                      <div class="modal fade" id="create" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #e77c38;">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" style="color: white;">Tambah Hasil Produksi</h4>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table tabelan table-hover ">
                                      <tbody>
                                        <tr>
                                          <td>
                                            Tanggal SPK<font color="red">*</font>
                                          </td>
                                          <td>
                                            <input type="text" class="form-control datepicker2" id="TanggalProduksi" onchange="SetTanggalProduksi()" name="Tanggal_Produksi">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Nomor SPK<font color="red">*</font></td>
                                          <td id="ubahselect">
                                            <select class="form-control input-sm" id="cari_spk" name="cariSpk" style="width: 100%;">
                                              <option>- Pilih Nomor SPK</option>
                                            </select>
                                          </td>                                         
                                        </tr>
                                        <tr>
                                          <td>Nama Item</td>
                                          <td>
                                            <input type="text" name="" type="text" class="form-control" id="NamaItem" value="" readonly>
                                            <input type="hidden" name="" class="form-control" id="id_item" value="" readonly>
                                            <input type="hidden" name=""  class="form-control" id="spk_id" value="" readonly>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Jumlah SPK</td>
                                          <td>
                                            <input type="text" name="" type="text" class="form-control" id="JumlahItemSpk" value="" readonly>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Jumlah Produksi</td>
                                          <td>
                                            <input type="text" name="" type="text" class="form-control" id="JumlahItemHasilSpk" value="" readonly>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Tanggal Produksi</td>
                                          <td>
                                            <input type="text" class="form-control" id="TanggalHasilProduksi" name="" value="{{ date('d-m-Y') }}" readonly>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Jam Produksi<font color="red">*</font></td>
                                          <td>
                                            <input type="text" class="form-control timepicker" id="time" name="">
                                          </td>
                                        </tr> 
                                        <tr>
                                          <td>Jumlah Item<font color="red">*</font></td>
                                          <td>
                                            <input type="number" class="form-control" id="JumlahItem" name="" style="text-align: right;" onkeyup="maxQty()">
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary PostingHasil" type="submit" onclick="simpanHasilProduct()" >Posting</button> 
                              </div>
                            </div>
                        </div>
                      </div>
                        <div class="table-responsive">
                          <table class="table tabelan table-bordered table-striped" id="oProduct">
                            <thead>
                             <tr>
                                <th>Nomor SPK</th>
                                <th>Tanggal Spk</th>
                                <th>Nama Item</th>
                                <th>Tanggal Jadi</th>
                                <th>Waktu Jadi</th>
                                <th>Jumlah</th>
                            </tr>
                            </thead>
                            <tbody> 
                            </tbody>
                          </table>
                        </div> 
                  </form>
              </div>                                       
            </div>
          </div> 

        
       <!-- div note-hasil-produksi -->
        <div id="note-hasil-produksi" class="tab-pane fade">
          <div class="row">
            <div class="panel-body">

                <div class="col-md-2 col-sm-3 col-xs-12">
                  <label class="tebal">Tanggal Belanja</label>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <div class="input-daterange input-group">
                      <input id="tanggal3" class="form-control input-sm datepicker1" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                      <span class="input-group-addon">-</span>
                      <input id="tanggal4" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                    </div>
                  </div>
                </div>
              

                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                  <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggalJual()">
                    <strong>
                      <i class="fa fa-search" aria-hidden="true"></i>
                    </strong>
                  </button>
                  <button class="btn btn-info btn-sm btn-flat" type="button">
                    <strong>
                      <i class="fa fa-undo" aria-hidden="true"></i>
                    </strong>
                  </button>
                </div>
                <div class="table-responsive">
                  <table class="table tabelan table-bordered table-striped" id="tabelHasilProduksi" width="100%">
                    <thead>
                      <tr>
                        <th>Tanggal Produksi</th>
                        <th>Nomor SPK</th>
                        <th>Nama Item</th>
                        <th>Belum Terkirim</th>
                        <th>Sudah Terkirim</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div> 
            </div>
          </div>
        </div>
        <!--end div note-hasil-produksi -->    
        <!--Modal Detail Belum Terkirim --> 
              <div class="modal fade" id="modalDetailProduksi" role="dialog">
                <div class="modal-dialog modal-lg" style="width: 90%;margin-left: auto;margin-top: 30px;" >
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #e77c38;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"  style="color: white;">Nama Item</h4>
                      
                    </div>
                    <div class="modal-body">
                      <div id="detailProduksi">
                        
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div> 
          <!--Modal Detail Belum Terkirim -->  
        <!--Modal Detail Belum Terkirim --> 
              <div class="modal fade" id="modalDetailProduksiKirim" role="dialog">
                <div class="modal-dialog modal-lg" style="width: 90%;margin-left: auto;margin-top: 30px;" >
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #e77c38;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"  style="color: white;">Nama Itemm</h4>
                      
                    </div>
                    <div class="modal-body">
                      <div id="detailProduksiKirim">
                        
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div> 
            <!--Modal tambah rencana-->
                        
            @include('produksi.o_produksi.modal')
              <!--End Modal-->
          <!--Modal Detail Belum Terkirim -->   
        </div>
      </div>
    </div>
                            
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<script type="text/javascript"> 

$(document).ready(function() {
var extensions = {
     "sFilterInput": "form-control input-sm",
    "sLengthSelect": "form-control input-sm"
}
// Used when bJQueryUI is false
$.extend($.fn.dataTableExt.oStdClasses, extensions);
// Used when bJQueryUI is true
$.extend($.fn.dataTableExt.oJUIClasses, extensions);

$('#oProduct').dataTable({
  "responsive":true,
  "pageLength": 10,
  "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
  "language": {
      "searchPlaceholder": "Cari Data",
      "emptyTable": "Tidak ada data",
      "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
      "infoFiltered" : "",
      "sSearch": '<i class="fa fa-search"></i>',
      "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
      "infoEmpty": "",
      "zeroRecords": "Data tidak ditemukan",
      "paginate": {
              "previous": "Sebelumnya",
              "next": "Selanjutnya",
          }
    },
  "ajax":{
          "url" : baseUrl + "/produksi/o_produksi/tabel",
          "type": "GET"
    },
  "columns": [
        { "data": "spk_code" },
        { "data": "pr_date" },
        { "data": "i_name" },
        { "data": "prdt_date" },
        { "data": "prdt_time" ,"className" : "dt-body-right" },
        { "data": "prdt_qty" ,"className" : "dt-body-right" },]
});

var timepicker = new TimePicker('time', {
  lang: 'en',
  theme: 'dark'
});
timepicker.on('change', function(evt) {
  
  var value = (evt.hour || '00') + ':' + (evt.minute || '00');
  evt.element.value = value;

});


});

  var tableSpk = $('#tabelHasilProduksi').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/produksi/o_produksi/lihat/tabelhasil",
    },
    columns: [
    {data: 'pr_date', name: 'pr_date'},
    {data: 'spk_code', name: 'spk_code'},
    {data: 'i_name', name: 'i_name', orderable: false},
    {data: 'action_belum', name: 'action_belum', orderable: false},
    {data: 'action_sudah', name: 'action_sudah', orderable: false, searchable: false},
    ],
    "responsive":true,

                  "pageLength": 10,
                "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
                "language": {
                    "searchPlaceholder": "Cari Data",
                    "emptyTable": "Tidak ada data",
                    "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                    "sSearch": '<i class="fa fa-search"></i>',
                    "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                    "infoEmpty": "",
                    "paginate": {
                            "previous": "Sebelumnya",
                            "next": "Selanjutnya",
                         }
                  }
  });

var date = new Date();
var newdate = new Date(date);

newdate.setDate(newdate.getDate()-3);
var nd = new Date(newdate);

  $('.datepicker').datepicker({
    format: "mm",
    viewMode: "months",
    minViewMode: "months"
  });
  $('.datepicker1').datepicker({
    autoclose: true,
    format:"dd-mm-yyyy",
    endDate: 'today'
  }).datepicker("setDate", nd);
  $('.datepicker2').datepicker({
    autoclose: true,
    format:"dd-mm-yyyy",
    endDate: 'today'
  });//.datepicker("setDate", "0"); 

function SetTanggalProduksi(){
  var tgl1 = $('#TanggalProduksi').val();
  $.ajax({
    url: baseUrl + '/produksi/o_produksi/select2/spk/'+tgl1,    
    type: 'get',
    success:function(response){ 
      $("#ubahselect").html(response);
      $( "#cari_spk" ).select2();
      }
    })
  }

function setResultSpk(){
  var x = document.getElementById("cari_spk").value;
  $.ajax({
    url: baseUrl + '/produksi/o_produksi/select2/pilihspk/'+x,    
    type: 'get',
    success:function(response){ 
      $('#NamaItem').val(response[0].i_name);
      $('#JumlahItemSpk').val(response[0].pp_qty);
      $('#JumlahItemHasilSpk').val(response[0].prdt_qty);
      $('#spk_id').val(response[0].spk_id);
      $('#id_item').val(response[0].i_id);
      }
    })
}

function maxQty(){
  var qty_plan = parseInt($("#JumlahItemSpk").val());
  var qty_result = parseInt($("#JumlahItemHasilSpk").val());
  var JumlahItem = parseInt($("#JumlahItem").val());
  var total = qty_plan - qty_result;

  if (qty_plan < JumlahItem) {
    $("#JumlahItem").val(''); 
    toastr.warning('Jumlah Pembuatan tidak boleh melebihi rencana'); 
  }else if (JumlahItem > total) {
    $("#JumlahItem").val(''); 
    toastr.warning('Jumlah Pembuatan tidak boleh melebihi rencana'); 
  }
}

function simpanHasilProduct(){
  $('.PostingHasil').attr('disabled','disabled');
  var tgl = $('#TanggalHasilProduksi').val(),
    spk_id = $('#spk_id').val(),
    time = $('#time').val(),
    spk_item = $("#id_item").val(),
    spk_qty = $("#JumlahItem").val();
  if (tgl == '') {
  Command: toastr["warning"]("Kolom Tanggal tidak boleh kosong ", "Peringatan !")
      $('.PostingHasil').removeAttr('disabled','disabled');
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  return false;
  }
  if (time == '') {
  Command: toastr["warning"]("Kolom Jam tidak boleh kosong ", "Peringatan !")
      $('.PostingHasil').removeAttr('disabled','disabled');
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  return false;
  }
  if (spk_id == '') {
  Command: toastr["warning"]("Kolom SPK tidak boleh kosong ", "Peringatan !")
      $('.PostingHasil').removeAttr('disabled','disabled');
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  return false;
  }
  if (spk_qty == '' || spk_qty <= 0 ) {
  Command: toastr["warning"]("Kolom Jumlah Item tidak boleh kosong ", "Peringatan !")
      $('.PostingHasil').removeAttr('disabled','disabled');
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  return false;
  }

  $.ajax({
  url : baseUrl + "/produksi/o_produksi/store",
  type: 'get',
  data: {
    tgl: tgl,
    spk_id: spk_id,
    spk_item: spk_item,
    spk_qty: spk_qty,
    time : time
  },
  success:function(response){
    if (response.status=='sukses') {
      $("#JumlahItem").val('');
      $("#NamaItem").val('');
      $("#mySelect").val('');
      $("#time").val('');
      $("#spk_ref").val('');
      $("#JumlahItemSpk").val('');
      $("#TanggalProduksi").val('');
      $("#oProduct").DataTable().ajax.reload( null, false );
       tableSpk.ajax.reload();
      alert('Data Tersimpan');
      $('.PostingHasil').removeAttr('disabled','disabled');
      $("input[name='Tanggal_Produksi']").focus();
    }else{
      alert('Data Tidak Tersimpan');
      $('.PostingHasil').removeAttr('disabled','disabled');
    }
    }
  })
}

function lihatDetail(idDetail){
   $.ajax({
    url : baseUrl + "/produksi/o_produksi/getdata/tabel",
    type: 'get',
    data: {x:idDetail},
    success:function(response){
      $('#detailProduksi').html(response);
    }
   });  
  }

function lihatDetailKirim(idDetail){
   $.ajax({
    url : baseUrl + "/produksi/o_produksi/getdata/tabel/kirim",
    type: 'get',
    data: {y:idDetail},
    success:function(response){
      $('#detailProduksiKirim').html(response);
    }
   });  
  }
  
function edit(id1,id2){
  $.ajax({
    type: "get",
    url : baseUrl + "/produksi/o_produksi/edit/"+id1+'/'+id2,
    success: function(response){
      $('#prdt_productresult').val(response.prdt_productresult);
      $('#prdt_detail').val(response.prdt_detail);
      $('#i_name').val(response.i_name);
      $('#prdt_qty').val(response.prdt_qty);
    }
  });
}

  function simpanProduksiQty(){
    if(!confirm("Apakah Anda yakin ingin merubah jumlah hasil produksi?")) return false;
    $('.btn-simpan').attr('disabled','disabled');
    var myForm = $('#myForm :input').serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
      type: "get",
      url : baseUrl + "/produksi/o_produksi/save",
      data: myForm,
      success: function(response){
        if (response.status == 'sukses') {
          oTable.ajax.reload();
          alert('Jumlah Barang Telah di Rubah');
        }else{
          alert('Barang Belum Bisa di Kirim');
          $('.btn-simpan').removeAttr('disabled','disabled');
        }
        
      }

    });
  }
</script>
@endsection()                           
