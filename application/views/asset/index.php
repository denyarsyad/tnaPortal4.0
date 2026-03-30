<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<a href="#modal-fade" title="Tambah <?= $title; ?>" class="btn btn-primary mb-4" data-toggle="modal">
				<i class="fa fa-plus"></i> Tambah <?= $title; ?>
			</a>
			<!-- <a href="<?= base_url('subdepartemen') ?>" title="Tambah Sub Departemen" class="btn btn-info mb-4">
				<i class="fa fa-building"></i> Sub Departemen
			</a> -->
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th style="white-space: nowrap;">#</th>
							<th style="white-space: nowrap;">ID Asset</th>
							<th>Category</th>
							<th>User</th>
							<th>Name</th>
							<th>Manufact</th>
							<th style="white-space: nowrap;">Device Model</th>
							<th>SN</th>
							<th>Year</th>
							<th>Desc</th>
							<th style="white-space: nowrap;">OS Name</th>
							<th>Status</th>
							<th>Loc</th>
							<th>Priority</th>
							<th>Act</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($assets as $row) { ?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $row->id_asset ?></td>
								<td><?= $row->category ?></td>
								<td><?= $row->id_user ?></td>
								<td><?= $row->computer_name ?></td>
								<td><?= $row->manufacturing ?></td>
								<td><?= $row->device_model ?></td>
								<td><?= $row->serial_number ?></td>
								<td><?= $row->year ?></td>
								<td><?= $row->desc ?></td>
								<td><?= $row->os_name ?></td>
								<td><?= $row->status ?></td>
								<td><?= $row->location ?></td>
								<td><?= $row->priority ?></td>
								<td>
									<a href="<?= site_url('asset/edit/' . $row->id_asset) ?>" data-toggle="tooltip" title="Edit Asset" class="btn btn-primary btn-circle btn-sm mr-2"><i class="fa fa-edit"></i>
									</a>
									<a href="<?= site_url('asset/hapus/' . $row->id_asset) ?>" data-toggle="tooltip" title="Hapus Asset" class="btn btn-danger btn-circle btn-sm hapus"><i class="fas fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-custom-width">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="m-0 font-weight-bold text-gray-800">Tambah <?= $title; ?></h6>
			</div>
			<div class="modal-body">
				<form id="form-validation" action="<?= site_url('asset/tambah') ?>" method="POST">
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
												name="category">
											<option value="">-- Pilih Category --</option>
											<option value="PC" <?= set_select('category', 'PC') ?>>PC</option>
											<option value="LAPTOP" <?= set_select('category', 'LAPTOP') ?>>Laptop</option>
											<option value="NETWORK" <?= set_select('category', 'NETWORK') ?>>Network</option>
											<option value="PRINTER" <?= set_select('category', 'PRINTER') ?>>Printer</option>
											<option value="SERVER" <?= set_select('category', 'SERVER') ?>>Server</option>
											<option value="LICENSE" <?= set_select('category', 'LICENSE') ?>>License</option>
										</select>
										<div class="invalid-feedback">
											<?= form_error('category'); ?>
										</div>
									</div>

									<div class="col-md-2">
										<label for="computer_name" class="form-label">User</label>
									</div>
									<div class="col-md-4">
										<?= form_dropdown('id_pegawai', $dd_pegawai, set_value('id_pegawai'), ' id="id_pegawai" class="form-control select2' . (form_error('id_pegawai') ? "is-invalid" : "") . ' " style="width: 100% !important;"'); ?>
										<div class="invalid-feedback">
											<?= form_error('id_pegawai'); ?>
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
											placeholder="Masukkan Manufacturing">
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
											placeholder="Masukkan Computer Name">
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
											placeholder="Masukkan Device Model">
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
											placeholder="Masukkan Serial Number">
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
												<option value="<?= $i ?>" <?= set_select('year', $i) ?>><?= $i ?></option>
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
											placeholder="Masukkan OS Name">
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
											<option value="NORMAL" <?= set_select('status', 'NORMAL') ?>>Normal</option>
											<option value="READY" <?= set_select('status', 'READY') ?>>Ready to Dispose</option>
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
											<option value="CRITICAL" <?= set_select('priority', 'CRITICAL') ?>>Critical</option>
											<option value="NON CRITICAL" <?= set_select('priority', 'NON CRITICAL') ?>>Non Critical</option>
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
											placeholder="Masukkan Location">
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
											placeholder="Masukkan Description">
										<div class="invalid-feedback">
											<?= form_error('desc'); ?>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire(
			'Sukses!',
			'Asset Berhasil ' + flashData,
			'success'
		)
	}

	$('.hapus').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apa kamu yakin?',
			text: "Asset akan dihapus",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Delete'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});
</script>
