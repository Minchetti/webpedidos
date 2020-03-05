
<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-clone" aria-hidden="true"></i> Atualizar Template
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Nome<span style="color: red;">*</span></label>
                    <input id="txtTemplateDescricao" type="text" class="form-control" name="template-atualiza-descricao" placeholder="Nome" maxlength="50" style="text-transform: uppercase;" value="<?php print($template_descricao); ?>" data-codigo="<?php print($codigo); ?>" disabled/>
                </div>
            </div>
            <!-- <div class="col-lg-6"> <!--adicionei para ter setor na hora d editar o template -->
                <!-- <div class="form-group">
                    <label>Setor<span style="color: red;">*</span></label>
                    <input id="txtSetorEditarTemplate" type="text" class="form-control" name="template-setor" placeholder="Setor" style="text-transform: uppercase;"/>
                </div> -->
            <!-- </div> -->
        </div>

        
        

        <!--<div class="row">
            <div class="col-lg-6">
                <strong><i class="fa fa-users" aria-hidden="true"></i>- </strong><span id="spSetorNome"></span>
            </div>
            <div class="col-lg-6">
                <strong><i class="fa fa-building" aria-hidden="true"></i> - </strong><span id="spSetorFantasia"></span>
            </div>
            <hr />
        </div>-->

        <!-- Observação -->
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Observação <small style="color:rgb(159, 159, 160); font-size: 0.82em;">Caracteres (<span id="txtObservacaoCaracter">0</span>/150)</small></label>
                    <textarea id="txtObservacaoTemplate" class="form-control" name="observacao-template" placeholder="Observação" maxlength="150" style="text-transform: uppercase; resize: none;" ><?php print($obs); ?></textarea>
                </div>
            </div>
        </div>


        <!-- Selecionar funcionários -->
        <div class="row">
            <div class="col-lg-12">
                <table id="funcionarios-lista" class="table table-hover table-bordered table-striped">
                    <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                        <tr>
                            <th style="width: 20px;"><input type="checkbox" name="check-todos" id="cb-check-todos" /></th>
                            <th>Matrícula</th>
                            <th>Funcionário</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody id="lista-funcionarios-atualizacao"></tbody>
                </table>
            </div>
        </div>
        <!-- //Selecionar funcionários -->

        <div class="row">
            <div class="col-lg-12">
                <button id="btn-add-funcionarios" class="btn btn-primary pull-right"><i class="fa fa-plus-square" aria-hidden="true"></i> Adicionar funcionários</button>
            </div>
            <hr />
        </div>

        <!-- Produtos -->
        <!-- Selecionar funcionários -->
        <!--<div class="row">
            <div class="col-lg-12">
                <table class="table table-hover table-bordered table-striped">
                    <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                        <tr>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>CA</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody id="lista-produtos-selecionados"></tbody>
                </table>
            </div>
        </div>-->
        <!-- //Selecionar funcionários -->

        <!-- Botões de ação -->
        <div class="row">
            <hr />
            <div class="col-lg-4">
                <div class="form-group">
                    <button id="btn-cancelar" class="btn btn-danger pull-right"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <button id="btn-salvar-template" class="btn btn-success pull-right"><i class="fa fa-check" aria-hidden="true"></i> Concluir</button>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<!-- Modal selecionar produtos -->
<div id="lista-produtos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Lista de produtos">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Lista de produtos</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="txtProduto">Produto</label>
                            <input type="text" class="form-control" id="txtProduto" placeholder="Produto">
                        </div>
                        <button id="btn-buscarProdutoTemplate" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </form>
                </div>
                <hr class="invisible">
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>Código</th>
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
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
        <!--<button class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar produtos -->

<!-- Modal visualizar produtos -->
<div id="lista-produtos-visualizacao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Lista de produtos">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Lista de produtos</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>Código</th>
                                <th>Produto</th>
                                <th>CA</th>
                                <th class="text-center">Unidade</th>
                                <th class="text-center">QTD</th>
                                <!--<th class="text-center">Adicionar</th>-->
                            </tr>
                        </thead>
                        <tbody id="visualizar-produtos"></tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
        <!--<button class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal visualizar produtos -->