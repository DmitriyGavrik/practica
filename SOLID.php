<?php
//S � Single Responsibility

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
//���� ��� ���� ��������� � excel, �� ���� ����� �������� saveAnimal, �����, ���� ����������� �����
//saveAnimal ���� �������� � ������.

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// O � Open-Closed

# ���
function animalSound_�������(array $animals) {
    /** @var Animal $animal */
    foreach ($animals as $animal) {
        switch ($animal->getName()) {
            case 'dog': return '�����';
            case 'cat': return '���';
        }
    }
}
//� ���� ����� �������� ??? ������� ���� ����� ��������. � ���� ����� ������ �������� ������� �� ���������, �� ���������� ��� ���� ?!
//���� ���� ���:

class Dog extends Animal
{
    public function sound():string {
        return '��������';
    }
}

//����� �������� - ����� ����� �� ����� ������� � ������� �� ���� ���� �������:
function animalSound(array $animals) {
    /** @var Animal $animal */
    foreach ($animals as $animal) {
        $animal->sound();
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// L - ������� ����������� ������� ������
//������:
$dog = new Dog();
if ($dog->getName() == '����') {
    $sound = '�������';
}
class StupidDog extends Dog//����
{
    public function sound():string {
        return '�������';
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// I - ������� ���������� ����������

interface Shape
{
    public function drawCircle();//����
    public function drawSquare();//�������
    public function drawRectangle();//�������������
    public function drawTriangle();//�����������
}

//����� ��� ������ �� ����� ��� ����� ������
class Circle_1 implements Shape
{
    public function drawCircle(){}
    public function drawSquare(){}
    public function drawRectangle(){}
    public function drawTriangle(){}
}

//������ �� ��������� ���������, ��� �� ������ ���� ������ ����������:

interface ICircle
{
    public function drawCircle();//����
}

class Circle implements ICircle
{
    public function drawCircle(){}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// D - ������� �������� ������������

// ��������� ������� ������
// (������ ������� ������� �� ������ �������� �� ������� ������� �������, ��� ���� ������� ������ �������� �� ����������):

class XMLHttpService//�������������� ���������
{
}

class HttpService //��������������� ���������
{
    public function __construct(XMLHttpService $qwe)
    {
        //.......
    }
}
//Http ������� �� XMLHttpService. � ���� �� ����� �������� ��� �� ��� �� ������? ��� ������������ �������� ��������

//���� ������� ���:
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