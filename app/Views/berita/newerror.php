			<section class="uk-section">
				<div class="uk-container uk-container-small">
					<?= $validation->listErrors('error_list') ?>
					<form class="uk-form uk-form-stacked" method="POST" action="/berita/new" accept-charset="utf-8">
						<div class="uk-margin">
							<label class="uk-form-label">Judul</label>
							<div class="uk-form-controls">
								<input class="uk-form-input uk-width-1-1 uk-form-large" type="text" name="judul" required/>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label">Foto</label>
							<div class="uk-form-controls uk-visible@m">
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
							<div id="fotodisplay" class="uk-child-width-1-2" uk-grid>
								<?php
									if (isset ($post['foto']))
									{
										echo '<div id="foto-display" class="uk-inline">';
										echo '<img class="uk-width-1-1" src="https://mataramutama.com/images/berita/' .$post['foto']. '"/>';
										echo '<a class="uk-position-small uk-position-top-right uk-light" style="padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;" onclick="takeoutfoto()"><span uk-icon="close"></span></a>';
										echo '</div>';
									}
								?>
							</div>
							<div id="ownershiplist">
								<?php
									if (isset ($post['foto']))
									{
										echo '<input class="input-foto" id="foto" name="foto" value="' .$post['foto']. '" hidden="hidden">';
									}
								?>
							</div>
							<script>
								var bar = document.getElementById('foto-progressbar');

								UIkit.upload('.foto-upload', {

									url: 'berita/upload',
									dataType: 'JSON',
									mime: 'image/*',
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
										
										var displaycontainer = document.getElementById('foto-display');
										var inputcontainer = document.getElementById('foto');
										
										if (typeof(displaycontainer) != 'undefined' && displaycontainer != null) {
											displaycontainer.remove();
										}
										if (typeof(inputcontainer) != 'undefined' && inputcontainer != null) {
											inputcontainer.remove();
										}
										
										var filename = arguments[0].response;
											
										var input = document.createElement("input");
										input.setAttribute('name', 'foto');
										input.setAttribute('value', filename);
										input.setAttribute('hidden', 'hidden');
										input.setAttribute('class', 'input-foto');
										input.setAttribute('id', 'foto');
										document.getElementById("ownershiplist").appendChild(input);
											
										var display = document.getElementById("fotodisplay");
										var item = document.createElement("div");
										item.setAttribute('class', 'uk-inline display-foto');
										item.setAttribute('id', 'foto-display');
										var img = document.createElement("img");
										img.setAttribute('src', 'https://mataramutama.com/images/berita/' +filename);
										img.setAttribute('class', 'uk-width-1-1');
										item.append(img);
										var removebutton = document.createElement("a");
										removebutton.setAttribute('class', 'uk-position-small uk-position-top-right uk-light button-foto');
										removebutton.setAttribute('style', 'padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;');
										removebutton.setAttribute('onclick', 'takeoutfoto()');
										var closebutton = document.createElement("span");
										closebutton.setAttribute('uk-icon', 'close');
										removebutton.append(closebutton);
										item.append(removebutton);
										display.append(item);
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
									
								function takeoutfoto() {
									document.getElementById('foto-display').remove();
									document.getElementById('foto').remove();
								}
							</script>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label">Intro Paragraf</label>
							<div class="uk-form-controls">
								<textarea class="uk-textarea" rows="5" name="intro" placeholder="Tuliskan paragraf pertama berita di sini" required></textarea>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label">Konten Berita</label>
							<div class="uk-form-controls">
								<textarea id="beritainput" name="content" required></textarea>
								<script>
									tinymce.init({
										selector: '#beritainput',
										height : 300,
										plugins: 'charmap link hr fullscreen lists advlist code help',
										toolbar: 'undo redo | styleselect bold italic | alignleft aligncenter alignright | bullist numlist | outdent indent | charmap link fullscreen code help'
									});
								</script>
							</div>
						</div>
						<div class="uk-margin">
							<button class="uk-button uk-button-primary" type="submit">Save</button>
						</div>
					</form>
				</div>
			</section>