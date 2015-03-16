#!/bin/bash

#http://sheharyar.me/blog/regular-mongo-backups-using-cron/

echo "Hao City Cabs Server bootup.."

echo "Starting tx_sms_service.py"

echo "" > nohup.out
sudo nohup python tx_sms_service.py &
sudo ps -aux | grep tx_sms_service

echo "Starting tx_alert_mongo.py"

echo "" > alert_to_mongo/nohup.out
nohup python alert_to_mongo/tx_alert_mongo.py &
sudo ps -aux | grep tx_alert_mongo

echo "Starting push-server.php"

echo "" > ../zerotest/nohup.out
nohup php -a ../zerotest/push-server.php &
sudo ps -aux | grep push-server


echo "Starting Wso2 Cep"

echo "" > ../wso2cep-4.0.0/bin/nohup.out
nohup ../wso2cep-4.0.0/bin/wso2server.sh &
sudo ps -aux | grep wso2server

echo "Startup complete."