<div class="modal fade" id="edit-call" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="la la-pencil"></i> Editar atendimento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-edit-call">
                <div class="modal-body" style="padding: 10px;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="btn-delete-call">
                        <i class="fa fa-trash"></i> Deletar
                    </button>
                    <button type="submit" class="btn btn-success" disabled>
                        <i class="fa fa-save"></i> Salvar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@include('Customers::search')