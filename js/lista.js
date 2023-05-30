serverurl='php/'

//these functions activate immideately after they are loaded
window.onload = function(){
    getProducts();
    document.getElementById("AddButton").onclick=function(){
        saveProduct();
    }
        document.getElementById("allabutton").onclick=function(){
        deleteAllProduct();
    }
    document.getElementById("valdabutton").onclick=function(){
        deleteCheckedProduct();
    }
}
//this function loads the database and lets you visually see the list in it
function getProducts(){

    fetch(serverurl+'hamtaAlla.php')
    .then(function(response){
        if (response.status == 200){
            return response.json();
        }
    })
    .then(function (data){
        
        appendProducts(data);
    })
}
//gives the buttons their purpose
function appendProducts(data){
    console.log(data);
    let btn=document.getElementById("valdabutton");
    btn.setAttribute("disabled",true)
    let tabell=document.getElementById("varatable");
    tabell.innerHTML="";
    //creating the purpose for the buttons
    for(let i=0;i<data.length;i++){
        let rad=document.createElement("tr");
        let checkboxtd=document.createElement("td");
        let checkbox=document.createElement("input");
        checkbox.setAttribute("type", "checkbox");
        //enable the button if something is checked
        if(data[i].checked){
            checkbox.checked=1;
            btn.removeAttribute("disabled");
        }
        //be able to check an item
        checkbox.onclick=function(){
            productChecked(data[i].id);
        }
        checkboxtd.appendChild(checkbox);

        //the products in the list and database
        let texttd=document.createElement("td");
        texttd.id="vara"+data[i].id;
        texttd.innerHTML=data[i].namn;

        //this lets you edit a product
        let redigeratd=document.createElement("td");
        let redigeraicon=document.createElement("i");
        redigeraicon.classList.add("material-icons");
        redigeraicon.innerHTML="edit";
        redigeraicon.onclick=function(){
            editVaraForm(data[i].id);
        }
        redigeratd.appendChild(redigeraicon);

        //this lets you to delete a product
        let raderatd=document.createElement("td");
        let raderaicon=document.createElement("i");
        raderaicon.classList.add("material-icons");
        raderaicon.innerHTML="delete";
        raderaicon.onclick=function(){
            deleteProduct(data[i].id, data[i].namn);
        }
    raderatd.appendChild(raderaicon);
    //all of the frontend functions

    //edit button
    rad.appendChild(redigeratd);
    //check/uncheck button
    rad.appendChild(checkboxtd);
    //not clickable, but the items in the list, can be edited 
    rad.appendChild(texttd);
    //delete product button
    rad.appendChild(raderatd);
    //makes the table work
    tabell.appendChild(rad);
    }
}