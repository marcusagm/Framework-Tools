<?php
/**
 * Obtem o separador utilizado para caminhos pelo sistema operacional
 */
$dirsep	= DIRECTORY_SEPARATOR;

/**
 * Constantes do caminho do sistema que utiliza a framework.
 */
define( 'SYSDIR', 'frameworktools' );
define( 'SYSROOT', dirname( __DIR__ ) . $dirsep );

define( 'PROJECT_FILES_PATH', SYSROOT . 'projects' . $dirsep );

/**
 * Define um timezone padrão.
 */
date_default_timezone_set('America/Sao_Paulo');

/**
 * Chama o arquivo responsável pela inicialização da framework.
 */
require dirname( dirname( __DIR__ ) ) . /*$dirsep . 'framework' .*/ $dirsep . 'framework' . $dirsep . 'bootstrap.php';