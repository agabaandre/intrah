<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Provider Bank Details</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="pid"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input name="firstName" placeholder="First Name" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input name="lastName" placeholder="Last Name" class="form-control" type="text" readonly>
                                <span class="help-block" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Other Name</label>
                            <div class="col-md-9">
                                <input name="otherName" placeholder="Other Name" class="form-control" type="text" readonly>
                                <span class="help-block" readonly></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Account Number</label>
                            <div class="col-md-9">
                                <input name="account_no" placeholder="Account Number" class="form-control input-emp-account_no" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Bank Name</label>
                            <div class="col-md-9">
                                <input name="bank_name" placeholder="Bank Name" class="form-control input-emp-bank_name" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Bank Code</label>
                            <div class="col-md-9">
                                <input name="bank_code" placeholder="Bank Code" class="form-control input-emp-bank_code" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Branch</label>
                            <div class="col-md-9">
                                <input name="branch_name" placeholder="Branch" class="form-control input-emp-branch_name" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Branch Code</label>
                            <div class="col-md-9">
                                <input name="branch_code" placeholder="Branch Code" class="form-control input-emp-branch_code" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->