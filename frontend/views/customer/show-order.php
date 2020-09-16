<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Order History';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="customer-show-orders">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $activeDataProvider = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    
        echo GridView::widget([
            'dataProvider' => $activeDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Customer Name',
                    'attribute' => 'customer_name',
                    'value' => function($data) {
                        return $data->orders->customer->nama;
                    },
                ],
                [
                    'label' => 'Order Id',
                    'attribute' => 'order_id',
                    'value' => function($data){
                        return $data->orders->customer->id;
                    },
                ],
                [
                    'label' => 'Item',
                    'attribute' => 'item_id',
                    'value' => function($data){
                        return $data->item->id;
                    },
                ],
                [
                    'label' => 'Nama Item',
                    'attribute' => 'name',
                    'value' => function($data){
                        return $data->item->name;
                    },
                ],
                ['class'=>'yii\grid\ActionColumn'],
            ],
            ]); ?>
</div>
