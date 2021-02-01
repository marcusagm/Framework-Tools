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

if ($moduleGroup) {
    echo '<?php $this->layout->addViewJs( \'' . $moduleGroup . '/' . $module . '_form.js\' ); ?>' . "\n";
} else {
    echo '<?php $this->layout->addViewJs( \'' . $module . '_form.js\' ); ?>' . "\n";
}
?>
<ol class="breadcrumb">
    <?php if ($moduleGroup) { ?>
        <li class="breadcrumb-item"><a href="<?php echo '<?php echo UrlMaker::toModuleAction( \'' , $moduleGroup , '\', \'' , $module , '\', \'index\' ) ?>' ?>"><?php echo '<?php echo $this->title ?>' ?></a></li>
    <?php } else { ?>
        <li class="breadcrumb-item"><a href="<?php echo '<?php echo UrlMaker::toAction( \'' , $module , '\', \'index\' ) ?>' ?>"><?php echo '<?php echo $this->title ?>' ?></a></li>
    <?php } ?>
    <li class="breadcrumb-item active"><?php echo '<?php echo $this->record ? \'Editar\' : \'Adicionar\' ?>' ?></li>
</ol>
<?php
echo $formContent;

