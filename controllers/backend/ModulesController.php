<?php

namespace diazoxide\yii2config\controllers\backend;

use diazoxide\yii2config\models\Modules;
use diazoxide\yii2config\models\ModulesOptions;
use diazoxide\yii2config\models\ModulesOptionsSearch;
use diazoxide\yii2config\Module;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 *
 * @property Module module
 */
class ModulesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'option-delete' => ['POST'],
                ],
            ],
            /*'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'delete', 'create', 'update', 'view', 'create-book', 'update-book', 'delete-book', 'create-book-chapter', 'update-book-chapter', 'delete-book-chapter'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['BLOG_VIEW_POSTS']
                    ],

                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function () {
                            return Yii::$app->user->can('BLOG_UPDATE_OWN_POST', ['model' => $this->findModel(Yii::$app->request->getQueryParam('id'))])
                                || Yii::$app->user->can('BLOG_UPDATE_POST');
                        },

                    ],
                ],
            ],*/
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = Modules::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Modules();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionOptions($id)
    {
        $model = $this->findModel($id);

        $options = $model->getOptions();

        return $this->render('options', [
            'model' => $model,
            'options' => $options,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionOptionCreate()
    {
        /** @var ModulesOptions $model */
        $model = new ModulesOptions();

        /* Module id from get parameters */
        $module_id = Yii::$app->request->get('module_id');

        /* Parent id from get parameters*/
        $parent_id = Yii::$app->request->get('parent_id');

        /* Getting Module model:ActiveRecord */
        if ($module_id) {
            $model->module_id = $module_id;
        } elseif ($parent_id) {
            $parent = $this->findOptionModel($parent_id);
            $model->parent_id = $parent_id;
            $model->module_id = $parent->module_id;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }


        if ($model->load(Yii::$app->request->post())) {

            if (
                ($parent_id && $model->prependTo($this->findOptionModel($parent_id))->save())
                || $model->makeRoot()->save()

            ) {
                return $this->redirect(['option-update', 'id' => $model->id]);
            }
        }

        return $this->render('option_create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionOptionUpdate($id)
    {
        /** @var ModulesOptions $model */
        $model = $this->findOptionModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['option-update', 'id' => $model->id]);
            }
        }

        $options = $model->getOptions();

        return $this->render('option_update', [
            'model' => $model,
            'options' => $options,
        ]);
    }


    /**
     * @param $id
     * @return Modules|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Modules::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return Modules|ModulesOptions|null
     * @throws NotFoundHttpException
     */
    protected function findOptionModel($id)
    {
        if (($model = ModulesOptions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);

    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionOptionDelete($id)
    {
        $model = $this->findOptionModel($id);
        $model->deleteWithChildren();
        return $this->redirect(Yii::$app->request->referrer);
    }

}
