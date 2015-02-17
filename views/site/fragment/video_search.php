<?php
/**
 * 搜索视频
 * site/index   user/default/index
 * 在包含页面需定义以下变量
 */
/* @var $searchForm :: render */
/* @var $user :: render or session */
/* @var $session_user :: session */

use yii\helpers\Html;
use \app\models\forms\SearchForm;
use yii\bootstrap\ActiveForm;

?>
<div class="panel panel-default collapse" id="search_video">
    <div class="panel-body">
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
                <?= $form->field($searchForm, 'search_type')
                    ->radioList([SearchForm::ALL=>'全部',$user->uid=>'ta的'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===SearchForm::ALL){
                               return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                               return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php elseif ($session_user&&$user->uid == $session_user->uid): ?>
                <?= $form->field($searchForm, 'search_type')
                    ->radioList([SearchForm::ALL=>'全部',$session_user->uid=>'我的'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===SearchForm::ALL){
                               return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                               return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php else: ?>
                <?= $form->field($searchForm, 'search_type')
                    ->radioList([SearchForm::ALL=>'全部'],
                        ['item'=>function ($index, $label, $name, $checked, $value){
                            if($index===SearchForm::ALL){
                                return '<label class="radio-inline">'.Html::radio($name,true,['value' => $value]).$label.'</label>';
                            }else{
                                return '<label class="radio-inline">'.Html::radio($name,false,['value' => $value]).$label.'</label>';
                            }
                        }]) ?>
                <?php endif; ?>
            </span>
            <?= $form->field($searchForm, 'search_content')->textInput(['class'=>'form-control','placeholder'=>'输入标签']) ?>
            <span class="input-group-btn">
                <?= Html::submitButton('Search!', ['class' => 'btn btn-default', 'name' => 'search-button']) ?>
            </span>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
