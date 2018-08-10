<!DOCTYPE html>
<html>
<head>
	<title>FORM ORDER PEMBELIAN</title>
	<style type="text/css">
		*{
			font-size: 12px;
		}
		.s16{
			font-size: 14px !important;
		}
		.div-width{
			margin: auto;
			width: 95vw;
		}
		.underline{
			text-decoration: underline;
		}
		.italic{
			font-style: italic;
		}
		.bold{
			font-weight: bold;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-top{
			border-top: hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-all{
			border: hidden;
		}
		.float-left{
			float: left;
		}
		.float-right{
			float: right;
		}
		.top{
			vertical-align: text-top;
		}
		.vertical-baseline{
			vertical-align: baseline;
		}
		.bottom{
			vertical-align: text-bottom;
		}
		.ttd{
			top: 0;
			position: absolute;
		}
		.relative{
			position: relative;
		}
		.absolute{
			position: absolute;
		}
		.empty{
			height: 15px;
		}
		table,td{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td, .border-none tr{
			border:none !important;
		}
		@media print{
			.btn-print{
				display: none;
			}
		}
		@page{
			size: landscape;
			margin: 0;
		}
		.div-page-break{
			page-break-after: always;
		}
		.border-hidden tr, .border-hidden td{
			border: hidden;
		}
		.btn-print{
			right: 10px;
			position: absolute;
		}
</style>
</head>
<body>
	<div class="btn-print">
		<button onclick="javascript:window.print();">Print</button>
	</div>
	<div class="div-width">

	@for($i=0;$i<count($dataIsi);$i++)
	
		<div class="div-page-break">
				<h1 class="s16">TAMMA ROBAH INDONESIA</h1>
				<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="s16 underline bold text-center" colspan="3">FORM ORDER PEMBELIAN</td>
					</tr>
					<tr>
						<td width="70%">
							No Order Pembelian : <label class="bold">{{$dataHeader[0]['d_pcs_code']}}</label><br>
							Tanggal Order Pembelian : <label class="bold">{{date('d M Y',strtotime($dataHeader[0]['d_pcs_date_created']))}}</label><br>
							
						</td>
						<td>
							Cara Pembayaran : <label class="bold">{{$dataHeader[0]['d_pcs_method']}}</label><br>
							Nama Staff : <label class="bold">{{$dataHeader[0]['m_name']}}</label><br>
							Suplier : <label class="bold">{{$dataHeader[0]['s_name']}}</label>
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="3px" class="tabel" border="1px">
					<tr class="text-center">
						<td>No</td>
						<td>Nama Item</td>
						<td>Satuan</td>
						<td>Quantity</td>
						<td>Stock Gudang</td>
						<td>Harga Prev</td>
						<td>Harga</td>
						<td>Total</td>
					</tr>

					@for($j=0;$j<count($dataIsi[$i]);$j++)
						<tr>
							<td width="1%" class="text-center">{{$j+1}}</td>
							<td>{{$dataIsi[$i][$j]['i_name']}}</td>
							<td width="1%" class="text-center">{{$dataIsi[$i][$j]['m_sname']}}</td>
							<td width="1%">{{$dataIsi[$i][$j]['d_pcsdt_qty']}}</td>
							<td width="1%">0{{-- {{$dataStok->val_stok[$i]['qtyStok']}} --}}</td>
							<td width="15%">
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcsdt_prevcost'],2,',','.')}}
								</div>
							</td>
							<td width="15%">
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcsdt_price'],2,',','.')}}
								</div>
							</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcsdt_total'],2,',','.')}}
								</div>
							</td>
						</tr>
					@endfor


					<?php
						$kosong = [];
						$hitung = 10 - count($dataIsi[$i]);

						for ($a=0; $a < $hitung; $a++) { 
							array_push($kosong, 'a');
						}
					?>
					@foreach($kosong as $index => $we)
					<tr>
						<td class="text-center empty"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforeach
					
					
					<tr>
						<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
					</tr>
					<tr class="border-hidden">
						<td colspan="2">Gross : <label class="bold">Rp. {{number_format($dataHeader[0]['d_pcs_total_gross'],2,',','.')}}</label></td>
						
					</tr>
					<tr class="border-hidden">
						<td colspan="2">Disc Total : <label class="bold">Rp. {{number_format($dataHeader[0]['disc_total'],2,',','.')}}</label></td>
						
					</tr>
					<tr class="border-hidden">
						<td colspan="2">Tax : <label class="bold">Rp. {{number_format($dataHeader[0]['d_pcs_tax_value'],2,',','.')}}</label></td>
						
					</tr>
					<tr class="border-hidden">
						<td colspan="2">Nett : <label class="bold">Rp. {{number_format($dataHeader[0]['d_pcs_total_net'],2,',','.')}}</label></td>
						
						<td colspan="4">Total : <label class="bold">Rp. {{number_format($dataHeader[0]['d_pcs_total_net'],2,',','.')}}</label></td>
						
					</tr>
					<tr class="border-hidden">
						<td class="empty"></td>
					</tr>
				</table>
						<div class="float-left" style="margin-left: 3vw;">
							<div class="top">
								Mengetahui,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</div>
						<div class="float-left" style="margin-left: 25px;">
							<div class="top">
								Finance,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</div>
						<div class="float-right" style="margin-right: 25px;">
							<div class="top">
								Pemohon,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</div>
						<div class="float-right" style="margin-right: 3vw;">
							<div class="top">
								Purchasing,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</div>
		</div>
		
	@endfor
		
	</div>
</body>
</html>