<!DOCTYPE html>
<html >
	<head>
		<?php echo $this->Html->charset(); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
		<title>AHOY STUDIOS – Graphic Design – NEW YORK / ZURICH / BERLIN</title>
      <meta name="description" content="<?php echo $options['description'] ?>" />
      <meta name="keywords" content="<?php echo $options['keywords'] ?>" />
      <meta name="author" content="Ahoy Studios" />

		<?php
			echo $this->Html->css('boilerplate');
			echo $this->Html->css('style');
			echo $this->Html->css('video-js');


      echo $this->Html->script('video.min.js');
      echo $this->Html->script('modernizr.touch.js');
		?>
			<!--<link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">-->
			<!--<script src="http://vjs.zencdn.net/c/video.js"></script>-->
	  <script src="https://api.html5media.info/1.1.5/html5media.min.js"></script>
	</head>
	<body style="background: #fff url('../img/<?php echo $options['background_image'] ?>');">

			<h1 id="mobile-logo">AHOY</h1>

			<div id="mobile-menu">

				<ul>
					<?php foreach($categories as $category): ?>
							<li>

								<!-- category button -->
								<?php if ($category['Category']['type'] == 'projects'): ?>
									<a href="/category/<?php echo $category['Category']['slug'] ?>" rel="category">
										<?php echo $category['Category']['name_en'] ?>
									</a>
								<?php endif; ?>
								<!-- tabs button -->
								<?php if ($category['Category']['type'] == 'tabs'): ?>
									<a href="/tabs/<?php echo $category['Category']['slug'] ?>"
										 rel="tabs"
										 data-url = "<?php echo Router::url(array('controller' => 'tabs','action' => 'view', $category['Category']['slug']),true); ?>";
										>
										<?php echo $category['Category']['name_en'] ?>
									</a>
								<?php endif; ?>
								<!-- inactive button -->
								<?php if ($category['Category']['type'] == 'inactive'): ?>
									<span><?php echo $category['Category']['name_en'] ?></span>
								<?php endif; ?>

							</li>
						<?php endforeach; ?>
				</ul>
			</div>

		<div id="container">
			<div id="left-column">
				<!-- <?php echo $this->Html->link('AHOY', '/', array('id' => 'logo', 'title' => 'AHOY') ) ?> -->
				<?php echo $this->Html->link(
				    $this->Html->image('AHOYlogo.png', ['alt' => '']),
				    '/',
				    ['escape' => false, 'id' => 'logo', 'title' => 'AHOY']
				); ?>
				<div id="move-menu">

					<ul id="menu">
						<?php foreach($categories as $category): ?>
							<li style="color: <?php echo $options['primary_text_color'] ?>;">

								<!-- category button -->
								<?php if ($category['Category']['type'] == 'projects'): ?>
									<a href="/category/<?php echo $category['Category']['slug']; ?>" rel="category" data-catid="<?php echo $category['Category']['id']; ?>">
										<?php echo $category['Category']['name_en']; ?>
									</a>
									<div style="display:none;">
										<?php $prcass = $catProjects[$category['Category']['id']]; ?>
										<?php foreach ($prcass as $pra): ?>
											<?php $tpa = "/category/".$category['Category']['slug']."/".strtolower($pra['Project']['slug']); ?>
											<a href="<?php echo $tpa; ?>" rel="project-content" data-slug="<?php echo strtolower($pra['Project']['slug']); ?>" data-base="<?php echo $category['Category']['slug']; ?>" data-baseid="<?php echo $category['Category']['id']; ?>"><?php echo $pra['Project']['name_en']; ?></a>
										<?php endforeach; ?>

									</div>
								<?php endif; ?>
								<!-- tabs button -->
								<?php if ($category['Category']['type'] == 'tabs'): ?>
									<a href="/tabs/<?php echo $category['Category']['slug'] ?>"
										 rel="tabs"
										 data-url = "<?php echo Router::url(array('controller' => 'tabs','action' => 'view', $category['Category']['slug']),true); ?>";
										>
										<?php echo $category['Category']['name_en'] ?>
									</a>
								<?php endif; ?>
								<!-- inactive button -->
								<?php if ($category['Category']['type'] == 'inactive'): ?>
									<span><?php echo $category['Category']['name_en'] ?></span>
								<?php endif; ?>

							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div id="social">
					<a id="email-address" href="mailto:<?php echo $options['email_address'] ?>" style="color: <?php echo $options['primary_text_color'] ?>; border-bottom: 1px solid <?php echo $options['primary_text_color'] ?>;"><?php echo $options['email_address'] ?></a>
					<a href="<?php echo $options['facebook_link'] ?>" target="_blank"><?php echo $this->Html->image('facebook_icon.png', array('width' => 20, 'height' => 20, 'alt' => 'facebook')) ?></a>
				</div>
			</div>

			<?php echo $this->fetch('content'); ?>

		</div>

		<script type="text/javascript">
			var json_options = <?php echo htmlspecialchars_decode($json_options); ?>;
			var json_settings = <?php echo htmlspecialchars_decode($json_settings); ?>;
			var cakeRoot = '<?php echo Router::url('/', true); ?>';
		</script>

		<?php
			echo $this->Html->script('jquery');
			echo $this->Html->script('imagesloaded');
			//echo $this->Html->script('video.min');

			//echo $this->Html->script('routie.min');
			echo $this->Html->script('jquery.router.min');
			echo $this->Html->script('Object.Slider.Vertical');
			echo $this->Html->script('Object.Slider.Horizontal');
			echo $this->Html->script('Object.Slider.Text');
			echo $this->Html->script('script');
		?>
		<?php if(!empty($options['google_analytics'])): ?>
	        <script type="text/javascript">

	          var _gaq = _gaq || [];
	          _gaq.push(['_setAccount', '<?php echo $options["google_analytics"] ?>']);
	          _gaq.push(['_trackPageview']);

	          (function() {
	            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	          })();
	        </script>
	    <?php endif;?>
	</body>
</html>
