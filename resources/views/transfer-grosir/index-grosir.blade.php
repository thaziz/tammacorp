@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>

            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Transfer Grosir</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Transfer Grosir</li>
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
                        <li class="active"><a href="#data-transfer" data-toggle="tab">Persetujuan Transfer</a></li>
                            <li><a href="#nav-stock" data-toggle="tab" onclick="tfToRetail()">Transfer Ke Retail</a></li>
                          </ul>
                <div id="generalTabContent" class="tab-content responsive">
                        <div id="data-transfer" class="tab-pane fade in active">

                        </div>
                

                  <!-- div note-tab -->
                          <div id="nav-stock" class="tab-pane fade">
                            <div class="row">
                              <div class="panel-body">
            <div class="" align="right" style="margin-bottom: 15px;">
                <button  data-toggle="modal" onclick="noNota()" aria-controls="list" role="tab"  class="btn-primary btn-flat btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Transfer Item</button>
            </div>        


            <div id="data-tf-to-retail" class="tab-pane fade in active">

            </div>                     
                              </div>
                            </div>                            
                          </div>
                          <!-- End DIv note-tab -->
                   @include('transfer-grosir.modal-transfer')        
                   
                 
        </div>
        @include('transfer-grosir.modal-edit-tf-grosir')  
        <!-- End div generalTab -->
      </div>
    </div>
  </div>
</div>  
  @include('transfer-grosir.modal-approve')

@endsection
@section("extra_scripts")

    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>

    <script type="text/javascript">
    
   
    datax();
    function datax(){
         $.ajax({
                    url         : baseUrl+'/transfer/data-transfer-appr',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer').html(response);
                        }
                    });
     }


     function edit($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/'+$id+'/edit',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer-appr').html(response);
                         $('#myTransfer').modal('show');
                        }
            });
     }


     function hapus($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/'+$id+'/hapus',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer').html(response);
                        }
            });
     }


     function simpanApprove(){

         $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/simpan-approve',
                    type        : 'get',
                    timeout     : 10000,  
                    data: item+'&'+tableReq.$('input').serialize(),
                    dataType:'json',                                      
                    success     : function(response){
                          if(response.status=='sukses'){
                            location.reload();
                          }else if(response.status=='Gagal'){
                            toastr.warning(response.info);
                          }
                    }
            });
     }

 function noNota(){
         $.ajax({
                    url         : baseUrl+'/transfer/no-nota',
                    type        : 'get',
                    timeout     : 10000,
                    dataType    :'json',
                    success     : function(response){
                        $('#no-nota').val(response);
                        $('#myTransferToRetail').modal('show');
                        }
                    });
    }

 tableReq=$('#transfer-detail').DataTable();

      //transfer thoriq
    $("#stf_namaitem").autocomplete({
        source: baseUrl+'/penjualan/transfer/grosir/transfer-item',
        minLength: 1,
        select: function(event, ui) 
        {
          console.log(ui);          
        $('#stf_namaitem').val(ui.item.label);        
        $('#stf_kode').val(ui.item.code);
        $('#stf_detailnama').val(ui.item.name);        
        $('#sstf_qty').val(ui.item.qty);
        $("input[name='stf_qty']").focus();
        }
      });


$('#stf_qty').keypress(function(e){      
      var qtyStok   =parseInt($('#sstf_qty').val()); 
      var qtySend   =parseInt($('#stf_qty').val()); 
      var charCode;
      if ((e.which && e.which == 13)) {
        charCode = e.which;
      }else if (window.event) {
          e = window.event;
          charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)){
        var isi   = $('#stf_qty').val();
        var nama= $('#stf_detailnama').val();
        if(nama == '' || isi == ''|| isi == '0'){
          toastr.warning('Item dan Jumlah tidak boleh kosong');
          return false;
        }
        else if(qtyStok-qtySend<0){
          toastr.warning('Stok Tidak Mencukupi');
          return false;
        }
        tambahTf();
        $("#stf_namaitem").val('');
        $("#stf_qty").val('');
        $("#sstf_qty").val('');
        $("input[name='stf_namaitem']").focus();
           return false;  
      }
   });

   var rindex=0;
    var rtamp=[];
            function tambahTf() {   
        var kode  =$('#stf_kode').val();      
        var nama  =$('#stf_detailnama').val();                                
        var qty   =parseInt($('#stf_qty').val());        
        var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="rhapus(this)"><i class="fa fa-trash-o"></i></button>';
        var rindex = rtamp.indexOf(kode);

        if ( rindex == -1){     
            tableReq.row.add([
              kode,
              nama+'<input type="hidden" name="kode_item[]" class="kode_item kode" value="'+kode+'"><input type="hidden" name="nama_item[]" class="nama_item" value="'+nama+'"> ',
              '<input size="30" style="text-align:right;" type="text"  name="sd_qty[]" class="sd_qty form-control tf_qty-'+kode+'" value="'+qty+'"> ',
              
              Hapus
              ]);

            tableReq.draw();
        rindex++;
        // console.log(rtamp);
        rtamp.push(kode);
            }else{
            var qtyLawas= parseInt($(".stf_qty-"+kode).val());
            $(".stf_qty-"+kode).val(qtyLawas+qty);
            }

          var kode  =$('#stf_kode').val('');      
          var nama  =$('#stf_detailnama').val('');
        }

       function simpanTransfer() 
      {
        var item = $('#master_transfer :input').serialize();
        var data = tableReq.$('input').serialize();
        $.ajax({
        url : baseUrl + "/penjualan/transfer/grosir/simpan-transfer-grosir",
        type: 'get',
        data: item+'&'+data,
        dataType:'json',
        success:function(response){
          
          
              if(response.status=='sukses'){

              $("input[name='tf_nomor']").val('');
              $("input[name='tf_admin']").val('');              
              $("input[name='tf_ketetangan']").val('');
              alert('Proses Telah Terkirim');                
              $('#myTransferToRetail').modal('hide');
              }    
        }
        })
      }

       function updateTransfer($id) 
      {
        var item = $('#edit_request :input').serialize();
        var data = tableTf.$('input').serialize();
        $.ajax({
        url : baseUrl + "/penjualan/POSgrosir/update-transfer-grosir/"+$id,
        type: 'get',
        data: item+'&'+data,
        dataType:'json',
        success:function(response){
          
          
              if(response.status=='sukses'){

              $("input[name='tf_nomor']").val('');
              $("input[name='tf_admin']").val('');              
              $("input[name='tf_ketetangan']").val('');
              alert('Proses Telah Terkirim');                
              $('#myTransferToRetail').modal('hide');
              }    
        }
        })
      }

  function rhapus(a){
    var par = a.parentNode.parentNode;
    tableReq.row(par).remove().draw(false);

  var inputs = document.getElementsByClassName( 'kode' ),
      names  = [].map.call(inputs, function( input ) {
          return input.value;
      });
      rtamp = names;

     }


//transfer grosir to retail

function tfToRetail(){
         $.ajax({
                    url         : baseUrl+'/penjualan/transfer/grosir/data-transfer-grosir',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-tf-to-retail').html(response);
                        }
                    });
     }

      function editTransferGrosir($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/edit-transfer-grosir/'+$id+'/edit',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#edit-data-transfer').html(response);
                         $('#EditTransfer').modal('show');
                        }
            });
     }


     function hapusTransferGrosir($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/hapus-transfer-grosir/hapus/'+$id,
                    type        : 'get',
                    timeout     : 10000,    
                    dataType    :'json',
                    success     : function(response){
                          if(response.status=='sukses'){
                                      alert('Berhasil Di Hapus');                                        
                                      tfToRetail();
                          }    
                    }
                        
            });
     }

    </script>
    
@endsection()