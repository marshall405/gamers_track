window.addEventListener( "DOMContentLoaded", () => {
    let updateStatus = setInterval( () => {
        fetch("/dashboard/api/getActiveUsers.php")
        .then( res => res.json())
        .then(json => {
            json.forEach(user => {
                let ele = document.querySelector(`[data-id="${user.id}"]`)
                if(user.active === "1") {
                    if(ele.classList.contains("offline")){
                        ele.classList.remove("offline")
                        ele.classList.add("online")
                    }
                }else {
                    if(ele.classList.contains("online")){
                        ele.classList.remove("online")
                        ele.classList.add("offline")
                    }
                }
            });
        }).catch( err => {
            console.log(`Oops! Something went wrong: ${err}`)
            clearInterval(updateStatus)
        })
    }, 45000);
})

