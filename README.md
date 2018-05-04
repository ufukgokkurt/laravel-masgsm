Laravel 5 için  Masgsm SMS
=========
Laravel 5.x   projelerinizde [Masgsm](https://www.masgsm.com.tr) altyapısını kullanarak tekli veya çoklu sms gönderebilir,SMS raporlarını ve bakiyenizi  sorgulayabilirsiniz.

Kurulum
-------
* Paketi projenize eklemek için aşağıdaki komutu kullanınız.
```bash
composer require ufukgokkurt/masgsm
```
* app/config/app.php dosyasını açın, providers dizisi içine aşağıdaki satırı ekleyiniz.
```bash
Ufukgokkurt\Masgsm\MasgsmServiceProvider::class,
```
* Aynı dosyada aliases kısmına aşağıdaki satırı ekleyiniz.
```bash
'Masgsm' => Ufukgokkurt\Masgsm\Facades\Masgsm::class,
```
* Konfigürasyon dosyasını paylaşmak için aşağıdaki komutu kullanınız.
```bash
 php artisan vendor:publish --provider="Ufukgokkurt\Masgsm\MasgsmServiceProvider"
 ```
 * config/masgsm.php dosyası paylaşılacak. Burada Masgsm için size atanan kullanıcı adı, parola ve başlık  değerlerini doldurmalısınız. Ayrıca .env dosyanıza MASGSM_USER, MASGSM_PASS ve MASGSM_DEFAULT_TITLE değerlerini ekleyerek config dosyanızı besleyebilirsiniz.
 
 Kullanım
 --------
 
 * Tek bir mesaj metnini bir veya birden fazla numaraya göndermek için
 ```bash
 $numaralar = array('50XXXXXXXX', '50XXXXXXXX', '50XXXXXXXX', '50XXXXXXXX'); 
 $mesaj='Test Mesaj';
 $smsID=Masgsm::sendSMS($numaralar,$mesaj); //$smsID integer bir değer olup, SMS raporu için kullanılacaktır
  ```
  
  * Her numaraya farlı bir mesaj metni göndermek için
  
   ```bash
   $numaralar = array('50XXXXXXXX', '50XXXXXXXX', '50XXXXXXXX', '50XXXXXXXX'); 
   $mesajlar = array(‘1. Numaraya gidecek mesaj','2. Numaraya gidecek mesaj','3. Numaraya gidecek mesaj','…');
   $smsID=Masgsm::sendMultiSMS($numaralar,$mesajlar); //$smsID integer bir değer olup, SMS raporu için kullanılacaktır
 ```
 * Varsayılan başlık( gönderici) dışında,  tanımlı farklı başlıkla gönderim yapmak için; sendSMS ve sendMultiSMS fonksiyonlarına  3. parametre olarak başlığı gönderebilirsiniz.
 
  ```bash
  $baslik='TEST';
  Masgsm::sendSMS($numaralar,$mesaj,$baslik);
  veya
  Masgsm::sendMultiSMS($numaralar,$mesajlar,$baslik);
   ```
 * Tanımlı olan başlıklarınızı sorgulamak için 
 ```bash
 Masgsm::listTitle(); // Dizi olarak döner
 ``` 
 * Kontör miktarınızı sorgulamak için
 ```bash
 Masgsm::checkCredits();
  ``` 
  * Göndermiş olduğunuz mesajların iletim ve hata durumlarını(raporlarını) sorgulamak için
  ```bash
  $smsID=123456;
  Masgsm::checkReport($smsID); // Dizi olarak döner
   ```  
  Not
  ----
  Mesaj içeriğindeki TR karekterler  otomatik olarak değiştirilmektedir. Bunun için ekstra birşey yapmanıza gerek yoktur.
