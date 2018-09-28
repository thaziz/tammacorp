<!DOCTYPE html>
<html>
<head>
	<title>SURAT APPLICATION FORM</title>
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
		.border-bottom-dotted{
			border-bottom: 1px dotted black !important;
		}
		.div-page-break-after{
			page-break-after: always;
			width: 100%;
		}
		.paragraph-indent{
			text-indent: 30px;
			line-height: 1.5;
		}
		.photo-3x4{
			height: 4cm;
			width: 3cm;
			border: 1px solid;
		}
	</style>
</head>
<body>
	<div class="div-page-break-after">



		<div class="btn-print" align="right">
			<button onclick="javascript:window.print();">Print</button>
		</div>
			<div class="div-width-background">
			</div>
			<header>
				<img width="100%" src="{{asset('assets/img/header-tammafood-surat.png')}}">
			</header>
				
		<div class="div-width">

			<h2 style="margin: 30px 0 0 0;">APPLICATION FORM</h2>
			<small>FM-SDM-01-2018</small>

			<table width="100%" style="margin-top: 10px;" cellpadding="5px">
				<tr>
					<td colspan="3" align="center" class="bold">IDENTITAS DIRI</td>
					<td colspan="3" align="center" class="bold">KARTU IDENTITAS DIRI</td>
				</tr>
				<tr>
					<td class="bold">Posisi yang di lamar</td>
					<td width="1%" class="border-none-left border-none-right">:</td>
					<td>........................................</td>
					<td class="bold" rowspan="9" valign="top">Pas Foto</td>
					<td width="1%" rowspan="9" valign="top" class="border-none-right border-none-left">:</td>
					<td rowspan="9" valign="top" align="center">
						
						<div class="photo-3x4">
							<img height="100%" width="100%" src="" title="3x4">
						</div>

					</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">Nama Lengkap</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">Nama Panggilan</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">Tanggal Lahir</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">Tempat Lahir</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">Negara</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">Kewarnegaraan</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">Suku</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">No HP</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">WA/Telegram</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
					<td class="bold">No KTP</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold">E-mail</td>
					<td class="border-none-left border-none-right">:</td>
					<td>........................................</td>
					<td class="bold">Nomor SIM</td>
					<td class="border-none-left border-none-right">:</td>
					<td>A / C / B1 / B2</td>
				</tr>
				<tr class="border-none-top">
					<td class="bold" valign="top">Jenis Kelamin</td>
					<td class="border-none-left border-none-right" valign="top">:</td>
					<td><label>Laki-laki&nbsp;&nbsp;&nbsp;<input type="radio" name="jk" value="laki"></label><br>
						<label>Perempuan<input type="radio" name="jk" value="perempuan"></label>
					</td>
					<td colspan="2" class="border-none-right"></td>
					<td valign="top" rowspan="2">........................................</td>
				</tr>
				<tr>
					<td class="bold border-none-top border-none-bottom">Marital Status</td>
					<td class="border-none-right border-none-left border-none-top border-none-bottom">:</td>
					<td class=" border-none-top border-none-bottom"><label><input type="radio" name="status_nikah" value="lajang">Lajang</label></td>
					<td colspan="3" align="center" class="bold">DATA BANK</td>

				</tr>
				<tr>
					<td colspan="2" class="border-none-right"></td>
					<td><label><input type="radio" name="status_nikah" value="menikah">Menikah</label></td>
					<td>Nama</td>
					<td>:</td>
					<td>........................................</td>

				</tr>
				<tr class="border-none-top">
					<td colspan="2" class="border-none-right"></td>
					<td><label><input type="radio" name="status_nikah" value="bertunangan">Bertunangan</label></td>
					<td>Nama Bank</td>
					<td>:</td>
					<td>........................................</td>
					
				</tr>
				<tr class="border-none-top">
					<td colspan="2" class="border-none-right"></td>
					<td><label><input type="radio" name="status_nikah" value="janda/duda">Janda/Duda</label></td>
					<td>No Rekening</td>
					<td>:</td>
					<td>........................................</td>
					
				</tr>
				<tr>
					<td colspan="2" class="border-none-right border-none-top border-none-bottom"></td>
					<td class="border-none-bottom border-none-top"><label><input type="radio" name="status_nikah" value="cerai">Cerai</label></td>
					<td class="bold" align="center" colspan="3">Kacamata</td>
					
				</tr>
				<tr>
					<td valign="top" rowspan="3" class="bold">Agama</td>
					<td valign="top" rowspan="3" class="border-none-left border-none-right">:</td>
					<td valign="top" rowspan="3">
						<table class="border-none" width="100%">
							<tr>
								<td><label><input type="radio" name="agama" value="islam">Islam</label></td>
								<td><label><input type="radio" name="agama" value="hindu">Hindu</label></td>

							</tr>
							<tr>
								<td><label><input type="radio" name="agama" value="kristen">Kristen</label></td>
								<td><label><input type="radio" name="agama" value="budha">Budha</label></td>

							</tr>

							<tr>
								<td><label><input type="radio" name="agama" value="katolik">Katolik</label></td>
								<td></td>

							</tr>
						</table>
						
					</td>
					<td>No Rekening</td>
					<td>:</td>
					<td>........................................</td>
					
				</tr>
				<tr class="border-none-top">
					<td>Kanan</td>
					<td>:</td>
					<td>........................................</td>
					
				</tr>
				<tr class="border-none-top">
					<td>Kiri</td>
					<td>:</td>
					<td>........................................</td>
					
				</tr>
			</table>

			<table width="100%" class="border-none-top">
				<tr>
					<td class="bold" align="center">Alamat</td>
				</tr>
				<tr>
					<td><label class="bold">Alamat Tetap</label><br>
						<table width="100%" class="border-none" cellpadding="5px">
							<tr>
								<td>Alamat Rumah</td>
								<td>:</td>
								<td>........................................</td>

							</tr>
							<tr>
								<td colspan="3">RT&nbsp;&nbsp;&nbsp;..........&nbsp;&nbsp;&nbsp;RW&nbsp;&nbsp;&nbsp;..........</label></td>
								
							</tr>
							<tr>
								<td>Kota</td>
								<td>:</td>
								<td>........................................</td>

							</tr>

							<tr>
								<td>Kelurahan</td>
								<td>:</td>
								<td>........................................</td>

							</tr>
							<tr>
								<td>Telepon Rumah / HP</td>
								<td>:</td>
								<td>........................................</td>

							</tr>
							<tr>
								<td>Status Rumah Milik</td>
								<td>:</td>
								<td><label><input type="radio" name="status_rumah_milik" value="sendiri"> Milik Sendiri</label><label><input type="radio" name="status_rumah_milik" value="orang_tua"> Orang Tua</label></td>

							</tr>
						</table>
					</td>
				</tr>
			</table>
			

		</div>
			<footer>
				<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
			</footer>
	</div>
</body>
</html>