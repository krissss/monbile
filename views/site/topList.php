<?php
/**
 * 榜单列表页面
 */
/* @var $this yii\web\View */
/* @var $tops_date_type :: render */
/* @var $tops_array :: render */

$this->title = '榜单';

use \app\models\Tops;
use \yii\helpers\Url;

?>
<div class="superAdmin-default-index">
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
                <div class="alert alert-warning" role="alert">
                <h4><strong>年榜</strong></h4>
                <div class="line_horizontal_height_21"></div>
                <div class="row text-center">
            <?php endif; ?>
            <div class="col-xs-3">
                <a href="<?=Url::to(['/site/top-videos','type'=>$tops_date_type[$i]->top_type,'date'=>$tops_date_type[$i]->top_date])?>" class="alert-link">
                    <?= $tops_date_type[$i]->top_date; ?>
                    <?php if(in_array($tops_date_type[$i]->top_date.$tops_date_type[$i]->top_type,$tops_array,true)): ?>
                    (<span class="text-danger">未公布</span>)
                    <?php else: ?>
                    (<span class="text-success">已公布</span>)
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
