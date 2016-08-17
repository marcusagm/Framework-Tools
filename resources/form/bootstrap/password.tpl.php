<div class="form-group">
	<label class="col-md-4 control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
		<input id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" type="password" placeholder="" maxlength="<?php echo $field['maxlength'] ?>" class="form-control input-md"<?php echo $field['required'] ? ' required' : '' ?><?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
		<!-- <span class="help-block"><?php echo $field['label'] ?></span> -->
	</div>
</div>