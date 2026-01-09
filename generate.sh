#!/bin/sh

host="localhost"
db="amman_darshanam"
usr="root"
# pwd="myname@A1"
pwd="vinroot"

echo "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8 COLLATE utf8_general_ci;" | /usr/bin/mysql -u$usr -p$pwd

perl insert_author.pl $host $db $usr $pwd
perl insert_feat.pl $host $db $usr $pwd
perl insert_articles.pl $host $db $usr $pwd
perl ocr.pl $host $db $usr $pwd
