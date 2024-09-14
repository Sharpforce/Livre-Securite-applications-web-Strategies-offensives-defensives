<?php 
  $_bdd = array();
  $_bdd['server'] = getenv('DB_SERVER') ?: '127.0.0.1';
  $_bdd['port'] = getenv('DB_PORT') ?: '3306';
  $_bdd['user'] = 'cross_site_request_forgery2-user';
  $_bdd['password'] = 'passw0rd.cross_site_request_forgery2';
  $_bdd['database'] = 'cross_site_request_forgery2';
?>