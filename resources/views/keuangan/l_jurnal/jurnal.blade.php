@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Laporan Keuangan</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Laporan Keuangan</li>
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
                                <li class="active"><a href="#alert-tab" data-toggle="tab">Laporan Keuangan</a></li>
                                <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                                <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;border-bottom: 1px solid gray;padding-bottom: 10px;">
                                      
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label class="tebal">Laporan Keuangan</label>
                                          </div>
                                          <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                                              <span id="text">Pilih</span> <span class="caret"></span></button>
                                              <ul class="dropdown-menu" role="menu">
                                                <li class="m1a2"><a class="t90" onclick="rmvClass(this)" data-toggle="tab" href="#laba-rugi">Laba Rugi</a></li>
                                                <li class="m1a2"><a class="t90" onclick="rmvClass(this)" data-toggle="tab" href="#label-badge-tab">Neraca</a></li>
                                                <li class="m1a2"><a class="t90" onclick="rmvClass(this)" data-toggle="tab" href="#arus-kas">Arus Kas</a></li>
                                                <li class="m1a2"><a class="t90" onclick="rmvClass(this)" data-toggle="tab" href="#alert-tab">Jurnal</a></li>
                                                <li class="m1a2"><a class="t90" onclick="rmvClass(this)" data-toggle="tab" href="#note-tab">Buku Besar</a></li>

                                              </ul>
                                            </div>
                                            
                                          </div>
                                        </div>
                                      </div>

                                </div>


                                <div id="alert-tab" class="tab-pane fade">
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        jurnal
                                    </div>
                                                                    
                                  </div>
                                    
                                </div>
                                <!-- /div alert-tab -->

                                <!-- div note-tab -->
                                <div id="note-tab" class="tab-pane fade">
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                          
                                          buku besar

                                        </div>
                                  </div>
                                </div><!--/div note-tab -->

                                <!-- div label-badge-tab -->
                                @include('keuangan.l_jurnal.neraca')
                                <!-- /div label-badge-tab -->

                                <!-- div arus-kas -->
                                @include('keuangan.l_jurnal.arus')
                                <!-- End div  arus-kas -->

                                <!-- laba-rugi -->
                                @include('keuangan.l_jurnal.laba')
                                <!-- end laba-rugi -->
                              </div>
                    
            </div>
          </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">

      function rmvClass(m1a2)
      {
        var li = $('.m1a2');
        li.removeClass('active');

      var par   = $(m1a2).parents('li');
      var text    = $(par).find('.t90').text();

        $('#text').html(text);

      }
     
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd/mm/yyyy"
      });  
      </script>
@endsection