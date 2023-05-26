function saveProduct(){
    let vara = document.getElementById('varainput');
    let varatext=vara.value;

    if (varatext.trim()!= "" && varatext.length<50){
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
    }else{
        alert("this field is either empty or is too long");
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

    if (vara.trim() != "" && vara.length<50){
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
    }else{
        alert("this field is either empty or is too long");
    }

    varanode.value="";
    document.getElementById("AddButton").onclick=function(){
        saveProduct();
    }
    document.getElementById("AddButton").innerHTML="+";


}



function deleteProduct(id, namn){
    if(confirm("are you sure you want to delete "+namn+"?")){
        let FD = new FormData();
        FD.append("id", id);

        fetch(serverurl+"raderaVara.php",
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
}
function deleteAllProduct(){
    if(confirm("are you sure you want to delete everything?")){

        fetch(serverurl+"raderaAllaVaror.php",
        {
            method: 'POST'
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
}

function productChecked(id){

    let FD = new FormData();
    FD.append("id", id);

    fetch(serverurl+"kryssaVara.php",
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
function deleteCheckedProduct(id){
    if(confirm("are you sure you want to delete chosen?")){
        let FD = new FormData();
        FD.append("id", id);

        fetch(serverurl+"raderaValda.php",
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
}