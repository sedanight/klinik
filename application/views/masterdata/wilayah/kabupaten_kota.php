<br><input type="hidden" name="page_now" id="page_now_kabupaten_kota"/>
<div class="row">
    <div class="col-sm-10">
       <?= form_button('tambah', '<i class="fa fa-plus"></i> Tambah Kabupaten dan Kota' ,'id=bt_tambah_kabupaten_kota class="btn btn-success"')?>
        <?= form_button('reset', '<i class="fa fa-refresh"></i> Reload Data' ,'id=bt_reset_kabupaten_kota class="btn"')?></li>
    </div>
    <div class="col-sm-2">
        <input type="text" class="search form-control" onkeyup="get_list_kabupaten_kota(1)" id="pencarian_kabupaten_kota" placeholder="Pencarian">
    </div>
</div>
<div class="row"><br></div>

<table class="table table-condensed table-striped table-hover" id="table_kabupaten_kota">
    <thead>
        <tr class="success">
            <th width="5%" style="text-align: center;">No</th>
            <th width="40%">Nama</th>
            <th width="40%">Provinsi</th>
            <th width="15%"></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="page_summary pull-left" id="kab_summary"></div>
<div id="kab_pagination" class="pull-right"></div>


<div class="modal fade" id="modal_kabupaten_kota" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_kabupaten_kota"></h4>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=formkabkot role=form class=form-horizontal'); ?>
                    <input type="hidden" name="id" id="id_kabupaten_kota">
                    
                    <div class="form-group">
                        <label for="provinsi_auto" class="col-lg-3 control-label">Provinsi</label>
                        <div class="col-lg-8">
                          <input type="text" name="id_provinsi" id="provinsi_auto" class="select2-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Kabupaten/Kota</label>

                        <div class="col-lg-8">
                            <input type="text" name="nama" id="kabupaten" placeholder="Nama Kabupaten/Kota" class="form-control">
                        </div>
                    </div>
                    
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_kabupaten_kota()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        get_list_kabupaten_kota(1);

        $('#bt_tambah_kabupaten_kota').click(function(){
            $('#modal_kabupaten_kota').modal('show');
            $('#modal_title_kabupaten_kota').html('Tambah Kabupaten dan Kota');
            reset_data_kabupaten_kota();
        });

        $('#bt_reset_kabupaten_kota').click(function(){
            reset_data_kabupaten_kota();
            get_list_kabupaten_kota(1);
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

        $('#provinsi_auto').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }            
        });

        $('#provinsi_auto').select2({
            ajax: {
                url: "<?= base_url('api/masterdata_auto/provinsi_auto') ?>",
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page // page number
                    };
                },
                results: function (data, page) {
                    var more = (page * 20) < data.total; // whether or not there are more results available
         
                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {results: data.data, more: more};
                }
            },
            formatResult: function(data){
                var markup = data.nama;
                return markup;
            }, 
            formatSelection: function(data){
                return data.nama;
            }
        });

    });

    function reset_data_kabupaten_kota() {
       $('#id_kabupaten_kota, .form-control, .select2-input, #pencarian_kabupaten_kota').val('');
       $('#s2id_provinsi_auto a .select2-chosen').html('Pilih Provinsi');
       my_validation_remove('.form-control');
       my_validation_remove('.select2-input');
    }


    function get_kabupaten_kota(id) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kabupaten_kota/id/'); ?>'+id,
            cache : false,
            dataType : 'JSON',
            success: function(data) {
                $('#kab_pagination').html('&nbsp;<br>&nbsp;<br>');
                $('#kab_summary').html(page_summary(1, 1, data.limit, data.page));

                $('#table_kabupaten_kota tbody').empty();
                var str =   '<tr>'+
                                '<td align="center">1</td>'+
                                '<td>'+data.data.nama+'</td>'+
                                '<td>'+data.data.provinsi+'</td>'+
                                '<td align="center" class="aksi">'+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="edit_kabupaten_kota(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="delete_kabupaten_kota(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                                '</td>'+
                            '</tr>';
                $('#table_kabupaten_kota tbody').append(str);
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function get_list_kabupaten_kota(p) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kabupaten_kota_list/page/'); ?>'+p,
            cache : false,
            data : 'pencarian='+$('#pencarian_kabupaten_kota').val(),
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_kabupaten_kota(p - 1);
                    return false;
                };

                $('#kab_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#kab_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_kabupaten_kota tbody').empty();

                var str = '';
                $.each(data.data, function(i, v) {
                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td>'+v.provinsi+'</td>'+
                            '<td align="center" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_kabupaten_kota(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-default btn-xs" onclick="delete_kabupaten_kota(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                          '</tr>';
                    $('#table_kabupaten_kota tbody').append(str);
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
        get_list_kabupaten_kota(p);
    }

    function simpan_kabupaten_kota() {
        var stop = false;

        if ($('#provinsi_auto').val() === '') {
            my_validation('#provinsi_auto', 'Nama provinsi harus diisi!');
            stop = true; 
        };
        if ($('#kabupaten').val() === '') {
            my_validation('#kabupaten', 'Nama kabupaten/kota harus diisi!');
            stop = true;   
        };

        if (stop) {
            return false;
        }

        var update = '';
        if ($('#id_kabupaten_kota').val() !== '') {
            update = 'id/'+ $('#id_kabupaten_kota').val();
        }

        show_ajax_loading();

        $.ajax({
            type : 'POST',
            url : '<?= base_url('api/masterdata/kabupaten_kota/'); ?>'+update,
            data : $('#formkabkot').serialize(),
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#modal_kabupaten_kota').modal('hide');

                if ($('#id_kabupaten_kota').val() !== '') {
                    message_edit_success();
                    get_list_kabupaten_kota($('#page_now_kabupaten_kota').val());
                } else {
                    message_add_success();
                    get_kabupaten_kota(data.id);
                }

                hide_ajax_loading();
            },
            error: function(e) {
                if ($('#id_kabupaten_kota').val() !== '') {
                    message_edit_failed();
                } else {
                    message_add_failed();
                }

                hide_ajax_loading();
            }
        });
    }

    function edit_kabupaten_kota(id, p) {
        reset_data_kabupaten_kota();
        $('#page_now_kabupaten_kota').val(p);
        $('#modal_title_kabupaten_kota').html('Edit Kabupaten dan Kota');
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kabupaten_kota/id/'); ?>'+id,
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#id_kabupaten_kota').val(data.data.id);
                $('#provinsi_auto').val(data.data.id_provinsi);
                $('#s2id_provinsi_auto a .select2-chosen').html(data.data.provinsi);
                $('#kabupaten').val(data.data.nama);

                $('#modal_kabupaten_kota').modal('show');
            },
            error : function(e) {
                access_failed(e.status);
            }
        });
    }

    function delete_kabupaten_kota(id, p) {
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
                    url : '<?= base_url('api/masterdata/kabupaten_kota/id/'); ?>'+id,
                    cache : false,
                    dataType: 'json',
                    success: function(data){
                        get_list_kabupaten_kota(p);
                        message_delete_success();
                    },
                    error: function(e){
                        get_list_kabupaten_kota(p);
                        message_delete_success();
                    }
                });
            }
        })
    }


</script>