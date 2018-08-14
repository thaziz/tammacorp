<div id="alert-tab" class="tab-pane fade in active">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;margin-top: -20px;" >
                  
        </div>
                              <div class="col-md-2 col-sm-12 col-xs-12">
                          <label class="tebal">Pemilik Item   :</label>
                      </div>
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group" align="pull-left">
                          <select class="form-control input-sm" id="prdt_produksi" name="prdt_produksi" style="width: 100%;">
                            <option class="form-control" value="">- Pilih Gudang</option>
                            @foreach ($data as $gudang)
                              <option class="form-control pemilik-gudang" value="{{ $gudang->cg_id }}">- {{ $gudang->cg_cabang }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-12 col-xs-12">
                          <label class="tebal">Posisi Item   :</label>
                      </div>
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group" align="pull-left">
                          <select class="form-control input-sm" id="prdt_produksi" name="prdt_produksi" style="width: 100%;">
                            <option class="form-control" value="">- Pilih Gudang</option>
                            @foreach ($data as $gudang)
                              <option class="form-control posisi-gudang" value="{{ $gudang->cg_id }}">- {{ $gudang->cg_cabang }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                      <div class="col-md-2 col-sm-12 col-xs-12">
                          <label class="tebal">Nama Item   :</label>
                      </div>
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group" align="pull-left">
                          <input type="text" class="form-control" name="" id="nama-item">
                        </div>
                      </div>
                    
        <div class="col-md-12 col-sm-12 col-xs-12">
          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabelOpname">
            <thead>
              <tr>
                <th class="wd-15p">Tanggal Opname</th>
                <th class="wd-15p text-center">Nama Item</th>
                <th class="wd-15p">Qty Sistem</th>
                <th class="wd-15p">Qty Real</th>
                <th class="wd-15p">Aksi</th>
                <th class="wd-15p">Keterangan</th>
              </tr>
            </thead>
            <tbody>
            </tbody>         
          </table> 
        </div>

    </div>
</div>

<script type="text/javascript">
  
</script>