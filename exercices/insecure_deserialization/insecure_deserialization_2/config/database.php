<?php 
  $_bdd = array();
  $_bdd['server'] = getenv('DB_SERVER') ?: '127.0.0.1';
  $_bdd['port'] = getenv('DB_PORT') ?: '3306';
  $_bdd['user'] = 'insecure_deserialization2-user';
  $_bdd['password'] = 'passw0rd.insecure_deserialization2';
  $_bdd['database'] = 'insecure_deserialization2';
?>