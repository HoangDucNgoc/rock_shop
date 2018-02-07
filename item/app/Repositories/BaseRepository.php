<?php

namespace App\Repositories;

use App\Enums\Status;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
	/*
    |--------------------------------------------------------------------------
    | Get signle data
    |--------------------------------------------------------------------------
    | Only use for query with condition operator '=' 
    | if for another operator '>', '<' , 'betwwen' please use sqlQuery
    | Example : 
    | getSingle('config',array('name','id'),array('name' => 'abc','created_at > 2010-20-10'))  ==> select name,id from config where name = 'abc' and created-at > 2010-20-10
	*/

    /**
	 * @param String $table 
	 * @param Array $select
	 * @param Array $query
	 * @param String $sqlQuery
	 * @return stdClass $result
	 */

	public function getSignleData($table,$select,$query = null,$sqlQuery = null){

		if($table == null){
			return null;
		}

		if(!is_array($select)) {
			return null;
		}

		$selects = implode(',', $select);

		$sql = "select  $selects  from $table where is_delete = :is_delete and is_active =:is_active ";
		$parameter = array(
			'is_delete' => Status::UNDELETE,
			'is_active' => Status::ACTIVE,
		);

		if($query && is_array($query)) {

			foreach ($query as $key => $value) {
				$sql .= " and $key =:$key";
				$parameter[$key] = $value;
			}
		}

		if($sqlQuery){
			$sql .= " and  $sqlQuery ";
		}

		$sql .= ' limit 1';

		$result = DB::select($sql, $parameter);

		if (count($result) == 0) {
			return null;
		}
		return $result[0];
	}


	/*
    |--------------------------------------------------------------------------
    | Get multi data
    |--------------------------------------------------------------------------
    | Only use for query with condition operator '=' 
    | if for another operator '>', '<' , 'betwwen' please use option
    | contruct option : 
    | 	option [ 'query' => 'value',
    			 'limit' => '1',
    			 'order_by' => 'value',
    			 'in' => array('key' =>'value') ]
    | Example : 
    | getMultiData('category',array('name','id'),array('name' => 'abc',array('query'=>'created-at > 2010-20-10','order_by'=>'order by level'))) 
    |  ==> select name,id from category where name = 'abc' and created-at > 2010-20-10 order by level
	*/

	/**
	 * @param String $table 
	 * @param Array $select
	 * @param Array $query
	 * @param Array $option
	 * @return stdClass $result
	 */
	public function getMultiData($table,$select,$query = null, $option = null){

		if($table == null){
			return null;
		}

		if(!is_array($select)) {
			return null;
		}

		$selects = implode(',', $select);

		$sql = "select  $selects  from $table where is_delete = :is_delete and is_active =:is_active ";
		$parameter = array(
			'is_delete' => Status::UNDELETE,
			'is_active' => Status::ACTIVE,
		);

		if($query && is_array($query)) {

			foreach ($query as $key => $value) {
				$sql .= " and $key =:$key";
				$parameter[$key] = $value;
			}
		}

		if(isset($option['in'])) {
			$in = $option['in'];
			foreach ($in as $key => $value) {
				$sql .= " and $key IN(:$key)";
				$parameter[$key] = $value;
			}
		}

		if(isset($option['query'])){
			$query = $option['query'];
			$sql .= " and $query ";
		}

		if(isset($option['order_by'])){
			$orderBy = $option['order_by'];
			$sql .= " $orderBy ";
		}

		$result = DB::select($sql, $parameter);

		if (count($result) == 0) {
			return null;
		}
		return $result;
	}
}
