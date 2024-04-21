let logOut = document.getElementById('logOut');

logOut.addEventListener("click", ()=> {
    window.location.href = "../../logout/logout.php";
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
