<script>

$(document).ready(function() {
    $('#todo_add').keydown(function (e){
        if(e.key === 'Enter') {
            // new todo item
            var todo_item = this.value; 
            var todo_action = 'add'; 
            
            $.ajax({
            type: 'POST',
                url: "<?php echo site_url('todo/create');?>",
                dataType: 'json',
                data: {todo_item, todo_action},
                success: function(response) {
                    $('#showdata_all').html(response.todo_html_all);
                    $('#showdata_act').html(response.todo_html_act);
                    $('#showdata_comp').html(response.todo_html_comp);
                    $('#act_count').html(response.todo_act_items);
                }
            });           
        }
    });

    $("#clear-all").click(function(){    
        var todo_action = 'remove_all'; 
            $.ajax({
            type: 'POST',
                url: "<?php echo site_url('todo/create');?>",
                dataType: 'json',
                data: {todo_action},
                success: function(response) {
                    $('#showdata_all').html(response.todo_html_all);
                    $('#showdata_act').html(response.todo_html_act);
                    $('#showdata_comp').html(response.todo_html_comp);
                    $('#act_count').html(response.todo_act_items);
                }
            }); 
    });
});

function Check(value) {

    var span_id = value.id;
    const span_id_Array = span_id.split("_");

    var item_id = span_id_Array[1];
    var item_status = span_id_Array[2];
    if(item_status == 0) {
        var item_checked = 1;
    } else {
        var item_checked = 0;
    }
        

    var todo_action = 'update'; 

    /*alert(item_id+'----'+ item_checked+'-----'+span_id+'---'+todo_action+'>>>'+value.id+'<<<'+value.class);
    if(item_checked == true){
        alert('am in');
        $('#'+span_id).removeClass('task-title');
        $('#'+span_id).addClass('complete-title');
    } else {
        $('#'+span_id).removeClass('complete-title');
        $('#'+span_id).addClass('task-title');
    }*/

    $.ajax({
    type: 'POST',
        url: "<?php echo site_url('todo/create');?>",
        dataType: 'json',
        data: {item_id, item_checked, todo_action},
        success: function(response) {
            $('#showdata_all').html(response.todo_html_all);
            $('#showdata_act').html(response.todo_html_act);
            $('#showdata_comp').html(response.todo_html_comp);
            $('#act_count').html(response.todo_act_items);
        }
    });
};

function Remove(value) {

var rspan_id = value.id;
const rspan_id_Array = rspan_id.split("_");

var ritem_id = rspan_id_Array[1];
   

var todo_action = 'remove'; 
//alert(rspan_id+'----'+ ritem_id+'-----'+todo_action);

$.ajax({
type: 'POST',
    url: "<?php echo site_url('todo/create');?>",
    dataType: 'json',
    data: {ritem_id, todo_action},
    success: function(response) {
        $('#showdata_all').html(response.todo_html_all);
        $('#showdata_act').html(response.todo_html_act);
        $('#showdata_comp').html(response.todo_html_comp);
        $('#act_count').html(response.todo_act_items);
    }
});
};

</script>
<div id="banner-image">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 title-div container d-flex align-items-center justify-content-center text-center h-100 ">
            TODO
            <button class="theme-btn light" onclick="setTheme('light')" title="Light mode">
                <img src="<?php echo base_url(); ?>images/icon-sun.svg" alt="sun">
            </button>
            <button class="theme-btn dark" onclick="setTheme('dark')" title="Dark mode">
                <img src="<?php echo base_url(); ?>images/icon-moon.svg" alt="moon">
            </button>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="card add-todo-card">
                    <div class="card-body">
                        <form >
                            <input type="text" class="form-control add-task" placeholder="Currently Typing" id="todo_add"/>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
    </br>
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="card todo-card">
                    <div class="card-body border-0 shadow">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                                <div class="todo-list" id="showdata_all">
                                    <?php foreach($todo_all as $kAll => $vAll){
                                        $all_span_id = 'complete-span_'.$vAll['todo_id'].'_'.$vAll['todo_status'];
                                        $remove_all_span_id = 'remove-span_'.$vAll['todo_id'];
                                    ?>
                                        <div class="todo-item">
                                            <div class="checker">
                                                <div class="dot-div">
                                                    <span class="dot">
                                                        <div class="<?php echo ($vAll['todo_status']== 0 ? 'complete-image' : 'active-image'); ?>"></div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="todo-item-div">
                                                <span id="<?php echo $all_span_id;?>" class="<?php echo ($vAll['todo_status']== 0 ? 'complete-title' : 'task-title'); ?>" onclick="Check(this)"><?php echo $vAll['todo_title']; ?></span>
                                            </div>
                                            <div class="checker">
                                                <div class="remove-div">
                                                    <span id="<?php echo $remove_all_span_id;?>"  onclick="Remove(this)">
                                                        <div class="remove-image"></div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>    
                            </div>
                            <div class="tab-pane fade" id="pills-act" role="tabpanel" aria-labelledby="pills-act-tab">
                                <div class="todo-list" id="showdata_act">
                                    <?php foreach($todo_act as $kAct => $vAct){
                                        $act_span_id = 'complete-span_'.$vAct['todo_id'].'_'.$vAct['todo_status'];
                                        $remove_act_span_id = 'remove-span_'.$vAct['todo_id'];
                                    ?>
                                        <div class="todo-item">
                                            <div class="checker">
                                                <div class="dot-div">
                                                    <span class="dot">
                                                        <div class="active-image"></div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="todo-item-div">
                                                <span id="<?php echo $act_span_id;?>" class="task-title" onclick="Check(this)"><?php echo $vAct['todo_title']; ?></span>
                                            </div>
                                            <div class="checker">
                                                <div class="remove-div">
                                                    <span id="<?php echo $remove_act_span_id;?>"  onclick="Remove(this)">
                                                        <div class="remove-image"></div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div> 
                            </div>
                            <div class="tab-pane fade" id="pills-comp" role="tabpanel" aria-labelledby="pills-comp-tab">
                                <div class="todo-list" id="showdata_comp">
                                    <?php foreach($todo_comp as $kComp => $vComp){
                                        $comp_span_id = 'complete-span_'.$vComp['todo_id'].'_'.$vComp['todo_status'];
                                        $remove_comp_span_id = 'remove-span_'.$vComp['todo_id'];    
                                    ?>
                                        <div class="todo-item">
                                            <div class="checker">
                                                <div class="dot-div">
                                                    <span class="dot">
                                                        <div class="complete-image"></div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="todo-item-div">
                                                <span id="<?php echo $comp_span_id;?>" class="complete-title" onclick="Check(this)"><?php echo $vComp['todo_title']; ?></span>
                                            </div>
                                            <div class="checker">
                                                <div class="remove-div">
                                                    <span id="<?php echo $remove_comp_span_id;?>"  onclick="Remove(this)">
                                                        <div class="remove-image"></div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div> 
                            </div>
                        </div>
                        </br>
                        <ul class="nav-tab-div nav nav-pills mb-3 nav-tabs-nostyle" id="pills-tab" role="tablist">
                            <div id="act_count" class="footer-div"><?php echo $todo_act_count; ?></div>&nbsp;
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active nav-item-div" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-item-div" id="pills-act-tab" data-bs-toggle="pill" data-bs-target="#pills-act" type="button" role="tab" aria-controls="pills-act" aria-selected="false">Active</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-item-div" id="pills-comp-tab" data-bs-toggle="pill" data-bs-target="#pills-comp" type="button" role="tab" aria-controls="pills-comp" aria-selected="false">Completed</button>
                            </li>
                            &nbsp;<div class="footer-div"><button class="clear-button" id="clear-all" type="button">Clear Completed</button></div>
                        </ul>    
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
            </div>
        </div>
    </div>
</div>