<script language="javascript" type="text/javascript">
	document.addEventListener('DOMContentLoaded', (event) => {
        const dateInput = document.querySelector('input[name="return_date"]');

        if (dateInput) {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0'); // getMonth() dimulai dari 0, jadi perlu +1. padStart untuk menambahkan nol di depan jika digit tunggal.
            const day = today.getDate().toString().padStart(2, '0');

				const formattedDate = `${year}-${month}-${day}`;

            dateInput.value = formattedDate;
        }
    });
</script>


<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Detail Request: #<?= $vehicle['id_req'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('rental/returned/' . $vehicle['id_req']) ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="card mb-3">
						<div class="card-body">
							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="user" class="form-label">User</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="user_req" 
										class="form-control <?= (form_error('user_req') ? 'is-invalid' : '') ?>" 
										name="user_req" 
										value="<?= $vehicle['user_req'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('user_req'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="computer_name" class="form-label">Request Date</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="req_date" 
										class="form-control <?= (form_error('req_date') ? 'is-invalid' : '') ?>" 
										name="req_date" 
										value="<?= $vehicle['req_date'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('req_date'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="dept" class="form-label">Dept</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="dept" 
										class="form-control <?= (form_error('dept') ? 'is-invalid' : '') ?>" 
										name="dept" 
										value="<?= $vehicle['dept'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('dept'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="driver_yn" class="form-label">Driver Y/N</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="driver_yn" 
										class="form-control <?= (form_error('driver_yn') ? 'is-invalid' : '') ?>" 
										name="driver_yn" 
										value="<?= $vehicle['driver_yn'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('driver_yn'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="target_dept" class="form-label">Request to</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="target_dept" 
										class="form-control <?= (form_error('target_dept') ? 'is-invalid' : '') ?>" 
										name="target_dept" 
										value="<?= $vehicle['target_dept'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('target_dept'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="status" class="form-label">Status</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="status" 
										class="form-control <?= (form_error('status') ? 'is-invalid' : '') ?>" 
										name="status" 
										value="<?= $vehicle['status'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('status'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="vehicle" class="form-label">Vehicle</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="vehicle" 
										class="form-control <?= (form_error('vehicle') ? 'is-invalid' : '') ?>" 
										name="vehicle" 
										value="<?= $vehicle['vehicle'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('vehicle'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="desc" class="form-label">Desc</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="desc" 
										class="form-control <?= (form_error('desc') ? 'is-invalid' : '') ?>" 
										name="desc" 
										value="<?= $vehicle['desc'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('desc'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="user_spv" class="form-label">Supervisor</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="user_spv" 
										class="form-control <?= (form_error('user_spv') ? 'is-invalid' : '') ?>" 
										name="user_spv" 
										value="<?= $vehicle['user_spv'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('user_spv'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="spv_desc" class="form-label">Spv Desc</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="spv_desc" 
										class="form-control <?= (form_error('spv_desc') ? 'is-invalid' : '') ?>" 
										name="spv_desc" 
										value="<?= $vehicle['spv_desc'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('spv_desc'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="driver_name" class="form-label">Driver Name</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="driver_name" 
										class="form-control <?= (form_error('driver_name') ? 'is-invalid' : '') ?>" 
										name="driver_name" 
										value="<?= $vehicle['driver_name'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('driver_name'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="vehicle_name" class="form-label">Vehicle Name</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="vehicle_name" 
										class="form-control <?= (form_error('vehicle_name') ? 'is-invalid' : '') ?>" 
										name="vehicle_name" 
										value="<?= $vehicle['vehicle_name'] ?>" disabled>
									<div class="invalid-feedback">
										<?= form_error('vehicle_name'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="driver_name" class="form-label">Note</label>
								</div>
								<div class="col-md-10">
									<textarea id="pic_desc" class="form-control <?= (form_error('pic_desc') ? 'is-invalid' : '') ?>" name="pic_desc" readonly><?= $vehicle['pic_desc'] ?></textarea>
								</div>
							</div>

						</div>
					</div>

					<label for="return_date" class="form-label font-weight-bold">Return Date</label>
					<div class="col-md-4" style="padding-left: 0; margin-bottom: 15px;">
						<input type="date" class="form-control" <?= (form_error('return_date') ? 'is-invalid' : '') ?> name="return_date" placeholder="Due date" value="<?= set_value('return_date'); ?>" required disabled>
					</div>

					<div class="form-group">
						<label class="mb-1 font-weight-bold">Keterangan</label>
						<textarea name="return_desc" placeholder="" class="form-control <?= (form_error('return_desc') ? "is-invalid" : "") ?>" rows="6"><?= set_value('return_desc'); ?></textarea>
						<div class="invalid-feedback">
							<?= form_error('return_desc'); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="mb-1 font-weight-bold">Vehicle Usage Report <span class="text-danger small">*Required</span></label> </br>
						<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, png, or pdf.</p>
						<input type="file" name="path_return" size="20" class="<?= (form_error('path_return') ? "is-invalid" : "") ?>">
						<div class="invalid-feedback">
							<?= form_error('path_return'); ?>
						</div>
						<div class="text-danger pt-1"><?= $error; ?></div>
					</div>

				</div>
				<br/>
				<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Submit</button>

			</form>
		</div>
	</div>
</div>