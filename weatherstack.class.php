<?php
/*
weatherstack class -
version 1.0 9/13/2019

API reference at https://weatherstack.com/documentation

Copyright (c) 2018, Wagon Trader

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class weatherStack{

    //Your weatherStack API key
    //Available at https://weatherstack.com/product
    protected $apiKey = 'e1e10bf6b83cdcda73c9947cf3ed6d2c';

    //API endpoints
    private $endPoint = array(
        'current' => 'api.weatherstack.com/current',
        'c' => 'api.weatherstack.com/current',
        'historical' => 'api.weatherstack.com/historical',
        'history' => 'api.weatherstack.com/historical',
        'h' => 'api.weatherstack.com/historical',
        'forecast' => 'api.weatherstack.com/forecast',
        'f' => 'api.weatherstack.com/forecast',
        'autocomplete' => 'api.weatherstack.com/autocomplete',
        'auto' => 'api.weatherstack.com/autocomplete',
        'a' => 'api.weatherstack.com/autocomplete'
    );

    //default endpoint to use
    public $useEndPoint = 'current';

    //use secure socket layer
    public $useSSL = false;

    //holds the error code, if any
    public $errorCode;

    //holds the error text, if any
    public $errorText;

    //response object
    public $response;

    //JSON response from API
    public $responseAPI;

    //params array
    public $params;

    /*
    method:  getResponse
    usage:   getResponse();
    params:  none

    This method will build the reqeust and get the response from the API

    returns: null
    */
    public function getResponse(){

        $request = $this->buildRequest();

        $this->responseAPI = file_get_contents($request);

        $this->response = json_decode($this->responseAPI);

        if( !empty($this->response->error->code) ){

            $this->errorCode = $this->response->error->code;
            $this->errorText = $this->response->error->info;

        }

    }

    /*
    method:  getResponseCurl
    usage:   getResponseCurl();
    params:  none

    This method will get an API response using curl

    returns: null
    */
    public function getResponseCurl(){

        $request = $this->buildRequest();

        $curl = curl_init($request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $this->responseAPI = curl_exec($curl);
        curl_close($curl);

        $this->response = json_decode($this->responseAPI);

        if( !empty($this->response->error->code) ){

            $this->errorCode = $this->response->error->code;
            $this->errorText = $this->response->error->info;

        }

    }

    /*
    method:  buildRequest
    usage:   buildRequest()
    params:  none

    This method will build the api request url.

    returns: api request url
    */
    public function buildRequest(){

        $prot = ( $this->useSSL ) ? 'https://' : 'http://';

        $request = $prot.$this->endPoint[$this->useEndPoint].'?access_key='.$this->apiKey;

        if( is_array($this->params) ){
            foreach( $this->params as $key=>$value ){

                $request .= '&'.$key.'='.urlencode($value);

            }
        }

        return $request;

    }

    /*
    method:  setParam
    usage:   setParam(string key, string value);
    params:  key = key of the params key/value pair
             value =  value of the params key/value pair

    add or change the params key/value pair specified.

    returns: null
    */
    public function setParam($key,$value){

        $this->params[$key] = $value;

    }

    /*
    method:  resetParam
    usage:   resetParam(void);
    params:  none

    resets all stored parameters.

    returns: null
    */
    public function resetParams(){

        $this->params = array();

    }

    /*
    method:  setEndPoint
    usage:   setEndPoint(string useEndPoint);
    params:  useEndPoint = end point to use for request

    Sets the end point to use for request.

    returns: null
    */
    public function setEndPoint($useEndPoint){

        if( array_key_exists($useEndPoint,$this->endPoint) ){

            $this->useEndPoint = $useEndPoint;

        }else{

            throw new Exception($useEndPoint.' is not a valid end point');

        }

    }

}
?>
