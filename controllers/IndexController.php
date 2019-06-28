<?php


class IndexController extends BaseController
{
    public function actionIndex()
    {
        $this->renderView('index');
    }
}