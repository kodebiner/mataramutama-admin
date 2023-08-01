			<section class="uk-section">
				<div class="uk-container">
					<div class="uk-child-width-1-2@m" uk-grid>
						<div>
							<h3>Berita Terbaru</h3>
							<ul class="uk-list">
							<?php
							foreach ($berita as $news) {
								echo '<li><a href="berita">'.$news['title'].'</a></li>';
							}
							?>
							</ul>
						</div>
					</div>
				</div>
			</section>