			<footer class="uk-light" style="padding: 20px; background-color:#727272;">
				<div class="uk-child-width-1-3@l" uk-grid uk-height-match="target: > div > .footer-height">
					<div>
						<div class="footer-height uk-flex uk-flex-center">
							<a href="<?php echo base_url(); ?>">
								<img data-src="images/logo.png" width="100" height="100" uk-img />
							</a>
						</div>
					</div>
					<div>
						<div class="footer-height uk-flex uk-flex-bottom uk-flex-center">
							<?php
							function auto_copyright($year = 'auto'){
								if(intval($year) == 'auto'){ $year = date('Y'); }
								if(intval($year) == date('Y')){ echo intval($year); }
								if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
								if(intval($year) > date('Y')){ echo date('Y'); }
							} ?>
							<span class="uk-text-small">Copyright &copy <?php auto_copyright('2021'); ?>. Mataram Utama FC</span>
						</div>
					</div>
				</div>
			</footer>