<?php
echo <<<EOFCORE
<?php
\$ConfigCore = ConfigCore::getInstance();

/**
 * Nome do aplicação.
 */
\$ConfigCore->setAppName('{$this->getName()}');

/**
 * Versão da aplicação.
 */
\$ConfigCore->setAppVersion('{$this->getVersion()}');

/**
 * Linguagem padrão da aplicação.
 */
\$ConfigCore->setAppLanguage('{$this->getLanguage()}');

/**
 * Define se a aplicação vai utilizar o sistema de tradução.
 */
\$ConfigCore->setUseTranslations({$this->getUseTranslations()});

/**
 * Define qual a codificação de caracteres utilizado pelo aplicativo.
 */
\$ConfigCore->setAppCharset('{$this->getCharset()}');

/**
 * URL base da aplicação.
 */
\$ConfigCore->setAppBaseUrl('{$this->getBaseUrl()}');

/**
 * Nome do controle inicial da aplicação.
 */
\$ConfigCore->setAppIndex('{$this->getModuleIndex()}');

/**
 * Indicar um ambiente de trabalho ajuda a realizar manutenções nas aplicações, sem
 * o risco de perda de dados.
 *
 * 'production':
 * No ambiente de produção é está os dados reais, e uma
 * ação realizada neste ambiente afetará o que é visto pelo usuário final.
 *
 * 'development':
 * No ambiente de desenvolvimento, os dados existem apenas para testes, permitindo
 * alterações sem o risco de perda de dados ou ações que prejudiquem ou sejam
 * visiveis ao usuário final.
 *
 * "development", "testing", "qa", or "production"
 */
\$ConfigCore->setEnvironment('{$this->getEnvironment()}');

/**
 * Define se o debug está ativado e qual o tipo que será utilizado.
 * Utilize os seguintes códigos para cada tipo de debug.
 * 		0: Desabilitado
 * 		1: Exibir na tela abaixo da aplicação.
 * 		2: Emitir relatórios através do Firebug.
 */
\$ConfigCore->setDebug('{$this->getDebug()}');

/**
 * Define como os relatórios de erros deverão ser armazenados.
 * Utilize os seguintes códigos para cada tipo de relatório.
 * 		0: Armazenar logs no servidor apenas.
 * 		1: Envia-los apenas para os emails de suporte.
 * 		2: Armazenar logs no servidor e tambem enviar-los para os emails de suporte.
 */
\$ConfigCore->setReport('{$this->getReport()}');

/**
 * Pasta onde serão armazenados os logs gerados pela aplicação.
 */
\$ConfigCore->setPathLogs( SYSROOT . 'logs' . DS );

/**
 * Email para enviar os relatórios de erros gerados pela aplicação.
 */
\$ConfigCore->addReportEmail('{$this->getReportEmail()}');

/**
 *
 */
\$ConfigCore->setReportEmailSubject('{$this->getReportEmailSubject()}');

/**
 * Configuração de rota para a área administrativa da aplicação.
 */
\$ConfigCore->setAppAdmin('admin');

/**
 * Define a chave utilizada para criptografia.
 */
\$ConfigCore->setSecuritySalt('CWhG46b0qySfIwfa4qvUoVvpWwvmlR4G0FgaC9mI');

EOFCORE;
?>