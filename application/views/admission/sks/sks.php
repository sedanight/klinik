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
                        <div class="button_right" style="float: right; display: block;">
                            <?=form_button('cari', '<i class="fa fa-search"></i> Pencarian', 'id=bt_pencarian class="btn btn-success"')?>
                            <?=form_button('reset', '<i class="fa fa-refresh"></i> Reload Data', 'id=bt_reset_data class="btn btn-default"')?></li>
                        </div>
                    </div>
                </div>

                <br>

                <table class="table table-condensed table-striped table-hover" id="table_data">
                    <thead>
                        <tr class="success">
                            <th width="3%" style="text-align: center;">No.</th>
                            <th width="7%" class="left">No. Register</th>
                            <th width="15%" class="left">Waktu Daftar</th>
                            <th width="7%" class="left">No. RM</th>
                            <th width="20%" class="left">Nama Pasien</th>
                            <th width="10%" class="left">Dari</th>
                            <th width="10%" class="left">Sampai</th>
                            <th width="7%" class="left">Hari</th>
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

<!-- Search Modal -->
<div id="search_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Parameter Pencarian</h4>
      </div>
      <div class="modal-body">
        <?=form_open('', 'id=formsearch role=form class=form-horizontal')?>
            <div class="form-group">
                <label class="col-lg-3 control-label">Tanggal</label>
                <div class="col-lg-3">
                  <input type="text" name="awal" class="form-control" id="awal" placeholder="Awal">
                </div>
                <div class="col-lg-1">
                    <center><h5 style="padding-top:9px;">s.d</h5></center>
                </div>
                <div class="col-lg-3">
                  <input type="text" name="akhir" value="<?=date('d/m/Y')?>" class="form-control" id="akhir" placeholder="Akhir">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">No. Register</label>
                <div class="col-lg-8">
                  <input type="text" name="no_register" class="form-control" id="no_register_search" placeholder="No. Register">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">No. RM</label>
                <div class="col-lg-8">
                  <input type="text" name="no_rm" class="form-control" id="no_rm_search" placeholder="No. RM">
                </div>
            </div>
            <div class="form-group">
                <label for="nama" class="col-lg-3 control-label">Nama</label>
                <div class="col-lg-8">
                  <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Pasien">
                </div>
            </div>
        <?=form_close()?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Keluar</button>
        <button type="button" class="btn btn-success" onclick="search_data()"><i class="fa fa-search"></i> Cari</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Search Modal -->

<!-- SKS Modal -->
<div id="sks_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Form Pembuatan Surat Keterangan Sakit</h4>
      </div>
      <div class="modal-body">
        <?=form_open('', 'id=formsks role=form class=form-horizontal')?>
            <input type="hidden" name="id" id="id_sks">
            <div class="form-group">
                <label class="col-lg-3 control-label">Tanggal</label>
                <div class="col-lg-3">
                  <input type="text" name="dari" value="<?=date('d/m/Y')?>" class="form-control validate_input" id="dari">
                </div>
                <div class="col-lg-1">
                    <center><h5 style="padding-top:9px;">s.d</h5></center>
                </div>
                <div class="col-lg-3">
                  <input type="text" name="sampai" value="<?=date('d/m/Y')?>" class="form-control validate_input" id="sampai">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Selama</label>
                <div class="col-lg-8">
                  <input type="number" name="selama" class="form-control validate_input" id="selama" placeholder="Hari">
                </div>
            </div>
        <?=form_close()?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Keluar</button>
        <button type="button" class="btn btn-success" onclick="konfirmasi_simpan_sks()"><i class="fa fa-save"></i> Buat SKS</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End SKS Modal -->

<script>
    $(function () {
        get_list_sks(1,'');

        $("#awal, #akhir, #dari, #sampai").datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });

        $('#bt_pencarian').click(function(){
            $('#search_modal').modal('show');
        });

        $('#bt_reset_data').click(function(){
            reset_data();
            get_list_sks(1, '');
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
    });

    function reset_data(){
        $('#id, .form-control, #pencarian, #nama_search, #no_rm_search').val('');
        $('#akhir, #dari, #sampai').val('<?=date("d/m/Y")?>');
        my_validation_remove('.form-control');
    }

    function search_data(){
        get_list_sks(1, '');
        $('#search_modal').modal('hide');
    }

    function get_list_sks(p, id) {
        show_ajax_loading();
        $('#page_now').val(p);
        $.ajax({
            type : 'GET',
            url: '<?=base_url("api/admission/list_sks")?>/page/'+p,
            data: $('#formsearch').serialize()+'&id='+id,
            cache: false,
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_sks(p-1, '');
                    return false;
                };

                $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 1));
                $('.page_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_data tbody').empty();
                var str = ''; 
                $.each(data.data,function(i, v){
                    var highlight = 'odd';
                    if ((i % 2) === 1) {
                        highlight = 'even';
                    };

                    str = '<tr class="'+highlight+'">'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.no_register+'</td>'+
                            '<td>'+v.waktu_daftar+'</td>'+
                            '<td>'+v.no_rm+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td>'+datefmysql(v.dari)+'</td>'+
                            '<td>'+datefmysql(v.sampai)+'</td>'+
                            '<td>'+v.hari+'</td>'+
                            '<td align="right" class="aksi">'+
                                '<button title="Edit SKS" type="button" class="btn btn-default btn-xs" onclick="edit_sks('+v.id+')"><i class="fa fa-pencil"></i></button> '+
                                '<button title="Hapus SKS" type="button" class="btn btn-default btn-xs" onclick="hapus_sks(\''+v.id+'\')"><i class="fa fa-trash-o"></i></button>'+
                            '</td>'+
                        '</tr>';
                    $('#table_data tbody').append(str);
                });
                hide_ajax_loading();
            },
            error: function(e){
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function edit_sks(id) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url: '<?= base_url("api/admission/edit_sks") ?>/id/'+id,
            cache: false,
            dataType : 'json',
            success: function(data) {
                hide_ajax_loading();
                if (data.sks !== null) {
                    hasil = data.sks;
            
                    $('#id_sks').val(hasil.id);
                    $('#dari').val(datefmysql(hasil.dari));
                    $('#sampai').val(datefmysql(hasil.sampai));
                    $('#selama').val(hasil.hari);
                }
                
                $('#sks_modal').modal('show');     
            },
            error: function(e){
                hide_ajax_loading();
                access_failed(e.status);
            }
        });
    }

    function konfirmasi_simpan_sks(){
        var stop = false;

        if ($('#selama').val() === '') {
            my_validation('#selama', 'Berapa hari istirahatnya..');
            stop = true;
        };

        if (stop) {
            return false;
        };

        klik = null;
        bootbox.dialog({
          message: "Anda yakin akan mengedit surat keterangan sakit ?",
          title: "Edit Surat Keterangan Sakit",
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
                simpan_sks();
              }
            }
          }
        });
    }

    function simpan_sks() {
        if (klik === null) {
            show_ajax_loading();
            klik = $.ajax({
                type : 'POST',
                url: '<?= base_url("api/admission/sks") ?>/',
                data: $('#formsks').serialize(),
                cache: false,
                dataType : 'json',
                success: function(data) {
                    hide_ajax_loading();
                    message_custom('success', 'Surat Keterangan Sakit Berhasil diedit!');
                    get_list_sks(1, '');
                    $('#sks_modal').modal('hide');
                },
                error: function(e){
                    hide_ajax_loading();
                    message_custom('error', 'Surat Keterangan Sakit Gagal diedit!')
                    $('#sks_modal').modal('hide');
                }
            });
        }
    }

    function hapus_sks(id) {
        bootbox.dialog({
            message: "Anda yakin akan menghapus data ini?",
            title: "Penghapusan Surat Keterangan Sakit",
            buttons: 
            {
                batal: 
                {
                  label: '<i class="fa fa-refresh"></i> Tidak',
                  className: "btn-default",
                  callback: function() {

                    }
                },
                hapus: 
                {
                    label: '<i class="fa fa-trash-o"></i>  Ya',
                    className: "btn-success",
                    callback: function() 
                    {
                        $.ajax({
                            type : 'DELETE',
                            url: '<?=base_url("api/admission/hapus_sks")?>/id/'+id,
                            cache: false,
                            dataType : 'json',
                            success: function(data) {
                                if (data.status) {
                                    message_custom('success', 'Penghapusan SKS', data.message, '');
                                    get_list_sks($('#page_now').val(), '');
                                }else{
                                    custom_alert('Penghapusan SKS', data.message);
                                }

                            },
                            error: function(e){
                                message_custom('error', 'Penghapusan SKS', 'Gagal melakukan penghapusan SKS', '');
                            }
                        });
                    } 
                }
            }
        });
    }


</script>