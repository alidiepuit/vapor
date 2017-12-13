<?php

class Helpers_View_TimeAgo extends Zend_View_Helper_Abstract
{
    public function timeAgo($date) {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $res = date_format($date, 'Y-m-d\TH:i:s\Z');
        return $res;
    }
}