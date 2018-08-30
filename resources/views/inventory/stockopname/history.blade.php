<div id="note-tab" class="tab-pane fade" >
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12"  style="padding-bottom: 10px;">

          <div style="margin-left:-5px;">
            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal Opname :</label>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-daterange input-group">
                        <input id="tanggal3" class="form-control input-sm datepicker1 " name="tanggal" type="text">
                        <span class="input-group-addon">-</span>
                        <input id="tanggal4" class="input-sm form-control datepicker2" name="tanggal" type="text"
                               value="{{ date('d-m-Y') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggal2()">
                    <strong>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabel2()">
                    <strong>
                        <i class="fa fa-undo" aria-hidden="true"></i>
                    </strong>
                </button>
            </div>
            </div>



    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table tabelan table-hover  table-bordered" width="100%" cellspacing="0" id="tableHistory">
            <thead>
              <tr>
                  <th class="wd-15p">Tanggal</th>
                  <th class="wd-15p">Nota</th>
                  <th class="wd-15p">Pemilik</th>
                  <th class="wd-15p">Posisi</th>
                  <th class="wd-15p">Status</th>
                  <th class="wd-15p">Aksi</th>
              </tr>
            </thead>

            <tbody>

            </tbody>


        </table>
      </div>
    </div>

  </div>
</div>
