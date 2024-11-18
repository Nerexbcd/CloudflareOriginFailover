<?php
    if (!isset($_GET["assetId"])) {
        echo '<script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function(event){
                new bootstrap.Modal("#formAssetIdChoice").show()
            });
        </script>';
    }
?>

<div class="py-5">
    <div id="scrollableArea" class="container overflow-hidden overflow-y-scroll" data-simplebar>
        <div class="border rounded-5 border-3 overflow-hidden theme-bg-sec theme-text theme-border">
            <div class="px-3 pt-1 border-bottom border-3 theme-border d-flex justify-content-between align-items-center">
                <h3 class="theme-text">Asset Files Upload</h3>
                <h3 class="theme-text">Asset <?=$_GET["assetId"]?></h3>
            </div>
            <?php if(isset($_GET['assetId'])) {?>
                <div class="overflow-hidden position-relative">
                    <div class="ratio ratio-16x9" alt="Asset Image" style="background-image: url(<?=getAssetImg($_GET["assetId"])?>); background-size: cover; background-position: center; filter: blur(8px); -webkit-filter: blur(8px);"></div>
                    <div class="ratio ratio-16x9 position-absolute top-0 start-0 overflow-hidden">
                        <img src="<?=getAssetImg($_GET["assetId"])?>" alt="" class="object-fit-contain">
                    </div>
                </div>
            <?php }?>

            <div class="p-2 pt-1 border-bottom border-3 theme-border <?=isset($_GET['assetId']) ? 'border-top' : '' ?>">
                <h2 class="mb-0"><?=getAssetName($_GET["assetId"])?></h2>
                <h5 class="mb-1">Author: <?=getAssetAuthorName($_GET["assetId"])?></h5>
                <h6 class="mb-0"><?=showAssetTags($_GET["assetId"]);?></h6>
            </div>
                <div class="p-3 border-bottom border-3 theme-border">  
                    <h5 class="theme-text mb-3">Upload Files:</h5>              
                    <div class="w-full border border-2 theme-border rounded-3 theme-bg-ter overflow-hidden">
                        <table class="table theme-border mb-0">
                            <thead>
                                <tr class="d-flex">
                                    <th scope="col" class="col-6 theme-bg-ter theme-text">Filename</th>
                                    <th scope="col" class="col-3 theme-bg-ter theme-text">Size</th>
                                    <th scope="col" class="col-3 theme-bg-ter theme-text">Percentage</th>
                                </tr>
                            </thead>
                            <tbody id="filelist">
                            </tbody>
                        </table>
                        <a id="pickfiles" class="theme-text" href="javascript:;"><div class="w-full h-full d-flex justify-content-center align-items-center py-2"><?= $icons->getIcon('file-plus') ?>Add Files</div></a>
                    </div>


                </div>
                <div class="p-3 clearfix">  
                    <div class="btn-group float-end">
                        <a href="<?=$_SERVER['HTTP_REFERER'] ?>" class="btn btn-secondary">Cancel</a>
                        <button id="uploadfiles" onclick="toggleUpload()" class="btn btn-success">Start Upload</button>
                        <button id="next" class="btn btn-primary" onclick="location.href = '/upload/process?assetId=<?=$_GET["assetId"]?>';" disabled>Next</button>
                    </div>
                </div>
        </div>
</div>

<div class="modal fade" id="formAssetIdChoice" data-bs-backdrop="static" data-bs-keyboard="false"  aria-labelledby="formAssetIdChoiceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content theme-bg">
            <div class="modal-header">
                <h1 class="modal-title fs-5 theme-text" id="formAssetIdChoiceLabel">Choose the Asset You want to Upload Files to:</h1>
            </div>
            <form method="get">
                <div class="modal-body theme-text">
                    <select name="assetId" id="assetIdChoice" class="form-control" placeholder="Select a asset..." autocomplete="off">
                        <?php
                            foreach(getAssets() as $assetId => $assetName) {
                                echo "<option value='" . $assetId . "'>" . $assetName. "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <a href="<?=$_SERVER['HTTP_REFERER'] ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Chose</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/Resources/js/plupload.full.min.js"></script>

<script>
    function toggleUpload() {
        var btn = document.getElementById('uploadfiles');
        if (uploader.state == plupload.STOPPED) {
            uploader.start();
            btn.innerHTML = 'Stop Upload';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-danger');


        } else {
            uploader.stop();
            btn.innerHTML = 'Start Upload';
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-success');
        }
        
    }

    document.addEventListener("DOMContentLoaded", function(event){
        select = new TomSelect("#assetIdChoice",{
            plugins: ['dropdown_input'],
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    })

    var uploader = new plupload.Uploader({
        // General settings
        runtimes : 'html5,browserplus,silverlight,flash,gears,html4',
        browse_button : 'pickfiles', // you can pass in id...
        url : '/upload/sys-rec?assetId=<?=$_GET["assetId"]?>',
        chunk_size : '1mb',
        unique_names : false,
        multiple_queues : true,

        filters : {
            max_file_size : '8192mb',
        },

        flash_swf_url : '/Resources/other/Moxie.swf',
        silverlight_xap_url : '/Resources/other/Moxie.xap', 

        init: {
            // PostInit: function() {
            // },

            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    document.getElementById('filelist').innerHTML += '<tr class="d-flex" id="' + file.id + '"><td scope="col" class="col-6 theme-bg-ter theme-text">' + file.name + '</td><td scope="col" class="col-3 theme-bg-ter theme-text">' + plupload.formatSize(file.size) + '</td><td id="percent-' + file.id + '" scope="col" class="col-3 theme-bg-ter theme-text">0%</td></tr>';
                });
            },

            UploadProgress: function(up, file) {
                document.getElementById("percent-" + file.id).innerHTML = file.percent + "%";
            },

            UploadComplete: function(up, files) {
                document.getElementById("next").disabled = false;
            },

        }
    });

    uploader.init();

</script>

<script src="/Resources/js/scrollableArea.js"></script>