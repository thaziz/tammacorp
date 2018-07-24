@extends('main') @section('content')
<style type="text/css">
  .ui-autocomplete {
    z-index: 2147483647;
  }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Transfer Retail</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Penjualan&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Transfer Retail</li>
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
              <a href="#transfer" data-toggle="tab">List Transfer</a>
            </li>
            <li>
              <a href="#alert-tab" data-toggle="tab" onclick="penerimaan()">Penerimaan Transfer</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">


            <div id="transfer" class="tab-pane fade in active">

              @if(Auth::user()->punyaAkses('Ritail Transfer','ma_insert'))
              <div class="" align="right" style="margin-bottom: 15px;">
                <div class="col-md-6 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                  <div style="margin-left:-30px;">
                    <div class="col-md-5 col-sm-7 col-xs-12">
                      <div class="form-group" style="display:">
                        <div class="input-daterange input-group">
                          <input id="tanggal" data-provide="datepicker" class="form-control input-sm" name="tanggal" type="text">
                          <span class="input-group-addon">-</span>
                          <input id="tanggal" data-provide="datepicker" class="input-sm form-control" name="tanggal" type="text">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                    <button class="btn btn-warning btn-sm btn-flat" type="button">
                      <strong>
                        <i class="fa fa-search" aria-hidden="true"></i>
                      </strong>
                    </button>
                    <button class="btn btn-danger btn-sm btn-flat" type="button">
                      <strong>
                        <i class="fa fa-undo" aria-hidden="true"></i>
                      </strong>
                    </button>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12" align="center"></div>
                    <button data-toggle="modal" onclick="noNota()" aria-controls="list" role="tab" class="btn-primary btn-flat btn-sm">
                      <i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Transfer Item</button>
                  </div>
                </div>
                @endif

                <div class="table-responsive">
                  <table id="tbl_list" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>


              <!-- div note-tab -->
              <div id="alert-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    <div class="table-responsive">
                      <table id="tbl_penerimaan" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Tanggal</th>
                            <th>Kode</th>
                            <th>Catatan</th>
                            <th>Status</th>
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
              <!-- End DIv note-tab -->




            </div>



          </div>
          <!-- End div generalTab -->
        </div>
      </div>
      @include('penjualan.POSretail.StokRetail.transfer')
    </div>
    @include('transfer.modal-transfer')
  </div>
  @include('transfer.penerimaan.modal-penerimaan') @endsection @section("extra_scripts")

  <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>

  <script type="text/javascript">
    $('#tbl_list').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url: '{{ url("/transfer/list-penerimaan/datatable") }}',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "tanggal" },
        { "data": "ti_code" },
        { "data": "ti_note" },
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
    $('#tbl_penerimaan').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url: '{{ url("/transfer/lihat-penerimaan/datatable") }}',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "tanggal" },
        { "data": "ti_code" },
        { "data": "ti_note" },
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
    function noNota() {
      $.ajax({
        url: baseUrl + '/transfer/no-nota',
        type: 'get',
        timeout: 10000,
        dataType: 'json',
        success: function (response) {
          $('#no-nota').val(response);
          $('#myTransfer').modal('show');
        }
      });
    }

    /*tableReq=$('#detail-req').DataTable();*/


    tableReq = $('#detail-req').DataTable({
      "columns": [{ "width": "10%px" }, { "width": "70%" }, { "width": "10%" }, { "width": "10%" }],
      'columnDefs': [
        {
          "targets": 3, // your case first column
          "className": "text-center",
          "width": "4%"
        }
      ],
    });

    //transfer thoriq
    $("#rnamaitem").autocomplete({
      source: baseUrl + '/penjualan/POSretail/retail/transfer-item',
      minLength: 1,
      select: function (event, ui) {
        console.log(ui);
        $('#rnamaitem').val(ui.item.label);
        $('#code').val(ui.item.code);
        $('#rkode').val(ui.item.id);
        $('#rdetailnama').val(ui.item.name);
        $('#rqty').val(ui.item.qty);
        $("input[name='rqty']").focus();
      }
    });

    //enter stock
    $('#rqty').keypress(function (e) {
      var charCode;
      if ((e.which && e.which == 13)) {
        charCode = e.which;
      } else if (window.event) {
        e = window.event;
        charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)) {
        var isi = $('#rqty').val();
        var jumlah = $('#rdetailnama').val();
        if (isi == '' || jumlah == '') {
          toastr.warning('Item dan Jumlah tidak boleh kosong');
          return false;
        }
        tambahreq();
        $("#rnamaitem").val('');
        $("#rqty").val('');
        $("input[name='rnamaitem']").focus();
        return false;
      }
    });

    var rindex = 0;
    var rtamp = [];
    function tambahreq() {
      var kode = $('#rkode').val();
      var code = $('#code').val();
      var nama = $('#rdetailnama').val();
      var qty = parseInt($('#rqty').val());
      var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="rhapus(this)"><i class="fa fa-trash-o"></i></button>';
      var rindex = rtamp.indexOf(kode);

      if (rindex == -1) {
        tableReq.row.add([
          code,
          nama + '<input type="hidden" name="kode_item[]" class="kode_item kode" value="' + kode + '"><input type="hidden" name="nama_item[]" class="nama_item" value="' + nama + '"> ',
          '<input size="30" style="text-align:right;" type="text"  name="sd_qty[]" class="sd_qty form-control r_qty-' + kode + '" value="' + qty + '"> ',

          Hapus
        ]);

        tableReq.draw();
        rindex++;
        // console.log(rtamp);
        rtamp.push(kode);
      } else {
        var qtyLawas = parseInt($(".r_qty-" + kode).val());
        $(".r_qty-" + kode).val(qtyLawas + qty);
      }

      var kode = $('#rkode').val('');
      var nama = $('#rdetailnama').val('');
    }

    function simpanTransfer() {
      $('.btn').attr('disabled', 'disabled');
      var item = $('#save_request :input').serialize();
      var data = tableReq.$('input').serialize();
      $.ajax({
        url: baseUrl + "/penjualan/POSretail/retail/simpan-transfer",
        type: 'get',
        data: item + '&' + data,
        dataType: 'json',
        success: function (response) {


          if (response.status == 'sukses') {
            $('.btn').removeAttr('disabled', 'disabled');

            $("input[name='ri_nomor']").val('');
            $("input[name='ri_admin']").val('');
            $("input[name='ri_ketetangan']").val('');
            alert('Proses Telah Terkirim');
            $('#myTransfer').modal('hide');
            tableReq.clear().draw();
            datax();
          }
          else if (response.status == 'not-allowed') {
            window.location = baseUrl + '/not-allowed';
          }
        }
      })
    }

    function rhapus(a) {
      var par = a.parentNode.parentNode;
      tableReq.row(par).remove().draw(false);


      var inputs = document.getElementsByClassName('kode'),
        names = [].map.call(inputs, function (input) {
          return input.value;
        });
      rtamp = names;

    }



    datax();
    function datax() {
      $.ajax({
        url: baseUrl + '/transfer/data-transfer',
        type: 'get',
        timeout: 10000,
        success: function (response) {
          $('#data-transfer').html(response);
        }
      });
    }


    function editTransfer($id) {
      $.ajax({
        url: baseUrl + '/transfer/data-transfer/' + $id + '/edit',
        type: 'get',
        timeout: 10000,
        success: function (response) {
          $('#Edit-data-transfer').html(response);
          $('#myTransferEdit').modal('show');
        }
      });
    }


    function hapusTransfer($id) {
      $.ajax({
        url: baseUrl + '/transfer/data-transfer/hapus/' + $id,
        type: 'get',
        timeout: 10000,
        dataType: 'json',
        success: function (response) {

          if (response.status == 'sukses') {
            datax();
          }
        }
      });
    }

    penerimaan();
    function penerimaan() {
      $.ajax({
        url: baseUrl + '/transfer/penerimaan-transfer',
        type: 'get',
        timeout: 10000,
        success: function (response) {
          $('#data-penerimaan').html(response);
        }
      });
    }
    function lihatPenerimaan($id) {
      $.ajax({
        url: baseUrl + '/transfer/lihat-penerimaan/' + $id,
        type: 'get',
        timeout: 10000,
        success: function (response) {
          $('#data-penerimaan-transfer').html(response);
          $('#myTransferPenerimaan').modal('show');
        }
      });
    }

    tablePenerimaan = $('#detail-terima').DataTable();
    function simpaPenerimaan() {
      $.ajax({
        url: baseUrl + '/transfer/penerimaan/simpa-penerimaan',
        type: 'get',
        timeout: 10000,
        data: item + '&' + tablePenerimaan.$('input').serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.status == 'sukses') {
            location.reload();
          }
        }
      });
    }




  </script> @endsection()