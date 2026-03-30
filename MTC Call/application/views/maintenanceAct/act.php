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


	// // auto fill req_date
	// document.addEventListener('DOMContentLoaded', (event) => {
   //      const dateInput = document.querySelector('input[name="req_date"]');

   //      if (dateInput) {
   //          const today = new Date();
   //          const year = today.getFullYear();
   //          const month = (today.getMonth() + 1).toString().padStart(2, '0'); 
   //          const day = today.getDate().toString().padStart(2, '0');
	// 		const dayPlus = new Date(today);
	// 		dayPlus.setDate(today.getDate() + 1);
	// 		const tomorrow = String(dayPlus.getDate()).padStart(2, '0');

   //          const formattedDate = `${year}-${month}-${day}`;
   //          dateInput.value = formattedDate;
   //      }

   //  });

	// document.addEventListener('DOMContentLoaded', (event) => {
	// 	const timeInput = document.querySelector('input[name="req_time"]');
	// 	if (timeInput) {
	// 		const now = new Date();
	// 		const hours = String(now.getHours()).padStart(2, '0');
	// 		const minutes = String(now.getMinutes()).padStart(2, '0');
	// 		const seconds = String(now.getSeconds()).padStart(2, '0');
	// 		const formattedTime = `${hours}:${minutes}:${seconds}`;
	// 		timeInput.value = formattedTime;
	// 	}
	// });

	// 2025.11.28
	$(document).ready(function () {

		// Tekan Enter di input Machine ID
		$("#machine_id").on("keypress", function(e) {
			if (e.which == 13) { // 13 = Enter
				e.preventDefault();
				checkMachine();
			}
		});

		function checkMachine() {
			let machineId = $("#machine_id").val();

			if (machineId.trim() === "") return;

			$.ajax({
				url: "<?= base_url('maintenance/getMachineById'); ?>",
				type: "POST",
				data: { machine_id: machineId },
				dataType: "json",
				success: function(res) {

					if (res.success) {
						$("#machine_name").val(res.data.machine_name);
					} else {
						$("#machine_name").val("");
						alert("Machine ID tidak ditemukan!");
					}
				},
				error: function() {
					alert("Terjadi kesalahan saat mengambil data.");
				}
			});
		}
	});

</script>

<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3">Respone Work Order Management.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Respone Work Order Management</h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('maintenance_act/submit/'.$maintenanceAct['wo_id']) ?>" enctype="multipart/form-data">

				<input class="form-control" name="nama" value="<?= $profile['nama'] ?>" hidden>
				<input class="form-control" name="email" value="<?= $profile['email'] ?>" hidden>

				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">WO ID</label>
							<input type="text" class="form-control <?= (form_error('wo_id') ? 'is-invalid' : '') ?>" name="wo_id" placeholder="Due date" value="<?= $maintenanceAct['wo_id'] ?>"  readonly>
							<div class="invalid-feedback">
								<?= form_error('wo_id'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">MC ID</label>
							<input type="text" class="form-control <?= (form_error('machine_id') ? 'is-invalid' : '') ?>" name="machine_id" value="<?= $maintenanceAct['machine_id'] ?>" readonly>
							<div class="invalid-feedback">
								<?= form_error('machine_id'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-3" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Current Date</label>
							<input type="date" class="form-control <?= (form_error('req_date') ? 'is-invalid' : '') ?>" name="req_date" value="<?= $maintenanceAct['req_date'] ?>" readonly>
							<div class="invalid-feedback">
								<?= form_error('req_date'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-3" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Current Time</label>
							<input type="time" class="form-control <?= (form_error('req_time') ? 'is-invalid' : '') ?>" name="req_time" value="<?= $maintenanceAct['req_time'] ?>"  readonly>
							<div class="invalid-feedback">
								<?= form_error('req_time'); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="row mb-3 align-items-center">
					<div class="col-md-6">
						<h6 class="mb-2 font-weight-bold text-primary">Evidence 1</h6>
						<?php if (pathinfo($maintenanceAct['path_photo_1'], PATHINFO_EXTENSION) == 'pdf') { ?>
							<a href="<?= base_url('uploads/' . $maintenanceAct['path_photo_1']) ?>" class="btn btn-light btn-icon-split">
								<span class="icon text-gray-600">
									<i class="fas fa-file-pdf"></i>
								</span>
								<span class="text"><?= $maintenanceAct['path_photo_1'] ?></span>
							</a>
						<?php } else { ?>
							<a data-fancybox="gallery" href="<?= base_url('uploads/' . $maintenanceAct['path_photo_1']) ?>">
								<img src="<?= base_url('uploads/' . $maintenanceAct['path_photo_1']) ?>" style="width:300px;height:300px;object-fit:cover;">
							</a><br>
							Click image to zoom <i class="fas fa-search-plus"></i>
						<?php } ?>	
					</div>
					<div class="col-md-6">
						<h6 class="mb-2 font-weight-bold text-primary">Evidence 2</h6>
						<?php if (pathinfo($maintenanceAct['path_photo_2'], PATHINFO_EXTENSION) == 'pdf') { ?>
							<a href="<?= base_url('uploads/' . $maintenanceAct['path_photo_2']) ?>" class="btn btn-light btn-icon-split">
								<span class="icon text-gray-600">
									<i class="fas fa-file-pdf"></i>
								</span>
								<span class="text"><?= $maintenanceAct['path_photo_2'] ?></span>
							</a>
						<?php } else { ?>
							<a data-fancybox="gallery" href="<?= base_url('uploads/' . $maintenanceAct['path_photo_2']) ?>">
								<img src="<?= base_url('uploads/' . $maintenanceAct['path_photo_2']) ?>" style="width:300px;height:300px;object-fit:cover;">
							</a><br>
							Click image to zoom <i class="fas fa-search-plus"></i>
						<?php } ?>	
					</div>
				</div>

				<div class="row mb-3 align-items-center">
					<div class="col-md-6">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Apakah problem bisa langsung di perbaiki? <span class="text-danger small">*Required</span></label>
							<select id="note" class="form-control" name="note">
								<option value="Y">Ya</option>
								<option value="N">Ya, butuh sparepart/tools</option>
								<option value="P">Ya, butuh sparepart dan tidak ada</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="mt-3">
					<!-- <button type="submit" name="status" value="done" class="btn btn-success btn-lg mr-2">
						<i class="fas fa-check"></i>
						Done
					</button> -->
					<button type="submit" name="status" value="process" class="btn btn-warning btn-lg mr-2">
						<i class="fas fa-cogs"></i>
						Process
					</button>
					<!-- <button type="submit" name="status" value="pending" class="btn btn-secondary btn-lg mr-2">
						<i class="fas fa-clock"></i>
						Pending
					</button> -->
				</div>
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