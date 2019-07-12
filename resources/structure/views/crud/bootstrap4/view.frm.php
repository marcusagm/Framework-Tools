<?php
echo <<<EOF
<?php
/**
 * Este aqruivo é para a visualização de registros do modulo "$module".
 * A visualização é gerado com base em um registro informado pelo controller, cujo
 * passa para a view a variável "record".
 */
?>

EOF;
?>
<div class="card">
    <div class="card-header"><?php echo '<?php echo $this->title ?>' ?></div>
    <div class="card-body">
        <table class="table table-striped table-hover" >
            <tbody>
    <?php foreach ( $fields as $field => $attributes ) { ?>
        <?php if( $field != 'id' ) { ?>
            <?php if ( $field == 'created_at' ) { ?>

                <tr>
                    <th scope="row"><?php echo $attributes['label'] ?></th>
                    <td><?php echo '<?php echo date( \'d/m/Y H:i:s\', strtotime( $this->record->' . $field . ' ) ) ?>' ?></td>
                </tr>
            <?php } elseif ( $field == 'updated_at' || $field == 'deleted_at' ) { ?>

                <tr>
                    <th scope="row"><?php echo $attributes['label'] ?></th>
                    <td><?php echo '<?php echo $this->record->' . $field . ' ? date( \'d/m/Y H:i:s\', strtotime( $this->record->' . $field . ' ) ) : \'-\' ?>' ?></td>
                </tr>
            <?php } else { ?>

                <tr>
                    <th scope="row"><?php echo $attributes['label'] ?></th>
                    <td><?php echo '<?php echo $this->record->' . $field . ' ?>' ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>

            </tbody>
        </table>
    </div>

    <div class="card-footer text-right">
        <?php if ($moduleGroup) { ?>

        <a href="<?php echo '<?php echo UrlMaker::toModuleAction( \'' , $moduleGroup , '\', \'' , $module , '\', \'index\' ) ?>' ?>" title="" class="btn btn-outline-secondary">Voltar</a>
        <a href="<?php echo '<?php echo UrlMaker::toModuleAction( \'' , $moduleGroup , '\', \'' , $module , '\', \'edit\', array( \'id\' => $this->record->id ) ) ?>' ?>" title="" class="btn btn-secondary"><i class="fas fa-edit"></i> Editar</a>
        <a href="<?php echo '<?php echo UrlMaker::toModuleAction( \'' , $moduleGroup , '\', \'' , $module , '\', \'delete\', array( \'id\' => $this->record->id ) ) ?>' ?>" title="" class="btn btn-danger"><i class="fas fa-trash"></i> Excluir</a>
        <?php } else { ?>

        <a href="<?php echo '<?php echo UrlMaker::toAction( \'' , $module , '\', \'index\' ) ?>' ?>" title="" class="btn btn-outline-secondary">Voltar</a>
        <a href="<?php echo '<?php echo UrlMaker::toAction( \'' , $module , '\', \'edit\', array( \'id\' => $this->record->id ) ) ?>' ?>" title="" class="btn btn-secondary"><i class="fas fa-edit"></i> Editar</a>
        <a href="<?php echo '<?php echo UrlMaker::toAction( \'' , $module , '\', \'delete\', array( \'id\' => $this->record->id ) ) ?>' ?>" title="" class="btn btn-danger"><i class="fas fa-trash"></i> Excluir</a>
        <?php } ?>
        
    </div>
</div>