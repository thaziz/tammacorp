@extends('main')

@section('extra_styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/datepicker/datepicker.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/toast/dist/jquery.toast.min.css') }}">

    <style>
      .transaksi-wrapper{
      	border: 1px solid #eee;
      	border-radius: 10px;
      	box-shadow: 0px 0px 10px #ccc;
      	text-align: center;
      	background: none;
      	margin-left: 4.8em;
      }

      .transaksi-wrapper .icon{
      	padding: 70px 0px 45px 0px;
      	background: none;
      	border-bottom: 1px solid #eee;
      }

      .transaksi-wrapper .icon i{
      	font-size: 75pt;
      }

      .transaksi-wrapper .text{
      	color: #999;
      	font-size: 14pt;
      	padding: 20px 0px;
      	cursor: pointer;
      }

      .transaksi-wrapper .text:hover{
      	color: #0d47a1;
      }
    </style>
@endsection

@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="vue-element">
              <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Pilihan Transaksi</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Input Pilihan Transaksi</li>
                    </ol>
                    <div class="clearfix"></div>
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
                            {{-- <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Akun Keuangan</a></li> --}}
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                          </ul>

                          <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 transaksi-wrapper">
                                    	<div class="col-md-12 icon">
                                    		<i class="fa fa-usd" style="color: #007E33;"></i>
                                    	</div>

                                    	<div class="col-md-12 text">
                                    		<a href="{{ url('/keuangan/p_inputtransaksi/transaksi_kas') }}">Transaksi Kas</a>
                                    	</div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                    	<div class="col-md-12 icon">
                                    		<i class="fa fa-university" style="color: #FF8800;"></i>
                                    	</div>

                                    	<div class="col-md-12 text">
                                    		<a href="{{ url('/keuangan/p_inputtransaksi/transaksi_bank') }}">Transaksi Bank</a>
                                    	</div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                    	<div class="col-md-12 icon">
                                    		<i class="fa fa-file-text" style="color: #CC0000;"></i>
                                    	</div>

                                    	<div class="col-md-12 text">
                                    		<a href="{{ url('/keuangan/p_inputtransaksi/transaksi_memorial') }}">Transaksi Memorial</a>
                                    	</div>
                                    </div>
                                </div>                                       
                              </div>
                            </div>    
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
                            
@endsection

@section("extra_scripts")
  
@endsection                            
