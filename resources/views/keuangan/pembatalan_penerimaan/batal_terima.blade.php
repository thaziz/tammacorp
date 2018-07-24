@extends('main') 
@section('content')
  <!--BEGIN PAGE WRAPPER-->
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Penerimaan Barang Hasil Produksi</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Penerimaan Barang Hasil Produksi</li>
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
              <li class="active">
                <a href="#finishResult-tab" data-toggle="tab" class="fResult">Daftar Hasil Penerimaan</a>
              </li>
            </ul>

            <div id="generalTabContent" class="tab-content responsive">

                  <!-- div finishResult-tab -->
                  <div id="finishResult-tab" class="tab-pane fade in active">
                    <div class="row">
                      <div class="panel-body">

                          <div class="col-md-2 col-sm-3 col-xs-12">
                            <label class="tebal">Tanggal Penerimaan</label>
                          </div>

                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <div class="input-daterange input-group">
                                <input id="tanggal1" class="form-control input-sm datepicker1 " name="tanggal" type="text" {{-- value="{{ date('d-m-Y') }}" --}}>
                                <span class="input-group-addon">-</span>
                                <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                            <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggal()">
                              <strong>
                                <i class="fa fa-search" aria-hidden="true"></i>
                              </strong>
                            </button>
                            <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabel()">
                              <strong>
                                <i class="fa fa-undo" aria-hidden="true"></i>
                              </strong>
                            </button>
                          </div>

                        <div class="table-responsive" style="padding-top: 15px;">
                          <div id="tabelPenerimaanFinal"> 
                            @include('keuangan.pembatalan_penerimaan.tabel_penerimaan_final')
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End DIv note-tab -->                     
              
            </div>

          </div>
        </div>                                       
      </div>
    </div>
  
  </div>
  <!--END PAGE WRAPPER-->

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
var save_method;
  $(document).ready(function() { 
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    console.log('tsr');
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    var date = new Date();
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate()-3);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
      }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
      });//datepicker("setDate", "0"); 

    $('.datepicker1').on('changeDate', function(ev){
      $(this).datepicker('hide');
    });

    $('.datepicker2').on('changeDate', function(ev){
      $(this).datepicker('hide');
    });
  
    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
      return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    // clear field pda modal apabila modal hidden
    $("#modalTerima").on("hidden.bs.modal", function(){
      $('#update-terima-produk')[0].reset();  
    });

    //load datatable
    cariTanggal();

    $('.fResult').click(function(event) {
      // event.preventDefault();
      cariTanggal();
    });

    $('#data3').DataTable();
    
});

function ubahStatus(id, id2)
{
  if(confirm('Anda yakin ubah status transaksi ?'))
  {
    $.ajax({
        url : baseUrl + "/keuangan/p_hasilproduksi/ubah_status_transaksi/"+id+"/"+id2,
        type: "get",
        dataType: "JSON",
        success: function(response)
        {
            if(response.status == "sukses")
            {
              alert(response.pesan);
              //call function
              refreshTabel();
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error updating data');
        }
    });
  }
}

function cariTanggal()
{
  var tgl1 = $('#tanggal1').val();
  var tgl2 = $('#tanggal2').val();
  var akses = "finance";
  $('#data3').DataTable({
    "destroy": true,
    "processing" : true,
    "serverside" : true,
    "ajax" : {
      url : baseUrl + "/inventory/p_hasilproduksi/get_penerimaan_by_tgl/"+tgl1+'/'+tgl2+'/'+akses,
      type: 'GET'
    },
    "columns" : [
      {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
      {"data" : "do_nota", "width" : "15%"},
      {"data" : "i_name", "width" : "25%"},
      {"data" : "dod_qty_send", "width" : "5%"},
      {"data" : "dod_qty_received", "width" : "5%"},
      {"data" : "tanggalTerima", "width" : "10%"},
      {"data" : "jamTerima", "width" : "10%"},
      {"data" : "status", "width" : "15%"},
      {"data" : "action", orderable: false, searchable: false, "width" : "10%"}
    ],
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
}

function refreshTabel() {
  $('#data3').DataTable().ajax.reload();
}
  
</script>
@endsection
