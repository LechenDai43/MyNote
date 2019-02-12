var pointer = 0;
var line = 0;
var scope = "";
var key = "";
var result = "";
var real_ARRAY = [];

function setUp(result){ 
    result = document.getElementById("hidden").innerHTML; 
    var tbody = document.getElementById("tbody");
    while(tbody.hasChildNodes()){
        tbody.removeChild(tbody.firstChild);
    }
    real_ARRAY = [];    
    if(result == "" || result == "没有找到相应的结果"){           
        var one_row = document.createElement("tr");
        var left_cell = document.createElement("td");
        var left = document.createElement("div");
        left.innerHTML = "没有找到相应的结果";
        left_cell.appendChild(left);
        left_cell.className = "title-cell";
        var right_cell = document.createElement("td");
        var right = document.createElement("em");
        right.innerHTML = "没有找到相应的结果";
        right_cell.className = "origin-cell";        
        right_cell.appendChild(right);
        one_row.appendChild(left_cell);
        one_row.appendChild(right_cell);
        var tbody = document.getElementById("tbody");
        tbody.appendChild(one_row);
        real_ARRAY.push(one_row);
        pointer = 0;
        line = 0;
    }else{
        var tem_arr = [];        
        tem_arr = result.split("^");          
        for(var i = 0; i < tem_arr.length; i ++){            
            var inter_arr = tem_arr[i].split(";");
            
            var one_row = document.createElement("tr");
            var left_cell = document.createElement("td");
            var left = document.createElement("a");
            left.innerHTML = inter_arr[1];
            left.href = "./viewer.php?id="+inter_arr[0];
            left.target = "_blank";
            left_cell.appendChild(left);
            left_cell.className = "title-cell";
            var right_cell = document.createElement("td");
            var right = document.createElement("em");
            right.innerHTML = inter_arr[2];
            right_cell.className = "origin-cell";
            right_cell.appendChild(right);
            one_row.appendChild(left_cell);
            one_row.appendChild(right_cell);
            real_ARRAY.push(one_row);
        }
        line = real_ARRAY.length;
        pointer = 0;
        queryData(pointer);
    }   
    var page_num = line / 25 + 1;
    var select = document.getElementById("selectPage");
    for(var i = 0; i < page_num; i ++){
        var op = document.createElement("option");
        op.innerHTML = i+1;
        select.appendChild(op);
    }
}

function goForward(){
    if(pointer == 0){
        alert("前面已经没有啦！");
    }else{
        pointer -= 1;
        queryData(pointer);
    }
}

function jumpPage(){
    var target = document.getElementById("selectPage").value;
    var num = parseInt(target,10);
    if(num <= 0){
        alert("超出界限啦！");
    }else if((num-1)*25 > line){
        alert("超出界限啦！");
    }else{
        pointer = num - 1;
        queryData(pointer);
    }
}

function goBackward(){
    if(line <= 25*pointer + 25){
        alert("后面已经没有啦！");
    }else{
        pointer += 1;
        queryData(pointer);
    }
}

function queryData(target){
    var tbody = document.getElementById("tbody");
    while(tbody.hasChildNodes()){
        tbody.removeChild(tbody.firstChild);
    }
    for(var i = target*25; i < real_ARRAY.length && i < target*25 + 26; i ++){
        tbody.appendChild(real_ARRAY[i]);
    }
}

function enterSearch(event){
    var keyVal = event.key;
    if(keyVal == "Enter"){
        clickSearch();
    }
}

function clickSearch(){
    key = document.getElementById("input_search").value;
    scope = document.getElementById("input_type").value;
    if(window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            result = xmlhttp.responseText;
            document.getElementById("hidden").innerHTML = result;
            setUp(result);
        }
    }
    var p1 = "GET";
    var p2 = "search_main.php?scope=" + scope + "&key=" + key;
    xmlhttp.open(p1,p2,true);
    xmlhttp.send();
}
