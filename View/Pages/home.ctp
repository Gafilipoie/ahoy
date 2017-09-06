<?php
if($isRobot) {
	//var_dump($data_robot);
	//print_r($tabs_robot);

	if(isset($tabs_robot)) foreach ($tabs_robot as $value) {
		echo '<h1>'.$value['Tab']['name_en'].' - '. $value['Category']['name_en'] .'</h1>';
		echo '<section>';
		foreach ($value['Content'] as $slide) {
			//$slide = $slide['Slide'];
			echo '<p>'.$slide['text_en'].'</p>';
			if($slide['type'] == 'image') {
				$imageAlt = ((isset($slide['image_alt']) && !empty($slide['image_alt'])) ? $slide['image_alt'] : 'AHOY studios '.$value['Tab']['name_en']);
				$imageTitle = ((isset($slide['image_title']) && !empty($slide['image_title'])) ? $slide['image_title'] : $slide['text_en']);
				echo '<img src="http://www.ahoystudios.com/img/uploads/desktop/'.$slide['image'].'" alt="'.$imageAlt.'" title="'.$imageTitle.'" />';
				//echo '<img src="http://www.ahoystudios.com/img/uploads/desktop/'.$slide['image'].'" alt="'.'AHOY studios '.$value['Tab']['name_en'].'" title="'.$slide['text_en'].'" />';
			} else if($slide['type'] == 'text') {
				echo '<article>';
				echo $slide['text_en'];
				echo $slide['text_de'];
				echo '</article>';
			}
		}
		echo '</section>';
	}

	if(isset($data_robot)) foreach ($data_robot as $value) {
		echo '<h1>'.$value['Category']['name_en'].' - '.$value['Category']['name_de'].'</h1>';
		echo '<h1>'.$value['Project']['name_en'].' - '.$value['Project']['name_de'].'</h1>';
		echo '<section>';
		foreach ($value['Project']['Slides'] as $slide) {
			$slide = $slide['Slide'];
			echo '<p>'.$slide['text_en'].'</p>';
			if($slide['type'] == 'image') {
				$imageAlt = ((isset($slide['image_alt']) && !empty($slide['image_alt'])) ? $slide['image_alt'] : 'AHOY studios '.$value['Project']['name_en']);
				$imageTitle = ((isset($slide['image_title']) && !empty($slide['image_title'])) ? $slide['image_title'] : $slide['text_en']);
				echo '<img src="http://www.ahoystudios.com/img/uploads/desktop/'.$slide['image'].'" alt="'.$imageAlt.'" title="'.$imageTitle.'" />';
			} else if($slide['type'] == 'text') {
				echo '<article>';
				echo $slide['text_en'];
				echo $slide['text_de'];
				echo '</article>';
			}
		}
		echo '</section>';
	}



}
?>
<div id="text-container">
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
	<ul id="text-slider"></ul>
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
	<div id="v-hover-prev"></div>
	<div id="v-hover-next"></div>
	<div id="vertical-slider">
		<ul>
			<li>
				<div>
					<div class="text">
						<div>
							<h3>our best</h3>
							<div class="en">
								<p>
									<span>Our favorite projects.</span>
									<br>
									<span>To navigate, scroll up or down.
										<br>Click on center image&nbsp;to view project.
										<br>Scroll left or right for more.
										<br>Change category on your left.
										<br>Repeat &amp; enjoy!
									</span>
								</p>
							</div>
							<div class="de">
								<p>
									<span>Unsere Lieblings-Projekte.</span>
									<br>
									<span>Einfach nach oben oder unten scrollen.
										<br>Bild in der Mitte clicken,
										<br>
									</span>
									<span>dann rechts oder links navigieren.
										<br>Repeat &amp; enjoy!
									</span>
								</p>
							</div>
						</div>
					</div>
				</div>
			</li>
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
	<div id="h-hover-prev"></div>
	<div id="h-hover-next"></div>
	<div id="horizontal-slider" class="clearfix">
		<ul class="clearfix">
		</ul>
	</div>
</div>
<div id="loader"></div>
