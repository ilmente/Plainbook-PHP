<?php $settings = $data->get('#settings'); ?>

			<footer>
				<div class="inner">
					<div class="contents">
						&copy; ilmente.it, 2006 - <?php echo date('Y'); ?>
						<span class="separator">//</span>
						happily made with <a href="https://github.com/ilmente/Plainbook" target="_blank">plainbook</a>
					</div>
				</div>
			</footer>
		</div>

		<!-- Big G analytics -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php echo $settings->meta->ga_code; ?>', '<?php echo $settings->meta->ga_name; ?>');
			ga('send', 'pageview');
		</script>
	</body>
</html>