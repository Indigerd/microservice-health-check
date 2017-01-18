<?php
/**
 * @author Alexander Stepanenko <alex.stepanenko@gmail.com>
 * @package templatemonster\healthchecks
 */

namespace templatemonster\healthchecks\controllers;

use Yii;
use indigerd\rest\Controller;

class ApiController extends Controller
{
    public $modelClass = 'templatemonster\healthchecks\models\HealthCheck';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['access']);
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        return $actions;
    }

    public function actionIndex()
    {
        /** @var \templatemonster\healthchecks\Module $module */
        $module = \Yii::$app->getModule(
            isset(\Yii::$app->params['healthChecksModuleName'])
                ? \Yii::$app->params['healthChecksModuleName']
                : 'healthchecks'
        );
        $result = $module->doHealthChecks();
        if (!$module->getHealth()) {
            Yii::$app->response->setStatusCode(424);
        }
        return $result;
    }
}
