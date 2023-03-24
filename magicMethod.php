<?php
///////////////////////////// __set_state ////////////////////////////////////////////////////////
/// https://git.fabrikant.ru/ets-applications/223smsp-zp-rosatom/-/blob/ROSATOM-3890/config/autoload/global.php
$p1 = new DateTime(
    '2023-03-14 00:00:00.000000',
    new \DateTimeZone('Europe/Moscow')
);

$p2 = DateTime::__set_state([
    'date' => '2023-03-14 00:00:00.000000',
    'timezone_type' => 3,
    'timezone' => 'Europe/Moscow',
]);
var_dump($p1);
var_dump($p2);
var_dump($p1 == $p2); // true!

$exportedDate = var_export($p1,true);
eval('$qwe= ' . $exportedDate . ';');
var_dump($qwe);
/**
object(DateTime)#3 (3) {
["date"]=>
string(26) "2023-03-14 00:00:00.000000"
["timezone_type"]=>
int(3)
["timezone"]=>
string(13) "Europe/Moscow"
}
 */

//serialize — Генерирует пригодное для хранения представление переменной.
//При сериализации объекта PHP пытается вызвать магические методы __serialize() или __sleep() перед сериализацией.
//А еще функция serialize() проверяет, присутствует ли в классе метод с магическим именем __sleep(). Если это так, то этот метод выполняется до любой операции сериализации.
$r = serialize($p1);
var_dump(unserialize($r));//Для превращения сериализованной строки обратно в PHP-значение. Вызывается __unserialize() или __wakeup(), если он есть у объекта
//При unserialize вызывается __wakeup(), если есть. Например коннекты к БД восстанавливает.

///////////////////////////// __invoke ////////////////////////////////////////////////////////
//https://git.fabrikant.ru/ets/integration-rosatom-forms/-/blob/GTW-221/src/Service/ExportPublishRequest.php

class qwe
{
    protected $c;
    public function __construct(int $c)
    {
        $this->c = $c;
    }

    public function __invoke($r)
    {
        return $r + $this->c;
    }

    public static function __callStatic($name, $arguments)
    {
        echo "Вызов статического метода '$name' "
            . implode(', ', $arguments). "\n";
    }

    public static function asdasdasd()
    {
        var_dump('Вызвал меня - asdasdasd');
    }
}

$qwe = new qwe(1);
echo $qwe(2); //3

///////////////////////////// __callStatic ////////////////////////////////////////////////////////
qwe::qwe();// Выведет: "Вызов статического метода 'qwe'". запускается при вызове недоступных методов в статическом контексте.
qwe::asdasdasd();// Выведет только: "Вызвал меня - asdasdasd"


//////////////////// _set __get ///////////////////////////////////////////////////////////////////
class SetGetPrivate
{
    private $r;

    public function __get($name)
    {
        return 123;
    }

    public function __set($name, $val)
    {
        echo 321;
    }
}

$r = new SetGetPrivate();
var_dump($r->r);
