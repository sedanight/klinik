<input type="hidden" name="page_now" id="page_now"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <!-- <div class="panel-heading clearfix">
                <h4 class="panel-title"><span class="fa fa-table"></span> <?=$list;?></h4>
            </div> -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="button_left" style="float: left; display: block;">
                            <?=form_button('cari', '<i class="fa fa-search"></i> Pencarian', 'id=bt_pencarian_pembayaran class="btn btn-success"')?>
                            <?=form_button('reset', '<i class="fa fa-refresh"></i> Reload Data', 'id=bt_reset_pembayaran class="btn btn-default"')?></li>
                            <button onclick="export_data()" class="btn btn-info"><span class="fa fa-download"></span>&nbsp;Export Data</button>
                        </div>
                        <span class="button_right" style="float: right; display: block">
                            <?=form_dropdown('status_pembayaran', $status_pembayaran, array(), 'class="form-control" id=status_pembayaran style="width: 200px;" ')?>
                        </span>
                    </div>
                </div>

                <br>

                <table class="table table-condensed table-striped table-hover" id="table_data">
                    <thead>
                        <tr class="success">
                            <th width="3%" style="text-align: center;">No.</th>
                            <th width="10%" class="left">No. Register</th>
                            <th width="12%" class="left">Waktu Daftar</th>
                            <th width="6%" class="left">No. RM</th>
                            <th width="30%" class="left">Nama Pasien</th>
                            <th width="12%" class="left">Waktu Bayar</th>
                            <th width="10%" class="left">Cara Bayar</th>
                            <th width="10%" class="left">Status</th>
                            <th align="center" width="10%"></th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>

                <div class="page_summary pull-left" id="summary"></div>

                <div id="pagination" class="pull-right"></div>
            </div>
        </div>
    </div>
</div>

<!-- modal cari -->
<div class="modal fade" id="search_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal_title_search">Parameter Pencarian</h4>
            </div>
            <div class="modal-body">
                <?= form_open('','id=formsearch role=form class=form-horizontal') ?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Tanggal</label>
                        <div class="col-lg-3">
                          <input type="text" name="awal" class="form-control" id="awal" placeholder="Awal">
                        </div>
                        <div class="col-lg-1">
                            <center><h5 style="padding-top:9px;">s.d</h5></center>
                        </div>
                        <div class="col-lg-4">
                          <input type="text" name="akhir" value="<?= date('d/m/Y') ?>" class="form-control" id="akhir" placeholder="Akhir">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">No. Register</label>
                        <div class="col-lg-8">
                          <input type="text" name="no_register" class="form-control" id="no_register_search" placeholder="No. Register">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_rm" class="col-lg-3 control-label">No. RM</label>
                        <div class="col-lg-8">
                          <input type="text" name="no_rm" class="form-control" id="no_rm_search" placeholder="No. RM">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-lg-3 control-label">Nama</label>
                        <div class="col-lg-8">
                          <input type="text" name="nama" class="form-control" id="nama_search" placeholder="Nama Pasien">
                        </div>
                    </div>
                <?= form_close() ?>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Keluar</button>
                <button type="button" class="btn btn-success" onclick="search_data()"><i class="fa fa-search"></i> Cari</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal cari -->

<!-- modal Bayar -->
<div class="modal fade" id="modal_bayar" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 45%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal_title">Form Pembayaran</h4>
            </div>
            <div class="modal-body">
                <?= form_open('','id=formadd role=form class=form-horizontal') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-hover">
                          <tbody class="ibox-content">
                            <!-- <tr>
                                <td width="20%"><strong>No RM</strong></td>
                                <td><span id="no_rm_detail"></span></td>
                            </tr> -->
                            <tr>
                                <td width="20%"><strong>No Register</strong></td>
                                <td><span id="no_register_detail"></span></td>
                            </tr>            
                            <tr>
                                <td><strong>Nama Pasien</strong></td>
                                <td><span id="nama_detail"></span></td>
                            </tr>
                            <!-- <tr>
                                <td><strong>Alamat</strong></td>
                                <td><span id="alamat_detail"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Telp</strong></td>
                                <td><span id="telp_detail"></span></td>
                            </tr> -->
                          </tbody>
                        </table>
                        <center><h2><strong>Billing</strong></h2><hr></center><br>
                        <div class="row">
                            <!-- Data Pembayaran -->
                            <input type="hidden" name="id" id="id">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Sudah diterima dari</label>
                                    <div class="col-lg-7 input-group">
                                        <input type="text" name="sudah_diterima" class="form-control validate_input" id="sudah_diterima">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Pemeriksaan</label>
                                    <div class="col-lg-7 input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" name="pemeriksaan" class="form-control" value="0" id="pemeriksaan" onkeyup="convertToCurrency(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Tindakan</label>
                                    <div class="col-lg-7 input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" name="tindakan" class="form-control" value="0" id="tindakan" onkeyup="convertToCurrency(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Obat-obatan</label>
                                    <div class="col-lg-7 input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" name="obat_obatan" class="form-control" value="0" id="obat_obatan" onkeyup="convertToCurrency(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Laboratorium</label>
                                    <div class="col-lg-7 input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" name="laboratorium" class="form-control" value="0" id="laboratorium" onkeyup="convertToCurrency(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Administrasi</label>
                                    <div class="col-lg-7 input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" name="administrasi" class="form-control" value="0" id="administrasi" onkeyup="convertToCurrency(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Keterangan</label>
                                    <div class="col-lg-7 input-group">
                                        <textarea  name="keterangan" class="form-control" id="keterangan" placeholder="Catatan jika diperlukan"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Total</label>
                                    <div class="col-lg-7 input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" name="total" class="form-control" value="0" id="total">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Dibayarkan</label>
                                    <div class="col-lg-7 input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" name="terbayar" class="form-control validate_input" id="terbayar" value="0" onkeyup="convertToCurrency(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="col-lg-4 control-label">Kembalian</label>
                                    <div class="col-lg-7">
                                        <span id="kembalian_detail" style="font-size: 30px; float: right;">0</span>
                                        <input type="hidden" name="kembalian" id="kembalian" value="0">
                                    </div>
                                </div>
                            </div>
                            <!-- Data Pembayaran -->
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Keluar</button>
                <button type="button" class="btn btn-success" onclick="konfirmasi_simpan()"><i class="fa fa-money"></i> Bayar</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal Bayar -->

<script type="text/javascript">
    $(function () {
        var klik = null;
        var dWidth = $(window).width();
        var dHeight= $(window).height();
        var x = screen.width/2 - dWidth/2;
        var y = screen.height/2 - dHeight/2;
        
        get_list_pembayaran(1,'');
        $('#status_pembayaran').change(function(){
            get_list_pembayaran(1, '');
        });

        $("#awal, #akhir").datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });

        $('#bt_pencarian_pembayaran').click(function(){
            reset_data();
            $('#search_modal').modal('show');
        });

        $('#formadd').submit(function(){
            return false;
        });

        $('#bt_reset_pembayaran').click(function(){
            reset_data();
            get_list_pembayaran(1, '');
        });

        $('.validate_input').keyup(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }
        });

        $('.validate_input').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }
        });

        $('#pemeriksaan, #tindakan, #obat_obatan, #laboratorium, #administrasi').keyup(function () {
            var pemeriksaan = parseInt(currencyToNumber($('#pemeriksaan').val()));
            var tindakan = parseInt(currencyToNumber($('#tindakan').val()));
            var obat_obatan = parseInt(currencyToNumber($('#obat_obatan').val()));
            var laboratorium = parseInt(currencyToNumber($('#laboratorium').val()));
            var administrasi = parseInt(currencyToNumber($('#administrasi').val()));

            var total = pemeriksaan + tindakan + obat_obatan + laboratorium + administrasi;
            $('#total').val(numberToCurrency(total));

        });

        $('#terbayar').keyup(function(){
            var grandtotal = parseInt(currencyToNumber($('#total').val()));
            var terbayar = parseInt(currencyToNumber($('#terbayar').val()));
            var kembalian = terbayar - grandtotal;
            if (kembalian < 0) {
                kembalian = 0;
            };

            $('#kembalian_detail').html(numberToCurrency(kembalian));
            $('#kembalian').val(kembalian);
        });


    });

    function reset_data(){
        $('#id, #pencarian, #nama_search, #no_register_search, #no_rm_search').val('');
        $('#akhir').val('<?= date("d/m/Y") ?>');
        my_validation_remove('.validate_input');
        my_validation_remove('.select2-input');
    }

    function reset_pembayaran() {
        $('#sudah_diterima').val('');
        $('#pemeriksaan').val('0');
        $('#tindakan').val('0');
        $('#obat_obatan').val('0');
        $('#laboratorium').val('0');
        $('#administrasi').val('0');
        $('#keterangan').val('');
        $('#total').val('0');
        $('#terbayar').val('0');
        $('#kembalian').val('0');
        $('#kembalian_detail').html('0');
        my_validation_remove('.validate_input');
        my_validation_remove('.select2-input');
    }

    function search_data(){
        get_list_pembayaran(1, '');
        $('#search_modal').modal('hide');
    }

    function konfirmasi_simpan(){
        show_ajax_loading();
        var stop = false;
        
        if ($('#sudah_diterima').val() === '') {
            my_validation('#sudah_diterima', 'Harus Diisi!');
            stop = true;   
        };

        if ($('#terbayar').val() === '0') {
            my_validation('#terbayar', 'Uang yang dibayarkan harus lebih besar atau sama dengan nominal yang akan dibayarkan!');
            stop = true;   
        };

        if (stop) {
            return false;
        };

        klik = null;
        bootbox.dialog({
          message: "Anda sudah yakin data yang dientri sudah benar ? ?",
          title: "Simpan Pembayaran",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {

              }
            },
            masuk: {
              label: '<i class="fa fa-check"></i> Simpan',
              className: "btn-success",
              callback: function() {
                save_data();
              }
            }
          }
        });
    }

    function save_data() {
        show_ajax_loading();
        var update = '';
        if($('#id').val() !== ''){
            update = 'id/'+ $('#id').val();
        }

        if (klik === null) {
            show_ajax_loading();
            klik = $.ajax({
                type : 'POST',
                url: '<?= base_url("api/keuangan/pembayaran") ?>/'+update,
                data: $('#formadd').serialize(),
                cache: false,
                dataType : 'json',
                success: function(data) {
                    hide_ajax_loading();
                    if ($('#id').val() !== '') {
                        reset_data();
                        get_list_pembayaran(1, '');
                        message_custom('success', 'Pembayaran Sukses');
                    }
                    
                    $('#modal_bayar').modal('hide');
                },
                error: function(e){
                    hide_ajax_loading();
                    if ($('#id').val() !== '') {
                        message_edit_failed();
                    }                }
            });
        }
    }

    function get_list_pembayaran(p, id) {
        $('#page_now').val(p);
        var filter = '&status_pembayaran='+$('#status_pembayaran').val();
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url: '<?= base_url("api/keuangan/pembayaran_list") ?>/page/'+p,
            data: $('#formsearch').serialize()+filter+'&id='+id,
            cache: false,
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_pembayaran(p-1, '');
                    return false;
                };
                
                $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 1));
                $('#summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_data tbody').empty();          
                var str = ''; var lunas = ''; var status_pembayaran = ''; var disabled = ''; var disabled_ = '';
                $.each(data.data,function(i, v){

                    if (v.status_pembayaran == 'Tagihan') {
                        status_pembayaran = "<span class='blinker'><i class='fa fa-spinner fa-spin'></i><i>&nbsp;Belum Lunas</i></span>";
                        disabled = '';
                        disabled_ = 'disabled';
                    } else if (v.status_pembayaran === 'Terbayar') {
                        status_pembayaran = "<span class='label label-info'><i class='fa fa-check'></i>&nbsp;Cetak Kwintasi</span>"
                        disabled = 'disabled';
                        disabled_ = '';
                    }

                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.no_register+'</td>'+
                            '<td>'+((v.waktu_daftar !== null)?datetimefmysql(v.waktu_daftar):'')+'</td>'+
                            '<td>'+v.id_pasien+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td>'+((v.tanggal_bayar !== null)?datetimefmysql(v.tanggal_bayar):'')+'</td>'+
                            '<td>'+v.cara_bayar+'</td>'+
                            '<td>'+status_pembayaran+'</td>'+
                            '<td align="right" class="aksi">'+
                                '<button title="Klik untuk melakukan pembayaran" type="button" class="btn btn-default btn-xs" onclick="pembayaran(\''+v.id_layanan_pendaftaran+'\')" '+disabled+'><i class="fa fa-plus"></i></button> '+
                                '<button '+disabled_+' title="Kwitansi Pembayaran" type="button" class="btn btn-default btn-xs" onclick="cetak_kwitansai_pembayaran(\''+v.id+'\')"><i class="fa fa-print"></i></button> '+
                            '</td>'+
                        '</tr>';
                    $('#table_data tbody').append(str);
                    hide_ajax_loading();
                });                
            },
            error: function(e){
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function paging(p){
        get_list_pembayaran(p, '');
    }

    function pembayaran(id) {
        $('#item_detail_laundry tbody').empty();
        reset_pembayaran();
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url("api/keuangan/pembayaran_detail"); ?>/id/'+id,
            cache : false,
            dataType : 'json',
            success: function (data) {
                if (data.customer !== null) {
                    hasil = data.pendaftaran;

                    $('#id').val(hasil.id);
                    $('#no_register_detail').html(hasil.no_register);
                    $('#no_rm_detail').html(hasil.id_pasien);
                    $('#nama_detail').html(hasil.nama);
                    $('#alamat_detail').html(hasil.alamat);
                    $('#telp_detail').html(hasil.telp);

                    $('#modal_bayar').modal('show');
                    hide_ajax_loading();
                }
            },

            error: function(e){
                access_failed(e.status);
                hide_ajax_loading();
            }

        });
    }

    function export_data() {
        location.href = '<?=base_url()?>export/export_data_pembayaran?'+$('#formsearch').serialize();
    }

    function cetak_kwitansai_pembayaran(id) {
        window.open('<?= base_url() ?>printing/kwitansi_pembayaran/'+id,'Cetak Kwitansi Pembayaran');
    }

    function convertToCurrency(obj){
        if ($(obj).val() !== '') {
            var conv = currencyToNumber($(obj).val());
            $(obj).val(numberToCurrency(conv));
        }else{
            $(obj).val(0);
        }
    }
</script>