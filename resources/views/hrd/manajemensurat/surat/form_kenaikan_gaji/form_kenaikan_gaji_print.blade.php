<!DOCTYPE html>
<html>
<head>
	<title>FORM KENAIKAN GAJI ATAU TINGKAT</title>
	<style type="text/css">
		*:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small):not(label){
			font-size: 14px;
		}
		.s16{
			font-size: 16px !important;
		}
		.div-width{
			width: 900px;
			padding: 0 15px 15px 15px;
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
				padding: 170px 15px 15px 15px;
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
		<div class="div-width-background">
		</div>
		<header>
			<img width="100%" src="{{asset('assets/img/header-tammafood-surat.png')}}">
		</header>
			
	<div class="div-width">

		<h2 style="margin: 30px 15px 0 15px;">FORMULIR KENAIKAN GAJI ATAU TINGKAT KARYAWAN</h2>
		<small style="margin: 15px 15px 15px 15px;">FM-SDM-01-2018</small>

		<table width="100%" class="border-none" style="margin: 30px 15px 15px 15px;">
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td colspan="2">Alpha</td>
			</tr>
			<tr>
				<td>Departemen</td>
				<td>:</td>
				<td colspan="2">1</td>
			</tr>
			<tr>
				<td>Tanggal Mulai Kerja</td>
				<td>:</td>
				<td colspan="2">28 Sep 2018</td>
			</tr>
			<tr>
				<td>Kenaikan</td>
				<td>:</td>
				<td><label><input type="radio" disabled="" value="gaji" name="">Gaji</label></td>
				<td><label><input type="radio" disabled="" value="tingkat" name="">Grade/Tingkat</label></td>
			</tr>
			
		</table>

		<table width="100%" style="margin-top: 30px;margin-bottom: 15px;">
			<tr>
				<td width="25%"></td>
				<td width="35%">Kondisi saat ini</td>
				<td width="35%">Diusulkan</td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Grade/Tingkat</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Gaji</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Efektif per Tanggal</td>
				<td></td>
				<td></td>
			</tr>
		</table>

		<label class="bold">Alasan Kenaikan</label>
		<p>Berhasil merampok bank sebesar Rp. 100.000.000.000.000,00 (Seratus Triliun Rupiah)</p>


		<table width="100%">
			<tr>
				<td colspan="2" class="border-none-bottom top" style="height: 70px;">
					
						Diusulkan oleh,
					
				</td>
			</tr>
			<tr>
				<td class="border-none-right">
					<div class="border-top ttd">
						Nama / Jabatan
					</div>
				</td>
				<td>
					<div class="float-left">
						Tanggal : 28 Sep 2018
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="border-none-bottom top" style="height: 70px;">
					
						Diusulkan oleh,
					
				</td>
			</tr>
			<tr>
				<td class="border-none-right">
					<div class="border-top ttd">
						Kepala HRD
					</div>
				</td>
				<td>
					<div class="float-left">
						Tanggal : 
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="border-none-bottom top" style="height: 70px;">
					
						Diusulkan oleh,
					
				</td>
			</tr>
			<tr>
				<td class="border-none-right">
					<div class="border-top ttd">
						Direktur Utama
					</div>
				</td>
				<td>
					<div class="float-left">
						Tanggal : 
					</div>
				</td>
			</tr>
		</table>
	</div>
		<footer>
			<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
		</footer>
</body>
</html>