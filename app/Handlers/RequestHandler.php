<?php

namespace App\Handlers;

trait RequestHandler {

    public function extractRequestData($request) : array {
		
		if ($request->isMethod('post')) {
			$RequestArray = $request->all();
		} else {
			$RequestArray = $request->query();
		}
    
		$_data = [];
		foreach ($RequestArray as $Key => $Value){
			$_data[$Key] = $Value;
		}

		return $_data;
    }
}
