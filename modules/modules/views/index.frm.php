<div class="row">
    <div class="col-md-3">
        <?php $this->addPartial( 'menu', 'projects', array('active' => 'modules', 'record' => $this->record ) ) ?>
    </div>
    <div class="col-md-9">
        <h1><span class="ftools-popup"></span> Modules</h1>
        <?php if( $this->message ) { ?>
            <div class="alert alert-warning">
                <?php echo $this->message ?>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php if( $this->record ) { ?>
                    Editing modules for: <?php echo $this->record->getName() ?>
                <?php } else { ?>
                    Modules
                <?php } ?>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="modules-list">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th class="table-column-minimum">Generated</th>
                            <th class="table-column-minimum">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $listTables = $this->projectModules->getModels();
                            foreach ( $listTables as $value ) { ?>
                                <tr>
                                    <td><?php echo $value ?></td>
                                    <td class="table-column-minimum">
                                        <?php
                                            switch ( $this->projectModules->getModelStatus( $value ) ) {
                                                case ProjectModules::STATUS_NOT_GENERATED:
                                                    echo 'Not generated';
                                                    break;
                                                case ProjectModules::STATUS_GENERATED:
                                                    echo 'Generated';
                                                    break;
                                                case ProjectModules::STATUS_MODIFIED:
                                                    echo 'Modified';
                                                    break;
                                                default:
                                                    echo 'Error';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td class="table-column-minimum"><a href="<?php echo UrlMaker::toAction( 'modules', 'generate', array( 'id' => $this->projectId, 'table' => $value ) )?>" title="Generate a CRUD module" class="ajax btn btn-xs btn-default">Generate</a></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer text-right">
                <a href="<?php echo UrlMaker::toAction( 'modules', 'generatelayout', array( 'id' => $this->projectId ) )?>" class="btn btn-default">Gerar layout</a>
            </div>
        </div>
    </div>
</div>