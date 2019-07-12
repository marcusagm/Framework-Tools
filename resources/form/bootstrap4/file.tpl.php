<div class="form-group row">
	<label class="col-md-4 col-form-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
        <?php echo '<?php if ($this->record && $this->record->' . $field['original_name'] . ') { ?>' ?>
        
        <p><a href="<?php echo '<?php echo $this->record->get' . $field['camelcase'] . 'Url() ?>' ?>" class="btn btn-outline-secondary btn-block" target="_blank"><i class="fas fa-download"></i> Download</a></p>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input upload-checkbox-new-file" id="<?php echo $field['name'] ?>_new_file">
            <label class="custom-control-label" for="<?php echo $field['name'] ?>_new_file">Substituir arquivo</label>
        </div>
        <?php echo '<?php } ?>' ?>

        <div id="<?php echo $field['name'] ?>_input" class="upload-input-file<?php echo '<?php echo $this->record && $this->record->' . $field['original_name'] . ' ? \' invisible\' : \'\' ?>' ?>">
            <div class="input-group">
                <span class="input-group-prepend">
                    <span class="btn btn-outline-secondary btn-file">
                        Selecionar arquivo
                        <input type="file" id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>_file"<?php echo $field['required'] ? ' required' : '' ?>>
                    </span>
                </span>
                <input type="text" readonly="" class="form-control btn-file-name">
            </div>
            <label class="invalid-feedback error" for="<?php echo $field['name'] ?>"></label>
        </div>
	</div>
</div>