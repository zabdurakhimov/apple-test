<?php

namespace console\controllers;


use backend\models\Apple;
use yii\console\Controller;
use yii\db\Query;
use yii\helpers\Console;
use yii\web\NotFoundHttpException;

/**
 * Controller to work with Apple schedules
 * */
class AppleController extends Controller {

    /**
     * The command will populate products of specified supplier and category or all
     * */
    public function actionClean()
    {
        $apples = Apple::find()->where(['<=', 'fallen_at', time() - 18000])->all();
        foreach ($apples as $apple) {
            try {
                $apple->rotten();
            } catch (NotFoundHttpException $exception) {
            }
        }

    }

}