<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\models\Item_Category;
use yii\web\UploadedFile;

class Item extends \yii\db\ActiveRecord
{
    public $upload;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    public static function tableName()
    {
        return 'item';
    }

    public function rules()
    {
        return [
            [['name', 'price', 'category_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['price', 'category_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item_Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['upload'], 'file', 'extensions' => ['jpeg', 'jpg', 'png'], 'maxSize' => 5000000], 
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'image' => Yii::t('app', 'Image'),
            'category_id' => Yii::t('app', 'Category ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getCategory()
    {
        return $this->hasMany(Item_Category::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery|OrderItemQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['item_id' => 'id']);
    }

    public function getPriceDollar()    
    {
        return '$ '.$this->price;
    }        
    public function getUrlImage()
    {    
        if(!$img = $this->image){
            $img = 'img/items/no_image.png';
        }        
        return Yii::$app->request->hostInfo.'/MyMart/frontend/web/'.$img;
    }

}
