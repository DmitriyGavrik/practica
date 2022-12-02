<?php

class Controller
{
    public function action()
    {
        // �����������
        if (isset($_GET['id'])) {
            throw new Exception('���� id!');
        }
        // ����� ���:
        assert(
            isset($_GET['id']),
            new Exception('�� ������� id')
        );

        $result = (new Model())->doSmth($_GET);

        //�����������
        if (!$result) {
            throw new Exception('���� ������!');
        }

        //����������
        $entity = new Entity();
        $entity->setId(123);

        if (!$this->validateEntity($entity)) {
            throw new Exception('�� ������� Entity!');
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
