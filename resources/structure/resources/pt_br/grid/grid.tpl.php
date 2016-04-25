<?php
	$records = $this->getRecords();
	$columns = $this->getColumns();
	$buttons = $this->getButtons();
	$buttonsConditionals = $this->getButtonsConditionals();
	$filters = $this->getFilters();
?>

<!--
<form action="<?php echo $this->getUrlToSearch() ?>" method="post" class="grid_search">
	<div class="controls input-prepend span12">
		<span class="add-on icon-search"></span>
		<input type="text" class="input-large" name="query" id="search_query" placeholder="Faça uma busca...">
	</div>
	<button class="hidden" type="submit">Buscar</button>
</form>
-->

<form action="<?php echo $this->getUrlToDeleteSelected() ?>" method="post" class="grid_form">

	<?php if( $this->getShowActionAdd() ) { ?>
		<a href="<?php echo $this->getUrlToAdd() ?>" title="" class="btn btn-primary ajax"><i class="fa fa-plus"></i> Adicionar</a>
	<?php } ?>
	<?php if( $this->getShowActionDeleteSelected() ) { ?>
		<button disabled="disabled" id="grid_button_delete_all" class="btn">
			<i class="fa fa-times"></i> Excluir
		</button>
	<?php } ?>

	<table class="table table-hover table-condensed table-striped grid_view">
		<thead>
			<tr>
				<th scope="col" class="grid_column_select">
					<input type="checkbox" name="grid_select_all" id="grid_select_all" title="Selecionar todos" />
				</th>
				<?php foreach ( $columns as $column ) { ?>
					<th scope="col">
						<?php
							if( $column['sortable'] ) {
								echo '<a href="' . $this->getUrlToSortByField($column['field']) . '" title="" />';
							}

							echo $column['title'];

							if( $column['sortable'] ) {
								echo '</a>';
							}
						?>
					</th>
				<?php } ?>
				<?php foreach ( $buttons as $button ) { ?>
					<th scope="col"></th>
				<?php } ?>
				<?php foreach ( $buttonsConditionals as $button ) { ?>
					<th scope="col"></th>
				<?php } ?>
				<th scope="col" class="grid_column_actions">Ações</th>
			</tr>
		</thead>
		<tbody>
		<?php if ( count( $records ) == 0 ) { ?>
			<tr>
				<td colspan="<?php echo count( $columns ) + count( $buttons )  + count( $buttonsConditionals ) + 2 ?>">Não existe registros cadastrados</td>
			</tr>
		<?php } else { ?>
			<?php foreach ( $records as $value ) { ?>
				<tr>
					<th scope="row" class="grid_column_select"><input type="checkbox" name="grid_selected_records[]" class="grid_checkbox_delete" value="<?php echo $value->id ?>" /></td>
					<?php
						foreach ( $columns as $column ) {
							if( $column['model'] !== null ) {
								if( $value[ $column['field'] ] != null ) {
									$modelName = $column['model'];
									$columnModel = new $modelName( $value->$column['field' ] );
									echo '<td>' . $columnModel . '</td>';
								} else {
									echo '<td>-</td>';
								}
							} elseif( count( $column['values'] ) > 0 ) {
								echo '<td>' . $column['values'][ $value->$column['field'] ] . '</td>';
							} else {
								echo '<td>' . $value->$column['field'] . '</td>';
							}
						}
					?>
					<?php
						foreach ( $buttons as $button ) {
							echo '<td>';
							echo '<a href="' . UrlMaker::toAction( $button['controller'], $button['action'], array( $button['field'] => $value->$button['field'] ) ) . '" title="" class="button_common">' . $button['text'] . '</a>';
							echo '</td>';
						}
					?>
					<?php
						foreach ( $buttonsConditionals as $button ) {
							$buttonValues = $button['conditionalsValues'][$value->$button['field']];
							echo '<td>';
							echo '<a href="' . UrlMaker::toAction( $buttonValues['controller'], $buttonValues['action'], array( $buttonValues['field'] => ( $buttonValues['field'] ? $value->$buttonValues['field'] : $value->$button['field'] ) ) ) . '" title="" class="btn' . ( $button['ajaxAction'] ? ' grid-ajax-action' : '' ) . '">' . $buttonValues['text'] . '</a>';
							echo '</td>';
						}
					?>
					<td class="grid_column_actions">
						<div class="btn-group">
							<?php if( $this->getShowActionView() ) { ?>
								<a href="<?php echo $this->getUrlToView( array( 'id' => $value->id ) ) ?>" title="Visualizar" class="btn btn-default btn-sm grid_button_view ajax"><i class="fa fa-eye"></i></a>
							<?php } ?>
							<?php if( $this->getShowActionEdit() ) { ?>
								<a href="<?php echo $this->getUrlToEdit( array( 'id' => $value->id ) ) ?>" title="Editar" class="btn btn-default btn-sm grid_button_edit ajax"><i class="fa fa-edit"></i></a>
							<?php } ?>
							<?php if( $this->getShowActionDelete() ) { ?>
								<a href="<?php echo $this->getUrlToDelete( array( 'id' => $value->id ) ) ?>" title="Excluir" class="btn btn-default btn-sm btn-danger grid_button_delete"><i class="fa fa-times"></i></a>
							<?php } ?>
						</div>
					</td>
				</tr>
			<?php } ?>
		<?php } ?>
		</tbody>
	</table>
</form>
<div class="row-fluid">
	<div class="col-md-8">
		<ul class="pagination">
			<?php
				$totalPages = $this->getLastPage();
				for( $page = 1; $page <= $totalPages; $page++ ) {
					if( $this->getPage() != $page ) {
			?>
					<li><a href="<?php echo $this->getUrlToList( array( 'page' => $page, 'sortField' => $this->getSortField(), 'sortOrder' => $this->getSortOrder(), 'limit' => $this->getLimit(), 'filter' => $this->getFilters() ) ) ?>" title=""><?php echo $page ?></a></li>
				<?php } else { ?>
				<li class="active"><span><?php echo $page ?></span></li>
			<?php } } ?>

		</ul>
	</div>
	<div class="col-md-4">
		<?php
			$page = $this->getPage();
			$limit = $this->getLimit();
			$totalRecords = $this->getTotal();

			$start = $page > 1 ? ( $page - 1 ) * $limit + 1 : 1;
			$start = $start > $totalRecords ? $totalRecords : $start;
			$end =  $page * $limit < $totalRecords ? $page * $limit : $totalRecords;
		?>
		<span class="pagination_stats_text">Mostrando de <?php echo $start . ' a ' . $end ?> de <?php echo $totalRecords ?></span>
	</div>
</div>