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
            <!--BEGIN PAGE WRAPPER-->
            <div id="vue-element">
              <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Input Data Transaksi Kas</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Input Transaksi Kas</li>
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
                            {{-- <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Akun Keuangan</a></li> --}}
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                          </ul>

                          <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                              <div class="row">
                                <div class="col-md-12" style="margin-top: -10px;margin-bottom: 20px;">
                                   <div class="col-md-5 col-sm-6 col-xs-8">
                                     <h4>Transaksi Kas</h4>
                                   </div>
                                   <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                     <a href="{{ url('master/datakeuangan/keuangan') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                   </div>
                                </div>

                                <hr>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form id="data-form">
                                      <input type="hidden" value="{{csrf_token()}}" name="_token" readonly>
                                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">

                                        <div class="col-md-6" style="padding: 0px;">
                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Jenis Transaksi</label>
                                            </div>
                                            <div class="col-md-6 col-sm-8 col-xs-11 mb-3">
                                              <select class="form-control" name="jenis_transaksi" id="jenis_transaksi" name="jenis_transaksi" v-model="single_data.jenis_transaksi">
                                                <option value="KM">Kas Masuk</option>
                                                <option value="KK">Kas Keluar</option>
                                              </select>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;"> 
                                              <i class="fa fa-search"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Tanggal Transaksi</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <datepicker :placeholder="'Plih Tanggal Transaksi'" :name="'tanggal_transaksi'" :id="'tanggal_transaksi'"></datepicker>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nama Transaksi</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <input type="text" name="nama_transaksi" class="form-control" placeholder="Nama Transaksi" v-model="single_data.nama_transaksi" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Keterangan</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <input type="text" name="keterangan" class="form-control" placeholder="Masukkan Keterangan Transaksi" v-model="single_data.keterangan" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Akun Kas</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <chosen :name="'perkiraan'" :option="akun_perkiraan" :id="'akun_perkiraan'"></chosen>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nominal Transaksi</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <inputmask :name="'nominal'" :id="'nominal'"></inputmask>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="col-md-5 col-md-offset-1" style="background: white; padding: 10px;">
                                          <div class="row">
                                            <div class="col-md-4 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Akun Lawan</label>
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-xs-12 mb-3">
                                                <chosen :name="'akun_lawan'" :option="akun_lawan" :id="'akun_lawan'"></chosen>
                                            </div>
                                          </div>
                                        </div>

                                      </div>

                                      <div align="right">
                                        <div class="form-group">
                                          <button type="button" name="tambah_data" class="btn btn-primary" id="simpan" @click="simpan_data" :disabled='btn_save_disabled'>Simpan Data</button>
                                        </div> 
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

                <div class="overlay transaksi_list">
                  <div class="content-loader" style="background: none; width:60%; margin: 3em auto; color: #eee;">
                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding: 10px; border-bottom: 1px solid #ccc;">
                      <h5>List Data Transaksi</h5>
                      {{-- <small></small> --}}
                    </div>

                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding-top: 10px;">
                      <xyz :data="list_transaksi"></xyz>
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

  <script type="text/x-template" id="datepicker-template">
    <input type="text" :name="name" :placeholder="placeholder" class="form-control" style="width:100%; cursor: pointer;" :id="id" required>
  </script>

  <script type="text/x-template" id="inputmask-template">
    <input type="text" :name="name" class="form-control text-right" :id="id" required>
  </script>

  <script type="text/x-template" id="choosen-template">
    <select class="form-control" :name="name" :id="id">
      <option value="cek" v-for="(n, idx) in option" :value="n.id_akun">@{{ n.id_akun+' - '+n.nama_akun }}</option>
    </select>
  </script>

  <script type="text/x-template" id="table-template">
    <table class="table table-striped table-bordered" style="font-size: 0.85em;">
      <thead>
        <tr>
          <th class="text-center">No.Bukti</th>
          <th class="text-center">Tanggal Transaksi</th>
          <th class="text-center">Nama Transaksi</th>
          <th class="text-center">Nominal</th>
        </tr>
      </thead>

      <tbody>
          <tr v-for="transaksi in data">
            <td class="text-center" style="cursor:pointer">@{{ transaksi.no_bukti }}</td>
            <td class="text-center">@{{ transaksi.tanggal_transaksi }}</td>
            <td class="text-center">@{{ transaksi.nama_transaksi }}</td>
            <td class="text-center">@{{ transaksi.nominal }}</td>
          </tr>
      </tbody>
    </table>
  </script>

  <script type="text/javascript">  

    function register_validator(){
      $('#data-form').bootstrapValidator({
          feedbackIcons : {
            valid : 'glyphicon glyphicon-ok',
            invalid : 'glyphicon glyphicon-remove',
            validating : 'glyphicon glyphicon-refresh'
          },
          fields : {
            nama_transaksi : {
              validators : {
                notEmpty : {
                  message : 'Nama Transaksi Tidak Boleh Kosong',
                }
              }
            },

            tanggal_transaksi : {
              validators : {
                notEmpty : {
                  message : 'Tanggal Transaksi Tidak Boleh Kosong',
                }
              }
            },

            keterangan : {
              validators : {
                notEmpty : {
                  message : 'Keterangan Transaksi Tidak Boleh Kosong',
                }
              }
            },

            nominal : {
              validators : {
                notEmpty : {
                  message : 'Nominal Harus Lebih Besar Dari 0',
                }
              }
            },

          }
        });
    }

    Vue.component('datepicker', {
      props: ['placeholder', 'name', 'id'],
      template: '#datepicker-template',
      mounted: function () {
        var vm = this
        $(this.$el).datepicker({
          format: 'dd-mm-yyyy'
        });
      },
      watch: {
        model: function(){
          // $(this.$el).val(this.model);
        }
      },
      destroyed: function () {

      }
    });

    Vue.component('inputmask', {
      props: ['placeholder', 'name', 'id'],
      template: '#inputmask-template',
      mounted: function () {
        var vm = this
        $(this.$el).inputmask("currency", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            autoGroup: true,
            prefix: '', //Space after $, this will not truncate the first character.
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });
      },
      watch: {
        model: function(){
          // $(this.$el).val(this.model);
        }
      },
      destroyed: function () {

      }
    });

    Vue.component('chosen', {
      props: ['option', 'name', 'id'],
      template: '#choosen-template',
      mounted: function(){
        var vm = this;
      },
      watch: {
        model: function(){
          // $(this.$el).val(this.model);
        }
      },
      destroyed: function () {
          
        }
    })

    Vue.component('xyz', {
      props: ['data'],
      template: '#table-template',
      mounted: function(){
        console.log(this.data)
      }
    })
    
    var vm = new Vue({

      el: '#vue-element',
      data: {
        baseUrl: '{{ url('/') }}',
        btn_save_disabled: false,

        akun_perkiraan: [],
        akun_lawan: [],
        list_transaksi: [],

        single_data: {

          jenis_transaksi   : 'KM',
          tanggal_transaksi : '',
          nama_transaksi    : '',
          keterangan        : '',
          akun_perkiraan    : '',
          nominal           : '',
          akun_lawan        : '',

        },
      },

      mounted: function(){
        register_validator();
        $('.overlay.transaksi_list').fadeIn(200);
        $('#load-status-text').text('Harap Tunggu. Sedang Menyiapkan Form');  
      },

      created: function(){
        axios.get(this.baseUrl+'/keuangan/p_inputtransaksi/transaksi_kas/form-resource')
              .then((response) => {
                console.log(response.data);
                this.akun_perkiraan = response.data.akun_perkiraan;
                this.akun_lawan = response.data.akun_lawan;
                this.list_transaksi = response.data.list_transaksi;
                $('#overlay').fadeOut();
              }).catch(err => {
                 $('#load-status-text').text('Sistem Bermasalah. Cobalah Memuat Ulang Halaman');
              }).then(() => {
                $('#overlay-transaksi').fadeIn(200);
              })
      },

      methods: {
        simpan_data: function(evt){
          evt.preventDefault();
          this.btn_save_disabled = true;

          if($('#data-form').data('bootstrapValidator').validate().isValid()){
            axios.post(this.baseUrl+'/keuangan/p_inputtransaksi/transaksi_kas/save', 
              $('#data-form').serialize()
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Transaksi Kas Anda Berhasil Disimpan.',
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
          }else{
            this.btn_save_disabled = false;
          }
        },

        form_reset: function(){
            this.single_data.jenis_transaksi   = 'KM';
            this.single_data.nama_transaksi    = '';
            this.single_data.keterangan        = '';
            this.single_data.nominal           = '';

            $('#tanggal_transaksi').val('');
            $('#nominal').val('');
            $('#akun_lawan').val(this.akun_lawan[0].id_akun);
            $('#akun_perkiraan').val(this.akun_perkiraan[0].id_akun);
        }
      }

    })

  </script>
@endsection                            
