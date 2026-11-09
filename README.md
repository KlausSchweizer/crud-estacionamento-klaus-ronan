# Estacione Aqui

- Veículos
- Tickets
- Vagas dinâmicas
- Clientes associados a veículos
- Logs
- Funcionários.

## Funcionários

Os usuários que fazem login e realizam todos os cadastros do sistema.

## Logs

Gerados dinamicamente quando se cadastra, edita ou deleta um veículo ou ticket. 

Possível de gerar PDF de relatório.

## Clientes

Cadastra-se nome e e-mail, ao vincular a um veículo, quando este estaciona e é retirado, é enviado automaticamente um PDF com o Recibo de pagamento e as informações do ticket ao cliente.

## Vagas

Possuem cadastro dinâmico conforme Fileira (A, B, C...) e índice (1, 2, 3...). Assim, temos as vagas A1, AB2 etc. No cadastro de ticket é preciso associá-lo a uma vaga, que a torna ocupada e a impede de ser excluída pelo usuário.

## Tickets

A erntidade mais fundamental da tabela, associa-se a um veículo e vaga, em que coloca-se o horário de entrada e, opcionalmente, de saída (ao retirar o veículo), o que gera um preço para o valor da "estacionada".

## Veículos

Relacionamento com clientes. Possui uma cor selecionada que dinamicamente mudará a cor do símbolo do veículo quando este ocupa uma vaga.

