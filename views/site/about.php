<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;


$session = Yii::$app->getSession();
$user = $session->get('user');
$session_user = $user;
$games = $session->get('games');
$tags_hot = $session->get('tags_hot');
$users_hot = $session->get('users_hot');

$is_other_user = false;
$is_other_user_video = true;
if(!isset($collections_array)){
    $collections_array = array();
}
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php require(__DIR__ . '/fragment/video_search.php'); ?>

    <?print_r($videos[0]->video->user->nickname)?>
</div>
