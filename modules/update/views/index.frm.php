<div class="row">
	<div class="col-md-3">
		<a href="" title="" class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus"></span> Create a new project</a>
		<hr>
		<div class="list-group">
			<a href="#" class="list-group-item">Cras justo odio</a>
			<a href="#" class="list-group-item">Dapibus ac facilisis in</a>
			<a href="#" class="list-group-item">Morbi leo risus</a>
			<a href="#" class="list-group-item">Porta ac consectetur ac</a>
			<a href="#" class="list-group-item">Vestibulum at eros</a>
		</div>
	</div>
	<div class="col-md-9">
		<form class="form-horizontal">
			<?php if( $this->message ) { ?>
				<div class="alert alert-warning"><?php echo $this->message ?></div>
			<?php } ?>
			<div class="panel panel-primary">
				<div class="panel-heading">Create a new project</div>
				<div class="panel-body">

				</div>
				<div class="panel-footer text-right">
					<button class="btn btn-danger" disabled><span class="glyphicon glyphicon-remove"></span> Delete</button>
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Create</button>
				</div>
			</div>
		</form>
	</div>
</div>