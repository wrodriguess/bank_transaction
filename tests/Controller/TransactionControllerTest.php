<?php

namespace App\Controller;

use App\Service\Transfer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TransactionControllerTest extends TestCase
{
    private Transfer $transferMock;
    private TransactionController $instance;

    public function setup(): void
    {
        $this->transferMock = $this->createMock(Transfer::class);
        $this->instance = new TransactionController($this->transferMock);
    }

    public function testTransactionWithInvalidDataShouldNotWork(): void
    {
        $payload = array_merge($this->validPayload(), ["value" => "", "payer_id" => "1"]);

        $requestStub = $this->createStub(Request::class);
        $requestStub->method('getContent')->willReturn(json_encode($payload));

        $actual = $this->instance->create($requestStub);

        $expectedMessage = '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["value must be of the type float","payer_id must be of the type integer"]}';

        $this->assertInstanceOf(JsonResponse::class, $actual);
        $this->assertEquals(422, $actual->getStatusCode());
        $this->assertEquals($expectedMessage, (string) $actual->getContent());
    }

    public function testTransactionWithValidDataShouldWork(): void
    {
        $payload = $this->validPayload();

        $requestStub = $this->createStub(Request::class);
        $requestStub->method('getContent')->willReturn(json_encode($payload));

        $actual = $this->instance->create($requestStub);

        $expectedMessage = '{"value":50,"payer_id":1,"payee_id":2}';

        $this->assertInstanceOf(JsonResponse::class, $actual);
        $this->assertEquals(201, $actual->getStatusCode());
        $this->assertEquals($expectedMessage, (string) $actual->getContent());
    }

    private function validPayload(): array
    {
        return [
            "value" => 50.0,
            "payer_id" => 1,
            "payee_id" => 2
        ];
    }
}
