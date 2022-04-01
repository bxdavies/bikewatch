
// Define filter dictonary
var filterDict = {
    "id": 0,
    "report_date": 0,
    "last_name": 0,
    "crime_date": 0, 
    "status": 0
};

// Define click count variables
var IDColumnClickCount = 0;
var reportDateColumnClickCount = 0;
var victimColumnClickCount = 0;
var lastSeenColumnClickCount = 0;
var statusColumnClickCount = 0;

// Define pagiantion variables
var numberOfResultsToDisplay = 10;
var pageNumber = 1;

window.addEventListener('load', () => {

    // Delay the execution of the functions so DOM can load fully
    setTimeout(() => {
        createPageButtons();
        updateTable();
    }, 1000)
})

// ID column click event handler
document.getElementById("IDColumn").addEventListener("click", (event) => {
  if (IDColumnClickCount == 2) {
    IDColumnClickCount = 0;
  } 
  else {
    IDColumnClickCount = IDColumnClickCount + 1;
  }

  changeArrowDirection(event.target, IDColumnClickCount)
  updateFilterDict("id", IDColumnClickCount);
  updateTable();
});

// Report date column click event handler
document.getElementById("reportDateColumn").addEventListener("click", (event) => {
  if (reportDateColumnClickCount == 2) {
    reportDateColumnClickCount = 0;
  } 
  else {
    reportDateColumnClickCount = reportDateColumnClickCount + 1;
  }

  changeArrowDirection(event.target, reportDateColumnClickCount)
  updateFilterDict("report_date", reportDateColumnClickCount);
  updateTable();  
});

// User column click event handler
document.getElementById("victimColumn").addEventListener("click", (event) => {
  if (victimColumnClickCount == 2) {
    victimColumnClickCount = 0;
  } 
  else {
    victimColumnClickCount = victimColumnClickCount + 1;
  }

  changeArrowDirection(event.target, victimColumnClickCount)
  updateFilterDict("last_name", victimColumnClickCount);
  updateTable();
});

// Last seen column click event handler
document.getElementById("lastSeenColumn").addEventListener("click", (event) => {
  if (lastSeenColumnClickCount == 2) {
    lastSeenColumnClickCount = 0;
  } 
  else {
    lastSeenColumnClickCount = lastSeenColumnClickCount + 1;
  }

  changeArrowDirection(event.target, lastSeenColumnClickCount)
  updateFilterDict("crime_date", lastSeenColumnClickCount);
  updateTable();
});

// Status column click event handler
document.getElementById("statusColumn").addEventListener("click", (event) => {
  if (statusColumnClickCount == 2) {
    statusColumnClickCount = 0;
  } 
  else {
    statusColumnClickCount = statusColumnClickCount + 1;
  }

  changeArrowDirection(event.target, statusColumnClickCount)
  updateFilterDict("status", statusColumnClickCount);
  updateTable();
});

// Number of results to display dropdown change event handler 
document.getElementById("numberOfResultsToDisplay").addEventListener('change', (event) => {
    numberOfResultsToDisplay = parseInt(event.target.value);
    createPageButtons();
    updateTable();
})

// Fucntion to adjust arrow direction
function changeArrowDirection(target, count){
    // Stop filtering this column so display nothing
    if (count == 0){
        target.children[0].innerHTML = "";
    }
    // Filter column in ascending order so show an up arrow
    else if(count == 1){
        target.children[0].innerHTML = "&#8593;";
    }
    // Filter column in descending order so show a down arrow
    else if(count == 2){
        target.children[0].innerHTML = "&#8595;";
    }
    
}

// Function to update filter dictionary
function updateFilterDict(column, value) {
    if (column == "status") {
        if(value == 1){
            value = "Assedning Order Here"
        }
        else if(value == 2){
            value = "Descedning Order Here"
        }
    }
    else{
        if(value == 1){
            value = "ASC"
        }
        else if(value == 2){
            value = "DESC"
        }
    }
    filterDict[column] = value;
}

// Fucntion to create page buttons
function createPageButtons(){

    const parent = document.getElementById('pageButtons');

    // Empty Products DIV
    while (parent.firstChild){
        parent.firstChild.remove();
    }


    const request = $.post("dashboard_dao.php", {action: "getNumberOfRows"})

    request.done((response) => {
        const numberOfResults = parseInt(response)
        const numberOfPages =  Math.ceil(numberOfResults / numberOfResultsToDisplay)
        
        for (let i = 1; i <= numberOfPages; i++)
        {
            const pageButton = document.createElement('button')
            pageButton.value = i;
            pageButton.innerHTML = i;
            pageButton.className = 'pageButton'

            if (i == pageNumber){
                pageButton.disabled = true
            }
            document.getElementById("pageButtons").append(pageButton)
        }
    })

    setTimeout(() => { 
        document.querySelectorAll('.pageButton').forEach(item => {
            // Event Listener for Add to Wish List Button Click
            item.addEventListener('click', (event) => {
            
                pageNumber = event.target.value;
                
                document.querySelectorAll('.pageButton').forEach(aitem => {
                    aitem.disabled = false;
                })

                item.disabled = true;

                updateTable();
            })
        })
    }, 1000);

}

// Fucntion to update the table while the crimes from the DB
function updateTable() {
    const crimeTable = document.getElementById('crimeTable')

    // Empty Products DIV
    while (crimeTable.firstChild){
        crimeTable.firstChild.remove();
    }


    const offset = numberOfResultsToDisplay * (pageNumber - 1);
    const limit = numberOfResultsToDisplay;

    const request = $.post("dashboard_dao.php", {action: 'getData', filters: filterDict, offset: offset, limit: limit})

    request.done((response) => {
        response = JSON.parse(response)
        response.forEach((row) => {

            const tr = document.createElement('tr');

            const IDTD = document.createElement('td')
            const reportDateTD = document.createElement('td')
            const userTD = document.createElement('td')
            const bikeTD = document.createElement('td')
            const lastSeenTD = document.createElement('td')
            const statusTD = document.createElement('td')
            const actionsTD = document.createElement('td')

            // Bike Image and Name
            const bikeImage = document.createElement('img')
            const bikeMPN = document.createElement('p')
            const bikeBrand = document.createElement('p')
            bikeImage.src = `../../uploads/${row['image']}`
            bikeImage.className = 'bike-image';
            bikeMPN.innerHTML = row['mpn']
            bikeBrand.innerHTML = row['brand']

            // Edit Button
            const editButton = document.createElement('a')
            editButton.innerHTML = 'View';
            editButton.href = `../view/view.php?id=${row['id']}&type=crime`;
            editButton.className = 'button';

            IDTD.innerHTML = row['id'];
            reportDateTD.innerHTML = row['report_date'];
            userTD.innerHTML = row['title'] + ' ' + row['first_name'] + ' ' + row['last_name']; 
            bikeTD.append(bikeImage);
            bikeTD.append(bikeMPN);
            bikeTD.append(bikeBrand);
            lastSeenTD.innerHTML = row['crime_date'];
            statusTD.innerHTML = row['status'];
            actionsTD.append(editButton)

            tr.append(IDTD);
            tr.append(reportDateTD);
            tr.append(userTD);
            tr.append(bikeTD);
            tr.append(lastSeenTD);
            tr.append(statusTD);
            tr.append(actionsTD);

            crimeTable.append(tr);
        })
        
    })

}