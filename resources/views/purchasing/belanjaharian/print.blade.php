<!DOCTYPE html>
<html>
<head>
	<title>FORM PERMINTAAN HARIAN</title>
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

	@for($i=0; $i < count($dataIsi); $i++)
		<div class="div-page-break">
				<h1 class="s16">TAMMA ROBAH INDONESIA</h1>
				<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="s16 underline bold text-center" colspan="3">FORM PERMINTAAN HARIAN</td>
					</tr>
					<tr>
						<td width="80%">
							Divisi :<label class="bold">{{$dataHeader[$i]['d_pcsh_peminta']}}</label><br>
							Keperluan :<label class="bold">{{$dataHeader[$i]['d_pcsh_keperluan']}}</label><br>
						</td>
						<td>
							No. Form : <label class="bold">{{$dataHeader[$i]['d_pcsh_code']}}</label><br>
							Tanggal : <label class="bold">{{$tanggal}}</label><br>
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="3px" class="tabel" border="1px">
					<tr class="text-center">
						<td width="20px">No</td>
						<td width="250px">Nama Barang</td>
						<td width="150px">Harga Satuan</td>
						<td width="100px">Quantity</td>
						<td width="150px">Total</td>
						<td width="300px">Keterangan</td>
					</tr>

					@for($j=0; $j<count($dataIsi[$i]); $j++)
						<tr>
							<td class="text-center">{{$j+1}}</td>
							<td>{{ $dataIsi[$i][$j]['i_name'] }}</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcshdt_price'],2,',','.') }}
								</div>
							</td>
							<td class="text-center">
								{{ $dataIsi[$i][$j]['d_pcshdt_qty']}}
							</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcshdt_pricetotal'],2,',','.')}}
								</div>
							</td>
							<td width="20%">{{ $dataIsi[$i][$j]['d_pcshdt_keterangan'] }}</td>
						</tr>
					@endfor

					<?php
						$kosong = [];
						$hitung = 10 - count($dataIsi[$i]);

						for ($a=0; $a < $hitung; $a++) { 
							array_push($kosong, 'a');
						}
					?>

					@foreach($kosong as $index => $array )
					<tr>
						<td class="text-center empty"></td>
						<td></td>
						<td></td>
						<td class="text-right"></td>
						<td class="text-right"></td>
						<td class="text-right"></td>
					</tr>
					@endforeach
					
					<tr>
						<td class="border-none-left"></td>
						<td colspan="2" class="border-none-left border-none-right"></td>
						<td class="bold text-right border-none-bottom">Total</td>
						<td>
							<div class="float-left">
								Rp.
							</div>
							<div class="float-right">
								{{number_format($hitungTotal->total_totalharga,2,',','.')}}
							</div>
						</td>
						<td class="bold text-right border-none-bottom border-none-right"></td>
					</tr>
					<tr>
						<td class="border-none-left border-none-top border-none-bottom"></td>
						<td colspan="2" class="bold" style="height: 30px;vertical-align: top;">Tanggal Pengembalian :</td>
						<td colspan="3" class="border-none-bottom border-none-right" ></td>
					</tr>
					<tr>
						<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
					</tr>
					<tr class="border-hidden">
						<td></td>
						<td>
							<div class="top">
								Mengetahui,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</td>
						<td>
							<div class="top">
								Finance,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</td>
						<td>

						</td>
						<td>
							<div class="top">
								Purchasing,
							</div>
							<div class="bottom" style="margin-top: 40px; padding-right: 80px;">
								( {{Auth::user()->m_name}} )
							</div>
						</td>
						<td>
							<div class="top" style="padding-left: 80px;">
								Pemohon,
							</div>
							<div class="bottom" style="margin-top: 40px; padding-left: 80px;">
								(......................................)
							</div>
						</td>
					</tr>
				</table>
		</div>
		@endfor
	</div>
	
	<div style="padding-top: 30px;">
		<hr>
	</div>

	<div class="div-width">

	@for($i=0; $i < count($dataIsi); $i++)
		<div class="div-page-break">
				<h1 class="s16" style="padding-top: 20px;">TAMMA ROBAH INDONESIA</h1>
				<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="s16 underline bold text-center" colspan="3">FORM PERMINTAAN HARIAN</td>
					</tr>
					<tr>
						<td width="80%">
							Divisi :<label class="bold">{{$dataHeader[$i]['d_pcsh_peminta']}}</label><br>
							Keperluan :<label class="bold">{{$dataHeader[$i]['d_pcsh_keperluan']}}</label><br>
						</td>
						<td>
							No. Form : <label class="bold">{{$dataHeader[$i]['d_pcsh_code']}}</label><br>
							Tanggal : <label class="bold">{{$tanggal}}</label><br>
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="3px" class="tabel" border="1px">
					<tr class="text-center">
						<td width="20px">No</td>
						<td width="250px">Nama Barang</td>
						<td width="150px">Harga Satuan</td>
						<td width="100px">Quantity</td>
						<td width="150px">Total</td>
						<td width="300px">Keterangan</td>
					</tr>

					@for($j=0; $j<count($dataIsi[$i]); $j++)
						<tr>
							<td class="text-center">{{$j+1}}</td>
							<td>{{ $dataIsi[$i][$j]['i_name'] }}</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcshdt_price'],2,',','.') }}
								</div>
							</td>
							<td class="text-center">
								{{ $dataIsi[$i][$j]['d_pcshdt_qty']}}
							</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcshdt_pricetotal'],2,',','.')}}
								</div>
							</td>
							<td width="20%">{{ $dataIsi[$i][$j]['d_pcshdt_keterangan'] }}</td>
						</tr>
					@endfor

					<?php
						$kosong = [];
						$hitung = 10 - count($dataIsi[$i]);

						for ($a=0; $a < $hitung; $a++) { 
							array_push($kosong, 'a');
						}
					?>

					@foreach($kosong as $index => $array )
					<tr>
						<td class="text-center empty"></td>
						<td></td>
						<td></td>
						<td class="text-right"></td>
						<td class="text-right"></td>
						<td class="text-right"></td>
					</tr>
					@endforeach
					
					<tr>
						<td class="border-none-left"></td>
						<td colspan="2" class="border-none-left border-none-right"></td>
						<td class="bold text-right border-none-bottom">Total</td>
						<td>
							<div class="float-left">
								Rp.
							</div>
							<div class="float-right">
								{{number_format($hitungTotal->total_totalharga,2,',','.')}}
							</div>
						</td>
						<td class="bold text-right border-none-bottom border-none-right"></td>
					</tr>
					<tr>
						<td class="border-none-left border-none-top border-none-bottom"></td>
						<td colspan="2" class="bold" style="height: 30px;vertical-align: top;">Tanggal Pengembalian :</td>
						<td colspan="3" class="border-none-bottom border-none-right" ></td>
					</tr>
					<tr>
						<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
					</tr>
					<tr class="border-hidden">
						<td></td>
						<td>
							<div class="top">
								Mengetahui,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</td>
						<td>
							<div class="top">
								Finance,
							</div>
							<div class="bottom" style="margin-top: 40px;">
								(......................................)
							</div>
						</td>
						<td>

						</td>
						<td>
							<div class="top">
								Purchasing,
							</div>
							<div class="bottom" style="margin-top: 40px; padding-right: 80px;">
								( {{Auth::user()->m_name}} )
							</div>
						</td>
						<td>
							<div class="top" style="padding-left: 80px;">
								Pemohon,
							</div>
							<div class="bottom" style="margin-top: 40px; padding-left: 80px;">
								(......................................)
							</div>
						</td>
					</tr>
				</table>
		</div>
		@endfor
	</div>
</body>
</html>