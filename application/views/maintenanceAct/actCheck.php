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
				url: "<?= base_url('maintenanceAct/getMachineById'); ?>",
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

<script src="<?= base_url('../../../assets/js/html5-qrcode.min.js') ?>"></script>
<script>
let html5QrCode;
let scanning = false;

$(document).on('click', '#btnScan', function () {
    if (scanning) return;
    scanning = true;

    $('#reader').show();
    html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 250, height: 150 }, // lebih cocok untuk barcode
            formatsToSupport: [
                Html5QrcodeSupportedFormats.CODE_128,
                Html5QrcodeSupportedFormats.CODE_39,
                Html5QrcodeSupportedFormats.EAN_13,
                Html5QrcodeSupportedFormats.EAN_8,
                Html5QrcodeSupportedFormats.UPC_A,
                Html5QrcodeSupportedFormats.UPC_E
            ]
        },
        function(decodedText) {
				let result = decodedText.toUpperCase();
            $('#machine_idScan').val(result);

            let beep = document.getElementById('beepSound');
            beep.currentTime = 0;
            beep.play();

				$('#machine_idScan').val(decodedText);
            checkMachine();

				function checkMachine() {
					let machineId = $("#machine_idScan").val();
					if (machineId.trim() === "") return;

					$.ajax({
						url: "<?= base_url('maintenance_act/getMachineById'); ?>",
						type: "POST",
						data: { machine_idScan: machineId },
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

            html5QrCode.stop().then(() => {
                $('#reader').hide().html('');
                scanning = false;
            });
        }
    );
});
</script>

<!-- Ini untuk PDA -->
 <script>
	$(document).ready(function () {

		$('#machine_idScan_input').on('keydown', function (e) {

			if (e.key === 'Enter') {
				e.preventDefault();

				let machineId = $(this).val().trim().toUpperCase();
				if (!machineId) return;

				$('#machine_idScan').val(machineId);

				$('#machine_idScan_display').val('*'.repeat(machineId.length));

				$(this).val('');

				processScan(machineId);
			}
		});

		function focusScanner() {
			$('#machine_idScan_input').focus();
		}

		$('#btnFocusScan').on('click', function () {
			focusScanner();
		});

		window.focusScanner = focusScanner;

	});

	function processScan(machineId) {

		let beep = document.getElementById('beepSound');
		beep.currentTime = 0;
		beep.play();

		$.ajax({
			url: "<?= base_url('maintenance_act/getMachineById'); ?>",
			type: "POST",
			data: { machine_idScan: machineId },
			dataType: "json",
			success: function (res) {
				if (res.success) {
					$('#machine_name').val(res.data.machine_name);
				} else {
					$('#machine_name').val('');
					alert('Machine ID tidak ditemukan!');
				}
			},
			error: function () {
				alert('Terjadi kesalahan saat mengambil data.');
			}
		});
	}
</script>
<!-- PDA -->

<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3">Respone Work Order Management.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Respone Work Order Management</h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('maintenance_act/actCheckSubmit/'.$maintenanceAct['wo_id']) ?>" enctype="multipart/form-data">

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

				<div class="row mb-3">
					<div class="col-md-2">
						<div class="form-group">
							<label class="mb-1 d-block">&nbsp;</label> 
							<!-- <button type="button" id="btnScan" class="btn btn-primary btn-block">
								Scan
							</button> -->
							<button type="button" id="btnFocusScan" class="btn btn-primary btn-block">
								Focus Scan
							</button>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div id="reader" style="width:300px; display:none;"></div>
							</div>
						</div>
						<audio id="beepSound" preload="auto">
							<source src="<?= base_url('../../../assets/sound/beepSound.mp3') ?>" type="audio/mpeg">
						</audio>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Machine ID</label>

							<input type="text"
								id="machine_idScan_input"
								class="form-control"
								autofocus
								style="opacity:100; position:absolute; pointer-events:none;">

							<input type="text"
								id="machine_idScan_display"
								class="form-control"
								placeholder="Scan Machine ID"
								readonly>

							<input type="hidden"
								id="machine_idScan"
								name="machine_idScan">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Machine Name</label>
							<input type="text" id="machine_name" name="machine_name" class="form-control" ... readonly>
						</div>
					</div>
				</div>
				
				
				<div class="mt-3">
					<button type="submit" name="status" value="process" class="btn btn-warning btn-lg mr-2">
						<i class="fas fa-cogs"></i>
						Process
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');

	if (flashData) {
		let iconType = flashData.includes('Berhasil') ? 'success' : 'error';
		let titleText = flashData.includes('Berhasil') ? 'Success!' : 'Oops...';

		Swal.fire({
			icon: iconType,
			title: titleText,
			text: flashData,
			footer: ''
		});
	}

	$('textarea').keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			var s = $(this).val();
			$(this).val(s + "\n");
		}
	});
</script>