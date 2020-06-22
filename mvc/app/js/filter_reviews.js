var btn = document.getElementById('find');
btn.addEventListener('click',function(){
//ajax call
var request = new XMLHttpRequest();
request.open('GET','../app/views/filter_reviews.php',true);
request.onload = function(){
    var data = request.responseText;
 };

console.log(request.responseText);
request.send();
});
