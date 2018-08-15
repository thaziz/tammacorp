@extends('main')
@section('content')
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
</style>
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
          <div class="page-title">Form Belanja Harian</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
          <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li class="active">Belanja Harian&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li class="active">Form Belanja Harian</li>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Belanja Harian</a></li>
            </ul>

            <div id="generalTabContent" class="tab-content responsive" >
              <!-- div alert-tab -->
              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row">  
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                      <div class="col-md-5 col-sm-6 col-xs-8" >
                        <h4>Form Belanja Harian</h4>
                      </div>

                      <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                        <a class="btn" onclick="tambahMasterSatuan()"><i class="fa fa-plus"></i>&nbsp; Master satuan</a></a>
                        <a href="{{ url('purchasing/belanjaharian/belanja') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                     </div>
                    </div>

                    <form action="#" method="post" id="form-belanja" name="formBelanja">
                      {{ csrf_field() }}
                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-top:30px;padding-bottom:20px;">
                        
                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <label class="tebal">Tanggal Beli</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                            <input id="tanggal_beli" class="form-control input-sm datepicker2" name="tanggalBeli" type="text" value="{{ date('d-m-Y') }}">
                          </div> 
                        </div>

                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <label class="tebal">No Nota</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                            <input type="text" readonly="" class="form-control input-sm" value="{{$codePH}}" name="kodeNota">                
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <label class="tebal">Total Biaya</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                            <input type="text" class="form-control input-sm" name="totalBiaya" readonly>
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <label class="tebal">Nama Staff</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                            <input type="text" readonly="" class="form-control input-sm" name="namaStaff" value="{{$staff['nama']}}">
                            <input type="hidden" readonly="" class="form-control input-sm" name="idStaff" value="{{$staff['id']}}">
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <label class="tebal">Divisi Peminta</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                              <input type="text" class="form-control input-sm" name="divisiPeminta">
                          </div>
                        </div>
                        
                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <label class="tebal">Keperluan</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                              <input type="text" class="form-control input-sm" name="keperluan">
                          </div>
                        </div>

                      </div>

                      <div class="table-responsive">
                        <table class="table tabelan table-bordered" id="tabel-belanja">
                          <thead>
                            <tr>
                              <th width="5%">No</th>
                              <th width="25%">Nama Barang</th>
                              <th width="10%">QTY</th>
                              <th width="10%">Satuan</th>
                              <th width="15%">Harga Satuan</th>
                              <th width="15%">Total Harga</th>
                              <th style="text-align: center;" width="5%">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="div_item">
                            <tr>
                              <td style="text-align: center;"><strong>#</strong></td>
                              <td>
                                  {{ csrf_field() }}
                                  <input type="hidden" id="ip_item" class="form-control" value="" name="ipItem">
                                  <div class="input-group input-group-sm" style="width: 100%;">
                                    <input type="text" id="ip_barang" class="form-control ui-autocomplete-input input-sm" placeholder="Masukkan nama barang" autocomplete="off" name="ipBarang">
                                    <span class="input-group-btn"><button  type="button" class="btn btn-info btn-sm btn_add_barang" onclick="tambahMasterBarang()"><i class="fa fa-plus"></i></button></span>
                                  </div>
                              </td>
                              <td>
                                  <input type="text" id="ip_qty" class="form-control input-sm numberinput" value="" name="ipQty">
                              </td>
                              <td>
                                  <select class="form-control input-sm" id="ip_satuan" name="ipSat" style="width: 100%;"></select>
                              </td>
                              <td>
                                  <input type="text" id="ip_harga" class="form-control input-sm" value="" name="ipHarga">
                              </td>
                              <td>
                                  <input type="text" id="ip_harga_total" class="form-control input-sm" value="" name="ipHargaTotal" readonly>
                              </td>
                              <td>
                                  <button id="add_item" type="button" onclick="addItemRow()" class="btn btn-info btn-sm" title="tambah"><i class="fa fa-plus"></i></button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div align="right" style="margin-top:20px;">
                        <div class="form-group" align="right">
                          <button type="button" id="button_save" class="btn btn-primary" onclick="simpanBelanja()">Simpan Data</button>
                        </div>
                      </div>

                    </form>

                  </div>
                </div>
              </div>
              <!-- /div alert-tab -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--END PAGE WRAPPER-->
  <!-- modal-barang -->
  @include('purchasing.belanjaharian.modal-barang')
  <!-- modal-satuan -->
  @include('purchasing.belanjaharian.modal-satuan')
@endsection
@section("extra_scripts")
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
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
        format:"dd-mm-yyyy"
    });

    //autocomplete
    $( "#ip_barang" ).focus(function() {
      var key = 1;
        $( "#ip_barang" ).autocomplete({
            source: baseUrl+'/purchasing/belanjaharian/autocomplete-barang',
            minLength: 1,
            select: function(event, ui) {
                $('#ip_item').val(ui.item.id);
                $('#ip_barang').val(ui.item.label);
                //$('#ip_satuan').val(ui.item.satuan);
                Object.keys(ui.item.sat).forEach(function()
                {
                  $('#ip_satuan').append($('<option>', 
                  { 
                      value: ui.item.sat[key-1],
                      text : ui.item.satTxt[key-1]
                  }));
                  key++;
                });
                $('#ip_harga').val(convertDecimalToRupiah('0.00'));
                $('#ip_harga_total').val(convertDecimalToRupiah('0.00'));
                $("input[name='ipQty']").focus();
            }
        });
        $('#ip_satuan').empty();
        $('#ip_barang').val("");
        $('#ip_item').val("");
        $('#ip_qty').val("");
        $('#ip_harga').val("");
        $('#ip_harga_total').val("");
    });

    //event focus on input harga
    $(document).on('focus', '#ip_harga',  function(e){
        $(this).val("");
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#total_bayar',  function(e){
        $(this).val("");
        $('#button_save').attr('disabled', true);
    });

    //event onblur input harga
    $(document).on('blur', '#ip_harga',  function(e){
      if ($(this).val() == "") { $(this).val(0) };
      var harga = $(this).val();
      var qty = $('#ip_qty').val();
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qty * harga);
      $('#ip_harga_total').val(valueHargaTotal);
      //ubah format ke rupiah
      var hargaRp = convertToRupiah($(this).val());
      $(this).val(hargaRp);
      $('#button_save').attr('disabled', false);
    });

    //event onblur qty
    $(document).on('blur', '#ip_qty',  function(e){
      var qty = $(this).val();
      var harga = convertToAngka($('#ip_harga').val());
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qty * harga);
      $('#ip_harga_total').val(valueHargaTotal);
    });

    $(document).on('blur', '#total_bayar',  function(e){
      if ($(this).val() == "") { $(this).val(0) };
      var valueHargaByr = convertToRupiah($(this).val());
      $(this).val(valueHargaByr);
      $('#button_save').attr('disabled', false);
    });

    $(document).on('click', '.btn_remove', function(){
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
      totalPembelian();
    });

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    //validasi
    $("#form-belanja").validate({
      rules:{
        tanggalBeli: "required",
        noReff: "required",
        totalBiaya: "required",
        divisiPeminta: "required",
        keperluan: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $('#ip_harga').keypress(function(e) {
      if(e.which == 13)
      {
        if ($(this).val() == "") { $(this).val(0) };
        //call event #ip_harga.blur()
        $("#ip_harga").trigger( "blur" );
        //call function and focus ke form nama barang
        addItemRow();
        $('#ip_barang').focus();
        return false;  
      }
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      //reset all input txt field
      $('#form-master-barang')[0].reset();
      $('#form-master-satuan')[0].reset();
      //remove class all jquery validation error
      $('.form-group').find('.error').removeClass('error');
    });

    //=======================================jquery handling modal master barang========================================
    //mask money
    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
        radixPoint: ".",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }

    $(this).maskFunc();

    $('#code_group').change(function(){
      var id = $(this).val();
      var bid = $('#code_group').find(':selected').data('val');
      console.log(id);
      $.ajax({
         type: "get",
         url: '{{ route('kode_barang') }}',
         data: {id},
         success: function(data){
          $('#kode_barang').val(data);
         
         },
         error: function(){
        
         },
         async: false
      });
    });

    //event focus on isi_sat2
    $(document).on('focus', '#isi_sat2',  function(e){
      $('#harga_beli1').val('');
      $('#harga_beli2').val('');
      $('#harga_beli3').val('');
    });

    //event focus on isi_sat3
    $(document).on('focus', '#isi_sat3',  function(e){
      $('#harga_beli1').val('');
      $('#harga_beli2').val('');
      $('#harga_beli3').val('');
    });

    //event focus on harga_beli1
    $(document).on('focus', '#harga_beli1',  function(e){
      $(this).attr('readonly', false).val(0);
      $('#harga_beli2').attr('readonly', true).val(0);
      $('#harga_beli3').attr('readonly', true).val(0);
    });

    //event focus on harga_beli2
    $(document).on('focus', '#harga_beli2',  function(e){
      $(this).attr('readonly', false).val(0);
      $('#harga_beli1').attr('readonly', true).val(0);
      $('#harga_beli3').attr('readonly', true).val(0);
    });

    //event focus on harga_beli3
    $(document).on('focus', '#harga_beli3',  function(e){
      $(this).attr('readonly', false).val(0);
      $('#harga_beli1').attr('readonly', true).val(0);
      $('#harga_beli2').attr('readonly', true).val(0);
    });

    //event onblur harga beli1
    $(document).on('blur', '#harga_beli1',  function(e){
      var harga1 = $(this).val();
      harga1 = harga1.replace(/,/g, "");
      //console.log(parseFloat(harga1));
      var isi2 = $('#isi_sat2').val();
      var isi3 = $('#isi_sat3').val();
      var harga2 = parseFloat(harga1 * isi2);
      var harga3 = parseFloat(harga1 * isi3);
      $('#harga_beli2').val(harga2);
      $('#harga_beli3').val(harga3);
    });

    //event onblur harga beli2
    $(document).on('blur', '#harga_beli2',  function(e){
      //cari harga sat 1
      var harga2 = $(this).val();
      harga2 = harga2.replace(/,/g, "");
      var isi2 = $('#isi_sat2').val();
      var isi3 = $('#isi_sat3').val();
      var harga1 = parseFloat(harga2 / isi2);
      //cari harga sat 3
      var harga3 = parseFloat(harga1 * isi3);
      $('#harga_beli1').val(harga1);
      $('#harga_beli3').val(harga3);
    });

    //event onblur harga beli3
    $(document).on('blur', '#harga_beli3',  function(e){
      //cari harga sat 1
      var harga3 = $(this).val();
      harga3 = harga3.replace(/,/g, "");
      var isi2 = $('#isi_sat2').val();
      var isi3 = $('#isi_sat3').val();
      var harga1 = parseFloat(harga3 / isi3);
      //cari harga sat 2
      var harga2 = parseFloat(harga1 * isi2);
      $('#harga_beli1').val(harga1);
      $('#harga_beli2').val(harga2);
    });

    $('#change_function').on("click", "#save_barang",function(){
      var IsValid = $("form[name='formMasterBarang']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/purchasing/belanjaharian/simpan-barang",
          data: $('#form-master-barang').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                  $('#save_barang').text('Simpan Data');
                  $('#save_barang').attr('disabled',false);
                  $('#modal-barang').modal('hide');
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                  $('#save_barang').text('Simpan Data');
                  $('#save_barang').attr('disabled',false);
                  $('#modal-barang').modal('hide');
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    });

    //validasi
    $("#form-master-barang").validate({
      rules:{
          nama: "required",
          type: "required",
          code_group: "required",
          min_stock: "required",
          satuan1: "required",
          isi_sat1: "required",
          satuan2: "required",
          isi_sat2: "required",
          satuan3: "required",
          isi_sat3: "required",
          hargaBeli1: "required",
          hargaBeli2: "required",
          hargaBeli3: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    //=======================================jquery handling modal master barang========================================
    //validasi
    $("#form-master-satuan").validate({
      rules:{
        fnamaSat: "required",
        fketeranganSat: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

  //end jquery
  });

  function addItemRow() 
  {
    var i = randString(5);
    var no = 1;
    var ambilSatuanId = $("#ip_satuan option:selected").val();
    var ambilSatuanTxt = $("#ip_satuan option:selected").text();
    $('#ip_satuan').empty();
    var ambilIdBarang = $('#ip_item').val();
    var ambilBarang = $('#ip_barang').val();
    var ambilQty = $('#ip_qty').val();
    var ambilHarga = $('#ip_harga').val();
    var ambilHargaTotal = $('#ip_harga_total').val();
    if (ambilIdBarang == "" || ambilBarang == "" || ambilQty == "" || ambilSatuanId == "" ) 
    {
      iziToast.warning({
        position: 'center',
        title: 'Pemberitahuan',
        message: "Terdapat kolom yang kosong, dimohon cek lagi !"
      });
    } 
    else
    {
      $('#tabel-belanja').append('<tr class="tbl_form_row" id="row'+i+'">'
                                +'<td style="text-align:center">'+no+'</td>'
                                +'<td><input type="text" name="fieldIpBarang[]" value="'+ambilBarang+'" id="field_ip_barang" class="form-control" required readonly>'
                                +'<input type="hidden" name="fieldIpItem[]" value="'+ambilIdBarang+'" id="field_ip_item" class="form-control"></td>'
                                +'<td><input type="text" name="fieldIpQty[]" value="'+ambilQty+'" id="field_ip_qty" class="form-control" required readonly></td>'
                                +'<td><input type="text" name="fieldIpSatTxt[]" value="'+ambilSatuanTxt+'" id="field_ip_sat_txt" class="form-control" required readonly>'
                                +'<input type="hidden" name="fieldIpSatId[]" value="'+ambilSatuanId+'" id="field_ip_sat_id" class="form-control" required readonly></td>'
                                +'<td><input type="text" name="fieldIpHarga[]" value="'+ambilHarga+'" id="field_ip_harga" class="form-control" required readonly></td>'
                                +'<td><input type="text" name="fieldIpHargaTot[]" value="'+ambilHargaTotal+'" id="field_ip_harga_tot" class="form-control hargaTotalItem" required readonly></td>'
                                +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'
                                +'</tr>');
      i = randString(5);
      no++;
      //kosongkan field setelah append row
      $('#ip_satuan').val("");
      $('#ip_barang').val("");
      $('#ip_qty').val("");
      $('#ip_item').val("");
      $('#ip_harga').val("");
      $('#ip_harga_total').val("");
      totalPembelian();
    }
  }

  function save_satuan() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Simpan Master Satuan',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formMasterSatuan']").valid();
          if(IsValid)
          {
            $('#btn-simpan-satuan').text('Menyimpan...');
            $('#btn-simpan-satuan').attr('disabled',true); 
            $.ajax({
              url : baseUrl + "/purchasing/belanjaharian/simpan-satuan",
              type: "POST",
              dataType: "JSON",
              data: $('#form-master-satuan').serialize(),
              success: function(response)
              {
                if(response.status == "sukses")
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.success({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      $('#btn-simpan-satuan').text('Simpan Data'); //change button text
                      $('#btn-simpan-satuan').attr('disabled',false); //set button enable
                      $('#modal-satuan').modal('hide');
                    }
                  });
                }
                else
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.error({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      $('#btn-simpan-satuan').text('Simpan Data'); //change button text
                      $('#btn-simpan-satuan').attr('disabled',false); //set button enable
                      $('#modal-satuan').modal('hide');
                    }
                  }); 
                }
              },
              error: function(){
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.warning({
                  icon: 'fa fa-times',
                  message: 'Terjadi Kesalahan!'
                });
              },
              async: false
            });
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !"
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function simpanBelanja() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      zindex: 999,
      title: 'Simpan Belanja Harian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formBelanja']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item tr').length;
            if(countRow > 1)
            {
              $('#button_save').text('Menyimpan...');
              $('#button_save').attr('disabled',true); 
              $.ajax({
                url : baseUrl + "/purchasing/belanjaharian/simpan-data-belanja",
                type: "post",
                dataType: "JSON",
                data: $('#form-belanja').serialize(),
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#button_save').text('Simpan Data');
                        $('#button_save').attr('disabled',false);
                        window.location.href = baseUrl+"/purchasing/belanjaharian/belanja";
                      }
                    });
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.error({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#button_save').text('Simpan Data');
                        $('#button_save').attr('disabled',false);
                        window.location.href = baseUrl+"/purchasing/belanjaharian/belanja";
                      }
                    }); 
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              });
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                 position: 'center',
                 message: "Mohon isi data pada tabel form !"
              });
            }//end check count form table
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !"
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function tambahMasterBarang() 
  {
    $('#code_group').empty();
    $('#satuan_1').empty();
    $('#satuan_2').empty();
    $('#satuan_3').empty();
    $('#code_group').append($('<option>', { value: "", text : "- Pilih Data -" }));
    $('#satuan_1').append($('<option>', { value: "", text : "- Pilih Data -" }));
    $('#satuan_2').append($('<option>', { value: "", text : "- Pilih Data -" }));
    $('#satuan_3').append($('<option>', { value: "", text : "- Pilih Data -" }));
    $.ajax({
      url : baseUrl + "/purchasing/belanjaharian/get-data-masterbarang",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var key2 = 1;
        Object.keys(data.group).forEach(function(){
          $('#code_group').append($('<option>',
          {
            value: data.group[key-1].m_gcode,
            text : data.group[key-1].m_gname 
          }));

          key++;
        });

        Object.keys(data.satuan).forEach(function(){
          $('#satuan_1').append($('<option>',
          {
            value: data.satuan[key2-1].m_sid,
            text : data.satuan[key2-1].m_sname 
          }));

          $('#satuan_2').append($('<option>',
          {
            value: data.satuan[key2-1].m_sid,
            text : data.satuan[key2-1].m_sname 
          }));

          $('#satuan_3').append($('<option>',
          {
            value: data.satuan[key2-1].m_sid,
            text : data.satuan[key2-1].m_sname 
          }));
          
          key2++;
        });

        $('#modal-barang').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function tambahMasterSatuan() 
  {
    $.ajax({
      url : baseUrl + "/purchasing/belanjaharian/get-data-kodesatuan",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('#fkode_sat').val(data.kode);
        $('#modal-satuan').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
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

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertDiscToAngka(disc) {
    return parseInt(disc.replace('%', ''), 10);
  }

  function totalPembelian(){
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) {
        if(input.value == '') input.value = 0;
        return input.value;
    });
    console.log(hasil);
    var total = 0;
    for (var i = hasil.length - 1; i >= 0; i--)
    {
      hasil[i] = convertToAngka(hasil[i]);
      hasil[i] = parseInt(hasil[i]);
      total = total + hasil[i];
    }
    if (isNaN(total)) 
    {
      total=0;
    }

    total = convertToRupiah(total);
    $('[name="totalBiaya"]').val(total);
  }  
</script>
@endsection()