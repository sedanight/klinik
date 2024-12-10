<br><input type="hidden" name="page_now" id="page_now_kecamatan"/>
<div class="row">
    <div class="col-sm-10">
       <?= form_button('tambah', '<i class="fa fa-plus"></i> Tambah Kecamatan' ,'id=bt_tambah_kecamatan class="btn btn-success"')?>
        <?= form_button('reset', '<i class="fa fa-refresh"></i> Reload Data' ,'id=bt_reset_kecamatan class="btn"')?></li>
    </div>
    <div class="col-sm-2">
        <input type="text" class="search form-control" onkeyup="get_list_kecamatan(1)" id="pencarian_kecamatan" placeholder="Pencarian">
    </div>
</div>
<div class="row"><br></div>

<table class="table table-condensed table-striped table-hover" id="table_kecamatan">
    <thead>
        <tr class="success">
            <th width="5%" style="text-align: center;">No</th>
            <th width="40%">Nama</th>
            <th width="40%">Kabupaten/Kota, Provinsi</th>
            <th width="15%"></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="page_summary pull-left" id="kec_summary"></div>
<div id="kec_pagination" class="pull-right"></div>


<div class="modal fade" id="modal_kecamatan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_kecamatan"></h4>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=formkec role=form class=form-horizontal'); ?>
                    <input type="hidden" name="id" id="id_kecamatan">
                    
                    <div class="form-group">
                        <label for="kabupaten" class="col-lg-2 control-label">Kabupaten</label>
                        <div class="col-lg-9">
                          <input type="text" name="id_kabupaten_kota" class="select2-input" id="kabupaten_kota_auto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kecamatan" class="col-lg-2 control-label">Kecamatan</label>
                        <div class="col-lg-9">
                          <input type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Nama Kecamatan">
                        </div>
                    </div>
                    
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_kecamatan()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        get_list_kecamatan(1);

        $('#bt_tambah_kecamatan').click(function(){
            $('#modal_kecamatan').modal('show');
            $('#modal_title_kecamatan').html('Tambah Kecamatan');
            reset_data_kecamatan();
        });

        $('#bt_reset_kecamatan').click(function(){
            reset_data_kecamatan();
            get_list_kecamatan(1);
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

        $('#kabupaten_kota_auto').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }            
        });

        $('#kabupaten_kota_auto').select2({
            ajax: {
                url: "<?= base_url('api/masterdata_auto/kabupaten_kota_auto') ?>",
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page, // page number
                    };
                },
                results: function (data, page) {
                    var more = (page * 20) < data.total; // whether or not there are more results available
         
                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {results: data.data, more: more};
                }
            },
            formatResult: function(data){
                var markup = '<b>'+data.nama+'</b><br/><i>'+data.provinsi+'</i>';
                return markup;
            }, 
            formatSelection: function(data){
                return data.nama+', '+data.provinsi;
            }
        });

    });

    function reset_data_kecamatan() {
       $('#id_kecamatan, .form-control, .select2-input, #pencarian_kecamatan').val('');
       $('#s2id_kabupaten_kota_auto a .select2-chosen').html('Pilih Kabupaten/Kota');
       my_validation_remove('.form-control');
       my_validation_remove('.select2-input');
    }


    function get_kecamatan(id) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kecamatan/id/'); ?>'+id,
            cache : false,
            dataType : 'JSON',
            success: function(data) {
                $('#kec_pagination').html('&nbsp;<br>&nbsp;<br>');
                $('#kec_summary').html(page_summary(1, 1, data.limit, data.page));

                $('#table_kecamatan tbody').empty();
                var str =   '<tr>'+
                                '<td align="center">1</td>'+
                                '<td>'+data.data.nama+'</td>'+
                                '<td>'+data.data.kabupaten+', '+data.data.provinsi+'</td>'+
                                '<td align="center" class="aksi">'+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="edit_kecamatan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="delete_kecamatan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                                '</td>'+
                            '</tr>';
                $('#table_kecamatan tbody').append(str);
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function get_list_kecamatan(p) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kecamatan_list/page/'); ?>'+p,
            cache : false,
            data : 'pencarian='+$('#pencarian_kecamatan').val(),
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_kecamatan(p - 1);
                    return false;
                };

                $('#kec_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#kec_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_kecamatan tbody').empty();

                var str = '';
                $.each(data.data, function(i, v) {
                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td>'+v.kabupaten+', '+v.provinsi+'</td>'+
                            '<td align="center" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_kecamatan(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-default btn-xs" onclick="delete_kecamatan(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                          '</tr>';
                    $('#table_kecamatan tbody').append(str);
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
        get_list_kecamatan(p);
    }

    function simpan_kecamatan() {
        var stop = false;

        if ($('#kabupaten_kota_auto').val() === '') {
            dc_validation('#kabupaten_kota_auto', 'Nama kabupaten dan kota harus diisi!');
            stop = true; 
        };
        if ($('#kecamatan').val() === '') {
            dc_validation('#kecamatan', 'Nama kecamatan harus diisi!');
            stop = true;   
        };

        if (stop) {
            return false;
        }

        var update = '';
        if ($('#id_kecamatan').val() !== '') {
            update = 'id/'+ $('#id_kecamatan').val();
        }

        show_ajax_loading();

        $.ajax({
            type : 'POST',
            url : '<?= base_url('api/masterdata/kecamatan/'); ?>'+update,
            data : $('#formkec').serialize(),
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#modal_kecamatan').modal('hide');

                if ($('#id_kecamatan').val() !== '') {
                    message_edit_success();
                    get_list_kecamatan($('#page_now_kecamatan').val());
                } else {
                    message_add_success();
                    get_kecamatan(data.id);
                }

                hide_ajax_loading();
            },
            error: function(e) {
                if ($('#id_kecamatan').val() !== '') {
                    message_edit_failed();
                } else {
                    message_add_failed();
                }

                hide_ajax_loading();
            }
        });
    }

    function edit_kecamatan(id, p) {
        reset_data_kecamatan();
        $('#page_now_kecamatan').val(p);
        $('#modal_title_kecamatan').html('Edit Kecamatan');
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kecamatan/id/'); ?>'+id,
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#id_kecamatan').val(data.data.id);
                $('#kabupaten_kota_auto').val(data.data.id_kabupaten_kota);
                $('#s2id_kabupaten_kota_auto a .select2-chosen').html(data.data.kabupaten+', '+data.data.provinsi);
                $('#kecamatan').val(data.data.nama);

                $('#modal_kecamatan').modal('show');
            },
            error : function(e) {
                access_failed(e.status);
            }
        });
    }

    function delete_kecamatan(id, p) {
        // bootbox.dialog({
        //     message: "Anda yakin akan menghapus data ini?",
        //     title: "Hapus Data",
        //     buttons: {
        //         batal: {
        //             label: '<i class="fa fa-refresh"></i> Batal',
        //             className: "btn-default",
        //             callback: function() {
                    
        //             }
        //         },
        //         hapus: {
        //             label: '<i class="fa fa-trash-o"></i>  Hapus',
        //             className: "btn-success",
        //             callback: function() {
        //                 $.ajax({
        //                     type : 'DELETE',
        //                     url: '<?= base_url("api/masterdata/kecamatan") ?>/id/'+id,
        //                     cache: false,
        //                     dataType : 'json',
        //                     success: function(data) {
        //                         get_list_kecamatan(p);
        //                         message_delete_success();
        //                     },
        //                     error: function(e){
        //                         message_delete_failed();
        //                     }
        //                 });
        //             }
        //         }
        //     }
        // });
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
                    url : '<?= base_url('api/masterdata/kecamatan/id/'); ?>'+id,
                    cache : false,
                    dataType: 'json',
                    success: function(data){
                        get_list_kecamatan(p);
                        message_delete_success();
                    },
                    error: function(e){
                        get_list_kecamatan(p);
                        message_delete_success();
                    }
                });
            }
        })
    }


</script>