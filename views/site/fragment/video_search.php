<?php
/**
 * 搜索视频
 * site/index   user/default/index
 * 在包含页面需定义以下变量
 */
/* @var $tagSearchForm :: render */
/* @var $dateSearchForm :: render */
/* @var $user :: render or session */
/* @var $session_user :: session */

use yii\helpers\Html;
use \app\models\forms\TagSearchForm;
use \app\models\forms\DateSearchForm;
use yii\bootstrap\ActiveForm;

?>
<div class="panel panel-default collapse" id="search_video">
    <div class="panel-body">
        <h5 class="text-info"><strong>搜标签</strong></h5>
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'fieldConfig' => [
                'template' => "{input}",
                'enableLabel' => false,
                'enableError' => false,
                'inline' => true,
            ],
        ]); ?>
        <div class="input-group">
            <span class="input-group-addon">
                <?php if ($is_other_user): ?>
                <?= $form->field($tagSearchForm, 'search_type')
                    ->radioList([TagSearchForm::ALL=>'全部',$user->uid=>'ta的'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===TagSearchForm::ALL){
                               return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                               return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php elseif ($session_user&&$user->uid == $session_user->uid): ?>
                <?= $form->field($tagSearchForm, 'search_type')
                    ->radioList([TagSearchForm::ALL=>'全部',$session_user->uid=>'我的'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===TagSearchForm::ALL){
                               return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                               return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php else: ?>
                <?= $form->field($tagSearchForm, 'search_type')
                    ->radioList([TagSearchForm::ALL=>'全部'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===TagSearchForm::ALL){
                                return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                                return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php endif; ?>
            </span>
            <?= $form->field($tagSearchForm, 'search_content')->textInput(['class'=>'form-control','placeholder'=>'输入标签所包含的字或词']) ?>
            <span class="input-group-btn">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'name' => 'tag-search-button']) ?>
            </span>
        </div>
        <?php ActiveForm::end(); ?>

        <h5 class="text-info"><strong>搜时间</strong></h5>
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'fieldConfig' => [
                'template' => "{input}",
                'enableLabel' => false,
                'enableError' => false,
                'inline' => true,
            ],
        ]); ?>
        <div class="input-group">
            <span class="input-group-addon">
                <?php if ($is_other_user): ?>
                <?= $form->field($dateSearchForm, 'search_type')
                    ->radioList([DateSearchForm::ALL=>'全部',$user->uid=>'ta的'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===DateSearchForm::ALL){
                               return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                               return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php elseif ($session_user&&$user->uid == $session_user->uid): ?>
                <?= $form->field($dateSearchForm, 'search_type')
                    ->radioList([DateSearchForm::ALL=>'全部',$session_user->uid=>'我的'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===DateSearchForm::ALL){
                               return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                               return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php else: ?>
                <?= $form->field($dateSearchForm, 'search_type')
                    ->radioList([DateSearchForm::ALL=>'全部'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===DateSearchForm::ALL){
                                return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                                return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php endif; ?>
            </span>
            <?= $form->field($dateSearchForm, 'date_start')->input('date',['class'=>'form-control']) ?>
            <span class="input-group-addon">至</span>
            <?= $form->field($dateSearchForm, 'date_end')->input('date',['class'=>'form-control']) ?>
            <span class="input-group-btn">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'name' => 'date-search-button']) ?>
            </span>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
