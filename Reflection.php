<?php

//����� ���� �������:
/**
 * @param $a
 * @param $b
 * @return int
 */
function sum($a, $b)
{
    return $a + $b;
}

//�������� ������-���������
$sumReflector = new ReflectionFunction('sum');
echo $sumReflector->getFileName(); // � ����� ����� ��������� �������
echo $sumReflector->getStartLine();//������ ������
echo $sumReflector->getEndLine();//������ �����
echo $sumReflector->getDocComment();//����������� � �������

//��������� ��������

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
var_dump($reflector->getProperties());//������� �������� ������� [ [��� ��������, ��� ������,], ... ]
var_dump($reflector->getMethods());// ��� ������

$privatedMethod = $reflector->getMethod('getLastName');
$privatedMethod->setAccessible(true);//true, ����� ������� ����� ���������, ��� false.
//����� ���:
$privatedMethod = new ReflectionMethod("Dmitriy", "getLastName");
$privatedMethod->setAccessible(true);
$obj = new Dmitriy();
echo $privatedMethod->invoke($obj);//�������� �����