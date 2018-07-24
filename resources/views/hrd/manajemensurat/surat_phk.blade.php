@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Data Surat PHK</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Surat PHK</li>
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
              <a href="#alert-tab" data-toggle="tab">Data Surat PHK</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                    <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">

            <div id="alert-tab" class="tab-pane fade in active">

              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <form method="POST" class="form" action="{{ url('/hrd/manajemensurat/simpan-phk') }}" enctype="multipart/form-data" style="font-family:Arial;">
                    {{ csrf_field() }}
                    <table class="table">
                      <tr>
                        <td class="col-sm-2">
                          <label>Kode</label>
                        </td>
                        <td class="col-sm-1">
                          <label>:</label>
                        </td>
                        <td>
                          <div class="col-sm-12">
                            <input disabled type="text" name="c_kode" value="{{ $kode }}" placeholder="Kode PHK" class="form-control">
                            <input type="hidden" name="c_kode" value="{{ $kode }}" placeholder="Kode PHK" class="form-control">
                          </div>
                        </td>
                        <td>
                          <label>Jenis PHK</label>
                        </td>
                        <td>
                          <label>:</label>
                        </td>
                        <td>
                          <div class="col-sm-12">
                            <select id="jenis" name="c_jenis" class="form-control input-sm">
                              <option>--pilih jenis--</option>
                              <option value="1">Pengurangan pegawai</option>
                              <option value="2">Kesalahan berat</option>
                            </select>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Nama</label>
                        </td>
                        <td>
                          <label>:</label>
                        </td>
                        <td>
                          <div class="col-sm-12">
                            <input type="text" value="" name="c_nama" placeholder="Nama" class="form-control">
                          </div>
                        </td>
                        <td>
                          <label>Tanggal</label>
                        </td>
                        <td>
                          <label>:</label>
                        </td>
                        <td>
                          <div class="col-sm-12">
                            <input id="tgl" type="text" value="" name="c_tgl_phk" placeholder="yyyy-mm-dd" class="form-control">
                          </div>
                        </td>
                      </tr>
                      <tr id="sejak" hidden>
                        <td>
                          <label>Selama bulan terakhir</label>
                        </td>
                        <td>
                          <label>:</label>
                        </td>
                        <td>
                          <div class="col-sm-12">
                            <input type="integer" value="" name="c_bulan_terakhir" placeholder="Bulan" class="form-control">
                          </div>
                        </td>
                      </tr>
                    </table>
                    <div class="col-sm-12">
                      <input type="submit" value="Simpan" class="btn btn-warning pull-right">
                    </div>

                  </form>
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 10px;">
                    <div class="table-responsive">
                      <table id="tbl_phk" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Tanggal PHK</th>
                            <th>Alasan</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /div alert-tab -->

              <!-- div note-tab -->
              <div id="note-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    <!-- Isi Content -->
                  </div>
                </div>
              </div>
              <!--/div note-tab -->

              <!-- div label-badge-tab -->
              <div id="label-badge-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    <!-- Isi content -->
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

  @endsection @section("extra_scripts")

  <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
  <script type="text/javascript">
    $('#tgl').datepicker({
              autoclose: true,
              format: 'yyyy-mm-dd'
            });
      $('select').on('change', function() {
        if(this.value == 2){
                 $('#sejak').removeAttr('hidden');
              }else{
                $('#sejak').attr('hidden','true');
              }
      })
    var extensions = {
      "sFilterInput": "form-control input-sm",
      "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    $('#tbl_phk').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url: '{{ url("hrd/manajemensurat/data-phk") }}',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "kode" },
        { "data": "c_nama" },
        { "data": "c_tgl_phk" },
        { "data": "status" },
        { "data": "action" },
      ],
      "responsive": true,
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

    function edit(a) {
      var parent = $(a).parents('tr');
      var id = $(parent).find('.d_id').text();
      console.log(id);
      $.ajax({
        type: "PUT",
        url: '{{ url("hrd/manajemensurat/edit-phk") }}' + '/' + a,
        data: { id },
        success: function (data) {
        },
        complete: function (argument) {
          window.location = (this.url)
        },
        error: function () {

        },
        async: false
      });
    }
    function hapus(id) {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        toastOnce: true,
        id: 'question',
        zindex: 999,
        title: 'Hey',
        message: 'Apakah anda yakin?',
        position: 'center',
        buttons: [
          ['<button><b>YA</b></button>', function (instance, toast) {
            $.ajax({
              url: '{{ url("hrd/manajemensurat/delete-phk") }}' + '/' + id,
              async: false,
              type: "DELETE",
              data: {
                "id": id,
                "_method": 'DELETE',
                "_token": '{{ csrf_token() }}',
              },
              dataType: "json",
              success: function (data) { }
            });
            window.location.reload();
            instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

          }, true],
          ['<button>TIDAK</button>', function (instance, toast) {

            instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

          }]
        ],
        onClosing: function (instance, toast, closedBy) {
          console.info('Closing | closedBy: ' + closedBy);
        },
        onClosed: function (instance, toast, closedBy) {
          console.info('Closed | closedBy: ' + closedBy);
        }
      });
    }
  </script> @endsection