			<section class="uk-section">
				<div class="uk-container uk-container-small">
					<div class="uk-flex uk-flex-right">
						<a class="uk-button uk-button-primary" href="pertandingan/addclub">Tambah Club</a>
					</div>
					<h1 class="uk-text-center uk-text-uppercase">Daftar Club</h1>
					<div class="uk-grid-small uk-child-width-1-2 uk-child-width-1-4@m" uk-grid uk-height-match="target: > div > a> .uk-card > .logo-container">
						<?php foreach ($clubs as $club) { ?>
							<div>
								<a href="#modal-<?php echo $club['id']; ?>" uk-toggle>
									<div class="uk-card uk-card-small uk-card-default uk-card-hover uk-card-body uk-width-1-1 uk-height-1-1">
										<div class="logo-container uk-flex uk-flex-middle">
											<?php
											if (!empty($club['logo'])) {
											?>
												<img class="uk-width-1-1" src="https://mataramutama.com/images/club/<?php echo $club['logo']; ?>" />
											<?php
											} else
											{
											?>
												<img class="uk-width-1-1" src="https://mataramutama.com/images/club/pssi.svg" />
											<?php
											}
											?>
										</div>
										<div class="uk-text-center uk-text-uppercase uk-text-bold uk-margin-small"><?php echo $club['name']; ?></div>
									</div>
								</a>
							</div>
						<?php } ?>
					</div>
					<?= $pager->links('club', 'custom'); ?>
				</div>
			</section>
			<?php
			foreach ($clubs as $club) {
			?>
				<div id="modal-<?php echo $club['id']; ?>" uk-modal>
					<div class="uk-modal-dialog uk-modal-body">
						<button class="uk-modal-close-outside" type="button" uk-close></button>
						<div class="uk-text-center">
							<?php if (!empty($club['logo'])) { ?>
								<img class="uk-width-1-1 uk-width-1-2@m" src="https://mataramutama.com/images/club/<?php echo $club['logo']; ?>" />
							<?php } else { ?>
								<img class="uk-width-1-1 uk-width-1-2@m" src="https://mataramutama.com/images/club/pssi.svg" />
							<?php } ?>
						</div>
						<div class="uk-text-center uk-h3 uk-text-uppercase"><?php echo $club['name']; ?></div>
						<div class="uk-margin-large uk-flex-center uk-child-width-1-2 uk-child-width-1-4@m" uk-grid>
							<div class="uk-text-center">
								<button class="uk-button uk-button-danger uk-text-uppercase" onclick="window.location='/pertandingan/clubremove/<?php echo $club['id']; ?>'">hapus</button>
							</div>
							<div class="uk-text-center">
								<button class="uk-button uk-button-default uk-text-uppercase" onclick="window.location='/pertandingan/updateclub/<?php echo $club['id']; ?>'">edit</button>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>