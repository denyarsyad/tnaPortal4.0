<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-4">Daftar semua Request Vehicle yang sudah kamu submit.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<!-- Button Input -->
	<a href="<?= site_url('rental/buatRequest') ?>" class="nav-link" style="padding-left: 0px;">
		<div class="btn btn-success btn-lg shadow-sm btn-left">
			<i class="fas fa-plus text-white" style="font-size: 15px"></i>
			<span class="text" style="font-size: 15px">Request</span>
		</div>
	</a>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<!-- <div class="card-header font-weight-bold text-primary d-flex justify-content-between">
			<a href="<?= site_url('rental/export_excel'); ?>" 
				class="btn btn-success btn-sm ml-auto">
				<i class="fas fa-file-excel"></i> Export Excel
			</a>
		</div> -->
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>ID Req</th>
							<th>Req Date</th>
							<th>Finish Date</th>
							<th>Vehicle</th>
							<th>Driver Y/N</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($rental as $row) { ?>
							<tr>
								<td><?= $no ?></td>

								<?php if (in_array($row->status, ["3", "4"])) { ?>
									<td><a href="<?= site_url('rental/return/' . $row->id_req) ?>" class="font-weight-bold"><?= $row->id_req ?></a></td>
								<?php } else { ?>
									<td><a href="<?= site_url('rental/detail/' . $row->id_req) ?>" class="font-weight-bold"><?= $row->id_req ?></a></td>
								<?php } ?>
								<td><?= $row->req_date ?></td>
								<td><?= $row->end_date ?></td>
								<td><?= $row->vehicle_name ?></td>
								<td><?= $row->driver_yn ?></td>
								<?php if ($row->status == "0") { ?>
									<td>
										<strong style="color: #B81414;">Request Rejected</strong>
									</td>
								<?php } else if ($row->status == "1") { ?>
									<td>
										<strong style="color:#000000;">Request Submited</strong>
									</td>
								<?php } else if ($row->status == 2) { ?>
									<td>
										<strong style="color: #FFB701;">Request Approved SPV</strong>
									</td>
								<?php } else if ($row->status == 3) { ?>
									<td>
										<strong style="color: #008000;">Request Approved</strong>
									</td>
								<?php } else if ($row->status == 4) { ?>
									<td>
										<strong style="color: #50ABE4;">Give Back</strong>
									</td>
								<?php } else if ($row->status == 5) { ?>
									<td>
										<strong style="color: #000080;">Finished</strong>
									</td>
								<?php } else if ($row->status == 6) { ?>
									<td>
										<strong style="color: #B3B300;">Returned</strong>
									</td>
								<?php } ?>
			
								<?php if (in_array($row->status, ["3", "4"])) { ?>
									<td><a href="<?= site_url('rental/return/' . $row->id_req) ?>" class="btn btn-primary btn-circle btn-sm" title="Detail"><i class="fas fa-search"></i></a></td>
								<?php } else { ?>
									<td><a href="<?= site_url('rental/detail/' . $row->id_req) ?>" class="btn btn-primary btn-circle btn-sm" title="Detail"><i class="fas fa-search"></i></a></td>
								<?php } ?>
	
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire(
			'Sukses!',
			'Request anda berhasil ' + flashData,
			'success'
		)
	}
</script>