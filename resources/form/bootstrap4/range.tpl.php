<div class="form-group row">
	<label class="col-md-4 col-form-label"" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
		<input id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" type="range" min="0" max="100" placeholder="" class="custom-range"<?php echo $field['required'] ? ' required' : '' ?> value="<?php echo $field['value'] ?>"<?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
		<label class="invalid-feedback error" for="<?php echo $field['name'] ?>"></label>
	</div>
</div>