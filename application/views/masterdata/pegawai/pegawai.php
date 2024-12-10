<input type="hidden" name="page_now" id="page_now" />
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <!-- <div class="panel-heading clearfix">
                <h4 class="panel-title"><?= $list; ?></h4>
            </div> -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                        <?= form_button('tambah', '<i class="fa fa-plus"></i> Tambah Pegawai', 'id=bt_tambah_pegawai class="btn btn-success"') ?>
                        <?= form_button('reset', '<i class="fa fa-refresh"></i> Reload Data', 'id=bt_reset_pegawai class="btn"') ?></li>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" onkeyup="get_list_pegawai(1)" id="pencarian_pegawai" placeholder="Pencarian">
                    </div>
                </div>

                <br>

                <table class="table table-condensed table-striped table-hover" id="table_pegawai">
                    <thead>
                        <tr class="success">
                            <th width="5%" style="text-align: center;">No</th>
                            <th width="5%">NIP</th>
                            <th width="15%">Nama</th>
                            <th width="7%" style="text-align: center;">Kelamin</th>
                            <th width="10%" style="text-align: center;">Tanggal Lahir</th>
                            <th width="10%" style="text-align: center;">Telp</th>
                            <th width="25%">Alamat</th>
                            <th width="5%">Agama</th>
                            <th width="12%"></th>
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

<!-- Modal pegawai -->
<div class="modal fade" id="modal_pegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_pegawai"></h4>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=addform role=form class=form-horizontal'); ?>
                <input type="hidden" name="id" id="id_pegawai">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">NIP</label>

                            <div class="col-lg-9">
                                <input type="text" name="nip" id="nip" placeholder="NIP pegawai" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Nama pegawai</label>

                            <div class="col-lg-9">
                                <input type="text" name="nama" id="nama" placeholder="Nama Pegawai" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Kelamin</label>

                            <div class="col-lg-5">
                                <?= form_dropdown('kelamin', $kelamin, array(), 'class=form-control id=kelamin'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Tanggal Lahir</label>

                            <div class="col-lg-4">
                                <input type="text" name="tanggal_lahir" class="datepicker form-control" id="tanggal_lahir" placeholder="Tanggal Lahir" value="<?= date('d/m/Y') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-lg-3 control-label">Alamat</label>
                            <div class="col-lg-9">
                                <textarea id="alamat" name="alamat" placeholder="Alamat" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="agama" class="col-lg-3 control-label">Agama</label>
                            <div class="col-lg-4">
                                <?= form_dropdown('agama', $agama, array(), 'class=form-control id=agama'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telp" class="col-lg-3 control-label">No. Telp</label>
                            <div class="col-lg-8">
                                <input type="text" name="telp" class="form-control" id="telp" placeholder="No. Telp">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="agama" class="col-lg-3 control-label">Is Dokter</label>
                            <div class="col-lg-4">
                                <?= form_dropdown('dokter', $dokter, array(), 'class=form-control id=dokter'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                <button type="button" class="btn btn-success" onclick="simpan_pegawai()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<script>
    $(function() {
        get_list_pegawai(1);

        $('#bt_tambah_pegawai').click(function() {
            $('#modal_pegawai').modal('show');
            $('#modal_title_pegawai').html('Tambah Pegawai');
            reset_data_pegawai();
        });

        $('#bt_reset_pegawai').click(function() {
            reset_data_pegawai();
            get_list_pegawai(1);
        });

        $("#tanggal_lahir").datepicker({
            format: 'dd/mm/yyyy',
            endDate: "1d"
        }).on('changeDate', function() {
            $(this).datepicker('hide');
        });

        $('.form-control').keyup(function() {
            if ($(this).val() !== '') {
                my_validation_remove(this);
            }
        });

        $('.form-control').change(function() {
            if ($(this).val() !== '') {
                my_validation_remove(this);
            }
        });
    });


    function reset_data_pegawai() {
        $('#id_pegawai, .form-control, #pencarian_pegawai').val('');
        my_validation_remove('.form-control');
    }

    function get_pegawai(id) {
        show_ajax_loading();
        $.ajax({
            type: 'GET',
            url: '<?= base_url('api/masterdata/pegawai/id/'); ?>' + id,
            cache: false,
            dataType: 'JSON',
            success: function(data) {
                $('#pagination').html('&nbsp;<br>&nbsp;<br>');
                $('#summary').html(page_summary(1, 1, data.limit, data.page));

                var kelamin = '';
                if (data.data.kelamin == 'L') {
                    kelamin = 'LAKI-LAKI';
                } else if (data.data.kelamin == 'P') {
                    kelamin = 'PEREMPUAN';
                }

                $('#table_pegawai tbody').empty();

                var str = '<tr>' +
                    '<td align="center">1</td>' +
                    '<td>' + data.data.nip + '</td>' +
                    '<td>' + data.data.nama + '</td>' +
                    '<td align="center">' + kelamin + '</td>' +
                    '<td align="center">' + ((data.data.tanggal_lahir !== null) ? datefmysql(data.data.tanggal_lahir) : '') + '</td>' +
                    '<td align="center">' + data.data.telp + '</td>' +
                    '<td>' + data.data.alamat + '</td>' +
                    '<td align="center">' + data.data.agama + '</td>' +
                    '<td align="center" class="aksi">' +
                    '<button type="button" class="btn btn-default btn-xs" onclick="edit_pegawai(\'' + data.data.id + '\', ' + data.page + ')"><i class="fa fa-pencil-square-o"></i> Edit</button> ' +
                    '<button type="button" class="btn btn-default btn-xs" onclick="delete_pegawai(\'' + data.data.id + '\', ' + data.page + ')"><i class="fa fa-trash"></i> Hapus</button>' +
                    '</td>' +
                    '</tr>';
                $('#table_pegawai tbody').append(str);
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function get_list_pegawai(p) {
        show_ajax_loading();
        $.ajax({
            type: 'GET',
            url: '<?= base_url('api/masterdata/pegawai_list/page/'); ?>' + p,
            cache: false,
            data: 'pencarian=' + $('#pencarian_pegawai').val(),
            dataType: 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_pegawai(p - 1);
                    return false;
                };

                $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_pegawai tbody').empty();

                var str = '';
                var kelamin = '';

                $.each(data.data, function(i, v) {

                    if (v.kelamin == 'L') {
                        kelamin = 'LAKI-LAKI';
                    } else if (v.kelamin == 'P') {
                        kelamin = 'PEREMPUAN';
                    }

                    str = '<tr>' +
                        '<td align="center">' + ((i + 1) + ((data.page - 1) * data.limit)) + '</td>' +
                        '<td>' + v.nip + '</td>' +
                        '<td>' + v.nama + '</td>' +
                        '<td align="center">' + kelamin + '</td>' +
                        '<td align="center">' + ((v.tanggal_lahir !== null) ? datefmysql(v.tanggal_lahir) : '') + '</td>' +
                        '<td align="center">' + v.telp + '</td>' +
                        '<td>' + v.alamat + '</td>' +
                        '<td align="center">' + v.agama + '</td>' +
                        '<td align="center" class="aksi">' +
                        '<button type="button" class="btn btn-default btn-xs" onclick="edit_pegawai(\'' + v.id + '\', ' + data.page + ')"><i class="fa fa-pencil-square-o"></i> Edit</button> ' +
                        '<button type="button" class="btn btn-default btn-xs" onclick="delete_pegawai(\'' + v.id + '\', ' + data.page + ')"><i class="fa fa-trash"></i> Hapus</button>' +
                        '</td>' +
                        '</tr>';
                    $('#table_pegawai tbody').append(str);
                });
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading()
            }
        });
    }

    function paging(p) {
        get_list_pegawai(p);
    }

    function simpan_pegawai() {
        var stop = false;

        if ($('#nama').val() === '') {
            my_validation('#nama', 'Nama pegawai harus diisi!');
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

        if ($('#dokter').val() === '') {
            my_validation('#dokter', 'Jika dokter pilih Ya');
            stop = true;
        };

        if (stop) {
            return false;
        }

        var update = '';
        if ($('#id_pegawai').val() !== '') {
            update = 'id/' + $('#id_pegawai').val();
        }

        show_ajax_loading();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('api/masterdata/pegawai/'); ?>' + update,
            data: $('#addform').serialize(),
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#modal_pegawai').modal('hide');

                if ($('#id_pegawai').val() !== '') {
                    message_edit_success();
                    get_list_pegawai($('#page_now').val());
                } else {
                    message_add_success();
                    get_pegawai(data.id);
                }

                hide_ajax_loading();

            },
            error: function(e) {
                if ($('#id_pegawai').val() !== '') {
                    message_edit_failed();
                } else {
                    message_add_failed();
                }

                hide_ajax_loading();
            }
        });
    }

    function edit_pegawai(id, p) {
        show_ajax_loading();
        reset_data_pegawai();
        $('#page_now').val(p);
        $('#modal_title_pegawai').html('Edit Pegawai');
        $.ajax({
            type: 'GET',
            url: '<?= base_url('api/masterdata/pegawai/id/'); ?>' + id,
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#id_pegawai').val(data.data.id);
                $('#nip').val(data.data.nip);
                $('#nama').val(data.data.nama);
                $('#kelamin').val(data.data.kelamin);
                $('#tempat_lahir').val(data.data.tempat_lahir);
                $('#tanggal_lahir').val((data.data.tanggal_lahir !== null) ? datefmysql(data.data.tanggal_lahir) : '');
                $('#alamat').val(data.data.alamat);
                $('#agama').val(data.data.agama);
                $('#telp').val(data.data.telp);
                $('#dokter').val(data.data.is_dokter);

                $('#modal_pegawai').modal('show');
                hide_ajax_loading();
            },
            error: function(e) {
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function delete_pegawai(id, p) {
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
                    type: 'DELETE',
                    url: '<?= base_url('api/masterdata/pegawai/id/'); ?>' + id,
                    cache: false,
                    dataType: 'json',
                    success: function(data) {
                        get_list_pegawai(p);
                        message_delete_success();
                    },
                    error: function(e) {
                        get_list_pegawai(p);
                        message_delete_success();
                    }
                });
            }
        })
    }
</script>