			<section class="uk-section-small">
				<div class="uk-container">
					<h1 class="uk-h3">Daftar Galeri Foto</h1>
					<div class="uk-margin">
						<a class="uk-button uk-button-primary uk-button-small" href="#modal-galeri-baru" uk-toggle><span uk-icon="icon: plus; ratio: 0.5;"></span> Galeri Baru</a>
					</div>
					<div class="uk-child-width-1-2 uk-child-width-1-4@m" uk-grid uk-height-match="target: > div > a > .uk-card > .uk-card-media-top">
						<?php
						foreach ($categories as $category) {
						?>
							<div>
								<a href="galeri/updategalerifoto/<?php echo $category['id']; ?>">
									<div class="uk-card uk-card-default uk-card-hover">
										<?php if (!empty($category['featured'])) { ?>
										<div class="uk-card-media-top uk-background-cover" style="background-image: url(https://mataramutama.com/images/gallery/<?php echo $category['featured']; ?>);">
										<?php } else { ?>
										<div class="uk-card-media-top uk-background-cover" style="background-image: url(images/dummy-img.png);">
										<?php } ?>
											<?php if (!empty($category['featured'])) { ?>
												<img class="uk-invisible" src="https://mataramutama.com/images/gallery/<?php echo $category['featured']; ?>" />
											<?php } else { ?>
												<img class="uk-invisible" src="images/dummy-img.png" />
											<?php } ?>
										</div>
										<div class="uk-card-body uk-padding-small">
											<h3 class="uk-h5"><?php echo $category['name']; ?></h3>
											<div class="uk-text-right">
												<?php if ($category['status'] === '0') { ?>
													<span class="uk-text-danger">unpublished</span>
												<?php } else if ($category['status'] === '1') { ?>
													<span class="uk-text-success">published</span>
												<?php } else { ?>
													<span class="uk-text-muted">undefined</span>
												<?php } ?>
											</div>
										</div>
									</div>
								</a>
							</div>
						<?php
						}
						?>
					</div>
					<?= $pager->links('category', 'custom'); ?>
				</div>
			</section>
			<div id="modal-galeri-baru" class="uk-flex-top" uk-modal="bg-close: false;">
				<div class="uk-modal-dialog uk-margin-auto-vertical">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<div class="uk-modal-header">
						<h2 class="uk-modal-title">Buat Galeri Baru</h2>
					</div>
					<div class="uk-modal-body">
						<form action="/galeri/foto" name="galeribaru" class="uk-form uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
							<div class="uk-margin">
								<label class="uk-form-label" for="judul">Judul Galeri</label>
								<div class="uk-form-controls">
									<input class="uk-input" id="judul" name="judul" type="text" placeholder="Judul Galeri" required>
								</div>
							</div>
							<div class="uk-margin">
								<button class="uk-button uk-botton-default" type="submit" name="submit" value="newcat">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php foreach ($categories as $category) { ?>
				<div id="edit-<?php echo $category['id']; ?>" class="uk-flex-top uk-modal-container" uk-modal="bg-close: false;">
					<div class="uk-modal-dialog uk-margin-auto-vertical">
						<button class="uk-modal-close-default" type="button" uk-close></button>
						<form action="/galeri/foto" name="edit<?php echo $category['id']; ?>" class="uk-form uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
							<div class="uk-modal-header">
								<h3 class="uk-modal-title"><?php echo $category['name']; ?></h3>
							</div>
							<div class="uk-modal-body" uk-overflow-auto>
								<input type="text" name="id" value="<?php echo $category['id']; ?>" hidden>
								<div class="uk-margin">
									<label class="uk-form-label" for="judul">Judul Galeri</label>
									<div class="uk-form-controls">
										<input class="uk-input" id="judul" name="judul" type="text" placeholder="<?php echo $category['name']; ?>" value="<?php echo $category['name']; ?>" required>
									</div>
								</div>
								<div class="uk-margin">
									<div class="uk-form-label">Upload Foto</div>
									<div class="uk-form-controls">
										<div class="uk-visible@m">
											<div class="foto-upload uk-placeholder uk-text-center uk-margin-remove-top uk-visible@m">
												<span uk-icon="icon: cloud-upload"></span>
												<span class="uk-text-middle">Seret dan lepas foto yang akan anda upload ke dalam kotak ini atau</span>
												<div uk-form-custom>
													<input type="file" name="fotoupload">
													<a class="uk-link"><b>pilih disini</b></a>
												</div>
											</div>
										</div>
										<div class="foto-upload uk-margin-bottom uk-hidden@m" uk-form-custom="target: true">
											<input type="file" name="fotoupload">
											<input class="uk-input uk-form-width-medium" type="text" placeholder="Pilih foto" disabled>
										</div>
										<progress id="foto-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
									</div>
								</div>
								<div class="uk-margin">
									<div class="uk-form-label">Cover</div>
									<div class="uk-form-controls">
										<div id="galericover" class="uk-child-width-1-1 uk-child-width-1-2@m" uk-grid>
											<?php
											foreach ($photos as $photo) {
												if ($photo['catid'] === $category['id']) {
											?>
												<div>
													<label class="tm-radio-gallery">
														<input type="radio" name="cover" value="<?php echo $photo['photo']; ?>">
														<img class="uk-width-1-1" src="https://mataramutama.com/images/gallery/<?php echo $photo['photo']; ?>" />
													</label>
												</div>
											<?php
												}
											}
											?>
										</div>
									</div>
								</div>
								<input id="fotolist-<?php echo $category['id']; ?>" type="text" value="" hidden>
								<script>
									var bar = document.getElementById('foto-progressbar');
									
									UIkit.upload('.foto-upload', {

										url: 'galeri/uploadfoto',
										dataType: 'JSON',
										mime: 'image/*',
										multiple: true,
										name: 'filein',

										beforeSend: function () {
											console.log('beforeSend', arguments);
										},
										beforeAll: function () {
											console.log('beforeAll', arguments);
										},
										load: function () {
											console.log('load', arguments);
										},
										error: function () {
											console.log('error', arguments);
											
											var error = arguments[0].xhr.response;
											alert(error);
										},
										complete: function () {
											console.log('complete', arguments);
											
											var filename = arguments[0].response;
											var file = filename.substr(0, filename.lastIndexOf('.')) || filename;
											
											var coverContainer = document.getElementById('galericover');
											
											var inputContainer = document.createElement("div");
											inputContainer.setAttribute('id', 'inputcontainer' +file);
											
											coverContainer.appendChild(inputContainer);
										},

										loadStart: function (e) {
											console.log('loadStart', arguments);

											bar.removeAttribute('hidden');
											bar.max = e.total;
											bar.value = e.loaded;
										},

										progress: function (e) {
											console.log('progress', arguments);

											bar.max = e.total;
											bar.value = e.loaded;
										},

										loadEnd: function (e) {
											console.log('loadEnd', arguments);

											bar.max = e.total;
											bar.value = e.loaded;
										},

										completeAll: function () {
											console.log('completeAll', arguments);

											setTimeout(function () {
												bar.setAttribute('hidden', 'hidden');
											}, 1000);

											alert('Upload Selesai');
										}

									});
								</script>
							</div>
							<div class="uk-modal-footer">
								<div class="uk-flex uk-flex-right">
									<div>
										<button class="uk-button uk-button-default" type="submit" name="submit" value="update">update</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php } ?>