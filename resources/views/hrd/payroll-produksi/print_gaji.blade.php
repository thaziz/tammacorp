<!DOCTYPE html>
<html>
<head>
	<title>Slip Gaji Produksi</title>
	<style type="text/css">
		*:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small):not(label){
			font-size: 14px;
		}
		.s16{
			font-size: 16px !important;
		}
		.div-width{
			width: 900px;
			padding: 50px 15px 15px 15px;
			background: transparent;
			position: relative;
		}
		.div-width-background{
			content: "";
			background-image: url("{{asset('assets/img/background-tammafood-surat.jpg')}}");
			background-repeat: no-repeat;
			background-position: center; 
			background-size: 700px 700px;
			position: absolute;
			z-index: -1;
			margin-top: 170px;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			opacity: 0.1; 
			width: 900px;
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
		.text-left{
			text-align: left;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-top{
			border-top: hidden;
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
			width: 150px;
		}
		.relative{
			position: relative;
		}
		.absolute{
			position: absolute;
		}
		.empty{
			height: 18px;
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
		.position-top{
			vertical-align: top;
		}
		@page {
			size: portrait;
			margin:0 0 0 0;
		}
		@media print {
			.div-width{
				margin: auto;
				padding: 10px 15px 15px 15px;
				width: 95vw;
				position: relative;
			}
			.btn-print{
				display: none;
			}
			header{
				top:0;
				left: 0;
				right: 0;
				position: absolute;
				width: 100%;
			}
			footer{
				bottom: 0;
				left: 0;
				right: 0;
				position: absolute;
				width: 100%;
			}
			.div-width-background{
				content: "";
				background-image: url("{{asset('assets/img/background-tammafood-surat.jpg')}}");
				background-repeat: no-repeat;
				background-position: center; 
				background-size: 700px 700px;
				position: absolute;
				z-index: -1;
				margin: auto;
				opacity: 0.1; 
				width: 95vw;
			}
		}
		fieldset{
			border: 1px solid black;
			margin:-.5px;
		}
		header{
			top: 0;
			width: 900px;
		}
		footer{
			bottom: 0;
			width: 900px;
		}
		.border-top{
			border-top: 1px solid black;
		}
		.btn-print{
			position: fixed;
			width: 100%;
			text-align: right;
			left: 0;
			top: 0;
			background: rgba(0,0,0,.2);
		}
		.btn-print button, .btn-print a{
			margin: 10px;
		}
	</style>
</head>
<body>
	<div class="btn-print" align="right">
		<button onclick="javascript:window.print();">Print</button>
	</div>

	<?php
setlocale(LC_ALL, 'IND');
?>

		
	<div class="div-width">

		<table width="50%" class="border-none">
			<tr>
				<td>Nama Pegawai</td>
				<td width="3%">:</td>
				<td>{{ $garapan[0]->c_nama }}</td>
			</tr>
			<tr>
				<td>Jabatan Pegawai</td>
				<td>:</td>
				<td>{{ $garapan[0]->c_jabatan_pro }}</td>
			</tr>
			<tr>
				<td>Periode</td>
				<td>:</td>
				<td>{{ strftime('%A', strtotime($tgl1)) }} - {{ strftime('%A', strtotime($tgl2)) }}</td>
			</tr>
		</table>

		<table width="100%" cellpadding="3px" style="margin-top: 15px;">
			<tr class="bold">
				<td width="40%">Nama Item</td>
				<td width="10%">Reguler</td>
				<td width="25%">Harga</td>
				<td width="25%">Total</td>
			</tr>
			@foreach($garapan as $data)
			<tr>
				<td>{{ $data->nm_gaji }}</td>
                <td class="text-right">{{ number_format( $data->dataGaji + $data->dataLembur,0,'.',',') }}</td>
                <td class="text-right">{{ number_format( $data->c_gaji,0,'.',',') }}</td>
                <td class="text-right">{{ number_format(( $data->dataGaji+ $data->dataLembur) * $data->c_gaji,0,'.',',') }}</td>
			</tr>
			@endforeach
		</table>

		<table width="100%" cellpadding="3px" style="margin-top: 15px;">
			<tr class="bold">
				<td width="40%">Nama Item</td>
				<td width="10%">Reguler</td>
				<td width="25%">Harga</td>
				<td width="25%">Total</td>
			</tr>
			@foreach ($garapan as $data)
                <tr>
                    <td>{{ $data->nm_gaji }}</td>
                    <td class="text-right">{{ number_format($data->dataLembur,0,'.',',') }}</td>
                    <td class="text-right">{{ number_format($data->c_lembur,0,'.',',') }}</td>
                    <td class="text-right">{{ number_format($data->dataLembur * $data->c_lembur,0,'.',',') }}</td>
                </tr>

	        @endforeach
	        <tr>
                    <td colspan="3" style="text-align:left;font-weight: bold;">Pendapatan Total</td>
                    <td  class="text-right" style="font-weight: bold;">{{ number_format($total,0,'.',',') }}</td>
	        </tr>
		</table>
	</div>
		
</body>
</html>