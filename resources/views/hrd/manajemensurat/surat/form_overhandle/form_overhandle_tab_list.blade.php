<div id="list-tab" class="tab-pane fade in">
  <div class="table-responsive">
    <table class="table tabelan table-bordered table-hover table-striped data-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>No Surat</th>
          <th>Nama Karyawan 1</th>
          <th>Nama Karyawan 2</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>26 Sep 2018</td>
          <td>000/STT/HRD/VII/2018</td>
          <td>Charlie</td>
          <td>Alpha</td>
          <td align="center">
            <div class="btn-group btn-group-sm">
              <a href="{{route('form_overhandle_print')}}" target="_blank" class="btn btn-info" title="Print"><i class="fa fa-print"></i></a>
              <button class="btn btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></button>
            </div>
          </td>
        </tr>
       
      </tbody>
    </table>
  </div>
  <div align="right" style="margin-top: 15px;">
    <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
  </div>
</div>