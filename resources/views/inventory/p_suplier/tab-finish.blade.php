<div id="finish-tab" class="tab-pane fade in">
    <div class="row">
   
    <div class="col-md-3 col-sm-3 col-xs-12" align="left">
      <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refreshTabelFinish()">
        <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
      </button>
    </div>

    <div class="col-md-9 col-sm-9 col-xs-12" align="right" style="margin-bottom: 10px;">
      <a href="{{ url('/purchasing/rencanapembelian/create') }}"><button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
        <i class="fa fa-plus" aria-hidden="true">
           &nbsp;
        </i>Tambah Data
        </button>
      </a>
    </div>

   
    <div class="col-md-12 col-sm-12 col-xs-12">                          
      <div class="table-responsive">
        <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-finish">
          <thead>
            <tr>
              <th class="wd-10p">No</th>
              <th class="wd-15p">Tgl Dibuat</th>
              <th class="wd-15p">Kode Rencana</th>
              <th class="wd-15p">Staff</th>
              <th class="wd-20p">Suplier</th>
              <th class="wd-15p">Tgl Disetujui</th>
              <th class="wd-15p">Status</th>
              <th class="wd-15p" style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>              
        </table> 
      </div>  
    </div>  

    </div>
  </div>