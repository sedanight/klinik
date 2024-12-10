<script type="text/javascript">
	$(function() {
		set_awal();

		$('#password_lama').keyup(function(){
			var lama = $(this).val();
			var user = $('#id').val();
			
			$.ajax({
				type : 'POST',
				url : '<?= base_url("home/cek_password")?>',
				data: 'username='+user+'&password='+lama,
				cache: false,
				dataType: 'json',
				success: function(data){
					if (data.status ==  true) {
						$('#password_baru').removeAttr('disabled');
						$('#message').html(' Isikan password baru anda');
						$('#password_baru').focus();
					}else{
						set_awal();
					}
				}	
			});
		});

		$('#password_baru').keyup(function(){
			if($(this).val() !== ''){
				$('#password_konf').removeAttr('disabled');
			}else{
				$('#password_konf').attr('disabled', 'disabled');
			}
		});

		$('#password_baru').blur(function(){
			if($(this).val() !== ''){
				$('#password_konf').removeAttr('disabled');
				$('#message').html(' Ketik ulang password baru anda');
			}else{
				$('#password_konf').attr('disabled', 'disabled');
				$('#message').html(' Isikan password baru anda terlebih dahulu!');
			}
			
		});

		$('#password_konf').keyup(function(){
			var konf = $(this).val();
			var baru = $('#password_baru').val();

			if(konf === baru){
				$('#bt_ganti').removeAttr('disabled');
				$('#message').html(' Silahkan simpan password baru anda');
			}else{
				$('#bt_ganti').attr('disabled', 'disabled');
				$('#message').html(' Konfirmasi password baru belum sesuai');
			}
		});

		$('#bt_ganti').click(function(){
			$.ajax({
				type : 'POST',
				url : '<?= base_url("home/save_password")?>',
				data: $('#formadd').serialize(),
				cache: false,
				dataType: 'json',
				success: function(data){
					if (data.status ==  true) {
						message_custom('success', 'Ganti Password', 'Ganti Password Berhasil', '');
						reset();
						setTimeout(logout, 2000);
					}else{
						message_custom('error', 'Ganti Password', 'Ganti Password Gagal', '');
					}
				}	
			});
		});

	});

	function logout() {
		location.href = '<?= base_url("users/logout") ?>';
	}

	function set_awal(){
		$('#message').html(' Isikan password lama anda');
		$('#password_konf, #password_baru, #bt_ganti').attr('disabled', 'disabled');
	}

	function reset(){
		$('#password_konf, #password_baru, #password_lama, #id').val('');
		set_awal();
		$('#password_lama').focus();
	}

</script>
<div class="row">
	<div class="col-xs-6 center">
		<div class="well well-sm">
			<span class="fa fa-info-circle" id="message"></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6 center">
		<div class="panel panel-white">
            <div class="panel-body">
            	<?= form_open('','id=formadd role=form class=form-horizontal') ?>
					<input name="id" type="hidden" id="id" value="<?= $id ?>"/>
					<div class="form-group">
					    <label for="asuransi" class="col-lg-3 control-label">Password Lama</label>
					    <div class="col-lg-7">
					      <input type="password" name="password_lama" class="form-control" id="password_lama" placeholder="Password Lama">
					    </div>
					</div>
					<div class="form-group">
					    <label for="diskon" class="col-lg-3 control-label">Password Baru</label>
					    <div class="col-lg-7">
					        <input type="password" name="password_baru" class="form-control" id="password_baru" placeholder="Password Baru">
					    </div>
					</div>
					<div class="form-group">
					    <label for="diskon" class="col-lg-3 control-label">Konfirmasi Password</label>
					    <div class="col-lg-7">
					        <input type="password" name="password_konf" class="form-control" id="password_konf" placeholder="Password Baru">
					    </div>
					</div>
					<div class="form-group">
					    <label for="diskon" class="col-lg-3 control-label"></label>
					    <div class="col-lg-7">
					        <button type="button" class="btn btn-success" id="bt_ganti"><i class="fa fa-check"></i> Ganti Password</button>
					        <button type="button" class="btn btn-default" onclick="reset()"><i class="fa fa-refresh"></i> Reset</button>
					    </div>
					</div>
				<?= form_close() ?>    
			</div>
		</div>
	</div>
</div>
