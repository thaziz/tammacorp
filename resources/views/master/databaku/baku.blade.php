@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Master Data Bahan Baku</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Master Data Bahan Baku</li>
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
                                <li class="active"><a href="#alert-tab" data-toggle="tab">Master Data Bahan Baku</a></li>
                                <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                                <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                
                                <div id="alert-tab" class="tab-pane fade in active">
                                 
                                  <div class="row" style="margin-top:-15px;">
                                   

                                  <div align="right" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">
    
                                    <a href="{{ url('master/databaku/tambah_baku') }}">
                                    <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                                     <i class="fa fa-plus" aria-hidden="true">
                                         &nbsp;
                                     </i>Tambah Data
                                    </button></a>
    
                                  </div>
                           
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                            <thead>
                                <tr>
                                  <th class="wd-15p" width="5%">Kode Barang</th>
                                  <th class="wd-15p">Nama Barang</th>
                                  <th class="wd-15p">Kelompok Barang</th>
                                  <th class="wd-15p">Harga Barang</th>
                                  <th class="wd-15p" width="10%">Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                            
                               
                              </tbody>
                          
                            </table> 
                          </div>                                       
                        </div>
                  </div>
                                  
                  </div><!-- /div alert-tab -->
                 <!-- div note-tab -->
                  <div id="note-tab" class="tab-pane fade">
                    <div class="row">
                      <div class="panel-body">
                        <!-- Isi Content -->we we we
                      </div>
                    </div>
                  </div><!--/div note-tab -->
                  <!-- div label-badge-tab -->
                  <div id="label-badge-tab" class="tab-pane fade">
                    <div class="row">
                      <div class="panel-body">
                        <!-- Isi content -->we
                      </div>
                    </div>
                  </div><!-- /div label-badge-tab -->
                            </div>
                    
            </div>
          </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
     var extensions = {
           "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);
      
    $('#data').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_baku') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'd_id center'
                  }, 
                  {
                     targets: 2 ,
                     className: 'right format_money'
                  },
                ],
            "columns": [
            { "data": "i_code" },
            { "data": "i_name" },
            { "data": "i_sat_isi1" },
            { "data": "i_sat1" },
            { "data": "aksi" },
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

        function hapus(a) {
          var parent = $(a).parents('tr');
          var id = $(parent).find('.d_id').text();
          console.log(id);
          $.ajax({
               type: "get",
               url: '{{ route('hapus_baku') }}',
               data: {id},
               success: function(data){
                  if (data.status == 1) {
                      location.reload();
                  }
                  
               },
               error: function(){
                iziToast.warning({
                  icon: 'fa fa-times',
                  message: 'Terjadi Kesalahan!',
                });
               },
               async: false
             });  
        }


         function edit(a) {
          var parent = $(a).parents('tr');
          var id = $(parent).find('.d_id').text();
          console.log(id);
          $.ajax({
               type: "get",
               url: '{{ route('edit_baku') }}',
               data: {id},
               success: function(data){
               },
               complete:function (argument) {
                window.location=(this.url)
               },
               error: function(){
               
               },
               async: false
             });  
        }

      </script>
@endsection()