@extends('main')
@section('extra_styles')
<style type="text/css">

  @media (min-width: 992px){
    .cari-filter{
      height: 125px;
      padding-left: 50px;
    }
    .cari-filter button{
      margin-top: 86px;
    }
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
      
                  <?php 
                    $person = ['Alpha', 'Bravo', 'Charlie', 'Delta', 'Echo', 'Foxtrot', 'Golf', 'Hotel', 'India', 'Juliet', 'Kilo', 'Mike', 'November', 'Oscar', 'Papa', 'Quebec', 'Romeo', 'Sierra', 'Tango', 'Uniform', 'Victor', 'Whiskey', 'X-ray', 'Zulu'];
                    $tanggal  = ['01-11-2018', '02-11-2018', '03-11-2018', '04-11-2018', '05-11-2018', '06-11-2018'];
                    $lulusan = ['Bayi', 'TK', 'SD', 'SMP', 'SMA', 'SMK', 'S1', 'S2', 'S3'];
                    $no_hp = ['0855331219757', '0853233221234', '0853321234484', '085585875855'];
                    $status = ['Released', 'Approval 1()', 'Approval 2()', 'Approval 3()', 'Done'];
                  ?>
                    
                  <ul id="generalTab" class="nav nav-tabs">
                    <li class="active"><a href="#alert-tab" data-toggle="tab">Recruitment</a></li>
                    <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                    <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                  </ul>
                  <div id="generalTabContent" class="tab-content responsive">
                    
                    <div id="alert-tab" class="tab-pane fade in active">
                      <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label style="font-weight: bold;font-size: 16px;">Pencarian Berdasarkan :</label>
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tanggal</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm datepicker2" name="">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Pendidikan Terakhir</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <select class="form-control input-sm">
                                <option>--Pilih Pendidikan Terakhir--</option>

                                  @foreach($lulusan as $index => $dataS)

                                    <option>{{$dataS}}</option>

                                  @endforeach

                               </select>
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Status Recruitment</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <select class="form-control input-sm">
                                <option>--Pilih Status Recruitent--</option>
                                  @foreach($status as $index => $kennyS)

                                    <option>{{$kennyS}}</option>

                                  @endforeach
                              </select>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 cari-filter">
                          <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
                          <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                        </div>
                      </div>
                      <div class="table-responsive" style="margin-top: 15px;">
                        <table class="table tabelan table-hover table-bordered data-table" width="100%" cellspacing="0">
                          <thead>
                              <tr>
                                <th class="wd-15p">No.</th>
                                <th>Tanggal Apply</th>
                                <th class="wd-15p">Nama Pelamar</th>
                                <th class="wd-20p">No. HP</th>
                                <th class="wd-15p">Pedidikan Terakhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              @for($i=0;$i<count($person);$i++)
                                <tr>
                                  <td>{{ $i+1 }}</td>
                                  <td>{{ date('d M Y', strtotime($tanggal[mt_rand(0, count($tanggal)-1)])) }}</td>
                                  <td>{{ $person[$i] }}</td>
                                  <td>{{ $no_hp[mt_rand(0, count($no_hp)-1)] }}</td>
                                  <td>{{ $lulusan[mt_rand(0, count($lulusan)-1)] }}</td>
                                  @if($status[mt_rand(0, count($status)-1)] == 'Released')
                                    <td style="color: red;">
                                      Released
                                    </td>
                                  @else
                                    <td>
                                      {{ $status[mt_rand(0, count($status)-1)] }}
                                    </td>
                                  @endif
                                  <td>
                                    <div class="btn-group">
                                      <button class="btn btn-xs btn-info" title="Preview">Preview</button>
                                      <button class="btn btn-xs btn-primary" title="Process">Process</button>
                                    </div>
                                  </td>
                                </tr>
                              @endfor
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
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd M yyyy"
      });    
      </script>
@endsection()