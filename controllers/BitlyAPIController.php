<?php


class BitlyAPIController extends BaseController
{

    public function actionSend()
    {
        $longUrl = key_exists('url', $_GET) ? trim($_GET["url"]) : '';
        $method = key_exists('method', $_GET) ? trim($_GET["method"]) : '';

        if ($method == "shorten" || $method == "expand"){
        if ($longUrl && $method) {

            $bitly = new Bitly();
            $response = $bitly->$method($longUrl,$method);
            $response = json_encode($response, JSON_PRETTY_PRINT);
            $_POST['resp'] = $response;

            $this->renderView('index');
        }
        }else{
            die('Something went wrong (: !');
        }
    }
}