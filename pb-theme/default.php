<?php partial('header'); ?>

<ul>
<?php foreach($pb->query() as $page){ ?>
	<li>
		<?php echo '<a href="'.$page->uri.'">'.$page->path.'</a>'; ?>
	</li>
	
	
<?php } ?>
</ul>


<?php echo $pb->current->excerpt; ?>