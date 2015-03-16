<h3><?php echo __d('cake_dev', 'P P I - A CAKEPHP DEVELOPMENT'); ?></h3>
<p>
<?php
echo __d('cake_dev', 'To change the content of this page, edit: %s.<br />
To change its layout, edit: %s.<br />
You can also add some CSS styles for your pages at: %s.',
	'APP/View/Pages/home.ctp', 'APP/View/Layouts/default.ctp', 'APP/webroot/css');
?>
</p>

<h3><?php echo __d('cake_dev', 'USER LOGIN'); ?></h3>
<p>
	<?php
	echo $this->Html->link('cake_dev', array('id' => 'username', 'name' => 'username', 'value' => '')
	);
	?>
</p>
<p>
	<?php
	echo $this->Html->link(
		__d('cake_dev', 'The 15 min Blog Tutorial'),
		'http://book.cakephp.org/2.0/en/tutorials-and-examples/blog/blog.html',
		array('target' => '_blank', 'escape' => false)
	);
	?>
</p>

<h3><?php echo __d('cake_dev', 'Official Plugins'); ?></h3>
<p>
<ul>
	<li>
		<?php echo $this->Html->link('DebugKit', 'https://github.com/cakephp/debug_kit') ?>:
		<?php echo __d('cake_dev', 'provides a debugging toolbar and enhanced debugging tools for CakePHP applications.'); ?>
	</li>
	<li>
		<?php echo $this->Html->link('Localized', 'https://github.com/cakephp/localized') ?>:
		<?php echo __d('cake_dev', 'contains various localized validation classes and translations for specific countries'); ?>
	</li>
</ul>
</p>

