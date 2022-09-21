<?php

require_once realpath("vendor/autoload.php");


function initialCreate()
{
    $s = new \Src\Repository\UserRepository();
//    $log = $s->insertUser(User::register("3442", "123123", "asd", "asd@asd.asd"));
//    if ($log)
//        var_dump($log);
//    else {
//        var_dump('adad');
//    }
    $d = $s->checkUser(new \Src\Models\User(['phone' => 3442, 'password' => 123123]));
    var_dump($d);
}

initialCreate();