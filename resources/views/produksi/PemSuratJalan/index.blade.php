@extends('main') 
@section('content')
  <!--BEGIN PAGE WRAPPER-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
  .btn span.glyphicon {         
    opacity: 0;       
  }
  .btn.active span.glyphicon {        
    opacity: 1;       
  }
</style>
  <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Pembuatan Pengambilan Item</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Rencana Produksi</li>
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
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Item Siap Kirim</a></li>
                      <li><a href="#alert-tab-itemkirim" data-toggle="tab">Item Terkirim</a></li>
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                          
                      <div id="alert-tab" class="tab-pane fade in active">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">   

                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                          <form id="formDelivery1">
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label class="tebal">Tanggal Pengiriman</label>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <input type="text" name="TanggalKirim" readonly="" class="form-control input-sm" name="" value="{{ date('d-m-Y') }}">
                              </div>
                            </div>  

                            <div class="col-md-3 col-sm-12 col-xs-12">  
                              <label class="tebal">Nama Pengirim</label>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <input value="" name="NamaPengirim" readonly="" class="form-control input-sm" type="text">
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label class="tebal">Tujuan Gudang<font color="red">*</font></label>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <input type="text" name="TujuanGudang" class="form-control input-sm" name="" value="">
                              </div>
                            </div>
                          </form> 
                        </div>

                          <div class="table-responsive">
                            <table class="table tabelan table-hover table-bordered" width="100%" id="tableSuratJalan">
                              <thead>
                                <tr>
                                  <th width="5%">No</th>
                                  <th>Kode Item</th>
                                  <th>Nama Item</th>
                                  <th>Jumlah Item</th>
                                  <th width="5%">Checklist</th>
                                </tr>
                              </thead>
                              <tbody>
                                 
                              </tbody>
                            </table> 
                          </div> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <button style="margin-top: 20px; margin-right:10px; " class="btn btn-warning pull-right" 
                            data-toggle="modal" data-target="#prosesProgres" type="button" onclick="saveDelevery()">Cetak
                            <i class="fa fa-print"></i>
                          </button>
                        </div> 
                        </div>
                      </div>
                    </div>

                   <!-- div alert-tab-itemkirim -->
                    <div id="alert-tab-itemkirim" class="tab-pane fade">
                      <div class="row">
                        <div class="panel-body">

                            <div class="col-md-2 col-sm-3 col-xs-12">
                              <label class="tebal">Tanggal Pengiriman</label>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <div class="input-daterange input-group">
                                  <input id="tanggal1" class="form-control input-sm datepicker1" name="tanggal" type="text">
                                  <span class="input-group-addon">-</span>
                                  <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
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
                              <table class="table tabelan table-bordered table-striped" id="tabelPengirimanDo" width="100%">
                                <thead>
                                  <tr>
                                    <th>Tanggal Pengiriman</th>
                                    <th>Nota DO</th>
                                    <th>Waktu Pengiriman</th>
                                    <th>Waktu Penerimaan</th>
                                    <th>Detail</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div> 
                        </div>
                      </div>
                    </div>
                    <!--end div alert-tab-itemkirim -->  
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
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
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

  var tableSuratJalan = $('#tableSuratJalan').DataTable({
    processing: true,
    serverSide: true,
      ajax: {
          url : baseUrl + "/produksi/suratjalan/create/delivery",
      },
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
      {data: 'i_code', name: 'i_code'},
      {data: 'i_name', name: 'i_name', orderable: false},
      {data: 'prdt_qty', name: 'prdt_qty', orderable: false},
      {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
    });

  function saveDelevery(){
    var formDelivery1 = $('#formDelivery1 :input').serialize();
    var ar = $();
        for (var i = 0; i < tableSuratJalan.rows()[0].length; i++) { 
            ar = ar.add(tableSuratJalan.row(i).node());
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var kirim = ar.find('input').serialize();

    $.ajax({
      url : baseUrl + "/produksi/suratjalan/save",
      type: 'get',
      data: formDelivery1+'&'+kirim,
      success:function(response){
        if (response.status == 'sukses') {
          alert('sukses');
          tableSuratJalan.ajax.reload( null, false );
        }else{
          alert('gagal');
        }
      }
    })
  }

  var tgl1 = $('#tanggal1').val();
  var tgl2 = $('#tanggal2').val();
  var tabelPengirimanDo = $('#tabelPengirimanDo').DataTable({
    responsive:true,
    destroy: true,
    processing: true,
    serverSide: true,
      ajax: {
          url : baseUrl + "/produksi/pengambilanitem/kirim/tabel/"+tgl1+'/'+tgl2,
      },
      columns: [
      {data: 'do_date_send', name: 'do_date_send'},
      {data: 'do_nota', name: 'do_nota'},
      {data: 'do_time', name: 'do_time', orderable: false},
      {data: 'do_date_received', name: 'do_date_received', orderable: false},
      {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
    });

  function cariTanggalJual(){
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tabelPengirimanDo').DataTable({
    responsive:true,
    destroy: true,
    processing: true,
    serverSide: true,
      ajax: {
          url : baseUrl + "/produksi/pengambilanitem/cari/tabel/"+tgl1+'/'+tgl2,
      },
      columns: [
      {data: 'do_date_send', name: 'do_date_send'},
      {data: 'do_nota', name: 'do_nota'},
      {data: 'do_time', name: 'do_time', orderable: false},
      {data: 'do_date_received', name: 'do_date_received', orderable: false},
      {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
    });
  }
  
  function lihatItem(id){
    $.ajax({
      url : baseUrl + "/produksi/pengambilanitem/lihat/id",
      type: 'get',
      data: {x:id},
      success:function(response){
        $('#detailProduksi').html(response);
      }
    })
  }

</script>
@endsection()
