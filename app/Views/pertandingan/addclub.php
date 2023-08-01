			<section class="uk-section">
				<div class="uk-container uk-container-small">
					<h3>Tambah Club Baru</h3>
					<?php
					if (isset($errors)) {
					?>
						<div class="uk-alert-danger" uk-alert>
							<a class="uk-alert-close" uk-close></a>
							<ul>
								<?php
								foreach ($errors as $error => $message) {
									echo '<li>'. $message .'</li>';
								}
								?>
							</ul>
						</div>
					<?php
					}
					?>
					<form action="/pertandingan/addclub" name="addclub" class="uk-form uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Nama Club</label>
							<div class="uk-form-controls">
								<input class="uk-form-input uk-width-1-1 uk-form-large" type="text" name="nama" <?php if (isset ($post['nama'])) { echo 'value="'. $post['nama'] .'"'; } if (isset($club['name'])) { echo 'value="'. $club['name'] .'"'; } ?> required />
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Logo Club</label>
							<div class="uk-form-controls uk-visible@m">
								<div class="logo-upload uk-placeholder uk-text-center uk-margin-remove-top uk-visible@m">
									<span uk-icon="icon: cloud-upload"></span>
									<span class="uk-text-middle">Seret dan lepas logo yang akan anda upload ke dalam kotak ini atau</span>
									<div uk-form-custom>
										<input type="file" name="logoupload">
										<a class="uk-link"><b>pilih disini</b></a>
									</div>
								</div>
							</div>
							<div class="logo-upload uk-margin-bottom uk-hidden@m" uk-form-custom="target: true">
								<input type="file" name="logoupload">
								<input class="uk-input uk-form-width-medium" type="text" placeholder="Pilih logo" disabled>
							</div>
							<progress id="logo-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
							<div id="logodisplay" class="uk-form-controls uk-child-width-1-2" uk-grid>
								<?php
									if (isset ($post['logo']))
									{
										echo '<div id="logo-display" class="uk-inline">';
										echo '<img class="uk-width-1-1" src="https://mataramutama.com/images/club/' .$post['logo']. '"/>';
										echo '<a class="uk-position-small uk-position-top-right uk-light" style="padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;" onclick="takeoutlogo()"><span uk-icon="close"></span></a>';
										echo '</div>';
									}
									
									if (isset ($club['logo']))
									{
										echo '<div id="logo-display" class="uk-inline">';
										echo '<img class="uk-width-1-1" src="https://mataramutama.com/images/club/' .$club['logo']. '"/>';
										echo '<a class="uk-position-small uk-position-top-right uk-light" style="padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;" onclick="takeoutlogo()"><span uk-icon="close"></span></a>';
										echo '</div>';
									}
								?>
							</div>
							<div id="logolist">
								<?php
									if (isset ($post['logo']))
									{
										echo '<input class="input-logo" id="logo" name="logo" value="' .$post['logo']. '" hidden="hidden">';
									}
									
									if (isset ($club['logo']))
									{
										echo '<input class="input-logo" id="logo" name="logo" value="' .$club['logo']. '" hidden="hidden">';
									}
								?>
							</div>
							<script>
								var bar = document.getElementById('logo-progressbar');

								UIkit.upload('.logo-upload', {

									url: 'pertandingan/clublogo',
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
										
										var displaycontainer = document.getElementById('logo-display');
										var inputcontainer = document.getElementById('logo');
										
										if (typeof(displaycontainer) != 'undefined' && displaycontainer != null) {
											displaycontainer.remove();
										}
										if (typeof(inputcontainer) != 'undefined' && inputcontainer != null) {
											inputcontainer.remove();
										}
										
										var filename = arguments[0].response;
											
										var input = document.createElement("input");
										input.setAttribute('name', 'logo');
										input.setAttribute('value', filename);
										input.setAttribute('hidden', 'hidden');
										input.setAttribute('class', 'input-logo');
										input.setAttribute('id', 'logo');
										document.getElementById("logolist").appendChild(input);
											
										var display = document.getElementById("logodisplay");
										var item = document.createElement("div");
										item.setAttribute('class', 'uk-inline display-logo');
										item.setAttribute('id', 'logo-display');
										var img = document.createElement("img");
										img.setAttribute('src', 'https://mataramutama.com/images/club/' +filename);
										img.setAttribute('class', 'uk-width-1-1');
										item.append(img);
										var removebutton = document.createElement("a");
										removebutton.setAttribute('class', 'uk-position-small uk-position-top-right uk-light button-logo');
										removebutton.setAttribute('style', 'padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;');
										removebutton.setAttribute('onclick', 'takeoutlogo()');
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
									
								function takeoutlogo() {
									document.getElementById('logo-display').remove();
									document.getElementById('logo').remove();
								}
							</script>
						</div>
						<div class="uk-margin uk-flex uk-flex-right">
							<button class="uk-button uk-button-primary" name="submit" type="submit">Save</button>
						</div>
					</form>
				</div>
			</section>