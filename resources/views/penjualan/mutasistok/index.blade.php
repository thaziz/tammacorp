@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Mutasi Stok & Retail</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Mutasi Stok & Retail</li>
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
                                  <a href="#grosir-retail" data-toggle="tab">Grosir ke Retail</a>
                                </li>
                                <li>
                                  <a href="#produksi-grosir" data-toggle="tab">Produksi ke Grosir</a>
                                </li>
                                <li>
                                  <a href="#penjualan-retail" data-toggle="tab">Penjualan Retail</a>
                                </li>
                                <li>
                                  <a href="#penjualan-grosir" data-toggle="tab">Penjualan Grosir</a>
                                </li>
                                <!-- <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                <!-- modal -->
                                @include('penjualan.mutasistok.tambah_retailgrosir')

                                @include('penjualan.mutasistok.tambah_grosirretail')
                                <!-- end modal -->
                                <!-- grosir-retail -->
                                @include('penjualan.mutasistok.grosir-retail')
                                <!-- end grosir-retail  -->

                                <!-- div Produksi-grosir -->
                                @include('penjualan.mutasistok.Produksi-grosir')
                                <!--/div retail-grosir -->

                                <!-- div Produksi-grosir -->
                                @include('penjualan.mutasistok.Penjualan-retail')
                                <!--/div retail-grosir -->

                                <!-- div label-badge-tab -->
                                <div id="label-badge-tab" class="tab-pane fade">
                                  <div class="row">
                                    <div class="panel-body">
                                      <!-- Isi content -->
                                    </div>
                                  </div>
                                </div>
                                <!-- /div label-badge-tab -->
                            </div>
                    
            </div>
          </div>

        </div>
      </div>
    </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
      $('#tglMutasiGrosir').datepicker({
        format:"dd-mm-yyyy",
        autoclose: true,
      }); 
$("#namaItem").autocomplete({
    source: baseUrl+'/penjualan/mutasistok/data-item',
    minLength: 1,
    select: function(event, ui) {           
    $('#namaItem').val(ui.item.label);        
    $('#rkode').val(ui.item.code);
    $('#rdetailnama').val(ui.item.name);        
    $('#rqty').val(ui.item.qty);
    $("input[name='rqty']").focus();
    }
  });

    $('#GrosirRetail').DataTable({
    processing: true,
    serverSide: true,
      ajax: {
          url : baseUrl + "/penjualan/mutasi/stock/grosir-retail",
      },
      columns: [
      {data: 'sm_date', name: 'sm_date', orderable: false, searchable: false},
      {data: 'i_code', name: 'i_code'},
      {data: 'i_name', name: 'i_name', orderable: false},
      {data: 'sm_qty', name: 'sm_qty', orderable: false},
      {data: 'sm_reff', name: 'sm_reff', orderable: false, searchable: false},
      ],
    });

    $('#PenjualanRetail').DataTable({
    processing: true,
    serverSide: true,
      ajax: {
          url : baseUrl + "/penjualan/mutasi/stock/penjualan-retail",
      },
      columns: [
      {data: 'sm_date', name: 'sm_date', orderable: false, searchable: false},
      {data: 'i_code', name: 'i_code'},
      {data: 'i_name', name: 'i_name', orderable: false},
      {data: 'sm_qty', name: 'sm_qty', orderable: false},
      {data: 'sm_reff', name: 'sm_reff', orderable: false, searchable: false},
      ],
    });




      </script>
@endsection()