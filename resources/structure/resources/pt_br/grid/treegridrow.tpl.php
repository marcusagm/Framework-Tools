<?php
//$records = $this->getRecords();
$columns = $this->getColumns();
$buttons = $this->getButtons();
$methods = $this->getColumnForModelMethod();
$buttonsConditionals = $this->getButtonsConditionals();
$filters = $this->getFilters();
foreach ( $records as $record ) {
	$value = $record['record'];
?>
	<tr class="treegrid-<?php echo $value->id ?><?php echo $value->parent_id ? ' treegrid-parent-' . $value->parent_id : '' ?>">
		<?php if( $this->getShowActionDeleteSelected() ) { ?>
		<th scope="row" class="grid_column_select"><input type="checkbox" name="grid_selected_records[]" class="grid_checkbox_delete" value="<?php echo $value->id ?>" /></th>
		<?php } ?>
		<?php
			foreach ( $columns as $column ) {
				if( $column['model'] !== null ) {
					if( $value->{$column['field']} != null ) {
						$modelName = $column['model'];
						$columnModel = new $modelName( $value->$column['field' ] );
						echo '<td>' . $columnModel . '</td>';
					} else {
						echo '<td>-</td>';
					}
				} elseif( count( $column['values'] ) > 0 ) {
					echo '<td>' . $column['values'][ $value->{$column['field']} ] . '</td>';
				} else {
					echo '<td>' . $value->{$column['field']} . '</td>';
				}
			}
		?>
		<?php foreach ( $methods as $method ) { ?>
			<td class="grid_column_method">
				<?php echo $value->{$method['method']}(); ?>
			</td>
		<?php } ?>
		<?php
			foreach ( $buttons as $button ) {
				echo '<td class="grid_column_button">';
				if( $button['module'] ) {
					echo '<a href="' . UrlMaker::toModuleAction( $button['module'], $button['controller'], $button['action'], array( $button['field'] => $value->{$button['field']} ) ) . '" title="" class="btn btn-default btn-sm">' . $button['text'] . '</a>';
				} else {
					echo '<a href="' . UrlMaker::toAction( $button['controller'], $button['action'], array( $button['field'] => $value->{$button['field']} ) ) . '" title="" class="btn btn-default btn-sm">' . $button['text'] . '</a>';
				}
				echo '</td>';
			}
		?>
		<?php
			foreach ( $buttonsConditionals as $button ) {
				$buttonValues = $button['conditionalsValues'][$value->{$button['field']}];
				echo '<td class="grid_column_button grid_column_button_conditions">';
				if( $buttonValues['module'] ) {
					echo '<a href="' . UrlMaker::toModuleAction( $buttonValues['module'], $buttonValues['controller'], $buttonValues['action'], array( $buttonValues['field'] => ( $buttonValues['field'] ? $value->$buttonValues['field'] : $value->{$button['field']} ) ) ) . '" title="" class="btn btn-default btn-sm' . ( $button['ajaxAction'] ? ' grid-ajax-action' : '' ) . '">' . $buttonValues['text'] . '</a>';
				} else {
					echo '<a href="' . UrlMaker::toAction( $buttonValues['controller'], $buttonValues['action'], array( $buttonValues['field'] => ( $buttonValues['field'] ? $value->$buttonValues['field'] : $value->{$button['field']} ) ) ) . '" title="" class="btn btn-default btn-sm' . ( $button['ajaxAction'] ? ' grid-ajax-action' : '' ) . '">' . $buttonValues['text'] . '</a>';
				}
				echo '</td>';
			}
		?>
		<td class="grid_column_actions">
			<div class="btn-group">
				<?php if( $this->getShowActionView() ) { ?>
					<a href="<?php echo $this->getUrlToView( array( 'id' => $value->id ) ) ?>" title="Visualizar" class="btn btn-default btn-sm grid_button_view"><i class="fa fa-eye"></i></a>
				<?php } ?>
				<?php if( $this->getShowActionEdit() ) { ?>
					<a href="<?php echo $this->getUrlToEdit( array( 'id' => $value->id ) ) ?>" title="Editar" class="btn btn-default btn-sm grid_button_edit"><i class="fa fa-edit"></i></a>
				<?php } ?>
				<?php if( $this->getShowActionDelete() ) { ?>
					<a href="<?php echo $this->getUrlToDelete( array( 'id' => $value->id ) ) ?>" title="Excluir" class="btn btn-default btn-sm btn-danger grid_button_delete"><i class="fa fa-times"></i></a>
				<?php } ?>
			</div>
		</td>
	</tr>
<?php
	$this->makeTreeGrid( $record['children'] );
}
?>