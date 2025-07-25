<div class="tab-pane fade" id="org-ar-content" role="tabpanel" aria-labelledby="org-ar">
  <div class="col md-4">
    <div class="card card-warning card-outline">
      <div class="card-header">
        <h3 class="card-title">Account Receivable</h3>
      </div>
      <form id="formAr" action="/organization/arap/{{ $organization->id }}" method="post"
        class="needs-validation" novalidate>
        @csrf
      <div class="card-body">  
        @php
          $companyData = $organization->companyData->first();
        @endphp        
        <div class="row">
          <div class="col-12 col-md-3">
            <div class="form-group form-group-sm">
              
              <label for="OB_OJ_ARDebtorGroup">Debtor Group</label>
              <select name="OB_OJ_ARDebtorGroup" id="OB_OJ_ARDebtorGroup" 
                      class="debtor"
                      style="width: 100%;"
                      @role('super-admin')
                        required
                      @else
                        @if($organization->hasArOutstanding() > 0) 
                          disabled 
                        @else 
                          required 
                        @endif
                      @endif>
                <option value="{{ $companyData->OB_OJ_ARDebtorGroup ?? '' }}">
                  {{ $companyData->arGroup->GroupDesc ?? "Select..." }}
                </option>
              </select>
              <span class="invalid-feedback">Please select Debtor Group</span>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group form-group-sm">
                    <label for="OB_ARInvoiceTermDays">Credit Terms</label>
                    <select name="OB_ARInvoiceTermDays" id="OB_ARInvoiceTermDays" 
                            class="custom-select form-control-border border-width-2" 
                            required>
                      <option selected disabled value="">--Select--</option>
                      <option value="0"
                        @if($companyData->OB_ARInvoiceTermDays == "0") selected @endif>0 Day</option>
                      <option value="7"
                        @if($companyData->OB_ARInvoiceTermDays == "7") selected @endif>7 Days</option>
                      <option value="14"
                        @if($companyData->OB_ARInvoiceTermDays == "14") selected @endif>14 Days</option>
                      <option value="30"
                        @if($companyData->OB_ARInvoiceTermDays == "30") selected @endif>30 Days</option>
                      <option value="45"
                        @if($companyData->OB_ARInvoiceTermDays == "45") selected @endif>45 Days</option>
                      <option value="60"
                        @if($companyData->OB_ARInvoiceTermDays == "60") selected @endif>60 Days</option>
                      <option value="90"
                        @if($companyData->OB_ARInvoiceTermDays == "90") selected @endif>90 Days</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="OB_ARWitholdingTax">With Holding Tax</label>
                    <select name="OB_ARWitholdingTax" id="OB_ARWitholdingTax" class="custom-select form-control-border border-width-2" required>
                        <option value="0"
                          @if($organization->hasArWitholding() == false) selected @endif>NO</option>
                        <option value="1"
                          @if($organization->hasArWitholding() == true) selected @endif>YES</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="OB_ARVATConfig">VAT</label>
                    <select name="OB_ARVATConfig" 
                            id="OB_ARVATConfig" 
                            class="custom-select form-control-border border-width-2" required>
                        <option value="Y"
                          @if($companyData->OB_ARVATConfig == 'Y') selected @endif>YES</option>
                        <option value="N"
                          @if($companyData->OB_ARVATConfig == 'N') selected @endif>NO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group form-group-sm">
                    <label for="OB_RX_NKARDDefltCurrency">Default Currency</label>
                    <select name="OB_RX_NKARDDefltCurrency" 
                            id="OB_RX_NKARDDefltCurrency" 
                            class="currency" 
                            style="width: 100%;"
                            required>
                      <option value="{{ $companyData->OB_RX_NKARDDefltCurrency ?? '' }}">
                        {{ $companyData->OB_RX_NKARDDefltCurrency ?? 'Select...' }}
                      </option>
                    </select>
                    <span class="invalid-feedback">Please select a Default Currency</span>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-3">
              <div class="form-group form-group-sm">
                  <label for="OB_RateSource">Rate Source</label>
                  <select name="OB_RateSource" 
                          id="OB_RateSource" 
                          class="custom-select custom-select-sm" 
                          required>
                    <option value="CAF3"
                      @if($companyData->OB_RateSource == 'CAF3') selected @endif>
                        CAF 3%</option>
                    <option value="CUS"
                      @if($companyData->OB_RateSource == 'CUS') selected @endif>
                        Selling Rate</option>
                    <option value="MID"
                      @if($companyData->OB_RateSource == 'MID') selected @endif>
                        Middle Rate</option>
                  </select>
                  <span class="invalid-feedback">Please select a Default Currency</span>
              </div>
          </div>
      </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="OB_OH_ARSettlementOrg">Settlement Organization</label>
                    <select name="OB_OH_ARSettlementOrg" 
                            id="OB_OH_ARSettlementOrg" 
                            class="settlementAr"
                            style="width: 100%;">
                      <option value="{{ $companyData->OB_OH_ARSettlementOrg ?? '' }}">
                        {{ optional($companyData->settlementAR)->OH_FullName ?? 'Select...' }}
                      </option>                     
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="card-footer">       
        <button type="submit" class="btn btn-sm btn-success elevation-2">
          <i class="fas fa-save"></i> Save
        </button>
      </div>
      </form>
    </div>
  </div>    
</div>

<script>
  jQuery(document).ready(function(){    
    $(document).on('submit', '#formAr', function(e){
      e.preventDefault(),
      
      $.ajax({
        url: "{{ route('setup.organization.arap', ['organization' => $organization->id]) }}",
        type: "POST",
        data: $(this).serialize(),
        success:function(msg){
          if(msg == "OK"){
            toastr.success("Update AR Config Success", "Success!", {timeOut: 3000, closeButton: true, progressBar: true});
          }
        }
      })
    });
  });
</script>
