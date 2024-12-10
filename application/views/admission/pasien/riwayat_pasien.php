<style type="text/css">
.ry_title h4, .ry_title h3 {
    display: inline-block;
}

</style>
<script type="text/javascript">
var dWidth = $(window).width();
var dHeight= $(window).height();
var x = screen.width/2 - dWidth/2;
var y = screen.height/2 - dHeight/2;

</script>

<div id="riwayat_modal" class="modal fade">
  <div class="modal-dialog" style="width:95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="judul_form_bed">Riwayat Medis Pasien | <span id="judul_riwayat"></span></h4>
      </div>
      <div class="modal-body">            
          <div class="row">
            <span id="top"></span>
            <div class="col-lg-10" role="main" id="riwayat_scroll" style="max-height: 550px;min-height:450px;overflow-y:auto;overflow-x: none;">
              <input type="hidden" id="id_pendaftaran_rm" />
              <ul id="riwayatTab" class="nav nav-tabs">
                <li class="link_tab" id="pasien_tab"><a href="#tab_pasien" data-toggle="tab"> Data Pasien</a></li>
                <li class="link_tab" id="riwayat_tab"><a href="#tab_riwayat" data-toggle="tab"> Riwayat</a></li>  
              </ul>
                                
              <div class="tab-content">
                <div class="tab-pane" id="tab_pasien">
                  <br/>
                  <div class="row">
                      <div class="col-lg-6">
                          <table class="table table-striped table-hover">
                            <tbody>
                              <tr>
                                  <td width="20%"><strong>Nama</strong></td>
                                  <td><span id="nama_rm_detail"></span></td>
                              </tr>          
                              <tr>
                                <td><strong>No. RM</strong></td>
                                <td><span id="no_rm_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Alamat</strong></td>
                                <td><span id="alamat_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Kelamin</strong></td>
                                <td><span id="kelamin_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Umur/Tgl. Lahir</strong></td>
                                <td><span id="umur_rm_detail"></span></td>
                              </tr>
                              <tr><td></td><td>&nbsp;</td></tr>
                              <tr>
                                <td><strong>Tempat Lahir</strong></td>
                                <td><span id="tempat_lahir_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Kelurahan</strong></td>
                                <td><span id="kelurahan_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Telp.</strong></td>
                                <td><span id="telp_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>No. Identitas</strong></td>
                                <td><span id="no_identitas_rm_detail"></span></td>
                              </tr>
                            </tbody>
                          </table>
                      </div>
                      <div class="col-lg-6">
                          <table class="table table-striped table-hover">
                            <tbody>
                              <tr>
                                  <td width="40%"><strong>Agama</strong></td>
                                  <td><span id="agama_rm_detail"></span></td>
                              </tr>          
                              <tr>
                                <td><strong>Golongan Darah</strong></td>
                                <td><span id="golongan_darah_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Pendidikan</strong></td>
                                <td><span id="pendidikan_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td><span id="pekerjaan_rm_detail"></span></td>
                              </tr>
                              <tr>
                                <td><strong>Status Pernikahan</strong></td>
                                <td><span id="status_pernikahan_rm_detail"></span></td>
                              </tr>

                              <tr><td></td><td>&nbsp;</td></tr>
                              <tr>
                                  <td width="40%"><strong>Nama Ayah</strong></td>
                                  <td><span id="nama_ayah_rm_detail"></span></td>
                              </tr>          
                              <tr>
                                <td><strong>Nama Ibu</strong></td>
                                <td><span id="nama_ibu_rm_detail"></span></td>
                              </tr>
                              <tr><td></td><td>&nbsp;</td></tr>
                              <tr>
                                  <td width="40%"><strong>Alergi</strong></td>
                                  <td><span id="alergi_rm_detail"></span></td>
                              </tr> 
                              
                            </tbody>
                          </table>

                      </div>
                  </div>

                </div>
                <div class="tab-pane" id="tab_riwayat" style="padding-top:15px;">
                  <div id="riwayat_area">
                    
                  </div>
                </div>
              </div>
              
            </div>
            <div class="col-lg-2" >
                <div  class="bs-docs-sidebar hidden-print"  role="complementary" style="">
                    <span class="title_nav_side">Tanggal Kunjungan</span>
                    <div id="kunjungan_scroll" style="max-height: 500px;overflow-y:auto;">
                        <ul class="nav bs-docs-sidenav" id="list_kunjungan">
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
            
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="close_riwayat_modal()"><i class="fa fa-check"></i> Ok</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  var numeroo = 1;
  $(function() {
   
    $('#riwayatTab a:last').click(function() {
      if ($('#id_pendaftaran_rm').val() !== '') {
        get_kunjungan($('#id_pendaftaran_rm').val());  
        $('#list_kunjungan li:first').addClass('active');
      };
      
    });
  });

  function close_riwayat_modal() {
    $('#riwayat_modal').modal('hide');
  }

  function riwayat_pasien(no_rm) {
    $('#riwayatTab a:first').tab('show');
    show_ajax_loading();
    $.ajax({
        url: '<?= base_url("api/rekam_medis/data_pasien") ?>/id/'+no_rm,
        cache: false,
        dataType : 'json',
        success: function(data) {
            hide_ajax_loading();
            
            show_data_pasien(data.pasien);
            show_riwayat_kunjungan(data.kunjungan);
            $('#riwayat_modal').modal('show');
        },
        error: function(e){
            hide_ajax_loading();
            message_custom('error', 'Error', 'Akses data gagal', '');
        }
    });

  }

  function detail_pasien() {
    var no_rm = $('#id_pasien').val();
    $('#riwayatTab a:first').tab('show');
    show_ajax_loading();
    $.ajax({
        url: '<?= base_url("api/rekam_medis/data_pasien") ?>/id/'+no_rm,
        cache: false,
        dataType : 'json',
        success: function(data) {
            hide_ajax_loading();
            
            show_data_pasien(data.pasien);
            show_riwayat_kunjungan(data.kunjungan);
            $('#riwayat_modal').modal('show');
        },
        error: function(e){
            hide_ajax_loading();
            message_custom('error', 'Error', 'Akses data gagal', '');
        }
    });

  }

  function show_data_pasien(pasien) {

    var kelamin = '';
        
    if (pasien.kelamin == 'L') {
        kelamin = 'Laki - Laki';
    }else{
        kelamin = 'Perempuan';
    }
    if (pasien.tanggal_lahir !== null) {
        umur = hitungUmur(pasien.tanggal_lahir)+' ('+datefmysql(pasien.tanggal_lahir)+')';
    }
    $('#judul_riwayat').html('<b>'+pasien.id+'</b> '+pasien.nama_depan+' '+pasien.nama_belakang);
    $('#nama_rm_detail').html(pasien.nama_depan+' '+pasien.nama_belakang);
    $('#no_rm_rm_detail').html(pasien.id);
    $('#alamat_rm_detail').html(pasien.alamat);
    $('#kelamin_rm_detail').html(kelamin);
    $('#umur_rm_detail').html(umur);

    $('#tempat_lahir_rm_detail').html(pasien.tempat_lahir);
    $('#kelurahan_rm_detail').html(pasien.kelurahan+', '+pasien.kecamatan+', '+pasien.kabupaten+', '+pasien.provinsi);
    $('#telp_rm_detail').html(pasien.telp);
    $('#no_identitas_rm_detail').html(pasien.no_identitas);
    $('#agama_rm_detail').html(pasien.agama);
    $('#golongan_darah_rm_detail').html(pasien.gol_darah);
    $('#pendidikan_rm_detail').html(pasien.pendidikan);
    $('#pekerjaan_rm_detail').html(pasien.pekerjaan);
    $('#status_pernikahan_rm_detail').html(pasien.status_pernikahan);
    $('#nama_ayah_rm_detail').html(pasien.nama_ayah);
    $('#nama_ibu_rm_detail').html(pasien.nama_ibu);
    $('#alergi_rm_detail').html(pasien.alergi);
  }


  function show_riwayat_kunjungan(data) {
    $('#list_kunjungan').empty();
    $.each(data, function (i, v) {
      if (i === 0) {
        $('#id_pendaftaran_rm').val(v.id);
      };
      $('#list_kunjungan').append('<li class="li_side" style="cursor: pointer; " onclick="get_kunjungan('+v.id+', this)"><a style="font-size:16px;">'+v.tanggal_kunjungan+'</a></li>');
    });
  }

  function get_kunjungan(id_pendaftaran, obj) {
    numeroo = 1;
    $('.li_side').removeClass('active');
    $(obj).addClass('active');
    $('#riwayatTab a:last').tab('show');
    $('#riwayat_area').empty();
    show_ajax_loading();
    $.ajax({
        url: '<?= base_url("api/rekam_medis/riwayat_kunjungan_pasien") ?>/id/'+id_pendaftaran,
        cache: false,
        dataType : 'json',
        success: function(data) {
            hide_ajax_loading();
            show_kunjungan(data);
            
        },
        error: function(e){
            hide_ajax_loading();
            message_custom('error', 'Error', 'Akses data gagal', '');
        }
    });
  }

  function show_kunjungan(data) {
      var str = '';
      str += '<div class="row">'+
              '<div class="col-lg-12 ry_title">'+
                '<h3 class="title_section">'+data.jenis+'</h3><h4 class="pull-right"><b>Tanggal '+data.tanggal_kunjungan+'</b></h4>'+
              '</div>'+
            '</div><br/>';

      str += '<div class="row">'+
              '<div class="col-lg-6">'+
                '<table class="table table-striped table-hover">'+
                  '<tbody>'+
                    '<tr>'+
                        '<td width="30%"><strong>No. Register</strong></td>'+
                        '<td><span>'+data.no_register+'</span></td>'+
                    '</tr>'+          
                    '<tr>'+
                      '<td><strong>Waktu Daftar</strong></td>'+
                      '<td><span>'+datetimefmysql(data.waktu_daftar)+'</span></td>'+
                    '</tr>'+
                    '<tr>'+
                      '<td><strong>Waktu Keluar</strong></td>'+
                      '<td><span>'+datetimefmysql(data.waktu_keluar)+'</span></td>'+
                    '</tr>'+
                    '<tr>'+
                      '<td><strong>Status</strong></td>'+
                      '<td><span>'+data.status+'</span></td>'+
                    '</tr>'+
                  '</tbody>'+
                '</table>'+
              '</div>'+
              '<div class="col-lg-6">'+
                '<table class="table table-striped table-hover">'+
                  '<tbody>'+
                    '<tr>'+
                      '<td width="30%"><strong>Nama Pjwb</strong></td>'+
                      '<td><span>'+data.nama_pjwb+'</span></td>'+
                    '</tr>'+
                    '<tr>'+
                      '<td width="30%"><strong>Telp. Pjwb</strong></td>'+
                      '<td><span>'+data.telp_pjwb+'</span></td>'+
                    '</tr>'+
                    '<tr>'+
                      '<td><strong>Alamat Pjwb</strong></td>'+
                      '<td><span>'+data.alamat_pjwb+'</span></td>'+
                    '</tr>'+
                    '<tr>'+
                      '<td><strong>Petugas Pendaftaran</strong></td>'+
                      '<td><span>'+data.petugas_pendaftaran+'</span></td>'+
                    '</tr>'+
                  '</tbody>'+
                '</table>'+
              '</div>'+
            '</div><br/>';


      $('#riwayat_area').append(str);

      str = '';
      $.each(data.layanan, function(i, v) {
        $('#riwayat_area').append(show_layanan_kunjungan(v));
      });

      $('#riwayat_area').append('<br/><br/><br/>');      
  }

  function show_layanan_kunjungan(v) {
    var str = '';
    numeroo++;
    str = '<div class="panel panel-info">'+
            '<div class="panel-heading">'+
              '<h3 class="panel-title">'+v.jenis+'</h3>'+
            '</div>'+
            '<div class="panel-body">'+
              '<div class="row">'+
                '<div class="col-lg-6">'+
                  '<table class="table table-striped table-hover">'+
                    '<tbody>'+
                      '<tr>'+
                          '<td width="20%">Waktu Masuk</td>'+
                          '<td><span>'+datetimefmysql(v.waktu)+'</span></td>'+
                      '</tr>'+          
                      '<tr>'+
                        '<td>Ruang</td>'+
                        '<td><span>'+v.ruang+'</span></td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Dokter DPJP</td>'+
                        '<td><span>'+v.dokter+'</span></td>'+
                      '</tr>'+
                    '</tbody>'+
                  '</table>'+
                '</div>'+
                '<div class="col-lg-6">'+
                  '<table class="table table-striped table-hover">'+
                    '<tbody>'+
                      '<tr>'+
                        '<td>Cara Bayar</td>'+
                        '<td><span>'+v.cara_bayar+'</span></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td width="20%">Waktu Keluar</td>'+
                          '<td><span>'+((v.keluar !== null)?datetimefmysql(v.keluar):'')+'</span></td>'+
                      '</tr>'+          
                      '<tr>'+
                        '<td>Tindak Lanjut</td>'+
                        '<td><span>'+v.tindak_lanjut+'</span></td>'+
                      '</tr>'+
                    '</tbody>'+
                  '</table></div></div>';

    str += '<div class="row">'+
                '<div class="col-lg-12"><div class="title"><h5 class="text-error">Pemeriksaan Umum</h5>'+show_rm_visitasi(v.visitasi)+'</div></div><br/>'+
              '</div>';

    str += '<div class="row">'+
                '<div class="col-lg-12"><div class="title"><h5 class="text-error">Diagnosa</h5>'+show_rm_diagnosa(v.diagnosis)+'</div></div><br/>'+
              '</div>';


    str += '<div class="row"><div class="col-lg-12">';
    str += show_rm_tindakan(numeroo, v.tindakan);
    
    if (v.laboratorium.length > 0) {
      str += show_rm_laboratorium(numeroo, v.laboratorium);  
    };

    if (v.radiologi.length > 0) {
      str += show_rm_radiologi(numeroo, v.radiologi);
    }
    
    if (v.fisioterapi.length > 0) {
      str += show_rm_fisioterapi(numeroo, v.fisioterapi);
    }

    if (v.obat.length > 0) {
      str += show_rm_obat(numeroo, v.obat);
    }

    if (v.operasi.length > 0) {
      str += show_rm_operasi(numeroo, v.operasi);
    }

    str += '</div></div>';
    str += '</div>'+
          '</div><br/>';

    return str;
  }

  function show_rm_visitasi(data){
        var str = '';
        
        str = '<table width="100%" class="table table-bordered table-stripped table-hover" cellpadding="0" cellspacing="0">'+
                '<thead><tr>'+
                    '<th width="5%">No.</th>'+
                    '<th width="15%">Waktu</th>'+
                    '<th width="12%">Tensi</th>'+
                    '<th width="7%">Nadi</th>'+
                    '<th width="7%">Suhu</th>'+
                    '<th width="7%">Nafas</th>'+
                    '<th class="left">Keluhan Utama</th>'+
                '</tr><thead><tbody>';
        
        $.each(data, function(i, v){
            str += '<tr>'+
                '<td align="center">'+ (++i) +'</td>'+
                '<td>'+((v.waktu !== null)?datetimefmysql(v.waktu):'')+'</td>'+
                '<td align="center">'+v.tensi+' mm/Hg</td>'+
                '<td align="center">'+v.nadi+' Bpm</td>'+
                '<td align="center">'+v.suhu+' &deg; C</td>'+
                '<td align="center">'+v.nafas+' Bpm</td>'+
                '<td>'+v.anamnesis+'</td>'+
                '</tr>';
        });

        if (data.length === 0) {
          str += '<tr>'+
                '<td align="center">&nbsp;</td>'+
                '<td></td>'+
                '<td align="center"></td>'+
                '<td align="center"></td>'+
                '<td align="center"></td>'+
                '<td align="center"></td>'+
                '<td></td>'+
                '</tr>';

        };
        
        str += '</tbody></table>';
        

        return str;        
    }


  function show_rm_diagnosa(data){
        var str = '';
        
        str = '<table width="100%" class="table table-bordered table-stripped table-hover" cellpadding="0" cellspacing="0">'+
                '<thead><tr>'+
                    '<th width="5%">No.</th>'+
                    '<th width="20%" class="left">Waktu</th>'+
                    '<th width="40%" class="left">Item</th>'+
                    '<th width="35%" class="left">Keterangan</th>'+
                '</tr><thead><tbody>';
        
        $.each(data, function(i, v){
            str += '<tr>'+
                '<td align="center">'+ (++i) +'</td>'+
                '<td>'+((v.waktu !== null)?datetimefmysql(v.waktu):'')+'</td>'+
                '<td>'+v.item+'</td>'+
                '<td>'+v.keterangan+'</td>'+
                '</tr>';
        });

        if (data.length === 0) {
          str += '<tr>'+
                '<td class="number_dg" align="center">&nbsp;</td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '</tr>';

        };
        
        str += '</tbody></table>';
        

        return str;        
    }


  function draw_top_collapse(title, num) {
    var str = '<div class="panel-group" role="tablist" aria-multiselectable="true">'+
                '<div class="panel panel-default">'+
                  '<div class="panel-heading" role="tab" id="heading'+num+'">'+
                    '<h4 class="panel-title">'+
                      '<a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'+num+'" aria-expanded="false" aria-controls="collapse'+num+'">'+
                        title+
                      '</a>'+
                    '</h4>'+
                  '</div>'+
                  '<div id="collapse'+num+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+num+'">'+
                    '<div class="panel-body">';

    return str;
  }

  function draw_bottom_collapse() {
    var str = '</div></div></div></div>';
    return str; 
  }

  function show_rm_tindakan(num, data) {
    var str = draw_top_collapse('Tindakan', 'Td'+num);
    str += '<table width="100%" class="table table-bordered table-stripped table-hover" cellpadding="0" cellspacing="0">'+
                '<thead><tr>'+
                    '<th width="5%">No.</th>'+
                    '<th width="15%" class="left">Waktu</th>'+
                    '<th width="45%" class="left">Item</th>'+
                    '<th width="25%" class="left">Operator</th>'+
                    '<th width="10%">Frekuensi</th>'+
                    
                '</tr><thead><tbody>';
        
        $.each(data, function(i, v){
            str += '<tr>'+
                '<td align="center">'+ (++i) +'</td>'+
                '<td>'+((v.waktu !== null)?datetimefmysql(v.waktu):'')+'</td>'+
                '<td>'+v.item+'</td>'+
                '<td>'+v.operator+'</td>'+
                '<td align="center">'+v.frekuensi+'</td>'+
                '</tr>';
        });

        if (data.length === 0) {
          str += '<tr>'+
                '<td align="center">&nbsp;</td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '</tr>';

        };
        
        str += '</tbody></table>';
         
    str += draw_bottom_collapse();

    return str;
  }

  function show_rm_operasi(num, data) {
    var str = draw_top_collapse('Operasi', 'Oper'+num);
    str += '<table width="100%" class="table table-bordered table-stripped table-hover" cellpadding="0" cellspacing="0">'+
                '<thead><tr>'+
                    '<th width="5%">No.</th>'+
                    '<th width="15%" class="left">Waktu</th>'+
                    '<th width="30%" class="left">Item</th>'+
                    '<th width="20%" class="left">Operator</th>'+
                    '<th width="20%" class="left">Anestesi</th>'+
                    '<th width="10%">Frekuensi</th>'+
                    
                '</tr><thead><tbody>';
        
        $.each(data, function(i, v){
            str += '<tr>'+
                '<td align="center">'+ (++i) +'</td>'+
                '<td>'+((v.waktu !== null)?datetimefmysql(v.waktu):'')+'</td>'+
                '<td>'+v.item+'</td>'+
                '<td>'+v.operator+'</td>'+
                '<td>'+v.operator_anestesi+'</td>'+
                '<td align="center">'+v.frekuensi+'</td>'+
                '</tr>';
        });

        if (data.length === 0) {
          str += '<tr>'+
                '<td align="center">&nbsp;</td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '</tr>';

        };
        
        str += '</tbody></table>';
         
    str += draw_bottom_collapse();

    return str;
  }

  function fill_content_penunjang(data, jenis) {
    var onclick = '';
    
    var str = '<table width="100%" class="table table-bordered table-stripped table-hover" cellpadding="0" cellspacing="0">'+
            '<thead><tr>'+
                '<th width="5%">No.</th>'+
                '<th width="10%" class="left">No. Periksa</th>'+
                '<th width="12%" class="left">Waktu Konfirm</th>'+
                '<th width="12%" class="left">Waktu Hasil</th>'+
                '<th width="20%" class="left">Dokter Pjwb</th>'+
                '<th width="35%" class="left">Item Pemeriksaan</th>'+
                '<th width="6%">Detail</th>'+
            '</tr><thead><tbody>';
    
    $.each(data, function(i, v){
        if (jenis === 'laboratorium') {
          onclick = 'onclick="show_rm_hasil_laboratorium('+v.id+')"';
        }else if (jenis === 'radiologi') {
          onclick = 'onclick="show_rm_hasil_radiologi('+v.id+')"';
        }else if (jenis === 'fisioterapi') {
          onclick = 'onclick="show_rm_hasil_fisioterapi('+v.id+')"';
        }else{
          onclick = '';
        }

        str += '<tr>'+
            '<td align="center">'+ (++i) +'</td>'+
            '<td>'+v.kode+'</td>'+
            '<td>'+((v.waktu_konfirm !== null)?datetimefmysql(v.waktu_konfirm):'')+'</td>'+
            '<td>'+((v.waktu_hasil !== null)?datetimefmysql(v.waktu_hasil):'')+'</td>'+
            '<td>'+v.dokter_pjwb+'</td>'+
            '<td>'+v.detail+'</td>'+
            '<td align="center">'+
              '<button title="Klik untuk melihat detail dan hasil pemeriksaan" '+onclick+' class="btn btn-default btn-xs"><i class="fa fa-eye"></i></button>'+
            '</td>'+
            '</tr>';
    });

    if (data.length === 0) {
      str += '<tr>'+
            '<td align="center">&nbsp;</td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '</tr>';

    };
    
    str += '</tbody></table>';

    return str;
  }

  function show_rm_laboratorium(num, data) {
    var str = draw_top_collapse('Laboratorium', 'Lab'+num);
    str += fill_content_penunjang(data, 'laboratorium');
    str += draw_bottom_collapse();

    return str;
  }

  function show_rm_radiologi(num, data) {
    var str = draw_top_collapse('Radiologi', 'Rad'+num);
    str += fill_content_penunjang(data, 'radiologi');
    str += draw_bottom_collapse();

    return str;
  }

  function show_rm_fisioterapi(num, data) {
    var str = draw_top_collapse('Rehab. Medik', 'Fis'+num);
    str += fill_content_penunjang(data, 'fisioterapi');
    str += draw_bottom_collapse();

    return str;
  }

  function fill_content_obat(data) {
    var onclick = '';
   

    var str = '<table width="100%" class="table table-bordered table-stripped table-hover" cellpadding="0" cellspacing="0">'+
            '<thead><tr>'+
                '<th width="5%">No.</th>'+
                '<th width="10%" class="left">No. Resep</th>'+
                '<th width="20%" class="left">Waktu Order</th>'+
                '<th width="55%" class="left">Jenis</th>'+
                '<th width="10%">Detail</th>'+
            '</tr><thead><tbody>';
    var detail = '';
    $.each(data, function(i, v){
        onclick = 'onclick="show_rm_detail_obat('+v.id+')"';
        str += '<tr>'+
            '<td align="center">'+ (++i) +'</td>'+
            '<td>'+v.id_resep+'</td>'+
            '<td>'+((v.waktu !== null)?datetimefmysql(v.waktu):'')+'</td>'+
            '<td>'+v.jenis+'</td>'+
            '<td align="center">'+
              '<button title="Klik untuk melihat detail obat" '+onclick+' class="btn btn-default btn-xs"><i class="fa fa-eye"></i></button>'+
            '</td>'+
            '</tr>';
    });

    if (data.length === 0) {
      str += '<tr>'+
            '<td align="center">&nbsp;</td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '</tr>';

    };
    
    str += '</tbody></table>';

    return str;
  }

  function show_rm_detail_obat(id) {
    show_ajax_loading();
    $.ajax({
        url: '<?= base_url("api/rekam_medis/detail_obat") ?>/id/'+id,
        cache: false,
        dataType : 'json',
        success: function(data) {
            hide_ajax_loading();
            $('#table_obat_rm tbody').empty();
            var str = '';
            $.each(data, function(i, v){
              
              str += '<tr>'+
                  '<td align="center">'+ (++i) +'</td>'+
                  '<td>'+v.item+'</td>'+
                  '<td align="center">'+v.qty+'</td>'+
                  '</tr>';
            });
            $('#table_obat_rm tbody').html(str);
            $('#riwayat_obat_modal').modal('show');
        },
        error: function(e){
            hide_ajax_loading();
            message_custom('error', 'Error', 'Akses data gagal', '');
        }
    });
  }


  function show_rm_obat(num, data) {
    var str = draw_top_collapse('Obat', 'Ob'+num);
    str += fill_content_obat(data, 'obat');
    str += draw_bottom_collapse();

    return str;
  }

  function show_rm_hasil_laboratorium(id) {
    $('#judul_riwayat_penunjang').html('Hasil Pemeriksaan Laboratorium');
    show_ajax_loading();
    $.ajax({
        url: '<?= base_url("api/rekam_medis/hasil_laboratorium") ?>/id/'+id,
        cache: false,
        dataType : 'json',
        success: function(data) {
            hide_ajax_loading();
            $('#area_riwayat_hasil_penunjang').empty();
            var str = '';
            $.each(data, function(i, v){               
              str += '<div class="row">'+
                      '<div class="col-md-12">'+
                        '<div class="widget">'+
                          '<div class="widget-header">'+
                            '<div class="title">'+
                              '<h5>'+
                                '<span class="fa fa-angle-right"></span> <b>'+v.layanan+'</b>'+
                              '</h5>'+
                            '</div>'+
                          '</div>'+
                          '<div class="widget-body">'+
                          '<table class="table" width="60%"><thead><tr><th width="30%" class="left">Jenis Pemeriksaan</th><th width="20%" class="left">Hasil</th><th width="25%">Nilai Normal</th><th width="30%">Catatan</th></tr></thead><tbody>';
            
            
            
              $.each(v.item, function(j, x){
                  str += '<tr>'+
                          '<td>'+x.item_laboratorium+'</td>'+
                          '<td>'+x.hasil+' '+x.satuan+'</td>'+
                          '<td align="center"><h5>'+x.nilai_normal+'</h5></td>'+
                          '<td>'+ ((x.catatan !== null)?x.catatan:"")+'</td>'+
                      '</tr>';
                 
              });
                              
              str += '</tbody></table></div></div></div></div>';

            });  
           
            $('#area_riwayat_hasil_penunjang').html(str);
            $('#riwayat_penunjang_modal').modal('show');
        },
        error: function(e){
            hide_ajax_loading();
            message_custom('error', 'Error', 'Akses data gagal', '');
        }
    });
  }

  function show_rm_hasil_radiologi(id) {
    window.open('<?= base_url() ?>printing/hasil_radiologi/'+id,'Cetak Hasil Radiologi','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
  }

  function show_rm_hasil_fisioterapi(id) {
    window.open('<?= base_url() ?>printing/hasil_fisioterapi/'+id,'Cetak Hasil Rehabilitasi Medik','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
  }
</script>


<div id="riwayat_obat_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Detail Obat</h4>
      </div>
      <div class="modal-body">            
        <table width="100%" id="table_obat_rm" class="table table-bordered table-stripped table-hover" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="5%">No.</th>
              <th width="85%">Obat</th>
              <th width="10%">Qty</th>
            </tr>
          <thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="riwayat_penunjang_modal" class="modal fade">
  <div class="modal-dialog" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="judul_riwayat_penunjang"></h4>
      </div>
      <div class="modal-body" id="area_riwayat_hasil_penunjang">            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->