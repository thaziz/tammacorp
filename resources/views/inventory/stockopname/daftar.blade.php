<div id="alert-tab" class="tab-pane fade in active">
    <div class="row">
      <form id="opname">

        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Pemilik Item :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <select class="form-control input-sm" id="pemilik" name="o_comp"
                style="width: 100%;">
                    <option class="form-control" value="">- Pilih Gudang</option>
                    @foreach ($data as $gudang)
                        <option class="form-control pemilik-gudang" value="{{ $gudang->cg_id }}">
                            - {{ $gudang->cg_cabang }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Posisi Item :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <select class="form-control input-sm" id="posisi" onclick="pilihGudang()"
                name="o_position" style="width: 100%;">
                    <option class="form-control" value="">- Pilih Gudang</option>
                    @foreach ($data as $gudang)
                        <option class="form-control pemilik-gudang" value="{{ $gudang->cg_id }}">
                            - {{ $gudang->cg_cabang }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Tanggal Opname :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <input type="text" class="form-control input-sm datepicker" name="o_date" value="{{ date('d-m-Y') }}">
            </div>
        </div>

        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Nama Staff :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
              <input type="text" readonly="" class="form-control input-sm" name="" value="{{$staff['nama']}}">
              <input type="hidden" readonly="" class="form-control input-sm" name="o_staff" value="{{$staff['id']}}">
            </div>
        </div>
      </form>
      <form id="tbOpname">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabelOpname">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Kode - Nama Item</th>
                    <th>Qty Sistem</th>
                    <th>Satuan</th>
                    <th>Qty Real</th>
                    <th>Keterangan</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
      </form>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <button class="btn btn-success kirim-opname" onclick="simpanOpname()" type="button">Kirim</button>
            <a class="btn btn-primary" style="float: right"><i class="fa fa-print"></i>&nbsp;Print</a>
        </div>

    </div>
</div>
