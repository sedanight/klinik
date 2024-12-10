$(function(){
    get_list_guru(1);

    $('#bt_tambah_guru').click(function(){
        $('#modal_guru').modal('show');
        $('#modal_title_guru').html('Tambah Guru');
        reset_data_guru();
    });

    $('#bt_reset_guru').click(function(){
        reset_data_guru();
        get_list_guru(1);
    });

    $("#tanggal_lahir").datepicker({
        format: 'dd/mm/yyyy',
        endDate: "1d"
    }).on('changeDate', function(){
        $(this).datepicker('hide');
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


function reset_data_guru() {
    $('#id_guru, .form-control, #pencarian_guru').val('');
    my_validation_remove('.form-control');
}

function get_guru(id) {
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url : 'api/masterdata/guru/id/'+id,
        cache : false,
        dataType : 'JSON',
        success: function(data) {
            $('#pagination').html('&nbsp;<br>&nbsp;<br>');
            $('#summary').html(page_summary(1, 1, data.limit, data.page));

            var kelamin = '';
            if (data.data.kelamin == 'L') {
                kelamin = 'Laki-laki';
            } else if (data.data.kelamin == 'P') {
                kelamin = 'Perempuan';
            }

            $('#table_guru tbody').empty();

            var str =  '<tr>'+
                        '<td align="center">1</td>'+
                        '<td>'+data.data.nip+'</td>'+
                        '<td>'+data.data.nama+'</td>'+
                        '<td align="center">'+kelamin+'</td>'+
                        '<td align="center">'+((data.data.tanggal_lahir !== null)?datefmysql(data.data.tanggal_lahir):'')+'</td>'+
                        '<td align="center">'+data.data.telp+'</td>'+
                        '<td align="center">'+data.data.alamat+'</td>'+
                        '<td align="center">'+data.data.agama+'</td>'+
                        '<td align="center" class="aksi">'+
                            '<button type="button" class="btn btn-default btn-xs" onclick="edit_guru(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                            '<button type="button" class="btn btn-default btn-xs" onclick="delete_guru(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                        '</td>'+
                      '</tr>';
            $('#table_guru tbody').append(str);
            hide_ajax_loading();
        },
        error: function(e) {
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function get_list_guru(p) {
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url : 'api/masterdata/guru_list/page/'+p,
        cache : false,
        data : 'pencarian='+$('#pencarian_guru').val(),
        dataType : 'json',
        success: function(data) {
            if ((p > 1) & (data.data.length === 0)) {
                get_list_guru(p - 1);
                return false;
            };

            $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
            $('#summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

            $('#table_guru tbody').empty();

            var str = '';
            var kelamin = '';

            $.each(data.data, function(i, v) {

                if (v.kelamin == 'L') {
                    kelamin = 'Laki-laki';
                }else if(v.kelamin == 'P'){
                    kelamin = 'Perempuan';
                }

                str = '<tr>'+
                        '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                        '<td>'+v.nip+'</td>'+
                        '<td>'+v.nama+'</td>'+
                        '<td align="center">'+kelamin+'</td>'+
                        '<td align="center">'+((v.tanggal_lahir !== null)?datefmysql(v.tanggal_lahir):'')+'</td>'+
                        '<td align="center">'+v.telp+'</td>'+
                        '<td>'+v.alamat+'</td>'+
                        '<td align="center">'+v.agama+'</td>'+
                        '<td align="center" class="aksi">'+
                            '<button type="button" class="btn btn-default btn-xs" onclick="edit_guru(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                            '<button type="button" class="btn btn-default btn-xs" onclick="delete_guru(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                        '</td>'+
                      '</tr>';
                $('#table_guru tbody').append(str);
            });
            hide_ajax_loading();
        },
        error: function(e){
            access_failed(e.status);
            hide_ajax_loading()
        }
    });
}

function paging(p) {
    get_list_guru(p);
}

function simpan_guru() {
    var stop = false;

    if ($('#nama').val() === '') {
        my_validation('#nama', 'Nama Guru harus diisi!');
        stop = true;
    };

    if ($('#kelamin').val() === '') {
        my_validation('#kelamin', 'Jenis kelamin harus dipilih!');
        stop = true;
    };

    if ($('#tanggal_lahir').val() === '') {
        my_validation('#tanggal_lahir', 'Tanggal lahir harus diisi!');
        stop = true;
    };

    if (stop) {
        return false;
    }

    var update = '';
    if ($('#id_guru').val() !== '') {
        update = 'id/'+ $('#id_guru').val();
    }

    show_ajax_loading();
    $.ajax({
        type : 'POST',
        url : 'api/masterdata/guru/'+update,
        data : $('#addform').serialize(),
        cache : false,
        dataType : 'json',
        success: function(data) {
            $('#modal_guru').modal('hide');

            if ($('#id_guru').val() !== '') {
                message_edit_success();
                get_list_guru($('#page_now').val());
            } else {
                message_add_success();
                get_guru(data.id);
            }

            hide_ajax_loading();

        },
        error: function(e) {
            if ($('#id_guru').val() !== '') {
                message_edit_failed();
            } else {
                message_add_failed();
            }

            hide_ajax_loading();
        }
    });
}

function edit_guru(id, p) {
    show_ajax_loading();
    reset_data_guru();
    $('#page_now').val(p);
    $('#modal_title_guru').html('Edit Guru');
    $.ajax({
        type : 'GET',
        url : 'api/masterdata/guru/id/'+id,
        cache : false,
        dataType : 'json',
        success: function(data) {
            $('#id_guru').val(data.data.id);
            $('#nip').val(data.data.nip);
            $('#nama').val(data.data.nama);
            $('#kelamin').val(data.data.kelamin);
            $('#tempat_lahir').val(data.data.tempat_lahir);
            $('#tanggal_lahir').val((data.data.tanggal_lahir !== null)?datefmysql(data.data.tanggal_lahir):'');
            $('#alamat').val(data.data.alamat);
            $('#agama').val(data.data.agama);
            $('#telp').val(data.data.telp);

            $('#modal_guru').modal('show');
            hide_ajax_loading();
        },
        error : function(e) {
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function delete_guru(id, p) {
    Swal({
        title: 'Apakah anda yakin ?',
        text: '"Data tidak bisa dikembalikan jika sudah terhapus"',
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus Data',
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.value === true) {
            $.ajax({
                type : 'DELETE',
                url : 'api/masterdata/guru/id/'+id,
                cache : false,
                dataType: 'json',
                success: function(data){
                    get_list_guru(p);
                    message_delete_success();
                },
                error: function(e){
                    get_list_guru(p);
                    message_delete_success();
                }
            });
        }
    })
}