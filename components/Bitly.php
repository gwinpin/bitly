<?php


class Bitly
{
    private $apiKey = "";

    function __construct()
    {
        $config = include(ROOT . '/config/conf.php');
        $this->apiKey = $config["token"];

    }


    /**
     * @param String $url
     * @return mixed
     */
    public function expand($url)
    {
        $remove_www = '/^www\./';
        $remove_http = '#^http(s)?://#';
        $_url = preg_replace($remove_http, '', $url);
        $_url = preg_replace($remove_www, '', $_url);
        $data = json_encode(["bitlink_id" => "$_url"]);
        $result = $this->call($data, 'expand');

        if (property_exists($result, 'long_url')) {
            $link = $result->long_url;
        }

        if (isset($link)) {
            $this->insertDb($link, $url);
        }
        return $result;
    }


    /**
     * @param $url
     * @return mixed
     */
    public function shorten($url)
    {
        $data = json_encode(["long_url" => "$url"]);
        $result = $this->call($data, 'shorten');
        if (property_exists($result, 'link')) {
            $link = $result->link;
        }

        if (isset($link)) {
            $this->insertDb($url, $link);
        }

        return $result;
    }


    /**
     * @param $data
     * @param $method
     * @return mixed
     */
    private function call($data, $method)
    {
        $ch = curl_init("https://api-ssl.bitly.com/v4/$method");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                "Authorization: Bearer $this->apiKey"]
        );
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        return $result;
    }


    /**
     * @param $long
     * @param $short
     */
    private function insertDb($long, $short)
    {

        $db = Db::getConnection();
        $sql = "insert into url (url_before,url_after) 
            VALUES ('$long','$short')";

        try {
            $db->exec($sql);
            $_GET['long'] = $long;
            $_GET['short'] = $short;
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

}