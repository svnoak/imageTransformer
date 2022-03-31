document.querySelector("#submit-button").addEventListener("click", processRequest);
document.querySelector("#transparent-background-box").addEventListener("click", disableBgColor);
const processed = document.querySelector("#processed");
const total = document.querySelector("#total");
const modal = document.querySelector(".overlay");
const loadingBar = document.querySelector(".loading-bar-inner");

function disableBgColor(){
    let colorField = document.querySelector("#background-color");
    colorField.disabled == true ? colorField.disabled = false : colorField.disabled = true;
}

function toggleModal(){
    modal.classList.toggle("hidden");
}

function updateProgressModal(proc, tot){
    processed.innerText = proc;
    total.innerText = tot;
    loadingBar.style.width = proc / tot * 100 + "%";
}
async function getImages(){
    const response = await fetch( "../../api/products/images.php", {
        method: "GET"
    })
    return await response.json();
}

async function processRequest(){

    toggleModal();

    let background;
    const transparent = document.querySelector("#transparent-background-box").value;
    transparent ? background = "rgba(0, 0, 0, 0)" : background = document.querySelector("#background-color").value;

    let formValues = {
        channel: document.querySelector("#channel-name").value,
        height: document.querySelector("#image-height").value,
        width: document.querySelector("#image-width").value,
        background: background,
        extension: document.querySelector("#extensions").value,
        maxSize: document.querySelector("#max-size").value,
        singles: document.querySelector("#singlefiles").value
    }

    let imagePaths;

    if( formValues.singles == "" ){
        imagePaths = await getImages();
    }else{
      imagePaths = formValues.singles.split("\n");
    }

    let chunks = splitArrayIntoChunksOfLen(imagePaths, 7);
    
    let totalLength = chunks.length
    let progress = 0;

    total.innerText = totalLength;

    for( let i = 0;  i < totalLength; i++ ){
        progress += 1;
        updateProgressModal(progress, totalLength);
        let chunk = chunks[i];
        const result = await createNewImages(chunk, formValues);
    }

    toggleModal();

}

async function createNewImages(chunk, formValues){
    const body = {
        images: chunk,
        settings: formValues
    }

    const response = await fetch( "../../api/products/images.php", {
        method: "POST",
        body: JSON.stringify(body)
    })

}

function splitArrayIntoChunksOfLen(arr, len) {

    let chunks = [], i = 0, n = arr.length;
    while (i < n) {
      chunks.push(arr.slice(i, i += len));
    }
    return chunks;
}
