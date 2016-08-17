<?php

/**
 * Description of ProjectModels
 *
 * @author marcusmaia
 */
class ProjectForms
{

    private $formContent = '';
    private $fields;
    private $validators = array();
    private $name;
    private $tabindex = 0;
    private $module;
    private $table;
    private $method = 'post';
    private $enctype = 'application/x-www-form-urlencoded';
    private $template = 'bootstrap';

    public function __construct($fields, $module, $table)
    {
        $this->fields = $fields;
        $this->module = $module;
        $this->table = $table;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTabindex()
    {
        return $this->tabindex;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getEnctype()
    {
        return $this->enctype;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setTabindex($tabindex)
    {
        $this->tabindex = $tabindex;
        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setEnctype($enctype)
    {
        $this->enctype = $enctype;
        return $this;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function addInput($field)
    {
        $tabindex = $this->tabindex;

        if ($field['type'] == 'file' || $field['type'] == 'cropbox') {
            $this->setEnctype('multipart/form-data');
        }

        if ($field['type'] == 'checkbox' || $field['type'] == 'radio') {
            $field['value'] = '<?php echo $this->record && $this->record->' . $field['name'] . ' ? \' checked\'' . ' : \'\' ?>';
        } else {
            $field['value'] = '<?php echo $this->record ? $this->record->' . $field['name'] . ' : \'\' ?>';
        }
        $field['original_name'] = $field['name'];
        $field['name'] = $this->table . '_' . $field['name'];

        // Chama método que irá veirifcar se o campo possui alguma validação
        $this->inputValidate($field);

        $path = dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'resources' .
            DIRECTORY_SEPARATOR . 'form' .
            DIRECTORY_SEPARATOR . $this->template .
            DIRECTORY_SEPARATOR . $field['type'] . '.tpl.php';

        if (!file_exists($path)) {
            throw new FwException('The template for input of type "' . $field['type'] . '" is not found.');
        }

        ob_start();
        include( $path );
        $this->formContent .= ob_get_contents() . "\n\n";
        ob_end_clean();

        $this->tabindex++;
        return $this;
    }

    private function inputValidate($field)
    {
        $validate = array();
        if ($field['required']) {
            $validate['required'] = $field['required'];
        }
        if ($field['type'] == 'email') {
            $validate['email'] = true;
        }
        if ($field['type'] == 'number') {
            $validate['number'] = true;
        }
        if ($field['maxlength'] !== false && ( $field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'password' || $field['type'] == 'url' )) {
            $validate['maxlength'] = $field['maxlength'];
        }
        if ($field['type'] == 'url') {
            $validate['url'] = true;
        }
        if (count($validate) == 0) {
            return false;
        }
        $this->validators[$field['name']] = $validate;
        return $this;
    }

    public function generate()
    {
        $name = $this->name;
        $content = str_replace("\n", "\n\t\t\t", $this->formContent);
        $action = '<?php echo UrlMaker::toAction( \'' . $this->module . '\', $this->record ? \'update\' : \'create\' ); ?>';
        $method = $this->method;
        $enctype = $this->enctype;

        $path = dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'resources' .
            DIRECTORY_SEPARATOR . 'form' .
            DIRECTORY_SEPARATOR . $this->template .
            DIRECTORY_SEPARATOR . 'form.tpl.php';

        if (!file_exists($path)) {
            throw new FwException('The template for form is not found.');
        }

        ob_start();
        include( $path );
        $form = ob_get_contents();
        ob_end_clean();

        return $form;
    }

    public function generateScripts()
    {
        $name = $this->name;
        $validators = $this->validators;

        $fields = array();
        foreach ($this->fields as $value) {
            $field = $value;
            $field['id'] = $this->table . '_' . $field['name'];
            $CamelCase = new String($field['name']);
            $CamelCase->camelize();
            $field['camelcase'] = $CamelCase->__toString();
            $fields[] = $field;
        }

        $path = dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'resources' .
            DIRECTORY_SEPARATOR . 'form' .
            DIRECTORY_SEPARATOR . $this->template .
            DIRECTORY_SEPARATOR . 'scripts.tpl.php';

        if (!file_exists($path)) {
            throw new FwException('The template for module script is not found.');
        }

        ob_start();
        include( $path );
        $script = ob_get_contents();
        ob_end_clean();

        return $script;
    }
}
