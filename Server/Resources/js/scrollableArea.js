var header = document.getElementsByTagName("header")[0]
var scrollableArea = document.getElementById("scrollableArea")
scrollableArea.style.maxHeight = "calc(100vh - (" + header.offsetHeight + "px + 6rem))";