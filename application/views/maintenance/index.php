<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-4">Daftar semua Request ke Maintenace yang sudah kamu submit.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<!-- Button Input -->
	<a href="<?= site_url('maintenance/buatRequest') ?>" class="nav-link" style="padding-left: 0px;">
		<div class="btn btn-success btn-lg shadow-sm btn-left">
			<i class="fas fa-plus text-white" style="font-size: 15px"></i>
			<span class="text" style="font-size: 15px">Request</span>
		</div>
	</a>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>ID</th>
							<th>Req Date</th>
							<th>Respone Time (HH:MM:DD)</th>
							<th>Down Time (HH:MM:DD)</th>
							<th>MC ID</th>
							<th>MC Name</th>
							<th>Req Message</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($maintenance as $row) { ?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<?php if (in_array($row->status, ["2"])) { ?>
										<a href="<?= site_url('maintenance_act/actConfirm/' . $row->wo_id) ?>" class="font-weight-bold"><?= $row->wo_id ?></a>
									<?php } else { ?>
										<?= $row->wo_id ?>
									<?php } ?>
								</td>
								<td><?= $row->wo_date ?></td>
								<td><?= $row->respone_time ?></td>
								<td><?= $row->down_time ?></td>
								<td><?= $row->machine_id ?></td>
								<td><?= $row->machine_name ?></td>
								<td><?= $row->req_message ?></td>
								<?php if ($row->status == 0) { ?>
									<td>
										<strong style="color: #B81414;">Request Submited</strong>
									</td>
								<?php } else if ($row->status == 1) { ?>
									<td>
										<strong style="color: #FFB701;">Request Pending</strong>
									</td>
								<?php } else if ($row->status == 2) { ?>
									<td>
										<strong style="color: #008000;">Request Done</strong>
									</td>
								<?php } else if ($row->status == 3) { ?>
									<td>
										<strong style="color: #000080;">Confirm</strong>
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
										<strong style="color: #B3B300;">Checked</strong>
									</td>
								<?php } else if ($row->status == 7) { ?>
									<td>
										<strong style="color: #75028f;">Change Machine</strong>
									</td>		
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