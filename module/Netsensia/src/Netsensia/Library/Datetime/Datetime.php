<?php
namespace Netsensia\Library\Datetime;

class Datetime
{
    public static function ukDateToGenericDate($datestring)
    {
        $day = substr($datestring, 0, 2);
        $month = substr($datestring, 3, 2);
        $year = substr($datestring, 6, 4);
        
        if (!checkdate($month, $day, $year)) {
            throw new \InvalidArgumentException(
                'Date is not a valid date in DD/MM/YYYY format'
            );
        }
        
        return $year . '-' . $month . '-' . $day;
    }
}
