<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Detail Request: #<?= $vehicle['id_req'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('rental_pic/process/' . $vehicle['id_req']) ?>" method="post">
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
						</div>
					</div>

					<div class="row mb-3 align-items-center">
						<div class="col-md-6">
							<h6 class="mb-2 font-weight-bold text-primary">SIM/SIO</h6>
							<?php if (pathinfo($vehicle['path_photo'], PATHINFO_EXTENSION) == 'pdf') { ?>
								<a href="<?= base_url('uploads/' . $vehicle['path_photo']) ?>" class="btn btn-light btn-icon-split">
									<span class="icon text-gray-600">
										<i class="fas fa-file-pdf"></i>
									</span>
									<span class="text"><?= $vehicle['path_photo'] ?></span>
								</a>
							<?php } else { ?>
								<a data-fancybox="gallery" href="<?= base_url('uploads/' . $vehicle['path_photo']) ?>">
									<img src="<?= base_url('uploads/' . $vehicle['path_photo']) ?>" style="width:100%;max-width:300px">
								</a><br>
								Click image to zoom <i class="fas fa-search-plus"></i>
							<?php } ?>	
						</div>
						<div class="col-md-6">
							<?php if (in_array($vehicle['status'], ["5"])) { ?>
								<h6 class="mb-2 font-weight-bold text-primary">Vehicle Usage Report</h6>
								<?php if (pathinfo($vehicle['path_return'], PATHINFO_EXTENSION) == 'pdf') { ?>
									<a href="<?= base_url('uploads/' . $vehicle['path_return']) ?>" class="btn btn-light btn-icon-split">
										<span class="icon text-gray-600">
											<i class="fas fa-file-pdf"></i>
										</span>
										<span class="text"><?= $vehicle['path_return'] ?></span>
									</a>
								<?php } else { ?>
									<a data-fancybox="gallery" href="<?= base_url('uploads/' . $vehicle['path_return']) ?>">
										<img src="<?= base_url('uploads/' . $vehicle['path_return']) ?>" style="width:100%;max-width:300px">
									</a><br>
									Click image to zoom <i class="fas fa-search-plus"></i>
								<?php } ?>	
							<?php } ?>
						</div>
					</div>		

				</div>
				<br/>

				<?php if (in_array($vehicle['status'], ["2"])) { ?>
					<button type="submit" name="action_type" value="approve" class="btn btn-success"><i class="fas fa-check"></i> Approve</button>
					<button type="submit" name="action_type" value="reject" class="btn btn-danger"><i class="fas fa-ban"></i> Reject</button>
					<div class="form-group">
						<br/>

						<?php if ($vehicle['driver_yn_code'] == "Y") { ?>
						<div class="row">
							<div class="col-md-6">
								<label for="driver_name" class="form-label font-weight-bold">Driver Name</label>
								<input type="text" id="driver_name" class="form-control <?= (form_error('driver_name') ? 'is-invalid' : '') ?>" name="driver_name" value="<?= $vehicle['driver_name'] ?>">
								<div class="invalid-feedback">
									<?= form_error('driver_name'); ?>
								</div>
							</div>	
							<div class="col-md-6">
								<label for="vehicle_name" class="form-label font-weight-bold">Vehicle Name</label>
								<input type="text" id="vehicle_name" class="form-control <?= (form_error('vehicle_name') ? 'is-invalid' : '') ?>" name="vehicle_name" value="<?= $vehicle['vehicle_name'] ?>">
								<div class="invalid-feedback">
									<?= form_error('vehicle_name'); ?>
								</div>
							</div>
						</div>
						<?php } ?>

						<label class="mb-1 font-weight-bold">Note</label>
						<textarea name="pic_desc" placeholder="" class="form-control <?= (form_error('pic_desc') ? "is-invalid" : "") ?>" rows="6"><?= set_value('pic_desc'); ?></textarea>
						<div class="invalid-feedback">
							<?= form_error('pic_desc'); ?>
						</div>
						<label class="mb-1 font-weight-bold">Berikan nilai '-'jika tanpa driver</label>
					</div>
				<?php } else { ?>

					<?php if ($vehicle['driver_name'] != "") { ?>
						<div class="row">
							<div class="col-md-6">
								<label for="driver_name" class="form-label font-weight-bold">Driver Name</label>
								<input type="text" id="driver_name" class="form-control <?= (form_error('driver_name') ? 'is-invalid' : '') ?>" name="driver_name" value="<?= $vehicle['driver_name'] ?>" disabled>
								<div class="invalid-feedback">
									<?= form_error('driver_name'); ?>
								</div>
							</div>	
							<div class="col-md-6">
								<label for="vehicle_name" class="form-label font-weight-bold">Vehicle Name</label>
								<input type="text" id="vehicle_name" class="form-control <?= (form_error('vehicle_name') ? 'is-invalid' : '') ?>" name="vehicle_name" value="<?= $vehicle['vehicle_name'] ?>" disabled>
								<div class="invalid-feedback">
									<?= form_error('vehicle_name'); ?>
								</div>
							</div>
						</div>
					<?php } ?>

					<div class="form-group">
						<label class="mb-1 font-weight-bold">Note</label>
						<textarea id="pic_desc" class="form-control <?= (form_error('pic_desc') ? 'is-invalid' : '') ?>" name="pic_desc" readonly><?= $vehicle['pic_desc'] ?></textarea>
					</div>					
				<?php } ?>

			</form>
		</div>
	</div>
</div>