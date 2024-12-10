$(function(){
    get_list_group_user(1);

    $('#bt_tambah_group_user').click(function(){
        $('#modal_group_user').modal('show');
        $('#modal_title_group_user').html('Tambah Group User');
        reset_data_group_user();
    });

    $('#bt_reset_group_user').click(function(){
        reset_data_group_user();
        get_list_group_user(1);
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

function reset_data_group_user() {
    $('#id_group_user, .form-control,  #pencarian_group_user').val('');
    my_validation_remove('.form-control');
}

function check_all(){
	$(".check").each( function() {
        $(this).attr("checked",'checked');
    });
}

function uncheck_all(){
	$(".check").each( function() {
        $(this).removeAttr('checked');
    });
}

function get_group_user(id) {
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url : 'api/sistem/group_user/id/'+id,
        cache : false,
        dataType : 'JSON',
        success: function(data) {
            $('#pagination').html('&nbsp;<br>&nbsp;<br>');
            $('#summary').html(page_summary(1, 1, data.limit, data.page));

            $('#table_group_user tbody').empty();
            var str =   '<tr>'+
                            '<td align="center">1</td>'+
                            '<td>'+data.data.nama+'</td>'+
                            '<td align="center" class="aksi">'+
                            	'<button type="button" class="btn btn-xs" onclick="edit_privileges(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-gears"></i> Edit Privileges</button> '+
                                '<button type="button" class="btn btn-xs" onclick="edit_group_user(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-xs" onclick="delete_group_user(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                        '</tr>';
            $('#table_group_user tbody').append(str);
            hide_ajax_loading();
        },
        error: function(e) {
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function get_list_group_user(p) {
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url : 'api/sistem/group_users/page/'+p,
        cache : false,
        data : 'pencarian='+$('#pencarian_group_user').val(),
        dataType : 'json',
        success: function(data) {
            if ((p > 1) & (data.data.length === 0)) {
                get_list_group_user(p - 1);
                return false;
            };

            $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
            $('#summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

            $('#table_group_user tbody').empty();

            var str = '';
            $.each(data.data, function(i, v) {
                str = '<tr>'+
                        '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                        '<td>'+v.nama+'</td>'+
                        '<td align="center" class="aksi">'+
                        	'<button type="button" class="btn btn-xs" onclick="edit_privileges(\''+v.id+'\', '+data.page+')"><i class="fa fa-gears"></i> Edit Privileges</button> '+
                            '<button type="button" class="btn btn-xs" onclick="edit_group_user(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                            '<button type="button" class="btn btn-xs" onclick="delete_group_user(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                        '</td>'+
                      '</tr>';
                $('#table_group_user tbody').append(str);
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
    get_list_group_user(p);
}

function simpan_group_user() {
    var stop = false;

    if ($('#nama_group').val() === '') {
        my_validation('#nama_group', 'Nama group harus diisi!');
        stop = true;
    };

    if (stop) {
        return false;
    }

    var update = '';
    if ($('#id_group_user').val() !== '') {
        update = 'id/'+ $('#id_group_user').val();
    }

    show_ajax_loading();

    $.ajax({
        type : 'POST',
        url : 'api/sistem/group_user/'+update,
        data : $('#formadd').serialize(),
        cache : false,
        dataType : 'json',
        success: function(data) {
            $('#modal_group_user').modal('hide');

            if ($('#id_group_user').val() !== '') {
                message_edit_success();
                get_list_group_user($('#page_now_group').val());
            } else {
                message_add_success();
                get_group_user(data.id);
            }

            hide_ajax_loading();
        },
        error: function(e) {
            if ($('#id_group_user').val() !== '') {
                message_edit_failed();
            } else {
                message_add_failed();
            }

            hide_ajax_loading();
            
        }
    });
}

function edit_group_user(id, p) {
    reset_data_group_user();
    $('#page_now_group').val(p);
    $('#modal_title_group_user').html('Edit Group User');
    $.ajax({
        type : 'GET',
        url : 'api/sistem/group_user/id/'+id,
        cache : false,
        dataType : 'json',
        success: function(data) {
            $('#id_group_user').val(data.data.id);
            $('#nama_group').val(data.data.nama);

            $('#modal_group_user').modal('show');
        },
        error : function(e) {
            access_failed(e.status);
        }
    });
}

function edit_privileges(id){
    show_ajax_loading();
	$.ajax({
        type : 'GET',
        url: 'api/sistem/group_user_privileges/id/'+id,
        cache: false,
        dataType : 'json',
        success: function(data) {
        	$('#id').val(id);
        	$('#table_priv tbody').empty();          
            var str = '';
          	var modul = '';
          	var no = 1;
            $.each(data,function(i, v){
          
            	var cek = '';
            	if (v.id_group_users !== null) {
            		cek = 'checked="checked"';
            	};

                var highlight = 'odd';
                if ((i % 2) == 1) {
                    highlight = 'even';
                };

                str = '<tr class="'+highlight+'">'+
                        '<td align="center"><b>'+((modul !== v.module)?no:'')+'</b></td>'+
                        '<td><b>'+((modul !== v.module)?v.module:'')+'</b></td>'+
                        '<td>'+v.menu+'</td>'+
                        '<td align="center" class="aksi">'+
                        	'<input type="checkbox" name="data[]" value="'+ v.id +'" '+cek+' class="check" />';
                        '</td>'+
                    '</tr>;'
                $('#table_priv tbody').append(str);

                if (modul !== v.module) {
                	no++;
                	modul = v.module;
                };
            });

            $('#modal_privileges').modal('show');
            hide_ajax_loading();
        },
        error: function(e){
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function delete_group_user(id, p) {
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
                url : 'api/sistem/group_user/id/'+id,
                cache : false,
                dataType: 'json',
                success: function(data){
                    get_list_group_user(p);
                    message_delete_success();
                },
                error: function(e){
                    get_list_group_user(p);
                    message_delete_success();
                }
            });
        }
    })
}

function save_priv(){
	var id = $('#id').val();
	$.ajax({
        type : 'POST',
        url: 'api/sistem/group_user_privileges/id/'+id,
        cache: false,
        data: $('#formprivileges').serialize(),
        dataType : 'json',
        success: function(data) {
        	$('#modal_privileges').modal('hide');
            message_edit_success();
        },
        error: function(e){
            message_edit_failed();  
        }
    });
	
}
