<link rel="stylesheet" href="<?= base_url('assets/css/print-struk.css') ?>" />
<script type="text/javascript">
    function cetak() {
       window.print();    
       setTimeout(function(){ window.close();},300);
    }
</script>
<title><?= $title ?></title>
<style>
    *{
        font-family: 'arial';
        /*text-align: center;*/
    }
    h2{
        font-size: 16px;
    }
</style>
<body onload="cetak()" style="height:auto">
    <div class="print-area" style="margin-left: 40px;">
    <table width="100%">
        <tr>
            <td>
                <h2><?= $clinic->nama ?></h2>
                <?= $layanan->dokter ?><br/>
                <?= datetimefmysql($layanan->waktu) ?> 
            </td>
        </tr>
        <tr>
            <td class="border">
                <b style="font-size: 25px; font-weight: bold;"><?= $layanan->no_antri ?></b>
            </td>
        </tr>
        <tr>
            <td class="border">
                <?= $pasien->nama ?><br/>
                <?= $pasien->id_pasien ?>
            </td>
        </tr>
    </table>
</div>
</body>
<?php die; ?>
