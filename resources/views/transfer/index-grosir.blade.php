@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Transfer Retail</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Transfer Retail</li>
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
                                
                     
                <div id="generalTabContent" class="tab-content responsive">
                        <div id="data-transfer">
                        </div>
                </div>
                   
                 
        </div>
        <!-- End div generalTab -->
      </div>
    </div>
  </div>
</div>  
@endsection
@section("extra_scripts")

    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>

    <script type="text/javascript">

    datax();
    function datax(){
         $.ajax({
                    url         : baseUrl+'/transfer/data-transfer',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer').html(response);
                        }
                    });
     }

     function edit($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/'+$id+'/edit',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer').html(response);
                        }
            });
     }


     function hapus($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/'+$id+'/hapus',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer').html(response);
                        }
            });
     }



    </script>
    
@endsection()