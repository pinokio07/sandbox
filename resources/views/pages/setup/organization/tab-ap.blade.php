<div class="tab-pane fade" id="org-ap-content" role="tabpanel" aria-labelledby="org-ar">
  <div class="col md-4">
    <div class="card card-warning card-outline">
      <div class="card-header">
        <h3 class="card-title">Account Payable</h3>
      </div>
      <form id="formAp" action="/organization/arap/{{ $organization->id }}" method="post"
        class="needs-validation" novalidate>
        @csrf
      <div class="card-body">  
        @php
          $companyData = $organization->companyData->first() ?? '';
        @endphp        
        <div class="row">
          <div class="col-12 col-md-3">
            <div class="form-group form-group-sm">
              
              <label for="OB_OG_APCreditorGroup">Creditor Group</label>
              <select name="OB_OG_APCreditorGroup" id="OB_OG_APCreditorGroup" 
                      class="creditor"
                      style="width: 100%;" 
                      @role('super-admin')
                        required
                      @else
                        @if($organization->hasApOutstanding() > 0) 
                          disabled 
                        @else 
                          required 
                        @endif
                      @endif>
                <option value="{{ $companyData->OB_OG_APCreditorGroup ?? '' }}">
                  {{ $companyData->apGroup->GroupDesc ?? "Select..." }}
                </option>
              </select>
              <span class="invalid-feedback">Please select Debtor Group</span>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group form-group-sm">
                    <label for="OB_APPaymentTermDays">Credit Terms</label>
                    <select name="OB_APPaymentTermDays" id="OB_APPaymentTermDays" 
                            class="custom-select form-control-border border-width-2" 
                            required>
                      <option selected disabled value="">--Select--</option>
                      <option value="0"
                        @if(optional($organization->companyData)->first()->OB_APPaymentTermDays == "0") selected @endif>0 Day</option>
                      <option value="7"
                        @if(optional($organization->companyData)->first()->OB_APPaymentTermDays == "7") selected @endif>7 Days</option>
                      <option value="14"
                        @if(optional($organization->companyData)->first()->OB_APPaymentTermDays == "14") selected @endif>14 Days</option>
                      <option value="30"
                        @if(optional($organization->companyData)->first()->OB_APPaymentTermDays == "30") selected @endif>30 Days</option>
                      <option value="45"
                        @if(optional($organization->companyData)->first()->OB_APPaymentTermDays == "45") selected @endif>45 Days</option>
                      <option value="60"
                        @if(optional($organization->companyData)->first()->OB_APPaymentTermDays == "60") selected @endif>60 Days</option>
                      <option value="90"
                        @if(optional($organization->companyData)->first()->OB_APPaymentTermDays == "90") selected @endif>90 Days</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="OB_APWitholdingTax">With Holding Tax</label>
                    <select name="OB_APWitholdingTax" id="OB_APWitholdingTax" class="custom-select form-control-border border-width-2" required>
                        <option value="0"
                          @if($organization->hasApWitholding() == false) selected @endif>NO</option>
                        <option value="1"
                          @if($organization->hasApWitholding() == true) selected @endif>YES</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="OB_APVATConfig">VAT</label>
                    <select name="OB_APVATConfig" 
                            id="OB_APVATConfig" 
                            class="custom-select form-control-border border-width-2" required>
                        <option value="Y"
                          @if(optional($organization->companyData)->first()->OB_APVATConfig == 'Y') selected @endif>YES</option>
                        <option value="N"
                          @if(optional($organization->companyData)->first()->OB_APVATConfig == 'N') selected @endif>NO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group form-group-sm">
                    <label for="OB_RX_NKAPDefltCurrency">Default Currency</label>
                    <select name="OB_RX_NKAPDefltCurrency" 
                            id="OB_RX_NKAPDefltCurrency" 
                            class="currency" 
                            style="width: 100%;"
                            required>
                      <option value="{{ optional($organization->companyData)->first()->OB_RX_NKAPDefltCurrency ?? '' }}">
                        {{ optional($organization->companyData)->first()->OB_RX_NKAPDefltCurrency ?? 'Select...' }}
                      </option>
                    </select>
                    <span class="invalid-feedback">Please select a Default Currency</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="OB_OH_APSettlementOrg">Settlement Organization</label>
                    <select name="OB_OH_APSettlementOrg" 
                            id="OB_OH_APSettlementOrg" 
                            style="width: 100%;"
                            class="settlementAp">
                      <option value="{{ optional($organization->companyData)->first()->OB_OH_APSettlementOrg ?? '' }}">
                        {{ optional(optional($organization->companyData)->first()->settlementAP)->OH_FullName ?? 'Select...' }}
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
    $(document).on('submit', '#formAp', function(e){
      e.preventDefault(),
      
      $.ajax({
        url: "{{ route('setup.organization.arap', ['organization' => $organization->id]) }}",
        type: "POST",
        data: $(this).serialize(),
        success:function(msg){
          if(msg == "OK"){
            toastr.success("Update AP Config Success", "Success!", {timeOut: 3000, closeButton: true, progressBar: true});
          }
        }
      })
    });
  });
</script>
