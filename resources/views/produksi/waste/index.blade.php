@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Data Actual SPK</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Data Actual</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Data Actual</a></li>

                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">

                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table tabelan table-bordered table-hover" id="data-actual">
                                                <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>No SPK</th>
                                                    <th>Nama Item</th>
                                                    <th>Adonan</th>
                                                    <th width="5%">Satuan</th>
                                                    <th>Kriwilan</th>
                                                    <th width="5%">Satuan</th>
                                                    <th>Sampah</th>
                                                    <th width="5%">Satuan</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /div alert-tab -->

                            <!-- div note-tab -->
                            <div id="note-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        <!-- Isi Content -->we we we
                                    </div>
                                </div>
                            </div>
                            <!--/div note-tab -->

                            <!-- div label-badge-tab -->
                            <div id="label-badge-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        <!-- Isi content -->we
                                    </div>
                                </div>
                            </div>
                            <!-- /div label-badge-tab -->
                        </div>

                    </div>
                </div>

                @endsection
                @section("extra_scripts")
                    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            var extensions = {
                                "sFilterInput": "form-control input-sm",
                                "sLengthSelect": "form-control input-sm"
                            }
                            // Used when bJQueryUI is false
                            $.extend($.fn.dataTableExt.oStdClasses, extensions);
                            // Used when bJQueryUI is true
                            $.extend($.fn.dataTableExt.oJUIClasses, extensions);
                            alert('d');
                        });

                        var data
                        -actual = $('#data-actual').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: baseUrl + "/produksi/o_produksi/tabel",
                            },
                            columns: [
                                {data: 'pr_date', name: 'pr_date'},
                                {data: 'spk_code', name: 'spk_code'},
                                {data: 'mp_name', name: 'mp_name'},
                                {data: 'i_name', name: 'i_name', orderable: false},
                                {data: 'prdt_date', name: 'prdt_date'},
                                {data: 'prdt_qty', name: 'prdt_qty', className: 'right'},
                                {data: 'prdt_status', name: 'prdt_status'},
                                {data: 'action', name: 'action'},
                            ],
                            "responsive": true,

                            "pageLength": 10,
                            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                            "language": {
                                "searchPlaceholder": "Cari Data",
                                "emptyTable": "Tidak ada data",
                                "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                                "sSearch": '<i class="fa fa-search"></i>',
                                "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                                "infoEmpty": "",
                                "paginate": {
                                    "previous": "Sebelumnya",
                                    "next": "Selanjutnya",
                                }
                            }
                        });

                    </script>
@endsection()