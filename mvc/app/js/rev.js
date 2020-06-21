let fetchBtn=document.getElementById("find");

fetchBtn.addEventListener("click",onClick);

function onClick(){
    fetchBtn.setAttribute("disabled",true);
    fetchBtn.textContent='Loading..';


    fetch("ReviewController/getReviews")
        .then(function(resp){
            return resp.json();
        })
        .then(function(jsonResp){
            console.log(jsonResp);

            //apendeazaContinut(jsonResp);
            fetchBtn.removeAttribute("disabled");
            fetchBtn.textContent = 'next';
        })
        .catch(function(){
            console.log("eroare cv");
        })
            

    function apendeazaContinut(jsonResp){
        
        let div=document.createElement("div");
        div.className="articlePreview";
        let img=div.createElement("img");
        img.alt=
    }
}
        
