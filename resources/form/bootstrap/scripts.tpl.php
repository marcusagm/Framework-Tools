$(document).ready(
	function() {
		$('#<?php echo $name ?>').validate({
			rules: {<?php
					$count = count($validators);
					if( $count > 0 ) {
						foreach ( $validators as $field => $attributes ) {
							$countAttributes = count( $attributes );
							echo "\n\t\t\t\t";
							echo '\'' . $field . '\' : { ';
							if( $attributes['required'] ) {
								echo '\'required\': true';
								$countAttributes--;
								echo $countAttributes > 0 ? ', ' : '';
							}
							if( $attributes['email'] ) {
								echo '\'email\': true';
								$countAttributes--;
								echo $countAttributes > 0  ? ', ' : '';
							}
							if( $attributes['number'] ) {
								echo '\'number\': true';
								$countAttributes--;
								echo $countAttributes > 0  ? ', ' : '';
							}
							if( $attributes['url'] ) {
								echo '\'url\': true';
								$countAttributes--;
								echo $countAttributes > 0  ? ', ' : '';
							}
							if( isset( $attributes['maxlength'] ) && $attributes['maxlength'] !== false ) {
								echo '\'maxlength\': ' . $attributes['maxlength'];
								$countAttributes--;
								echo $countAttributes > 0  ? ', ' : '';
							}
							$count--;
							echo ' }' . ( $count > 0 ? ',' : '' );
						}
					}
				?>

			}
		});
});