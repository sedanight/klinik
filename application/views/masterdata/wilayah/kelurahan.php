<br><input type="hidden" name="page_now" id="page_now_kelurahan"/>
<div class="row">
    <div class="col-sm-10">
       <?= form_button('tambah', '<i class="fa fa-plus"></i> Tambah kelurahan' ,'id=bt_tambah_kelurahan class="btn btn-success"')?>
        <?= form_button('reset', '<i class="fa fa-refresh"></i> Reload Data' ,'id=bt_reset_kelurahan class="btn"')?></li>
    </div>
    <div class="col-sm-2">
        <input type="text" class="search form-control" onkeyup="get_list_kelurahan(1)" id="pencarian_kelurahan" placeholder="Pencarian">
    </div>
</div>
<div class="row"><br></div>

<table class="table table-condensed table-striped table-hover" id="table_kelurahan">
    <thead>
        <tr class="success">
            <th width="5%" style="text-align: center;">No</th>
            <th width="40%">Nama</th>
            <th width="40%">Kecamatan, Kabupaten/Kota, Provinsi</th>
            <th width="15%"></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="page_summary pull-left" id="kel_summary"></div>
<div id="kel_pagination" class="pull-right"></div>


<div class="modal fade" id="modal_kelurahan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_kelurahan"></h4>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=formkel role=form class=form-horizontal'); ?>
                    <input type="hidden" name="id" id="id_kelurahan">
                    
                    <div class="form-group">
                        <label for="kecamatan" class="col-lg-2 control-label">Kecamatan</label>
                        <div class="col-lg-10">
                          <input type="text" name="id_kecamatan" class="select2-input" id="kecamatan_auto" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kelurahan" class="col-lg-2 control-label">Kelurahan</label>
                        <div class="col-lg-10">
                          <input type="text" name="kelurahan" class="form-control" id="kelurahan" placeholder="Nama Kelurahan">
                        </div>
                    </div>
                    
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_kelurahan()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        get_list_kelurahan(1);

        $('#bt_tambah_kelurahan').click(function(){
            $('#modal_kelurahan').modal('show');
            $('#modal_title_kelurahan').html('Tambah Kelurahan');
            reset_data_kelurahan();
        });

        $('#bt_reset_kelurahan').click(function(){
            reset_data_kelurahan();
            get_list_kelurahan(1);
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

        $('#kecamatan_auto').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }            
        });

        $('#kecamatan_auto').select2({
            ajax: {
                url: "<?= base_url('api/masterdata_auto/kecamatan_auto') ?>",
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
                var markup = '<b>'+data.nama+'</b><br/><i>'+data.kabupaten+', '+data.provinsi+'</i>';
                return markup;
            }, 
            formatSelection: function(data){
                return data.nama+', '+data.kabupaten+', '+data.provinsi;
            }
        });

    });

    function reset_data_kelurahan() {
       $('#id_kelurahan, .form-control, .select2-input, #pencarian_kelurahan').val('');
       $('#s2id_kecamatan_auto a .select2-chosen').html('Pilih Kecamatan');
       my_validation_remove('.form-control');
       my_validation_remove('.select2-input');
    }


    function get_kelurahan(id) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kelurahan/id/'); ?>'+id,
            cache : false,
            dataType : 'JSON',
            success: function(data) {
                $('#kel_pagination').html('&nbsp;<br>&nbsp;<br>');
                $('#kel_summary').html(page_summary(1, 1, data.limit, data.page));

                $('#table_kelurahan tbody').empty();
                var str =   '<tr>'+
                                '<td align="center">1</td>'+
                                '<td>'+data.data.nama+'</td>'+
                                '<td>'+data.data.kecamatan+', '+data.data.kabupaten+', '+data.data.provinsi+'</td>'+
                                '<td align="center" class="aksi">'+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="edit_kelurahan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                    '<button type="button" class="btn btn-default btn-xs" onclick="delete_kelurahan(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                                '</td>'+
                            '</tr>';
                $('#table_kelurahan tbody').append(str);
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function get_list_kelurahan(p) {
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kelurahan_list/page/'); ?>'+p,
            cache : false,
            data : 'pencarian='+$('#pencarian_kelurahan').val(),
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_kelurahan(p - 1);
                    return false;
                };

                $('#kel_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#kel_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_kelurahan tbody').empty();

                var str = '';
                $.each(data.data, function(i, v) {
                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td>'+v.kecamatan+', '+v.kabupaten+', '+v.provinsi+'</td>'+
                            '<td align="center" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_kelurahan(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-default btn-xs" onclick="delete_kelurahan(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                          '</tr>';
                    $('#table_kelurahan tbody').append(str);
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
        get_list_kelurahan(p);
    }

    function simpan_kelurahan() {
        var stop = false;

        if ($('#kecamatan_auto').val() === '') {
            my_validation('#kecamatan_auto', 'Nama kecamatan harus diisi!');
            stop = true;   
        };
        if ($('#kelurahan').val() === '') {
            my_validation('#kelurahan', 'Nama Kelurahan harus diisi!');
            stop = true;      
        };

        if (stop) {
            return false;
        }

        var update = '';
        if ($('#id_kelurahan').val() !== '') {
            update = 'id/'+ $('#id_kelurahan').val();
        }

        show_ajax_loading();

        $.ajax({
            type : 'POST',
            url : '<?= base_url('api/masterdata/kelurahan/'); ?>'+update,
            data : $('#formkel').serialize(),
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#modal_kelurahan').modal('hide');

                if ($('#id_kelurahan').val() !== '') {
                    message_edit_success();
                    get_list_kelurahan($('#page_now_kelurahan').val());
                } else {
                    message_add_success();
                    get_kelurahan(data.id);
                }

                hide_ajax_loading();
            },
            error: function(e) {
                if ($('#id_kelurahan').val() !== '') {
                    message_edit_failed();
                } else {
                    message_add_failed();
                }

                hide_ajax_loading();
            }
        });
    }

    function edit_kelurahan(id, p) {
        reset_data_kelurahan();
        $('#page_now_kelurahan').val(p);
        $('#modal_title_kelurahan').html('Edit kelurahan');
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/masterdata/kelurahan/id/'); ?>'+id,
            cache : false,
            dataType : 'json',
            success: function(data) {
                $('#id_kelurahan').val(data.data.id);
                $('#kecamatan_auto').val(data.data.id_kecamatan);
                $('#s2id_kecamatan_auto a .select2-chosen').html(data.data.kecamatan+', '+data.data.kabupaten+', '+data.data.provinsi);
                $('#kelurahan').val(data.data.nama);

                $('#modal_kelurahan').modal('show');
            },
            error : function(e) {
                access_failed(e.status);
            }
        });
    }

    function delete_kelurahan(id, p) {
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
        //                     url: '<?= base_url("api/masterdata/kelurahan") ?>/id/'+id,
        //                     cache: false,
        //                     dataType : 'json',
        //                     success: function(data) {
        //                         get_list_kelurahan(p);
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
                    url : '<?= base_url('api/masterdata/kelurahan/id/'); ?>'+id,
                    cache : false,
                    dataType: 'json',
                    success: function(data){
                        get_list_kelurahan(p);
                        message_delete_success();
                    },
                    error: function(e){
                        get_list_kelurahan(p);
                        message_delete_success();
                    }
                });
            }
        })
    }


</script>