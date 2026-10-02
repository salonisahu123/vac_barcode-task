<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.dashboardEmployees = @json($users);
</script>
<script>

document.addEventListener("DOMContentLoaded", function () {

    /* ================= SAFE CANVAS CHECK ================= */
    const taskCanvas = document.getElementById('taskChart');
    const ticketCanvas = document.getElementById('ticketChart');

    if (!taskCanvas) console.log("Task canvas not found");
    if (!ticketCanvas) console.log("Ticket canvas not found");

    /* ================= COMMON CHART STYLE ================= */
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 10,
                    boxWidth: 10,
                    font: {
                        size: 12
                    }
                }
            }
        }
    };

    /* ================= TASK DATA ================= */
    const taskData = [
        {{ $taskStatus->pending ?? 0 }},
        {{ $taskStatus->in_progress ?? 0 }},
        {{ $taskStatus->completed ?? 0 }}
    ];

    const totalTaskSum = taskData.reduce((a,b)=>a+b,0);

    if (taskCanvas && totalTaskSum > 0) {

        const taskCtx = taskCanvas.getContext('2d');

        new Chart(taskCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'In Progress', 'Completed'],
                datasets: [{
                    data: taskData,
                    backgroundColor: ['#ef4444','#f59e0b','#22c55e'],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: commonOptions
        });

    } else if (taskCanvas) {
        taskCanvas.style.display = 'none';

        const taskNoData = document.getElementById('taskNoData');
        if(taskNoData){
            taskNoData.classList.remove('d-none');
        }
    }

    /* ================= TICKET DATA ================= */
    const ticketData = [
        {{ $ticketStatus->pending ?? 0 }},
        {{ $ticketStatus->in_progress ?? 0 }},
        {{ $ticketStatus->hold ?? 0 }},
        {{ $ticketStatus->close_request ?? 0 }},
        {{ $ticketStatus->closed ?? 0 }},
        {{ $ticketStatus->reopen ?? 0 }},
        {{ $ticketStatus->assigned ?? 0 }}
    ];

    const totalTicketSum = ticketData.reduce((a,b)=>a+b,0);

    if (ticketCanvas && totalTicketSum > 0) {

        const ticketCtx = ticketCanvas.getContext('2d');

        new Chart(ticketCtx, {
            type: 'doughnut',   // 👈 SAME TYPE FOR BOTH
            data: {
                labels: [
                    'Pending','In Progress','Hold',
                    'Close Request','Closed','Reopen','Assigned'
                ],
                datasets: [{
                    data: ticketData,
                    backgroundColor: [
                        '#ef4444','#f59e0b','#3b82f6',
                        '#a855f7','#22c55e','#14b8a6','#64748b'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: commonOptions
        });

    } else if (ticketCanvas) {
        ticketCanvas.style.display = 'none';

        const ticketNoData = document.getElementById('ticketNoData');
        if(ticketNoData){
            ticketNoData.classList.remove('d-none');
        }
    }

    /* ================= FILTER SYSTEM ================= */

    function submitGraphFilters() {

        let url = new URL(window.location.href);

        const task_filter = document.querySelector(".task-filter")?.value || '';
        const task_user_id = document.querySelector(".task-user")?.value || '';

        const ticket_filter = document.querySelector(".ticket-filter")?.value || '';
        const ticket_user_id = document.querySelector(".ticket-user")?.value || '';

        url.searchParams.set("task_filter", task_filter);
        url.searchParams.set("task_user_id", task_user_id);

        url.searchParams.set("ticket_filter", ticket_filter);
        url.searchParams.set("ticket_user_id", ticket_user_id);

        window.location.href = url.toString();
    }

    const taskFilter = document.querySelector(".task-filter");
    const taskUser = document.querySelector(".task-user");
    const ticketFilter = document.querySelector(".ticket-filter");
    const ticketUser = document.querySelector(".ticket-user");

    if (taskFilter) taskFilter.addEventListener("change", submitGraphFilters);
    if (taskUser) taskUser.addEventListener("change", submitGraphFilters);
    if (ticketFilter) ticketFilter.addEventListener("change", submitGraphFilters);
    if (ticketUser) ticketUser.addEventListener("change", submitGraphFilters);

    /* ================= FILTER RESET ================= */

    const filterType = document.getElementById("filterType");

    if (filterType) {
        filterType.addEventListener("change", function () {

            let url = new URL(window.location.href);

            url.searchParams.delete("location_id");
            url.searchParams.delete("department_id");

            url.searchParams.set("filter_type", this.value);

            window.location.href = url.toString();
        });
    }

});

</script>