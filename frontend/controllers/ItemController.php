<?php

namespace frontend\controllers;

use Yii;
use app\models\Item;
use frontend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Statistic;
use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class ItemController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        Yii::$app->MyComponent->trigger(\common\components\MyComponent::EVENT_TRIGGER);
        //$this->addToStatistic(Yii::$app->request);
        $searchModel = new ItemSearch();
        $items = Item::find()->joinWith('category')->orderBy('id');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        Yii::$app->MyComponent->trigger(\common\components\MyComponent::EVENT_TRIGGER);
        //$this->addToStatistic(Yii::$app->request);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Item();
        $this->saveImage($model);
      
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->saveImage($model);

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function addToStatistic($req){
        $req = \Yii::$app->request;
        $statistic=new Statistic();
        $statistic->access_time=date('Y-m-d H:i:s');
        $statistic->user_ip = $req->userIp;
        $statistic->user_host = $req->hostInfo;
        $statistic->path_info = $req->pathInfo;
        $statistic->query_string = $req->queryString;
        if($statistic->save()) var_dump($statistic->getErrors());
    }

    protected function saveImage(Item $item){
        if ($item->load(Yii::$app->request->post()) && $item->save(false)) {
            $item->upload = UploadedFile::getInstance($item, 'upload');
            if($item->validate()){
                $path = 'img/items/'.$item->upload->baseName.'-'.time().'.'.$item->upload->extension;
                if($item->upload->saveAs($path)){
                    $item->image = $path;
                }
                if($item->save(false)){
                    return $this->redirect(['view', 'id' => $item->id]);
                }
            }
        }
    }

}
