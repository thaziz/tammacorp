<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">
  
      

        <div class="row tamma-bg tamma-bg-form-top">
          <div class="col-md-12">

           

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>No Surat Serah Terima Tugas</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" name="">
                
                </div>
              </div>

                {{-- <div class="col-md-6 hidden-sm hidden-xs" style="height: 50px">
                  
                </div> --}}

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama Karyawan 1</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm select2">
                    <option>--Pilih Karyawan</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Telah melakukan serah terima tugas sebagai</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" name="">
                
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama Karyawan 2</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm select2">
                    <option>--Pilih Karyawan</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3 col-sm-12 col-xs-12">
                <label>Dari Tanggal</label>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <div class="input-group input-daterange">
                    <input type="text" class="form-control input-sm" id="" name="">
                    <span class="input-group-addon">-</span>
                    <input type="text" class="form-control input-sm" id="" name="">

                  </div>
                </div>
              </div>

              <div class="col-md-3 hidden-sm hidden-xs height45px">
                
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Di buat di</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" name="">
                
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Tanggal</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm datepicker" name="" value="{{date('d-m-Y')}}">
                
                </div>
              </div>

          </div>
        </div>

        <div align="right" style="margin-top: 15px;">
          <button class="btn btn-primary">Simpan</button>
          <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
        </div>

      
</div>
<!-- /div form-tab -->