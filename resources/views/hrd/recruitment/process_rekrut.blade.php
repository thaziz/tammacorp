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
                                <label class="bold s16">Data Pelamar</label>
                              </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nama Pelamar</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="Alpha">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>No. HP</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="085331219757">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Jabatan yang dilamar</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="Public Exposer">
                              </div>
                            </div>
                         
                        </div>
                      </div>   


                        <div class="row">
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <fieldset style="padding-top: 15px;">

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label class="s16 bold underline">Approval 1</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="ditolak_1" id="ditolak_1"> Ditolak Administratif (tdk bisa diprocess lagi)</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="tahap_1" id="tahap_1"> Tahap 1(Pending)</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label class="modal_checkbox"><input type="checkbox" class="input_checkbox" name="test_interview" id="test_interview"> Test Interview</label>
                                </div>
                              </div>
                            </fieldset>                           
                          </div>
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <fieldset style="padding-top: 15px;">

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label class="s16 bold underline">Approval 2</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="tidak_lolos_2" id="tidak_lolos_2"> Tidak Lolos Interview (tdk bisa diprocess)</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="tahap_2" id="tahap_2"> Tahap II(Pending)</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label class="modal_checkbox"><input type="checkbox" class="input_checkbox" name="lolos_interview" id="lolos_interview"> Lolos Interview</label>
                                </div>
                              </div>
                            </fieldset>                           
                          </div>
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <fieldset style="padding-top: 15px;">

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label class="s16 bold underline">Approval 3</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="ditolak_3" id="ditolak_3"> Ditolak Final (tdk bisa diprocess)</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label class="modal_checkbox"><input type="checkbox" class="input_checkbox" name="diterima" id="diterima"> Diterima Sebagai Karyawan</label>
                                </div>
                              </div>
                            </fieldset>                           
                          </div>
                        </div>  

                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
                            <button class="btn btn-primary">Process</button>
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

      $('.modal_checkbox').click(function(){

        $this = $(this);

        $attr =  $this.find('input').attr('id');

        $checked = $this.find('div').hasClass('checked');

        if ($checked === false) {
          
          $('#'+$attr).modal('show');
        }


      });

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