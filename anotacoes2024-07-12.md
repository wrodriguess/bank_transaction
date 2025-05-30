DURANTE AS DISCUSSÕES TÉCNICAS FAÇA PERGUNTAS QUE FACILITEM O ENTENDIMENTO.
NÃO SE PREOCUPE TANTO EM DAR OPNIÃO

REFATORAR SEU PRÓPRIO CÓDIGO TE AJUDA A EVOLUIR RAPIDAMENTE

---

Http client -> mover para repository
NotificationService e TransferAuthorizationService mover para pasta "repository"
Apagar a pasta "Services"



---

PRÓXIMA ENTREGA:

1) CRIAR CAMADAS DENTRO DA PASTA REPOSITORY

- Contracts (interfaces)
- Mysql (TransferRepository, UserRepository, WalletRepository)
- Http (HttpClient, NotificationService, TransferAuthorizationService)

2) PROVIDER: teste para todas as validações em um único método do phpunit

3) ESCREVER O TESTE DO SERVICE (TRANSFER.PHP)
-> Fazer o teste primeiro
-> (DEPOIS REFATORAR PARA INTERFACE)

---
ANOTAÇÕES DE OUTROS ARQUIVOS PARA NÃO PERDER:

Login




Entidades
- Usuario
- Tarefa (prioridade da tarefa, categoria)
-- titulo
-- descrição
-- status (pendente, concluida, atrasada)
-- prioridade
-- categoria
-- created_at
-- updated_at
-- deleted_at



Funcionalidades:
- cadastrar usuário
- login
- recuperar senha
- criar nova tarefa
- ver todas tarefas
- ver uma tarefa
- marcar uma tarefa como concluida
- editar uma tarefa
- excluir uma tarefa
- tarefas atrasadas
- filtrar e ordenar (por data de criação, data de vencimento, prioridade, categoria)
- filtros (todas, mes, semana, hoje, concluidas)
- enviar lembrete (push notification, email, sms)
- sub-tarefas
- buscar uma tarefa pelo titulo, descrição, etc
- criptografar senha
- utilizar uuid
- testes unitarios e de integração

