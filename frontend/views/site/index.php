<?php

/* @var $this yii\web\View */
use yii\helpers\Html; 
use yii\widgets\LinkPager;
$this->title = 'MyMart';
?>

<div class="site-index"> 
 
    <div class="jumbotron">
        <h1><?=Yii::$app->name ?></h1> 
        <p class="lead">Selamat Datang.</p> 
    </div> 
<div class="row">
<?php
    $items = $dataProvider->getModels();
    foreach ($items as $item):?>
    <div class="item  col-xs-3 col-xs-3">
        <div class="thumbnail">
            <img class="group list-group-image" src="<?=$item->urlImage?>" alt="" style="min-height: 200px; max-height: 200px"/>
                <div class="caption">
                    <h4 class="group inner list-group-item-heading"><?=$item->name?></h4>
                    <p class="group inner list-group-item-text">
                    <?php // =$item->category->name?:'No Category'?>
                    </p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                            <?=$item->priceDollar?></p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                        <?php
                            if (Yii::$app->user->isGuest)
                                echo Html::a('Sign in first',['/site/login'],['class'=>'btn btn-warning']);
                            else
                                echo Html::a('Add to cart',['/site/about'],['class'=>'btn btn-success']);
                        ?></div> 
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <?php   echo LinkPager::widget(['pagination' => $pagination]); ?>
</div> 