let passCheckBox = document.getElementById('showPass');
let passImg = document.getElementById('img');
let e = document.getElementById('pass');


passCheckBox.addEventListener('change', ()=>{
    showPassword(passImg, e);
});


function showPassword(passImg, e){
    if(e.type == 'password'){
        e.type = 'text';
        passImg.src = '../../resources/eye.png';
        e.style.fontWeight = 400;
    }else {
        e.type = 'password';
        passImg.src = '../../resources/hidden.png';
        e.style.fontWeight = 900;
    }
}



