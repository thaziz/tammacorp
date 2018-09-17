<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Neraca</title>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="csrf-token" content="{{ csrf_token() }}" />
	    <link rel="shortcut icon" href="{{ asset ('assets/images/icons/favicon.ico') }}">
	    <link rel="apple-touch-icon" href="{{ asset ('assets/images/icons/favicon.png') }}">
	    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset ('assets/images/icons/favicon-72x72.png') }}">
	    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset ('assets/images/icons/favicon-114x114.png') }}">
	    <!--Loading bootstrap css-->
	{{--     <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
	    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
	    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> --}}
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery-ui-1.10.4.custom.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/font-awesome.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/animate.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/all.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/main.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/style-responsive.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/zabuto_calendar.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/pace.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.news-ticker.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap-datepicker.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/dataTables.bootstrap.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2-bootstrap.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/timepicker.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/css/ladda-themeless.min.css') }}">

	    <style type="text/css">
	      @page { margin: 10px; }

	       table{
	       	color: #333;
	       }

	      .page_break { page-break-before: always; }

	      .page-number:after { content: counter(page); }

	     	 #table-data{
				font-size: 8pt;
				margin-top: 10px;
				border: 1px solid #555;
				color: #222;
		    }
		    #table-data th{
		    	text-align: center;
		    	border: 1px solid #aaa;
		    	border-collapse: collapse;
		    	background: #ccc;
		    	padding: 5px;
		    }

		    #table-data td{
		    	border-right: 1px solid #555;
		    	padding: 5px;
		    }

		    #table-data td.currency{
		    	text-align: right;
		    	padding-right: 5px;
		    }

		    #table-data td.no-border{
		    	border: 0px;
		    }

		    #table-data td.total{
		    	background: #ccc;
		    	padding: 5px;
		    	font-weight: bold;
		    }

		    #table-data td.total.not-same{
	    		 color: red !important;
	    		 -webkit-print-color-adjust: exact;
	    	}

	      #navigation ul{
	        float: right;
	        padding-right: 110px;
	      }

	      #navigation ul li{
	        color: #fff;
	        font-size: 15pt;
	        list-style-type: none;
	        display: inline-block;
	        margin-left: 40px;
	      }

	       #form-table{
	          font-size: 8pt;
	        }

	        #form-table td{
	          padding: 5px 0px;
	        }

	        #form-table .form-control{
	          height: 30px;
	          width: 90%;
	          font-size: 8pt;
	        }
	    </style>

	    <style type="text/css" media="print">
	        @page { size: landscape; }
	        #navigation{
	            display: none;
	         }

	        #table-data td.total{
		         background-color: #ccc !important;
		         -webkit-print-color-adjust: exact;
	      	}

		     #table-data td.not-same{
		         color: red !important;
		         -webkit-print-color-adjust: exact;
		    }

	        .page-break { display: block; page-break-before: always; }
	    </style>
      
	</head>

	<body style="background: #555;">

		<div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
	        <div class="row">
	          <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
	            TammaFood
	          </div>
	          <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
	            <ul>
	              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_neraca').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Register Jurnal"></i></li>
	              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
	            </ul>
	          </div>
	        </div>
	  </div>

    <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
        <center>Neraca Sedang Dalam Perbaikan :(</center>
    </div>

	      <!-- modal -->
              <!-- Modal -->
              <div class="modal fade" id="modal_neraca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Neraca</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_neraca.index') }}" target="_self">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Jenis Periode
                        </div>

                        <div class="col-md-4">
                          <select name="jenis" class="form-control" id="jenis_periode_neraca">
                            <option value="bulan">Bulan</option>
                            <option value="tahun">Tahun</option>
                          </select>
                        </div>
                    </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-9 durasi_bulan_neraca">
                          <input type="text" name="durasi_1_neraca_bulan" placeholder="periode Mulai" class="form-control" id="d1_neraca" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-9 durasi_tahun_neraca" style="display: none;">
                          <input type="text" name="durasi_1_neraca_tahun" placeholder="periode Mulai" class="form-control" id="d1_neraca_tahun" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>
                      </div>
                    </div>
                    
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Proses</button>
                    </div>

                    </form>
                  </div>
                </div>
              </div>
		  <!-- modal -->

		<script src="{{ asset ('assets/script/jquery-2.2.4.min.js') }}"></script>
	    <script src="{{ asset ('assets/js/date-uk.js') }}"></script>
	{{--     <script src="{{ asset ('assets/js/my.js') }}"></script> --}}
	    <script src="{{ asset ('assets/js/js_ssb.js') }}"></script>
	{{--     <script src="{{ asset ('assets/script/jquery-1.10.2.min.js') }}"></script> --}}
	{{--     <script src="{{ asset ('assets/script/jquery-2.2.4.min.js') }}"></script> --}}
	    <script src="{{ asset ('assets/script/jquery-migrate-1.2.1.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery-ui.js') }}"></script>
	    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>
	    <script src="{{ asset ('assets/script/bootstrap.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/bootstrap-hover-dropdown.js') }}"></script>
	{{--     <script src="{{ asset ('assts/script/html5shiv.js') }}"></script> --}}
	    <script src="{{ asset ('assets/script/respond.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.metisMenu.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.slimscroll.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.cookie.js') }}"></script>
	    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/custom.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.news-ticker.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.menu.js') }}"></script>
	    <script src="{{ asset ('assets/script/pace.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/holder.js') }}"></script>
	    <script src="{{ asset ('assets/script/responsive-tabs.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.categories.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.pie.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.tooltip.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.resize.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.fillbetween.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.stack.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.spline.js') }}"></script>
	    <script src="{{ asset ('assets/script/zabuto_calendar.min.js') }}"></script>
	    {{-- <script src="{{ asset ('assets/script/index.js') }}"></script> --}}
	    <script src="{{ asset ('assets/script/dataTables.bootstrap.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.dataTables.js') }}"></script>
	    <script src="{{ asset ('assets/toastr/toastr.min.js') }}"></script>
	    <script src="{{ asset ('assets/select2/select2.min.js') }}"></script>
	    <!--LOADING SCRIPTS FOR CHAfRTS-->
	    <script src="{{ asset ('assets/script/highcharts.js') }}"></script>
	    <script src="{{ asset ('assets/script/data.js') }}"></script>
	    <script src="{{ asset ('assets/script/drilldown.js') }}"></script>
	    <script src="{{ asset ('assets/script/exporting.js') }}"></script>
	    <script src="{{ asset ('assets/script/highcharts-more.js') }}"></script>
	    <script src="{{ asset ('assets/script/charts-highchart-pie.js') }}"></script>
	    <script src="{{ asset ('assets/script/charts-highchart-more.js') }}"></script>
	    <!--CORE JAVASCRIPT-->
	    <script src="{{ asset ('assets/script/main.js') }}"></script>
	    <script src="{{ asset ('assets/script/timepicker.min.js') }}"></script>
	    <script src="{{asset('assets/script/jquery.maskMoney.js')}}"></script>
	    <script src="{{asset('assets/script/accounting.min.js')}}"></script>
	    <script src="{{ asset('js/iziToast.min.js') }}"></script>
	    <script src="{{asset('js/jquery-validation.min.js')}}"></script>

	    <script type="text/javascript">
	    	  // modal neraca

            $('#d2_neraca').datepicker( {
                format: "yyyy-mm",
                viewMode: "months", 
                minViewMode: "months"
            });

            $('#d1_neraca').datepicker({
              format: "yyyy-mm",
              viewMode: "months", 
              minViewMode: "months"
            })

            $('#d1_neraca_tahun').datepicker({
              format: "yyyy",
              viewMode: "years", 
              minViewMode: "years"
            })

            $('#jenis_periode_neraca').change(function(evt){
              evt.preventDefault();

              if($(this).val() == 'bulan'){
                $('.durasi_bulan_neraca').show();
                $('.durasi_tahun_neraca').hide();
              }else{
                $('.durasi_bulan_neraca').hide();
                $('.durasi_tahun_neraca').show();
              }
            })

          // modal neraca

            $('#print').click(function(evt){
              evt.preventDefault();

              window.print();
            })

	    </script>

	</body>
</html>