<div class="form-group">
	<label class="col-md-4 control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
        <?php echo '<?php if ($this->record && $this->record->' . $field['original_name'] . ') { ?>' ?>
        <p><a href="<?php echo '<?php echo $this->record->getFileUrl() ?>' ?>" class="btn btn-default btn-block" target="_blank">Download</a></p>
        <label for="<?php echo $field['name'] ?>_new_file">
            <input type="checkbox" id="<?php echo $field['name'] ?>_new_file" value="1">
            Substituir arquivo
        </label>
        <?php echo '<?php } ?>' ?>
        <div id="<?php echo $field['name'] ?>_input" class="<?php echo '<?php echo $this->record && $this->record->' . $field['original_name'] . ' ? \' hidden\' : \'\' ?> ' ?>">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-default btn-file">
                        Selecionar arquivo
                        <input id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" type="file"<?php echo $field['required'] ? ' required' : '' ?><?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
                    </span>
                </span>
                <input type="text" readonly="" class="form-control btn-file-name">
            </div>
            <label for="<?php echo $field['name'] ?>" class="error"></label>
        </div>
	</div>
</div>