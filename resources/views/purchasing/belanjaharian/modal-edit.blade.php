<div class="modal fade" id="modal-edit" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="post" id="form-belanja-edit" name="formBelanjaEdit">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Edit Pembelian Harian</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_edit"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">                          
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Beli</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="tanggal_beli_edit" class="form-control input-sm datepicker2" name="tanggalBeliEdit" type="text" value="{{ date('d-m-Y') }}">
              </div> 
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">No Nota</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="no_nota_edit" class="form-control input-sm" name="noNotaEdit" type="text" value="" readonly>
                <input type="hidden" class="form-control" name="idBelanjaEdit" id="id_belanja_edit">
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Biaya</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="total_biaya_edit" class="form-control input-sm" name="totalBiayaEdit" type="text" value="" readonly>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nama Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="nama_staff_edit" class="form-control input-sm" name="namaStaffEdit" type="text" value="{{Auth::user()->m_name}}" readonly>
                <input id="id_staff_edit" class="form-control input-sm" name="idStaffEdit" type="hidden" value="{{Auth::user()->m_id}}" readonly>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Divisi Peminta</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="peminta_edit" class="form-control input-sm" name="pemintaEdit" type="text" value="" readonly>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Keperluan</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="keperluan_edit" class="form-control input-sm" name="keperluanEdit" type="text" value="" readonly>
              </div>
            </div>
          </div>
         
          <div class="table-responsive">
            <table id="tabel-edit-beli" class="table tabelan table-bordered table-striped">
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
          
        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-primary" onclick="submitEdit()" id="btn_update">Update Data</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>