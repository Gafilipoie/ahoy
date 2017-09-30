<div id="text-container">
	
	<div id="loader"></div>

	<div id="text-lhover">
		<div class="text-prev"><span></span></div>
		<div class="text-next"><span></span></div>	
		<ul class="text-pagination">
			<?php foreach($category['Tab'] as $tab): ?>
			<li></li>
			<?php endforeach; ?>
		</ul>			
	</div>		

	<div id="text-rhover">
		<div class="text-prev"><span></span></div>
		<div class="text-next"><span></span></div>
		<ul class="text-pagination">
			<?php foreach($category['Tab'] as $tab): ?>
			<li></li>
			<?php endforeach; ?>
		</ul>				
	</div>	

	<ul id="text-slider">
		<?php foreach ($category['Tab'] as $tab): ?>
		<li>
			<h3><span><?php echo $tab['Tab']['name_en'] ?></span></h3>
			<div>
			<?php foreach ($tab['Content'] as $content): ?>
				<?php if ($content['type'] == 'image'): ?>
					<?php 
						if($is_iPhone == 1){
							echo $this->Html->image( Router::url('/',true).'img/uploads/timthumb/timthumb.php?src=../' . $content['image'] .'&q=100&w=250&h=167' , array( 'alt' =>  $tab['Tab']['name_en'])); 
						}	
						else{
							if($is_iPad == 1){
								echo $this->Html->image( Router::url('/',true).'img/uploads/timthumb/timthumb.php?src=../' . $content['image'] .'&q=100&w=560&h=375' , array( 'alt' =>  $tab['Tab']['name_en'])); 
							}
							else{
								echo $this->Html->image('uploads/' . $content['image'], array( 'alt' =>  $tab['Tab']['name_en'])); 
							}
						}
					?>
				<?php endif ?>

				<?php if ($content['type'] == 'text'): ?>
					<div class="text clearfix">
						<div class="en"><?php echo $content['text_en'] ?></div>
						<div class="de"><?php echo $content['text_de'] ?></div>
					</div
				<?php endif ?>
			
			<?php endforeach ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>


<div id="vertical-container">

	<div id="vertical-lhover">
		<div class="vertical-prev"><span></span></div>
		<div class="vertical-next"><span></span></div>	
		<ul class="vertical-pagination"></ul>	
	</div>		

	<div id="vertical-rhover">
		<div class="vertical-prev"><span></span></div>
		<div class="vertical-next"><span></span></div>
		<ul class="vertical-pagination"></ul>	
	</div>		

	<div id="vertical-slider">	
		<ul>	

		</ul>
	</div>

</div>




<div id="horizontal-container">

	<div id="horizontal-thover">
		<div class="horizontal-prev"><span></span></div>
		<div class="horizontal-next"><span></span></div>	
		<ul class="horizontal-pagination"></ul>		
	</div>		

	<div id="horizontal-bhover">
		<div class="horizontal-prev"><span></span></div>
		<div class="horizontal-next"><span></span></div>		
		<ul class="horizontal-pagination"></ul>	
	</div>		


	<div id="horizontal-slider" class="clearfix">	

		<div id="hover-slide"><h3>BACK TO PROJECTS</h3></div>

		<ul class="clearfix">

		</ul>
	</div>
</div>	