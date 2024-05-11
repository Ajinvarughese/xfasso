function showContent(imageData, product_name, product_size, date, orderID, prodID) {
    let orders = document.getElementById("orders");
    let imageType = "image/jpeg";
    
    orders.innerHTML += 
    `
        <a href='order-details/order-details.php?orderID="${orderID}"&productID="${prodID}"'>
            <div class="card">
                <div class="cardimg">
                    <img src="data:${imageType};base64,${imageData}" alt="product">
                </div>
                <div class="cardContent">
                    <div class="contentHead">
                        ${date}
                    </div>
                    <div class="p">
                        ${product_name}
                    </div>
                    <div class="size">
                        size: ${product_size}
                    </div>
                    <div class="client">
                        ordered for Ajin Varughese
                    </div>
                </div>
            </div>
        </a>
    `;
}


function orderProducts(json="", hasValue=false) {
    if(hasValue && json) {
        console.log(json);
        let img = document.getElementById('img');
        for(let i=0; i<json['products'].length; i++) {
            let product_name = json['products'][i]['product_name'];
            let imageData = json['products'][i]['product_image'];
            
            let jsonDate = new Date(json['products'][i]['date']);
            let date = jsonDate.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });


            let product_size = json['products'][i]['size'];
            let prodID = json['products'][i]['product_id'];
            let orderID = json['products'][i]['order_id'];
            showContent(imageData, product_name, product_size, date, orderID, prodID);
        }
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
        outcome.products.sort((a, b) => new Date(b.date) - new Date(a.date));  
        outcome.products.reverse();    
        orderProducts(outcome, true);
    })
    .catch((error) => {
        orderProducts(); 
    });
    
let back = document.getElementById("back");
back.addEventListener('click', ()=> {
    window.history.back();
})

let user = document.getElementById("user");
user.addEventListener("click" ,()=> {
    window.location.href = '../edit-profile.php';
})
