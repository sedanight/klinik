<style>
    .dropzone {
        /*margin-top: 100px;*/
        border: 2px dashed #ccc;
    }
</style>

<div class="row">
    <div class="col-md-6 center">
        <div class="panel panel-white">
        	<div class="panel-heading clearfix">
                <h4><center>Card Profil</center></h4>
            </div>
            <div class="panel-body">
            	<hr>
                <div class="row">
                    <div class="col-md-4">
                        <?php if ($profil == ''): ?>
                            <center><img src="<?=base_url('assets/images/admin.png')?>" alt="admin" style="width: 100%; border-radius: 3%;"><br><br>
                        <?php else: ?>
                            <center><img src="<?=base_url('assets/foto/')?><?= $profil->nama; ?>" alt="admin" style="width: 100%; border-radius: 3%;"><br><br>
                        <?php endif ?>
                            <!-- <button class="btn btn-danger btn-sm" id="removeFoto">Hapus Foto</button> -->
                        </center>
                    </div>
                    <div class="col-md-8">
                    	<center>
		                    <table class="table table-striped table-hover">
		                      <tbody class="ibox-content">
		                        <tr>
		                            <td width="30%"><strong>Nama</strong></td>
		                            <td><span id="nama_detail"><?=$this->session->userdata('nama');?></span></td>
		                        </tr>
		                        <tr>
		                            <td><strong>Alamat</strong></td>
		                            <td><span id="alamat_detail"><?=$this->session->userdata('alamat');?></span></td>
		                        </tr>
		                        <tr>
		                            <td><strong>Unit</strong></td>
		                            <td><span id="unit_detail"><?=$this->session->userdata('unit');?></span></td>
		                        </tr>
		                      </tbody>
		                    </table>
                            <form class="form-horizontal" id="submit">
                                <div class="form-group">    
                                    <input type="file" class="form-control" name="file" id="foto" style="width: 80%;">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success" id="btn_upload" type="submit">Upload</button>
                                </div>
                            </form>
	                    </center>
	                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(function () {
        $('.form-control, #foto').keyup(function(){
            if ($(this).val() !== '') {
                my_validation_remove(this);
            }
        });

        $('.form-control, #foto').change(function(){
            if ($(this).val() !== '') {
                my_validation_remove(this);
            }
        });

        $('#submit').submit(function(e){
            var stop = false;

            if ($('#foto').val() === '') {
                my_validation('#foto', 'Silahkan pilih foto terlebih dahulu!');
                stop = true;
            };

            if (stop) {
                return false;
            }
            e.preventDefault(); 
            $.ajax({
                url:'<?php echo base_url('home/do_upload')?>',
                type:"post",
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                success: function(data){
                    if(data > 0) {
                        $('#foto').val('');
                        message_custom('success', 'Foto Berhasil di upload');
                        setTimeout(location.reload.bind(location), 1100);
                    } else {
                        // location.reload();
                        message_custom('error', 'Foto Gagal di upload');
                    }
                }
            });
        });
    });

</script>