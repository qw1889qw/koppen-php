<?php

function show_if_set($value) {
  echo $_SESSION[$value] ?? ''; // don't need to use session_start() in this script?
}

function f_to_c($temp) {
  return ($temp - 32) * (5 / 9);
}

function mean($num1, $num2) { // only calculates mean of 2 numbers
  return ($num1 + $num2) / 2;
}

function get_first_element($arr = []) {
  return $arr[0];
}

function get_second_element($arr = []) {
  return $arr[1];
}

function determine_checked($obj, $prop, $val) {
  if (isset($obj)) {
    if ($obj->$prop === $val) {
      echo 'checked';
    }
  }
}

function determine_checked_default($obj, $prop, $val) {
  if (isset($obj)) {
    determine_checked($obj, $prop, $val);
  } else {
    echo 'checked';
  }
}