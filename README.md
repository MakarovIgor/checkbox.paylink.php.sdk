[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
# checkbox.paylink.php.sdk - проста бібліотека для роботи з POS терміналами через Paylink REST API 

Бібліотека для роботи з POS терміналами через Paylink REST API як в локальній мережі, так і через інтеграції з web-CRM або інших.  


#### Увага:

Для роботи глобального доступу із мережі інтернет, треба білий IP та на роутері вивести порт, який зазначений у вкалдці "POS server"(за замовчуванням 9020) для зовнішнього доступу, для IP ПК на якому встановленний PayLink.

#### Підключення бібліотеки до проекту:
```cli
composer require igormakarov/checkbox.paylink.php.sdk - https://packagist.org/packages/igormakarov/checkbox.paylink.php.sdk
```
```php
require_once 'vendor/autoload.php';
```

#### Ініціалізація і робота з клієнтом:

Ініціалізація

```php
use igormakarov\PayLink\HostConfig;
use igormakarov\PayLink\PayLinkClient;

$client = new PayLinkClient(
    new HostConfig("<your_ip_or_dynamic_dns>", 9020)
);

HostConfig(string $ipOrHost, int $port): $ipOrHost - може бути як у вигляді IP так і доменого імені(DynDNS), наприклад "192.168.1.102" або 'testlink.ddns.net'
```

#### Отримання списку всіх терміналів які зареєстровані в программі PayLink
```php
$сlient->getDevices();

public function getDevices(): array
```

#### Отримання даних терміналу p PayLink по його ІД 
```php
$сlient->getDevice('your-device-uu-id');

public function getDevice($deviceId): Device
```
> $deviceId - ІД терміналу


#### Підключення до терміналу/перевірка з'єднання
```php
$сlient->ping('your-device-uu-id');

public function ping(string $deviceId): bool
```
> $deviceId - ІД терміналу

#### Відправка грошей на оплату картою в термінал, перед цим з'єднує PayLink з терміналом якщо підключення не було 
```php
$сlient->purchase("your-device-uu-id", 1);

public function purchase(string $deviceId, int $amount): PurchaseResult
```
> $deviceId - ІД терміналу,
> $amount - кількість грошей(1 = одна копійка, 100 = одна гривня) 


### Простий приклад

```php
use igormakarov\PayLink\HostConfig;
use igormakarov\PayLink\PayLinkClient;

$client = new PayLinkClient(
    new HostConfig("<your_ip_or_dynamic_dns>", 9020)
);

$purchaseResult = $client->purchase("1ad4ec2c-3aa3-44a0-812c-bd285ef253f0", 1);
```
а далі підставляєте дані $purchaseResult в чек у вашому коді чи бібліотеці якій використовуєте.

Приклад підстановки даних для віправки в чекбокс за допомогою бібліотеки [checkbox-in-ua-php-sdk](https://github.com/igorbunov/checkbox-in-ua-php-sdk):
```php
$receipt = new SellReceipt(
    'Вася Пупкін',
    'Відділ продажів', 
    new Goods(
        [
            new GoodItemModel(new GoodModel('vm-123', 100, 'Биовак'), 1000)
        ]
    ),
    new Payments([
        new CardPaymentPayload(
            $sum = 100,
            'Оплата картою',
            $purchaseResult->code(),
            $purchaseResult->cardMask(),
            $purchaseResult->cardName(),
            $purchaseResult->terminal(),
            $purchaseResult->rrn(),
            $purchaseResult->authCode(),
            $purchaseResult->paymentSystem(),
            $purchaseResult->receiptNo(),
            $purchaseResult->acquirerAndSeller(),
            $purchaseResult->commission()
        )
    ])
);
$api->createSellReceipt($receipt);
```