@extends('main')
@section('content')
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Manajemen Return Penjualan</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Manajemen Return Penjualan</li>
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
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Manajemen Return Penjualan</a></li>
                </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                      <div id="alert-tab" class="tab-pane fade in active">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div align="right" style="margin-bottom: 10px;">
                              <a href="{{ url('/penjualan/returnpenjualan/tambahreturn') }}">
                                <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                                  <i class="fa fa-plus" aria-hidden="true">&nbsp;</i>
                                  Tambah Data
                                </button>
                              </a>
                            </div>
                            <div class="table-responsive">
                              <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel-sales-return">
                                <thead>
                                  <tr>
                                    <th class="wd-5p">No.</th>
                                    <th class="wd-10p">Tgl Return</th>
                                    <th class="wd-15p">ID Return</th>
                                    <th class="wd-10p">Staff</th>
                                    <th class="wd-10p">Metode</th>
                                    <th class="wd-15p">Supplier</th>
                                    <th class="wd-15p">Total Retur</th>
                                    <th class="wd-15p">Status</th>
                                    <th class="wd-15p">Aksi</th>
                                  </tr>
                                </thead>

                                <tbody>                 
                                </tbody>
                              </table> 
                            </div>   
                          </div> 
                        </div>    
                      </div>
                    <!-- /div alert-tab -->

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

      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd/mm/yyyy"
      });

  });

  var dataHarga =  $('#tabel-sales-return').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/penjualan/returnpenjualan/tabel",
    },
    columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index'},
      {data: 'i_code', name: 'i_code'},
      {data: 'i_type', name: 'i_type'},
      {data: 'm_gname', name: 'm_gname'},
      {data: 'i_name', name: 'i_name'},
      {data: 'm_psell1', name: 'm_psell1'},
      {data: 'm_psell2', name: 'm_psell2'},
      {data: 'm_psell3', name: 'm_psell3'},
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    language: {
      searchPlaceholder: "Cari Data",
      emptyTable: "Tidak ada data",
      sInfo: "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
      sSearch: '<i class="fa fa-search"></i>',
      sLengthMenu: "Menampilkan &nbsp; _MENU_ &nbsp; Data",
      infoEmpty: "",
      paginate: {
            previous: "Sebelumnya",
            next: "Selanjutnya",
         }
    }
  });
    
  </script>
@endsection()