
// Event Listener for Load
window.addEventListener('load', () => {

    // Delay the execution of the functions so the DOM can be loaded
    setTimeout(() => { 
        initAutocomplete();
    }, 2000);
    
})

// Define variables for later
let autocomplete;

// Get HTML fields
const searchAddressField = document.getElementById('searchAddress')
const addressLine1Field = document.getElementById('addressLine1') 
const addressLine2Field = document.getElementById('addressLine2') 
const townField = document.getElementById('town')
const postcodeField = document.getElementById('postcode')

// Initialize Google Maps address Autocomplete
function initAutocomplete() {

    // Create the autocomplete object, restricting the search predictions to UK
    autocomplete = new google.maps.places.Autocomplete(searchAddressField, {
        componentRestrictions: { country: ['UK'] },
        fields: ['address_components', 'geometry']
    });

    // When the user selects an address from the drop-down, populate the address fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

// Fill in the address fields in the form
function fillInAddress() {

    // Get the place details from the autocomplete object
    const place = autocomplete.getPlace();

    // Define variables for later
    let addressLine1 ;
    let town;
    let postcode;

    // Get each component of the address from the place details, and then fill-in the corresponding field on the form.
    // which are documented at http://goo.gle/3l5i5Mr
    for (const component of place.address_components) {
        
    const componentType = component.types[0];
    
        switch (componentType) {

            case 'street_number': {
                addressLine1 = component.long_name;
                break;
            }

            case 'route': {
                addressLine1 += ' ' + component.long_name;
                break;
            }

            case 'postal_code': {
                postcode = component.long_name;
                break;
            }
            
            case 'locality': {
                town = component.long_name;
                break;
            }

            case 'postal_town': {

                // Not all results contain locality so falling back to postal_town
                console.log(!town)
                if(!town)
                {
                    town = component.long_name;
                }
                    
            }
        }
    }

    // Set form fields 
    addressLine1Field.value = addressLine1;
    townField.value = town;
    postcodeField.value = postcode;

    // Set focus to addressLine2
    addressLine2Field.focus();
}

// document.getElementById('password').addEventListener(')