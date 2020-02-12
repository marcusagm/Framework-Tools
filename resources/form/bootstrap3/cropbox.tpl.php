<div class="form-group">
    <label class="col-md-4 control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
    <div class="col-md-8">
        <?php echo '<?php if( $this->record && $this->record->' . $field['original_name'] . ' ) { ?>'; ?>

            <div id="<?php echo $field['name'] ?>_view">
                <button id="<?php echo $field['name'] ?>_update" class="btn btn-default">
                    <i class="fas fa-upload"></i>
                    Alterar imagem
                </button>
                <div class="checkbox">
                    <label for="<?php echo $field['name'] ?>_remove">
                        <input class="custom-control-input" type="checkbox" name="<?php echo $field['name'] ?>_remove" id="<?php echo $field['name'] ?>_remove" value="1">
                        Remover imagem
                    </label>
                </div>
                <div class="img-crop-update-preview">
                    <img src="<?php echo "<?php echo \$this->record->getPhotoUrl() ?>" ?>" alt="Imagem" id="<?php echo $field['name'] ?>_image" class="img-thumbnail img-fluid">
                </div>
            </div>
        <?php echo '<?php } else { ?>' ?>

            <input type="file" class="crop-input-file" id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" accept="image/gif, image/jpeg, image/png">
            <label for="<?php echo $field['name'] ?>" class="error"></label>
        <?php echo '<?php } ?>' ?>

    </div>
</div>
