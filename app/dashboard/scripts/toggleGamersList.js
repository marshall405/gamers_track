function toggleGamersList(){
    const gamers = document.getElementById("gamers");
    let left = getComputedStyle(gamers).left;
    if(left == "0px"){
        left = "-304px";
    }else { 
        left = "0px";
    }
    gamers.style.left = left;
}