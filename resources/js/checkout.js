$(document).ready(initCheckout)

function initCheckout() {
    $('#complete-order').on('click', validateAddress)
}

function validateAddress(e) {
    e.preventDefault()
    //const url = "https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+California&key=AIzaSyCJ-vnNoXrdBsHypgW3PoOt5xfLhSMcXPc"

    const address = $('#address').val().trim().replace(" ", "+")
    const city = $('#city').val().trim().replace(" ", "+")
    const state = $('#state').val().trim()
    const zip = $('#zip').val().trim()

    const baseUrl = "https://maps.googleapis.com/maps/api/geocode/json?address="
    const apiKey = "&key=AIzaSyCJ-vnNoXrdBsHypgW3PoOt5xfLhSMcXPc"
    const fullUrl = baseUrl + address + ",+" + city + ",+" + state + apiKey

    $.get(fullUrl, null, (response) => validateResponse(response))
}

function validateResponse(response) {
    const locationType = response['results'][0]['geometry']['location_type']
    if (locationType === 'APPROXIMATE') {

    } else if (locationType === 'ROOFTOP') {
        
    }
}

