<style>
    select.ui-datepicker-month, select.ui-datepicker-year{
        color: rgb(0, 0, 0);
    }
</style>

<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-commenting-o" aria-hidden="true"></i> Sugestões
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="txtMatricula">Matrícula</label>
                        <input class="form-control" id="txtMatricula" type="text" name="matricula" value="<?php echo $this->session->userdata('key_funcionarios'); ?>" disabled />
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="cbTipoReclamacao">Tipo</label>
                        <select id="cbTipoReclamacao" class="form-control">
                            <option value="1">Falta de EPI</option>
                            <option value="2">EPI entregue errado</option>
                            <option value="3">Problemas na requisição</option>
                            <option value="4">Problemas na aprovação</option>
                            <option value="5">Sugestão de melhorias</option>
                            <option value="6" selected>Outros</option>
                        </select>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="txtMessage">Sugestão <small  style="color:rgb(159, 159, 160); font-size: 0.82em;">Caracteres (<span id="txtMessageCaracter">0</span>/2000)</small></label>
                    <textarea id="txtMessage" rows="3" class="form-control" style="text-transform: uppercase;" maxlength="2000"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="aviso-sugestoes"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button id="enviar-sugestao" class="btn btn-primary pull-right" disabled><i class="glyphicon glyphicon-send"></i> Enviar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="txtFiltro">Listar por: </label>
                    <label class="radio-inline">
                        <input type="radio" name="listar-por-sugestoes" class="listar-por-sugestoes" value="0" checked> Todos
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="listar-por-sugestoes" class="listar-por-sugestoes" value="1"> Aguardando
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="listar-por-sugestoes" class="listar-por-sugestoes" value="2"> Respondido
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-border table-hover">
                    <thead>
                        <th>#</th>
                        <th>Matrícula</th>
                        <th>Setor</th>
                        <th>Sugestão</th>
                        <th>Abertura</th>
                        <th>Status</th>
                        <th class="text-center">Ação</th>
                       
                        <?php if($this->session->respondesugestao === TRUE) : ?>
                         <th class="text-center">RESPONDER</th>
                        <?php endif; ?>
                    </thead>
                    <tbody id="lista-sugestoes"></tbody>
                    <tfoot>
                        <tr>
                            <td id="sugestao-pager"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>



        <div id="responde-sugestao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Responder Sugestão">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> Responder Sugestão</h4>
            </div>
            <div class="modal-body">
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="txtResposta">Produto</label>
                                    <input type="text" class="form-control" id="txtResposta" placeholder="Produto">
                                </div>
                                <button id="btn-buscarProduto" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                            </form>
                        </div>
                        <hr class="invisible">
                    </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="txtResposta">Responder Sugestão <small style="color:rgb(159, 159, 160); font-size: 0.82em;">Caracteres (<span id="txtRespostaCaracter">0</span>/2000)</small></label>
                                <textarea id="txtResposta" rows="3" class="form-control" style="text-transform: uppercase;" maxlength="2000"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-condensed table-hover">
                                <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                                    <tr>
                                        <th>Código</th>
                                        <th>Partnumber</th>
                                        <th>Produto</th>
                                        <th>CA</th>
                                        <th class="text-center">Unidade</th>
                                        <th class="text-center">QTD</th>
                                        <th class="text-center">Adicionar</th>
                                    </tr>
                                </thead>
                                <tbody id="selecionar-produtos"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" id="paginacao-produtos"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button id="zerar-resposta" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
                <button id="enviar-resposta" class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!--// Modal selecionar produtos -->





    </div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->