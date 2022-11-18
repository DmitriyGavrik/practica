<?php

//Массив SplFixedArray. В нём только базовая функциональность. Массив в php используется хэш таблица для индексов, а тут только int
// Лучше использовать, когда массив большой - будет занимать меньше памяти
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

//Очередь. Реализованную с использованием двусвязного списка
$q = new SplQueue();
$q->push("Я");
$q->push("Ты");
$q->push("он, она");
var_dump($q->pop());// "он, она"

//Очередь с приоритетами
$queue = new SplPriorityQueue();
$queue->setExtractFlags(SplPriorityQueue::EXTR_DATA); // получаем только значения элементов

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

///////////////////////// Итераторы
$apIt = new AppendIterator();//Итератор, который выполняет несколько других итераторов один за другим
$array1 = new ArrayIterator(['a' => 'aaaaaa', 'b' => 'bb', 'c' => 'ccccc']);
$array2 = new ArrayIterator(['d' => 'ddddd', 'e' => 'eeeee']);
$apIt->append($array1);
$apIt->append($array2);
//пройдёт по всем итераторам поочереди:
foreach ($apIt as $item) {
    var_dump($item);
}
//string(6) "aaaaaa"
//string(2) "bb"
//string(5) "ccccc"
//string(5) "ddddd"
//string(5) "eeeee"

//////////////////////////Интерфейсы
//Есть определённое множество какой нибудь хуеты, гуляем только по нему
class DmitriyFedorovich implements SeekableIterator {
    private $position;
    private $array = [
        "первый элемент",
        "второй элемент",
        "третий элемент",
        "четвёртый элемент"
    ];

    //Задаём позицию
    public function seek($position) {
        if (!isset($this->array[$position])) {
            throw new OutOfBoundsException("недействительная позиция ($position)");
        }
        $this->position = $position;
    }

    /*  Методы, требуемые для интерфейса Iterator */

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