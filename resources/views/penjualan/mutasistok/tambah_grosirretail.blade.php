<div class="modal fade" id="tambah-grosirretail" role="dialog">
  <div class="modal-dialog">
      
    <form method="get" action="#">
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Form Grosir to Retail</h4>
          </div>

          <div class="modal-body">

            <div class="row">
              
                <div class="col-md-6 col-sm-6 col-xs-12">  
                  <label class="tebal">Tanggal</label>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="tglMutasiGrosir" class="form-control input-sm" name="">
                  </div>
                </div>

             

                <div class="col-md-6 col-sm-6 col-xs-12">  
                  <label class="tebal">Nama Item</label>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <input type="text" id="namaItem" name="namaItem" class="form-control">
                      <input type="" id="rkode" name="rsd_item" class="form-control">
                      <input type="" id="code" class="form-control">
                      <input type="" id="rdetailnama" name="rnama" class="form-control"> 
                  </div>
                </div>


                <div class="col-md-6 col-sm-6 col-xs-12">  
                  <label class="tebal">Gudang Awal</label>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control" name="gudangAwal">
                      <option value="1">Bahan Baku</option>
                      <option value="2">Produksi</option>
                      <option value="3">Retail</option>
                    </select>
                  </div>
                </div>


                <div class="col-md-6 col-sm-6 col-xs-12">  
                  <label class="tebal">Gudang Tujuan</label>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control" name="gudangTujuan">
                       <option value="1">Bahan Baku</option>
                      <option value="2">Produksi</option>
                      <option value="3">Grosir</option>
                    </select>
                  </div>
                </div>



                <div class="col-md-6 col-sm-6 col-xs-12">  
                  <label class="tebal">Stok</label>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control input-sm" readonly="" name="">
                  </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">  
                  <label class="tebal">Jumlah</label>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control input-sm"  name="">
                  </div>
                </div>

                
              </div>
            
            
          </div>
      
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Simpan Data</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>   
    </div>
</div>

<script type="text/javascript">

</script>