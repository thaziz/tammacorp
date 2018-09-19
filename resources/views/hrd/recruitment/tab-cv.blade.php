<div class="tab-pane" role="tabpanel" id="step2">
    <h1 class="text-md-center">Daftar Riwayat Hidup</h1>
    <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="perusahaan1" class="col-sm-2 col-form-label font-weight-bold">Nama Perusahaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="perusahaan1" name="perusahaan1" placeholder="Nama Perusahaan" value="{{ old('perusahaan1')}}">
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="tahun1" class="col-sm-2 col-form-label font-weight-bold">Tahun</label>
            <div class="col-sm-5">
              <select id="dob_cv_awal1" class="form-control" style="margin-right: 5px;" name="dob_cv_awal1"></select>
            </div>
            <div class="col-sm-5">
              <select id="dob_cv_akhir1" class="form-control" style="margin-right: 5px;" name="dob_cv_akhir1"></select>
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="jobdesc1" class="col-sm-2 col-form-label font-weight-bold">Job Desc</label>
            <div class="col-sm-10">
              <textarea name="jobdesc1" id="jobdesc1" maxlength="300" cols="30" rows="3" class="form-control" placeholder="Job Desc (Maks : 300 Karakter)">{{ old('jobdesc1')}}</textarea>
            </div>
          </div>
        </div>

        <div style="border-top:1px solid #e0e0e0;margin-bottom: 10px;width: 100%;"></div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="perusahaan2" class="col-sm-2 col-form-label font-weight-bold">Nama Perusahaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="perusahaan2" name="perusahaan2" placeholder="Nama Perusahaan" value="{{ old('perusahaan2')}}">
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="tahun2" class="col-sm-2 col-form-label font-weight-bold">Tahun</label>
            <div class="col-sm-5">
              <select id="dob_cv_awal2" class="form-control" style="margin-right: 5px;" name="dob_cv_awal2"></select>
            </div>
            <div class="col-sm-5">
              <select id="dob_cv_akhir2" class="form-control" style="margin-right: 5px;" name="dob_cv_akhir2"></select>
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="jobdesc2" class="col-sm-2 col-form-label font-weight-bold">Job Desc</label>
            <div class="col-sm-10">
              <textarea name="jobdesc2" id="jobdesc2" maxlength="300" cols="30" rows="3" class="form-control" placeholder="Job Desc (Maks : 300 Karakter)">{{ old('jobdesc2')}}</textarea>
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label class="tebal" style="color: black; float: left;">Skip Halaman ini apabila anda Fresh Graduate.</label>
          </div>
        </div>

    </div>

    <ul class="list-inline text-md-center">
        <li><a class="btn btn-lg btn-primary next-step next-button js-scroll-trigger" href="#form_wizard">Next Step</a></li>
        <li><a href="#form_wizard" class="btn btn-lg btn-common prev-step next-button js-scroll-trigger">Back</a></li>
    </ul>
</div>
