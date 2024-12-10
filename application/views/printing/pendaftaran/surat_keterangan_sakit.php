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
            .tengah{
            	margin: 0 auto;
            }
            .bold{
            	font-weight: bold;
            }
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
				<td><center><b style="font-weight: bold; font-style: 50px; line-height: 15pt">SURAT KETERANGAN <br> SAKIT / ISTIRAHAT</b></center></td>
			</tr>
		</table>
		<br><br><br>

		<table width="80%" class="tengah">
			<tr>
		    	<td colspan="3" style="padding-bottom:20px;">Dengan ini menerangkan :</td>
		  	</tr>
		  	<tr>
		    	<td width="14%" class="bold">Nama</td>
		    	<td width="1%">:</td>
		    	<td width="65%"><?= $sks->nama; ?></td>
		  	</tr>
		  	<tr>
		    	<td width="14%" class="bold">Umur</td>
		    	<td width="1%">:</td>
		    	<td width="65%"><?= datefmysql($sks->tanggal_lahir); ?>, <?= hitungUmur($sks->tanggal_lahir); ?></td>
		  	</tr>
		  	<tr>
		    	<td width="14%" class="bold">Alamat</td>
		    	<td width="1%">:</td>
		    	<td width="65%"><?= $sks->alamat; ?>,&nbsp;<?= $sks->kelurahan ?>&nbsp;</td>
		  	</tr>
		  	<tr>
		    	<td width="14%"></td>
		    	<td width="1%"></td>
		    	<td width="65%"><?= $sks->kecamatan; ?>,&nbsp;<?= $sks->kabupaten_kota ?>&nbsp;</td>
		  	</tr>
		  	<tr>
		    	<td width="14%" class="bold">Pekerjaan</td>
		    	<td width="1%">:</td>
		    	<td width="65%"><?= $sks->pekerjaan; ?></td>
		  	</tr>
		  	<tr>
		  		<td colspan="3" style="padding-top:20px; text-align: justify; line-height: 20px">Sehubungan dengan sakitnya perlu istirahat : selama <?= $sks->hari ?> ( <?=terbilang($sks->hari)?> ) hari, Terhitung dari tanggal <?= $sks->dari ?> s/d <?= $sks->sampai; ?></td>
		  	</tr>
		  	<tr>
		  		<td colspan="3" style="padding-top:20px;">Harap yang berkepentingan maklum adanya</td>
		  	</tr>
		  	<tr>
		  		<td colspan="3" style="text-align: justify;">Terima Kasih</td>
		  	</tr>
		</table>
		<br><br><br>
		<table width="40%" style="margin-left: 60%">
			<tr>
				<td style="padding-bottom: 100px; text-align: center;">Tangerang, <?= date('d/m/Y') ?></td>
			</tr>
			<tr>
				<td style="text-align: center;">(<?= $this->session->userdata('nama'); ?>)</td>
			</tr>
		</table>
	</div>
</body>
</html>
