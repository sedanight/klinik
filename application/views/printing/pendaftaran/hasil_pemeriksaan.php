<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
        <link rel="stylesheet" href="<?= base_url('assets/css/printing-A4.css') ?>" media="all" />
	<script type="text/javascript">
	    function cetak() {
	       setTimeout(function(){ window.close();},300);
	       window.print();    
	    }
	</script>
        <style type="text/css">
            * { line-height: 12pt; font-size: 12pt; font-family: Calibri;}
        </style>
</head>
<body onload="cetak();">
	<div class="page">
		<br/><br/>
		<table width="100%" style="color: #000; border-bottom: 3px solid #000;">
            <tr>
                <td rowspan="11" style="width: 100px"><img src="<?= base_url('assets/images/'.$clinic->logo) ?>" width="100px" height="100px" /></td>    
            </tr>
			<tr><td colspan="3" align="center"><b style="font-weight:bold; font-size: 40px"><?= strtoupper($clinic->nama) ?></b></td></tr>
            <tr><td colspan="3" align="center"><b style="font-weight:bold;"><?= strtoupper($clinic->type) ?></b></td> </tr>
            <tr><td colspan="3" align="center"><b style="font-weight:bold;"><?= strtoupper($clinic->izin) ?></b></td> </tr>
            <tr><td colspan="3" align="center"><b style="font-weight:bold;"><?= strtoupper($clinic->no_izin) ?></b></td> </tr>
            <tr><td colspan="3" align="center"><b style="font-weight:bold;"><?= strtoupper($clinic->pj) ?></b></td> </tr>
            <tr><td colspan="3" align="center"><b style="font-weight:bold;"><?= strtoupper($clinic->alamat) ?></b></td> </tr>
            <tr><td colspan="3" align="center"><b style="font-weight:bold;">TELP. <?= $clinic->telp ?></b></td> </tr>
        </table>
		<br>

		<table width="100%">
			<tr>
				<td width="15%">No. RM</td><td width="1%">:</td><td><?= $pasien->no_rm ?></td>
			</tr>
			<tr>
				<td width="15%">No. Register</td><td width="1%">:</td><td><?= $pasien->no_register ?></td>
			</tr>
			<tr>
				<td width="15%">Nama Pasien</td><td width="1%">:</td><td><?= $pasien->nama ?></td>
			</tr>
			<tr>
				<td width="15%">Kelamin</td><td>:</td><td><?= $pasien->kelamin ?></td>
			</tr>			
			<tr>
				<td width="15%">Alamat</td><td>:</td><td><?= $pasien->alamat ?></td>
			</tr>
			
		</table>
		<br>
		<table width="100%" cellspacing="0" cellpadding="0" class="tabel-hasil">
			<tr>
				<th width="20%" style="text-align:center;">TGL</th>
				<th width="20%" style="">ANAMNESA</th>
				<th width="20%">DIAGNOSA</th>
				<th width="20%">THERAPY/TINDAKAN</th>
				<!-- <th width="15%" style="">CATATAN</th> -->
			</tr>

			<tr>
				<td style="border-bottom: 1px #000 solid; width: 10%;" align="center"><?= $pasien->waktu_periksa ?></td>
				<td style="border-bottom: 1px #000 solid;"><?= $pasien->anamnesa; ?></td>
				<td style="border-bottom: 1px #000 solid;"><?= $pasien->diagnosa ?></td>
				<td style="border-bottom: 1px #000 solid;"><?= $pasien->tindakan ?></td>
				<!-- <td style="padding-left:10px;border-bottom: 1px #000 solid;"><?= $pasien->catatan ?></td> -->
			</tr>
		</table>        

		<table width="100%">
			<tr><td></td></tr>
			<tr>
				<td width="70%">
					<p align="left"></p>
				</td>
				<td width="30%">
					<p align="left">
						Pemeriksa : <br/><br/><br/><br/><br/>
						( dr. M. Zakir.CH )
					</p>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>