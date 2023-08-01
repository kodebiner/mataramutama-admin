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
        <?php if ($mobile === true) { ?>            
            <h1 class="uk-h3">Daftar Pemain</h1>
            <div class="uk-child-width-auto uk-flex-between" uk-grid>
                <div>
                    <button class="uk-button uk-button-default" type="button" uk-toggle="target: #filter; animation: uk-animation-slide-top-medium">Filter</button>
                </div>
                <div>
                    <button class="uk-button uk-button-primary"  uk-toggle="target: #new-player">+ Tambah Pemain</button>
                </div>
            </div>
            <div id="filter" class="uk-margin uk-width-1-1 uk-card uk-card-primary uk-card-body" hidden>
                <form class="uk-form-horizontal" action="tim/player" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="position">Posisi</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="position" aria-label="position"  name="position">
                                <option value="">Semua Posisi</option>
                                <?php foreach ($positions as $position) { ?>
                                    <option value="<?= $position['id']; ?>" <?php if (isset($selpos)) { if ($selpos === $position['id']) { echo 'selected'; }} ?>><?= $position['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="tim">Tim</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="tim" aria-label="tim"  name="tim">
                                <option value="">Semua Tim</option>
                                <?php foreach ($team as $tim) { ?>
                                    <option value="<?= $tim['id']; ?>" <?php if (isset($seltim)) { if ($seltim === $tim['id']) { echo 'selected'; }} ?>><?= $tim['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-default" type="submit">Terapkan</button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="uk-margin uk-flex-between uk-child-width-auto" uk-grid>
                <div class="uk-flex uk-flex-middle">
                    <h1 class="uk-h3">Daftar Pemain</h1>
                </div>
                <div class="uk-flex uk-flex-middle">
                    <button class="uk-button uk-button-primary"  uk-toggle="target: #new-player">+ Tambah Pemain</button>
                </div>
            </div>
            <div class="uk-background-muted uk-padding-small">
                <form action="tim/player" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="uk-child-auto uk-flex-right" uk-grid>
                        <div class="uk-flex uk-flex-middle">
                            <span class="uk-h3">Filter</span>
                        </div>
                        <div class="uk-flex uk-flex-middle">
                            <select class="uk-width-1-1 uk-select" aria-label="position" name="position">
                                <option value="">Semua Posisi</option>
                                <?php foreach ($positions as $position) { ?>
                                    <option value="<?= $position['id']; ?>" <?php if (isset($selpos)) { if ($selpos === $position['id']) { echo 'selected'; }} ?>><?= $position['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="uk-flex uk-flex-middle">
                            <select class="uk-width-1-1 uk-select" aria-label="tim" name="tim">
                                <option value="">Semua Tim</option>
                                <?php foreach ($team as $tim) { ?>
                                    <option value="<?= $tim['id']; ?>" <?php if (isset($seltim)) { if ($seltim === $tim['id']) { echo 'selected'; }} ?>><?= $tim['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="uk-flex uk-flex-middle">
                            <button class="uk-button uk-button-secondary" type="submit">Terapkan</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-small uk-table-hover uk-table-divider">
                <thead>
                    <tr>
                        <th class="uk-text-center">Nama</th>
                        <th class="uk-text-center">No Punggung</th>
                        <th class="uk-text-center">Posisi</th>
                        <th class="uk-text-center">Tim</th>
                        <th class="uk-text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($player as $pemain) {
                    ?>
                        <tr>
                            <td><?= $pemain['name']; ?></td>
                            <td class="uk-text-center"><?= $pemain['nopunggung']; ?></td>
                            <td class="uk-text-center">
                                <?php
                                foreach ($positions as $posisi) {
                                    if ($pemain['positionid'] === $posisi['id']) {
                                        echo $posisi['name'];
                                    }
                                }
                                ?>
                            </td>
                            <td class="uk-text-center">
                                <?php
                                foreach ($team as $tim) {
                                    if ($pemain['timid'] === $tim['id']) {
                                        echo $tim['name'];
                                    }
                                }
                                ?>
                            </td>
                            <td class="uk-grid-small uk-child-width-auto uk-flex-center" uk-grid>
                                <div><a href="tim/editpemain/<?= $pemain['id']; ?>" class="uk-icon-link" uk-icon="file-edit"></a></div>
                                <div>
                                    <a href="#player-<?= $pemain['id']; ?>" class="uk-icon-link" uk-toggle uk-icon="trash"></a>
                                    <div id="player-<?= $pemain['id']; ?>" class="uk-flex-top" uk-modal="bg-close:false;">
                                        <div class="uk-modal-dialog uk-margin-auto-vertical">
                                            <button class="uk-modal-close-outside" type="button" uk-close></button>
                                            <div class="uk-modal-body">
                                                <p class="uk-text-center">Anda yakin akan menghapus data pemain <b><?= $pemain['name']; ?></b></p>
                                            </div>
                                            <div class="uk-modal-footer">
                                                <div class="uk-child-width-auto uk-flex-center" uk-grid>
                                                    <div>
                                                        <a href="tim/hapuspemain/<?= $pemain['id']; ?>" class="uk-button uk-button-danger">Hapus</a>
                                                    </div>
                                                    <div>
                                                        <button class="uk-modal-close uk-button uk-button-default">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?= $pager->links('player', 'custom'); ?>
    </div>
</section>
<div id="new-player" class="uk-modal-container uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h4 class="uk-h3 uk-text-center">Tambah Pemain</h4>
        </div>
        <form action="tim/simpanpemain" name="simpanpemain" class="uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="uk-modal-body" uk-overflow-auto>
                <div class="uk-margin">
                    <label class="uk-form-label" for="fullname">Nama Lengkap</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="fullname" name="fullname" type="text" placeholder="Nama Lengkap" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Nama Punggung</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="name" name="name" type="text" placeholder="Nama Punggung" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="no">Nomor Punggung</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-small" id="no" name="no" type="number" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="height">Tinggi Badan</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-small" id="height" name="height" type="number" required> cm
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="weight">Berat Badan</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-small" id="weight" name="weight" type="number" required> Kg
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="birthdate">Tanggal lahir</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-medium" id="birthdate" name="birthdate" type="text" placeholder="YYYY-mm-dd" required>
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
                                echo '<option value="'.$position['id'].'">'.$position['name'].'</option>';
                            }
                            ?>
                        </select> <a href="#add-position" class="uk-button uk-button-small uk-button-primary" uk-toggle>+ Tambah Posisi</a>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="team">Tim</label>
                    <div class="uk-form-controls">
                        <select class="uk-select uk-form-width-medium" id="team" name="team" aria-label="Tim" required>
                            <option value=""></option>
                            <?php
                            foreach ($team as $tim) {
                                echo '<option value="'.$tim['id'].'">'.$tim['name'].'</option>';
                            }
                            ?>
                        </select> <a href="#add-team" class="uk-button uk-button-small uk-button-primary" uk-toggle>+ Tambah Tim</a>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="quote">Quote</label>
                    <div class="uk-form-controls">
                        <textarea class="uk-textarea" rows="5" id="quote" name="quote" placeholder="Quote" aria-label="Quote"></textarea>
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
					<div id="picdisplay" class="uk-child-width-1-2" uk-grid>
					</div>
					<div id="piclist">
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
					<div id="fotodisplay" class="uk-child-width-1-2" uk-grid>
					</div>
					<div id="fotolist">
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
</div>
<div id="add-position" class="uk-flex-top" uk-modal="bg-close:false;">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <div class="uk-modal-header">
            <div class="uk-h3 uk-text-center">Tambah Posisi</div>
        </div>
        <form action="tim/addposition" class="uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="uk-modal-body" uk-overflow-auto>
                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Nama Posisi</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="name" name="name" type="text" placeholder="Nama Posisi">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="group">Grup Posisi</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="group" name="group">
                            <option value=""></option>
                            <?php
                            foreach ($posgroup as $group) {
                                echo '<option value="'.$group['id'].'">'.$group['name'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer">
                <div class="uk-flex uk-flex-right">
                    <button class="uk-button uk-button-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="add-team" class="uk-flex-top" uk-modal="bg-close:false;">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <div class="uk-modal-header">
            <div class="uk-h3 uk-text-center">Tambah Tim</div>
        </div>
        <form action="tim/addteam" class="uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="uk-modal-body" uk-overflow-auto>
                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Nama Tim</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="name" name="name" type="text" placeholder="Nama Tim">
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer">
                <div class="uk-flex uk-flex-right">
                    <button class="uk-button uk-button-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>