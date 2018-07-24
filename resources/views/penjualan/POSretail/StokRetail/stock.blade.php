          <div id="loading" style="display: none;">
          </div>
          <div id="nav-stock" class="tab-pane fade">
            @include('penjualan.POSretail.StokRetail.transfer')
            <div class="row" style="margin-top: 15px;">
              <div class="col-md-12 col-sm-12 col-xs-12">           
                @if(Auth::user()->punyaAkses('Ritail Transfer','ma_insert'))
                  <div class="" align="right" style="margin-bottom: 15px;">
                    <button data-toggle="modal" onclick="noNota()" aria-controls="list" role="tab" 
                      class="btn-primary btn-flat btn-sm">
                      <i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Transfer Item
                    </button>
                  </div>
                @endif
                   <table class="table tabelan table-bordered no-padding" id="tabelStock" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Item</th>
                        <th>Tipe Item</th>
                        <th>Group Item</th>
                        <th>Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>


<script type="text/javascript">
  function noNota(){
    $.ajax({
      url         : baseUrl+'/transfer/no-nota',
      type        : 'get',
      timeout     : 10000,
      dataType    :'json',
      success     : function(response){
          $('#no-nota').val(response);
          $('#myTransfer').modal('show');
          }
      });
    }

</script>