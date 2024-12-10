<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title"><?= $list; ?></h4>
            </div>
            <div class="panel-body">
                <div class="tabs-container">
                    <ul id="mytab" class="nav nav-tabs">
                        <li class="link_tab" id="group_tab"><a href="#tab1" data-toggle="tab"> Group</a></li>  
                        <li class="link_tab" id="user_tab"><a href="#tab2" data-toggle="tab"> User</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab1" class="tab-pane"></div>
                        <div id="tab2" class="tab-pane"></div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        // tabs
        $('#mytab a:first').tab('show');
        my_ajax('<?= base_url("sistem/group_user") ?>','#tab1');
        $(document).on('click','.link_tab',function() {
            var tab_id = $(this).attr('id');
            switch(tab_id){
                case 'group_tab':
                    if($('#tab1').html()== ''){
                        my_ajax('<?= base_url("sistem/group_user") ?>','#tab1');
                    }
                break;

                case 'user_tab':
                    if($('#tab2').html()== ''){
                        my_ajax('<?= base_url("sistem/users") ?>','#tab2');
                    }
                break;

                
            }

            
             return false;
        });
    });

    function paging(page, tab){
        switch(tab){
            case 1:
                get_list_group_user(page);
                $('#page_now_group').val(page);
            break;

            case 2:
                get_list_user(page);
                $('#page_now').val(page);
            break;

            default:

            break;
        }


    }
</script>