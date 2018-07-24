<div class="modal fade" id="modal-barang" role="dialog">
  <div class="modal-dialog" style="width: 80%;margin: auto;">
      
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title" style="color: white;">Form Master Barang</h4>
          </div>

          <div class="modal-body">
            <form action="#" method="POST" id="form-master-barang">
              {{ csrf_field() }}
              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
                                  
                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Kode Barang</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                      <input type="text" id="kode_barang" name="kode_barang" placeholder="PILIH GROUP UNTUK GENERATE KODE" readonly="" class="form-control input-sm">
                  </div>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Nama</label> 
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="nama" name="nama" class="form-control input-sm">
                  </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                  <label class="tebal">Type Barang</label> 
                </div>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <div class="form-group">
                     <select class="form-control" name="type" id="type">
                       <option selected="">- Pilih Dahulu -</option>
                       <option value="BB">BAHAN BAKU</option>
                       <option value="BJ">BAHAN JUAL</option>
                       <option value="BP">BAHAN PRODUKSI</option>
                     </select>                               
                  </div>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Kelompok</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <select class="input-sm form-control" name="code_group" id="code_group">
                    </select>
                  </div>
                </div>

                <input type="hidden" name="group" id="group">                              
                
                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Min Stock</label> 
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="min_stock" name="min_stock" class="form-control input-sm">
                  </div>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Satuan Utama</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <select class="input-sm form-control" name="satuan1" id="satuan_1">
                    </select>
                  </div>
                </div>
                
                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Isi Sat Utama</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="isi_sat1" name="isi_sat1" class="form-control input-sm" readonly value="1">                               
                  </div>
                </div>
                {{-- satuan 1/utama --}}

                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Satuan Alternatif 1</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <select class="input-sm form-control" name="satuan2" id="satuan_2">
                    </select>
                  </div>
                </div>
                
                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Isi Sat Alternatif 1</label> 
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="isi_sat2" name="isi_sat2" class="form-control input-sm" placeholder="Qty terhadap satuan utama">
                  </div>
                </div>
                {{-- satuan alternatif1 / 2 --}}

                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Satuan Alternatif 2</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <select class="input-sm form-control" name="satuan3" id="satuan_3">
                    </select>
                  </div>
                </div>
                
                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Isi Sat Alternatif 2</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="isi_sat3" name="isi_sat3" class="form-control input-sm" placeholder="Qty terhadap satuan utama">                               
                  </div>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Harga/Satuan Utama</label>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="harga_beli1" name="hargaBeli1" class="form-control input-sm currency" readonly>                               
                  </div>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="harga_beli2" name="hargaBeli2" class="form-control input-sm currency" readonly>                               
                  </div>
                </div>

                <div class="col-md-3 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="harga_beli3" name="hargaBeli3" class="form-control input-sm currency" readonly>                               
                  </div>
                </div>

                <div class="col-xs-12">
                  <label class="tebal"></label>
                </div>
                
                <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Detail</label>
                </div>
                
                <div class="col-md-9 col-sm-8 col-xs-12">
                  <div class="form-group">
                      <textarea class="form-control input-sm" name="detail"></textarea>
                  </div>
                </div>

              </div>
            </form>
          </div>

          <div class="modal-footer" id="change_function" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save_barang">Simpan Data</button>
          </div>
        </div>

  </div>
</div>