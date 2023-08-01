			<section class="uk-section-small">
				<div class="uk-container uk-container-small" uk-height-viewport="offset-top: true; offset-bottom: .uk-light;">
					<form action="/galeri/editvideo/<?php echo $video['id'] ?>" name="editvideo" class="uk-form uk-form-horizontal" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
						<div class="uk-margin">
							<label class="uk-form-label" for="judul">Judul Video</label>
							<div class="uk-form-controls">
								<input class="uk-input" id="judul" name="judul" type="text" placeholder="Judul Galeri" value="<?php echo $video['title'] ?>" required>
							</div>
						</div>
						<hr class="uk-divider-icon"/>						
						<div class="uk-margin">
							<label class="uk-form-label" for="videoid">Video ID</label>
							<div class="uk-form-controls">
								<input class="uk-input" id="videoid" name="videoid" type="text" placeholder="Judul Galeri" value="<?php echo $video['videoid'] ?>" required>
								<div class="uk-text-meta">https://www.youtube.com/watch?v=<strong class="uk-text-success">VIDEO ID</strong></div>
							</div>
						</div>
						<div class="uk-margin">
							<div id="preview" class="uk-form-controls">
								<img id="image-preview" class="uk-width-1-1" src="https://img.youtube.com/vi/<?php echo $video['videoid'] ?>/maxresdefault.jpg" />
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
						<div class="uk-margin uk-flex uk-flex-right">
							<div>
								<button class="uk-button uk-button-default" id="submit" type="submit" name="submit" value="save">Save</button>
							</div>
						</div>
					</form>
				</div>
			</section>