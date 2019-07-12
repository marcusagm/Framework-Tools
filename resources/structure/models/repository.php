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
echo "    protected \$_tableName = '" . $this->getTableName( $tableName, true ) . "';\n";
echo "    protected \$_schema = array (\n";


// Tratando a estrutura do banco de dados
$totalFields = count($fields);
$hasCreatedDateField = false;
$isCreatedFiledTimestamp = false;
$hasUpdatedDateField = false;
$isUpdatedFiledTimestamp = false;
$hasDeletedDateField = false;
$isDeletedFiledTimestamp = false;

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

	if( $field['Field'] == 'deleted_at' ) {
		$hasDeletedDateField = true;
		if( $field['Type'] == 'timestamp' ) {
			$isDeletedFiledTimestamp = true;
		}
	}

	if( stripos( $field['Type'], 'enum') !== false ) {
		$field['Type'] = str_replace( '\'', '"', $field['Type'] );
	}

	echo "        $key => array (\n";
		echo "            'Field' => '" . $field['Field'] . "',\n";
		echo "            'Type' => '" . $field['Type'] . "',\n";
		echo "            'Null' => '" . $field['Null'] . "',\n";
		echo "            'Key' => '" . $field['Key'] . "',\n";
		echo "            'Default' => " . ( $field['Default'] == null ? 'NULL' : "'" . $field['Default'] . "'" ) . ",\n";
		echo "            'Extra' => '" . $field['Extra'] . "'\n";
	echo "        )";

	echo $totalFields -1 > $key ? ",\n" : "\n";
}
echo "    );\n\n";

echo "    public static function getAllRecords ( \$filter = array(), \$order = null, \$start = null, \$limit = null )\n    {\n";
	echo "        \$" . $tableName . " = new " . $tableName . "();\n";
	echo "        \$list = $" . $tableName . "->find( \$filter, \$order, \$start, \$limit );\n\n";

	echo "        \$return = array();\n";
	echo "        foreach ( \$list as \$value ) {\n";
		echo "            \$return[] = new " . $tableName . "( \$value['id'], \$value );\n";
	echo "        }\n\n";

	echo "        return \$return;\n";
echo "    }\n\n";

if( is_array( $foreingKeys ) ) {
	foreach( $foreingKeys as $relation ) {
		$functionName = $this->camelize( $this->removePrefix( $relation['COLUMN_NAME'] ) );
		$objectName = $this->camelize( $this->removePrefix( $relation['REFERENCED_TABLE_NAME'] ) );
		echo "    public function get" . $functionName . "()\n    {\n";
			echo "        return new " . $objectName . "( \$this->" . $relation['COLUMN_NAME'] . " );\n";
		echo "    }\n\n";
	}
}

if( is_array( $referencedForeingKeys ) ) {
	foreach( $referencedForeingKeys as $relation ) {
		$functionName = $this->camelize( $this->removePrefix( $relation['TABLE_NAME'] ) );
		$objectName = $this->camelize( $this->removePrefix( $relation['TABLE_NAME'] ) );

		echo "    public function get" . $functionName . "( \$start = null, \$limit = null )\n    {\n";
			echo "        \$" . $objectName . " = new " . $objectName . "();\n";
			echo "        \$list = \$" . $objectName . "->find( array(\n";
				echo "            '" . $relation['COLUMN_NAME'] . " = \"' . \$this->id . '\"'\n";
			echo "        ), 'created_at ASC', \$start, \$limit );\n\n";

			echo "        \$return = array();\n";
			echo "        foreach ( \$list as \$value ) {\n";
				echo "            \$return[] = new " . $objectName . "( \$value['id'], \$value );\n";
			echo "        }\n\n";

			echo "        return \$return;\n";
		echo "    }\n\n";
	}
}

echo "    protected function beforeInsert()\n    {\n";
	if ( $hasCreatedDateField ) {
		echo "        \$this->created_at = date('Y-m-d H:i:s');\n";
	}
	echo "        return true;\n";
echo "    }\n\n";

echo "    protected function beforeUpdate()\n    {\n";
	if( $hasUpdatedDateField ) {
		echo "        \$this->updated_at = date('Y-m-d H:i:s');\n";
	}
	echo "        return true;\n";
echo "    }\n\n";

if( $hasDeletedDateField ) {
	echo "    public function delete()\n    {\n";
		echo "        \$this->beforeDelete();\n";
		echo "        \$this->deleted_at = date('Y-m-d H:i:s');\n";
 		echo "        \$this->save();\n";
		echo "        \$this->afterDelete();\n";
		echo "        return true;\n";
	echo "    }\n\n";
}

echo '}';