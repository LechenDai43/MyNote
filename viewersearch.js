function clickSearch(){
    var key = document.getElementById("input_search").value;
    var scope = document.getElementById("input_type").value;
    window.open("./main.php?type=outer&key=" + key + "&scope=" + scope);
}

function enterSearch(event){
    var keyVal = event.key;
    if(keyVal == "Enter"){
        clickSearch();
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


