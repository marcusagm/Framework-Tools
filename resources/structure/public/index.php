<?php
/**
 * Obtem o separador utilizado para caminhos pelo sistema operacional
 */
$dirsep	= DIRECTORY_SEPARATOR;

/**
 * Constantes do caminho do sistema que utiliza a framework.
 */
define( 'SYSDIR', 'locus' );
define( 'SYSROOT', dirname( __DIR__ ) . $dirsep );

/**
 * Define um timezone padrão.
 */
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR.utf-8', 'Portuguese_Brazil.1252', 'pt_BR.ISO-8859-1', 'pt_BR', 'portuguese', 'ptb', 'br');

/**
 * Chama o arquivo responsável pela inicialização da framework.
 */
require dirname( dirname( __DIR__ ) ) . /*$dirsep . 'framework' .*/ $dirsep . 'framework' . $dirsep . 'bootstrap.php';