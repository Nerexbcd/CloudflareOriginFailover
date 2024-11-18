function maxSizingAlbumArea() {
    var header = document.getElementsByTagName("header")[0];
    var search = document.getElementById("search");
    var scrollableArea = document.getElementById("scrollableArea");
    scrollableArea.style.maxHeight = "calc(100vh - (" + header.offsetHeight + "px + 6rem + " + search.offsetHeight + "px))";
}

maxSizingAlbumArea()