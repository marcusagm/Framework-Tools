<div class="form-group row">
    <label class="col-md-4 col-form-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-prepend">R$</div>
            <input id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" type="text" maxlength="15" placeholder="" class="form-control input-md"<?php echo $field['required'] ? ' required' : '' ?> value="<?php echo $field['value'] ?>"<?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
        </div>
        <label class="invalid-feedback error" for="<?php echo $field['name'] ?>"></label>
    </div>
</div>