@extends('main')
@section('content')
<style type="text/css">
   .ui-autocomplete { z-index:2147483647; }
   .error { border: 1px solid #f00; }
   .valid { border: 1px solid #8080ff; }
   .has-error .select2-selection {
    border: 1px solid #f00 !important;
}
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
   <!--BEGIN TITLE & BREADCRUMB PAGE-->
   <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
         <div class="page-title">Form Rencana Pembelian</div>
      </div>

      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
         <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li>Rencana Pembelian&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li class="active">Form Rencana Pembelian</li>
      </ol>

      <div class="clearfix"></div>
   </div>

   <div class="page-content fadeInRight">
      <div id="tab-general">
         <div class="row mbl">
            <div class="col-lg-12">
               <div class="col-md-12">
                  <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;"></div>
               </div>
               
               <ul id="generalTab" class="nav nav-tabs">
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Form Rencana Pembelian</a></li>
               </ul>

               <div id="generalTabContent" class="tab-content responsive" >
                  <!-- div alert-tab -->
                  <div id="alert-tab" class="tab-pane fade in active">
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: -10px;margin-bottom: 10px;">
                              <div class="form-group">
                                 <h4>Form Rencana Pembelian</h4>
                              </div>
                           </div>
                                     
                           <div class="col-md-6 col-sm-6 col-xs-6" align="right">
                              <a href="{{ url('/purchasing/rencanapembelian/rencana') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>  
                           
                           <form method="POST" id="form_order_plan" name="formOrderPlan">
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Kode Rencana Pembelian</label>
                                 </div>

                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" readonly="" class="form-control input-sm" name="kodeOrderPlan" value="{{$codePlan}}">
                                    </div>
                                 </div>
                                          
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Tanggal Rencana Pembelian <span style="color: red">*</span></label>
                                 </div>

                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input id="tanggalPlan" class="form-control input-sm datepicker2 " name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                    </div>
                                 </div>

                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Staff</label>
                                 </div>

                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" readonly="" class="form-control input-sm" name="namaStaff" value="{{$staff['nama']}}">
                                       <input type="hidden" readonly="" class="form-control input-sm" name="idStaff" value="{{$staff['id']}}">
                                    </div>
                                 </div>

                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Supplier <span style="color: red">*</span></label>
                                 </div>

                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group" id="divSelectSup">
                                       <select class="form-control input-sm" id="cari_sup" name="cariSup" style="width: 100%;">
                                          <option value=""> - Pilih Supplier</option>
                                       </select>
                                    </div>
                                 </div>

                              </div>
                              
                              <div class="table-responsive">
                                 <table id="barang_table" class="table tabelan table-bordered table-striped">
                                    <thead>
                                       <tr>
                                          <th style="text-align: center;">No</th>
                                          <th>Kode | Barang</th>
                                          <th>Qty</th>
                                          <th>Satuan</th>
                                          <th>Harga Prev / Satuan utama</th>
                                          <th>Stok Gudang</th>
                                          <th style="text-align: center;">Aksi</th>
                                       </tr>
                                    </thead>
                                    <tbody id="div_item">
                                       <tr>
                                          <td width="5%;" style="text-align: center;"><strong>#</strong></td>
                                          <td width="50%;">
                                             {{ csrf_field() }}
                                             <input type="hidden" id="ip_item" class="form-control" value="" name="ipItem">
                                             <input type="text" id="ip_barang" class="form-control ui-autocomplete-input input-sm" placeholder="Masukkan nama barang" autocomplete="off" name="ipBarang">
                                          </td>
                                          <td width="10%;">
                                             <input type="text" id="ip_qtyreq" class="form-control input-sm numberinput" value="" name="ipQtyReq">
                                          </td>
                                          <td width="10%;">
                                             <select class="form-control input-sm" id="ip_sat" name="ipSat" style="width: 100%;">
                                             </select>
                                          </td>
                                          <td width="15%;">
                                             <input type="text" id="ip_hargaPrev" class="form-control input-sm" value="" name="ipHargaPrev" readonly>
                                          </td>
                                          <td>
                                             <input type="text" id="ip_qtyStok" class="form-control input-sm" value="" name="ipQtyStok" readonly>
                                          </td>
                                          <td>
                                             <button id="add_item" onclick="addItemRow()" type="button" class="btn btn-info btn-sm" title="tambah"><i class="fa fa-plus"></i></button>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              
                              <div class="col-md-12 col-sm-4 col-xs-12">
                                 <label class="tebal" style="color: red">Keterangan : * Wajib diisi.</label>
                              </div>

                              <div align="right" style="padding-top:10px;">
                                 <div id="div_button_save" class="form-group">
                                    <button type="button" id="button_save" class="btn btn-primary" onclick="simpanPlan()">Simpan Data</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <!-- end div alert-tab -->
               </div>

            </div>
         </div>
      </div>
   </div>
</div>
<!--END PAGE WRAPPER-->
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

      $('.datepicker').datepicker({
         format: "mm-yyyy",
         viewMode: "months",
         minViewMode: "months"
      });

      $('.datepicker2').datepicker({
         format:"dd-mm-yyyy",
         autoclose: true
      });

      //select2
      $( "#cari_sup" ).select2({
         placeholder: "Pilih Supplier...",
         ajax: {
            url: baseUrl + '/purchasing/rencanapembelian/get-supplier',
            dataType: 'json',
            data: function (params) {
               return {
                  q: $.trim(params.term)
               };
            },
            processResults: function (data) {
               return {
                   results: data
               };
            },
            cache: true
         }, 
      });

      //autocomplete
      $( "#ip_barang" ).focus(function() {
         var key = 1;
         $( "#ip_barang" ).autocomplete({
            source: baseUrl+'/purchasing/rencanapembelian/autocomplete-barang',
            minLength: 1,
            select: function(event, ui) {
              $('#ip_item').val(ui.item.id);
              $('#ip_barang').val(ui.item.label);
              $('#ip_qtyStok').val(ui.item.stok);
              $('#ip_hargaPrev').val(ui.item.prevCost);
              Object.keys(ui.item.sat).forEach(function(){
                $('#ip_sat').append($('<option>', { 
                  value: ui.item.sat[key-1],
                  text : ui.item.satTxt[key-1]
                }));
                key++;
              });
              $("input[name='ipQtyReq']").focus();
            }
         });
         $('#ip_sat').empty();
         $('#ip_barang').val("");
         $('#ip_qtyreq').val("");
         $('#ip_hargaPrev').val("");
         $('#ip_qtyStok').val("");
      });

      // $('#ip_sat').change(function() {
      //   var idBrg = $('#ip_item').val();
      //   var idSat = $(this).val();
      //   $.ajax({
      //     type: "GET",
      //     url: baseUrl + '/purchasing/rencanapembelian/get-stok-persatuan',
      //     data: {idBrg:idBrg, idSat:idSat},
      //     success: function(data){

      //     },
      //     error: function(){
      //     },
      //    async: false
      //   });
      // });

      $(document).on('click', '.btn_remove', function(){
         var no = 1;
         no--;
         var button_id = $(this).attr('id');
         $('#row'+button_id+'').remove();
      });

      //force integer input in textfield
      $('input.numberinput').bind('keypress', function (e) {
         return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
      });

      //validasi
      $("#form_order_plan").validate({
          // Specify validation rules
          rules:{
              tanggal: "required",
              cariSup: "required"
          },
          errorPlacement: function() {
              return false;
          },
          submitHandler: function(form) {
            form.submit();
          }
      });

      $('#ip_sat').keypress(function(event) {
         addItemRow();
      });

   });

   function randString(angka) 
   {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (var i = 0; i < angka; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
   }

   function addItemRow() 
   {
      var i = randString(5);
      var no = 1;
      var ambilSatuan = $("#ip_sat option:selected").text();
      var ambilSatuanId = $("#ip_sat option:selected").val();
      $('#ip_sat').empty();
      var ambilIdBarang = $('#ip_item').val();
      var ambilBarang = $('#ip_barang').val();
      var ambilQtyReq = $('#ip_qtyreq').val();
      var ambilQtyStok = $('#ip_qtyStok').val();
      var ambilHargaPrev = $('#ip_hargaPrev').val();
      if (ambilIdBarang == "" || ambilBarang == "" || ambilQtyReq == "" || ambilQtyStok == "" ) 
      {
         iziToast.warning({
            position: 'center',
            title: 'Pemberitahuan',
            message: "Terdapat kolom yang kosong, dimohon cek lagi !"
         });
         $('#ip_barang').focus();
      }
      else
      {
         $('#barang_table').append('<tr class="tbl_form_row" id="row'+i+'">'
                                  +'<td style="text-align:center">'+no+'</td>'
                                  +'<td><input type="text" name="fieldIpBarang[]" value="'+ambilBarang+'" id="field_ip_barang" class="form-control" required readonly>'
                                  +'<input type="hidden" name="fieldIpItem[]" value="'+ambilIdBarang+'" id="field_ip_item" class="form-control"></td>'
                                  +'<td><input type="text" name="fieldIpQtyReq[]" value="'+ambilQtyReq+'" id="field_ip_qty_req" class="form-control" required readonly></td>'
                                  +'<td><input type="text" name="fieldIpSat[]" value="'+ambilSatuan+'" id="field_ip_sat" class="form-control" required readonly>'
                                  +'<input type="hidden" name="fieldIpSatid[]" value="'+ambilSatuanId+'" id="field_ip_satid" class="form-control" required></td>'
                                  +'<td><input type="text" name="fieldHargaPrev[]" value="'+ambilHargaPrev+'" id="field_ip_hargaprev" class="form-control" required readonly></td>'
                                  +'<td><input type="text" name="fieldIpQtyStok[]" value="'+ambilQtyStok+'" id="field_ip_qty_stok" class="form-control" required readonly></td>'
                                  +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'
                                  +'</tr>');
         i = randString(5);
         no++;
         //kosongkan field setelah append row
         $('#ip_item').val("");
         $('#ip_barang').val("");
         $('#ip_qtyreq').val("");
         $('#ip_qtyStok').val("");
         $('#ip_hargaPrev').val("");
         $('#ip_barang').focus();
      }
   }
   
   function simpanPlan()
   {
      var IsValid = $("form[name='formOrderPlan']").valid();
      if(IsValid)
      {
         //count tr table
         var countRow = $('#div_item tr').length;
         if(countRow > 1){
            $('#divSelectSup').removeClass('has-error');
            $('#button_save').text('Menyimpan...'); //change button text
            $('#button_save').attr('disabled',true); //set button disable 
            $.ajax({
                url : baseUrl + "/purchasing/rencanapembelian/simpan-plan",
                type: "POST",
                dataType: "JSON",
                data: $('#form_order_plan').serialize(),
                success: function(response)
                {
                    if(response.status == "sukses")
                    {
                        iziToast.success({
                           position: 'center',
                           title: 'Pemberitahuan',
                           message: response.pesan,
                           onClosing: function(instance, toast, closedBy){
                              $('#button_save').text('Simpan Data'); 
                              $('#button_save').attr('disabled',false); 
                              window.location.href = baseUrl+"/purchasing/rencanapembelian/rencana";
                           }
                        });
                    }
                    else
                    {
                        iziToast.error({
                           position: 'center',
                           title: 'Pemberitahuan',
                           message: "Data Gagal disimpan !",
                           onClosing: function(instance, toast, closedBy){
                              $('#button_save').text('Simpan Data');
                              $('#button_save').attr('disabled',false);
                              window.location.href = baseUrl+"/purchasing/rencanapembelian/rencana";
                           }
                        }); 
                     }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  iziToast.error({
                     position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                     title: 'Pemberitahuan',
                     message: "Data gagal disimpan !"
                  });
                }
            });
         }
         else
         {
            iziToast.warning({
               position: 'center',
               message: "Mohon isi data pada tabel form !"
            });
         }
      }
      else //else validation
      {
         iziToast.warning({
            position: 'center',
            message: "Mohon Lengkapi data form !",
            onClosing: function(instance, toast, closedBy){
               $('#divSelectSup').addClass('has-error');
            }
         });
      }
   }

   function convertDecimalToRupiah(decimal) 
   {
        var angka = parseInt(decimal);
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
        return hasil+',00';
   }
</script>
@endsection()