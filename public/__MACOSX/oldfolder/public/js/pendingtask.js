/* POPUP */

const popup = document.getElementById("popup");
const board = document.getElementById("board");
const saveTask = document.getElementById("saveTask");

let currentList = null;

/* OPEN POPUP */

document.addEventListener("click",(e)=>{

    if(e.target.closest(".add-task")){

        popup.style.display = "flex";

        currentList = e.target
        .closest(".task-list")
        .querySelector(".list");

    }

});

/* CLOSE POPUP */

document.querySelectorAll(".close").forEach(btn=>{

    btn.addEventListener("click",()=>{

        popup.style.display = "none";

    });

});

/* SAVE TASK */

saveTask.addEventListener("click",()=>{

    const title = document.getElementById("taskTitle").value;
    const desc = document.getElementById("taskDesc").value;
    const priority = document.getElementById("taskPriority").value;

    if(title === ""){

        alert("Please Enter Task Title");
        return;

    }

    const task = document.createElement("li");

    task.classList.add("task-item");

    task.innerHTML = `

        <span class="task-item-close">
            <i class="fa-solid fa-xmark"></i>
        </span>

        <h4>${title}</h4>

        <p>${desc}</p>

        <button class="view-btn">
            <i class="fa-solid fa-eye"></i>
            View
        </button>

        <span class="status ${priority}">
            ${priority}
        </span>

    `;

    currentList.prepend(task);

    popup.style.display = "none";

    document.getElementById("taskForm").reset();

});

/* DELETE TASK */

document.addEventListener("click",(e)=>{

    if(e.target.closest(".task-item-close")){

        e.target.closest(".task-item").remove();

    }

});

/* DELETE BOARD */

document.addEventListener("click",(e)=>{

    if(e.target.closest(".task-close")){

        if(confirm("Delete This Board ?")){

            e.target.closest(".task-list").remove();

        }

    }

});

/* ADD NEW BOARD */

document.querySelector(".add-task-board").addEventListener("click",()=>{

    let boardName = prompt("Enter Board Name");

    if(boardName === "" || boardName === null){

        return;

    }

    const newBoard = document.createElement("div");

    newBoard.classList.add("task-list");

    newBoard.innerHTML = `

        <div class="header">

            <h2>${boardName}</h2>

            <div class="d-flex">

                <button class="add-task">
                    <i class="fa-solid fa-plus"></i>
                </button>

                <button class="task-close">
                    <i class="fa-solid fa-trash"></i>
                </button>

            </div>

        </div>

        <ul class="list"></ul>

    `;

    board.insertBefore(
        newBoard,
        document.querySelector(".btn-board")
    );

});

