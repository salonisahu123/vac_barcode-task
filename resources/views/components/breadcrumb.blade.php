<div class="row column_title mb-4" style="margin-top:20px;">
    <div class="col-md-12">

        <div class="custom-breadcrumb-box d-flex justify-content-between align-items-center">

            <!-- 🔹 LEFT SIDE (TITLE) -->
           <!-- LEFT TITLE -->
            <div>
                <h3 class="mb-0" style="font-weight:600;">
                    {{ $title }}
                </h3>
                <small class="text-muted">
                    Manage your {{ strtolower($page) }}
                </small>
            </div>

            <!-- 🔹 RIGHT SIDE (BREADCRUMB) -->
            <nav>
                <ol class="breadcrumb mt-5 mb-0 bg-transparent p-0 align-items-center">

                    <li class="breadcrumb-item">
                        @php
    $employee = \App\Models\Employee::where('user_id', auth()->id())->first();

    $dashboardId = null;

    if ($employee) {
        $dashboardId = DB::table('employee_dashboards')
            ->where('employee_id', $employee->id)
            ->value('dashboard_id');
    }
@endphp

<a href="{{ auth()->user()->role_id == 1
        ? route('tasks.pending')
        : ($dashboardId
            ? route('dashboard.render', $dashboardId)
            : route('tasks.index')) }}">
    <i class="fa fa-home"></i>
</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="#">{{ $title }}</a>
                    </li>

                    <li class="breadcrumb-item active">
                        {{ $page }}
                    </li>

                </ol>
            </nav>

        </div>

    </div>
</div>
