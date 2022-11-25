<?php

class ProposalService
{
    public function getProposalsByLotId($lotId)
    {
        $mapper = new MysqlMapperProposal();
        $mapper->filterByLotId($lotId);
        return $mapper->getIteratir();
    }

    public function getProposalsById($id)
    {
        $mapper = new MysqlMapperProposal();
        $mapper->filterById($id);
        return $mapper->getIteratir();
    }
    // .... много MysqlMapperProposal
    //минусы: при изменении БД надо менять такие сервисы, плохо расширяется, много зависимости
    // А если нам надо MysqlMapperProposalRetrading ?
}

////////////////////////////// Фабрика //////////////////////////////////////////
class ProposalServiceWithFabrika
{
    public function getProposalsByLotId($lotId)
    {
        $factory = new ProposalRepositoryFactory();
        /**  MapperInterface $mapper */
        $mapper = $factory->build();
        $mapper->filterByLotId($lotId);
        return $mapper->getIteratir();
    }
}
class ProposalRepositoryFactory
{
    /**
     * @return MapperInterface
     */
    public function build()
    {
        //Если надо изменить хранилище Proposal везде, то делаем мапер и меняем его тут:
        return new MysqlMapperProposal();
    }
}

////////////////////////////// Service Locator //////////////////////////////////////////
class ProposalServiceWithServiceLocator
{
    public function getProposalsByLotId($lotId)
    {
        /**  MapperInterface $mapper */
        $mapper = ServiceLocator::get('ProposalMapper');//на НЭПе исползуется эта штука, которая юзает фабрики и конфиги
        // к названию "ProposalMapper" можно привязать что угодно и переделать когда угодно
        $mapper->filterByLotId($lotId);
        return $mapper->getIteratir();
    }
}

////////////////////////////// Dependency Injection //////////////////////////////////////////
// 1) Setter:
class ProposalServiceSetter
{
    /**
     * @var IProposalRepository
     */
    private $proposalRepository;

    public function setRepository(IProposalRepository $repository)
    {
        $this->proposalRepository = $repository;
    }
}

class MysqlProposalMapper implements IProposalRepository
{
}
class MongoDBProposalMapper implements IProposalRepository
{
}

// Где нибудь так:
$service = new ProposalServiceSetter();
$service->setRepository(new MongoDBProposalMapper());

// 2) Constructor injection:
class ProposalServiceSetterWithConstruct
{
    /**
     * @var IProposalRepository
     */
    private $proposalRepository;

    public function __construct(IProposalRepository $proposalRepository)
    {
        $this->proposalRepository = $proposalRepository;
    }
}

// 3) Interface injection
class ProposalRepository implements IProposalRepository{};
interface IProposalRepository{};

interface IProposalRepositoryInject
{
    public function setRepository(IProposalRepository $repository);
}

class ProposalServiceSetterWithInterfaceInjection implements IProposalRepositoryInject
{
    /**
     * @var IProposalRepository
     */
    private $proposalRepository;

    public function setRepository(IProposalRepository $repository)
    {
        $this->proposalRepository = $repository;
    }
}
$service = new ProposalServiceSetter();
$service->setRepository(new ProposalRepository());