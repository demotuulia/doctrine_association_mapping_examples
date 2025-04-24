# Here we create the database and import the database with the content, the content will be deleted.
cd /
mysql --defaults-extra-file=/var/www/config/mysq.cnf -h doctrine_association_mapping_mysql  -uroot -proot doctrine_association_mapping  </var/www/Tests/Scripts/sql/createDatabases.sql
mysql --defaults-extra-file=/var/www/config/mysq.cnf -h doctrine_association_mapping_mysql  -uroot -proot doctrine_association_mapping </var/www/database/doctrine_association_mapping.sql
