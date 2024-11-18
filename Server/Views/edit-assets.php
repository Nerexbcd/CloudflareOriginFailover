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
                <h3 class="theme-text">Edit Asset</h3>
                <h3 class="theme-text">Asset <?=$_GET["assetId"]?></h3>
            </div>
            <form name="editForm" method="post" class="needs-validation special-validation check-base" novalidate>
                <div class="px-3 pt-3 border-bottom border-3 theme-border">
                    <div class="row mb-0">
                        <div class="col-md mb-3">
                            <div class="form-floating has-validation">
                                <input type="text" name="assetName" id="assetName" class="form-control" value="<?=getAssetName($_GET["assetId"]) ?>" required>
                                <label for="assetName">Name of the Asset:</label>
                                <div class="invalid-feedback">You must set the Asset Name!!</div>
                            </div>
                        </div>
                        <div class="col-md mb-3">
                            <div class="form-floating has-validation">
                                <input type="text" name="assetAuthor" id="assetAuthor" class="form-control" value="<?=getAssetAuthorName($_GET["assetId"]) ?>" required>
                                <label for="assetAuthor">Author of the Asset:</label>
                                <div class="invalid-feedback">You must set the Asset Author Name!!</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating has-validation mb-3">
                        <input type="url" name="urlRef" id="urlRef" class="form-control" value="<?=getAssetUrlRef($_GET["assetId"]) ?>">
                        <label for="urlRef">Url of Reference:</label>
                        <div class="invalid-feedback">You must set a valid URL!!</div>
                    </div>
                </div>
                <div class="px-3 pt-3 pb-0 border-bottom border-3 theme-border">
                    <div class="row mb-0">
                        <div class="col-md">
                            <h5 class="theme-text mb-3">Asset Category:</h5>
                            <div class="has-validation form-floating mb-3">
                                <select name="category" id="category" class="form-control" autocomplete="off" placeholder='Select the Asset Category' required onchange="CheckBase('editForm')" disabled>
                                    <option value=''>Select the Asset Category</option>
                                    <?php
                                        foreach(getAssetCategories() as $categoryId => $categoryName) {
                                            echo "<option value='" . $categoryId . "'>" . $categoryName . "</option>";
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback">You must Select an Asset Category!!</div>
                            </div>
                        </div>
                        <div class="col-md">
                            <h5 class="theme-text mb-3">Related Bases:</h5>
                            <div class="form-floating mb-3">
                                <select name="relBase" id="relBase" class="form-control" autocomplete="off" placeholder='Select the related Base' required>
                                    <option value=''>Select the related Base</option>
                                    <?php
                                        foreach(getAssetsAvatarBases() as $assetId => $assetName) {
                                            echo "<option value='" . $assetId . "'>" . $assetName . "</option>";
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback">You must Select an Related Base!!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-3 pt-3 border-bottom border-3 theme-border">
                    <h5 class="theme-text mb-3">Asset Image:</h5>
                    <div class=" has-validation form-floating mb-3">
                        <input type="url" name="urlImg" id="urlImg" class="form-control" value="<?=(getAssetImg($_GET["assetId"]) == '/Data/public/default/file_asset.png') ? '' : getAssetImg($_GET["assetId"]) ?>">
                        <label for="urlImg">Image Url:</label>
                        <div class="invalid-feedback">You must set a valid URL!!</div>
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="fileImg">
                    </div>
                </div>
                <div class="p-3 clearfix">  
                    <div class="btn-group float-end">
                        <a href="/assets" class="btn btn-secondary">Cancel</a>
                        <input class="btn btn-primary" type="submit" value="Update" id="sbm-bt" name="update">
                    </div>
                </div>
            </form>
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
                    <a href="/" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Chose</button >
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event){
        select = new TomSelect("#relBase",{
            plugins: ['dropdown_input'],
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        if ("<?=getAssetRelBaseId($_GET["assetId"]) ?>" == "createNew") {
            select.addOption({value:"createNew", text:"Create New"});
            select.addItem("createNew"); 
            select.disable();
        } else {
            select.addItem("<?=getAssetRelBaseId($_GET["assetId"]) ?>")
        }



        

        select2 = new TomSelect("#category",{
            plugins: ['dropdown_input'],
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        select2.addItem(<?=getAssetCategory($_GET["assetId"])["id"] ?>)
    })
</script>

<script src="/Resources/js/scrollableArea.js"></script>