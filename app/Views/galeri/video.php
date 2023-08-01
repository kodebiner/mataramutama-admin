			<section class="uk-section-small">
				<div class="uk-container uk-container-small">
					<div class="uk-margin">
						<a class="uk-button uk-button-primary" href="#newvideo" uk-toggle><span uk-icon="icon: plus; ratio: 0.5;"></span> Video Baru</a>
					</div>
					<table class="uk-table uk-table-small uk-table-hover uk-table-middle">
						<thead>
							<tr>
								<td>Judul</td>
								<td>Video ID</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($videos as $video) { ?>
							<tr>
								<td><?php echo $video['title']; ?></td>
								<td><?php echo $video['videoid']; ?></td>
								<td><a href="galeri/editvideo/<?php echo $video['id']; ?>" style="padding:3px;" uk-icon="icon: file-edit"></a><a class="uk-text-danger" href="#delete-<?php echo $video['id']; ?>" style="padding:3px;"uk-icon="icon: trash" uk-toggle></a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?= $pager->links('video', 'custom'); ?>
				</div>
			</section>
			<?php foreach ($videos as $video) { ?>
			
			<div id="delete-<?php echo $video['id']; ?>" class="uk-flex-top" uk-modal="bg-close: false;">
				<div class="uk-modal-dialog uk-margin-auto-vertical">
					<div class="uk-modal-body">
						<img class="uk-width-1-1" src="https://img.youtube.com/vi/<?php echo $video['videoid']; ?>/maxresdefault.jpg" />
						<div>
							<p>Apakah anda yakin akan menghapus video berjudul <strong>"<?php echo $video['title']; ?>"</strong>?</p>
						</div>
					</div>
					<div class="uk-modal-footer">
						<div class="uk-child-width-1-2" uk-grid>
							<div class="uk-text-center">
								<button class="uk-button uk-modal-close" type="button">Batal</button>
							</div>
							<div class="uk-text-center">
								<button class="uk-button uk-button-danger" onclick="window.location='/galeri/removevideo/<?php echo $video['id']; ?>'" type="button">Hapus</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<div id="newvideo" class="uk-flex-top" uk-modal="bg-close: false;">
				<div class="uk-modal-dialog uk-margin-auto-vertical">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<div class="uk-modal-header">
						<h2 class="uk-modal-title">Tambah Video Baru</h2>
					</div>
					<div class="uk-modal-body">
						<form action="/galeri/video" name="videobaru" class="uk-form uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
							<div class="uk-margin">
								<label class="uk-form-label" for="judul">Judul Video</label>
								<div class="uk-form-controls">
									<input class="uk-input" id="judul" name="judul" type="text" placeholder="Judul Galeri" required>
								</div>
							</div>
							<div class="uk-margin">
								<label class="uk-form-label" for="videoid">Video ID</label>
								<div class="uk-form-controls">
									<input class="uk-input" id="videoid" name="videoid" type="text" placeholder="" required>
									<div class="uk-text-meta">https://www.youtube.com/watch?v=<strong class="uk-text-success">VIDEO ID</strong></div>
								</div>
							</div>
							<div class="uk-margin">
								<div id="preview" class="uk-form-controls">
								</div>
							</div>
							<script>
								const input = document.querySelector('#videoid');
								var preview = document.getElementById('preview');
								
								input.addEventListener('change', updateValue);
								
								function updateValue(e) {
									if (document.getElementById("image-preview") != null) {
										document.getElementById("image-preview").remove();
									}
									
									var value = input.value;
									
									var imagepreview = document.createElement("img");
									imagepreview.setAttribute('id', 'image-preview');
									imagepreview.setAttribute('class', 'uk-width-1-1');
									imagepreview.setAttribute('src', 'https://img.youtube.com/vi/'+value+'/maxresdefault.jpg');
									
									preview.appendChild(imagepreview);
								}
							</script>
							<div class="uk-margin">
								<button class="uk-button uk-botton-default" type="submit" name="submit" value="addvideo">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>