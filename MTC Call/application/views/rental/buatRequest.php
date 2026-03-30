<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$("#id_dept").change(function() {
			var data = {
				id_dept: $("#id_dept").val()
			};
			// console.log(data);
			$.ajax({
				type: "POST",
				url: "<?= site_url('select/select_vehicle') ?>",
				data: data,
				success: function(msg) {
					$('#div-order').html(msg);
				}
				,error: function() {
					$('#div-order').html('<p class="text-danger">Gagal memuat kendaraan.</p>');
				}
			});
		});

	});


	// auto fill req_date
	document.addEventListener('DOMContentLoaded', (event) => {
        const dateInput = document.querySelector('input[name="req_date"]');
		const endDateInput = document.querySelector('input[name="end_date"]');

        if (dateInput && endDateInput) {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0'); 
            const day = today.getDate().toString().padStart(2, '0');
			//const hours = String(today.getHours()).padStart(2, '0');
			//const minutes = String(today.getMinutes()).padStart(2, '0');
			const dayPlus = new Date(today);
			dayPlus.setDate(today.getDate() + 1);
			const tomorrow = String(dayPlus.getDate()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}`;
			const formattedEndDate = `${year}-${month}-${tomorrow}`;
            dateInput.value = formattedDate;
			endDateInput.value = formattedEndDate;
        }

    });

	document.addEventListener('DOMContentLoaded', (event) => {
		const timeInput = document.querySelector('input[name="req_time"]');
		const endTimeInput = document.querySelector('input[name="end_time"]');
		if (timeInput && endTimeInput) {
			const now = new Date();
			const hours = String(now.getHours()+1).padStart(2, '0');
			const minutes = String(now.getMinutes()).padStart(2, '0');

			const formattedTime = `${hours}:${minutes}`;
			timeInput.value = formattedTime;
			endTimeInput.value = formattedTime;
		}
	});
</script>

<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3">Kirim Data Request.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Request Vehicle</h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('rental/submit') ?>" enctype="multipart/form-data">

				<input class="form-control" name="nama" value="<?= $profile['nama'] ?>" hidden>
				<input class="form-control" name="email" value="<?= $profile['email'] ?>" hidden>

				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Dept <span class="text-danger small">*Required</span></label>
							<?= form_dropdown('id_dept', $dd_dept, set_value('id_dept'), 'id="id_dept" class="form-control ' . (form_error('id_dept') ? "is-invalid" : "") . ' "'); ?>
							<div class="invalid-feedback">
								<?= form_error('id_dept'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Vehicle <span class="text-danger small">*Required</span></label>
							<div id="div-order">
								<?= form_dropdown('id_vehicle', $dd_vehicle, set_value('id_vehicle'), ' class="form-control ' . (form_error('id_vehicle') ? "is-invalid" : "") . ' "'); ?>
								<div class="invalid-feedback">
									<?= form_error('id_vehicle'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Driver Y/N <span class="text-danger small">*Required</span></label>
							<select id="driver_yn" 
											class="form-control <?= (form_error('driver_yn') ? 'is-invalid' : '') ?>" 
											name="driver_yn">
										<option value="">-- Dengan Driver --</option>
										<option value="Y" <?= set_select('driver_yn', 'Y', $vehicle['driver_yn'] == 'Y') ?>>Ya, Dengan Driver</option>
										<option value="N" <?= set_select('driver_yn', 'N', $vehicle['driver_yn'] == 'N') ?>>Tidak Dengan Driver</option>
							</select>
							<div class="invalid-feedback">
								<?= form_error('driver_yn'); ?>
							</div>
						</div>
					</div>	
				</div>
				<div class="row">
	 				<div class="col-sm-3" >
						<label class="mb-1 font-weight-bold">Request Date <span class="text-danger small">*Required</span></label>
						<input type="date" class="form-control <?= (form_error('req_date') ? 'is-invalid' : '') ?>" name="req_date" placeholder="Due date" value="<?= set_value('req_date'); ?>" required>
						<p class="small mb-6">contoh: 2025-09-15</p>
						<div class="invalid-feedback">
							<?= form_error('req_date'); ?>
						</div>
					</div>
					<div class="col-sm-3" >
						<label class="mb-1 font-weight-bold">Request Time <span class="text-danger small">*Required</span></label>
						<input type="time" class="form-control <?= (form_error('req_time') ? 'is-invalid' : '') ?>" name="req_time" value="<?= set_value('req_time'); ?>" required>
						<div class="invalid-feedback">
							<?= form_error('req_time'); ?>
						</div>
					</div>
					<div class="col-sm-3" >
						<label class="mb-1 font-weight-bold">Finish Date <span class="text-danger small">*Required</span></label>
						<input type="date" class="form-control <?= (form_error('end_date') ? 'is-invalid' : '') ?>" name="end_date" placeholder="Due date" value="<?= set_value('end_date'); ?>" required>
						<p class="small mb-6">contoh: 2025-09-15</p>
						<div class="invalid-feedback">
							<?= form_error('end_date'); ?>
						</div>
					</div>
					<div class="col-sm-3" >
						<label class="mb-1 font-weight-bold">Finish Time <span class="text-danger small">*Required</span></label>
						<input type="time" class="form-control <?= (form_error('end_time') ? 'is-invalid' : '') ?>" name="end_time" value="<?= set_value('end_time'); ?>" required>
						<div class="invalid-feedback">
							<?= form_error('end_time'); ?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="mb-1 font-weight-bold">Note <span class="text-danger small">*Required</span></label>
					<textarea name="keterangan" placeholder="" class="form-control <?= (form_error('keterangan') ? "is-invalid" : "") ?>" rows="6"><?= set_value('keterangan'); ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('keterangan'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Upload SIM/SIO <span class="text-info small">*Optional</span></label> </br>
					<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, jpeg, png, or pdf.</p>
					<input type="file" name="path_photo" size="20" class="<?= (form_error('path_photo') ? "is-invalid" : "") ?>">
					<div class="invalid-feedback">
						<?= form_error('path_photo'); ?>
					</div>
					<div class="text-danger pt-1"><?= $error; ?></div>
				</div>

				<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Submit</button>

			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire({
			icon: 'error',
			title: flashData,
			text: 'Something went wrong! file is more than 25MB or not supported format',
			footer: ''
		})
	}

	$('textarea').keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			var s = $(this).val();
			$(this).val(s + "\n");
		}
	});
</script>