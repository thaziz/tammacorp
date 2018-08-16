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

    <!-- Apply -->
    <section class="content-section bg-light" id="apply">
      <div class="container text-center">
        <div class="row">
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
            <form class="formlamaran" action="{{ url('recruitment/save') }}" method="post">
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
                <label for="suami" class="col-sm-2 col-form-label font-weight-bold">Nama Suami/Stri</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="suami" name="suami" placeholder="Nama Suami/Stri">
                </div>
              </div>
              <div class="form-group row">
                <label for="anak" class="col-sm-2 col-form-label font-weight-bold">Anak</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="anak" name="anak" placeholder="Jumlah Anak">
                </div>
              </div>
              <div class="row form-group">
                <dir class="col-sm-12">
                  <button type="submit" class="btn btn-success" style="float: right;">Simpan</button>
                </dir>
              </div>
            </form>
          </div>
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
      <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d989.5326478226659!2d112.76258721077522!3d-7.225942202698499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f9aaab9b9ad5%3A0xb6f7039d2cc4db9c!2sTamma+Robah+Indonesia!5e0!3m2!1sen!2sid!4v1534411169797"></iframe>
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

  </body>

</html>
