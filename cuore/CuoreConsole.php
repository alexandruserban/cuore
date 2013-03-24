<?php
class CuoreConsole{
    static $model_dir;
    static $model_prefix;
    function BuildModel($db_name, $table_name)
    {
        $fields = CuoreDb::getTableFields($db_name, $table_name);
        $class_name = self::$model_prefix . str_replace(' ','', ucwords(preg_replace('/[^a-zA-Z0-9]/',' ', $table_name)));
        $file = self::$model_dir . $class_name . '.php';
        $custom_content = '';
        if (file_exists($file)) {
            $old_content = explode("/*custom methods*/", file_get_contents($file));
            
            if (count($old_content) == 2) {
               $rest = trim(str_replace('', '', substr($old_content[1], 0, strrpos($old_content[1], '}'))));
$custom_content .= <<<EOT
    
    /*custom methods*/
    $rest
EOT;
            }
            //file_put_contents($file. '_bkp_' . date('Y_m_d'), file_get_contents($file));
        }
        $getset_ers = '';
        $content =
<<<EOT
<?php
class $class_name extends CuoreModel {
    static public \$table = '$table_name';

EOT;
        foreach ($fields as $field) {
            $content .=
<<<EOT
    public $$field;

EOT;
            $camel_case_field = str_replace(' ', '', ucfirst(str_replace('_', ' ', $field)));
            $getset_ers .= 
<<<EOT
            
    function get$camel_case_field()
    {
        return \$this->$field;
    }
    function set$camel_case_field($$field)
    {
        return \$this->$field = $$field;
    }
EOT;
        }
        $content .= $getset_ers . $custom_content . "\n}\n";
        file_put_contents($file, $content);
    }
    
    function BuildAllModels($db_name)
    {
        $tables = CuoreDb::getDBTables($db_name);
        foreach ($tables as $table) {
            self::BuildModel($db_name, $table);
        }
    }
}

