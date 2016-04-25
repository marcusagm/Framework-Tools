<div class="row">
	<div class="col-md-3">
		<?php $this->addPartial( 'menu', 'projects', array('active' => 'services', 'record' => $this->record ) ) ?>
	</div>
	<div class="col-md-9">
		<h1><span class="ftools-briefcase"></span> Services</h1>
		<?php if( $this->message ) { ?>
			<div class="alert alert-warning"><?php echo $this->message ?></div>
		<?php } ?>
		<form class="form-horizontal">
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