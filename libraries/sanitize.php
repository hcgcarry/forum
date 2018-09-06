<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class sanitize{
	public function sanitizeArray($array){
		if(isset($array) and count($array) > 0){
			foreach($array as $index => $item){
				$array[$index]=htmlspecialchars($item);	
			}
		}
	}

}

