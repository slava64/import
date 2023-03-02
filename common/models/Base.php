<?php

namespace common\models;

use yii\helpers\ArrayHelper;

class Base extends \yii\db\ActiveRecord
{
    public static function getMap($index = 'id', $value = 'name'): array
    {
        return ArrayHelper::map(static::find()->all(), $index, $value);
    }
}