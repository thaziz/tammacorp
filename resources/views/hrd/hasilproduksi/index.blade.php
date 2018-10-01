@extends('main') 
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Data hasil Pengerjaan Produksi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Hasil Pengerjaan Produksi</li>
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
              <a href="#alert-tab" data-toggle="tab">Data Hasil Produksi</a>
            </li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div alert-tab -->
            @include('hrd.hasilproduksi.tab-index')
          </div>

        </div>
      </div>
    </div>
  </div> 
  @include('hrd.hasilproduksi.modal-detail')
</div>
@endsection 
@section("extra_scripts")
  <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
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

      newdate.setDate(newdate.getDate()-30);
      var nd = new Date(newdate);

      $('.datepicker1').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      }).datepicker("setDate", nd);

      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      });//datepicker("setDate", "0");

      //load fungsi
      lihatHasilByTanggal();

      // fungsi jika modal hidden
      $(".modal").on("hidden.bs.modal", function(){
        //remove append tr
        $('tr').remove('.tbl_modal_detail_row');
      });
    });//end jquery

    function lihatHasilByTanggal()
    {
      var tgl1 = $('#tanggal1').val();
      var tgl2 = $('#tanggal2').val();
      $('#tbl-index').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/hrd/hasilproduksi/get-hasil-by-tgl/"+tgl1+"/"+tgl2,
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBuat", "width" : "10%"},
          {"data" : "c_nama", "width" : "30%"},
          {"data" : "c_nik", "width" : "20%"},
          {"data" : "qty_reguler", "width" : "10%"},
          {"data" : "qty_lembur", "width" : "10%"},
          {"data" : "qty_total", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "5%"}
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

    function detailHasil(id) 
    {
      $.ajax({
        url : baseUrl + "/hrd/hasilproduksi/get-detail/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          var date = data.data[0].d_hg_tgl;
          if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }
          
          //ambil data ke json->modal
          $('#lblTgl').text(newDueDate);
          $('#lblNama').text(data.data[0].c_nama);
          $('#lblNik').text(data.data[0].c_nik);
          $('#lblRmhPro').text(data.data[0].c_rumah_produksi);
          $('#lblTotalHasil').text(parseInt(data.data[0].qty_reguler) + parseInt(data.data[0].qty_lembur));

          $('#div_item_reguler').append(
            '<tr class="tbl_modal_detail_row">'
              +'<td align="center">'+parseInt(data.data[0].d_hg_jumbo_r)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_tb_r)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_ts_r)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_tm_r)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_tc_r)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].qty_reguler)+'</td>'
            +'</tr>');

           $('#div_item_lembur').append(
            '<tr class="tbl_modal_detail_row">'
              +'<td align="center">'+parseInt(data.data[0].d_hg_jumbo_l)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_tb_l)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_ts_l)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_tm_l)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].d_hg_tc_l)+'</td>'
              +'<td align="center">'+parseInt(data.data[0].qty_lembur)+'</td>'
            +'</tr>');
          
          $('#apdsfs').html('<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
          $('#modal_detail').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }
  </script> 
@endsection()