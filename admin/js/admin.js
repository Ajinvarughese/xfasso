let logOut = document.getElementById('logOut');

logOut.addEventListener("click", ()=> {
    window.location.href = "./logout/logout.php";
})

let drop = document.getElementById('drop');
let showDrop = document.getElementById('showDrop');
setClicked = false;
drop.addEventListener('click', ()=> {

    if(setClicked === false){
        setClicked = true;
        showDrop.style.display = 'block';
    }else {
        setClicked = false;
        showDrop.style.display = 'none';
    }
});

document.addEventListener('click', ()=> {
    if (!drop.contains(event.target) && !showDrop.contains(event.target)) {
        showDrop.style.display = 'none';
        setClicked = false;
    }
});




let workData = {}; 

fetch('work.json')
    .then(response => response.json())
    .then(data => {
        workData = data;
        displayWorkData();
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });

function displayWorkData() {
    let duties = document.getElementById('duties');

    let workTitle = document.getElementById('woekTitle');

    workData.forEach(work => {
        // Create a new div element for each work item
        let workDiv = document.createElement('div');
        workDiv.classList.add('work');
        workDiv.setAttribute('onclick', `goWork(${work.workID})`);
        workDiv.innerHTML = `
            <div class='ic'>
                <img src='./images/${work.workName}.png'>
            </div>
           <div class='content'>
                <h3>${setName(work.workName)}</h3>
                <p>
                    ${setComment(work.workName)}
                </p>
           </div>
        `;
        duties.appendChild(workDiv); 
    });
}

function goWork(workID) {
    window.location.href = `./dutie/dutie.php?workID=${workID}`;
}

function setName(title) {
    switch (title) {
        case 'comments':
            newTitle = 'Check Spam';
            break;
        case 'productAdd':
            newTitle = 'Add Product';
            break;
        case 'stock':
            newTitle = 'Stock Management';
            break;
        case 'blacklist':
            newTitle = 'Blacklist Users';
            break;
        case 'productEdit':
            newTitle = 'Edit Product';
            break
        default:
            newTitle = 'Work';
            break;
    }
    return newTitle;
}
function setComment(title) {
    switch (title) {
    case 'comments':
        message = 'Delete any inappropriate comments given by users to products.';

        break;
    case 'productAdd':
        message = 'Add new product into to the website with all it\'s details.';
        break;
    case 'stock':
        message = 'Make a product available to the users or hide from the users.';
        break;
    case 'blacklist':
        message = 'Block the suspecious users from the website.';
        break;
    case 'productEdit':
        message = 'Edit the already created product details.';
        break
    default:
        message = 'This is your new work it currently under construction.';
        break;
}
return message;
}


// <p>Work ID: ${work.workID}</p> 
// do the card styling and  header page.







