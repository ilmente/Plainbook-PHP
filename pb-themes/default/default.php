<?php $theme->render('partials/header'); ?>
		
<div id="main">
	<div class="content">
		<?php echo $data->current->content; ?>
		<hr>
		<?php var_dump($data->current); ?>
		<hr>
		tag
		<?php var_dump($data->current->tags); ?>
		<hr>
		ex
		<?php var_dump($data->current->excerpt); ?>
		<hr>
	</div>
</div>

<?php $theme->render('partials/footer'); ?>
