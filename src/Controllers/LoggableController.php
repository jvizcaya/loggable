<?php

namespace Jvizcaya\Loggable\Controllers;

use App\Http\Controllers\Controller;
use Jvizcaya\Loggable\Models\Log;
use Illuminate\Http\Request;


class LoggableController extends Controller
{
    /**
    * Display the main view.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
          return view('Loggable::index');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function logs(Request $request)
    {
        $logs =  Log::byUser($request->user)
                    ->byTable($request->table)
                    ->byModel($request->model)
                    ->date($request->date)
                    ->orderBy('log_at', 'desc')
                    ->paginate(10);

        $logs->each(function ($log) {
            $log->append('log_at_string');
        });

        return $logs;

    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function users(Request $request)
    {
        return Log::selectRaw('JSON_EXTRACT(payload, "$.user") as payload')
                    ->whereRaw('JSON_EXTRACT(payload, "$.user.name") LIKE "%'. $request->q .'%"')
                    ->distinct()
                    ->take(10)
                    ->get();
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function tables(Request $request)
    {
        return Log::select('table')
                    ->distinct()
                    ->orderBy('table', 'asc')
                    ->get();
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function models(Request $request)
    {
        return Log::select('model_id')
                    ->where('model_id', $request->q)
                    ->distinct()
                    ->orderBy('model_id', 'asc')
                    ->take(10)
                    ->get();
    }


}
