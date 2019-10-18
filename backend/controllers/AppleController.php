<?php

namespace backend\controllers;

use backend\forms\EatForm;
use backend\models\search\AppleSearch;
use Yii;
use backend\models\Apple;
use backend\models\search\RegionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all active Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        //пример создания ниже
        /*$apple = new Apple('green');
        $apple->save();*/
        $searchModel = new AppleSearch();
        $request = Yii::$app->request->queryParams;
        $request['AppleSearch']['active'] = true;
        $dataProvider = $searchModel->search($request);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all deleted Apple models.
     * @return mixed
     */
    public function actionDeleted()
    {
        $searchModel = new AppleSearch();
        $request = Yii::$app->request->queryParams;
        $request['AppleSearch']['active'] = false;
        $dataProvider = $searchModel->search($request);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apple model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apple model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apple();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Apple model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRemove($id)
    {
        $this->findModel($id)->remove();

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionFall($id)
    {
        $apple = Apple::findOne($id);
        if ($apple->status != Apple::STATUS_ON_GROUND) {
            $this->findModel($id)->fallToGround();
        }else{
            Yii::$app->session->setFlash('error', "it is on the ground already!");
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionEat($id)
    {
        $apple = Apple::findOne($id);
        if ($apple->status == Apple::STATUS_ON_TREE) {
            Yii::$app->session->setFlash('error', "you cannot eat it while it is on tree!");
            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        } elseif ($apple->status == Apple::STATUS_ROTTEN) {
            Yii::$app->session->setFlash('error', "you cannot eat it when it is rotten!");
            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        }
        $model = new EatForm(['apple' => Apple::findOne(['id' => $id])]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        }

        return $this->renderByRequest('eat', ['model' => $model]);
    }

    public function actionCreateRandom()
    {
        (new \backend\models\Apple)->createRandom();

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function renderByRequest(string $view, array $params): string
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax($view, $params);
        }
        return $this->render($view, $params);
    }
}
