<!DOCTYPE html>
<html>
<head>
	<title>Laporan Penjualan</title>
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
			page-break-inside: avoid;
		}
		.tabel{
			page-break-inside: avoid;

		}
		@media print {
			.button-group{
				display: none;
				padding: 0;
				margin: 0;
			}
			@page {
				size: landscape
			}
		}
		@page { 
			margin:0; 
		}
		.tabel th{
			white-space: nowrap;
			width: 1%;
		}
		.no-border-head{
			border-top:hidden;
			border-left: hidden;
			border-right: hidden;
		}

	</style>
</head>
<body>
	<div class="button-group">
		<button onclick="prints()">Print</button>
	</div>
	
		<div class="div-width">
		
		@for($i=0;$i<count($data);$i++)

		<table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
			<thead>
				<tr>
					<td colspan="13" class="no-border-head">
						<div class="s16 bold">
							TAMMA ROBAH INDONESIA
						</div>
						<div>
							Jl. Raya Randu no.74<br>
							Sidotopo Wetan - Surabaya 60123<br>
						</div>
						<div class="bold" style="margin-top: 15px;">
							Laporan : Penjualan Per Barang - Detail <br>
							Pembayaran : Kredit PPn : Gabungan <br>
							Periode : {{$tgl1}} s/d {{$tgl2}}
						</div>
					</td>
				</tr>
				<tr>
					<th width="150px">Nama Barang</th>
					<th>No Bukti</th>
					<th>Tanggal</th>
					<th>Jatuh Tempo</th>
					<th>Customer</th>
					<th>Kurs</th>
					<th>Sat</th>
					<th>Qty</th>
					<th>Harga</th>
					<th>Diskon</th>
					<th>DPP</th>
					<th>PPN</th>
					<th>Total</th>
					
				</tr>
			</thead>
			<tbody>
			<?php

			//dd($data[$i]);

				$arr  = [];
				$item = [];
		        $note = [];
			    $cus  = [];
			    $tanggal = [];
			    $satuan = [];
			    $code = [];
			    $qty = [];
			    $price = [];
			    $disc = [];
			    $total = [];

		        foreach ($data[$i] as $index => $ini_data) {
		        
			        array_push($note, $ini_data->s_note);
			        array_push($item, $ini_data->i_name);
			        array_push($tanggal, $ini_data->s_date);
			        array_push($cus, $ini_data->c_name);
			        array_push($satuan, $ini_data->m_sname);
			        array_push($code, $ini_data->i_code);
			        array_push($qty, $ini_data->sd_qty);
			        array_push($price, $ini_data->sd_price);
			        array_push($disc, $ini_data->sd_disc_percent);
			        array_push($total, $ini_data->sd_total);



					if (!isset($arr[$ini_data->i_name])) {
		                $arr[$ini_data->i_name]['rowspan'] = 0;
		            }
		            $arr[$ini_data->i_name]['printed'] = 'no';
		            $arr[$ini_data->i_name]['rowspan'] += 1;

		            
		        }

		        //dd(array_count_values($item));

			?>

				@for($j=0;$j<count($data[$i]);$j++)

					<?php 

			            $empName = $item[$j];
			            echo "<tr>";

			            # If this row is not printed then print.
			            # and make the printed value to "yes", so that
			            # next time it will not printed.
			            	if ($arr[$empName]['printed'] == 'no') {
				                echo "<td class='item_".$i.'_'.$code[$j]."' rowspan='".$arr[$empName]['rowspan']."'>".$empName." - ".$code[$j]."</td>";
				                $arr[$empName]['printed'] = 'yes';
			            	}
			            echo "<td>".$note[$j]."</td>".
			            "<td>".$tanggal[$j]."</td>".
			            "<td></td>".
			            "<td>".$cus[$j]."</td>".
			            "<td class='text-right'></td>".
			            "<td>".$satuan[$j]."</td>".
			            "<td class='text-right qty_".$i.'_'.$code[$j]."'>".$qty[$j]."</td>".
			            "<td>".
			            "<div class='float-left'>Rp.</div>".
			            "<div class='float-right'>".
			            number_format($price[$j],2,',','.').
			            "</div>".
			            "</td>".
			            "<td class='text-right'>".number_format($disc[$j],2,',','.')."</td>".
			            "<td class='text-right total_".$i.'_'.$code[$j]."'>".number_format($total[$j],2,',','.')."</td>".
			            "<td></td>".
			            "<td class='text-right'>".number_format($total[$j],2,',','.')."</td>"

			            ;
			            echo "</tr>";
			        	
			        ?>
					
				@endfor


			</tbody>

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