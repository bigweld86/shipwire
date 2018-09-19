@extends('layouts.app')

@section('content')



<div class="row">
        <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Shipping address</h4>
          <form method="POST" action="/orders/checkout" id="order-checkout">
          {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="first-name">First name <span class="required-field">*</label></label>
                <input type="text" class="form-control" id="first-name" name="order_customer_first_name" placeholder="First Name" value="{{ old('order_customer_first_name') }}">
              </div>
              <div class="col-md-6 mb-3">
                <label for="last-name">Last name <span class="required-field">*</label></label>
                <input type="text" class="form-control" id="last-name" placeholder="Last Name" name="order_customer_last_name" value="{{ old('order_customer_last_name') }}">
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address <span class="required-field">*</label></label>
              <input type="text" class="form-control" id="address" name="order_address" placeholder="1234 Main St" value="{{ old('order_address') }}">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">City <span class="required-field">*</label></label>
                <input type="text" class="form-control" id="city" placeholder="City" name="order_city" value="{{ old('order_city') }}">
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State <span class="required-field">*</label></label>
                <input type="text" class="form-control" id="state" name="order_state" placeholder="State" value="{{ old('order_state') }}">
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip <span class="required-field">*</label></label>
                <input type="text" class="form-control" id="zip" name="order_zip" placeholder="Zip-Code" value="{{ old('order_zip') }}">
              </div>
            </div>
            <hr class="mb-4">
            <div class="row">
            <div class="col-sm-12">
                <div class="float-right">(<span class="required-field">*</span>) <i>Required Field</i></div><br>
            </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" id="complete-order" type="submit">Complete Order</button>
          </form>
        </div>
      </div>

      
@endsection
