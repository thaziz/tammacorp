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
            <div class="page-title">Order Pembelian</div>
        </div>

        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Order Pembelian</li>
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

              <ul id="generalTab" class="nav nav-tabs ">
                <li class="active"><a href="#index-tab" data-toggle="tab">Order Pembelian</a></li>
                <!-- <li><a href="#note-tab" data-toggle="tab">Belanja Harian</a></li> -->
                <!--  <li><a href="#label-badge-tab" data-toggle="tab">Belanja Harian</a></li> -->
              </ul>

              <div id="generalTabContent" class="tab-content responsive">
                
                <!-- div index-tab -->  
                @include('purchasing.orderpembelian.tab-index')
                <!-- /div index-tab -->

              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- modal -->
      <!-- modal detail -->
      @include('purchasing.orderpembelian.modal')
      <!-- modal edit -->
      @include('purchasing.orderpembelian.modal-edit')
      <!-- /modal -->
  </div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  var save_method;
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    //add bootstrap class to datatable
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    $('#tbl-index').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/purchasing/orderpembelian/get-data-tabel-index",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglOrder", "width" : "10%"},
          {"data" : "d_pcs_code", "width" : "10%"},
          {"data" : "d_pcs_staff", "width" : "10%"},
          {"data" : "s_company", "width" : "13%"},
          {"data" : "d_pcs_method", "width" : "5%"},
          {"data" : "hargaTotalNet", "width" : "10%"},
          {"data" : "tglMasuk", "width" : "10%"},
          {"data" : "status", "width" : "7%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "15%"}
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

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_row');
      $('tr').remove('.tbl_modal_edit_row');
      //remove span class in modal detail
      $("#txt_span_status_detail").removeClass();
      $('#txt_span_status_edit').removeClass();
    });

    //event focus on input harga
    $(document).on('focus', '.field_harga',  function(e){
      var harga = convertToAngka($(this).val());
      $(this).val(harga);
    });

    $(document).on('focus', '#potongan_harga',  function(e){
        var potHarga = convertToAngka($(this).val());
        $(this).val(potHarga);
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#diskon_harga',  function(e){
        var discChar = convertToAngka($(this).val());
        $(this).val(discChar);
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#ppn_harga',  function(e){
        var ppnChar = convertToAngka($(this).val());
        $(this).val(ppnChar);
        $('#button_save').attr('disabled', true);
    });

    //event onblur input harga
    $(document).on('blur', '.field_harga',  function(e){
      var getid = $(this).attr("id");
      var harga = $(this).val();
      var qtyOrder = $('#qty_'+getid+'').val();
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qtyOrder * harga);
      //ubah format ke rupiah
      var hargaRp = convertToRupiah($(this).val());
      $(this).val(hargaRp);
      $('#total_'+getid+'').val(valueHargaTotal);
      totalPembelianGross();
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur potongan harga
    $(document).on('blur', '#potongan_harga',  function(e){
      //ubah format ke rupiah
      var potonganRp = convertToRupiah($(this).val());
      $(this).val(potonganRp);
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur diskon
    $(document).on('blur', '#diskon_harga',  function(e){
      //ubah format ke diskon
      var discSimbol = $(this).val();
      $(this).val(discSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur ppn
    $(document).on('blur', '#ppn_harga',  function(e){
      //ubah format ke diskon
      var ppnSimbol = $(this).val();
      $(this).val(ppnSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

  });

  function detailOrder(id) 
  {
    $('#append-modal-detail div').remove();
    $.ajax({
      url : baseUrl + "/purchasing/orderpembelian/get-data-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_detail').text(data.spanTxt);
        $("#txt_span_status_detail").addClass('label'+' '+data.spanClass);
        $('#lblNoOrder').text(data.header[0].d_pcs_code);
        $('#lblCaraBayar').text(data.header[0].d_pcs_method);
        $('#lblTglOrder').text(data.header[0].d_pcs_date_created);
        $('#lblTglKirim').text(data.header[0].d_pcs_date_received);
        $('#lblStaff').text(data.header[0].d_pcs_staff);
        $('#lblSupplier').text(data.header[0].s_company);
        $('[name="totalHarga"]').val(data.header2.hargaBruto);
        $('[name="diskonHarga"]').val(data.header2.nilaiDiskon);
        $('[name="ppnHarga"]').val(data.header2.nilaiPajak);
        $('[name="totalHargaFinal"]').val(data.header2.hargaNet);
        if (data.header[0].d_pcs_method != "CASH") 
        {
          $('#append-modal-detail div').remove();
          var metode = data.header[0].d_pcs_method;
          if (metode == "DEPOSIT") 
          {
            $('#append-modal-detail div').remove();
            $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">Batas Terakhir Pengiriman</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
          else if(metode == "CREDIT")
          {
            $('#append-modal-detail div').remove();
            $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">TOP (Termin Of Payment)</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
        }
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-order').append('<tr class="tbl_modal_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].i_sat1+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcsdt_qty+'</td>'
                          +'<td>'+data.data_stok[key-1].qtyStok+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_prevcost)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_price)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_total)+'</td>'
                          +'</tr>');
          key++;  
          i = randString(5);
        });
        $('#modal-detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editOrder(id) 
  {
    $('#append-modal-edit div').remove();
    $.ajax({
      url : baseUrl + "/purchasing/orderpembelian/get-edit-order/"+id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var totalHarga = 0;
        var key = 1;
        i = randString(5);
        $('#txt_span_status_edit').text(data.spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+data.spanClass);
        $('#id_purchase_edit').val(data.header[0].d_pcs_id);
        $('#lblNoOrderEdit').text(data.header[0].d_pcs_code);
        $('#lblCaraBayarEdit').text(data.header[0].d_pcs_method);
        $('#lblTglOrderEdit').text(data.header[0].d_pcs_date_created);
        $('#lblStaffEdit').text(data.header[0].d_pcs_staff);
        $('#lblTglKirimEdit').text(data.header[0].d_pcs_date_received);
        $('#lblSupplierEdit').text(data.header[0].s_company);
        $('#total_gross').val(convertDecimalToRupiah(data.header[0].d_pcs_total_gross))
        $('#potongan_harga').val(convertDecimalToRupiah(data.header[0].d_pcs_discount))
        $('#diskon_harga').val(data.header[0].d_pcs_disc_percent+'%')
        $('#ppn_harga').val(data.header[0].d_pcs_tax_percent+'%')
        $('#total_nett').val(convertDecimalToRupiah(data.header[0].d_pcs_total_net))
        if (data.header[0].d_pcs_method != "CASH") 
        {
          $('#append-modal-edit div').remove();
          var metode = data.header[0].d_pcs_method;
          if (metode == "DEPOSIT") 
          {
            $('#append-modal-edit div').remove();
            $('#append-modal-edit').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">Batas Terakhir Pengiriman</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
          else if(metode == "CREDIT")
          {
            $('#append-modal-edit div').remove();
            $('#append-modal-edit').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">TOP (Termin Of Payment)</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
        }
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          var qtyCost = data.data_isi[key-1].d_pcsdt_qty;
          $('#tabel-edit').append('<tr class="tbl_modal_edit_row">'
                            +'<td style="text-align:center">'+key+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" name="fieldNamaItem[]" class="form-control input-sm" readonly/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].i_id+'" name="fieldItemId[]" class="form-control input-sm"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_id+'" name="fieldIdPurchaseDt[]" class="form-control input-sm"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_idpdt+'" name="fieldIdPlanDt[]" class="form-control input-sm"/></td>'
                            +'<td><input type="text" value="'+qtyCost+'" name="fieldQty[]" class="form-control numberinput input-sm" id="qty_'+i+'" readonly/></td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].i_sat1+'" name="fieldSatuan[]" class="form-control input-sm" readonly/></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_prevcost)+'" name="fieldHargaPrev[]" class="form-control input-sm" readonly/></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_price)+'" name="fieldHarga[]" id="'+i+'" class="form-control input-sm field_harga numberinput"/></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_total)+'" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem" id="total_'+i+'" readonly/></td>'
                            +'<td><input type="text" value="'+data.data_stok[key-1].qtyStok+'" name="fieldStok[]" class="form-control input-sm" readonly/></td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                            +'</tr>');
          i = randString(5);
          key++;
        });
        $('#modal-edit').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function submitEdit()
  {
    if(confirm('Update Data ?'))
    {
        $('#btn_update').text('Updating...'); //change button text
        $('#btn_update').attr('disabled',true); //set button disable 
        $.ajax({
            url : baseUrl + "/purchasing/orderpembelian/update-data-order",
            type: "post",
            dataType: "JSON",
            data: $('#form-edit-order').serialize(),
            success: function(response)
            {
                if(response.status == "sukses")
                {
                    alert(response.pesan);
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tbl-index').DataTable().ajax.reload();
                }
                else
                {
                    alert(response.pesan);
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tbl-index').DataTable().ajax.reload();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error updating data');
            }
        });
    }
  }

  function deleteOrder(idPo, idPlan) 
  {
    if(confirm('Yakin hapus data ?'))
    {
      $.ajax({
        url : baseUrl + "/purchasing/orderpembelian/delete-data-order",
        type: "POST",
        dataType: "JSON",
        data: {idPo:idPo, idPlan:idPlan, "_token": "{{ csrf_token() }}"},
        success: function(response)
        {
          if(response.status == "sukses")
          {
            alert(response.pesan);
            $('#tbl-index').DataTable().ajax.reload();
          }
          else
          {
            alert(response.pesan);
            $('#tbl-index').DataTable().ajax.reload();
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error updating data');
        }
      });
    }
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
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

  function convertIntToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) 
      if(i%3 == 0) 
        rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function totalPembelianGross(){
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) {
        if(input.value == '') input.value = 0;
        return input.value;
    });
    console.log(hasil);
    var total = 0;
    for (var i = hasil.length - 1; i >= 0; i--){

      hasil[i] = convertToAngka(hasil[i]);
      hasil[i] = parseInt(hasil[i]);
      total = total + hasil[i];
    }
      if (isNaN(total)) {
          total=0;
        }
    total = convertToRupiah(total);
    // console.log(total);
    $('[name="totalGrossEdit"]').val(total);
  }

  function totalPembelianNett() 
  {
    var totalGross = convertToAngka($('#total_gross').val());
    var potongan = convertToAngka($('#potongan_harga').val());
    var disc = convertDiscToAngka($('#diskon_harga').val());
    var tax = convertDiscToAngka($('#ppn_harga').val());
    var discValue = totalGross * disc / 100;
    //var taxValue = totalGross * tax / 100;
    //hitung total pembelian nett
    var hasilNett = (parseInt(totalGross) - parseInt(potongan + discValue));
    var taxValue = hasilNett * tax / 100;
    var finalValue = parseInt(hasilNett + taxValue);
    // $('#total_nett').val(convertToRupiah(finalValue));
    // var hasilNett = (parseInt(totalGross) - (parseInt(potongan + discValue)) + taxValue);
    $('[name="totalNettEdit"]').val(convertToRupiah(finalValue));
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



</script>
@endsection()