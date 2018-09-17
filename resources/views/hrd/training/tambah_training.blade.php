@extends('main')
@section('extra_styles')
<style type="text/css">
  .bold{
    font-weight: bold;
  }
  .div-answer{
    margin-left: 15px;
    margin-right: 15px;
  }
</style>
@endsection
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Form Training Pegawai</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Training&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Form Training Pegawai</li>
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
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Form Training Pegawai</a></li>
                      <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                      <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                      
                      <div id="alert-tab" class="tab-pane fade in active">
                       
                        <div class="row" align="right"  style="margin-top: -10px;margin-bottom: 15px;">
                          <div class="col-md-10 col-sm-10 col-xs-10" align="left">
                            <h4>Form Training Pegawai</h4>
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-2">
                            <a href="{{route('training')}}" class="btn btn-box-tool"><i class="fa fa-arrow-left"></i></a>
                          </div>
                        </div>
                                                
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12 ">

                            <div class="row tamma-bg" style="padding-top: 15px;margin: 5px;">

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label class="bold">Nama</label>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control input-sm" name="">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label class="bold">Jabatan/Posisi</label>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control input-sm" name="">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label class="bold">Ruang Lingkup Pekerjaan</label>
                              </div>

                              <div class="col-md-9 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control input-sm" name="">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label class="bold">Nama Atasan</label>
                              </div>

                              <div class="col-md-9 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control input-sm" name="">
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="bold">Petunjuk Pengisian</label><br>
                                <div class="form-group">
                                  <small>Berilah tanda Checklist pada tempat yang disediakan atau berilah jawaban singkat, jelas, dan padat pada pertanyaan yang diminta</small>
                                </div>
                              </div>

                              {{-- No 1 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  1.&nbsp;&nbsp;Apakah tugas dan tanggung jawab dapat diselesaikan dengan baik ?
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <label>
                                    <input type="radio" class="form-control" value="iyes" name="number1"> Ya, Langsung ke nomor 6
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <label>
                                    <input type="radio" class="form-control" value="eno" name="number1"> Tidak, Lanjut ke nomor 2
                                  </label>
                                </div>
                              </div>

                              {{-- No 2 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  2.&nbsp;&nbsp;Untuk Tugas yang mana ? (diuraikan)
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><input type="checkbox" checked="" class="form-control input-sm" name=""></span>
                                    <input type="text" class="form-control input-sm" name="">
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><input type="checkbox" class="form-control input-sm" name=""></span>
                                    <input type="text" class="form-control input-sm" name="">
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><input type="checkbox" class="form-control input-sm" name=""></span>
                                    <input type="text" class="form-control input-sm" name="">
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><input type="checkbox" class="form-control input-sm" name=""></span>
                                    <input type="text" class="form-control input-sm" name="">
                                  </div>
                                </div>
                              </div>

                              {{-- No 3 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  3.&nbsp;&nbsp;Apa Penyebab utamanya ?
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Minat/Sikap</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Pengetahuan</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Kemampuan atau Ketrampilan</label>
                                </div>
                              </div>

                              {{-- No 4 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  4.&nbsp;&nbsp;Tindakan yang sudah dilakukan ?
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="row">

                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group ">
                                      <label><input type="checkbox" name="">&nbsp;&nbsp; Bimbingan Atasan</label>
                                    </div>
                                  </div>

                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group ">
                                      <label><input type="checkbox" name="">&nbsp;&nbsp; Diberikan contoh-contoh</label>
                                    </div>
                                  </div>

                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group ">
                                      <label><input type="checkbox" name="">&nbsp;&nbsp; Diberikan alat bantu kerja</label>
                                    </div>
                                  </div>

                                </div>
                              </div>

                              <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                  
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon"><input type="checkbox" class="form-control input-sm" name=""></span>
                                        <input type="text" class="form-control input-sm" name="">
                                      </div>
                                      Lainnya, Sebutkan
                                    </div>
                                  </div>

                                </div>
                              </div>

                              {{-- No 5 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  5.&nbsp;&nbsp;Apakah tindakan tersebut pada nomor 4 sudah memadai ?
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <label>
                                    <input type="radio" class="form-control" value="iyes" name="number5"> Ya
                                  </label>
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <label>
                                    <input type="radio" class="form-control" value="eno" name="number5"> Tidak
                                  </label>
                                </div>
                              </div>

                              {{-- No 6 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  6.&nbsp;&nbsp;Apakah diperlukan pelatihan untuk meningkatkan produktivitas kerja ?
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <label>
                                    <input type="radio" class="form-control" value="iyes" name="number6"> Ya
                                  </label>
                                </div>
                              </div>

                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <label>
                                    <input type="radio" class="form-control" value="eno" name="number6"> Tidak
                                  </label>
                                </div>
                              </div>

                              {{-- No 7 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  7.&nbsp;&nbsp;Jenis pelatihan umum apa yang diperlukan agar dapat menunjang produktivitas kerja bapak/ibu ?
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Leadership/Kepemimpinan</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Management Sumberdaya</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Keterampilan Bahasa Asing (Inggris)</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Administrasi dan Kearsipan / Surat Menyurat</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Presentation Skill / Ketrampilan Presentasi</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Organizational Skill / Keterampilan Organisasi</label>
                                </div>
                              </div>
                              
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Customer Service / Pelayanan Konsumen</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Manager Skill / Keterampilan Manajerial</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Conflict Management / Manajemen Konflik</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Management Keuangan</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Penyusutan Laporan</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" name="">&nbsp;&nbsp; Management Proyek</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon"><input type="checkbox" class="form-control input-sm" name=""></span>
                                    <input type="text" class="form-control input-sm" name="">
                                  </div>
                                  Lainnya, Sebutkan
                                </div>
                              </div>

                              {{-- No 8 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  8.&nbsp;&nbsp;Metode pelatihan yang diinginkan
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" class="form-control" name="">&nbsp;&nbsp; Classroom (Tatap Muka)</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" class="form-control" name="">&nbsp;&nbsp; E-learning</label>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label><input type="checkbox" class="form-control" name="">&nbsp;&nbsp; Outdoor/Outbond</label>
                                </div>
                              </div>

                              {{-- No 9 --}}

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  9.&nbsp;&nbsp; Pelaksanaan Pelatihan ?
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  Waktu ( Sebutkan )<input type="text" class="form-control input-sm" name="">
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group bold">
                                  Penyelenggara
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  Intern ( Sebutkan )
                                  <div class="input-group">
                                    <span class="input-group-addon">
                                      <input type="checkbox" class="form-control" name="">
                                    </span>
                                    <input type="text" class="form-control input-sm" name="">
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  Extern ( Sebutkan )
                                  <div class="input-group">
                                    <span class="input-group-addon">
                                      <input type="checkbox" class="form-control" name="">
                                    </span>
                                    <input type="text" class="form-control input-sm" name="">
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      
                        <div align="right" style="margin-top: 10px;">
                          <button class="btn btn-primary">Simpan</button>
                        </div>
                        
                      </div><!-- /div alert-tab -->

                      <!-- div note-tab -->
                      <div id="note-tab" class="tab-pane fade">
                        <div class="row">
                          <div class="panel-body">
                            <!-- Isi Content -->we we we
                          </div>
                        </div>
                      </div><!--/div note-tab -->

                      <!-- div label-badge-tab -->
                      <div id="label-badge-tab" class="tab-pane fade">
                        <div class="row">
                          <div class="panel-body">
                            <!-- Isi content -->we
                          </div>
                        </div>
                      </div><!-- /div label-badge-tab -->

                    </div>
          
                  </div>
              </div>
          </div>
      </div>
</div>


@endsection
@section("extra_scripts")
    <script type="text/javascript">
 
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd/mm/yyyy"
      });    
      </script>
@endsection()