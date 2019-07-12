<div class="row">
    <div class="col-md-3">
        <?php $this->addPartial( 'menu', 'projects', array('active' => 'projects', 'record' => $this->record ) ) ?>
    </div>
    <div class="col-md-9">
        <h1><span class="ftools-code"></span> Project</h1>
        <?php if( $this->message ) { ?>
            <div class="alert alert-warning">
                <?php echo $this->message ?>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        <?php } ?>
        <form class="form-horizontal" method="post" action="<?php echo UrlMaker::toAction( 'projects', 'save' ) ?>">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php if( $this->record ) { ?>
                        Editing: <?php echo $this->record->getName() ?>
                    <?php } else { ?>
                        Create a new project
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <legend>Details</legend>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_name">Project name</label>
                            <div class="col-md-8">
                                <input value="<?php echo $this->record ? $this->record->getName() : '' ?>" id="project_name" name="project_name" placeholder="" class="form-control input-md" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_path">Path</label>
                            <div class="col-md-8">
                                <input value="<?php echo $this->record ? $this->record->getPath() : '' ?>" id="project_path" name="project_path" placeholder="/var/www/project" class="form-control input-md" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div class="checkbox">
                                    <label for="project_exist">
                                        <input type="checkbox" name="project_exist" id="project_exist" value="1">
                                        Project from existing source code
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="panel-footer text-right">
                    <?php if( $this->record ) { ?>
                        <a href="<?php echo UrlMaker::toAction( 'projects', 'delete', array('id' => $this->record->getId() ) ) ?>" class="btn btn-danger tools-remove"><span class="ftools-remove"></span> Delete</a>
                    <?php } ?>
                    <button type="submit" class="btn btn-success"><span class="ftools-ok"></span> <?php echo $this->record ? 'Save' : 'Create' ?></button>
                    <input type="hidden" value="<?php echo $this->record ? $this->record->getId() : '' ?>" name="project_id" id="project_id" />
                </div>
            </div>
        </form>
    </div>
</div>