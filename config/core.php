<?php

$ConfigCore = ConfigCore::getInstance();

/**
 * Define se o debug está ativado e qual o tipo que será utilizado.
 * Utilize os seguintes códigos para cada tipo de debug.
 * 		0: Desabilitado
 * 		1: Exibir na tela abaixo da aplicação.
 * 		2: Emitir relatórios através do Firebug.
 */
$ConfigCore->setDebug(1);

/**
 * Define como os relatórios de erros deverão ser armazenados.
 * Utilize os seguintes códigos para cada tipo de relatório.
 * 		0: Armazenar logs no servidor apenas.
 * 		1: Envia-los apenas para os emails de suporte.
 * 		2: Armazenar logs no servidor e tambem enviar-los para os emails de suporte.
 */
$ConfigCore->setReport(0);

$ConfigCore->setPathLogs( SYSROOT . 'logs' . DS );
$ConfigCore->setReportEmailSubject( 'Error report' );
$ConfigCore->addReportEmail( 'marcusagmaia@gmail.com' );


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
$ConfigCore->setEnvironment('development');

/**
 * Nome do aplicação.
 */
$ConfigCore->setAppName('Framework Tools');

/**
 * Versão da aplicação.
 */
$ConfigCore->setAppVersion('1.0');

/**
 * Linguagem padrão da aplicação.
 */
$ConfigCore->setAppLanguage('pt-br');

/**
 * Define se a aplicação vai utilizar o sistema de tradução.
 */
$ConfigCore->setUseTranslations(false);

/**
 * Define qual a codificação de caracteres utilizado pelo aplicativo.
 */
$ConfigCore->setAppCharset('utf-8');

/**
 * URL base da aplicação.
 */
$ConfigCore->setAppBaseUrl('http://belvedere/frameworktools/');

/**
 * Nome do controle inicial da aplicação.
 */
$ConfigCore->setAppIndex('index');

/**
 * Configuração de rota para a área administrativa da aplicação.
 */
$ConfigCore->setAppAdmin('admin');

/**
 * Define a chave utilizada para criptografia.
 */
$ConfigCore->setSecuritySalt('CWhG47b0qySfIwfa5qvuovvpWwvmlR4G0FgaC9mI');
