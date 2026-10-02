<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // Adjust the view path as necessary
    }
    
    public function showUsers(Request $request)
    {
        // Fetch users except those with 'admin' user_type, ordered by ID, and paginated by 10 entries per page
        $users = User::where('user_type', '!=', 'admin')->orderBy('id', 'desc')->paginate(10);
        
        // Return the view with the users data
        return view('auth.register', compact('users')); // Adjust the view path as necessary
    }
    
    public function addUsers()
    {
        $roles = Role::all(); 
        return view('auth.add-user', compact('roles'));
    }
    
 public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'required|string|max:255',
            'user_type' => 'required',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed', // If you want a confirmation field
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'user_type' =>  $request->user_type,
            'role_id' => $request->role_id,
            'password' =>Hash::make($request->password), // Hashing password
            'show_password' =>$request->password,
        ]);

        return redirect()->route('show.users')->with('success', 'User added successfully!');
    }

    // Handle the login request
  public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

        $user = Auth::user();

        if ($user->is_active == 0) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact administrator.',
            ])->withInput();
        }

        $request->session()->regenerate();

if ($user->user_type == 'employee') {

    $employee = \App\Models\Employee::where('user_id', $user->id)->first();

    if ($employee) {

        $dashboardId = \DB::table('employee_dashboards')
            ->where('employee_id', $employee->id)
            ->value('dashboard_id');

        if ($dashboardId) {
            return redirect()->route('dashboard.render', $dashboardId)
                ->with('success', 'Login successful! Welcome back');
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Login successful! Welcome back');
    }
}

return redirect('/')
    ->with('success', 'Login successful! Welcome back');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput();
}
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login'); // Adjust the route name as necessary
    }
    
       public function destroy($id)
    {
        // Find the user by ID and delete
        $user = User::find($id);
        
        if ($user) {
            $user->delete(); // Delete the user
            return redirect()->route('show.users')->with('success', 'User deleted successfully.');
        }

        return redirect()->route('users.index')->with('error', 'User not found.');
    }
    ///////////////////////////////////
public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

public function checkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email not found!']);
    }

    return redirect()->route('password.reset.form', $request->email);
}

public function showResetForm($email)
{
    return view('auth.reset-password', compact('email'));
}

public function updatePassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'User not found'
        ]);
    }

    $user->password      = Hash::make($request->password);
    $user->show_password = $request->password; 
    $user->save();

    return redirect('/login')->with('success', 'Password updated successfully!');
}
    //////////////////////////////////

public function downloadBackup()
{
    // Get database connection details
    $dbHost = env('DB_HOST');
    $dbName = env('DB_DATABASE');
    $dbUser = env('DB_USERNAME');
    $dbPass = env('DB_PASSWORD');

    // Get PDO connection
    $connection = DB::connection()->getPdo();

    // Prepare the backup file name
    $backupFileName = $dbName . '_backup_' . date('Y_m_d_H_i_s') . '.sql';

    // Start the SQL dump as a string
    $sqlDump = "-- Database: {$dbName}\n";
    $sqlDump .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";

    // Get all table names
    $tables = $connection->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        // Get CREATE TABLE statement
        $createTable = $connection->query("SHOW CREATE TABLE {$table}")->fetch(\PDO::FETCH_ASSOC);
        $sqlDump .= $createTable['Create Table'] . ";\n\n";

        // Get table data
        $rows = $connection->query("SELECT * FROM {$table}")->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $columns = implode("`, `", array_keys($row));
            $values = implode("', '", array_map([$connection, 'quote'], array_values($row)));
            $sqlDump .= "INSERT INTO `{$table}` (`{$columns}`) VALUES ('{$values}');\n";
        }
        $sqlDump .= "\n\n";
    }

    // Convert the SQL dump to a downloadable response
    return response($sqlDump, 200, [
        'Content-Type' => 'application/sql',
        'Content-Disposition' => "attachment; filename={$backupFileName}",
    ]);
}

}
