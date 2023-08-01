<section class="uk-section-small">
    <div class="uk-container">
    <?php
    if (session()->has('errors')) {
    ?>
        <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <ul class="uk-list uk-list-circle">
                <?php
                foreach (session('errors') as $error) {
                    echo '<li>'.$error.'</li>';
                }
                ?>
            </ul>
        </div>
    <?php
    }
    if (session()->has('success')) {
    ?>
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><?= session('success'); ?></p>
        </div>
    <?php
    }
    ?>
    <form action="tim/playeredit" name="simpanpemain" class="uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            <input name="id" value="<?= $player['id']; ?>" hidden>
            <div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="fullname">Nama Lengkap</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="fullname" name="fullname" type="text" value="<?= $player['name']; ?>" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Nama Punggung</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="name" name="name" type="text"  value="<?= $player['namapunggung']; ?>" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="no">Nomor Punggung</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-small" id="no" name="no" type="number" value="<?= $player['nopunggung']; ?>" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="height">Tinggi Badan</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-small" id="height" name="height" type="number" value="<?= $player['tinggibadan']; ?>" required> cm
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="weight">Berat Badan</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-small" id="weight" name="weight" type="number" value="<?= $player['beratbadan']; ?>" required> Kg
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="birthdate">Tanggal lahir</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-medium" id="birthdate" name="birthdate" type="text"  value="<?= $player['tgllahir']; ?>" required>
                    </div>
                </div>
                <script>
                    jQuery.datetimepicker.setLocale('id');
                    jQuery('#birthdate').datetimepicker({
                        i18n:{
                            id:{
                                months:[
                                    'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nuvember','Desember'
                                ],
                                dayOfWeek:[
                                    'Sen','Sel','Rab','Kam','Jum','Sab','Min'
                                ]
                            }
                        },
                        timepicker:false,
                        format:'Y-m-d'
                    });
                </script>
                <div class="uk-margin">
                    <label class="uk-form-label" for="position">Posisi</label>
                    <div class="uk-form-controls">
                        <select class="uk-select uk-form-width-medium" id="position" name="position" aria-label="Posisi" required>
                            <option value=""></option>
                            <?php
                            foreach ($positions as $position) {
                            ?>
                                <option value="<?= $position['id']; ?>" <?php if ($player['positionid'] === $position['id']) { echo 'selected'; } ?>><?= $position['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="team">Tim</label>
                    <div class="uk-form-controls">
                        <select class="uk-select uk-form-width-medium" id="team" name="team" aria-label="Tim" required>
                            <option value=""></option>
                            <?php
                            foreach ($team as $tim) {
                            ?>
                                <option value="<?= $tim['id']; ?>" <?php if ($player['timid'] === $tim['id']) { echo 'selected'; } ?>><?= $tim['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="quote">Quote</label>
                    <div class="uk-form-controls">
                        <textarea class="uk-textarea" rows="5" id="quote" name="quote"  placeholder="<?= $player['description']; ?>" aria-label="Quote"><?= $player['description']; ?></textarea>
                    </div>
                </div>
                <div class="uk-margin">
					<label class="uk-form-label">Foto Profil</label>
					<div class="uk-form-controls uk-visible@m">
						<div class="pic-upload uk-placeholder uk-text-center uk-margin-remove-top uk-visible@m">
							<span uk-icon="icon: cloud-upload"></span>
							<span class="uk-text-middle">Seret dan lepas foto yang akan anda upload ke dalam kotak ini atau</span>
							<div uk-form-custom>
								<input type="file" name="picupload">
								<a class="uk-link"><b>pilih disini</b></a>
							</div>
						</div>
					</div>
					<div class="pic-upload uk-margin-bottom uk-hidden@m" uk-form-custom="target: true">
						<input type="file" name="picupload">
						<input class="uk-input uk-form-width-medium" type="text" placeholder="Pilih foto" disabled>
					</div>
					<progress id="pic-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
					<div id="picdisplay" class="uk-child-width-1-4@m uk-flex-center" uk-grid>
                    <?php
						if (isset ($player['profilepic']))
						{
							echo '<div id="pic-display" class="uk-inline">';
							echo '<img class="uk-width-1-1" src="https://mataramutama.com/images/pemain/' .$player['profilepic']. '"/>';
							echo '<a class="uk-position-small uk-position-top-right uk-light" style="padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;" onclick="takeoutpic()"><span uk-icon="close"></span></a>';
							echo '</div>';
						}
					?>
					</div>
					<div id="piclist">
                    <?php
						if (isset ($player['profilepic']))
						{
							echo '<input class="input-pic" id="pic" name="pic" value="' .$player['profilepic']. '" hidden="hidden">';
						}
					?>
					</div>
					<script>
						var bar = document.getElementById('pic-progressbar');

						UIkit.upload('.pic-upload', {

							url: 'tim/uploadpic',
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
										
								var displaycontainer = document.getElementById('pic-display');
								var inputcontainer = document.getElementById('pic');
										
								if (typeof(displaycontainer) != 'undefined' && displaycontainer != null) {
									displaycontainer.remove();
								}
								if (typeof(inputcontainer) != 'undefined' && inputcontainer != null) {
									inputcontainer.remove();
								}
										
								var filename = arguments[0].response;
											
								var input = document.createElement("input");
								input.setAttribute('name', 'pic');
								input.setAttribute('value', filename);
								input.setAttribute('hidden', 'hidden');
								input.setAttribute('class', 'input-pic');
								input.setAttribute('id', 'pic');
								document.getElementById("piclist").appendChild(input);
											
								var display = document.getElementById("picdisplay");
								var item = document.createElement("div");
								item.setAttribute('class', 'uk-inline display-pic');
								item.setAttribute('id', 'pic-display');
								var img = document.createElement("img");
								img.setAttribute('src', 'https://mataramutama.com/images/pemain/' +filename);
								img.setAttribute('class', 'uk-width-1-1');
								item.append(img);
								var removebutton = document.createElement("a");
								removebutton.setAttribute('class', 'uk-position-small uk-position-top-right uk-light button-foto');
								removebutton.setAttribute('style', 'padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;');
								removebutton.setAttribute('onclick', 'takeoutpic()');
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
									
						function takeoutpic() {
							document.getElementById('pic-display').remove();
							document.getElementById('pic').remove();
						}
					</script>
				</div>
                <div class="uk-margin">
					<label class="uk-form-label">Foto Header</label>
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
					<div id="fotodisplay" class="uk-child-width-1-4@m uk-flex-center" uk-grid>
                    <?php
						if (isset ($player['photo']))
						{
							echo '<div id="pic-display" class="uk-inline">';
							echo '<img class="uk-width-1-1" src="https://mataramutama.com/images/pemain/' .$player['photo']. '"/>';
							echo '<a class="uk-position-small uk-position-top-right uk-light" style="padding: 5px; background-color: #f0506e; border-radius: 15px; line-height: 15px;" onclick="takeoutfoto()"><span uk-icon="close"></span></a>';
							echo '</div>';
						}
					?>
					</div>
					<div id="fotolist">
                    <?php
						if (isset ($player['photo']))
						{
							echo '<input class="input-foto" id="foto" name="foto" value="' .$player['photo']. '" hidden="hidden">';
						}
					?>
					</div>
					<script>
						var bar = document.getElementById('foto-progressbar');

						UIkit.upload('.foto-upload', {

							url: 'tim/upload',
							dataType: 'JSON',
							mime: 'image/png',
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
								document.getElementById("fotolist").appendChild(input);
											
								var display = document.getElementById("fotodisplay");
								var item = document.createElement("div");
								item.setAttribute('class', 'uk-inline display-foto');
								item.setAttribute('id', 'foto-display');
								var img = document.createElement("img");
								img.setAttribute('src', 'https://mataramutama.com/images/pemain/' +filename);
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
            </div>
            <div class="uk-modal-footer">
                <div class="uk-flex uk-flex-right">
                    <button class="uk-button uk-button-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</section>