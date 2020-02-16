<?php

function show_if_set($value) {
  echo $_SESSION[$value] ?? ''; // don't need to use session_start() in this script?
}

function mean($num1, $num2) {
  return ($num1 + $num2) / 2;
}