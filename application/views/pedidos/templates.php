

<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-clone" aria-hidden="true"></i> Template
                </h1>
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Criteria -->
        <div class="row">
            <!-- Número requisição -->
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Nº template inicial</label>
                    <input id="num-inicial" type="text" name="num-inicial" class="form-control" title="Digite apenas números" placeholder="Nº Pedido" />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Nº template final</label>
                    <input id="num-final" type="text" name="num-final" class="form-control" title="Digite apenas números" placeholder="Nº Pedido" />
                </div>
            </div>

            <!-- Descrição -->
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Descrição</label>
                    <input id="txtDescricao" type="text" name="descricao" class="form-control" placeholder="Descrição" />
                </div>
            </div>

             <!-- Funcionário -->
            <!--<div class="col-lg-2">
                <div class="form-group">
                    <label>Usuário*</label>
                    <input id="txtFuncionario" type="text" name="matricula" class="form-control" placeholder="Usuário" <?php # (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? print('') : print('disabled');?>/>
                </div>
            </div>-->

            <!-- Buscar -->
            <div class="col-lg-2">
                <div class="form-group">
                    <label>&nbsp;</label><br />
                    <button id="btn-listarTemplate" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <hr class="invisible">
                <table class="table table-hover table-bordered table-striped">
                    <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                        <tr>
                            <th>Número</th>
                            <th>Descrição</th>
                            <!--<th>Setor</th>-->
                            <th>Usuário</th>
                            <th class="text-center">Detalhes</th>
                        <tr>
                    </thead>
                    <tbody id="selecionar-template"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10" id="paginacao-templates"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.row -->
    </div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<!-- Modal visualizar produtos -->
<div id="lista-detalhes-template" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Lista de produtos">
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
                                <th>Matricula</th>
                                <th>Nome</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody id="visualizar-funcionarios"></tbody>
                    </table>
                </div>
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
                                <!--<th class="text-center">Adicionar</th>-->
                            </tr>
                        </thead>
                        <tbody id="visualizar-produtos"></tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <div class="row">
            <div id="deletar-template" class="col-lg-4"></div>
            <div id="atualizar-template" class="col-lg-4"></div>
            <div class="col-lg-4">
                <button id="detalhes-template-fechar" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
            </div>
        </div>
        <!--<button class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal visualizar produtos -->

