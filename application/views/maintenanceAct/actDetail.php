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

        if (dateInput) {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0'); 
            const day = today.getDate().toString().padStart(2, '0');
			const dayPlus = new Date(today);
			dayPlus.setDate(today.getDate() + 1);
			const tomorrow = String(dayPlus.getDate()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}`;
            dateInput.value = formattedDate;
        }

    });

	document.addEventListener('DOMContentLoaded', (event) => {
		const timeInput = document.querySelector('input[name="req_time"]');
		if (timeInput) {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, '0');
			const minutes = String(now.getMinutes()).padStart(2, '0');
			const seconds = String(now.getSeconds()).padStart(2, '0');
			const formattedTime = `${hours}:${minutes}:${seconds}`;
			timeInput.value = formattedTime;
		}
	});

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

<?php if ($this->session->flashdata('error')): ?>
<script>
    alert("<?= $this->session->flashdata('error'); ?>");
</script>
<?php endif; ?>


<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3">Respone Downtime</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Respone Downtime</h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('maintenance_act/' . ($this->session->userdata('level') === 'MGR' ? 'actNoted' : 'actUpdate') . '/' . $maintenanceAct['wo_id']) ?>" enctype="multipart/form-data">

				<input class="form-control" name="nama" value="<?= $profile['nama'] ?>" hidden>
				<input class="form-control" name="email" value="<?= $profile['email'] ?>" hidden>

				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">WO ID</label>
							<input type="text" class="form-control <?= (form_error('wo_id') ? 'is-invalid' : '') ?>" name="wo_id" value="<?= $maintenanceAct['wo_id'] ?>"  readonly>
							<div class="invalid-feedback">
								<?= form_error('wo_id'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-4" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Machine ID</label>
							<input type="text" id="machine_id" class="form-control <?= (form_error('machine_id') ? 'is-invalid' : '') ?>" name="machine_id" value="<?= $maintenanceAct['machine_id'] ?>" style="text-transform: uppercase;" readonly>
							<div class="invalid-feedback">
								<?= form_error('machine_id'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-4" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Machine Name</label>
							<input type="text" id="machine_name" class="form-control <?= (form_error('machine_name') ? 'is-invalid' : '') ?>" name="machine_name" value="<?= $maintenanceAct['machine_name'] ?>" readonly>
							<div class="invalid-feedback">
								<?= form_error('machine_name'); ?>
							</div>
						</div>
					</div>
				</div>	

				<?php if (!empty($maintenanceAct['mtc_message'])): ?>
					<div class="form-group">
						<label class="mb-1 font-weight-bold">Spare Part <span class="text-danger small">*Required</span></label>
						<textarea id="mtc_message" class="form-control <?= (form_error('mtc_message') ? 'is-invalid' : '') ?>" name="mtc_message" readonly><?= $maintenanceAct['mtc_message'] ?></textarea>
						<div class="invalid-feedback">
							<?= form_error('mtc_message'); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($maintenanceAct['status'] == 7): ?>
					<div class="form-group">
						<label class="mb-1 font-weight-bold">Changed to Machine <span class="text-danger small">*Required</span></label>
						<textarea id="change_mc" class="form-control <?= (form_error('change_mc') ? 'is-invalid' : '') ?>" name="change_mc" readonly><?= $maintenanceAct['change_mc'] ?></textarea>
						<div class="invalid-feedback">
							<?= form_error('change_mc'); ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Root Cause <span class="text-danger small">*Required</span></label>
					<textarea id="root_cause" class="form-control <?= (form_error('root_cause') ? 'is-invalid' : '') ?>" name="root_cause" <?= !in_array($this->session->userdata('level'), ['SPVU']) ? 'readonly' : '' ?>><?= $maintenanceAct['root_cause'] ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('root_cause'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Temporary Action <span class="text-danger small">*Required</span></label>
					<textarea id="temp_act" class="form-control <?= (form_error('temp_act') ? 'is-invalid' : '') ?>" name="temp_act" <?= !in_array($this->session->userdata('level'), ['SPVU']) ? 'readonly' : '' ?>><?= $maintenanceAct['temp_act'] ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('temp_act'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Preventive Action <span class="text-danger small">*Required</span></label>
					<textarea id="prev_act" class="form-control <?= (form_error('prev_act') ? 'is-invalid' : '') ?>" name="prev_act" <?= !in_array($this->session->userdata('level'), ['SPVU']) ? 'readonly' : '' ?>><?= $maintenanceAct['prev_act'] ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('prev_act'); ?>
					</div>
				</div>

				<?php 
					$userLevel = $this->session->userdata('level');
					$mgrNoteValue = isset($maintenanceAct['mgr_note']) ? $maintenanceAct['mgr_note'] : '';
					if ($userLevel === 'MGR' || !empty($mgrNoteValue)): 
				?>
					<div class="form-group">
						<label class="mb-1 font-weight-bold">
							<i class="fas fa-sticky-note"></i> Note 
							<?php if ($userLevel === 'MGR'): ?>
								<span class="text-danger small">*Required</span>
							<?php endif; ?>
						</label>

						<textarea id="mgr_note" 
							class="form-control <?= (form_error('mgr_note') ? 'is-invalid' : '') ?>" 
							name="mgr_note"
							<?= ($userLevel !== 'MGR') ? 'readonly' : '' ?>><?= $mgrNoteValue ?></textarea>

						<div class="invalid-feedback">
							<?= form_error('mgr_note'); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($this->session->userdata('level') === 'SPVU'): ?>
					<div class="mt-3">
						<button type="submit" class="btn btn-success btn-lg mr-2">
							<i class="fas fa-edit"></i>
							Update
						</button>
					</div>
				<?php elseif ($this->session->userdata('level') === 'MGR'): ?>	
					<div class="mt-3">
						<button type="submit" class="btn btn-primary btn-lg mr-2">
							<i class="fas fa-sticky-note"></i>
							Add Note
						</button>
					</div>
				<?php endif; ?>

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