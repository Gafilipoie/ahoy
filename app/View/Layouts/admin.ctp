<!DOCTYPE html>
<html>
    <head>
        <title>Ahoy</title>
		<?php
			echo $this->Html->css('admin');
			echo $this->Html->css('fileuploader');
			echo $this->Html->css('video-js');
			echo $this->Html->script('fileuploader');

			echo $this->Html->script('video.min.js');

		?>

<script type="text/javascript" >
	var cakeRoot = '<?php echo Router::url('/', true) ?>';
</script>

    </head>

    <body>
        <div id="wrapper">

            <div id="header" class="clearfix">
                <p class="left">AHOY STUDIOS</p>
                <p class="right">CMS</p>
            </div>
            <p id="logout">
                <?php
                echo $this->Html->link('OPTIONS', array('controller' => 'options', 'action' => 'index', 'admin' => true));
                echo $this->Html->link('SETTINGS', array('controller' => 'settings', 'action' => 'index', 'admin' => true));
                echo $this->Html->link('ACCOUNTS', array('controller' => 'users', 'action' => 'index', 'admin' => true));
                echo $this->Html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?>
            </p>


            <div id="content" class="clearfix">

                <?php
                echo $this->Form->create('Category', array('url' => array('controller' => 'categories', 'action' => 'admin_saveOrder'), 'id' => 'left-menu', 'class' => 'clearfix left'));  ?>
                <h4 class="categories"><?php echo $this->Html->link( 'PROJECTS' ,array('controller' => 'projects', 'action' => 'index', 'admin' => true), array('class' => 'link')) ?></h4>
                <h4 class="categories"><?php echo $this->Html->link( 'CATEGORIES' ,array('controller' => 'categories', 'action' => 'index', 'admin' => true), array('class' => 'link')) ?></h4>
                <ul id="menu" class="sortable">
                    <?php foreach($admin_categories as $category):  ?>

                        <li><?php
                            if($category['Category']['type'] == 'projects'){
                                echo $this->Html->link($category['Category']['name_en'] ,array('controller' => 'categories', 'action' => 'view', $category['Category']['id'], 'admin' => true), array('class' => 'link'));
                            }
                            if($category['Category']['type'] == 'tabs'){
                                echo $this->Html->link($category['Category']['name_en'] ,array('controller' => 'tabs', 'action' => 'index', $category['Category']['id'], 'admin' => true), array('class' => 'link'));
                            }
                            if($category['Category']['type'] == 'inactive'){
                                echo $this->Html->tag('span', $category['Category']['name_en'] , array('class' => 'link'));
                            }
                            ?>


                            <?php echo $this->Html->link(' ',array('controller' => 'categories', 'action' => 'delete', $category['Category']['id'], 'admin' => true), array('class' => 'delete','title' => 'delete'), 'Are you sure you want to delete?'); ?>


                            <?php echo $this->Html->link(' ',array('controller' => 'categories', 'action' => 'edit', $category['Category']['id'], 'admin' => true), array('class' => 'edit','title' => 'edit')) ?>

                            <?php

                            if(empty($category['Category']['active'])){
                                echo $this->Html->link(' ',array('controller' => 'categories', 'action' => 'categoryActive', $category['Category']['id'], 'admin' => true), array('class' => 'busy','title' => 'busy'));
                            }
                            else{
                                echo $this->Html->link(' ',array('controller' => 'categories', 'action' => 'categoryInActive', $category['Category']['id'], 'admin' => true), array('class' => 'active', 'title' => 'active'));
                            }
                            ?>


                            <input name="data[Category][order_rank][]" type="hidden" value='<?php echo $category['Category']['id']; ?>' />

                        </li>
                    <?php endforeach; ?>
                    <li class="add-new disable"><?php echo $this->Html->link( '+' ,array('controller' => 'categories', 'action' => 'add', 'admin' => true), array('class' => 'link')) ?></li>

                </ul>
                <?php echo $this->Form->end();?>
                <div id="admin-content" class="clearfix">
                   <?php echo $content_for_layout ?>
                </div>
            </div>

        </div>

        <script type="text/javascript" >
            var cakeRoot = '<?php echo Router::url('/', true) ?>';
        </script>
        <?php
    		echo $this->Html->script('jquery');
    		echo $this->Html->script('jquery_ui');
    		echo $this->Html->script('jscolor');
    		echo $this->Html->script('../tiny_mce/jquery.tinymce');
            echo $this->Html->script('admin');

        ?>
    </body>
</html>
