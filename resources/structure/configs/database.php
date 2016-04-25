<?php
echo <<<EOFDATABASE
<?php
\$ConfigDatabase = ConfigDatabase::getInstance();

\$ConfigDatabase->addDatabase(
	'{$this->getEnvironment()}',
	'{$this->getDatabaseType()}',
	'{$this->getDatabaseType()}:host={$this->getDatabaseHost()};dbname={$this->getDatabaseName()}',
	'{$this->getDatabaseUsername()}',
	'{$this->getDatabasePassword()}',
	'{$this->getDatabasePrefix()}_'
);
EOFDATABASE;
?>