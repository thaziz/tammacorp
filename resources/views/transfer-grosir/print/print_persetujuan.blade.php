<!DOCTYPE html>
<html>
<head>
	<title>Print Persetujuan Print</title>
</head>
<style type="text/css">
	.div-width{
		width: 95vw;
		margin: auto;
	}
	.float-left{
		float: left;
	}
	.float-right{
		float: right;
	}
	
	.with-border table, td, th{
		border: 1px solid black;
	}
	@media print{

	}
	@page{
		size: portrait;
		margin:0;
	}
</style>
<body>
	<div class="div-width">
		<div class="float-right">
			PUKUL {{$waktu}}
		</div>
		<br>
		<table class="with-border" width="100%" cellspacing="0" cellpadding="0" border="1px">
			<tr>
				<th>No</th>
				<th>Nama Barang</th>
				<th>Qnt</th>
				<th>Ditransfer</th>
				<th>KET</th>
			</tr>
			<tr>
				<td>1</td>
				<td>Trotilla</td>
				<td>1</td>
				<td>1</td>
				<td>-</td>
			</tr>
		</table>
	</div>
</body>
</html>