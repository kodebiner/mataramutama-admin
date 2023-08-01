<section class="uk-section uk-section-small">
    <div class="uk-container">
        <?php if ($mobile === true) { ?>
            <h1 class="uk-h3">Daftar Pelatih</h1>
            <button class="uk-button uk-button-primary" uk-toggle="target: #new-official" type="button">+ Tambah Pelatih</button>
        <?php } else { ?>
            <div class="uk-margin uk-child-width-auto uk-flex-between" uk-grid>
                <div><h1 class="uk-h3">Daftar Pelatih</h1></div>
                <div><button class="uk-button uk-button-primary" uk-toggle="target: #new-official" type="button">+ Tambah Pelatih</button></div>
            </div>
        <?php } ?>
        <div id="new-official" class="uk-flex-top" uk-modal="bg-close: false;">
            <div class="uk-modal-dialog uk-margin-auto-vertical">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Tambah Pelatih Baru</h3>
                </div>
                <form class="uk-form-horizontal" action="tim/simpanpelatih" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="uk-modal-body" uk-overflow-auto>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="fullname">Nama Lengkap</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="fullname" name="fullname" type="text" placeholder="Nama Lengkap">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="position">Posisi</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="position" name="position" type="text" placeholder="Posisi">
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

                                    url: 'tim/uploadofficial',
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
                                        img.setAttribute('src', 'https://mataramutama.com/images/official/' +filename);
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
                        <div class="uk-text-right">
                            <button class="uk-button uk-button-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-small uk-table-hover uk-table-divider">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th class="uk-text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($officials as $pelatih) {
                    ?>
                    <tr>
                        <td><?= $pelatih['name'] ?></td>
                        <td><?= $pelatih['position'] ?></td>
                        <td class="uk-grid-small uk-child-width-auto uk-flex-center" uk-grid>
                            <div><a href="tim/editpelatih/<?= $pelatih['id']; ?>" class="uk-icon-link" uk-icon="file-edit"></a></div>
                            <div><a href="tim/editpemain/<?= $pelatih['id']; ?>" class="uk-icon-link" uk-icon="trash"></a></div>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>