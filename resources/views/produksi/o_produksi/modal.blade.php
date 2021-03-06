<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" style="width: 500px">
      
    <form id="myForm" onsubmit="return false">
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Form Edit Hasil Produksi</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">             

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group"> 
                  <input style="text-align: right;" type="hidden" class="form-control input-sm" name="prdt_productresult" id="prdt_productresult">
                  <input style="text-align: right;" type="hidden" class="form-control input-sm" name="prdt_detail" id="prdt_detail"> 
                  <input type="text" readonly class="form-control input-sm" name="i_name" id="i_name">
                </div>
              </div>           

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Jumlah Hasil Produksi</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" type="number" class="form-control input-sm" name="prdt_qty" id="prdt_qty">
                </div>
              </div>

            </div>
            
          </div>
      
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn-simpan" onclick="simpanProduksiQty()">Simpan Data</button>
          </div>

           
        </div>

      </form>   
      
    </div>

</div>