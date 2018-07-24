@extends('main')
@section('content')
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Manajemen SPK</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Manajemen SPK</li>
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
              <li class="active"><a href="#index-tab" data-toggle="tab">Rencana Produksi</a></li>
              <li ><a href="#manajemen-spk-tab" data-toggle="tab" onclick="cariTanggalSpk()">Manajemen SPK</a></li>
            </ul>
            <div id="generalTabContent" class="tab-content responsive">
              <!-- div index-tab -->
              @include('keuangan.spk.tab-index')
              <!-- /div index-tab -->
              <!-- div manajemen-spk-tab -->
              @include('keuangan.spk.tab-manajemen-spk')
              <!-- /div manajemen-spk-tab -->
            </div>
          </div>
        </div>
      </div>
      {{-- /div tab-general --}}
    </div>
  </div>

  <!-- Modal -->
  @include('keuangan.spk.create-spk')
  <!-- End Modal -->

@endsection

@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">

  function BuatSpk(id,tgl,jumlah,iditem){
    $.ajax({
      url         : baseUrl+'/produksi/spk/create-id/'+iditem,
      type        : 'get',
      timeout     : 10000,                          
      dataType    :'json',
      success     : function(response){
        console.log(response);
        if(response.status=='sukses'){
          $('#id_spk').val(response.id_spk);
          $('#create-data').modal('show');
          $('#id_plan').val(id);
          $('#tgl_plan').val(tgl);
          $('#iditem').val(iditem);
          $('#item').val(response.i_name.i_name);
          $('#jumlah').val(jumlah); 
          tabelFormmula(iditem, jumlah); 
        }
      }
    });
  }

  function tabelFormmula(iditem, jumlah){
    $('#tableFormula').DataTable({
      responsive:true,
      destroy: true,
      processing: true,
      serverSide: true,
        ajax: {
            url : baseUrl + "/produksi/lihatadonan/tabel/"+iditem+'/'+jumlah,
        },
        columns: [
        {data : 'DT_Row_Index', orderable: true, searchable: false},
        {data: 'f_bb', name: 'f_bb'},
        {data: 'f_value', name: 'f_value'},
        {data: 'f_scale', name: 'f_scale'},
        {data: '-', name: '-', orderable: false},
        {data: '-', name: '-', orderable: false},
        ],
      });
  }
  
  function tambahSpk(){
    cariTanggal();       
    $('#table-production-plan').modal('show');
  }

  function editSpk(id){       
    $('#create-data').modal('show');
    $.ajax({
      url : baseUrl+'/keuangan/spk/get-data-spk-byid/' + id,
      type : 'get',
      timeout : 10000,                          
      dataType :'json',
      success : function(response)
      {
        if(response.status =='sukses')
        {
            $('#tgl_plan').val(response.data[0].pp_date);
            $('#id_plan').val(response.data[0].spk_ref);
            $('#iditem').val(response.data[0].spk_item);
            $('#item').val(response.data[0].i_name);
            $('#jumlah').val(response.data[0].pp_qty);
            $('#id_spk').val(response.data[0].spk_code);
            $('#tgl_spk').val(response.data[0].spk_date);
            // location.reload();
        }
      }
    });
  }

  function draft(status){
    var dataPlan=$('#data-product-plan :input').serialize(); //spk.create-spk
    var dataSpk=$('#data-spk :input').serialize(); //spk.create-spk
      $.ajax({
        url         : baseUrl+'/produksi/spk/simpan-spk',
        type        : 'get',
        timeout     : 10000,                          
        dataType    :'json',
        data        :dataPlan+'&'+dataSpk+'&status='+status,
        success     : function(response){
          if(response.status=='sukses') {
            $('#id_spk').val(response.id_spk);
            $('#create').modal('show');
            $('#id_plan').val(id);
            $('#tgl_plan').val(tgl);
            $('#iditem').val(iditem);
            $('#item').val(item);
            $('#jumlah').val(jumlah);
            $('#tgl_spk').val(tgl);
            location.reload();
          }
        }
      });
    }

  function final(status){
    var dataPlan=$('#data-product-plan :input').serialize(); //spk.create-spk
    var dataSpk=$('#data-spk :input').serialize(); //spk.create-spk
    var idformula=$('#formula :input').serialize();
    $.ajax({
      url         : baseUrl+'/produksi/spk/simpan-spk',
      type        : 'get',
      timeout     : 10000,                          
      dataType    :'json',
      data        :dataPlan+'&'+dataSpk+'&status='+status+'&'+idformula,
      success     : function(response) {
        if(response.status=='sukses'){
          alert('Data rencana berhasil disimpan');
          $('#create-data').modal('hide');
          location.reload(true);
        }else{
          alert('Gagal merubah spk!');
        }
      }
    });
  }

  $(document).ready(function() {
    var extensions = {
      "sFilterInput": "form-control input-sm",
      "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    
    //datatable
    var indexTable = $('#table-index').DataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax": {
          url : baseUrl + "/keuangan/spk/get-data-tabel-index",
          type: 'GET'
      },
      "columns": [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : 'pp_date', name: 'spk_date', "width" : "10%"},
        {"data" : 'i_name', name: 'spk_code', "width" : "25%"},
        {"data" : 'pp_qty', name: 'i_name', "width" : "10%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "5%"},
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

    // data3 dataTable
    $('#data3').dataTable({
      "responsive":true,
      "pageLength": 10,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
      "language": 
      {
        "searchPlaceholder": "Cari Data",
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "sSearch": '<i class="fa fa-search"></i>',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "infoEmpty": "",
        "paginate": 
        {
          "previous": "Sebelumnya",
          "next": "Selanjutnya",
        }
      }
    });

  });

  var date = new Date();
  var newdate = new Date(date);
  newdate.setDate(newdate.getDate()-3);
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
  });
      
  $('.datepicker').datepicker({
    format: "mm",
    viewMode: "months",
    minViewMode: "months"
  });

  function cariTanggalSpk(){
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil = $('#tampil_data').val();
    var spkTable = $('#table-spk').DataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax": {
          url : baseUrl + "/keuangan/spk/get-data-tabel-spk/"+tgl1+"/"+tgl2+"/"+tampil,
          type: 'GET'
      },
      "columns": [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : 'spk_date', name: 'spk_date', "width" : "10%"},
        {"data" : 'spk_code', name: 'spk_code', "width" : "10%"},
        {"data" : 'i_name', name: 'i_name', "width" : "25%"},
        {"data" : 'pp_qty', name: 'pp_qty', "width" : "10%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "15%"},
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

  $('#tampil_data').on('change', function() {
    cariTanggalSpk();
  })

  function ubahStatus(id){
    if(confirm('Anda yakin ubah status transaksi ?')){
      $.ajax({
          url : baseUrl + "/keuangan/spk/get-data-spk-byid/" + id,
          type: "get",
          dataType: "JSON",
          success: function(response){
            if(response.status == "sukses")
            {
              alert(response.pesan);
              refreshTabel();
              refreshTabelSpk();
            }
          },
          error: function (jqXHR, textStatus, errorThrown){
            alert('Error updating data');
          }
      });
    }
  } 

  function refreshTabel() {
    $('#table-index').DataTable().ajax.reload();
  }

  function refreshTabelSpk() {
    $('#table-spk').DataTable().ajax.reload();
  }
  
</script>
@endsection()