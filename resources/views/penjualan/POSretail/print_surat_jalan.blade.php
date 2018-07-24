<!DOCTYPE html>
<html>
<head>
	<title>Surat Jalan</title>
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
			border-right: none;
		}
		.border-none-left{
			border-left:none;
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
		table.border-none ,.border-none td{
			border:none !important;
		}
		@media print {
			.button-group{
				display: none;
			}
			@page {
				size: portrait;
			}
		}
		@page { 
			margin: 0; 
		}
	</style>
</head>
<body>
	<div class="button-group">
		<button onclick="prints()">Print</button>
	</div>

	<?php $totalDis = 0 ?>

	<div class="div-width">

		@for($i=0;$i < count($data);$i++)

			<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="s16 italic bold" width="35%">TAMMA ROBAH INDONESIA</td>
					<td class="s16" width="30%"><p class="underline text-center">Surat Jalan</p></td>
					<td class="s16" width="35%">Surabaya, <text class="bold">{{$sales->s_date}}</text></td>
				</tr>
				<tr>
					<td>Jl. Raya Randu no.74<br>
						Sidotopo Wetan - Surabaya 60123<br>
						Telp. 031-51165528<br>
						Fax. 081331100028-081234561066<br>
						http:://www.tammafood.com
					</td>
					<td class="text-center">{{ $sales->s_note }}</td>
					<td>Kepada Yth,<br>
						{{$sales->c_name}}<br>
						{{$sales->c_address}}
					</td>
				</tr>
			</table>
			<table width="100%" cellspacing="0" class="tabel" border="1px">
				<tr class="text-center">
					<td width="1%">No</td>
					<td>Kode Barang</td>
					<td>Nama Barang</td>
					<td colspan="2">Unit</td>
				</tr>

				@for($j=0;$j < count($data[$i]);$j++)

					@if(count($data[$i])==10)
						<tr>
							<td class="text-center">{{ $j+1 }}</td>
							<td>{{ $data[$i][$j]->i_code }}</td>
			            	<td>{{ $data[$i][$j]->i_name }}</td>
							<td class="text-right" colspan="2">{{$data[$i][$j]->sd_qty}}&nbsp;{{ $data[$i][$j]->m_sname }}</td>
						</tr>
					@else
						<tr>
							<td class="text-center">{{ $j+1 }}</td>
							<td>{{ $data[$i][$j]->i_code }}</td>
			            	<td>{{ $data[$i][$j]->i_name }}</td>
							<td class="text-right" colspan="2">{{$data[$i][$j]->sd_qty}}&nbsp;{{ $data[$i][$j]->m_sname }}</td>
						</tr>
					@endif

				@endfor
				<?php
				$hitung = count($data[$i]);
				$total = 12 - $hitung;
				$array = [];

					for ($l=0; $l < $total; $l++) { 
						array_push($array, 'b');
					}
				?>
				@foreach($array as $a)
					<tr>
						<td class="text-center empty"></td>
						<td></td>
						<td></td>
						<td class="text-right" colspan="2"></td>
					</tr>
				@endforeach

			<tr>
				<td colspan="3" class="border-none-right">Koli :</td>
				
				<td class="border-none-right border-none-left">Jumlah</td>
				<td class="border-none-left text-right">{{ number_format($dataTotal[0]->total,2,'.',',')}}</td>
			</tr>
			<tr>
				<td colspan="3" class="vertical-baseline border-none-right" style="position: relative;">
					
					<div class="float-left" style="width: 40vw;">
						<ul style="padding-left: -15px;">
							<li>Barang yang sudah dibeli tidak bisa dikembalikan lagi kecuali ada perjanjian</li>
							<li>Keterlambatan, kehilangan atau kerusakan barang selama pengiriman tidak menjadi tanggung jawab kami.</li>
							<li>Klaim dilayani 1x24 jam setelah barang diterima</li>
						</ul>
					</div>
					<div class="float-right text-center" style="margin-top: 15px;height: 60px;width: 40%;position: absolute;right: 0;bottom: 25px;">
						<div>Hormat Kami</div>
						<div style="margin:auto;border-bottom: 1px solid black;width: 150px;height: 55px;"></div>
						<div>Admin</div>
					</div>
				</td>
				<td colspan="2" class="border-none-left">
					<!-- Empty -->
				</td>
			</tr>
		</table>

		@endfor

			
			
	</div>
	<script type="text/javascript">
		function prints()
		{
			window.print();
		}
	</script>
</body>
</html>