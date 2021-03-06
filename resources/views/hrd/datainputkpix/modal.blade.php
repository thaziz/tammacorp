<div class="modal fade" id="modal_tambah_data" role="dialog">
  <div class="modal-dialog" style="width: 70%;margin: auto;">
    
    <form method="post" id="form-input-kpi" name="formInputKpi">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Input Data Payroll Manajemen</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Tanggal</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input id="tgl_kpix" class="form-control input-sm datepicker2" name="tglKpix" type="text" value="{{ date('d-m-Y') }}">
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="divisi" id="divisi" class="form-control input-sm" readonly>
                <input type="hidden" name="iddivisi" id="iddivisi" class="form-control input-sm" readonly>
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Pegawai</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectJabatan">
                <select class="form-control input-sm select2 selJabatan" id="jabatan" name="jabatan" style="width: 100% !important;"></select>
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectPegawai">
                <select class="form-control input-sm select2 selPegawai" id="pegawai" name="pegawai" style="width: 100% !important;" disabled></select>
              </div>  
            </div>
                        
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg">

          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitKpix()" id="btn_simpan">Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->

  </div>

  </div>
</div>