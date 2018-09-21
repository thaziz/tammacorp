<div class="modal fade" id="modal_detail" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #e77c38;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: white;">Detail Hasil Garapan Produksi</h4>
      </div>

      <div class="modal-body">
        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

          <div class="col-md-2 col-sm-2 col-xs-2">
            <label class="tebal">Tanggal</label>
          </div>

          <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: left;">
            <div class="form-group">
              <label id="lblTgl"></label>
            </div>  
          </div>

          <div class="col-md-2 col-sm-2 col-xs-2">
            <label class="tebal">Produksi</label>
          </div>

          <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: left;">
            <div class="form-group">
              <label id="lblRmhPro"></label>
            </div>  
          </div>

          <div class="col-md-2 col-sm-2 col-xs-2">
            <label class="tebal">Nama</label>
          </div>

          <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: left;">
            <div class="form-group">
              <label id="lblNama"></label>
            </div>  
          </div>
          
          <div class="col-md-2 col-sm-2 col-xs-2">
            <label class="tebal">NIK</label>
          </div>

          <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: left;">
            <div class="form-group">
              <label id="lblNik"></label>
            </div>  
          </div>
        </div>
        
        <div class="table-responsive">
          <span><strong>Hasil Reguler</strong></span>
          <table id="tabel-hasil-reguler" class="table tabelan table-bordered table-striped">
            <thead>
              <tr>
                <th width="10%" style="text-align: center;">T.Jumbo</th>
                <th width="10%" style="text-align: center;">T. Besar</th>
                <th width="10%" style="text-align: center;">T. Sedang</th>
                <th width="10%" style="text-align: center;">T. Mini</th>
                <th width="10%" style="text-align: center;">T. Catering</th>
                <th width="10%" style="text-align: center;">Total</th>
              </tr>
            </thead>
            <tbody id="div_item_reguler">

            </tbody>
          </table>

          <span><strong>Hasil Lembur</strong></span>
          <table id="tabel-hasil-lembur" class="table tabelan table-bordered table-striped">
            <thead>
              <tr>
                <th width="10%" style="text-align: center;">T.Jumbo</th>
                <th width="10%" style="text-align: center;">T. Besar</th>
                <th width="10%" style="text-align: center;">T. Sedang</th>
                <th width="10%" style="text-align: center;">T. Mini</th>
                <th width="10%" style="text-align: center;">T. Catering</th>
                <th width="10%" style="text-align: center;">Total</th>
              </tr>
            </thead>
            <tbody id="div_item_lembur">

            </tbody>
          </table>
        </div>
        
        <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: right;">
          <label class="tebal">Total Hasil Produksi</label>
        </div>

        <div class="col-md-2 col-sm-2 col-xs-2" style="text-align: center;">
          <div class="form-group">
            <label id="lblTotalHasil"></label>
          </div>  
        </div>


      </div>
  
      <div id="apdsfs" class="modal-footer" style="border-top: none;">
        
      </div>
    </div>
    <!-- /Modal content-->
  </div>

  </div>
</div>