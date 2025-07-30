<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class serviceFolder extends Controller
{
    public $serviceName;
    public function getFolderService($serviceId){
        session()->forget('currentFolder');
        session()->put('SessionService',$serviceId); //jai besoin de lui pour le chemin dans foldermanager pour faire le home
        $serviceName=$this->serviceName = Service::find($serviceId);
        return view("serviceFolder", compact('serviceName'));
    }
}
