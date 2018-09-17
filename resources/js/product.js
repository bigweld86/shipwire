$(document).ready(initProducts)


function initProducts() {
    $('.delete-product').on('click', initProductDeletion)
    $(".products-table .action-buttons a.action-icon").popover({ trigger: "hover" });
}

function initProductDeletion() {
    const productId = $(this).data('product-id')
    $('h5.modal-title').text('Confirmation')
    $('div.modal-content div.modal-body').text('Are you sure you want to delete this Product?')
    $('div.modal-footer button.btn.btn-primary').text('Yes, Delete It!')
    $('#main-modal').modal()
    $('div.modal-footer button.btn.btn-primary').off('click.close').on('click.close', function () {
        deleteProduct(productId)
        $('#main-modal').modal('hide')   
    })
    return 

}

function deleteProduct(productId) {
    $.get(
        "/products/" + productId + "/remove", 
        null, 
        (response) => {
            console.log(response)
            removeProductFromList(productId)
        }
    )
}

function removeProductFromList(productId) {
    console.log('removing from the list...')
    $('.product-' + productId).remove()
}