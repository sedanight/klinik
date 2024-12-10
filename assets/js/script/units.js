$(document).ready(function () {

	get_list_units(1);

	$('#bt_tambah_modal_units').click(function(){
        $('#modal_units').modal('show');
        $('#modal_title_units').html('Tambah Data Unit');
        reset_data_units();
    });

    $('#bt_reset_units').click(function(){
        reset_data_units();
        get_list_units(1);
    });

    $('.form-control').keyup(function(){
        if($(this).val() !== ''){
            my_validation_remove(this);
        }            
    });

    $('.form-control').change(function(){
        if($(this).val() !== ''){
            my_validation_remove(this);
        }            
    });

    $('input').keyup(function() {
        this.value = this.value.toUpperCase();
    });
});

function reset_data_units(){
   	$('#id_units, .form-control, #pencarian_units').val('');
   	my_validation_remove('.form-control');
}

function paging(p) {
    get_list_units(p);
}

function get_units(id) {
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url : 'api/masterdata/units/id/'+id,
        cache : false,
        dataType : 'JSON',
        success: function(data) {
            $('#pagination').html('&nbsp;<br>&nbsp;<br>');
            $('#summary').html(page_summary(1, 1, data.limit, data.page));

            $('#table_units tbody').empty();

            var str =   '<tr>'+
                            '<td align="center">1</td>'+
                            '<td>'+data.data.nama+'</td>'+
                            '<td align="center" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_units(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil-square-o"></i> Edit</button> '+
                                '<button type="button" class="btn btn-default btn-xs" onclick="delete_units(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-trash"></i> Hapus</button>'+
                            '</td>'+
                        '</tr>';
            $('#table_units tbody').append(str);
            hide_ajax_loading();
        },
        error: function(e) {
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function get_list_units(p){
    show_ajax_loading();
    $.ajax({
        type : 'GET',
        url: 'api/masterdata/units_list/page/'+p,
        cache: false,
        data: 'pencarian='+$('#pencarian_units').val(),
        dataType : 'json',
        success: function(data) {
            if ((p > 1) & (data.data.length === 0)) {
                get_list_units(p-1);
                return false;
            };
            
            $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
            $('#summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

            $('#table_units tbody').empty();          
            var str = '';

            $.each(data.data,function(i, v){

                str = '<tr>'+
                        '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                        '<td>'+v.nama+'</td>'+
                        '<td align="center" class="aksi">'+
                            '<button type="button" class="btn btn-default btn-xs" onclick="edit_units(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil"></i> Edit</button> '+
                            '<button type="button" class="btn btn-default btn-xs" onclick="delete_units(\''+v.id+'\', '+data.page+')"><i class="fa fa-trash-o"></i> Hapus</button>'+
                        '</td>'+
                    '</tr>';
                $('#table_units tbody').append(str);
            });  
            hide_ajax_loading();
          
        },
        error: function(e){
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function simpan_units() {
    var stop = false;

    if ($('#nama').val() === '') {
        my_validation('#nama', 'Nama unit harus diisi!');
        stop = true;
    };

    if (stop) {
        return false;
    }

    var update = '';
    if ($('#id_units').val() !== '') {
        update = 'id/'+ $('#id_units').val();
    }

    show_ajax_loading();
    
    $.ajax({
        type : 'POST',
        url : 'api/masterdata/units/'+update,
        data : $('#addform').serialize(),
        cache : false,
        dataType : 'json',
        success: function(data) {
            $('#modal_units').modal('hide');

            if ($('#id_units').val() !== '') {
                message_edit_success();
                get_list_units($('#page_now').val());
            } else {
                message_add_success();
                get_units(data.id);
            }

            hide_ajax_loading();

        },
        error: function(e) {
            if ($('#id_units').val() !== '') {
                message_edit_failed();
            } else {
                message_add_failed();
            }

            hide_ajax_loading();
        }
    });
}

function edit_units(id, p){
    show_ajax_loading();
    reset_data_units();
    $('#page_now').val(p);
    $('#modal_title_units').html('Edit Data Unit');
    $.ajax({
        type : 'GET',
        url: 'api/masterdata/units/id/'+id,
        cache: false,
        dataType : 'json',
        success: function(data) {
            $('#id_units').val(data.data.id);
            $('#nama').val(data.data.nama);
            
            $('#modal_units').modal('show');
            hide_ajax_loading();
        },
        error: function(e){
            access_failed(e.status);
            hide_ajax_loading();
        }
    });
}

function delete_units(id, p) {
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
                url : 'api/masterdata/units/id/'+id,
                cache : false,
                dataType: 'json',
                success: function(data){
                    get_list_units(p);
                    message_delete_success();
                },
                error: function(e){
                    get_list_units(p);
                    message_delete_success();
                }
            });
        }
    })

}
   