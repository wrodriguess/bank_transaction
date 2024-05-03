# TAREFAS


1. Substituir id inteiro por UUID
2. Documentação swagger
3. Criar a classe transaction repository (interface) para fazer a inversão de dependencia (ela deve existir na tabela entity)? teoricamente seria no mode, mas não temos model
4. Transformar value de transfer em objeto de valor




# DÚVIDAS

1. Passar entityManagerInterface como injeção de dependencias no construtor do serviço ou na assinatura do métod?
2. Qual a vantagem/diferença de utilizar injeção de dependencia ao invés de dar um new [CLASSE]?
3. Devo fazer da maneira que relaciona a carteira do usuário ao usuário? tornando um atributo de usuario um objeto de carteira? para que possa acessar o saldo da carteira sem precisar instanciar a carteira?
4. Utilização de try catch, o arquivo CreateTransaction (Service) é claramente o local perfeito para se utilizar try catch, mas vejo vários motivo para retornar exceção, deveria colocar uma exceção maior englobando todo o código e dentro desse try aninhar outras execções mais especificar? ou o try que engloba todo o código não deve existir?
5. 