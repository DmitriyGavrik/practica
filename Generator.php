<?php

// Любая функция, содержащая yield, является функцией генератора:
function getSomething($from = 0, $to = 10) {
    for ($i = $from; $i <= $to; $i++) {
        echo "|";//будет отображаться перед символом, который выводится где то внизу
        yield $i; // $i сохраняет своё значение между вызовами. Его также можно считать как return.
    }
}
$generator = getSomething();
foreach ($generator as $value) {
    echo $value;
}
// отобразится так: |0|1|2|3|4|5|6|7|8|9|10

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ассоциативные массив:
function getSomethingAssociative($from = 0, $to = 10) {
    for ($i = $from; $i <= $to; $i++) {
        yield $i => 'Q';//ключь => значение
    }
}
$generator = getSomethingAssociative(0,5);
foreach ($generator as $key => $value) {
    echo $key . ' ' . $value . ' | ';
}
// Выведет: 0 Q | 1 Q | 2 Q | 3 Q | 4 Q | 5 Q |

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Можно изменять то, что лежит внутри функции:
function &generalisimusAxuenus() {
    $value = 3;
    while ($value > 0) {
        yield $value;
    }
}
foreach (generalisimusAxuenus() as &$number) {
    echo (--$number).'... ';//Уменьшаем тут то, что лежит сверху в переменной
}
//Выведет: 2... 1... 0...

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Один генератор внутри другого:
function inner() {
    yield 'i';
    yield 'm';
}
function gen() {
    yield 'D';
    yield from inner();
    yield 'a';
}

foreach (gen() as $q) {
    echo $q;
}
// Выведет: Dima
