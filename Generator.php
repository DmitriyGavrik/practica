<?php

// ����� �������, ���������� yield, �������� �������� ����������:
function getSomething($from = 0, $to = 10) {
    for ($i = $from; $i <= $to; $i++) {
        echo "|";//����� ������������ ����� ��������, ������� ��������� ��� �� �����
        yield $i; // $i ��������� ��� �������� ����� ��������. ��� ����� ����� ������� ��� return.
    }
}
$generator = getSomething();
foreach ($generator as $value) {
    echo $value;
}
// ����������� ���: |0|1|2|3|4|5|6|7|8|9|10

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ������������� ������:
function getSomethingAssociative($from = 0, $to = 10) {
    for ($i = $from; $i <= $to; $i++) {
        yield $i => 'Q';//����� => ��������
    }
}
$generator = getSomethingAssociative(0,5);
foreach ($generator as $key => $value) {
    echo $key . ' ' . $value . ' | ';
}
// �������: 0 Q | 1 Q | 2 Q | 3 Q | 4 Q | 5 Q |

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ����� �������� ��, ��� ����� ������ �������:
function &generalisimusAxuenus() {
    $value = 3;
    while ($value > 0) {
        yield $value;
    }
}
foreach (generalisimusAxuenus() as &$number) {
    echo (--$number).'... ';//��������� ��� ��, ��� ����� ������ � ����������
}
//�������: 2... 1... 0...

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ���� ��������� ������ �������:
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
// �������: Dima
