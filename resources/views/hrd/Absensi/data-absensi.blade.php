    <div class="col-md-2 col-sm-3 col-xs-12">
        <label class="tebal">Detail Absensi :</label>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <div class="input-daterange input-group">
                <input id="tanggal1" class="form-control input-sm datepicker1 "
                       name="tanggal" type="text">
                <span class="input-group-addon">-</span>
                <input id="tanggal2" class="input-sm form-control datepicker2"
                       name="tanggal" type="text" value="{{ date('d-m-Y') }}">
            </div>
        </div>
    </div>

    <div class="col-md-2 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                onclick="detTanggal()">
            <strong>
                <i class="fa fa-search" aria-hidden="true"></i>
            </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat refresh-data2" type="button"
                onclick="detTanggal()">
            <strong>
                <i class="fa fa-undo" aria-hidden="true"></i>
            </strong>
        </button>
    </div>

    <div class="col-md-4 col-sm-3 col-xs-12" align="left">
        <select name="tampilDet" id="tampilDet" onchange="detTanggal()" class="form-control input-sm">
          @foreach ($devisi as $divisi)
            <option value="{{$divisi->d_id}}" class="form-control input-sm">{{$divisi->d_name}}</option>
          @endforeach
        </select>
    </div>
    <div class="panel-body">
    <div class="table-responsive">
      <table id="detailAbsensi" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
        <thead>
          <tr>
            <th>No.</th>
            <th>Kode - Nama Pegawai</th>
            <th>Alpha</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Cuti</th>
            <th>Hadir</th>
          </tr>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
