<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">
  
      

        <div class="row tamma-bg tamma-bg-form-top">
          <div class="col-md-12">


              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>PIC</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" name="">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Divisi</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" name="">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Hari</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm datepicker" name="">
                </div>
              </div>
             
          </div>
        </div>

        <div class="table-responsive" style="margin-top: 15px;">
          <table width="100%" class="table tabelan table-bordered table-hover table-striped" id="tabel_aktifitas">
            <thead>
              <tr>
                <th width="1%"></th>
                <th>Aktivitas</th>
                <th>Keterangan</th>
                <th width="5%"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td valign="middle">#</td>
                <td><textarea type="text" class="form-control" name="" rows="3"></textarea></td>
                <td><textarea type="text" class="form-control" name="" rows="3"></textarea></td>
                <td valign="middle">
                  <button class="btn btn-primary btn-sm tambah"><i class="fa fa-plus"></i></button>
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