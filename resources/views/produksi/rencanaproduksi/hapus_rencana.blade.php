<div class="modal fade" id="hapus" role="dialog">
  <div class="modal-dialog">
    <form id="hapus_rencana" onsubmit="return false">
       <input name="_method" type="hidden" value="DELETE">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <input type="hidden" name="hapus_id" id="hapus_id">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Hapus Rencana Produksi ?</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding: 15px; ">
              <h3 id="plan_name" style="text-align: center;"></h3>
            </div>
            
          </div>
      
          <div class="modal-footer" style="border-top: none; text-align: center;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Hapus</button>
          </div>
        </div>
    </form>   
  </div>
</div>