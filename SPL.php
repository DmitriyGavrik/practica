<?php

//������ SplFixedArray. � �� ������ ������� ����������������. ������ � php ������������ ��� ������� ��� ��������, � ��� ������ int
// ����� ������������, ����� ������ ������� - ����� �������� ������ ������
$a = new SplFixedArray(5);
$a[1] = 2;
$a[4] = "foo";
var_dump($a);
//object(SplFixedArray)#1 (5) {
//[0]=>
//  NULL
//  [1]=>
//  int(2)
//  [2]=>
//  NULL
//  [3]=>
//  NULL
//  [4]=>
//  string(3) "foo"
//}

//�������. ������������� � �������������� ����������� ������
$q = new SplQueue();
$q->push("�");
$q->push("��");
$q->push("��, ���");
var_dump($q->pop());// "��, ���"

//������� � ������������
$queue = new SplPriorityQueue();
$queue->setExtractFlags(SplPriorityQueue::EXTR_DATA); // �������� ������ �������� ���������

$queue->insert('N', 1);
$queue->insert('O', 2);
$queue->insert('M', 3);
$queue->insert('I', 4);
$queue->insert('D', 5);
$queue->top();

while($queue->valid())
{
    echo $queue->current();
    $queue->next();
}
//DIMON

///////////////////////// ���������
$apIt = new AppendIterator();//��������, ������� ��������� ��������� ������ ���������� ���� �� ������
$array1 = new ArrayIterator(['a' => 'aaaaaa', 'b' => 'bb', 'c' => 'ccccc']);
$array2 = new ArrayIterator(['d' => 'ddddd', 'e' => 'eeeee']);
$apIt->append($array1);
$apIt->append($array2);
//������ �� ���� ���������� ���������:
foreach ($apIt as $item) {
    var_dump($item);
}
//string(6) "aaaaaa"
//string(2) "bb"
//string(5) "ccccc"
//string(5) "ddddd"
//string(5) "eeeee"

//////////////////////////����������
//���� ����������� ��������� ����� ������ �����, ������ ������ �� ����
class DmitriyFedorovich implements SeekableIterator {
    private $position;
    private $array = [
        "������ �������",
        "������ �������",
        "������ �������",
        "�������� �������"
    ];

    //����� �������
    public function seek($position) {
        if (!isset($this->array[$position])) {
            throw new OutOfBoundsException("���������������� ������� ($position)");
        }
        $this->position = $position;
    }

    /*  ������, ��������� ��� ���������� Iterator */

    public function rewind() {
        $this->position = 0;
    }
    public function current() {
        return $this->array[$this->position];
    }
    public function key() {
        return $this->position;
    }
    public function next() {
        ++$this->position;
    }
    public function valid() {
        return isset($this->array[$this->position]);
    }
}