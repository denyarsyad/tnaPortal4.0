<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Asset: #<?= $asset['id_asset'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('asset/update/' . $asset['id_aset']) ?>" method="post">
				<div class="form-group">
					<div class="card mb-3">
						<div class="card-body">
							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="category" class="form-label">Category</label>
								</div>
								<div class="col-md-4">
									<select id="category" 
											class="form-control <?= (form_error('category') ? 'is-invalid' : '') ?>" 
											name="category"
											disabled>
										<option value="">-- Pilih Category --</option>
										<option value="PC" <?= set_select('category', 'PC', $asset['category'] == 'PC') ?>>PC</option>
										<option value="LAPTOP" <?= set_select('category', 'LAPTOP', $asset['category'] == 'LAPTOP') ?>>Laptop</option>
										<option value="NETWORK" <?= set_select('category', 'NETWORK', $asset['category'] == 'NETWORK') ?>>Network</option>
										<option value="PRINTER" <?= set_select('category', 'PRINTER', $asset['category'] == 'PRINTER') ?>>Printer</option>
										<option value="SERVER" <?= set_select('category', 'SERVER', $asset['category'] == 'SERVER') ?>>Server</option>
										<option value="LICENSE" <?= set_select('category', 'LICENSE', $asset['category'] == 'LICENSE') ?>>License</option>
									</select>
									<div class="invalid-feedback">
										<?= form_error('category'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="computer_name" class="form-label">User</label>
								</div>
								<div class="col-md-4">
									<?= form_dropdown('id_user', $dd_user,  $asset['id_user'], ' id="id_user" class="form-control ' . (form_error('id_user') ? "is-invalid" : "") . ' " disabled'); ?>
									<div class="invalid-feedback">
										<?= form_error('id_user'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="manufacturing" class="form-label">Manufacturing</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="manufacturing" 
										class="form-control <?= (form_error('manufacturing') ? 'is-invalid' : '') ?>" 
										name="manufacturing" 
										value="<?= $asset['manufacturing'] ?>">
									<div class="invalid-feedback">
										<?= form_error('manufacturing'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="computer_name" class="form-label">Computer Name</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="computer_name" 
										class="form-control <?= (form_error('computer_name') ? 'is-invalid' : '') ?>" 
										name="computer_name" 
										value="<?= $asset['computer_name'] ?>">
									<div class="invalid-feedback">
										<?= form_error('computer_name'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="device_model" class="form-label">Device Model</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="device_model" 
										class="form-control <?= (form_error('device_model') ? 'is-invalid' : '') ?>" 
										name="device_model" 
										value="<?= $asset['device_model'] ?>">
									<div class="invalid-feedback">
										<?= form_error('device_model'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="serial_number" class="form-label">Serial Number</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="serial_number" 
										class="form-control <?= (form_error('serial_number') ? 'is-invalid' : '') ?>" 
										name="serial_number" 
										value="<?= $asset['serial_number'] ?>">
									<div class="invalid-feedback">
										<?= form_error('serial_number'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="year" class="form-label">Year</label>
								</div>
								<div class="col-md-4">
									<select id="year"
										class="form-control <?= (form_error('year') ? 'is-invalid' : '') ?>" 
										name="year">
										<option value="">-- Pilih Tahun --</option>
										<?php 
											$tahunSekarang = date('Y');
											for ($i = $tahunSekarang; $i >= $tahunSekarang - 20; $i--): ?>
											<option value="<?= $i ?>" <?= set_select('year', $i, $asset['year'] == $i) ?>><?= $i ?></option>
										<?php endfor; ?>
									</select>
									<div class="invalid-feedback">
										<?= form_error('year'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="os_name" class="form-label">OS Name</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="os_name" 
										class="form-control <?= (form_error('os_name') ? 'is-invalid' : '') ?>" 
										name="os_name" 
										value="<?= $asset['os_name'] ?>">
									<div class="invalid-feedback">
										<?= form_error('os_name'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="status" class="form-label">Status</label>
								</div>
								<div class="col-md-4">
									<select id="status" 
											class="form-control <?= (form_error('status') ? 'is-invalid' : '') ?>" 
											name="status">
										<option value="">-- Pilih Status --</option>
										<option value="NORMAL" <?= set_select('status', 'NORMAL', $asset['status'] == 'NORMAL') ?>>Normal</option>
										<option value="READY" <?= set_select('status', 'READY', $asset['status'] == 'READY') ?>>Ready to Dispose</option>
									</select>
									<div class="invalid-feedback">
										<?= form_error('status'); ?>
									</div>
								</div>

								<div class="col-md-2">
									<label for="priority" class="form-label">Priority</label>
								</div>
								<div class="col-md-4">
									<select id="priority" 
											class="form-control <?= (form_error('priority') ? 'is-invalid' : '') ?>" 
											name="priority">
										<option value="">-- Pilih Priority --</option>
										<option value="CRITICAL" <?= set_select('priority', 'CRITICAL', $asset['priority'] == 'CRITICAL') ?>>Critical</option>
										<option value="NON CRITICAL" <?= set_select('priority', 'NON CRITICAL', $asset['priority'] == 'NON CRITICAL') ?>>Non Critical</option>
									</select>
									<div class="invalid-feedback">
										<?= form_error('priority'); ?>
									</div>
								</div>
							</div>

							<div class="row mb-3 align-items-center">
								<div class="col-md-2">
									<label for="location" class="form-label">Location</label>
								</div>
								<div class="col-md-4">
									<input type="text" 
										id="location" 
										class="form-control <?= (form_error('location') ? 'is-invalid' : '') ?>" 
										name="location" 
										value="<?= $asset['location'] ?>">
									<div class="invalid-feedback">
										<?= form_error('location'); ?>
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
										value="<?= $asset['desc'] ?>">
									<div class="invalid-feedback">
										<?= form_error('desc'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('asset') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>