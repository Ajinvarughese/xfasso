document.addEventListener('DOMContentLoaded', function() {
    var userIDElement = document.getElementById('userId');
    var prodIDElement = document.getElementById('prodID');
    var ratingElement = document.getElementById('rating');
    var descElement = document.getElementById('desc');

    fetch('./ratingAPI.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            
            data.forEach(ratingsArray => {
                ratingsArray.forEach(rating => {
                    prodIDElement.innerHTML += rating.productID + '<br>';
                    userIDElement.innerHTML += rating.userID + '<br>';
                    descElement.innerHTML += rating.description + '<br>';
                    ratingElement.innerHTML += rating.starCount + '<br>';
                });
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});
