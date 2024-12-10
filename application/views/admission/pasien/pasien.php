<script type="text/javascript">

    $(function(){
        get_list_pasien(1); 

        $('#bt_tambah').click(function(){
            $('#pasien_modal').modal('show');
            $('#modal_title').html('Tambah Pasien');
            reset_data();
        });
        
        $("#tanggal_lahir").datepicker({
            format: 'dd/mm/yyyy',
            endDate: "1d"
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });

        $('#bt_pencarian').click(function(){
            $('#search_modal').modal('show');
        });

        $('#formadd').submit(function(){
            return false;
        });

        $('#formsearch').submit(function(){
            search_data();
            return false;
        });

        $('#bt_reset').click(function(){
            reset_data();
            get_list_pasien(1);
        });

        $('.form-control').keyup(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }
        });

        $('.select2-input').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }
        });
        $('#tempat_lahir, #kelurahan_auto, #kelamin').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }            
        });

        $('#kelurahan_auto').select2({
            ajax: {
                url: "<?= base_url('api/masterdata_auto/kelurahan_auto') ?>",
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
                var markup = '<b>'+data.nama+'</b> <br/>'+data.kecamatan+', '+data.kabupaten+', '+data.provinsi;
                return markup;
            }, 
            formatSelection: function(data){
                return data.nama+', '+data.kecamatan+', '+data.kabupaten+', '+data.provinsi;
            }
        });

        $('#tempat_lahir').select2({
            // dropdownParent: $(this).parent(),
            ajax: {
                url: "<?=base_url('api/masterdata_auto/kabupaten_kota_auto')?>",
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

  
    function reset_data(){
       $('#id, .form-control, .select2-input, #pencarian').val('');
       $('#s2id_kelurahan_auto a .select2-chosen').html('Pilih Kelurahan');
       $('#no_rm').html('-');
       my_validation_remove('.form-control');
       my_validation_remove('.select2-input');
    }

    function search_data(){
        get_list_pasien(1);
        $('#search_modal').modal('hide');
    }

    function save_data(){
        var stop = false;
        if ($('#nama').val() === '') {
            my_validation('#nama', 'Nama harus diisi!');
            stop = true;   
       
        };

        if ($('#kelamin').val() === '') {
            my_validation('#kelamin', 'Jenis Kelamin harus diisi!');
            stop = true;   
        };

        if ($('#tanggal_lahir').val() === '') {
            my_validation('#tanggal_lahir', 'Tanggal Lahir harus diisi!');
            stop = true;   
        };

        if ($('#alamat').val() === '') {
            my_validation('#alamat', 'Alamat harus diisi!');
            stop = true;   
        };


        if (stop) {
            return false;
        };

        var update = '';
        if($('#id').val() !== ''){
            update = 'id/'+ $('#id').val();
        }
        show_ajax_loading();
        $.ajax({
            type : 'POST',
            url: '<?= base_url("api/admission/pasien") ?>/'+update,
            data: $('#formadd').serialize(),
            cache: false,
            dataType : 'json',
            success: function(data) {
                
                $('#pasien_modal').modal('hide')
                
                if($('#id').val() !== ''){
                    message_edit_success();
                    get_list_pasien($('#page_now').val());
                }else{
                    message_add_success();
                    get_pasien(data.id);
                }
                hide_ajax_loading();
            },
            error: function(e){
                hide_ajax_loading();
                if($('#id').val() !== ''){
                    message_edit_failed();
                }else{
                    message_add_failed();
                }
            }
        });

    }

    function get_pasien(id){
        $.ajax({
            type : 'GET',
            url: '<?= base_url("api/admission/pasien") ?>/id/'+id,
            cache: false,
            dataType : 'json',
            success: function(data) {                                
                $('#pagination').html('&nbsp;<br/>&nbsp;<br/>');
                $('.page_summary').html(page_summary(1, 1, data.limit, data.page));

                $('#table_data tbody').empty();
                var kelamin = '';
                if (data.data.kelamin == 'L') {
                    kelamin = 'Laki-laki';
                }else if(data.data.kelamin == 'P'){
                    kelamin = 'Perempuan';
                }     
                var str = '<tr class="odd">'+
                            '<td align="center">1</td>'+
                            '<td>'+data.data.nama+'</td>'+
                            '<td>'+kelamin+'</td>'+
                            '<td>'+((data.data.tanggal_lahir !== null)?datefmysql(data.data.tanggal_lahir):'')+'</td>'+
                            '<td>'+data.data.telp+'</td>'+
                            '<td>'+data.data.alamat+'</td>'+
                            '<td align="right" class="aksi">'+
                                '<button type="button" class="btn btn-default btn-xs" onclick="edit_pasien(\''+data.data.id+'\', '+data.page+')"><i class="fa fa-pencil"></i> Edit</button> '+
                            '</td>'+
                        '</tr>';
                    $('#table_data tbody').append(str);
                            
            },
            error: function(e){
                access_failed(e.status);
            }
        });
    }

    function get_list_pasien(p) {
        $('#page_now').val(p);
        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url: '<?= base_url("api/admission/pasien_list") ?>/page/'+p,
            data: $('#formsearch').serialize(),
            cache: false,
            dataType : 'json',
            success: function(data) {
                hide_ajax_loading();
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_pasien(p-1);
                    return false;
                };
                
                $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 1));
                $('.page_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_data tbody').empty();          
                var str = '';
                var kelamin = '';
                var wilayah = '';
                var style_meninggal = '';
                $.each(data.data,function(i, v){
                    var highlight = 'odd';
                    if ((i % 2) === 1) {
                        highlight = 'even';
                    };
                    if (v.kelamin == 'L') {
                        kelamin = 'Laki-laki';
                    }else if(v.kelamin == 'P'){
                        kelamin = 'Perempuan';
                    }

                    wilayah = '';
                    if (v.id_kelurahan !== null) {
                        wilayah = v.kelurahan+', '+v.kecamatan+', '+v.kabupaten;
                    };

                    style_meninggal = '';
                    if (v.status === 'Meninggal') {
                        style_meninggal = 'style="background-color:#ffa64d;color:black;"';
                    };
                    str = '<tr class="'+highlight+'" '+style_meninggal+' >'+
                            '<td align="center">'+v.id+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td>'+kelamin+'</td>'+
                            '<td>'+((v.tanggal_lahir !== null)?datefmysql(v.tanggal_lahir):'')+'</td>'+
                            '<td>'+v.telp+'</td>'+
                            '<td>'+v.alamat+'</td>'+
                            '<td>'+wilayah+'</td>'+
                            '<td align="right" class="aksi">'+
                                '<button title="Klik untuk mengedit" type="button" class="btn btn-default btn-xs" onclick="edit_pasien(\''+v.id+'\', '+data.page+')"><i class="fa fa-pencil"></i></button> '+
                            '</td>'+
                        '</tr>';
                    $('#table_data tbody').append(str);
                });                
            },
            error: function(e){
                hide_ajax_loading();
                access_failed(e.status);
            }
        });
    }

    function get_kabupaten_kota(id){
        $.ajax({
            type : 'GET',
            url: '<?=base_url("api/masterdata/kabupaten_kota")?>/id/'+id,
            cache: false,
            dataType : 'json',
            success: function(data) {
                $('#s2id_tempat_lahir a .select2-chosen').html(data.data.nama+', '+data.data.provinsi);
            },
            error: function(e){
                access_failed(e.status);
            }
        });
    }

    function edit_pasien(id, p){
        my_validation_remove('.form-control');
        $('#page_now').val(p);
        $('#modal_title').html('Edit Pasien');
        $.ajax({
            type : 'GET',
            url: '<?= base_url("api/admission/pasien") ?>/id/'+id,
            cache: false,
            dataType : 'json',
            success: function(data) {
                $('#id').val(data.data.id);
                $('#no_rm').html(data.data.id);
                $('#nama').val(data.data.nama);
                $('#kelamin').val(data.data.kelamin);
                $('#kelurahan_auto').val(data.data.id_kelurahan);
                $('#s2id_kelurahan_auto a .select2-chosen').html(data.data.kelurahan);
                $('#alamat').val(data.data.alamat);
                $('#tanggal_lahir').val((data.data.tanggal_lahir !== null)?datefmysql(data.data.tanggal_lahir):'');
                $('#tempat_lahir').val(data.data.tempat_lahir);

                $('#agama').val(data.data.agama);
                $('#gol_darah').val(data.data.gol_darah);
                $('#pendidikan').val(data.data.id_pendidikan);
                $('#pekerjaan').val(data.data.id_pekerjaan);
                $('#pernikahan').val(data.data.status_pernikahan);
                $('#telp').val(data.data.telp);
                $('#jenis_identitas').val(data.data.jenis_identitas);
                $('#no_identitas').val(data.data.no_identitas);
                $('#nama_ayah').val(data.data.nama_ayah);
                $('#nama_ibu').val(data.data.nama_ibu);

                $('#s2id_tempat_lahir a .select2-chosen').html('');
		        if (data.data.tempat_lahir !== null) {
		            get_kabupaten_kota(data.data.tempat_lahir);
		        }else{
		            $('#s2id_tempat_lahir a .select2-chosen').html('');
		        }

                $('#pasien_modal').modal('show');
                
            },
            error: function(e){
                access_failed(e.status);
            }
        });
    }

    function paging(p){
        get_list_pasien(p);
    }

    function eksport_data_pasien() {
        location.href='<?= base_url() ?>printing/eksport_data_pasien';
    }
</script>

<input type="hidden" name="page_now" id="page_now"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <!-- <div class="panel-heading clearfix">
                <h4 class="panel-title"><span class="fa fa-table"></span> <?=$list;?></h4>
            </div> -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="button_right" style="float: right; display: block;">
                            <?=form_button('cari', '<i class="fa fa-search"></i> Pencarian', 'id=bt_pencarian class="btn btn-default"')?>
                             <button type="button" id="bt_merge" class="btn btn-default" onclick="merge_pasien()"><span class="fa fa-link"></span> Merge Pasien</button>
                            <!-- <button onclick="export_data()" class="btn btn-default"><span class="fa fa-download"></span>&nbsp;Export Data Pasien</button> -->
                            <?=form_button('reset', '<i class="fa fa-refresh"></i> Reload Data', 'id=bt_reset class="btn"')?>
                        </div>
                    </div>
                </div>

                <br>

                <table class="table table-condensed table-striped table-hover" id="table_data">
				    <thead>
				        <tr class="success">
				            <th align="center" width="6%">No. RM</th>
				            <th width="20%" class="left">Nama</th>
				            <th width="7%" class="left">Kelamin</th>
				            <th width="10%" class="left">Tanggal Lahir</th>
				            <th width="10%" class="left">No. Telp</th>
				            <th width="20%" class="left">Alamat</th>
				            <th width="16%" class="left">Wilayah</th>
				            <th align="center" width="15%"></th>
				        </tr>
				            
				    </thead>

				    <tbody></tbody>
				</table>

                <div class="page_summary pull-left" id="summary"></div>

                <div id="pagination" class="pull-right"></div>
			</div>
		</div>
	</div>
</div>

<!-- Edit Pasien -->
<div id="pasien_modal" class="modal fade">
  <div class="modal-dialog" style="width: 80%; height: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="modal_title">Tambah Pasien</h4>
      </div>
      <div class="modal-body">
        <?= form_open('','id=formadd role=form class=form-horizontal') ?>
        <input name="id" type="hidden" id="id"/>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group tight">
                    <label for="no_rm" class="col-lg-3 control-label">No. RM</label>
                    <div class="col-lg-9">
                      <h4 id="no_rm">-</h4>
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">Nama Pasien*</label>
                    <div class="col-lg-9">
                        <input type="text" name="nama" class="form-control validate_input" id="nama" placeholder="Nama Pasien">
                    </div>
                </div>
                <div class="form-group tight">
                    <label for="jenis_kelamin" class="col-lg-3 control-label">Jenis Kelamin</label>
                    <div class="col-lg-9">
                      <?= form_dropdown('kelamin', $kelamin, array(), 'class=form-control id=kelamin') ?>
                    </div>
                </div>
                <div class="form-group tight">
                    <label for="tanggal_lahir" class="col-lg-3 control-label">Tanggal Lahir</label>
                    <div class="col-lg-3">
                      <input type="text" name="tanggal_lahir" class="form-control" id="tanggal_lahir" placeholder="Tanggal Lahir" style="width: 145px;">
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">Tempat Lahir</label>
                    <div class="col-lg-8">
                        <input type="text" name="tempat_lahir" class="select2-input validate_input" id="tempat_lahir" placeholder="Tempat Lahir" style="width: 300px;">
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">Kelurahan</label>
                    <div class="col-lg-9">
                      <input type="text" name="kelurahan" class="select2-input" id="kelurahan_auto">
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">Alamat</label>
                    <div class="col-lg-9">
                      <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group tight">
                    <label for="agama" class="col-lg-3 control-label">Agama</label>
                    <div class="col-lg-9">
                      <?= form_dropdown('agama', $agama, array(), 'class=form-control id=agama') ?>
                    </div>
                </div>
                <div class="form-group tight">
                    <label for="gol_darah" class="col-lg-3 control-label">Golongan Darah</label>
                    <div class="col-lg-9">
                      <?= form_dropdown('gol_darah', $gol_darah, array(), 'class=form-control id=gol_darah') ?>
                    </div>
                </div>
                <div class="form-group tight">
                    <label for="pendidikan" class="col-lg-3 control-label">Pendidikan</label>
                    <div class="col-lg-9">
                      <?= form_dropdown('pendidikan', $pendidikan, array(), 'class=form-control id=pendidikan') ?>
                    </div>
                </div>
                <div class="form-group tight">
                    <label for="pekerjaan" class="col-lg-3 control-label">Pekerjaan</label>
                    <div class="col-lg-9">
                      <?= form_dropdown('pekerjaan', $pekerjaan, array(), 'class=form-control id=pekerjaan') ?>
                    </div>
                </div>
                <div class="form-group tight">
                    <label for="pernikahan" class="col-lg-3 control-label">Status Pernikahan</label>
                    <div class="col-lg-9">
                      <?= form_dropdown('pernikahan', $pernikahan, array(), 'class=form-control id=pernikahan') ?>
                    </div>
                </div>
                <div class="form-group tight">
                    <label for="telp" class="col-lg-3 control-label">No. Telp</label>
                    <div class="col-lg-9">
                      <input type="text" name="telp" class="form-control" id="telp" placeholder="No. Telp">
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">Jenis Identitas</label>
                    <div class="col-lg-9">
                      <?= form_dropdown('jenis_identitas', $jenis_identitas, array(), 'class=form-control id=jenis_identitas style="width: 300px;" ') ?>
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">No. Identitas</label>
                    <div class="col-lg-9">
                        <input type="text" name="no_identitas" class="form-control" id="no_identitas" placeholder="No. KTP">
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">Nama Ayah</label>
                    <div class="col-lg-9">
                        <input type="text" name="nama_ayah" class="form-control" id="nama_ayah" placeholder="Nama Ayah">
                    </div>
                </div>
                <div class="form-group tight">
                    <label class="col-lg-3 control-label">Nama Ibu</label>
                    <div class="col-lg-9">
                        <input type="text" name="nama_ibu" class="form-control" id="nama_ibu" placeholder="Nama Ibu">
                    </div>
                </div>
            </div>
        </div>

        
        
        <?= form_close() ?>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
        <button type="button" class="btn btn-success" onclick="save_data()"><i class="fa fa-save"></i> Simpan</button>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End modal edit -->

<!-- Modal Search -->
<div id="search_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Pencarian Pasien</h4>
      </div>
      <?= form_open('','id=formsearch role=form class=form-horizontal') ?>
      <div class="modal-body">
        <div class="form-group">
            <label for="no_rm" class="col-lg-3 control-label">No. RM</label>
            <div class="col-lg-9">
              <input type="text" name="no_rm" class="form-control" id="no_rm_search" placeholder="No. RM" style="width:300px;">
            </div>
        </div>
        <div class="form-group">
            <label for="nama" class="col-lg-3 control-label">Nama</label>
            <div class="col-lg-9">
              <input type="text" name="nama" class="form-control" id="nama_search" placeholder="Nama Pasien" style="width:300px;">
            </div>
        </div>
        <div class="form-group">
            <label for="jenis_kelamin" class="col-lg-3 control-label">Jenis Kelamin</label>
            <div class="col-lg-9">
              <?= form_dropdown('kelamin', $kelamin, array(), 'class=form-control id=kelamin_search style="width:300px;"') ?>
            </div>
        </div>
        <div class="form-group">
            <label for="umur" class="col-lg-3 control-label">Umur</label>
            <div class="col-lg-9">
              <input type="text" name="umur" class="form-control" id="umur_search" placeholder="Umur" style="width:300px;">
            </div>
        </div>
        <div class="form-group">
            <label for="alamat" class="col-lg-3 control-label">Alamat</label>
            <div class="col-lg-9">
              <textarea name="alamat" class="form-control" id="alamat_search" placeholder="Alamat" style="width:300px;"></textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Keluar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
      </div>
      <?= form_close() ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Modal Search -->

<?php $this->load->view('admission/pasien/merge_pasien'); ?>