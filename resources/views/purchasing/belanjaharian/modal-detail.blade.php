<div class="modal fade" id="modal-detail" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="get" action="#">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Detail Pembelian Harian</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_detail"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">                          
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Beli</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglBeli"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">No Nota</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblNoNota"></label>
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Biaya</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTotalBiaya"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nama Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaff"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">No Reff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblNoReff"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Jumlah Yang Dibayarkan</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTotalBayar"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Supplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplier"></label>
              </div>
            </div>
          </div>
         
          <div class="table-responsive">
            <table id="tabel-detail-beli" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="20%">Nama Barang</th>
                  <th width="10%">Qty</th>
                  <th width="10%">Satuan</th>
                  <th width="10%">Harga Satuan</th>
                  <th width="15%">Harga Total</th>
                </tr>
              </thead>
              <tbody id="div_item">
              </tbody>
            </table>
          </div>

          <!-- <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-top:15px;margin-bottom: 25px;">
            <input type="checkbox" name="">&nbsp;Di tolak&nbsp;<input type="checkbox" name="">&nbsp;Di Setujui&nbsp;<input type="checkbox" name="">&nbsp;Di revisi<br>
            <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: 10px;">
              <div class="form-group">  
                <textarea class="form-control"></textarea>
              </div>
            </div>
          </div> -->
          
        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>