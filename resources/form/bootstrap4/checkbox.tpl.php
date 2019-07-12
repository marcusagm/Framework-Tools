<div class="form-group row">
	<div class="col-md-8 offset-md-4">
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" name="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>" value="1"<?php echo $field['value'] ?>>
			<label class="custom-control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?></label>
			<label class="invalid-feedback error" for="<?php echo $field['name'] ?>"></label>
		</div>
	</div>
</div>