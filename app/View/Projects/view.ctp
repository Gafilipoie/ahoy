<div id="text-container">
	<div id="loader"></div>
	<div id="text-lhover">
		<div class="text-prev"><span></span></div>
		<div class="text-next"><span></span></div>	
		<ul class="text-pagination"></ul>		
	</div>		
	<div id="text-rhover">
		<div class="text-prev"><span></span></div>
		<div class="text-next"><span></span></div>	
		<ul class="text-pagination"></ul>		
	</div>	
	<ul id="text-slider">
	</ul>
</div>

<div id="vertical-container">

	<div id="vertical-lhover">
		<div class="vertical-prev"><span></span></div>
		<div class="vertical-next"><span></span></div>		
	<ul class="vertical-pagination">
			<?php 
			$i = 0;
			foreach($category['Project'] as $project): $i++; ?>
				<li <?php if($i==1) echo 'class="active"'; ?>></li>
			<?php endforeach; ?>
			<?php if($category['Category']['active_slide'] == true) echo '<li></li>'?>
		</ul>	
	</div>		

	<div id="vertical-rhover">
		<div class="vertical-prev"><span></span></div>
		<div class="vertical-next"><span></span></div>
		<ul class="vertical-pagination">
			<?php 
			$i = 0;
			foreach($category['Project'] as $project): $i++; ?>
				<li <?php if($i==1) echo 'class="active"'; ?>></li>
			<?php endforeach; ?>
			<?php if($category['Category']['active_slide'] == true) echo '<li></li>'?>
		</ul>	
	</div>			

	<div id="vertical-slider">	
		<ul>	
			
		<?php  if($category['Category']['active_slide'] == true): ?>
			<li>
			
				<div class="text" style="background-color: <?php  echo '#'.$category['Category']['bgcolor']?>; ">
					<div>
						<h3><?php echo $category['Category']['name_en'] ?></h3>
						<div class="en">
							<?php echo $category['Category']['text_en'] ?>
						</div>
						<div class="de">
							<?php echo $category['Category']['text_de'] ?>
						</div>
					</div>
				</div>
			</li>
		<?php  endif; ?>

		<?php foreach($category['Project'] as $project): ?>

			<!-- <li>
				<a link="<?php echo Router::url(array('controller' => 'slides', 'action' => 'view',$project['Project']['slug'] ),true) ?>">
					<?php 
						if($is_iPhone == 1){
							//echo $this->Html->image( Router::url('/',true).'img/uploads/timthumb/timthumb.php?src=../' . $project['Slide']['image'] .'&q=90&w=250&h=167' , 
							echo $this->Html->image( Router::url('/',true).'img/uploads/iphone/' . $project['Slide']['image'] , 
							array( 'alt' =>  $project['Project']['name_en'])); 
						}	
						else{
							if($is_iPad == 1){
								echo $this->Html->image( Router::url('/',true).'img/uploads/ipad/' . $project['Slide']['image'] , 
								array( 'alt' =>  $project['Project']['name_en'])); 
							}
							else{
								echo $this->Html->image('uploads/' .$project['Slide']['image'], array( 'alt' =>  $project['Project']['name_en'])); 
							}
						}
					?>
				</a>
				<h5><span><?php echo $project['Project']['name_en'] ?> /</span> <?php echo $project['Project']['name_de'] ?></h5>
			</li> -->

		<?php endforeach; ?>

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