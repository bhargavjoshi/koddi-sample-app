<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('koddi', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=localhost;port=3306;dbname=koddi;user=homestead;password=secret',
  'user' => 'homestead',
  'password' => 'secret',
));
$manager->setName('koddi');
$serviceContainer->setConnectionManager('koddi', $manager);
$serviceContainer->setDefaultDatasource('koddi');