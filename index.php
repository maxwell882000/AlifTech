<?php

require_once realpath("vendor/autoload.php");


function initialCreate()
{
    $main = new \Src\Commands\MainCommand();
    $main->getCommand();
}

initialCreate();