function load() {
    let e = document.getElementById("country");
    let country_id = e.options[e.selectedIndex].value;
    let zip_code = document.getElementById("zip_code").value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("result").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "api.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("country="+country_id+"&zip_code="+zip_code);
}

// On Load page . . . Load Country option list
window.onload = function () {
    let country = document.getElementById('country');
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            for(let index in data) {
                country.options.add( new Option(data[index]['name'],data[index]['code']) );
            }
        }
    };
    xhttp.open("POST", "api.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("get_country_list=1");
    
};
