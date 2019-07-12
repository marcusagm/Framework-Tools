<?php
	$records = $this->getRecords();
	$columns = $this->getColumns();
	$buttons = $this->getButtons();
	$buttonsConditionals = $this->getButtonsConditionals();
	$methods = $this->getColumnForModelMethod();
	$filters = $this->getFilters();
?>
<?php /*
<form action="<?php echo $this->getUrlToSearch() ?>" method="post" class="grid_search">
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
		<input type="text" class="form-control" name="query" id="search_query" placeholder="Digite o que procura..." value="<?php echo $this->getFilters() ?>">
	</div>
	<button class="hidden" type="submit">Buscar</button>
</form>
 */
?>

<form action="<?php echo $this->getUrlToDeleteSelected() ?>" method="post" class="treegrid_form">

	<?php if( $this->getShowActionAdd() ) { ?>
		<a href="<?php echo $this->getUrlToAdd() ?>" title="" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</a>
	<?php } ?>
	<?php if( $this->getShowActionDeleteSelected() ) { ?>
		<button disabled="disabled" id="grid_button_delete_all" class="btn">
			<i class="fa fa-times"></i> Excluir
		</button>
	<?php } ?>

	<table class="table table-hover table-condensed table-striped treegrid_view">
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
							//if( $column['sortable'] ) {
							//	echo '<a href="' . $this->getUrlToSortByField($column['field']) . '" title="" />';
							//}

							echo $column['title'];

							//if( $column['sortable'] ) {
							//	echo '</a>';
							//}
						?>
					</th>
				<?php } ?>
				<?php foreach ( $methods as $method ) { ?>
					<th scope="col" class="grid_column_method">
						<?php echo $method['title']; ?>
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
		<?php
		} else {
			$this->makeTreeGrid( $records );
		}
		?>
		</tbody>
	</table>
</form>
<?php
/*
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
 */
?>