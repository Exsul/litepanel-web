<?php

if (!isset($language))
  $language = 'en';

$locale = json_decode(file_get_contents("$language.json"), true);

function L( $str, $scope = 'errors' )
{
  global $locale;
  return $locale[$scope][$str];
}
