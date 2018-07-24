@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
  .select2-container { margin: 0; }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
        <div class="page-title">Return Pembelian</div>
    </div>

    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Return Pembelian</li>
    </ol>

    <div class="clearfix">
    </div>
  </div>

  <div class="page-content fadeInRight">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">
                    
          <div class="col-md-12">
              <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;"></div>
          </div>
                    
          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#alert-tab" data-toggle="tab">Return Pembelian</a></li>
          <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
          <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>

          <div id="generalTabContent" class="tab-content responsive" >
            <div id="alert-tab" class="tab-pane fade in active">
            <div class="row">
          <div class="col-lg-12">
          
          <div class="pull-right" style="margin-bottom: 10px;">
            <a href="{{ url('purchasing/returnpembelian/tambah-return') }}">
              <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                <i class="fa fa-plus" aria-hidden="true">&nbsp;</i>
                Tambah Data
              </button>
            </a>
          </div>

          <div class="table-responsive">
            <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel-return">
              <thead>
                <tr>
                  <th class="wd-5p">No.</th>
                  <th class="wd-10p">Tgl Return</th>
                  <th class="wd-15p">ID Return</th>
                  <th class="wd-10p">Staff</th>
                  <th class="wd-10p">Metode</th>
                  <th class="wd-15p">Supplier</th>
                  <th class="wd-15p">Total Retur</th>
                  <th class="wd-15p">Status</th>
                  <th class="wd-15p">Aksi</th>
                </tr>
              </thead>

              <tbody>                 
              </tbody>
            </table> 
          </div>
              
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
    <!--modal detail-->
    @include('purchasing.returnpembelian.modal-detail')
    <!--modal edit-->
    @include('purchasing.returnpembelian.modal-edit')
 <!-- /modal -->
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
    });//datepicker("setDate", "0");

    $('#tabel-return').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/purchasing/returnpembelian/get-data-return-pembelian",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBuat", "width" : "10%"},
          {"data" : "d_pcsr_code", "width" : "10%"},
          {"data" : "d_pcs_staff", "width" : "10%"},
          {"data" : "metode", "width" : "10%"},
          {"data" : "s_company", "width" : "15%"},
          {"data" : "hargaTotal", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
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

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    $(document).on('click', '.btn_remove', function(){
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
      totalNilaiReturn();
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_edit_row');
      //remove span class in modal detail
      $("#txt_span_status").removeClass();
      $('#txt_span_status_edit').removeClass();
    });

    //event focus on input qty
    $(document).on('focus', '.field_qty',  function(e){
        var qty = $(this).val();
        $(this).val(qty);
        $('#button_save').attr('disabled', true);
    });

    //event onblur input qty
    $(document).on('blur', '.field_qty',  function(e){
      var getid = $(this).attr("id");
      var qtyReturn = $(this).val();
      //alert(qtyReturn);
      var cost = $('#costRaw_'+getid+'').val();
      var hasilTotal = parseInt(qtyReturn * cost);
      var totalCost = $('#total_'+getid+'').val(convertDecimalToRupiah(hasilTotal));
      // $(this).val(potonganRp);
      totalNilaiReturn();
      $('#button_save').attr('disabled', false);
    });

  //end jquery
  });

  function detailReturPembelian(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/returnpembelian/get-data-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_detail').text(data.spanTxt);
        $("#txt_span_status_detail").addClass('label'+' '+data.spanClass);
        $('#lblNotaPembelian').text(data.header[0].d_pcs_code);
        $('#lblCodeReturn').text(data.header[0].d_pcsr_code);
        $('#lblTglReturn').text(data.header2.tanggalReturn);
        $('#lblStaff').text(data.header[0].d_pcs_staff);
        $('#lblSupplier').text(data.header[0].s_company);
        $('#lblMetode').text(data.lblMethod);
        $('#lblTotalReturn').text(data.header2.hargaTotalReturn);
        // $('[name="totalHarga"]').val(data.header2.hargaBruto);
        // $('[name="diskonHarga"]').val(data.header2.nilaiDiskon);
        // $('[name="ppnHarga"]').val(data.header2.nilaiPajak);
        // $('[name="totalHargaFinal"]').val(data.header2.hargaNet);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcsrdt_qty+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_price)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_pricetotal)+'</td>'
                          +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
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

  function editReturPembelian(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/returnpembelian/get-data-detail/"+id+"/all",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_edit').text(data.spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+data.spanClass);
        $('#lblCodeReturnEdit').text(data.header[0].d_pcsr_code);
        $('#lblNotaPembelianEdit').text(data.header[0].d_pcs_code);
        $('#lblTglReturnEdit').text(data.header2.tanggalReturn);
        $('#lblStaffEdit').text(data.header[0].d_pcs_staff);
        $('#lblSupplierEdit').text(data.header[0].s_company);
        $('#lblMetodeEdit').text(data.lblMethod);
        $('#lblTotalReturnEdit').text(data.header2.hargaTotalReturn);
        $('#id_return').val(data.header[0].d_pcsr_id);
        $('#id_sup').val(data.header[0].d_pcsr_supid);
        $('#code_return').val(data.header[0].d_pcsr_code);
        $('#method_return').val(data.header[0].d_pcsr_method);
        $('#price_total').val(data.header[0].d_pcsr_pricetotal);
        $('#price_total_nett').val(data.header[0].d_pcs_total_net);
        $('#price_result').val(data.header[0].d_pcsr_priceresult);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          var qtyCost = data.data_isi[key-1].d_pcsrdt_qty;
          var hargaSatuanItemNet = data.data_isi[key-1].d_pcsrdt_price
          var hargaTotalItemNet = Math.round(parseFloat(qtyCost * hargaSatuanItemNet).toFixed(2));
          //console.log(hargaSatuanItemNet);
          $('#tabel-edit').append('<tr class="tbl_modal_edit_row" id="row'+i+'">'
                          +'<td style="text-align:center">'+key+'</td>'
                          +'<td><input type="text" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" name="fieldNamaItem[]" class="form-control" readonly/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_item+'" name="fieldIdItem[]" class="form-control" readonly/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_id+'" name="fieldIdDt[]" class="form-control"/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_smdetail+'" name="fieldSmidDetail[]" class="form-control"/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_qty+'" name="fieldQtyLalu[]" class="form-control"/></td>'
                          +'<td><input type="text" value="'+qtyCost+'" name="fieldQty[]" class="form-control field_qty numberinput input-sm" id="'+i+'"/></td>'
                          +'<td><input type="text" value="'+data.data_isi[key-1].m_sname+'" name="fieldSatuanTxt[]" class="form-control input-sm" readonly/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].m_sid+'" name="fieldSatuanId[]" class="form-control input-sm" readonly/></td>'
                          +'<td><input type="text" value="'+convertDecimalToRupiah(hargaSatuanItemNet)+'" name="fieldHarga[]" class="form-control input-sm" id="cost_'+i+'" readonly/>'
                          +'<input type="hidden" value="'+hargaSatuanItemNet+'" name="fieldHargaRaw[]" id="costRaw_'+i+'" class="form-control input-sm field_harga_raw numberinput" readonly/></td>'
                          +'<td><input type="text" value="'+convertDecimalToRupiah(hargaTotalItemNet)+'" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem" id="total_'+i+'" readonly/></td>'
                          +'<td><input type="text" value="'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'" name="fieldStokTxt[]" class="form-control input-sm" readonly/>'
                          +'<input type="hidden" value="'+data.data_stok[key-1].qtyStok+'" name="fieldStokVal[]" class="form-control input-sm" readonly/></td>'
                          +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                          +'</tr>');
          i = randString(5);
          key++;
        });
        totalNilaiReturn();
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
            url : baseUrl + "/purchasing/returnpembelian/update-data-return",
            type: "POST",
            dataType: "JSON",
            data: $('#form-edit-return').serialize(),
            success: function(response)
            {
                if(response.status == "sukses")
                {
                    alert(response.pesan);
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tabel-return').DataTable().ajax.reload();
                }
                else
                {
                    alert(response.pesan);
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tabel-return').DataTable().ajax.reload();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error updating data');
            }
        });
    }
  }

  function deleteReturPembelian(id) 
  {
    if(confirm('Yakin hapus data ?'))
    {
        $.ajax({
            url : baseUrl + "/purchasing/returnpembelian/delete-data-return",
            type: "POST",
            dataType: "JSON",
            data: {id:id, "_token": "{{ csrf_token() }}"},
            success: function(response)
            {
                if(response.status == "sukses")
                {
                    alert(response.pesan);
                    $('#tabel-return').DataTable().ajax.reload();
                }
                else
                {
                    alert(response.pesan);
                    $('#tabel-return').DataTable().ajax.reload();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
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

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function totalNilaiReturn()
  {
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) 
    {
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
    $('#lblTotalReturnEdit').text(total);
    $('#price_total').val(total);
  }

</script>
@endsection