@extends('main')
@section('extra_styles')
<style type="text/css">
  
  .bold{
    font-weight: bold;
  }
  .underline{
    text-decoration: underline;
  }
  .italic{
    font-style: italic;
  }
  .s16{
    font-size: 16px;
  }

  fieldset{
    border: 1px solid black;
  }
  .divided{
    border-bottom: 1px solid black;
  }
  .text-lightgreen{
    color: lightgreen;
  }
</style>
@endsection
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Recruitment</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Recruitment</li>
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
                    <li class="active"><a href="#alert-tab" data-toggle="tab">Recruitment</a></li>
                    <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                    <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                  </ul>
                  <div id="generalTabContent" class="tab-content responsive">
                    
                    @include('hrd.recruitment.test_interview')
                    @include('hrd.recruitment.lolos_interview')
                    @include('hrd.recruitment.diterima')

                    <div id="alert-tab" class="tab-pane fade in active">
                      
                      <div class="row tamma-bg" style="margin-top: -23px;padding-top: 23px;padding-bottom: 10px;border-radius: unset;margin-bottom: 15px;">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                          

                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <label class="bold s16 underline">Data Pelamar</label>
                              </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nama</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nomor Identitas</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Alamat</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Alamat Sekarang</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Tempat Lahir</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>
                         
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Tanggal Lahir</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Pendidikan</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nomor Telpon/WA</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Agama</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Status</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nama Suami/Istri</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Anak</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">

                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <label class="bold s16 underline">Daftar Riwayat Hidup</label>
                              </div>
                            </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Nama Perusahaan</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Awal</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Akhir</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Job Desc</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>

                          <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group divided">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Nama Perusahaan</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Awal</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Akhir</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Job Desc</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>
                        </div>
                      </div>   

                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label class="bold s16 underline">Kelengkapan Berkas</label>
                            </div>
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <label>CV</label>
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12" align="center">
                            <iframe src='https://docs.google.com/viewer?url=ENTER URL OF YOUR DOCUMENT HERE&embedded=true' frameborder='0'></iframe>
                          </div>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <label>Ijazah</label>
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12" align="center">
                            <iframe src='https://docs.google.com/viewer?url=ENTER URL OF YOUR DOCUMENT HERE&embedded=true' frameborder='0'></iframe>
                          </div>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <label>Sertifikat</label>
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-0 col-xs-0" style="height: 50px;">
                            
                          </div>
                          
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <label>Lain-lain</label>
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="">
                            </div>
                          </div>
                        </div>
                      </div>

                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
                            <a href="{{route('rekrut')}}" class="btn btn-default">Back</a>
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
                    </div>
                    <!--/div note-tab -->

                    <!-- div label-badge-tab -->
                    <div id="label-badge-tab" class="tab-pane fade">
                      <div class="row">
                        <div class="panel-body">
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



      $('.datepicker').datepicker({
        format:"dd-mm-yyyy"
      });
      $('.datepicker2').datepicker({
        format:"dd M yyyy"
      }); 
      $('.datepicker3').datepicker({
        timeFormat:  "hh:mm:ss"
      });       
      </script>
@endsection()