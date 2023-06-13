        <!-- RODAPE - INICIO //-->
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="dialogPadrao" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="dialogTitulo">Confirmação de Transação</h4>
            </div>
            <div class="modal-body">
                <div id="boxDialogMensagem" class="clearfix alert-sm"></div><!-- MENSAGEM PEQUENA //-->
                <p id="dialogSubtitulo">Tem certeza que deseja &hellip;</p>
                <form id="formDialog" name="formDialog" action="action.php" method="post" onsubmit="return false;" >
                    <input type="hidden" id="dialogControle" name="controle" value="" />
                    <input type="hidden" id="dialogAcao" name="acao" value="" />
                    <input type="hidden" id="dialogId" name="id" value="" />
                    <div class="row clearfix" id="boxDialogObservacao" >
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <label class="control-label label-sm" for="dialogObservacao">Observações:</label>
                            <textarea class="form-control input-sm" rows="3" id="dialogObservacao" name="Observacao" maxlength="512" ></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="dialogButtonConfirmar"><span class="fa fa-check"></span> Confirmar</button>
                <button type="button" class="btn btn-default" id="dialogButtonCancelar" data-dismiss="modal"><span class="fa fa-stop"></span> Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>