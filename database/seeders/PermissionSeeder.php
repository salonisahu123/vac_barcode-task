<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = [

            // ================= DASHBOARD =================
            'Dashboard' => ['view'],

            // ================= REPORT =================
            'Report' => ['view','add'],

            // ================= USERS =================
            'Users' => ['view','add','edit','delete'],

            // ================= EMPLOYEE =================
            'Employee' => ['view','add','edit','delete'],

            // ================= LOCATION =================
            'Location' => ['add','edit','delete'],

            // ================= DEPARTMENT =================
            'Department' => ['add','edit','delete'],

            // ================= ROLE =================
            'Role' => ['add','edit','delete'],

            // ================= PERMISSION =================
            'Permission' => ['add','edit','delete'],

            // ================= ASSIGN PERMISSION =================
            'RolePermission' => ['view','add','edit','delete'],

            // ================= GROUP =================
            'Group' => ['view','add','edit','delete'],

            // ================= TASK =================
            'Task' => ['view','add','edit','delete','change_status'],

            // ================= TICKET =================
            'Ticket' => ['view','add','edit','delete','change_status'],

            // ================= OPTIONAL STATIC =================
            'Production' => ['view'],
            'Packing' => ['view'],
        ];

        foreach ($modules as $module => $actions) {

            foreach ($actions as $action) {

                $slug = strtolower($module . '_' . $action);

                Permission::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $module . ' ' . ucfirst(str_replace('_',' ', $action)),
                        'module' => $module,
                        'action' => $action,
                        'user_id' => 20
                    ]
                );
            }
        }
    }
}