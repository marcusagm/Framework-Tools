<div class="form-group">
	<!-- <label class="col-md-4 control-label" for="checkboxes"><?php echo $field['label'] ?></label> -->
	<div class="col-md-8 col-md-offset-4">
		<div class="radio">
			<label for="<?php echo $field['name'] ?>">
				<input type="radio" name="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>" value="1"<?php echo $field['required'] ? ' required' : '' ?><?php echo $value ?><?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
				<?php echo $field['label'] ?>
			</label>
		</div>
	</div>
</div>