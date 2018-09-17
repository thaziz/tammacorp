@extends('main')

@section('extra_styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/datepicker/datepicker.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/toast/dist/jquery.toast.min.css') }}">

    <style>
      .mb-3{
        margin-bottom: 15px;
      }
    </style>
@endsection

@section('content')

  <div id="vue-element">
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Form Data Transaksi Keuangan</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Master Data Transaksi Keuangan</li>
              <li><i class="fa fa-angle-right"></i>&nbsp;Form Data Transaksi Keuangan&nbsp;&nbsp;&nbsp;&nbsp;</li>
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
                <li class="active"><a href="#alert-tab" data-toggle="tab">Form Data Transaksi Keuangan</a></li>
                  <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                  <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
              </ul>

              <div id="generalTabContent" class="tab-content responsive">
                <div id="alert-tab" class="tab-pane fade in active">
                
                  <div class="row">
                   
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;"> 
                       <div class="col-md-5 col-sm-6 col-xs-8">
                         <h4>Form Data Transaksi Keuangan</h4>
                       </div>
                       <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                         <a href="{{ url('master/keuangan/master_transaksi') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                       </div>
                    </div>
                 
                    <hr>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form id="data-form">
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:15px;margin-bottom: 20px; padding-bottom:5px;padding-top: 15px; ">    

                          <div class="col-md-2 col-sm-3 col-xs-12">
                                <label class="tebal">Nama Transaksi</label>
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <input type="text" id="nama" name="nama" class="form-control input-sm" placeholder="Masukkan Nama" required>
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-3 col-xs-12">
                                <label class="tebal">Cash Flow</label>
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <select class="form-control input-sm" name="cash_flow" id="cash_flow">                        
                                <option value="-">Tidak Ada Cash Flow</option>                                    
                                <option value="O" >Operating Cash Flow</option>                                    
                                <option value="F">Financing Cash Flow</option>                                    
                                <option value="I">Investing Cash Flow</option>
                              </select>                                  
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-3 col-xs-12">
                              <label class="tebal">Transaksi Type</label>
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <select class="form-control input-sm" name="type" id="type">                                 
                                <option value="KM">Kas Masuk</option>                                     
                                <option value="KK" >Kas Keluar</option>                                  
                                <option value="BM">Bank Masuk</option>                              
                                <option value="BK">Bank Keluar</option>                              
                                <option value="MM">Memorial</option>
                              </select>                                  
                            </div>
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="margin-top:5px;margin-bottom: 0px; padding-bottom:0px;padding-top: 5px; ">
                            <button class="btn btn-xs btn-primary" @click="add_akun"><i class="fa fa-plus fa-fw"></i></button>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:15px;margin-bottom: 20px; padding-bottom:5px;padding-top: 15px; ">
                            <div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Pilih Akun</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control input-sm" name="akun_[]" id="akun_1">
                                    <option :value="data_akun.id_akun" v-for="data_akun in akun">@{{ data_akun.id_akun+' - '+data_akun.nama_akun }}</option>
                                  </select> 
                                </div>                                 
                              </div>

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Debet/Kredit</label>
                              </div>
                              <div class="col-md-3 col-sm-8 col-xs-11">
                                <div class="form-group">
                                  <select class="form-control input-sm" name="akun_dka[]" id="akun_dka_1">
                                    <option value="D" >Debet</option>
                                  </select> 
                                </div>                                 
                              </div>
                            </div>

                            <div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Pilih Akun</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control input-sm" name="akun_[]" id="akun_2">
                                    <option :value="data_akun.id_akun" v-for="data_akun in akun">@{{ data_akun.id_akun+' - '+data_akun.nama_akun }}</option>
                                  </select> 
                                </div>                                 
                              </div>

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Debet/Kredit</label>
                              </div>
                              <div class="col-md-3 col-sm-8 col-xs-11">
                                <div class="form-group">
                                  <select class="form-control input-sm" name="akun_dka[]" id="akun_dka_2">
                                    <option value="K" >Kredit</option>
                                  </select> 
                                </div>                                 
                              </div>
                            </div>

                            <div v-for="(n, idx) in akun_next" v-if="n > 2" :id="'akun_'+n">
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Pilih Akun</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control input-sm" name="akun_[]">
                                    <option :value="data_akun.id_akun" v-for="data_akun in akun">@{{ data_akun.id_akun+' - '+data_akun.nama_akun }}</option>
                                  </select> 
                                </div>                                 
                              </div>

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Debet/Kredit</label>
                              </div>
                              <div class="col-md-3 col-sm-8 col-xs-11">
                                <div class="form-group">
                                  <select class="form-control input-sm" name="akun_dka[]" >
                                    <option value="D" >Debet</option>
                                    <option value="K" >Kredit</option>
                                  </select> 
                                </div>                                 
                              </div>

                              <div class="col-md-1">
                                <button class="btn btn-xs btn-danger" @click="delete_akun(n)" type="button" :disabled="btn_save_disabled"><i class="fa fa-eraser"></i></button>
                              </div>
                            </div>
                        </div>

                  
                        <div class="form-group" align="right">
                          <input type="button" name="tambah_data" value="Simpan Data" class="btn btn-danger" @click="simpan" :disabled="btn_save_disabled">
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
  </div>
                            
@endsection
@section("extra_scripts")

  <script src="{{ asset("js/chosen/chosen.jquery.js") }}"></script>
  <script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
  <script src="{{ asset("js/datepicker/datepicker.js") }}"></script>
  <script src="{{ asset("js/vue/vue.js") }}"></script>
  <script src="{{ asset("js/axios/dist/axios.min.js") }}"></script>
  <script src="{{ asset("js/validator/bootstrapValidator.min.js") }}"></script>
  <script src="{{ asset("js/toast/dist/jquery.toast.min.js") }}"></script>

  <script type="text/javascript">     
      function register_validator(){
        $('#data-form').bootstrapValidator({
            feedbackIcons : {
              valid : 'glyphicon glyphicon-ok',
              invalid : 'glyphicon glyphicon-remove',
              validating : 'glyphicon glyphicon-refresh'
            },
            fields : {
              nama : {
                validators : {
                  notEmpty : {
                    message : 'Nama Transaksi Tidak Boleh Kosong',
                  }
                }
              },

            }
          });
      }

      var vm = new Vue({
        el: '#vue-element',
        data: {
          baseUrl: '{{ url('/') }}',
          akun_next: 2,
          btn_save_disabled: false,
          akun: [],
        },

        mounted: function(){
          register_validator();
          $('.overlay.main').fadeIn(200);
          $('#load-status-text').text('Harap Tunggu. Sedang Menyiapkan Form');
          console.log('vue ready');
        },

        created: function(){
          axios.get(this.baseUrl+'/master/keuangan/master_transaksi/form_resource')
              .then((response) => {
                console.log(response.data);
                this.akun = response.data;
                $('.overlay.main').fadeOut(200);
              }).catch(err => {
                 $('#load-status-text').text('Sistem Bermasalah. Cobalah Memuat Ulang Halaman');
              }).then(() => {
                // this.getTransaksi();
              })
        },

        methods: {
          add_akun: function(){
            this.akun_next++;
          },

          delete_akun: function(alpha){
            $('#akun_'+alpha).remove();
          },

          simpan:function(evt){
            evt.preventDefault();
            this.btn_save_disabled = true;

            if($('#nama').val() == ""){
              $.toast({
                  text: 'Nama Transaksi Tidak Boleh Kosong.',
                  showHideTransition: 'slide',
                  hideAfter: false,
                  position: 'top-right',
                  icon: 'error'
              })
              this.btn_save_disabled = false;
              return false;
            }

            // if($('#data-form').data('bootstrapValidator').validate().isValid()){
              axios.post(this.baseUrl+'/master/keuangan/master_transaksi/save', 
                $('#data-form').serialize()
              ).then((response) => {
                console.log(response.data);
                if(response.data.status == 'berhasil'){
                  $.toast({
                      text: 'Data Master Transaksi Berhasil Disimpan.',
                      showHideTransition: 'slide',
                      position: 'top-right',
                      icon: 'success'
                  })

                  this.form_reset();
                }
              }).catch((err) => {
                alert(err);
                this.btn_save_disabled = false;
              }).then(() => {
                this.btn_save_disabled = false;
              })
            // }
          },

          form_reset: function(){

            this.akun_next = 2;
            $('#nama').val('');
            $('#cash_flow').val('-');
            $('#type').val('KM');

            $('#akun_1').val($('#akun_1').children('option').first().attr('value'));
            $('#akun_2').val($('#akun_2').children('option').first().attr('value'));
            $('#data-form').data('bootstrapValidator').resetForm();
          }
        }
      })
  </script>

@endsection                            
