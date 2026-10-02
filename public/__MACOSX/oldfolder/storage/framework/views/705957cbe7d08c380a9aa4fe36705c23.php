

<?php $__env->startSection('title','Ticket Details'); ?>

<?php $__env->startSection('css'); ?>
<style>

/* ================= PAGE ================= */
.page-wrap{
    background:#eef2f7;
    padding:15px;
}

/* ================= LAYOUT ================= */
.ticket-grid{
    display:flex;
    gap:15px;
}

.left-panel{width:60%;}
.right-panel{
    width:40%;
    background:#fff;
    border-radius:14px;
    border:1px solid #e5e7eb;
    display:flex;
    flex-direction:column;
    height:85vh;
    overflow:hidden;
}

/* ================= CARD ================= */
.card-box{
    background:#fff;
    border-radius:12px;
    border:1px solid #e5e7eb;
    padding:15px;
    margin-bottom:12px;
}

/* ================= BADGE ================= */
.badge-soft{
    font-size:11px;
    padding:4px 10px;
    border-radius:20px;
}
.high{background:#fee2e2;color:#b91c1c;}
.medium{background:#fef3c7;color:#b45309;}
.low{background:#dbeafe;color:#1d4ed8;}

/* ================= CHAT HEADER ================= */
.chat-header{
    padding:12px 15px;
    background:linear-gradient(90deg,#dbeafe,#e0f2fe);
    font-weight:600;
    font-size:14px;
}

/* ================= CHAT BODY ================= */
.chat-body{
    flex:1;
    padding:12px;
    overflow-y:auto;

    /* WhatsApp style background */
    background:url("https://i.pinimg.com/236x/79/3d/f7/793df797732aaf145a0f8a40d7e92cc1.jpg");
    background-size:cover;
}

/* overlay for readability */
.chat-body::before{
    content:"";
    position:absolute;
}

.msg{
    max-width:70%;
    padding:8px 10px;
    font-size:13px;
    border-radius:10px;
    position:relative;
}

/* MY MESSAGE */
.me{
    background:#dcf8c6;
    margin-left:auto;
    border-radius:10px 10px 0 10px;
}

/* OTHER MESSAGE */
.other{
    background:#fff;
    margin-right:auto;
    border-radius:10px 10px 10px 0;
    border:1px solid #eee;
}

.avatar{
    width:30px;
    height:30px;
    border-radius:50%;
    object-fit:cover;
    margin-top:5px;
}

/* ================= TIME (WHATSAPP STYLE) ================= */
.msg small{
    display:block;
    text-align:right;
    font-size:10px;
    color:#6b7280;
    margin-top:3px;
}

/* ================= INPUT ================= */
.chat-footer{
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px;
    border-top:1px solid #eee;
    background:#fff;
}

.chat-footer input{
    flex:1;
    border-radius:20px;
    border:1px solid #ddd;
    padding:8px 12px;
    outline:none;
}

/* icons */
.icon-btn{
    width:38px;
    height:38px;
    border-radius:50%;
    background:#f3f4f6;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
}

.send-btn{
    background:#2563eb;
    color:#fff;
}

/* ================= AVATAR ================= */
.avatar{
    width:30px;
    height:30px;
    border-radius:50%;
    margin-right:6px;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

.info-item{
    background:#f9fafb;
    padding:10px 12px;
    border-radius:10px;
    border:1px solid #eee;
}

.info-item .label{
    display:block;
    font-size:11px;
    color:#6b7280;
    margin-bottom:3px;
}

.info-item .value{
    font-size:13px;
    font-weight:500;
    color:#111827;
}

.assign-box{
    display:flex;
    align-items:center;
    gap:10px;
    padding:8px 10px;
    background:#f9fafb;
    border-radius:10px;
    margin-bottom:8px;
}

.assign-box img{
    width:35px;
    height:35px;
    border-radius:50%;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 20px;
    margin-bottom:15px;

    background: linear-gradient(135deg, #acafb6, #b9bbc9);
    color:#fff;

    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.12);
    position:relative;
    overflow:hidden;
}

/* soft shine effect */
.page-header::after{
    content:"";
    position:absolute;
    top:-50%;
    right:-30%;
    width:200px;
    height:200px;
    background:rgba(255,255,255,0.15);
    transform:rotate(25deg);
    border-radius:50%;
}

.page-header h5{
    font-size:16px;
    font-weight:600;
    letter-spacing:0.3px;
}

.page-header small{
    display:block;
    font-size:12px;
    opacity:0.85;
    margin-top:2px;
}

.page-header span{
    font-size:12px;
    font-weight:600;
    letter-spacing:1px;

    background:rgba(255,255,255,0.18);
    border:1px solid rgba(255,255,255,0.25);
    backdrop-filter: blur(6px);

    padding:6px 14px;
    border-radius:30px;
}

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php if($isAdmin || hasPermission('ticket_view_all') || hasPermission('ticket_view_own')): ?>

<div class="page-wrap">
    
     
    <div class="page-header">
        <div>
            <h3 style="margin:0;">Ticket Details</h3>
            <small>Manage activity, assignment & chat</small>
        </div>
        <div>
            
        </div>
    </div>

<div class="ticket-grid">


<div class="left-panel">

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#overview">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#activities">Activities</a>
        </li>
    </ul>

    <div class="tab-content">

        
<div class="tab-pane fade show active" id="overview">

    <div class="card-box">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
            <h6 style="margin:0;">Ticket Overview</h6>

            <span class="badge badge-primary">
                <?php echo e(ucfirst($ticket->status)); ?>

            </span>
        </div>

        <div class="info-grid">

            <div class="info-item">
                <span class="label">Title</span>
                <span class="value"><?php echo e($ticket->title); ?></span>
            </div>

            <div class="info-item">
                <span class="label">Subject</span>
                <span class="value"><?php echo e($ticket->subject); ?></span>
            </div>

            <div class="info-item">
                <span class="label">Type</span>
                <span class="value"><?php echo e(ucfirst($ticket->ticket_type)); ?></span>
            </div>

            <div class="info-item">
                <span class="label">Priority</span>
                <span class="value">
                    <span class="badge-soft <?php echo e($ticket->priority=='high'?'high':($ticket->priority=='medium'?'medium':'low')); ?>">
                        <?php echo e(ucfirst($ticket->priority)); ?>

                    </span>
                </span>
            </div>

        </div>

    </div>


    

<div class="card-box">

    <h6 style="margin-bottom:12px;">Assigned To</h6>

    <div style="display:flex; align-items:center;">

        <?php
            $assignments = $ticket->assignments;
            $showLimit = 5;
        ?>

        <?php $__currentLoopData = $assignments->take($showLimit); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
                $emp = $assign->employee ?? null;

                $img = $emp && $emp->image
                    ? asset('uploads/employees/'.$emp->image)
                    : asset('uploads/employees/user.png');
            ?>

            <img src="<?php echo e($img); ?>"
                 title="<?php echo e($emp->user->name ?? 'Unknown'); ?>"
                 style="
                    width:40px;
                    height:40px;
                    border-radius:50%;
                    object-fit:cover;
                    border:2px solid #fff;
                    margin-left:-8px;
                    box-shadow:0 2px 5px rgba(0,0,0,0.1);
                    background:#fff;
                 ">

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($assignments->count() > $showLimit): ?>

            <div style="
                width:40px;
                height:40px;
                border-radius:50%;
                background:#e5e7eb;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:13px;
                font-weight:600;
                margin-left:6px;
                border:2px solid #fff;
            ">
                +<?php echo e($assignments->count() - $showLimit); ?>

            </div>

        <?php endif; ?>

    </div>

</div>


    
    <div class="card-box info-grid">

        <div class="info-item">
            <span class="label">Created By</span>
            <span class="value"><?php echo e($ticket->creator->name ?? '-'); ?></span>
        </div>

        <div class="info-item">
            <span class="label">Department</span>
            <span class="value"><?php echo e($ticket->department->dept_name ?? '-'); ?></span>
        </div>

        <div class="info-item">
            <span class="label">Location</span>
            <span class="value"><?php echo e($ticket->location->name ?? '-'); ?></span>
        </div>

        <div class="info-item">
            <span class="label">Created At</span>
            <span class="value"><?php echo e($ticket->created_at->format('d M Y h:i A')); ?></span>
        </div>

    </div>

</div>

      
       
<div class="tab-pane fade" id="activities">

    <div class="card-box">
        <h6>Activity Timeline</h6>
    </div>

    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
            // employee name resolve (assignment case)
            $empName = null;

            if($act->table_name == 'ticket_assignments') {
                $assign = \App\Models\TicketAssignment::with('employee.user')
                    ->find($act->table_id);

                $empName = $assign->employee->user->name ?? null;
            }
        ?>

        <div class="card-box" style="font-size:13px;">

            <div style="display:flex; gap:10px;">

                <div style="width:8px;height:8px;border-radius:50%;background:#2563eb;margin-top:6px;"></div>

                <div>

                    <b style="text-transform:capitalize;">
                        <?php echo e($act->operation); ?>

                    </b>

                    <div style="color:#374151;">
                        <?php if($empName): ?>
                            <?php echo e(str_replace('employee ID', $empName, $act->description)); ?>

                        <?php else: ?>
                            <?php echo e($act->description); ?>

                        <?php endif; ?>
                    </div>

                    <small style="color:#888;">
                        <?php echo e(\Carbon\Carbon::parse($act->created_at)->format('d M Y h:i A')); ?>

                    </small>

                </div>

            </div>

        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

    </div>

</div>



   <div class="right-panel">

    <div class="chat-header">
        💬 Ticket Chat
    </div>

    <div class="chat-body" id="chatBox">

     <?php $__currentLoopData = $ticket->comments->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php
    $isMe = $msg->user_id == auth()->id();

    $emp = $msg->user->employee ?? null;

    $avatar = $emp && $emp->image
        ? asset('uploads/employees/'.$emp->image)
        : asset('uploads/employees/user.png');
?>

<div class="d-flex mb-2 <?php echo e($isMe ? 'justify-content-end' : 'justify-content-start'); ?>">

    
    <?php if(!$isMe): ?>
        <img src="<?php echo e($avatar); ?>" class="avatar">
    <?php endif; ?>

    
   <div class="msg <?php echo e($isMe ? 'me' : 'other'); ?>">

    <small style="font-weight:600; display:block;">
        <?php echo e($msg->user->name ?? 'User'); ?>

    </small>

    <?php echo e($msg->comment); ?>


    <?php if($msg->attachment): ?>

<?php
$ext = pathinfo($msg->attachment, PATHINFO_EXTENSION);
?>

<?php if(in_array(strtolower($ext), ['jpg','jpeg','png'])): ?>
    <br>
    <img src="<?php echo e(asset('uploads/comments/'.$msg->attachment)); ?>"
         style="width:140px;border-radius:10px;margin-top:5px;">

<?php else: ?>

    <br>

    <div style="
        background:#f1f3f4;
        padding:10px;
        border-radius:10px;
        display:flex;
        align-items:center;
        gap:10px;
        margin-top:5px;
        max-width:230px;
    ">

        <?php if(strtolower($ext) == 'pdf'): ?>
            <i class="fa fa-file-pdf-o"
               style="font-size:28px;color:red;"></i>

        <?php elseif(in_array(strtolower($ext), ['doc','docx'])): ?>
            <i class="fa fa-file-word-o"
               style="font-size:28px;color:#2563eb;"></i>

        <?php else: ?>
            <i class="fa fa-file-o"
               style="font-size:28px;color:#555;"></i>
        <?php endif; ?>

        <div style="flex:1;overflow:hidden;">

            <div style="
                font-size:12px;
                font-weight:600;
                white-space:nowrap;
                overflow:hidden;
                text-overflow:ellipsis;
            ">
                <?php echo e($msg->attachment); ?>

            </div>

            <a href="<?php echo e(asset('uploads/comments/'.$msg->attachment)); ?>"
               target="_blank"
               style="font-size:11px;color:#2563eb;">
               Open File
            </a>

        </div>

    </div>

<?php endif; ?>

<?php endif; ?>

    <small><?php echo e($msg->created_at->format('g:i A')); ?></small>

</div>

    
    <?php if($isMe): ?>
        <img src="<?php echo e($avatar); ?>" class="avatar">
    <?php endif; ?>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="chat-footer">

    <label class="icon-btn">
        <i class="fa fa-paperclip"></i>
        <input type="file" id="fileInput" style="display:none;">
    </label>

    <input type="text" id="message" placeholder="Type message...">

    <!-- FILE NAME SHOW HOGA -->
    <small id="fileNameShow" style="color:green; font-size:12px;"></small>

    <div class="icon-btn send-btn" id="sendBtn">
        <i class="fa fa-paper-plane"></i>
    </div>

</div>

</div>



</div>
</div>

<?php else: ?>
<div class="alert alert-danger">No Permission</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>

function scrollBottom(){
    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
}
scrollBottom();

/* ================= SEND MESSAGE ================= */
$('#sendBtn').click(function(){
    
    let msg = $('#message').val();
    let file = $('#fileInput')[0].files[0];
    
    console.log("Message:", msg);
    console.log("File:", file); 
    let ticketId = "<?php echo e($ticket->id); ?>";

    if(msg.trim() == '' && !file) return;

    let formData = new FormData();
    formData.append('_token', "<?php echo e(csrf_token()); ?>");
    formData.append('comment', msg);

    if(file){
        formData.append('attachment', file);
    }

    $.ajax({
        url: "/ticket/" + ticketId + "/comment",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

success:function(res){

    $('#message').val('');
    $('#fileInput').val('');
    $('#fileNameShow').html('');

    let fileHtml = '';

    if(res.file){

        let ext = res.file.split('.').pop().toLowerCase();

        if(ext == 'jpg' || ext == 'jpeg' || ext == 'png'){

            fileHtml = `
                <br>
                <img src="${res.file}" 
                style="width:140px;border-radius:10px;margin-top:5px;">
            `;

        }else{

    let fileName = res.file.split('/').pop();

    fileHtml = `
        <br>
        <div style="
            background:#f1f3f4;
            padding:10px;
            border-radius:10px;
            display:flex;
            align-items:center;
            gap:10px;
            margin-top:5px;
            max-width:230px;
        ">
            <i class="fa fa-file-text-o" 
               style="font-size:28px;color:#2563eb;"></i>

            <div style="flex:1;overflow:hidden;">
                <div style="
                    font-size:12px;
                    font-weight:600;
                    white-space:nowrap;
                    overflow:hidden;
                    text-overflow:ellipsis;
                ">
                    ${fileName}
                </div>

                <a href="${res.file}" target="_blank"
                   style="font-size:11px;color:#2563eb;">
                   Open File
                </a>
            </div>
        </div>
    `;
}
    }

    $('#chatBox').append(`
        <div class="msg me">
            ${res.message ?? ''}
            ${fileHtml}
            <small>${res.time}</small>
        </div>
    `);

    scrollBottom();
}
    });

});

$('#fileInput').change(function () {
    console.log(this.files[0]);
});

$('#fileInput').change(function () {

    let file = this.files[0];

    if(file){

        let ext = file.name.split('.').pop().toLowerCase();

        // IMAGE FILE
        if(ext == 'jpg' || ext == 'jpeg' || ext == 'png'){

            let reader = new FileReader();

            reader.onload = function(e){

                $('#fileNameShow').html(`
                    <div style="display:flex;align-items:center;gap:8px;">
                        <img src="${e.target.result}" 
                             style="width:45px;height:45px;border-radius:8px;object-fit:cover;">
                        <span style="font-size:12px;">${file.name}</span>
                    </div>
                `);

            }

            reader.readAsDataURL(file);

        }

        // PDF FILE
        else if(ext == 'pdf'){

            $('#fileNameShow').html(`
                <div style="display:flex;align-items:center;gap:8px;">
                    <i class="fa fa-file-pdf-o" style="color:red;font-size:22px;"></i>
                    <span style="font-size:12px;">${file.name}</span>
                </div>
            `);

        }

        // DOC / DOCX
        else if(ext == 'doc' || ext == 'docx'){

            $('#fileNameShow').html(`
                <div style="display:flex;align-items:center;gap:8px;">
                    <i class="fa fa-file-word-o" style="color:blue;font-size:22px;"></i>
                    <span style="font-size:12px;">${file.name}</span>
                </div>
            `);

        }

        // OTHER FILE
        else{

            $('#fileNameShow').html(`
                <div style="display:flex;align-items:center;gap:8px;">
                    <i class="fa fa-file-o"></i>
                    <span style="font-size:12px;">${file.name}</span>
                </div>
            `);

        }

    }

});



</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/tickets/show.blade.php ENDPATH**/ ?>