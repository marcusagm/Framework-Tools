<div class="form-group row">
    <label class="col-md-4 col-form-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'] ?><?php echo $field['required'] ? '<abbr title="Campo obrigatório" class="input-required-label">*</abbr>' : '' ?>:</label>
    <div class="col-md-8">
        <select name="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>"  class="custom-select"<?php echo $field['required'] ? ' required' : '' ?><?php /* tabindex="<?php echo $tabindex ?>"*/ ?>>
            <option value="">Selecione</option>
            <?php
            echo '<?php /*
            <?php
            foreach ( $this->allAreas as $Area ) {
                $selected = \'\';
                if ( $this->record && $this->record->area_id == $Area->id ) {
                    $selected = \' selected="selected"\';
                }
                ?>
                <option value="<?php echo $Area->id; ?>" <?php echo $selected ?>><?php echo $Area->name; ?></option>
            <?php } ?>"
            */ ?>';
            ?>

        </select>
        <label class="invalid-feedback error" for="<?php echo $field['name'] ?>"></label>
    </div>
</div>