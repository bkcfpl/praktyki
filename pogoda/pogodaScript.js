change_location(0,0)

function load(latitude, longitude){
    fetch("https://api.open-meteo.com/v1/forecast?latitude=" + latitude + "&longitude=" + longitude + "&current=temperature_2m,is_day,relative_humidity_2m,apparent_temperature,precipitation,weather_code,surface_pressure&hourly=temperature_2m,apparent_temperature,weather_code,surface_pressure&daily=weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,uv_index_max,precipitation_sum,wind_speed_10m_max,wind_direction_10m_dominant&timezone=Europe%2FBerlin")
        .then(res => res.json())
        .then(res => {
        //pierwszy blok 

            document.getElementById("temp_current").innerText = res.current.temperature_2m + "°C"
            code = change_code(res.current.weather_code);
            document.getElementById("wheater_current").innerText = code[0] + " " + res.daily.temperature_2m_max[0] + "°/" + res.daily.temperature_2m_min[0] + "°";  

        //drugi blok    

            //tworzenie tabelki forecast, przypisywanie polom id, i dwanie polom wartości
            for(let i = 0; i < 7; i++){
                let tr = document.createElement("tr");  

                for(let j = 0; j < 4; j++){
                    td = document.createElement("td")
                    let a = ""; 

                    switch(j){
                        case 0:
                            a = "ikona" + i
                            break;
                        case 1:
                            a = "data" + i
                            break;
                        case 2:
                            a = "zachmurzenie" + i
                            break;
                        case 3:
                            a = "temp" + i
                            break;
                    }
                    td.setAttribute("id", a)
                    tr.appendChild(td);
                }
                document.getElementById("forecast").appendChild(tr);    

                document.getElementById("ikona" + i).innerHTML = "<img src='grafiki/" + change_code(res.daily.weather_code[i], 1)[1] + ".png' alt=''>";
                document.getElementById("data" + i).innerText = res.daily.time[i]
                document.getElementById("zachmurzenie" + i).innerText = change_code(res.daily.weather_code[i], 0)[0]
                document.getElementById("temp" + i).innerText = res.daily.temperature_2m_max[i] + "°/" + res.daily.temperature_2m_min[i]+ "°";
            }   

            //tworzenie nagłówków, z godzinami
            let tr = document.createElement("tr");
            th = document.createElement("th")
            th.setAttribute("id", "hour")
            tr.appendChild(th);
            document.getElementById("hourly").appendChild(tr);
            document.getElementById("hour").innerText = "kategoria\\godzina"    

            for(let i = 0; i < 24; i++){
                th = document.createElement("th")
                th.setAttribute("id", "hour" + i)
                tr.appendChild(th);
                document.getElementById("hourly").appendChild(tr);
                document.getElementById("hour" + i).innerText = i + ":00"
            }   

            //tworzenie dwóch wierszy
            for(let i = 0; i < 2; i++){
                tr = document.createElement("tr");
                td = document.createElement("td")
                td.setAttribute("id", "idL" + i)
                tr.appendChild(td); 

                //tworzenie 24 kolumn, przypisywanie im id po godzinie, i wrzucanie ich do wierszy
                for(let j = 0; j < 24; j++){
                    switch(i){
                        case 0:
                           a = "hourTemp" + j
                            break;
                        case 1:
                           a = "hourIkona" + j
                            break;
                    }
                    td = document.createElement("td")
                    td.setAttribute("id", a)
                    tr.appendChild(td);
                }       

                //wrzucanie wszystkiego do tabelki
                document.getElementById("hourly").appendChild(tr);
                if(i == 0){
                    document.getElementById("idL0").innerHTML = "<i>temperatura</i>"
                }
                else{
                    document.getElementById("idL1").innerHTML = "<i>warunki</i>"
                }
            }   

            let day;
            for(let i = 0; i < 24; i++){
                if(i < Number(res.daily.sunrise[0][11]) + Number(res.daily.sunrise[0][12]) || i > Number(res.daily.sunset[0][11] + res.daily.sunset[0][12])){
                    day = 0
                }
                else{
                    day = 1
                }   

                document.getElementById("hourIkona" + i).innerHTML = "<img src='grafiki/" + change_code(res.hourly.weather_code[i], day)[1] + ".png' alt=''>";
                document.getElementById("hourTemp" + i).innerText = res.hourly.temperature_2m[i] + "°";
            }

        //trzeci blok   

            //ustawienie tekstowego kierunku wiatru, w zależności od cyfrowego kierunku
            let direct = res.daily.wind_direction_10m_dominant[0]
            if(direct < 24){
                direct = "północ"
            }
            else if(direct > 23 && direct < 69){
                direct = "północny-wschód"
            }
            else if(direct > 68 && direct < 114){
                direct = "wschód"
            }
            else if(direct > 113 && direct < 159){
                direct = "połódniowy-wschód"
            }
            else if(direct > 158 && direct < 204){
                direct = "południe"
            }
            else if(direct > 203 && direct < 249){
                direct = "południowy-zachód"
            }
            else if(direct > 248 && direct < 294){
                direct = "zachód"
            }
            else if(direct > 293 && direct < 339){
                direct = "północny-zachód"
            }
            else{
                direct = "północ"
            }
            document.getElementById("wind").innerHTML = "<i>wiatr</i> <br/>" + res.daily.wind_speed_10m_max[0] + " km/h<br/>" + direct

            let sunrise = res.daily.sunrise[0][11] + res.daily.sunrise[0][12] + res.daily.sunrise[0][13] + res.daily.sunrise[0][14] + res.daily.sunrise[0][15]
            let sunset = res.daily.sunset[0][11] + res.daily.sunset[0][12] + res.daily.sunset[0][13] + res.daily.sunset[0][14] + res.daily.sunset[0][15]    

            document.getElementById("sun").innerHTML = sunrise + " wschód<br/>" + sunset + " zachód"
            document.getElementById("general").innerHTML = "Wilgotność " + res.current.relative_humidity_2m + "%<br/>Odczuwalnie " + res.current.apparent_temperature + "°<br/>UV " + res.daily.uv_index_max[0] + "<br/>Ciśnienie " + res.current.surface_pressure + " mbar<br/>Szansa na deszcz " + res.current.precipitation + "%"
            document.getElementById("loading").innerText = ""
            document.getElementById("error").innerText = "" 

            console.log(res);
        })
}

function change_code(code, day){
    switch(code){
        case 0:
            code = "czyste niebo";
            image = "clear"
            break;
        case 1:
        case 2:
        case 3:
            image = "cloud"
            if(code == 1){
                code = "przeważnie bezchmurnie"
            }
            else if(code == 2){
                code = "częściowo pochmurno"
            }
            else{
                code = "pochmurno"
            }
            break;
        case 45:
        case 48:
            image = "fog"
            if(code == 45){
                code = "mgła"
            }
            else{
                code = "szadź"
            }
            break;
        case 51:
        case 53:
        case 55:
        case 56:
        case 57:
            image = "drizzle"   
            if(code == 51){
                code = "mżawka lekka"
            }
            else if(code == 53){
                code = "mżawka umiarkowana"
            }
            else if(code == 55){
                code = "mżawka gęsta"
            }
            else if(code == 56){
                code == "marznąca mżawka lekka"
            }
            else{
                code == "marznąca mżawka gęsta"
            }
            break;
        case 61:
        case 63:
        case 65:
        case 66:
        case 67:
        case 80:
        case 81:
        case 82:
            image = "rain"
            if(code == 61){
                code = "niewielki deszcz"
            }
            else if(code == 63){
                code = "umiarkowany deszcz"
            }
            else if(code == 65){
                code = "silny deszcz"
            }
            else if(code == 66){
                code = "lekki marznący deszcz"
            }
            else if(code == 67){
                code = "silny marznący deszcz"
            }
            else if(code == 80){
                code = "lekki opad deszczu"
            }
            else if(code == 81){
                code = "umiarkowany opad deszczu"
            }
            else{
                code = "gwałtowny opad deszczu"
            }
            break;
        case 71:
        case 73:
        case 75:
        case 77:
        case 85:
        case 86:
            image = "snow"
            if(code == 71){
                code = "niewielkie opady śniegu"
            }
            else if(code == 73){
                code = "umiarkowane opady śniegu"
            }
            else if(code == 75){
                code = "duże opady śniegu"
            }
            else if(code == 77){
                code = "ziarnisty śnieg"
            }
            else if(code == 85){
                code = "słabe opady śniegu"
            }
            else{
                code = "intensywne opady śniegu"
            }
            break;
        case 95:
            image = "storm"
            code = "Lekka lub umiarkowana burza"
            break;
        case 96:
        case 99:
            image = "snow_storm"
            if(code == 96){
                code = "burza z lekkim gradem"
            }
            else{
                code = "burza z silnym gradem"
            }
            break;
    }

    if(day == 1 && image != "snow" && image != "storm" && image != "snow_storm"){
        image = "day_" + image
    }
    else if(image != "snow" && image != "storm" && image != "snow_storm"){
        image = "night_" + image
    }
    return [code, image];
}

function change_location(){
    latitude = Number(document.getElementById("latitude").value)
    longitude = Number(document.getElementById("longitude").value)

    if(latitude == 0 || latitude == null){
        latitude =	52.25
    }

    if(longitude == 0 || longitude == null){
        longitude =	21
    }

    load(latitude, longitude)
}