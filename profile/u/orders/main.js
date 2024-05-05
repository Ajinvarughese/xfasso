function orderProducts(json="", hasValue=false) {
    if(hasValue) {
        console.log(json);
        let img = document.getElementById('img');
        let imageType = "image/jpeg";
        for(let i=0; i<json['products'].length; i++) {
            let product_name = json['products'][i]['product_name'];
            let imgData = json['products'][i]['product_image'];
            img.innerHTML += `<img id='i' src='data:${imageType};base64,${imgData}'>`
        }
        console.log()
    }
    else {
        console.log("NoValue");
    }
}

fetch('../../../components/orders/order.php')
    .then((result) => {
        return result.json();
    })
    .then((outcome) => {
        orderProducts(outcome, true);
    })
    .catch((error) => {
        orderProducts(); 
    });

