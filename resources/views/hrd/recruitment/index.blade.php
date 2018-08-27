<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tammafood | Recruitment</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/recruitment/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('assets/recruitment/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/recruitment/vendor/fontgoogle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/recruitment/vendor/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/recruitment/css/stylish-portfolio.min.css') }}" rel="stylesheet">
    <style type="text/css">
      .col-form-label {
        text-align: left;
      }
    </style>

    <style type="text/css">
      .wizard {
          margin: 20px auto;
          background: transparent;
      }

      .wizard .nav-tabs {
          position: relative;
          margin: 40px auto;
          margin-bottom: 0;
          border-bottom-color: #e0e0e0;
          display: -webkit-box;
          display: -moz-box;
          display: -ms-flexbox;
          display: -webkit-flex;
          display: flex;
          -webkit-flex-flow: row wrap;
          justify-content: space-around;
          -webkit-justify-content: space-around;
          flex-wrap: nowrap;
          -webkit-flex-wrap: nowrap;
      }

      .wizard > div.wizard-inner {
          position: relative;
      }

      .connecting-line {
          height: 2px;
          background: #e0e0e0;
          position: absolute;
          width: 80%;
          margin: 0 auto;
          left: 0;
          right: 0;
          top: 50%;
          z-index: 1;
      }

      .wizard .nav-tabs > li.active > a,
      .wizard .nav-tabs > li.active > a:hover,
      .wizard .nav-tabs > li.active > a:focus {
          color: #555555;
          cursor: default;
          border: 0;
          border-bottom-color: transparent;
      }

      span.round-tab {
          width: 70px;
          height: 70px;
          line-height: 70px;
          display: inline-block;
          border-radius: 100px;
          background: #fff;
          border: 2px solid #e0e0e0;
          z-index: 2;
          position: absolute;
          left: 0;
          text-align: center;
          font-size: 25px;
      }

      span.round-tab i {
          color: #555555;
      }

      .wizard li a.active span.round-tab {
          background: #fff;
          border: 2px solid #5bc0de;

      }

      .wizard li a.active span.round-tab i {
          color: #5bc0de;
      }

      span.round-tab:hover {
          color: #333;
          border: 2px solid #333;
      }

      

      .wizard li a:after {
          content: " ";
          position: relative;
          left: 46%;
          top: -20px;
          opacity: 0;
          margin: 0 auto;
          bottom: 0px;
          border: 5px solid transparent;
          border-bottom-color: #5bc0de;
          transition: 0.1s ease-in-out;
      }

      .wizard li.active.nav-item:after {
          content: " ";
          position: relative;
          left: 46%;
          top: -20px;
          opacity: 1;
          margin: 0 auto;
          bottom: 0px;
          border: 10px solid transparent;
          border-bottom-color: #5bc0de;
      }

      .wizard .nav-tabs > li a {
          width: 70px;
          height: 70px;
          margin: 20px auto;
          border-radius: 100%;
          padding: 0;
          position: relative;
      }

      .wizard .nav-tabs > li a:hover {
          background: transparent;
      }

      .wizard .tab-pane {
          position: relative;
          padding-top: 50px;
      }

      .wizard h3 {
          margin-top: 0;
      }

      @media( max-width: 585px) {

          .wizard {
              width: 90%;
              height: auto !important;
          }

          span.round-tab {
              font-size: 16px;
              width: 50px;
              height: 50px;
              line-height: 50px;
          }

          .wizard .nav-tabs > li a {
              width: 50px;
              height: 50px;
              line-height: 50px;
          }

          .wizard li.active:after {
              content: " ";
              position: absolute;
              left: 35%;
          }
      }
    </style>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <a class="menu-toggle rounded" href="#">
      <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand">
          <a class="js-scroll-trigger" href="#page-top">Top</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#apply">Apply</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#about">About</a>
        </li>
      </ul>
    </nav>




    <!-- Header -->
    <header class="masthead d-flex">
      <div class="container text-center my-auto">
        <a class="btn btn-danger btn-xl js-scroll-trigger" style="margin-top: 380px; margin-right: 30px;" href="#about">About Tammafood</a>
        <a class="btn btn-primary btn-xl js-scroll-trigger" style="margin-top: 380px; margin-left: 30px;" href="#apply">Apply Now</a>
      </div>
      <div class="overlay"></div>
    </header>

    {{-- Wizard --}}
    <section class="content-section bg-light" >
      <div class="container text-center">
          <form class="form cf" action="{{ url('recruitment/save') }}" method="post" enctype="multipart/form-data">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="nav-item">
                                    <a href="#apply" data-toggle="tab" aria-controls="apply" role="tab" title="Data Diri" class="nav-link active">
                                        <span class="round-tab">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Daftar Riwayat Hidup" class="nav-link disabled">
                                        <span class="round-tab">
                                            <i class="fa fa-history"></i>
                                        </span>
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Upload Berkas" class="nav-link disabled">
                                        <span class="round-tab">
                                            <i class="fa fa-file-archive"></i>
                                        </span>
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Finish" class="nav-link disabled">
                                        <span class="round-tab">
                                            <i class="fa fa-check"></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="form_wizard">
                            <div class="tab-pane active text-center" role="tabpanel" id="apply">
                                <h1 class="text-md-center">Data Diri</h1>
                                <div class="row" >
                                  <div class="col-lg-10 mx-auto">
                                    @if ($message = Session::get('sukses'))
                                      <div class="alert alert-success alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Sukses!</strong> Data berhasil disimpan.
                                      </div>
                                    @elseif($message = Session::get('gagal'))
                                      <div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Gagal!</strong> Silahkan coba beberapa saat lagi.
                                      </div>
                                    @endif
                                    
                                       {{ csrf_field() }}
                                      <div class="form-group row">
                                        <label for="nama" class="col-sm-2 col-form-label font-weight-bold">Nama</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pelamar">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="noktp" class="col-sm-2 col-form-label font-weight-bold">Nomor Identitas</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="noktp" name="noktp" placeholder="Nomor Identitas KTP/SIM">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="alamat" class="col-sm-2 col-form-label font-weight-bold">Alamat</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat KTP/SIM">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="alamatnow" class="col-sm-2 col-form-label font-weight-bold">Alamat Sekarang</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="alamatnow" name="alamatnow" placeholder="Alamat Sekarang">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="tempatlahir" class="col-sm-2 col-form-label font-weight-bold">Tempat Lahir</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" placeholder="Tempat Lahir">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="tanggallahir" class="col-sm-2 col-form-label font-weight-bold">Tanggal Lahir</label>
                                        <div class="col-sm-10 row form-group" style="margin-left: 0px; margin-bottom: -10px;">
                                          <select id="dobday" class="form-control col-sm-2" style="margin-right: 5px;" name="tanggal" id="tanggal"></select>
                                          <select id="dobmonth" class="form-control col-sm-4" style="margin-right: 5px;" name="bulan" id="bulan"></select>
                                          <select id="dobyear" class="form-control col-sm-3" style="margin-right: 5px;" name="tahun" id="tahun"></select>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="pendidikanterakhir" class="col-sm-2 col-form-label font-weight-bold">Pendidikan</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="pendidikanterakhir" name="pendidikanterakhir" placeholder="Pendidikan Terakhir">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="notlp" class="col-sm-2 col-form-label font-weight-bold">No Telp/WA</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="notlp" name="notlp" placeholder="Nomor Telp/WA">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="agama" class="col-sm-2 col-form-label font-weight-bold">Agama</label>
                                        <div class="col-sm-10">
                                          <select class="form-control" name="agama" id="agama">
                                            <option value="-" selected disabled>-- Pilih Agama --</option>
                                            <option value="islam">Islam</option>
                                            <option value="kristen">Kristen</option>
                                            <option value="katolik">Katolik</option>
                                            <option value="budha">Budha</option>
                                            <option value="hindu">Hindu</option>
                                            <option value="konghuchu">Konghucu</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="status" class="col-sm-2 col-form-label font-weight-bold">Status</label>
                                        <div class="col-sm-10">
                                          <select class="form-control" name="status" id="status">
                                            <option value="-" selected disabled>-- Pilih Status --</option>
                                            <option value="menikah">Menikah</option>
                                            <option value="belum">Belum Menikah</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="partner_name" class="col-sm-2 col-form-label font-weight-bold">Nama Suami/Stri</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="partner_name" name="partner_name" placeholder="Nama Suami/Stri">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="anak" class="col-sm-2 col-form-label font-weight-bold">Anak</label>
                                        <div class="col-sm-10">
                                          <input type="number" class="form-control" id="anak" name="anak" placeholder="Jumlah Anak">
                                        </div>
                                      </div>
                                      
                                    
                                  </div>
                                </div>
                                <ul class="list-inline text-md-center">
                                    <li><a class="btn btn-lg btn-primary next-step next-button js-scroll-trigger" href="#form_wizard"> Get Started Now</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h1 class="text-md-center">Daftar Riwayat Hidup</h1>
                                <div class="row">
                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="perusahaan1" class="col-sm-2 col-form-label font-weight-bold">Nama Perusahaan</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="perusahaan1" name="perusahaan1" placeholder="Nama Perusahaan">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="tahun1" class="col-sm-2 col-form-label font-weight-bold">Tahun</label>
                                        <div class="col-sm-5">
                                          <input type="text" class="form-control" id="tahun1" name="tahun1" placeholder="Tahun Awal">
                                        </div>
                                        <div class="col-sm-5">
                                          <input type="text" class="form-control" id="tahun_end1" name="tahun_end1" placeholder="Tahun Akhir">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="jobdesc1" class="col-sm-2 col-form-label font-weight-bold">Job Desc</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="jobdesc1" name="jobdesc1" placeholder="Job Desc">
                                        </div>
                                      </div>
                                    </div>

                                    <div style="border-top:1px solid #e0e0e0;margin-bottom: 10px;width: 100%;"></div>

                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="perusahaan2" class="col-sm-2 col-form-label font-weight-bold">Nama Perusahaan</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="perusahaan2" name="perusahaan2" placeholder="Nama Perusahaan">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="tahun2" class="col-sm-2 col-form-label font-weight-bold">Tahun</label>
                                        <div class="col-sm-5">
                                          <input type="text" class="form-control" id="tahun2" name="tahun2" placeholder="Tahun Awal">
                                        </div>
                                        <div class="col-sm-5">
                                          <input type="text" class="form-control" id="tahun_end2" name="tahun_end2" placeholder="Tahun Akhir">
                                        </div>                                      
                                      </div>
                                    </div>

                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="jobdesc2" class="col-sm-2 col-form-label font-weight-bold">Job Desc</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="jobdesc2" name="jobdesc2" placeholder="Job Desc">
                                        </div>
                                      </div>
                                    </div>
                                 

                                </div>
                                <ul class="list-inline text-md-center">
                                    <li><a class="btn btn-lg btn-primary next-step next-button js-scroll-trigger" href="#form_wizard">Next Step</a></li>
                                    <li><a href="#form_wizard" class="btn btn-lg btn-common prev-step next-button js-scroll-trigger">Back</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h1 class="text-md-center">Upload Berkas</h1>
                                <div class="row">
                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="sertifikat" class="col-sm-2 col-form-label font-weight-bold">File Sertifikat</label>
                                        <div class="col-sm-10">
                                          <input type="file" class="form-control" id="sertifikat" name="sertifikat" placeholder="File Sertifikat">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="ijazah" class="col-sm-2 col-form-label font-weight-bold">File Ijazah</label>
                                        <div class="col-sm-10">
                                          <input type="file" class="form-control" id="ijazah" name="ijazah" placeholder="File Ijazah">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-lg-10 mx-auto">
                                      <div class="form-group row">
                                        <label for="file_lain_lain" class="col-sm-2 col-form-label font-weight-bold">File Lain-lain</label>
                                        <div class="col-sm-10">
                                          <input type="file" class="form-control" id="file_lain_lain" name="file_lain_lain" placeholder="File Lain-lain">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <ul class="list-inline text-md-center">
                                    <li><a href="#form_wizard" class="btn btn-lg btn-primary next-step next-button js-scroll-trigger">Next Step</a></li>
                                    <li><a href="#form_wizard" class="btn btn-lg btn-common prev-step next-button js-scroll-trigger">Back</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step4">
                                <h1 class="text-md-center">Complete</h1>
                                <div class="row">
                                  

                                </div>
                                <ul class="list-inline text-md-center">
                                    <li><button type="submit" class="btn btn-lg btn-primary next-button">Finish</button></li>
                                    <li><a href="#form_wizard" class="btn btn-lg btn-common prev-step next-button js-scroll-trigger">Back</a></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
          </form>
        </div>
      </div>
    </section>



    <!-- About -->
    <section class="content-section bg-primary text-white text-center" id="about">
      <div class="container">
        <div class="content-section-heading">
          <h3 class="text-secondary mb-0">About</h3>
          <h2 class="mb-5">Tammafood</h2>
        </div>
        <p class="lead mb-5">CV. Tamma Robbah Indonesia adalah salah satu produsen tortilla dan berbagai perlengkapan kebutuhan bahan baku kebab di indonesia. Berdiri sejak 2008 dan sudah memiliki ijin PIRT dan Halal MUI.</p>
        <p class="lead">Alamat kami Jalan Randu no. 74. Sidotopo Wetan. Surabaya.</p>
        <p class="lead">Butuh Konsultasi. Silahkan Hubungi Customer Service kami 0812-3456-1066</p>
      </div>
    </section>
    <section id="contact" class="map">
      <iframe width="100%" height="100%" frameborder="0" scrolling="true" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d989.5326478226659!2d112.76258721077522!3d-7.225942202698499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f9aaab9b9ad5%3A0xb6f7039d2cc4db9c!2sTamma+Robah+Indonesia!5e0!3m2!1sen!2sid!4v1534411169797"></iframe>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
      <div class="container">
        <span><img src="{{ asset('assets/img/tammafood.png') }}" alt="" height="50"></span>
        </br>
        <p class="text-muted small mb-0" style="margin-top: 10px;">Copyright &copy; Alamraya Sebar Barokah</p>
      </div>
    </footer>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('assets/recruitment/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/recruitment/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('assets/recruitment/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('assets/recruitment/js/stylish-portfolio.min.js') }}"></script>
    <script src="{{ asset('assets/recruitment/vendor/dobPicker.min.js') }}"></script>

    <script type="text/javascript">
      
      $(document).ready(function(){
        $.dobPicker({
          // Selectopr IDs
          daySelector: '#dobday',
          monthSelector: '#dobmonth',
          yearSelector: '#dobyear',

          // Default option values
          dayDefault: 'Tangal',
          monthDefault: 'Bulan',
          yearDefault: 'Tahun',

          // Minimum age
          minimumAge: 10,

          // Maximum age
          maximumAge: 80
        });

      });
    </script>
    <script type="text/javascript">
       //Initialize tooltips
       $('.nav-tabs > li a[title]').tooltip();

       //Wizard
       $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

           var $target = $(e.target);

           if ($target.hasClass('disabled')) {
               return false;
           }
       });

       $(".next-step").click(function (e) {
           var $active = $('.wizard .nav-tabs .nav-item .active');
           var $activeli = $active.parent("li");

           $($activeli).next().find('a[data-toggle="tab"]').removeClass("disabled");
           $($activeli).next().find('a[data-toggle="tab"]').click();
       });


       $(".prev-step").click(function (e) {

           var $active = $('.wizard .nav-tabs .nav-item .active');
           var $activeli = $active.parent("li");

           $($activeli).prev().find('a[data-toggle="tab"]').removeClass("disabled");
           $($activeli).prev().find('a[data-toggle="tab"]').click();

       });

    </script>

  </body>

</html>
