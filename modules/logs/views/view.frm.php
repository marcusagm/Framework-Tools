<div class="row">
	<?php if( !$this->isAjax ) { ?>
		<div class="col-md-3">
			<?php $this->addPartial( 'menu', 'projects', array('active' => 'logs', 'record' => $this->record ) ) ?>
		</div>
		<div class="col-md-9">
	<?php } else { ?>
		<div class="col-md-12">
	<?php } ?>
		<?php if( !$this->isAjax ) { ?>
			<ol class="breadcrumb">
				<li><a href="<?php echo UrlMaker::toAction( 'logs', 'index', array( 'id' => $this->record->getId() ) ) ?>">Logs</a></li>
				<li class="active"><?php echo $this->log ?></li>
			</ol>
		<?php } ?>
		<div class="panel panel-primary">
			<div class="panel-heading">Log - <?php echo $this->log ?></div>
			<div class="panel-body">
				<pre><?php echo $this->logContent ?></pre>
			</div>
		</div>
	</div>
</div>