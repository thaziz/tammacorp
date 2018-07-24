@extends('main') 
@section('content')
  <!--BEGIN PAGE WRAPPER-->
  <style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
  <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Rencana Produksi</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Rencana Produksi</li>
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
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Rencana Produksi</a></li>
                      <!-- <li><a href="#note-tab" data-toggle="tab">History Rencana Produksi</a></li> -->
                      <!-- <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                          
                      <div id="alert-tab" class="tab-pane fade in active">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">   

                            <div class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                <div style="margin-left:-30px;">
                                  <div class="col-md-3 col-sm-2 col-xs-12">
                                    <label class="tebal">Tanggal</label>
                                  </div>

                                  <div class="col-md-6 col-sm-7 col-xs-12">
                                    <div class="form-group" style="display: ">
                                      <div class="input-daterange input-group">
                                        <input id="tanggal1" class="form-control input-sm datepicker2 " name="tanggal" type="text">
                                        <span class="input-group-addon">-</span>
                                        <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text">
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                  <button class="btn btn-primary btn-sm btn-flat fa fa-search" type="button" id="cariTanggal">
                                   
                                  </button>
                                  <button class="btn btn-info btn-sm btn-flat" type="button" id="refresh">
                                    <strong>
                                      <i class="fa fa-undo" aria-hidden="true"></i>
                                    </strong>
                                  </button>
                                </div>
                                
                              </div>

                              <div align="right">
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-box-tool" id="btn-tambah"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                              </div>

                            <div class="table-responsive">
                              <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                                    <thead>
                                        <tr>
                                          <th>Tanggal</th>
                                          <th>Kode Item</th>
                                          <th>Nama Item</th>
                                          <th>Rencana Produksi</th>
                                          <th>Aksi</th>
                                        </tr>
                                      </thead>
                                      <tbody id="data-search">
                                       
                                      </tbody>

                                      <!--Modal-->
                                      <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog">
                                            
                                          <form id="myForm" onsubmit="return false">
                                            <!-- Modal content-->
                                              <div class="modal-content">
                                                <div class="modal-header" style="background-color: #e77c38;">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title" style="color: white;">Form Rencana Produksi</h4>
                                                </div>

                                                <div class="modal-body">

                                                  <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
                                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                                    <input type="hidden" name="pp_id">                      
                                                    <input type="hidden" name="crud">                      

                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                      <label class="tebal">Nama Item</label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                      <div class="form-group">  
                                                        <input type="text" class="form-control input-sm" maxlength="10" name="namaitem" id="namaitem">
                                                      </div>
                                                    </div>

                                                    

                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                      <label class="tebal">Tanggal</label>
                                                    </div>

                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                      <div class="form-group">  
                                                        <input type="text" class="form-control input-sm" readonly="" name="pp_date" value="{{ date('d-m-Y') }}">
                                                      </div>
                                                    </div>

                                                    

                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                      <label class="tebal">Jumlah Rencana Produksi</label>
                                                    </div>

                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                      <div class="form-group">  
                                                       <input type="text" class="form-control input-sm" name="pp_qty">
                                                      </div>
                                                    </div>

                                                  </div>
                                                  
                                                </div>
                                            
                                                <div class="modal-footer" style="border-top: none;">
                                                  <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                                                </div>
                                              </div>
                                            </form>   
                                          </div>
                                      </div>
                                       <!--End Modal-->
                                                 
                              </table> 
                            </div>  
                           
                          </div>

                        </div>

                      </div>
                      
                  
                      
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
@section("extra_scripts")
<script type="text/javascript">
  $(document).ready(function() {

    var extensions = {
         "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    var myTable = $('#data').dataTable({

        /*"paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "responsive": true,
        "autoWidth": false,            
        "retrieve" : true,
        */
        "responsive":true,
        "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "infoFiltered" : "",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "zeroRecords": "Data tidak ditemukan",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                }
          },

        "ajax":{
              "url" : baseUrl + "/produksi/rencanaproduksi/tabel",
              "type": "GET",
              
        },
        "columns": [
            { "data": "pp_date" },
            { "data": "pp_item" },
            { "data": "i_name" },
            { "data": "pp_qty" },
            { "data": "button" },
        ]

    });

    $.fn.dataTableExt.afnFiltering.push(
      function( settings, data, dataIndex ) {
        var tgl1 = $('#tanggal1').val().toString();
        var y = tgl1.slice(-4);
        var m = tgl1.slice(3,5);
        var d = tgl1.slice(0,2);
        var tgl2 = $('#tanggal2').val().toString();
        var y2 = tgl2.slice(-4);
        var m2 = tgl2.slice(3,5);
        var d2 = tgl2.slice(0,2);
        // var yt = data[0].slice(-4);
        // var mt = data[0].slice(3,5);
        // var dt = data[0].slice(0,2);
        if(y == '' || m == '' || d == ''){
          var min = NaN;
        }else{
          var min = new Date(y,m-1,d);  
        }
        if(y2 == '' || m2 == '' || d2 == ''){
          var max = NaN;
        }else{
          var max = new Date(y2,m2-1,d2);
        }
        
        var age = new Date(data[0].slice(0,10));
        
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
      
      return false;
    });

    $(document).on('click','#cariTanggal',function(){
      myTable.fnDraw();
    });  

    $(document).on('change','#tanggal1,#tanggal2',function(){
      myTable.fnDraw();
    });

    $(document).on('click','#refresh',function(){
      $('#tanggal1').val('');
      $('#tanggal2').val('');
      myTable.fnDraw();
    });

    $(document).on('click','#btn-tambah',function(){
        $("input[name='crud']").val('tambah');
        $("input[name='namaitem']").val('');
        $("input[name='pp_qty']").val('');
    });

    $(document).on('click','.edit',function(){
        var pp_id = $(this).data('id'),
            i_name = $(this).data('name'),
            pp_qty = $(this).data('qty');
        console.log(pp_id);
        console.log(i_name);
        console.log(pp_qty);
        $("input[name='namaitem']").val(i_name);
        $("input[name='pp_qty']").val(pp_qty);
        $("input[name='pp_id']").val(pp_id);
        $("input[name='crud']").val('edit');
        console.log($("input[name='pp_id']").val());
    });

    $(document).on('click','.hapus',function(){
        var pp_id = $(this).data('id'),
            i_name = $(this).data('name');
        if(!confirm("Hapus Rencana Produksi " +i_name+ " ?")) return false;
        
        $.ajax({
            type: "get",
            url : baseUrl + "/produksi/rencanaproduksi/hapus_rencana/"+pp_id,
            dataType:"JSON",
            success: function(data, textStatus, jqXHR)
            {
              console.log('s');
                if(data.result ==1){
                    var table = $('#data').DataTable();
                    table.ajax.reload( null, false );
                    alert("Data berhasil dihapus");
                }else{
                    alert("Error. Data tidak bisa hapus : "+data.error+" error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              console.log('e');
                alert("Error!"+ textStatus+ "error");
            }
        });

        
    });

    $(document).on('click','#btn-simpan',function(){
      var a=$("input[name='namaitem']").val(),
          b=$("input[name='pp_qty']").val();

        if (a == '') {
            Command: toastr["warning"]("Kolom Nama Item tidak boleh kosong ", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        } 
        if (b == '') {
            Command: toastr["warning"]("Kolom Jumlah Rencana Produksi tidak boleh kosong ", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        } 
        $.ajax({
          url : baseUrl + "/produksi/rencanaproduksi/save",
            type: "get",
            dataType:"JSON",
            data : $('#myForm').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
              console.log(data.crud);
              if(data.crud == 'tambah'){
                if(data.result == 1){
                        var table = $('#data').DataTable();
                        table.ajax.reload( null, false );
                        alert("Data Tersimpan")
                        $("#myModal").modal('hide');
                        $("#btn_add").focus();
                }else{
                        alert("Gagal menyimpan data!");
                }
              }
              else if(data.crud == 'edit'){
                if(data.result == 1){
                        //$.notify('Successfull update data');
                        var table = $('#data').DataTable();
                        table.ajax.reload( null, false );
                        //$("#edkode").focus();
                        $("#myModal").modal('hide');
                        $("#btn_add").focus();
                }else{
                  //swal("Error","Can't update data, error : "+data.error,"error");
                }
              }else{
                //swal("Error","invalid order","error");
              }

            },
            error:function(x, e) {
              if (x.status == 0) {
                alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
              } else if (x.status == 404) {
                  alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
              } else if (x.status == 500) {
                  alert("Code telah Terpakai", "Harap Cek sekali lagi",'warning');
              } else if (e == 'parsererror') {
                  alert('Error.\nParsing JSON Request failed.');
              } else if (e == 'timeout'){
                  alert('Request Time out. Harap coba lagi nanti');
              } else {
                  alert('Unknow Error.\n' + x.responseText);
              }
            }
        });
    });


    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        altFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });

    $('.datepicker2').datepicker({
        format:"dd-mm-yyyy"
      }); 
    $( "#namaitem" ).autocomplete({
        source: baseUrl+'/produksi/rencanaproduksi/produksi/autocomplete',
        minLength: 1,
        select: function(event,ui) 
        {
          $("#namaitem").val(ui.item.value);
        }

    });
    
  });
  


</script>
@endsection()