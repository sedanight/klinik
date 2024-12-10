<div id="merge_modal" class="modal fade">
  <div class="modal-dialog" style="width:80%;height:100%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Penggabungan Pasien</h4>
      </div>
      <?= form_open('','id=formmerge role=form class=form-horizontal') ?>
      <div class="modal-body" style="min-height:300px;">
        <p style="font-size:14px;">Form ini digunakan untuk menggabungkan pasien yang mempunyai nomor rekam medis lebih dari satu</p>
        <br/>
        <div class="row">
          <div class="col-lg-5">
            <h4>No. RM Utama</h4>
            <br/>
            <div class="form-group">
                <label class="col-lg-2 control-label">Pasien</label>
                <div class="col-lg-9">
                  <input type="text" name="pasien_utama" class="select2-input" id="pasien_utama">
                </div>
            </div>
          </div>
          <div class="col-lg-7">
            <h4>No. RM yang akan digabung</h4>
            <br/>
            <div class="form-group tight">
                <label class="col-lg-2 control-label">Pasien</label>
                <div class="col-lg-9">
                  <input type="text" class="select2-input" id="pasien_gabung">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label"></label>
                <div class="col-lg-9">
                  <button type="button" class="btn btn-success" onclick="pilih_pasien_merge()"><i class="fa fa-plus"></i> Pilih</button>
                  <button type="button" class="btn btn-default" onclick="reset_pasien_merge()"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </div>
            <table width="60%" class="table table-condensed table-striped table-hover" id="table_merge" cellpadding="0" cellspacing="0">
              <thead>
              <tr class="success">
                  <th width="20%">No. RM</th>
                  <th width="40%" class="left">Nama</th>
                  <th width="20%" class="left">Kelamin</th>
                  <th width="20%" class="left">Tanggal Lahir</th>
              </tr>
              </thead>
              <tbody>                                    
              </tbody>
            </table>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
        <button type="button" class="btn btn-success" onclick="merge_process()"><i class="fa fa-check"></i> Proses</button>
      </div>
      <?= form_close() ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  var data_merge = null;
  $(function () {
    $('#formmerge').submit(function() {
      return false;
    });

    $('#pasien_utama').select2({
            ajax: {
                url: "<?= base_url('api/admission_auto/pasien_auto') ?>",
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
                var markup = '<b>'+data.id+'</b>'+' '+data.nama+'<br/>'+data.alamat;
                return markup;
            }, 
            formatSelection: function(data){
                return '<b>'+data.id+'</b> '+data.nama;
            }
        });

        $('#pasien_gabung').select2({
            ajax: {
                url: "<?= base_url('api/admission_auto/pasien_auto') ?>",
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
                var markup = '<b>'+data.id+'</b>'+' '+data.nama+'<br/>'+data.alamat;
                return markup;
            }, 
            formatSelection: function(data){
              data_merge = data; 
              return '<b>'+data.id+'</b> '+data.nama;
            }
        });

  });

  function merge_pasien() {
    reset_pasien_merge();
    reset_pasien_utama();
    $('#table_merge tbody').empty();
    klik = null;
    $('#merge_modal').modal('show');
  }

  function reset_pasien_utama() {
    $('#pasien_utama').val('');
    $('#s2id_pasien_utama a .select2-chosen').html('');
  }

  function reset_pasien_merge() {
    $('#pasien_gabung').val('');
    $('#s2id_pasien_gabung a .select2-chosen').html('');
    my_validation_remove('#pasien_gabung');
    data_merge = null;
  }

  function pilih_pasien_merge() {
    if (data_merge !== null) {
      var kelamin = '';
      
      if (data_merge.kelamin == 'L') {
          kelamin = 'Laki-laki';
      }else if(data_merge.kelamin == 'P'){
          kelamin = 'Perempuan';
      }

      var str = '<tr class="number_merge">'+
              '<td align="center">'+data_merge.id+'<input type="hidden" name="pasien_merge[]" value="'+data_merge.id+'" /></td>'+
              '<td>'+data_merge.nama+'</td>'+
              '<td>'+kelamin+'</td>'+
              '<td>'+((data_merge.tanggal_lahir !== null)?datefmysql(data_merge.tanggal_lahir):'')+'</td>'+
          '</tr>';
      $('#table_merge tbody').append(str);
      reset_pasien_merge();
    }else{
       my_validation('#pasien_gabung', 'Pilih pasien dulu!');
    }
    
  }

  function merge_process() {
    if (klik !== null) {
      return false;
    }

    var stop = false;

    if ($('#pasien_utama').val()  === '') {
        my_validation('#pasien_utama', "Pilih pasien dulu!");
        stop = true;
    };

    if ($('.number_merge').length < 1) {
        my_validation('#pasien_gabung', "Pilih pasien dulu!");
        stop = true;
    };

    if (stop) {
        return false;
    };
    show_ajax_loading();
    klik = $.ajax({
            type : 'POST',
            url: '<?= base_url("api/admission/pasien_merge") ?>',
            data: $('#formmerge').serialize(),
            cache: false,
            dataType : 'json',
            success: function(data) {
                hide_ajax_loading();
                var tipe = 'success';
                if (!data.status) {
                  tipe = 'error';
                };

                message_custom(tipe, 'Penggabungan Pasien', data.message, '');
                get_list_pasien($('#page_now').val());
                $('#merge_modal').modal('hide');

            },
            error: function(e){
              hide_ajax_loading();
              message_custom('error', 'Penggabungan Pasien', 'Gagal melakukan penggabungan pasien, server error', '');
            }
        });
  }
</script>