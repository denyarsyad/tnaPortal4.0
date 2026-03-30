<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
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
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($myAsset as $row) { ?>
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
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

