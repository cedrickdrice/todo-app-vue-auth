<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * [v2x Migration] : Order Search API
     */
    const UPDATE_TASK = array(
        'title'         => 'task_title',
        'description'   => 'task_description',
        'priority'      => 'task_priority_id',
        'status'        => 'task_status_id'
    );

    public function getMappedParam($aInitialSet, $aChangeSet): array
    {
        $aNewSet = array();
        foreach ($aInitialSet as $sKey => $aValue) {
            $sNewKey = array_key_exists($sKey, $aChangeSet) ? $aChangeSet[$sKey] : $sKey;
            $aNewSet[$sNewKey] = is_array($aValue) ? self::getMappedParam($aValue, $aChangeSet) : $aValue;
        }
        return $aNewSet;
    }
}
