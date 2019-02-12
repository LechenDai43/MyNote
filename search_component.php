<div id="search_component">
    <input type="text" name="key_word" id="input_search" value="" onkeypress="enterSearch(event)"/>
    <select name="select_type" id="input_type">
        <option>全局</option>
        <option>标题</option>
        <option>概念</option>
        <option>来源</option>
        <option>人物</option>
        <option>书目</option>
    </select>
    <button onclick="clickSearch()">搜索</button>
</div>