<div class="row">
    <?php if( !$this->isAjax ) { ?>
    <div class="col-md-3">
        <?php $this->addPartial( 'menu', 'projects', array('active' => 'models', 'record' => $this->record ) ) ?>
    </div>
    <div class="col-md-9">
    <?php } else { ?>
        <div class="col-md-12">
    <?php } ?>
        <?php if( !$this->isAjax ) { ?>
            <ol class="breadcrumb">
                <li><a href="<?php echo UrlMaker::toAction( 'models', 'index', array( 'id' => $this->record->getId() ) ) ?>">Models</a></li>
                <li class="active"><?php echo $this->tableName ?></li>
            </ol>
        <?php } ?>
        <div class="row">
            <div class="col-xs-6">
                <?php if ( $this->model ) { ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">Model - <?php echo $this->modelName ?></div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Type</th>
                                        <th>Is Null</th>
                                        <th>Key</th>
                                        <th>Default</th>
                                        <th>Extra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php // var_dump($this->model); ?>
                                    <?php foreach( $this->model['fields'] as $field ) { ?>
                                        <tr>
                                            <td><?php echo $field['Field'] ?></td>
                                            <td><?php echo $field['Type'] ?></td>
                                            <td><?php echo $field['Null'] ?></td>
                                            <td><?php echo $field['Key'] ?></td>
                                            <td><?php echo $field['Default'] ?></td>
                                            <td><?php echo $field['Extra'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning">This model was not generated</div>
                <?php } ?>
            </div>
            <div class="col-xs-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Table - <?php echo $this->tableName ?></div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Is Null</th>
                                    <th>Key</th>
                                    <th>Default</th>
                                    <th>Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php // var_dump($this->table); ?>
                                <?php foreach( $this->table as $field ) { ?>
                                    <tr>
                                        <td><?php echo $field['Field'] ?></td>
                                        <td><?php echo $field['Type'] ?></td>
                                        <td><?php echo $field['Null'] ?></td>
                                        <td><?php echo $field['Key'] ?></td>
                                        <td><?php echo $field['Default'] ?></td>
                                        <td><?php echo $field['Extra'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>