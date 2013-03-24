<?php 
class CuoreRoute 
{
	static $parameter_delimiter = '/';
	static $segments = array();
	static $controller;
	static $method;
    /*array('0' => array(':num', function ($val) { return ' lambda_filter: ' . $val;})); 
    this filter applies to the fist parmeter(position 0) of the controller method
     */
	static $filter_rules = array();
	static $parameters = array();
	static $fallback_function;
	static $controller_prefix;
	static $default_controller;
	static $default_method;
    
	function init () {

		CuoreRoute::$fallback_function = function ($segments) {
			/*the URL does not provide any callable function name*/ 
            //CuoreDebug::printhr("No Controller goes by that name here");
            throw new CuoreException('E01');
		};
	}
    
	function route($url)
	{
		$prefix = self::$controller_prefix;
		
		self::$segments = explode(self::$parameter_delimiter, $url);
		self::$controller = ucfirst(self::$segments[1]);
		self::$method = isset(self::$segments[2]) &&  self::$segments[2] ? self::$segments[2] :
						str_replace($prefix, '', self::$controller);
		self::$parameters = array_slice(self::$segments, 3);
		self::$parameters = self::filter(self::$parameters);
		
        if (!self::$controller) {
            self::$controller = self::$default_controller;
            self::$method = self::$default_method;
        }
        self::$controller = $prefix . self::$controller;
        
		if (is_callable(array(self::$controller, self::$method)))  {
			call_user_func_array(array(self::$controller, self::$method), self::$parameters);
		} elseif (is_callable(self::$fallback_function)) {
			call_user_func_array(self::$fallback_function, array(self::$segments));
		}
	}
	
	function filter($parameters)
	{
		if (count(self::$filter_rules)) {
			
			foreach ($parameters as $k => $parameter) {
				if (isset(self::$filter_rules[$k])) {
					$new_parameter = $parameter;
					if (!is_array(self::$filter_rules[$k])) {
                        self::$filter_rules[$k] = array(self::$filter_rules[$k]);
                    }
                    foreach (self::$filter_rules[$k] as $filter) {
                        if (is_callable($filter)) {
                            $new_parameter = call_user_func_array($filter, array($new_parameter));
                        } else {
                            switch ($filter) {
                                case ':num': $new_parameter = preg_replace('/[^0-9]/', '', $new_parameter);break;
                                case ':alpha': $new_parameter = preg_replace('/[^a-zA-Z]/', '', $new_parameter);break;
                            }
                        }

                    }
                    
                    $parameters[$k] = $new_parameter;
				}
			}
		}
		
		return $parameters;
	}
}
