@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Data Jabatan</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li>
                <i class="fa fa-home"></i>&nbsp;
                <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
                <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li>
                <i></i>&nbsp;HRD&nbsp;&nbsp;
                <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Data Jabatan</li>
            <li>
                <i class="fa fa-angle-right"></i>&nbsp;Tambah Data Jabatan&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <div class="page-content">
        <div id="tab-general">
            <div class="row mbl">
                <div class="col-lg-12">

                    <div class="col-md-12">
                        <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                        </div>
                    </div>

                    <ul id="generalTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#alert-tab" data-toggle="tab">Data Jabatan</a>
                        </li>
                        <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                        <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px; margin-bottom: 10px;">
                                    <div class="col-md-5 col-sm-6 col-xs-8">
                                        <h4>Tambah Data Jabatan</h4>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                                        <a href="{{ url('hrd/datajabatan/datajabatan') }}" class="btn">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                    <form method="POST" class="form" action="{{ url('hrd/datajabatan/simpan-jabatan') }}" enctype="multipart/form-data" style="font-family:Arial;">
                                        {{ csrf_field() }}
                                        <table class="table">
                                            <tr>
                                                <td class="col-sm-2">
                                                    <label>Kode</label>
                                                </td>
                                                <td class="col-sm-1">
                                                    <label>:</label>
                                                </td>
                                                <td>
                                                    <div class="col-sm-12">
                                                        <input disabled type="text" name="c_id" value="{{$data->c_id}}" placeholder="Kode Jabatan" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Divisi</label>
                                                </td>
                                                <td>
                                                    <label>:</label>
                                                </td>
                                                <td>
                                                    <div class="col-sm-12">
                                                        <select id="divisi" name="c_divisi_id" class="form-control input-sm">
                                                            <option>--pilih divisi--</option>
                                                            <?php foreach($divisi as $div){ ?>
																															<?php if($div->c_id == $data->c_divisi_id){ ?>
																															<option value="{{ $div->c_id }}" selected="">{{ $div->c_divisi }}</option>
																															<?php }else{ ?>
																															<option value="{{ $div->c_id }}">{{ $div->c_divisi }}</option>
																														<?php }} ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Nama Jabatan</label>
                                                </td>
                                                <td>
                                                    <label>:</label>
                                                </td>
                                                <td>
                                                    <div class="col-sm-12">
                                                        <input type="text" value="{{$data->c_posisi}}" name="c_posisi" placeholder="Nama" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="col-sm-12">
                                            <input type="submit" value="Simpan" class="btn btn-warning pull-right">
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection @section('extra_scripts')
            <script type="text/javascript">
                function klik() {
                    swal({
                        title: "Apa anda yakin?",
                        text: "Data Yang Dihapus Tidak Dapat Dikembalikan",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                swal("Deleted!", "Your imaginary data has been delete.", "success");
                            } else {
                                swal("Cancelled", "Your imaginary data is safe :)", "error");
                            }
                        });
                }
            </script> @endsection