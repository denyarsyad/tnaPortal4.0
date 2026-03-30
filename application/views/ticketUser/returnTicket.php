<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?> #<?= $detail['id_ticket'] ?></h1>

	<div class="card shadow mb-4">
		<div class="card-body">
			<form method="post" action="<?= site_url('ticket_user/return/' . $detail['id_ticket']) ?>" enctype="multipart/form-data">
				<div class="form-group">
					<label class="mb-1 font-weight-bold text-gray-800">Penerima</label>
					<input class="form-control" name="reciepent" readonly value="<?= $detail['teknisi_mail'] ?>">
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold text-gray-800">Subjek</label>
					<input class="form-control" name="subject" readonly value="<?= $detail['id_ticket'] ?>">
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold text-gray-800">Memo Complete</label>
					<textarea name="memo" class="form-control" readonly rows="5"><?= $detail['memo_teknisi'] ?></textarea>
				</div>

				<div class="form-group">
					<h6 class="mb-2 font-weight-bold text-gray-800">Jawaban</h6>
					<div class="alert alert-warning text-dark" role="alert">
						<p class="mb-0" style="font-size: 14px;">
							<i class="fas fa-exclamation-circle"></i> Masukkan alasan mengapa tiket ini akan di kembalikan.
						</p>
					</div>
					<textarea name="answer" class="form-control <?= (form_error('answer') ? "is-invalid" : "") ?>" rows="8" id="answer"></textarea>
					<div class="invalid-feedback">
						<?= form_error('answer'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Lampiran (Media) <span class="text-danger small">*Request</span></label> </br>
					<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, jpeg, png, or pdf.</p>
					<input type="file" name="answerfoto" size="20" class="<?= (form_error('answerfoto') ? "is-invalid" : "") ?>">
					<div class="invalid-feedback">
						<?= form_error('answerfoto'); ?>
					</div>
					<div class="text-danger pt-1"><?= $error; ?></div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('ticket_user/index') ?>'">Batal</button>
			</form>
		</div>
	</div>
</div>