<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomDashboard;
use App\Models\Subtask;
use App\Models\Activity;

class CustomDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

   public function index()
{
    $dashboards = CustomDashboard::with('user')
                    ->latest()
                    ->get();

    return view('custom-dashboard.index', compact('dashboards'));
}

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

       public function create()
    {
        $subtasks = Subtask::latest()->get();
        return view('custom-dashboard.create', compact('subtasks'));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'dash_name' => 'required|string|max:255|unique:custom_dashboards,dash_name',
    ]);

    /*
    |--------------------------------------------------------------------------
    | DEFAULT JSON STRUCTURE
    |--------------------------------------------------------------------------
    */

    $viewJson = [

        'task_module' => [
            'chart' => false,
            'redirect_div' => false,
            'subtasks' => [],
        ],

        'ticket_module' => [
            'chart'        => false,
            'redirect_div' => false,
            'table'        => false,
        ],

        'modules' => [
            'Location Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],

            'Department Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],

            'Employee Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],

            'Group Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],
        ],

    ];

    /*
    |--------------------------------------------------------------------------
    | TASK MODULE
    |--------------------------------------------------------------------------
    */

    if ($request->has('view_json.task_module.chart')) {
        $viewJson['task_module']['chart'] = true;
    }
    
     if ($request->has('view_json.task_module.redirect_div')) {
        $viewJson['task_module']['redirect_div'] = true;
    }

    /*
    |--------------------------------------------------------------------------
    | SUBTASKS
    |--------------------------------------------------------------------------
    */

    $allSubtasks = Subtask::pluck('subtask')->toArray();

    foreach ($allSubtasks as $subtask) {

        $checked = in_array(
            $subtask,
            $request->input('view_json.task_module.subtasks', [])
        );

        $viewJson['task_module']['subtasks'][$subtask] = $checked;
    }

    /*
    |--------------------------------------------------------------------------
    | TICKET MODULE
    |--------------------------------------------------------------------------
    */

    if ($request->has('view_json.ticket_module.chart')) {
        $viewJson['ticket_module']['chart'] = true;
    }

    if ($request->has('view_json.ticket_module.redirect_div')) {
        $viewJson['ticket_module']['redirect_div'] = true;
    }

    if ($request->has('view_json.ticket_module.table')) {
        $viewJson['ticket_module']['table'] = true;
    }

    /*
    |--------------------------------------------------------------------------
    | OTHER MODULES
    |--------------------------------------------------------------------------
    */

    $modules = [
        0 => 'Location Module',
        1 => 'Department Module',
        2 => 'Employee Module',
        3 => 'Group Module',
    ];

    foreach ($modules as $key => $moduleName) {

        if ($request->has("view_json.modules.$key.redirect_div")) {
            $viewJson['modules'][$moduleName]['redirect_div'] = true;
        }

        if ($request->has("view_json.modules.$key.table")) {
            $viewJson['modules'][$moduleName]['table'] = true;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    $dashboard = CustomDashboard::create([

        'user_id'   => Auth::id(),
        'dash_name' => $request->dash_name,
        'view_json' => json_encode($viewJson),

    ]);
    
    Activity::create([
    'user_id'     => Auth::id(),
    'table_name'  => 'custom_dashboards',
    'table_id'    => $dashboard->id,
    'operation'   => 'create',
    'description' => 'Custom Dashboard "'.$dashboard->dash_name.'" created',
]);

    return redirect()
        ->route('custom-dashboards.index')
        ->with('success', 'Custom Dashboard Created Successfully');
}

public function edit($id)
{
    $dashboard = CustomDashboard::findOrFail($id);

    $subtasks = Subtask::latest()->get();

    return view('custom-dashboard.edit', compact(
        'dashboard',
        'subtasks'
    ));
}


/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

public function update(Request $request, $id)
{
    $dashboard = CustomDashboard::findOrFail($id);

    $request->validate([
        'dash_name' => 'required|string|max:255|unique:custom_dashboards,dash_name,' . $dashboard->id,
    ]);

    /*
    |--------------------------------------------------------------------------
    | DEFAULT JSON STRUCTURE
    |--------------------------------------------------------------------------
    */

    $viewJson = [

        'task_module' => [
            'chart' => false,
            'redirect_div' => false,
            'subtasks' => [],
        ],

        'ticket_module' => [
            'chart'        => false,
            'redirect_div' => false,
            'table'        => false,
        ],

        'modules' => [
            'Location Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],

            'Department Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],

            'Employee Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],

            'Group Module' => [
                'redirect_div' => false,
                'table'        => false,
            ],
        ],

    ];

    /*
    |--------------------------------------------------------------------------
    | TASK MODULE
    |--------------------------------------------------------------------------
    */

    if ($request->has('view_json.task_module.chart')) {
        $viewJson['task_module']['chart'] = true;
    }
    
    if ($request->has('view_json.task_module.redirect_div')) {
        $viewJson['task_module']['redirect_div'] = true;
    }

    /*
    |--------------------------------------------------------------------------
    | SUBTASKS
    |--------------------------------------------------------------------------
    */

    $allSubtasks = Subtask::pluck('subtask')->toArray();

    foreach ($allSubtasks as $subtask) {

        $checked = in_array(
            $subtask,
            $request->input('view_json.task_module.subtasks', [])
        );

        $viewJson['task_module']['subtasks'][$subtask] = $checked;
    }

    /*
    |--------------------------------------------------------------------------
    | TICKET MODULE
    |--------------------------------------------------------------------------
    */

    if ($request->has('view_json.ticket_module.chart')) {
        $viewJson['ticket_module']['chart'] = true;
    }

    if ($request->has('view_json.ticket_module.redirect_div')) {
        $viewJson['ticket_module']['redirect_div'] = true;
    }

    if ($request->has('view_json.ticket_module.table')) {
        $viewJson['ticket_module']['table'] = true;
    }

    /*
    |--------------------------------------------------------------------------
    | OTHER MODULES
    |--------------------------------------------------------------------------
    */

    $modules = [
        0 => 'Location Module',
        1 => 'Department Module',
        2 => 'Employee Module',
        3 => 'Group Module',
    ];

    foreach ($modules as $key => $moduleName) {

        if ($request->has("view_json.modules.$key.redirect_div")) {
            $viewJson['modules'][$moduleName]['redirect_div'] = true;
        }

        if ($request->has("view_json.modules.$key.table")) {
            $viewJson['modules'][$moduleName]['table'] = true;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    $dashboard->update([

        'dash_name' => $request->dash_name,
        'view_json' => json_encode($viewJson),

    ]);
    
    Activity::create([
    'user_id'     => Auth::id(),
    'table_name'  => 'custom_dashboards',
    'table_id'    => $dashboard->id,
    'operation'   => 'update',
    'description' => 'Dashboard "'.$dashboard->dash_name.'" updated',
   ]);

    return redirect()
        ->route('custom-dashboards.index')
        ->with('success', 'Custom Dashboard Updated Successfully');
}

/*
|--------------------------------------------------------------------------
| SHOW
|--------------------------------------------------------------------------
*/

public function show($id)
{
    $dashboard = CustomDashboard::findOrFail($id);

    $subtasks = Subtask::latest()->get();

    return view('custom-dashboard.show', compact(
        'dashboard',
        'subtasks'
    ));
}

/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

public function destroy($id)
{
    $dashboard = CustomDashboard::findOrFail($id);

    $dashboard->delete();
    
    Activity::create([
    'user_id'     => Auth::id(),
    'table_name'  => 'custom_dashboards',
    'table_id'    => $dashboard->id,
    'operation'   => 'delete',
    'description' => 'Dashboard "'.$dashboard->dash_name.'" deleted',
]);

    return redirect()
        ->route('custom-dashboards.index')
        ->with('success', 'Custom Dashboard Deleted Successfully');
}

}


