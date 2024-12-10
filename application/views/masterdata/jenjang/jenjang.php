<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <!-- <div class="panel-heading clearfix">
                <h4 class="panel-title"><?=$list;?></h4>
            </div> -->
            <div class="panel-body">
                <div class="tabs-container">
                    <ul id="mytab" class="nav nav-tabs">
                        <li class="link_tab" id="pendidikan_tab"><a href="#tab1" data-toggle="tab"> Pendidikan</a></li>
                        <li class="link_tab" id="pekerjaan_tab"><a href="#tab2" data-toggle="tab"> Pekerjaan</a></li>
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
        my_ajax('<?=base_url("masterdata/pendidikan")?>','#tab1');
        $(document).on('click','.link_tab',function() {
            var tab_id = $(this).attr('id');
            switch(tab_id){
                case 'pendidikan_tab':
                    if($('#tab1').html()== ''){
                        my_ajax('<?=base_url("masterdata/pendidikan")?>','#tab1');
                    }
                break;

                case 'pekerjaan_tab':
                    if($('#tab2').html()== ''){
                        my_ajax('<?=base_url("masterdata/pekerjaan")?>','#tab2');
                    }
                break;

            }


             return false;
        });
    });

    function paging(page, tab){
        switch(tab){
            case 1:
                get_list_pendidikan(page);
                $('#page_now_pendidikan').val(page);
            break;

            case 2:
                get_list_pekerjaan(page);
                $('#page_now_pekerjaan').val(page);
            break;

            default:

            break;
        }


    }
</script>