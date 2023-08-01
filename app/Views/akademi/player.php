<section class="uk-section uk-section-small">
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
        if (session()->has('error')) {
        ?>
            <div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?= session('error'); ?></p>
            </div>
        <?php
        }
        ?>
        <div class="uk-grid-divider uk-grid-match" uk-grid>
            <div class="uk-width-1-4@m <?php if ($mobile === false) { echo 'uk-flex-last'; } ?> academy-container">
                <div class="uk-position-z-index" <?php if ($mobile === false) { ?>uk-sticky="end: !.academy-container; offset: 140" <?php } ?>>
                    <h3>Daftar Akademi</h3>
                    <button class="uk-button uk-button-primary"  uk-toggle="target: #new-academy">+ Tambah Akademi</button>
                    <table class="uk-table uk-table-small uk-table-hover">
                        <tbody>
                            <?php
                            foreach ($akademi as $academy) {
                            ?>
                            <tr>
                                <td><?= $academy['nama']; ?></td>
                                <td class="uk-grid-small uk-child-width-auto uk-flex-center" uk-grid>
                                    <div><a href="" uk-icon="file-edit"></a></div>
                                    <div><a href="" uk-icon="trash"></a></div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="uk-width-3-4@m <?php if ($mobile === false) { echo 'uk-flex-first'; } ?>">
                <?php
                if ($mobile === false) {
                ?>
                <div class="uk-margin uk-child-width-auto uk-flex-between" uk-grid>
                    <div class="uk-flex uk-flex-middle"><h1 class="uk-h3">Daftar Siswa</h1></div>
                    <div class="uk-flex uk-flex-middle"><button class="uk-button uk-button-primary"  uk-toggle="target: #new-player">+ Tambah Siswa</button></div>
                </div>
                <div class="uk-background-muted uk-padding-small">
                    <form action="akademi" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="uk-child-auto uk-flex-right" uk-grid>
                            <div class="uk-flex uk-flex-middle"><span class="uk-h3">Filter</span></div>
                            <div class="uk-flex uk-flex-middle">
                                <select class="uk-width-1-1 uk-select" aria-label="academy" name="academy">
                                    <option value="">Semua Siswa</option>
                                    <?php
                                    foreach ($akademi as $academy) {
                                    ?>
                                        <option value="<?= $academy['id']; ?>" <?php if (isset($acd)) { if ($acd === $academy['id']) { echo 'selected'; }} ?>><?= $academy['nama']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="uk-flex uk-flex-middle">
                                <button class="uk-button uk-button-secondary" type="submit">Terapkan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                }
                else {
                ?>
                <h1 class="uk-h3">Daftar Siswa</h1>
                <div class="uk-child-width-auto uk-flex-between" uk-grid>
                    <div><button class="uk-button uk-button-default" type="button" uk-toggle="target: #filter; animation: uk-animation-slide-top-medium">Filter</button></div>
                    <div><button class="uk-button uk-button-primary"  uk-toggle="target: #new-player">+ Tambah Siswa</button></div>
                </div>
                <div id="filter" class="uk-margin uk-width-1-1 uk-card uk-card-primary uk-card-body" hidden>
                    <form class="uk-form-horizontal" action="akademi" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="academy">Akademi</label>
                            <div class="uk-form-controls">
                                <select class="uk-select" aria-label="academy" name="academy">
                                    <option value="">Semua Siswa</option>
                                    <?php
                                    foreach ($akademi as $academy) {
                                    ?>
                                        <option value="<?= $academy['id']; ?>" <?php if (isset($acd)) { if ($acd === $academy['id']) { echo 'selected'; }} ?>><?= $academy['nama']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-margin">
                            <button class="uk-button uk-button-default" type="submit">Terapkan</button>
                        </div>
                    </form>
                </div>
                <?php
                }
                ?>
                <div class="uk-margin uk-overflow-auto">
                    <table class="uk-table uk-table-small uk-table-hover uk-table-divider">
                        <thead>
                            <tr>
                                <th class="uk-text-center">Nama</th>
                                <th class="uk-text-center">Akademi</th>
                                <th class="uk-text-center">Tanggal Lahir</th>
                                <th class="uk-text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($players as $player) {
                            ?>
                                <tr>
                                    <td><?= $player['nama']; ?></td>
                                    <td class="uk-text-center">
                                        <?php
                                        foreach ($akademi as $academy) {
                                            if ($academy['id'] === $player['akademiid']) {
                                                echo $academy['nama'];
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="uk-text-center">
                                        <?php
                                        $time = strtotime($player['birthdate']);
                                        $birthdate = date('d-m-Y', $time);
                                        echo $birthdate;
                                        ?>
                                    </td>
                                    <td class="uk-grid-small uk-child-width-auto uk-flex-center" uk-grid>
                                        <div><a href="" uk-icon="file-edit"></a></div>
                                        <div><a href="#delete-<?= $player['id']; ?>" uk-icon="trash" uk-toggle></a></div>
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
        </div>
    </div>
</section>
<div id="new-academy" class="uk-modal-container uk-flex-top" uk-modal="bg-close:false;">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-outside uk-icon uk-close" type="button" uk-close></button>
        <div class="uk-modal-header"><h4 class="uk-h3 uk-text-center">Tambah Akademi</h4></div>
        <form class="uk-form-horizontal" action="akademi/addacademy" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="uk-modal-body">
                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Nama Akademi</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="name" name="name" type="text" placeholder="Nama Akademi" required>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer">
                <div class="uk-text-center"><button class="uk-button uk-button-primary" type="submit">Simpan</button></div>
            </div>
        </form>
    </div>
</div>
<div id="new-player" class="uk-modal-container uk-flex-top" uk-modal="bg-close:false;">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-outside uk-icon uk-close" type="button" uk-close></button>
        <div class="uk-modal-header"><h4 class="uk-h3 uk-text-center">Tambah Siswa</h4></div>
        <form class="uk-form-horizontal" action="akademi/addstudent" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="uk-modal-body" uk-overflow-auto>
                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Nama Lengkap</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="name" name="name" type="text" placeholder="Nama Lengkap" required>
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
                    <label class="uk-form-label" for="academy">Akademi</label>
                    <div class="uk-form-controls">
                        <select class="uk-select uk-form-width-medium" id="academy" name="academy" aria-label="Posisi" required>
                            <option value=""></option>
                            <?php
                            foreach ($akademi as $academy) {
                                echo '<option value="'.$academy['id'].'">'.$academy['nama'].'</option>';
                            }
                            ?>
                        </select>
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

							url: 'akademi/uploadpic',
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
            </div>
            <div class="uk-modal-footer">
                <div class="uk-text-center"><button class="uk-button uk-button-primary" type="submit">Simpan</button></div>
            </div>
        </form>
    </div>
</div>
<?php
foreach ($players as $player) {
?>
<div id="delete-<?= $player['id']; ?>" class="uk-modal-container uk-flex-top" uk-modal="bg-close:false;">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-outside uk-icon uk-close" type="button" uk-close></button>
        <div class="uk-modal-body"><p class="uk-text-center">Anda yakin akan menghapus siswa <b><?= $player['nama']; ?></b></p></div>
        <div class="uk-modal-footer">
            <div class="uk-flex-center uk-child-width-auto" uk-grid>
                <div><a href="akademi/deletestudent/<?= $player['id']; ?>" class="uk-button uk-button-danger">Hapus</a></div>
                <div><a class="uk-modal-close uk-button uk-button-default">Batal</a></div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>