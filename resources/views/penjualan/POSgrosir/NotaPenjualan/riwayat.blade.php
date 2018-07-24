<h4 style="padding-bottom: 15px;">Riwayat Penjualan</h4>
<div class="col-md-2 col-sm-3 col-xs-12">
  <label class="tebal">Tanggal Belanja</label>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
  <div class="form-group">
    <div class="input-daterange input-group">
      <input id="Rtgl1" class="form-control input-sm datepicker1 " name="tanggal" type="text" value="{{ date('d-m-Y', strtotime(date('d-m-Y').' - 2 days')) }}">
      <span class="input-group-addon">-</span>
      <input id="Rtgl2" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
    </div>
  </div>
</div>

<div class="col-md-3 col-sm-3 col-xs-12" align="center">
  <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariRiwayat()">
    <strong>
      <i class="fa fa-search" aria-hidden="true"></i>
    </strong>
  </button>
  <button class="btn btn-info btn-sm btn-flat" type="button">
    <strong>
      <i class="fa fa-undo" aria-hidden="true"></i>
    </strong>
  </button>
</div>

<div class="col-md-3 col-sm-3 col-xs-12" align="right">
  <button class="btn btn-info btn-sm btn-flat" onclick="showNote()">
    <strong>
      <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </strong>
  </button>
</div>

<div class="table-responsive" style="padding-top: 15px;">
  <div id="dt_nota_jual">

  </div>
</div>

<script type="text/javascript">
  var date = new Date();
  var newdate = new Date(date);

  newdate.setDate(newdate.getDate()-3);
  var nd = new Date(newdate);

       
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker1').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      }).datepicker("setDate", nd);
      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      });



</script>
