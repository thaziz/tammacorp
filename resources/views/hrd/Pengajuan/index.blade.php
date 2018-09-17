@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Pengajuan Pelatihan</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Pengajuan Pelatihan</li>
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
              <a href="#alert-tab" data-toggle="tab">Form Pelatihan</a>
            </li>
            <li><a href="#note-tab" data-toggle="tab" onclick="detTanggal()">Data Absensi</a></li>
                            {{-- <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> --> --}}
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                   <form method="get" id="form_cust" action="simpan_cust">
                     <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">

                       <div class="col-md-2 col-sm-3 col-xs-12">


                             <label class="tebal">Nama:<font color="red">*</font></label>

                       </div>
                       <div class="col-md-4 col-sm-9 col-xs-12">
                         <div class="form-group">
                           <div class="input-icon right">
                             <i class="glyphicon glyphicon-user"></i>
                                <input type="text" readonly="" class="form-control input-sm" name="namaStaff" value="{{$staff['nama']}}">
                                <input type="hidden" readonly="" class="form-control input-sm" name="idStaff" value="{{$staff['id']}}">
                           </div>
                         </div>
                       </div>
                       <div class="col-md-2 col-sm-3 col-xs-12">

                             <label class="tebal">Jabatan/Posisi:<font color="red">*</font></label>

                       </div>
                       <div class="col-md-4 col-sm-9 col-xs-12">
                         <div class="form-group">
                           <select name="tampilData" id="tampil_data" class="form-control input-sm">
                               <option value="" class="form-control input-sm">- Pilih Jabatan</option>
                             @foreach ($jabatan as $data)
                               <option value="{{$data->c_id}}" class="form-control input-sm">{{$data->c_posisi}}</option>
                             @endforeach
                           </select>
                         </div>
                       </div>
                       <div class="col-md-2 col-sm-3 col-xs-12">


                             <label class="tebal">Ruang Lingkup Pekerjaan :<font color="red">*</font></label>

                       </div>
                       <div class="col-md-10 col-sm-9 col-xs-12">
                         <div class="form-group">
                                <input type="text" class="form-control input-sm" name="namaStaff" value="">
                         </div>
                       </div>
                       <div class="col-md-2 col-sm-3 col-xs-12">


                             <label class="tebal">Nama Atasan	 :<font color="red">*</font></label>

                       </div>
                       <div class="col-md-10 col-sm-9 col-xs-12">
                         <div class="form-group">
                           <select name="tampilData" id="tampil_data" class="form-control input-sm">
                               <option value="" class="form-control input-sm">- Nama Atasan</option>
                             @foreach ($staf as $data)
                               <option value="{{$data->mp_id}}" class="form-control input-sm">{{$data->c_nama}}</option>
                             @endforeach
                           </select>
                         </div>
                       </div>

                       <div class="col-md-12 col-sm-3 col-xs-12">

                             <label class="tebal">Petunjuk Pengisian : Berilah tanda Checklist pada tempat yang
                               disediakan atau berilah jawaban singkat, jelas, dan padat pada pertanyaan yang diminta !</label>

                       </div>

                      </div>


                </div>


                <div class="col-lg-12">
                <div class="panel-body">
                  <div class="table-responsive">
                    <form id="Absensi">
                    <table id="tablePengajuan" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Soal</th>
                          <th>Jawab</th>
                        </tr>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                    </form>
                  </div>
                </div>
                </div>
              </div>
            </div>
            <!-- div note-tab -->
                <div id="note-tab" class="tab-pane fade">
                    <div class="row">
                        <div class="panel-body">

                          @include('hrd.Pengajuan.data-absensi')
                        </div>
                    </div>
                </div>
                <!-- End DIv note-tab -->
          </div>
        </div>
        @endsection @section('extra_scripts')
        <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
        <script type="text/javascript">
        $(document).ready(function () {
          var extensions = {
            "sFilterInput": "form-control input-sm",
            "sLengthSelect": "form-control input-sm"
          }
          // Used when bJQueryUI is false
          $.extend($.fn.dataTableExt.oStdClasses, extensions);
          // Used when bJQueryUI is true
          $.extend($.fn.dataTableExt.oJUIClasses, extensions)

          var date = new Date();
          var newdate = new Date(date);

          newdate.setDate(newdate.getDate() - 6);
          var nd = new Date(newdate);

          $('.datepicker').datepicker({
              format: "mm",
              viewMode: "months",
              minViewMode: "months"
          });

          $('#datepicker').datepicker({
              autoclose: true,
              format: "dd-mm-yyyy",
              endDate: 'today'
          }).datepicker("setDate", nd);


          $('#tableAbsensi').on('click', "input[type='radio']", function() {
              if (this.getAttribute('checked')) {
                  $(this).removeAttr('checked')
                  var data = $(this).val().split('|');
                  var cek = $("#data"+data[1]).val();

              } else {
                  $(this).attr('checked', true)
                  var data = $(this).val().split('|');
                  $("#data"+data[1]).val(data[0]);

              }
          });


          $('#tablePengajuan').DataTable({
              "scrollY": 500,
              "scrollX": true,
              "paging":  false,
              "autoWidth": false,
              "ajax": {
                  url: baseUrl + "/hrd/Pengajuan/table",
                  type: 'GET'
              },
              "columns": [
                {"data" : "DT_Row_Index", orderable: false, searchable: false, "width" : "5%"},
                {"data" : 'Soal', name: 'Soal', width:"55%"},
                {"data" : 'Jawab', name: 'Jawab', orderable: false, width:"40%"},
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

        });


        </script>

        @endsection
