@php
$config = $config ?? [];
$isAdminUser = in_array($roleSlug, ['super-admin', 'admin']);
@endphp

{{-- ================= Graph Section Start================= --}}
   
<div class="row mt-2">

    {{-- LEFT : TASK GRAPH --}}
    @if(data_get($config, 'task_module.chart') == true)
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card graph-card">

            {{-- Top Row --}}
            <div class="graph-head-line">
                <div class="graph-title">
                    <i class="fa fa-tasks text-primary mr-2"></i>
                    Task Analytics
                </div>

                <div class="graph-right-filter">
                   <select class="graph-select task-filter" name="task_filter">
                    <option value="day" {{ request('task_filter')=='day'?'selected':'' }}>Day Wise</option>
                    <option value="month" {{ request('task_filter','month')=='month'?'selected':'' }}>Month Wise</option>
                    <option value="year" {{ request('task_filter')=='year'?'selected':'' }}>Year Wise</option>
                </select>
                
                @if(in_array($roleSlug, ['super-admin','admin']))

                <select class="graph-select task-user" name="task_user_id">
                    <option value="">All Users</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('task_user_id')==$u->id?'selected':'' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
                @endif
                </div>
            </div>

            {{-- Graph --}}
           <div class="chart-box position-relative">

            <canvas id="taskChart"></canvas>
        
            <div id="taskNoData"
                 class="no-chart-data d-none">
                No Task Found
            </div>
        
        </div>

        </div>
    </div>
    @endif



    {{-- RIGHT : TICKET GRAPH --}}
    @if(data_get($config, 'ticket_module.chart') == true)
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card graph-card">

            {{-- Top Row --}}
            <div class="graph-head-line">
                <div class="graph-title">
                    <i class="fa fa-ticket text-warning mr-2"></i>
                    Ticket Analytics
                </div>

                <div class="graph-right-filter">
                <select class="graph-select ticket-filter" name="ticket_filter">
                <option value="day" {{ request('ticket_filter')=='day'?'selected':'' }}>Day Wise</option>
                <option value="month" {{ request('ticket_filter','month')=='month'?'selected':'' }}>Month Wise</option>
                <option value="year" {{ request('ticket_filter')=='year'?'selected':'' }}>Year Wise</option>
            </select>
            
            @if(in_array($roleSlug, ['super-admin','admin']))
             <select class="graph-select ticket-user" name="ticket_user_id">
                <option value="">All Users</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('ticket_user_id')==$u->id?'selected':'' }}>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
            @endif
                </div>
            </div>

            {{-- Graph --}}
            <div class="chart-box position-relative">

            <canvas id="ticketChart"></canvas>
        
            <div id="ticketNoData"
                 class="no-chart-data d-none">
                No Ticket Found
            </div>
        
        </div>
            

        </div>
    </div>
    @endif

</div>