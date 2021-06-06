function response(){
    var url = window.location.search;
    if(url.includes("errorlogin")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h5>Error Username or Password!!!</h5></span>";
    }
    if(url.includes("usernotfound")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h5>Can't find user!!!</h5></span>";
    }
    if(url.includes("errorEmail")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h5>There is no user with this Email address</h5></span>";
    }
    if(url.includes("updated")){
        document.getElementById("messages").innerHTML = "<span style='color:DarkBlue'><h5>Password updated!</h5></span>";
    }
    if(url.includes("userexists")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h5>This email address already exists.</h5></span>";
    }
    if(url.includes("emptyfields")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h5>You have some empty fields</h5></span>";
    }
    if(url.includes("errorProcess")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h5>Error processing. Try again</h5></span>";
    }
    if(url.includes("registrationerror")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h5>Error while sending registration email. Try again</h5></span>";
    }
    if(url.includes("usercreated")){
        document.getElementById("messages").innerHTML = "<span style='color:Blue'><h5>User created successful. Now Login to insert.</h5></span>";
    }
   

}

