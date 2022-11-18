<?php

//Пусть есть функция:
/**
 * @param $a
 * @param $b
 * @return int
 */
function sum($a, $b)
{
    return $a + $b;
}

//Создадим объекь-рефлектор
$sumReflector = new ReflectionFunction('sum');
echo $sumReflector->getFileName(); // В каком файле объявлена функция
echo $sumReflector->getStartLine();//строка начала
echo $sumReflector->getEndLine();//строка конца
echo $sumReflector->getDocComment();//комментарии к функции

//Рефлексия объектов

class Dmitriy {
    private $name = 'Dima';
    protected $lastName = 'Gavrik';
    public function getName() {
        return $this->name;
    }
    private function getLastName() {
        return $this->lastName;
    }
}

$q = new Dmitriy();
$reflector = new \ReflectionObject($q);
var_dump($reflector->getProperties());//Смотрим свойства объекта [ [имя свойства, имя класса,], ... ]
var_dump($reflector->getMethods());// все методы

$privatedMethod = $reflector->getMethod('getLastName');
$privatedMethod->setAccessible(true);//true, чтобы сделать метод доступным, или false.
//Можно так:
$privatedMethod = new ReflectionMethod("Dmitriy", "getLastName");
$privatedMethod->setAccessible(true);
$obj = new Dmitriy();
echo $privatedMethod->invoke($obj);//выполнит метод