function displayList(id){
    const targetDiv = document.getElementById(id);
    if (targetDiv.style.display !== "none") {
        targetDiv.style.display = "none";
    } else {
        targetDiv.style.display = "block";
    }
}
