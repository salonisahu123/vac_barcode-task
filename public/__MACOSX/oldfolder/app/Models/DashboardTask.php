<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardTask extends Model
{
    use HasFactory;

    protected $table = 'dashboard_tasks';

    protected $fillable = [
        'user_id',
        'in_production',
        'work_in_shop_floor',
        'under_qc_project',
        'rfd_without_dc',
        'rfd_with_dc',
        'ranjitha_follow_up',
        'quotation_pending_for_approval',
        'so_approval_pending',
        'so_approved_list',
        'shop_floor_follow_up',
        'design_follow_up',
        'customer_drawings_clarification',
        'pending_design_by_harshil_sir',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // 👉 User relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 👉 Task relation (1 dashboard_task = 1 task)
    public function task()
    {
        return $this->hasOne(Task::class, 'dashboard_task_id ');
    }
}