Plugin to display notifications / information on
LaMetric.

Plugin configuration 
=======================

Once the plugin is installed, it is necessary to create an "indicator
App "on the LaMetric website :

-   1 \. Se rendre à l'adresse : <https://developer.lametric.com>

-   2 \. Create an "INDICATOR APP" :

![lametric1](../images/lametric1.png)

-   3 \. Configure an icon, a name and select Push in "Communication
    type" :

![lametric2](../images/lametric2.png)

-   4 \. Give a name and description to your app and check "Private app"
    then click on "Save" :

![lametric3](../images/lametric3.png)

-   5 \. Publish the application then install it on your LaMetric using
    the mobile app.

Once the application is published, you have the information
essential for plugin configuration.

![lametric4](../images/lametric4.png)

You can then create new equipment in Jeedom and fill in
the requested fields :

![lametric5](../images/lametric5.png)

Using the plugin 
=====================

2 orders are automatically created when adding equipment
:

-   **Message** ⇒ Allows the sending of messages

-   **Clear** ⇒ Allows you to reset the display ("JEEDOM"
    then register)

The message type command contains 2 fields : \* **Icon ID** :
Corresponds to the number of the desired icon (Do not put the \#; list
des icônes disponibles ici : <https://developer.lametric.com / icons>) \*
**Text** : Corresponds to the text you want to display

It is possible to send more messages in one send by separating
icons and texts by character : **|**

Here is for example a scenario sending 4 different information in 1
single shipment :

![lametric6](../images/lametric6.png)
