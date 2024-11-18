<?php
    if (isset($_GET["assetDel"])) {
        echo '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event){
            new bootstrap.Modal("#delModal").show();
        });
    </script>';
    }   
?>
<div class="py-5">
    <div id="scrollableArea" class="container overflow-hidden overflow-y-scroll" data-simplebar>
        <div class="border rounded-5 border-3 overflow-hidden theme-bg-sec theme-text theme-border">
            <div class="px-3 pt-1 border-bottom border-3 theme-border d-flex justify-content-between align-items-center">
                <h3 class="theme-text">Assets</h3>
                <a href="/assets/new" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add a New Asset"><?= $icons->getIcon('plus-circle') ?></a>
            </div>
            <div id="search" class="container py-3 border-bottom border-3 theme-border">
                <form method="get">
                    <?php
                        $qString = explode("&",str_replace("search=" . $_GET["search"],"",$_SERVER["QUERY_STRING"]));
                        foreach($qString as $qItem) {
                            $qItem = explode("=",$qItem);
                            echo '<input type="hidden" name="' . $qItem[0] . '" value="' . $qItem[1] . '">';
                        }
                    ?>
                    <div class="input-group mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="search" id="search" value="<?=$_GET["search"]?>">
                            <label for="search">Search.:</label>
                        </div>
                        <button type="submit" class="btn btn-primary" type="button">Search</button>
                    </div>
                </form>   
            </div>
            <div class="overflow-y-auto px-0 border-3 border-bottom theme-border">
                <table class="table table-bordered mb-0 theme-border">
                    <thead>
                        <tr class="d-flex">
                            <th scope="col" class="col-2 text-center theme-bg-sec theme-text">Name</th>
                            <th scope="col" class="col-2 text-center theme-bg-sec theme-text">Author</th>
                            <th scope="col" class="col-2 text-center theme-bg-sec theme-text">Asset Category</th>
                            <th scope="col" class="col-2 text-center theme-bg-sec theme-text">Related Base</th>
                            <th scope="col" class="col-4 text-center theme-bg-sec theme-text">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach (getAssetsIds($query) as $assetId) {
                                echo '<tr class="d-flex">';
                                echo '<th scope="row" class="d-flex align-items-center col-2 theme-text theme-bg-sec"><a class="text-decoration-none theme-text" href="/assets/show?assetId=' . $assetId . '">' . getAssetName($assetId) . '</a></th>';
                                echo '<td class="d-flex align-items-center col-2 theme-text theme-bg-sec">' . getAssetAuthorName($assetId) . '</td>';
                                echo '<td class="d-flex align-items-center col-2 theme-text theme-bg-sec">' . getAssetCategory($assetId)["name"] . '</td>';
                                if (getAssetRelBaseId($assetId) != "createNew") {
                                    echo '<th class="d-flex align-items-center col-2 theme-text theme-bg-sec"><a class="text-decoration-none theme-text" href="/assets/show?assetId=' . getAssetRelBaseId($assetId) . '">' . getAssetName(getAssetRelBaseId($assetId)) . '</a></th>';
                                } else {
                                    echo '<td class="d-flex align-items-center col-2 theme-text theme-bg-sec"><a class="text-decoration-none theme-text" href="/assets/show?assetId=' . $assetId . '">It is a base</a></td>';
                                }
                                ?>
                                    <td class="col-5 col-md-4 d-flex justify-content-evenly align-items-center theme-bg-sec">
                                        <a href="/assets/show/?assetId=<?=$assetId?>" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="See Asset"><?= $icons->getIcon('eye') ?></a>
                                        <a href="/upload/?assetId=<?=$assetId?>" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Upload File to Asset"><?= $icons->getIcon('upload') ?></a>
                                        <a href="/assets/edit/?assetId=<?=$assetId?>" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Asset"><?= $icons->getIcon('edit') ?></a>
                                        <a href="?assetId=<?=$assetId?>&assetDel" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Asset"><?= $icons->getIcon('trash-2') ?></a>
                                    </td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 text-center">
                <h4 class="theme-text">If Your seeing this, You need More Assets!! ;)</h4>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content theme-bg">
            <div class="modal-header">
                <h1 class="modal-title fs-5 theme-text" id="delModalLabel">Are You sure You want to Delete the "<?=getAssetName($_GET["assetId"]) ?>" Asset?</h1>
            </div>
            <div class="modal-body theme-text">Deleting an Asset will Erase All Data and Files associated with it!!<br>If the Asset is a Base, Don't Forget to Desassociate the Assets related to It!!</div>
            <div class="modal-footer">
                <a href="<?=$request?>" class="btn btn-secondary">Cancel</a>
                <form method="post">
                    <input type="hidden" name="assetId" value="<?=$_GET['assetId']?>">
                    <button type="submit" name="deletionConfirmed" class="btn btn-primary">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/Resources/js/scrollableArea.js"></script>