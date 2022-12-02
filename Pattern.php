<?php

//1) ���������
//1.1) ���������

interface ICTC
{
    public function doSmth(array $data);
}

class CTC_1 implements ICTC
{
    public function doSmth(array $data)
    {
        echo "��� ������� ����";
    }
}

class CTC_2 implements ICTC
{
    public function doSmth(array $data)
    {
        echo "��� ������� ����";
    }
}

class Controller
{
    public function execute()
    {
        $sorter = new CTC_2();//����� ����� - ��. ������ ���� ����� �� ������.
        $sorter->doSmth($_POST);
    }
}

//1.2) ��������� (Mediator)

class SenderMediator
{
    //��� �� ���������� ��������:
    public function send($msg)
    {
        // ��� �� ��� ������������ ��������. ��� - ��, ����� ������� ����� �� ������ ��� ����� �� ������.
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
$user->sendMail('���');

//1.3) ��������

//1.4) ����������� (Observer)

//��������
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

//�����, ������ ������
class JobSeeker
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    //� ������ ����� ������:
    public function onJobPosted(JobPost $job)
    {
        // ������ ���-�� � ������������ ��������
        echo '������ ' . $this->name . '! ��������� ����� ������: '. $job->getTitle();
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
            //��� ����� ������ ������ ���������� ������� .... � ���������� ������:
            $observer->onJobPosted($jobPosting);
        }
    }
}

// ������� �����������
$johnDoe = new JobSeeker('����');
$janeDoe = new JobSeeker('����');

// ������� ���������� � ��������� ����������
$jobPostings = new JobPostings();
$jobPostings->attach($johnDoe);
$jobPostings->attach($janeDoe);

// ��������� ����� ������ � ������� ������� �� ���������� �����������
$jobPostings->addJob(new JobPost('Software Engineer'));

// 2.2) ����������� ������� (Abstract Factory)
interface Door
{
    public function getDescription();
}

//��������� ����� ������:

class WoodenDoor implements Door
{
    public function getDescription()
    {
        echo '� ���������� �����';
    }
}

class IronDoor implements Door
{
    public function getDescription()
    {
        echo '� �������� �����';
    }
}

// ��������� �������, ������� ����� ������:

interface DoorFittingExpert
{
    public function getDescription();
}

class Welder implements DoorFittingExpert
{
    public function getDescription()
    {
        echo '� ������� ������ � ��������� �������';
    }
}

class Carpenter implements DoorFittingExpert
{
    public function getDescription()
    {
        echo '� ������� ������ � ����������� �������';
    }
}

// ������� ��� ������� ����:

interface DoorFactory
{
    public function makeDoor(): Door;
    public function makeFittingExpert(): DoorFittingExpert;
}

// ���������� ������� ������ ���������� ����� � �������
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

// �������� ������� ������ �������� ����� � ��������
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

$door->getDescription();  // �����: � ���������� �����
$expert->getDescription(); // �����: � ������� ������ � ����������� �������

// 2.3) ������

//������ ������:
/**
public function __construct($size, $cheese = true, $pepperoni = true, $tomato = false, $lettuce = true)
{
}
 * ��� ���� ����������, �������� ���� ������
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

//3.1) �������

// ����� ��������� �� �����. ���� ����������� � ���������:

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

// ������� ������ �� �����
class Hunter
{
    public function hunt(Lion $lion) {    }
}

// ��, ���, ���� �������, ������� ����� ����������
class Dog
{
    public function ��������()//������ "���", �� �� ��� ���� ����� ���������
    {
    }
}

// �������, ����� ������� Dog ����������� � ����� �����
// ������ ��� ���� ������:
class dDogAdapter implements Lion
{
    protected $dog;
    public function __construct(Dog $dog)
    {
        $this->dog = $dog;
    }
    public function roar()
    {
        $this->dog->��������();
    }
}

//3.2) ��������� (Decorator)

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
        return '������� ����';
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
        return $this->coffee->getDescription() . ', ������';
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
        return $this->coffee->getDescription() . ', ������';
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
        return $this->coffee->getDescription() . ', ������';
    }
}

$someCoffee = new SimpleCoffee();
echo $someCoffee->getCost(); // 10
echo $someCoffee->getDescription(); // ������� ����

$someCoffee = new MilkCoffee($someCoffee);
echo $someCoffee->getCost(); // 12
echo $someCoffee->getDescription(); // ������� ����, ������