const imgs = document.querySelectorAll('.img-select a');
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener('click', (event) => {
        event.preventDefault();
        imgId = imgItem.dataset.id;
        slideImage();
    });
});


var quantityInput = document.getElementById("quantity");

quantityInput.addEventListener("blur", function() {
    var inputValue = parseInt(quantityInput.value, 10);

    if (inputValue > 5) {
        quantityInput.value = 1;
    } 
    else if(inputValue<=0) {
        quantityInput.value = 1;
    }
});

function slideImage(){
    const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

    document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
}

window.addEventListener('resize', slideImage);


function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
var limitW = document.getElementById('limitW');
if(getCookie('SESSIONQEND')) {
    limitW.innerHTML = 'You added maximum quantity to cart';
    document.cookie = `SESSIONQEND=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
    limitW.style.display='block';
    setTimeout(()=> {
        limitW.style.display = 'none';
    }, 10000)
}else {
    limitW.innerHTML = '';
}