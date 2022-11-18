<?php

$message = 'привет';

// Без "use"
$example = function () {
    var_dump($message);
};
$example(); //Notice: Undefined variable: message in /example.php on line 6 NULL

// Наследуем $message
$example = function () use ($message) {
    var_dump($message);
};
$example();//привет

// Значение унаследованной переменной задано там, где функция определена,
// но не там, где вызвана
$message = 'мир';
$example();//привет

// Сбросим message
$message = 'привет';
// Наследование по ссылке
$example = function () use (&$message) {
    var_dump($message);
};
$example();

// Изменённое в родительской области видимости значение
// остаётся тем же внутри вызова функции
$message = 'мир';
echo $example();//мир

// Замыкания могут принимать обычные аргументы
$example = function ($arg) use ($message) {
    var_dump($arg . ', ' . $message);
};
$example("привет");//привет, мир

// Объявление типа возвращаемого значения идет после конструкции use
$example = function () use ($message): string {
    return "привет $message";
};
var_dump($example());


// В php 7.4 появились стрелочные функции
$y = 1;
$fn1 = fn($x) => $x + $y;
// эквивалентно использованию $y по значению:
$fn2 = function ($x) use ($y) {
    return $x + $y;
};
var_export($fn1(3));

//Начиная с PHP 8.0.0, список наследуемых переменных может завершаться запятой: use ($q1,)
$fn3 = function ($x) use ($y, ) {};

//Стрелочные функции захватывают переменные по значению автоматически, даже когда они вложены:
$z = 1;
$fn = fn($x) => fn($y) => $x * $y + $z;
var_export($fn(5)(10));