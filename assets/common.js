function load() {
    let e = document.getElementById("country");
    let country_id = e.options[e.selectedIndex].value;
    let zip_code = document.getElementById("zip_code").value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try {
                JSON.parse(this.responseText);
            }
            catch (err) {
                document.getElementById("result").innerHTML = this.responseText;
                return false;
            }
    
            let data = JSON.parse(this.responseText);
            
            // EXTRACT VALUE FOR HTML HEADER.
            let col = [];
            for (let i = 0; i < data.places.length; i++) {
                for (let key in data.places[i]) {
                    if (col.indexOf(key) === -1) {
                        col.push(key);
                    }
                }
            }
    
            // CREATE DYNAMIC TABLE.
            let table = document.createElement("table");
    
            // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.
            let tr = table.insertRow(-1);
            for (let i = 0; i < col.length; i++) {
                let th = document.createElement("th");
                th.innerHTML = col[i];
                tr.appendChild(th);
            }
    
            // ADD JSON DATA TO THE TABLE AS ROWS.
            for (let i = 0; i < data.places.length; i++) {
                tr = table.insertRow(-1);
                for (let j = 0; j < col.length; j++) {
                    let tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = data.places[i][col[j]];
                }
            }
    
            // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
            let divContainer = document.getElementById("result");
            divContainer.innerHTML = "";
            divContainer.appendChild(table);
        }
    };
    xhttp.open("POST", "api.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("country="+country_id+"&zip_code="+zip_code);
}

// ON LOAD PAGE . . . LOAD COUNTRY OPTION LIST
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
