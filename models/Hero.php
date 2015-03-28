<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%hero}}".
 *
 * @property integer $hid
 * @property string $hero_nickname
 * @property string $hero_name_cn
 * @property string $hero_name_py
 * @property string $hero_wh
 * @property integer $hero_hot
 */
class Hero extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%hero}}';
    }

    public function rules()
    {
        return [
            [['hero_nickname', 'hero_name_cn', 'hero_name_py','hero_hot'], 'required'],
            [['hero_nickname', 'hero_name_cn', 'hero_name_py', 'hero_wh'], 'string', 'max' => 255],
            ['hero_hot', 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'hid' => Yii::t('app', 'Hid'),
            'hero_nickname' => Yii::t('app', 'Hero Nickname'),
            'hero_name_cn' => Yii::t('app', 'Hero Name Cn'),
            'hero_name_py' => Yii::t('app', 'Hero Name Py'),
            'hero_wh' => Yii::t('app', 'Hero Wh'),
            'hero_hot' => Yii::t('app', 'Hero Hot'),
        ];
    }

    /**
     * 一对多关联，一个hero有多个video
     * @return \yii\db\ActiveQuery
     */
    public function getVideos(){
        return $this->hasMany(Videos::className(), ['hero_id' => 'hid'])
            ->inverseOf('hero');
    }

    public static function findHotHero($limit = 20){
        return Hero::find()
            ->orderBy(['hero_hot'=>SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function incrementHeroHot($hero_id,$step=1){
        $hero = Hero::findOne($hero_id);
        if(!$hero){
            return false;
        }
        $hero->hero_hot+=$step;
        if(!$hero->update()){
            return false;
        }
        return true;
    }
}
