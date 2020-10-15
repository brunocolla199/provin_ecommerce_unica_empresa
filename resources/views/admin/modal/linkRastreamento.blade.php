
<!--Modal Codigo de Rastreio-->
<div class="modal" tabindex="-1" role="dialog" id="codRastreio">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Link para rastreamento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Link</label>
                <input type="text"  id="linkRastreamento" name="linkRastreamento"  class="  form-control"  > 
                <small class="form-control-feedback"> Informe o link para rastreamento. </small> 
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="salvarLink" class="btn btn-success">@lang('buttons.general.save')</button>
            <button type="button" class="btn btn-inverse" style="border-color: black" data-dismiss="modal">@lang('buttons.general.cancel')</button>
        </div>
        </div>
    </div>
</div>

