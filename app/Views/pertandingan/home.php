			<section class="uk-section-small">
				<div class="uk-container">
					<div class="uk-overflow-auto">
						<table class="uk-table uk-table-divider uk-table-hover uk-table-responsive">
							<thead>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th>Tanggal & Waktu</th>
									<th>Stadion</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($matches as $match) { ?>
								<?php
								if ($match['status'] == '1') {
									$status = 'uk-text-success';
								} elseif ($match['status'] == '0') {
									$status = 'uk-text-danger';
								}
								
								foreach ($clubs as $club) {
									if ($club['id'] == $match['opponentid']) {
										$opponent = $club['name'];
									}
								}
								?>
								<tr class="<?php echo $status; ?>">
									<td class="uk-text-right">
										<?php
										if ($match['homeaway'] == '0') {
											echo 'Mataram Utama FC';
										} elseif ($match['homeaway'] == '1') {
											echo $opponent;
										}
										?>
									</td>
									<td class="uk-text-center">
										<?php
										if ($match['status'] == '0') {
											echo '<trong>VS</strong>';
										} elseif ($match['status'] == '1') {
											if ($match['homeaway'] === '0') {
												$goalwon = array_column($goalswon, 'pertandinganid');
												$won = array_count_values($goalwon);
												if (array_key_exists($match['id'], $won)) {
													echo $won[$match['id']];
												} else {
													echo '0';
												}
											} elseif ($match['homeaway'] === '1') {
												$goallost = array_column($goalsconceded, 'pertandinganid');
												$lost = array_count_values($goallost);
												if (array_key_exists($match['id'], $lost)) {
													echo $lost[$match['id']];
												} else {
													echo '0';
												}
											}
											
											echo ' <strong>:</strong> ';
											
											if ($match['homeaway'] === '1') {
												$goalwon = array_column($goalswon, 'pertandinganid');
												$won = array_count_values($goalwon);
												if (array_key_exists($match['id'], $won)) {
													echo $won[$match['id']];
												} else {
													echo '0';
												}
											} elseif ($match['homeaway'] === '0') {
												$goallost = array_column($goalsconceded, 'pertandinganid');
												$lost = array_count_values($goallost);
												if (array_key_exists($match['id'], $lost)) {
													echo $lost[$match['id']];
												} else {
													echo '0';
												}
											}
										}
										?>
									</td>
									<td class="uk-text-left">
										<?php
										if ($match['homeaway'] == '1') {
											echo 'Mataram Utama FC';
										} elseif ($match['homeaway'] == '0') {
											echo $opponent;
										}
										?>
									</td>
									<td>
										<?php
										$strMatchDate = strtotime($match['date']);
										$MatchDate = strftime('%d %B %Y %H:%M', $strMatchDate);
										echo $MatchDate;
										?>
									</td>
									<td>
										<?php echo $match['stadium']; ?>
									</td>
									<td>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					<?= $pager->links('berita', 'custom'); ?>
				</div>
			</section>