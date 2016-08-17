<div class="form-group">
	<!-- <label class="col-md-4 control-label" for="checkboxes"><?php echo $field['label'] ?></label> -->
	<div class="col-sm-offset-4 col-sm-8">
		<div class="checkbox">
			<label for="<?php echo $field['name'] ?>">
				<input type="checkbox" name="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>" value="1"<?php echo $field['required'] ? ' required' : '' ?><?php echo $field['value'] ?><?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
				<?php echo $field['label'] ?>

			</label>
		</div>
	</div>
</div>