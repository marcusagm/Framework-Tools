<?php $this->layout->addViewJs( 'table.js' ); ?>
<?php $this->layout->addViewJs( 'models.js' ); ?>
<div class="row">
    <div class="col-md-3">
        <?php $this->addPartial( 'menu', 'projects', array('active' => 'models', 'record' => $this->record ) ) ?>
    </div>
    <div class="col-md-9">
        <h1><span class="ftools-database"></span> Models</h1>
        <?php if( $this->message ) { ?>
            <div class="alert alert-warning">
                <?php echo $this->message ?>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        <?php } ?>
        <form class="form-horizontal" method="post" action="<?php echo UrlMaker::toAction( 'models', 'save' ) ?>">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php if( $this->record ) { ?>
                        Editing models for: <?php echo $this->record->getName() ?>
                    <?php } else { ?>
                        Models
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover" id="models-list">
                        <thead>
                            <tr>
                                <th class="table-column-select"><input type="checkbox" name="select_all" id="select_all" value="1"></th>
                                <th>Model</th>
                                <th>Table</th>
                                <th class="table-column-minimum">Generated</th>
                                <th class="table-column-minimum">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $listTables = $this->projectModel->getTables();
                                foreach ( $listTables as $value ) { ?>
                                    <tr>
                                        <td class="table-column-select"><input type="checkbox" name="tables[]" value="<?php echo $value ?>"></td>
                                        <td><?php echo $this->projectModel->getModelName( $value ) ?></td>
                                        <td><?php echo $value ?></td>
                                        <td class="table-column-minimum">
                                            <?php
                                                switch ( $this->projectModel->getModelStatus( $value ) ) {
                                                    case ProjectModels::STATUS_NOT_GENERATED:
                                                        echo '<span class="label label-danger">Not generated</span>';
                                                        break;
                                                    case ProjectModels::STATUS_GENERATED:
                                                        echo '<span class="label label-success">Generated</span>';
                                                        break;
                                                    case ProjectModels::STATUS_MODIFIED:
                                                        echo '<span class="label label-warning">Modified</span>';
                                                        break;
                                                    default:
                                                        echo 'Error';
                                                        break;
                                                }
                                            ?>
                                        </td>
                                        <td class="table-column-minimum"><a href="<?php echo UrlMaker::toAction( 'models', 'view', array( 'id' => $this->projectId, 'table' => $value ) )?>" title="View detais" class="ajax btn btn-xs btn-default"><i class="ftools-eye"></i> Details</a></td>
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer text-right">
                    <div class="checkbox checkbox-inline">
                        <label for="genarate_only_repositories">
                            <input type="checkbox" name="genarate_only_repositories" id="genarate_only_repositories" value="1">
                            Genarate only the repositories
                        </label>
                    </div>
                    &nbsp;
                    <a href="<?php echo UrlMaker::toAction( 'models', 'uptademodeldata', array( 'id' => $this->projectId ) )?>" class="btn btn-default pull-left"><span class="ftools-update"></span> Atualizar informações de models</a>
                    <button type="submit" class="btn btn-success model-generate"><span class="ftools-ok"></span> Generate all</button>
                    <input type="hidden" value="<?php echo $this->projectId ?>" name="project_id" id="project_id" />
                </div>
            </div>
        </form>
    </div>
</div>