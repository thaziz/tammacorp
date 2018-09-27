<!DOCTYPE html>
<html>
<head>
	<title>FORM LAPORAN LEADER</title>
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
		table,td,th{
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
		}
		fieldset{
			border: 1px solid black;
			margin:-.5px;
		}
		header{
			top: 0;
			width: 900px;
			z-index: 99;
		}
		footer{
			bottom: 0;
			width: 900px;
			z-index: 99;
		}
		.border-top{
			border-top: 1px solid black;
		}
		.border-bottom{
			border-bottom: 1px solid black;
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
	<div class="btn-print">
		<button onclick="javascript:window.print();">Print</button>
	</div>
		<header>
			<img width="100%" src="{{asset('assets/img/header-tammafood-surat.png')}}">
		</header>
	<div class="div-width">

		<h2 style="margin: 30px 15px 0 15px;">FORM LAPORAN LEADER</h2>
		<small style="margin: 15px 15px 15px 15px;">FM-SDM-01-2018</small>

		<table width="100%" class="border-none" style="margin: 30px 15px 0 15px;">
			<tr>
				<td>PIC</td>
				<td>:</td>
				<td>Alpha</td>
			</tr>
			<tr>
				<td>Divisi</td>
				<td>:</td>
				<td>1</td>
			</tr>
			<tr>
				<td>Hari</td>
				<td>:</td>
				<td>28 Sep 2018</td>
			</tr>
			<tr>
				<td class="italic" colspan="3">(Tuliskan 6 pekerjaan harian rutin dan 6 pekerjaan yang akan di lakukan besok)</td>
			</tr>
			
		</table>

		<table width="100%" style="margin-bottom: 15px;">
			<thead class="top">
				<tr>
					<th width="5%" style="height: 30px;">No</th>
					<th>Aktivitas</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="center">1</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">3</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">4</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">5</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">6</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">7</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">8</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">9</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">10</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">11</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="center">12</td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>

		<div class="float-right border-bottom ttd" align="center" style="height: 70px;margin-bottom: 15px;margin-top: 30px;">
			<label class="bold">TTD</label>
		</div>

		
	</div>
		<footer>
			<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
		</footer>
</body>
</html>