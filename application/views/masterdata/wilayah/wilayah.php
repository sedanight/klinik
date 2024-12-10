<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <!-- <div class="panel-heading clearfix">
                <h4 class="panel-title"><?= $list; ?></h4>
            </div> -->
            <div class="panel-body">
                <div class="tabs-container">
                    <ul id="mytab" class="nav nav-tabs">
                        <li class="link_tab" id="provinsi_tab"><a href="#tab1" data-toggle="tab"> Provinsi</a></li>  
                        <li class="link_tab" id="kabupaten_kota_tab"><a href="#tab2" data-toggle="tab"> Kabupaten/Kota</a></li>
                        <li class="link_tab" id="kecamatan_tab"><a href="#tab3" data-toggle="tab"> Kecamatan</a></li>
                        <li class="link_tab" id="kelurahan_tab"><a href="#tab4" data-toggle="tab"> Kelurahan</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab1" class="tab-pane"></div>
                        <div id="tab2" class="tab-pane"></div>
                        <div id="tab3" class="tab-pane"></div>
                        <div id="tab4" class="tab-pane"></div>
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
        my_ajax('<?= base_url("masterdata/provinsi") ?>','#tab1');
        $(document).on('click','.link_tab',function() {
            var tab_id = $(this).attr('id');
            switch(tab_id){
                case 'provinsi_tab':
                    if($('#tab1').html()== ''){
                        my_ajax('<?= base_url("masterdata/provinsi") ?>','#tab1');
                    }
                break;

                case 'kabupaten_kota_tab':
                    if($('#tab2').html()== ''){
                        my_ajax('<?= base_url("masterdata/kabupaten_kota") ?>','#tab2');
                    }
                break;

                case 'kecamatan_tab':
                    if($('#tab3').html()== ''){
                        my_ajax('<?= base_url("masterdata/kecamatan") ?>','#tab3');
                    }
                break;

                case 'kelurahan_tab':
                    if($('#tab4').html()== ''){
                        my_ajax('<?= base_url("masterdata/kelurahan") ?>','#tab4');
                    }
                break;

                
            }

            
             return false;
        });
    });

    function paging(page, tab){
        switch(tab){
            case 1:
                get_list_provinsi(page);
                $('#page_now_provinsi').val(page);
            break;

            case 2:
                get_list_kabupaten_kota(page);
                $('#page_now_kabupaten_kota').val(page);
            break;

            case 3:
                get_list_kecamatan(page);
                $('#page_now_kecamatan').val(page);
            break;

            case 2:
                // get_list_user(page);
                $('#page_now_kelurahan').val(page);
            break;

            default:

            break;
        }


    }
</script>