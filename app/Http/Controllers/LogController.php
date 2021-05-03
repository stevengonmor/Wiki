<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Spatie\Permission\Models\Permission;

//use DB;

class LogController extends Controller {

    /**
     * Create a new controller instance and defines what the user can do based on the permissions.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:Ver Historial', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $logs = Log::all()->sortByDesc("id");
        return view('logs.index', compact('logs'));
    }

}
