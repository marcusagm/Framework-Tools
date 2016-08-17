<div class="form-group">
	<label class="col-md-4 control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
        <div id="<?php echo $field['name'] ?>_input">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-default btn-file">
                        Selecionar arquivo
                        <input id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" type="file" accept="image/gif, image/jpeg, image/png"<?php echo $field['required'] ? ' required' : '' ?><?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
                    </span>
                </span>
                <input type="text" readonly="" class="form-control btn-file-name">
            </div>
            <label for="<?php echo $field['name'] ?>" class="error"></label>
        </div>
	</div>
</div>