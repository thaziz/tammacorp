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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Barang</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
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

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Kode Barang</label>

                                </div>
                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="kode_barang" name="kode_barang" placeholder="PILIH GROUP DAHULU" readonly="" class="form-control input-sm">
                                  </div>
                                </div>



                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Nama<font color="red">*</font></label>

                                </div>
                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="nama" name="nama" class="form-control input-sm">
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Kelompok<font color="red">*</font></label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <select class="input-sm form-control" name="code_group" id="code_group">
                                        <option selected value="">- Pilih -</option>
                                        @foreach ($group as $g)
                                          <option value="{{ $g->m_gcode }}" data-val="{{ $g->m_gname }}" >{{ $g->m_gcode }} - {{ $g->m_gname }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                </div>

                                <input type="hidden" name="group" id="group">

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Min Stock</label>

                                </div>
                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="min_stock" name="min_stock" class="form-control input-sm">
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
                                          <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
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
                                          <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
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
                                          <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                                        @endforeach

                                      </select>
                                  </div>
                                </div>

                                <div class="col-xs-12">

                                      <label class="tebal"></label>

                                </div>

                        </div>

                          <div align="right">
                            {{-- <button name="tambah_data" id="save_item" class="btn btn-primary" onclick="simpanItem()">Simpan Data</button> --}}
                            <button type="button" name="button" id="save_item" class="btn btn-primary" onclick="simpanItem()">Simpan Data</button>
                          </div>

                      </form>
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

        //event focus on isi_sat3
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

    });


      $("#nama").load("/master/databarang/tambah_barang", function(){
          $("#nama").focus();
      });


  function simpanItem(){
    // alert('s');
    $.ajaxSetup({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
    $('#save_item').attr('disabled','disabled');
    var a = $('#form-save').serialize();
    $.ajax({
      url : baseUrl + "/master/itemproduksi/simpan_item",
      type: 'POST',
      data: a,
      success:function(response){
        if (response.status=='sukses') {
          iziToast.success({timeout: 5000,
                          position: "topRight",
                          icon: 'fa fa-chrome',
                          title: '',
                          message: 'Item Produksi tersimpan.'});
          $('#form-save')[0].reset();
          $('#save_item').removeAttr('disabled','disabled');
        }else{
          iziToast.error({position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'});
          $('#save_item').removeAttr('disabled','disabled');
        }
      }
     })
    }

      $('#type').change(function(){
          var id = $(this).val();
          $.ajax({
             type: "get",
             url: '{{ route('cari_group_barang') }}',
             data: {id},
             success: function(data){
              console.log(data);
              var array_change = '<option selected >- Pilih -</option>';
              $.each(data, function(i, item) {
                array_change += '<option value="'+data[i].m_gcode+'" data-val="'+data[i].m_gname+'" >'+data[i].m_gcode+' - '+data[i].m_gname+'</option>';
              });
              $('#code_group').html(array_change);
             },
             error: function(){

             },
             async: false
           });
      })

      function convertToAngka(rupiah)
      {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
      }
</script>
@endsection
