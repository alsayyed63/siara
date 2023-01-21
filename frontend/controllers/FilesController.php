<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;

class FilesController extends Controller
{   
    public function actionIndex()
    {
        $googleModel = new Yii::$app->googleModel();
        if(!$googleModel->hasAccessToGoogleApi(Yii::$app->request->get('code')))
            return $this->redirect($googleModel->getGoogleAuthUrl());

        return $this->render('index',[
            'files'=>$googleModel->getFiles(),
        ]);
    }

    public function actionSaveToken()
    {
        $googleModel = new Yii::$app->googleModel();
        $googleModel->authenticatateToken(Yii::$app->request->get('code'));
        return $this->redirect(['files/index']); 
    }
}