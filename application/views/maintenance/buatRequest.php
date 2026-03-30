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
            $('#machine_id').val(result);

            let beep = document.getElementById('beepSound');
            beep.currentTime = 0;
            beep.play();

				$('#machine_id').val(decodedText);
            checkMachine();

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

            html5QrCode.stop().then(() => {
                $('#reader').hide().html('');
                scanning = false;
            });
        }
    );
});
</script>

<!-- ini untuk PDA -->
<script>
$('#machine_id').on('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        checkMachine();
    }
});

function checkMachine() {
    let machineId = $("#machine_id").val().trim().toUpperCase();
    if (machineId === "") return;

    $("#machine_id").val(machineId); // rapihin

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

    // siap scan berikutnya
    $("#machine_id").val("").focus();
}
</script>
<!-- PDA -->


<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3">Kirim Data Work Order Management.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Request Work Order Management</h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('maintenance/submit') ?>" enctype="multipart/form-data">

				<input class="form-control" name="nama" value="<?= $profile['nama'] ?>" hidden>
				<input class="form-control" name="email" value="<?= $profile['email'] ?>" hidden>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">To Dept</label>
							<?= form_dropdown('id_dept', $dd_dept, set_value('id_dept', 3), 'id="id_dept" class="form-control" readonly'); ?>
							<div class="invalid-feedback">
								<?= form_error('id_dept'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-3" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Current Date</label>
							<input type="date" class="form-control <?= (form_error('req_date') ? 'is-invalid' : '') ?>" name="req_date" placeholder="Due date" value="<?= set_value('req_date'); ?>" readonly>
							<div class="invalid-feedback">
								<?= form_error('req_date'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-3" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Current Time</label>
							<input type="time" class="form-control <?= (form_error('req_time') ? 'is-invalid' : '') ?>" name="req_time" value="<?= set_value('req_time'); ?>" readonly>
							<div class="invalid-feedback">
								<?= form_error('req_time'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Note<span class="text-danger small">*Required</span></label>
							<select id="note" 
											class="form-control <?= (form_error('note') ? 'is-invalid' : '') ?>" 
											name="note">
										<option value="">-- Pilih Keterangan --</option>
										<option value="Y" <?= set_select('note', 'Mesin Stop', $vehicle['note'] == 'Mesin Stop') ?>>Mesin Stop</option>
										<option value="N" <?= set_select('note', 'Mesin Menyala', $vehicle['note'] == 'Mesin Menyala') ?>>Mesin Menyala</option>
							</select>
							<div class="invalid-feedback">
								<?= form_error('note'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-3" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Machine ID<span class="text-danger small">*Required</span></label>
							<input type="text" id="machine_id" autofocus class="form-control <?= (form_error('machine_id') ? 'is-invalid' : '') ?>" name="machine_id" value="<?= set_value('machine_id'); ?>" style="text-transform: uppercase;" oinput="this.value = this.value.toUpperCase();" require>
							<div class="invalid-feedback">
								<?= form_error('machine_id'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-4" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Machine Name</label>
							<input type="text" id="machine_name" class="form-control <?= (form_error('machine_name') ? 'is-invalid' : '') ?>" name="machine_name" value="<?= set_value('machine_name'); ?>" readonly>
							<div class="invalid-feedback">
								<?= form_error('machine_name'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-2 pt-4">
						<button type="button" id="btnScan" class="btn btn-primary btn-block">
							Scan
						</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div id="reader" style="width:300px; display:none;"></div>
					</div>
				</div>
				<audio id="beepSound" preload="auto">
					<source src="<?= base_url('../../../assets/sound/beepSound.mp3') ?>" type="audio/mpeg">
				</audio>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Desc</label>
					<textarea name="req_message" placeholder="" class="form-control <?= (form_error('req_message') ? "is-invalid" : "") ?>" rows="6"><?= set_value('req_message'); ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('req_message'); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Upload 1 <span class="text-info small">*Optional</span></label> </br>
							<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, jpeg, png, or pdf.</p>
							<input type="file" name="path_photo_1" size="20" class="<?= (form_error('path_photo_1') ? "is-invalid" : "") ?>">
							<div class="invalid-feedback">
								<?= form_error('path_photo_1'); ?>
							</div>
							<div class="text-danger pt-1"><?= $error; ?></div>
						</div>
					</div>
					<div class="col-sm-6" >
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Upload 2 <span class="text-info small">*Optional</span></label> </br>
							<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, jpeg, png, or pdf.</p>
							<input type="file" name="path_photo_2" size="20" class="<?= (form_error('path_photo_2') ? "is-invalid" : "") ?>">
							<div class="invalid-feedback">
								<?= form_error('path_photo_2'); ?>
							</div>
							<div class="text-danger pt-1"><?= $error; ?></div>
						</div>
					</div>
				</div>

				</br>
				</br>
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