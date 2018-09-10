<div class="tab-pane active text-center" role="tabpanel" id="apply">
  <h1 class="text-md-center">Data Diri</h1>
  <div class="row" >
    <div class="col-lg-10 mx-auto">
      @if ($message = Session::get('sukses'))
        <div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sukses!</strong> Data berhasil disimpan, Anda Akan dihubungi apabila lolos administrasi. Terima Kasih.
        </div>
      @elseif($message = Session::get('gagal'))
        <div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Gagal!</strong> Silahkan coba beberapa saat lagi.
        </div>
      @endif
      
      <div class="form-group row">
        <label for="nama" class="col-sm-2 col-form-label font-weight-bold">Nama
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10">
          <input type="text" class="form-control {{ $errors->has('nama') ? 'has-error' : '' }}" id="nama" name="nama" placeholder="Nama Pelamar" value="{{ old('nama')}}">
          @if ($errors->has('nama'))
            <span style="color: red;" class="col-sm-12">{{$errors->first('nama')}}</span>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="noktp" class="col-sm-2 col-form-label font-weight-bold">Nomor Identitas
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10">
          <input type="text" class="form-control {{ $errors->has('noktp') ? 'has-error' : '' }}" id="noktp" name="noktp" placeholder="Nomor Identitas KTP/SIM" value="{{ old('noktp')}}">
          @if ($errors->has('noktp'))
            <span style="color: red;" class="col-sm-12">{{$errors->first('noktp')}}</span>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="alamat" class="col-sm-2 col-form-label font-weight-bold">Alamat
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10">
          <input type="text" class="form-control {{ $errors->has('alamat') ? 'has-error' : '' }}" id="alamat" name="alamat" placeholder="Alamat KTP/SIM" value="{{ old('alamat')}}">
          @if ($errors->has('alamat'))
            <span style="color: red;" class="col-sm-12">{{$errors->first('alamat')}}</span>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="alamatnow" class="col-sm-2 col-form-label font-weight-bold">Alamat Sekarang</label>
        <div class="col-sm-10">
          <input type="text" class="form-control {{ $errors->has('alamatnow') ? 'has-error' : '' }}" id="alamatnow" name="alamatnow" placeholder="Alamat Sekarang" value="{{ old('alamatnow')}}">
          @if ($errors->has('alamatnow'))
            <span style="color: red;" class="col-sm-12">{{$errors->first('alamatnow')}}</span>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="tempatlahir" class="col-sm-2 col-form-label font-weight-bold">Tempat Lahir
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10">
          <input type="text" class="form-control {{ $errors->has('nama') ? 'has-error' : '' }}" id="tempatlahir" name="tempatlahir" placeholder="Tempat Lahir" value="{{ old('tempatlahir')}}">
           @if ($errors->has('tempatlahir'))
            <span style="color: red;" class="col-sm-12">{{$errors->first('tempatlahir')}}</span>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="tanggallahir" class="col-sm-2 col-form-label font-weight-bold">Tanggal Lahir
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10 row form-group" style="margin-left: 0px; margin-bottom: -10px;">
          <select id="dobday" class="form-control col-sm-2" style="margin-right: 5px;" name="tanggal" id="tanggal"></select>
          <select id="dobmonth" class="form-control col-sm-4" style="margin-right: 5px;" name="bulan" id="bulan"></select>
          <select id="dobyear" class="form-control col-sm-3" style="margin-right: 5px;" name="tahun" id="tahun"></select>
        </div>
        @if ($errors->has('tanggal'))
          <span style="color: red;" class="col-sm-12">{{$errors->first('tanggal')}}</span>
        @endif
        @if ($errors->has('bulan'))
          <span style="color: red;" class="col-sm-12">{{$errors->first('bulan')}}</span>
        @endif
        @if ($errors->has('tahun'))
          <span style="color: red;" class="col-sm-12">{{$errors->first('tahun')}}</span>
        @endif
      </div>
      <div class="form-group row">
        <label for="pendidikanterakhir" class="col-sm-2 col-form-label font-weight-bold">Pendidikan
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10">
          <input type="text" class="form-control {{ $errors->has('pendidikanterakhir') ? 'has-error' : '' }}" id="pendidikanterakhir" name="pendidikanterakhir" placeholder="Pendidikan Terakhir" value="{{ old('pendidikanterakhir')}}">
          @if ($errors->has('pendidikanterakhir'))
            <span style="color: red;" class="col-sm-12">{{$errors->first('pendidikanterakhir')}}</span>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label font-weight-bold">Email
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="email" name="email" placeholder="ex : abcd@gmail.com" value="{{ old('email')}}">
        </div>
        <div class="col-sm-1">
          <button type="button" class="btn btn-md btn-success" id="btn_cekemail"><i class="fa fa-check"></i></button>
        </div>
        @if ($errors->has('email'))
          <span style="color: red;" class="col-sm-12">{{$errors->first('email')}}</span>
        @endif
      </div>
      <div class="form-group row">
        <label for="notlp" class="col-sm-2 col-form-label font-weight-bold">No Telp/WA
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-9">
          <input type="text" class="form-control numberinput" id="notlp" name="notlp" placeholder="ex : 081234567890" value="{{ old('notlp')}}" readonly>
        </div>
        <div class="col-sm-1">
          <button type="button" class="btn btn-md btn-success" id="btn_cekwa" disabled><i class="fa fa-check"></i></button>
        </div>
        @if ($errors->has('notlp'))
          <span style="color: red;" class="col-sm-12">{{$errors->first('notlp')}}</span>
        @endif
      </div>
      <div class="form-group row">
        <label for="agama" class="col-sm-2 col-form-label font-weight-bold">Agama
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10">
          <select class="form-control" name="agama" id="agama" disabled>
            <option value="-" selected disabled>-- Pilih Agama --</option>
            <option value="islam" @if (old('agama') == 'islam') selected="selected" @endif>Islam</option>
            <option value="kristen" @if (old('agama') == 'kristen') selected="selected" @endif>Kristen</option>
            <option value="katolik" @if (old('agama') == 'katolik') selected="selected" @endif>Katolik</option>
            <option value="budha" @if (old('agama') == 'budha') selected="selected" @endif>Budha</option>
            <option value="hindu" @if (old('agama') == 'hindu') selected="selected" @endif>Hindu</option>
            <option value="konghuchu" @if (old('agama') == 'konghuchu') selected="selected" @endif>Konghuchu</option>
          </select>
        </div>
        @if ($errors->has('agama'))
          <span style="color: red;" class="col-sm-12">{{$errors->first('agama')}}</span>
        @endif
      </div>
      <div class="form-group row">
        <label for="status" class="col-sm-2 col-form-label font-weight-bold">Status
          <span style="color: red">*</span>
        </label>
        <div class="col-sm-10">
          <select class="form-control" name="status" id="status" disabled>
            <option value="-" selected disabled>-- Pilih Status --</option>
            <option value="menikah" @if (old('status') == 'menikah') selected="selected" @endif>Menikah</option>
            <option value="belum" @if (old('status') == 'belum') selected="selected" @endif>Belum Menikah</option>
          </select>
        </div>
        @if ($errors->has('status'))
          <span style="color: red;" class="col-sm-12">{{$errors->first('status')}}</span>
        @endif
      </div>
      <div class="form-group row">
        <label for="partner_name" class="col-sm-2 col-form-label font-weight-bold">Nama Suami/Stri</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="partner_name" name="partner_name" placeholder="Nama Suami/Stri" value="{{ old('partner_name')}}" readonly>
        </div>
      </div>
      <div class="form-group row">
        <label for="anak" class="col-sm-2 col-form-label font-weight-bold">Anak</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" id="anak" name="anak" placeholder="Jumlah Anak" value="{{ old('anak')}}" readonly>
        </div>
      </div>
      <div class="form-group row">
        <label class="tebal" style="color: red; float: left;">Keterangan : * Wajib diisi.</label>
      </div>
    </div>
  </div>
  <ul class="list-inline text-md-center">
    <li><a class="btn btn-lg btn-primary next-step next-button js-scroll-trigger" href="#form_wizard"> Next Step </a></li>
  </ul>
</div>