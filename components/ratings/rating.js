document.addEventListener('DOMContentLoaded', function() {
    var userIDElement = document.getElementById('userId');
    var prodIDElement = document.getElementById('prodID');
    var ratingElement = document.getElementById('rating');
    var descElement = document.getElementById('desc');

    var json;

    fetch('./ratingAPI.php')
        .then(response => response.json())
        .then(data => {
            json = data;
            data.forEach(ratingsArray => {
                ratingsArray.forEach(rating => {
                    prodIDElement.innerHTML += rating.productID + '<br>';
                    userIDElement.innerHTML += rating.userID + '<br>';
                    descElement.innerHTML += rating.description + '<br>';
                    ratingElement.innerHTML += rating.starCount + '<br>';
                });
            });

            let totalElements = 0;

            for (let i = 0; i < json.length; i++) {
                if (Array.isArray(json[i])) {
                    totalElements += json[i].length;
                } else {
                    totalElements++;
                }
            }
    
            for (let i = 0; i < json.length; i++) {
                if (Array.isArray(json[i])) {
                    for (let j = 0; j < json[i].length; j++) {
                        console.log(json[i][j]);
                    }
                } else {
                    console.log(json[i]);
                }
            }
        })
        .catch(error => {
            console.error('Error fetching data');
        });

    function rating(productID) {
              
    }
});
