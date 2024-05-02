<?php

// функция преобразовывает name и secondname
function formatName($name)
{
  $name = ucfirst(strtolower($name));
  return $name;
}
// функция для проверки email 
function checkEmail($email)
{
  if (strpos($email, '@') !== false) {
    return true;
  } else {
    return false;
  }
}
// функция для проверки isikukood 
function checkIsikukood($isikukood)
{
  if (strlen($isikukood) === 11 && ctype_digit($isikukood)) {
    return true;
  } else {
    return false;
  }
}
