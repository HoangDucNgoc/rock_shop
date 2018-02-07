<?php

namespace App\Repositories;

use App\Models\Feature;
use Illuminate\Support\Facades\DB;

class FeatureRepository extends BaseRepository {

	public function getFeature($roleId) {
		
		$features = array();
		$result = DB::table('role_feature')
            ->join('feature', 'feature.id', '=', 'role_feature.feature_id')
            ->join('roles', 'roles.id', '=', 'role_feature.role_id')
            ->select('role_feature.create','role_feature.update','role_feature.delete','role_feature.view', 'feature.name','roles.name as role')
            ->where('role_feature.role_id', '=', $roleId)
            ->get();
        if($result){
        	foreach ($result as $key => $item) {
        		$feature = new Feature();
        		$feature->feature = $item->name;
			    $feature->delete  = $item->delete;
			    $feature->update  = $item->update;
			    $feature->create  = $item->create;
			    $feature->view    = $item->view;
			    $features[$item->name] = $feature;
        	}

        }
        return $features;

	}

}
