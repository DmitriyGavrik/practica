<?php

class View
{
    public function execute()
    {
        echo $this->getRow($_GET);
    }

    public function getRow($params)
    {
        return 'SELECT * FROM tableName WHERE id =' . $params['param'];
    }
}

$q = new View();

var_dump($q->getRow(['param' =>'"1"or1=1' ]));

//SELECT * FROM tableName WHERE id ='1'or'1'=1