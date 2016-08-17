<div class="row">
	<?php if( !$this->isAjax ) { ?>
	<div class="col-md-3">
		<?php $this->addPartial( 'menu', 'projects', array('active' => 'modules', 'record' => $this->record ) ) ?>
	</div>
	<div class="col-md-9">
	<?php } else { ?>
		<div class="col-md-12">
	<?php } ?>
		<?php if( !$this->isAjax ) { ?>
			<ol class="breadcrumb">
				<li><a href="<?php echo UrlMaker::toAction( 'module', 'index', array( 'id' => $this->record->getId() ) ) ?>">Module</a></li>
				<li class="active"><?php echo $this->modelName ?></li>
			</ol>
		<?php } ?>
		<form class="form-horizontal" method="post" action="<?php echo UrlMaker::toAction( 'modules', 'save' ) ?>">
			<div class="panel panel-primary">
				<div class="panel-heading">Model</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label" for="template">Select the template</label>
						<div class="col-md-9">
							<select id="template" name="template" class="form-control">
								<option value="bootstrap">Bootstrap</option>
							</select>
						</div>
					</div>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Field</th>
								<th>Label</th>
								<th>Input type</th>
								<th>Data provider<sup title="Select the data provider for select or treeview">1</sup></th>
								<th><abbr title="Field required">Req</abbr></th>
								<th><abbr title="Display this field in the list">Grid</abbr></th>
								<th><abbr title="Sort the list by this field">Sort</abbr></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach( $this->model['fields'] as $field ) { ?>
								<tr>
									<td><?php echo $field['Field'] ?></td>
									<td><input type="text" name="input_label[<?php echo $field['Field'] ?>]" value="<?php $value = new String( $field['Field'] ); $value->humanize(); echo $value; ?>" class="form-control"></td>
									<td>
										<select name="input_type[<?php echo $field['Field'] ?>]" class="form-control">
											<option value="">None</option>
											<option value="text"<?php echo stripos( $field['Type'], 'char' ) !== false|| stripos( $field['Type'], 'float' ) !== false  ? ' selected' : ''?>>Text</option>
											<option value="password"<?php echo stripos( $field['Field'], 'password' ) !== false ? ' selected' : ''?>>Password</option>
											<option value="textarea"<?php echo stripos( $field['Type'], 'text' ) !== false ? ' selected' : ''?>>Textarea</option>
											<option value="editor">Editor</option>
											<option value="hidden"<?php echo $field['Field'] == 'id' ? ' selected' : ''?>>Hidden</option>
											<option value="select"<?php echo stripos( $field['Type'], '_id' ) !== false ? ' selected' : ''?>>Select</option>
											<option value="checkbox"<?php echo stripos( $field['Type'], 'tinyint' ) !== false ? ' selected' : ''?>>Checkbox</option>
											<option value="radio">Radio</option>
											<option value="file">File</option>
											<option value="cropbox">Cropbox</option>
											<option value="email"<?php echo stripos( $field['Field'], 'email' ) !== false ? ' selected' : ''?>>Email</option>
											<option value="number"<?php echo stripos( $field['Type'], 'int(' ) !== false && $field['Field'] != 'id' ? ' selected' : ''?>>Number</option>
											<option value="money"<?php echo stripos( $field['Type'], 'decimal(' ) !== false && $field['Field'] != 'id' ? ' selected' : ''?>>Money</option>
											<option value="url"<?php echo stripos( $field['Type'], 'site' ) !== false ? ' selected' : ''?>>URL</option>
											<option value="tel"<?php echo stripos( $field['Type'], 'phone' ) !== false ? ' selected' : ''?>>Tel</option>
											<option value="date"<?php echo stripos( $field['Type'], 'date' ) !== false ? ' selected' : ''?>>Date</option>
											<option value="time"<?php echo stripos( $field['Type'], 'time' ) !== false ? ' selected' : ''?>>Time</option>
											<option value="datetime"<?php echo stripos( $field['Type'], 'datetime' ) !== false || stripos( $field['Type'], 'timestamp' ) !== false ? ' selected' : ''?>>Datetime</option>
											<option value="range">Range</option>
										</select>
									</td>
									<td>
										<select name="input_data[<?php echo $field['Field'] ?>]" class="form-control">
											<option value="">None</option>
											<option value="foreign_1n">Foreign key (1..n)</option>
											<option value="foreign_nn">Foreign key (n..n)</option>
											<option value="activestatus">Aticve status</option>
											<option value="publishstatus">Publish status</option>
											<option value="acceptstatus">Accept status</option>
											<option value="gender">Gender</option>
											<option value="visibility">Visibility</option>
											<option value="period">Period</option>
										</select>
									</td>
									<td><input name="input_required[<?php echo $field['Field'] ?>]" value="1" type="checkbox"<?php echo $field['Null'] == 'NO' && $field['Field'] != 'id' ? ' checked' : '' ?>></td>
									<td><input name="input_grid[<?php echo $field['Field'] ?>]" value="1" type="checkbox"<?php //echo $field['Field'] != 'id' ? ' checked' : '' ?>></td>
									<td><input name="input_sort" type="radio" value="<?php echo $field['Field'] ?>"></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<div class="panel-footer text-right">
					<button type="submit" class="btn btn-success"><span class="ftools-ok"></span> Generate</button>
					<input type="hidden" value="<?php echo $this->projectId ?>" name="project_id" id="project_id" />
					<input type="hidden" value="<?php echo $this->modelName ?>" name="model_name" id="model_name" />
				</div>
			</div>
		</form>
	</div>
</div>