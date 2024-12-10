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

<h4 class="center">DATA PENDAFTARAN DAN PEMERIKSAAN<br><?= $clinic->nama; ?></h4>
<table border="1">
	<thead>
		<tr style="background-color: #1bb39c">
		 <th>No Register</th>
		 <th>Waktu Daftar</th>
		 <th>No. RM</th>
		 <th>Nama</th>
		 <th>Kelamin</th>
		 <th>Alamat</th>
		 <th>Anamnesa</th>
		 <th>Diagnosa</th>
		 <th>Tindakan</th>
		 </tr>
	</thead>
	<tbody>
		<?php $i = 1;foreach ($data as $row) {
	?>
		<?php
if ($row->kelamin == 'L') {
		$kelamin = 'LAKI-LAKI';
	} elseif ($row->kelamin == 'P') {
		$kelamin = 'PEREMPUAN';
	}
	?>
		<tr>
		 <td width="2%" class="center"><?php echo $row->no_register ?></td>
		 <td width="5%" class="center"><?php echo $row->waktu_daftar ?></td>
		 <td width="5%" class="center"><?php echo $row->id_pasien ?></td>
		 <td width="5%"><?php echo $row->nama ?></td>
		 <td width="1%" class="center"><?php echo $kelamin ?></td>
		 <td width="7%"><?php echo $row->alamat ?></td>
		 <td width="7%"><?php echo $row->anamnesa ?></td>
		 <td width="7%"><?php echo $row->diagnosa ?></td>
		 <td width="7%"><?php echo $row->tindakan ?></td>
		 </tr>
		<?php $i++;}?>
	</tbody>
</table>