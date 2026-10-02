<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtask;
use App\Models\Activity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SubtaskController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $subtasks = Subtask::with('user')
            ->latest()
            ->get();

        return view('subtasks.index', compact('subtasks'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'subtask' => 'required|string|max:255',
        ]);

        $subtask = Subtask::create([
            'user_id'   => Auth::id(),
            'subtask' => $request->subtask,
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'subtasks',
            'table_id'    => $subtask->id,
            'operation'   => 'create',
            'description' => 'Subtask "' . $subtask->subtask . '" created',
        ]);

        return redirect()->route('subtasks.index')
            ->with('success', 'Subtask created successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $subtasks = Subtask::with('user')
            ->latest()
            ->get();

        $editSubtask = Subtask::findOrFail($id);

        return view('subtasks.index', compact('subtasks', 'editSubtask'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([
            'subtask' => [
                'required',
                'string',
                'max:255',
                
            ],
        ]);

        $subtask = Subtask::findOrFail($id);

        $subtask->update([
            'subtask' => $request->subtask,
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'subtasks',
            'table_id'    => $subtask->id,
            'operation'   => 'update',
            'description' => 'Subtask "' . $subtask->subtask . '" updated',
        ]);

        return redirect()->route('subtasks.index')
            ->with('success', 'Subtask updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $subtask = Subtask::findOrFail($id);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'subtasks',
            'table_id'    => $subtask->id,
            'operation'   => 'delete',
            'description' => 'Subtask "' . $subtask->subtask . '" deleted',
        ]);

        $subtask->delete();

        return redirect()->route('subtasks.index')
            ->with('success', 'Subtask deleted successfully');
    }
}