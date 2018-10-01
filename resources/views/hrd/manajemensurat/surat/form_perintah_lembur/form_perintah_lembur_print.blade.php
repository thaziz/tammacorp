<!DOCTYPE html>
<html>
<head>
	<title>FORM PERINTAH LEMBUR</title>
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
				padding: 120px 15px 15px 15px;
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

		<h2 style="margin: 30px 0 0 0;">FORM PERINTAH LEMBUR</h2>
		<small style="margin: 15px 0 0 0;">FM-SDM-01-2018</small>

		<table width="100%" style="margin-top: 30px;" cellpadding="5px">
			<tr>
				<td colspan="2">Tanggal Pengajuan Lembur pada<br>
					Hari, Tgl 28 Sep 2018
				</td>
				<td rowspan="2" align="center">Lembur Pada Waktu :</td>
				<td align="center">
					<label><input type="radio" value="hari_kerja" name="hari" disabled=""> Hari Kerja</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">Divisi :
				</td>
				
				<td align="center">
					<label><input type="radio" value="hari_libur" name="hari" disabled=""> Hari Libur</label>
				</td>
			</tr>
			<tr>
				<td class="top" style="height: 50px;" colspan="4">
					<label class="bold">Uraian Lembur : </label><br>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</td>
			</tr>
			<tr>
				<td class="border-none-bottom" colspan="4">Yang Bertanda di bawah ini :</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td class="border-none-left border-none-right" width="1%">:</td>
				<td colspan="2">Alpha</td>
			</tr>
			<tr>
				<td>NIK</td>
				<td class="border-none-left border-none-right" width="1%">:</td>
				<td colspan="2">11112</td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td class="border-none-left border-none-right" width="1%">:</td>
				<td colspan="2">Jendral</td>
			</tr>
			<tr>
				<td>Divisi</td>
				<td class="border-none-left border-none-right">:</td>
				<td colspan="2"></td>
			</tr>
			
		</table>
		<table width="100%" class="border-none-top" cellpadding="5px">
			<tr>
				<td rowspan="2" valign="middle" align="center" width="1%">No</td>
				<td rowspan="2" valign="middle" align="center">Nama Karyawan</td>
				<td rowspan="2" valign="middle" align="center">Jabatan</td>
				<td align="center" colspan="2">Jam Lembur</td>
			</tr>
			<tr>
				<td align="center">Mulai</td>
				<td align="center">Berakhir</td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<table width="100%" class="border-none-top" cellpadding="5px">
			<tr>
				<td align="center">Dikeluarkan oleh,<br>Kepala Divisi</td>
				<td align="center">Diketahui oleh :<br>Ka. HRD & Umum</td>
			</tr>
			<tr>
				<td height="70px" valign="bottom" align="center">..................................</td>
				<td valign="bottom" align="center">..................................</td>
			</tr>
		</table>

	</div>
		<footer>
			<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
		</footer>
</body>
</html>