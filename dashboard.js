window.addEventListener("load", function(){
    
    let all_btn = document.querySelector(".all");
    let only_sales_btn = document.querySelector(".sales_leads");
    let only_support_btn = document.querySelector(".support");
    let only_assigned_btn = document.querySelector(".to_me");
    let result = document.querySelector(".result");

    all_btn.addEventListener("click", function(event){
        event.preventDefault();

        let url = `dashboard.php?filter=All`;
        console.log(url);

        fetch(url)
        .then(function (response) {
            if (response.ok) {
            return response.text();
            } else {
            throw new Error(response.statusText);
            }
        })
        .then(function (data) {
            result.innerHTML = data;
        });
    })

    only_sales_btn.addEventListener("click", function(event){
        event.preventDefault();

        let url = `dashboard.php?filter=SalesLead`;

        fetch(url)
        .then(function (response) {
            if (response.ok) {
            return response.text();
            } else {
            throw new Error(response.statusText);
            }
        })
        .then(function (data) {
            result.innerHTML = data;
        });
    })

    only_support_btn.addEventListener("click", function(event){
        event.preventDefault();

        let url = `dashboard.php?filter=Support`;

        fetch(url)
        .then(function (response) {
            if (response.ok) {
            return response.text();
            } else {
            throw new Error(response.statusText);
            }
        })
        .then(function (data) {
            result.innerHTML = data;
        });
    })

    only_assigned_btn.addEventListener("click", function(event){
        event.preventDefault();

        let url = `dashboard.php?filter=Assigned`;

        fetch(url)
        .then(function (response) {
            if (response.ok) {
            return response.text();
            } else {
            throw new Error(response.statusText);
            }
        })
        .then(function (data) {
            result.innerHTML = data;
        });
    })
})