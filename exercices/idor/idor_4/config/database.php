<?php 
  $_bdd = array();
  $_bdd['server'] = getenv('DB_SERVER') ?: '127.0.0.1';
  $_bdd['port'] = getenv('DB_PORT') ?: '3306';
  $_bdd['user'] = 'idor4-user';
  $_bdd['password'] = 'passw0rd.idor4';
  $_bdd['database'] = 'idor4';
?>