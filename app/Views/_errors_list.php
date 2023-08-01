<div class="uk-alert-danger" uk-alert role="alert">
	<a class="uk-alert-close uk-text-danger" uk-close></a>
    <ul uk-margin-remove>
    <?php foreach ($errors as $error) : ?>
        <li><?= esc($error) ?></li>
    <?php endforeach ?>
    </ul>
</div>