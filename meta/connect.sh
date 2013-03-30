#!/bin/bash

while [[ -z $pass ]]; do
    echo 'Enter database password for user "bohhls":'
    read -s pass
done

mysql -u bohhls -p$pass -h home.jaysan1292.com -D bohhls
