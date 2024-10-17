Problema de design (25min)

GetWallet e SetWallet não deveria estar dentro da entidade User.php

Isso dificulta a manetunebilidade e acessibilidade

Responsabilidade única: as responsabilidades estão se misturando

Além disso o saque e deposito não devem estar no construtor da entidade transfer, deve-se exisir um método para executar tal funcionalidade

Quem deve fazer a transferencia é o service, ele deve chamar o método da entidade "transfer" e não executar automaticamente no construtor

## INSTALAR MOCKOON DESKTOP (39MIN)

---
https://www.youtube.com/watch?v=EAaKeWKgjjE

Após subir alterações na API acompanhar via sentry o tempo de resposta da API e das querys

