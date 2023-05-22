function saveProduct(){
    let vara = document.getElementById('varainput');
    let varatext=vara.value;

    if (varatext.trim()!= ""){
        let FD = new FormData();
        FD.append("vara", varatext);

        fetch(serverurl+"sparaVara.php",
        {
            method: 'POST',
            body: FD
        })
        .then(function (response){
            if (response.status==200){
                return response.json();
            }
        })
        .then(function(data){
            getProducts();
        })
    }

    vara.value="";
}


function editVaraForm(id){
    document.getElementById("varainput").value = document.getElementById("vara" + id).innerHTML;
    document.getElementById("AddButton").onclick=function(){
        editProduct(id);
    }
}

function editProduct(id){
    let varanode = document.getElementById('varainput');
    let vara =varanode.value;

    if (vara.trim() != ""){
        let FD = new FormData();
        FD.append("vara", vara);
        FD.append("id", id);

        fetch(serverurl+"uppdateraVara.php",
        {
            method: 'POST',
            body: FD
        })
        .then(function (response){
            if (response.status==200){
                return response.json();
            }
        })
        .then(function(data){
            getProducts();
        })
    }

    varanode.value="";
    document.getElementById("AddButton").onclick=function(){
        saveProduct();
    }
    document.getElementById("AddButton").innerHTML="add";


}