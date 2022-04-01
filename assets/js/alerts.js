var autoCloseAlert;
var progressBar;

/**
 * Load Event Listener
 *
 * @param   {event}  load  Event to listen for
 *
 * @return  {none}     
 */
window.addEventListener('load', () => {

    // Delay the execution of the functions so the DOM can be load
    setTimeout(() => { 
        addAlertEventListeners();
        moveProgressBar();
    }, 100);
    
})


/**
 * Function to create alerts
 *
 * @param   {string}  alertType    The alert type possible values are error or success
 * @param   {string}  alertText    The text to display in the alert box
 * @param   {string}  redirectURL  The url to redirect to once the alert is closed or expired
 *
 * @return  {none}      
 */
function createAlert(alertType, alertText, redirectURL = "")
{   
    // Create DIV for alert
    var alertDIV = document.createElement("div")

    // Set DIV attributes
    alertDIV.className = "alert " + alertType;

    // Create a new paragraph for the alert text
    var alertParagraph = document.createElement("p")

    // Set paragraph attributes
    alertParagraph.innerHTML = alertText

    // Create span for the alert exit button
    var alertHide = document.createElement("span")

    // Set span attributes
    alertHide.className = "alert-close"
    alertHide.innerHTML = "&times;"
    alertHide.setAttribute("redirectURL", redirectURL); // Create custom attribute redirectURL

    // Add span to paragraph
    alertParagraph.append(alertHide)

    // Add paragraph to DIV
    alertDIV.append(alertParagraph)

    // Create progress bar
    var alertProgress = document.createElement("progress")

    // Set progress bar attributes
    alertProgress.className = "alert-progress"
    alertProgress.value = 0;
    alertProgress.max = 100;

    // Add progress bar to DIV
    alertDIV.append(alertProgress)

    // Add paragraph to the alert container
    document.getElementById("alert-container").append(alertDIV)

    // Call functions
    addAlertEventListeners();
    moveProgressBar();


}

/**
 * Move alert progress bar
 *
 * @return  {none}
 */
function moveProgressBar() {

    // Get all elements with the class alert-progress
    document.querySelectorAll('.alert-progress').forEach(item => {

        // Run code every 10 milliseconds 
        progressBar = setInterval(() => {

            // If hover is set to true do not move progress bar
            if(item.parentElement.getAttribute('hover') == 'true')
            {}
            // Else move progress bar
            else{
                item.value += 1;
            }
        }, 10)
    })
}

/**
 * Add Alert event listeners
 *
 * @return  {none}
 */
function addAlertEventListeners(){

    // Get all elements with the class alert
    document.querySelectorAll('.alert').forEach(item => {

        // Add mouseover event listener
        item.addEventListener('mouseover', () => {

            // Set hover to true
            item.setAttribute('hover', true)
        })

        // Add mouseleave event listener
        item.addEventListener('mouseleave', () => {

            // Set hover to false
            item.setAttribute('hover', false)
        })
    });

    // Get all elements with the class alert-close and loop over them
    document.querySelectorAll('.alert-close').forEach(item => {

        // Add click event listener
        item.addEventListener('click', () => {

            // Stop progress bar
            window.clearInterval(progressBar)

            // Hide element
            item.parentElement.parentElement.style.display='none';

            // If custom attribute redirectURL is not empty then redirect to url
            if (item.getAttribute("redirectURL") != ""){
                window.location.href= item.getAttribute("redirectURL");
            }
        });

        // After 2 seconds automatically close the alert
        autoCloseAlert = setTimeout(closeAlert, 2000, item);
    
    });
}

/**
 * Try and close the alert
 *
 * @param   {HTML}  element  HTML Alert Span Element
 *
 * @return  {none}           
 */
function closeAlert(element) {

    //  If hover is true call this function again in 1s
    if(element.parentElement.parentElement.getAttribute('hover') == 'true') {
        window.clearTimeout(autoCloseAlert);
        autoCloseAlert = setTimeout(closeAlert, 1000, element);
    }

    // Else dispatch click event
    else{
        element.dispatchEvent(new Event('click'));
    }
    
}


