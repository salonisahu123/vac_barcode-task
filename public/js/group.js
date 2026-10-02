function loadGroupEmployees(groupId)
{
    document.getElementById('employeeModalBody').innerHTML = "Loading...";

    fetch(`/groups/${groupId}/employees`)
        .then(res => res.json())
        .then(data => {

            let html = "";

            data.employees.forEach(emp => {
                html += `
                    <div style="padding:6px; border-bottom:1px solid #eee;">
                        👤 ${emp.name}
                    </div>
                `;
            });

            document.getElementById('employeeModalBody').innerHTML = html;

            new bootstrap.Modal(document.getElementById('employeeModal')).show();
        });
}