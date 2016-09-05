<div class="view">

	<?php echo 'Writer'; ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->writer)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('title')); ?>:
	<?php echo GxHtml::encode($data->title); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('text')); ?>:
	<?php echo GxHtml::encode($data->text); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('created_at')); ?>:
	<?php echo GxHtml::encode($data->created_at); ?>
	<br />

	<?php echo GxHtml::link('View More', array('post/view', 'id' => $data->id)); ?>
</div>