<?php
//S – Single Responsibility

abstract class Animal
{
    public function __construct(
        private string $name,
    ) {}

    abstract public function sound(): string;

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function saveAnimal(Animal $animal) {
        //.......
    }
}
//Если нам надо сохранять в excel, то надо будет изменять saveAnimal, флаги, либо дублировать класс
//saveAnimal надо фигачить в маппер.

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// O — Open-Closed

# поём
function animalSound_попытка(array $animals) {
    /** @var Animal $animal */
    foreach ($animals as $animal) {
        switch ($animal->getName()) {
            case 'dog': return 'ррррр';
            case 'cat': return 'мяу';
        }
    }
}
//А если новое животное ??? придётся этот метод изменять. А если какое нибудь животное зависит от параменра, то передавать для всех ?!
//Надо типо так:

class Dog extends Animal
{
    public function sound():string {
        return 'Рррррррр';
    }
}

//новое животное - новый класс со своим методом и функцию не надо ваще трогать:
function animalSound(array $animals) {
    /** @var Animal $animal */
    foreach ($animals as $animal) {
        $animal->sound();
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// L - Принцип подстановки Барбары Лисков
//Вместо:
$dog = new Dog();
if ($dog->getName() == 'Мопс') {
    $sound = 'мяяуууу';
}
class StupidDog extends Dog//Мопс
{
    public function sound():string {
        return 'мяяуууу';
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// I - Принцип разделения интерфейса

interface Shape
{
    public function drawCircle();//круг
    public function drawSquare();//квадрат
    public function drawRectangle();//прямоугольник
    public function drawTriangle();//треугольник
}

//почти все методы не нужны для этого класса
class Circle_1 implements Shape
{
    public function drawCircle(){}
    public function drawSquare(){}
    public function drawRectangle(){}
    public function drawTriangle(){}
}

//фигуры не совпадают настолько, что мы создаём ваще разные интерфейсы:

interface ICircle
{
    public function drawCircle();//круг
}

class Circle implements ICircle
{
    public function drawCircle(){}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// D - Принцип инверсии зависимостей

// Нарушение первого пункта
// (модули верхних уровней не должны зависеть от модулей нижнийх уровней, Оба типа модулей должны зависеть от абстракций):

class XMLHttpService//низкоуровневый компонент
{
}

class HttpService //высокоуровненый компонент
{
    public function __construct(XMLHttpService $qwe)
    {
        //.......
    }
}
//Http зависит от XMLHttpService. А если мы хотим заменить его на что то другое? для тестирования заглушку например

//Надо сделать так:
interface Connection {

}
class XMLHttpService2 implements Connection {

}

class HttpService2
{
    public function __construct(Connection $qwe)
    {
        //.......
    }
}