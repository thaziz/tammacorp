@extends('main')
@section('content')

<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Master Data Barang</div>
    </div>
    
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Data Barang</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Barang&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
    </ol>
    
    <div class="clearfix"></div>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Barang</a></li>
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Master Data Barang</h4>
                  </div>
                  
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/databarang/barang') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form id="form-save">
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <input type="hidden" name="kode_old" value="{{ $data_item->i_id }}">
                      
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Kode Barang</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="kode_barang" name="kode_barang" value="{{ $data_item->i_code }}" readonly="" class="form-control input-sm">                                  
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Nama</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="nama" name="nama" value="{{ $data_item->i_name }}" class="form-control input-sm">                               
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <label class="tebal">Type Barang</label>
                      </div>

                      <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <select class="form-control disabled_select" name="type" id="type" >
                            <option selected="">- Pilih Dahulu -</option>
                            <option @if ($data_item->i_type == 'BB') selected="" @endif value="BB">BAHAN BAKU</option>
                            <option @if ($data_item->i_type == 'BJ') selected="" @endif value="BJ">BAHAN JUAL</option>
                            <option @if ($data_item->i_type == 'BP') selected="" @endif value="BP">BAHAN PRODUKSI</option>
                          </select>                               
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Kelompok</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control disabled_select" name="code_group"> 
                            @foreach ($group as $g)
                              @if ($g->m_gcode == $data_item->i_code_group)
                                <option readonly value="{{ $g->m_gcode }}" data-name="{{ $g->m_gname }}" selected="">{{ $g->m_gcode }} - {{ $g->m_gname }}</option>
                              @else
                                <option value="{{ $g->m_gcode }}" data-name="{{ $g->m_gname }}">{{ $g->m_gcode }} - {{ $g->m_gname }}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Min Stock</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="min_stock" name="min_stock" value="{{ $min_stock->qtyStokMin }}" class="form-control input-sm">                               
                        </div>
                      </div>
                      
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Satuan Utama</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control" name="satuan1">
                            <option value="">- Pilih -</option>
                            @foreach ($satuan as $element)
                              @if ($element->m_sid == $data_item->i_sat1)
                                <option selected value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                              @else
                                <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Isi Sat Utama</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="isi_sat1" name="isi_sat1" value="{{ $data_item->i_sat_isi1 }}" class="form-control input-sm" readonly>                               
                        </div>
                      </div>
                      {{-- satuan 1 --}}

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Satuan Alternatif 1</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control" name="satuan2">
                            <option value="">- Pilih -</option>
                            @foreach ($satuan as $element)
                              @if ($element->m_sid == $data_item->i_sat2)
                                <option selected value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                              @else
                                <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Isi Sat Alternatif 1</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="isi_sat2" name="isi_sat2" value="{{ $data_item->i_sat_isi2 }}" class="form-control input-sm" placeholder="Qty terhadap satuan utama">                               
                        </div>
                      </div>
                      {{-- satuan 2 --}}

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Satuan Alternatif 2</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control" name="satuan3">
                            <option value="">- Pilih -</option>
                            @foreach ($satuan as $element)
                              @if ($element->m_sid == $data_item->i_sat3)
                                  <option selected value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                              @else
                                  <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Isi Sat Alternatif 2</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="isi_sat3" name="isi_sat3" value="{{ $data_item->i_sat_isi3 }}" class="form-control input-sm" placeholder="Qty terhadap satuan utama">                               
                        </div>
                      </div>
                    
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Harga</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="harga_beli1" name="hargaBeli1" value="{{ $data_price->m_pbuy1 }}" class="form-control input-sm currency" readonly>                               
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="harga_beli2" name="hargaBeli2" class="form-control input-sm currency" readonly value="{{ $data_price->m_pbuy2 }}">                               
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <input type="text" id="harga_beli3" name="hargaBeli3" class="form-control input-sm currency" readonly value="{{ $data_price->m_pbuy3 }}">                               
                        </div>
                      </div>
                      
                      <div class="col-xs-12">
                        <label class="tebal"></label>
                      </div>

                      <div class="col-xs-12">
                        <label class="tebal"></label>
                      </div>
                      
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Detail</label>
                      </div>
                      
                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <textarea class="form-control input-sm" name="detail">{{ $data_item->i_det }}</textarea>
                        </div>
                      </div>
                    </div> 
              
                    <div align="right" id="change_function">
                      <input type="button" name="tambah_data" value="Simpan Data" id="save_data" class="btn btn-primary">
                    </div>   
                  </form>
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
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  $( document ).ready(function() {
      //mask money
      $.fn.maskFunc = function(){
          $('.currency').inputmask("currency", {
              radixPoint: ",",
              groupSeparator: ".",
              digits: 2,
              autoGroup: true,
              prefix: '', //Space after $, this will not truncate the first character.
              rightAlign: false,
              oncleared: function () { self.Value(''); }
          });
        }

      $(this).maskFunc();

      //mengembalikan format desimal ke bentuk int bulat
      var sat1= Math.round($('#isi_sat1').val());
      var sat2 = Math.round($('#isi_sat2').val());
      var sat3 = Math.round($('#isi_sat3').val());
      $('#isi_sat1').val(sat1);
      $('#isi_sat2').val(sat2);
      $('#isi_sat3').val(sat3);

      //event focus on isi_sat3
      $(document).on('focus', '#isi_sat2',  function(e){
        $('#isi_sat2').attr('readonly', false);
        $('#isi_sat3').attr('readonly', false);
        $('#harga_beli1').val('').attr('readonly', true);
        $('#harga_beli2').val('');
        $('#harga_beli3').val('');
      });

      //event focus on isi_sat3
      $(document).on('focus', '#isi_sat3',  function(e){
        $('#isi_sat2').attr('readonly', false);
        $('#isi_sat3').attr('readonly', false);
        $('#harga_beli1').val('').attr('readonly', true);
        $('#harga_beli2').val('');
        $('#harga_beli3').val('');
      });

      //event onblur harga isi_sat3
      $(document).on('blur', '#isi_sat3',  function(e){
        $('#harga_beli1').attr('readonly', false);
      });

      //event focus on harga beli1
      $(document).on('focus', '#harga_beli1',  function(e){
        $('#isi_sat2').attr('readonly', true);
        $('#isi_sat3').attr('readonly', true);
      });

      //event onblur harga beli1
      $(document).on('blur', '#harga_beli1',  function(e){
        var harga1 = convertToAngka($(this).val());
        // console.log(harga1);
        var isi2 = $('#isi_sat2').val();
        var isi3 = $('#isi_sat3').val();
        var harga2 = parseInt(harga1 * isi2);
        var harga3 = parseInt(harga1 * isi3);
        // console.log(harga2);
        // console.log(harga3);
        $('#harga_beli2').val(harga2);
        $('#harga_beli3').val(harga3);
      });
  });
  
  $("#nama").load("/master/databarang/tambah_barang", function(){
      $("#nama").focus();
  });

  $('#tgl_lahir').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
  });


  $('#change_function').on("click", "#save_data",function(){
  $.ajax({
       type: "get",
       url: '{{ route('update_barang') }}',
       data: $('#form-save').serialize(),
       success: function(response)
       {
        if(response.status == "sukses")
        {
          toastr.success(response.pesan, 'Pemberitahuan');
          window.location=('{{ route('barang') }}');
        }
        else
        {
          toastr.error(response.pesan, 'Pemberitahuan'); 
          window.location=('{{ route('barang') }}');
        }
       },
       error: function(){
        
       },
       async: false
     });
  });

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

</script>
@endsection                            
