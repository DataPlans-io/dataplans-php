<?php

class DataPlansApiResource extends DataPlansObject
{
    // Request methods
    const REQUEST_GET = 'GET';
    const REQUEST_POST = 'POST';
    const REQUEST_DELETE = 'DELETE';
    const REQUEST_PATCH = 'PATCH';

    // API setting
    const API_PROTOCAL = 'https';
    const API_VERSION = 1;
    const API_MODE = 'sandbox';
    const API_DOMAIN = 'dataplans.io';
    const LIB_VERSION = '1.0.0';

    // Timeout settings
    private $REQUEST_CONNECTTIMEOUT = 30;
    private $REQUEST_TIMEOUT = 60;

    /**
     * Returns an instance of the class given in $instance or raise an error.
     *
     * @param  string $instance
     *
     * @throws Exception
     *
     * @return DataPlansResource
     */
    protected static function getInstance($instance)
    {
        if (class_exists($instance)) {
            return new $instance();
        }

        throw new Exception('Undefined class.');
    }

    /**
     * Retrieves the resource.
     *
     * @param  string $instance
     *
     * @throws Exception|DataPlansException
     *
     * @return DataPlansBalance
     */
    protected static function doRetrieve($instance, $url)
    {
        $resource = call_user_func(array($instance, 'getInstance'), $instance);
        $result = $resource->execute($url, self::REQUEST_GET, $resource->getResourceKey());
        $resource->refresh($result);

        return $resource;
    }

    /**
     * Creates the resource with given parameters.in an associative array.
     *
     * @param  string $instance
     * @param  string $url
     * @param  array  $params
     *
     * @throws Exception|DataPlansException
     *
     * @return DataPlansBalance
     */
    protected static function doCreate($instance, $url, $params)
    {
        $resource = call_user_func(array($instance, 'getInstance'), $instance);
        $result = $resource->execute($url, self::REQUEST_POST, $resource->getResourceKey(), $params);
        $resource->refresh($result);

        return $resource;
    }

    /**
     * Updates the resource with the given parameters in an associative array.
     *
     * @param  string $url
     * @param  array  $params
     *
     * @throws Exception|DataPlansException
     */
    protected function doUpdate($url, $params)
    {
        $result = $this->execute($url, self::REQUEST_PATCH, $this->getResourceKey(), $params);
        $this->refresh($result);
    }

    /**
     * Destroys the resource.
     *
     * @param  string $url
     *
     * @throws Exception|DataPlansException
     *
     * @return DataPlansApiResource
     */
    protected function doDestroy($url)
    {
        $result = $this->execute($url, self::REQUEST_DELETE, $this->getResourceKey());
        $this->refresh($result, true);
    }

    /**
     * Reloads the resource with latest data.
     *
     * @param  string $url
     *
     * @throws Exception|DataPlansException
     */
    protected function doReload($url)
    {
        $result = $this->execute($url, self::REQUEST_GET, $this->getResourceKey());
        $this->refresh($result);
    }

    /**
     * Makes a request and returns a decoded JSON data as an associative array.
     *
     * @param  string $url
     * @param  string $requestMethod
     * @param  string $token
     * @param  array  $params
     *
     * @throws DataPlansException
     *
     * @return array
     */
    protected function execute($url, $requestMethod, $token, $params = null)
    {
        if ($this->isPHPUnit()) {
            $result = $this->executeTest($url, $requestMethod, $token, $params);
        } else {
            $result = $this->executeCurl($url, $requestMethod, $token, $params);
        }

        // Decode the JSON response as an associative array.
        $array = json_decode($result, true);

        // If response is invalid or not a JSON.
        if (!$this->isValidAPIResponse($array)) {
            throw new Exception('Unknown error. (Bad Response)');
        }

        // If response is an error object.
        if (!empty($array['object']) && $array['object'] === 'error') {
            throw DataPlansException::getInstance($array);
        }

        return $array;
    }

    /**
     * Checks if response from API was valid.
     *
     * @param  array  $array  - decoded JSON response
     *
     * @return boolean
     */
    protected function isValidAPIResponse($array)
    {
        return count($array);
    }
    
    /**
     * Checks if this class is execute by phpunit.
     *
     * @return boolean
     */
    protected function isPHPUnit()
    {
        return preg_match('/phpunit/', $_SERVER['SCRIPT_NAME']);
    }

    /**
     * @param  string $url
     * @param  string $requestMethod
     * @param  string $token
     * @param  array  $params
     *
     * @throws DataPlansException
     *
     * @return string
     */
    private function executeCurl($url, $requestMethod, $token, $params = null)
    {
        $ch = curl_init(trim($url, '/'));

        curl_setopt_array($ch, $this->genOptions($requestMethod, $token, $params));

        // Make a request or thrown an exception.
        if (($result = curl_exec($ch)) === false) {
            $error = curl_error($ch);
            curl_close($ch);

            throw new Exception($error);
        }

        // Close.
        curl_close($ch);

        // Debug
        if ($this->isPHPUnit()) {
            print PHP_EOL .'================================================'. PHP_EOL .$url. PHP_EOL .'================================================'. PHP_EOL;
        }

        return $result;
    }

    /**
     * @param  string $url
     * @param  string $requestMethod
     * @param  string $token
     * @param  array  $params
     *
     * @throws DataPlansException
     *
     * @return string
     */
    private function executeTest($url, $requestMethod, $token, $params = null)
    {
        // Extract only hostname and URL path without trailing slash.
        $parsed = parse_url($url);
        $request_url = $parsed['host'] . rtrim($parsed['path'], '/');

        // Convert query string into filename friendly format.
        if (!empty($parsed['query'])) {
            $query = base64_encode($parsed['query']);
            $query = str_replace(array('+', '/', '='), array('-', '_', ''), $query);
            $request_url = $request_url . '-' . $query;
        }

        // Finally.
        $directory = dirname(__FILE__) . '/../../../tests/fixtures/';
        $request_url = $directory . $request_url . '-' . strtolower($requestMethod) . '.json';

        // Make a request from Curl if json file was not exists.
        if (!file_exists($request_url)) {
            // Get a directory that's file should contain.
            $request_dir = explode('/', $request_url);
            unset($request_dir[count($request_dir) - 1]);
            $request_dir = implode('/', $request_dir);

            // Create directory if it not exists.
            if (!file_exists($request_dir)) {
                mkdir($request_dir, 0777, true);
            }

            $result = $this->executeCurl($url, $requestMethod, $token, $params);

            $f = fopen($request_url, 'w');
            if ($f) {
                fwrite($f, $result);

                fclose($f);
            }
        } else { // Or get response from json file.
            $result = file_get_contents($request_url);
        }

        return $result;
    }

    /**
     * Creates an option for php-curl from the given request method and parameters in an associative array.
     *
     * @param  string $requestMethod
     * @param  string $token
     * @param  array  $params
     *
     * @return array
     */
    private function genOptions($requestMethod, $token, $params)
    {
        $user_agent = 'DataPlans/' . self::LIB_VERSION . ' ';
        $user_agent .= 'APIVersion/' . self::API_VERSION . ' ';
        $user_agent .= 'PHP/' . phpversion() . ' ';

        $options = array(
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestMethod,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_TIMEOUT => $this->REQUEST_TIMEOUT,
            CURLOPT_CONNECTTIMEOUT => $this->REQUEST_CONNECTTIMEOUT,
            CURLOPT_USERAGENT => $user_agent,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'DataPlans-Version: ' . self::API_VERSION,
            ),
        );

        // Also merge POST parameters with the option.
        if (is_array($params) && count($params) > 0) {
            $http_query = http_build_query($params);
            $http_query = preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $http_query);

            $options += array(CURLOPT_POSTFIELDS => $http_query);
        }

        return $options;
    }

    /**
     * Checks whether the resource has been destroyed.
     *
     * @return bool|null
     */
    protected function isDestroyed()
    {
        return $this['deleted'];
    }

    /**
     * Returns the secret key.
     *
     * @return string
     */
    protected function getResourceKey()
    {
        return $this->_token;
    }

    /**
     * Returns the api url
     *
     * @param  string $endpoint
     */
    protected static function getApiUrl($endpoint = null)
    {
        $mode = defined('DATAPLANS_API_MODE') ? DATAPLANS_API_MODE : self::API_MODE;
        return self::API_PROTOCAL . '://' . $mode . '.' . self::API_DOMAIN . '/api/v' . self::API_VERSION . '/' . $endpoint;
    }
}
