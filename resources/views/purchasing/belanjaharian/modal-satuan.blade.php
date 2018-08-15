<div class="modal fade" id="modal-satuan" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
      
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title" style="color: white;">Form Buat Master Satuan</h4>
          </div>

          <div class="modal-body">
            <form method="POST" id="form-master-satuan" name="formMasterSatuan">
              {{ csrf_field() }}
              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
                                  
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Kode Satuan</label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="fkodeSat" id="fkode_sat" autocomplete="off" type="text" readonly>
                  </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Akronim Nama Satuan<span style="color: red">*</span></label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="fnamaSat" id="fnama_sat" autocomplete="off" type="text">
                  </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Keterangan Satuan <span style="color: red">*</span></label>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">  
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="fketeranganSat" id="fketerangan_sat" autocomplete="off" type="text">
                  </div>
                </div>

              </div>
            </form>
            <div class="col-md-12 col-sm-4 col-xs-12">
              <label class="tebal" style="color: red">Keterangan : * Wajib diisi.</label>
            </div>
          </div>
                            
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-simpan-satuan" onclick="save_satuan()">Simpan Data</button>
          </div>
        </div>

  </div>
</div>