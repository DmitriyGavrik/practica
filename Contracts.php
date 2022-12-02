<?php

class Controller
{
    public function action()
    {
        // Предусловия
        if (isset($_GET['id'])) {
            throw new Exception('Нету id!');
        }
        // Можно так:
        assert(
            isset($_GET['id']),
            new Exception('не передан id')
        );

        $result = (new Model())->doSmth($_GET);

        //Постусловия
        if (!$result) {
            throw new Exception('Нету нифига!');
        }

        //Инварианты
        $entity = new Entity();
        $entity->setId(123);

        if (!$this->validateEntity($entity)) {
            throw new Exception('не валиден Entity!');
        }
    }

    private function validateEntity(Entity $entity): bool
    {
        return $entity->getId() > 100;
    }
}

class Model
{
    public function doSmth($data)
    {
        return $data;
    }
}

class Entity
{
    private $id;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
