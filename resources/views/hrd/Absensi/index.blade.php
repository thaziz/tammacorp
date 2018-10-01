@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Absensi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Absensi</li>
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
              <a href="#alert-tab" data-toggle="tab">Absensi</a>
            </li>
            <li><a href="#note-tab" data-toggle="tab" onclick="detTanggal()">Data Absensi</a></li>
                            {{-- <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> --> --}}
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >

                      <div style="margin-left:-5px;">
                        <div class="col-md-1 col-sm-3 col-xs-12">
                            <label class="tebal">Tanggal:</label>
                        </div>
                          <form id="date">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="input-daterange input-group">
                                        <input id="datepicker" class="form-control input-sm"
                                          name="tanggal">
                                    </div>
                                </div>
                            </div>
                          </form>

                          <div class="col-md-2 col-sm-3 col-xs-12" align="center">
                              <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                      onclick="getTanggal()">
                                  <strong>
                                      <i class="fa fa-search" aria-hidden="true"></i>
                                  </strong>
                              </button>
                              <button class="btn btn-info btn-sm btn-flat refresh-data2" type="button"
                                      onclick="getTanggal()">
                                  <strong>
                                      <i class="fa fa-undo" aria-hidden="true"></i>
                                  </strong>
                              </button>
                          </div>

                        <div class="col-md-1 col-sm-3 col-xs-12">
                            <label class="tebal">Devisi:</label>
                        </div>

                        <div class="col-md-5 col-sm-3 col-xs-12" align="right">
                            <select name="tampilData" id="tampil_data" onchange="getTanggal()" class="form-control input-sm">
                              @foreach ($devisi as $divisi)
                                <option value="{{$divisi->c_id}}" class="form-control input-sm">{{$divisi->c_divisi}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>


                </div>


                <div class="col-lg-12">
                <div class="panel-body">
                  <div class="table-responsive">
                    <form id="Absensi">
                    <table id="tableAbsensi" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Kode - Nama Pegawai</th>
                          <th>Alpha</th>
                          <th>Izin</th>
                          <th>Sakit</th>
                          <th>Cuti</th>
                          <th>Hadir</th>
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

                          @include('hrd.Absensi.data-absensi')
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

          $('#tanggal1').datepicker({
              autoclose: true,
              format: "dd-mm-yyyy",
              endDate: 'today'
          }).datepicker("setDate", nd);

          $('#tanggal2').datepicker({
              autoclose: true,
              format: "dd-mm-yyyy",
              endDate: 'today'
          });

          $('#tableAbsensi').on('click', "input[type='radio']", function() {
              if (this.getAttribute('checked')) {
                  $(this).removeAttr('checked')
                  var data = $(this).val().split('|');
                  var cek = $("#data"+data[1]).val();
                  if (cek == data[0]) {
                    $("#data"+data[1]).val('');
                  }else{
                    $("#data"+data[1]).val(data[0]);
                  }
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  var a = $('#Absensi').serialize();
                  var b = $('#date').serialize();
                  $.ajax({
                      url: baseUrl + "/hrd/absensi/peg/save",
                      type: 'GET',
                      data: a + '&' + b,
                      success: function (response) {
                        if (response.status == 'sukses') {
                          iziToast.success({
                              timeout: 5000,
                              position: "topLeft",
                              icon: 'fa fa-chrome',
                              title: '',
                              message: 'Absensi Tersimpan.'
                          });
                        }else {
                          iziToast.error({
                              position: "topLeft",
                              title: '',
                              message: 'Absensi Gagal Tersimpan.'
                          });
                        }
                      }
                    });
              } else {
                  $(this).attr('checked', true)
                  var data = $(this).val().split('|');
                  $("#data"+data[1]).val(data[0]);
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  var a = $('#Absensi').serialize();
                  var b = $('#date').serialize();
                  $.ajax({
                      url: baseUrl + "/hrd/absensi/peg/save",
                      type: 'GET',
                      data: a + '&' + b,
                      success: function (response) {
                        if (response.status == 'sukses') {
                          iziToast.success({
                              timeout: 5000,
                              position: "topLeft",
                              icon: 'fa fa-chrome',
                              title: '',
                              message: 'Absensi Tersimpan.'
                          });
                        }else {
                          iziToast.error({
                              position: "topLeft",
                              title: '',
                              message: 'Absensi Gagal Tersimpan.'
                          });
                        }
                      }
                    });
              }
          });


          getTanggal();

        });

        function getTanggal(){
          $('#tableAbsensi').dataTable().fnDestroy();
          var tgl1 = $("#datepicker").val();
          var data = $("#tampil_data").val();
          $('#tableAbsensi').DataTable({
              "scrollY": 500,
              "scrollX": true,
              "paging":  false,
              "autoWidth": false,
              "ajax": {
                  url: baseUrl + "/hrd/absensi/table/" + tgl1 + "/" + data,
                  type: 'GET'
              },
              "columns": [
                {"data" : "DT_Row_Index", orderable: false, searchable: false, "width" : "5%"},
                {"data" : 'pegawai', name: 'pegawai', width:"45%"},
                {"data" : 'Alpha', name: 'Alpha', orderable: false, width:"10%"},
                {"data" : 'Izin', name: 'Izin', orderable: false, width:"10%"},
                {"data" : 'Sakit', name: 'Sakit', orderable: false, width:"10%"},
                {"data" : 'Cuti', name: 'Cuti', orderable: false, width:"10%"},
                {"data" : 'Hadir', name: 'Hadir', orderable: false, width:"10%"},
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
      };

      function detTanggal(){
        $('#detailAbsensi').dataTable().fnDestroy();
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
        var tampil = $("#tampilDet").val();
        $('#detailAbsensi').DataTable({
            "ajax": {
                url: baseUrl + "/hrd/absensi/detail/" + tgl1 + "/" +tgl2+ "/" + tampil,
                type: 'GET'
            },
            "columns": [
              {"data" : "DT_Row_Index", orderable: false, searchable: false},
              {"data" : 'pegawai', name: 'pegawai', width:"40%"},
              {"data" : 'Alpha', name: 'Alpha', orderable: false, width:"10%"},
              {"data" : 'Izin', name: 'Izin', orderable: false, width:"10%"},
              {"data" : 'Sakit', name: 'Sakit', orderable: false, width:"10%"},
              {"data" : 'Cuti', name: 'Cuti', orderable: false, width:"10%"},
              {"data" : 'Hadir', name: 'Hadir', orderable: false, width:"10%"},
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

        @endsection
