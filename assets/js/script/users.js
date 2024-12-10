$(function(){
    get_list_user(1);

    $('#bt_tambah_user').click(function(){
        $('#modal_user').modal('show');
        $('#modal_title_user').html('Tambah User');
        $('.add_pass').show();
        $('.edit_pass').hide();
        reset_data_user();
    });

    // $('#username').keyup(function(){
    //     cek_username($(this).val());
    // });

    $('#guru').select2({
        ajax: {
            url : 'api/masterdata_auto/guru_auto',
            dataType : 'json',
            quietMillis : 100,
            data: function (term, page) {
                return {
                    q: term,
                    page: page,
                    param: 'not_in'
                };
            },
            results: function (data,page) {
                var more = (page * 20) < data.total;
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

    $('#group').select2({
        ajax: {
            url: "api/sistem_auto/group_user_auto",
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
            var markup = data.nama;
            return markup;
        }, 
        formatSelection: function(data){
            return data.nama;
        }
    });

    $('#unit').select2({
        ajax: {
            url: "api/masterdata_auto/unit_auto",
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
            var markup = data.nama;
            return markup;
        }, 
        formatSelection: function(data){
            return data.nama;
        }
    });

    $('#bt_reset_user').click(function(){
        reset_data_user();
        get_list_user(1);
    });

    $('.form-control').keyup(function(){
        if ($(this).val() !== '') {
            my_validation_remove(this);
        }
    });

    $('.form-control, #guru, #group').change(function(){
        if ($(this).val() !== '') {
            my_validation_remove(this);
        }
    });

});

function reset_data_user() {
    $('#id_user, .form-control, .select2-input  #pencarian_user').val('');
    $('.select2-chosen').html('');
    my_validation_remove('.form-control');
    my_validation_remove('.select2-input');
}

function get_user(id) {
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url : 'api/sistem/user/id/'+id,
        cache : false,
        dataType : 'JSON',
        success: function(data) {
            $('#u_pagination').html('&nbsp;<br>&nbsp;<br>');
            $('#u_summary').html(page_summary(1, 1, data.limit, data.page));

            $('#table_user tbody').empty();
            var str =   '<tr>'+
                            '<td align="center">1</td>'+
                            '<td>'+data.data.username+'</td>'+
                            '<td>'+data.data.nama+'</td>'+
                            '<td>'+data.data.unit+'</td>'+
                            '<td>'+data.data.group_user+'</td>'+
                            '<td align="center" class="aksi">'+
                            	'<button type="button" class="btn btn-xs" onclick="reset_password(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-refresh"></i> Reset Password</button> '+
                                '<button type="button" class="btn btn-xs" onclick="edit_user(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-xs" onclick="delete_user(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                        '</tr>';
            $('#table_user tbody').append(str);
            hide_ajax_loading();
        },
        error: function(e) {
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function get_list_user(p) {
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url : 'api/sistem/users/page/'+p,
        cache : false,
        data : 'pencarian='+$('#pencarian_user').val(),
        dataType : 'json',
        success: function(data) {
            if ((p > 1) & (data.data.length === 0)) {
                get_list_user(p - 1);
                return false;
            };

            $('#u_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
            $('#u_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

            $('#table_user tbody').empty();

            var str = '';
            $.each(data.data, function(i, v) {
                str = '<tr>'+
                        '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                        '<td>'+v.username+'</td>'+
                        '<td>'+v.nama+'</td>'+
                        '<td>'+v.unit+'</td>'+
                        '<td>'+v.group_user+'</td>'+
                        '<td align="center" class="aksi">'+
                        	'<button type="button" class="btn btn-xs" onclick="reset_password(\''+v.id+'\',\''+v.nama+'\')"><i class="fa fa-refresh"></i> Reset Password</button> '+
                            '<button type="button" class="btn btn-xs" onclick="edit_user(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                            '<button type="button" class="btn btn-xs" onclick="delete_user(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                        '</td>'+
                      '</tr>';
                $('#table_user tbody').append(str);
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
    get_list_user(p);
}

function simpan_user() {
    var stop = false;

    if ($('#guru').val() === '') {
        my_validation('#guru', 'Nama guru harus diisi!');
        stop = true;
    };

    if ($('#username').val() === '') {
        my_validation('#username', 'Username harus diisi!');
        stop = true; 
    };

    if ($('#group').val() === '') {
        my_validation('#group', 'Group harus dipilih!');
        stop = true;
    };

    if (stop) {
        return false;
    }

    var update = '';
    if ($('#id_user').val() !== '') {
        update = 'id/'+ $('#id_user').val();
    }

    show_ajax_loading();
    $.ajax({
        type : 'POST',
        url : 'api/sistem/user/'+update,
        data : $('#formuser').serialize(),
        cache : false,
        dataType : 'json',
        success: function(data) {
            $('#modal_user').modal('hide');

            if ($('#id_user').val() !== '') {
                message_edit_success();
                get_list_user($('#page_now').val());
            } else {
                message_add_success();
                get_user(data.id);
            }
            hide_ajax_loading();
        },
        error: function(e) {
            if ($('#id_user').val() !== '') {
                message_edit_failed();
            } else {
                message_add_failed();
            }
            hide_ajax_loading();
        }
    });
}

function edit_user(id, p) {
    show_ajax_loading();
    reset_data_user();
    $('#page_now').val(p);
    $('#modal_title_user').html('Edit User');

    $('.add_pass').hide();
    $('.edit_pass').show();

    $.ajax({
        type : 'GET',
        url : 'api/sistem/user/id/'+id,
        cache : false,
        dataType : 'json',
        success: function(data) {
            $('#id_user, #guru').val(data.data.id);
            $('#s2id_guru a .select2-chosen').html(data.data.nama);
            $('#s2id_group a .select2-chosen').html(data.data.group_user);
            $('#s2id_unit a .select2-chosen').html(data.data.unit);
            $('#username').val(data.data.username);
            $('#group').val(data.data.id_group_users);
            $('#unit').val(data.data.id_unit);

            $('#modal_user').modal('show');
            hide_ajax_loading();
        },
        error : function(e) {
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}


function delete_user(id, p) {
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
                url : 'api/sistem/user/id/'+id,
                cache : false,
                dataType: 'json',
                success: function(data){
                    get_list_user(p);
                    message_delete_success();
                },
                error: function(e){
                    get_list_user(p);
                    message_delete_success();
                }
            });
        }
    })
}

function cek_username(username) {
    $.ajax({
        type : 'GET',
        url : 'api/sistem/cek_username',
        data : 'username='+username,
        cache : false,
        dataType : 'json',
        success: function (data) {
            if (data) {
                my_validation('#username', 'Username sudah dipakai, silahkan cari username lain');
                $('bt_simpan').attr('disabled', 'disabled');
            }  else {
                my_validation_remove('#username');
                $('bt_simpan').removeAttr('disabled');
            }
        },
        error: function (e) {
            message_custom('error', 'Sistem Error');
        }
    });
}

function reset_password(id, nama){
    swal({
        type: "info",
        title: "Reset Password !",
        html:
            "Password anda akan direset menjadi <b>1234</b>, <br>" +
            "Anda yakin akan mereset password <b>"+nama+"</b>",
        customClass: 'swal-wide',
        showCancelButton: true,
        confirmButtonText: 'Ya, Reset Password',
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.value === true) {
            $.ajax({
                type : 'GET',
                url : 'api/sistem/user_reset_password/id/'+id,
                cache : false,
                dataType: 'json',
                error: function(e){
                    message_custom('success', 'Reset Password', 'Berhasil reset password');
                },
            });
        }
    }); 
}