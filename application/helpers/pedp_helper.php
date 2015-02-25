<?php

function date_not_empty($str_date) {
  if (!in_array(trim($str_date), array('', '0000-00-00', '1970-01-01', '1969-12-31'))) {
    return true;
  } else {
    return false;  
  }
}

function get_quarter_of_date($str_date = '') {
  $quarter = 1;
  if (!$str_date) {
    $month = date('n');
  } else {
    $month = date('n', strtotime($str_date));
  }
  if ($month < 4) {
    $quarter = 1;
  }
  if ($month > 3 && $month < 7) {
    $quarter = 2;
  }
  if ($month > 6 && $month < 9) {
    $quarter = 3;
  }
  if ($month > 8 && $month <= 12) {
    $quarter = 4;
  }
  
  return $quarter;
}