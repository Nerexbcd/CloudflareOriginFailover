
function CheckBase(_formName) {
    var isBase = (document.forms[_formName]["category"].tomselect.items[0] == 1);
    if (isBase) { 
        document.forms[_formName]["relBase"].tomselect.addOption({value:"createNew", text:"Create New"});
        document.forms[_formName]["relBase"].tomselect.addItem("createNew"); 
        document.forms[_formName]["relBase"].tomselect.disable();
    } else {
        document.forms[_formName]["relBase"].tomselect.enable();
        document.forms[_formName]["relBase"].tomselect.removeOption("createNew");
    }
}

function CheckFileType() {
    var subspFileType = document.getElementById("subspFileType")
    var unityFileType = document.getElementById("unityFileType")
    var blenderFileType = document.getElementById("blenderFileType")
    var packFileType = document.getElementById("packFileType")
    var othersFileType = document.getElementById("othersFileType")
    var howto = !(subspFileType.checked||unityFileType.checked||blenderFileType.checked||packFileType.checked||othersFileType.checked);
    subspFileType.required = howto;
    unityFileType.required = howto;
    blenderFileType.required = howto;
    packFileType.required = howto;
    othersFileType.required = howto;
    if (howto) {document.getElementById("CheckFileTypeInvalid").style.display = "block"} else {document.getElementById("CheckFileTypeInvalid").style.display = "none"}
}