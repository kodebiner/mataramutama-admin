<ul class="uk-pagination uk-flex-right uk-margin-medium-top" uk-margin>
	<?php if ($pager->hasPrevious()) : ?>
	<li>
		<a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" uk-icon="chevron-double-left"></a>
	</li>
	<li>
		<a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" uk-icon="chevron-left"></a>
	</li>
	<?php endif ?>
	
	<?php foreach ($pager->links() as $link) : ?>
	<li <?= $link['active'] ? 'class="uk-active"' : '' ?>>
		<?php if ($link['active']) {
			echo '<span>'.$link['title'].'</span>';
		} else {
			echo '<a href="'.$link['uri'].'">'.$link['title'].'</a>';
		} ?>
	</li>
	<?php endforeach ?>
	
	<?php if ($pager->hasNext()) : ?>
	<li>
		<a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" uk-icon="chevron-right"></a>
	</li>
	<li>
		<a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" uk-icon="chevron-double-right"></a>
	</li>
	<?php endif ?>
</ul>