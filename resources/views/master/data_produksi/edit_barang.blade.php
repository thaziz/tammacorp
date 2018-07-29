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
                    <a href="{{ url('/master/itemproduksi/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form id="form-save">
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <input type="hidden" name="kode_old" id="id_item" value="{{ $data_item->i_id }}">
                      
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Kode Barang</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="kode_barang" name="kode_barang" value="{{ $data_item->i_code }}" readonly="" class="form-control input-sm">                                  
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Nama<font color="red">*</font></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="nama" name="nama" value="{{ $data_item->i_name }}" class="form-control input-sm">                               
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
                    {{--   {{ dd($min_stock) }} --}}
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Min Stock</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="number" id="min_stock" name="min_stock" 

                          @if ($min_stock == null)
                            value="0" 
                          @else
                          value="{{ $min_stock->s_qty_min }}" 
                          @endif
                          class="form-control input-sm text-right">                               
                        </div>
                      </div>
                      
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Satuan Utama<font color="red">*</font></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
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
                        <label class="tebal">Satuan Alternatif 1</label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
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
                        <label class="tebal">Satuan Alternatif 2</label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
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
                      
                      <div class="col-xs-12">
                        <label class="tebal"></label>
                      </div>

                      <div class="col-xs-12">
                        <label class="tebal"></label>
                      </div>
                      
                    </div> 
                  </form>
                    <div align="right" id="change_function">
                      <button name="tambah_data" class="btn btn-primary" id="updateItem" onclick="updateItem()">Update Data</button>
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
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  $( document ).ready(function() {

  });
  
  $("#nama").load("/master/databarang/tambah_barang", function(){
      $("#nama").focus();
  });

  function updateItem(){
    $('#updateItem').attr('disabled','disabled');
    $.ajaxSetup({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
    var a = $('#id_item').val();
    var b = $('#form-save').serialize();
    $.ajax({
      url : baseUrl + "/master/itemproduksi/update_item/"+a,
      type: 'GET',
      data: b,
      success:function(response){
        if (response.status=='sukses') {
          iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: '', 
                          message: 'Item berhasil tersimpan.'});
          window.location.href = baseUrl + "/master/itemproduksi/index";
        }else{
          iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Item gagal tersimpan.'});
          $('#updateItem').removeAttr('disabled','disabled');
        }
      }
     })
  }



</script>
@endsection                            
