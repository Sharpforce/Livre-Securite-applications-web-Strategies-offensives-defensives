<?php 
  $_bdd = array();
  $_bdd['server'] = getenv('DB_SERVER') ?: '127.0.0.1';
  $_bdd['port'] = getenv('DB_PORT') ?: '3306';
  $_bdd['user'] = 'sqli2-user';
  $_bdd['password'] = 'passw0rd.sqli2';
  $_bdd['database'] = 'sqli2';
?>