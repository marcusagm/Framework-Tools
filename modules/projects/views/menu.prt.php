<?php $projects = Project::getListProject(); ?>
<div class="dropdown">
    <?php if( isset( $record ) && $record !== false ) { ?>
        <a href="<?php echo UrlMaker::toAction( 'projects' ) ?>" class="btn btn-primary btn-block" data-toggle="dropdown">
            <span class="dropdown-header"><?php echo $record->getName() ?></span>
            <span class="ftools-down-open"></span>
        </a>
    <?php } elseif ( count($projects) > 0 ) { ?>
        <a href="<?php echo UrlMaker::toAction( 'projects' ) ?>" class="btn btn-primary btn-block" data-toggle="dropdown">
            <span class="dropdown-header">New Project</span>
            <span class="ftools-down-open"></span>
        </a>
    <?php } else { ?>
        <a href="<?php echo UrlMaker::toAction( 'projects' ) ?>" class="btn btn-primary btn-block" data-toggle="dropdown">
            <span class="dropdown-header">No projects found</span>
            <span class="ftools-down-open"></span>
        </a>
    <?php } ?>
    <ul class="dropdown-menu " role="menu">
        <?php if( count( $projects ) ) { ?>
            <?php foreach( $projects as $project ) { ?>
                <li><a href="<?php echo UrlMaker::toAction('projects', 'edit', array( 'id' => $project->getId() ) ) ?>"><span class="ftools-code"></span> <?php echo $project->getName() ?></a></li>
            <?php } ?>
            <li class="divider"></li>
        <?php } ?>
        <li><a href="<?php echo UrlMaker::toAction('projects', 'add' ) ?>"><span class="ftools-plus-circle"></span> Create a new project</a></li>
    </ul>
</div>

<hr>
<ul class="nav nav-pills nav-stacked">
    <?php if( isset( $record ) && $record !== false ) { ?>
        <li<?php echo $active == 'projects' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'projects', 'edit', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-code"></span> Project</a></li>
        <li<?php echo $active == 'config' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'config', 'index', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-cogs"></span> Configurations</a></li>
        <?php
            $Config = new ProjectConfigs($record->getId() );
            if( $Config->hasConfigFileGenerated() ) {
        ?>
            <li<?php echo $active == 'models' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'models', 'index', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-database"></span> Models</a></li>
            <?php
                $Model = new ProjectModels( $record->getId() );
                if( $Model->hasGeneratedModels() ) {
            ?>
                <li<?php echo $active == 'modules' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'modules', 'index', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-popup"></span> Modules</a></li>
                <li<?php echo $active == 'services' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'services', 'index', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-briefcase"></span> Services</a></li>
                <li<?php echo $active == 'api' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'api', 'index', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-lab"></span> API</a></li>
                <li<?php echo $active == 'logs' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'logs', 'index', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-docs"></span> Logs</a></li>
                <li<?php echo $active == 'backup' ? ' class="active"' : '' ?>><a href="<?php echo UrlMaker::toAction( 'backup', 'index', array( 'id' => $record->getId() ) ) ?>"><span class="ftools-back-in-time"></span> Backup</a></li>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</ul>