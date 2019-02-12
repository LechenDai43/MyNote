/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function addOneTerm(){
    //把左侧含有“概念”的隔间向下扩展两行
    var theLeft = document.getElementById("key-cell");
    var num = theLeft.rowSpan;
    num = num + 2;
    theLeft.rowSpan = num;
    //建立两个新行
    var newRowOne = document.createElement("tr");
    var newRowTwo = document.createElement("tr");
    //给第一个新行添加内容
    var celOneOne = document.createElement("td");
    //<input type="text" name="概念-词汇[]" class="t-v-term" value=""/>
    var concept = document.createElement("input");
    concept.type = "text";
    concept.name = "概念-词汇[]";
    concept.classList.add("t-v-term");
    concept.value = "";
    celOneOne.appendChild(concept);
    celOneOne.colSpan = 2;
    
    //给第二个新行添加内容
    var celTwoOne = document.createElement("td");
    //<td>
    //    <textarea name="概念-定义[]" class="t-v-defenition" value=""></textarea>
    //</td>
    var def = document.createElement("textarea");
    def.name = "概念-定义[]";
    def.classList.add("t-v-defenition");
    def.value = "";
    celTwoOne.appendChild(def);
    
    var celTwoTwo = document.createElement("td");
    //<td>
    //    <textarea name="概念-例子[]" class="t-v-example" value=""></textarea>
    //</td>
    var exe = document.createElement("textarea");
    exe.name = "概念-例子[]";
    exe.classList.add("t-v-example");
    exe.value = "";
    celTwoTwo.appendChild(exe);
    
    newRowOne.appendChild(celOneOne);    
    newRowTwo.appendChild(celTwoOne);
    newRowTwo.appendChild(celTwoTwo);
    
    var keyRow = document.getElementById("key-row");
    var table = document.getElementById("table");
    var body = table.lastChild;
    body.insertBefore(newRowOne,keyRow);
    body.insertBefore(newRowTwo,keyRow);
}