<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%relations}}".
 *
 * @property integer $rid
 * @property integer $front_id
 * @property integer $back_id
 * @property integer $relation_state
 */
class Relations extends \yii\db\ActiveRecord
{
    const RELATION_STABLE = 1;
    const RELATION_DISABLE = 0;

    public static function tableName()
    {
        return '{{%relations}}';
    }

    public function rules()
    {
        return [
            [['front_id', 'back_id', 'relation_state'], 'required'],
            [['front_id', 'back_id', 'relation_state'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'Rid'),
            'front_id' => Yii::t('app', 'Front ID'),
            'back_id' => Yii::t('app', 'Back ID'),
            'relation_state' => Yii::t('app', 'Relation State'),
        ];
    }

    /**
     * 一对一关联，一个relation只有一个front
     * @return \yii\db\ActiveQuery
     */
    public function getFront()
    {
        return $this->hasOne(Users::className(), ['uid' => 'front_id'])
            ->inverseOf('relationsFront');
    }

    /**
     * 一对一关联，一个relation只有一个back
     * @return \yii\db\ActiveQuery
     */
    public function getBack()
    {
        return $this->hasOne(Users::className(), ['uid' => 'back_id'])
            ->inverseOf('relationsBack');
    }

    /**
     * 判断某个关系是否存在
     * @param $front_id ::关注者
     * @param $back_id  ::被关注者
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function isExist($front_id, $back_id){
        return Relations::find()
            ->where(['front_id'=>$front_id, 'back_id'=>$back_id])
            ->one();
    }

    /**
     * 查询某个用户的所有关注（back_id），并以数组传出，用以判断用户是否关注了某个用户
     * @param $front_id
     * @return array
     */
    public static function findAllBackIdInRelationsByFrontId($front_id){
        $relations = Relations::find()
            ->select('back_id')
            ->where(['front_id'=>$front_id, 'relation_state'=>Relations::RELATION_STABLE])
            ->all();
        $relations_array = array();
        foreach($relations as $relation){
            array_push($relations_array,$relation->back_id);
        }
        return $relations_array;
    }

    /**
     * 查询某个用户的所有粉丝（front_id），并以数组传出，用以判断用户是否有该粉丝
     * @param $front_id
     * @return array
     */
    public static function findAllFrontIdInRelationsByBackId($back_id){
        $relations = Relations::find()
            ->select('front_id')
            ->where(['back_id'=>$back_id, 'relation_state'=>Relations::RELATION_STABLE])
            ->all();
        $relations_array = array();
        foreach($relations as $relation){
            array_push($relations_array,$relation->front_id);
        }
        return $relations_array;
    }
}
