<h4 class="categories">SETTINGS</h4>
<?php

$options = array(
	'linear' => 'linear',
	'swing' => 'swing',
	'easeInQuad' => 'easeInQuad',
	'easeOutQuad' => 'easeOutQuad',
	'easeInOutQuad' => 'easeInOutQuad',
	'easeInCubic' => 'easeInCubic',
	'easeOutCubic' => 'easeOutCubic',
	'easeInOutCubic' => 'easeInOutCubic',
	'easeInQuart' => 'easeInQuart',
	'easeInOutQuart' => 'easeInOutQuart',
	'easeInQuint' => 'easeInQuint',
	'easeOutQuint' => 'easeOutQuint',
	'easeInOutQuint' => 'easeInOutQuint',
	'easeInSine' => 'easeInSine',
	'easeOutSine' => 'easeOutSine',
	'easeInOutSine' => 'easeInOutSine',
	'easeInExpo' => 'easeInExpo',
	'easeOutExpo' => 'easeOutExpo',
	'easeInOutExpo' => 'easeInOutExpo',
	'easeInCirc' => 'easeInCirc',
	'easeOutCirc' => 'easeOutCirc',
	'easeInOutCirc' => 'easeInOutCirc',
	'easeInElastic' => 'easeInElastic',
	'easeOutElastic' => 'easeOutElastic',
	'easeInOutElastic' => 'easeInOutElastic',
	'easeInBack' => 'easeInBack',
	'easeOutBack' => 'easeOutBack',
	'easeInOutBack' => 'easeInOutBack',
	'easeInBounce' => 'easeInBounce',
	'easeOutBounce' => 'easeOutBounce',
	'easeInOutBounce' => 'easeInOutBounce',
	);


echo $this->Form->create('Setting', array('class' => 'category-edit settings' ));



$i = 0;
foreach ($settings as $setting){
	$i++;
	if($setting['Setting']['type'] == 'easing'){
		echo $this->Form->input('Setting.'.$i.'.value', array( 'label' => $setting['Setting']['name'] ,'value' => $setting['Setting']['value'], 'options' => $options ));
	}
	else{
		echo $this->Form->input('Setting.'.$i.'.value', array('type' => 'text', 'label' => $setting['Setting']['name'] ,'value' => $setting['Setting']['value'] ));
	}
	echo $this->Form->input('Setting.'.$i.'.id', array('type' => 'hidden', 'value' => $setting['Setting']['id'] ));

}

echo $this->Form->submit('SAVE');
?>


<p style="text-align: right; font-size: 14px;">Click <a href="http://jqueryui.com/demos/effect/easing.html" target="_blank">here</a> for easing examples. </p>
<p style="text-align: right; font-size: 10px;">Note: Time is set in miliseconds (1000 miliseconds = 1 second).</p>


<?php

echo $this->Form->end();



?>
