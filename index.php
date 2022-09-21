<?php

require_once realpath("vendor/autoload.php");

// не совсем понял вас насчет SMS, так как через api я отправлял всегда , подключался к какому то серверу
// я вам оставил просто пример , как я подключил к eskiz
function initialCreate()
{
    $main = new \Src\Commands\MainCommand();
    $main->getCommand();
}

initialCreate();