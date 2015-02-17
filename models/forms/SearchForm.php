<?php

namespace app\models\forms;

use yii\base\Model;

class SearchForm extends Model
{
    const ALL = 0;

    public $search_type;
    public $search_content;

    public function rules()
    {
        return [
            [['search_type', 'search_content'], 'required'],
        ];
    }

}