<div class="form-group row">
	<label class="col-md-4 col-form-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
		<textarea class="form-control" id="<?php echo $field['name'] ?>" rows="5" name="<?php echo $field['name'] ?>"<?php echo $field['required'] ? ' required' : '' ?><?php /* tabindex="<?php echo $tabindex ?>"*/ ?>><?php echo $field['value'] ?></textarea>
		<label class="invalid-feedback error" for="<?php echo $field['name'] ?>"></label>
	</div>
</div>