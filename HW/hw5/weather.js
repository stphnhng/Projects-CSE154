/*
    Stephen Hung
    CSE 154 AD
    This JavaScript file is the JS file for weather.html.
    This script is used to display weather data for a specified city. 
    It takes in a user's inputed city and attempts to find the temperature for the next 24 hrs for
    the specified city and the precipitation chance. In addition, it displays several icons for 
    the week's weather.
*/
// Anonymous module function that encloses all code in order to follow module pattern.
(function(){
    "use strict";
    var tempArray = []; 

    // Function called when the window is loaded.
    window.onload = function(){
        var cityBox = document.getElementById('citiesinput');
        cityBox.disabled = true;
        cityBox.value = "";
        queryServer("?mode=cities", loadCities);
        var searchButton = document.getElementById('search');
        searchButton.onclick = searchCities;
        var precipButton = document.getElementById('precip');
        precipButton.onclick = loadPrecipitation;
        var tempButton = document.getElementById('temp');
        tempButton.onclick = loadTemp;
    };

    // Querys the server for the given params & function.
    function queryServer(params,onloadFunction){
        var ajax = new XMLHttpRequest();
        ajax.onload = onloadFunction;
        ajax.open("GET","https://webster.cs.washington.edu/cse154/weather.php" + params,true);
        ajax.send();
    }

    // Determines whether the content, loading statuses, and error status are hidden or visible.
    function setResultsDisplay(displayStatus,loadingStatus,errorStatus){
        var divIDs = ["location","currentTemp","temp","precip","graph","slider","forecast"];
        var loadingIDs = ["loadinglocation","loadinggraph","loadingforecast"];
        // Loops through the ids for each div in order to set their display to the passed
        // in parameter.
        for(var i = 0; i < divIDs.length; i++){
            var tempDiv = document.getElementById(divIDs[i]);
            tempDiv.style.display = displayStatus;
        }
        for(var i = 0; i < loadingIDs.length; i++){
            var loadingDiv = document.getElementById(loadingIDs[i]);
            loadingDiv.style.display = loadingStatus;
        }
        document.getElementById('errors').style.display = errorStatus;
    }

    // Handles errors from Ajax requests.
    function errorHandle(status){
        var noDataDiv = document.getElementById('nodata');
        if(status === 410){
            // If the status is 410, set all content, loading, and error displays to hidden 
            // and shows the "nodata" div.
            noDataDiv.style.display = "";
            setResultsDisplay("none","none","none");
        }else if(status !== 200){
            // If the AJAX request returns something other than 200, indicate the error that happened.
            var errorDiv = document.getElementById('errors');
            errorDiv.innerText = "Error " + status + " happened.";
            setResultsDisplay("none","none","");
        }else{
            // If everything is fine, make all content displays but error visible and load the
            // temperature.
            setResultsDisplay("","","none");
            noDataDiv.style.display = "none";
            loadTemp();
        }
    }

    // Loads the precipitation graph and removes the temperature slider.
    function loadPrecipitation(){
        var slider = document.getElementById('slider');
        var graph = document.getElementById('graph');
        graph.style.display = "";
        slider.style.display = "none";
    }

    // Loads the temperature slider and removes the precipitation graph.
    function loadTemp(){
        var slider = document.getElementById('slider');
        var graph = document.getElementById('graph');
        graph.style.display = "none";
        slider.style.display = "";
    }

    // Loads city data into the search box.
    function loadCities(){
        errorHandle(this.status);
        var cityList = this.responseText;
        cityList = cityList.split("\n");
        var cityDataset = document.getElementById('cities');
        for(var i = 0; i < cityList.length; i++){
            var option = document.createElement('option');
            option.value = cityList[i];
            cityDataset.appendChild(option);
        }
        document.getElementById('citiesinput').disabled = false;
        document.getElementById('loadingnames').style.display = "none";
    }

    // Populates the location div.
    // This includes the slider, city name, time/date, and weather description.
    function populateLocationDiv(node){
        var slider = document.getElementById('slider');
        var locationDiv = document.getElementById('location');
        locationDiv.innerHTML = "";
        var cityName = node.querySelector('name').textContent;
        var timeElements = node.querySelectorAll('time');
        for(var i = 0; i < timeElements.length; i++){
            tempArray.push(timeElements[i].querySelector('temperature').textContent);
        }
        var cityP = document.createElement('p');
        cityP.innerText = cityName;
        cityP.className = "title";
        var dateP = document.createElement('p');
        dateP.innerText = Date();
        var weatherDescription = document.createElement('p');
        weatherDescription.innerHTML = node.querySelector('symbol').getAttribute('description');
        weatherDescription.id = "description";


        locationDiv.appendChild(cityP);
        locationDiv.appendChild(dateP);
        locationDiv.appendChild(weatherDescription);
    }

    // Populates the current temperature div with the current temperature.
    function populateCurrentTempDiv(){
        var temp = document.createElement('p');
        temp.id = "temperature";
        var currentTempBox = document.getElementById('currentTemp');
        currentTempBox.innerHTML = "";
        currentTempBox.appendChild(temp);
        changeTempText();
    }

    // Load the data for the current day and sets up visualizations of precipitation chance.
    function loadCurrentDay(){
        errorHandle(this.status);
        if(this.status === 200){
            var node = (this.responseXML);
            populateLocationDiv(node);
            populateCurrentTempDiv();
            var slider = document.getElementById('slider');
            slider.onchange = changeTempText;

            document.getElementById('loadinglocation').style.display = "none";

            var graph = document.getElementById('graph');
            graph.innerHTML = "";
            var firstRow = graph.insertRow(0);
            var precipData_Array = node.querySelectorAll('clouds');
            for(var i = 0; i < precipData_Array.length; i++){
                var precipData = precipData_Array[i].getAttribute('chance');
                var barDiv = document.createElement('div');
                barDiv.style.height = precipData + "%";
                barDiv.innerText = precipData + "%";
                firstRow.insertCell(i).appendChild(barDiv);
            }
            graph.style.display = "none";
            document.getElementById('loadinggraph').style.display = "none";
        }
    }

    // Change Temperature Text.
    function changeTempText(){
        var sliderValue = document.getElementById('slider').value;
        var tempPEle = document.getElementById('temperature');
        var tempText = tempArray[sliderValue/3];
        tempPEle.innerHTML = Math.round(tempText) + "&#8457";
    }

    // Loads week data into a graph.
    function loadWeek(){
        var weatherImageURL = "https://openweathermap.org/img/w/";
        var parsedJSON = JSON.parse(this.responseText);
        var weatherArray = parsedJSON.weather;
        var weatherTable = document.getElementById('forecast');
        weatherTable.innerHTML = "";
        var firstRow = weatherTable.insertRow(0);
        var secondRow = weatherTable.insertRow(1);

        for(var i = 0; i < weatherArray.length; i++){
            var imgSRC = weatherImageURL + weatherArray[i].icon + ".png";
            var imgEle = document.createElement('img');
            imgEle.src = imgSRC;
            imgEle.alt = "Weather Data Image: " + weatherArray[i].icon;
            firstRow.insertCell(i).appendChild(imgEle);
            secondRow.insertCell(i).innerHTML = Math.round(weatherArray[i].temperature) + 
            "&#176";
        }
        document.getElementById('loadingforecast').style.display = "none";
    }

    // Search for weather info given the entered city.
    function searchCities(){
        var cityInput = document.getElementById('citiesinput').value;
        if(cityInput){
            loadTemp();
            setResultsDisplay("none","","none");
            var noDataDiv = document.getElementById('nodata');
            noDataDiv.style.display = "none";
            var resultsArea = document.getElementById('resultsarea');
            resultsArea.style.display = "";
            var params = "?mode=oneday&city=" + cityInput.toLowerCase();
            queryServer(params,loadCurrentDay);
            params = "?mode=week&city=" + cityInput.toLowerCase();
            queryServer(params,loadWeek);
        }
    }

})();
