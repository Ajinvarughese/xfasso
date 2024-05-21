function showContent(imageData, product_name, product_size, date, orderID, prodID) {
    let orders = document.getElementById("orders");
    let imageType = "image/jpeg";
    orderID = encodeURIComponent(orderID);
    prodID = encodeURIComponent(prodID); 
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
        showNothing();
    }
}


function showNothing() {
    let orders = document.getElementById("orders");
    orders.style.maxWidth = 'unset';
    orders.innerHTML = 
    `
        <div class='asj3'>
            <div class='asj4'>
                <img src='../../../resources/noProduct.png'> 
                <p>Nothing to show here.</p>
            </div>      
        </div>
    `;
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}
let userId = encodeURIComponent(getCookie('XassureUser'));

fetch(`../../../components/orders/order.php?userId=${userId}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((outcome) => {
        // outcome.products.sort((a, b) => new Date(b.date) - new Date(a.date));  
        outcome.products.reverse()
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
