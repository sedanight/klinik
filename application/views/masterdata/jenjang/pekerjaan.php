<br><input type="hidden" name="page_now" id="page_now_pekerjaan"/>
<div class="row">
    <div class="col-sm-10">
       <?=form_button('tambah', '<i class="fa fa-plus"></i> Tambah pekerjaan', 'id=bt_tambah_pekerjaan class="btn btn-success"')?>
        <?=form_button('reset', '<i class="fa fa-refresh"></i> Reload Data', 'id=bt_reset_pekerjaan class="btn"')?></li>
    </div>
    <div class="col-sm-2">
        <input type="text" class="search form-control" onkeyup="get_list_pekerjaan(1)" id="pencarian_pekerjaan" placeholder="Pencarian">
    </div>
</div>
<div class="row"><br></div>

<table class="table table-condensed table-striped table-hover" id="table_pekerjaan">
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

<div class="page_summary pull-left" id="pk_summary"></div>
<div id="pk_pagination" class="pull-right"></div>

<div class="modal fade" id="modal_pekerjaan" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_pekerjaan"></h4>
            </div>
            <div class="modal-body">
                <?=form_open('', 'id=formpk role=form class=form-horizontal');?>
                    <input type="hidden" name="id" id="id_pekerjaan">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Nama pekerjaan</label>

                        <div class="col-lg-8">
                            <input type="text" name="nama" id="nama_pekerjaan" placeholder="Nama pekerjaan" class="form-control">
                        </div>
                    </div>

                <?=form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_pekerjaan()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        get_list_pekerjaan(1);

        $('#bt_tambah_pekerjaan').click(function(){
            $('#modal_pekerjaan').modal('show');
            $('#modal_title_pekerjaan').html('Tambah pekerjaan');
            reset_data_pekerjaan();
        });

        $('#bt_reset_pekerjaan').click(function(){
            reset_data_pekerjaan();
            get_list_pekerjaan(1);
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

    function reset_data_pekerjaan() {
        $('#id_pekerjaan, .form-control,  #pencarian_pekerjaan').val('');
        my_validation_remove('.form-control');
    }

    function get_pekerjaan(id) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?=base_url('api/masterdata/pekerjaan_by_id/id/');?>'+id,
            cache : false,
            dataType : 'JSON',
            success: function(data) {
                $('#pk_pagination').html('&nbsp;<br>&nbsp;<br>');
                $('#pk_summary').html(page_summary(1, 1, data.limit, data.page));

                $('#table_pekerjaan tbody').empty();
                var str =   '<tr>'+
                                '<td align="center">1</td>'+
                                '<td>'+data.data.nama+'</td>'+
                                '<td align="center" class="aksi">'+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="edit_pekerjaan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="delete_pekerjaan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                                '</td>'+
                            '</tr>';
                $('#table_pekerjaan tbody').append(str);
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function get_list_pekerjaan(p) {
        show_ajax_loading()
        $.ajax({
            type : 'GET',
            url : '<?=base_url('api/masterdata/pekerjaan/page/');?>'+p,
            cache : false,
            data : 'pencarian='+$('#pencarian_pekerjaan').val(),
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_pekerjaan(p - 1);
                    return false;
                };

                $('#pk_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#pk_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_pekerjaan tbody').empty();

                var str = '';
                $.each(data.data, function(i, v) {
                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td align="center" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_pekerjaan(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-default btn-xs" onclick="delete_pekerjaan(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                          '</tr>';
                    $('#table_pekerjaan tbody').append(str);
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
        get_list_pekerjaan(p);
    }

    function simpan_pekerjaan() {
        var stop = false;

        if ($('#nama_pekerjaan').val() === '') {
            my_validation('#nama_pekerjaan', 'Nama pekerjaan harus diisi!');
            stop = true;
        };

        if (stop) {
            return false;
        }

        var update = '';
        if ($('#id_pekerjaan').val() !== '') {
            update = 'id/'+ $('#id_pekerjaan').val();
        }

        show_ajax_loading();

        $.ajax({
            type : 'POST',
            url : '<?=base_url('api/masterdata/pekerjaan/');?>'+update,
            data : $('#formpk').serialize(),
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#modal_pekerjaan').modal('hide');

                if ($('#id_pekerjaan').val() !== '') {
                    message_edit_success();
                    get_list_pekerjaan($('#page_now_pekerjaan').val());
                } else {
                    message_add_success();
                    get_pekerjaan(data.id);
                }

                hide_ajax_loading();
            },
            error: function(e) {
                if ($('#id_pekerjaan').val() !== '') {
                    message_edit_failed();
                } else {
                    message_add_failed();
                }

                hide_ajax_loading();
            }
        });
    }

    function edit_pekerjaan(id, p) {
        show_ajax_loading();
        reset_data_pekerjaan();
        $('#page_now_pekerjaan').val(p);
        $('#modal_title_pekerjaan').html('Edit pekerjaan');
        $.ajax({
            type : 'GET',
            url : '<?=base_url('api/masterdata/pekerjaan_by_id/id/');?>'+id,
            cache : false,
            dataType : 'json',
            success: function(data) {
                // alert(data.data.nama);
                $('#id_pekerjaan').val(data.data.id);
                $('#nama_pekerjaan').val(data.data.nama);

                $('#modal_pekerjaan').modal('show');
                hide_ajax_loading();
            },
            error : function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function delete_pekerjaan(id, p) {
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
                    url : '<?=base_url('api/masterdata/pekerjaan/id/');?>'+id,
                    cache : false,
                    dataType: 'json',
                    success: function(data){
                        get_list_pekerjaan(p);
                        message_delete_success();
                    },
                    error: function(e){
                        get_list_pekerjaan(p);
                        message_delete_success();
                    }
                });
            }
        })
    }


</script>