@extends('layouts.app')

@section('content')



<div class="row">
        <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" novalidate="">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">City</label>
                <input type="text" class="form-control" id="city" placeholder="City" required="">
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" placeholder="" required="">
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" placeholder="" required="">
              </div>
            </div>
            <hr class="mb-4">

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" id="complete-order" type="submit">Complete Order</button>
          </form>
        </div>
      </div>
</form>
      
@endsection
