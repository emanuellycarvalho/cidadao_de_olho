# Cidadão de Olho
Os cidadãos do estado de Minas Gerais estão muito interessados em monitorar como o dinheiro do estado está sendo gasto. Gostariam de acompanhar quem são os deputados que mais gastam, além disso, como maneira de divulgação destes dados, desejam também saber qual mídia social tem mais impacto para divulgar o ranking dos “gastadores”. Buscam, de forma geral, viabilizar o monitoramento público estadual de gastos em verbas indenizatórias.

## Instalação
- `cd {cidadao_de_olho}`
- `composer install`
- copie o `.env.example` e o renomeie para `.env`.
- `php artisan key:generate`
- `docker-compose up` <sub>Obs: o Docker precisa estar ativo.</sub>
- `./vendor/bin/sail php artisan migrate`
- `http://localhost/api/deputados/redes-sociais/mais-utilizadas` <sub>Para povoar o banco de dados com as informações da api.</sub>

## Ferramentas e versões
<table>
  <tr>
    <th><b>Ferramenta</b></th>
    <th><b>Versão</b></th>
  </tr>
  <tr>
    <td>PHP</td>
    <td>8.1.13</td>
  </tr>
  <tr>
    <td>Laravel</td>
    <td>9.45.1</td>
  </tr>
  <tr>
    <td>NPM</td>
    <td>9.2.0</td>
  </tr>
</table>

## Fonte
Os dados utilizados nessa aplicação foram retirados dos [dados abertos da Assembleia Legislativa de Minas Gerais](http://dadosabertos.almg.gov.br/ws/ajuda/sobre).

## Documentação
A documentação completa está disponível [neste link](https://docs.google.com/document/d/1bkg0uE89hlXm0t7b1bF8kSyo1sxi_ShW9jwBbKqvOC8/edit?usp=sharing).

