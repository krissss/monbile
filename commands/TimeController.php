<?php
/**
 * 定时执行脚本
 */
namespace app\commands;

use app\models\Tops;
use yii\console\Controller;

class TimeController extends Controller {

    /**
     * 需要每周执行
     */
    public function actionChoseTopWeek(){
        if(Tops::insertTopVideosToTops(date('Y-m-d'),Tops::TOP_TYPE_WEEK)){
            echo date('Y-m-d').'___week___ok  ';
        }else{
            echo date('Y-m-d').'___week___wrong  ';
        }
        return 0;
    }

    /**
     * 需要每月执行
     */
    public function actionChoseTopMonth(){
        if(Tops::insertTopVideosToTops(date('Y-m-d'),Tops::TOP_TYPE_MONTH)){
            echo date('Y-m-d').'___month___ok  ';
        }else{
            echo date('Y-m-d').'___month___wrong  ';
        }
        return 0;
    }

    /**
     * 需要每年执行
     */
    public function actionChoseTopYear(){
        if(Tops::insertTopVideosToTops(date('Y-m-d'),Tops::TOP_TYPE_YEAR)){
            echo date('Y-m-d').'___year___ok  ';
        }else{
            echo date('Y-m-d').'___year__wrong  ';
        }
        return 0;
    }
}