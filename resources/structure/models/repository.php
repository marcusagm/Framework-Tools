<?php
echo <<<EOF
<?php
/**
 * Model $tableName.
 *
 * @date $date
 * @sice $version
 */

/**
 * Repositório para o modelo $tableName.
 *
EOF;
foreach ( $fields as $key => $field ) {
	echo "\n * @property mixed {$field['Field']}";
}
echo <<<EOF

 * @package Models
 * @subpakage Repositories
 */
class {$tableName}Repository extends Model
{

EOF;
echo "\tprotected \$_tableName = '" . $this->getTableName( $tableName, true ) . "';\n";
echo "\tprotected \$_schema = array (\n";


// Tratando a estrutura do banco de dados
$totalFields = count($fields);
$hasCreatedDateField = false;
$isCreatedFiledTimestamp = false;
$hasUpdatedDateField = false;
$isUpdatedFiledTimestamp = false;
foreach ( $fields as $key => $field ) {

	if( $field['Field'] == 'created_at' ) {
		$hasCreatedDateField = true;
		if( $field['Type'] == 'timestamp' ) {
			$isCreatedFiledTimestamp = true;
		}
	}

	if( $field['Field'] == 'updated_at' ) {
		$hasUpdatedDateField = true;
		if( $field['Type'] == 'timestamp' ) {
			$isUpdatedFiledTimestamp = true;
		}
	}

	if( stripos( $field['Type'], 'enum') !== false ) {
		$field['Type'] = str_replace( '\'', '"', $field['Type'] );
	}

	echo "\t\t$key => array (\n";
		echo "\t\t\t'Field' => '" . $field['Field'] . "',\n";
		echo "\t\t\t'Type' => '" . $field['Type'] . "',\n";
		echo "\t\t\t'Null' => '" . $field['Null'] . "',\n";
		echo "\t\t\t'Key' => '" . $field['Key'] . "',\n";
		echo "\t\t\t'Default' => " . ( $field['Default'] == null ? 'NULL' : "'" . $field['Default'] . "'" ) . ",\n";
		echo "\t\t\t'Extra' => '" . $field['Extra'] . "'\n";
	echo "\t\t)";

	echo $totalFields -1 > $key ? ",\n" : "\n";
}
echo "\t);\n\n";

echo "\tpublic static function getAllRecords ( \$filter = array(), \$order = null, \$start = null, \$limit = null )\n\t{\n";
	echo "\t\t\$" . $tableName . " = new " . $tableName . "();\n";
	echo "\t\t\$list = $" . $tableName . "->find( \$filter, \$order, \$start, \$limit );\n\n";

	echo "\t\t\$return = array();\n";
	echo "\t\tforeach ( \$list as \$value ) {\n";
		echo "\t\t\t\$return[] = new " . $tableName . "( \$value['id'], \$value );\n";
	echo "\t\t}\n\n";

	echo "\t\treturn \$return;\n";
echo "\t}\n\n";

if( is_array( $foreingKeys ) ) {
	foreach( $foreingKeys as $relation ) {
		$functionName = $this->camelize( $this->removePrefix( $relation['COLUMN_NAME'] ) );
		$objectName = $this->camelize( $this->removePrefix( $relation['REFERENCED_TABLE_NAME'] ) );
		echo "\tpublic function get" . $functionName . "() {\n";
			echo "\t\treturn new " . $objectName . "( \$this->" . $relation['COLUMN_NAME'] . " );\n";
		echo "\t}\n\n";
	}
}

if( is_array( $referencedForeingKeys ) ) {
	foreach( $referencedForeingKeys as $relation ) {
		$functionName = $this->camelize( $this->removePrefix( $relation['TABLE_NAME'] ) );
		$objectName = $this->camelize( $this->removePrefix( $relation['TABLE_NAME'] ) );

		echo "\tpublic function get" . $functionName . "( \$start = null, \$limit = null )\n\t{\n";
			echo "\t\t\$" . $objectName . " = new " . $objectName . "();\n";
			echo "\t\t\$list = \$" . $objectName . "->find( array(\n";
				echo "\t\t\t'" . $relation['COLUMN_NAME'] . " = \"' . \$this->id . '\"'\n";
			echo "\t\t), 'created_at ASC', \$start, \$limit );\n\n";

			echo "\t\t\$return = array();\n";
			echo "\t\tforeach ( \$list as \$value ) {\n";
				echo "\t\t\t\$return[] = new " . $objectName . "( \$value['id'], \$value );\n";
			echo "\t\t}\n\n";

			echo "\t\treturn \$return;\n";
		echo "\t}\n\n";
	}
}

echo "\tprotected function beforeInsert()\n\t{\n";
	if ( $hasCreatedDateField ) {
		echo "\t\t\$this->created_at = date('Y-m-d H:i:s');\n";
	}
	echo "\t\treturn true;\n";
echo "\t}\n\n";

echo "\tprotected function beforeUpdate()\n\t{\n";
	if( $hasUpdatedDateField ) {
		echo "\t\t\$this->updated_at = date('Y-m-d H:i:s');\n";
	}
	echo "\t\treturn true;\n";
echo "\t}\n\n";

echo '}';