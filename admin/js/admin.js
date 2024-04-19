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
        
    workData.forEach(work => {
        // Create a new div element for each work item
        let workDiv = document.createElement('div');
        workDiv.classList.add('work');
        workDiv.innerHTML = `
            <div class='ic'>
                <img src='./images/${work.workName}.png'>
            </div>
            <h3>${work.workName}</h3>
            <p>Work ID: ${work.workID}</p>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing 
            </p>
        `;
        duties.appendChild(workDiv); 
    });
}

// do the card styling and  header page.