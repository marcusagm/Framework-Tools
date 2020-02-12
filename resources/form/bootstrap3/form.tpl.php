<form action="<?php echo $action ?>" method="<?php echo $method ?>"<?php $this->enctype ? ' enctype="' . $this->enctype . '"' : '' ?> name="<?php echo $name ?>" id="<?php echo $name ?>" class="form-horizontal" enctype="multipart/form-data">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo '<?php echo $this->title ?>' ?></div>
		<div class="panel-body">

			<?php echo $content ?>

		</div>

		<div class="panel-footer text-right">
			<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Salvar</button>
		</div>
	</div>
</form>
