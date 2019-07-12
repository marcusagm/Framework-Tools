<?php
	$records = $this->getRecords();
	$columns = $this->getColumns();
	$methods = $this->getColumnForModelMethod();
	$buttons = $this->getButtons();
	$buttonsConditionals = $this->getButtonsConditionals();
	$filters = $this->getFilters();
?>


<form action="<?php echo $this->getUrlToSearch() ?>" method="post" class="grid_search">
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
		<input type="text" class="form-control" name="query" id="search_query" placeholder="Digite o que procura..." value="<?php echo $this->getFilters() ?>">
	</div>
	<button class="hidden" type="submit">Buscar</button>
</form>


<form action="<?php echo $this->getUrlToDeleteSelected() ?>" method="post" class="grid_form">

	<?php if( $this->getShowActionAdd() ) { ?>
		<a href="<?php echo $this->getUrlToAdd() ?>" title="" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
	<?php } ?>
	<?php if( $this->getShowActionDeleteSelected() ) { ?>
		<button disabled="disabled" id="grid_button_delete_all" class="btn">
			<i class="fa fa-times"></i> Excluir
		</button>
	<?php } ?>

	<table class="table table-hover table-condensed table-striped grid_view">
		<thead>
			<tr>
				<?php if( $this->getShowActionDeleteSelected() ) { ?>
				<th scope="col" class="grid_column_select">
					<input type="checkbox" name="grid_select_all" id="grid_select_all" title="Selecionar todos" />
				</th>
				<?php } ?>
				<?php foreach ( $columns as $column ) { ?>
					<th scope="col">
						<?php
							if( $column['sortable'] ) {
								echo '<a href="' . $this->getUrlToSortByField($column['field']) . '" title="">';
							}

							echo $column['title'];

							if( $column['sortable'] ) {
								echo '</a>';
							}
						?>
					</th>
				<?php } ?>
				<?php foreach ( $methods as $method ) { ?>
					<th scope="col" class="grid_column_method">
						<?php echo $method['title']; ?>
					</th>
				<?php } ?>
				<?php
					$totalButtons = count( $buttons );
					if( $totalButtons <= 2 ) {
						foreach ( $buttons as $button ) {
							echo '<th scope="col" class="grid_column_button"></th>';
						}
					} elseif( $totalButtons > 2 ) {
						echo '<th scope="col" class="grid_column_button"></th>';
					}
				?>
				<?php foreach ( $buttonsConditionals as $button ) { ?>
					<th scope="col" class="grid_column_button grid_column_button_conditions"></th>
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
					<?php if( $this->getShowActionDeleteSelected() ) { ?>
					<th scope="row" class="grid_column_select"><input type="checkbox" name="grid_selected_records[]" class="grid_checkbox_delete" value="<?php echo $value->id ?>" /></th>
					<?php } ?>
					<?php
						foreach ( $columns as $column ) {
							if( $column['model'] !== null ) {
								if( $value->$column['field'] != null ) {
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
					<?php foreach ( $methods as $method ) { ?>
						<td class="grid_column_method">
							<?php echo $value->$method['method'](); ?>
						</td>
					<?php } ?>
					<?php
						foreach ( $buttonsConditionals as $button ) {
							$buttonValues = $button['conditionalsValues'][$value->$button['field']];
							echo '<td class="grid_column_button grid_column_button_conditions">';
							if( isset( $buttonValues['module'] ) ) {
								echo '<a href="' . UrlMaker::toModuleAction( $buttonValues['module'], $buttonValues['controller'], $buttonValues['action'], array( $buttonValues['field'] => ( $buttonValues['field'] ? $value->$buttonValues['field'] : $value->$button['field'] ) ) ) . '" title="" class="btn btn-default btn-sm' . ( $button['ajaxAction'] ? ' grid-ajax-action' : '' ) . '">' . $buttonValues['text'] . '</a>';
							} else {
								echo '<a href="' . UrlMaker::toAction( $buttonValues['controller'], $buttonValues['action'], array( $buttonValues['field'] => ( $buttonValues['field'] ? $value->$buttonValues['field'] : $value->$button['field'] ) ) ) . '" title="" class="btn btn-default btn-sm' . ( $button['ajaxAction'] ? ' grid-ajax-action' : '' ) . '">' . $buttonValues['text'] . '</a>';
							}
							echo '</td>';
						}
					?>
					<?php
						$totalButtons = count( $buttons );
						if( $totalButtons <= 2 ) {
							foreach ( $buttons as $button ) {
								echo '<td class="grid_column_button">';
								if( $button['module'] ) {
									echo '<a href="' . UrlMaker::toModuleAction( $button['module'], $button['controller'], $button['action'], array( $button['field'] => $value->$button['field'] ) ) . '" title="" class="btn btn-default btn-sm' . ( $button['modal'] ? ' ajax' : '' ) . '">' . $button['text'] . '</a>';
								} else {
									echo '<a href="' . UrlMaker::toAction( $button['controller'], $button['action'], array( $button['field'] => $value->$button['field'] ) ) . '" title="" class="btn btn-default btn-sm' . ( $button['modal'] ? ' ajax' : '' ) . '">' . $button['text'] . '</a>';
								}
								echo '</td>';
							}
						} elseif( $totalButtons > 2 ) {
							echo '<td class="grid_column_button">';
								echo '<div class="btn-group">';
									echo '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Mais <span class="caret"></span></button>';
									echo '<ul class="dropdown-menu pull-right" role="menu">';
									foreach ( $buttons as $button ) {
										if( $button['module'] ) {
											echo '<li><a href="' . UrlMaker::toModuleAction( $button['module'], $button['controller'], $button['action'], array( $button['field'] => $value->$button['field'] ) ) . '" title="" class="' . ( $button['modal'] ? ' ajax' : '' ) . '">' . $button['text'] . '</a></li>';
										} else {
											echo '<li><a href="' . UrlMaker::toAction( $button['controller'], $button['action'], array( $button['field'] => $value->$button['field'] ) ) . '" title="" class="' . ( $button['modal'] ? ' ajax' : '' ) . '">' . $button['text'] . '</a></li>';
										}
									}
									echo '</ul>';
								echo '</div>';
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
			<?php } ?>
		<?php } ?>
		</tbody>
	</table>
</form>
<div class="row-fluid">
	<div class="col-md-8">
		<ul class="pagination">
			<?php
			$page = $this->getPage();
			$limit = $this->getLimit();
			$totalRecords = $this->getTotal();

			$totalPages = $this->getLastPage();
			$max = $this->getMaxLinkPagesNumbers();
			$middle = ceil( $max / 2 );

			$startLink = 1;
			$endLink = $totalPages;
			if ( $totalPages > $max ) {
				if ( $page > ( $totalPages - $middle ) ) {
					$startLink = $totalPages - $max + 1;
				} elseif ( $page > $middle ) {
					$startLink = $page - $middle + 1;
				}

				if ( $page <= ( $totalPages - $middle ) &&  $page > $middle ) {
					$endLink = $page + $middle;
				} elseif ( $page < $max ) {
					$endLink = $max;
				}
			}

			for( $actualPage = $startLink; $actualPage <= $endLink; $actualPage++ ) {
				if( $this->getPage() != $actualPage ) {
			?>
				<li>
					<a href="<?php echo $this->getUrlToList( array( 'page' => $actualPage, 'sortField' => $this->getSortField(), 'sortOrder' => $this->getSortOrder(), 'limit' => $this->getLimit(), 'filter' => $this->getFilters() ) ) ?>" title="">
						<?php
						if ( $page > $middle && $actualPage == $startLink ) {
							echo '<i class="fa fa-ellipsis-h"></i>';
						} elseif ( $totalPages > $max && $page < ( $totalPages - $middle ) && $actualPage == $endLink ) {
							echo '<i class="fa fa-ellipsis-h"></i>';
						} else {
							echo $actualPage;
						}
						?>
					</a>
				</li>
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