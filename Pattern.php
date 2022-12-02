<?php

//1) Поведения
//1.1) Стратегия

interface ICTC
{
    public function doSmth(array $data);
}

class CTC_1 implements ICTC
{
    public function doSmth(array $data)
    {
        echo "СТС первого типа";
    }
}

class CTC_2 implements ICTC
{
    public function doSmth(array $data)
    {
        echo "Стс второго типа";
    }
}

class Controller
{
    public function execute()
    {
        $sorter = new CTC_2();//какой класс - хз. Должна быть какая то логика.
        $sorter->doSmth($_POST);
    }
}

//1.2) Посредник (Mediator)

class SenderMediator
{
    //Как то отправляет письмецо:
    public function send($msg)
    {
        // как то тут отправляется соощение. Как - хз, может вызвать какой то сервис при какой то логике.
    }
}

class User
{
    //............

    private SenderMediator $senderMediator;

    public function __construct(SenderMediator $senderMediator)
    {
        $this->senderMediator = $senderMediator;
    }

    public function sendMail($message)
    {
        $this->senderMediator->send($message);
    }
}

$mediator = new SenderMediator();

$user = new User($mediator);
$user->sendMail('Лол');

//1.3) Итератор

//1.4) Наблюдатель (Observer)

//Вакансия
class JobPost
{
    protected $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
}

//Чувак, ищущий работу
class JobSeeker
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    //В случае новой работы:
    public function onJobPosted(JobPost $job)
    {
        // Делаем что-то с публикациями вакансий
        echo 'Привет ' . $this->name . '! Появилась новая работа: '. $job->getTitle();
    }
}

class JobPostings
{
    /** @var JobSeeker[] */
    protected $observers = [];

    public function attach(JobSeeker $observer)
    {
        $this->observers[] = $observer;
    }

    public function addJob(JobPost $jobPosting)
    {
        $this->notify($jobPosting);
    }

    protected function notify(JobPost $jobPosting)
    {
        foreach ($this->observers as $observer) {
            //Тут какая нибудь логика фильтрации чуваков .... И отправляем письма:
            $observer->onJobPosted($jobPosting);
        }
    }
}

// Создаем соискателей
$johnDoe = new JobSeeker('Дима');
$janeDoe = new JobSeeker('Саня');

// Создаем публикацию и добавляем подписчика
$jobPostings = new JobPostings();
$jobPostings->attach($johnDoe);
$jobPostings->attach($janeDoe);

// Добавляем новую работу и смотрим получит ли соискатель уведомление
$jobPostings->addJob(new JobPost('Software Engineer'));

// 2.2) Абстрактная фабрика (Abstract Factory)
interface Door
{
    public function getDescription();
}

//Несколько типов дверей:

class WoodenDoor implements Door
{
    public function getDescription()
    {
        echo 'Я деревянная дверь';
    }
}

class IronDoor implements Door
{
    public function getDescription()
    {
        echo 'Я железная дверь';
    }
}

// Несколько чуваков, которые двери делают:

interface DoorFittingExpert
{
    public function getDescription();
}

class Welder implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'Я работаю только с железными дверьми';
    }
}

class Carpenter implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'Я работаю только с деревянными дверьми';
    }
}

// Фабрики для каждого типа:

interface DoorFactory
{
    public function makeDoor(): Door;
    public function makeFittingExpert(): DoorFittingExpert;
}

// Деревянная фабрика вернет деревянную дверь и столяра
class WoodenDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new WoodenDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Carpenter();
    }
}

// Железная фабрика вернет железную дверь и сварщика
class IronDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new IronDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Welder();
    }
}

$woodenFactory = new WoodenDoorFactory();

$door = $woodenFactory->makeDoor();
$expert = $woodenFactory->makeFittingExpert();

$door->getDescription();  // Вывод: Я деревянная дверь
$expert->getDescription(); // Вывод: Я работаю только с деревянными дверями

// 2.3) Билдер

//Вместо такого:
/**
public function __construct($size, $cheese = true, $pepperoni = true, $tomato = false, $lettuce = true)
{
}
 * где куча параметров, передаем один билдер
 */

class Burger
{
    protected $size;
    protected $cheese;

    public function __construct(BurgerBuilder $builder)
    {
        $this->size = $builder->size;
        $this->cheese = $builder->cheese;
    }
}

class BurgerBuilder
{
    public $size;
    public $cheese;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function addCheese()
    {
        $this->cheese = true;
        return $this;
    }

    public function build(): Burger
    {
        return new Burger($this);
    }
}

$burger = (new BurgerBuilder(14))
    ->addCheese('qwerwerwer')
    //->add ....
    ->build();

//3.1) адаптер

// Хотим охотиться на львов. Есть африканские и азиатские:

interface Lion
{
    public function roar();
}

class AfricanLion implements Lion
{
    public function roar()
    {
    }
}

class AsianLion implements Lion
{
    public function roar()
    {
    }
}

// Охотник только на львов
class Hunter
{
    public function hunt(Lion $lion) {    }
}

// Но, бля, есть собачка, которая хочет охоттиться
class Dog
{
    public function ГафБляяя()//только "гав", но за ним тоже хотим охотиться
    {
    }
}

// Адаптер, чтобы сделать Dog совместимой с нашей игрой
// Делаем его типа тигром:
class dDogAdapter implements Lion
{
    protected $dog;
    public function __construct(Dog $dog)
    {
        $this->dog = $dog;
    }
    public function roar()
    {
        $this->dog->ГафБляяя();
    }
}

//3.2) Декоратор (Decorator)

interface Coffee
{
    public function getCost();
    public function getDescription();
}

class SimpleCoffee implements Coffee
{
    public function getCost()
    {
        return 10;
    }

    public function getDescription()
    {
        return 'Простой кофе';
    }
}

class MilkCoffee implements Coffee
{
    protected $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function getCost()
    {
        return $this->coffee->getCost() + 2;
    }

    public function getDescription()
    {
        return $this->coffee->getDescription() . ', молоко';
    }
}

class WhipCoffee implements Coffee
{
    protected $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function getCost()
    {
        return $this->coffee->getCost() + 5;
    }

    public function getDescription()
    {
        return $this->coffee->getDescription() . ', сливки';
    }
}

class VanillaCoffee implements Coffee
{
    protected $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function getCost()
    {
        return $this->coffee->getCost() + 3;
    }

    public function getDescription()
    {
        return $this->coffee->getDescription() . ', ваниль';
    }
}

$someCoffee = new SimpleCoffee();
echo $someCoffee->getCost(); // 10
echo $someCoffee->getDescription(); // Простой кофе

$someCoffee = new MilkCoffee($someCoffee);
echo $someCoffee->getCost(); // 12
echo $someCoffee->getDescription(); // Простой кофе, молоко