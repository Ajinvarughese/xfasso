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
        workDiv.innerHTML = `
            <div class='ic'>
                <img src='./images/${work.workName}.png'>
            </div>
            <h3>${setName(work.workName)}</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing 
            </p>
        `;
        duties.appendChild(workDiv); 
    });
}

function setName(title) {
    switch (title) {
        case 'comments':
            title = 'Check Spam';
            break;
        case 'productAdd':
            title = 'Add Product';
            break;
        case 'stock':
            title = 'Stock Management';
            break;
        case 'blacklist':
            title = 'Blacklist Users';
            break;
        case 'productEdit':
            title = 'Edit Product';
            break
        default:
            title = 'Work';
            break;
    }
    return title;
}





function randomValues() {
    anime({
        targets: '.square, .circle, .triangle',
        translateX: function() {
        return anime.random(-500, 500);
        },
            translateY: function() {
        return anime.random(-300, 300);
        },
            rotate: function() {
                return anime.random(0, 360);
            },
            scale: function() {
                return anime.random(.2, 2);
            },
        duration: 1000,
            easing: 'easeInOutQuad',
        complete: randomValues,
    });
}

randomValues();
    
// <p>Work ID: ${work.workID}</p> 
// do the card styling and  header page.








