function verifier() {

    form = document.getElementById("formarticlecreate");
    form.action = "apercu";
    window.open('', 'formpopup', 'width=900,height=1200,resizeable,scrollbars');
    form.target = 'formpopup';
    
    
    }
    function envoie() {
    form.target = '';
    
    form.action = "ajoutArticle";
    
    
    }