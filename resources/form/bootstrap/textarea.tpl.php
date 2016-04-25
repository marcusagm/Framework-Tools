<div class="form-group">
	<label class="col-md-4 control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
	<div class="col-md-8">
		<textarea class="form-control" id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>"<?php echo $field['required'] ? ' required' : '' ?> tabindex="<?php echo $tabindex ?>"><?php echo $field['value'] ?></textarea>
	</div>
</div>