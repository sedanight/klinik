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
                        <div class="button_left" style="float: left; display: block;">
                            <?=form_button('tambah', '<i class="fa fa-plus"></i> Entri Pendaftaran', 'id=bt_tambah class="btn btn-success"')?>
                            <?=form_button('cari', '<i class="fa fa-search"></i> Pencarian', 'id=bt_pencarian class="btn btn-default"')?>
                            <?=form_button('reset', '<i class="fa fa-refresh"></i> Reload Data', 'id=bt_reset_pendaftaran class="btn btn-default"')?></li>
                        </div>
                        <div class="button_right" style="float: right; display: block;">
                            <button onclick="export_data()" class="btn btn-info"><span class="fa fa-download"></span>&nbsp;Export Data</button>
                        </div>
                    </div>
                </div>

                <br>

                <table class="table table-condensed table-striped table-hover" id="table_data">
                    <thead>
                        <tr class="success">
                            <th width="3%" style="text-align: center;">No.</th>
                            <th width="7%" class="left">No. Register</th>
                            <th width="9%" class="left">Waktu Daftar</th>
                            <th width="5%" class="left">No. RM</th>
                            <th width="20%" class="left">Nama Pasien</th>
                            <th width="10%" class="left">Waktu Periksa</th>
                            <th width="5%" class="left">Pasien</th>
                            <th width="7%" class="left">Status</th>
                            <th width="5%" class="left">Petugas</th>
                            <th align="center" width="12%"></th>
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

<!-- Modal Pendaftaran -->
<div class="modal fade" id="modal_pendaftaran">
    <div class="modal-dialog" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title"></h4>
            </div>
            <div class="modal-body">
                <?=form_open('', 'id=formadd role=form class=form-horizontal');?>
                    <input type="hidden" name="jenis" id="jenis_pendaftaran" value="" />
                    <input type="hidden" name="no_antri" id="antrian" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget-body">
                                <div id="wizard">
                                    <div class="row">
                                        <!-- Data Pasien -->
                                        <div class="col-lg-6">
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Tanggal</label>
                                                <div class="col-lg-7">
                                                    <h5 id="tanggal"><?=date('d/m/Y')?></h5>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">No. RM</label>
                                                <div class="col-lg-4">
                                                    <input type="hidden" name="id_pasien" id="id_pasien">
                                                    <input type="text" name="no_rm" class="select2-input validate_input" id="no_rm" placeholder="No. RM" style="width: 300px;">
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Nama Pasien</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="nama" class="form-control validate_input" id="nama" placeholder="Nama Pasien" style="width: 300px;"/>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Status Pasien</label>
                                                <div class="col-lg-5">
                                                    <?=form_dropdown('status_pasien', $status_pasien, array(), 'class="form-control" id=status_pasien')?>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label"></label>
                                                <div class="col-lg-5">
                                                    <span><small><i>*) Status pasien harap diisi jika pasien baru</i></small></span>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Jenis Kelamin</label>
                                                <div class="col-lg-5">
                                                    <?=form_dropdown('kelamin', $kelamin, array(), 'class="form-control validate_input" id=kelamin')?>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label for="tempat_lahir" class="col-lg-3 control-label">Tempat Lahir</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="tempat_lahir" class="select2-input validate_input" id="tempat_lahir" placeholder="Tempat Lahir" style="width: 300px;">
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Tanggal Lahir</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="tanggal_lahir" class="form-control validate_input" id="tanggal_lahir" placeholder="Tanggal Lahir">
                                                </div>
                                                <div class="col-lg-1">
                                                     <center style="padding-top:0px;"><h5>atau</h5></center>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" name="umur" class="form-control mousetrap" id="umur" placeholder="Umur" />
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Umur</label>
                                                <div class="col-lg-6">
                                                    <h5 id="umur_label"></h5>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Alamat</label>
                                                <div class="col-lg-9">
                                                    <textarea  name="alamat" class="form-control validate_input" id="alamat" placeholder="Alamat" style="width: 300px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label for="kelurahan_auto" class="col-lg-3 control-label">Kelurahan</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="kelurahan" class="select2-input validate_input" id="kelurahan_auto" placeholder="Kelurahan" style="width: 300px;">
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">Telp.</label>
                                                <div class="col-lg-7">
                                                    <input type="text" name="telp" class="form-control validate_input" id="telp" placeholder="No. Telp" style="width: 300px;" />
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-3 control-label">NIK</label>
                                                <div class="col-lg-7">
                                                    <input type="text" name="no_identitas" class="form-control validate_input" id="no_identitas" placeholder="NIK" style="width: 300px;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label">Agama</label>
                                                <div class="col-lg-8">
                                                  <?=form_dropdown('agama', $agama, array(), 'class="form-control validate_input" id=agama')?>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label">Gol. Darah</label>
                                                <div class="col-lg-8">
                                                  <?=form_dropdown('gol_darah', $gol_darah, array(), 'class="form-control validate_input" id=gol_darah')?>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label">Pendidikan Tertingi</label>
                                                <div class="col-lg-8">
                                                    <?=form_dropdown('pendidikan', $pendidikan, array(), 'class="form-control validate_input" id=pendidikan')?>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label">Pekerjaan</label>
                                                <div class="col-lg-8">
                                                  <?=form_dropdown('pekerjaan', $pekerjaan, array(), 'class="form-control validate_input" id=pekerjaan')?>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label">Status Kawin</label>
                                                <div class="col-lg-8">
                                                  <?=form_dropdown('pernikahan', $pernikahan, array(), 'class="form-control validate_input" id=pernikahan')?>
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label">Nama Ayah</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="nama_ayah" class="form-control validate_input" id="nama_ayah" placeholder="Nama Ayah">
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label">Nama Ibu</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="nama_ibu" class="form-control validate_input" id="nama_ibu" placeholder="Nama Ibu">
                                                </div>
                                            </div>
                                            <div class="form-group tight">
                                                <label class="col-lg-4 control-label"><h2>Antrian Ke -</h2></label>
                                                <div class="col-lg-6">
                                                    <h2 id="no_antri" style="padding-top: 9px; font-weight: bold"></h2>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Data Pasien -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?=form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="reset_data()"><i class="fa fa-refresh"></i> Reset</button>
                <button type="button" class="btn btn-success" onclick="konfirmasi_simpan()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Search Modal -->
<div id="search_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Parameter Pencarian</h4>
      </div>
      <div class="modal-body">
        <?=form_open('', 'id=formsearch role=form class=form-horizontal')?>
            <div class="form-group">
                <label class="col-lg-3 control-label">Tanggal</label>
                <div class="col-lg-3">
                  <input type="text" name="awal" value="<?=date('d/m/Y')?>" class="form-control" id="awal" placeholder="Awal">
                </div>
                <div class="col-lg-1">
                    <center><h5 style="padding-top:9px;">s.d</h5></center>
                </div>
                <div class="col-lg-3">
                  <input type="text" name="akhir" value="<?=date('d/m/Y')?>" class="form-control" id="akhir" placeholder="Akhir">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">No. Register</label>
                <div class="col-lg-8">
                  <input type="text" name="no_register" class="form-control" id="no_register_search" placeholder="No. Register">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">No. RM</label>
                <div class="col-lg-8">
                  <input type="text" name="no_rm" class="form-control" id="no_rm_search" placeholder="No. RM">
                </div>
            </div>
            <div class="form-group">
                <label for="nama" class="col-lg-3 control-label">Nama</label>
                <div class="col-lg-8">
                  <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Pasien">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Status</label>
                <div class="col-lg-8">
                  <?= form_dropdown('status', $status_pemeriksaan, '', 'id="status" class="form-control"') ?>
                </div>
            </div>

        <?=form_close()?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Keluar</button>
        <button type="button" class="btn btn-success" onclick="search_data()"><i class="fa fa-search"></i> Cari</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Search Modal -->

<!-- Pemeriksaan Modal -->
<div id="pemeriksaan_modal" class="modal fade">
  <div class="modal-dialog" style="width: 90%; height: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Form Pemeriksaan Pasien</h4>
      </div>
      <div class="modal-body">
          <?= form_open('','id=formaddpemeriksaan role=form class=form-horizontal') ?>
            <input type="hidden" name="id_layanan" id="id_layanan" />
            <input type="hidden" name="id_pendaftaran" id="id_pendaftaran" />
            <!-- <input type="hidden" name="id_pasien" id="id_pasien"  /> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <div id="wizard2">
                            <ol>
                                <li>Detail Data Pasien</li>
                                <li>Pemeriksaan</li>
                            </ol>
                            <div class="row">
                                <!-- Data Pasien -->
                                <div class="col-lg-6">
                                    <table class="table table-condensed table-striped table-hover">
                                      <tbody>
                                        <tr>
                                            <td width="30%"><strong>Nama</strong></td>
                                            <td><span id="nama_pemeriksaan"></span></td>
                                        </tr>          
                                        <tr>
                                          <td><strong>No. RM</strong></td>
                                          <td><span id="no_rm_pemeriksaan"></span></td>
                                        </tr>
                                        <tr>
                                          <td><strong>No. Register</strong></td>
                                          <td><span id="no_reg_pemeriksaan"></span></td>
                                        </tr>
                                        <tr>
                                          <td><strong>Alamat</strong></td>
                                          <td><span id="alamat_pemeriksaan"></span></td>
                                        </tr>
                                        <tr>
                                          <td><strong></strong></td>
                                          <td><span id="area_pemeriksaan"></span></td>
                                        </tr>
                                        <tr>
                                          <td><strong>Kelamin</strong></td>
                                          <td><span id="kelamin_pemeriksaan"></span></td>
                                        </tr>
                                        <tr>
                                          <td><strong>Umur/Tgl. Lahir</strong></td>
                                          <td><span id="umur_pemeriksaan"></span></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <input type="hidden" name="id_dokter_pemeriksaan" id="id_dokter_pemeriksaan" />
                                    <table class="table table-condensed table-striped table-hover">
                                      <tbody>
                                        <tr>
                                            <td width="30%"><strong>Tanggal</strong></td>
                                            <td><span id="tanggal_masuk_pemeriksaan"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>No. Antri</strong></td>
                                            <td>
                                                <b><span id="no_antri_pemeriksaan"></span></b>&nbsp;
                                                <button type="button" class="btn btn-info btn-xs" id="cetak_antrian"><i class="fa fa-print"></i> Cetak</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dokter</strong></td>
                                            <td><span id="dokter_pemeriksaan"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cara Bayar</strong></td>
                                            <td><span id="cara_bayar_pemeriksaan"></span></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                                <!-- Data Pasien -->
                            </div>
                            <div class="row">
                                <!-- Data Pemeriksaan -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group tight">
                                            <label class="col-lg-2 control-label">Pasien</label>
                                            <div class="col-lg-9">
                                                <h5 class="identitas_pasien"></h5>
                                            </div>
                                        </div>
                                        <div class="form-group tight">
                                            <label class="col-lg-2 control-label">Dokter</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="dokter" class="select2-input" id="dokter">
                                            </div>
                                        </div>
                                        <div class="form-group tight">
                                            <label class="col-lg-2 control-label">Anamnesa & Pemeriksaan</label>
                                            <div class="col-lg-9">
                                                <textarea type="text" name="anamnesa" class="form-control" rows="5" id="anamnesa_pemeriksaan" placeholder="Anamnesa dan Pemeriksaan"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group tight">
                                            <label class="col-lg-2 control-label">Diagnosa</label>
                                            <div class="col-lg-9">
                                                <textarea type="text" name="diagnosa" class="form-control" rows="5" id="diagnosa_pemeriksaan" placeholder="Diagnosa"></textarea>
                                            </div>
                                        </div>
                                         <div class="form-group tight">
                                            <label class="col-lg-2 control-label">Therapi/Tindakan</label>
                                            <div class="col-lg-9">
                                                <textarea type="text" name="tindakan" class="form-control" rows="5" id="tindakan_pemeriksaan" placeholder="Therapi/Tindakan"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Data Pemeriksaan -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <?= form_close() ?>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
        <button type="button" class="btn btn-success" onclick="konfirmasi_simpan_pemeriksaan()"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Pemeriksaan Modal -->

<!-- modal detail data pemeriksaan -->
<div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 80%; height: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Detail Data Pemeriksaan</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-condensed table-striped table-hover">
                          <tbody class="ibox-content">
                            <tr>
                                <td width="30%"><strong>Nama</strong></td>
                                <td><span id="nama_detail"></span></td>
                            </tr>          
                            <tr>
                              <td><strong>No. RM</strong></td>
                              <td><span id="no_rm_detail"></span></td>
                            </tr>
                            <tr>
                              <td><strong>No. Register</strong></td>
                              <td><span id="no_reg_detail"></span></td>
                            </tr>
                            <tr>
                              <td><strong>Alamat</strong></td>
                              <td><span id="alamat_detail"></span></td>
                            </tr>
                            <tr>
                              <td><strong></strong></td>
                              <td><span id="area_detail"></span></td>
                            </tr>
                            <tr>
                              <td><strong>Kelamin</strong></td>
                              <td><span id="kelamin_detail"></span></td>
                            </tr>
                            <tr>
                              <td><strong>Umur/Tgl. Lahir</strong></td>
                              <td><span id="umur_detail"></span></td>
                            </tr>  
                          </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-condensed table-striped table-hover">
                          <tbody class="ibox-content">
                            <tr>
                                <td width="30%"><strong>Tanggal</strong></td>
                                <td><span id="tanggal_masuk_detail"></span></td>
                            </tr>
                            <tr>
                                <td><strong>No. Antri</strong></td>
                                <td>
                                    <b><span id="no_antri_detail"></span></b>&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dokter</strong></td>
                                <td><span id="dokter_detail"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Cara Bayar</strong></td>
                                <td><span id="cara_bayar_detail"></span></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group">
                            <li class="list-group-item active"><strong>DETAIL ITEM PEMERIKSAAN</strong></li>
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <li class="list-group-item">
                                        <table class="table table-condensed table-striped table-hover" id="item_detail_pemeriksaan">
                                            <thead>
                                                <tr class="success">
                                                    <th width="5%" style="text-align: center;">NO</th>
                                                    <th width="30%">ANAMNESA DAN PEMERIKSAAN</th>
                                                    <th width="30%" style="text-align: center;">DIAGNOSA</th>
                                                    <th width="30%" style="text-align: center;">TINDAKAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </li>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="reset_detail_form()"><i class="fa fa-check"></i>&nbsp;Oke</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal detail -->

<!-- SKS Modal -->
<div id="sks_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Form Pembuatan Surat Keterangan Sakit</h4>
      </div>
      <div class="modal-body">
        <?=form_open('', 'id=formsks role=form class=form-horizontal')?>
            <input type="hidden" name="id_layanan2" id="id_layanan2">
            <div class="form-group">
                <label class="col-lg-3 control-label">Tanggal</label>
                <div class="col-lg-3">
                  <input type="text" name="dari" value="<?=date('d/m/Y')?>" class="form-control validate_input" id="dari">
                </div>
                <div class="col-lg-1">
                    <center><h5 style="padding-top:9px;">s.d</h5></center>
                </div>
                <div class="col-lg-3">
                  <input type="text" name="sampai" value="<?=date('d/m/Y')?>" class="form-control validate_input" id="sampai">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Selama</label>
                <div class="col-lg-8">
                  <input type="number" name="selama" class="form-control validate_input" id="selama" placeholder="Hari">
                </div>
            </div>
        <?=form_close()?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Keluar</button>
        <button type="button" class="btn btn-success" onclick="konfirmasi_simpan_sks()"><i class="fa fa-save"></i> Buat SKS</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End SKS Modal -->

<script src="<?=base_url('assets/js/wizard/bwizard.js')?>"></script>
<script type="text/javascript">
    var jenis_status= '';
    var klik = null;

    $(function () {
        get_list_pendaftaran(1, '');
        $("#wizard").bwizard();
        $("#wizard2").bwizard();
        $("#tanggal_lahir").datepicker({
            format: 'dd/mm/yyyy',
            endDate: "1d"
        }).on('changeDate', function(){
            $(this).datepicker('hide');
            var tgl = $(this).val();
            $('#umur_label').html('');
            if (tgl !== '') {
                var umur = hitungUmur(date2mysql(tgl));
                $('#umur_label').html(umur);
            }
        });

        $("#awal, #akhir, #dari, #sampai").datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });

        $('#bt_tambah').click(function(){
            $('#modal_pendaftaran').modal('show');
            $('#modal_title').html('ENTRI PENDAFTARAN PASIEN');
            $("#wizard").bwizard("show","0");
            reset_data();
        });

        $('#bt_pencarian').click(function(){
            $('#search_modal').modal('show');
        });

        $('#formadd').submit(function(){
            return false;
        });

        $('#bt_reset_pendaftaran').click(function(){
            reset_data();
            get_list_pendaftaran(1, '');
        });

        $('.select2-input, .validate_input').keyup(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }
        });

        $('.select2-input, .validate_input').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }
        });

        $('#agama').change(function(){
            if($(this).val() !== ''){
                my_validation_remove(this);
            }
        });

        $('#no_rm').change(function(){
            var tanggal = $('#tanggal').html();
            get_antrian(tanggal, $(this).val(),'#no_antri', '#antrian');
        });

        $('#nama').change(function(){
            var tanggal = $('#tanggal').html();
            get_antrian(tanggal, $(this).val(),'#no_antri', '#antrian');
        });

        $('#dokter').select2({
            ajax: {
                url: "<?= base_url('api/masterdata_auto/dokter_auto') ?>",
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
                $('#s2id_dokter_diag a .select2-chosen, #s2id_operator a .select2-chosen,#dokter_pemeriksaan').html(data.nama);
                $('#operator,#id_dokter_pemeriksaan').val(data.id);
                return data.nama;
            }
        });

        $('#no_rm').select2({
            ajax: {
                url: "<?=base_url('api/admission_auto/pasien_auto')?>",
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
                fill_data_pasien(data);
                return data.id;
            }
        });

        $('#kelurahan_auto').select2({
            // dropdownParent: $(this).parent(),
            ajax: {
                url: "<?=base_url('api/masterdata_auto/kelurahan_auto')?>",
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
                var markup = '<b>'+data.nama+'</b><br/><i>'+data.kecamatan+', '+data.kabupaten+', '+data.provinsi+'</i>';
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

        $('input').keyup(function() {
            this.value = this.value.toUpperCase();
        });
    });

    function reset_detail_form() {
        $('#item_detail_pemeriksaan tbody').empty();
        $('#detail_modal').modal("hide");
    }

    function get_antrian(tanggal, id_pasien, elemen_html, elemen_value){
        $.ajax({
            type : 'GET',
            url: '<?=base_url("api/admission/pendaftaran_get_antrian")?>/',
            data: 'tanggal='+tanggal+'&id_pasien='+id_pasien,
            cache: false,
            dataType : 'json',
            success: function(data) {
                $(elemen_html).html(data.antrian);
                $(elemen_value).val(data.antrian);
            },
            error: function(e){
                access_failed(e.status);
            }
        });
    }

    function reset_antri(){
        $('#no_antri').html('');
        $('#antrian, #layanan_antri').val('');
        dc_validation_remove('.validate_input');
    }

    function reset_data(){
        $('#id, .form-control, .select2-input, #pencarian, #antrian, #nama_search, #no_rm_search').val('');
        $('#s2id_no_rm a .select2-chosen').html('No. RM');
        $('#s2id_tempat_lahir a .select2-chosen').html('Pilih Kabupaten');
        $('#s2id_kelurahan_auto a .select2-chosen').html('Pilih Kelurahan');
        $('#s2id_dokter a .select2-chosen').html('Pilih Dokter');

        $('#cara_bayar').val('Tunai');
        $('#no_antri, #umur_label').html('');
        $('#awal, #akhir, #dari, #sampai').val('<?=date("d/m/Y")?>');
        my_validation_remove('.form-control');
        my_validation_remove('.select2-input');
    }

    function fill_data_pasien(data){
        $('#no_rm').val(data.id);
        $('#nama').val(data.nama);
        $('#kelamin').val(data.kelamin);
        $('#kelurahan_auto').val(data.id_kelurahan);
        $('#alamat').val(data.alamat);
        $('#tanggal_lahir').val((data.tanggal_lahir !== null)?datefmysql(data.tanggal_lahir):'');
        $('#tempat_lahir').val(data.tempat_lahir);
        $('#telp').val(data.telp);
        $('#agama').val(data.agama);
        $('#gol_darah').val(data.gol_darah);
        $('#pendidikan').val(data.id_pendidikan);
        $('#pekerjaan').val(data.id_pekerjaan);
        $('#pernikahan').val(data.status_pernikahan);

        $('#no_identitas').val(data.no_identitas);
        $('#nama_ayah').val(data.nama_ayah);
        $('#nama_ibu').val(data.nama_ibu);

        var umur = hitungUmur(data.tanggal_lahir);
        $('#umur_label').html(umur);
        $('#s2id_kelurahan_auto a .select2-chosen').html('');
        if (data.id_kelurahan !== null) {
            get_kelurahan(data.id_kelurahan);
        }else{
            $('#s2id_kelurahan_auto a .select2-chosen').html('');
        }

        $('#s2id_tempat_lahir a .select2-chosen').html('');
        if (data.tempat_lahir !== null) {
            get_kabupaten_kota(data.tempat_lahir);
        }else{
            $('#s2id_tempat_lahir a .select2-chosen').html('');
        }

    }

    function get_kelurahan(id){
        $.ajax({
            type : 'GET',
            url: '<?=base_url("api/masterdata/kelurahan")?>/id/'+id,
            cache: false,
            dataType : 'json',
            success: function(data) {
                $('#s2id_kelurahan_auto a .select2-chosen').html(data.data.nama+', '+data.data.kecamatan+', '+data.data.kabupaten);
            },
            error: function(e){
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

    function search_data(){
        get_list_pendaftaran(1, '');
        $('#search_modal').modal('hide');
    }

    function konfirmasi_simpan(){
        var stop = false;

        if ($('#nama').val() === '') {
            my_validation('#nama', 'Nama pasien harus diisi!');
            stop = true;
        };

        if ($('#alamat').val() === '') {
            my_validation('#alamat', 'Alamat harus diisi!');
            stop = true;
        };

        if ($('#tempat_lahir').val() === '') {
            my_validation('#tempat_lahir', 'Tempat lahir harus diisi!');
            stop = true;
        };

        // if ($('#agama').val() === '') {
        //     my_validation('#agama', 'Agama harus dipilih!');
        //     stop = true;
        // };


        // if ($('#umur').val() === '') {
        //     if ($('#tanggal_lahir').val() === ''){
        //         my_validation('#tanggal_lahir', 'Tanggal Lahir harus diisi!');
        //         stop = true;
        //     };
        // };

        if ($('#kelamin').val() === '') {
            my_validation('#kelamin', 'Jenis Kelamin harus dipilih!');
            stop = true;
        };

        if ($('#kelurahan_auto').val() === '') {
            my_validation('#kelurahan_auto', 'Kelurahan harus diisi!');
            stop = true;
        };

        // if ($('#telp').val() === '') {
        //     my_validation('#telp', 'Telp harus diisi!');
        //     stop = true;
        // };


        if (stop) {
            return false;
        };

        klik = null;
        bootbox.dialog({
          message: "Anda sudah yakin data yang dientri sudah benar ? ?",
          title: "Simpan Pendaftaran MI",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {

              }
            },
            masuk: {
              label: '<i class="fa fa-check"></i> Simpan',
              className: "btn-success",
              callback: function() {
                save_data();
              }
            }
          }
        });
    }

    function save_data(){
        if (klik === null) {
            show_ajax_loading();
            klik = $.ajax({
                type : 'POST',
                url: '<?=base_url("api/admission/pendaftaran")?>/',
                data: $('#formadd').serialize(),
                cache: false,
                dataType : 'json',
                success: function(data) {
                    if (data.id !== null) {
                        message_add_success();
                        get_list_pendaftaran(1, data.id);
                        $('#modal_pendaftaran').modal('hide');
                    }else{
                        bootbox.dialog({
                          message: data.message,
                          title: "Pendaftaran Gagal",
                          buttons: {
                            batal: {
                              label: '<i class="fa fa-check"></i> OK',
                              className: "btn-primary",
                              callback: function() {

                              }
                            }

                          }
                        });
                    }

                    hide_ajax_loading();
                },
                error: function(e){
                    $('#modal_pendaftaran').modal('hide');
                    message_add_failed();
                    hide_ajax_loading();
                }
            });
        }
    }

    function get_list_pendaftaran(p, id) {
        show_ajax_loading();
        $('#page_now').val(p);
        $.ajax({
            type : 'GET',
            url: '<?=base_url("api/admission/list_pendaftaran")?>/page/'+p+'/jenis/',
            data: $('#formsearch').serialize()+'&id='+id,
            cache: false,
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_pendaftaran(p-1, '');
                    return false;
                };

                $('#pagination').html(pagination(data.jumlah, data.limit, data.page, 1));
                $('.page_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_data tbody').empty();
                var str = ''; var waktu_keluar = ''; var disabled = ''; var disable = ''; var waktu_periksa = ''; var detail_button = ''; var button_batal = ''; var status_pemeriksaan =''; var print_sks = '';
                $.each(data.data,function(i, v){
                    var highlight = 'odd';
                    if ((i % 2) === 1) {
                        highlight = 'even';
                    };

                    if (v.status == 'Baru') {
                        status = "<span class='label label-info'><i class='fa fa-plus'></i>&nbsp;Baru</span>"
                    } else if (v.status == 'Lama') {
                        status = "<span class='label label-success'><i class='fa fa-history'></i>&nbsp;Lama</span>"
                    }

                    disabled = '';
                    if (v.waktu_keluar !== null) {
                        disabled = 'disabled';
                        detail_button = '';
                    };

                    if (v.waktu_periksa == '') {
                        disable = 'disabled';
                        waktu_periksa = '-';
                    } else {
                        disable = '';
                        waktu_periksa = ((v.waktu_periksa !== null)?datetimefmysql(v.waktu_periksa):'');
                    }

                    if (v.id_sks !== null) {
                        print_sks = '<button title="Print SKS" type="button" class="btn btn-default btn-xs" onclick="print_sks(\''+v.id_sks+'\')"><i class="fa fa-envelope"></i></button> ';
                    } else {
                        print_sks = '<button title="Buat SKS" type="button" class="btn btn-default btn-xs" onclick="buat_sks(\''+v.id_layanan+'\')"><i class="fa fa-plus"></i></button> ';
                    }

                    if (v.status_pemeriksaan === 'Belum') {
                        detail_button = '';
                        status_pemeriksaan = '<i class="blinker">Belum</i>';
                    }else if (v.status_pemeriksaan === 'Batal') {
                        detail_button = '';
                        status_pemeriksaan = '<span class="label label-danger"><i class="fa fa-times"></i> Batal</span>';
                    }else if (v.status_pemeriksaan === 'Sudah'){
                        detail_button = '<button title="Detail Pemeriksaan" type="button" class="btn btn-default btn-xs" onclick="detail_pemeriksaan('+v.id+','+v.id_layanan+')"><i class="fa fa-eye"></i></button> '
                        status_pemeriksaan = '<span class="label label-success"><i class="fa fa-check-circle"></i> Diperiksa</span>';
                    }

                    str = '<tr class="'+highlight+'">'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.no_register+'</td>'+
                            '<td>'+((v.waktu_daftar !== null)?datetimefmysql(v.waktu_daftar):'')+'</td>'+
                            '<td>'+v.id_pasien+'</td>'+
                            '<td>'+v.nama+'</td>'+
                            '<td>'+waktu_periksa+'</td>'+
                            // '<td>'+v.cara_bayar+'</td>'+
                            '<td>'+status+'</td>'+
                            '<td>'+status_pemeriksaan+'</td>'+
                            '<td>'+v.username+'</td>'+
                            '<td align="right" class="aksi">'+
                                '<button '+disabled+' title="Entri Pemeriksaan" type="button" class="btn btn-default btn-xs" onclick="entri_pemeriksaan('+v.id+','+v.id_layanan+')"><i class="fa fa-pencil"></i></button> '+
                                ''+detail_button+
                                ''+print_sks+
                                '<button '+disable+' title="Print Hasil" type="button" class="btn btn-default btn-xs" onclick="cetak_hasil_pemeriksaan(\''+v.id+'\')"><i class="fa fa-print"></i></button> '+
                                '<button '+disabled+' title="Batalkan Pendaftaran" type="button" class="btn btn-default btn-xs" onclick="batal_pendaftaran(\''+v.id+'\')"><i class="fa fa-trash-o"></i></button>'+
                            '</td>'+
                        '</tr>';
                    $('#table_data tbody').append(str);
                });
                hide_ajax_loading();
            },
            error: function(e){
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function set_tanggal_pencarian(){
        var awal = $('#awal').val();
        var akhir = $('#akhir').val();
        var status = $('#status').val();
        var no_register = $('#no_register_search').val();
        var no_rm = $('#no_rm_search').val();
        var nama = $('#nama_search').val();

        reset_data();
        $('#awal').val(awal);
        $('#akhir').val(akhir);
        $('#status').val(status);
        $('#no_register_search').val(no_register);
        $('#no_rm_search').val(no_rm);
        $('#nama_search').val(nama);
    }

    function entri_pemeriksaan(id, id_layanan) {
        $("#wizard2").bwizard("show","0");

        set_tanggal_pencarian();
        $('#id_layanan').val(id_layanan);
        $('#id_pendaftaran').val(id);

        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url: '<?= base_url("api/admission/layanan_pendaftaran_detail") ?>/id/'+id+'/id_layanan/'+id_layanan,
            cache: false,
            dataType : 'json',
            success: function(data) {
                hide_ajax_loading();
                var kelamin = ''; var umur = ''; var hasil = ''; var visitasi = '';
                if (data.pasien !== null) {
                    hasil = data.pasien;
                    layan = data.layanan;
                    if (hasil.kelamin == 'L') {
                        kelamin = 'Laki - Laki';
                    }else{
                        kelamin = 'Perempuan';
                    }
                    if (hasil.tanggal_lahir !== null) {
                        umur = hitungUmur(hasil.tanggal_lahir)+' ('+datefmysql(hasil.tanggal_lahir)+')';
                    }

                    $('.identitas_pasien').html(hasil.id_pasien+' / '+hasil.nama+' / '+umur);
                    
                    $('#id_pasien').val(hasil.id_pasien);
                    $('#nama_pemeriksaan').html(hasil.nama);
                    $('#no_rm_pemeriksaan').html(hasil.id_pasien);
                    $('#no_rm_lama_pemeriksaan').html(hasil.rm_lama);
                    $('#no_reg_pemeriksaan').html(hasil.no_register);
                    $('#alamat_pemeriksaan').html(hasil.alamat);

                    var area = hasil.kelurahan+', '+hasil.kecamatan+', '+hasil.kabupaten+', '+hasil.provinsi;
                    $('#area_pemeriksaan').html(area);
                    
                    $('#kelamin_pemeriksaan').html(kelamin);
                    $('#umur_pemeriksaan').html(umur);
                    $('#tanggal_masuk_pemeriksaan').html(hasil.waktu_daftar);

                    $('#cetak_antrian').click(function () {
                        cetak_antrian(hasil.id, data.layanan.id);
                    });
                }
                
               
                // Layanan
                $('#s2id_dokter a .select2-chosen, #s2id_dokter a .select2-chosen ,#dokter_pemeriksaan').html(data.layanan.dokter);
                $('#id_dokter_pemeriksaan, #dokter').val(data.layanan.id_dokter);
                $('#layanan_pemeriksaan').html(data.layanan.layanan);
                $('#no_antri_pemeriksaan').html(data.layanan.no_antri);
                $('#dokter_pemeriksaan').html(data.layanan.dokter);
                
                var cara_bayar = data.layanan.cara_bayar;
                $('#cara_bayar_pemeriksaan').html(cara_bayar);

                //item pemeriksaan
                $('#anamnesa_pemeriksaan').val(data.layanan.anamnesa);
                $('#diagnosa_pemeriksaan').val(data.layanan.diagnosa);
                $('#tindakan_pemeriksaan').val(data.layanan.tindakan);
                $('#pemeriksaan_modal').modal('show');     
            },
            error: function(e){
                hide_ajax_loading();
                access_failed(e.status);
            }
        });
    }

    function detail_pemeriksaan(id, id_layanan) {
        $('#item_detail_pemeriksaan tbody').empty();
        $("#wizard2").bwizard("show","0");

        set_tanggal_pencarian();
        $('#id_layanan').val(id_layanan);
        $('#id_pendaftaran').val(id);

        show_ajax_loading();
        $.ajax({
            type : 'GET',
            url: '<?= base_url("api/admission/layanan_pendaftaran_detail") ?>/id/'+id+'/id_layanan/'+id_layanan,
            cache: false,
            dataType : 'json',
            success: function(data) {
                hide_ajax_loading();
                var kelamin = ''; var umur = ''; var hasil = ''; var visitasi = '';
                if (data.pasien !== null) {
                    hasil = data.pasien;
                    layan = data.layanan;
                    if (hasil.kelamin == 'L') {
                        kelamin = 'Laki - Laki';
                    }else{
                        kelamin = 'Perempuan';
                    }
                    if (hasil.tanggal_lahir !== null) {
                        umur = hitungUmur(hasil.tanggal_lahir)+' ('+datefmysql(hasil.tanggal_lahir)+')';
                    }

                    $('.identitas_pasien').html(hasil.id_pasien+' / '+hasil.nama+' / '+umur);
                    
                    $('#id_pasien').val(hasil.id_pasien);
                    $('#nama_detail').html(hasil.nama);
                    $('#no_rm_detail').html(hasil.id_pasien);
                    $('#no_rm_lama_detail').html(hasil.rm_lama);
                    $('#no_reg_detail').html(hasil.no_register);
                    $('#alamat_detail').html(hasil.alamat);

                    var area = hasil.kelurahan+', '+hasil.kecamatan+', '+hasil.kabupaten+', '+hasil.provinsi;
                    $('#area_detail').html(area);
                    
                    $('#kelamin_detail').html(kelamin);
                    $('#umur_detail').html(umur);
                    $('#tanggal_masuk_detail').html(hasil.waktu_daftar);

                    $('#cetak_antrian').click(function () {
                        cetak_antrian(hasil.id, data.layanan.id);
                    });
                }
                
               
                // Layanan
                $('#s2id_dokter a .select2-chosen, #s2id_dokter a .select2-chosen ,#dokter_detail').html(data.layanan.dokter);
                $('#id_dokter_detail, #dokter').val(data.layanan.id_dokter);
                $('#layanan_detail').html(data.layanan.layanan);
                $('#no_antri_detail').html(data.layanan.no_antri);
                $('#dokter_detail').html(data.layanan.dokter);
                
                var cara_bayar = data.layanan.cara_bayar;
                $('#cara_bayar_detail, #cara_bayar_tindakan').html(cara_bayar);

                //item pemeriksaan
                var str = '';
                str =   '<tr>'+
                            '<td align="center">1</td>'+
                            '<td>'+data.layanan.anamnesa+'</td>'+
                            '<td>'+data.layanan.diagnosa+'</td>'+
                            '<td>'+data.layanan.tindakan+'</td>'+
                        '</tr>';
                $('#item_detail_pemeriksaan tbody').append(str);

                $('#detail_modal').modal('show');     
            },
            error: function(e){
                hide_ajax_loading();
                access_failed(e.status);
            }
        });
    }
    

    function batal_pendaftaran(id){
        bootbox.dialog({
            message: "Anda yakin akan melakukan pembatalan pendaftaran?",
            title: "Pembatalan Pendaftaran",
            buttons: 
            {
                batal: 
                {
                  label: '<i class="fa fa-refresh"></i> Tidak',
                  className: "btn-default",
                  callback: function() {

                    }
                },
                hapus: 
                {
                    label: '<i class="fa fa-trash-o"></i>  Ya',
                    className: "btn-success",
                    callback: function() 
                    {
                        $.ajax({
                            type : 'DELETE',
                            url: '<?=base_url("api/admission/batal_pendaftaran")?>/id/'+id,
                            cache: false,
                            dataType : 'json',
                            success: function(data) {
                                if (data.status) {
                                    message_custom('success', 'Pembatalan Pendaftaran', data.message, '');
                                    get_list_pendaftaran($('#page_now').val(), '');
                                }else{
                                    custom_alert('Pembatalan Pendaftaran', data.message);
                                }

                            },
                            error: function(e){
                                message_custom('error', 'Pembatalan Pendaftaran', 'Gagal melakukan pembatalan pendaftaran', '');
                            }
                        });
                    } 
                }
            }
        });
    }

    function konfirmasi_simpan_pemeriksaan(){
        var stop = false;

        if ($('#dokter').val() === '') {
            my_validation('#dokter', 'Dokter harus diisi!');
            stop = true;
            $('#wizard2').bwizard('show','1');
            return false;
        };

        if (stop) {
            return false;
        };

        klik = null;
        bootbox.dialog({
          message: "Anda yakin akan menyimpan hasil pemeriksaan ?",
          title: "Simpan Pemeriksaan",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {
                
              }
            },
            masuk: {
              label: '<i class="fa fa-check"></i> Simpan',
              className: "btn-success",
              callback: function() {
                save_data_pemeriksaan();
              }
            }
          }
        });
    }

    function save_data_pemeriksaan(){
        if (klik === null) {
            show_ajax_loading();
            klik = $.ajax({
                type : 'POST',
                url: '<?= base_url("api/admission/pemeriksaan_save") ?>/',
                data: $('#formaddpemeriksaan').serialize(),
                cache: false,
                dataType : 'json',
                success: function(data) {
                    hide_ajax_loading();
                    $('#pemeriksaan_modal').modal('hide');
                    message_add_success();
                    get_list_pendaftaran(1, '');
                },
                error: function(e){
                    message_add_failed();
                    hide_ajax_loading();
                }
            });
        }
    }

    function buat_sks(id_layanan2) {
        $('#id_layanan2').val(id_layanan2)
        $('#selama').val('');
        my_validation_remove('.form-control');
        $('#sks_modal').modal('show');
    }

    function konfirmasi_simpan_sks(){
        var stop = false;

        if ($('#selama').val() === '') {
            my_validation('#selama', 'Berapa hari istirahatnya..');
            stop = true;
        };

        if (stop) {
            return false;
        };

        klik = null;
        bootbox.dialog({
          message: "Anda yakin akan membuat surat keterangan sakit ?",
          title: "Simpan Surat Keterangan Sakit",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {
                
              }
            },
            masuk: {
              label: '<i class="fa fa-check"></i> Simpan',
              className: "btn-success",
              callback: function() {
                simpan_sks();
              }
            }
          }
        });
    }
    function simpan_sks() {
        if (klik === null) {
            show_ajax_loading();
            klik = $.ajax({
                type : 'POST',
                url: '<?= base_url("api/admission/sks") ?>/',
                data: $('#formsks').serialize(),
                cache: false,
                dataType : 'json',
                success: function(data) {
                    hide_ajax_loading();
                    message_custom('success', 'Surat Keterangan Sakit Berhasil dibuat!');
                    get_list_pendaftaran(1, '');
                    $('#sks_modal').modal('hide');
                    print_sks(data.id);
                },
                error: function(e){
                    hide_ajax_loading();
                    message_custom('error', 'Surat Keterangan Sakit Gagal dibuat!')
                    $('#sks_modal').modal('hide');
                }
            });
        }
    }

    function paging(p){
        get_list_pendaftaran(p, '');
    }

    function cetak_hasil_pemeriksaan(id) {
        window.open('<?=base_url()?>printing/hasil_pemeriksaan/'+id,'Cetak Hasil Pemeriksaan','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
    }

    function export_data() {
        location.href = '<?=base_url()?>export/export_data_pendaftaran?'+$('#formsearch').serialize();
    }

    function cetak_antrian(id_pendaftaran, id_layanan){
        window.open('<?=base_url()?>printing/no_antri/'+id_pendaftaran+'/'+id_layanan,'Cetak Nomor Antri Pendaftaran','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
    }

    function print_sks(id) {
        window.open('<?=base_url()?>printing/sks/'+id,'Cetak Surat Keterangan Sakit','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
    }
</script>