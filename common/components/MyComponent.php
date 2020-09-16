<?php

namespace common\components;

use app\models\Statistic;
use yii\base\Component;

class MyComponent extends Component{
    const EVENT_TRIGGER = "event_trigger";

    public function addToStatistic(){
        $req = \Yii::$app->request;
        $statistic = new Statistic();
        $statistic->access_time =date('Y-m-d H:i:s');
        $statistic->user_ip = $req->userIp;
        $statistic->user_host = $req->hostInfo;
        $statistic->path_info = $req->pathInfo;
        $statistic->query_string = $req->queryString;
        $statistic->save(false);
    }
}

?>