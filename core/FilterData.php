<?php

class FilterData
{
    public function filterNumbers($number)
    {
        $number = filter_var ( $number, FILTER_SANITIZE_NUMBER_INT);
        return $number;
    }

    public function filterName ($name)
    {
        $name = filter_var( $name, FILTER_SANITIZE_STRING);
        return $name;
    }
}