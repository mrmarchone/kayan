@extends('kayan::layouts.app')
@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Basic Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Title <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Title">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" placeholder="Description">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Content </label>
                                <input type="text" class="form-control" placeholder="Content">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="form-label">Image</label>
                            <div class="input-group mb-5 file-browser">
                                <input type="text" class="form-control browse-file" placeholder="Choose" readonly="">
                                <label class="input-group-text btn btn-primary">
                                    Browse <input type="file" class="file-browserinput" style="display: none;"
                                                  multiple="">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Icons</label>
                                <select class="form-control form-select select2" data-bs-placeholder="Select">
                                    <option label="Select"></option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Address <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Home Address">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">City <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Postal Code <span class="text-red">*</span></label>
                                <input type="number" class="form-control" placeholder="ZIP Code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Information</h3>
                </div>
                <div class="card-body">
                    <div class="card-pay">
                        <ul class="tabs-menu nav">
                            <li class=""><a href="#tab20" class="active" data-bs-toggle="tab"><i
                                        class="fa fa-credit-card"></i> Credit Card</a></li>
                            <li><a href="#tab21" data-bs-toggle="tab" class=""><i class="fa fa-paypal"></i> Paypal</a>
                            </li>
                            <li><a href="#tab22" data-bs-toggle="tab" class=""><i class="fa fa-university"></i> Bank
                                    Transfer</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab20">
                                <div class="bg-danger-transparent-2 text-danger px-4 py-2 br-3 mb-4" role="alert">Please
                                    Enter Valid Details
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Card Holder Name</label>
                                    <input type="text" class="form-control" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Card number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-text btn btn-success shadow-none">
																<i class="fa fa-cc-visa"></i> &nbsp; <i
                                                class="fa fa-cc-amex"></i> &nbsp;
																<i class="fa fa-cc-mastercard"></i>
															</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label class="form-label">Expiration</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="MM" name="Month">
                                                <input type="number" class="form-control" placeholder="YY" name="Year">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">CVV <i class="fa fa-question-circle"></i></label>
                                            <input type="number" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="btn  btn-lg btn-primary">Confirm</a>
                            </div>
                            <div class="tab-pane" id="tab21">
                                <p>Paypal is easiest way to pay online</p>
                                <p><a href="#" class="btn btn-primary"><i class="fa fa-paypal"></i> Log in my Paypal</a>
                                </p>
                                <p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit
                                    aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                                    voluptatem sequi nesciunt. </p>
                            </div>
                            <div class="tab-pane" id="tab22">
                                <p>Bank account details</p>
                                <dl class="card-text">
                                    <dt>BANK:</dt>
                                    <dd> THE UNION BANK 0456</dd>
                                </dl>
                                <dl class="card-text">
                                    <dt>Account Number:</dt>
                                    <dd> 67542897653214</dd>
                                </dl>
                                <dl class="card-text">
                                    <dt>IBAN:</dt>
                                    <dd>543218769</dd>
                                </dl>
                                <p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit
                                    aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                                    voluptatem sequi nesciunt. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
