<?php

use Src\Models\ReservedRoom;
use Src\Models\User;

require_once realpath("vendor/autoload.php");


function initialCreate()
{
//    $s = new \Src\Repository\ReservationRepository();
////    $log = $s->insertUser(User::register("3442", "123123", "asd", "asd@asd.asd"));
////    if ($log)
////        var_dump($log);
////    else {
////        var_dump('adad');
////    }
//    $date = new \Src\Models\ReserveDate("2000", 12, 23, 12);
//    try {
//        $d = $s->checkFree(new ReservedRoom([
//            'room' => new \Src\Models\Room(['room_number' => 1]),
//            'user' => new User(['phone' => '3442']),
//            'start_date' => $date,
//            'end_date' => $date->getEndDate(5),
//        ]));
//    }catch (\Src\Repository\Exceptions\ReserveException $exception) {
//        var_dump($exception->getReservedRoom());
//    }
//
////    var_dump($d);
}

initialCreate();