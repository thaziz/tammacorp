<div id="htgbeli-tab" class="tab-pane fade in active">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
        <div style="margin-left:-30px;">
          <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="tebal" style="padding-top: 7px; font-size: 15px; margin-right:100px;">Periode</label>
          </div>

          <div class="col-md-6 col-sm-7 col-xs-12">
            <div class="form-group" style="display: ">
              <div class="input-daterange input-group">
                <input id="tanggal1" class="form-control input-sm datepicker1" name="iTanggal1" type="text">
                <span class="input-group-addon">-</span>
                <input id="tanggal2" class="input-sm form-control datepicker2" name="iTanggal2" type="text" value="{{ date('d-m-Y') }}">
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
          <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="lihatHtgBeliByTgl()">
            <strong>
              <i class="fa fa-search" aria-hidden="true"></i>
            </strong>
          </button>
          <button class="btn btn-info btn-sm btn-flat refresh-data-htgbeli" type="button">
            <strong>
              <i class="fa fa-undo" aria-hidden="true"></i>
            </strong>
          </button>
        </div>

      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-htgbeli">
          <thead>
            <tr>
              <th class="wd-5p">No</th>
              <th class="wd-25p">PO</th>
              <th class="wd-35p">Nama Supplier</th>
              <th class="wd-10p">Tgl PO</th>
              <th class="wd-10p">Tgl Selesai</th>
              <th class="wd-10p">Total Harga</th>
              <th style="text-align: center;" class="wd-5p">Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table> 
      </div>                                       
    </div>
  </div>     
</div><!-- /div alert-tab -->