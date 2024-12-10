<input type="hidden" name="page_now" id="page_now"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <!-- <div class="panel-heading clearfix">
                <h4 class="panel-title"><?= $list; ?></h4>
            </div> -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                        <?= form_button('tambah', '<i class="fa fa-plus"></i> Tambah Unit' ,'id=bt_tambah_modal_units class="btn btn-success"')?>
                        <?= form_button('reset', '<i class="fa fa-refresh"></i> Reload Data' ,'id=bt_reset_units class="btn"')?></li>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" onkeyup="get_list_units(1)" id="pencarian_units" placeholder="Pencarian">
                    </div>
                </div>

                <br>

                <table class="table table-condensed table-striped table-hover" id="table_units">
                    <thead>
                        <tr class="success">
                            <th style="text-align: center" width="5%">No.</th>
                            <th width="80%" class="left">Nama</th>
                            <th align="center" width="15%"></th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>

                <div class="page_summary pull-left" id="summary"></div>
                       
                <div id="pagination" class="pull-right"></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal units -->
<div class="modal fade" id="modal_units" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_units"></h4>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=addform role=form class=form-horizontal'); ?>
                    <input type="hidden" name="id" id="id_units">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Unit</label>

                        <div class="col-lg-8">
                            <input type="text" name="nama" id="nama" placeholder="Nama Unit" class="form-control">
                        </div>
                    </div>
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_units()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<script>
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
            url : '<?= base_url('api/masterdata/units/id/'); ?>'+id,
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
            url: '<?= base_url('api/masterdata/units_list/page/'); ?>'+p,
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
            url : '<?= base_url('api/masterdata/units/'); ?>'+update,
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
            url: '<?= base_url('api/masterdata/units/id/'); ?>'+id,
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
                    url : '<?= base_url('api/masterdata/units/id/'); ?>'+id,
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
       
</script>