Problema de design (25min)

GetWallet e SetWallet não deveria estar dentro da entidade User.php

Isso dificulta a manetunebilidade e acessibilidade

Responsabilidade única: as responsabilidades estão se misturando

Além disso o saque e deposito não devem estar no construtor da entidade transfer, deve-se exisir um método para executar tal funcionalidade

Quem deve fazer a transferencia é o service, ele deve chamar o método da entidade "transfer" e não executar automaticamente no construtor

## INSTALAR MOCKOON DESKTOP (39MIN)

---

Após subir alterações na API acompanhar via sentry o tempo de resposta da API e das querys (OBSERVABILIDADE)
-> Aprender como fazer!

Sempre que ocorrer um erro/problema tente tirar uma lição disso.
Sempre há algo que poderia ser feito diferente.

PESQUISAR:
- "Coss mortin" -> Não sei como escreve, mas deve ser feito quando ocorre um problema.
Entender o problema e definir plano de ação para quando esse tipo de problema ocorra.

=> criar um segundo registro no mockoon (pagador e recebedor)

=> desacoplar a carteira da entidade User (problema de design)
- entidade
- repository (buscar do próprio walletRepository)

=> transfer não deve realizar a transferencia em seu construtor, deve existir um método especifico 
para isso.
Service deve chamar o método de transfer responsavel por realizar a transferencia.

=> remover o getWallet da entidade Transfer e importar o wallet repository no service e lá buscar a carteira do 
usuário

=> a maneira que minha implementação foi realizada há muita consulta (SQL), fazer uma única consulta para buscar
payer e payee, além disso para buscar payerWallet e payeeWallet
-> Consulta separando qual é o payee e qual é o payeer wallet

=> utilizar o mockoon via GUI


