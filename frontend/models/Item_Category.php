<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_category".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_category
 */
class Item_Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'item_category';
    }

    public function rules()
    {
        return [
            [['id', 'name', 'parent_category'], 'required'],
            [['id', 'parent_category'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_category' => 'Parent Category',
        ];
    }
}
