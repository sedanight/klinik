<?php
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=" . $judul . ".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>

<style>
    *{ font-size: 13px; font-family: "Arial"}
    .bold {font-weight: 900}
    .center{
        text-align: center;
    }
</style>

<h4 class="center"><?= $judul; ?><br><?= $clinic->nama; ?></h4>
<table border="1" width="100%">
	<thead>
		<tr style="background-color: #1bb39c">
		 	<th>No Register</th>
		 	<th>Waktu Daftar</th>
		 	<!-- <th>No. RM</th> -->
		 	<th>Nama</th>
		 	<th>Pemeriksaan</th>
		 	<th>Tindakan</th>
		 	<th>Obat-Obatan</th>
		 	<th>Laboratorium</th>
		 	<th>Administrasi</th>
		 	<th>Total</th>
		 	<th>Kembalian</th>
		 	<th>Terbayar</th>
		 	<th>Status</th>
		 	<th>Keterangan</th>
		 	<th>Tanggal Bayar</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $row): ?>		
		<tr>
			<td width="2%" class="center"><?php echo $row->no_register ?></td>
			 <td width="5%" class="center"><?php echo $row->waktu_daftar ?></td>
			<!-- <td width="5%" class="center">'<?php echo $row->id_pasien ?></td> -->
			<td width="5%"><?php echo $row->nama ?></td>
			<td width="5%"><?php echo $row->pemeriksaan ?></td>
			<td width="5%"><?php echo $row->tindakan ?></td>
			<td width="5%"><?php echo $row->obat_obatan ?></td>
			<td width="5%"><?php echo $row->laboratorium ?></td>
			<td width="5%"><?php echo $row->administrasi ?></td>
			<td width="5%"><?php echo $row->total ?></td>
			<td width="5%"><?php echo $row->kembalian ?></td>
			<td width="5%"><?php echo $row->terbayar ?></td>
			<td width="5%"><?php echo $row->status ?></td>
			<td width="5%"><?php echo $row->keterangan ?></td>
			<td width="5%"><?php echo $row->tanggal_bayar ?></td>
		 </tr>
		<?php endforeach ?>
		<!-- <tr>
		 	<td class="center">Grand Total</td>
		 	<td colspan="13" class="center"><?php echo $grandtotal; ?></td>
		</tr> -->
	</tbody>
</table>