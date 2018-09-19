$(document).ready(initCheckout)

function initCheckout() {
    $('#complete-order').on('click', validateAddress)
}

function validateAddress(e) {
    e.preventDefault()

    const address = $('#address').val().trim().replace(" ", "+")
    const city = $('#city').val().trim().replace(" ", "+")
    const state = $('#state').val().trim()
    const zip = $('#zip').val().trim()

    const baseUrl = "https://maps.googleapis.com/maps/api/geocode/json?address="
    const apiKey = "&key=AIzaSyCJ-vnNoXrdBsHypgW3PoOt5xfLhSMcXPc"
    const fullUrl = baseUrl + address + ",+" + city + ",+" + state + apiKey

    $.get(fullUrl, null, (response) => validateResponse(response))
}

function submitOrder(submit) {
    if (submit) {
        $('#order-checkout').submit()
        return
    }
    
    $('h5.modal-title').text('Error')
    $('div.modal-content div.modal-body').text('Wrong address!')
    $('div.modal-footer button.btn.btn-primary').text('Ok, my mistake, I\'ll try again')
    $('#main-modal').modal()
    $('div.modal-footer button.btn.btn-primary').off('click.close').on('click.close', function () {
        $('#main-modal').modal('hide')   
    })
    
}

function validateResponse(response) {
    
    if (response['results'].length === 0) {
        submitOrder(false)
        return
    }

    const partialMatch = response['results'][0]['partial_match']
    const locationType = response['results'][0]['geometry']['location_type']
    return locationType === 'ROOFTOP' && partialMatch === undefined ? submitOrder(true) : submitOrder(false)
}

