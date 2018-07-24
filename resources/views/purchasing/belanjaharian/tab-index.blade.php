<div id="index-tab" class="tab-pane fade in active">
                 
  <div class="row" style="">
    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
        <div style="margin-left:-30px;">
          <div class="col-md-3 col-sm-2 col-xs-12">
            <label class="tebal">Tanggal Belanja</label>
          </div>

          <div class="col-md-6 col-sm-7 col-xs-12">
            <div class="form-group" style="display: ">
              <div class="input-daterange input-group">
                <input id="tanggal1" data-provide="datepicker" class="form-control input-sm datepicker1" name="tanggal1" type="text">
                <span class="input-group-addon">-</span>
                <input id="tanggal2" data-provide="datepicker" class="input-sm form-control datepicker2" name="tanggal2" type="text" value="{{ date('d-m-Y') }}">
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
          <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="lihatBelanjaByTanggal()">
            <strong>
              <i class="fa fa-search" aria-hidden="true"></i>
            </strong>
          </button>
          <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelBelanja()"> 
            <strong>
              <i class="fa fa-undo" aria-hidden="true"></i>
            </strong>
          </button>
        </div>
        
      </div>

      <div align="right">
        <a href="{{ url('/purchasing/belanjaharian/tambah_belanja') }}" class="btn btn-box-tool"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
      </div>

      <div class="table-responsive" style="margin-top: 15px;">
        <table class="table tabelan table-bordered" id="data">
          <thead>
            <th>No</th>
            <th>Tanggal Belanja</th>
            <th>Staff</th>
            <th>Nota</th>
            <th>No Reff</th>
            <th>Supplier</th>
            <th>Total Biaya</th>
            <th>Status</th>
            <th>Aksi</th>
          </thead>
        </table>
      </div>

    </div>
  </div>
              
</div><!-- /div index-tab -->