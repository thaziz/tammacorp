<div class="modal fade" id="modal-supplier" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
      
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title" style="color: white;">Form Buat Master Supplier</h4>
          </div>

          <div class="modal-body">
            <form action="#" method="POST" id="form-master-supplier">
              {{ csrf_field() }}
              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
                                  
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Nama Toko/Vendor</label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="fNamaSupplier" id="fnama_supplier" autocomplete="off" type="text">
                  </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Nama Pemilik</label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="fNamaPemilik" id="fnama_pemilik" autocomplete="off" type="text">
                  </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Alamat Toko/vendor</label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="fNamaAlamat" id="fnama_alamat" autocomplete="off" type="text">
                  </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">No. Telp</label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input numberinput" name="fTelp" id="ftelp" autocomplete="off" type="text">
                  </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">No. Fax</label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input numberinput" name="fFax" id="ffax" autocomplete="off" type="text">
                  </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Keterangan Toko</label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="fKeterangan" id="fketerangan" autocomplete="off" type="text">
                  </div>
                </div>

              </div>
            </form>
          </div>
                            
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-simpan-supplier" onclick="save_supplier()">Simpan Data</button>
          </div>
        </div>

  </div>
</div>