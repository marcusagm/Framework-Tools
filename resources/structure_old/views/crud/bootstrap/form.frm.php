<?php
echo <<<EOF
<?php
/**
 * Este aqruivo é o formulário para adicionar e editar os registros do modulo "$module".
 * O controller informa a variável "record" que caso ela não esteja nula, o formulário
 * é montado no modo de edição.
 */
?>

EOF;
?>
<?php echo '<?php $this->layout->addViewJs( \'' . $module . '_form.js\' ); ?>'; ?>

<?php echo $formContent ?>

