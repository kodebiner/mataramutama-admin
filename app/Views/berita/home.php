			<section class="uk-section">
				<div class="uk-container uk-container-small">
					<div class="uk-clearfix" uk-height-match>
						<div class="uk-float-left uk-flex uk-flex-middle">
							<a class="uk-button uk-button-primary" href="berita/new">Buat Berita Baru</a>
						</div>
						<div class="uk-float-right uk-flex uk-flex-middle">
							<div>
								View: <a href="berita/view/15">15</a> <a href="berita/view/20">20</a> <a href="berita/view/25">25</a>
							</div>
						</div>
					</div>
					<table class="uk-table uk-table-small uk-table-hover uk-table-middle">
						<thead>
							<tr>
								<th class="uk-table-expand">Judul</th>
								<th class="uk-table-small uk-text-nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($berita as $news) { ?>
							<tr>
								<td class="uk-table-link"><a class="uk-link-reset" href="berita/edit/<?php echo $news['id']; ?>"><?php echo $news['title']; ?></a></td>
								<td><a href="berita/edit/<?php echo $news['id']; ?>" style="padding:3px;"uk-icon="icon: file-edit"></a><a class="uk-text-danger" href="#delete-<?php echo $news['id']; ?>" style="padding:3px;"uk-icon="icon: trash" uk-toggle></a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?= $pager->links('berita', 'custom'); ?>
				</div>
			</section>
			<?php foreach ($berita as $news) { ?>
			<div id="delete-<?php echo $news['id']; ?>" class="uk-flex-top" uk-modal="esc-close:false; bg-close:false;">
				<div class="uk-modal-dialog uk-margin-auto-vertical">
					<div class="uk-modal-body">
						<p>Apakah anda yakin akan menghapus berita berjudul <strong>"<?php echo $news['title']; ?>"</strong>?</p>
					</div>
					<div class="uk-modal-footer">
						<div class="uk-child-width-1-2" uk-grid>
							<div class="uk-text-center">
								<button class="uk-button uk-modal-close" type="button">Batal</button>
							</div>
							<div class="uk-text-center">
								<button class="uk-button uk-button-danger" onclick="window.location='/berita/remove/<?php echo $news['id']; ?>'" type="button">Hapus</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>