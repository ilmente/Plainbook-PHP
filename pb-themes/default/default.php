<?php $theme->render('partials/header'); ?>
		
		<div id="main">
			<div class="contents inner">
				<?php echo $data->current->content; ?>

				<?php var_dump($data->current->meta->tags->toJSON()); ?>
			</div>
		</div>

<?php $theme->render('partials/footer'); ?>
