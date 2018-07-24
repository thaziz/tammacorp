<div class="modal fade" id="modalTerima" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
      
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title" style="color: white;">Form Terima Hasil Produksi</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">No. Nota</label>
              </div>
              
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="noNotaMasuk" id="noNotaMasuk" autocomplete="off" readonly="" type="text">
                </div>
              </div>
                
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="namaItemMasuk" id="namaItemMasuk" autocomplete="off" readonly="" type="text">
                  <input class="form-control" name="idItemMasuk" id="idItemMasuk" type="hidden">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input class="form-control input-sm" name="tglMasuk"  type="text" id="datetimepicker">
                </div>
              </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Pajak</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" name="headTotalTax" id="head_total_tax" readonly="" class="form-control input-sm">
              </div>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Total Pembelian Nett</label>
            </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" class="form-control input-sm numberinput" name="qtyMasuk" type="number" readonly>
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Qty Diterima</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" class="form-control input-sm numberinput" name="qtyDiterima" type="number" min="1" max="9999">
                </div>
              </div>

            </div>
            
          </div>
                            
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
          </div>
        </div>

  </div>
</div>