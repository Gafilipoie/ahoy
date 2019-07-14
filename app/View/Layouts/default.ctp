<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$baseTitle = 'AHOY STUDIOS – Graphic Design and Branding';
			$uriPieces = explode('/', $_SERVER['REQUEST_URI']);
			$uriCategory = (isset($uriPieces[2])) ? strtoupper(implode(" ", explode("-", $uriPieces[2]))) : null;
			$uriProject = (isset($uriPieces[3])) ? strtoupper(implode(" ", explode("-", $uriPieces[3]))) : null;
			$pageTitle = ((isset($uriProject)) ? $uriProject.' | ' : '') . $uriCategory;

			$metaTitle =  empty($pageTitle) ? $baseTitle : $pageTitle . ' --- AHOY STUDIOS';
			$metaDescription = $uriProject.' | '.$uriCategory.' | '.$options['description'];

		?>
		<title><?php echo $metaTitle ?></title>
		<meta name="description" content="<?php echo $metaDescription ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
		<meta name="keywords" content="<?php echo $options['keywords'] ?>" />
		<meta name="author" content="Ahoy Studios" />
		<meta http-equiv="Expires" content="30">

		<!-- SEO purposes -->
		<meta property="og:type" content="Design Studio">
		<meta property="og:image" content="https://ahoystudios.com/img/AHOYlogo.png">
		<meta property="og:title" content="<?php echo $metaTitle ?>">
		<meta property="og:description" content="<?php echo $metaDescription ?>">
		<meta property="og:site_name" content="AHOY STUDIOS">
		<meta property="og:url" content="https://ahoystudios.com">

		<meta name="twitter:card" content="gallery">
		<meta name="twitter:image" content="https://ahoystudios.com/img/AHOYlogo.png">
		<meta name="twitter:title" content="<?php echo $metaTitle ?>">
		<meta name="twitter:description" content="<?php echo $metaDescription ?>">
		<meta name="twitter:site"  content="https://ahoystudios.com">
		<meta name="twitter:url" content="https://ahoystudios.com">
		<!-- SEO purposes -->

		<?php echo $this->Html->charset(); ?>
		<?php echo $this->Html->css(array('_combinedStyles.min')); ?>
	</head>
	 <body style="background: #fff url('/img/<?php echo $options['background_image'] ?>');">
		<h1 class="hidden"><?php echo $metaTitle ?></h1> <!-- For SEO purposes -->
		<h2 class="hidden">Founded by Connie Koch and Aline Ozkan</h2> <!-- For SEO purposes -->
		<p id="mobile-logo">AHOY</p>

		<header id="mobile-menu">
			<ul>
				<?php foreach($categories as $category): ?>
					<li>
						<!-- category button -->
						<?php if ($category['Category']['type'] == 'projects'): ?>
							<a
								href="/category/<?php echo $category['Category']['slug'] ?>"
								rel="category"
								title="<?php echo $category['Category']['name_en'] ?>"
							>
								<?php echo $category['Category']['name_en'] ?>
							</a>
						<?php endif; ?>
						<!-- tabs button -->
						<?php if ($category['Category']['type'] == 'tabs'): ?>
							<a
								href="/tabs/<?php echo $category['Category']['slug'] ?>"
								rel="tabs"
								data-url="<?php echo Router::url(array('controller' => 'tabs','action' => 'view', $category['Category']['slug']),true); ?>"
								title="<?php echo $category['Category']['name_en'] ?>"
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
		</header>

		<div id="container">
			<header id="left-column">
				<?php echo $this->Html->link(
					$this->Html->image('AHOYlogo.png', ['alt' => 'AHOY logo']),
					'/',
					['escape' => false, 'id' => 'logo', 'title' => 'AHOY']
				); ?>

				<div id="move-menu">
					<ul id="menu">
						<?php foreach($categories as $category): ?>
							<li style="color: <?php echo $options['primary_text_color'] ?>;">
								<!-- category button -->
								<?php if ($category['Category']['type'] == 'projects'): ?>
									<a
										href="/category/<?php echo $category['Category']['slug']; ?>"
										rel="category"
										data-catid="<?php echo $category['Category']['id']; ?>"
										title="<?php echo $category['Category']['name_en']; ?>"
									>
										<?php echo $category['Category']['name_en']; ?>
									</a>
									<div class="hidden">
										<?php $prcass = $catProjects[$category['Category']['id']]; ?>
										<?php foreach ($prcass as $pra): ?>
											<?php $tpa = "/category/".$category['Category']['slug']."/".strtolower($pra['Project']['slug']); ?>
											<a
												href="<?php echo $tpa; ?>"
												rel="project-content"
												data-slug="<?php echo strtolower($pra['Project']['slug']); ?>"
												data-base="<?php echo $category['Category']['slug']; ?>"
												data-baseid="<?php echo $category['Category']['id']; ?>"
												title="<?php echo $pra['Project']['name_en']; ?>"
											>
												<?php echo $pra['Project']['name_en']; ?>
											</a>
										<?php endforeach; ?>

									</div>
								<?php endif; ?>
								<!-- tabs button -->
								<?php if ($category['Category']['type'] == 'tabs'): ?>
									<a href="/tabs/<?php echo $category['Category']['slug'] ?>"
										 rel="tabs"
										 data-url = "<?php echo Router::url(array('controller' => 'tabs','action' => 'view', $category['Category']['slug']),true); ?>";
										 title="<?php echo $category['Category']['name_en'] ?>"
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
					<div id="social-instagram-wrapper">
						<a
							id="social-instagram"
							href="https://www.instagram.com/ahoystudios/"
							target="_BLANK"
							title="Instagram"
						>
							<img class="social-instagram-grey" src="/img/instagram-grey.png" alt="instagram-ico" />
							<img class="social-instagram-black" src="/img/instagram-black.png" alt="instagram-ico" />
						</a>
					</div>
				</div>

				<div id="social">
					<a
						id="email-address"
						href="mailto:<?php echo $options['email_address'] ?>"
						style="color: <?php echo $options['primary_text_color'] ?>; border-bottom: 1px solid <?php echo $options['primary_text_color'] ?>;"
						title="Email Adress"
					>
						<?php echo $options['email_address'] ?>
					</a>
					<?php if ($options['facebook_link']): ?>
						<a
							href="<?php echo $options['facebook_link'] ?>"
							target="_blank"
							title="Facebook"
						>
							<?php echo $this->Html->image('facebook_icon.png', array('width' => 20, 'height' => 20, 'alt' => 'facebook')) ?>
						</a>
					<?php endif; ?>
				</div>
			</header>

			<?php echo $this->fetch('content'); ?>
		</div>

		<?php
			echo $this->Html->script(array(
				'https://api.html5media.info/1.1.5/html5media.min.js',
				'_combinedScript.min'
			), array('defer' => true));
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

		<script type="text/javascript">
			var json_options = <?php echo htmlspecialchars_decode($json_options); ?>;
			var json_settings = <?php echo htmlspecialchars_decode($json_settings); ?>;
			var cakeRoot = '<?php echo Router::url('/', true); ?>';
		</script>
	</body>
</html>
