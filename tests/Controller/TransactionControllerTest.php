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

    /**
     * @dataProvider dataProvider
     */
    public function testTransaction(array $payload, string $expectedMessage, int $httpCode): void
    {
        $requestStub = $this->createStub(Request::class);
        $requestStub->method('getContent')->willReturn(json_encode($payload));

        $actual = $this->instance->create($requestStub);

        $this->assertInstanceOf(JsonResponse::class, $actual);
        $this->assertEquals($httpCode, $actual->getStatusCode());
        $this->assertEquals($expectedMessage, (string) $actual->getContent());
    }

    private function dataProvider(): array
    {
        return [
            'valid payload' => [
                $this->validPayload(),
                '{"value":50,"payer_id":1,"payee_id":2}',
                201
            ],
//            'value equals null' => [
//                [
//                    "value" => null,
//                    "payer_id" => 1,
//                    "payee_id" => 2
//                ],
//                '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["value must be of the type float"]}',
//                422
//            ],
            'payer_id equals null' => [
                array_merge($this->validPayload(), ["payer_id" => null]),
                '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["payer_id must be of the type integer"]}',
                422
            ],
            'payer_id equals string' => [
                array_merge($this->validPayload(), ["payer_id" => "1"]),
                '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["payer_id must be of the type integer"]}',
                422
            ],
            'payer_id equals float' => [
                array_merge($this->validPayload(), ["payer_id" => 1.5]),
                '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["payer_id must be of the type integer"]}',
                422
            ],
            'payee_id equals null' => [
                array_merge($this->validPayload(), ["payee_id" => null]),
                '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["payee_id must be of the type integer"]}',
                422
            ],
            'payee_id equals string' => [
                array_merge($this->validPayload(), ["payee_id" => "1"]),
                '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["payee_id must be of the type integer"]}',
                422
            ],
            'payee_id equals float' => [
                array_merge($this->validPayload(), ["payee_id" => 1.5]),
                '{"status":"error","type":"ValidationError","message":"Houve um ou mais erros ao validar o corpo da requisi\u00e7\u00e3o.","errors":["payee_id must be of the type integer"]}',
                422
            ],
        ];
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
