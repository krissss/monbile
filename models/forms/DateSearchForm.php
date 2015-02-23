<?php
/**
 * Created by PhpStorm.
 * User: kriss
 * Date: 2015/2/23
 * Time: 16:07
 */

namespace app\models\forms;

use yii\base\Model;

class DateSearchForm extends Model
{
    const ALL = 0;

    public $date_start;
    public $date_end;
    public $search_type;

    public function rules()
    {
        return [
            [['date_start', 'date_end', 'search_type'], 'required'],
        ];
    }

}