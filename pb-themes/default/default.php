<?php $theme->render('partials/header'); ?>
		
<div id="main">
	<div class="content">
		<?php echo $data->current->content; ?>
		<?php if ($data->get('#test')->exists) echo $data->get('#test')->content; ?>
	</div>
</div>

<?php $theme->render('partials/footer'); ?>
