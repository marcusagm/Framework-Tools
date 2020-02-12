<form action="<?php echo $action ?>" method="<?php echo $method ?>"<?php $this->enctype ? ' enctype="' . $this->enctype . '"' : '' ?> name="<?php echo $name ?>" id="<?php echo $name ?>" class="form-horizontal" enctype="multipart/form-data">
	<div class="card">
		<div class="card-header"><?php echo '<?php echo $this->title ?>' ?></div>
		<div class="card-body">

			<?php echo $content ?>

		</div>

		<div class="card-footer text-right">
			<a href="<?php echo $backLink ?>" class="btn btn-outline-secondary">Cancelar</a>
			<button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Salvar</button>
		</div>
	</div>
</form>
