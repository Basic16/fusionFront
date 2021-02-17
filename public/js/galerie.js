function selectAll() {
    var items = document.getElementsByName('suppimgs[]');
    for (var i = 0; i < items.length; i++) {
    if (items[i].type == 'checkbox') 
    items[i].checked = true;
    
    
    
    }
    }
    function unselectAll() {
    var items = document.getElementsByName('suppimgs[]');
    for (var i = 0; i < items.length; i++) {
    if (items[i].type == 'checkbox') 
    items[i].checked = false;
    
    
    
    }
    }