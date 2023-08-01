			<section class="uk-section-small">
				<div class="uk-container">
					<form action="/galeri/updategalerifoto/<?php echo $category['id']; ?>" name="update" class="uk-form uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
						<div>
							<label class="uk-form-label" for="judul">Judul Galeri</label>
							<div class="uk-form-controls">
								<input class="uk-input uk-form-large" id="judul" name="judul" type="text" placeholder="<?php echo $category['name']; ?>" value="<?php echo $category['name']; ?>" required>
							</div>
						</div>
						<hr/>
						<div class="uk-margin">
							<div class="uk-form-label">Tambah Foto</div>
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
								<div id="galericover" class="uk-child-width-1-2 uk-child-width-1-4@m" uk-grid>
									<?php
									foreach ($photos as $photo) {
										if ($photo['photo'] === $category['featured']) {
											$checked = 'checked';
										} else {
											$checked = '';
										}
									?>
										<div id="inputcontainer<?php echo $photo['id']; ?>">
											<label class="tm-radio-gallery">
												<input type="radio" name="cover" value="<?php echo $photo['photo']; ?>" <?php echo $checked; ?>>
												<img class="uk-width-1-1" src="https://mataramutama.com/images/gallery/<?php echo $photo['photo']; ?>" />
												<button class="remove-button uk-icon-button uk-button-danger" uk-icon="icon: close;" value="<?php echo $photo['id']; ?>"></button>
											</label>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<input id="fotoin" type="text" name="fotoin" value="" hidden>
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
									
									var getInputContainer = document.getElementById('inputcontainer'+file);
									
									var label = document.createElement("label");
									label.setAttribute('class', 'tm-radio-gallery');
									label.setAttribute('id', 'label-' +file);
									
									getInputContainer.appendChild(label);
									
									var getLabel = document.getElementById('label-'+file);
									
									var input = document.createElement("input");
									input.setAttribute('type', 'radio');
									input.setAttribute('name', 'cover');
									input.setAttribute('value', filename);
									
									getLabel.appendChild(input);
									
									var img = document.createElement("img");
									img.setAttribute('class', 'uk-width-1-1');
									img.setAttribute('src', 'https://mataramutama.com/images/gallery/' +filename);
									
									getLabel.appendChild(img);
									
									var btn = document.createElement("button");
									btn.setAttribute('class', 'remove-button-only uk-icon-button uk-button-danger');
									btn.setAttribute('uk-icon', 'icon: close;');
									btn.setAttribute('value', filename);
									
									getLabel.appendChild(btn);
									
									var fotoin = document.getElementById('fotoin');
									var prevFotoin = fotoin.value;
									fotoin.setAttribute('value', prevFotoin+filename+ ', ');
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
							
							$(function() {
								$('.remove-button').on('click', function (e) {
									e.preventDefault();
									e.stopPropagation();
									
									var id = $(this).val();
									
									$.ajax({
										type: 'POST',
										url: 'galeri/removephoto',
										data: {
											id: id
										},
										dataType : 'JSON',

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
										},										
										complete: function () {
											console.log('complete', arguments);
											
											var array = arguments[0].responseText;
											
											const obj = JSON.parse(array);
											
											var container = document.getElementById('inputcontainer'+obj.id);
											container.remove();
											
											
										},
										loadStart: function (e) {
											console.log('loadStart', arguments);
										},
											progress: function (e) {
											console.log('progress', arguments);
										},
										loadEnd: function (e) {
											console.log('loadEnd', arguments);
										},
										completeAll: function () {
											console.log('completeAll', arguments);
										}
									});
								});
								
								$(document).on('click', '.remove-button-only', function (f) {
									f.preventDefault();
									f.stopPropagation();
									
									var btnval = $(this).val();
									
									$.ajax({
										type: 'POST',
										url: 'galeri/removephotoonly',
										data: {
											filename: btnval
										},
										dataType : 'JSON',

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
										},										
										complete: function () {
											console.log('complete', arguments);
											
											var obj = arguments[0].responseText;
											var idcon = obj.substr(0, obj.lastIndexOf('.')) || obj;
											
											var container = document.getElementById('inputcontainer'+idcon);
											container.remove();
											
											var fotoinput = document.getElementById('fotoin');
											var oldval = fotoinput.value;
											var newval = oldval.replace(obj+', ','');
											fotoinput.setAttribute('value', newval);
										},
										loadStart: function (e) {
											console.log('loadStart', arguments);
										},
											progress: function (e) {
											console.log('progress', arguments);
										},
										loadEnd: function (e) {
											console.log('loadEnd', arguments);
										},
										completeAll: function () {
											console.log('completeAll', arguments);
										}
									});
								});
							});
						</script>
						<div class="uk-margin-large uk-child-width-1-1 uk-child-width-1-2@m" uk-grid>
							<div>
								<div class="uk-flex uk-flex-left">
									<a href="#modal-remove" class="uk-button uk-button-danger" uk-toggle><span uk-icon="icon: trash;"></span> Hapus Galeri</a>
								</div>
							</div>
							<div>
								<div class="uk-flex uk-flex-right">
									<div class="uk-margin-right uk-margin-left">
										<button class="uk-button uk-button-default" type="submit" name="submit" value="save">Save</button>
									</div>
									<?php if ($category['status'] === '0') { ?>
									<div class="uk-margin-right uk-margin-left">
										<button class="uk-button uk-button-primary" type="submit" name="submit" value="publish">Save & Publish</button>
									</div>
									<?php } else { ?>
									<div class="uk-margin-right uk-margin-left">
										<button class="uk-button uk-button-danger" type="submit" name="submit" value="unpublish">Unpublish</button>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
			<div id="modal-remove" class="uk-flex-top" uk-modal="bg-close: false;">
				<div class="uk-modal-dialog uk-margin-auto-vertical">
					<div class="uk-modal-body">
						<p>Anda yakin akan menghapus Galeri berjudul <strong><?php echo $category['name']; ?></strong>?</p>
					</div>
					<div class="uk-modal-footer">
						<div class="uk-child-width-1-2" uk-grid>
							<div class="uk-text-center">
								<button class="uk-button uk-modal-close" type="button">Batal</button>
							</div>
							<div class="uk-text-center">
								<button class="uk-button uk-button-danger" onclick="window.location='/galeri/removegallery/<?php echo $category['id']; ?>'" type="button">Hapus</button>
							</div>
						</div>
					</div>
				</div>
			</div>