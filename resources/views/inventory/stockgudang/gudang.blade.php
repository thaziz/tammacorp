@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Penerimaan Barang Suplier</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Penerimaan Barang Suplier</li>
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
                                  <li class="active"><a href="#alert-tab" data-toggle="tab">Penerimaan Barang Suplier</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">History Penerimaan Barang Suplier</a></li> -->
                            <!-- <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                                </ul>
                                <div id="generalTabContent" class="tab-content responsive">

                                  @include('inventory.p_suplier.modal')

                                    <div id="alert-tab" class="tab-pane fade in active">
                                      <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                           <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                              <label class="tebal">Posisi :</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                              <select class="form-control input-sm" name="cabang" id="cabang">
                                                <option>-- Pilih --</option>
                                                @foreach ($cabanggudang as $a)
                                                  <option value="{{ $a->cg_id }}">{{ $a->cg_id }} - {{ $a->cg_cabang }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                              <label class="tebal">Item :</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                              <select class="form-control input-sm" id="item" name="item">
                                                <option>-- Pilih --</option>
                                                @foreach ($item as $b)
                                                  <option value="{{ $b->i_id }}">{{ $b->i_id }} - {{ $b->i_name }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                              <label class="tebal"></label>
                                          </div>
{{-- 
                                          <div class="col-md-3 col-sm-12 col-xs-12">
                                              <label class="tebal">Posisi gudang:</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                              <select class="form-control input-sm" name="gudang" id="gudang">
                                                <option>-- Pilih --</option>
                                                @foreach ($cabanggudang as $c)
                                                  <option value="{{ $c->cg_id }}">{{ $c->cg_id }} - {{ $c->cg_gudang }}</option>
                                                @endforeach
                                              </select>
                                            </div> --}}

                                          </div>
                                          <div class="col-md-3 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary btn-sm" onclick="cari()"><i class="fa fa-search"></i> Search</button>
                                          </div>
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                              <label class="tebal"></label>
                                          </div>
                                          <div id="replace">
                                          <div class="table-responsive">
                                            <table class="table tabelan table-hover table-bordered" id="data">
                                              <thead>
                                                <tr>
                                                  {{-- <th>No</th> --}}
                                                  <th>Posisi cabang</th>
                                                  <th>Posisi gudang</th>
                                                  <th>Item</th>
                                                  <th>Qty</th>
                                                  <th>Detil</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                     <!-- End div #alert-tab  -->

                                    <!-- div note-tab -->
                                
                                    <!--/div note-tab -->

                                    <!-- div label-badge-tab -->
                                    <div id="label-badge-tab" class="tab-pane fade">
                                      <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                          <!-- Isi content -->we
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
     $('#data').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_gudang') }}',
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
            { "data": "cg_gudang" },
            { "data": "cg_cabang" },
            { "data": "i_name" },
            { "data": "s_qty" },
            { "data": "aksi" },
            ]
      });
     $('#data-cari').DataTable();
     function cari() {
        var cabang = $('#cabang').val();
        var gudang = $('#gudang').val();
        var item = $('#item').val();
          $.ajax({
               type: "get",
               url: '{{ route('cari_gudang') }}',
               data: {cabang,gudang,item},
               success: function(data){
                      $('#replace').html(data);                  
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
    </script>
@endsection