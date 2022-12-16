<?php

use PHPUnit\Framework\TestCase;

class MessageSenderTest extends TestCase
{
    public function testThatEmailNotificationIsSentUsingStub()
    {
        $mailer = new GmailMailer();

        $clientStub = $this->createStub(Client::class);
        $clientStub->method('getData')->willReturn('��������� �� ���������');

        $service = new MessageSender($clientStub, $mailer);
        $service->send();
    }

    public function testThatEmailNotificationIsSentUsingMock()
    {
        // ��������� �������� ��� ������ send(),
        // ������� ������ ��������� ������ ���� ���
        // � �������� ��������� ������� �� ������ ($message)
        $mailerMock = $this->createMock(GmailMailer::class);
        $mailerMock->expects($this->once())
            ->method('send')
            ->with($this->equalTo('something'));;

        $client = new Client();

        $sportMetric = new MessageSender($client, $mailerMock);
        $sportMetric->send();
    }
}

class GmailMailer
{
    public function send(string $message): void
    {
        var_dump($message);
    }
}

class Client
{
    public function getData(): string
    {
        // ...
        return '����� �� ������';
    }
}

class MessageSender
{
    public function __construct(
        private $client,
        private $mailer
    ) {
    }

    public function send():void
    {
        $message = $this->client->getData();
        $this->mailer->send($message);
    }
}