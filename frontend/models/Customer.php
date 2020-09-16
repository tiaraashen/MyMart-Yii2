<?php

namespace app\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $email
 * @property int $user_id
 *
 * @property User $user
 * @property Order[] $orders
 */
class Customer extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%customer}}';
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['nama', 'email'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Nama'),
            'email' => Yii::t('app', 'Email'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
