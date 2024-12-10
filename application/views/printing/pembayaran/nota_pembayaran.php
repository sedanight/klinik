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
            * { line-height: 12pt; font-size: 14pt; font-family: Calibri;}
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
				<td><center><b style="font-weight: bold; font-style: 30px;">BUKTI PEMBAYARAN / KWITANSI</b></center></td>
			</tr>
		</table>
		<br><br>
		<table width="100%">
			<tr>
				<td width="15%" style="font-weight: bold;">Tanggal Bayar</td><td width="1%">:</td><td><?= $pembayaran->tanggal_bayar; ?></td>
			</tr>
			<tr>	
				<td style="font-weight: bold;">No. Register</td><td width="1%">:</td><td><?= $pembayaran->no_register; ?></td>
			</tr>
		</table>
		<br>

		<table width="100%" style="margin-left: 50px;">
			<tr><td width="30%" style="font-weight: bold;">Sudah diterima dari</td><td width="1%">:</td><td><?= $pembayaran->sudah_diterima_dari; ?></td></tr>
			<tr><td style="font-weight: bold;">Untuk pembayaran pasien</td><td width="1%">:</td><td><?= $pembayaran->nama; ?></td></tr>
		</table>
		<br><br>
		
		<table width="100%" style="padding-left: 63%;">
			<tr><td width="30%" style="font-weight: bold; font-size: 25pt">Copy R/</td></tr>
		</table>

		<table width="60%" style="border-right: 3px solid #000;">
			<tr><td width="20%" style="font-weight: bold;">1. Pemeriksaan</td><td width="1%">:</td><td width="20%">Rp. <?= currency($pembayaran->pemeriksaan); ?>,-</td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td style="font-weight: bold;">2. Tindakan</td><td>:</td><td>Rp. <?= currency($pembayaran->tindakan); ?>,-</td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td style="font-weight: bold;">3. Obat-obatan</td><td>:</td><td>Rp. <?= currency($pembayaran->obat_obatan); ?>,-</td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td style="font-weight: bold;">4. Pemeriksaan</td><td>:</td><td>Rp. <?= currency($pembayaran->laboratorium); ?>,-</td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td style="font-weight: bold;">5. Pemeriksaan</td><td>:</td><td>Rp. <?= currency($pembayaran->administrasi); ?>,-</td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td style="font-weight: bold;">Total</td><td>:</td><td>Rp. <?= currency($pembayaran->total); ?>,-</td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
		</table>

		<table width="60%" style="border-right: 3px solid #000;">
			<tr><td style="font-weight: bold; font-style: italic;">(<?= terbilang($pembayaran->total); ?>)</td></tr>
		</table>
		
		<table width="60%" style="border-right: 3px solid #000; text-align: center;">
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td width="20%"></td><td width="10%" style="font-weight: bold;">Kasir</td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td ></td><td></td></tr>
			<tr><td width="20%"></td><td width="10%" style="font-weight: bold;">(<?= $this->session->userdata('nama'); ?>)</td></tr>

		</table>
		
	</div>
</body>
</html>
