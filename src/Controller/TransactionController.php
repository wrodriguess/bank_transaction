<?php

namespace App\Controller;

use App\DTO\TransferDTO;
use App\Service\Transfer;
use DomainException;
use Respect\Validation\Exceptions\NestedValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Respect\Validation\Validator as v;

class TransactionController extends AbstractController
{
    private Transfer $transfer;

    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    #[Route('/transaction', name: 'create_transaction', methods: ['POST'])]
    public function create(Request $request): Response {
        try {
            $data = json_decode($request->getContent(), true);
            $data['value'] = (float)$data['value'];

            v::key('value', v::floatType()->notEmpty())
                ->key('payer_id', v::intType())
                ->key('payee_id', v::intType())
                ->assert($data);

            $transfer = new TransferDTO($data['payer_id'], $data['payee_id'], $data['value']);
            $this->transfer->execute($transfer);
        } catch (DomainException $e) {
            $payload = [
                'status' => 'error',
                'type' => $e->getType(),
                'message' => $e->getMessage()
            ];

            return new JsonResponse($payload, 400);
        } catch (NestedValidationException $e) {
            $payload = [
                'status' => 'error',
                'type' => 'ValidationError',
                'message' => 'Houve um ou mais erros ao validar o corpo da requisição.',
                'errors' => $e->getMessages()
            ];

            return new JsonResponse($payload, 422);
        }
        return new JsonResponse($data, 201);
    }
}
