@extends('main')
@section('extra_styles')
<style type="text/css">
  
  .ui-autocomplete { z-index:2147483647; }
  .error { border: 1px solid #f00; }
  .valid { border: 1px solid #8080ff; }
  .has-error .select2-selection {
    border: 1px solid #f00 !important;
  }
  .has-valid .select2-selection {
    border: 1px solid #8080ff !important;
  }

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
                  $lulusan = ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D3', 'S1', 'S2', 'S3'];
                  $no_hp = ['0855331219757', '0853233221234', '0853321234484', '085585875855'];
                ?>
                  
                <ul id="generalTab" class="nav nav-tabs">
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Recruitment</a></li>
                  <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                  <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                </ul>
                <div id="generalTabContent" class="tab-content responsive">
                  
                  <div id="alert-tab" class="tab-pane fade in active">
                    <div class="row tamma-bg" style="margin-top: -23px;padding-top: 23px;padding-bottom: 10px;border-radius: unset;">
                      <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label style="font-weight: bold;font-size: 16px;">Pencarian Berdasarkan :</label>
                          </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="form-group" style="float: right;">
                            <button class="btn btn-primary btn-sm" onclick="cariDataIndex()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-default btn-sm" onclick="refreshTabelIndex()"><i class="fa fa-refresh"></i></button>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <label>Tgl Awal</label>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group">
                            <input type="text" class="form-control input-sm datepicker1" readonly="" id="head_tgl1" name="headTgl1" style="cursor: pointer;">
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <label>Tgl Akhir</label>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group">
                            <input type="text" class="form-control input-sm datepicker2" readonly="" id="head_tgl2" name="headTgl2" style="cursor: pointer;">
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <label>Pendidikan Terakhir</label>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group">
                            <select class="form-control input-sm" name="headGrade" id="head_grade">
                              <option value="semua"> Tampilkan Semua </option>

                                @foreach($lulusan as $index => $dataS)

                                  <option value="{{$dataS}}">{{$dataS}}</option>

                                @endforeach

                             </select>
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <label>Status Recruitment</label>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group">
                            <select class="form-control input-sm" name="headStatus" id="head_status">
                              <option value="semua"> Tampilkan Semua </option>
                                @foreach($statusApply as $val)

                                  <option value="{{$val->p_st_id}}">{{$val->p_st_name}}</option>

                                @endforeach
                            </select>
                          </div>
                        </div>

                      </div>

                    </div>
                    <div class="table-responsive" style="margin-top: 15px;">
                      <table class="table tabelan table-hover table-bordered data-table" width="100%" cellspacing="0" id="tbl-index">
                        <thead>
                            <tr>
                              <th class="wd-15p">No.</th>
                              <th>Tanggal Apply</th>
                              <th class="wd-15p">Nama Pelamar</th>
                              <th class="wd-20p">No. HP</th>
                              <th class="wd-20p">Email</th>
                              <th class="wd-15p">Pedidikan</th>
                              <th>Status</th>
                              <th>Approval</th>
                              <th style="text-align: center;">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
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
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    var date = new Date();
    var newdate = new Date(date);
    // newdate.setDate(newdate.getDate()-30);
    newdate.setDate(newdate.getDate()-30);
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
      format:"dd-mm-yyyy"
    }).datepicker("setDate", "0");

    cariDataIndex();
  });//end jquery

  function cariDataIndex()
  {
    var tgl1 = $('#head_tgl1').val();
    var tgl2 = $('#head_tgl2').val();
    var grade = $('#head_grade').val();
    var status = $('#head_status').val();
    $('#tbl-index').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/hrd/recruitment/get-data-hrd",
        type: 'GET',
        data: {tgl1:tgl1, tgl2:tgl2, grade:grade, status:status}
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : "tglBuat", "width" : "5%"},
        {"data" : "p_name", "width" : "15%"},
        {"data" : "p_tlp", "width" : "10%"},
        {"data" : "p_email", "width" : "10%"},
        {"data" : "p_education", "width" : "10%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "statusdt", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "20%"}
      ],
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
  }
</script>
@endsection()