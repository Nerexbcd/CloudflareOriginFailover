<div class="py-5" >
    <div id="search" class="container pb-3">
        <form method="get">
            <div class="input-group mb-2">
                <div class="form-floating">
                    <input type="text" class="form-control" name="search" id="search" value="">
                    <label for="search">Search.:</label>
                </div>
                <button type="submit" class="btn btn-primary" type="button">Search</button>
            </div>
        </form>   
    </div>
    <div id="scrollableArea" class="container overflow-hidden overflow-y-scroll" data-simplebar>
        <div id="assets" class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3 h-100 align-items-stretch">
        </div>
    </div>
</div>

<script src="/Resources/js/album.js"></script>

<script>
loadAssets()

function loadAssets() {
    fetch("/api/assets")
    .then(response => response.json())
    .then(data => {
        var table = document.querySelector("#assets");
        table.innerHTML = 
            '<div id="loading"  class="col placeholder-glow placeholder bg-transparent">' +
                '<div class="card shadow-sm theme-bg-sec overflow-hidden h-100">' +
                    '<div class="ratio ratio-16x9 bg-secondary bg-opacity-50 placeholder"></div>' +
                    '<div class="card-body theme-text theme-border border-top border-3" style=" max-height:fit-content;">' +
                        '<h5 class="mb-0 placeholder col-8"> </h5>' +
                        '<small class="theme-text placeholder col-5"> </small>' +
                        '<div class=" mt-1">' +
                            '<span class="badge text-bg-primary me-1 mb-1 placeholder w-25" style="height: 20px;"> </span>' +
                            '<span class="badge text-bg-primary me-1 mb-1 placeholder w-25" style="height: 20px;"> </span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        data['assets'].reverse().forEach(assetHId => {
            fetch("/api/assets/" + assetHId)
            .then(response => response.json())
            .then(asset => {
                table.innerHTML = 
                    '<div class="col">' +
                        '<a href="/assets/' + asset['humanId'] + '" class="text-decoration-none">' +
                            '<div class="card shadow-sm theme-bg-sec overflow-hidden h-100">' +
                                '<div class="overflow-hidden position-relative">' +
                                    '<div class="ratio ratio-16x9" style="background-image: url(' + asset['image']['url'] + '); background-size: cover; background-position: center; filter: blur(8px); -webkit-filter: blur(8px);"></div>' +
                                    '<div class="ratio ratio-16x9 position-absolute top-0 start-0">' +
                                        '<img src="' + asset['image']['url'] + '" alt="" class="object-fit-contain">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="card-body theme-text theme-border border-top border-3" style=" max-height:fit-content;">' +
                                    '<h5 class="mb-0">' + asset['name'] + '</h5>' +
                                    '<small class="theme-text">Author: ' + asset['author'] + '</small>' +
                                    '<div class="d-flex flex-wrap mt-1">' +
                                        '<span class="badge text-bg-primary me-1 mb-1">' + (asset['category']['id'] == 1 ? "Avatar Base" : asset['category']['name']) + '</span>' +
                                        '<span class="badge text-bg-primary me-1 mb-1">' + (asset['category']['id'] == 1 ? asset['name'] : asset['related']['name']) + '</span>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</a>' +
                    '</div>'+ table.innerHTML;
            })
            // .then(() => {
            //     document.getElementById('loading').classList.add('d-none');
            // });
        });
    });
}

</script>


