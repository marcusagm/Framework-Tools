<?php $this->layout->addViewJs( 'table.js' ); ?>
<?php $this->layout->addViewJs( 'logs.js' ); ?>
<div class="row">
	<div class="col-md-3">
		<?php $this->addPartial( 'menu', 'projects', array('active' => 'logs', 'record' => $this->record ) ) ?>
	</div>
	<div class="col-md-9">
		<h1><span class="ftools-docs"></span> Logs</h1>
		<?php if( $this->message ) { ?>
			<div class="alert alert-warning">
				<?php echo $this->message ?>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
		<?php } ?>

		<form class="form-horizontal" method="post" action="<?php echo UrlMaker::toAction( 'logs', 'deleteSelected' ) ?>">
			<div class="panel panel-primary">
				<div class="panel-heading">All logs</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" id="models-list">
						<thead>
							<tr>
								<th class="table-column-select"><input type="checkbox" name="select_all" id="select_all" value="1"></th>
								<th>Data</th>
								<th>Hora</th>
								<th>Type</th>
								<th class="table-column-minimum">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ( $this->logs as $value ) { ?>
									<tr>
										<td class="table-column-select"><input type="checkbox" name="logs[]" value="<?php echo $value['file'] ?>"></td>
										<td><?php echo $value['date'] ?></td>
										<td><?php echo $value['time'] ?></td>
										<td><?php echo $value['type'] ?></td>
										<td class="table-column-minimum">
											<a href="<?php echo UrlMaker::toAction( 'logs', 'view', array( 'id' => $this->record->getId(), 'table' => $value['file'] ) )?>" title="View detais" class="ajax btn btn-xs btn-default"><i class="ftools-eye"></i> View</a>
											<a href="<?php echo UrlMaker::toAction( 'logs', 'delete', array( 'id' => $this->record->getId(), 'table' => $value['file'] ) )?>" title="View detais" class="btn btn-xs btn-danger"><i class="ftools-remove"></i> Delete</a>
										</td>
									</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer text-right">
					<input type="hidden" value="<?php echo $this->record->getId() ?>" name="project_id" id="project_id" />
					<button class="btn btn-danger log-delete-button"><span class="ftools-remove"></span> Delete all</button>
				</div>
			</div>
		</form>
	</div>
</div>