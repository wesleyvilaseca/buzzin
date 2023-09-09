#!/bin/bash
( cd /etc/apache2/sites-avaliable/ && a2ensite * )
( cd /etc/apache2/sites-avaliable/ && a2enmod rewrite )
exec apache2-foreground