<div class="form-group">
	<label class="col-md-4 control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
        <input id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" type="text" maxlength="15" placeholder="" class="form-control input-md"<?php echo $field['required'] ? ' required' : '' ?> value="<?php echo $field['value'] ?>"<?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
		<!-- <span class="help-block"><?php echo $field['label'] ?></span> -->
	</div>
</div>
