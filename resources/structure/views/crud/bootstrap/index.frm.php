<?php
echo <<<EOF
<?php
/**
 * Este aqruivo é para listar os registros do modulo "$module".
 * Listagem utiliza um helper da framework chamada "DataGrid", e utiliza variáveis
 * passadas pelo controller para inicializar a listagem, configurando a paginação e
 * ordenação.
 */
?>

EOF;
?>
<div class="panel panel-primary">
	<div class="panel-heading"><?php echo '<?php echo $this->title ?>' ?></div>
	<div class="panel-body">
<?php echo <<<EOF
		<?php if( \$this->message ) { ?>
			<div class="alert alert-warning fade in">
				<?php echo \$this->message ?>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
		<?php } ?>

		<?php
		\$grid = new DataGrid( '$module' );
		// Caso queira usar outro template para grid indique na linha abaixo
		\$grid->setTemplate( SYSROOT . 'resources/pt_br/grid/grid.tpl.php');
		// Seta a página atual da grid
		\$grid->setPage( \$this->paginationPage );
		// Seta o limite de registro por página
		\$grid->setLimit( \$this->paginationLimit );
		// Passa para o grid os parâmetros que serão exibidos na grid
		\$grid->setRecords( \$this->paginationList );
		// Indica o total de registros
		\$grid->setTotal( \$this->paginationTotal );
		// Seta o campo de ordenação
		\$grid->setSortField( \$this->paginationSortField );
		// Seta se a ordenação é crescente ou decrescente
		\$grid->setSortOrder( \$this->paginationSortOrder );
		// Seta filtro aplicado
		\$grid->setFilters( \$this->gridFilters );

		// Configura quais botões serão exibidos na grid
		\$grid->setShowActionView( true );
		\$grid->setShowActionAdd( true );
		\$grid->setShowActionEdit( true );
		\$grid->setShowActionDelete( true );
		\$grid->setShowActionDeleteSelected( true );

		// Configura os campos que deverão aparecer na listagem.
		// No helper "DataGrid" existem métodos que podem ser usados para adicionar
		// colunas com botões relacionados com o resgitro apresentado. São eles:
		// "addColumnButton" e "addColumnButtonConditional", onde o primeiro adiciona
		// um link para uma action informado o id do registro relacionado, e o
		// segundo possui o mesmo funcionamento do anterior, com a posibilidade de
		// variar o link de acordo com um valor de um atributo.

EOF;
		foreach( $fields as $field => $attributes ) {
			if( $attributes['grid'] ) {
				echo "\t\t";
				echo '$grid->addColumn( ',
					'\'', $field, '\', ',
					'\'', $attributes['label'], '\', ',
					$attributes['db_type'] == 'varchar' || $attributes['db_type'] == 'datetime' ? 'true' : 'false',
					' );';
				echo "\n";
			}
		}
		echo "\n\t\t\$grid->generate();\n";
		echo "\t\t?>";
		?>

	</div>
</div>