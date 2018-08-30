@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Stock Opname</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Stock Opname</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Stock Opname</a></li>
                            <li><a href="#note-tab" data-toggle="tab">Daftar Stock Opname</a></li>
                            <!--  <li><a href="#label-badge-tab" data-toggle="tab">Belanja Harian</a></li> -->
                        </ul>

                        <div id="generalTabContent" class="tab-content responsive">

                            <!-- Div #alert-tab -->
                        @include('inventory.stockopname.daftar')
                        <!-- End Div #alert-tab -->

                            <!-- Div #note-tab -->
                        @include('inventory.stockopname.history')
                        <!-- End Div #note-tab -->

                            <!-- Div #label-badge-tab -->
                            <div id="label-badge-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- Isi Content -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Div #label-badge-tab -->

                        </div>

                    </div>

                </div>

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

            $('#tabelOpname').DataTable();

            var date = new Date();
            var newdateIndex = new Date(date);
            var newdate = new Date(date);

            newdateIndex.setDate(newdate.getDate() - 30);
            newdate.setDate(newdate.getDate() - 3);

            var ndi = new Date(newdateIndex);
            var nd = new Date(newdate);

            $('.datepicker').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            }).datepicker("setDate", ndi);

            $('.datepicker1').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            }).datepicker("setDate", nd);

            $('.datepicker2').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            });

        });

        function pilihGudang()
        {
            var x = document.getElementById("pemilik").value;
            var y = document.getElementById("posisi").value;
            $.ajax({
                url: baseUrl + '/inventory/namaitem/tableopname/'+x+'/'+y,
                type: 'GET',
                success: function (response) {
                  var tableOpname = $('#tabelOpname').DataTable({
                   responsive: true,
                   destroy: true,
                   paging: false,
                   "scrollY": 500,
                   "scrollX": true,
                   // processing: true,
                   // serverSide: true,
                   ajax: {
                       url: baseUrl + '/inventory/namaitem/tableopname/'+x+'/'+y,
                   },
                   columns: [
                       {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, width: '5%'},
                       {data: 'item', name: 'item'},
                       {data: 's_qty', name: 's_qty'},
                       {data: 'm_sname', name: 'm_sname', orderable: false},
                       {data: 'real', name: 'real', orderable: false},
                       {data: 'ket', name: 'ket', orderable: false, searchable: false},
                   ],
           });
                }
              })
        }

        function simpanOpname(){
          $('.kirim-opname').attr('disabled', 'disabled');
          var a = $('#opname :input').serialize();
          var b = $('#tbOpname :input').serialize();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            url: baseUrl + '/inventory/namaitem/simpanopname',
            type: 'POST',
            data:a + '&' + b,
            success: function (response, nota) {
              if (response.status == 'sukses') {
                $('#tbOpname')[0].reset();
                var nota = response.nota.o_nota;
                iziToast.success({
                    timeout: 5000,
                    position: "topRight",
                    icon: 'fa fa-chrome',
                    title: nota,
                    message: 'Telah terkirim.'
                });
                $('.kirim-opname').removeAttr('disabled', 'disabled');
              }else {
                iziToast.error({
                    position: "topRight",
                    title: '',
                    message: 'Mohon melengkapi data.'
                });
                $('.kirim-opname').removeAttr('disabled', 'disabled');
              }
            }
          });
        }

    </script>
@endsection
