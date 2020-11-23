<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use common\models\Message;
use common\models\MessageSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [ 'create', 'index', 'incorrect'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'incorrect'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->identity->role == User::ROLE_ADMIN;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     *  Display chat messages
     * @return mixed
     */
    public function actionChat()
    {
        $model = new Message();
        $dataProvider = new ActiveDataProvider([
            'query' => Message::getChatQuery(),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        return $this->render('chat', compact('model', 'dataProvider'));
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {
            $model->incorrect = Message::NO;
            $model->save();
        }
        return $this->redirect(['chat']);

    }

    /**
     * Set  message as incorrect
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionIncorrect($id, $incorrect = false)
    {
        $model = $this->findModel($id);
        $model->incorrect = $incorrect ? Message::YES : Message::NO;
        $model->save();
        return $this->redirect(['chat']);
    }


    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
