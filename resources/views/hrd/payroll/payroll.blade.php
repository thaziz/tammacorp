@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Payroll</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Payroll</li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="page-content fadeInRight">
                    <div id="tab-general">
                        <div class="row mbl">
                            <div class="col-lg-12">

                                            <div class="col-md-12">
                                                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                                                </div>
                                            </div>

                            <ul id="generalTab" class="nav nav-tabs">
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Payroll</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive" >
                            <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row">
                           <div class="col-lg-12">





    <div class="pull-right" style="margin-bottom: 10px;">
    <a href="{{ url('hrd/payroll/tambah_payroll') }}"><button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                               <i class="fa fa-plus" aria-hidden="true">
                                   &nbsp;
                               </i>Tambah Data
                            </button></a>
    </div>
          <div class="table-responsive">
            <table class="table tabelan table-hover table-bordered data-table" width="100%" cellspacing="0" id="data">
                          <thead>
                            <tr>
                              <th>Tanggal Pengajian</th>
                                <th>jumlah Pegawai</th>
                                <th>Total Gaji Pegawai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                          </thead>

                          <tbody>
                          </tbody>


            </table>
          </div>

                    </div>
                        </div>

                                    </div>
                                         </div>
                            </div>
@endsection
@section('extra_scripts')
<script type="text/javascript">
function klik(){
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
  function(isConfirm) {
  if (isConfirm) {
  swal("Deleted!", "Your imaginary data has been delete.", "success");
  } else {
  swal("Cancelled", "Your imaginary data is safe :)", "error");
  }
  });
}
</script>
@endsection
