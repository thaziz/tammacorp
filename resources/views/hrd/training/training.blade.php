@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Training Pegawai</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Training Pegawai</li>
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
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Training Pegawai</a></li>
                      <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                      <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                      
                      <div id="alert-tab" class="tab-pane fade in active">
                       
                        <div class="row" align="right">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="{{route('form_training')}}" class="btn btn-box-tool"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                          </div>
                        </div>
            
                        <div class="table-responsive">
                          <table class="table tabelan table-hover table-bordered data-table" width="100%" cellspacing="0" id="t29">
                            <thead>
                                <tr>
                                  <th width="1%">No</th>
                                  <th>Nama Pegawai</th>
                                  <th>Jabatan/Posisi</th>
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Charlie</td>
                                  <td>Admin</td>
                                  <td align="center">
                                    <div class="btn-group">
                                      <button class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></button>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>Delta</td>
                                  <td>Public Exposer</td>
                                  <td align="center">
                                    <div class="btn-group">
                                      <button class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></button>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                          
                          </table> 
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
          </div>
      </div>
</div>


@endsection
@section("extra_scripts")
    <script type="text/javascript">
 
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd/mm/yyyy"
      });    
      </script>
@endsection()