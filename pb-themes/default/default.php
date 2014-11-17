<?php $theme->render('partials/header'); ?>
		
		<div id="main">
			<div class="contents inner">
				<?php echo $data->current->content; ?>
			</div>
		</div>

<?php $theme->render('partials/footer'); ?>
