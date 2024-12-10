<br><input type="hidden" name="page_now" id="page_now_pendidikan"/>
<div class="row">
	<div class="col-sm-10">
       <?=form_button('tambah', '<i class="fa fa-plus"></i> Tambah Pendidikan', 'id=bt_tambah_pendidikan class="btn btn-success"')?>
        <?=form_button('reset', '<i class="fa fa-refresh"></i> Reload Data', 'id=bt_reset_pendidikan class="btn"')?></li>
    </div>
    <div class="col-sm-2">
        <input type="text" class="search form-control" onkeyup="get_list_pendidikan(1)" id="pencarian_pendidikan" placeholder="Pencarian">
    </div>
</div>
<div class="row"><br></div>

<table class="table table-condensed table-striped table-hover" id="table_pendidikan">
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

<div class="modal fade" id="modal_pendidikan" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_pendidikan"></h4>
            </div>
            <div class="modal-body">
                <?=form_open('', 'id=formadd role=form class=form-horizontal');?>
                    <input type="hidden" name="id" id="id_pendidikan">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Nama pendidikan</label>

                        <div class="col-lg-8">
                            <input type="text" name="nama" id="nama" placeholder="Nama pendidikan" class="form-control">
                        </div>
                    </div>

                <?=form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_pendidikan()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        get_list_pendidikan(1);

        $('#bt_tambah_pendidikan').click(function(){
            $('#modal_pendidikan').modal('show');
            $('#modal_title_pendidikan').html('Tambah pendidikan');
            reset_data_pendidikan();
        });

        $('#bt_reset_pendidikan').click(function(){
            reset_data_pendidikan();
            get_list_pendidikan(1);
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

    function reset_data_pendidikan() {
        $('#id_pendidikan, .form-control,  #pencarian_pendidikan').val('');
        my_validation_remove('.form-control');
    }

    function get_pendidikan(id) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?=base_url('api/masterdata/pendidikan_by_id/id/');?>'+id,
            cache : false,
            dataType : 'JSON',
            success: function(data) {
                $('#p_pagination').html('&nbsp;<br>&nbsp;<br>');
                $('#p_summary').html(page_summary(1, 1, data.limit, data.page));

                $('#table_pendidikan tbody').empty();
                var str =   '<tr>'+
                                '<td align="center">1</td>'+
                                '<td>'+data.data.nama+'</td>'+
                                '<td align="center" class="aksi">'+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="edit_pendidikan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="delete_pendidikan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                                '</td>'+
                            '</tr>';
                $('#table_pendidikan tbody').append(str);
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function get_list_pendidikan(p) {
        show_ajax_loading()
        $.ajax({
            type : 'GET',
            url : '<?=base_url('api/masterdata/pendidikan/page/');?>'+p,
            cache : false,
            data : 'pencarian='+$('#pencarian_pendidikan').val(),
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_pendidikan(p - 1);
                    return false;
                };

                $('#p_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#p_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_pendidikan tbody').empty();

                var str = '';
                $.each(data.data, function(i, v) {
                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td align="center" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_pendidikan(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-default btn-xs" onclick="delete_pendidikan(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                          '</tr>';
                    $('#table_pendidikan tbody').append(str);
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
        get_list_pendidikan(p);
    }

    function simpan_pendidikan() {
        var stop = false;

        if ($('#nama').val() === '') {
            my_validation('#nama', 'Nama pendidikan harus diisi!');
            stop = true;
        };

        if (stop) {
            return false;
        }

        var update = '';
        if ($('#id_pendidikan').val() !== '') {
            update = 'id/'+ $('#id_pendidikan').val();
        }

        show_ajax_loading();

        $.ajax({
            type : 'POST',
            url : '<?=base_url('api/masterdata/pendidikan/');?>'+update,
            data : $('#formadd').serialize(),
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#modal_pendidikan').modal('hide');

                if ($('#id_pendidikan').val() !== '') {
                    message_edit_success();
                    get_list_pendidikan($('#page_now_pendidikan').val());
                } else {
                    message_add_success();
                    get_pendidikan(data.id);
                }

                hide_ajax_loading();
            },
            error: function(e) {
                if ($('#id_pendidikan').val() !== '') {
                    message_edit_failed();
                } else {
                    message_add_failed();
                }

                hide_ajax_loading();
            }
        });
    }

    function edit_pendidikan(id, p) {
        show_ajax_loading();
        reset_data_pendidikan();
        $('#page_now_pendidikan').val(p);
        $('#modal_title_pendidikan').html('Edit pendidikan');
        $.ajax({
            type : 'GET',
            url : '<?=base_url('api/masterdata/pendidikan_by_id/id/');?>'+id,
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#id_pendidikan').val(data.data.id);
                $('#nama').val(data.data.nama);

                $('#modal_pendidikan').modal('show');
                hide_ajax_loading();
            },
            error : function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function delete_pendidikan(id, p) {
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
                    url : '<?=base_url('api/masterdata/pendidikan/id/');?>'+id,
                    cache : false,
                    dataType: 'json',
                    success: function(data){
                        get_list_pendidikan(p);
                        message_delete_success();
                    },
                    error: function(e){
                        get_list_pendidikan(p);
                        message_delete_success();
                    }
                });
            }
        })
    }


</script>