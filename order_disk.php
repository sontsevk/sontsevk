<?php
$delivery = isset($_REQUEST['delivery']) ? $_REQUEST['delivery'] :'';
$amount = (int) $_REQUEST['amount'];
$redirectUrl = 'http://sontsevk.com.ua/?p=127';
if (!$amount ) {
    header('Location: '.$redirectUrl);
}
$name = isset($_REQUEST['name']) ? $_REQUEST['name'] :'';
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] :'';
$phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] :'';
$message = isset($_REQUEST['message']) ? $_REQUEST['message'] :'';
$city = isset($_REQUEST['city']) ? $_REQUEST['city'] :'';
$street = isset($_REQUEST['street']) ? $_REQUEST['street'] :'';
$house = isset($_REQUEST['house']) ? $_REQUEST['house'] :'';
$flat = isset($_REQUEST['flat']) ? $_REQUEST['flat'] :'';
$novap_num = isset($_REQUEST['novap_num']) ? $_REQUEST['novap_num'] :'';
$novap_address = isset($_REQUEST['novap_address']) ? $_REQUEST['novap_address'] :'';
$valid = true;
$emptyFields='';
if (!$name) {
    $valid = false;
    $emptyFields = $emptyFields . 'Імя; ';
}
if (!$email && !$phone) {
    $valid = false;
    $emptyFields = $emptyFields . 'Контактні дані (телефон або емейл); ';
}
if ($delivery =='novaposhta') {
    $deliveryPrice = 20;
    $deliveryLabel = 'Нова пошта';
    if (!$city) {
        $valid = false;
        $emptyFields = $emptyFields . 'Місто; ';
    }
    if (!$novap_num && !$novap_address) {
        $valid = false;
        $emptyFields = $emptyFields . 'Відділення Нової пошти (номер або адреса); ';
    }
} else if ($delivery =='ukrposhta') {
    $deliveryPrice = 6.4;
    $deliveryLabel = 'Укрпошта';
    if (!$city) {
        $valid = false;
        $emptyFields = $emptyFields . 'Місто; ';
    }
    if (!$street) {
        $valid = false;
        $emptyFields = $emptyFields . 'Вулиця; ';
    }
    if (!$house) {
        $valid = false;
        $emptyFields = $emptyFields . 'Номер будинку; ';
    }
} else if ($delivery =='self'){
    $deliveryPrice = 0;
    $deliveryLabel = 'При зустрічі';
} else {
    header('Location: '.$redirectUrl);
}

$total = $amount*20 + $deliveryPrice;

if ($valid) {
    $c = mysqli_connect("localhost", "root", "", "yii2advanced");
    $delivery = mysqli_real_escape_string($c, $delivery);
    $name = mysqli_real_escape_string($c, $name);
    $email = mysqli_real_escape_string($c, $email);
    $phone = mysqli_real_escape_string($c, $phone);
    $message = mysqli_real_escape_string($c, $message);
    $street = mysqli_real_escape_string($c, $street);
    $house = mysqli_real_escape_string($c, $house);
    $flat = mysqli_real_escape_string($c, $flat);
    $novap_num = mysqli_real_escape_string($c, $novap_num);
    $novap_address = mysqli_real_escape_string($c, $novap_address);
    $sql = "INSERT INTO disk_orders (delivery, username, email, phone, message, street, house, flat, novap_num, novap_address, total)".
        " VALUES ('$delivery', '$name', '$email', '$phone', '$message', '$street', '$house', '$flat', '$novap_num', '$novap_address', '$total');";

    $res = $c->query($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Содержание титула тут сделано блоком - чтобы в других шаблонах можно было легко вставить туда другой текст -->
    <title>Замовлення CD-диску "21 грам" гурту "Сонце в кишені"</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <style type="text/css">
        body {
            background: URL('wordpress/wp-content/themes/san-kloud/colors/default/images/body-bg.png');
            font-family: Arial;
        }
        .wrapper {
            width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
        }
        dt {
            float: left;
            width: 300px;
        }
        textarea {
            width: 230px;
        }
    </style>
</head>
<body>
<div class="wrapper">
<h1>Замовлення CD-диску "21 грам" гурту "Сонце в кишені"</h1>
<p><img src="images/sontsevk_1_360.jpg" alt="Sontse vk logo" /></p>
<p>Ви замовили <?php echo $amount ?> диск<?php echo (($amount %10 <5) && ($amount %10 >1)) ? 'и' : ($amount %10 >1 ? 'ів' : ''); ?> гурту "Сонце в кишені".</p>
<?php if ($valid) { ?>
    <p>Перевірте заповнені дані:</p>
    <ul>
        <li>Ваше ім'я та прізвище: <?php echo $name; ?></li>
        <li>Спосіб доставки: <?php echo $deliveryLabel; ?></li>
        <li>Eмейл: <?php echo $email; ?></li>
        <li>Телефон: <?php echo $phone; ?></li>
        <li>Додаткове повідомлення: <?php echo $message; ?></li>
        <?php if ($delivery =='ukrposhta') { ?>
        <li>Адреса: <?php echo $city.', вул. '.$street.', буд. '.$house. ', кв. '.$flat; ?></li>
        <?php } else if ($delivery =='novaposhta') { ?>
         <li>Адреса відділення Нової пошти: <?php echo $novap_address.' (відділення '.$novap_num.')'; ?></li>
        <?php } ?>
        <li>Вартість разом з доставкою: <?php echo $total; ?> грн.</li>
    </ul>
    <p>Для купівлі - натисніть кнопку:</p>
    <form accept-charset="utf-8" action="https://www.liqpay.com/api/pay" method="POST">
        <input name="public_key" type="hidden" value="i71442848566" />
        <input name="amount" type="hidden" value="<?php echo $total?>" />
        <input name="currency" type="hidden" value="UAH" />
        <input name="description" type="hidden" value="CD-диск максі-сингла 21 грам гурту &quot;Сонце в кишені&quot; (<?php echo $amount?> штук, доставка - <?php echo $deliveryLabel ?> )" />
        <input name="type" type="hidden" value="buy" />
        <input name="pay_way" type="hidden" value="card,delayed" />
        <input name="language" type="hidden" value="ru" />
        <input name="btn_text" src="//static.liqpay.com/buttons/p1ru.radius.png" type="image" />
    </form>
</body>
</html>
<?php
exit;

} ?>
<p>Для здійснення замовлення, заповніть деякі дані:</p>
<form method="post" action="order_disk.php">
    <dl>
        <input type="hidden" name="amount" value = "<?php echo $amount; ?>">
        <input type="hidden" name="delivery" value = "<?php echo $delivery; ?>">
        <dt>
            <label for="user-name">Ваше прізвище та ім'я:</label>
        </dt>
        <dd>
            <input type="text" name="name" id = "user-name" value = "">
        </dd>
        <dt>
            <label for="user-email">E-mail:</label>
        </dt>
        <dd>
            <input type="text" name="email" id = "user-email" value = "">
        </dd>
        <dt>
            <label for="user-phone">Телефон:</label>
        </dt>
        <dd>
            <input type="text" name="phone" id = "user-phone" value = "">
        </dd>
        <? if ($deliveryPrice > 0) { ?>
            <dd>
                Ваша адреса:
            </dd>
            <dt>
                <label for="user-city">Місто:</label>
            </dt>
            <dd>
                <input type="text" name="city" id = "user-city" value = "">
            </dd>
            <? if ($delivery =='ukrposhta') { ?>
            <dt>
                <label for="user-street">Вулиця:</label>
            </dt>
            <dd>
                <input type="text" name="street" id = "user-street" value = "">
            </dd>
            <dt>
                <label for="user-house">Будинок:</label>
            </dt>
            <dd>
                <input type="text" name="house" id = "user-house" value = "">
            </dd>
            <dt>
                <label for="user-flat">Квартира:</label>
            </dt>
            <dd>
                <input type="text" name="flat" id = "user-flat" value = "">
            </dd>
            <? } else { //($delivery =='ukrposhta') ?>
                <dt>
                    <label for="user-novap-number">Номер відділення нової пошти:</label>
                </dt>
                <dd>
                    <input type="text" name="novap_num" id = "user-novap-number" value = "">
                </dd>
                <dt>
                    <label for="user-novap-address">Адреса відділення:</label>
                </dt>
                <dd>
                    <input type="text" name="novap_address" id = "user-novap-address" value = "">
                </dd>
            <? } //($delivery =='ukrposhta') ?>
        <? } else { //if ($deliveryPrice > 0) ?>
            Ви вибрали отримання диску у нас особисто. Вкажіть будь-ласка у повідомленні, де ми можемо Вам віддати диск або іншу необхідну інформацію. Після оплати ми з Вами зв'яжемось і домовимось про зустріч.
        <? } // if ($deliveryPrice > 0)?>
        <dt>
            <label for="user-notes">Додаткове повідомлення:</label>
        </dt>
        <dd>
                <textarea name="message" id = "user-message">
                </textarea>
        </dd>
    </dl>
    <?php if (!$valid) { ?>
        <p>Ви не вказали наступні поля:<?php echo $emptyFields; ?></p>
    <?php } ?>

    <input type="submit" value="Підтвердити замовлення">
    </form>
</div>
    </body>
</html>

