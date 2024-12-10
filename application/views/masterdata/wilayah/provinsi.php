<br><input type="hidden" name="page_now" id="page_now_provinsi"/>
<div class="row">
	<div class="col-sm-10">
       <?= form_button('tambah', '<i class="fa fa-plus"></i> Tambah Provinsi' ,'id=bt_tambah_provinsi class="btn btn-success"')?>
        <?= form_button('reset', '<i class="fa fa-refresh"></i> Reload Data' ,'id=bt_reset_provinsi class="btn"')?></li>
    </div>
    <div class="col-sm-2">
        <input type="text" class="search form-control" onkeyup="get_list_provinsi(1)" id="pencarian_provinsi" placeholder="Pencarian">
    </div>
</div>
<div class="row"><br></div>

<table class="table table-condensed table-striped table-hover" id="table_provinsi">
    <thead>
        <tr class="success">
            <th width="5%" style="text-align: center;">No</th>
            <th width="80%">Nama</th>
            <th width="15%"></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="page_summary pull-left" id="p_summary"></div>
<div id="p_pagination" class="pull-right"></div>

<div class="modal fade" id="modal_provinsi" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_provinsi"></h4>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=formadd role=form class=form-horizontal'); ?>
                    <input type="hidden" name="id" id="id_provinsi">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Provinsi</label>

                        <div class="col-lg-8">
                            <input type="text" name="nama" id="nama" placeholder="Nama Provinsi" class="form-control">
                        </div>
                    </div>
                    
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_provinsi()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        get_list_provinsi(1);

        $('#bt_tambah_provinsi').click(function(){
            $('#modal_provinsi').modal('show');
            $('#modal_title_provinsi').html('Tambah Provinsi');
            reset_data_provinsi();
        });

        $('#bt_reset_provinsi').click(function(){
            reset_data_provinsi();
            get_list_provinsi(1);
        });

        $('.form-control').keyup(function(){
            if ($(this).val() !== '') {
                my_validation_remove(this);
            }
        });

        $('.form-control').change(function(){
            if ($(this).val() !== '') {
                my_validation_remove(this);
            }
        });

    });

    function reset_data_provinsi() {
        $('#id_provinsi, .form-control,  #pencarian_provinsi').val('');
        my_validation_remove('.form-control');
    }

    function get_provinsi(id) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/provinsi_by_id/id/'); ?>'+id,
            cache : false,
            dataType : 'JSON',
            success: function(data) {
                $('#p_pagination').html('&nbsp;<br>&nbsp;<br>');
                $('#p_summary').html(page_summary(1, 1, data.limit, data.page));

                $('#table_provinsi tbody').empty();
                var str =   '<tr>'+
                                '<td align="center">1</td>'+
                                '<td>'+data.data.nama+'</td>'+
                                '<td align="center" class="aksi">'+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="edit_provinsi(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="delete_provinsi(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                                '</td>'+
                            '</tr>';
                $('#table_provinsi tbody').append(str);
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function get_list_provinsi(p) {
        show_ajax_loading()
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/provinsi/page/'); ?>'+p,
            cache : false,
            data : 'pencarian='+$('#pencarian_provinsi').val(),
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_provinsi(p - 1);
                    return false;
                };

                $('#p_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#p_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_provinsi tbody').empty();

                var str = '';
                $.each(data.data, function(i, v) {
                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td align="center" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_provinsi(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-default btn-xs" onclick="delete_provinsi(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                          '</tr>';
                    $('#table_provinsi tbody').append(str);
                });
                hide_ajax_loading();

            },
            error: function(e){
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function paging(p) {
        get_list_provinsi(p);
    }

    function simpan_provinsi() {
        var stop = false;

        if ($('#nama').val() === '') {
            my_validation('#nama', 'Nama provinsi harus diisi!');
            stop = true;
        };

        if (stop) {
            return false;
        }

        var update = '';
        if ($('#id_provinsi').val() !== '') {
            update = 'id/'+ $('#id_provinsi').val();
        }

        show_ajax_loading();

        $.ajax({
            type : 'POST',
            url : '<?= base_url('api/masterdata/provinsi/'); ?>'+update,
            data : $('#formadd').serialize(),
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#modal_provinsi').modal('hide');

                if ($('#id_provinsi').val() !== '') {
                    message_edit_success();
                    get_list_provinsi($('#page_now_provinsi').val());
                } else {
                    message_add_success();
                    get_provinsi(data.id);
                }

                hide_ajax_loading();
            },
            error: function(e) {
                if ($('#id_provinsi').val() !== '') {
                    message_edit_failed();
                } else {
                    message_add_failed();
                }

                hide_ajax_loading();
            }
        });
    }

    function edit_provinsi(id, p) {
        show_ajax_loading();
        reset_data_provinsi();
        $('#page_now_provinsi').val(p);
        $('#modal_title_provinsi').html('Edit Provinsi');
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/provinsi_by_id/id/'); ?>'+id,
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#id_provinsi').val(data.data.id);
                $('#nama').val(data.data.nama);

                $('#modal_provinsi').modal('show');
                hide_ajax_loading();
            },
            error : function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function delete_provinsi(id, p) {
        Swal({
            title: 'Apakah anda yakin ?',
            text: '"Data tidak bisa dikembalikan jika sudah terhapus"',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Data',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.value === true) {
                $.ajax({
                    type : 'DELETE',
                    url : '<?= base_url('api/masterdata/provinsi/id/'); ?>'+id,
                    cache : false,
                    dataType: 'json',
                    success: function(data){
                        get_list_provinsi(p);
                        message_delete_success();
                    },
                    error: function(e){
                        get_list_provinsi(p);
                        message_delete_success();
                    }
                });
            }
        })
    }


</script>