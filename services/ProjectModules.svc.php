<?php
/**
 * Description of ProjectModels
 *
 * @author marcusmaia
 */
class ProjectModules {
    const STATUS_NOT_GENERATED = 0;
    const STATUS_GENERATED = 1;
    const STATUS_MODIFIED = 2;

    private $projectId = null;

    private $path = null;

    private $models = array();

    private $template = 'bootstrap';

    public function __construct( $id )
    {
        $ProjectConfig = new ProjectConfigs( $id );
        $ProjectModels = new ProjectModels( $id );

        $this->projectId = $ProjectConfig->getId();
        $this->path = $ProjectConfig->getPath();
        $this->models = $ProjectModels->getModelNames();
    }

    public function getModels()
    {
        return $this->models;
    }

    public function getModel( $name )
    {
        $ProjectModels = new ProjectModels( $this->projectId );
        $table = $ProjectModels->getTableName( $name );
        return $ProjectModels->getModelData( $table );
    }

    public function getModelStatus( $name )
    {
        $model = $this->loadModelFile( $name, true );
        if( $model === false ) {
            return self::STATUS_NOT_GENERATED;
        }
        return self::STATUS_GENERATED;
    }

    public function getRegistredModules()
    {
        try {
            $path = PROJECT_FILES_PATH . $this->projectId . DS .'modules' . DS;
            $files = glob( $path . '*.json');

            // Percorrer lista de arquivos carregando as informações
            $return = array();
            foreach ( $files as $file ) {
                $return[] = basename( $file, '.json' );
            }
            return $return;
        } catch ( FwException $e ) {
            echo $e->getMessage();
        }
    }

    public function getModuleName( $model )
    {
        return Text::toLower($model);
        // return $module->__toString();
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate( $template )
    {
        $this->template = $template;
        return $this;
    }

    public function makeModule( $model, $fields, $moduleGroup = null )
    {
        $module = $this->getModuleName( $model );

        $this->makeController( $model, $fields, $moduleGroup );
        $this->makeList( $module, $fields, $moduleGroup );
        $this->makeForm( $module, $fields, $model, $moduleGroup );
        $this->makeView( $module, $fields, $moduleGroup );
        $this->registerModule( $module, $fields, $moduleGroup );
    }

    public function makeController( $model, $fields, $moduleGroup = null )
    {
        $ProjectConfig = new ProjectConfigs( $this->projectId );

        // Cria a o título do módulo
        $title = Text::humanize($model);
        $table = Text::underscore( $model );

        // Obtem a data de criação do módulo
        $date = date('Y-m-d H:i:s');

        // Obtem a versão em que foi criado o módulo
        $version = $ProjectConfig->getVersion();

        // Identifica o campo padrão de ordenação
        $sortField = 'id';
        $newFields = array();
        foreach ( $fields as $field ) {
            if( $field['sort'] ) {
                    $sortField = $field['name'];
            }
            $field['id'] = $table . '_' . $field['name'];
            $field['camelcase'] = Text::camelize($field['name']);
            $newFields[] = $field;
        }
                $fields = $newFields;

        ob_start();
        include( dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'resources' .
            DIRECTORY_SEPARATOR . 'structure' .
            DIRECTORY_SEPARATOR . 'controllers' .
            DIRECTORY_SEPARATOR . 'crudcontroller.ctrl.php'
        );
        $controller = ob_get_contents();
        ob_end_clean();

        if ($moduleGroup) {
            $path = $this->path . 'modules' . DS . $moduleGroup . DS . strtolower( $model ) . DS;
        } else {
            $path = $this->path . 'modules' . DS . strtolower( $model ) . DS;
        }

        if( !file_exists( $path ) ) {
            if( !mkdir( $path, 0775, true ) ) {
                throw new FwException( 'The module folder does not exist and cannot be created.' );
            }
        }

        file_put_contents( $path . strtolower( $model ) . '.ctrl.php' , $controller );
        chmod( $path . strtolower( $model ) . '.ctrl.php' , 0775 );
    }

    public function makeView( $module, $fields, $moduleGroup = null )
    {
        ob_start();
        include( dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'resources' .
            DIRECTORY_SEPARATOR . 'structure' .
            DIRECTORY_SEPARATOR . 'views' .
            DIRECTORY_SEPARATOR . 'crud' .
            DIRECTORY_SEPARATOR . $this->template .
            DIRECTORY_SEPARATOR . 'view.frm.php'
        );
        $view = ob_get_contents();
        ob_end_clean();

        if ($moduleGroup) {
            $path = $this->path . 'modules' . DS . $moduleGroup . DS . strtolower( $module ) . DS;
        } else {
            $path = $this->path . 'modules' . DS . strtolower( $module ) . DS;
        }

        if( !file_exists( $path . 'views' ) ) {
            if( !mkdir( $path . 'views', 0775, true ) ) {
                throw new FwException( 'The module folder does not exist and cannot be created.' );
            }
        }

        file_put_contents( $path . 'views' . DS . 'view.frm.php' , $view );
        chmod( $path . 'views' . DS . 'view.frm.php' , 0775 );
    }

    public function makeForm( $module, $fields, $model, $moduleGroup = null )
    {
        $table = Text::underscore( $model );

        $Form = new ProjectForms( $fields, $module, $table );
        $Form->setMethod( 'post' );
        $Form->setName( 'form-' . $module );
        $Form->setTemplate( $this->template );
        $Form->setModuleGroup( $moduleGroup );

        foreach ( $fields as $field ) {
            if( $field['type'] != '' ) {
                $Form->addInput( $field );
            }
        }

        $formContent = $Form->generate();
        $scripts = $Form->generateScripts();

        ob_start();
        include( dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'resources' .
            DIRECTORY_SEPARATOR . 'structure' .
            DIRECTORY_SEPARATOR . 'views' .
            DIRECTORY_SEPARATOR . 'crud' .
            DIRECTORY_SEPARATOR . $this->template .
            DIRECTORY_SEPARATOR . 'form.frm.php'
        );
        $view = ob_get_contents();
        ob_end_clean();


        if ($moduleGroup) {
            $path = $this->path . 'modules' . DS . $moduleGroup . DS . strtolower( $module ) . DS;
        } else {
            $path = $this->path . 'modules' . DS . strtolower( $module ) . DS;
        }

        if( !file_exists( $path . 'views' ) ) {
            if( !mkdir( $path . 'views', 0775, true ) ) {
                throw new FwException( 'The module folder does not exist and cannot be created.' );
            }
        }

        file_put_contents( $path . 'views' . DS . 'form.frm.php' , $view );
        chmod( $path . 'views' . DS . 'form.frm.php' , 0775 );

        if( !file_exists( $this->path . 'public' . DS . 'scripts' . DS . 'modules' . DS  . ($moduleGroup ? DS . $moduleGroup  . DS : '')) ) {
            if( !mkdir( $this->path . 'public' . DS . 'scripts' . DS . 'modules' . DS . ($moduleGroup ? DS . $moduleGroup  . DS : ''), 0775, true ) ) {
                throw new FwException( 'The script module folder does not exist and cannot be created.' );
            }
        }

        file_put_contents( $this->path . 'public' . DS . 'scripts' . DS . 'modules' . DS . ($moduleGroup ? DS . $moduleGroup  . DS : '') . $module . '_form.js' , $scripts );
        chmod( $this->path . 'public' . DS . 'scripts' . DS . 'modules' . DS . ($moduleGroup ? DS . $moduleGroup  . DS : '') . $module . '_form.js' , 0775 );
    }

    public function makeList( $module, $fields, $moduleGroup = null )
    {
        ob_start();
        include( dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'resources' .
            DIRECTORY_SEPARATOR . 'structure' .
            DIRECTORY_SEPARATOR . 'views' .
            DIRECTORY_SEPARATOR . 'crud' .
            DIRECTORY_SEPARATOR . $this->template .
            DIRECTORY_SEPARATOR . 'index.frm.php'
        );
        $view = ob_get_contents();
        ob_end_clean();


        if ($moduleGroup) {
            $path = $this->path . 'modules' . DS . $moduleGroup . DS . strtolower( $module ) . DS;
        } else {
            $path = $this->path . 'modules' . DS . strtolower( $module ) . DS;
        }

        if( !file_exists( $path . 'views' ) ) {
            if( !mkdir( $path . 'views', 0775, true ) ) {
                throw new FwException( 'The module folder does not exist and cannot be created.' );
            }
        }

        file_put_contents( $path . 'views' . DS . 'index.frm.php' , $view );
        chmod( $path . 'views' . DS . 'index.frm.php' , 0775 );
    }

    public function registerModule( $module, $fields, $moduleGroup = null )
    {
        $file = PROJECT_FILES_PATH . $this->projectId . DS . 'modules' . DS . $module . '.json';

        $json = array(
            'fields' => $fields
        );
        file_put_contents( $file, json_encode( $json ) );
        chmod($file, 0775);
    }

    private function loadModelFile( $module, $asArray = false )
    {
        $file = PROJECT_FILES_PATH . $this->projectId . DS . 'modules' . DS . $module . '.json';
        if( !file_exists( $file ) ) {
            return false;
        }

        $contents = file_get_contents($file);
        if( $contents === false ) {
            return false;
        }
        return json_decode( $contents, $asArray );
    }
}
