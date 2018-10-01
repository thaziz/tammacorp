<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">
  
      

        <div class="row tamma-bg tamma-bg-form-top">
          <div class="col-md-12">

           

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                 
                  <select class="form-control input-sm select2">
                    <option>--Pilih Karyawan--</option>
                  </select>
                
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Divisi</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" readonly="" name="">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Tanggal pengajuan lembur</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm datepicker" name="">
                </div>
              </div>
              
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Lembur pada waktu</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label><input type="radio" class="form-control" value="hari_kerja" name="hari"> Hari Kerja</label><br>
                  <label><input type="radio" class="form-control" value="hari_libur" name="hari"> Hari Libur</label>
                </div>
              </div>
              
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Uraian tugas lembur</label>
              </div>

              <div class="col-md-9 col-sm-6 col-xs-12">
                <div class="form-group">
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>



          </div>
        </div>

        <div class="table-responsive" style="margin-top: 15px;">
          <table class="table tabelan table-bordered table-hover table-striped" id="tabel_perintah_lembur">
            <thead>
              <tr>
                <th rowspan="2"  style="text-align: center !important;vertical-align: middle;">Nama Karyawan</th>
                <th colspan="2"  style="text-align: center !important;">Jam Lembur</th>
                <th width="1%" rowspan="2"  style="text-align: center !important;vertical-align: middle;">Aksi</th>
              </tr>
              <tr style="text-align: center !important;">
                <th style="text-align: center !important;">Mulai</th>
                <th style="text-align: center !important;">Berakhir</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select class="form-control select2">
                    <option>--Pilih Karyawan--</option>
                  </select>
                </td>
                <td><input type="text" class="form-control input-sm" name=""></td>
                <td><input type="text" class="form-control input-sm" name=""></td>
                <td>
                  <button class="btn btn-primary tambah"><i class="fa fa-plus"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div align="right" style="margin-top: 15px;">
          <button class="btn btn-primary">Simpan</button>
          <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
        </div>

      
</div>
<!-- /div form-tab -->