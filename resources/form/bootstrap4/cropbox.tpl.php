<div class="form-group row">
    <label class="col-md-4 col-form-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
    <div class="col-md-8">
        <?php echo '<?php if( $this->record && $this->record->' . $field['original_name'] . ' ) { ?>'; ?>

            <div id="<?php echo $field['name'] ?>_view">
                <button id="<?php echo $field['name'] ?>_update" class="btn btn-outline-secondary">
                    <i class="fas fa-upload"></i>
                    Alterar imagem
                </button>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input class="custom-control-input" type="checkbox" name="<?php echo $field['name'] ?>_remove" id="<?php echo $field['name'] ?>_remove" value="1">
                    <label class="custom-control-label" for="<?php echo $field['name'] ?>_remove">Remover imagem</label>
                </div>
                <div class="img-crop-update-preview">
                    <img src="<?php echo "<?php echo \$this->record->getPhotoUrl() ?>" ?>" alt="Imagem" id="<?php echo $field['name'] ?>_image" class="img-thumbnail img-fluid">
                </div>
            </div>
        <?php echo '<?php } else { ?>' ?>

            <input type="file" class="crop-input-file" id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>">
            <label class="invalid-feedback error" for="<?php echo $field['name'] ?>"></label>
        <?php echo '<?php } ?>' ?>
        
    </div>
</div>