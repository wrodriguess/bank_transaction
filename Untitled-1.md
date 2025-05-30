https://www.awesomescreenshot.com/video/27352000

(Som 43seg a frente da imagem)

- Testes unitários
- Documentação (swagger)
- Pesquisar em inglês


Pesquisar:
- responsabilidade dos objetos/classes/camadas (controller, service, repository, etc) -> Ser reutilizaveis
- POO
- SOLID


TAREFAS:
- Persist ficar dentro do repository (Entity manager deve ser inserido dentro do 
repository)
- implementar uuid
- Substituir o nome de createTransaction para Transfer
- implementar verificação de quando o pagador e recebedor não existem
- testes unitários
- substituir o array passado como parametro de Transfer para um DTO

O QUE O NERIS PEDIU
- entidade transfer fazer muita coisa, refatorar, validar se usuário existe é 
responsabilidade do usuário
- revisar responsabilidades
- criar testes unitários da controller


Nomes de classes e métodos
classes: nomes sempre substantivo
métodos: nomes sempre verbos

---
ISOLAR:

SERVICE/TRANSDER
makeHttpRequest
AuthorizedTransfer
SendNotification

não devem estar aqui, devem estar em classes separadas

---

# TransactionController

1. Recebe o service Transfer como injeção de dependencia
2. Atributi os dados recebidos no corpo da requisição a variavel $data
3. Faz valdação dos tipos e existencia dos dados esperados utilizando Respect Validation
4. Instancia um DTO chamado TransferDTO (string $payerId, string $payeeId, float $value)
5. Chama o método execute do service Transfer, passando TransferDTO como parametro

# Service Transfer

1. Receber UserRepository e TransferRepository como injeção de dependencia
2. Faz early return caso a transferencia não seja autorizada
3. Busca os usuários $payer e $payee, utilizando o método find de UserRepository
4. Cria uma instancia da entidade Transfer, passando como parametro User $payer, User $payee, float $transferDto->value, DateTime $dateTime
5. Chama o método create de TransferRepository para efetivamente criar a transferenia no banco <<< ISSO DEVERIA ESTAR AQUI? É RESPONSABILIDADE DA ENTIDADE SABER LIDAR COM ISSO >>>
6. Caso haja falha ao notificar o recebedor emite uma exception <<< Isso não deveria estar aqui, deveria haver uma classe responsavel por notificações >>>
7. Métodos auxiliares como: makeHttpRequest, authorizedTransfer e sendNotificationToRecipient <<< Rever a responsabilidade do serviço e verificar se esses métodos devem estar aqui >>>