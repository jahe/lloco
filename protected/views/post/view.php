<?php
$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<h1>View Post #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		'content',
		//'location',
		'longitude',
		'latitude',
		'createTime',
		'authorId',
		'_id',
	),
)); ?>

<?php
	$posts = $model->nearPosts();
	foreach ($posts as $p)
		{
			echo '<p>'.$p->title.' ['.$p->longitude.'; '.$p->latitude.'] ';
			echo round(Post::distance($model->longitude, $model->latitude, $p->longitude, $p->latitude) * 1000).' m';
			echo ' ('.$p->commentCount().')';
			echo '</p>';
		}
?>

<?php
	$this->renderPartial('_comments', array(
		'post' => $model,
		'comments' => $model->comments()
	));
?>

<?php
	$this->renderPartial('/comment/_form', array(
		'model' => $comment
	));
?>
	