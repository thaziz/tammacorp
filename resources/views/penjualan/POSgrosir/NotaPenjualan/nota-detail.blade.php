<h4 style="padding-bottom: 15px;">Nota Penjualan</h4>
<div class="col-md-2 col-sm-3 col-xs-12">
  <label class="tebal">Tanggal Belanja</label>
</div>

<div class="col-md-3 col-sm-3 col-xs-12" align="right">
  <select name="tampilData" id="tampil_data" onchange="tampilDataGrosir(this);" class="form-control">
    <option value="semua" class="form-control">Tampilkan Data : Semua</option>
    <option value="draft" class="form-control">Tampilkan Data : Draft</option>
    <option value="progress" class="form-control">Tampilkan Data : Progress</option>
    <option value="final" class="form-control">Tampilkan Data : Final</option>
    <option value="packing" class="form-control">Tampilkan Data : Packing</option>
    <option value="sending" class="form-control">Tampilkan Data : Sending</option>
    <option value="received" class="form-control">Tampilkan Data : Received</option>
  </select>
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