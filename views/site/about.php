<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

use \app\models\Tops;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <? print_r($tops_array) ?>

    <?php $week = 0; $month = 0; $year = 0; ?>
    <?php for ($i = 0; $i < count($tops_date_type); $i++): ?>
            <?php if ($tops_date_type[$i]->top_type == Tops::TOP_TYPE_WEEK && $week == 0):$week++; ?>
                <div class="alert alert-info" role="alert">
                <h4><strong>周榜</strong></h4>
                <div class="line_horizontal_height_21"></div>
                <div class="row text-center">
            <?php endif; ?>
            <?php if ($tops_date_type[$i]->top_type == Tops::TOP_TYPE_MONTH && $month == 0):$month++; ?>
                <div class="alert alert-success" role="alert">
                <h4><strong>月榜</strong></h4>
                <div class="line_horizontal_height_21"></div>
                <div class="row text-center">
            <?php endif; ?>
            <?php if ($tops_date_type[$i]->top_type == Tops::TOP_TYPE_YEAR && $year == 0):$year++; ?>
                <div class="alert alert-danger" role="alert">
                <h4><strong>年榜</strong></h4>
                <div class="line_horizontal_height_21"></div>
                <div class="row text-center">
            <?php endif; ?>
            <div class="col-xs-3">
                <a href="#" class="alert-link">
                    <?= $tops_date_type[$i]->top_date; ?>
                    <?php if(in_array($tops_date_type[$i]->top_date.$tops_date_type[$i]->top_type,$tops_array,true)): ?>
                    (<span class="text-danger">未审核</span>)
                    <?php else: ?>
                    (<span class="text-success">已审核</span>)
                    <?php endif; ?>
                </a>
            </div>
            <?php if (!isset($tops_date_type[$i+1])
                ||($tops_date_type[$i+1]->top_type == Tops::TOP_TYPE_MONTH && $month==0)
                ||($tops_date_type[$i+1]->top_type == Tops::TOP_TYPE_YEAR && $year==0)): ?>
                </div>
                </div>
            <?php endif; ?>
    <?php endfor; ?>

</div>