<?php
/**
 * Laravel 5 Masgsm SMS
 * @license MIT License
 * @author Ufuk GÖKKURT <ufuk.gokkurt@gmail.com>
 * @link http://ufukgokkurt.com
 *
 */
namespace Ufukgokkurt\Masgsm;


class Masgsm
{
   protected $app;
   protected  $config;
   protected  $title;

    public function __construct($app)
    {
        $this->app=$app;
        $this->setConfig($app['config']['masgsm']);
    }



    /**
     * Tek bir mesaj metnini bir veya birden fazla numaraya göndermek için kullanılır
     * @param $numbers array ['50XXXXXXXX', '50XXXXXXXX', '50XXXXXXXX', '50XXXXXXXX']
     * @param string $message 'TEST MESAJ'
     * @param string $title 'DEMO' -> Boş bırakılırsa varsayılan başlıkla gönderilir
     * @return string  DONUS|OK:8457787
     */
    public function sendSMS($numbers,$message='',$title='') {

        $this->setTitle($title);

        $data= [
            'apiNo'=>'1',
            'mesaj'=>$this->replaceTR($message),
            'numaralar' =>$numbers,
            'baslik' =>$this->title,

        ];

        $result=$this->sendData($data);

        if(preg_match('/DONUS/i', $result)) {
            $output = explode(':', $result);
                return $output[1]; // SMSID alınıyor
        }
        else{
            return $result; // DONUS kelimesi yoksa hata dönmüştür
        }

    }






    /**
     * Kontör Miktarınızı Sorgulamak İçin Kullanılır
     * @return int
     */
    public function checkCredits() {
    $data=[
        'apiNo' =>'2'
    ];
    $result=$this->sendData($data);
    return json_decode($result)->ORJINLI;
    }


    /**
     * Tanımlı Olan Başlıklarınızı Sorgulamak İçin Kullanılır
     * @return array
     */
    public function listTitle() {
        $data=[
            'apiNo' =>'3'
        ];
        $result=$this->sendData($data);
        return json_decode($result);

    }



    /**
     * Göndermiş Olduğunuz Mesajların İletim ve Hata Durumlarını(Raporlarını) Sorgulamak İçin Kullanılır
     * @param $smsID int
     * @return  tarih,durum,numara  array olarak döner
     * @throws \Exception
     */
    public function checkReport($smsID) {

        if (is_numeric($smsID)) {

            $data= [
                'apiNo'=>'4',
                'id'=>$smsID
            ];
            return json_decode($this->sendData($data));

        }else {
            throw new \Exception('SMS ID sayısal   değer olmalı');
        }


    }

    /**
     * Her numaraya farlı bir mesaj metni göndermek için ve bu mesajların raporlarını sorgulamak için kullanılır
     * @param $numbers
     * @param $messages
     * @param string $title
     * @return int    SMSID  döner
     */
    public function sendMultiSMS($numbers,$messages,$title='') {

        $this->setTitle($title);

        $data= [
            'apiNo'=>'5',
            'mesaj'=>array_map('self::replaceTR',$messages),
            'numaralar' =>$numbers,
            'baslik' =>$this->title,
            'islem'=>'kayit'

        ];

        return $this->sendData($data);
    }



    /**
     * @param array $config
     * @return $this
     * @throws \Exception
     */

    public function setConfig(array $config)
    {
        $this->config = $config;

        if (!$this->config['user'] || !$this->config['pass']) {

            throw new \Exception('API kullanıcı bilgileri tanımsız');

        }

        if (!$this->config['title']) {
            throw new \Exception('Varsayılan SMS başlığı tanımsız');
        }

        return $this;
    }



    /**
     * SMS başlığını(Gönderici) ayarı
     * @param $title
     */
    protected function setTitle($title) {

        if($title==null || strlen(trim($title))) {
            $this->title=$this->config['title'];
        }else{
            $this->title=$title;
        }
    }



    /**
     * Türkçe karakterleri değiştirir
     * @param $text
     * @return mixed
     */
    protected  function replaceTR($text) {
        $text = trim($text);
        $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
        $replace = array('C','c','G','g','i','I','O','o','S','s','U','u');
        return str_replace($search,$replace,$text);
    }


    /**
     * @array $data SMS config array(apiNo ve kullanılan apiNo'ya ait veriler)
     * @return $result
     */

    private function sendData($data) {

        // standart veriler $data değişkenine ekleniyor
        $data['user']=$this->config['user'];
        $data['pass']=$this->config['pass'];

        $ch=curl_init();
        $veri = http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, $this->config['apiUrl']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$veri);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }


}