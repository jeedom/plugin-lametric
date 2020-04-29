Plugin para exibir notificações / informações sobre
LaMetric.

Configuração do plugin 
=======================

Após a instalação do plug-in, é necessário criar um indicador "
App "no site da LaMetric :

-   1 \. Se rendre à l'adresse : <https://developer.lametric.com>

-   2 \. Crie um "INDICATOR APP" :

![lametric1](../images/lametric1.png)

-   3 \. Configure um ícone, um nome e selecione Push in "Communication
    Tipo" :

![lametric2](../images/lametric2.png)

-   4 \. Dê um nome e uma descrição ao seu aplicativo e marque "Aplicativo particular"
    depois clique em "Salvar" :

![lametric3](../images/lametric3.png)

-   5 \. Publique o aplicativo e instale-o no seu LaMetric usando
    o aplicativo móvel.

Depois que o aplicativo é publicado, você tem as informações
essencial para a configuração do plugin.

![lametric4](../images/lametric4.png)

Você pode criar um novo equipamento no Jeedom e preencher
os campos solicitados :

![lametric5](../images/lametric5.png)

Usando o plugin 
=====================

2 pedidos são criados automaticamente ao adicionar equipamento
:

-   **Message** ⇒ Permite o envio de mensagens

-   **Vider** ⇒ Permite redefinir a exibição ("JEEDOM"
    registre-se)

O comando do tipo de mensagem contém 2 campos : \* **ID do ícone** :
Corresponde ao número do ícone desejado (não coloque a lista \#;
des icônes disponibles ici : <https://developer.lametric.com / icons>) \*
**Texte** : Corresponde ao texto que você deseja exibir

É possível enviar mais mensagens em um envio, separando
ícones e textos por personagem : **|**

Aqui está, por exemplo, um cenário que envia 4 informações diferentes em 1
remessa única :

![lametric6](../images/lametric6.png)
