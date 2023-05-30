function saveProduct(){
    //Take the info from textfield
    let vara = document.getElementById('varainput');
    let varatext=vara.value;
    //checks if the textfield isn't empty, or has less than 50 characters in it
    if (varatext.trim()!= "" && varatext.length<50){
        let FD = new FormData();
        FD.append("vara", varatext);

        //if the textfield has 1-49 characters then the backend will be  requested for info
        fetch(serverurl+"sparaVara.php",
        {
            method: 'POST',
            body: FD
        })
        //if it responses with status exactly 200 it will return an answer
        .then(function (response){
            if (response.status==200){
                return response.json();
            }
        })
        //then the input text will be added to the database
        .then(function(data){
            getProducts();
        })
    }else{
        //otherwise it will alert with a pop-up error
        alert("this field is either empty or is too long");
    }

    vara.value="";
}


function editVaraForm(id){
    //when clicked on "edit" textfield will change its function to updating instead of creating
    document.getElementById("varainput").value = document.getElementById("vara" + id).innerHTML;
    //changes the function of "add button" to "update button"
    document.getElementById("AddButton").onclick=function(){
        editProduct(id);
    }
}

function editProduct(id){
    let varanode = document.getElementById('varainput');
    let vara =varanode.value;

    //checks if the field is not empty or has less than 50 characters
    if (vara.trim() != "" && vara.length<50){
        let FD = new FormData();
        FD.append("vara", vara);
        FD.append("id", id);
        
         //if the textfield has 1-49 characters then the backend will be  requested for info
        fetch(serverurl+"uppdateraVara.php",
        {
            method: 'POST',
            body: FD
        })

         //if it responses with status exactly 200 it will return an answer
        .then(function (response){
            if (response.status==200){
                return response.json();
            }
        })
         //then the input text will be updated in the database
        .then(function(data){
            getProducts();
        })
    }else{

        //otherwise it will alert with a pop-up error
        alert("this field is either empty or is too long");
    }

    varanode.value="";
    //the user needs to click it for it to work
    document.getElementById("AddButton").onclick=function(){
        saveProduct();
    }
    document.getElementById("AddButton").innerHTML="+";


}



function deleteProduct(id, namn){
    //asks you if you are sure you want to delete specifically that item
    if(confirm("are you sure you want to delete "+namn+"?")){
        let FD = new FormData();
        FD.append("id", id);

        //if confirmed, the backend will be requested for info
        fetch(serverurl+"raderaVara.php",
        {
            method: 'POST',
            body: FD
        })

         //if it responses with status exactly 200 it will return an answer
        .then(function (response){
            if (response.status==200){
                return response.json();
            }
        })
        //then it deletes the product
        .then(function(data){
            getProducts();
        })
    }
}
function deleteAllProduct(){

    //asks you if you are sure you want to delete all items
    if(confirm("are you sure you want to delete everything?")){
        
        //if confirmed, the backend will be requested for info
        fetch(serverurl+"raderaAllaVaror.php",
        {
            method: 'POST'
        })

         //then the input text will be updated in the database
        .then(function (response){
            if (response.status==200){
                return response.json();
            }
        })
         //then it deletes all products
        .then(function(data){
            getProducts();
        })
    }
}

function productChecked(id){

    //allows the checking/unchecking to be executable in the frontend
    let FD = new FormData();
    FD.append("id", id);

    //requests info from the backend
    fetch(serverurl+"kryssaVara.php",
    {
        method: 'POST',
        body: FD
    })
    
    //if it responses with status exactly 200 it will return an answer
    .then(function (response){
        if (response.status==200){
            return response.json();
        }
    })
    //then it checks the products
    .then(function(data){
        getProducts();
    })
}
function deleteCheckedProduct(id){

     //asks you if you are sure you want to delete selected items
    if(confirm("are you sure you want to delete chosen?")){
        let FD = new FormData();
        FD.append("id", id);

        fetch(serverurl+"raderaValda.php",
        {
            method: 'POST',
            body: FD
        })      

         //if confirmed, the backend will be requested for info
        .then(function (response){
            if (response.status==200){
                return response.json();
            }
        })
        
        //then it deletes the products
        .then(function(data){
            getProducts();
        })
    }
}